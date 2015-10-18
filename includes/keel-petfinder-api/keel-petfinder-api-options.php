<?php

	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	function keel_petfinder_api_settings_field_developer_key() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<input type="text" name="keel_petfinder_api_theme_options[developer_key]" class="large-text" id="developer_key" value="<?php echo esc_attr( $options['developer_key'] ); ?>" />
		<label class="description" for="developer_key"><?php _e( '<a href="https://www.petfinder.com/developers/api-docs">Get your developer key</a> to begin using the Petfinder API', 'keel_petfinder_api' ); ?></label>
		<?php
	}

	function keel_petfinder_api_settings_field_shelter_id() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<input type="text" name="keel_petfinder_api_theme_options[shelter_id]" id="shelter_id" value="<?php echo esc_attr( $options['shelter_id'] ); ?>" />
		<label class="description" for="shelter_id"><?php _e( 'The Petfinder ID of the shelter to fetch data for', 'keel_petfinder_api' ); ?></label>
		<?php
	}

	function keel_petfinder_api_settings_field_count() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<input type="number" min="0" name="keel_petfinder_api_theme_options[count]" id="count" value="<?php echo esc_attr( $options['count'] ); ?>" />
		<label class="description" for="count"><?php _e( 'Number of pet entries to retrieve. Should be greater than or equal to the  number of pets you have listed in Petfinder.', 'keel_petfinder_api' ); ?></label>
		<?php
	}

	function keel_petfinder_api_settings_field_slug() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<input name="keel_petfinder_api_theme_options[slug]" id="slug" value="<?php echo esc_attr( $options['slug'] ); ?>" />
		<label class="description" for="slug">
			<?php _e( 'The URL path for your Petfinder listings (ex. if you put <code>pets</code>, your animals would be displayed at <code>yourwebsite.com/pets</code>)', 'keel_petfinder_api' ); ?> <strong><?php _e( 'Note:', 'keel_petfinder_api' ); ?></strong> <em><?php _e( 'It this doesn\'t work, try saving your options again. It\'s absurd, but it works.', 'keel_petfinder_api' ); ?></em>
		</label>
		<?php
	}

	function keel_petfinder_api_settings_field_page_title() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<input name="keel_petfinder_api_theme_options[page_title]" id="slug" value="<?php echo esc_attr( $options['page_title'] ); ?>" />
		<label class="description" for="page_title">
			<?php _e( 'Title to display on the page where all of your available pets are listed', 'keel_petfinder_api' ); ?>
		</label>
		<?php
	}

	function keel_petfinder_api_settings_field_page_content() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<?php wp_editor(
			stripslashes( $options['page_content'] ),
			'page_content',
			array(
				'wpautop' => false,
				'textarea_name' => 'keel_petfinder_api_theme_options[page_content]',
				'textarea_rows' => 4,
			)
		); ?>
