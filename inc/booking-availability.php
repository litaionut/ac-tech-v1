<?php
/**
 * Booking availability engine.
 *
 * @package AC-Tech
 */

/**
 * @return int
 */
function ac_tech_get_booking_settings_id() {
	return function_exists( 'ac_tech_get_booking_settings_page_id' ) ? (int) ac_tech_get_booking_settings_page_id() : 0;
}

/**
 * @param string $field_name Field name.
 * @param mixed  $default Default value.
 * @return mixed
 */
function ac_tech_get_booking_setting( $field_name, $default = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$page_id = ac_tech_get_booking_settings_id();
	if ( $page_id <= 0 ) {
		return $default;
	}

	$value = get_field( $field_name, $page_id );
	if ( function_exists( 'ac_tech_editable_value_is_empty' ) && ac_tech_editable_value_is_empty( $value ) ) {
		return $default;
	}

	return $value;
}

/**
 * @return array<int, array{slug: string, label: string, duration_min: int, buffer_before_min: int, buffer_after_min: int}>
 */
function ac_tech_get_booking_services() {
	$rows = ac_tech_get_booking_setting( 'booking_services', array() );
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || empty( $row['service_slug'] ) ) {
			continue;
		}
		$slug = sanitize_title( (string) $row['service_slug'] );
		if ( '' === $slug ) {
			continue;
		}
		$out[] = array(
			'slug'              => $slug,
			'label'             => ! empty( $row['service_label'] ) ? (string) $row['service_label'] : $slug,
			'duration_min'      => ! empty( $row['service_duration_min'] ) ? max( 15, (int) $row['service_duration_min'] ) : 120,
			'buffer_before_min' => ! empty( $row['service_buffer_before_min'] ) ? max( 0, (int) $row['service_buffer_before_min'] ) : 0,
			'buffer_after_min'  => ! empty( $row['service_buffer_after_min'] ) ? max( 0, (int) $row['service_buffer_after_min'] ) : 0,
		);
	}

	return $out;
}

/**
 * @return array<string, string> slug => label
 */
function ac_tech_get_booking_service_choices() {
	static $resolving = false;
	if ( $resolving ) {
		return array();
	}

	$out = array();

	$services = ac_tech_get_booking_services();
	if ( empty( $services ) ) {
		// Fallback to existing static booking-content services.
		$resolving = true;
		$form = function_exists( 'ac_tech_get_booking_form' ) ? ac_tech_get_booking_form() : array();
		$resolving = false;
		if ( ! empty( $form['services'] ) && is_array( $form['services'] ) ) {
			foreach ( $form['services'] as $slug => $label ) {
				$out[ sanitize_title( (string) $slug ) ] = (string) $label;
			}
		}
		return $out;
	}

	foreach ( $services as $svc ) {
		$out[ $svc['slug'] ] = $svc['label'];
	}

	return $out;
}

/**
 * @param string $slug Service slug.
 * @return array{slug: string, label: string, duration_min: int, buffer_before_min: int, buffer_after_min: int}|null
 */
function ac_tech_get_booking_service( $slug ) {
	$slug = sanitize_title( (string) $slug );
	foreach ( ac_tech_get_booking_services() as $svc ) {
		if ( $svc['slug'] === $slug ) {
			return $svc;
		}
	}

	// Fallback (so UI can still work if ACF not filled yet).
	$choices = ac_tech_get_booking_service_choices();
	if ( isset( $choices[ $slug ] ) ) {
		return array(
			'slug'              => $slug,
			'label'             => $choices[ $slug ],
			'duration_min'      => 120,
			'buffer_before_min' => 0,
			'buffer_after_min'  => 0,
		);
	}

	return null;
}

/**
 * @return array{working_days: int[], day_start: string, day_end: string, slot_step_min: int, lead_hours: int, max_days_ahead: int, notify_email: string}
 */
function ac_tech_get_booking_rules() {
	$days = ac_tech_get_booking_setting( 'booking_working_days', array( '1', '2', '3', '4', '5' ) );
	if ( ! is_array( $days ) ) {
		$days = array( '1', '2', '3', '4', '5' );
	}

	$working_days = array();
	foreach ( $days as $d ) {
		$int = (int) $d;
		if ( $int >= 1 && $int <= 7 ) {
			$working_days[] = $int;
		}
	}
	$working_days = array_values( array_unique( $working_days ) );
	sort( $working_days );

	return array(
		'working_days'   => $working_days,
		'day_start'      => (string) ac_tech_get_booking_setting( 'booking_day_start', '08:00' ),
		'day_end'        => (string) ac_tech_get_booking_setting( 'booking_day_end', '17:00' ),
		'slot_step_min'  => (int) ac_tech_get_booking_setting( 'booking_slot_step_min', 30 ),
		'lead_hours'     => (int) ac_tech_get_booking_setting( 'booking_lead_hours', 6 ),
		'max_days_ahead' => (int) ac_tech_get_booking_setting( 'booking_max_days_ahead', 60 ),
		'notify_email'   => (string) ac_tech_get_booking_setting( 'booking_notify_email', '' ),
	);
}

/**
 * @param string $date Y-m-d
 * @param string $time H:i
 * @return int Unix timestamp in WP timezone.
 */
function ac_tech_booking_ts( $date, $time ) {
	$tz  = wp_timezone();
	$dt  = date_create_immutable_from_format( 'Y-m-d H:i', $date . ' ' . $time, $tz );
	return $dt ? $dt->getTimestamp() : 0;
}

