<?php
if (!is_block_region_applicable()) {
    return;
}

$has_bg = get_field('has_background');
if (!empty($has_bg) && is_array($has_bg)) {
    $bg = 'text_text__background';
} else {
    $bg = '';
}
?>
<section class="text_text">
    <div class="container <?=$bg?>">
        <div class="text_text__parallax">
            <?=wp_get_attachment_image(get_field('image'), 'full', false, ['class' => 'text_text__parallax_image', 'data-parallax' => ''])?>
        </div>
        <div class="row">
            <div class="col-md-6 p-5 text_text__left">
                <?php
                if (get_field('title_left') ?? null) {
                    echo '<h2>' . get_field('title_left') . '</h2>';
                }
?>
                <div class="mb-5"><?= get_field('content_left') ?></div>
                <?php
if (!empty(get_field('link_left'))) {
    $l = get_field('link_left');
    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
                    <?php
}
?>
            </div>
            <div class="col-md-6 p-5 text_text__right">
                <?php
if (get_field('title_right') ?? null) {
    echo '<h2>' . get_field('title_right') . '</h2>';
}
?>
                <div class="mb-5"><?= get_field('content_right') ?></div>
                <?php
if (!empty(get_field('link_right'))) {
    $l = get_field('link_right');
    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
                    <?php
}
?>
            </div>
        </div>
    </div>
</section>