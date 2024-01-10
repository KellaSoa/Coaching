<?php

/**
 * Registers the `type_course` taxonomy,
 * for use with 'course'.
 */
function type_course_init() {
	register_taxonomy( 'type-course', [ 'course' ], [
		'hierarchical'          => false,
		'public'                => true,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'query_var'             => true,
		'rewrite'               => true,
		'capabilities'          => [
			'manage_terms' => 'edit_posts',
			'edit_terms'   => 'edit_posts',
			'delete_terms' => 'edit_posts',
			'assign_terms' => 'edit_posts',
		],
		'labels'                => [
			'name'                       => __( 'Tipo corso', 'apiu-course' ),
			'singular_name'              => _x( 'Tipo corso', 'taxonomy general name', 'apiu-course' ),
			'search_items'               => __( 'Cerca Tipi corso', 'apiu-course' ),
			'popular_items'              => __( 'Popular Tipi corso', 'apiu-course' ),
			'all_items'                  => __( 'All Tipi corso', 'apiu-course' ),
			'parent_item'                => __( 'Parent Tipo corso', 'apiu-course' ),
			'parent_item_colon'          => __( 'Parent Tipo corso:', 'apiu-course' ),
			'edit_item'                  => __( 'Modifica Tipo corso', 'apiu-course' ),
			'update_item'                => __( 'Aggiorna Tipo corso', 'apiu-course' ),
			'view_item'                  => __( 'View Tipo corso', 'apiu-course' ),
			'add_new_item'               => __( 'Add New Tipo corso', 'apiu-course' ),
			'separate_items_with_commas' => __( 'Separate Tipi corso with commas', 'apiu-course' ),
			'add_or_remove_items'        => __( 'Add or remove Tipi corso', 'apiu-course' ),
			'choose_from_most_used'      => __( 'Choose from the most used Tipi corso', 'apiu-course' ),
			'not_found'                  => __( 'No Tipi corso found.', 'apiu-course' ),
			'no_terms'                   => __( 'No Tipi corso', 'apiu-course' ),
			'menu_name'                  => __( 'Tipo corso', 'apiu-course' ),
			'items_list_navigation'      => __( 'Tipi corso list navigation', 'apiu-course' ),
			'items_list'                 => __( 'Tipi corso list', 'apiu-course' ),
			'most_used'                  => _x( 'Most Used', 'type-course', 'apiu-course' ),
			'back_to_items'              => __( '&larr; Back to Tipi corso', 'apiu-course' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'type-course',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );

}

add_action( 'init', 'type_course_init' );

/**
 * Sets the post updated messages for the `type_course` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `type_course` taxonomy.
 */
function type_course_updated_messages( $messages ) {

	$messages['type-course'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Tipo corso added.', 'apiu-course' ),
		2 => __( 'Tipo corso deleted.', 'apiu-course' ),
		3 => __( 'Tipo corso updated.', 'apiu-course' ),
		4 => __( 'Tipo corso not added.', 'apiu-course' ),
		5 => __( 'Tipo corso not updated.', 'apiu-course' ),
		6 => __( 'Tipi corso deleted.', 'apiu-course' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'type_course_updated_messages' );
