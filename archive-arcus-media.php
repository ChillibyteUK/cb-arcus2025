<?php
/**
 * Template Name: Arcus Media Archive
 *
 * This template displays the archive for the Arcus Media custom post type.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main">
    <div class="page_hero">
        <?= wp_get_attachment_image( get_field( 'media_hero', 'option' ), 'full' ); ?>
    </div>
    <section class="translucent_text--light">
        <div class="container p-5">
            <h1 class="insights-title mb-4">Media</h1>
            <div class="translucent_text__content"><?= wp_kses_post( get_field( 'media_intro', 'option' ) ); ?></div>
        </div>
    </section>

	<section class="media">
		<div class="container bg--white p-5">
			<?php
			if ( have_posts() ) {
				?>
				<div class="posts-list">
					<?php
					$row_count = 0; // Initialize a counter for rows.
					while ( have_posts() ) {
						the_post();
						++$row_count;
						$yt   = get_field( 'youtube_url' );
						$mp3  = get_field( 'audio' );
						$mov  = get_field( 'video_mov' );
						$mp4  = get_field( 'video_mp4' );
						$webm = get_field( 'video_webm' );
						$img  = get_field( 'featured_image' );

						?>
						<article id="post-<?= esc_attr( get_the_ID() ); ?>" <?php post_class(); ?>>
							<div class="row g-5">
								<div class="col-md-6 order-1 <?= 0 === $row_count % 2 ? 'order-lg-2' : 'order-lg-1'; ?>">
									<h2 class="h3"><?= esc_html( get_the_title() ); ?></h2>
									<div class="mb-2 has-gold-400-color"><?= esc_html( get_the_date( 'jS F, Y' ) ); ?></div>
									<div class="mb-4"><?= wp_kses_post( get_field( 'intro' ) ); ?></div>
									<?php
									if ( $mp3 ) {
										?>
									<strong>Listen</strong>
									<figure class="wp-block-audio"><audio src="<?= esc_url( $mp3 ); ?>" controls="controls" draggable="true"></audio></figure>
										<?php
									}
									?>
								</div>
								<div class="col-md-6 order-2 <?= 0 === $row_count % 2 ? 'order-lg-1' : 'order-lg-2'; ?>">
									<?php
									// Priority logic for displaying media.
									if ( $webm && $mp4 ) {
										?>
										<div class="ratio ratio-16x9">
											<video controls>
												<source src="<?= esc_url( $webm ); ?>" type="video/webm">
												<source src="<?= esc_url( $mp4 ); ?>" type="video/mp4">
												<?= esc_html__( 'Your browser does not support the video tag.', 'cb-arcus2025' ); ?>
											</video>
										</div>
										<?php
									} elseif ( $mp4 ) {
										?>
										<div class="ratio ratio-16x9">
											<video controls>
												<source src="<?= esc_url( $mp4 ); ?>" type="video/mp4">
												<?= esc_html__( 'Your browser does not support the video tag.', 'cb-arcus2025' ); ?>
											</video>
										</div>
										<?php
									} elseif ( $mov ) {
										?>
										<a href="<?= esc_url( $mov ); ?>" download>
											<?= esc_html__( 'Download Video', 'cb-arcus2025' ); ?>
										</a>
										<?php
									} elseif ( $yt ) {
										// Normalize YouTube URL to embed format.
										if ( preg_match( '/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtube\.com\/embed\/|youtu\.be\/)?([a-zA-Z0-9_-]{11})$/', $yt, $matches ) ) {
											$video_id  = $matches[4];
											$embed_url = 'https://www.youtube.com/embed/' . $video_id;
										} else {
											$embed_url = esc_url( $yt ); // Fallback if format is unexpected.
										}
										?>
										<div class="ratio ratio-16x9">
											<iframe src="<?= esc_url( $embed_url ); ?>" frameborder="0" allowfullscreen></iframe>
										</div>
										<?php
									} elseif ( $img ) {
										echo wp_get_attachment_image( $img, 'full' );
									}
									?>
								</div>
							</div>
						</article>
						<hr class="my-5" />
						<?php
					}
					?>
				</div>

				<div class="pagination">
					<?php the_posts_pagination(); ?>
				</div>
				<?php
			} else {
				?>
				<p><?php esc_html_e( 'No media items found.', 'cb-arcus2025' ); ?></p>
				<?php
			}
			?>
		</div>
	</section>
</main>
<?php
get_footer();