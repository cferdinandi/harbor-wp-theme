<?php

/**
 * no-posts.php
 * Template for when no posts are found.
 */

?>

<article class="<?php if ( is_singular() ) { echo 'container'; } ?>">
	<header>
		<?php if ( is_post_type_archive( 'keel-pets' ) ) : ?>
			<h1><?php _e( 'Sorry, but we don\'t have any available pets at the moment.', 'keel' ) ?></h1>
		<?php elseif ( is_singular( 'keel-pets' ) ) : ?>
			<h1><?php _e( 'Sorry, but this pet is no longer available.', 'keel' ) ?></h1>
		<?php elseif ( is_post_type_archive( 'keel-events' ) ) : ?>
			<h1><?php _e( 'Sorry, but we don\'t have any events at the moment.', 'keel' ) ?></h1>
		<?php elseif ( is_singular( 'keel-events' ) ) : ?>
			<h1><?php _e( 'Sorry, this event is no longer available.', 'keel' ) ?></h1>
		<?php else : ?>
			<h1><?php _e( 'No posts to display', 'keel' ) ?></h1>
		<?php endif; ?>
	</header>
</article>