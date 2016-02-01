<?php

/**
 * content-pets.php
 * Template for "pets" custom post type content.
 */

?>

<?php
	// Variables
	$options = keel_pet_listings_get_theme_options(); // Pet Listings options
	$details = get_post_meta( $post->ID, 'keel_pet_listings_pet_details', true ); // Details for this pet
	$imgs = get_post_meta( $post->ID, 'keel_pet_listings_pet_imgs', true ); // Images for this pet
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
			<aside><p><a href="<?php echo get_post_type_archive_link( 'keel-pets' ); ?>">&larr; <?php _e( 'Back to All Pets', 'keel' ); ?></a></p></aside>
		</header>

		<?php
			// Pet images
			if ( !empty( $imgs ) ) {
				echo $imgs;
			}
		?>

		<?php
			// Key pet info
		?>
		<ul class="list-unstyled">
			<li><strong><?php _e( 'Size', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['size'] ); ?></li>
			<li><strong><?php _e( 'Age', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['age'] ); ?></li>
			<li><strong><?php _e( 'Gender', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['gender'] ); ?></li>
			<li><strong><?php _e( 'Breeds', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['breeds'] ); ?></li>
			<?php echo ( empty( $details['options']['multi'] ) ? '' : '<li><em>' . esc_attr( $details['options']['multi'] ) . '</em></li>' ); ?>
			<?php echo ( empty( $details['options']['special_needs'] ) ? '' : '<li><em>' . esc_attr( $details['options']['special_needs'] ) . '</em></li>' ); ?>
		</ul>

		<?php
			// Adoption application button
			echo ( $options['adoption_form_url'] ? '<p><a class="btn" href="' . esc_url( $options['adoption_form_url'] ) . '">' . esc_attr( $options['adoption_form_text'] ) . '</a></p>' : '' );
		?>

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