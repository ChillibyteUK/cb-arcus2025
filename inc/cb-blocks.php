<?php
function acf_blocks()
{
    if (function_exists('acf_register_block_type')) {

        acf_register_block_type(array(
            'name'                => 'cb_text_video', 
            'title'               => __('CB Text Video'), 
            'category'            => 'layout',
            'icon'                => 'cover-image', 
            'render_template'    => 'page-templates/blocks/cb_text_video.php', 
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_button', 
            'title'               => __('CB Button'), 
            'category'            => 'layout',
            'icon'                => 'cover-image', 
            'render_template'    => 'page-templates/blocks/cb_button.php', 
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_two_col_text_feature', 
            'title'               => __('CB Two Col Text Feature'), 
            'category'            => 'layout',
            'icon'                => 'cover-image', 
            'render_template'    => 'page-templates/blocks/cb_two_col_text_feature.php', 
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_plain_quote',
            'title'               => __('CB Plain Quote'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_plain_quote.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_two_col_people',
            'title'               => __('CB Two Col People'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_two_col_people.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_translucent_text',
            'title'               => __('CB Translucent Text'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_translucent_text.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_page_hero',
            'title'               => __('CB Page Hero'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_page_hero.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_team',
            'title'               => __('CB Team'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_team.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_latest_insights',
            'title'               => __('CB Latest Insights'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_latest_insights.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_text_text',
            'title'               => __('CB Text Text'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_text_text.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_text_image',
            'title'               => __('CB Text Image'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_text_image.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_quote_image_bg',
            'title'               => __('CB Quote Image BG'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_quote_image_bg.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_title_text',
            'title'               => __('CB Title Text'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_title_text.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_text_quote',
            'title'               => __('CB Text Quote'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_text_quote.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_split_title_banner',
            'title'               => __('CB Split Title Banner'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_split_title_banner.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));


        acf_register_block_type(array(
            'name'                => 'cb_video_hero',
            'title'               => __('CB Video Hero'),
            'category'            => 'layout',
            'icon'                => 'cover-image',
            'render_template'    => 'page-templates/blocks/cb_video_hero.php',
            'mode'                => 'edit',
            'supports'            => array('mode' => false, 'anchor' => true, 'className' => true),
        ));

    }
}
add_action('acf/init', 'acf_blocks');


// Gutenburg core modifications
add_filter('register_block_type_args', 'core_image_block_type_args', 10, 3);
function core_image_block_type_args($args, $name)
{

    if ($name == 'core/paragraph') {
        $args['render_callback'] = 'modify_core_add_container';
    }
    if ($name == 'core/heading') {
        $args['render_callback'] = 'modify_core_add_container';
    }
    if ($name == 'core/list') {
        $args['render_callback'] = 'modify_core_add_container';
    }

    return $args;
}

// Helper function to detect if footer.php is being rendered
function is_footer_rendering()
{
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    foreach ($backtrace as $trace) {
        if (isset($trace['file']) && basename($trace['file']) === 'footer.php') {
            return true;
        }
    }
    return false;
}

function modify_core_add_container($attributes, $content)
{
    if (is_footer_rendering()) {
        return $content;
    }

    ob_start();
    // $class = $block['className'];
    ?>
    <div class="container">
        <?= $content ?>
    </div>
<?php
        $content = ob_get_clean();
    return $content;
}
