<?php
/**
 * Booking blocks — storage helpers (ACF repeater).
 *
 * @package AC-Tech
 */

define( 'AC_TECH_BOOKING_BLOCKS_OPTION', 'ac_tech_booking_blocks_store' );

/**
 * @param mixed $raw Raw services value from ACF or API.
 * @return string[]
 */
function ac_tech_booking_block_parse_services_raw( $raw ) {
	if ( empty( $raw ) || false === $raw ) {
		return array();
	}
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$out = array();
	foreach ( $raw as $slug ) {
		$slug = sanitize_title( (string) $slug );
		if ( '' !== $slug ) {
			$out[] = $slug;
		}
	}

	return array_values( array_unique( $out ) );
}

/**
 * @param string[] $services Service slugs.
 * @return bool
 */
function ac_tech_booking_block_is_all_services( $services ) {
	$services = ac_tech_booking_block_parse_services_raw( $services );
	if ( empty( $services ) ) {
		return true;
	}

	$all = array_keys( ac_tech_get_booking_service_choices() );
	sort( $all );
	$services_sorted = $services;
	sort( $services_sorted );

	return ! empty( $all ) && $all === $services_sorted;
}

/**
 * @param string[]|mixed $services_a First scope.
 * @param string[]|mixed $services_b Second scope.
 * @return bool
 */
function ac_tech_booking_block_scopes_match( $services_a, $services_b ) {
	if ( ac_tech_booking_block_is_all_services( $services_a ) && ac_tech_booking_block_is_all_services( $services_b ) ) {
		return true;
	}

	$a = ac_tech_booking_block_parse_services_raw( $services_a );
	$b = ac_tech_booking_block_parse_services_raw( $services_b );
	sort( $a );
	sort( $b );

	return $a === $b;
}

/**
 * @param string[]|mixed $block_services Block services.
 * @param string[]       $filter_services Selected services.
 * @return bool
 */
function ac_tech_booking_block_intersects_services( $block_services, $filter_services ) {
	$filter_services = ac_tech_booking_block_parse_services_raw( $filter_services );
	if ( empty( $filter_services ) ) {
		return true;
	}

	$block_services = ac_tech_booking_block_parse_services_raw( $block_services );
	if ( empty( $block_services ) || ac_tech_booking_block_is_all_services( $block_services ) ) {
		return true;
	}

	foreach ( $filter_services as $slug ) {
		if ( in_array( $slug, $block_services, true ) ) {
			return true;
		}
	}

	return false;
}

/**
 * @param array $row Raw repeater row.
 * @return string
 */
function ac_tech_booking_block_compute_key( $row ) {
	$services = ac_tech_booking_block_parse_services_raw( $row['block_services'] ?? array() );
	sort( $services );

	return md5(
		wp_json_encode(
			array(
				'date'     => (string) ( $row['block_date'] ?? '' ),
				'type'     => (string) ( $row['block_type'] ?? 'day' ),
				'start'    => (string) ( $row['block_start'] ?? '' ),
				'end'      => (string) ( $row['block_end'] ?? '' ),
				'services' => $services,
			)
		)
	);
}

/**
 * @param array $row Raw row.
 * @return array{type: string, date: string, start: string, end: string, services: string[], reason: string, key: string}
 */
function ac_tech_normalize_booking_block_row( $row ) {
	if ( ! is_array( $row ) ) {
		return array();
	}

	$type     = ! empty( $row['block_type'] ) && 'interval' === $row['block_type'] ? 'interval' : 'day';
	$services = ac_tech_booking_block_parse_services_raw( $row['block_services'] ?? array() );

	$key = ! empty( $row['block_key'] ) ? (string) $row['block_key'] : ac_tech_booking_block_compute_key( $row );

	return array(
		'type'     => $type,
		'date'     => (string) ( $row['block_date'] ?? '' ),
		'start'    => ! empty( $row['block_start'] ) ? (string) $row['block_start'] : '00:00',
		'end'      => ! empty( $row['block_end'] ) ? (string) $row['block_end'] : '23:59',
		'services' => $services,
		'reason'   => ! empty( $row['block_reason'] ) ? (string) $row['block_reason'] : '',
		'key'      => $key,
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_booking_blocks_raw_rows() {
	$stored = get_option( AC_TECH_BOOKING_BLOCKS_OPTION, null );
	if ( is_array( $stored ) ) {
		return $stored;
	}

	$rows = ac_tech_get_booking_setting( 'booking_blocks', array() );
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}

	if ( ! empty( $rows ) ) {
		update_option( AC_TECH_BOOKING_BLOCKS_OPTION, $rows, false );
	}

	return $rows;
}

/**
 * @param array<int, array<string, mixed>> $rows Rows.
 * @return bool
 */
function ac_tech_save_booking_blocks_raw_rows( $rows ) {
	$prepared = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$prepared[] = ac_tech_booking_block_prepare_row_for_storage( $row );
	}

	$saved = update_option( AC_TECH_BOOKING_BLOCKS_OPTION, $prepared, false );

	$page_id = ac_tech_get_booking_settings_id();
	if ( $page_id > 0 && function_exists( 'update_field' ) ) {
		update_field( 'booking_blocks', $prepared, $page_id );
	}

	return (bool) $saved;
}

