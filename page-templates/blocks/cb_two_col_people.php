<section class="two_col_people">
    <div class="container">
        <div class="row g-5">
            <?php
            foreach (get_field('people') as $p) {
                $office_terms = get_the_terms($p, 'office');

                if (!empty($office_terms) && !is_wp_error($office_terms)) {
                    $offices = wp_list_pluck($office_terms, 'name');
                }
                $offices = !empty($offices) ? '(' . implode(', ', $offices) . ')' : null;
                ?>
            <div class="col-md-6 person">
                <?=get_the_post_thumbnail($p,'large',['class' => 'person__image'])?>
                <div class="person__name"><?=get_the_title($p)?></div>
                <div class="person__role"><?=get_field('role',$p)?> <?=$offices?></div>
                <div class="person__bio"><?=get_the_content(null, false, $p)?></div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>