<?php

	/**
	 * Render the page hero
	 */

	// Get hero content
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
			'content'              => $is_hero && array_key_exists( 'content', $hero ) ? stripslashes( $hero['content'] ) : null,
			'image'                => $is_hero && array_key_exists( 'image', $hero ) ? $hero['image'] : null,
			'color'                => $is_hero && array_key_exists( 'color', $hero ) ? $hero['color'] : null,
			'overlay'              => $is_hero && array_key_exists( 'overlay', $hero ) ? $hero['overlay'] : null,
			'img'                  => $is_thumbnail ? wp_get_attachment_image_src( $thumbnail_id, 'full', true ) : null,
		);

	}



	// Determine if a post has a hero
	function keel_has_hero( $post_id = null ) {

		// Get the post ID
		global $post;
		$post_id = $post_id ? $post_id : $post->ID;

		// Get hero content
		$hero = keel_get_hero_content( $post_id );

		return ( empty( $hero['content'] ) && empty( $hero['image'] ) && empty( $hero['img'] ) ) ? false : true;

	}



	// Generate hero markup
	function keel_get_hero( $post_id = null ) {

		// Get the post ID
		global $post;
		$post_id = $post_id ? $post_id : $post->ID;

		// Get hero
		$hero = keel_get_hero_content( $post_id );

		// If no hero, bail
		if ( empty( $hero['content'] ) && empty( $hero['image'] ) && empty( $hero['img'] ) ) return;

		// Get hero image
		$check_image = wp_check_filetype( $hero['image'] );
		$image = ( strpos( $check_image['type'], 'image' ) === false ? wp_oembed_get( $hero['image'] ) : '<img src="' . $hero['image'] . '">' );
		$overlay = ( $hero['color'] === 'muted' ? '255, 255, 255' : '0, 0, 0' );

		?>

		<header class="bg-hero bg-<?php echo $hero['color']; ?> margin-bottom" <?php if ( !empty( $hero['img'] ) ) { echo 'style="background-image: ' . ( empty( $hero['overlay'] ) ? '' : 'linear-gradient( rgba(' . $overlay . ', 0.7), rgba(' . $overlay . ', 0.7) ),' ) . ' url(' . $hero['img'][0] . ');"'; } ?>>
					<div class="container <?php if ( !empty( $hero['content'] ) && !empty( $image ) ) { echo 'container-large'; } ?> <?php echo ( !empty( $hero['img'] ) && is_array( $hero['img'] ) && ( empty( $hero['content'] ) || empty( $image ) ) ? 'padding-top-xlarge padding-bottom-xlarge' : 'padding-top padding-bottom' ); ?>">
						<?php
							// If there's hero content AND video
							if ( !empty( $hero['content'] ) && !empty( $hero['image'] ) ) :
						?>
							<div class="row text-center">
								<div class="grid-half text-left-large">
									<h1><?php the_title(); ?></h1>
									<?php echo do_shortcode( $hero['content'] ); ?>
								</div>
								<div class="grid-half grid-flip margin-bottom">
									<?php echo $image; ?>
								</div>
							</div>
						<?php
							// If there's hero content, but no video
							// OR, if there's video, but no content
							elseif ( !empty( $hero['content'] ) || !empty( $hero['image'] ) ) :
						?>
							<div class="text-center">
								<h1><?php the_title(); ?></h1>
								<?php echo do_shortcode( $hero['content'] ); ?>
								<?php echo $image; ?>
							</div>
						<?php
							// If there's no content or video
							else :
						?>
							<h1 class="text-center"><?php the_title(); ?></h1>
						<?php endif; ?>
					</div>
				</header>
		<?php

	}