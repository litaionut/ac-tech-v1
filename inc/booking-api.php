<?php
/**
 * Booking REST API.
 *
 * @package AC-Tech
 */

/**
 * @param array $service Service config.
 * @param string $date Y-m-d.
 * @param string $start_time H:i.
 * @return array{start_ts: int, end_ts: int, service_start_ts: int, service_end_ts: int}
 */
function ac_tech_booking_interval_for_service( $service, $date, $start_time ) {
	$service_start = ac_tech_booking_ts( $date, $start_time );
	$before        = (int) $service['buffer_before_min'] * MINUTE_IN_SECONDS;
	$after         = (int) $service['buffer_after_min'] * MINUTE_IN_SECONDS;
	$duration      = (int) $service['duration_min'] * MINUTE_IN_SECONDS;

	return array(
		'start_ts'         => $service_start - $before,
		'end_ts'           => $service_start + $duration + $after,
		'service_start_ts' => $service_start,
		'service_end_ts'   => $service_start + $duration,
	);
}

/**
 * @param string $service_slug Service slug.
 * @param string $date Y-m-d.
 * @param string $start_time H:i.
 * @return bool
 */
function ac_tech_booking_slot_is_available( $service_slug, $date, $start_time ) {
	$result = ac_tech_get_availability_for_date( $service_slug, $date );
	if ( empty( $result['slots'] ) || ! is_array( $result['slots'] ) ) {
		return false;
	}

	foreach ( $result['slots'] as $slot ) {
		if ( ! empty( $slot['start'] ) && $slot['start'] === $start_time ) {
			return true;
		}
	}

	return false;
}

/**
 * @param string $service_slug Service slug.
 * @param string $month YYYY-MM.
 * @return array{month: string, service: string, days: array<string, bool>}
 */
function ac_tech_get_availability_for_month( $service_slug, $month ) {
	$parts = explode( '-', (string) $month );
	if ( count( $parts ) !== 2 ) {
		return array( 'month' => $month, 'service' => sanitize_title( (string) $service_slug ), 'days' => array() );
	}

	$year  = (int) $parts[0];
	$mon   = (int) $parts[1];
	$days  = array();
	$count = (int) gmdate( 't', gmmktime( 0, 0, 0, $mon, 1, $year ) );

	for ( $d = 1; $d <= $count; $d++ ) {
		$date   = sprintf( '%04d-%02d-%02d', $year, $mon, $d );
		$result = ac_tech_get_availability_for_date( $service_slug, $date );
		$days[ $date ] = ! empty( $result['slots'] );
	}

	$service = ac_tech_get_booking_service( $service_slug );

	return array(
		'month'   => sprintf( '%04d-%02d', $year, $mon ),
		'service' => $service ? $service['slug'] : sanitize_title( (string) $service_slug ),
		'days'    => $days,
	);
}

/**
 * Register REST routes.
 */
function ac_tech_register_booking_rest_routes() {
	register_rest_route(
		'ac-tech/v1',
		'/availability',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'ac_tech_rest_get_availability',
			'permission_callback' => '__return_true',
			'args'                => array(
				'service' => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_title',
				),
				'date'    => array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				'month'   => array(
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		)
	);

	register_rest_route(
		'ac-tech/v1',
		'/bookings',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'ac_tech_rest_create_booking',
			'permission_callback' => 'ac_tech_rest_booking_can_create',
		)
	);
}
add_action( 'rest_api_init', 'ac_tech_register_booking_rest_routes' );

/**
 * @return bool
 */
function ac_tech_rest_booking_can_create() {
	$nonce = isset( $_SERVER['HTTP_X_WP_NONCE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_WP_NONCE'] ) ) : '';
	return (bool) wp_verify_nonce( $nonce, 'wp_rest' );
}

