<?php
/**
 * Page Hero Block Template
 *
 * Displays the hero section with an image.
 *
 * @package cb-arcus2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="page_hero">
    <?= wp_get_attachment_image( get_field( 'image' ), 'full' ); ?>
</div>
