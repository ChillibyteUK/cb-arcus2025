<?php
/**
 * Page Hero Block Template
 *
 * Displays the hero section with an image.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$position = get_field( 'position' ) ?? 'center';
$bg       = 'page_hero--' . $position;
?>
<div class="page_hero <?= esc_attr( $bg ); ?>">
    <?= wp_get_attachment_image( get_field( 'image' ), 'full' ); ?>
</div>
