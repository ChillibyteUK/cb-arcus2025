<?php
/**
 * Custom taxonomies for the CB Arcus 2025 theme.
 *
 * This file defines and registers custom taxonomies such as 'Teams' and 'Offices'.
 *
 * @package cb-arcus2025
 */

/**
 * Register custom taxonomies for the theme.
 *
 * This function registers two custom taxonomies: 'Teams' and 'Offices'.
 * Both taxonomies are hierarchical and associated with the 'people' post type.
 * The taxonomies are set to be publicly queryable, have a UI in the admin,
 * and support REST API.
 *
 * @return void
 */
function cb_register_taxes() {
    $args = array(
        'labels'             => array(
            'name'          => 'Teams',
            'singular_name' => 'Team',
		),
        'public'             => true,
        'publicly_queryable' => false,
        'hierarchical'       => true,
        'show_ui'            => true,
        'rewrite'            => false,
        'show_admin_column'  => true,
        'show_in_rest'       => true,
        'show_tagcloud'      => false,
        'show_in_quick_edit' => true,
	);
    register_taxonomy( 'team', array( 'people' ), $args );

	$args = array(
		'labels'             => array(
			'name'          => 'Offices',
			'singular_name' => 'Office',
		),
		'public'             => true,
		'publicly_queryable' => false,
		'hierarchical'       => true,
		'show_ui'            => true,
		'rewrite'            => false,
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => false,
		'show_in_quick_edit' => true,
	);
    register_taxonomy( 'office', array( 'people' ), $args );
}
add_action( 'init', 'cb_register_taxes' );
