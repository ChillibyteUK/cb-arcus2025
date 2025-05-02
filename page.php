<?php
/**
 * Template Name: Page
 *
 * @package cb-arcus2025
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();

if ( check_page_permissions() === false ) {
    echo '<main id="main" class="pt-5 mt-5">';
    echo "<div class='container-xl'>INSUFFICIENT PERMISSIONS TO VIEW THIS CONTENT</div>";
    echo '</main>';
    get_footer();
    exit;
}

require_once __DIR__ . '/page-templates/template-parts/class-footnotes.php';

$footnotes = new Footnotes();

?>
<main id="main">
    <?php
    the_post();
    $content = $footnotes->extract_footnote( 'footnote', apply_filters( 'the_content', get_the_content() ) );
    echo $content['content'];
    // the_content();
	// phpcs:disable
    // $block_names = get_all_block_names_from_content(get_the_ID());
    // print_r($block_names);
	// phpcs:enable
    if ( $footnotes->has_footnotes( 'footnote' ) ) {
        ?>
        <div class="container has-grey-100-background-color p-5">
            <h2 class="h3">Footnotes</h2>
            <?php
            $footnotes->display_footnotes( 'footnote' );
            ?>
        </div>
        <?php
    }
    ?>
</main>
<?php
get_footer();
