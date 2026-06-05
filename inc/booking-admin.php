<?php
/**
 * Booking admin UI — ACF fields, sync meta, list columns.
 *
 * @package AC-Tech
 */

/**
 * Flag to skip admin sync during API persistence.
 *
 * @param bool $set Optional set value.
 * @return bool
 */
function ac_tech_booking_api_save_flag( $set = null ) {
	static $flag = false;
	if ( null !== $set ) {
		$flag = (bool) $set;
	}
	return $flag;
}

/**
 * @return array<string, string>
 */
function ac_tech_booking_admin_service_choices() {
	$choices = ac_tech_get_booking_service_choices();
	if ( empty( $choices ) ) {
		return array();
	}
	return $choices;
}

/**
 * Register ACF fields on booking posts.
 */
function ac_tech_register_booking_post_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_ac_tech_booking_post',
			'title'  => __( 'Detalii programare', 'ac-tech' ),
			'fields' => array(
				array(
					'key'   => 'field_ac_tech_booking_post_tab_client',
					'label' => __( 'Client', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_booking_post_name',
					'label' => __( 'Nume complet', 'ac-tech' ),
					'name'  => 'name',
					'type'  => 'text',
					'required' => 1,
				),
				array(
					'key'   => 'field_ac_tech_booking_post_phone',
					'label' => __( 'Telefon', 'ac-tech' ),
					'name'  => 'phone',
					'type'  => 'text',
					'required' => 1,
				),
				array(
					'key'   => 'field_ac_tech_booking_post_email',
					'label' => __( 'E-mail', 'ac-tech' ),
					'name'  => 'email',
					'type'  => 'email',
					'required' => 1,
				),
				array(
					'key'   => 'field_ac_tech_booking_post_address',
					'label' => __( 'Adresa intervenției', 'ac-tech' ),
					'name'  => 'address',
					'type'  => 'text',
					'required' => 1,
				),
				array(
					'key'   => 'field_ac_tech_booking_post_tab_schedule',
					'label' => __( 'Programare', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_ac_tech_booking_post_service',
					'label'   => __( 'Serviciu', 'ac-tech' ),
					'name'    => 'service_slug',
					'type'    => 'select',
					'choices' => ac_tech_booking_admin_service_choices(),
					'ui'      => 1,
					'required' => 1,
				),
				array(
					'key'            => 'field_ac_tech_booking_post_date',
					'label'          => __( 'Data', 'ac-tech' ),
					'name'           => 'booking_date',
					'type'           => 'date_picker',
					'display_format' => 'd.m.Y',
					'return_format'  => 'Y-m-d',
					'required'       => 1,
				),
				array(
					'key'            => 'field_ac_tech_booking_post_start',
					'label'          => __( 'Ora start', 'ac-tech' ),
					'name'           => 'booking_start_time',
					'type'           => 'time_picker',
					'display_format' => 'H:i',
					'return_format'  => 'H:i',
					'required'       => 1,
				),
				array(
					'key'            => 'field_ac_tech_booking_post_end',
					'label'          => __( 'Ora sfârșit (estimat)', 'ac-tech' ),
					'name'           => 'booking_end_time',
					'type'           => 'time_picker',
					'display_format' => 'H:i',
					'return_format'  => 'H:i',
					'readonly'       => 1,
					'disabled'       => 1,
				),
				array(
					'key'     => 'field_ac_tech_booking_post_urgency',
					'label'   => __( 'Urgență', 'ac-tech' ),
					'name'    => 'urgency',
					'type'    => 'select',
					'choices' => array(
						'standard' => __( 'Standard', 'ac-tech' ),
						'urgent'   => __( 'Urgent', 'ac-tech' ),
					),
					'default_value' => 'standard',
				),
				array(
					'key'     => 'field_ac_tech_booking_post_status',
					'label'   => __( 'Status', 'ac-tech' ),
					'name'    => 'status',
					'type'    => 'select',
					'choices' => array(
						'confirmed' => __( 'Confirmată', 'ac-tech' ),
						'pending'   => __( 'În așteptare', 'ac-tech' ),
						'cancelled' => __( 'Anulată', 'ac-tech' ),
					),
					'default_value' => 'confirmed',
				),
				array(
					'key'   => 'field_ac_tech_booking_post_notes',
					'label' => __( 'Observații', 'ac-tech' ),
					'name'  => 'notes',
					'type'  => 'textarea',
					'rows'  => 4,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ac_booking',
					),
				),
			),
			'position' => 'normal',
			'style'    => 'default',
			'active'   => true,
		)
	);
}
add_action( 'acf/init', 'ac_tech_register_booking_post_acf_field_group', 6 );

