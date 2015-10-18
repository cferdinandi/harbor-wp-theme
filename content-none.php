<?php

/**
 * no-posts.php
 * Template for when no posts are found.
 */

?>

<article class="<?php if ( is_singular() ) { echo 'container'; } ?>">
	<header>
		<?php if ( is_post_type_archive( 'pets' ) ) : ?>
			<h1><?php _e( 'Sorry, but we don\'t have any available pets at the moment.', 'keel' ) ?></h1>
		<?php elseif ( is_singular( 'pets' ) ) : ?>
			<h1><?php _e( 'Sorry, but this pet is no longer available.', 'keel' ) ?></h1>
		<?php else : ?>
			<h1><?php _e( 'No posts to display', 'keel' ) ?></h1>
		<?php endif; ?>
	</header>
</article>