<?php
/**
 * Template for the two-column text feature block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_block_region_applicable() ) {
    return;
}

global $footnotes;
$content = $footnotes->extract_footnote( 'footnote', apply_filters( 'the_content', get_field( 'left_content' ) ) );
?>
<section class="two_col_text_feature">
    <div class="container">
        <div class="row">
            <div class="col-md-7 p-5">
                <?= wp_kses_post( $content['content'] ); ?>
            </div>
            <div class="col-md-5 p-5">
                <?php
				$image = get_field( 'image' );
                if ( $image ) {
                    echo wp_get_attachment_image( $image, 'large', false, array( 'class' => 'two_col_text_feature__image mb-4' ) );
                }
				$quote = get_field( 'quote' );
				if ( $quote ) {
					?>
                <div class="quote">
                    <div class="quote__quote">
                        <?= wp_kses_post( $quote['quote'] ); ?>
                    </div>
                    <div class="quote__attribution">
                        <?= esc_html( $quote['attribution'] ); ?>
                    </div>
                </div>
                    <?php
				}
				?>
            </div>
        </div>
    </div>
</section>