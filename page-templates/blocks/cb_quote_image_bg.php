<?php
if (!is_block_region_applicable()) {
    return;
}
$colour_field = get_field('colour');
$colour = ($colour_field === 'Gold' || $colour_field === null) ? 'quote_image_bg__gold' : 'quote_image_bg__red';
?>
<section class="quote_image_bg <?=$colour?>">
    <div class="container px-0">
        <?=wp_get_attachment_image(get_field('background'),'full',false,['class' => 'quote_image_bg__image'])?>
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="quote_image_bg__quote-container">
                    <div class="h2 quote_image_bg__quote">
                        <?=get_field('quote')?>
                    </div>
                    <div class="quote_image_bg__attribution">
                        <?=get_field('attribution')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>