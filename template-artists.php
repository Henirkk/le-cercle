<?php
/* Template Name: Artistes */
get_header();
$u = get_template_directory_uri();
$me = wp_get_current_user();
$initial = $me->exists() ? strtoupper(substr($me->display_name ?: $me->user_login, 0, 1)) : 'U';
$artists = array(
    array('Damso', 'D', 'Bruxelles', 'Rap · R&B', '2,8 M', '#3b2400', 'damso.jpg'),
    array('Meryl', 'M', 'Martinique', 'Rap · Pop', '580 k', '#351c45', 'meryl.jpg'),
    array('Jewel Usain', 'J', 'Paris', 'Rap alternatif', '415 k', '#0d3538', 'jewel-usain.jpg'),
    array('Luidji', 'L', 'Paris', 'Rap · Soul', '1,2 M', '#30200d', 'luidji.jpg'),
    array('Theodora', 'T', 'Paris', 'Rap · Afro', '266 k', '#3b111f', 'theodora.jpg'),
    array('H JeuneCrack', 'H', 'Paris', 'Hip-hop', '352 k', '#17243b', 'h-jeunecrack.jpg'),
);
?>
<style>
.lc-artists-page .lc-artist-art img[alt="Damso"]{object-position:center 22%}
.lc-artists-page .lc-artist-art img[alt="Meryl"]{object-position:center 16%}
.lc-artists-page .lc-artist-art img[alt="Jewel Usain"]{object-position:center 11%}
.lc-artists-page .lc-artist-art img[alt="Luidji"]{object-position:center 42%}
.lc-artists-page .lc-artist-art img[alt="Theodora"]{object-position:center 18%}
.lc-artists-page .lc-artist-art img[alt="H JeuneCrack"]{object-position:center 18%}
.lc-artists-page .lc-feature-photo{background:#0e0e0e}
.lc-artists-page .lc-feature-photo:before,.lc-artists-page .lc-feature-photo:after{display:none}
.lc-artists-page .lc-feature-photo img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 22%;filter:saturate(.8) contrast(1.06)}
.lc-artists-page .lc-feature-photo span{z-index:2;text-shadow:0 2px 12px #000}
.lc-artists-page .lc-feature-photo:has(img){background:linear-gradient(90deg,rgba(0,0,0,.08),rgba(0,0,0,.45))}
</style>
<div class="lc-home lc-artists-page">
<?php get_template_part('template-parts/site-header'); ?>
  <main class="lc-artists">
    <section class="lc-artists-intro"><div><span>↗ Découvrir</span><h1>Les voix qui font bouger la scène.</h1><p>Artistes établis, nouveaux visages et coups de cœur de la communauté Le Cercle.</p></div><div class="lc-artists-number"><b>06</b><span>artistes<br>à suivre</span></div></section>
    <section class="lc-artists-featured">
      <div class="lc-feature-copy"><span>ARTISTE À LA UNE</span><h2>Damso</h2><p>Une écriture singulière, une aura rare et des morceaux qui continuent de marquer le rap francophone.</p><div><button type="button" class="lc-artist-follow" data-artist="damso">＋ Suivre</button><a href="#artistes">Voir les artistes <b>→</b></a></div></div>
      <div class="lc-feature-mark lc-feature-photo"><img src="<?php echo esc_url($u . '/assets/images/artists/damso.jpg'); ?>" alt="Portrait de Damso"><span>BRUXELLES · RAP FRANCOPHONE</span></div>
    </section>
    <section class="lc-artists-list" id="artistes"><header><div><h2>À découvrir maintenant</h2><p>Des artistes sélectionnés par la communauté.</p></div><span><b>6</b> artistes</span></header><div class="lc-artist-grid"><?php foreach ($artists as $artist) : ?><article class="lc-artist-card" data-search="<?php echo esc_attr(strtolower(implode(' ', array_slice($artist, 0, 4)))); ?>"><div class="lc-artist-art" style="--artist-color:<?php echo esc_attr($artist[5]); ?>"><?php if ($artist[6]) : ?><img src="<?php echo esc_url($u . '/assets/images/artists/' . $artist[6]); ?>" alt="<?php echo esc_attr($artist[0]); ?>"><span><?php echo esc_html($artist[0]); ?></span><?php else : ?><b><?php echo esc_html($artist[1]); ?></b><span><?php echo esc_html($artist[0]); ?></span><?php endif; ?></div><div class="lc-artist-info"><div><h3><?php echo esc_html($artist[0]); ?></h3><button type="button" class="lc-artist-follow" data-artist="<?php echo esc_attr(sanitize_title($artist[0])); ?>">＋ Suivre</button></div><p><?php echo esc_html($artist[3]); ?> · <?php echo esc_html($artist[2]); ?></p><small>♬ <?php echo esc_html($artist[4]); ?> auditeurs mensuels</small></div></article><?php endforeach; ?></div><p class="lc-artists-credits">Photos : Damso — Thesupermat (CC BY-SA 4.0) ; Jewel Usain — Gnouz Kent (CC BY-SA 4.0) ; Luidji — ManoSolo13241324 (CC0) ; Théodora — Degobex (CC0) ; H JeuneCrack — Tohkagero (CC BY-SA 4.0), via Wikimedia Commons.</p></section>
  </main>
</div>
<?php get_footer(); ?>
