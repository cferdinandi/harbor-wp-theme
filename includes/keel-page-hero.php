<?php

	/**
	 * Set page to full-width
	 */

	// Create a metabox
	function keel_create_page_hero_box() {
		add_meta_box( 'keel_render_page_hero_box', 'Page Hero', 'keel_render_page_hero_box', 'page', 'normal', 'default');
	}
	add_action('add_meta_boxes', 'keel_create_page_hero_box');


	// Add checkbox to the metabox
	function keel_render_page_hero_box() {

		global $post;

		// Get values
		$hero = get_post_meta( $post->ID, 'keel_page_hero', true );

		?>

			<p>This is where you can create a banner that will be displayed at the top the page. If you've added a <em>Featured Image</em>, it will show up in the background behind your page title. Use this section to add additional content.</p>

			<fieldset id="keel_page_hero_box">
				<p><strong>Content</strong></p>
				<div>
					<?php wp_editor(
						( array_key_exists( 'content', (array) $hero ) ? stripslashes( $hero['content'] ) : '' ),
						'keel_page_hero_content',
						array(
							'wpautop' => false,
							'textarea_name' => 'keel_page_hero_content',
							'textarea_rows' => 4,
						)
					); ?>
					<label class="description" for="hero_content"><?php _e( 'Add additional text and content to the page Hero.', 'keel' ); ?></label>
				</div><br>

				<p><strong>Video</strong></p>
				<div>
					<input type="text" class="large-text" id="keel_page_hero_video" name="keel_page_hero_video" value="<?php echo ( array_key_exists( 'video', (array) $hero ) ? esc_html( $hero['video'] ) : '' ); ?>">
					<label class="description" for="keel_page_hero_video"><?php _e( '[Optional] URL for a video hosted on YouTube, Vimeo, Viddler, Instagram, TED, <a target="_blank" href="http://www.oembed.com/#section7.1">and more</a>. Example: <code>http://youtube.com/watch/?v=12345abc</code>', 'keel' ); ?></label>
				</div>
				<div>
					<p><em>On small screens, the video should be on the:</em></p>
					<radiogroup>
						<label>
							<input type="radio" name="keel_page_hero_video_location_small" value="top" <?php ( array_key_exists( 'video_location_small', (array) $hero ) ? checked( $hero['video_location_small'], 'top' ) : checked( '', '' ) ); ?>>
							Top
						</label><br>
						<label>
							<input type="radio" name="keel_page_hero_video_location_small" value="bottom" <?php ( array_key_exists( 'video_location_small', (array) $hero ) ? checked( $hero['video_location_small'], 'bottom' ) : '' ); ?>>
							Bottom
						</label>
					</radiogroup>
				</div>
				<div>
					<p><em>On big screens, the video should be on the:</em></p>
					<radiogroup>
						<label>
							<input type="radio" name="keel_page_hero_video_location_large" value="left" <?php ( array_key_exists( 'video_location_large', (array) $hero ) ? checked( $hero['video_location_large'], 'left' ) : '' ); ?>>
							Left
						</label>&nbsp;
						<label>
							<input type="radio" name="keel_page_hero_video_location_large" value="right" <?php ( array_key_exists( 'video_location_large', (array) $hero ) ? checked( $hero['video_location_large'], 'right' ) : checked( '', '' ) ); ?>>
							Right
						</label>
					</radiogroup>
				</div>
			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'keel_page_hero_box_nonce', 'keel_page_hero_box_process' );

	}

	// Save checkbox data
	function keel_save_page_hero_box( $post_id, $post ) {

		// Verify data came from edit screen
		if ( !isset( $_POST['keel_page_hero_box_process'] ) || !wp_verify_nonce( $_POST['keel_page_hero_box_process'], 'keel_page_hero_box_nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Push options to an array
		$hero = array();
		if ( isset( $_POST['keel_page_hero_content'] ) ) {
			$hero['content'] = wp_filter_post_kses( $_POST['keel_page_hero_content'] );
		}
		if ( isset( $_POST['keel_page_hero_video'] ) ) {
			$hero['video'] = esc_url( $_POST['keel_page_hero_video'] );
		}
		if ( isset( $_POST['keel_page_hero_video_location_small'] ) ) {
			$hero['video_location_small'] = wp_filter_nohtml_kses( $_POST['keel_page_hero_video_location_small'] );
		}
		if ( isset( $_POST['keel_page_hero_video_location_large'] ) ) {
			$hero['video_location_large'] = wp_filter_nohtml_kses( $_POST['keel_page_hero_video_location_large'] );
		}

		// Update data in the database
		update_post_meta( $post->ID, 'keel_page_hero', $hero );

	}
	add_action( 'save_post', 'keel_save_page_hero_box', 1, 2 );



	/**
	 * Get hero content
	 */
	function keel_get_hero_content( $post_id = null ) {

		// Get the post ID
		global $post;
		$post_id = $post_id ? $post_id : $post->ID;

		// Get hero
		$hero = get_post_meta( $post_id, 'keel_page_hero', true );
		$is_hero = is_array( $hero );

		// Get post thumbnail
		$is_thumbnail = has_post_thumbnail( $post_id );
		$thumbnail_id = $is_thumbnail ? get_post_thumbnail_id() : null;

		return array(
			'content'              => $is_hero && array_key_exists('content', $hero) ? stripslashes( $hero['content'] ) : null,
			'video'                => $is_hero && array_key_exists('video', $hero) ? wp_oembed_get( $hero['video'] ) : null,
			'video_location_small' => $is_hero && array_key_exists('video_location_small', $hero) ? $hero['video_location_small'] : 'top',
			'video_location_large' => $is_hero && array_key_exists('video_location_large', $hero) ? $hero['video_location_large'] : 'right',
			'img'                  => $is_thumbnail ? wp_get_attachment_image_src( $thumbnail_id, 'full', true ) : null,
		);

	}



	/**
	 * Determine if a post has a hero
	 */
	function keel_has_hero( $post_id = null ) {

		// Get the post ID
		global $post;
		$post_id = $post_id ? $post_id : $post->ID;

		// Get hero content
		$hero = keel_get_hero_content( $post_id );

		return ( empty( $hero['content'] ) && empty( $hero['video'] ) && empty( $hero['img'] ) ) ? false : true;

	}



	/**
	 * Generate hero markup
	 */
	function keel_get_hero( $post_id = null ) {

		// Get the post ID
		global $post;
		$post_id = $post_id ? $post_id : $post->ID;

		// Get hero
		$hero = keel_get_hero_content( $post_id );

		?>

		<header class="bg-hero <?php if ( !empty( $hero['content'] ) || !empty( $hero['video'] ) ) { echo 'bg-muted'; } ?> <?php if ( !empty( $hero['img'] ) || !empty( $hero['content'] ) || !empty( $hero['video'] ) ) { echo 'margin-bottom'; } ?>" style="<?php if ( !empty( $hero['img'] ) ) { echo 'background-image: url(' . $hero['img'][0] . ')'; } ?>">
					<div class="container <?php if ( !empty( $hero['content'] ) && !empty( $hero['video'] ) ) { echo 'container-large'; } ?> <?php if ( !empty( $hero['img'] ) || !empty( $hero['content'] ) || !empty( $hero['video'] ) ) { echo 'padding-top padding-bottom'; } ?> <?php if ( !empty( $hero['img'] ) && empty( $hero['content'] ) && empty( $hero['video'] ) ) { echo 'padding-top-xlarge padding-bottom-xlarge'; } ?>">
						<?php
							// If there's hero content AND video
							if ( !empty( $hero['content'] ) && !empty( $hero['video'] ) ) :
						?>
							<?php
								// If video should be on the top on small viewports
								if ( $hero['video_location_small'] === 'top' ) :
							?>
								<div class="row">
									<div class="grid-half <?php if ( $hero['video_location_large'] === 'right' ) { echo 'grid-flip'; } ?>">
										<?php echo $hero['video']; ?>
									</div>
									<div class="grid-half">
										<h1 class="margin-bottom-small"><?php the_title(); ?></h1>
										<?php echo do_shortcode( $hero['content'] ); ?>
									</div>
								</div>
							<?php else : ?>
								<div class="row">
									<div class="grid-half <?php if ( $hero['video_location_large'] === 'left' ) { echo 'grid-flip'; } ?>">
										<h1><?php the_title(); ?></h1>
										<?php echo do_shortcode( $hero['content'] ); ?>
									</div>
									<div class="grid-half">
										<?php echo $hero['video']; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php
							// If there's hero content, but no video
							// OR, if there's video, but no content
							elseif ( !empty( $hero['content'] ) || !empty( $hero['video'] ) ) :
						?>
							<div class="text-center">
								<h1><?php the_title(); ?></h1>
								<?php echo do_shortcode( $hero['content'] ); ?>
								<?php echo $hero['video']; ?>
							</div>
						<?php
							// If there's no content or video
							else :
						?>
							<h1><?php the_title(); ?></h1>
						<?php endif; ?>
					</div>
				</header>
		<?php

	}