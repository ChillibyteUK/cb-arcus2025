<?php
$mp4 = get_field('video_mp4') ? get_field('video_mp4') : null;
$webm = get_field('video_webm') ? get_field('video_webm') : null;
$image = wp_get_attachment_image(get_field('fallback'), 'full', false, ['alt' => 'Video not supported']);
?>
<div class="video_hero">
    <?php if ($webm || $mp4) { ?>
        <video autoplay loop muted playsinline>
            <?php if ($webm) { ?>
                <source src="<?= esc_url($webm); ?>" type="video/webm">
            <?php } ?>
            <?php if ($mp4) { ?>
                <source src="<?= esc_url($mp4); ?>" type="video/mp4">
            <?php } ?>
            <?= $image; ?>
            Your browser does not support the video tag.
        </video>
    <?php } else { ?>
        <?= $image; ?>
    <?php } ?>
</div>
