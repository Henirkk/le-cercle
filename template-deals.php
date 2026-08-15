<?php
/* Template Name: Bons plans */
get_header();
$u = get_template_directory_uri();
$me = wp_get_current_user();
$initial = $me->exists() ? strtoupper(substr($me->display_name ?: $me->user_login, 0, 1)) : 'U';
$deals = array(
    array('spotify-premium.png', '-50%', 'Streaming', 'Spotify Premium — 3 mois offerts', 'Découvre tes artistes préférés sans publicité, partout.', 'Valable jusqu’au 30 juin 2027', 'streaming'),
    array('sony-wh1000xm5.png', '-25%', 'Audio', 'Casque Sony WH-1000XM5', 'Le son immersif pour tes trajets, sessions et studios.', 'Valable jusqu’au 15 mai 2027', 'audio'),
    array('festival-hip-hop.png', '-20%', 'Événements', 'Billets Festival Hip-Hop Nation', 'Une journée de lives, de DJs et de culture hip-hop.', 'Valable jusqu’au 20 août 2027', 'events'),
    array('vinyles-rap.png', '-15%', 'Vinyles', 'Vinyles rap français — collection limitée', 'Découvre notre sélection de vinyles collector.', 'Valable jusqu’au 10 septembre 2027', 'vinyles'),
    array('studio-pack.png', '-35%', 'Studios', 'Studio d’enregistrement — pack découverte', '4 heures d’enregistrement avec ingénieur du son professionnel.', 'Valable jusqu’au 30 avril 2027', 'studio'),
    array('merch-printemps.png', '-20%', 'Merch', 'Merchandise Le Cercle — collection printemps', 'T-shirts, sweats et casquettes exclusifs à prix réduit.', 'Valable jusqu’au 20 mars 2027', 'merch'),
);
?>
<div class="lc-home lc-deals-page">
  <header class="lc-header"><a class="lc-brand" href="<?php echo esc_url(home_url('/')); ?>"><span><img src="<?php echo esc_url($u.'/assets/images/brand/le-cercle-logo.png'); ?>" alt=""></span><b>Le Cercle</b></a><nav><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a><a href="<?php echo esc_url(home_url('/forum')); ?>">Forum</a><a href="<?php echo esc_url(home_url('/artistes')); ?>">Artistes</a><a href="<?php echo esc_url(home_url('/playlists')); ?>">Playlists</a><a href="<?php echo esc_url(home_url('/evenements')); ?>">Événements</a></nav><div class="lc-tools"><label>⌕ <input placeholder="Rechercher..."></label><a href="<?php echo esc_url(is_user_logged_in() ? home_url('/profil') : home_url('/login')); ?>"><?php echo esc_html($initial); ?></a></div></header>
  <main class="lc-deals">
    <header class="lc-deals-hero"><div><span>LES BONS PLANS DU CERCLE</span><h1>Des offres pour vivre<br>la culture à fond.</h1><p>Équipement, musique, événements et exclusivités sélectionnés pour la communauté.</p></div><b><i>06</i> offres du moment</b></header>
    <section class="lc-deals-controls"><div><button class="active" type="button" data-deal-filter="all">Tout voir</button><button type="button" data-deal-filter="audio">Audio</button><button type="button" data-deal-filter="events">Événements</button><button type="button" data-deal-filter="merch">Merch</button></div><small>Les offres sont renouvelées régulièrement.</small></section>
    <section class="lc-deals-grid">
      <?php foreach ($deals as $deal) : ?>
      <article class="lc-deal-card" data-deal-type="<?php echo esc_attr($deal[6]); ?>"><div class="lc-deal-image"><img src="<?php echo esc_url($u.'/assets/images/deals/'.$deal[0]); ?>" alt=""><b><?php echo esc_html($deal[1]); ?></b><span><?php echo esc_html($deal[2]); ?></span></div><div class="lc-deal-body"><h2><?php echo esc_html($deal[3]); ?></h2><p><?php echo esc_html($deal[4]); ?></p><small>◷ <?php echo esc_html($deal[5]); ?></small><button type="button">Voir l’offre <b>→</b></button></div></article>
      <?php endforeach; ?>
    </section>
  </main>
</div>
<?php get_footer(); ?>
