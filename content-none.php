<?php

/**
 * no-posts.php
 * Template for when no posts are found.
 */

?>

<?php
	// Get event date
	$events_date = get_query_var( 'date' );
	$events_date = empty( $events_date ) ? '' : strtolower( $events_date ) . ' ';
?>

<article class="<?php if ( is_singular() ) { echo 'container'; } ?>">
	<header>
		<h1>
			<?php if ( is_post_type_archive( 'keel-pets' ) ) : ?>
				<?php _e( 'Sorry, but we don\'t have any available pets at the moment.', 'keel' ) ?>
			<?php elseif ( is_singular( 'keel-pets' ) ) : ?>
				<?php _e( 'Sorry, but this pet is no longer available.', 'keel' ) ?>
			<?php elseif ( is_post_type_archive( 'keel-events' ) ) : ?>
				<?php printf( __( 'Sorry, but we don\'t have any %sevents at the moment.', 'keel' ), $events_date ); ?>
			<?php elseif ( is_singular( 'keel-events' ) ) : ?>
				<?php _e( 'Sorry, this event is no longer available.', 'keel' ) ?>
			<?php else : ?>
				<?php _e( 'No posts to display', 'keel' ) ?>
			<?php endif; ?>
		</h1>
	</header>
</article>