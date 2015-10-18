<?php

/**
 * content-pets.php
 * Template for "pets" custom post type content.
 */

?>

<?php
	// Get pet details
	$details = get_post_meta( $post->ID, 'keel_petfinder_api_pet_details', true );
?>

<?php
	/**
	 * Individual Pet Listings
	 */
	if ( is_single() ) :
?>

	<article class="container">

		<header>
			<h1 class="no-margin-bottom"><?php the_title(); ?></h1>
			<aside><p><a href="<?php echo get_post_type_archive_link( 'pets' ); ?>">&larr; <?php _e( 'Back to All Pets', 'keel' ); ?></a></p></aside>
		</header>

		<?php
			// The page or post content
			the_content( '<p>' . __( 'Read More...', 'keel' ) . '</p>' );
		?>

	</article>

<?php
	/**
	 * All Pets Page
	 */
	else :
?>

	<article class="grid-dynamic text-center <?php echo $details['classes']; ?>" data-right-height-content>

		<header>
			<a href="<?php the_permalink(); ?>">
				<figure><img class="img-photo img-limit-height" src="<?php echo $details['photos']['medium'][0]; ?>"></figure>
				<h1 class="h3 no-padding-top no-margin-bottom"><?php the_title(); ?></h1>
			</a>
		</header>
		<aside class="text-small">
			<p>
				<?php echo $details['size']; ?>, <?php echo $details['age']; ?>, <?php echo $details['gender']; ?><br>
				<span class="text-muted"><?php echo $details['breeds']; ?></span>
				<?php
					if ( !empty( $details['options']['multi'] ) ) {
						echo '<br><em class="text-muted">' . $details['options']['multi'] . '</em>';
					}
				?>
				<?php
					if ( !empty( $details['options']['special_needs'] ) ) {
						echo '<br><em class="text-muted">' . $details['options']['special_needs'] . '</em>';
					}
				?>
			</p>
		</aside>

	</article>

<?php endif; ?>