<?php
/**
 * Booking — ACF integration (form services + seed defaults).
 *
 * @package AC-Tech
 */

define( 'AC_TECH_BOOKING_SEED_OPTION', 'ac_tech_booking_seeded_v1' );

/**
 * Ensure a settings page exists for ACF booking fields.
 */
function ac_tech_maybe_create_booking_settings_page() {
	if ( ac_tech_get_booking_settings_page_id() > 0 ) {
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'private',
			'post_title'   => __( 'Setări booking', 'ac-tech' ),
			'post_content' => '',
		),
		true
	);

	if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
		update_post_meta( $page_id, '_wp_page_template', 'template-booking-settings.php' );
	}
}
add_action( 'acf/init', 'ac_tech_maybe_create_booking_settings_page', 5 );

/**
 * Default services for seed / fallback.
 *
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_booking_services_seed_rows() {
	$form = ac_tech_get_booking_form();
	$map  = array(
		'igienizare'  => 120,
		'mentenanta'  => 90,
		'reparatie'   => 60,
		'instalare'   => 180,
		'consultanta' => 60,
	);

	$rows = array();
	if ( empty( $form['services'] ) || ! is_array( $form['services'] ) ) {
		return $rows;
	}

	foreach ( $form['services'] as $slug => $label ) {
		$key = sanitize_title( (string) $slug );
		$rows[] = array(
			'service_slug'            => $key,
			'service_label'           => (string) $label,
			'service_duration_min'    => isset( $map[ $key ] ) ? (int) $map[ $key ] : 120,
			'service_buffer_before_min' => 0,
			'service_buffer_after_min'  => 15,
		);
	}

	return $rows;
}

/**
 * Seed booking settings ACF on settings page.
 */
function ac_tech_seed_booking_acf_fields() {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	if ( get_option( AC_TECH_BOOKING_SEED_OPTION ) ) {
		return;
	}

	$page_id = ac_tech_get_booking_settings_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	if ( ac_tech_editable_value_is_empty( get_field( 'booking_services', $page_id ) ) ) {
		$rows = ac_tech_get_booking_services_seed_rows();
		if ( ! empty( $rows ) ) {
			update_field( 'booking_services', $rows, $page_id );
		}
	}

	$defaults = array(
		'booking_working_days'   => array( '1', '2', '3', '4', '5' ),
		'booking_day_start'      => '08:00',
		'booking_day_end'        => '17:00',
		'booking_slot_step_min'  => 30,
		'booking_lead_hours'     => 6,
		'booking_max_days_ahead' => 60,
	);

	foreach ( $defaults as $field => $value ) {
		if ( ! ac_tech_editable_value_is_empty( get_field( $field, $page_id ) ) ) {
			continue;
		}
		update_field( $field, $value, $page_id );
	}

	update_option( AC_TECH_BOOKING_SEED_OPTION, 1, false );
}
add_action( 'acf/init', 'ac_tech_seed_booking_acf_fields', 25 );

/**
 * Override booking form services from ACF when configured.
 *
 * @param array<string, mixed> $form Form config.
 * @return array<string, mixed>
 */
function ac_tech_filter_booking_form_services( $form ) {
	$choices = ac_tech_get_booking_service_choices();
	if ( ! empty( $choices ) ) {
		$form['services'] = $choices;
	}
	return $form;
}
add_filter( 'ac_tech_booking_form', 'ac_tech_filter_booking_form_services', 20 );
