<?php
/* Template Name: Forum */
get_header();
$u = get_template_directory_uri();
$me = wp_get_current_user();
$initial = $me->exists() ? strtoupper(substr($me->display_name ?: $me->user_login, 0, 1)) : 'U';
$categories = array(
    array('Actualités', 'actualites.svg', 'Actualités du rap français et international, sorties, annonces', 342, 2847, 'Nouveau single de Freeze Corleone en approche', 'par RapKing · Il y a 5 min'),
    array('Freestyles', 'freestyles.svg', 'Partagez vos flows, punchlines et freestyles originaux', 567, 4123, 'Mon dernier freestyle sur un instru Drill', 'par FlowMaster · Il y a 12 min'),
    array('Beats', 'beats.svg', 'Instrumentales, productions, beat making et techniques', 428, 3215, 'Type beat Travis Scott - Disponible', 'par BeatMaker93 · Il y a 23 min'),
    array('Concerts', 'concerts.svg', 'Concerts, showcases, battles et rencontres rap', 189, 1567, 'Festival Rap en Seine - Line up confirmé', 'par EventPlanner · Il y a 1h'),
    array('Bons plans', 'bons-plans.svg', 'Deals, merchandising, équipement et opportunités', 256, 1834, 'Micro Shure SM7B en promo -30%', 'par Dealz · Il y a 2h'),
);
$discussions = array(
    array('rapfan92.png', 'Qui sont vos artistes rap préférés en 2025 ?', 'Actualités', 'RapFan92', 234, 5421, 'MusicLover', 'Il y a 2 min', 'Épinglé', 'Hot'),
    array('youngmc.png', 'Conseils pour améliorer son flow et sa technique', 'Freestyles', 'YoungMC', 89, 1245, 'StudioPro', 'Il y a 15 min', '', ''),
    array('concertlover.png', 'Concert Booba à Paris - Qui y va ?', 'Concerts', 'ConcertLover', 156, 3421, 'RapHead', 'Il y a 20 min', 'Épinglé', ''),
    array('', 'Comparatif interfaces audio pour home studio', 'Bons plans', 'TechGeek', 67, 1122, 'AudioExpert', 'Il y a 35 min', '', ''),
    array('punchlinecollector.png', "Les meilleures punchlines de l'histoire du rap FR", 'Freestyles', 'PunchlineCollector', 203, 5678, 'OldSchool', 'Il y a 45 min', '', 'Hot'),
    array('', 'Nekfeu annonce son nouvel album', 'Actualités', 'NewsAlert', 98, 2134, 'FanNekfeu', 'Il y a 1h', '', ''),
);
$created_topics = get_posts(array('post_type' => 'lc_forum_topic', 'post_status' => 'publish', 'numberposts' => 20, 'orderby' => 'date', 'order' => 'DESC'));
$created_discussions = array();
foreach ($created_topics as $created_topic) {
    $author = get_the_author_meta('display_name', $created_topic->post_author);
    $created_discussions[] = array('', $created_topic->post_title, get_post_meta($created_topic->ID, 'lc_topic_category', true) ?: 'Actualités', $author ?: 'Membre Le Cercle', 0, 0, $author ?: 'Membre Le Cercle', 'À l’instant', 'Nouveau', '', $created_topic->post_name, $created_topic->ID);
}
$discussions = array_merge($created_discussions, $discussions);
?>
<div class="lc-home lc-forum-page">
<header class="lc-header"><a class="lc-brand" href="<?php echo esc_url(home_url('/')); ?>"><span><img src="<?php echo esc_url($u.'/assets/images/brand/le-cercle-logo.png'); ?>" alt=""></span><b>Le Cercle</b></a><nav><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a><a class="active" href="<?php echo esc_url(home_url('/forum')); ?>">Forum</a><a href="<?php echo esc_url(home_url('/artistes')); ?>">Artistes</a><a href="<?php echo esc_url(home_url('/playlists')); ?>">Playlists</a><a href="<?php echo esc_url(home_url('/evenements')); ?>">Événements</a></nav><div class="lc-tools"><label>⌕ <input class="lc-forum-search" placeholder="Rechercher..."></label><a href="<?php echo esc_url(is_user_logged_in()?home_url('/profil'):home_url('/login')); ?>"><?php echo esc_html($initial); ?></a></div></header>
<main class="lc-forum">
  <section class="lc-forum-intro"><div><h1>Forum Le Cercle</h1><p>Échangez avec la communauté rap sur tous les sujets qui vous passionnent</p></div><button class="lc-new-topic" type="button">＋ Créer un sujet</button></section>
  <?php if (isset($_GET['topic']) && $_GET['topic'] === 'created') : ?><p class="lc-forum-notice">✓ Ton sujet est publié et visible dans les discussions récentes.</p><?php elseif (isset($_GET['topic']) && $_GET['topic'] === 'deleted') : ?><p class="lc-forum-notice">✓ Ton sujet a été supprimé.</p><?php elseif (isset($_GET['topic']) && $_GET['topic'] === 'error') : ?><p class="lc-forum-notice lc-forum-notice--error">Impossible de publier ou supprimer le sujet. Réessaie.</p><?php endif; ?>
  <section class="lc-forum-categories"><header><h2>Catégories</h2><span>5 catégories · 1782 sujets</span></header><div class="lc-category-grid">
  <?php foreach ($categories as $cat): ?><article class="lc-category" tabindex="0"><div class="lc-category-icon"><img src="<?php echo esc_url($u.'/assets/icons/figma/forum/'.$cat[1]); ?>" alt=""></div><div class="lc-category-body"><h3><?php echo esc_html($cat[0]); ?></h3><p><?php echo esc_html($cat[2]); ?></p><div class="lc-category-stats"><span><img src="<?php echo esc_url($u.'/assets/icons/figma/forum/topics.svg'); ?>" alt=""><?php echo esc_html($cat[3]); ?> sujets</span><i></i><span><?php echo esc_html($cat[4]); ?> messages</span></div><div class="lc-last"><small>Dernier message</small><b><?php echo esc_html($cat[5]); ?></b><span><?php echo esc_html($cat[6]); ?></span><img src="<?php echo esc_url($u.'/assets/icons/figma/forum/arrow.svg'); ?>" alt=""></div></div></article><?php endforeach; ?>
  </div></section>
  <section class="lc-discussions"><header><h2>Discussions récentes</h2><button class="lc-new-topic" type="button">Nouvelle discussion</button></header><div class="lc-discussion-list">
  <?php foreach ($discussions as $index => $d): ?><article class="lc-discussion" data-search="<?php echo esc_attr(strtolower($d[1].' '.$d[2].' '.$d[3])); ?>"><div class="lc-disc-avatar"><?php if ($d[0]): ?><img src="<?php echo esc_url($u.'/assets/images/figma/forum/'.$d[0]); ?>" alt=""><?php else: ?><span><?php echo esc_html(strtoupper(substr($d[3],0,1))); ?></span><?php endif; ?></div><div class="lc-disc-main"><h3><a href="<?php echo esc_url(home_url('/forum/sujet/'.(!empty($d[10]) ? $d[10] : sanitize_title($d[1])))); ?>"><?php echo esc_html($d[1]); ?></a><?php if ($d[8]): ?><em><?php echo esc_html($d[8]); ?></em><?php endif; ?><?php if ($d[9]): ?><strong>♨ <?php echo esc_html($d[9]); ?></strong><?php endif; ?></h3><p><b><?php echo esc_html($d[2]); ?></b> par <?php echo esc_html($d[3]); ?></p></div><div class="lc-disc-counts"><span>◯ <?php echo esc_html($d[4]); ?></span><span>⌁ <?php echo esc_html($d[5]); ?></span></div><div class="lc-disc-last"><small>Dernière activité</small><b><?php echo esc_html($d[6]); ?></b><span><?php echo esc_html($d[7]); ?></span><?php if (!empty($d[11]) && (int) get_current_user_id() === (int) get_post_field('post_author', $d[11])) : ?><form class="lc-topic-delete" method="post" action="<?php echo esc_url(home_url('/forum')); ?>" onsubmit="return confirm('Supprimer ce sujet ?');"><?php wp_nonce_field('lc_delete_topic_'.$d[11], 'lc_topic_delete_nonce'); ?><input type="hidden" name="lc_topic_id" value="<?php echo esc_attr($d[11]); ?>"><button type="submit" name="lc_topic_delete" value="1">Supprimer</button></form><?php endif; ?></div></article><?php endforeach; ?>
  </div></section>
</main>
<dialog class="lc-topic-dialog"><form method="post" action="<?php echo esc_url(home_url('/forum')); ?>"><header class="lc-topic-head"><h2>Créer un sujet</h2><button class="lc-dialog-close" type="button" aria-label="Fermer">×</button></header><div class="lc-topic-content"><?php wp_nonce_field('lc_create_topic', 'lc_topic_nonce'); ?><label class="lc-topic-field"><span>Titre</span><input name="topic_title" required maxlength="90" placeholder="Titre de la discussion"></label><label class="lc-topic-field"><span>Catégorie</span><select name="topic_category"><option>Actualités</option><option>Freestyles</option><option>Beats</option><option>Concerts</option><option>Bons plans</option></select></label><label class="lc-topic-field"><span>Message</span><textarea name="topic_message" required maxlength="1200" placeholder="Écrivez votre message..."></textarea><small class="lc-topic-count">0 / 1200</small></label></div><footer class="lc-topic-footer"><button class="lc-topic-cancel" type="button">Annuler</button><button class="lc-topic-submit" type="submit" name="lc_topic_submit" value="1">Publier le sujet</button></footer></form></dialog>
</div>
<?php get_footer(); ?>
