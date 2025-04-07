<?php
/**
 * Template for displaying a quote with an image background.
 *
 * @package cb-arcus2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! is_block_region_applicable() ) {
    return;
}
$colour_field = get_field( 'colour' );
$colour       = ( 'Gold' === $colour_field || null === $colour_field ) ? 'quote_image_bg__gold' : 'quote_image_bg__red';
?>
<section class="quote_image_bg <?= esc_attr( $colour ); ?>">
    <div class="container px-0">
        <?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'class' => 'quote_image_bg__image' ) ); ?>
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="quote_image_bg__quote-container">
                    <div class="h2 quote_image_bg__quote">
                        <?= wp_kses_post( get_field( 'quote' ) ); ?>
                    </div>
                    <div class="quote_image_bg__attribution">
                        <?= esc_html( get_field( 'attribution' ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>