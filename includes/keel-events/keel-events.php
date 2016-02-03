<?php

/**
 * Add an events custom post type
 */


	// Load required files
	require_once( dirname( __FILE__) . '/keel-events-options.php' );



	/**
	 * Add the custom post type
	 */
	function keel_events_add_custom_post_type() {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['events'] ) return;

		$options = keel_events_get_theme_options();
		$labels = array(
			'name'               => _x( 'Events', 'post type general name', 'keel' ),
			'singular_name'      => _x( 'Event', 'post type singular name', 'keel' ),
			'add_new'            => _x( 'Add New', 'events', 'keel' ),
			'add_new_item'       => __( 'Add New Event', 'keel' ),
			'edit_item'          => __( 'Edit Event', 'keel' ),
			'new_item'           => __( 'New Event', 'keel' ),
			'all_items'          => __( 'All Events', 'keel' ),
			'view_item'          => __( 'View Event', 'keel' ),
			'search_items'       => __( 'Search Events', 'keel' ),
			'not_found'          => __( 'No events found', 'keel' ),
			'not_found_in_trash' => __( 'No events found in the Trash', 'keel' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Events', 'keel' ),
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our events and event-specific data',
			'public'        => true,
			// 'menu_position' => 5,
			'menu_icon'     => 'dashicons-calendar-alt',
			// 'supports'      => array(),
			'has_archive'   => true,
			'rewrite' => array(
				'slug' => $options['page_slug'],
			),
			'map_meta_cap'  => true,
		);
		register_post_type( 'keel-events', $args );
	}
	add_action( 'init', 'keel_events_add_custom_post_type' );



	/**
	 * Create the metabox
	 */
	function keel_events_create_events_metabox() {
		add_meta_box( 'keel_events_metabox', 'Event Details', 'keel_events_render_metabox', 'keel-events', 'normal', 'default');
	}
	add_action( 'add_meta_boxes', 'keel_events_create_events_metabox' );



	/**
	 * Create the metabox default values
	 */
	function keel_events_metabox_defaults() {
		return array(
			'date_start' => '',
			'time_start_hour' => '',
			'time_start_minutes' => '',
			'time_start_ampm' => '',
			'date_end' => '',
			'time_end_hour' => '',
			'time_end_minutes' => '',
			'time_end_ampm' => '',
			'date_timezone' => '',
			'location_venue' => '',
			'location_venue_url' => '',
			'location_address' => '',
			'location_city' => '',
			'location_state' => '',
			'location_zip' => '',
			'location_country' => '',
			'hide_google_calendar' => 'off',
			'hide_ical_invite' => 'off',
			'hide_google_maps' => 'off',
			'register_url' => '',
			'register_text' => '',
		);
	}



	/**
	 * Render the metabox
	 */
	function keel_events_render_metabox() {

		// Variables
		global $post;
		$options = keel_events_get_theme_options(); // Events options
		$saved = get_post_meta( $post->ID, 'keel_events_details', true );
		$defaults = keel_events_metabox_defaults();
		$details = wp_parse_args( $saved, $defaults );
		$start_date = get_post_meta( $post->ID, 'keel_events_start_date', true );
		$end_date = get_post_meta( $post->ID, 'keel_events_end_date', true );

		?>

			<h3>Date and Time</h3>

			<!-- Start Date -->
			<div>
				<label for="keel_events_date_start"><?php _e( 'Start Date', 'keel' ); ?></label>
				<input type="text" class="medium-text keel-events-datepicker" id="keel_events_date_start" name="keel_events_date_start" value="<?php echo ( empty( $start_date ) ? '' : esc_attr( date( 'm/d/Y', $start_date ) ) ); ?>" placeholder="MM/DD/YYYY">

				@

				<label class="screen-reader-text" for="keel_events_time_start_hour"><?php _e( 'Start Time Hour', 'keel' ); ?></label>
				<select id="keel_events_time_start_hour" name="keel_events[time_start_hour]">
					<option <?php selected( $details['time_start_hour'], '' ); ?> value="">HH</option>
					<?php
						foreach ( range( 1, 12 ) as $num ) :
					?>
						<option <?php selected( $details['time_start_hour'], $num ); ?> value="<?php echo esc_attr( $num ); ?>"><?php echo esc_html( $num ); ?></option>
					<?php endforeach; ?>
				</select>

				<label class="screen-reader-text" for="keel_events_time_start_minutes"><?php _e( 'Start Time Minutes', 'keel' ); ?></label>
				<select id="keel_events_time_start_minutes" name="keel_events[time_start_minutes]">
					<option <?php selected( $details['time_start_minutes'], '' ); ?> value="">MM</option>
					<option <?php selected( $details['time_start_minutes'], '00' ); ?> value="00">00</option>
					<option <?php selected( $details['time_start_minutes'], '15' ); ?> value="15">15</option>
					<option <?php selected( $details['time_start_minutes'], '30' ); ?> value="30">30</option>
					<option <?php selected( $details['time_start_minutes'], '45' ); ?> value="45">45</option>
				</select>

				<label class="screen-reader-text" for="keel_events_time_start_ampm"><?php _e( 'Start Time AM/PM', 'keel' ); ?></label>
				<select id="keel_events_time_start_ampm" name="keel_events[time_start_ampm]">
					<option <?php selected( $details['time_start_ampm'], '' ); ?> value="">am/pm</option>
					<option <?php selected( $details['time_start_ampm'], 'am' ); ?> value="am">am</option>
					<option <?php selected( $details['time_start_ampm'], 'pm' ); ?> value="pm">pm</option>
				</select>
			</div>
			<br>

			<!-- End Date -->
			<div>
				<label for="keel_events_date_end"><?php _e( 'End Date', 'keel' ); ?></label>
				<input type="text" class="medium-text keel-events-datepicker" id="keel_events_date_end" name="keel_events_date_end" value="<?php echo ( empty( $end_date ) ? '' : esc_attr( date( 'm/d/Y', $end_date ) ) ); ?>" placeholder="MM/DD/YYYY">

				@

				<label class="screen-reader-text" for="keel_events_time_end_hour"><?php _e( 'End Time Hour', 'keel' ); ?></label>
				<select id="keel_events_time_end_hour" name="keel_events[time_end_hour]">
					<option <?php selected( $details['time_end_hour'], '' ); ?> value="">HH</option>
					<?php
						foreach ( range( 1, 12 ) as $num ) :
					?>
						<option <?php selected( $details['time_end_hour'], $num ); ?> value="<?php echo esc_attr( $num ); ?>"><?php echo esc_html( $num ); ?></option>
					<?php endforeach; ?>
				</select>

				<label class="screen-reader-text" for="keel_events_time_end_minutes"><?php _e( 'End Time Minutes', 'keel' ); ?></label>
				<select id="keel_events_time_end_minutes" name="keel_events[time_end_minutes]">
					<option <?php selected( $details['time_end_minutes'], '' ); ?> value="">MM</option>
					<option <?php selected( $details['time_start_minutes'], '00' ); ?> value="00">00</option>
					<option <?php selected( $details['time_start_minutes'], '15' ); ?> value="15">15</option>
					<option <?php selected( $details['time_start_minutes'], '30' ); ?> value="30">30</option>
					<option <?php selected( $details['time_start_minutes'], '45' ); ?> value="45">45</option>
				</select>

				<label class="screen-reader-text" for="keel_events_time_end_ampm"><?php _e( 'End Time AM/PM', 'keel' ); ?></label>
				<select id="keel_events_time_end_ampm" name="keel_events[time_end_ampm]">
					<option <?php selected( $details['time_end_ampm'], '' ); ?> value="">am/pm</option>
					<option <?php selected( $details['time_end_ampm'], 'am' ); ?> value="am">am</option>
					<option <?php selected( $details['time_end_ampm'], 'pm' ); ?> value="pm">pm</option>
				</select>
			</div>
			<br>

			<!-- Timezone -->
			<div>
				<label for="keel_events_date_timezone"><?php _e( 'Timezone', 'keel' ); ?></label>
				<select id="keel_events_date_timezone" name="keel_events[date_timezone]">
					<option <?php selected( $details['date_timezone'], '' ); ?> value="">WordPress Default</option>
					<?php
						$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
						foreach ( $timezones as $timezone ) :
					?>
						<option <?php selected( $details['date_timezone'], $timezone ); ?> value="<?php echo esc_attr( $timezone ); ?>"><?php echo esc_html( $timezone ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<h3>Location</h3>

			<div>
				<label for="keel_events_location_venue"><?php _e( 'Venue', 'keel' ); ?></label>
				<input type="text" class="large-text" id="keel_events_location_venue" name="keel_events[location_venue]" value="<?php echo esc_attr( $details['location_venue'] ); ?>" placeholder="Awesome Event Location">
			</div>
			<br>

			<div>
				<label for="keel_events_location_venue_url"><?php _e( 'Venue Website', 'keel' ); ?></label>
				<input type="url" class="large-text" id="keel_events_location_venue_url" name="keel_events[location_venue_url]" value="<?php echo esc_attr( $details['location_venue_url'] ); ?>" placeholder="http://example.com">
			</div>
			<br>

			<div>
				<label for="keel_events_location_address"><?php _e( 'Address', 'keel' ); ?></label>
				<input type="text" class="large-text" id="keel_events_location_address" name="keel_events[location_address]" value="<?php echo esc_attr( $details['location_address'] ); ?>" placeholder="123 Somewhere Street">
			</div>
			<br>

			<div>
				<label for="keel_events_location_city"><?php _e( 'City', 'keel' ); ?></label>
				<input type="text" class="large-text" id="keel_events_location_city" name="keel_events[location_city]" value="<?php echo esc_attr( $details['location_city'] ); ?>" placeholder="Boston">
			</div>
			<br>

			<div>
				<label for="keel_events_location_state"><?php _e( 'State', 'keel' ); ?></label>
				<input type="text" class="large-text" id="keel_events_location_state" name="keel_events[location_state]" value="<?php echo esc_attr( $details['location_state'] ); ?>" placeholder="MA">
			</div>
			<br>

			<div>
				<label for="keel_events_location_zip"><?php _e( 'Zipcode', 'keel' ); ?></label>
				<input type="text" class="large-text" id="keel_events_location_zip" name="keel_events[location_zip]" value="<?php echo esc_attr( $details['location_zip'] ); ?>" placeholder="12345">
			</div>
			<br>

			<div>
				<label for="keel_events_"><?php _e( 'Country', 'keel' ); ?></label>
				<input type="text" class="large-text" id="keel_events_location_country" name="keel_events[location_country]" value="<?php echo esc_attr( $details['location_country'] ); ?>" placeholder="United States">
			</div>
			<br>

			<div>
				<label for="keel_events_hide_google_calendar">
					<input type="checkbox" id="keel_events_hide_google_calendar" name="keel_events[hide_google_calendar]" <?php checked( 'on', $details['hide_google_calendar'] ); ?> value="on">
					<?php _e( 'Hide Google Calendar link on just this event', 'keel' ); ?>
				</label>
				<br>
				<label for="keel_events_hide_ical_invite">
					<input type="checkbox" id="keel_events_hide_ical_invite" name="keel_events[hide_ical_invite]" <?php checked( 'on', $details['hide_ical_invite'] ); ?> value="on">
					<?php _e( 'Hide iCal invite on just this event', 'keel' ); ?>
				</label>
				<br>
				<label for="keel_events_hide_google_maps">
					<input type="checkbox" id="keel_events_hide_google_maps" name="keel_events[hide_google_maps]" <?php checked( 'on', $details['hide_google_maps'] ); ?> value="on">
					<?php _e( 'Hide Google Maps on just this event', 'keel' ); ?>
				</label>
				<br>
			</div>

			<h3>Event Registration</h3>

			<div>
				<label for="keel_events_"><?php _e( 'Registration Website', 'keel' ); ?></label>
				<input type="url" class="large-text" id="keel_events_register_url" name="keel_events[register_url]" value="<?php echo esc_attr( $details['register_url'] ); ?>" placeholder="http://example.com">
			</div>
			<br>

			<div>
				<label for="keel_events_"><?php _e( 'Registration Text', 'keel' ); ?> (<?php _e( 'default' ); ?>: <?php echo esc_html( $options['labels_register'] ); ?>)</label>
				<input type="text" class="large-text" id="keel_events_register_text" name="keel_events[register_text]" value="<?php echo esc_attr( $details['register_text'] ); ?>">
			</div>
			<br>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					// jQuery( '.keel-events-datepicker' ).datetimepicker({
					// 	startDate: new Date(),
					// 	timeFormat: 'h:mm tt',
					// 	ampm: true
					// });
					jQuery( '.keel-events-datepicker' ).datepicker();
				});
			</script>
		<?php

		// Security field
		wp_nonce_field( 'keel-events-metabox-nonce', 'keel-events-metabox-process' );

	}



	/**
	 * Save the metabox
	 * @param  Number $post_id The post ID
	 * @param  Array  $post    The post data
	 */
	function keel_events_save_metabox( $post_id, $post ) {

		if ( !isset( $_POST['keel-events-metabox-process'] ) ) return;

		// Verify data came from edit screen
		if ( !wp_verify_nonce( $_POST['keel-events-metabox-process'], 'keel-events-metabox-nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Check that events details are being passed along
		if ( !isset( $_POST['keel_events'] ) ) {
			return $post->ID;
		}

		// Sanitize all data
		$sanitized = array();
		foreach ( $_POST['keel_events'] as $key => $detail ) {
			// if ( in_array( $key, array( 'date_start', 'date_end' ) ) ) {
			// 	$sanitized[$key] = strtotime( $detail );
			// 	continue;
			// }
			$sanitized[$key] = wp_filter_nohtml_kses( $detail );
		}

		// Update data in database
		$timezone = ( empty( $details['date_timezone'] ) ? get_option('timezone_string') : $details['date_timezone'] );
		update_post_meta( $post->ID, 'keel_events_details', $sanitized );
		update_post_meta( $post->ID, 'keel_events_start_date', strtotime( $_POST['keel_events_date_start'] ) );
		update_post_meta( $post->ID, 'keel_events_end_date', strtotime( $_POST['keel_events_date_end'] ) );

	}
	add_action('save_post', 'keel_events_save_metabox', 1, 2);



	/**
	 * Load jQuery date-picker
	 */
	function keel_events_load_cpt_events_scripts() {
		global $post_type;
		if( 'keel-events' !== $post_type ) return;
		wp_enqueue_script( 'jquery-ui-datepicker' );
		// wp_enqueue_script( 'jquery-ui-timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
		wp_enqueue_style( 'jquery-ui-datepicker-style' , '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
		// wp_enqueue_style( 'jquery-ui-timepickerpicker-style' , '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css');
	}
	add_action( 'admin_enqueue_scripts', 'keel_events_load_cpt_events_scripts', 10, 1 );



	/**
	 * Exclude past or upcoming events from events query
	 * @param Array $query The database query
	 */
	function keel_events_filter_query( $query ) {

		if ( is_admin() || !isset( $query->query['post_type'] ) || $query->query['post_type'] !== 'keel-events' || !isset( $query->query['date'] )  || !$query->is_main_query() ) return $query;

		//Get original meta query
		$meta_query = $query->get('meta_query');

		// if filtering by past events
		if ( $query->query['date'] === 'past' ) {
			//Add our meta query to the original meta queries
			$meta_query[] = array(
				'relation' => 'OR',
				array(
					'key' => 'keel_events_start_date',
					'value' => strtotime( 'today', current_time( 'timestamp' ) ),
					'compare' => '<',
					'type' => 'NUMERIC',
				),
				array(
					'key' => 'keel_events_end_date',
					'value' => strtotime( 'today', current_time( 'timestamp' ) ),
					'compare' => '<',
					'type' => 'NUMERIC',
				),
			);
			$query->set( 'meta_query', $meta_query );
			$query->set('meta_key', 'keel_events_start_date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'DESC');
		}

		// If filtering by upcoming events
		if ( $query->query['date'] === 'upcoming' ) {
			//Add our meta query to the original meta queries
			$meta_query[] = array(
				'relation' => 'OR',
				array(
					'key' => 'keel_events_start_date',
					'value' => strtotime( 'today', current_time( 'timestamp' ) ),
					'compare' => '>=',
					'type' => 'NUMERIC',
				),
				array(
					'key' => 'keel_events_end_date',
					'value' => strtotime( 'today', current_time( 'timestamp' ) ),
					'compare' => '>=',
					'type' => 'NUMERIC',
				),
			);
			$query->set( 'meta_query', $meta_query );
			$query->set('meta_key', 'keel_events_start_date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'ASC');
		}

	}
	add_action( 'pre_get_posts', 'keel_events_filter_query' );



	/**
	 * Add rewrite rules
	 */
	function keel_events_add_rewrite_rules() {
		$options = keel_events_get_theme_options();
		add_rewrite_rule('^' . $options['page_slug'] . '/past/?$', 'index.php?post_type=keel-events&date=past', 'top');
		add_rewrite_rule('^' . $options['page_slug'] . '/past/page/([0-9]{1,})/?$', 'index.php?post_type=keel-events&date=past&paged=$matches[1]', 'top');
		add_rewrite_rule('^' . $options['page_slug'] . '/upcoming/?$', 'index.php?post_type=keel-events&date=upcoming', 'top');
		add_rewrite_rule('^' . $options['page_slug'] . '/upcoming/page/([0-9]{1,})/?$', 'index.php?post_type=keel-events&date=upcoming&paged=$matches[1]', 'top');
	}
	add_action( 'init', 'keel_events_add_rewrite_rules' );



	/**
	 * Add custom query variable
	 * @param  Array $vars Existing query variables
	 */
	function keel_events_events_add_query_vars( $vars ){
		$vars[] = 'date';
		$vars[] = 'ical';
		return $vars;
	}
	add_filter( 'query_vars', 'keel_events_events_add_query_vars' );



	/**
	 * Redirect "all events" page to upcoming events
	 */
	function keel_redirect_all_events_page() {

		// Only run for events
		if ( !is_post_type_archive( 'keel-events' ) ) return;

		// Variables
		$date = get_query_var( 'date' );
		$options = keel_events_get_theme_options();

		// If date specified, don't redirect
		if ( !empty( $date ) ) return;

		// Redirect to "upcoming events"
		wp_safe_redirect( site_url() . '/' . $options['page_slug'] . '/upcoming', '301' );
		exit;

	}
	add_action( 'template_redirect', 'keel_redirect_all_events_page' );



	/**
	 * Convert multiple time strings into a single timestamp
	 * @param  string $day     Day timestamp
	 * @param  string $hour    Hour
	 * @param  string $minutes Minutes
	 * @param  string $ampm    am/pm
	 * @return string          timestamp
	 */
	function keel_events_strings_to_timestamp( $day, $hour, $mins, $ampm, $timezone ) {
		$day = date( 'F j, Y', $day );
		if ( empty( $hour ) ) { $hour = '12'; }
		if ( empty( $mins ) ) { $mins = '00'; }
		if ( empty( $ampm ) ) { $ampm = 'am'; }
		return strtotime( $day . ' ' . $hour . ':' . $mins . $ampm . ' ' . $timezone );
	}


	/**
	 * Convert timestamps into calendar format
	 * @param String $timestamp The timestamp to convert
	 * @link http://stackoverflow.com/a/6589203
	 * @link https://gist.github.com/jakebellacera/635416
	 */
	function keel_events_timestamp_to_calendar( $timestamp = null ) {

	    if ( empty( $timestamp) ) {
	        $timestamp = current_time( 'timestamp' );
	    }

	    return date('Ymd\THis\Z', $timestamp);

	    $date = date( 'Ymd\TH:i:s', $timestamp );
	}



	/**
	 * Convert multiple time strings into a single timestamp
	 * @param  string $day     Day timestamp
	 * @param  string $hour    Hour
	 * @param  string $minutes Minutes
	 * @param  string $ampm    am/pm
	 * @return string          Calendar format timestamp
	 */
	function keel_events_string_to_calendar( $day, $hour, $minutes, $ampm, $timezone, $offset = 0 ) {
		$timestamp = keel_events_strings_to_timestamp( $day, $hour, $minutes, $ampm, $timezone );
		$timestamp = $timestamp + $offset;
		return keel_events_timestamp_to_calendar( $timestamp );
	}



	/**
	 * Escape strings for inclusion in a .ics file
	 * @param  String $string The string to escape
	 * @return String         The escaped string
	 * @link https://gist.github.com/jakebellacera/635416
	 */
	function keel_events_escape_string( $string ) {
		return preg_replace('/([\,;])/','\\\$1', $string);
	}



	/**
	 * Generate an .ics file on-the-fly
	 * @link https://github.com/moderntribe/the-events-calendar
	 * @license GNU https://github.com/moderntribe/the-events-calendar/blob/release/122/license.txt
	 */
	function keel_events_generate_ical_invite() {

		if ( !get_query_var( 'ical' ) ) return;

		// Variables
		$event_id = get_query_var( 'ical' );
		$event = get_post( $event_id );
		$start_date = get_post_meta( $event_id, 'keel_events_start_date', true ); // Event start date
		$end_date = get_post_meta( $event_id, 'keel_events_end_date', true ); // Event end date
		$details = get_post_meta( $event_id, 'keel_events_details', true ); // Details for this event

		// Checks
		$has_end_date = !empty( $end_date );
		$has_end_time = !empty( $details['time_end_hour'] ) && !empty( $details['time_end_minutes'] ) && !empty( $details['time_end_ampm'] );

		// Strings
		$timezone = ( empty( $details['date_timezone'] ) ? get_option('timezone_string') : $details['date_timezone'] );
		$calendar_timestamp_start = keel_events_string_to_calendar( $start_date, $details['time_start_hour'], $details['time_start_minutes'], $details['time_start_ampm'], $timezone );
		$calendar_timestamp_end = ( $has_end_date && $has_end_time ? keel_events_string_to_calendar( $end_date, $details['time_end_hour'], $details['time_end_minutes'], $details['time_end_ampm'], $timezone ) : keel_events_string_to_calendar( $start_date, $details['time_start_hour'], $details['time_start_minutes'], $details['time_start_ampm'], $timezone, 3600 ) );
		$calendar_location =
			( empty( $details['location_address'] ) && !empty( $details['location_venue'] ) ? $details['location_venue'] . ', ' : '' ) .
			( !empty( $details['location_address'] ) ? $details['location_address'] . ', ' : '' ).
			( !empty( $details['location_city'] ) ? $details['location_city'] . ', ' : '' ) .
			( !empty( $details['location_state'] ) ? $details['location_state'] . ' ' : '' ) .
			( !empty( $details['location_zip'] ) ? $details['location_zip'] . ' ' : '' ) .
			$details['location_country'];

		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename=invite_' . str_replace( ' ', '_', keel_events_escape_string( esc_html( $event->post_title ) ) ) . '_' . esc_html( $event_id ) . '.ics');
		$output  = "BEGIN:VCALENDAR\r\n";
		$output .= "VERSION:2.0\r\n";
		$output .= "PRODID:-//" . get_bloginfo( 'name' ) . " - ECPv4.0.5//NONSGML v1.0//EN\r\n";
		$output .= "CALSCALE:GREGORIAN\r\n";
		$output .= "METHOD:PUBLISH\r\n";
		$output .= "X-WR-CALNAME:" . get_bloginfo( 'name' ) . "\r\n";
		$output .= "X-ORIGINAL-URL:" . site_url() . "\r\n";
		$output .= "X-WR-CALDESC:" . get_bloginfo( 'name' ) ." Events\r\n";
		$output .= "BEGIN:VEVENT\r\n";
		$output .= 'DTSTART;TZID="' . esc_html( $timezone ) . '":' . esc_html( $calendar_timestamp_start ) . "\r\n";
		$output .= 'DTEND;TZID="' . esc_html( $timezone ) . '":' . esc_html( $calendar_timestamp_end ) . "\r\n";
		$output .= "DTSTAMP:" . esc_html( current_time( 'timestamp' ) ) . "\r\n";
		$output .= "CREATED:" . esc_html( current_time( 'timestamp' ) ) . "\r\n";
		$output .= "LAST-MODIFIED:" . esc_html( current_time( 'timestamp' ) ) . "\r\n";
		$output .= "UID:" . esc_html( $event_id ) . "_"  . esc_html( $calendar_timestamp_start ) . "_" . esc_html( $calendar_timestamp_end ) . "@" . esc_html( parse_url( site_url( '/' ), PHP_URL_HOST ) ) . "\r\n";
		$output .= "SUMMARY:" . keel_events_escape_string( esc_html( $event->post_title ) ) . "\r\n";
		$output .= "LOCATION:" . keel_events_escape_string( esc_html( $calendar_location ) ) . "\r\n";
		$output .= "DESCRIPTION:\r\n";
		$output .= "URL:" . keel_events_escape_string( get_permalink( $event_id ) ) . "\r\n";
		$output .= "END:VEVENT\r\n";
		$output .= "END:VCALENDAR";
		echo $output;
		die();
	}
	add_action( 'init', 'keel_events_generate_ical_invite' );