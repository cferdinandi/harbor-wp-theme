<?php

/**
 * PayPal Donations
 */


// Load plugin options
require_once( dirname( __FILE__) . '/keel-paypal-donations-options.php' );

// PayPal Donations Class
class Keel_PayPal_Donations {

	/**
	 * Get the URL of the current page
	 * @return string The URL
	 */
	private static function get_url() {

		// Get URL
		$url  = @( $_SERVER['HTTPS'] != 'on' ) ? 'http://' . $_SERVER['SERVER_NAME'] :  'https://' . $_SERVER['SERVER_NAME'];
		$url .= ( $_SERVER['SERVER_PORT'] !== 80 ) ? ":" . $_SERVER['SERVER_PORT'] : '';
		$url .= $_SERVER['REQUEST_URI'];

		return $url;

	}

	/**
	 * Process donations table on submit
	 */
	public static function process_donations_table() {

		// Verify form exists and was properly posted
		if ( isset( $_POST['keel_paypal_donations_table_process'] ) ) {
			if ( wp_verify_nonce( $_POST['keel_paypal_donations_table_process'], 'keel_paypal_donations_table_nonce' ) ) {

				// Variables
				$options = keel_paypal_donations_get_theme_options();
				$referer = self::get_url();

				// Values
				$type = isset( $_POST['paypal_donations_form_recurring'] ) ? '_xclick-subscriptions' : '_donations';
				$description = isset( $_POST['paypal_donations_form_recurring'] ) ? 'Monthly Donation' : 'Donation';
				$in_honor = isset( $_POST['paypal_donations_form_in_honor'] ) && !empty( $_POST['paypal_donations_form_in_honor'] ) ? ' - ' . $options['in_honor'] . ' ' . $_POST['paypal_donations_form_in_honor'] : '';
				$amount = isset( $_POST['paypal_donations_form_amount'] ) ? $_POST['paypal_donations_form_amount'] : '';
				if ( ( empty($amount) || $amount === 'other' ) && isset( $_POST['paypal_donations_form_other'] ) && !empty( $_POST['paypal_donations_form_other'] ) ) {
					$amount = ltrim( $_POST['paypal_donations_form_other'], '$ £' );
				}
				$currency = empty( $amount ) ? '' : ': ' . $options['currency'] . $amount;
				$return = empty( $options['success_link'] ) ? $referer : $options['success_link'];


				// Construct PayPal URL
				$base_url = 'https://www.paypal.com/cgi-bin/webscr?';
				$queries = http_build_query(
					array(
						'cmd' => $type,
						'business' => $options['email'],
						'item_name' => $description . $currency . $in_honor,
						'amount' => $amount,
						'a3' => $amount,
						'p3' => 1,
						't3' => 'M',
						'src' => 1,
						'return' => $return,
						'cancel_return' => $referer,
						'notify_url' => $options['notify_url'],
					)
				);
				$url = $base_url . $queries;

				wp_redirect( $url );
				exit;

			} else {
				die( 'Security check' );
			}
		}

	}

	/**
	 * Process donation button on submit
	 */
	public static function process_donations_button() {

		// Verify form exists and was properly posted
		if ( isset( $_POST['keel_paypal_donations_button_process'] ) ) {
			if ( wp_verify_nonce( $_POST['keel_paypal_donations_button_process'], 'keel_paypal_donations_button_nonce' ) ) {

				// Variables
				$options = keel_paypal_donations_get_theme_options();
				$referer = self::get_url();

				// Values
				$type = isset( $_POST['paypal_donations_button_recurring'] ) ? '_xclick-subscriptions' : '_donations';
				$description = isset( $_POST['paypal_donations_button_description'] ) ? $_POST['paypal_donations_button_description'] : 'Donation';
				$amount = isset( $_POST['paypal_donations_button_amount'] ) ? $_POST['paypal_donations_button_amount'] : '';
				$currency = empty( $amount ) ? '' : ': ' . $options['currency'] . $amount;
				$return = empty( $options['success_link'] ) ? $referer : $options['success_link'];
				$notify_url = isset( $_POST['paypal_donations_button_notify_url'] ) ? $_POST['paypal_donations_button_notify_url'] : '';


				// Construct PayPal URL
				$base_url = 'https://www.paypal.com/cgi-bin/webscr?';
				$queries = http_build_query(
					array(
						'cmd' => $type,
						'business' => $options['email'],
						'item_name' => $description . $currency,
						'amount' => $amount,
						'a3' => $amount,
						'p3' => 1,
						't3' => 'M',
						'src' => 1,
						'return' => $return,
						'cancel_return' => $referer,
						'notify_url' => $notify_url,
					)
				);
				$url = $base_url . $queries;

				wp_redirect( $url );
				exit;

			} else {
				die( 'Security check' );
			}
		}

	}

