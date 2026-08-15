<?php
/**
 * Header visuel partagé du thème Le Cercle.
 * Le fichier header.php conserve la structure technique WordPress.
 */

$lc_template = get_page_template_slug(get_queried_object_id());
$lc_active = '';
$lc_search_class = '';

if (is_front_page()) {
    $lc_active = 'home';
    $lc_search_class = 'lc-home-search';
} elseif ($lc_template === 'template-forum.php') {
    $lc_active = 'forum';
    $lc_search_class = 'lc-forum-search';
} elseif ($lc_template === 'template-topic.php') {
    $lc_active = 'forum';
} elseif ($lc_template === 'template-artists.php') {
    $lc_active = 'artists';
    $lc_search_class = 'lc-artists-search';
} elseif ($lc_template === 'template-playlists.php') {
    $lc_active = 'playlists';
    $lc_search_class = 'lc-playlists-search';
} elseif ($lc_template === 'template-events.php') {
    $lc_active = 'events';
    $lc_search_class = 'lc-events-search';
}

$lc_user = wp_get_current_user();
$lc_display_name = $lc_user->display_name ?: $lc_user->user_login;
$lc_initial = $lc_user->exists() ? strtoupper(substr($lc_display_name, 0, 1)) : 'U';
$lc_profile_url = is_user_logged_in() ? home_url('/profil') : home_url('/login');
$lc_is_profile = $lc_template === 'template-profile.php';
$lc_uri = get_template_directory_uri();
?>

<header class="lc-header">
    <a class="lc-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <span><img src="<?php echo esc_url($lc_uri . '/assets/images/brand/le-cercle-logo.png'); ?>" alt=""></span>
        <b>Le Cercle</b>
    </a>

    <nav>
        <a<?php echo $lc_active === 'home' ? ' class="active"' : ''; ?> href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
        <a<?php echo $lc_active === 'forum' ? ' class="active"' : ''; ?> href="<?php echo esc_url(home_url('/forum')); ?>">Forum</a>
        <a<?php echo $lc_active === 'artists' ? ' class="active"' : ''; ?> href="<?php echo esc_url(home_url('/artistes')); ?>">Artistes</a>
        <a<?php echo $lc_active === 'playlists' ? ' class="active"' : ''; ?> href="<?php echo esc_url(home_url('/playlists')); ?>">Playlists</a>
        <a<?php echo $lc_active === 'events' ? ' class="active"' : ''; ?> href="<?php echo esc_url(home_url('/evenements')); ?>">Événements</a>
    </nav>

    <div class="lc-tools">
        <label>⌕ <input<?php if ($lc_search_class) : ?> class="<?php echo esc_attr($lc_search_class); ?>"<?php endif; ?> placeholder="Rechercher..."></label>
        <a<?php echo $lc_is_profile ? ' class="is-current"' : ''; ?> href="<?php echo esc_url($lc_profile_url); ?>"><?php echo esc_html($lc_initial); ?></a>
    </div>
</header>
