<?php
if (!is_block_region_applicable()) {
    return;
}
?>
<div class="split_title_banner">
    <div class="container px-0">
        <div class="split_title_banner__left">
            <?=get_field('left')?>
        </div>
        <div class="split_title_banner__right">
            <?=get_field('right')?>
        </div>
    </div>
</div>