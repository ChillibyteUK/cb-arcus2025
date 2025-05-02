<?php
/**
 * Template for displaying a text and image block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_block_region_applicable() ) {
    return;
}

global $footnotes;
$content = $footnotes->extract_footnote( 'footnote', apply_filters( 'the_content', get_field( 'content' ) ) );
?>
<section class="text_image">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text_image__left p-5">
                <h2><?= esc_html( get_field( 'title' ) ); ?></h2>
                <div class="mb-5"><?= wp_kses_post( $content['content'] ); ?></div>
                <?php
				$l = get_field( 'link' );
                if ( ! empty( $l ) ) {
                    ?>
                <a href="<?= esc_url( $l['url'] ); ?>" target="<?= esc_attr( $l['target'] ); ?>" class="button--wo"><?= esc_html( $l['title'] ); ?></a>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-6 text_image__right">
                <?= wp_get_attachment_image( get_field( 'image' ), 'large', false, array( 'class' => 'text_image__image' ) ); ?>
            </div>
        </div>
    </div>
</section>