/**
 * Normalize a repeater row before ACF storage.
 *
 * @param array $row Raw row.
 * @return array<string, mixed>
 */
function ac_tech_booking_block_prepare_row_for_storage( $row ) {
	$type     = ! empty( $row['block_type'] ) && 'interval' === $row['block_type'] ? 'interval' : 'day';
	$services = ac_tech_booking_block_parse_services_raw( $row['block_services'] ?? ( $row['services'] ?? array() ) );

	$prepared = array(
		'block_type'   => $type,
		'block_date'   => (string) ( $row['block_date'] ?? '' ),
		'block_reason' => (string) ( $row['block_reason'] ?? '' ),
		'block_key'    => ! empty( $row['block_key'] ) ? (string) $row['block_key'] : '',
	);

	$prepared['block_services'] = $services;

	if ( 'interval' === $type ) {
		$prepared['block_start'] = (string) ( $row['block_start'] ?? '08:00' );
		$prepared['block_end']   = (string) ( $row['block_end'] ?? '17:00' );
	}

	if ( '' === $prepared['block_key'] ) {
		$prepared['block_key'] = ac_tech_booking_block_compute_key( $prepared );
	}

	return $prepared;
}

/**
 * @param array  $block  Normalized block.
 * @param string $service_slug Service slug or empty for all.
 * @return bool
 */
function ac_tech_booking_block_applies_to_service( $block, $service_slug ) {
	if ( empty( $block['services'] ) ) {
		return true;
	}
	if ( '' === $service_slug ) {
		return true;
	}
	return in_array( $service_slug, $block['services'], true );
}

/**
 * @param string|null $service_slug Filter by service.
 * @return array<int, array{type: string, date: string, start: string, end: string, services: string[], reason: string, key: string}>
 */
function ac_tech_get_booking_blocks( $service_slug = null ) {
	$out = array();
	foreach ( ac_tech_get_booking_blocks_raw_rows() as $row ) {
		$block = ac_tech_normalize_booking_block_row( $row );
		if ( empty( $block['date'] ) ) {
			continue;
		}
		if ( null !== $service_slug && '' !== $service_slug && ! ac_tech_booking_block_applies_to_service( $block, $service_slug ) ) {
			continue;
		}
		$out[] = $block;
	}
	return $out;
}

/**
 * @param string $block_key Block key.
 * @return bool
 */
function ac_tech_remove_booking_block_by_key( $block_key ) {
	$rows  = ac_tech_get_booking_blocks_raw_rows();
	$next  = array();
	$found = false;

	foreach ( $rows as $row ) {
		$norm = ac_tech_normalize_booking_block_row( $row );
		if ( $norm['key'] === $block_key ) {
			$found = true;
			continue;
		}
		$next[] = $row;
	}

	if ( ! $found ) {
		return false;
	}

	return ac_tech_save_booking_blocks_raw_rows( $next );
}

/**
 * @param array $block Block payload.
 * @return true|WP_Error
 */
