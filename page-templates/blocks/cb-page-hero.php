<?php
/**
 * Page Hero Block Template
 *
 * Displays the hero section with an image.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="page_hero">
    <?= wp_get_attachment_image( get_field( 'image' ), 'full' ); ?>
</div>
