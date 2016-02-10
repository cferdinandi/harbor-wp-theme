<?php

/**
 * woocommerce.php
 * Template for WooCommerce content.
 */

get_header(); ?>

<article <?php if ( is_single() ) { echo 'class="container"'; } ?>>

	<?php
		// WooCommerce custom loop
		woocommerce_content();
	?>

	<?php
		// Add link to edit pages
		edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
	?>

</article>

<?php get_footer(); ?>