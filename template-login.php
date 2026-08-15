<?php
/**
 * Template Name: Login Template
 */

get_header();

$asset_uri      = get_template_directory_uri() . '/assets/icons/figma/';
$brand_logo_uri = get_template_directory_uri() . '/assets/images/brand/le-cercle-logo.png';
$login_status   = isset($_GET['login']) ? sanitize_key(wp_unslash($_GET['login'])) : '';
?>

<div class="auth-page auth-page--login">
    <div class="auth-decor" aria-hidden="true">
        <span class="auth-decor__title">LE CERCLE</span>
        <span class="auth-decor__word auth-decor__word--one">RAP</span>
        <span class="auth-decor__word auth-decor__word--two">CULTURE</span>
        <span class="auth-decor__word auth-decor__word--three">COMMUNAUTÉ</span>
        <span class="auth-wave auth-wave--left"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span>
        <span class="auth-wave auth-wave--right"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span>
    </div>

    <section class="auth-shell" aria-labelledby="login-title">
        <header class="auth-brand">
            <span class="auth-brand__mark"><img src="<?php echo esc_url($brand_logo_uri); ?>" alt="Le Cercle"></span>
            <strong>Le Cercle</strong>
            <p>Retrouvez la communauté rap</p>
        </header>

        <div class="auth-card">
            <h1 id="login-title">Connexion</h1>

            <?php if ($login_status === 'failed') : ?>
                <div class="auth-notice auth-notice--error" role="alert">Adresse e-mail, nom d’utilisateur ou mot de passe incorrect.</div>
            <?php elseif ($login_status === 'empty') : ?>
                <div class="auth-notice auth-notice--error" role="alert">Merci de remplir les deux champs.</div>
            <?php endif; ?>

            <?php if (is_user_logged_in()) : ?>
                <div class="auth-notice auth-notice--success">Vous êtes déjà connecté.</div>
                <div class="auth-session-actions">
                    <a class="auth-submit" href="<?php echo esc_url(home_url('/')); ?>">Accéder au Cercle</a>
                    <a class="auth-secondary" href="<?php echo esc_url(wp_logout_url(home_url('/login'))); ?>">Se déconnecter</a>
                </div>
            <?php else : ?>
                <form method="post" action="<?php echo esc_url(home_url('/login')); ?>" class="auth-form">
                    <?php wp_nonce_field('login_action', 'login_nonce'); ?>

                    <div class="auth-field">
                        <label for="login-identity">Adresse e-mail ou nom d’utilisateur</label>
                        <span class="auth-input">
                            <img src="<?php echo esc_url($asset_uri . 'mail-v2.svg'); ?>" alt="">
                            <input type="text" name="log" id="login-identity" placeholder="votre@email.com" autocomplete="username" required>
                        </span>
                    </div>

                    <div class="auth-field">
                        <label for="login-password">Mot de passe</label>
                        <span class="auth-input">
                            <img src="<?php echo esc_url($asset_uri . 'lock-v2.svg'); ?>" alt="">
                            <input type="password" name="pwd" id="login-password" placeholder="••••••••" autocomplete="current-password" required>
                        </span>
                    </div>

                    <div class="auth-options">
                        <label class="auth-remember"><input type="checkbox" name="rememberme" value="forever"> Rester connecté</label>
                        <a class="auth-forgot" href="<?php echo esc_url(wp_lostpassword_url(home_url('/login'))); ?>">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" name="login_submit" class="auth-submit">Se connecter</button>
                </form>

                <div class="auth-separator"><span>ou</span></div>
                <p class="auth-switch">Vous n’avez pas encore de compte ?</p>
                <a class="auth-secondary" href="<?php echo esc_url(home_url('/signup')); ?>">Créer un compte</a>
            <?php endif; ?>
        </div>

        <p class="auth-legal">En vous connectant, vous acceptez nos conditions d’utilisation</p>
    </section>
</div>

<?php get_footer(); ?>