function ac_tech_add_booking_block( $block ) {
	$type = ! empty( $block['type'] ) && 'interval' === $block['type'] ? 'interval' : 'day';
	$date = sanitize_text_field( (string) ( $block['date'] ?? '' ) );

	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
		return new WP_Error( 'invalid_date', __( 'Dată invalidă.', 'ac-tech' ) );
	}

	$services = ac_tech_booking_block_parse_services_raw( $block['services'] ?? array() );
	$validated = array();
	foreach ( $services as $slug ) {
		if ( ac_tech_get_booking_service( $slug ) ) {
			$validated[] = $slug;
		}
	}
	$services = $validated;

	if ( empty( $services ) ) {
		return new WP_Error( 'missing_services', __( 'Selectează cel puțin un serviciu.', 'ac-tech' ) );
	}

	$start  = sanitize_text_field( (string) ( $block['start'] ?? '08:00' ) );
	$end    = sanitize_text_field( (string) ( $block['end'] ?? '17:00' ) );
	$reason = sanitize_text_field( (string) ( $block['reason'] ?? '' ) );

	if ( 'interval' === $type && ( ! preg_match( '/^\d{2}:\d{2}$/', $start ) || ! preg_match( '/^\d{2}:\d{2}$/', $end ) ) ) {
		return new WP_Error( 'invalid_interval', __( 'Interval orar invalid.', 'ac-tech' ) );
	}

	$row = array(
		'block_type'   => $type,
		'block_date'   => $date,
		'block_reason' => $reason,
		'services'     => $services,
	);

	if ( 'interval' === $type ) {
		$row['block_start'] = $start;
		$row['block_end']   = $end;
	}

	$row = ac_tech_booking_block_prepare_row_for_storage( $row );

	// Prevent duplicate for same scope.
	foreach ( ac_tech_get_booking_blocks_raw_rows() as $existing ) {
		$norm = ac_tech_normalize_booking_block_row( $existing );
		if ( $norm['date'] !== $date || $norm['type'] !== $type ) {
			continue;
		}
		if ( 'interval' === $type && ( $norm['start'] !== $start || $norm['end'] !== $end ) ) {
			continue;
		}
		if ( ac_tech_booking_block_scopes_match( $norm['services'], $services ) ) {
			return new WP_Error( 'duplicate_block', __( 'Această blocare există deja.', 'ac-tech' ) );
		}
	}

	$rows   = ac_tech_get_booking_blocks_raw_rows();
	$rows[] = $row;

	if ( ! ac_tech_save_booking_blocks_raw_rows( $rows ) ) {
		return new WP_Error( 'save_failed', __( 'Nu am putut salva blocarea în setările booking.', 'ac-tech' ) );
	}

	return true;
}

/**
 * @param string $date Y-m-d.
 * @param array  $services Service slugs.
 * @param string $reason Optional reason.
 * @return string|WP_Error added|removed
 */
function ac_tech_toggle_booking_day_block( $date, $services = array(), $reason = '' ) {
	$services = ac_tech_booking_block_parse_services_raw( $services );

	if ( empty( $services ) ) {
		return new WP_Error( 'missing_services', __( 'Selectează cel puțin un serviciu.', 'ac-tech' ) );
	}

	foreach ( ac_tech_get_booking_blocks( null ) as $block ) {
		if ( 'day' !== $block['type'] || $block['date'] !== $date ) {
			continue;
		}
		if ( ac_tech_booking_block_scopes_match( $block['services'], $services ) ) {
			if ( ! ac_tech_remove_booking_block_by_key( $block['key'] ) ) {
				return new WP_Error( 'save_failed', __( 'Nu am putut salva blocarea în setările booking.', 'ac-tech' ) );
			}
			return 'removed';
		}
	}

	$added = ac_tech_add_booking_block(
		array(
			'type'     => 'day',
			'date'     => $date,
			'services' => $services,
			'reason'   => $reason,
		)
	);

	if ( is_wp_error( $added ) ) {
		return $added;
	}

	return 'added';
}

/**
 * @param string $date_from Y-m-d.
 * @param string $date_to   Y-m-d.
 * @return string[]|WP_Error
 */
function ac_tech_booking_dates_in_range( $date_from, $date_to ) {
	$date_from = sanitize_text_field( (string) $date_from );
	$date_to   = sanitize_text_field( (string) $date_to );

	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_from ) || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_to ) ) {
		return new WP_Error( 'invalid_date', __( 'Dată invalidă.', 'ac-tech' ) );
	}

	$tz   = wp_timezone();
	$from = date_create_immutable_from_format( 'Y-m-d', $date_from, $tz );
	$to   = date_create_immutable_from_format( 'Y-m-d', $date_to, $tz );

	if ( ! $from || ! $to ) {
		return new WP_Error( 'invalid_date', __( 'Dată invalidă.', 'ac-tech' ) );
	}

	if ( $from > $to ) {
		$tmp  = $from;
		$from = $to;
		$to   = $tmp;
	}

	$dates = array();
	$day   = $from;
	$limit = 366;

	for ( $i = 0; $i < $limit && $day <= $to; $i++ ) {
		$dates[] = $day->format( 'Y-m-d' );
		$day     = $day->modify( '+1 day' );
	}

	if ( $day <= $to ) {
		return new WP_Error( 'range_too_large', __( 'Intervalul de zile este prea mare (max. 366).', 'ac-tech' ) );
	}

	return $dates;
}

