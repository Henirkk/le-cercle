<?php
/* Template Name: Sujet du forum */
get_header();

$u       = get_template_directory_uri();
$me      = wp_get_current_user();
$initial = $me->exists() ? strtoupper(substr($me->display_name ?: $me->user_login, 0, 1)) : 'U';
$path    = trim((string) wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$slug    = sanitize_title(basename($path));
$topics  = array(
    'qui-sont-vos-artistes-rap-preferes-en-2025' => array('Qui sont vos artistes rap préférés en 2025 ?', 'Actualités', 'RapFan92', 'rapfan92.png', 'Il y a 3 h', 342, 5421),
    'conseils-pour-ameliorer-son-flow-et-sa-technique' => array('Conseils pour améliorer son flow et sa technique', 'Freestyles', 'YoungMC', 'youngmc.png', 'Il y a 5 h', 89, 1245),
    'concert-booba-a-paris-qui-y-va' => array('Concert Booba à Paris — Qui y va ?', 'Concerts', 'ConcertLover', 'concertlover.png', 'Hier', 156, 3421),
    'comparatif-interfaces-audio-pour-home-studio' => array('Comparatif interfaces audio pour home studio', 'Bons plans', 'TechGeek', '', 'Hier', 67, 1122),
    'les-meilleures-punchlines-de-lhistoire-du-rap-fr' => array("Les meilleures punchlines de l’histoire du rap FR", 'Freestyles', 'PunchlineCollector', 'punchlinecollector.png', 'Il y a 2 j', 203, 5678),
    'nekfeu-annonce-son-nouvel-album' => array('Nekfeu annonce son nouvel album', 'Actualités', 'NewsAlert', '', 'Il y a 2 j', 98, 2134),
);
$topic_post = get_page_by_path($slug, OBJECT, 'lc_forum_topic');
$is_dynamic_topic = $topic_post instanceof WP_Post;
if ($is_dynamic_topic) {
    $topic_author = get_the_author_meta('display_name', $topic_post->post_author);
    $topic = array($topic_post->post_title, get_post_meta($topic_post->ID, 'lc_topic_category', true) ?: 'Actualités', $topic_author ?: 'Membre Le Cercle', '', 'À l’instant', 0, 0);
} else {
    $topic = isset($topics[$slug]) ? $topics[$slug] : $topics['qui-sont-vos-artistes-rap-preferes-en-2025'];
}
$replies = array(
    array('M', 'MusicLover', '@musiclover', 'Il y a 2 h', 'Pour moi, cette année c’est clairement Tiakola. Il arrive à garder une vraie identité tout en proposant des morceaux très différents. Son dernier projet tourne en boucle chez moi.', 74),
    array('S', 'StudioPro', '@studiopro', 'Il y a 1 h', 'Je mettrais aussi SCH dans la liste. Sa direction artistique reste l’une des plus travaillées de la scène française, autant dans les sons que dans les visuels.', 51),
    array('Y', 'YoungMC', '@youngmc', 'Il y a 18 min', 'Je découvre beaucoup de nouveaux artistes grâce aux recommandations du forum. En ce moment, je conseille Jewel Usain et H JeuneCrack.', 29),
);
?>
<div class="lc-home lc-thread-page">
<header class="lc-header"><a class="lc-brand" href="<?php echo esc_url(home_url('/')); ?>"><span><img src="<?php echo esc_url($u.'/assets/images/brand/le-cercle-logo.png'); ?>" alt=""></span><b>Le Cercle</b></a><nav><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a><a class="active" href="<?php echo esc_url(home_url('/forum')); ?>">Forum</a><a href="<?php echo esc_url(home_url('/artistes')); ?>">Artistes</a><a href="<?php echo esc_url(home_url('/playlists')); ?>">Playlists</a><a href="<?php echo esc_url(home_url('/evenements')); ?>">Événements</a></nav><div class="lc-tools"><label>⌕ <input placeholder="Rechercher..."></label><a href="<?php echo esc_url(is_user_logged_in()?home_url('/profil'):home_url('/login')); ?>"><?php echo esc_html($initial); ?></a></div></header>

<main class="lc-thread">
  <nav class="lc-breadcrumb" aria-label="Fil d’Ariane"><a href="<?php echo esc_url(home_url('/forum')); ?>">Forum</a><span>›</span><a href="<?php echo esc_url(home_url('/forum')); ?>"><?php echo esc_html($topic[1]); ?></a><span>›</span><b>Sujet</b></nav>
  <header class="lc-thread-title"><div><span><?php echo esc_html($topic[1]); ?></span><h1><?php echo esc_html($topic[0]); ?></h1><p>Discussion lancée par <?php echo esc_html($topic[2]); ?> · <?php echo esc_html($topic[4]); ?></p></div><button class="lc-thread-follow" type="button" aria-pressed="false">＋ Suivre</button></header>

  <div class="lc-thread-layout">
    <section class="lc-thread-stream">
      <article class="lc-thread-post lc-thread-post--origin" data-thread-message="origin">
        <aside class="lc-thread-author"><div class="lc-thread-avatar"><?php if ($topic[3]) : ?><img src="<?php echo esc_url($u.'/assets/images/figma/forum/'.$topic[3]); ?>" alt=""><?php else : ?><?php echo esc_html(strtoupper(substr($topic[2], 0, 1))); ?><?php endif; ?></div><strong><?php echo esc_html($topic[2]); ?></strong><small>@<?php echo esc_html(strtolower($topic[2])); ?></small><em>Auteur</em><span>1 284 messages</span></aside>
        <div class="lc-thread-message"><header><time><?php echo esc_html($topic[4]); ?></time><button type="button" aria-label="Plus d’options">•••</button></header><div class="lc-thread-copy"><?php if ($is_dynamic_topic) : ?><p><?php echo nl2br(esc_html($topic_post->post_content)); ?></p><?php else : ?><p>Salut Le Cercle 👋</p><p>La scène rap évolue énormément cette année et je suis curieux de connaître vos artistes du moment. Qui vous a le plus marqué en 2025, que ce soit par un album, une performance ou une vraie proposition artistique ?</p><p>Partagez aussi un morceau à écouter pour faire découvrir vos choix à toute la communauté.</p><?php endif; ?></div><footer class="lc-thread-actions"><button class="lc-thread-like" type="button" data-count="<?php echo esc_attr($topic[5]); ?>" aria-pressed="false">♡ <b><?php echo esc_html($topic[5]); ?></b></button><button class="lc-thread-reply-trigger" type="button">↩ Répondre</button><button class="lc-thread-share" type="button">⌁ Partager</button></footer></div>
      </article>

      <div class="lc-thread-divider"><span><?php echo count($replies); ?> réponses</span><i></i><select aria-label="Trier les réponses"><option>Plus récentes</option><option>Plus populaires</option></select></div>

      <div class="lc-thread-replies">
      <?php foreach ($replies as $index => $reply) : ?>
        <article class="lc-thread-post" data-thread-message="reply-<?php echo esc_attr($index); ?>"><aside class="lc-thread-author"><div class="lc-thread-avatar lc-thread-avatar--letter"><?php echo esc_html($reply[0]); ?></div><strong><?php echo esc_html($reply[1]); ?></strong><small><?php echo esc_html($reply[2]); ?></small><span><?php echo esc_html(214 + ($index * 97)); ?> messages</span></aside><div class="lc-thread-message"><header><time><?php echo esc_html($reply[3]); ?></time><button type="button" aria-label="Plus d’options">•••</button></header><div class="lc-thread-copy"><p><?php echo esc_html($reply[4]); ?></p></div><footer class="lc-thread-actions"><button class="lc-thread-like" type="button" data-count="<?php echo esc_attr($reply[5]); ?>" aria-pressed="false">♡ <b><?php echo esc_html($reply[5]); ?></b></button><button class="lc-thread-reply-trigger" type="button">↩ Répondre</button></footer></div></article>
      <?php endforeach; ?>
      </div>

      <form class="lc-reply-box">
        <div class="lc-thread-avatar lc-thread-avatar--letter"><?php echo esc_html($initial); ?></div>
        <div><label for="lc-reply">Votre réponse</label><textarea id="lc-reply" maxlength="1200" placeholder="Partagez votre avis avec la communauté..."></textarea><footer><small class="lc-reply-count">0 / 1200</small><button type="submit">Publier la réponse</button></footer></div>
      </form>
    </section>

    <aside class="lc-thread-side">
      <section><h2>À propos du sujet</h2><dl><div><dt>Réponses</dt><dd><?php echo esc_html($topic[5]); ?></dd></div><div><dt>Vues</dt><dd><?php echo esc_html(number_format_i18n($topic[6])); ?></dd></div><div><dt>Participants</dt><dd>128</dd></div></dl></section>
      <section><h2>Règles du Cercle</h2><ul><li>Respectez les autres membres</li><li>Restez dans le sujet</li><li>Pas de contenu promotionnel abusif</li></ul><a href="#">Voir toutes les règles</a></section>
      <a class="lc-thread-back" href="<?php echo esc_url(home_url('/forum')); ?>">← Retour au forum</a>
    </aside>
  </div>
</main>
</div>
<?php get_footer(); ?>
