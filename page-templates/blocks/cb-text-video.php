<?php
/**
 * Template part for displaying a text and video block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="text_video">
    <div class="container-xl bg-white p-5">
        <div class="row">
            <div class="col-md-6">
                <?= wp_kses_post( get_field( 'text' ) ); ?>
            </div>
            <div class="col-md-6">
                <div class="ratio ratio-16x9 mb-3">
                <iframe src="<?= esc_url( 'https://player.vimeo.com/video/' . get_field( 'video_id' ) . '?title=0&byline=0&portrait=0' ); ?>"
                    title="Vimeo video"
                    allowfullscreen
                    allow="autoplay; fullscreen; picture-in-picture">
                </iframe>
                    <!-- <iframe src="<?= esc_url( 'https://www.youtube.com/embed/' . get_field( 'video_id' ) . '?rel=0&modestbranding=1&autoplay=0&mute=0' ); ?>"
                        title="YouTube video"
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe> -->
                </div>

                <?php
                if ( get_field( 'video_caption' ) ?? null ) {
                    ?>
                <div class="fs-300"><?= esc_html( get_field( 'video_caption' ) ); ?></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>