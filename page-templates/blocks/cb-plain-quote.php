<?php
/**
 * Template for displaying a plain quote block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$colour_field = get_field( 'colour' );
$colour       = ( 'Red' === $colour_field || null === $colour_field ) ? 'plain_quote__red' : 'plain_quote__gold';
?>
<section class="plain_quote <?= esc_attr( $colour ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-4 d-flex flex-column">
                <div class="plain_quote__quote-container">
                    <div class="h2 plain_quote__quote">
                        <?= esc_html( get_field( 'quote' ) ); ?>
                    </div>
                    <div class="plain_quote__attribution">
                        <?= esc_html( get_field( 'attribution' ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>