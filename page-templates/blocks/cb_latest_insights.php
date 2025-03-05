<section class="latest_insights">
    <div class="container py-5">
        <div class="latest_insights__inner p-5">
            <div class="latest_insights__title">
                <h2>Insights</h2>
            </div>
            <div class="row g-5">
                <?php
                $q = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                ));
                while ($q->have_posts()) {
                    $q->the_post();
                    ?>
                <div class="col-md-4">
                    <div class="latest_insights__card">
                        <?=get_the_post_thumbnail($q->ID,'large',['class' => 'latest_insights__image'])?>
                        <h3><?=get_the_title()?></h3>
                        <div class="latest_insights__intro">
                            <?=wp_trim_words(get_the_content(),30)?>
                        </div>
                    </div>
                </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>