/**
 * @param int   $booking_id Booking ID.
 * @param array $data       Booking data.
 * @return true|WP_Error
 */
function ac_tech_save_booking_fields( $booking_id, $data ) {
	$booking_id = (int) $booking_id;
	if ( $booking_id <= 0 ) {
		return new WP_Error( 'invalid_booking', __( 'ID programare invalid.', 'ac-tech' ) );
	}

	$service_slug = sanitize_title( (string) ( $data['service_slug'] ?? '' ) );
	$date         = sanitize_text_field( (string) ( $data['booking_date'] ?? $data['date'] ?? '' ) );
	$start_time   = sanitize_text_field( (string) ( $data['booking_start_time'] ?? $data['start_time'] ?? '' ) );
	$name         = sanitize_text_field( (string) ( $data['name'] ?? '' ) );
	$phone        = sanitize_text_field( (string) ( $data['phone'] ?? '' ) );
	$email        = sanitize_email( (string) ( $data['email'] ?? '' ) );
	$address      = sanitize_text_field( (string) ( $data['address'] ?? '' ) );
	$urgency      = sanitize_key( (string) ( $data['urgency'] ?? 'standard' ) );
	$notes        = sanitize_textarea_field( (string) ( $data['notes'] ?? '' ) );
	$status       = sanitize_key( (string) ( $data['status'] ?? 'confirmed' ) );

	if ( '' === $service_slug || '' === $date || '' === $start_time ) {
		return new WP_Error( 'missing_schedule', __( 'Serviciu, dată și oră sunt obligatorii.', 'ac-tech' ) );
	}

	$service = ac_tech_get_booking_service( $service_slug );
	if ( ! $service ) {
		return new WP_Error( 'invalid_service', __( 'Serviciu invalid.', 'ac-tech' ) );
	}

	$interval = ac_tech_booking_interval_for_service( $service, $date, $start_time );
	$tz       = wp_timezone();
	$end_time = wp_date( 'H:i', $interval['service_end_ts'], $tz );

	ac_tech_booking_api_save_flag( true );

	$meta_map = array(
		'service_slug'       => $service_slug,
		'booking_date'       => $date,
		'booking_start_time' => $start_time,
		'booking_end_time'   => $end_time,
		'start_ts'           => $interval['start_ts'],
		'end_ts'             => $interval['end_ts'],
		'service_start_ts'   => $interval['service_start_ts'],
		'service_end_ts'     => $interval['service_end_ts'],
		'name'               => $name,
		'phone'              => $phone,
		'email'              => $email,
		'address'            => $address,
		'urgency'            => $urgency,
		'notes'              => $notes,
		'status'             => $status,
	);

	foreach ( $meta_map as $key => $value ) {
		update_post_meta( $booking_id, $key, $value );
		if ( function_exists( 'update_field' ) ) {
			update_field( $key, $value, $booking_id );
		}
	}

	$title = sprintf(
		'%s — %s %s',
		$name ? $name : __( 'Programare', 'ac-tech' ),
		wp_date( 'd.m.Y', $interval['service_start_ts'], $tz ),
		wp_date( 'H:i', $interval['service_start_ts'], $tz )
	);

	wp_update_post(
		array(
			'ID'         => $booking_id,
			'post_title' => $title,
		)
	);

	ac_tech_booking_api_save_flag( false );

	return true;
}

/**
 * Sync timestamps when booking is saved in admin (ACF).
 *
 * @param int|string $post_id Post ID.
 */