<!-- 		<textarea class="large-text" type="text" name="keel_petfinder_api_theme_options[page_content]" id="page_content" cols="50" rows="10" /><?php echo esc_textarea( $options['page_content'] ); ?></textarea> -->
		<label class="description" for="page_content"><?php _e( 'Content to display at the top of the page where all of your available pets are listed', 'keel_petfinder_api' ); ?></label>
		<?php
	}

	function keel_petfinder_api_settings_field_adoption_form() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<div>
			<input name="keel_petfinder_api_theme_options[adoption_form_url]" id="adoption_form_url" value="<?php echo esc_attr( $options['adoption_form_url'] ); ?>" />
			<label class="description" for="adoption_form_url">
				<?php _e( 'URL of your adoption form. If entered, will display a link to the form on individual pet profiles.', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<div>
			<input name="keel_petfinder_api_theme_options[adoption_form_text]" id="adoption_form_text" value="<?php echo esc_attr( $options['adoption_form_text'] ); ?>" />
			<label class="description" for="adoption_form_text">
				<?php _e( 'Text for the adoption form link, if URL is set.', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<?php
	}

	function keel_petfinder_api_settings_field_filters() {
		$options = keel_petfinder_api_get_theme_options();
		?>
		<p class="description"><em>Select which options to display.</em></p>
		<div>
			<label>
				<input type="checkbox" name="keel_petfinder_api_theme_options[filters_animal]" id="filters_animal" <?php checked( 'on', $options['filters_animal'] ); ?> />
				<?php _e( 'Animal', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<div>
			<label>
				<input type="checkbox" name="keel_petfinder_api_theme_options[filters_breed]" id="filters_breed" <?php checked( 'on', $options['filters_breed'] ); ?> />
				<?php _e( 'Breed', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<div>
			<label>
				<input type="checkbox" name="keel_petfinder_api_theme_options[filters_age]" id="filters_age" <?php checked( 'on', $options['filters_age'] ); ?> />
				<?php _e( 'Age', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<div>
			<label>
				<input type="checkbox" name="keel_petfinder_api_theme_options[filters_size]" id="filters_" <?php checked( 'on', $options['filters_size'] ); ?> />
				<?php _e( 'Size', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<div>
			<label>
				<input type="checkbox" name="keel_petfinder_api_theme_options[filters_gender]" id="filters_gender" <?php checked( 'on', $options['filters_gender'] ); ?> />
				<?php _e( 'Gender', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<div>
			<label>
				<input type="checkbox" name="keel_petfinder_api_theme_options[filters_other]" id="filters_other" <?php checked( 'on', $options['filters_other'] ); ?> />
				<?php _e( 'Other Options', 'keel_petfinder_api' ); ?>
			</label>
		</div>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under keel_petfinder_api_get_theme_options(), and an if statement under keel_petfinder_api_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_petfinder_api_get_theme_options() {
		$saved = (array) get_option( 'keel_petfinder_api_theme_options' );
		$defaults = array(
			'developer_key' => '',
			'shelter_id' => '',
			'count' => '10',
			'slug' => 'pets',
			'page_title' => 'Our Pets',
			'page_content' => '',
			'adoption_form_url' => '',
			'adoption_form_text' => 'Fill out an adoption form',
			'filters_animal' => 'on',
			'filters_breed' => 'on',
			'filters_age' => 'on',
			'filters_size' => 'on',
			'filters_gender' => 'on',
			'filters_other' => 'on',
		);

		$defaults = apply_filters( 'keel_petfinder_api_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function keel_petfinder_api_theme_options_validate( $input ) {
		$output = array();

		if ( isset( $input['developer_key'] ) && ! empty( $input['developer_key'] ) )
			$output['developer_key'] = wp_filter_nohtml_kses( $input['developer_key'] );

		if ( isset( $input['shelter_id'] ) && ! empty( $input['shelter_id'] ) )
			$output['shelter_id'] = wp_filter_nohtml_kses( $input['shelter_id'] );

		if ( isset( $input['count'] ) && ! empty( $input['count'] ) && $input['count'] > 1 )
			$output['count'] = wp_filter_nohtml_kses( $input['count'] );

		if ( isset( $input['slug'] ) && ! empty( $input['slug'] ) )
			$output['slug'] = wp_filter_nohtml_kses( $input['slug'] );

		if ( isset( $input['page_title'] ) && ! empty( $input['page_title'] ) )
			$output['page_title'] = wp_filter_nohtml_kses( $input['page_title'] );

		if ( isset( $input['page_content'] ) && ! empty( $input['page_content'] ) )
			$output['page_content'] = wp_filter_post_kses( $input['page_content'] );

		if ( isset( $input['adoption_form_url'] ) && ! empty( $input['adoption_form_url'] ) )
			$output['adoption_form_url'] = wp_filter_nohtml_kses( esc_url( $input['adoption_form_url'] ) );

		if ( isset( $input['adoption_form_text'] ) && ! empty( $input['adoption_form_text'] ) )
			$output['adoption_form_text'] = wp_filter_nohtml_kses( $input['adoption_form_text'] );

		if ( !isset( $input['filters_animal'] ) )
			$output['filters_animal'] = 'off';

		if ( !isset( $input['filters_breed'] ) )
			$output['filters_breed'] = 'off';

		if ( !isset( $input['filters_age'] ) )
			$output['filters_age'] = 'off';

		if ( !isset( $input['filters_size'] ) )
			$output['filters_size'] = 'off';

		if ( !isset( $input['filters_gender'] ) )
			$output['filters_gender'] = 'off';

		if ( !isset( $input['filters_other'] ) )
			$output['filters_other'] = 'off';

		return apply_filters( 'keel_petfinder_api_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_petfinder_api_theme_options_render_page() {
		$options = keel_petfinder_api_get_theme_options();

		?>
		<div class="wrap">
			<h2><?php _e( 'Petfinder API Options', 'keel_petfinder_api' ); ?></h2>
			<?php
				// If required API data is not yet provided
				if ( empty( $options['developer_key'] ) || empty( $options['shelter_id'] ) ) :
					if ( empty( $options['developer_key'] ) && empty( $options['shelter_id'] ) ) {
						$message = 'Please enter a <a href="https://www.petfinder.com/developers/api-docs">Petfinder developer key</a> and shelter ID to begin using the Petfinder API.';
					} elseif ( empty( $options['developer_key'] ) ) {
						$message = 'Please enter a <a href="https://www.petfinder.com/developers/api-docs">Petfinder developer key</a> to begin using the Petfinder API.';
					} else {
						$message = 'Please enter a shelter ID to begin using the Petfinder API.';
					}
			 ?>
				<div class="error">
					<p><?php _e( $message, 'keel_petfinder_api' ); ?></p>
				</div>
			<?php endif; ?>
			<?php
				// If API failed on it's last run
				$api_error = get_transient( 'keel_petfinder_api_get_pets_error' );
				if ( !empty( $api_error ) ) :
			 ?>
				<div class="error">
					<p><?php echo $api_error; ?></p>
				</div>
			<?php endif; ?>
			<?php settings_errors(); ?>

			<?php
				$timestamp = get_transient( 'keel_petfinder_api_get_pets_timestamp' );
				if ( !empty( $timestamp ) ) :
			?>
				<p><?php printf( __( 'Petfinder API data was last retrieved on %s at %s.', 'keel_petfinder_api' ), date( 'F j, Y', $timestamp ), date( 'g:i a', $timestamp ) ); ?></p>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_petfinder_api_options' );
					do_settings_sections( 'keel_petfinder_api_theme_options' );
					wp_nonce_field( 'keel_petfinder_api_update_options_nonce', 'keel_petfinder_api_update_options_process' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function keel_petfinder_api_theme_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'keel_petfinder_api_options', 'keel_petfinder_api_theme_options', 'keel_petfinder_api_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See keel_petfinder_api_theme_options_add_page().
		add_settings_section( 'general', 'General Settings',  '__return_false', 'keel_petfinder_api_theme_options' );
		add_settings_section( 'display', 'Display Settings',  '__return_false', 'keel_petfinder_api_theme_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'developer_key', __( 'Developer Key', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_developer_key', 'keel_petfinder_api_theme_options', 'general' );
		add_settings_field( 'shelter_id', __( 'Shelter ID', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_shelter_id', 'keel_petfinder_api_theme_options', 'general' );
		add_settings_field( 'count', __( 'Count', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_count', 'keel_petfinder_api_theme_options', 'general' );
		add_settings_field( 'slug', __( 'URL Path', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_slug', 'keel_petfinder_api_theme_options', 'display' );
		add_settings_field( 'page_title', __( 'Page Title', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_page_title', 'keel_petfinder_api_theme_options', 'display' );
		add_settings_field( 'page_content', __( 'Page Content', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_page_content', 'keel_petfinder_api_theme_options', 'display' );
		add_settings_field( 'adoption_form', __( 'Adoption Form Link', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_adoption_form', 'keel_petfinder_api_theme_options', 'display' );
		add_settings_field( 'filters', __( 'Filters', 'keel_petfinder_api' ), 'keel_petfinder_api_settings_field_filters', 'keel_petfinder_api_theme_options', 'display' );
	}
	add_action( 'admin_init', 'keel_petfinder_api_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_petfinder_api_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		// $theme_page = add_theme_page( __( 'Theme Options', 'keel_petfinder_api' ), __( 'Theme Options', 'keel_petfinder_api' ), 'edit_theme_options', 'keel_petfinder_api_theme_options', 'keel_petfinder_api_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'keel_petfinder_api' ), __( 'Theme Options', 'keel_petfinder_api' ), 'edit_theme_options', 'keel_petfinder_api_theme_options', 'keel_petfinder_api_theme_options_render_page' );
		$theme_page = add_submenu_page( 'edit.php?post_type=pets', __( 'Petfinder API Options', 'keel_petfinder_api' ), __( 'Options', 'keel_petfinder_api' ), 'edit_theme_options', 'keel_petfinder_api_theme_options', 'keel_petfinder_api_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'keel_petfinder_api_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function keel_petfinder_api_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_petfinder_api_options', 'keel_petfinder_api_option_page_capability' );
