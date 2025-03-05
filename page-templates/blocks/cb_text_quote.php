<section class="text_quote">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-8 col-xl-9 p-5">
                <h2><?=get_field('title')?></h2>
                <div class="text_quote__text mb-5"><?=get_field('content')?></div>
                <?php
                if (!empty(get_field('cta'))) {
                    $l = get_field('cta');
                    ?>
                <a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-5 col-lg-4 col-xl-3 d-flex flex-column">
                <div class="text_quote__quote-container">
                    <div class="h2 text_quote__quote">
                        <?=get_field('quote')?>
                    </div>
                    <div class="text_quote__attribution">
                        <?=get_field('attribution')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>