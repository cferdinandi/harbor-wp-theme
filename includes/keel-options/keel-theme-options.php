<?php

/**
 * Theme Options
 * @link https://gist.github.com/mfields/4678999
 */

	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	// Typefaces

	function keel_settings_field_style_typeface_choices() {
		$typefaces = array(
			'helvetica' => array(
				'value' => 'helvetica',
				'label' => '<span style="font-family: \'Helvetica Neue\', Arial, sans;"><strong>Helvetica Neue</strong> ' . __( '(Sample: Grumpy wizards make toxic brew for the evil Queen and Jack.</span>)', 'keel' ) . '</span>'
			),
			'open_sans' => array(
				'value' => 'open_sans',
				'label' => '<span style="font-family: \'Open Sans\', \'Helvetica Neue\', Arial, sans;"><strong>Open Sans</strong> ' . __( '(Sample: Grumpy wizards make toxic brew for the evil Queen and Jack.</span>)', 'keel' ) . '</span>'
			),
			'source_sans_pro' => array(
				'value' => 'source_sans_pro',
				'label' => '<span style="font-family: \'Source Sans Pro\', \'Helvetica Neue\', Arial, sans;"><strong>Source Sans Pro</strong> ' . __( '(Sample: Grumpy wizards make toxic brew for the evil Queen and Jack.</span>)', 'keel' ) . '</span>'
			),
			'georgia' => array(
				'value' => 'georgia',
				'label' => '<span style="font-family: Georgia, Times, serif;"><strong>Georgia</strong> ' . __( '(Sample: Grumpy wizards make toxic brew for the evil Queen and Jack.</span>)', 'keel' ) . '</span>'
			),
			'lora' => array(
				'value' => 'lora',
				'label' => '<span style="font-family: \'Lora\', Georgia, Times, serif;"><strong>Lora</strong> ' . __( '(Sample: Grumpy wizards make toxic brew for the evil Queen and Jack.</span>)', 'keel' ) . '</span>'
			),
			'droid_serif' => array(
				'value' => 'droid_serif',
				'label' => '<span style="font-family: \'Droid Serif\', Georgia, Times, serif;"><strong>Droid Serif</strong> ' . __( '(Sample: Grumpy wizards make toxic brew for the evil Queen and Jack.</span>)', 'keel' ) . '</span>'
			),
		);

		return $typefaces;
	}

	function keel_settings_field_style_typeface() {
		$options = keel_get_theme_options();

		foreach ( keel_settings_field_style_typeface_choices() as $button ) {
		?>
		<div class="layout">
			<label class="description">
				<input type="radio" name="keel_theme_options[typeface]" value="<?php echo esc_attr( $button['value'] ); ?>" <?php checked( $options['typeface'], $button['value'] ); ?> />
				<?php echo $button['label']; ?>
			</label>
		</div>
		<?php
		}
	}


	// Social Media Accounts

	function keel_settings_field_social_facebook() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[facebook]" id="facebook" value="<?php echo esc_attr( $options['facebook'] ); ?>" />
		<label class="description" for="facebook"><?php _e( 'Facebook page URL (ex. <code>http://facebook.com/PetRescueOrg</code>)', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_twitter() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[twitter]" id="twitter" value="<?php echo esc_attr( $options['twitter'] ); ?>" />
		<label class="description" for="twitter"><?php _e( 'Twitter username (ex. <code>PetRescueOrg</code>)', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_youtube() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[youtube]" id="youtube" value="<?php echo esc_attr( $options['youtube'] ); ?>" />
		<label class="description" for="youtube"><?php _e( 'YouTube page URL (ex. <code>http://www.youtube.com/channel/PetRescueOrg</code>)', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_google() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[google]" id="google" value="<?php echo esc_attr( $options['google'] ); ?>" />
		<label class="description" for="google"><?php _e( 'Google+ page URL (ex. <code>http://plus.google.com/PetRescueOrg</code>', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_instagram() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[instagram]" id="instagram" value="<?php echo esc_attr( $options['instagram'] ); ?>" />
		<label class="description" for="instagram"><?php _e( 'Instagram username (ex. <code>PetRescueOrg</code>)', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_pinterest() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[pinterest]" id="pinterest" value="<?php echo esc_attr( $options['pinterest'] ); ?>" />
		<label class="description" for="pinterest"><?php _e( 'Pinterest username (ex. <code>PetRescueOrg</code>)', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_flickr() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[flickr]" id="flickr" value="<?php echo esc_attr( $options['flickr'] ); ?>" />
		<label class="description" for="flickr"><?php _e( 'Flickr username (ex. <code>PetRescueOrg</code>', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_social_newsletter() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[newsletter]" id="newsletter" value="<?php echo esc_attr( $options['newsletter'] ); ?>" />
		<label class="description" for="newsletter"><?php _e( 'Newsletter sign-up form URL (ex. <code>http://mailchimp.com/12345</code>', 'keel' ); ?></label>
		<?php
	}

	// Footer

	function keel_settings_field_footer_content_1() {
		$options = keel_get_theme_options();
		?>
		<?php
			wp_editor(
				stripslashes( $options['footer1'] ),
				'footer1',
				array(
					'autop' => false,
					'textarea_name' => 'keel_theme_options[footer1]',
					'textarea_rows' => 8
				)
			);
		?>
		<label class="description" for="footer1"><?php _e( 'Content to show in the first footer area (ex. Copyright info, contact info, and so on)', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_footer_content_2() {
		$options = keel_get_theme_options();
		?>
		<?php
			wp_editor(
				stripslashes( $options['footer2'] ),
				'footer2',
				array(
					'autop' => false,
					'textarea_name' => 'keel_theme_options[footer2]',
					'textarea_rows' => 8
				)
			);
		?>
		<label class="description" for="footer1"><?php _e( 'Content to show in the second footer area (ex. Copyright info, contact info, and so on)', 'keel' ); ?></label>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under keel_get_theme_options(), and an if statement under keel_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_get_theme_options() {
		$saved = (array) get_option( 'keel_theme_options' );
		$defaults = array(

			// Fonts
			'typeface' => 'helvetica',

			// Social
			'facebook' => '',
			'twitter' => '',
			'youtube' => '',
			'google' => '',
			'instagram' => '',
			'pinterest' => '',
			'flickr' => '',
			'newsletter' => '',

			// Footer
			'footer1' => '',
			'footer2' => '',

		);

		$defaults = apply_filters( 'keel_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function keel_theme_options_validate( $input ) {
		$output = array();

		// Styles

		if ( isset( $input['typeface'] ) && array_key_exists( $input['typeface'], keel_settings_field_style_typeface_choices() ) )
			$output['typeface'] = $input['typeface'];

		// Social

		if ( isset( $input['facebook'] ) && ! empty( $input['facebook'] ) )
			$output['facebook'] = wp_filter_nohtml_kses( esc_url( $input['facebook'] ) );

		if ( isset( $input['twitter'] ) && ! empty( $input['twitter'] ) )
			$output['twitter'] = wp_filter_nohtml_kses( ltrim( $input['twitter'], '@' ) );

		if ( isset( $input['youtube'] ) && ! empty( $input['youtube'] ) )
			$output['youtube'] = wp_filter_nohtml_kses( esc_url( $input['youtube'] ) );

		if ( isset( $input['google'] ) && ! empty( $input['google'] ) )
			$output['google'] = wp_filter_nohtml_kses( esc_url( $input['google'] ) );

		if ( isset( $input['instagram'] ) && ! empty( $input['instagram'] ) )
			$output['instagram'] = wp_filter_nohtml_kses( $input['instagram'] );

		if ( isset( $input['pinterest'] ) && ! empty( $input['pinterest'] ) )
			$output['pinterest'] = wp_filter_nohtml_kses( $input['pinterest'] );

		if ( isset( $input['flickr'] ) && ! empty( $input['flickr'] ) )
			$output['flickr'] = wp_filter_nohtml_kses( $input['flickr'] );

		if ( isset( $input['newsletter'] ) && ! empty( $input['newsletter'] ) )
			$output['newsletter'] = wp_filter_nohtml_kses( $input['newsletter'] );

		// Footer

		if ( isset( $input['footer1'] ) && ! empty( $input['footer1'] ) )
			$output['footer1'] = wp_filter_post_kses( $input['footer1'] );

		if ( isset( $input['footer2'] ) && ! empty( $input['footer2'] ) )
			$output['footer2'] = wp_filter_post_kses( $input['footer2'] );

		return apply_filters( 'keel_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_theme_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Theme Options', 'keel' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_theme_options' );
					do_settings_sections( 'keel_theme_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function keel_theme_options_init() {

		// Developer Options
		$dev_options = keel_developer_options();

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'keel_theme_options', 'keel_theme_options', 'keel_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See keel_theme_options_add_page().
		if ( $dev_options['fonts'] ) {
			add_settings_section( 'fonts', 'Fonts',  '__return_false', 'keel_theme_options' );
		}
		if ( $dev_options['social'] ) {
			add_settings_section( 'social', 'Social Media Accounts',  '__return_false', 'keel_theme_options' );
		}
		if ( $dev_options['footer'] ) {
			add_settings_section( 'footer', 'Footer Content',  '__return_false', 'keel_theme_options' );
		}


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.

		// Fonts
		add_settings_field( 'typeface', __( 'Typeface', 'keel' ), 'keel_settings_field_style_typeface', 'keel_theme_options', 'fonts' );

		// Social
		add_settings_field( 'facebook', __( 'Facebook', 'keel' ), 'keel_settings_field_social_facebook', 'keel_theme_options', 'social' );
		add_settings_field( 'twitter', __( 'Twitter', 'keel' ), 'keel_settings_field_social_twitter', 'keel_theme_options', 'social' );
		add_settings_field( 'youtube', __( 'YouTube', 'keel' ), 'keel_settings_field_social_youtube', 'keel_theme_options', 'social' );
		add_settings_field( 'google', __( 'Google+', 'keel' ), 'keel_settings_field_social_google', 'keel_theme_options', 'social' );
		add_settings_field( 'instagram', __( 'Instagram', 'keel' ), 'keel_settings_field_social_instagram', 'keel_theme_options', 'social' );
		add_settings_field( 'pinterest', __( 'Pinterest', 'keel' ), 'keel_settings_field_social_pinterest', 'keel_theme_options', 'social' );
		add_settings_field( 'flickr', __( 'Flickr', 'keel' ), 'keel_settings_field_social_flickr', 'keel_theme_options', 'social' );
		add_settings_field( 'newsletter', __( 'Newsletter', 'keel' ), 'keel_settings_field_social_newsletter', 'keel_theme_options', 'social' );

		// Footer
		add_settings_field( 'footer1', __( 'Footer 1', 'keel' ), 'keel_settings_field_footer_content_1', 'keel_theme_options', 'footer' );
		add_settings_field( 'footer2', __( 'Footer 2', 'keel' ), 'keel_settings_field_footer_content_2', 'keel_theme_options', 'footer' );

	}
	add_action( 'admin_init', 'keel_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		$theme_page = add_theme_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );
		// $theme_page = add_submenu_page( 'tools.php', __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'keel_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function keel_theme_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_theme_options', 'keel_theme_option_page_capability' );



	/**
	 * Load the theme option styles
	 */

	function keel_theme_options_scripts_and_styles() {

		// Only load on Theme Options page
		global $pagenow;
		if ( !isset( $_GET['page'] ) ) return;
		if ( $pagenow !== '/themes.php' && $_GET['page'] !== 'keel_theme_options' ) return;

		// Load color picker
		// wp_enqueue_script( 'wp-color-picker' );
		// wp_enqueue_style( 'wp-color-picker' );

		// Load typefaces
		// wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		wp_enqueue_style( 'open_sans', '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' );
		wp_enqueue_style( 'source_sans_pro', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700' );
		wp_enqueue_style( 'lora', '//fonts.googleapis.com/css?family=Lora:400,400italic,700' );
		wp_enqueue_style( 'droid_serif', '//fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700' );

	}
	add_action( 'admin_enqueue_scripts', 'keel_theme_options_scripts_and_styles', 10, 1 );
