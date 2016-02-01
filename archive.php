<?php

/**
 * archive.php
 * Template for posts by category, tag, author, date, etc.
 */

get_header(); ?>


<?php if (have_posts()) : ?>

	<?php
		// Create pet listings grid
		if ( !is_post_type_archive( 'keel-pets' ) ) :
	?>
		<header>
			<h1>
				<?php if ( is_category() ) : // If this is a category archive ?>
					<?php _e( 'Category:', 'keel' ); ?> <?php single_cat_title(); ?>...
				<?php elseif( is_tag() ) : // If this is a tag archive ?>
					<?php _e( 'Tag:', 'keel' ); ?> <?php single_tag_title(); ?>...
				<?php elseif ( is_day() ) : // If this is a daily archive ?>
					<?php _e( 'Day:', 'keel' ); ?> <?php the_time('F jS, Y'); ?>...
				<?php elseif ( is_month() ) : // If this is a monthly archive ?>
					<?php _e( 'Month:', 'keel' ); ?> <?php the_time('F, Y'); ?>...
				<?php elseif ( is_year() ) : // If this is a yearly archive ?>
					<?php _e( 'Year:', 'keel' ); ?> <?php the_time('Y'); ?>...
				<?php elseif ( is_author() ) : // If this is an author archive ?>
					<?php _e( 'Author Archive', 'keel' ); ?>
				<?php elseif ( is_post_type_archive( 'keel-pets' ) ) : // If this is the Pets archive ?>
					<?php
						$options = keel_pet_listings_get_theme_options();
						if ( $options ) {
							_e( $options['page_title'], 'keel' );
						}
					?>
				<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : // If this is a paged archive ?>
					<?php _e( 'Blog Archive', 'keel' ); ?>
				<?php endif; ?>
			</h1>
		</header>
	<?php endif; ?>


	<section>

		<?php
			// Create pet listings grid
			if ( is_post_type_archive( 'keel-pets' ) ) :
		?>
			<?php
				$options = keel_pet_listings_get_theme_options();
				$filters = get_transient( 'keel_petfinder_api_filters' );
				$has_filters = $options['filters_animal'] === 'on' || $options['filters_breed'] === 'on' || $options['filters_age'] === 'on' || $options['filters_size'] === 'on' || $options['filters_gender'] === 'on' || $options['filters_other'] === 'on' ? true : false;
				$grid_content = $has_filters ? 'grid-three-fourths petfinder-content' : 'grid-full';
			?>
			<div class="row">
				<?php if ( $has_filters ) : ?>
					<aside class="grid-fourth">
						<div class="petfinder-filters" id="petfinder-filters">
							<span class="screen-reader">Use these checkboxes to filter the list of available animals:</span>

							<?php if ( $options['filters_animal'] === 'on' ) : ?>
								<div class="margin-bottom">
									<h2 class="no-padding-top">Animal</h2>
									<?php echo $filters['checkboxes']['animals']; ?>
								</div>
							<?php endif; ?>

							<?php if ( $options['filters_breed'] === 'on' ) : ?>
								<div class="margin-bottom">
									<h2 class="no-padding-top">Breed</h2>
									<?php echo $filters['checkboxes']['breeds']; ?>
								</div>
							<?php endif; ?>

							<?php if ( $options['filters_age'] === 'on' ) : ?>
								<div class="margin-bottom">
									<h2 class="no-padding-top">Age</h2>
									<?php echo $filters['checkboxes']['ages']; ?>
								</div>
							<?php endif; ?>

							<?php if ( $options['filters_size'] === 'on' ) : ?>
								<div class="margin-bottom">
									<h2 class="no-padding-top">Size</h2>
									<?php echo $filters['checkboxes']['sizes']; ?>
								</div>
							<?php endif; ?>

							<?php if ( $options['filters_gender'] === 'on' ) : ?>
								<div class="margin-bottom">
									<h2 class="no-padding-top">Gender</h2>
									<?php echo $filters['checkboxes']['genders']; ?>
								</div>
							<?php endif; ?>

							<?php if ( $options['filters_other'] === 'on' ) : ?>
								<div class="margin-bottom">
									<h2 class="no-padding-top">Other Options</h2>
									<?php echo $filters['checkboxes']['options']; ?>
								</div>
							<?php endif; ?>
						</div>

						<p class="petfinder-filters-toggle"><button class="btn" data-nav-toggle="#petfinder-filters">Filter Results</button></p>
					</aside>
				<?php endif; ?>

				<div class="grid-three-fourths <?php if ( $has_filters ) { echo 'petfinder-content'; } ?> <?php if ( !$has_filters ) { echo 'float-center'; } ?>">

					<header>
						<h1>
							<?php
								$options = keel_pet_listings_get_theme_options();
								if ( $options ) {
									_e( esc_attr( $options['page_title'], 'keel' ) );
								}
							?>
						</h1>
					</header>

					<?php echo stripslashes( $options['page_content'] ); ?>

					<div class="row" data-right-height>
		<?php endif; ?>

					<?php
						// Start the loop
						while (have_posts()) : the_post();
					?>
						<?php
							// Insert the post content
							get_template_part( 'content', get_post_type() );
						?>
					<?php endwhile; ?>

		<?php
			// End pet listings grid
			if ( is_post_type_archive( 'keel-pets' ) ) :
		?>
					</div>
				</div>
			</div>
		<?php endif; ?>

	</section>


	<?php
		// Previous/next page navigation
		get_template_part( 'nav', 'page' );
	?>


<?php else : ?>
	<?php
		// If no content, include the "No post found" template
		get_template_part( 'content', 'none' );
	?>
<?php endif; ?>


<?php get_footer(); ?>