	/**
	 * Render the PayPal donations table
	 * @return string  The donation table markup
	 */
	public static function render_donations_table() {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['paypal'] ) return '';

		// Options and settings
		$options = keel_paypal_donations_get_theme_options();
		$table = '';
		$table_body = '';
		$show_in_honor = $options['show_in_honor'] === 'on';
		$show_recurring = $options['show_recurring'] === 'on';

		if ( empty( $options['email'] ) || empty( $options['amounts'][0]['amount'] ) || empty( $options['amounts'][0]['description'] ) ) return $table;

		foreach ($options['amounts'] as $key => $amount) {
			$table_body .=
				'<tr>' .
					'<td>' .
						'<label>' .
							'<input type="radio" name="paypal_donations_form_amount" id="paypal_donations_form_amount_' . $key . '" value="' . $amount['amount'] . '" ' . checked( $options['default_amount'], $key, False ) . '> ' .
							$options['currency'] . $amount['amount'] .
						'</label>' .
					'</td>' .
					'<td>' .
						'<label for="paypal_donations_form_amount_' . $key . '">' .
							$amount['description'] .
						'</label>' .
					'</td>' .
				'</tr>';
		}

		if ( $options['show_other'] === 'on' ) {
			$table_body .=
				'<tr>' .
					'<td>' .
						'<label>' .
							'<input type="radio" name="paypal_donations_form_amount" id="paypal_donations_form_amount_other" value="other"> ' .
							__( 'Other', 'keel' ) .
						'</label>' .
					'</td>' .
					'<td>' .
						$options['currency'] . ' <input type="number" step="any" min="0" class="input-inline input-condensed input-underline no-margin-bottom" name="paypal_donations_form_other" id="paypal_donations_form_other" value="">' .
					'</td>' .
				'</tr>';
		}

		if ( $show_in_honor || $show_recurring ) {
			$table_body .=
				'<tr>' .
					'<td colspan="2">';

			if ( $show_in_honor ) {
				$table_body .=
					'<label class="padding-top">' .
						// '<input type="checkbox" id="paypal_donations_form_donate_in_honor"> ' .
						$options['in_honor'] . ' <input type="text" class="input-inline input-condensed input-underline no-margin-bottom" name="paypal_donations_form_in_honor" id="paypal_donations_form_in_honor" value="">' .
					'</label>';
			}

			if ( $show_recurring ) {
				$table_body .=
					'<label class="padding-top">' .
						'<input type="checkbox" name="paypal_donations_form_recurring" value="on"> ' .
						$options['recurring'] .
					'</label>';
			}

			$table_body .=
					'</td>' .
				'</tr>';
		}

		$table =
			'<form class="paypal-donations-table" id="paypal-donations-table" name="paypal-donations-table" action="" method="post">' .
				'<table class="table-responsive">' .
					'<thead>' .
						'<tr>' .
							'<th>' . __( $options['heading_amount'], 'keel' ) . '</th>' .
							'<th>' . __( $options['heading_impact'], 'keel' ) . '</th>' .
						'</tr>' .
					'</thead>' .
					'<tbody>' .
						$table_body .
					'</tbody>' .
				'</table>' .
				wp_nonce_field( 'keel_paypal_donations_table_nonce', 'keel_paypal_donations_table_process' ) .
				'<button class="btn">' . $options['donate'] . '</button>' .
			'</form>';

