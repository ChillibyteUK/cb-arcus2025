<?php
if (!is_block_region_applicable()) {
    return;
}
?>
<section class="text_text">
    <div class="container">
        <div class="text_text__parallax">
            <?=wp_get_attachment_image(get_field('image'),'full',false,['class' => 'text_text__parallax_image', 'data-parallax' => ''])?>
        </div>
        <div class="row">
            <div class="col-md-6 p-5">
            <h2><?= get_field('title_left') ?></h2>
                <div class="mb-5"><?= get_field('content_left') ?></div>
                <?php
                if (!empty(get_field('cta_left'))) {
                    $l = get_field('cta_left');
                    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-6 p-5">
                <h2><?= get_field('title_right') ?></h2>
                <div class="mb-5"><?= get_field('content_right') ?></div>
                <?php
                if (!empty(get_field('cta_right'))) {
                    $l = get_field('cta_right');
                    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>