/**
 * @param array  $norm     Normalized block.
 * @param string $date     Y-m-d.
 * @param string $type     Block type.
 * @param array  $services Service slugs.
 * @param string $start    Optional start time.
 * @param string $end      Optional end time.
 * @return bool
 */
function ac_tech_booking_row_is_duplicate( $norm, $date, $type, $services, $start = '', $end = '' ) {
	if ( empty( $norm['date'] ) || $norm['date'] !== $date || $norm['type'] !== $type ) {
		return false;
	}
	if ( 'interval' === $type && ( $norm['start'] !== $start || $norm['end'] !== $end ) ) {
		return false;
	}
	return ac_tech_booking_block_scopes_match( $norm['services'], $services );
}

/**
 * @param string $date_from Y-m-d.
 * @param string $date_to   Y-m-d.
 * @param array  $services  Service slugs.
 * @param string $reason    Optional reason.
 * @return array{added: int, skipped: int, total: int}|WP_Error
 */
function ac_tech_add_booking_day_range( $date_from, $date_to, $services = array(), $reason = '' ) {
	$services = ac_tech_booking_block_parse_services_raw( $services );
	if ( empty( $services ) ) {
		return new WP_Error( 'missing_services', __( 'Selectează cel puțin un serviciu.', 'ac-tech' ) );
	}

	$dates = ac_tech_booking_dates_in_range( $date_from, $date_to );
	if ( is_wp_error( $dates ) ) {
		return $dates;
	}

	$rows    = ac_tech_get_booking_blocks_raw_rows();
	$added   = 0;
	$skipped = 0;
	$reason  = sanitize_text_field( (string) $reason );

	foreach ( $dates as $date ) {
		$duplicate = false;
		foreach ( $rows as $existing ) {
			$norm = ac_tech_normalize_booking_block_row( $existing );
			if ( ac_tech_booking_row_is_duplicate( $norm, $date, 'day', $services ) ) {
				$duplicate = true;
				break;
			}
		}

		if ( $duplicate ) {
			++$skipped;
			continue;
		}

		$rows[] = ac_tech_booking_block_prepare_row_for_storage(
			array(
				'block_type'   => 'day',
				'block_date'   => $date,
				'block_reason' => $reason,
				'services'     => $services,
			)
		);
		++$added;
	}

	if ( $added <= 0 ) {
		return new WP_Error( 'duplicate_block', __( 'Toate zilele din interval sunt deja blocate.', 'ac-tech' ) );
	}

	if ( ! ac_tech_save_booking_blocks_raw_rows( $rows ) ) {
		return new WP_Error( 'save_failed', __( 'Nu am putut salva blocarea în setările booking.', 'ac-tech' ) );
	}

	return array(
		'added'   => $added,
		'skipped' => $skipped,
		'total'   => count( $dates ),
	);
}

/**
 * @param string $date_from Y-m-d.
 * @param string $date_to   Y-m-d.
 * @param array  $services  Service slugs.
 * @return array{removed: int, total: int}|WP_Error
 */
function ac_tech_remove_booking_day_range( $date_from, $date_to, $services = array() ) {
	$services = ac_tech_booking_block_parse_services_raw( $services );
	if ( empty( $services ) ) {
		return new WP_Error( 'missing_services', __( 'Selectează cel puțin un serviciu.', 'ac-tech' ) );
	}

	$dates = ac_tech_booking_dates_in_range( $date_from, $date_to );
	if ( is_wp_error( $dates ) ) {
		return $dates;
	}

	$rows    = ac_tech_get_booking_blocks_raw_rows();
	$next    = array();
	$removed = 0;

	foreach ( $rows as $row ) {
		$norm = ac_tech_normalize_booking_block_row( $row );
		if ( 'day' === $norm['type'] && in_array( $norm['date'], $dates, true ) && ac_tech_booking_block_scopes_match( $norm['services'], $services ) ) {
			++$removed;
			continue;
		}
		$next[] = $row;
	}

	if ( $removed <= 0 ) {
		return new WP_Error( 'not_found', __( 'Nu există blocări de zi pentru acest interval.', 'ac-tech' ) );
	}

	if ( ! ac_tech_save_booking_blocks_raw_rows( $next ) ) {
		return new WP_Error( 'save_failed', __( 'Nu am putut salva blocarea în setările booking.', 'ac-tech' ) );
	}

	return array(
		'removed' => $removed,
		'total'   => count( $dates ),
	);
}
