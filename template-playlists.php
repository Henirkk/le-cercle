<?php
/* Template Name: Playlists */
get_header();
$u = get_template_directory_uri();
$me = wp_get_current_user();
$initial = $me->exists() ? strtoupper(substr($me->display_name ?: $me->user_login, 0, 1)) : 'U';
$playlists = array(
    array('Love en boucle', 'Damso, Meryl, Lous and The Yakuza', 'Pour les trajets tardifs et les messages qu’on hésite à envoyer.', 'love', 'Douceur', '65lCFhOz5RyYH52JryAf10'),
    array('Bruxelles connectée', 'Hamza, Zwangere Guy, Isha', 'Une sélection entre rap belge, intensité et nouveautés.', 'brussels', 'Rap belge', '0cFS3AMF9Lhj3CNoFvwjvY'),
    array('Nouveaux visages', 'SDM, Jewel Usain, Theodora', 'Les artistes que la communauté veut voir monter.', 'new', 'Découverte', '5Y8C6KjzBRKvcT3Aln1Bc4'),
    array('Sessions freestyle', 'Lacrim, Niska, Soso Maness', 'Du flow brut, des punchlines et de l’énergie live.', 'freestyle', 'Freestyle', '1TaJ5m4eKM2gFqhxQo4YWX'),
);
?>
<div class="lc-home lc-playlists-page">
<?php get_template_part('template-parts/site-header'); ?>
  <main class="lc-playlists">
    <section class="lc-playlists-hero"><div><span>♬ SÉLECTIONS LE CERCLE</span><h1>Les sons qui tournent en boucle.</h1><p>Des playlists imaginées pour chaque moment, entre rap francophone, découvertes et sons à partager.</p></div><p class="lc-playlists-count"><b>04</b><span>playlists<br>à écouter</span></p></section>
    <section class="lc-playlists-feature" aria-label="Sélection du moment"><div class="lc-playlists-feature-copy"><span>EN CE MOMENT</span><h2>Love en boucle</h2><p>Pour les trajets tardifs et les messages qu’on hésite à envoyer.</p><div class="lc-playlists-meta"><span>♬ 18 titres</span><span>·</span><span>52 min</span></div></div><div class="lc-playlists-player"><iframe title="Love en boucle sur Spotify" src="https://open.spotify.com/embed/track/65lCFhOz5RyYH52JryAf10?utm_source=generator" width="100%" height="352" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe></div></section>
    <section class="lc-playlists-library"><header><div><h2>À écouter maintenant</h2><p>Un titre à écouter dans chaque sélection.</p></div><span><b>4</b> playlists</span></header><div class="lc-playlist-grid"><?php foreach ($playlists as $index => $playlist) : ?><article class="lc-playlist-card" data-spotify="<?php echo esc_attr($playlist[5]); ?>" data-search="<?php echo esc_attr(strtolower(implode(' ', $playlist))); ?>"><div class="lc-playlist-cover lc-playlist-cover--<?php echo esc_attr($playlist[3]); ?>"><i><?php echo $index === 0 ? '▶' : '♬'; ?></i><span><?php echo esc_html($playlist[4]); ?></span></div><div><h3><?php echo esc_html($playlist[0]); ?></h3><p><?php echo esc_html($playlist[1]); ?></p><small><?php echo esc_html($playlist[2]); ?></small></div><div class="lc-playlist-embed"><iframe title="<?php echo esc_attr($playlist[0]); ?> sur Spotify" src="https://open.spotify.com/embed/track/<?php echo esc_attr($playlist[5]); ?>?utm_source=generator" width="100%" height="352" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe></div></article><?php endforeach; ?></div></section>
  </main>
</div>
<?php get_footer(); ?>
