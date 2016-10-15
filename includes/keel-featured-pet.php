<?php

	function keel_featured_pet_settings_field_filters() {
		$options = keel_featured_pet_get_selections();
		$pet_names = keel_retrieve_pet_names();
		?>
		<p class="description"><em>Select a pet to feature.</em></p>
		<div>
				<select name="keel_featured_pet_selections[featured_pet_id]">
				<?php foreach( $pet_names as $info_tag ) {
    						echo '<option value="'.$info_tag[0].'" ';
    						selected( $options['featured_pet_id'], $info_tag[0] );
    						echo '>'.$info_tag[1].'</option>';
							}
				?>
				</select>
		</div>
		<?php
	}
	
	function keel_featured_pet_backup_settings_field_filters() {
		$options = keel_featured_pet_get_selections();
		$pet_names = keel_retrieve_pet_names();
		?>
		<p class="description"><em>In case first featured pet isn't available.</em></p>
		<div>
				<select name="keel_featured_pet_selections[featured_pet_backup_id]">
				<?php foreach( $pet_names as $info_tag ) {
    						echo '<option value="'.$info_tag[0].'" ';
    						selected( $options['featured_pet_backup_id'], $info_tag[0] );
    						echo '>'.$info_tag[1].'</option>';
							}
				?>
				</select>
		</div>
		<?php
		
	}
	
	function keel_featured_pet_settings_names_details() {
		if(isset($_GET['settings-updated']) && $_GET['settings-updated']=='true'){
		$options = keel_featured_pet_get_selections();
		$args = array(
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post_type' => 'keel-pets'
		);
		
		$pets = get_posts($args);
		foreach ( $pets as $pet ) :
			$details = get_post_meta( $pet->ID, 'keel_pet_listings_pet_details', true );
			if ($details['id'] == $options['featured_pet_id']):
				$options['featured_pet_details'] = $details;
				$options['featured_pet_name'] = $pet->post_title;
				$options['featured_pet_post_id'] = $pet->ID;
				continue;
			elseif ($details['id'] == $options['featured_pet_backup_id']):
				$options['featured_pet_backup_details'] = $details;
				$options['featured_pet_backup_name'] = $pet->post_title;
				$options['featured_pet_backup_post_id'] = $pet->ID;
				continue;
			endif;
		endforeach;
		echo '<input type="hidden" name="keel_featured_pet_selections[featured_pet_name]" value="' . $options['featured_pet_name'] . '" />';
		echo '<input type="hidden" name="keel_featured_pet_selections[featured_pet_backup_name]" value="' . $options['featured_pet_backup_name'] . '" />';
		echo '<input type="hidden" name="keel_featured_pet_selections[featured_pet_post_id]" value="' . $options['featured_pet_post_id'] . '" />';
		echo '<input type="hidden" name="keel_featured_pet_selections[featured_pet_backup_post_id]" value="' . $options['featured_pet_backup_post_id'] . '" />';
		echo '<input type="hidden" name="keel_featured_pet_selections[featured_pet_details]" value="nothing' . serialize($options['featured_pet_details']) . '" />';
		echo '<input type="hidden" name="keel_featured_pet_selections[featured_pet_backup_details]" value="nothing' . serialize($options['featured_pet_backup_details']) . '" />';
    //wp_cache_delete('keel_featured_pet_selections');
    update_option( 'keel_featured_pet_selections', $options, True );		}
	}
	/**
	 * Return list of names (the post Titles) for each published pet
	 */
	function keel_retrieve_pet_names() {
		$args = array(
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post_type' => 'keel-pets'
		);
		$features = get_posts($args);
		foreach ( $features as $feature ) :
			$details = get_post_meta( $feature->ID, 'keel_pet_listings_pet_details', true );
			$posts[] = array($details['id'], $feature->post_title);
		endforeach;
		return $posts;
	}
	
	/**
	 * Featured Pet Defaults & Sanitization
	 * Each option field requires a default value under keel_featured_pet_get_theme_options(), and an if statement under keel_featured_pet_selections_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_featured_pet_get_selections() {
		$saved = (array) get_option( 'keel_featured_pet_selections' );

		$defaults = array(
			'featured_pet_id' => '',
			'featured_pet_backup_id' => '',
			'featured_pet_name' => '',
			'featured_pet_backup_name' => '',
			'featured_pet_post_id' => '',
			'featured_pet_backup_post_id' => '',
			'featured_pet_details' => array(),
			'featured_pet_backup_details' => array(),
		);

		$defaults = apply_filters( 'keel_featured_pet_get_selections', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated featured pet selections - necessary as from select and hidden fields?
	function keel_featured_pet_validate( $input ) {
		$output = array();

		if ( isset( $input['featured_pet_id'] ) && ! empty( $input['featured_pet_id'] ) )
			$output['featured_pet_id'] = wp_filter_nohtml_kses( $input['featured_pet_id'] );

		if ( isset( $input['featured_pet_backup_id'] ) && ! empty( $input['featured_pet_backup_id'] ) )
			$output['featured_pet_backup_id'] = wp_filter_nohtml_kses( $input['featured_pet_backup_id'] );
			
			
		if ( isset( $input['featured_pet_name'] ) && ! empty( $input['featured_pet_name'] ) )
			$output['featured_pet_name'] = wp_filter_nohtml_kses( $input['featured_pet_name'] );

		if ( isset( $input['featured_pet_backup_name'] ) && ! empty( $input['featured_pet_backup_name'] ) )
			$output['featured_pet_backup_name'] = wp_filter_nohtml_kses( $input['featured_pet_backup_name'] );
			
		// Validate these?
		if ( isset( $input['featured_pet_post_id'] ) && ! empty( $input['featured_pet_post_id'] ) )
			$output['featured_pet_post_id'] = $input['featured_pet_post_id'];
			
		if ( isset( $input['featured_pet_backup_post_id'] ) && ! empty( $input['featured_pet_backup_post_id'] ) )
			$output['featured_pet_backup_post_id'] = $input['featured_pet_backup_post_id'];

		// TODO Validate pet details arrays
			
		if ( isset( $input['featured_pet_details'] ) && ! empty( $input['featured_pet_details'] ) )
			$output['featured_pet_details'] =  $input['featured_pet_details'] ;
			
		if ( isset( $input['featured_pet_backup_details'] ) && ! empty( $input['featured_pet_backup_details'] ) )
			$output['featured_pet_backup_details'] = $input['featured_pet_backup_details'];

		return apply_filters( 'keel_featured_pet_validate', $output, $input );
	}

	/**
	 * Featured Pet Page
	 * Each option field requires its own add_settings_field function.
	 */

	// Create featured pet menu
	// The content that's rendered on the menu page.
	function keel_featured_pet_render_page() {
		$options = keel_featured_pet_get_selections();

		?>
		<div class="wrap">	
								
			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_featured_pet_selections' );
					do_settings_sections( 'keel_featured_pet_selections' );
					wp_nonce_field( 'keel_featured_pet_selections_update_options_nonce', 'keel_featured_pet_selections_update_options_process' );
					submit_button();
				?>
			</form>
			 
			<h4><?php _e( 'If no featured pet is found, oldest pet will be displayed', 'keel' ); ?></h4>

		</div>
		<?php
	}


	// Register the featured pet page and its fields
	function keel_featured_pet_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'keel_featured_pet_selections', 'keel_featured_pet_selections', 'keel_featured_pet_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See keel_pet_listings_theme_options_add_page().
		add_settings_section( 'featured', __( 'Select Featured Pet and display by shortcode [featured-pet]', 'keel' ),  '__return_false', 'keel_featured_pet_selections' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'keel_featured_pet', __( 'Featured Pet', 'keel' ), 'keel_featured_pet_settings_field_filters', 'keel_featured_pet_selections', 'featured' );
		add_settings_field( 'keel_featured_pet_backup', __( 'Backup Featured Pet', 'keel' ), 'keel_featured_pet_backup_settings_field_filters', 'keel_featured_pet_selections', 'featured' );
		add_settings_field( 'keel_featured_pet_settings_names_details', __( 'Featured Pet Hidden', 'keel' ), 'keel_featured_pet_settings_names_details', 'keel_featured_pet_selections', 'featured' );
	}
	add_action( 'admin_init', 'keel_featured_pet_init' );
	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_featured_pet_add_page() {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['pets'] ) return;

		$theme_page = add_submenu_page( 'edit.php?post_type=keel-pets', __( 'Featured Pet', 'keel' ), __( 'Featured Pet', 'keel' ), 'edit_theme_options', 'keel_featured_pet_selections', 'keel_featured_pet_render_page' );

	}
	$saved = (array) get_option( 'keel_pet_listings_theme_options' );	
	// Only add featured pet page if Basic API options have been configured.	
	if(isset($saved['developer_key']))
		add_action( 'admin_menu', 'keel_featured_pet_add_page' );

?>