<?php
if (!is_block_region_applicable()) {
    return;
}
?>
<section class="two_col_text_feature">
    <div class="container">
        <div class="row">
            <div class="col-md-7 p-5">
                <?=get_field('left_content')?>
            </div>
            <div class="col-md-5 p-5">
                <?php
                if (get_field('image') ?? null) {
                    echo wp_get_attachment_image(get_field('image'), 'large', false, ['class' => 'two_col_text_feature__image mb-4']);
                }
if (get_field('quote') ?? null) {
    $q = get_field('quote');
    ?>
                <div class="quote">
                    <div class="quote__quote">
                        <?=$q['quote']?>
                    </div>
                    <div class="quote__attribution">
                        <?=$q['attribution']?>
                    </div>
                </div>
                    <?php
}
?>
            </div>
        </div>
    </div>
</section>