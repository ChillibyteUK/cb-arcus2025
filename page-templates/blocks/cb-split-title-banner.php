<?php
/**
 * Template part for displaying the split title banner block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_block_region_applicable() ) {
    return;
}
?>
<div class="split_title_banner">
    <div class="container px-0">
        <div class="split_title_banner__left">
            <?= esc_html( get_field( 'left' ) ); ?>
        </div>
        <div class="split_title_banner__right">
            <?= esc_html( get_field( 'right' ) ); ?>
        </div>
    </div>
</div>