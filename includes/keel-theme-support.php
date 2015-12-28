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
			<h2><?php _e( 'Theme Support', 'keel_theme_support' ); ?></h2>
			<p>Need help? There are a few ways to get support.</p>
			<ol>
				<li>Create an <a target="_blank" href="https://github.com/cferdinandi/harbor-pet-rescue-wordpress-theme">issue on GitHub</a> (<em>don't forget to search through the closed issues first</em>).</li>
				<li>For premium, 1-on-1 support, contact me at <a target="_blank" href="http://gomakethings.com">GoMakeThings.com</a>.</li>
			</ol>
		</div>
		<?php
	}

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_theme_support_add_page() {
		$theme_page = add_menu_page( __( 'Theme Support', 'keel_theme_support' ), __( 'Theme Support', 'keel_theme_support' ), 'edit_theme_options', 'theme_options', 'keel_theme_support_render_page', 'dashicons-editor-help' );
	}
	add_action( 'admin_menu', 'keel_theme_support_add_page' );



	// Restrict access to the theme options page to admins
	function keel_theme_support_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_theme_support_options', 'keel_theme_support_option_page_capability' );
