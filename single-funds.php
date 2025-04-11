<?php
/**
 * Template Name: Performance
 *
 * @package cb-arcus2025
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/page-templates/template-parts/class-footnotes.php';

$footnotes = new Footnotes();

get_header();

if ( check_page_permissions() === false ) {
    echo '<main id="main" class="pt-5 mt-5">';
    echo "<div class='container-xl'>INSUFFICIENT PERMISSIONS TO VIEW THIS CONTENT</div>";
    echo '</main>';
    get_footer();
    exit;
}
?>
<main id="main">
    <div class="page_hero">
        <?= get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
    </div>
    <section class="translucent_text">
        <div class="container p-5">
            <h1 class="mb-4"><?= esc_html( get_the_title() ); ?></h1>
            <div class="translucent_text__content fs-500"><?= wp_kses_post( get_field( 'excerpt' ) ); ?></div>
        </div>
    </section>
    <section class="jump_nav">
        <div class="container has-grey-100-background-color px-5 py-3">
            <ul class="jump_nav__list d-flex flex-column flex-lg-row">
                <li><a href="#objective">Objective</a></li>
                <li><a href="#commentary">Commentary</a></li>
                <li><a href="#performance">Performance</a></li>
                <li><a href="#positioning">Positioning</a></li>
                <li><a href="#key_facts">Key Facts</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </section>
    <section id="objective">
        <?php
        $investment_objective = get_field( 'investment_objective' );
        if ( $investment_objective ) {
            $objective_with_footnotes = $footnotes->extract_footnote( 'footnote', $investment_objective );

            echo '<div class="container bg--primary-400 text--white p-5">';
            echo '<h2>Investment Objective</h2>';
            echo '<div class="w-constrained--lg">' . wp_kses_post( $objective_with_footnotes['content'] ) . '</div>';
            echo '</div>';
        }
        ?>
    </section>
    <section id="commentary">
        <?php
        $commentary = get_field( 'commentary' );
        if ( $commentary ) {
            echo '<div class="container bg--white p-5">';
            echo '<h2>Commentary</h2>';
            echo '<div class="w-constrained--lg">' . wp_kses_post( $commentary ) . '</div>';
            echo '</div>';
        }
        ?>
    </section>
    <section id="performance">
        <div class="container bg--white p-5">
            <h2>Performance Data</h2>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>
            <!-- <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script> -->

            <?php
            get_template_part( 'page-templates/template-parts/performance-chart' );
            get_template_part( 'page-templates/template-parts/historical-performance' );
            ?>
    </section>
    <section id="positioning">
        <div class="container bg--white p-5">
            <h2>Positioning</h2>
            <?php
            get_template_part( 'page-templates/template-parts/top-10-holdings' );

            get_template_part( 'page-templates/template-parts/industry-under-over-weights' );

            ?>
            <div class="row g-5 pb-5">
                <div class="col-lg-6">
                    <?php
                    get_template_part( 'page-templates/template-parts/portfolio-characteristics' );
                    ?>
                </div>
                <div class="col-lg-6">
                    <?php
                    get_template_part( 'page-templates/template-parts/size-distribution-of-equity-positions' );
                    ?>
                </div>
            </div>
            <?php
            get_template_part( 'page-templates/template-parts/business-classification' );
            ?>
            <?php
            ?>
        </div>
    </section>
    <section id="key_facts">
        <div class="container has-primary-400-background-color text--white p-5">
            <h2>Key Facts</h2>
            <?php
            get_template_part( 'page-templates/template-parts/key-facts' );
            ?>
        </div>
    </section>
    <section id="footnotes">
        <div class="container bg--white p-5">
            <h2>Footnotes</h2>
            <?php $footnotes->display_footnotes( 'footnote' ); ?>
        </div>
    </section>
    <section id="share_class">
        <?php
        get_template_part( 'page-templates/template-parts/share-class' );
        ?>
    </section>
    <section id="risks_rewards">
        <div class="container bg--white p-5">
            <h2>Risks and Rewards</h2>
            <?php
            if ( have_rows( 'rr_links' ) ) {
                echo '<ul>';
                while ( have_rows( 'rr_links' ) ) {
                    the_row();
                    $rr_link = get_sub_field( 'link' );
                    ?>
                <li>
                    <a href="<?= esc_url( $rr_link['url'] ); ?>" target="<?= esc_attr( $rr_link['target'] ); ?>" rel="noopener noreferrer">
                            <?= esc_html( $rr_link['title'] ); ?>
                    </a>
                </li>
                    <?php
                }
                echo '</ul>';
            }
            ?>
        </div>
    </section>
    <section id="factsheet">
        <div class="container bg--white p-5">
            <h2>Factsheet</h2>
            <?php
            $factsheet = get_field( 'factsheet' );
            if ( $factsheet ) {
                $factsheet_url       = $factsheet['url'];
                $factsheet_title     = $factsheet['title'];
                $factsheet_thumbnail = $factsheet['thumbnail'] ?? ''; // Assuming thumbnail is part of the factsheet field.

                echo '<div class="card d-flex gap-4">';
                if ( $factsheet_thumbnail ) {
                    echo '<img src="' . esc_url( $factsheet_thumbnail ) . '" class="card-img-top" alt="' . esc_attr( $factsheet_title ) . '">';
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . esc_html( $factsheet_title ) . '</h5>';
                echo '<a href="' . esc_url( $factsheet_url ) . '" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Download Factsheet</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
    <section id="contact">
        <div class="container has-primary-400-background-color text--white p-5">
            <h2>Contact</h2>
            <?php
            if ( have_rows( 'contact' ) ) {
                while ( have_rows( 'contact' ) ) {
                    the_row();
                    ?>
            <div class="d-flex gap-4">
                <div class="contact-image-wrapper">
                    <?php
                    if ( get_sub_field( 'image' ) ) {
                        echo wp_get_attachment_image( get_sub_field( 'image' ), 'medium', false, array( 'class' => 'contact-image' ) );
                    }
                    ?>
                </div>
                <p>
                    <?= esc_html( get_sub_field( 'name' ) ); ?><br>
                    <?= esc_html( get_sub_field( 'role' ) ); ?><br>
                    <a href="mailto:<?= esc_attr( get_sub_field( 'email' ) ); ?>">E: <?= esc_html( get_sub_field( 'email' ) ); ?></a><br>
                    <a class="button" href="mailto:<?= esc_attr( get_sub_field( 'email' ) ); ?>">Contact</a>
                </p>
            </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
                <?php
            }
            ?>
        </div>
    </section>
    <section id="contact">
        <div class="container bg--white p-5">
            <h2>Disclaimer</h2>
            <?php
            echo wp_kses_post( get_field( 'disclaimer' ) );
            ?>
        </div>
    </section>
    <?php


    the_post();
    the_content();
	// phpcs:disable
    // $block_names = get_all_block_names_from_content(get_the_ID());
    // print_r($block_names);
	// phpcs:enable
    ?>
</main>
<?php
get_footer();
