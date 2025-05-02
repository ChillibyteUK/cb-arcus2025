<?php
/**
 * Template part for displaying translucent text block.
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
<section class="translucent_text">
    <div class="container p-5">
        <h1><?= esc_html( get_field( 'title' ) ); ?></h1>
        <div class="translucent_text__content"><?= wp_kses_post( $content['content'] ); ?></div>
    </div>
</section>