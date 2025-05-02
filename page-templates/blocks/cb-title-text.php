<?php
/**
 * Template part for displaying the title and text block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_block_region_applicable() ) {
    return;
}

global $footnotes;
// Ensure the Footnotes class is instantiated if not already.
if ( ! isset( $footnotes ) || ! $footnotes instanceof Footnotes ) {
    require_once __DIR__ . '/../template-parts/class-footnotes.php';
    $footnotes = new Footnotes();
}

$content = $footnotes->extract_footnote( 'footnote', apply_filters( 'the_content', get_field( 'content' ) ) );
?>
<section class="title_text">
    <div class="container">
        <div class="title_text__parallax">
            <?=
			wp_get_attachment_image(
				get_field( 'tab_background' ),
				'full',
				false,
				array(
					'class'         => 'title_text__parallax_image',
					'data-parallax' => '',
            	)
			);
			?>
        </div>
        <div class="row">
            <div class="col-md-6 p-5">
                <h2><?= esc_html( get_field( 'title' ) ); ?></h2>
            </div>
            <div class="col-md-6 p-5">
                <div class="mb-5"><?= wp_kses_post( $content['content'] ); ?></div>
                <?php
				$l = get_field( 'cta' );
                if ( ! empty( $l ) ) {
                    ?>
                <a href="<?= esc_url( $l['url'] ); ?>" target="<?= esc_attr( $l['target'] ); ?>" class="button"><?= esc_html( $l['title'] ); ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
