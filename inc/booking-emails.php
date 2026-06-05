<?php
/**
 * Booking email notifications.
 *
 * @package AC-Tech
 */

/**
 * @param int $booking_id Booking post ID.
 * @return bool
 */
function ac_tech_send_booking_emails( $booking_id ) {
	$booking_id = (int) $booking_id;
	if ( $booking_id <= 0 || 'ac_booking' !== get_post_type( $booking_id ) ) {
		return false;
	}

	$name    = (string) get_post_meta( $booking_id, 'name', true );
	$phone   = (string) get_post_meta( $booking_id, 'phone', true );
	$email   = (string) get_post_meta( $booking_id, 'email', true );
	$address = (string) get_post_meta( $booking_id, 'address', true );
	$service = (string) get_post_meta( $booking_id, 'service_slug', true );
	$urgency = (string) get_post_meta( $booking_id, 'urgency', true );
	$notes   = (string) get_post_meta( $booking_id, 'notes', true );
	$start   = (int) get_post_meta( $booking_id, 'service_start_ts', true );
	$end     = (int) get_post_meta( $booking_id, 'service_end_ts', true );
	if ( ! $start ) {
		$start = (int) get_post_meta( $booking_id, 'start_ts', true );
	}
	if ( ! $end ) {
		$end = (int) get_post_meta( $booking_id, 'end_ts', true );
	}

	$svc = ac_tech_get_booking_service( $service );
	$svc_label = $svc ? $svc['label'] : $service;

	$tz       = wp_timezone();
	$date_lbl = $start ? wp_date( 'd.m.Y', $start, $tz ) : '';
	$time_lbl = $start && $end ? wp_date( 'H:i', $start, $tz ) . ' – ' . wp_date( 'H:i', $end, $tz ) : '';

	$rules = ac_tech_get_booking_rules();
	$admin = ! empty( $rules['notify_email'] ) ? sanitize_email( $rules['notify_email'] ) : sanitize_email( get_option( 'admin_email' ) );

	$subject_admin = sprintf(
		/* translators: %s: customer name */
		__( 'Programare nouă: %s', 'ac-tech' ),
		$name
	);

	$body_admin = implode(
		"\n",
		array(
			__( 'Programare nouă pe site:', 'ac-tech' ),
			'',
			sprintf( '%s: %s', __( 'Nume', 'ac-tech' ), $name ),
			sprintf( '%s: %s', __( 'Telefon', 'ac-tech' ), $phone ),
			sprintf( '%s: %s', __( 'E-mail', 'ac-tech' ), $email ),
			sprintf( '%s: %s', __( 'Adresă', 'ac-tech' ), $address ),
			sprintf( '%s: %s', __( 'Serviciu', 'ac-tech' ), $svc_label ),
			sprintf( '%s: %s', __( 'Urgență', 'ac-tech' ), $urgency ),
			sprintf( '%s: %s %s', __( 'Data/ora', 'ac-tech' ), $date_lbl, $time_lbl ),
			$notes ? sprintf( '%s: %s', __( 'Observații', 'ac-tech' ), $notes ) : '',
		)
	);

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	$sent    = wp_mail( $admin, $subject_admin, $body_admin, $headers );

	if ( is_email( $email ) ) {
		$subject_client = __( 'Confirmare programare AC-Tech', 'ac-tech' );
		$body_client    = implode(
			"\n",
			array(
				sprintf( __( 'Bună %s,', 'ac-tech' ), $name ),
				'',
				__( 'Programarea ta a fost înregistrată:', 'ac-tech' ),
				sprintf( '%s: %s', __( 'Serviciu', 'ac-tech' ), $svc_label ),
				sprintf( '%s: %s %s', __( 'Data/ora', 'ac-tech' ), $date_lbl, $time_lbl ),
				sprintf( '%s: %s', __( 'Adresă', 'ac-tech' ), $address ),
				'',
				__( 'Te vom contacta dacă este nevoie de detalii suplimentare.', 'ac-tech' ),
			)
		);
		wp_mail( $email, $subject_client, $body_client, $headers );
	}

	return $sent;
}
