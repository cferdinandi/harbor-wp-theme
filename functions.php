<?php

/**
 * functions.php
 * For modifying and expanding core WordPress functionality.
 */


	/**
	 * Load theme files.
	 */
	function keel_load_theme_files() {
		$keel_theme = wp_get_theme();
		// wp_enqueue_style( 'keel-theme-styles', get_template_directory_uri() . '/dist/css/main.min.' . $keel_theme->get( 'Version' ) . '.css', null, null, 'all' );
		wp_enqueue_style( 'keel-theme-styles', get_template_directory_uri() . '/dist/css/main.css', null, null, 'all' );
	}
	add_action('wp_enqueue_scripts', 'keel_load_theme_files');



	/**
	 * Include feature detection scripts inline in the header
	 */
	function keel_initialize_theme_detects() {
		$keel_theme = wp_get_theme();
		$options = keel_get_theme_options();
		?>
			<script>
				<?php //echo file_get_contents( get_template_directory_uri() . '/dist/js/detects.min.' . $keel_theme->get( 'Version' ) . '.js' ); ?>
				<?php echo file_get_contents( get_template_directory_uri() . '/dist/js/detects.js' ); ?>
				document.createElement( 'picture' );
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
	add_action('wp_head', 'keel_initialize_theme_detects', 30);



	/**
	 * Include script inits inline in the footer
	 */
	function keel_initialize_theme_scripts() {
		$keel_theme = wp_get_theme();
		?>
			<script>
				<?php //echo file_get_contents( get_template_directory_uri() . '/dist/js/loadJS.min.' . $keel_theme->get( 'Version' ) . '.js' ); ?>
				<?php echo file_get_contents( get_template_directory_uri() . '/dist/js/loadJS.js' ); ?>
				if ( 'querySelector' in document && 'addEventListener' in window ) {
					// loadJS('<?php echo get_template_directory_uri() . "/dist/js/main.min." . $keel_theme->get( "Version" ) . ".js"; ?>');
					loadJS('<?php echo get_template_directory_uri() . "/dist/js/main.js"; ?>');
					<?php if ( is_post_type_archive( 'pets' ) || is_singular( 'pets' ) ) : ?>
						// loadJS('<?php echo get_template_directory_uri() . "/dist/js/petfinder-api.min." . $keel_theme->get( "Version" ) . ".js"; ?>');
						loadJS('<?php echo get_template_directory_uri() . "/dist/js/petfinder-api.js"; ?>');
					<?php endif; ?>
				}
			</script>
		<?php
	}
	add_action('wp_footer', 'keel_initialize_theme_scripts', 30);



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
		return '... <a href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'keel') . '</a>';
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
	 * Add submenu-only display option to wp_nav_menu()
	 * @link http://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
	 */
	function keel_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
		if ( isset( $args->sub_menu ) ) {
			$root_id = 0;

			// find the current menu item
			foreach ( $sorted_menu_items as $menu_item ) {
				if ( $menu_item->current ) {
					// set the root id based on whether the current menu item has a parent or not
					$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
					break;
				}
			}

			// find the top level parent
			if ( ! isset( $args->direct_parent ) ) {
				$prev_root_id = $root_id;
				while ( $prev_root_id != 0 ) {
					foreach ( $sorted_menu_items as $menu_item ) {
						if ( $menu_item->ID == $prev_root_id ) {
							$prev_root_id = $menu_item->menu_item_parent;
							// don't set the root_id to 0 if we've reached the top of the menu
							if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
							break;
						}
					}
				}
			}
			$menu_item_parents = array();
			foreach ( $sorted_menu_items as $key => $item ) {
				// init menu_item_parents
				if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
				if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
					// part of sub-tree: keep!
					$menu_item_parents[] = $item->ID;
				} else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
					// not part of sub-tree: away with it!
					unset( $sorted_menu_items[$key] );
				}
			}

			return $sorted_menu_items;
		} else {
			return $sorted_menu_items;
		}
	}
	add_filter( 'wp_nav_menu_objects', 'keel_wp_nav_menu_objects_sub_menu', 10, 2 );



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
	 * Deregister picturefill.js (loaded already in main.js)
	 */
	function keel_dequeue_picturefill() {
		wp_dequeue_script( 'picturefill' );
	}
	add_action( 'wp_enqueue_scripts', 'keel_dequeue_picturefill', 20 );



	/**
	 * Remove Jetpack front-end styles
	 * @workaround
	 * @todo Remove once Jetpack glitch fixed
	 */
	add_filter( 'jetpack_implode_frontend_css', '__return_false' );



	/**
	 * Fix Chrome Admin bug
	 * @workaround
	 * @link http://wordpress.stackexchange.com/questions/200096/admin-sidebar-items-overlapping-in-admin-panel
	 * @todo Remove once WP update fixes
	 */
	function keel_chrome_fix() {
		if ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Chrome' ) !== false ) {
			wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0) }' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'keel_chrome_fix' );



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

	// Developer Options
	function keel_developer_options() {
		return array(
			'photoswipe_options' => false,
		);
	}

	// Theme options
	require_once( dirname( __FILE__) . '/includes/keel-theme-options.php' );

	// Custom logo
	require_once( dirname( __FILE__) . '/includes/keel-custom-logo.php' );

	// Page width settings
	// require_once( dirname( __FILE__) . '/includes/keel-set-page-width.php' );

	// Page hero settings
	require_once( dirname( __FILE__) . '/includes/keel-page-hero.php' );

	// A GUI for grid-based layouts
	// require_once( dirname( __FILE__) . '/includes/keel-grid-layouts.php' );

	// Paypal donations
	require_once( dirname( __FILE__) . '/includes/keel-paypal-donations/keel-paypal-donations.php' );

	// Petfinder API
	require_once( dirname( __FILE__) . '/includes/keel-petfinder-api/keel-petfinder-api.php' );

	// PhotoSwipe.js
	require_once( dirname( __FILE__) . '/includes/keel-photoswipe/keel-photoswipe.php' );

	// Button links shortcode
	require_once( dirname( __FILE__) . '/includes/keel-button-shortcode.php' );
