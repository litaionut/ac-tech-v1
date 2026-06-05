<?php
/**
 * Admin calendar for booking blocks.
 *
 * @package AC-Tech
 */

/**
 * @param string   $date Y-m-d.
 * @param string[] $service_slugs Selected service slugs.
 * @return array{blocked_full: bool, has_interval: bool, blocks: array, visitor_available: bool}
 */
function ac_tech_admin_calendar_day_meta( $date, $service_slugs = array() ) {
	$service_slugs = ac_tech_booking_block_parse_services_raw( $service_slugs );

	$day_blocks   = array();
	$blocked_full = false;
	$has_interval = false;

	foreach ( ac_tech_get_booking_blocks( null ) as $block ) {
		if ( $block['date'] !== $date ) {
			continue;
		}
		if ( ! ac_tech_booking_block_intersects_services( $block['services'], $service_slugs ) ) {
			continue;
		}

		$day_blocks[] = $block;

		if ( 'interval' === $block['type'] ) {
			$has_interval = true;
			continue;
		}

		if ( 'day' === $block['type'] && ac_tech_booking_block_scopes_match( $block['services'], $service_slugs ) ) {
			$blocked_full = true;
		} elseif ( 'day' === $block['type'] ) {
			$has_interval = true;
		}
	}

	$visitor_available = false;
	if ( 1 === count( $service_slugs ) ) {
		$avail = ac_tech_get_availability_for_date( $service_slugs[0], $date );
		$visitor_available = ! empty( $avail['slots'] );
	}

	return array(
		'blocked_full'      => $blocked_full,
		'has_interval'      => $has_interval,
		'blocks'            => $day_blocks,
		'visitor_available' => $visitor_available,
	);
}

/**
 * @param string        $month YYYY-MM.
 * @param array<string> $service_slugs Selected service slugs.
 * @return array
 */
function ac_tech_get_admin_calendar_month( $month, $service_slugs = array() ) {
	$service_slugs = ac_tech_booking_block_parse_services_raw( $service_slugs );

	$parts = explode( '-', (string) $month );
	if ( count( $parts ) !== 2 ) {
		return array( 'month' => $month, 'services' => $service_slugs, 'days' => array(), 'blocks' => array() );
	}

	$year  = (int) $parts[0];
	$mon   = (int) $parts[1];
	$days  = array();
	$count = (int) gmdate( 't', gmmktime( 0, 0, 0, $mon, 1, $year ) );

	for ( $d = 1; $d <= $count; $d++ ) {
		$date          = sprintf( '%04d-%02d-%02d', $year, $mon, $d );
		$days[ $date ] = ac_tech_admin_calendar_day_meta( $date, $service_slugs );
	}

	$blocks = array();
	foreach ( ac_tech_get_booking_blocks( null ) as $block ) {
		if ( 0 !== strpos( $block['date'], sprintf( '%04d-%02d', $year, $mon ) ) ) {
			continue;
		}
		if ( ! ac_tech_booking_block_intersects_services( $block['services'], $service_slugs ) ) {
			continue;
		}
		$blocks[] = $block;
	}

	return array(
		'month'    => sprintf( '%04d-%02d', $year, $mon ),
		'services' => $service_slugs,
		'days'     => $days,
		'blocks'   => $blocks,
	);
}

/**
 * @param mixed $raw Services from REST request.
 * @return string[]
 */
function ac_tech_rest_parse_services_param( $raw ) {
	if ( is_array( $raw ) ) {
		return ac_tech_booking_block_parse_services_raw( $raw );
	}

	if ( is_string( $raw ) && '' !== $raw ) {
		return ac_tech_booking_block_parse_services_raw( explode( ',', $raw ) );
	}

	return array();
}

/**
 * Admin submenu.
 */
function ac_tech_register_booking_calendar_admin_page() {
	add_submenu_page(
		'edit.php?post_type=ac_booking',
		__( 'Calendar blocări', 'ac-tech' ),
		__( 'Calendar blocări', 'ac-tech' ),
		'manage_options',
		'ac-tech-booking-calendar',
		'ac_tech_render_booking_calendar_admin_page'
	);
}
add_action( 'admin_menu', 'ac_tech_register_booking_calendar_admin_page' );

/**
 * Render admin page.
 */
