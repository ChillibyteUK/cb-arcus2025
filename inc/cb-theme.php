<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

require_once CB_THEME_DIR . '/inc/compliance-modal.php';
require_once CB_THEME_DIR . '/inc/cb-utility.php';
require_once CB_THEME_DIR . '/inc/cb-posttypes.php';
require_once CB_THEME_DIR . '/inc/cb-taxonomies.php';
require_once CB_THEME_DIR . '/inc/cb-blocks.php';

// Remove unwanted SVG filter injection WP
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');


// Remove comment-reply.min.js from footer
function remove_comment_reply_header_hook()
{
    wp_deregister_script('comment-reply');
}
add_action('init', 'remove_comment_reply_header_hook');

add_action('admin_menu', 'remove_comments_menu');
function remove_comments_menu()
{
    remove_menu_page('edit-comments.php');
}

add_filter('theme_page_templates', 'child_theme_remove_page_template');
function child_theme_remove_page_template($page_templates)
{
    // unset($page_templates['page-templates/blank.php'],$page_templates['page-templates/empty.php'], $page_templates['page-templates/fullwidthpage.php'], $page_templates['page-templates/left-sidebarpage.php'], $page_templates['page-templates/right-sidebarpage.php'], $page_templates['page-templates/both-sidebarspage.php']);
    unset($page_templates['page-templates/blank.php'], $page_templates['page-templates/empty.php'], $page_templates['page-templates/left-sidebarpage.php'], $page_templates['page-templates/right-sidebarpage.php'], $page_templates['page-templates/both-sidebarspage.php']);
    return $page_templates;
}
add_action('after_setup_theme', 'remove_understrap_post_formats', 11);
function remove_understrap_post_formats()
{
    remove_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        array(
            'page_title'     => 'Site-Wide Settings',
            'menu_title'    => 'Site-Wide Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
        )
    );
}

function widgets_init()
{

    register_nav_menus(array(
        'primary_nav' => __('Primary Nav', 'cb-arcus2025'),
        'footer_menu1' => __('Footer Nav', 'cb-arcus2025'),
    ));

    unregister_sidebar('hero');
    unregister_sidebar('herocanvas');
    unregister_sidebar('statichero');
    unregister_sidebar('left-sidebar');
    unregister_sidebar('right-sidebar');
    unregister_sidebar('footerfull');
    unregister_nav_menu('primary');

    add_theme_support('disable-custom-colors');
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name'  => 'Dark',
                'slug'  => 'dark',
                'color' => '#333333',
            ),
            array(
                'name'  => 'Light',
                'slug'  => 'light',
                'color' => '#f9f9f9',
            ),
        )
    );
}
add_action('widgets_init', 'widgets_init', 11);

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

//Custom Dashboard Widget
add_action('wp_dashboard_setup', 'register_cb_dashboard_widget');
function register_cb_dashboard_widget()
{
    wp_add_dashboard_widget(
        'cb_dashboard_widget',
        'Chillibyte',
        'cb_dashboard_widget_display'
    );
}

function cb_dashboard_widget_display()
{
?>
    <div style="display: flex; align-items: center; justify-content: space-around;">
        <img style="width: 50%;"
            src="<?= get_stylesheet_directory_uri() . '/img/cb-full.jpg'; ?>">
        <a class="button button-primary" target="_blank" rel="noopener nofollow noreferrer"
            href="mailto:hello@www.chillibyte.co.uk/">Contact</a>
    </div>
    <div>
        <p><strong>Thanks for choosing Chillibyte!</strong></p>
        <hr>
        <p>Got a problem with your site, or want to make some changes & need us to take a look for you?</p>
        <p>Use the link above to get in touch and we'll get back to you ASAP.</p>
    </div>
<?php
}


// add_filter('wpseo_breadcrumb_links', function( $links ) {
//     global $post;
//     if ( is_singular( 'post' ) ) {
//         $t = get_the_category($post->ID);
//         $breadcrumb[] = array(
//             'url' => '/guides/',
//             'text' => 'Guides',
//         );

//         array_splice( $links, 1, -2, $breadcrumb );
//     }
//     return $links;
// }
// );

// remove discussion metabox
// function cc_gutenberg_register_files()
// {
//     // script file
//     wp_register_script(
//         'cc-block-script',
//         get_stylesheet_directory_uri() . '/js/block-script.js', // adjust the path to the JS file
//         array('wp-blocks', 'wp-edit-post')
//     );
//     // register block editor script
//     register_block_type('cc/ma-block-files', array(
//         'editor_script' => 'cc-block-script'
//     ));
// }
// add_action('init', 'cc_gutenberg_register_files');

function understrap_all_excerpts_get_more_link($post_excerpt)
{
    if (is_admin() || ! get_the_ID()) {
        return $post_excerpt;
    }
    return $post_excerpt;
}

//* Remove Yoast SEO breadcrumbs from Revelanssi's search results
add_filter('the_content', 'wpdocs_remove_shortcode_from_index');
function wpdocs_remove_shortcode_from_index($content)
{
    if (is_search()) {
        $content = strip_shortcodes($content);
    }
    return $content;
}