/**
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function ac_tech_rest_get_availability( $request ) {
	$service = sanitize_title( (string) $request->get_param( 'service' ) );
	$date    = (string) $request->get_param( 'date' );
	$month   = (string) $request->get_param( 'month' );

	if ( '' === $service || ! ac_tech_get_booking_service( $service ) ) {
		return new WP_Error( 'invalid_service', __( 'Serviciu invalid.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( $date ) {
		if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
			return new WP_Error( 'invalid_date', __( 'Dată invalidă.', 'ac-tech' ), array( 'status' => 400 ) );
		}
		return rest_ensure_response( ac_tech_get_availability_for_date( $service, $date ) );
	}

	if ( $month ) {
		if ( ! preg_match( '/^\d{4}-\d{2}$/', $month ) ) {
			return new WP_Error( 'invalid_month', __( 'Lună invalidă.', 'ac-tech' ), array( 'status' => 400 ) );
		}
		return rest_ensure_response( ac_tech_get_availability_for_month( $service, $month ) );
	}

	return new WP_Error( 'missing_param', __( 'Specifică date sau month.', 'ac-tech' ), array( 'status' => 400 ) );
}

/**
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function ac_tech_rest_create_booking( $request ) {
	if ( ! ac_tech_booking_reservations_are_open() ) {
		return new WP_Error(
			'bookings_closed',
			__( 'Rezervările online sunt temporar oprite. Te rugăm să ne contactezi telefonic.', 'ac-tech' ),
			array( 'status' => 503 )
		);
	}

	$rate_check = ac_tech_booking_rate_limit_check();
	if ( is_wp_error( $rate_check ) ) {
		return $rate_check;
	}

	ac_tech_booking_rate_limit_record_attempt();

	$params = $request->get_json_params();
	if ( ! is_array( $params ) ) {
		$params = array();
	}

	$service_slug = sanitize_title( (string) ( $params['service_slug'] ?? $params['service'] ?? '' ) );
	$date         = sanitize_text_field( (string) ( $params['date'] ?? '' ) );
	$start_time   = sanitize_text_field( (string) ( $params['start_time'] ?? '' ) );
	$name         = sanitize_text_field( (string) ( $params['name'] ?? '' ) );
	$phone        = sanitize_text_field( (string) ( $params['phone'] ?? '' ) );
	$email        = sanitize_email( (string) ( $params['email'] ?? '' ) );
	$address      = sanitize_text_field( (string) ( $params['address'] ?? '' ) );
	$urgency      = sanitize_key( (string) ( $params['urgency'] ?? 'standard' ) );
	$notes        = sanitize_textarea_field( (string) ( $params['notes'] ?? '' ) );

	if ( '' === $service_slug || '' === $date || '' === $start_time || '' === $name || '' === $phone || '' === $email || '' === $address ) {
		return new WP_Error( 'missing_fields', __( 'Completează toate câmpurile obligatorii.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( ! is_email( $email ) ) {
		return new WP_Error( 'invalid_email', __( 'E-mail invalid.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) || ! preg_match( '/^\d{2}:\d{2}$/', $start_time ) ) {
		return new WP_Error( 'invalid_datetime', __( 'Dată sau oră invalidă.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	$service = ac_tech_get_booking_service( $service_slug );
	if ( ! $service ) {
		return new WP_Error( 'invalid_service', __( 'Serviciu invalid.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( ! ac_tech_booking_slot_is_available( $service_slug, $date, $start_time ) ) {
		return new WP_Error( 'slot_unavailable', __( 'Intervalul selectat nu mai este disponibil.', 'ac-tech' ), array( 'status' => 409 ) );
	}

	$interval = ac_tech_booking_interval_for_service( $service, $date, $start_time );

	// Re-check overlap immediately before insert.
	$existing = ac_tech_get_bookings_in_range( $interval['start_ts'], $interval['end_ts'] );
	if ( ! empty( $existing ) ) {
		return new WP_Error( 'slot_conflict', __( 'Intervalul a fost rezervat între timp. Alege alt interval.', 'ac-tech' ), array( 'status' => 409 ) );
	}

	$title = sprintf(
		'%s — %s %s',
		$name,
		wp_date( 'd.m.Y', $interval['service_start_ts'], wp_timezone() ),
		wp_date( 'H:i', $interval['service_start_ts'], wp_timezone() )
	);

	$booking_id = wp_insert_post(
		array(
			'post_type'   => 'ac_booking',
			'post_status' => 'publish',
			'post_title'  => $title,
		),
		true
	);

	if ( is_wp_error( $booking_id ) ) {
		return new WP_Error( 'save_failed', __( 'Nu am putut salva programarea.', 'ac-tech' ), array( 'status' => 500 ) );
	}

	$saved = ac_tech_save_booking_fields(
		$booking_id,
		array(
			'service_slug'       => $service_slug,
			'booking_date'       => $date,
			'booking_start_time' => $start_time,
			'name'               => $name,
			'phone'              => $phone,
			'email'              => $email,
			'address'            => $address,
			'urgency'            => $urgency,
			'notes'              => $notes,
			'status'             => 'confirmed',
		)
	);

	if ( is_wp_error( $saved ) ) {
		wp_delete_post( $booking_id, true );
		return new WP_Error( 'save_failed', $saved->get_error_message(), array( 'status' => 500 ) );
	}

	if ( function_exists( 'ac_tech_send_booking_emails' ) ) {
		ac_tech_send_booking_emails( $booking_id );
	}

	$tz = wp_timezone();

	return rest_ensure_response(
		array(
			'success'    => true,
			'booking_id' => (int) $booking_id,
			'date'       => $date,
			'start'      => $start_time,
			'end'        => wp_date( 'H:i', $interval['service_end_ts'], $tz ),
			'service'    => $service_slug,
		)
	);
}