function ac_tech_sync_booking_on_acf_save( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 || 'ac_booking' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( ac_tech_booking_api_save_flag() ) {
		return;
	}

	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$data = array(
		'service_slug'       => get_field( 'service_slug', $post_id ),
		'booking_date'       => get_field( 'booking_date', $post_id ),
		'booking_start_time' => get_field( 'booking_start_time', $post_id ),
		'name'               => get_field( 'name', $post_id ),
		'phone'              => get_field( 'phone', $post_id ),
		'email'              => get_field( 'email', $post_id ),
		'address'            => get_field( 'address', $post_id ),
		'urgency'            => get_field( 'urgency', $post_id ),
		'notes'              => get_field( 'notes', $post_id ),
		'status'             => get_field( 'status', $post_id ),
	);

	if ( empty( $data['booking_date'] ) || empty( $data['booking_start_time'] ) || empty( $data['service_slug'] ) ) {
		return;
	}

	ac_tech_save_booking_fields( $post_id, $data );
}
add_action( 'acf/save_post', 'ac_tech_sync_booking_on_acf_save', 20 );

/**
 * Populate date/time fields from timestamps when missing.
 *
 * @param mixed $value   Value.
 * @param mixed $post_id Post ID.
 * @param array $field   Field.
 * @return mixed
 */
function ac_tech_acf_load_booking_post_field_value( $value, $post_id, $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $value;
	}

	$post_id = (int) $post_id;
	if ( $post_id <= 0 || 'ac_booking' !== get_post_type( $post_id ) ) {
		return $value;
	}

	if ( ! ac_tech_editable_value_is_empty( $value ) ) {
		return $value;
	}

	$name = (string) $field['name'];
	$tz   = wp_timezone();

	if ( 'booking_date' === $name ) {
		$ts = (int) get_post_meta( $post_id, 'service_start_ts', true );
		return $ts ? wp_date( 'Y-m-d', $ts, $tz ) : $value;
	}

	if ( 'booking_start_time' === $name ) {
		$ts = (int) get_post_meta( $post_id, 'service_start_ts', true );
		return $ts ? wp_date( 'H:i', $ts, $tz ) : $value;
	}

	if ( 'booking_end_time' === $name ) {
		$ts = (int) get_post_meta( $post_id, 'service_end_ts', true );
		return $ts ? wp_date( 'H:i', $ts, $tz ) : $value;
	}

	$simple = array( 'name', 'phone', 'email', 'address', 'service_slug', 'urgency', 'notes', 'status' );
	if ( in_array( $name, $simple, true ) ) {
		$stored = get_post_meta( $post_id, $name, true );
		return ( '' !== $stored && null !== $stored ) ? $stored : $value;
	}

	return $value;
}
add_filter( 'acf/load_value', 'ac_tech_acf_load_booking_post_field_value', 10, 3 );

/**
 * Admin list columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function ac_tech_booking_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['booking_datetime'] = __( 'Data / oră', 'ac-tech' );
			$new['booking_client']   = __( 'Client', 'ac-tech' );
			$new['booking_phone']    = __( 'Telefon', 'ac-tech' );
			$new['booking_service']  = __( 'Serviciu', 'ac-tech' );
		}
	}
	return $new;
}
add_filter( 'manage_ac_booking_posts_columns', 'ac_tech_booking_admin_columns' );

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function ac_tech_booking_admin_column_content( $column, $post_id ) {
	$tz = wp_timezone();

	switch ( $column ) {
		case 'booking_datetime':
			$start = (int) get_post_meta( $post_id, 'service_start_ts', true );
			$end   = (int) get_post_meta( $post_id, 'service_end_ts', true );
			if ( $start ) {
				echo esc_html( wp_date( 'd.m.Y H:i', $start, $tz ) );
				if ( $end ) {
					echo ' – ' . esc_html( wp_date( 'H:i', $end, $tz ) );
				}
			} else {
				$date = get_post_meta( $post_id, 'booking_date', true );
				$time = get_post_meta( $post_id, 'booking_start_time', true );
				echo esc_html( trim( $date . ' ' . $time ) );
			}
			break;

		case 'booking_client':
			echo esc_html( (string) get_post_meta( $post_id, 'name', true ) );
			$email = get_post_meta( $post_id, 'email', true );
			if ( $email ) {
				echo '<br><a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
			}
			break;

		case 'booking_phone':
			echo esc_html( (string) get_post_meta( $post_id, 'phone', true ) );
			break;

		case 'booking_service':
			$slug = (string) get_post_meta( $post_id, 'service_slug', true );
			$svc  = ac_tech_get_booking_service( $slug );
			echo esc_html( $svc ? $svc['label'] : $slug );
			break;
	}
}
add_action( 'manage_ac_booking_posts_custom_column', 'ac_tech_booking_admin_column_content', 10, 2 );