// GF really is pants.
/**
 * Change submit from input to button
 *
 * Do not use example provided by Gravity Forms as it strips out the button attributes including onClick
 */
function wd_gf_update_submit_button($button_input, $form)
{
    //save attribute string to $button_match[1]
    preg_match("/<input([^\/>]*)(\s\/)*>/", $button_input, $button_match);

    //remove value attribute (since we aren't using an input)
    $button_atts = str_replace("value='" . $form['button']['text'] . "' ", "", $button_match[1]);

    // create the button element with the button text inside the button element instead of set as the value
    return '<button ' . $button_atts . '><span>' . $form['button']['text'] . '</span></button>';
}
add_filter('gform_submit_button', 'wd_gf_update_submit_button', 10, 2);


function cb_theme_enqueue()
{
    $the_theme = wp_get_theme();
    // wp_enqueue_style('lightbox-stylesheet', get_stylesheet_directory_uri() . '/css/lightbox.min.css', array(), $the_theme->get('Version'));
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox-plus-jquery.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_style('aos-style', "https://unpkg.com/aos@2.3.1/dist/aos.css", array());
    // wp_enqueue_script('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), null, true);
    wp_deregister_script('jquery');
    // wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.3.min.js', array(), null, true);
    // wp_enqueue_script('parallax', get_stylesheet_directory_uri() . '/js/parallax.min.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'cb_theme_enqueue');


// function add_custom_menu_item($items, $args)
// {
//     if ($args->theme_location == 'primary_nav') {
//         $new_item = '<li class="menu-item menu-item-type-post_tyep menu-item-object-page nav-item"><a href="' . esc_url(home_url('/search/')) . '" class="nav-link" title="Search"><span class="icon-search"></span></a></li>';
//         $items .= $new_item;
//     }

//     return $items;
// }
// add_filter('wp_nav_menu_items', 'add_custom_menu_item', 10, 2);


// check block region

function is_block_region_applicable()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $session_region = isset($_SESSION['region']) ? $_SESSION['region'] : null;

    if (!$session_region) {
        return false;
    }

    $block_regions = get_field('region');

    if (empty($block_regions)) {
        return false;
    }

    // Handle Term Objects or IDs
    $block_slugs = [];
    if (is_object($block_regions[0]) || is_array($block_regions[0])) {
        // Term Objects: Extract the slug
        foreach ($block_regions as $term) {
            $block_slugs[] = is_object($term) ? $term->slug : $term['slug'];
        }
    } elseif (is_numeric($block_regions[0])) {
        // Term IDs: Fetch term objects to get slugs
        foreach ($block_regions as $term_id) {
            $term = get_term($term_id);
            if ($term) {
                $block_slugs[] = $term->slug;
            }
        }
    }

    if (in_array('all-regions', $block_slugs, true)) {
        return true;
    }
    

    return in_array($session_region, $block_slugs, true);
}

function check_page_permissions()
{
    // Ensure the session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // retrieve region from the session
    $userRegion = $_SESSION['region'] ?? null;


    // Bail early if userRegion is not set
    if (!$userRegion) {
        return false;
    }

    // get list of allowed region IDs
    $areas = get_field('region', get_the_ID());

    // Bail early if no regions are assigned to the page/post
    if (empty($areas)) {
        return false;
    }

    // Normalise the region data to ensure we always work with slugs
    $allowedRegions = [];
    foreach ($areas as $area) {
        if (is_object($area) && isset($area->slug)) {
            // Term object with a slug property
            $allowedRegions[] = $area->slug;
        } elseif (is_array($area) && isset($area['slug'])) {
            // Associative array with a slug key
            $allowedRegions[] = $area['slug'];
        } elseif (is_numeric($area)) {
            // Numeric term ID; retrieve the term to get its slug
            $term = get_term($area);
            if ($term && !is_wp_error($term)) {
                $allowedRegions[] = $term->slug;
            }
        }
    }

    // Bail early if no valid regions were found
    if (empty($allowedRegions)) {
        return false;
    }

    // If 'All Regions' is one of the assigned regions, grant access
    if (in_array('all-regions', $allowedRegions, true)) {
        return true;
    }

    // Check if the user's region matches any of the allowed regions
    return in_array($userRegion, $allowedRegions, true);

    foreach ($areas as $area) {
        if ($area->slug === $userRegion) {
            return true;
        }
    }

    return false;
}

// Handle the AJAX request to clear the session
function clear_session_ajax_handler()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Clear the session variable
    unset($_SESSION['region']);

    // Respond with success
    wp_send_json_success('Session cleared.');
}
add_action('wp_ajax_clear_session', 'clear_session_ajax_handler');
add_action('wp_ajax_nopriv_clear_session', 'clear_session_ajax_handler');


// set default region if none is selected
add_filter('acf/load_value/name=region', function ($value, $post_id, $field) {
    // If no value is set, return the default term
    if (empty($value)) {
        $default_term = get_term_by('slug', 'all-regions', 'region'); // Change 'region' to your taxonomy name

        return $default_term ? [$default_term->term_id] : []; // Ensure it returns an array if using multi-select
    }

    return $value;
}, 10, 3);
