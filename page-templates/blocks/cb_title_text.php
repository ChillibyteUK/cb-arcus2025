<?php
if (!is_block_region_applicable()) {
    return;
}
?>
<section class="title_text">
    <div class="container">
        <div class="title_text__parallax">
            <?=wp_get_attachment_image(get_field('tab_background'),'full',false,['class' => 'title_text__parallax_image', 'data-parallax' => ''])?>
        </div>
        <div class="row">
            <div class="col-md-6 p-5">
                <h2><?= get_field('title') ?></h2>
            </div>
            <div class="col-md-6 p-5">
                <div class="mb-5"><?= get_field('content') ?></div>
                <?php
                if (!empty(get_field('cta'))) {
                    $l = get_field('cta');
                    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
