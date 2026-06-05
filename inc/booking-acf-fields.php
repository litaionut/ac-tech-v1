<?php
/**
 * ACF field group: Booking settings (services, rules, blocks).
 *
 * @package AC-Tech
 */

/**
 * @return int Booking settings page ID (template-booking-settings.php) or 0.
 */
function ac_tech_get_booking_settings_page_id() {
	static $cached = null;
	if ( null !== $cached ) {
		return (int) $cached;
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'post_status'    => array( 'publish', 'draft', 'private' ),
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'template-booking-settings.php',
		)
	);

	$cached = ! empty( $pages[0] ) ? (int) $pages[0] : 0;
	return (int) $cached;
}

/**
 * Register booking settings ACF fields.
 */
function ac_tech_register_booking_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_ac_tech_booking_settings',
			'title'  => __( 'Booking — Setări', 'ac-tech' ),
			'fields' => array(
				array(
					'key'   => 'field_ac_tech_booking_tab_services',
					'label' => __( 'Servicii', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_booking_services',
					'label'        => __( 'Servicii', 'ac-tech' ),
					'name'         => 'booking_services',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă serviciu', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_ac_tech_booking_service_slug',
							'label' => __( 'Slug', 'ac-tech' ),
							'name'  => 'service_slug',
							'type'  => 'text',
							'instructions' => __( 'Ex.: igienizare, mentenanta, reparatie', 'ac-tech' ),
						),
						array(
							'key'   => 'field_ac_tech_booking_service_label',
							'label' => __( 'Etichetă', 'ac-tech' ),
							'name'  => 'service_label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_booking_service_duration',
							'label' => __( 'Durată (minute)', 'ac-tech' ),
							'name'  => 'service_duration_min',
							'type'  => 'number',
							'min'   => 15,
							'step'  => 5,
						),
						array(
							'key'   => 'field_ac_tech_booking_service_buffer_before',
							'label' => __( 'Buffer înainte (minute)', 'ac-tech' ),
							'name'  => 'service_buffer_before_min',
							'type'  => 'number',
							'min'   => 0,
							'step'  => 5,
							'default_value' => 0,
						),
						array(
							'key'   => 'field_ac_tech_booking_service_buffer_after',
							'label' => __( 'Buffer după (minute)', 'ac-tech' ),
							'name'  => 'service_buffer_after_min',
							'type'  => 'number',
							'min'   => 0,
							'step'  => 5,
							'default_value' => 0,
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_booking_tab_rules',
					'label' => __( 'Reguli', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_booking_working_days',
					'label' => __( 'Zile lucrătoare', 'ac-tech' ),
					'name'  => 'booking_working_days',
					'type'  => 'checkbox',
					'choices' => array(
						'1' => __( 'Luni', 'ac-tech' ),
						'2' => __( 'Marți', 'ac-tech' ),
						'3' => __( 'Miercuri', 'ac-tech' ),
						'4' => __( 'Joi', 'ac-tech' ),
						'5' => __( 'Vineri', 'ac-tech' ),
						'6' => __( 'Sâmbătă', 'ac-tech' ),
						'7' => __( 'Duminică', 'ac-tech' ),
					),
					'default_value' => array( '1', '2', '3', '4', '5' ),
				),
				array(
					'key'   => 'field_ac_tech_booking_day_start',
					'label' => __( 'Program — început', 'ac-tech' ),
					'name'  => 'booking_day_start',
					'type'  => 'time_picker',
					'display_format' => 'H:i',
					'return_format'  => 'H:i',
					'default_value'  => '08:00',
				),
				array(
					'key'   => 'field_ac_tech_booking_day_end',
					'label' => __( 'Program — sfârșit', 'ac-tech' ),
					'name'  => 'booking_day_end',
					'type'  => 'time_picker',
					'display_format' => 'H:i',
					'return_format'  => 'H:i',
					'default_value'  => '17:00',
				),
				array(
					'key'   => 'field_ac_tech_booking_slot_step',
					'label' => __( 'Pas slot (minute)', 'ac-tech' ),
					'name'  => 'booking_slot_step_min',
					'type'  => 'number',
					'min'   => 5,
					'step'  => 5,
					'default_value' => 30,
				),
				array(
					'key'   => 'field_ac_tech_booking_lead_hours',
					'label' => __( 'Minim înainte (ore)', 'ac-tech' ),
					'name'  => 'booking_lead_hours',
					'type'  => 'number',
					'min'   => 0,
					'step'  => 1,
					'default_value' => 6,
				),
				array(
					'key'   => 'field_ac_tech_booking_max_days',
					'label' => __( 'Maxim zile în avans', 'ac-tech' ),
					'name'  => 'booking_max_days_ahead',
					'type'  => 'number',
					'min'   => 1,
					'step'  => 1,
					'default_value' => 60,
				),
				array(
					'key'   => 'field_ac_tech_booking_notify_email',
					'label' => __( 'E-mail notificări (opțional)', 'ac-tech' ),
					'name'  => 'booking_notify_email',
					'type'  => 'email',
					'instructions' => __( 'Gol = e-mailul admin implicit.', 'ac-tech' ),
				),
				array(
					'key'           => 'field_ac_tech_booking_reservations_enabled',
					'label'         => __( 'Acceptă rezervări online', 'ac-tech' ),
					'name'          => 'booking_reservations_enabled',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
					'instructions'  => __( 'Dezactivat = formularul nu mai acceptă programări noi. Poți comuta rapid din Programări → banner.', 'ac-tech' ),
				),
				array(
					'key'   => 'field_ac_tech_booking_tab_blocks',
					'label' => __( 'Blocări calendar', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_booking_blocks',
					'label'        => __( 'Blocări', 'ac-tech' ),
					'name'         => 'booking_blocks',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă blocare', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'     => 'field_ac_tech_booking_block_type',
							'label'   => __( 'Tip', 'ac-tech' ),
							'name'    => 'block_type',
							'type'    => 'select',
							'choices' => array(
								'day'      => __( 'Zi întreagă', 'ac-tech' ),
								'interval' => __( 'Interval orar', 'ac-tech' ),
							),
						),
						array(
							'key'          => 'field_ac_tech_booking_block_services',
							'label'        => __( 'Servicii afectate', 'ac-tech' ),
							'name'         => 'block_services',
							'type'         => 'checkbox',
							'choices'      => ac_tech_booking_admin_service_choices(),
							'instructions' => __( 'Gol = toate serviciile.', 'ac-tech' ),
						),
						array(
							'key'   => 'field_ac_tech_booking_block_key',
							'label' => __( 'Cheie internă', 'ac-tech' ),
							'name'  => 'block_key',
							'type'  => 'text',
							'readonly' => 1,
						),
						array(
							'key'   => 'field_ac_tech_booking_block_date',
							'label' => __( 'Data', 'ac-tech' ),
							'name'  => 'block_date',
							'type'  => 'date_picker',
							'display_format' => 'Y-m-d',
							'return_format'  => 'Y-m-d',
						),
						array(
							'key'   => 'field_ac_tech_booking_block_start',
							'label' => __( 'Start (doar pentru interval)', 'ac-tech' ),
							'name'  => 'block_start',
							'type'  => 'time_picker',
							'display_format' => 'H:i',
							'return_format'  => 'H:i',
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_ac_tech_booking_block_type',
										'operator' => '==',
										'value'    => 'interval',
									),
								),
							),
						),
						array(
							'key'   => 'field_ac_tech_booking_block_end',
							'label' => __( 'End (doar pentru interval)', 'ac-tech' ),
							'name'  => 'block_end',
							'type'  => 'time_picker',
							'display_format' => 'H:i',
							'return_format'  => 'H:i',
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_ac_tech_booking_block_type',
										'operator' => '==',
										'value'    => 'interval',
									),
								),
							),
						),
						array(
							'key'   => 'field_ac_tech_booking_block_reason',
							'label' => __( 'Motiv (opțional)', 'ac-tech' ),
							'name'  => 'block_reason',
							'type'  => 'text',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-booking-settings.php',
					),
				),
			),
			'active' => true,
		)
	);
}
add_action( 'acf/init', 'ac_tech_register_booking_acf_field_group', 6 );

