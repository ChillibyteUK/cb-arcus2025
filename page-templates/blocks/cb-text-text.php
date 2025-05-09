<?php
/**
 * Template part for displaying text-text blocks.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

global $footnotes;
// Ensure the Footnotes class is instantiated if not already.
if ( ! isset( $footnotes ) || ! $footnotes instanceof Footnotes ) {
    require_once __DIR__ . '/../template-parts/class-footnotes.php';
    $footnotes = new Footnotes();
}

if ( ! is_block_region_applicable() ) {
    return;
}

$has_bg = get_field( 'has_background' );
if ( ! empty( $has_bg ) && is_array( $has_bg ) ) {
    $bg = 'text_text__background';
} else {
    $bg = '';
}

$content_left  = $footnotes->extract_footnote( 'footnote', apply_filters( 'the_content', get_field( 'content_left' ) ) );
$content_right = $footnotes->extract_footnote( 'footnote', apply_filters( 'the_content', get_field( 'content_right' ) ) );
?>
<section class="text_text">
    <div class="container <?= esc_attr( $bg ); ?>">
        <div class="text_text__parallax">
            <?=
			wp_get_attachment_image(
				get_field( 'image' ),
				'full',
				false,
				array(
                	'class'         => 'text_text__parallax_image',
                	'data-parallax' => '',
            	)
			);
			?>
        </div>
        <div class="row">
            <div class="col-md-6 p-5 text_text__left">
                <?php
				$title_left = get_field( 'title_left' );
                if ( $title_left ) {
                    echo '<h2>' . esc_html( $title_left ) . '</h2>';
                }
				?>
                <div class="mb-5"><?= wp_kses_post( $content_left['content'] ); ?></div>
                <?php
				$link_left = get_field( 'link_left' );
				if ( ! empty( $link_left ) ) {
					?>
                <a href="<?= esc_url( $link_left['url'] ); ?>" target="<?= esc_attr( $link_left['target'] ); ?>" class="button"><?= esc_html( $link_left['title'] ); ?></a>
                    <?php
				}
				?>
            </div>
            <div class="col-md-6 p-5 text_text__right">
                <?php
				$title_right = get_field( 'title_right' );
				if ( $title_right ) {
					echo '<h2>' . esc_html( $title_right ) . '</h2>';
				}
				?>
                <div class="mb-5"><?= wp_kses_post( $content_right['content'] ); ?></div>
                <?php
				$link_right = get_field( 'link_right' );
				if ( ! empty( $link_right ) ) {
					?>
                <a href="<?= esc_url( $link_right['url'] ); ?>" target="<?= esc_attr( $link_right['target'] ); ?>" class="button"><?= esc_html( $link_right['title'] ); ?></a>
                    <?php
				}
				?>
            </div>
        </div>
    </div>
</section>