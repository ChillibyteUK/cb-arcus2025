<?php
/**
 * Template Name: Performance
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
?>
<main id="main">
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
