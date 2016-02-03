<?php

/**
 * Get Pets from Petfinder API
 * @link https://www.petfinder.com/developers/api-docs
 */


	// Load required files
	require_once( dirname( __FILE__) . '/keel-pet-listings-options.php' );
	require_once( dirname( __FILE__) . '/keel-pet-listings-petfinder.php' );



	// Add custom post type
	function keel_pet_listings_add_custom_post_type() {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['pets'] ) return;

		$options = keel_pet_listings_get_theme_options();
		$labels = array(
			'name'               => _x( 'Pets', 'post type general name', 'keel' ),
			'singular_name'      => _x( 'Pet', 'post type singular name', 'keel' ),
			'add_new'            => _x( 'Add New', 'keel-pets', 'keel' ),
			'add_new_item'       => __( 'Add New Pet', 'keel' ),
			'edit_item'          => __( 'Edit Pet', 'keel' ),
			'new_item'           => __( 'New Pet', 'keel' ),
			'all_items'          => __( 'All Pets', 'keel' ),
			'view_item'          => __( 'View Pet', 'keel' ),
			'search_items'       => __( 'Search Pets', 'keel' ),
			'not_found'          => __( 'No pets found', 'keel' ),
			'not_found_in_trash' => __( 'No pets found in the Trash', 'keel' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Pet Listings', 'keel' ),
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our pets and pet-specific data from Petfinder',
			'public'        => true,
			// 'menu_position' => 5,
			'menu_icon'     => 'dashicons-screenoptions',
			// 'supports'      => array(),
			'has_archive'   => true,
			'rewrite' => array(
				'slug' => $options['slug'],
			),
			'map_meta_cap'  => true,
			'capabilities' => array(
				'create_posts' => false,
				'edit_published_posts' => false,
				'delete_posts' => false,
				'delete_published_posts' => false,
			)
		);
		register_post_type( 'keel-pets', $args );
	}
	add_action( 'init', 'keel_pet_listings_add_custom_post_type' );



	/**
	 * Show all pets on pets archive page and update the sort order
	 */
	function keel_pet_listings_filter_pets_query( $query ) {
		if ( !isset( $query->query['post_type'] ) || $query->query['post_type'] !== 'keel-pets' ) return;
		$options = keel_pet_listings_get_theme_options();
		$query->set( 'posts_per_page', '-1' );
		$query->set( 'order', ( $options['oldest_first'] ? 'ASC' : 'DESC' ) );
	}
	add_action( 'pre_get_posts', 'keel_pet_listings_filter_pets_query' );



	/**
	 * Convert old post type to new one
	 */
	function keel_pet_listings_convert_post_type() {

		// Get existing pets
		$current_pets = get_posts(array(
			'post_type' => 'pets',
			'showposts' => -1,
		));

		// Update each pet
		foreach ($current_pets as $pet) {
			$post = array(
				'ID'        => $pet->ID,
				'post_type' => 'keel-pets', // Default 'post'
			);
			wp_update_post( $post );
		}

	}
	add_action( 'after_switch_theme', 'keel_pet_listings_convert_post_type' );