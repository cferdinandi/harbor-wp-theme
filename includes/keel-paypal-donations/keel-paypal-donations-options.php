<?php

	/**
	 * Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	function keel_paypal_donations_settings_field_email() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<input type="text" name="keel_paypal_donations_theme_options[email]" id="email" value="<?php echo esc_attr( $options['email'] ); ?>" />
		<label class="description" for="email"><?php _e( 'PayPal account email address or username (donations are sent to this account)', 'keel' ); ?></label>
		<?php
	}

	function keel_paypal_donations_settings_field_notify_url() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<input type="text" name="keel_paypal_donations_theme_options[notify_url]" id="notify_url" value="<?php echo esc_attr( $options['notify_url'] ); ?>" />
		<label class="description" for="notify_url"><?php printf( __( 'Notification URL for %sPayPal IPN%s [optional]', 'keel' ), '<a href="https://developer.paypal.com/docs/classic/products/instant-payment-notification/">', '</a>' ); ?></label>
		<?php
	}

	function keel_paypal_donations_settings_field_headings() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<div>
			<input type="text" name="keel_paypal_donations_theme_options[heading_amount]" id="heading_amount" value="<?php echo esc_attr( $options['heading_amount'] ); ?>" />
			<label class="description" for="heading_amount"><?php _e( 'Table heading for the amount', 'keel' ); ?></label>
		</div>
		<br>
		<div>
			<input type="text" name="keel_paypal_donations_theme_options[heading_impact]" id="heading_impact" value="<?php echo esc_attr( $options['heading_impact'] ); ?>" />
			<label class="description" for="heading_impact"><?php _e( 'Table heading for the impact of that amount', 'keel' ); ?></label>
		</div>
		<?php
	}

	function keel_paypal_donations_settings_field_currency() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<input type="text" name="keel_paypal_donations_theme_options[currency]" id="currency" value="<?php echo esc_attr( $options['currency'] ); ?>" />
		<label class="description" for="currency"><?php _e( 'Currency prefix to use before amounts', 'keel' ); ?></label>
		<?php
	}

	function keel_paypal_donations_settings_field_show_other() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<input type="checkbox" name="keel_paypal_donations_theme_options[show_other]" id="show_other" <?php checked( 'on', $options['show_other'] ); ?> />
		<label for="show_other"><?php _e( 'Show "Other" field for users to fill in their own amount', 'keel' ); ?></label>
		<?php
	}

	function keel_paypal_donations_settings_field_show_in_honor() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<div>
			<input type="checkbox" name="keel_paypal_donations_theme_options[show_in_honor]" id="show_in_honor" <?php checked( 'on', $options['show_in_honor'] ); ?> />
			<label for="show_in_honor"><?php _e( 'Show "In Honor/Memory Of" field', 'keel' ); ?></label>
		</div>
		<br>
		<div>
			<input type="text" name="keel_paypal_donations_theme_options[in_honor]" class="large-text" id="in_honor" value="<?php echo esc_attr( $options['in_honor'] ); ?>" />
			<label class="description" for="in_honor"><?php _e( 'Language to describe "in honor/memory of" donations', 'keel' ); ?></label>
		</div>
		<?php
	}

	function keel_paypal_donations_settings_field_show_recurring() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<div>
			<input type="checkbox" name="keel_paypal_donations_theme_options[show_recurring]" id="show_recurring" <?php checked( 'on', $options['show_recurring'] ); ?> />
			<label for="show_recurring"><?php _e( 'Provide an option for recurring monthly donations', 'keel' ); ?></label>
		</div>
		<br>
		<div>
			<input type="text" name="keel_paypal_donations_theme_options[recurring]" class="large-text" id="recurring" value="<?php echo esc_attr( $options['recurring'] ); ?>" />
			<label class="description" for="recurring"><?php _e( 'Language to describe recurring monthly donation', 'keel' ); ?></label>
		</div>
		<?php
	}

	function keel_paypal_donations_settings_field_donate_text() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<input type="text" name="keel_paypal_donations_theme_options[donate]" id="donate" value="<?php echo esc_attr( $options['donate'] ); ?>" />
		<label class="description" for="donate"><?php _e( 'Donate button text', 'keel' ); ?></label>
		<?php
	}

	function keel_paypal_donations_settings_field_success_link() {
		$options = keel_paypal_donations_get_theme_options();
		?>
		<input type="text" name="keel_paypal_donations_theme_options[success_link]" class="regular-text" id="success_link" value="<?php echo esc_attr( $options['success_link'] ); ?>" />
		<label class="description" for="success_link"><?php _e( 'Link to send donors to after donation is completed', 'keel' ); ?></label>
		<?php
	}

	function keel_paypal_donations_settings_field_amounts( $args ) {
		$options = keel_paypal_donations_get_theme_options();
		$amount = $options['amounts'][$args['id']];
		?>
			<div data-paypal-amount="<?php echo $args['id']; ?>">
				<div>
					<input type="number" step="any" min="0" name="keel_paypal_donations_theme_options[amounts][<?php echo $args['id']; ?>][amount]" id="amount-<?php echo $args['id']; ?>" value="<?php echo esc_attr( $amount['amount'] ); ?>" />
					<label class="description" for="amount-<?php echo $args['id']; ?>"><?php _e( 'Amount in dollars, no <code>$</code> needed. (ex. <code>25</code>)', 'keel' ); ?></label>
				</div>
				<br>
				<div>
					<input type="text" name="keel_paypal_donations_theme_options[amounts][<?php echo $args['id']; ?>][description]" class="large-text" id="description-<?php echo $args['id']; ?>" value="<?php echo esc_attr( $amount['description'] ); ?>" />
					<label class="description" for="description-<?php echo $args['id']; ?>"><?php _e( 'Description of what the donation can provide (ex. <code>Provides food for one animal for a month</code>)', 'keel' ); ?></label>
				</div>
			</div>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under keel_paypal_donations_get_theme_options(), and an if statement under keel_paypal_donations_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_paypal_donations_get_theme_options() {
		$saved = (array) get_option( 'keel_paypal_donations_theme_options' );
		$defaults = array(
			'email' => '',
			'notify_url' => '',
			'heading_amount' => 'Amount',
			'heading_impact' => 'Impact',
			'currency' => '$',
			'show_other' => 'on',
			'show_in_honor' => 'on',
			'in_honor' => 'Make donation in honor or memory of:',
			'show_recurring' => 'on',
			'recurring' => 'I would like to make this a monthly donation',
			'donate' => 'Donate',
			'success_link' => '',
			'amounts' => array(
				0 => array(
					'amount' => '',
					'description' =>''
				),
			),
		);

		$defaults = apply_filters( 'keel_paypal_donations_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function keel_paypal_donations_theme_options_validate( $input ) {
		$options = keel_paypal_donations_get_theme_options();
		$output = array();

		if ( isset( $input['email'] ) && ! empty( $input['email'] ) )
			$output['email'] = wp_filter_nohtml_kses( $input['email'] );

		if ( isset( $input['notify_url'] ) && ! empty( $input['notify_url'] ) )
			$output['notify_url'] = wp_filter_nohtml_kses( $input['notify_url'] );

		if ( isset( $input['heading_amount'] ) && ! empty( $input['heading_amount'] ) )
			$output['heading_amount'] = wp_filter_nohtml_kses( $input['heading_amount'] );

		if ( isset( $input['heading_impact'] ) && ! empty( $input['heading_impact'] ) )
			$output['heading_impact'] = wp_filter_nohtml_kses( $input['heading_impact'] );

		if ( isset( $input['currency'] ) && ! empty( $input['currency'] ) )
			$output['currency'] = wp_filter_nohtml_kses( $input['currency'] );

		if ( !isset( $input['show_other'] ) || empty( $input['show_other'] ) )
			$output['show_other'] = 'off';

		if ( !isset( $input['show_in_honor'] ) || empty( $input['show_in_honor'] ) )
			$output['show_in_honor'] = 'off';

		if ( isset( $input['in_honor'] ) && ! empty( $input['in_honor'] ) )
			$output['in_honor'] = wp_filter_nohtml_kses( $input['in_honor'] );

		if ( !isset( $input['show_recurring'] ) || empty( $input['show_recurring'] ) )
			$output['show_recurring'] = 'off';

		if ( isset( $input['recurring'] ) && ! empty( $input['recurring'] ) )
			$output['recurring'] = wp_filter_nohtml_kses( $input['recurring'] );

		if ( isset( $input['donate'] ) && ! empty( $input['donate'] ) )
			$output['donate'] = wp_filter_nohtml_kses( $input['donate'] );

		if ( isset( $input['success_link'] ) && ! empty( $input['success_link'] ) )
			$output['success_link'] = wp_filter_nohtml_kses( $input['success_link'] );

		foreach ($input['amounts'] as $key => $amount) {
			if ( isset( $input['amounts'][$key]['amount'] ) && ! empty ( $input['amounts'][$key]['amount'] )  && isset( $input['amounts'][$key]['description'] ) && ! empty ( $input['amounts'][$key]['description'] ) )
				$output['amounts'][$key] = array(
					'amount' => wp_filter_nohtml_kses( ltrim( $input['amounts'][$key]['amount'], '$ £' ) ),
					'description' => wp_filter_nohtml_kses( $input['amounts'][$key]['description'] ),
				);
		}

		return apply_filters( 'keel_paypal_donations_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_paypal_donations_theme_options_render_page() {
		$options = keel_paypal_donations_get_theme_options();

		?>
		<div class="wrap">
			<h2><?php _e( 'PayPal Donations Options', 'keel' ); ?></h2>
			<?php if ( empty( $options['email'] ) ) : ?>
				<div class="error">
					<p><?php _e( 'Please enter a PayPal account email address or ID to beging accepting PayPal donations on your site.', 'keel' ); ?></p>
				</div>
			<?php endif; ?>
			<?php settings_errors(); ?>
			<p><?php printf( __( 'You can display your donations form on any page by using the %s shortcode. You can also create one-off PayPal donation buttons using the %s.', 'keel' ), '<code>[paypal_donations_form]</code>', '<code>[paypal_donations_button]</code>' ); ?></p>
			<p><?php printf( __( ' Example: %s. Only %s is required. All other fields are options. %s makes the donation recurring. %s is what is displayed on PayPal.com.', 'keel' ), '<code>[paypal_donations_button amount="25" label="Donate $25" recurring="true" description="Donate $25 to the Special Fund" notify_url="http://example.com/12345"]</code>', '<code>amount</code>', '<code>recurring="true"</code>', '<code>description</code>' ); ?></p>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_paypal_donations_options' );
					do_settings_sections( 'keel_paypal_donations_theme_options' );
					submit_button();
				?>
			</form>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					var template = function ( id ) {
						var theTemplate =
							'<tr>' +
								'<th scope="row">Donation Value ' + ( id + 1 ) + '</th>' +
								'<td>' +
									'<div data-paypal-amount="' + id + '">' +
										'<div>' +
											'<input type="number" step="any" min="0" name="keel_paypal_donations_theme_options[amounts][' + id + '][amount]" id="amount-' + id + '" value="" /> ' +
											'<label class="description" for="amount-' + id + '">Amount in dollars, no <code>$</code> needed. (ex. <code>25</code></label>' +
										'</div>' +
										'<br>' +
										'<div>' +
											'<input type="text" name="keel_paypal_donations_theme_options[amounts][' + id + '][description]" class="large-text" id="description-' + id + '" value="" />' +
											'<label class="description" for="description-' + id + '">Description of what the donation can provide (ex. <code>Provides food for one animal for a month</code>)</label>' +
										'</div>' +
									'</div>' +
								'</td>' +
							'</tr>';
						return theTemplate;
					};

					var last = jQuery( '[data-paypal-amount]' ).last();
					last.closest('tbody').after( '<tr><th>&nbsp;</th><td><p><button class="button js-paypal-add-amount">Add Another Amount</button></p></td></tr>' );

					jQuery( '.js-paypal-add-amount' ).click(function() {

						// Variables
						var last = jQuery( '[data-paypal-amount]' ).last();
						var id = last.data( 'paypal-amount' );
						var newAmount = template( id + 1 );

						// Add new row
						event.preventDefault();
						last.closest('tr').after( newAmount );

					});
				});
			</script>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function keel_paypal_donations_theme_options_init() {

		$options = keel_paypal_donations_get_theme_options();

		// Register a setting and its sanitization callback
		register_setting( 'keel_paypal_donations_options', 'keel_paypal_donations_theme_options', 'keel_paypal_donations_theme_options_validate' );

		// General
		add_settings_section( 'general', 'General Settings',  '__return_false', 'keel_paypal_donations_theme_options' );
		add_settings_field( 'email', __( 'PayPal Account ID', 'keel' ), 'keel_paypal_donations_settings_field_email', 'keel_paypal_donations_theme_options', 'general' );
		add_settings_field( 'notify_url', __( 'Notification URL', 'keel' ), 'keel_paypal_donations_settings_field_notify_url', 'keel_paypal_donations_theme_options', 'general' );

		// Details
		add_settings_section( 'details', 'Form Details',  '__return_false', 'keel_paypal_donations_theme_options' );
		add_settings_field( 'headings', __( 'Table Headings', 'keel' ), 'keel_paypal_donations_settings_field_headings', 'keel_paypal_donations_theme_options', 'details' );
		add_settings_field( 'currency', __( 'Currency', 'keel' ), 'keel_paypal_donations_settings_field_currency', 'keel_paypal_donations_theme_options', 'details' );
		add_settings_field( 'show_other', __( 'Other Amount', 'keel' ), 'keel_paypal_donations_settings_field_show_other', 'keel_paypal_donations_theme_options', 'details' );
		add_settings_field( 'in_honor', __( 'In Honor/Memory', 'keel' ), 'keel_paypal_donations_settings_field_show_in_honor', 'keel_paypal_donations_theme_options', 'details' );
		add_settings_field( 'recurring', __( 'Recurring Donations', 'keel' ), 'keel_paypal_donations_settings_field_show_recurring', 'keel_paypal_donations_theme_options', 'details' );
		add_settings_field( 'donate', __( 'Donate Button', 'keel' ), 'keel_paypal_donations_settings_field_donate_text', 'keel_paypal_donations_theme_options', 'details' );
		add_settings_field( 'success_link', __( 'Success URL', 'keel' ), 'keel_paypal_donations_settings_field_success_link', 'keel_paypal_donations_theme_options', 'details' );

		// Amounts
		add_settings_section( 'amounts', 'Donation Values',  '__return_false', 'keel_paypal_donations_theme_options' );
		foreach ($options['amounts'] as $key => $amount) {
			add_settings_field( 'amounts_' . $key, __( 'Donation Value ', 'keel' ) . ($key + 1), 'keel_paypal_donations_settings_field_amounts', 'keel_paypal_donations_theme_options', 'amounts', array( 'id' => $key ) );
		}

	}
	add_action( 'admin_init', 'keel_paypal_donations_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_paypal_donations_theme_options_add_page() {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['paypal'] ) return '';

		$theme_page = add_menu_page( __( 'PayPal Donations', 'keel' ), __( 'PayPal Donations', 'keel' ), 'edit_theme_options', 'keel_paypal_donations_theme_options', 'keel_paypal_donations_theme_options_render_page', 'dashicons-heart' );
		// $theme_page = add_submenu_page( 'tools.php', __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_paypal_donations_theme_options', 'keel_paypal_donations_theme_options_render_page' );

	}
	add_action( 'admin_menu', 'keel_paypal_donations_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function keel_paypal_donations_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_paypal_donations_options', 'keel_paypal_donations_option_page_capability' );