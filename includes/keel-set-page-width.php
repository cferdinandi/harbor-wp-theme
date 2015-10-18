<?php

	/**
	 * Set page to full-width
	 */

	// Create a metabox
	function keel_set_page_width_box() {
		add_meta_box( 'keel_set_page_width_checkbox', 'Set page width', 'keel_set_page_width_checkbox', 'page', 'side', 'default');
	}
	add_action('add_meta_boxes', 'keel_set_page_width_box');


	// Add checkbox to the metabox
	function keel_set_page_width_checkbox() {

		global $post;

		// Get checkedbox value
		$page_width = get_post_meta( $post->ID, 'keel_page_width', true );

		?>

			<fieldset id="keel-set-page-width-box">
				<div>
					<radiogroup>
						<label>
							<input type="radio" name="keel-set-page-width-checkbox" value="default" <?php checked( $page_width, '' ); ?>>
							Default
						</label>
						<br>
						<label>
							<input type="radio" name="keel-set-page-width-checkbox" value="wide" <?php checked( $page_width, 'wide' ); ?>>
							Wide
						</label>
						<br>
						<label>
							<input type="radio" name="keel-set-page-width-checkbox" value="full" <?php checked( $page_width, 'full' ); ?>>
							Full Width
						</label>
					</radiogroup>
				</div>
			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'keel-set-page-width-nonce', 'keel-set-page-width-process' );

	}

	// Save checkbox data
	function keel_save_page_set_width_checkbox( $post_id, $post ) {

		// Verify data came from edit screen
		if ( !isset( $_POST['keel-set-page-width-process'] ) || !wp_verify_nonce( $_POST['keel-set-page-width-process'], 'keel-set-page-width-nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Update data in database
		$width = $_POST['keel-set-page-width-checkbox'];
		if ( isset( $width ) ) {
			if ( $width === 'default' ) { delete_post_meta( $post->ID, 'keel_page_width' ); }
			if ( $width === 'wide' ) { update_post_meta( $post->ID, 'keel_page_width', 'wide' ); }
			if ( $width === 'full' ) { update_post_meta( $post->ID, 'keel_page_width', 'full' ); }
		} else {
			delete_post_meta( $post->ID, 'keel_page_width' );
		}

	}
	add_action('save_post', 'keel_save_page_set_width_checkbox', 1, 2);