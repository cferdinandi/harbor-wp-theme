<?php

/**
 * content.php
 * Template for post content.
 */

?>

<article class="<?php if ( is_singular() ) { echo 'container'; } ?>">

	<header>
		<?php
			/**
			 * Headers
			 * Unlinked h1 for invidual blog posts. Linked h1 for collections of posts.
			 */
		?>
		<?php if ( is_single() ) : ?>
			<h1 class="no-margin-bottom"><?php the_title(); ?></h1>
		<?php else : ?>
			<h1 class="<?php if ( get_post_type() !== 'pets' ) { echo 'no-margin-bottom'; } ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php endif; ?>

		<?php if ( get_post_type() !== 'pets' ) : ?>
			<aside class="text-muted">
				<p>
					<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_time( 'F j, Y' ) ?></time> by <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author(); ?> </a>/
					<a href="<?php comments_link(); ?>">
						<?php comments_number( __( 'Comment', 'keel' ), __( '1 Comment', 'keel' ), __( '% Comments', 'keel' ) ); ?>
					</a>
					<?php edit_post_link( __( 'Edit', 'keel' ), ' / ', '' ); ?>
				</p>
			</aside>
		<?php endif; ?>
	</header>

	<?php
		// The page or post content
		the_content( '<p>' . __( 'Read More...', 'keel' ) . '</p>' );
	?>


	<?php if ( is_single() ) : ?>

		<?php
			// Add call-to-action after individual blog posts
			$options = keel_get_theme_options();
			if ( !empty( $options['blog_cta'] ) ) :
		?>
			<div class="padding-top padding-bottom">
				<?php echo stripslashes( $options['blog_cta'] ); ?>
			</div>
		<?php endif; ?>

		<?php
			// Add comments template to blog posts
			comments_template();
		?>
	<?php endif; ?>

	<?php
		// If this is not the last post on the page, insert a divider
		if ( !keel_is_last_post($wp_query) ) :
	?>
	    <hr>
	<?php endif; ?>

</article>