function ac_tech_render_booking_calendar_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$rules    = ac_tech_get_booking_rules();
	$services = ac_tech_get_booking_service_choices();
	$weekdays = array(
		__( 'Lu', 'ac-tech' ),
		__( 'Ma', 'ac-tech' ),
		__( 'Mi', 'ac-tech' ),
		__( 'Jo', 'ac-tech' ),
		__( 'Vi', 'ac-tech' ),
		__( 'Sâ', 'ac-tech' ),
		__( 'Du', 'ac-tech' ),
	);
	?>
	<div class="wrap ac-tech-admin-calendar-wrap">
		<h1><?php esc_html_e( 'Calendar blocări programări', 'ac-tech' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Bifează serviciile, selectează data din calendar, alege tipul blocării și confirmă cu butonul.', 'ac-tech' ); ?>
		</p>

		<div class="ac-tech-admin-calendar-toolbar">
			<div class="ac-tech-admin-calendar-field ac-tech-admin-calendar-field--services">
				<span><?php esc_html_e( 'Servicii afectate', 'ac-tech' ); ?></span>
				<div class="ac-tech-admin-calendar-services" id="ac-tech-admin-cal-services">
					<?php foreach ( $services as $slug => $label ) : ?>
						<label class="ac-tech-admin-calendar-services__item">
							<input type="checkbox" name="ac-tech-admin-cal-service[]" value="<?php echo esc_attr( $slug ); ?>" checked>
							<span><?php echo esc_html( $label ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
				<div class="ac-tech-admin-calendar-services__actions">
					<button type="button" class="button button-small" id="ac-tech-admin-cal-select-all">
						<?php esc_html_e( 'Bifează toate', 'ac-tech' ); ?>
					</button>
					<button type="button" class="button button-small" id="ac-tech-admin-cal-clear-all">
						<?php esc_html_e( 'Debifează toate', 'ac-tech' ); ?>
					</button>
				</div>
			</div>

		</div>

		<div class="ac-tech-admin-calendar-layout">
			<div class="ac-tech-admin-calendar-panel">
				<div class="ac-tech-booking-calendar ac-tech-admin-calendar" id="ac-tech-admin-calendar" data-weekdays="<?php echo esc_attr( wp_json_encode( array_values( $weekdays ) ) ); ?>">
					<div class="ac-tech-booking-calendar__nav">
						<span class="ac-tech-booking-calendar__month" id="ac-tech-admin-cal-month-label"></span>
						<div class="ac-tech-booking-calendar__nav-btns">
							<button type="button" class="ac-tech-booking-calendar__nav-btn" id="ac-tech-admin-cal-prev" aria-label="<?php esc_attr_e( 'Luna anterioară', 'ac-tech' ); ?>">‹</button>
							<button type="button" class="ac-tech-booking-calendar__nav-btn" id="ac-tech-admin-cal-next" aria-label="<?php esc_attr_e( 'Luna următoare', 'ac-tech' ); ?>">›</button>
						</div>
					</div>
					<div class="ac-tech-booking-calendar__weekdays" id="ac-tech-admin-cal-weekdays"></div>
					<div class="ac-tech-booking-calendar__days" id="ac-tech-admin-cal-days" role="grid"></div>
				</div>

				<ul class="ac-tech-admin-calendar-legend">
					<li><span class="ac-tech-admin-calendar-legend__swatch is-blocked-full"></span> <?php esc_html_e( 'Zi blocată', 'ac-tech' ); ?></li>
					<li><span class="ac-tech-admin-calendar-legend__swatch is-blocked-partial"></span> <?php esc_html_e( 'Interval blocat', 'ac-tech' ); ?></li>
					<li><span class="ac-tech-admin-calendar-legend__swatch is-visitor-open"></span> <?php esc_html_e( 'Deschis vizitatorilor (un singur serviciu bifat)', 'ac-tech' ); ?></li>
					<li><span class="ac-tech-admin-calendar-legend__swatch is-visitor-closed"></span> <?php esc_html_e( 'Închis vizitatorilor', 'ac-tech' ); ?></li>
				</ul>
			</div>

			<div class="ac-tech-admin-calendar-side">
				<div class="ac-tech-admin-calendar-action" id="ac-tech-admin-cal-action-panel">
					<h2><?php esc_html_e( 'Confirmă blocarea', 'ac-tech' ); ?></h2>
					<ol class="ac-tech-admin-calendar-action__steps">
						<li><?php esc_html_e( 'Bifează serviciile', 'ac-tech' ); ?></li>
						<li><?php esc_html_e( 'Selectează data sau intervalul de zile', 'ac-tech' ); ?></li>
						<li><?php esc_html_e( 'Alege tipul și confirmă', 'ac-tech' ); ?></li>
					</ol>

					<div class="ac-tech-admin-calendar-field">
						<span><?php esc_html_e( 'Selecție', 'ac-tech' ); ?></span>
						<strong class="ac-tech-admin-calendar-action__date" id="ac-tech-admin-cal-selected-date">—</strong>
						<p class="description ac-tech-admin-calendar-action__hint" id="ac-tech-admin-cal-range-hint" hidden></p>
					</div>

					<label class="ac-tech-admin-calendar-field">
						<span><?php esc_html_e( 'Tip blocare', 'ac-tech' ); ?></span>
						<select id="ac-tech-admin-cal-mode">
							<option value="day"><?php esc_html_e( 'Zi întreagă', 'ac-tech' ); ?></option>
							<option value="day_range"><?php esc_html_e( 'Interval de zile', 'ac-tech' ); ?></option>
							<option value="interval"><?php esc_html_e( 'Interval orar (o zi)', 'ac-tech' ); ?></option>
						</select>
					</label>

					<div class="ac-tech-admin-calendar-action__range" id="ac-tech-admin-cal-range-fields" hidden>
						<label class="ac-tech-admin-calendar-field">
							<span><?php esc_html_e( 'De la data', 'ac-tech' ); ?></span>
							<input type="date" id="ac-tech-admin-cal-date-from">
						</label>
						<label class="ac-tech-admin-calendar-field">
							<span><?php esc_html_e( 'Până la data', 'ac-tech' ); ?></span>
							<input type="date" id="ac-tech-admin-cal-date-to">
						</label>
					</div>

					<div class="ac-tech-admin-calendar-action__interval" id="ac-tech-admin-cal-interval-fields" hidden>
						<label class="ac-tech-admin-calendar-field">
							<span><?php esc_html_e( 'De la', 'ac-tech' ); ?></span>
							<input type="time" id="ac-tech-admin-cal-start" value="<?php echo esc_attr( $rules['day_start'] ); ?>">
						</label>
						<label class="ac-tech-admin-calendar-field">
							<span><?php esc_html_e( 'Până la', 'ac-tech' ); ?></span>
							<input type="time" id="ac-tech-admin-cal-end" value="<?php echo esc_attr( $rules['day_end'] ); ?>">
						</label>
					</div>

					<label class="ac-tech-admin-calendar-field">
						<span><?php esc_html_e( 'Motiv (opțional)', 'ac-tech' ); ?></span>
						<input type="text" id="ac-tech-admin-cal-reason" placeholder="<?php esc_attr_e( 'ex. concediu, întreținere', 'ac-tech' ); ?>">
					</label>

					<button type="button" class="button button-primary button-hero ac-tech-admin-calendar-action__confirm" id="ac-tech-admin-cal-confirm" disabled>
						<?php esc_html_e( 'Confirmă blocarea', 'ac-tech' ); ?>
					</button>
				</div>

				<div class="ac-tech-admin-calendar-blocks">
					<h2><?php esc_html_e( 'Blocări în această lună', 'ac-tech' ); ?></h2>
					<p class="ac-tech-admin-calendar-status" id="ac-tech-admin-cal-status" aria-live="polite"></p>
					<ul class="ac-tech-admin-calendar-blocks__list" id="ac-tech-admin-cal-blocks-list"></ul>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * @param string $hook Admin hook.
 */
function ac_tech_enqueue_booking_admin_calendar_assets( $hook ) {
	if ( 'ac_booking_page_ac-tech-booking-calendar' !== $hook ) {
		return;
	}

	wp_enqueue_style(
		'ac-tech-booking',
		get_template_directory_uri() . '/assets/css/booking.css',
		array(),
		_S_VERSION
	);
	wp_enqueue_style(
		'ac-tech-booking-admin-calendar',
		get_template_directory_uri() . '/assets/css/booking-admin-calendar.css',
		array( 'ac-tech-booking' ),
		_S_VERSION
	);
	wp_enqueue_script(
		'ac-tech-booking-admin-calendar',
		get_template_directory_uri() . '/js/booking-admin-calendar.js',
		array(),
		_S_VERSION,
		true
	);

	$service_labels = ac_tech_get_booking_service_choices();

	wp_localize_script(
		'ac-tech-booking-admin-calendar',
		'acTechBookingAdmin',
		array(
			'restUrl'        => esc_url_raw( rest_url( 'ac-tech/v1/' ) ),
			'nonce'          => wp_create_nonce( 'wp_rest' ),
			'serviceLabels'  => $service_labels,
			'months'         => array(
				__( 'Ianuarie', 'ac-tech' ),
				__( 'Februarie', 'ac-tech' ),
				__( 'Martie', 'ac-tech' ),
				__( 'Aprilie', 'ac-tech' ),
				__( 'Mai', 'ac-tech' ),
				__( 'Iunie', 'ac-tech' ),
				__( 'Iulie', 'ac-tech' ),
				__( 'August', 'ac-tech' ),
				__( 'Septembrie', 'ac-tech' ),
				__( 'Octombrie', 'ac-tech' ),
				__( 'Noiembrie', 'ac-tech' ),
				__( 'Decembrie', 'ac-tech' ),
			),
			'messages'       => array(
				'loading'       => __( 'Se încarcă calendarul...', 'ac-tech' ),
				'saving'        => __( 'Se salvează...', 'ac-tech' ),
				'dayBlocked'    => __( 'Zi blocată.', 'ac-tech' ),
				'dayUnblocked'  => __( 'Zi deblocată.', 'ac-tech' ),
				'intervalAdded' => __( 'Interval blocat.', 'ac-tech' ),
				'dayRangeAdded' => __( '%1$d zile blocate (%2$d existente deja).', 'ac-tech' ),
				'dayRangeRemoved' => __( '%d zile deblocate.', 'ac-tech' ),
				'blockRemoved'  => __( 'Blocare eliminată.', 'ac-tech' ),
				'error'         => __( 'Operațiunea a eșuat. Încearcă din nou.', 'ac-tech' ),
				'selectDay'     => __( 'Selectează o zi din calendar.', 'ac-tech' ),
				'selectServices'=> __( 'Selectează cel puțin un serviciu.', 'ac-tech' ),
				'confirmBlockDay' => __( 'Blochează ziua', 'ac-tech' ),
				'confirmUnblockDay' => __( 'Deblochează ziua', 'ac-tech' ),
				'confirmBlockInterval' => __( 'Blochează intervalul orar', 'ac-tech' ),
				'confirmBlockDayRange' => __( 'Blochează intervalul de zile', 'ac-tech' ),
				'confirmUnblockDayRange' => __( 'Deblochează intervalul de zile', 'ac-tech' ),
				'confirmDisabled' => __( 'Selectează o dată din calendar.', 'ac-tech' ),
				'confirmDisabledRange' => __( 'Selectează ambele date ale intervalului.', 'ac-tech' ),
				'rangeHint' => __( 'Click pe ziua de start, apoi pe ziua de sfârșit. Poți folosi și câmpurile de dată.', 'ac-tech' ),
				'noDateSelected' => __( '—', 'ac-tech' ),
				'allServices'   => __( 'Toate serviciile', 'ac-tech' ),
				'dayType'       => __( 'Zi întreagă', 'ac-tech' ),
				'intervalType'  => __( 'Interval', 'ac-tech' ),
				'remove'        => __( 'Elimină', 'ac-tech' ),
				'noBlocks'      => __( 'Nicio blocare în această lună.', 'ac-tech' ),
			),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'ac_tech_enqueue_booking_admin_calendar_assets' );

/**
 * @return bool
 */
function ac_tech_rest_admin_booking_permission() {
	return current_user_can( 'manage_options' );
}

/**
 * Register admin REST routes.
 */
function ac_tech_register_booking_admin_rest_routes() {
	register_rest_route(
		'ac-tech/v1',
		'/admin/calendar',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'ac_tech_rest_admin_get_calendar',
			'permission_callback' => 'ac_tech_rest_admin_booking_permission',
			'args'                => array(
				'month'   => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'services' => array(
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		)
	);

	register_rest_route(
		'ac-tech/v1',
		'/admin/blocks',
		array(
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => 'ac_tech_rest_admin_save_block',
				'permission_callback' => 'ac_tech_rest_admin_booking_permission',
			),
			array(
				'methods'             => WP_REST_Server::DELETABLE,
				'callback'            => 'ac_tech_rest_admin_delete_block',
				'permission_callback' => 'ac_tech_rest_admin_booking_permission',
			),
		)
	);
}
add_action( 'rest_api_init', 'ac_tech_register_booking_admin_rest_routes' );

/**
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function ac_tech_rest_admin_get_calendar( $request ) {
	$month    = (string) $request->get_param( 'month' );
	$services = ac_tech_rest_parse_services_param( $request->get_param( 'services' ) );

	if ( ! preg_match( '/^\d{4}-\d{2}$/', $month ) ) {
		return new WP_Error( 'invalid_month', __( 'Lună invalidă.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( empty( $services ) ) {
		return new WP_Error( 'missing_services', __( 'Selectează cel puțin un serviciu.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	foreach ( $services as $slug ) {
		if ( ! ac_tech_get_booking_service( $slug ) ) {
			return new WP_Error( 'invalid_service', __( 'Serviciu invalid.', 'ac-tech' ), array( 'status' => 400 ) );
		}
	}

	return rest_ensure_response( ac_tech_get_admin_calendar_month( $month, $services ) );
}

/**
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function ac_tech_rest_admin_save_block( $request ) {
	$params = $request->get_json_params();
	if ( ! is_array( $params ) ) {
		$params = array();
	}

	$action = sanitize_key( (string) ( $params['action'] ?? 'add' ) );
	$date   = sanitize_text_field( (string) ( $params['date'] ?? '' ) );

	$services = ac_tech_booking_block_parse_services_raw( $params['services'] ?? array() );

	if ( empty( $services ) ) {
		return new WP_Error( 'missing_services', __( 'Selectează cel puțin un serviciu.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( 'toggle_day' === $action ) {
		$reason = sanitize_text_field( (string) ( $params['reason'] ?? '' ) );
		$result = ac_tech_toggle_booking_day_block( $date, $services, $reason );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		return rest_ensure_response(
			array(
				'success' => true,
				'action'  => 'toggle_day',
				'state'   => $result,
			)
		);
	}

	if ( 'add_day_range' === $action ) {
		$date_from = sanitize_text_field( (string) ( $params['date_from'] ?? $params['date'] ?? '' ) );
		$date_to   = sanitize_text_field( (string) ( $params['date_to'] ?? '' ) );
		$reason    = sanitize_text_field( (string) ( $params['reason'] ?? '' ) );
		$result    = ac_tech_add_booking_day_range( $date_from, $date_to, $services, $reason );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		return rest_ensure_response(
			array_merge(
				array( 'success' => true, 'action' => 'add_day_range' ),
				$result
			)
		);
	}

	if ( 'remove_day_range' === $action ) {
		$date_from = sanitize_text_field( (string) ( $params['date_from'] ?? $params['date'] ?? '' ) );
		$date_to   = sanitize_text_field( (string) ( $params['date_to'] ?? '' ) );
		$result    = ac_tech_remove_booking_day_range( $date_from, $date_to, $services );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		return rest_ensure_response(
			array_merge(
				array( 'success' => true, 'action' => 'remove_day_range' ),
				$result
			)
		);
	}

	$result = ac_tech_add_booking_block(
		array(
			'type'     => sanitize_key( (string) ( $params['type'] ?? 'interval' ) ),
			'date'     => $date,
			'start'    => sanitize_text_field( (string) ( $params['start'] ?? '' ) ),
			'end'      => sanitize_text_field( (string) ( $params['end'] ?? '' ) ),
			'services' => $services,
			'reason'   => sanitize_text_field( (string) ( $params['reason'] ?? '' ) ),
		)
	);

	if ( is_wp_error( $result ) ) {
		return $result;
	}

	return rest_ensure_response( array( 'success' => true, 'action' => 'add' ) );
}

/**
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function ac_tech_rest_admin_delete_block( $request ) {
	$params = $request->get_json_params();
	if ( ! is_array( $params ) ) {
		$params = array();
	}

	$block_key = sanitize_text_field( (string) ( $params['block_key'] ?? $request->get_param( 'block_key' ) ) );
	if ( '' === $block_key ) {
		return new WP_Error( 'missing_key', __( 'Cheie blocare lipsă.', 'ac-tech' ), array( 'status' => 400 ) );
	}

	if ( ! ac_tech_remove_booking_block_by_key( $block_key ) ) {
		return new WP_Error( 'remove_failed', __( 'Blocarea nu a putut fi eliminată.', 'ac-tech' ), array( 'status' => 404 ) );
	}

	return rest_ensure_response( array( 'success' => true ) );
}
