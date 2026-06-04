<?php
/**
 * Static content for the Booking page.
 *
 * @package AC-Tech
 */

/**
 * URL of the booking page.
 *
 * @return string
 */
function ac_tech_get_booking_url() {
	return apply_filters( 'ac_tech_booking_url', home_url( '/programare/' ) );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_booking_hero() {
	return apply_filters(
		'ac_tech_booking_hero',
		array(
			'title' => __( 'Confort de precizie', 'ac-tech' ),
			'text'  => __( 'Programează serviciul premium de climatizare în mai puțin de două minute. Aer curat la doar câteva clicuri distanță.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_booking_form() {
	return apply_filters(
		'ac_tech_booking_form',
		array(
			'title'       => __( 'Date personale', 'ac-tech' ),
			'name_label'  => __( 'Nume complet', 'ac-tech' ),
			'name_ph'     => __( 'Ion Popescu', 'ac-tech' ),
			'phone_label' => __( 'Telefon', 'ac-tech' ),
			'phone_ph'    => __( '07xx xxx xxx', 'ac-tech' ),
			'email_label' => __( 'E-mail', 'ac-tech' ),
			'email_ph'    => __( 'nume@exemplu.ro', 'ac-tech' ),
			'address_label' => __( 'Adresa intervenției', 'ac-tech' ),
			'address_ph'  => __( 'Stradă, număr, bloc, apartament', 'ac-tech' ),
			'service_label' => __( 'Tip serviciu', 'ac-tech' ),
			'service_ph'  => __( 'Selectează serviciul', 'ac-tech' ),
			'services'    => array(
				'igienizare'   => __( 'Igienizare aer condiționat', 'ac-tech' ),
				'mentenanta'   => __( 'Întreținere / revizie', 'ac-tech' ),
				'reparatie'    => __( 'Reparație urgență', 'ac-tech' ),
				'instalare'    => __( 'Instalare nouă', 'ac-tech' ),
				'consultanta'  => __( 'Consultanță eficiență energetică', 'ac-tech' ),
			),
			'urgency_label' => __( 'Urgență', 'ac-tech' ),
			'urgency_standard' => __( 'Standard', 'ac-tech' ),
			'urgency_urgent'   => __( 'Urgent', 'ac-tech' ),
			'notes_label' => __( 'Observații și cerințe speciale', 'ac-tech' ),
			'notes_ph'    => __( 'Descrie problema sau cerințele tale...', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_booking_calendar() {
	return apply_filters(
		'ac_tech_booking_calendar',
		array(
			'title'       => __( 'Selectează data și ora', 'ac-tech' ),
			'slots_label' => __( 'Intervale disponibile', 'ac-tech' ),
			'time_slots'  => array(
				'08:00-10:00' => '08:00 - 10:00',
				'10:00-12:00' => '10:00 - 12:00',
				'13:00-15:00' => '13:00 - 15:00',
				'15:00-17:00' => '15:00 - 17:00',
			),
			'weekdays'    => array(
				__( 'D', 'ac-tech' ),
				__( 'L', 'ac-tech' ),
				__( 'M', 'ac-tech' ),
				__( 'Mi', 'ac-tech' ),
				__( 'J', 'ac-tech' ),
				__( 'V', 'ac-tech' ),
				__( 'S', 'ac-tech' ),
			),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_booking_summary() {
	return apply_filters(
		'ac_tech_booking_summary',
		array(
			'cost_label'  => __( 'Cost estimativ', 'ac-tech' ),
			'cost_value'  => __( 'de la 189 lei', 'ac-tech' ),
			'submit'      => __( 'Confirmă programarea', 'ac-tech' ),
			'disclaimer'  => __( 'Plata nu este necesară până la finalizarea serviciului.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_booking_success() {
	return apply_filters(
		'ac_tech_booking_success',
		array(
			'title'       => __( 'Programare confirmată!', 'ac-tech' ),
			'text'        => __( 'Programarea ta este înregistrată. Vei primi un e-mail de confirmare în curând.', 'ac-tech' ),
			'text_detail' => __( 'Programare: %1$s la %2$s.', 'ac-tech' ),
			'done'        => __( 'Închide', 'ac-tech' ),
			'calendar'    => __( 'Adaugă în calendar', 'ac-tech' ),
		)
	);
}
