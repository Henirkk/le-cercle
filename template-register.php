<?php

/**
 * Template Name: Register Template
 */
get_header();
$asset_uri = get_template_directory_uri() . '/assets/icons/figma/';
$brand_logo_uri = get_template_directory_uri() . '/assets/images/brand/le-cercle-logo.png';
?>
<div class="auth-page">
    <div class="auth-decor" aria-hidden="true">
        <span class="auth-decor__title">LE CERCLE</span>
        <span class="auth-decor__word auth-decor__word--one">RAP</span>
        <span class="auth-decor__word auth-decor__word--two">CULTURE</span>
        <span class="auth-decor__word auth-decor__word--three">COMMUNAUTÉ</span>
        <span class="auth-wave auth-wave--left"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span>
        <span class="auth-wave auth-wave--right"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span>
    </div>
    <section class="auth-shell" aria-labelledby="register-title">
        <header class="auth-brand">
            <span class="auth-brand__mark"><img src="<?php echo esc_url($brand_logo_uri); ?>" alt="Le Cercle"></span>
            <strong>Le Cercle</strong>
            <p>Rejoignez la communauté rap</p>
        </header>
        <div class="auth-card">
            <h1 id="register-title">Créer un compte</h1>

        <?php
        if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
            echo '<div class="success-message">Registration successful! You can now login.</div>';
        }
        if (isset($_GET['registration']) && $_GET['registration'] == 'error') {
            echo '<div class="error-message">Registration failed. Please try again.</div>';
        }
        if (is_user_logged_in()) {
            echo '<div class="success-message">You are already logged in. <a href="' . wp_logout_url(home_url()) . '">Logout</a></div>';
        } else {
        ?>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="auth-form">
                <?php wp_nonce_field('register_action', 'register_nonce'); ?>

                <div class="auth-field">
                    <label for="user_login">Nom d'utilisateur</label>
                    <span class="auth-input"><img src="<?php echo esc_url($asset_uri . 'user-v2.svg'); ?>" alt=""><input type="text" name="user_login" id="user_login" placeholder="votreusername" required></span>
                </div>

                <div class="auth-field">
                    <label for="user_email">Adresse e-mail</label>
                    <span class="auth-input"><img src="<?php echo esc_url($asset_uri . 'mail-v2.svg'); ?>" alt=""><input type="email" name="user_email" id="user_email" placeholder="votre@email.com" required></span>
                </div>

                <div class="auth-field">
                    <label for="user_pass">Mot de passe</label>
                    <span class="auth-input"><img src="<?php echo esc_url($asset_uri . 'lock-v2.svg'); ?>" alt=""><input type="password" name="user_pass" id="user_pass" placeholder="••••••••" required></span>
                </div>

                <div class="auth-field">
                    <label for="user_pass_confirm">Confirmer mot de passe</label>
                    <span class="auth-input"><img src="<?php echo esc_url($asset_uri . 'lock-v2.svg'); ?>" alt=""><input type="password" name="user_pass_confirm" id="user_pass_confirm" placeholder="••••••••" required></span>
                </div>

                <button type="submit" name="register_submit" class="auth-submit">Créer mon compte</button>
            </form>

            <div class="auth-separator"><span>ou</span></div>
            <p class="auth-switch">Vous avez déjà un compte ?</p>
            <a class="auth-secondary" href="<?php echo esc_url(home_url('/login')); ?>">Se connecter</a>

        <?php } ?>
        </div>
        <p class="auth-legal">En créant un compte, vous acceptez nos conditions d'utilisation</p>
    </section>
</div>

<?php
get_footer();
?>
