<?php

/**
 * Theme Functions
 */

// Theme setup
function theme_setup()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');

function lecercle_register_forum_topics()
{
    register_post_type('lc_forum_topic', array(
        'label' => 'Sujets Le Cercle',
        'public' => false,
        'show_ui' => false,
        'supports' => array('title', 'editor', 'author'),
    ));
}
add_action('init', 'lecercle_register_forum_topics');

// Enqueue styles and scripts
function theme_scripts()
{
    $css_file = get_template_directory() . '/assets/css/main.css';
    $mobile_css_file = get_template_directory() . '/assets/css/mobile.css';
    $account_css_file = get_template_directory() . '/assets/css/account.css';
    $deals_css_file = get_template_directory() . '/assets/css/deals.css';
    $js_file = get_template_directory() . '/assets/js/main.js';
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/main.css', array(), file_exists($css_file) ? md5_file($css_file) : '1.0.0');
    wp_enqueue_style('theme-mobile-style', get_template_directory_uri() . '/assets/css/mobile.css', array('theme-style'), file_exists($mobile_css_file) ? md5_file($mobile_css_file) : '1.0.0');
    wp_enqueue_style('theme-account-style', get_template_directory_uri() . '/assets/css/account.css', array('theme-mobile-style'), file_exists($account_css_file) ? md5_file($account_css_file) : '1.0.0');
    wp_enqueue_style('theme-deals-style', get_template_directory_uri() . '/assets/css/deals.css', array('theme-account-style'), file_exists($deals_css_file) ? md5_file($deals_css_file) : '1.0.0');
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/main.js', array(), file_exists($js_file) ? md5_file($js_file) : '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');

/**
 * Keep the authentication URLs working even when the corresponding WordPress
 * pages have not yet been created or assigned a page template in wp-admin.
 */
function lecercle_auth_template_fallback($template)
{
    $path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $routes = array(
        'login'  => 'template-login.php',
        'signup' => 'template-register.php',
        'forum'  => 'template-forum.php',
        'profil' => 'template-profile.php',
        'artistes' => 'template-artists.php',
        'playlists' => 'template-playlists.php',
        'evenements' => 'template-events.php',
        'bons-plans' => 'template-deals.php',
    );

    if (isset($routes[$path])) {
        $route_template = get_template_directory() . '/' . $routes[$path];
        if (is_readable($route_template)) {
            return $route_template;
        }
    }

    return $template;
}
add_filter('template_include', 'lecercle_auth_template_fallback', 99);

/**
 * Render the public theme routes before WordPress can redirect /login to the
 * native wp-login.php screen. Form handlers still run before the template is
 * displayed, so registration and authentication remain functional.
 */
function lecercle_render_public_route()
{
    $path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $routes = array(
        'login'  => 'template-login.php',
        'signup' => 'template-register.php',
        'forum'  => 'template-forum.php',
        'profil' => 'template-profile.php',
        'artistes' => 'template-artists.php',
        'playlists' => 'template-playlists.php',
        'evenements' => 'template-events.php',
        'bons-plans' => 'template-deals.php',
    );

    if (strpos($path, 'forum/sujet/') === 0) {
        $topic_template = get_template_directory() . '/template-topic.php';
        if (is_readable($topic_template)) {
            include $topic_template;
            exit;
        }
    }

    if (!isset($routes[$path])) {
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($path === 'login') {
            handle_user_login();
        } elseif ($path === 'signup') {
            handle_user_registration();
        } elseif ($path === 'profil') {
            lecercle_handle_profile_update();
        } elseif ($path === 'forum') {
            lecercle_handle_forum_topic();
        }
    }

    $route_template = get_template_directory() . '/' . $routes[$path];
    if (is_readable($route_template)) {
        include $route_template;
        exit;
    }
}
add_action('template_redirect', 'lecercle_render_public_route', 0);

function lecercle_handle_forum_topic()
{
    if (!empty($_POST['lc_topic_delete'])) {
        $topic_id = absint($_POST['lc_topic_id'] ?? 0);

        if (is_user_logged_in() && $topic_id && wp_verify_nonce($_POST['lc_topic_delete_nonce'] ?? '', 'lc_delete_topic_'.$topic_id)) {
            $topic = get_post($topic_id);
            if ($topic && $topic->post_type === 'lc_forum_topic' && (int) $topic->post_author === get_current_user_id()) {
                wp_delete_post($topic_id, true);
                wp_safe_redirect(add_query_arg('topic', 'deleted', home_url('/forum')));
                exit;
            }
        }

        wp_safe_redirect(add_query_arg('topic', 'error', home_url('/forum')));
        exit;
    }

    if (empty($_POST['lc_topic_submit'])) {
        return;
    }

    if (!is_user_logged_in()) {
        wp_safe_redirect(home_url('/login'));
        exit;
    }

    if (empty($_POST['lc_topic_nonce']) || !wp_verify_nonce($_POST['lc_topic_nonce'], 'lc_create_topic')) {
        wp_safe_redirect(home_url('/forum?topic=error'));
        exit;
    }

    $title = sanitize_text_field(wp_unslash($_POST['topic_title'] ?? ''));
    $content = sanitize_textarea_field(wp_unslash($_POST['topic_message'] ?? ''));
    $category = sanitize_text_field(wp_unslash($_POST['topic_category'] ?? 'Actualités'));
    $allowed_categories = array('Actualités', 'Freestyles', 'Beats', 'Concerts', 'Bons plans');

    if ($title === '' || $content === '' || !in_array($category, $allowed_categories, true)) {
        wp_safe_redirect(home_url('/forum?topic=error'));
        exit;
    }

    $topic_id = wp_insert_post(array(
        'post_type' => 'lc_forum_topic',
        'post_status' => 'publish',
        'post_title' => $title,
        'post_content' => $content,
        'post_author' => get_current_user_id(),
    ));

    if (!is_wp_error($topic_id)) {
        update_post_meta($topic_id, 'lc_topic_category', $category);
        wp_safe_redirect(home_url('/forum?topic=created'));
        exit;
    }

    wp_safe_redirect(home_url('/forum?topic=error'));
    exit;
}

// Handle user registration
function handle_user_registration()
{
    if (isset($_POST['register_submit']) && isset($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);
        $password = $_POST['user_pass'];
        $password_confirm = $_POST['user_pass_confirm'];

        if ($password !== $password_confirm) {
            wp_redirect(home_url('/signup?registration=error'));
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Save custom fields as user meta
            if (isset($_POST['first_name'])) {
                update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            }
            if (isset($_POST['last_name'])) {
                update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
            }
            if (isset($_POST['phone'])) {
                update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
            }
            if (isset($_POST['student_id'])) {
                update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
            }

            // Update display name
            $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
            $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
            if ($first_name || $last_name) {
                wp_update_user(array(
                    'ID' => $user_id,
                    'display_name' => trim($first_name . ' ' . $last_name),
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ));
            }

            wp_redirect(home_url('/signup?registration=success'));
            exit;
        } else {
            wp_redirect(home_url('/signup?registration=error'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_registration');

// Handle user login
function handle_user_login()
{
    if (isset($_POST['login_submit']) && isset($_POST['login_nonce']) && wp_verify_nonce($_POST['login_nonce'], 'login_action')) {
        $username = sanitize_user($_POST['log']);
        $password = $_POST['pwd'];
        $remember = isset($_POST['rememberme']) ? true : false;

        if (empty($username) || empty($password)) {
            wp_redirect(home_url('/login?login=empty'));
            exit;
        }

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember
        );

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            wp_redirect(home_url());
            exit;
        } else {
            wp_redirect(home_url('/login?login=failed'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_login');

// Update the public member profile.
function lecercle_handle_profile_update()
{
    if (!is_user_logged_in() || !isset($_POST['lc_profile_submit'], $_POST['lc_profile_nonce'])) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lc_profile_nonce'])), 'lc_profile_update')) {
        return;
    }

    $user_id = get_current_user_id();
    $display_name = isset($_POST['display_name']) ? sanitize_text_field(wp_unslash($_POST['display_name'])) : '';
    $description = isset($_POST['description']) ? sanitize_textarea_field(wp_unslash($_POST['description'])) : '';
    $location = isset($_POST['location']) ? sanitize_text_field(wp_unslash($_POST['location'])) : '';

    if ($display_name !== '') {
        wp_update_user(array('ID' => $user_id, 'display_name' => $display_name, 'description' => $description));
        update_user_meta($user_id, 'lc_location', $location);
    }

    wp_safe_redirect(home_url('/profil?updated=1'));
    exit;
}

// Redirect after login
function redirect_after_login($redirect_to, $request, $user)
{
    if (!is_wp_error($user)) {
        return home_url();
    }
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_after_login', 10, 3);

// Helper function to get user custom field
function get_user_custom_field($user_id, $field_name)
{
    return get_user_meta($user_id, $field_name, true);
}

// Add custom fields to user profile in admin
function add_custom_user_profile_fields($user)
{
?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="tel" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="student_id">Student ID</label></th>
            <td>
                <input type="text" name="student_id" id="student_id" value="<?php echo esc_attr(get_user_meta($user->ID, 'student_id', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

// Save custom fields in admin
function save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    if (isset($_POST['student_id'])) {
        update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
    }
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

// Add custom columns to users list table
function add_custom_user_columns($columns)
{
    $columns['phone'] = 'Phone';
    $columns['student_id'] = 'Student ID';
    return $columns;
}
add_filter('manage_users_columns', 'add_custom_user_columns');

// Display custom column data in users list
function show_custom_user_column_data($value, $column_name, $user_id)
{
    if ($column_name == 'phone') {
        return get_user_meta($user_id, 'phone', true) ?: '—';
    }
    if ($column_name == 'student_id') {
        return get_user_meta($user_id, 'student_id', true) ?: '—';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_custom_user_column_data', 10, 3);
