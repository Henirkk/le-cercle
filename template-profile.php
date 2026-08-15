<?php
/* Template Name: Profil utilisateur */
get_header();

$u          = get_template_directory_uri();
$me         = wp_get_current_user();
$is_member  = $me->exists();
$name       = $is_member ? ($me->display_name ?: $me->user_login) : 'RapFan92';
$handle     = $is_member ? $me->user_login : 'rapfan92';
$initial    = strtoupper(substr($name, 0, 1));
$bio        = $is_member && $me->description ? $me->description : 'Passionné de rap français, collectionneur de vinyles et toujours à la recherche des prochaines pépites de la scène.';
$location   = $is_member ? get_user_meta($me->ID, 'lc_location', true) : 'Bruxelles, Belgique';
$location   = $location ?: 'Bruxelles, Belgique';
$avatar     = $is_member ? get_avatar_url($me->ID, array('size' => 160)) : $u . '/assets/images/figma/forum/rapfan92.png';
?>
<div class="lc-home lc-profile-page">
<?php get_template_part('template-parts/site-header'); ?>

<main class="lc-profile">
  <section class="lc-profile-hero">
    <div class="lc-profile-cover" aria-hidden="true"><span>LE CERCLE</span><i></i><i></i><i></i></div>
    <div class="lc-profile-overview">
      <div class="lc-profile-avatar"><img src="<?php echo esc_url($avatar); ?>" alt="Avatar de <?php echo esc_attr($name); ?>"><span>●</span></div>
      <div class="lc-profile-identity"><div><h1><?php echo esc_html($name); ?></h1><em>Membre actif</em></div><p>@<?php echo esc_html($handle); ?></p></div>
      <div class="lc-profile-buttons"><?php if ($is_member) : ?><button class="lc-profile-edit" type="button">✎ Modifier le profil</button><a class="lc-profile-home" href="<?php echo esc_url(home_url('/')); ?>">⌂ Accueil</a><a class="lc-profile-signout" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">Déconnexion</a><?php else : ?><a href="<?php echo esc_url(home_url('/login')); ?>">Se connecter</a><?php endif; ?></div>
    </div>
    <div class="lc-profile-details"><p><?php echo esc_html($bio); ?></p><div><span>⌖ <?php echo esc_html($location); ?></span><span>◷ Membre depuis mars 2024</span><span>♬ Rap FR · Boom bap</span></div></div>
    <dl class="lc-profile-stats"><div><dt>Publications</dt><dd>48</dd></div><div><dt>Sujets</dt><dd>16</dd></div><div><dt>Abonnés</dt><dd>1 284</dd></div><div><dt>Abonnements</dt><dd>392</dd></div><div><dt>Likes reçus</dt><dd>3 842</dd></div></dl>
    <nav class="lc-profile-tabs" aria-label="Contenu du profil"><button class="is-active" data-profile-tab="posts">Publications <b>48</b></button><button data-profile-tab="topics">Sujets <b>16</b></button><button data-profile-tab="saved">Favoris <b>24</b></button><button data-profile-tab="about">À propos</button></nav>
  </section>

  <?php if (isset($_GET['updated']) && $_GET['updated'] === '1') : ?><div class="lc-profile-notice">✓ Profil mis à jour avec succès.</div><?php endif; ?>

  <div class="lc-profile-layout">
    <section class="lc-profile-content">
      <div class="lc-profile-panel is-active" data-profile-panel="posts">
        <article class="lc-profile-post"><header><div class="lc-mini-avatar"><img src="<?php echo esc_url($avatar); ?>" alt=""></div><div><strong><?php echo esc_html($name); ?></strong><small>@<?php echo esc_html($handle); ?> · il y a 2 h</small></div><em>À l’écoute</em><button>•••</button></header><p>Le nouveau feat de Damso avec une jeune artiste tourne en boucle aujourd’hui. Un morceau doux et love, porté par une vraie belle alchimie entre les deux voix. 🎧</p><section class="lc-profile-track lc-spotify-player" aria-label="Lecteur Spotify"><iframe data-testid="embed-iframe" title="Écouter ce titre sur Spotify" src="https://open.spotify.com/embed/track/7heoPFrtuH6JU6AcfzjWHp?utm_source=generator" width="100%" height="152" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe></section><footer><button class="lc-profile-like" data-count="128">♡ <b>128</b></button><button>◯ 18</button><button class="lc-profile-share">⌁ Partager</button></footer></article>
        <article class="lc-profile-post"><header><div class="lc-mini-avatar"><img src="<?php echo esc_url($avatar); ?>" alt=""></div><div><strong><?php echo esc_html($name); ?></strong><small>@<?php echo esc_html($handle); ?> · hier</small></div><em>Concert</em><button>•••</button></header><p>Quelques images du concert d’hier soir. Une énergie incroyable dans la salle et un public qui connaissait chaque parole.</p><img class="lc-profile-media" src="<?php echo esc_url($u.'/assets/images/figma/home-post-1.png'); ?>" alt="Artiste sur scène"><footer><button class="lc-profile-like" data-count="246">♡ <b>246</b></button><button>◯ 31</button><button class="lc-profile-share">⌁ Partager</button></footer></article>
      </div>

      <div class="lc-profile-panel" data-profile-panel="topics"><h2>Sujets créés</h2><?php $profile_topics = array(array('Qui sont vos artistes rap préférés en 2025 ?', 'Actualités', 342), array('Vos meilleures découvertes indépendantes', 'Bons plans', 87), array('Le retour du boom bap en France', 'Beats', 64)); foreach ($profile_topics as $item) : ?><a class="lc-profile-topic" href="<?php echo esc_url(home_url('/forum/sujet/'.sanitize_title($item[0]))); ?>"><span>◎</span><div><strong><?php echo esc_html($item[0]); ?></strong><small><?php echo esc_html($item[1]); ?> · <?php echo esc_html($item[2]); ?> réponses</small></div><b>›</b></a><?php endforeach; ?></div>
      <div class="lc-profile-panel" data-profile-panel="saved"><h2>Favoris</h2><div class="lc-profile-empty"><span>☆</span><strong>Vos contenus enregistrés</strong><p>Les publications et sujets sauvegardés apparaîtront ici.</p><a href="<?php echo esc_url(home_url('/')); ?>">Explorer le fil</a></div></div>
      <div class="lc-profile-panel" data-profile-panel="about"><h2>À propos</h2><div class="lc-profile-about"><div><span>Bio</span><p><?php echo esc_html($bio); ?></p></div><div><span>Localisation</span><p><?php echo esc_html($location); ?></p></div><div><span>Styles préférés</span><p>Rap français, boom bap, rap alternatif</p></div><div><span>Membre depuis</span><p>Mars 2024</p></div></div></div>
    </section>

    <aside class="lc-profile-side"><section><h2>Badges</h2><div class="lc-profile-badges"><span title="Membre actif">★</span><span title="Contributeur">♬</span><span title="Explorateur">⌁</span><span title="1000 likes">♥</span></div><p>4 badges débloqués</p></section><section><h2>Communautés</h2><a><i>BB</i><span><strong>Boom Bap France</strong><small>12,4 k membres</small></span></a><a><i>RF</i><span><strong>Rap FR Indépendant</strong><small>8,7 k membres</small></span></a><a><i>VC</i><span><strong>Vinyles & Culture</strong><small>3,2 k membres</small></span></a></section><section class="lc-profile-completion"><h2>Profil complété à 80%</h2><div><i></i></div><p>Ajoutez vos artistes préférés pour compléter votre profil.</p></section></aside>
  </div>
</main>

<?php if ($is_member) : ?><dialog class="lc-profile-dialog"><form method="post" action="<?php echo esc_url(home_url('/profil')); ?>"><header><h2>Modifier le profil</h2><button type="button" class="lc-profile-close" aria-label="Fermer">×</button></header><div><?php wp_nonce_field('lc_profile_update', 'lc_profile_nonce'); ?><label>Nom affiché<input name="display_name" maxlength="60" value="<?php echo esc_attr($name); ?>" required></label><label>Bio<textarea name="description" maxlength="240"><?php echo esc_textarea($bio); ?></textarea></label><label>Localisation<input name="location" maxlength="80" value="<?php echo esc_attr($location); ?>"></label></div><footer><button type="button" class="lc-profile-cancel">Annuler</button><button type="submit" name="lc_profile_submit">Enregistrer</button></footer></form></dialog><?php endif; ?>
</div>
<?php get_footer(); ?>
