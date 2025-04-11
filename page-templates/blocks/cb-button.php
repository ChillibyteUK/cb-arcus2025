<?php
/**
 * Button block template.
 *
 * This template renders a button block with either a file download link or a standard link.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$l     = get_field( 'link' );
$f     = get_field( 'file' );
$class = $block['className'] ?? '';

if ( ! empty( $f ) && is_array( $f ) && isset( $f['url'] ) ) {
    $button_title = get_field( 'file_button_title' ) ? get_field( 'file_button_title' ) : 'Download';
    ?>
    <a href="<?= esc_url( $f['url'] ); ?>" target="_blank" class="button <?= esc_attr( $class ); ?>"><?= esc_html( $button_title ); ?></a>
    <?php
} elseif ( ! empty( $l ) && is_array( $l ) && isset( $l['url'], $l['title'] ) ) {
    ?>
    <a href="<?= esc_url( $l['url'] ); ?>" target="<?= esc_attr( $l['target'] ?? '_self' ); ?>" class="button <?= esc_attr( $class ); ?>"><?= esc_html( $l['title'] ); ?></a>
    <?php
}
?>