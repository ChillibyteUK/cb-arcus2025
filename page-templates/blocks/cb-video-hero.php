<?php
/**
 * CB Video Hero Template
 *
 * This template displays a video hero section with optional MP4 and WebM videos
 * and a fallback image.
 *
 * @package CB_Arcus2025
 */

defined( 'ABSPATH' ) || exit;

$mp4   = get_field( 'video_mp4' ) ? get_field( 'video_mp4' ) : null;
$webm  = get_field( 'video_webm' ) ? get_field( 'video_webm' ) : null;
$image = wp_get_attachment_image( get_field( 'fallback' ), 'full', false, array( 'alt' => 'Video not supported' ) );
?>
<div class="video_hero">
    <?php
	if ( $webm || $mp4 ) {
		?>
        <video autoplay loop muted playsinline>
            <?php
			if ( $webm ) {
				?>
                <source src="<?= esc_url( $webm ); ?>" type="video/webm">
            	<?php
			}
			if ( $mp4 ) {
				?>
                <source src="<?= esc_url( $mp4 ); ?>" type="video/mp4">
            	<?php
			}
			echo wp_kses_post( $image );
			?>
            Your browser does not support the video tag.
        </video>
    	<?php
	} else {
		echo wp_kses_post( $image );
	}
	?>
</div>