/**
 * @param int $start_ts Start.
 * @param int $end_ts End.
 * @param int $range_start Range start.
 * @param int $range_end Range end.
 * @return bool
 */
function ac_tech_booking_overlaps( $start_ts, $end_ts, $range_start, $range_end ) {
	return $start_ts < $range_end && $end_ts > $range_start;
}

/**
 * @param int $range_start Day start ts.
 * @param int $range_end Day end ts.
 * @return array<int, array{start_ts: int, end_ts: int}>
 */
function ac_tech_get_bookings_in_range( $range_start, $range_end ) {
	$q = new WP_Query(
		array(
			'post_type'      => 'ac_booking',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 200,
			'no_found_rows'  => true,
			'fields'         => 'ids',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'start_ts',
					'value'   => $range_end,
					'compare' => '<',
					'type'    => 'NUMERIC',
				),
				array(
					'key'     => 'end_ts',
					'value'   => $range_start,
					'compare' => '>',
					'type'    => 'NUMERIC',
				),
			),
		)
	);

	$out = array();
	foreach ( $q->posts as $id ) {
		$start = (int) get_post_meta( $id, 'start_ts', true );
		$end   = (int) get_post_meta( $id, 'end_ts', true );
		if ( $start && $end ) {
			$out[] = array( 'start_ts' => $start, 'end_ts' => $end );
		}
	}

	return $out;
}

/**
 * @param string $service_slug Service slug.
 * @param string $date Y-m-d
 * @return array{date: string, service: string, slots: array<int, array{start: string, end: string}>, reason?: string}
 */
function ac_tech_get_availability_for_date( $service_slug, $date ) {
	$service = ac_tech_get_booking_service( $service_slug );
	if ( ! $service ) {
		return array( 'date' => $date, 'service' => sanitize_title( (string) $service_slug ), 'slots' => array(), 'reason' => 'invalid_service' );
	}

	$rules = ac_tech_get_booking_rules();
	$step  = max( 5, (int) $rules['slot_step_min'] );

	$tz = wp_timezone();
	$day = date_create_immutable_from_format( 'Y-m-d', (string) $date, $tz );
	if ( ! $day ) {
		return array( 'date' => $date, 'service' => $service['slug'], 'slots' => array(), 'reason' => 'invalid_date' );
	}

	// Working day check (1..7).
	$weekday = (int) $day->format( 'N' );
	if ( ! in_array( $weekday, $rules['working_days'], true ) ) {
		return array( 'date' => $date, 'service' => $service['slug'], 'slots' => array() );
	}

	$day_start_ts = ac_tech_booking_ts( $date, $rules['day_start'] );
	$day_end_ts   = ac_tech_booking_ts( $date, $rules['day_end'] );
	if ( $day_start_ts <= 0 || $day_end_ts <= 0 || $day_end_ts <= $day_start_ts ) {
		return array( 'date' => $date, 'service' => $service['slug'], 'slots' => array(), 'reason' => 'invalid_rules' );
	}

	// Lead time + max days ahead.
	$now_ts = (int) ( new DateTimeImmutable( 'now', $tz ) )->getTimestamp();
	$min_ts = $now_ts + ( max( 0, (int) $rules['lead_hours'] ) * HOUR_IN_SECONDS );
	$max_ts = $now_ts + ( max( 1, (int) $rules['max_days_ahead'] ) * DAY_IN_SECONDS );
	if ( $day_start_ts > $max_ts ) {
		return array( 'date' => $date, 'service' => $service['slug'], 'slots' => array() );
	}

	$blocks = ac_tech_get_booking_blocks( $service['slug'] );
	$booked = ac_tech_get_bookings_in_range( $day_start_ts, $day_end_ts );

	$duration_total_min = (int) $service['buffer_before_min'] + (int) $service['duration_min'] + (int) $service['buffer_after_min'];
	$duration_total_sec = max( 15 * MINUTE_IN_SECONDS, $duration_total_min * MINUTE_IN_SECONDS );

	$slots = array();
	for ( $t = $day_start_ts; ( $t + $duration_total_sec ) <= $day_end_ts; $t += $step * MINUTE_IN_SECONDS ) {
		$slot_start = $t;
		$slot_end   = $t + $duration_total_sec;

		if ( $slot_start < $min_ts ) {
			continue;
		}

		// Block rules.
		$blocked = false;
		foreach ( $blocks as $b ) {
			if ( $b['date'] !== $date ) {
				continue;
			}
			if ( 'day' === $b['type'] ) {
				$blocked = true;
				break;
			}
			$bs = ac_tech_booking_ts( $date, $b['start'] );
			$be = ac_tech_booking_ts( $date, $b['end'] );
			if ( $bs && $be && ac_tech_booking_overlaps( $slot_start, $slot_end, $bs, $be ) ) {
				$blocked = true;
				break;
			}
		}
		if ( $blocked ) {
			continue;
		}

		// Existing bookings overlap.
		foreach ( $booked as $existing ) {
			if ( ac_tech_booking_overlaps( $slot_start, $slot_end, (int) $existing['start_ts'], (int) $existing['end_ts'] ) ) {
				$blocked = true;
				break;
			}
		}
		if ( $blocked ) {
			continue;
		}

		$slots[] = array(
			'start' => wp_date( 'H:i', $slot_start, $tz ),
			'end'   => wp_date( 'H:i', $slot_start + (int) $service['duration_min'] * MINUTE_IN_SECONDS, $tz ),
		);
	}

	return array(
		'date'    => $date,
		'service' => $service['slug'],
		'slots'   => $slots,
	);
}

