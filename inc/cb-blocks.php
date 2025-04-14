<?php
/**
 * File responsible for registering custom ACF blocks and modifying core block arguments.
 *
 * @package cb-arcus2025
 */

/**
 * Registers custom ACF blocks.
 *
 * This function checks if the ACF plugin is active and registers custom blocks
 * for use in the WordPress block editor. Each block has its own name, title,
 * category, icon, render template, and supports various features.
 */
function acf_blocks() {
    if ( function_exists( 'acf_register_block_type' ) ) {

		// INSERT NEW BLOCKS HERE.

        acf_register_block_type(
            array(
                'name'            => 'cb_stat_spinner',
                'title'           => __( 'CB Stat Spinner' ),
                'category'        => 'layout',
                'icon'            => 'cover-image',
                'render_template' => 'page-templates/blocks/cb-stat-spinner.php',
                'mode'            => 'edit',
                'supports'        => array(
                    'mode'      => false,
                    'anchor'    => true,
                    'className' => true,
                    'align'     => true,
                ),
            )
        );

        acf_register_block_type(
			array(
				'name'            => 'cb_strategies',
				'title'           => __( 'CB Strategies' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-strategies.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

		acf_register_block_type(
			array(
				'name'            => 'cb_contact_cards',
				'title'           => __( 'CB Contact Cards' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-contact-cards.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_text_video',
				'title'           => __( 'CB Text Video' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-text-video.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_button',
				'title'           => __( 'CB Button' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-button.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_two_col_text_feature',
				'title'           => __( 'CB Two Col Text Feature' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-two-col-text-feature.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_plain_quote',
				'title'           => __( 'CB Plain Quote' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-plain-quote.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_two_col_people',
				'title'           => __( 'CB Two Col People' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-two-col-people.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_translucent_text',
				'title'           => __( 'CB Translucent Text' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-translucent-text.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_page_hero',
				'title'           => __( 'CB Page Hero' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-page-hero.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_team',
				'title'           => __( 'CB Team' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-team.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_latest_insights',
				'title'           => __( 'CB Latest Insights' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-latest-insights.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_text_text',
				'title'           => __( 'CB Text Text' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-text-text.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_text_image',
				'title'           => __( 'CB Text Image' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-text-image.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_quote_image_bg',
				'title'           => __( 'CB Quote Image BG' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-quote-image-bg.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_title_text',
				'title'           => __( 'CB Title Text' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-title-text.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_text_quote',
				'title'           => __( 'CB Text Quote' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-text-quote.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_split_title_banner',
				'title'           => __( 'CB Split Title Banner' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-split-title-banner.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

        acf_register_block_type(
			array(
				'name'            => 'cb_video_hero',
				'title'           => __( 'CB Video Hero' ),
				'category'        => 'layout',
				'icon'            => 'cover-image',
				'render_template' => 'page-templates/blocks/cb-video-hero.php',
				'mode'            => 'edit',
				'supports'        => array(
					'mode'      => false,
					'anchor'    => true,
					'className' => true,
				),
			)
		);

    }
}
add_action( 'acf/init', 'acf_blocks' );



/**
 * Modifies the arguments for specific core block types.
 *
 * @param array  $args The block type arguments.
 * @param string $name The block type name.
 * @return array Modified block type arguments.
 */
function core_block_type_args( $args, $name ) {

	if ( 'core/paragraph' === $name ) {
		$args['render_callback'] = 'modify_core_add_container';
	}
	if ( 'core/heading' === $name ) {
		$args['render_callback'] = 'modify_core_add_container';
	}
	if ( 'core/list' === $name ) {
		$args['render_callback'] = 'modify_core_add_container';
	}

    return $args;
}
add_filter( 'register_block_type_args', 'core_block_type_args', 10, 3 );

/**
 * Helper function to detect if footer.php is being rendered.
 *
 * @return bool True if footer.php is being rendered, false otherwise.
 */
function is_footer_rendering() {
    $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
    foreach ( $backtrace as $trace ) {
        if ( isset( $trace['file'] ) && basename( $trace['file'] ) === 'footer.php' ) {
            return true;
        }
    }
    return false;
}

/**
 * Adds a container div around the block content unless footer.php is being rendered.
 *
 * @param array  $attributes The block attributes.
 * @param string $content    The block content.
 * @return string The modified block content wrapped in a container div.
 */
function modify_core_add_container( $attributes, $content ) {
    if ( is_footer_rendering() ) {
        return $content;
    }

    ob_start();
    ?>
    <div class="container">
        <?= wp_kses_post( $content ); ?>
    </div>
	<?php
	$content = ob_get_clean();
    return $content;
}
