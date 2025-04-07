<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

$page_for_posts = get_option('page_for_posts');
$bg = get_the_post_thumbnail($page_for_posts, 'full');

get_header();
?>
<main id="main">
    <div class="page_hero">
        <?=$bg?>
    </div>
    <section class="translucent_text--light">
        <div class="container p-5">
            <h1 class="insights-title mb-4">Insights</h1>
            <div class="translucent_text__content"><?=get_the_content(null, false, $page_for_posts)?></div>
        </div>
    </section>
    <section class="latest_insights">
        <div class="container bg--white p-5">
            <div class="row g-5 w-100">
            <?php
                while ( have_posts() ) {
                    the_post();
                    $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    if ( ! $img ) {
                        $img = get_stylesheet_directory_uri() . '/img/default-blog.jpg';
                    }
                    ?>
                    <div class="col-md-4">
                        <a class="latest_insights__card" href="<?=get_the_permalink()?>">
                            <?=get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'latest_insights__image'])?>
                            <h3 class="latest_insights__post-title"><?=get_the_title()?></h3>
                            <div class="latest_insights__intro">
                                <?=get_field('post_excerpt', get_the_ID()) ?: wp_trim_words(get_the_content(), 30)?>
                            </div>
                        </a>
                    </div>
                    <?php
                }
?>
        <?php
        understrap_pagination();
?>
            </div>
        </div>
    </div>
</main>
<?php

get_footer();
?>