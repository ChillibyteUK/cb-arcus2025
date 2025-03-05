<?php
if (!is_block_region_applicable()) {
    return;
}
?>
<section class="text_image">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text_image__left p-5">
                <h2><?=get_field('title')?></h2>
                <div class="mb-5"><?=get_field('content')?></div>
                <?php
                if (!empty(get_field('link'))) {
                    $l = get_field('link');
                    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button--wo"><?=$l['title']?></a>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-6 text_image__right">
                <?=wp_get_attachment_image(get_field('image'),'large',false,['class' => 'text_image__image'])?>
            </div>
        </div>
    </div>
</section>