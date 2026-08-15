    </main>

    <?php if (!is_page(array('login', 'signup'))) : ?>
        <footer class="lc-site-footer">
            <div class="lc-site-footer__inner">
                <div class="lc-site-footer__brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Le Cercle — accueil">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/brand/le-cercle-logo.png'); ?>" alt="">
                        <span>Le Cercle</span>
                    </a>
                    <p>La communauté qui partage le rap d’aujourd’hui.</p>
                </div>
                <nav class="lc-site-footer__nav" aria-label="Navigation du pied de page">
                    <a href="<?php echo esc_url(home_url('/forum')); ?>">Forum</a>
                    <a href="<?php echo esc_url(home_url('/artistes')); ?>">Artistes</a>
                    <a href="<?php echo esc_url(home_url('/playlists')); ?>">Playlists</a>
                    <a href="<?php echo esc_url(home_url('/evenements')); ?>">Événements</a>
                    <a href="<?php echo esc_url(home_url('/bons-plans')); ?>">Bons plans</a>
                </nav>
                <a class="lc-site-footer__spotify" href="https://open.spotify.com/" target="_blank" rel="noopener noreferrer">♬ Écouter sur Spotify <b>↗</b></a>
            </div>
            <div class="lc-site-footer__bottom">
                <span>© <?php echo esc_html(wp_date('Y')); ?> Le Cercle</span>
                <span>Projet étudiant · Rap francophone</span>
            </div>
        </footer>
    <?php endif; ?>

    <?php wp_footer(); ?>
    </body>

    </html>
