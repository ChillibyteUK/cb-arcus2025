<?php
/**
 * Template for displaying the latest insights block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="latest_insights">
    <div class="container pt-2 pb-5 px-0">
        <div class="latest_insights__inner p-5 mb-5">
            <div class="latest_insights__title">
                <h2>Insights</h2>
            </div>
            <div class="row g-5">
                <?php
                $q = new WP_Query(
					array(
                    	'post_type'      => 'post',
                    	'posts_per_page' => 3,
                	)
				);
                while ( $q->have_posts() ) {
                    $q->the_post();
                    ?>
                <div class="col-md-4">
                    <a class="latest_insights__card" href="<?= esc_url( get_the_permalink() ); ?>">
                        <?= get_the_post_thumbnail( $q->ID, 'large', array( 'class' => 'latest_insights__image' ) ); ?>
                        <h3 class="latest_insights__post-title"><?= esc_html( get_the_title() ); ?></h3>
                        <div class="latest_insights__intro">
                            <?php
							$excerpt = get_field( 'post_excerpt', get_the_ID() );
							if ( ! $excerpt ) {
								$excerpt = wp_trim_words( get_the_content(), 30 );
							}
							echo wp_kses_post( $excerpt );
							?>
                        </div>
                    </a>
                </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</section>