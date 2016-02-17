<?php

/**
 * content-keel-events.php
 * Template for "events" custom post type content.
 */

?>

<?php
	// Variables
	$options = keel_events_get_theme_options(); // Events options
	$start_date = get_post_meta( $post->ID, 'keel_events_start_date', true ); // Event start date
	$end_date = get_post_meta( $post->ID, 'keel_events_end_date', true ); // Event end date
	$details = get_post_meta( $post->ID, 'keel_events_details', true ); // Details for this event

	// Checks
	$has_start_date = !empty( $start_date );
	$has_start_time = !empty( $details['time_start_hour'] ) && !empty( $details['time_start_minutes'] ) && !empty( $details['time_start_ampm'] );
	$has_end_date = !empty( $end_date );
	$has_end_time = !empty( $details['time_end_hour'] ) && !empty( $details['time_end_minutes'] ) && !empty( $details['time_end_ampm'] );
	$upcoming_event = $has_end_date ? $end_date >= strtotime( 'today', current_time( 'timestamp' ) ) : $start_date >= strtotime( 'today', current_time( 'timestamp' ) );
	$has_location = !empty( $details['location_venue'] ) || !empty( $details['location_address'] ) || !empty( $details['location_city'] ) || !empty( $details['location_state'] );
	$has_registration = !empty( $details['register_url'] );
	$show_google_calendar = !array_key_exists( 'hide_google_calendar', $details ) && $options['hide_google_calendar'] !== 'on';
	$show_ical_invite = !array_key_exists( 'hide_ical_invite', $details ) && $options['hide_ical_invite'] !== 'on';
	$show_google_maps = !array_key_exists( 'hide_google_maps', $details ) && $options['hide_google_maps'] !== 'on';

	// Strings
	$google_map =
		( empty( $details['location_address'] ) && !empty( $details['location_venue'] ) ? $details['location_venue'] . '+' : '' ) .
		( !empty( $details['location_address'] ) ? $details['location_address'] . '+' : '' ).
		( !empty( $details['location_city'] ) ? $details['location_city'] . '+' : '' ) .
		( !empty( $details['location_state'] ) ? $details['location_state'] . '+' : '' ) .
		$details['location_country'];
	$calendar_timezone = ( empty( $details['date_timezone'] ) ? get_option('timezone_string') : $details['date_timezone'] );
	$calendar_timestamp_start = keel_events_string_to_calendar( $start_date, $details['time_start_hour'], $details['time_start_minutes'], $details['time_start_ampm'], $calendar_timezone );
	$calendar_timestamp_end = ( $has_end_date && $has_end_time ? keel_events_string_to_calendar( $end_date, $details['time_end_hour'], $details['time_end_minutes'], $details['time_end_ampm'], $calendar_timezone ) : keel_events_string_to_calendar( $start_date, $details['time_start_hour'], $details['time_start_minutes'], $details['time_start_ampm'], $calendar_timezone, 3600 ) );
	$calendar_location =
		( empty( $details['location_address'] ) && !empty( $details['location_venue'] ) ? $details['location_venue'] . ', ' : '' ) .
		( !empty( $details['location_address'] ) ? $details['location_address'] . ', ' : '' ).
		( !empty( $details['location_city'] ) ? $details['location_city'] . ', ' : '' ) .
		( !empty( $details['location_state'] ) ? $details['location_state'] . ' ' : '' ) .
		( !empty( $details['location_zip'] ) ? $details['location_zip'] . ' ' : '' ) .
		$details['location_country'];
?>



<?php
	/**
	 * Individual Events
	 */
	if ( is_single() ) :
