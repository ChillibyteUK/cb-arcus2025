<?php
$mp4 = get_field('video_mp4') ?? null;
$webm = get_field('video_webm') ?? null;
?>
<div class="video_hero">
    <video autoplay loop muted playsinline>
        <source src="<?=$webm?>" type="video/webm">
        <source src="<?=$mp4?>" type="video/mp4">
        <?=wp_get_attachment_image(get_field('image'), 'full', false, ['alt' => 'Video not supported'])?>
        Your browser does not support the video tag.
    </video>
</div>
