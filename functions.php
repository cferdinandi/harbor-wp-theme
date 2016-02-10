<?php

/**
 * functions.php
 * For modifying and expanding core WordPress functionality.
 */


	/**
	 * Developer Features
	 * Set to false to deactive a feature.
	 */
	function keel_developer_options() {
		return array(
			'fonts' => true,
			'social' => true,
			'footer' => true,
			'pets' => true,
			'paypal' => true,
			'events' => true,
			'gallery' => true,
			'hero' => true,
			'page_width' => false,
			'custom_logo' => true,
			'button_shortcode' => true,
			'svg_shortcode' => true,
			'asm_forms_shortcode' => true,
			'theme_support' => true,
		);
	}



	/**
	 * Load theme files
	 */
	function keel_load_theme_files() {
		$keel_theme = wp_get_theme();
		wp_enqueue_style( 'keel-theme-styles', get_template_directory_uri() . '/dist/css/main.min.' . $keel_theme->get( 'Version' ) . '.css', null, null, 'all' );
		// wp_enqueue_style( 'keel-theme-styles', get_template_directory_uri() . '/dist/css/main.css', null, null, 'all' );
	}
	add_action('wp_enqueue_scripts', 'keel_load_theme_files');



	/**
	 * Load inline header content
	 */
	function keel_load_inline_header() {
		$keel_theme = wp_get_theme();
		$options = keel_get_theme_options();
		?>
			<script>
				<?php echo file_get_contents( get_template_directory_uri() . '/dist/js/detects.min.' . $keel_theme->get( 'Version' ) . '.js' ); ?>
				<?php // echo file_get_contents( get_template_directory_uri() . '/dist/js/detects.js' ); ?>
				<?php if ( $options['typeface'] === 'open_sans' ) : ?>
					loadCSS( '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' );
				<?php elseif ( $options['typeface'] === 'source_sans_pro' ) : ?>
					loadCSS( '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700' );
				<?php elseif ( $options['typeface'] === 'lora' ) : ?>
					loadCSS( '//fonts.googleapis.com/css?family=Lora:400,400italic,700' );
				<?php elseif ( $options['typeface'] === 'droid_serif' ) : ?>
					loadCSS( '//fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700' );
				<?php endif; ?>
			</script>
		<?php
	}
	add_action('wp_head', 'keel_load_inline_header', 30);



	/**
	 * Load inline footer content
	 */
	function keel_load_inline_footer() {
		$keel_theme = wp_get_theme();
		?>
			<script>
				<?php echo file_get_contents( get_template_directory_uri() . '/dist/js/loadJS.min.' . $keel_theme->get( 'Version' ) . '.js' ); ?>
				if ( 'querySelector' in document && 'addEventListener' in window ) {
					loadJS('<?php echo get_template_directory_uri() . "/dist/js/main.min." . $keel_theme->get( "Version" ) . ".js"; ?>');
					// loadJS('<?php echo get_template_directory_uri() . "/dist/js/main.js"; ?>');

					// Load Pet scripts
					if ( document.querySelectorAll( '[data-petfinder-sort="breeds"], [data-petfinder-sort="attributes"], [data-petfinder-sort="toggle"]' ).length > 0 ) {
							loadJS('<?php echo get_template_directory_uri() . "/dist/js/petfinder-api.min." . $keel_theme->get( "Version" ) . ".js"; ?>');
							// loadJS('<?php echo get_template_directory_uri() . "/dist/js/petfinder-api.js"; ?>');
					}

					// Load PhotoSwipe scripts
					if ( document.querySelector( '[data-photoswipe]' ) ) {
						loadJS('<?php echo get_template_directory_uri() . "/dist/js/photoswipe.min." . $keel_theme->get( "Version" ) . ".js"; ?>');
						// loadJS('<?php echo get_template_directory_uri() . "/dist/js/photoswipe.js"; ?>');
					}

				}
			</script>
		<?php
	}
	add_action('wp_footer', 'keel_load_inline_footer', 30);



	/**
	 * Add a shortcode for the search form
	 * @return string Markup for search form
	 */
	function keel_wpsearch() {
		return get_search_form();
	}
	add_shortcode( 'searchform', 'keel_wpsearch' );



	/**
	 * Replace the default password-protected post messaging with custom language
	 * @return string Custom language
	 */
	function keel_post_password_form() {
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$form =
			'<form class="text-center" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post"><p>' . __( 'This is a password protected post.', 'keel' ) . '</p><label class="screen-reader" for="' . $label . '">' . __( 'Password', 'keel' ) . '</label><input id="' . $label . '" name="post_password" type="password"><input type="submit" name="Submit" value="' . __( 'Submit', 'keel' ) . '"></form>';
		return $form;
	}
	add_filter( 'the_password_form', 'keel_post_password_form' );



	/**
	 * Customize the `wp_title` method
	 * @param  string $title The page title
	 * @param  string $sep   The separator between title and description
	 * @return string        The new page title
	 */
	function keel_pretty_wp_title( $title, $sep ) {

		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name
		$title .= get_bloginfo( 'name' );

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'keel' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'keel_pretty_wp_title', 10, 2 );



	/**
	 * Override default the_excerpt length
	 * @param  number $length Default length
	 * @return number         New length
	 */
	function keel_excerpt_length( $length ) {
		return 35;
	}
	add_filter( 'excerpt_length', 'keel_excerpt_length', 999 );



	/**
	 * Override default the_excerpt read more string
	 * @param  string $more Default read more string
	 * @return string       New read more string
	 */
	function keel_excerpt_more( $more ) {

		global $post_type;

		// If events post type
		if ( 'keel-events' === $post_type ) {
			return '...';
		}

		// Else
		return
			'... <a href="'. get_permalink( get_the_ID() ) . '">' .
			sprintf(
				__( 'Read more %s', 'keel' ),
				'<span class="screen-reader">of ' . get_the_title() . '</span>'
			) .
			'</a>';
	}
	add_filter( 'excerpt_more', 'keel_excerpt_more' );



	/**
	 * Sets max allowed content width
	 * Deliberately large to prevent pixelation from content stretching
	 * @link http://codex.wordpress.org/Content_Width
	 */
	if ( !isset( $content_width ) ) {
		$content_width = 1240;
	}



	/**
	 * Registers navigation menus for use with wp_nav_menu function
	 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
	 */
	function keel_register_menus() {
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu' ),
				'secondary' => __( 'Secondary Menu' )
			)
		);
	}
	add_action( 'init', 'keel_register_menus' );



	/**
	 * Adds support for featured post images
	 * @link http://codex.wordpress.org/Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );



	/**
	 * Disable WordPress auto-formatting
	 * Disabled by default. Uncomment add_action to enable
	 */
	function keel_remove_wpautop() {
		remove_filter('the_content', 'wpautop');
	}
	// add_action( 'pre_get_posts', 'keel_remove_wpautop' );



	/**
	 * Display all posts instead of a limited number
	 * @param  array $query The WordPress post query
	 */
	function keel_get_all_posts( $query ) {
		$query->set( 'posts_per_page', '-1' );
	}
	// add_action( 'pre_get_posts', 'keel_get_all_posts' );



	/**
	 * Custom comment callback for wp_list_comments used in comments.php
	 * @param  object $comment The comment
	 * @param  object $args Comment settings
	 * @param  integer $depth How deep to nest comments
	 * @return string Comment markup
	 * @link http://codex.wordpress.org/Function_Reference/wp_list_comments
	 */
	function keel_comment_layout($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' === $args['style'] ) {
			$tag = 'div';
		} else {
			$tag = 'li';
		}
	?>

		<<?php echo $tag ?> <?php if ( $depth > 1 ) { echo 'class="comment-nested"'; } ?> id="comment-<?php comment_ID() ?>">

			<hr>

			<article>

				<?php if ($comment->comment_approved == '0') : // If the comment is held for moderation ?>
					<p><em><?php _e( 'Your comment is being held for moderation.', 'keel' ) ?></em></p>
				<?php endif; ?>

				<header class="clearfix margin-bottom-small">
					<figure>
						<?php if ( $args['avatar_size'] !== 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</figure>
					<h3 class="no-padding-top no-margin-bottom">
						<?php comment_author_link() ?>
					</h3>
					<aside class="text-muted">
						<time datetime="<?php comment_date( 'Y-m-d' ); ?>" pubdate><?php comment_date('F jS, Y') ?></time>
						<?php edit_comment_link('Edit', ' / ', ''); ?>
					</aside>
				</header>

				<?php comment_text(); ?>
				<?php
					/**
					 * Add inline reply link.
					 * Only displays if nested comments are enabled.
					 */
					comment_reply_link( array_merge(
						$args,
						array(
							'add_below' => 'comment',
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'before' => '<p>',
							'after' => '</p>'
						)
					) );
				?>

			</article>

	<?php
	}



	/**
	 * Custom implementation of comment_form
	 * @return string Markup for comment form
	 */
	function keel_comment_form() {

		$commenter = wp_get_current_commenter();
		global $user_identity;

		$must_log_in =
			'<p>' .
				sprintf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
					wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				) .
			'</p>';

		$logged_in_as =
			'<p>' .
				sprintf(
					__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s">Log out.</a>' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				) .
			'</p>';

		$notes_before = '';
		$notes_after = '';

		$field_author =
			'<div>' .
				'<label for="author"><strong>' . __( 'Name' ) . '</strong></label>' .
				'<input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" required>' .
			'</div>';

		$field_email =
			'<div>' .
				'<label for="email"><strong>' . __( 'Email' ) . '</strong></label>' .
				'<input type="email" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required>' .
			'</div>';

		$field_url =
			'<div>' .
				'<label for="url"><strong>' . __( 'Website (optional)' ) . '</strong></label>' .
				'<input type="url" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '">' .
			'</div>';

		$field_comment =
			'<div>' .
				'<label for="comment"><strong>' . __( 'Comment' ) . '</strong></label>' .
				'<textarea name="comment" id="comment" required></textarea>' .
			'</div>';

		$args = array(
			'title_reply' => __( 'Leave a Comment' ),
			'title_reply_to' => __( 'Reply to %s' ),
			'cancel_reply_link' => __( '[Cancel]' ),
			'label_submit' => __( 'Submit Comment' ),
			'comment_field' => $field_comment,
			'must_log_in' => $must_log_in,
			'logged_in_as' => $logged_in_as,
			'comment_notes_before' => $notes_before,
			'comment_notes_after' => $notes_after,
			'fields' => apply_filters(
				'comment_form_default_fields',
				array(
					'author' => $field_author,
					'email' => $field_email,
					'url' => $field_url
				)
			),
		);

		return comment_form( $args );

	}



	/**
	 * Add script for threaded comments if enabled
	 */
	if ( is_single() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script( 'comment-reply' );
	}



	/**
	 * Deregister JetPack's devicepx.js script
	 */
	function keel_dequeue_devicepx() {
		wp_dequeue_script( 'devicepx' );
	}
	add_action( 'wp_enqueue_scripts', 'keel_dequeue_devicepx', 20 );



	/**
	 * Remove Jetpack front-end styles
	 * @workaround
	 * @todo Remove once Jetpack glitch fixed
	 */
	add_filter( 'jetpack_implode_frontend_css', '__return_false' );



	/**
	 * Declare WooCommerce support
	 */
	function keel_woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'keel_woocommerce_support' );



	/**
	 * Optimize WooCommerce Scripts
	 * Remove WooCommerce Generator tag, styles, and scripts from non-WooCommerce pages.
	 * @link https://gist.github.com/DevinWalker/7621777
	 */
	function keel_optimize_woocommerce_scripts_and_styles() {

		//remove generator meta tag
		remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

		//first check that woo exists to prevent fatal errors
		if ( function_exists( 'is_woocommerce' ) ) {
			//dequeue scripts and styles
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce_frontend_styles' );
				wp_dequeue_style( 'woocommerce_fancybox_styles' );
				wp_dequeue_style( 'woocommerce_chosen_styles' );
				wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
				wp_dequeue_script( 'wc_price_slider' );
				wp_dequeue_script( 'wc-single-product' );
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'wc-checkout' );
				wp_dequeue_script( 'wc-add-to-cart-variation' );
				wp_dequeue_script( 'wc-single-product' );
				wp_dequeue_script( 'wc-cart' );
				wp_dequeue_script( 'wc-chosen' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'prettyPhoto' );
				wp_dequeue_script( 'prettyPhoto-init' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
				wp_dequeue_script( 'fancybox' );
				wp_dequeue_script( 'jqueryui' );
			}
		}

	}
	add_action( 'wp_enqueue_scripts', 'keel_optimize_woocommerce_scripts_and_styles', 99 );



	/**
	 * Remove empty paragraphs created by wpautop()
	 * @author Ryan Hamilton
	 * @link https://gist.github.com/Fantikerz/5557617
	 */
	function keel_remove_empty_p( $content ) {
		$content = force_balance_tags( $content );
		$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
		$content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
		return $content;
	}
	add_filter('the_content', 'keel_remove_empty_p', 20, 1);



	/**
	 * Allow new content types in posts
	 */
	$allowedposttags['svg']['xmlns'] = true;
	$allowedposttags['svg']['class'] = true;
	$allowedposttags['svg']['id'] = true;
	$allowedposttags['svg']['viewbox'] = true;
	$allowedposttags['path']['d'] = true;



	/**
	 * Allow SVGs in the Media Uploader
	 */
	function keel_allow_svg_mime_type( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'keel_allow_svg_mime_type' );



	/**
	 * Unlink images by default
	 */
	function keel_update_image_default_link_type() {
		update_option( 'image_default_link_type', 'none' );
	}
	add_action( 'admin_init', 'keel_update_image_default_link_type' );



	/**
	 * Get number of comments (without trackbacks or pings)
	 * @return integer Number of comments
	 */
	function keel_just_comments_count() {
		global $post;
		return count( get_comments( array( 'type' => 'comment', 'post_id' => $post->ID ) ) );
	}



	/**
	 * Get number of trackbacks
	 * @return integer Number of trackbacks
	 */
	function keel_trackbacks_count() {
		global $post;
		return count( get_comments( array( 'type' => 'trackback', 'post_id' => $post->ID ) ) );
	}



	/**
	 * Get number of pings
	 * @return integer Number of pings
	 */
	function keel_pings_count() {
		global $post;
		return count( get_comments( array( 'type' => 'pingback', 'post_id' => $post->ID ) ) );
	}



	/**
	 * Check if more than one page of content exists
	 * @return boolean True if content is paginated
	 */
	function keel_is_paginated() {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Check if post is the last in a set
	 * @param  object  $wp_query WPQuery object
	 * @return boolean           True if is last post
	 */
	function keel_is_last_post($wp_query) {
		$post_current = $wp_query->current_post + 1;
		$post_count = $wp_query->post_count;
		if ( $post_current == $post_count ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Print a pre formatted array to the browser - useful for debugging
	 * @param array $array Array to print
	 * @author 	Keir Whitaker
	 * @link https://github.com/viewportindustries/starkers/
	 */
	function keel_print_a( $a ) {
		print( '<pre>' );
		print_r( $a );
		print( '</pre>' );
	}



	/**
	 * Pass in a path and get back the page ID
	 * @param  string $path The URL of the page
	 * @return integer Page or post ID
	 * @author Keir Whitaker
	 * @link https://github.com/viewportindustries/starkers/
	 */
	function keel_get_page_id_from_path( $path ) {
		$page = get_page_by_path( $path );
		if( $page ) {
			return $page->ID;
		} else {
			return null;
		};
	}


	/**
	 * Load includes
	 */
	require_once( dirname( __FILE__) . '/includes/keel-options/keel-theme-options.php' ); // Theme options
	require_once( dirname( __FILE__) . '/includes/keel-options/keel-post-options.php' ); // Post options
	require_once( dirname( __FILE__) . '/includes/keel-custom-logo.php' ); // Custom logo
	require_once( dirname( __FILE__) . '/includes/keel-page-hero/keel-page-hero.php' ); // Page hero settings
	require_once( dirname( __FILE__) . '/includes/keel-paypal-donations/keel-paypal-donations.php' ); // Paypal donations
	require_once( dirname( __FILE__) . '/includes/keel-pet-listings/keel-pet-listings.php' ); // Pet listings
	require_once( dirname( __FILE__) . '/includes/keel-events/keel-events.php' ); // Events
	require_once( dirname( __FILE__) . '/includes/keel-photoswipe/keel-photoswipe.php' ); // PhotoSwipe.js image galleries
	require_once( dirname( __FILE__) . '/includes/keel-shortcodes/keel-button-shortcode.php' ); // Button links shortcode
	require_once( dirname( __FILE__) . '/includes/keel-shortcodes/keel-svg-shortcode.php' ); // Inline SVG shortcode
	require_once( dirname( __FILE__) . '/includes/keel-shortcodes/keel-animal-shelter-manager-forms-shortcode.php' ); // ASM forms shortcode
	require_once( dirname( __FILE__) . '/includes/keel-set-page-width.php' ); // Custom page widths
	require_once( dirname( __FILE__) . '/includes/keel-options/keel-theme-support.php' ); // Theme support