?>

	<article class="container">

		<header>
			<h1><?php the_title(); ?></h1>
		</header>

		<aside class="row">
			<div class="grid-half">
				<p>
					<?php if ( $has_start_date ) : ?>
						<?php echo esc_html( date( 'l, F j, Y', $start_date ) ); ?>
						<?php if ( $has_end_date && $end_date !== $start_date ) : ?>
							&ndash;<br><?php echo esc_html( date( 'l, F j, Y', $end_date ) ); ?>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $has_start_date && $has_start_time ) : ?>
						<br>
					<?php endif; ?>

					<?php if ( $has_start_time ) : ?>
						<?php echo esc_html( $details['time_start_hour'] . ':' . $details['time_start_minutes'] . ' ' . $details['time_start_ampm'] ); ?>
						<?php if ( $has_end_time ) : ?>
							&ndash; <?php echo esc_html( $details['time_end_hour'] . ':' . $details['time_end_minutes'] . ' ' . $details['time_end_ampm'] ); ?>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( ( $has_start_date || $has_start_time ) && $has_location ) : ?>
						<br>
					<?php endif; ?>

					<?php if ( !empty( $details['location_venue'] ) && !empty( $details['location_venue_url'] ) ) : ?><a href="<?php echo esc_url( $details['location_venue_url'] ); ?>"><?php endif; ?><?php echo esc_html( $details['location_venue'] ); ?><?php if ( !empty( $details['location_venue'] ) && !empty( $details['location_venue_url'] ) ) : ?></a><?php endif; ?><?php if ( !empty( $details['location_venue'] ) && ( !empty( $details['location_city'] ) || !empty( $details['location_state'] ) ) ) : ?>,<?php endif; ?> <?php echo esc_html( $details['location_city'] ); ?><?php if ( !empty( $details['location_city'] ) && !empty( $details['location_state'] ) ) : ?>,<?php endif; ?> <?php echo esc_html( $details['location_state'] ); ?>
				</p>
			</div>
			<div class="grid-half">
				<?php if ( $upcoming_event ) : ?>
					<?php if ( $has_registration || $show_google_calendar || $show_ical_invite ) : ?>
						<p>
							<?php if ( $has_registration ) : ?>
								<a class="btn" href="<?php echo esc_url( $details['register_url'] ); ?>">
									<?php echo esc_html( empty( $details['register_text'] ) ? $options['labels_register'] : $details['register_text'] ); ?>
								</a>
							<?php endif; ?>

							<?php if ( $has_registration && ( $show_google_calendar || $show_ical_invite ) ) : ?>
								<br>
							<?php endif; ?>

							<?php if ( $show_google_calendar ) : ?>
								<a target="blank" rel="nofollow" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php the_title(); ?>&dates=<?php echo esc_attr( $calendar_timestamp_start ); ?>/<?php echo esc_attr( $calendar_timestamp_end ); ?>&ctz=<?php echo esc_attr( $calendar_timezone ); ?>&details=<?php the_permalink(); ?>&location=<?php echo esc_attr( $calendar_location ); ?>&trp=false&sprop=website:<?php echo site_url(); ?>">+ <?php _e( 'Google Calendar', 'keel' ); ?></a>
							<?php endif; ?>

							<?php if ( $show_google_calendar && $show_ical_invite ) : ?>
								<br>
							<?php endif; ?>

							<?php if ( $show_ical_invite ) : ?>
								<a target="blank" rel="nofollow"  href="<?php the_permalink(); ?>?ical=<?php echo esc_attr( $post->ID ); ?>">+ <?php _e( 'iCal Invite', 'keel' ); ?></a>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				<?php else : ?>
					<p><em><?php _e( 'This event has ended.', 'keel' ); ?></em></p>
				<?php endif; ?>
			</div>
		</aside>

		<?php the_content(); ?>

		<?php if ( $show_google_maps && $has_location ) : ?>
			<aside class="margin-bottom">
				<iframe width="640" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo esc_attr( $google_map ); ?>&output=embed"></iframe>
			</aside>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' ); ?>

	</article>

<?php
	/**
	 * All Events Page
	 */
	else :
?>

	<article>

		<a class="link-block" href="<?php the_permalink(); ?>">
			<header>
				<h2 class="h1 link-block-styled no-margin-bottom"><?php the_title(); ?></h2>
			</header>

			<aside class="margin-bottom-small">
				<?php if ( $has_start_date ) : ?>
					<?php echo esc_html( date( 'D, M j, Y', $start_date ) ); ?> <?php if ( $has_start_time ) : ?><?php _e( 'at', 'keel' ); ?> <?php echo esc_html( $details['time_start_hour'] . ':' . $details['time_start_minutes'] . ' ' . $details['time_start_ampm'] ); ?><?php endif; ?>
				<?php endif; ?>
				<?php if ( $has_start_date && $has_end_date && $end_date !== $start_date ) : ?>
					&ndash; <?php echo esc_html( date( 'D, M j, Y', $end_date ) ); ?> <?php if ( $has_end_time ) : ?><?php _e( 'at', 'keel' ); ?> <?php echo esc_html( $details['time_end_hour'] . ':' . $details['time_end_minutes'] . ' ' . $details['time_end_ampm'] ); ?><?php endif; ?>
				<?php endif; ?>
				<?php if ( $has_start_time && $has_location ) : ?>
					<br>
				<?php endif; ?>
				<?php echo esc_html( $details['location_venue'] ); ?><?php if ( !empty( $details['location_venue'] ) && ( !empty( $details['location_city'] ) || !empty( $details['location_state'] ) ) ) : ?>,<?php endif; ?> <?php echo esc_html( $details['location_city'] ); ?><?php if ( !empty( $details['location_city'] ) && !empty( $details['location_state'] ) ) : ?>,<?php endif; ?> <?php echo esc_html( $details['location_state'] ); ?>
			</aside>

			<div class="text-muted">
				<?php the_excerpt(); ?>
			</div>
		</a>
		<?php edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' ); ?>

		<?php
			// If this is not the last post on the page, insert a divider
			if ( !keel_is_last_post($wp_query) ) :
		?>
		    <hr>
		<?php endif; ?>

	</article>

<?php endif; ?>