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

			<p><?php printf( __( 'Need help? Please %screate an issue on GitHub%s.', 'keel' ), '<a target="_blank" href="https://github.com/cferdinandi/harbor-wp-theme/issues">', '</a>' ) ?></p>
			<p>(<em><?php _e( 'Don’t forget to search through the existing and closed issues first.', 'keel' ); ?></em>)</p>

			<h3><?php _e( 'Customize This Theme', 'keel' ); ?></h3>

			<p><?php printf( __( 'Interested in this theme but require customization to satisfy your particular use case? This theme can be customized to suit your specific needs. %sLet’s schedule a quick call%s to talk about about your organization, your goals, and how we might work together.', 'keel' ), '<a target="_blank" href="http://gomakethings.com/schedule-a-call/">', '</a>' ); ?></p>

			<h3><?php _e( 'Free Course', 'keel' ); ?></h3>

			<p><?php _e( 'Sign up for my free email course on digital fundraising for animal rescue, and learn how to use technology to raise more money for your animal rescue at <a target="_blank" href="http://gomakethings.com/course">http://gomakethings.com/course</a>.', 'keel' ); ?></p>
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
