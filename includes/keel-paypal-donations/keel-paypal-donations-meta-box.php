<?php


	/**
	 * Add a donation table option to pages and posts
	 */


	// Create a metabox
	function keel_paypal_donations_box() {
		foreach ( array( 'post', 'page' ) as $page ) {
			add_meta_box( 'keel_paypal_donations_textarea', 'PayPal Donations', 'keel_paypal_donations_textarea', $page, 'normal', 'default' );
		}
	}
	add_action( 'add_meta_boxes', 'keel_paypal_donations_box' );



	// Add PayPal donations options to the metabox
	function keel_paypal_donations_textarea() {

		global $post;

		// Get PayPal settings
		$paypal = get_post_meta( $post->ID, 'keel_paypal_donations', true );

		?>

			<?php if ( empty( $paypal['email'] ) ) : ?>
				<p style="color: #de302b;"><strong><em><?php _e( 'Please enter a PayPal account email address or ID to accept PayPal donations on this page or post.', 'keel' ); ?></em></strong></p>
			<?php endif; ?>

			<p><?php printf( __( 'You can display your donations form on this page or post by using the %s shortcode. You can also create one-off PayPal donation buttons using the %s.', 'keel' ), '<code>[paypal_donations_form]</code>', '<code>[paypal_donations_button]</code>' ); ?></p>
			<p><?php printf( __( ' Example: %s. Only %s is required. All other fields are options. %s makes the donation recurring. %s is what is displayed on PayPal.com.', 'keel' ), '<code>[paypal_donations_button amount="25" label="Donate $25" recurring="true" description="Donate $25 to the Special Fund"]</code>', '<code>amount</code>', '<code>recurring="true"</code>', '<code>description</code>' ); ?></p>


			<h3>General Settings</h3>

			<h4>PayPal Account ID</h4>
			<fieldset>
				<input type="text" name="keel_paypal_donations_email" id="keel_paypal_donations_email" value="<?php echo ( array_key_exists( 'email', (array) $paypal ) ? stripslashes( esc_attr( $paypal['email'] ) ) : '' ); ?>">
				<label class="description" for="keel_paypal_donations_email"><?php _e( 'PayPal account email address or username (donations are sent to this account)', 'keel' ); ?></label>
			</fieldset>

			<h4>Currency</h4>
			<fieldset>
				<input type="text" name="keel_paypal_donations_currency" id="keel_paypal_donations_currency" value="<?php echo ( array_key_exists( 'currency', (array) $paypal ) ? stripslashes( esc_attr( $paypal['currency'] ) ) : '$' ); ?>">
				<label class="description" for="keel_paypal_donations_currency"><?php _e( 'Currency prefix to use before amounts', 'keel' ); ?></label>
			</fieldset>

			<h3>Form Details</h3>


			<fieldset>
				<input type="text" name="keel_paypal_donations_table_heading_amount" id="keel_paypal_donations_table_heading_amount" value="<?php echo ( array_key_exists( 'table_heading_amount', (array) $paypal ) ? stripslashes( esc_attr( $paypal['table_heading_amount'] ) ) : 'Amount' ); ?>">
				<label class="description" for="keel_paypal_donations_email"><?php _e( 'Table heading for the donation amount', 'keel' ); ?></label>
			</fieldset>


			<fieldset>
				<input type="text" name="keel_paypal_donations_table_heading_impact" id="keel_paypal_donations_table_heading_impact" value="<?php echo ( array_key_exists( 'table_heading_impact', (array) $paypal ) ? stripslashes( esc_attr( $paypal['table_heading_impact'] ) ) : 'Impact' ); ?>">
				<label class="description" for="keel_paypal_donations_email"><?php _e( 'Table heading for the impact of the donation amount', 'keel' ); ?></label>
			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'keel-paypal-donations-nonce', 'keel-paypal-donations-process' );

	}



	// Save textarea data
	function keel_save_paypal_donations_textarea( $post_id, $post ) {

		// Verify data came from edit screen
		if ( !isset( $_POST['keel-paypal-donations-process'] ) || !wp_verify_nonce( $_POST['keel-paypal-donations-process'], 'keel-paypal-donations-nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Get hero data
		$paypal = array();

		if ( isset( $_POST['keel_paypal_donations_content'] ) ) {
			$paypal['content'] = wp_filter_post_kses( $_POST['keel_paypal_donations_content'] );
		}

		if ( isset( $_POST['keel_paypal_donations_image'] ) ) {
			$paypal['image'] = wp_filter_post_kses( $_POST['keel_paypal_donations_image'] );
		}

		if ( isset( $_POST['keel_paypal_donations_color'] ) ) {
			$paypal['color'] = wp_filter_nohtml_kses( $_POST['keel_paypal_donations_color'] );
		}

		if ( isset( $_POST['keel_paypal_donations_overlay'] ) ) {
			$paypal['overlay'] = wp_filter_nohtml_kses( $_POST['keel_paypal_donations_overlay'] );
		}

		// Update hero settings
		update_post_meta( $post->ID, 'keel_paypal_donations', $paypal );

	}
	add_action('save_post', 'keel_save_paypal_donations_textarea', 1, 2);



	// Save the data with revisions
	function keel_save_revisions_paypal_donations_textarea( $post_id ) {

		// Check if it's a revision
		$parent_id = wp_is_post_revision( $post_id );

		// If is revision
		if ( $parent_id ) {

			// Get the data
			$parent = get_post( $parent_id );
			$paypal = get_post_meta( $parent->ID, 'keel_paypal_donations', true );

			// If data exists, add to revision
			if ( !empty( $paypal ) && is_array( $paypal ) ) {
				if ( array_key_exists( 'content', $paypal ) ) {
					add_metadata( 'post', $post_id, 'keel_paypal_donations_content', $paypal['content'] );
				}

				if ( array_key_exists( 'image', $paypal ) ) {
					add_metadata( 'post', $post_id, 'keel_paypal_donations_image', $paypal['image'] );
				}

				if ( array_key_exists( 'color', $paypal ) ) {
					add_metadata( 'post', $post_id, 'keel_paypal_donations_color', $paypal['color'] );
				}

				if ( array_key_exists( 'overlay', $paypal ) ) {
					add_metadata( 'post', $post_id, 'keel_paypal_donations_overlay', $paypal['overlay'] );
				}
			}

		}

	}
	add_action( 'save_post', 'keel_save_revisions_paypal_donations_textarea' );



	// Restore the data with revisions
	function keel_restore_revisions_paypal_donations_textarea( $post_id, $revision_id ) {

		// Variables
		$post = get_post( $post_id );
		$revision = get_post( $revision_id );
		$paypal = get_post_meta( $post_id, 'keel_paypal_donations', true );
		$paypal_content = get_metadata( 'post', $revision->ID, 'keel_paypal_donations_content', true );
		$paypal_image = get_metadata( 'post', $revision->ID, 'keel_paypal_donations_image', true );
		$paypal_color = get_metadata( 'post', $revision->ID, 'keel_paypal_donations_color', true );
		$paypal_overlay = get_metadata( 'post', $revision->ID, 'keel_paypal_donations_overlay', true );

		// Update content
		if ( !empty( $paypal_content ) ) {
			$paypal['content'] = $paypal_content;
		}
		if ( !empty( $paypal_image ) ) {
			$paypal['image'] = $paypal_image;
		}
		if ( !empty( $paypal_color ) ) {
			$paypal['color'] = $paypal_color;
		}
		if ( !empty( $paypal_overlay ) ) {
			$paypal['overlay'] = $paypal_overlay;
		}
		update_post_meta( $post_id, 'keel_paypal_donations', $paypal );

	}
	add_action( 'wp_restore_post_revision', 'keel_restore_revisions_paypal_donations_textarea', 10, 2 );



	// Get the data to display the revisions page
	function keel_get_revisions_field_paypal_donations_textarea( $fields ) {
		$fields['keel_paypal_donations_content'] = 'Page Hero Content';
		$fields['keel_paypal_donations_image'] = 'Page Hero Image or Video';
		$fields['keel_paypal_donations_color'] = 'Page Hero Background and Text Color';
		$fields['keel_paypal_donations_overlay'] = 'Page Hero Background Overlay';
		return $fields;
	}
	add_filter( '_wp_post_revision_fields', 'keel_get_revisions_field_paypal_donations_textarea' );



	// Display the data on the revisions page
	function keel_display_revisions_field_paypal_donations_textarea( $value, $field ) {
		global $revision;
		return get_metadata( 'post', $revision->ID, $field, true );
	}
	add_filter( '_wp_post_revision_field_my_meta', 'keel_display_revisions_field_paypal_donations_textarea', 10, 2 );



	// Load required scripts and styles
	function keel_add_paypal_donations_scripts( $hook ) {
		global $typenow;
		if ( in_array( $typenow, array( 'page', 'post' ) ) ) {
			wp_enqueue_media();

			// Registers and enqueues the required javascript.
			wp_register_script( 'meta-box-image', get_template_directory_uri() . '/includes/keel-paypal-donations/keel-paypal-donations.js', array( 'jquery' ) );
			wp_localize_script( 'meta-box-image', 'meta_image',
				array(
					'title' => __( 'Choose or Upload an Image', 'keel' ),
					'button' => __( 'Use this image', 'keel' ),
				)
			);
			wp_enqueue_script( 'meta-box-image' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'keel_add_paypal_donations_scripts', 10, 1 );