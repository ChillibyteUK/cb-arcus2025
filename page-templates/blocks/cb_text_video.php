<section class="text_video">
    <div class="container-xl bg-white p-5">
        <div class="row">
            <div class="col-md-6">
                <?=get_field('text')?>
            </div>
            <div class="col-md-6">
                <div class="ratio ratio-16x9 mb-3">
                    <iframe src="https://www.youtube.com/embed/<?= get_field('video_id') ?>?rel=0&modestbranding=1&autoplay=0&mute=0"
                        title="YouTube video"
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                </div>

                <?php
                if (get_field('video_caption') ?? null) {
                    ?>
                <div class="fs-300"><?=get_field('video_caption')?></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>