		$script = '<script>!function(e,n){"use strict";if(!(!1 in n)){var o=n.querySelector("#paypal_donations_form_other"),t=n.querySelector("#paypal_donations_form_amount_other"),c=n.querySelector("#paypal_donations_form_in_honor"),r=n.querySelector("#paypal_donations_form_donate_in_honor");o&&t&&(o.addEventListener("focus",function(){t.checked=!0},!1),t.addEventListener("click",function(){t.checked===!0&&o.focus()},!1)),c&&r&&(c.addEventListener("focus",function(){r.checked=!0},!1),r.addEventListener("click",function(){r.checked===!0&&c.focus()},!1))}}(window,document);</script>';

			// Unminified
			// <script>
			// 	;(function (window, document, undefined) {
			// 		'use strict';
			// 		if ( ! 'querySelector' in document ) return;
			// 		var other = document.querySelector( '#paypal_donations_form_other' );
			// 		var radio = document.querySelector( '#paypal_donations_form_amount_other' );
			// 		var memory = document.querySelector( '#paypal_donations_form_in_honor' );
			// 		var check = document.querySelector( '#paypal_donations_form_donate_in_honor' );
			// 		if ( other && radio ) {
			// 			other.addEventListener('focus', function () { radio.checked = true; }, false);
			// 			radio.addEventListener('click', function () { if ( radio.checked === true ) { other.focus(); } }, false);
			// 		}
			// 		if ( memory && check ) {
			// 			memory.addEventListener('focus', function () { check.checked = true; }, false);
			// 			check.addEventListener('click', function () { if ( check.checked === true ) { memory.focus(); } }, false);
			// 		}
			// 	})(window, document);
			// </script>

		return $table . $script;

	}

	/**
	 * Render a PayPal donation button
	 * @return string  The donation button markup
	 */
	public static function render_donations_button( $atts ) {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['paypal'] ) return '';

		// Shortcode values
		$paypal = shortcode_atts( array(
			'amount' => '',
			'label' => '',
			'recurring' => false,
			'description' => '',
			'size' => '',
			'notify_url' => '',
		), $atts );

		// Options and settings
		$options = keel_paypal_donations_get_theme_options();

		// If not PayPal account is provided, do nothing
		if ( empty( $options['email'] ) ) return;

		// Variables
		$amount = ltrim( $paypal['amount'], '$ £' );
		$label = empty( $paypal['label'] ) ? $options['currency'] . $amount : $paypal['label'];
		$recurring = empty( $paypal['recurring'] ) ? '' : '<input type="hidden" name="paypal_donations_button_recurring" value="true">';
		$description = empty( $paypal['description'] ) ? '' : '<input type="hidden" name="paypal_donations_button_description" value="' . $paypal['description'] . '">';
		$form =
			'<form class="paypal-donations-button" id="paypal-donations-table-' . $amount . '" name="paypal-donations-table" action="" method="post">' .
				'<input type="hidden" name="paypal_donations_button_amount" value="' . $amount . '">' .
				'<input type="hidden" name="paypal_donations_button_notify_url" value="' . $paypal['notify_url'] . '">' .
				$recurring .
				$description .
				wp_nonce_field( 'keel_paypal_donations_button_nonce', 'keel_paypal_donations_button_process' ) .
				'<button class="btn btn-' . $paypal['size'] . '">' . $label . '</button>' .
			'</form>';

		return $form;

	}

	/**
	 * Initialize hooks and shortcodes
	 */
	public function __construct() {
		add_shortcode( 'paypal_donations_form', array( $this, 'render_donations_table' ) );
		add_shortcode( 'paypal_donations_button', array( $this, 'render_donations_button' ) );
		add_action( 'init', array( $this, 'process_donations_table' ) );
		add_action( 'init', array( $this, 'process_donations_button' ) );
	}

}

new Keel_PayPal_Donations();