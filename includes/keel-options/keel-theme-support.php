<?php

/**
 * Theme Support
 * Get theme support
 *
 * @link https://gist.github.com/mfields/4678999
 */


	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_theme_support_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Theme Support', 'keel' ); ?></h2>
			<p>Need help? There are a few ways to get support.</p>
			<ol>
				<li>Check out <a target="_blank" href="http://harbor.gomakethings.com">the live demo and documentation</a>.</li>
				<li>Create an <a target="_blank" href="https://github.com/cferdinandi/harbor-wp-theme">issue on GitHub</a> (<em>don't forget to search through the closed issues first</em>).</li>
				<li>For premium, 1-on-1 support, contact me at <a target="_blank" href="http://gomakethings.com">GoMakeThings.com</a>.</li>
			</ol>
			<p>Do you want to learn how to learn how to provide your supporters with an amazing experience on whatever device they have with them? <strong>Sign-up for a free 7 lesson email course and learn the essentials of mobile strategy at <a href="http://gomakethings.com/course">http://gomakethings.com/course</a>.</strong></p>
		</div>
		<?php
	}

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_theme_support_add_page() {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['theme_support'] ) return;

		$theme_page = add_submenu_page( 'themes.php', __( 'Theme Support', 'keel' ), __( 'Theme Support', 'keel' ), 'edit_theme_options', 'keel_theme_support', 'keel_theme_support_render_page' );

	}
	add_action( 'admin_menu', 'keel_theme_support_add_page' );



	// Restrict access to the theme options page to admins
	function keel_theme_support_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_theme_support_options', 'keel_theme_support_option_page_capability' );
