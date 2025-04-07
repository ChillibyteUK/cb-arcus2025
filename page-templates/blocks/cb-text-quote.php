<?php
/**
 * Template part for displaying a text quote block.
 *
 * @package cb-arcus2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$colour_field = get_field( 'colour' );
$colour       = ( 'Red' === $colour_field || null === $colour_field ) ? 'text_quote__red' : 'text_quote__gold';
?>
<section class="text_quote <?= esc_attr( $colour ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-8 col-xl-9 p-5">
                <h2><?= esc_html( get_field( 'title' ) ); ?></h2>
                <div class="text_quote__text mb-5"><?= wp_kses_post( get_field( 'content' ) ); ?></div>
                <?php
				$l = get_field( 'cta' );
                if ( ! empty( $l ) ) {
                    ?>
                <a href="<?= esc_url( $l['url'] ); ?>" target="<?= esc_attr( $l['target'] ); ?>" class="button"><?= esc_html( $l['title'] ); ?></a>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-5 col-lg-4 col-xl-3 d-flex flex-column">
                <div class="text_quote__quote-container">
                    <div class="h2 text_quote__quote">
                        <?= wp_kses_post( get_field( 'quote' ) ); ?>
                    </div>
                    <div class="text_quote__attribution">
                        <?= esc_html( get_field( 'attribution' ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>