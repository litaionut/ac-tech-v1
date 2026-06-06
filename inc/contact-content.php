<?php
/**
 * Contact page defaults; overrides via ACF (contact-editable.php).
 *
 * @package AC-Tech
 */

/**
 * @return array<string, string>
 */
function ac_tech_get_contact_hero_fallback_base() {
	return apply_filters(
		'ac_tech_contact_hero_fallback',
		array(
			'text' => __( 'Ai întrebări sau vrei o ofertă personalizată? Completează formularul și revenim în cel mai scurt timp.', 'ac-tech' ),
		)
	);
}

/**
 * @deprecated Use ac_tech_get_contact_hero_fallback_base().
 * @return array<string, string>
 */
function ac_tech_get_contact_hero_fallback() {
	return ac_tech_get_contact_hero_fallback_base();
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_contact_form_base() {
	return apply_filters(
		'ac_tech_contact_form',
		array(
			'title'          => __( 'Trimite un mesaj', 'ac-tech' ),
			'name_label'     => __( 'Nume complet', 'ac-tech' ),
			'name_ph'        => __( 'Ion Popescu', 'ac-tech' ),
			'phone_label'    => __( 'Telefon', 'ac-tech' ),
			'phone_ph'       => __( '07xx xxx xxx', 'ac-tech' ),
			'email_label'    => __( 'E-mail', 'ac-tech' ),
			'email_ph'       => __( 'nume@exemplu.ro', 'ac-tech' ),
			'subject_label'  => __( 'Subiect', 'ac-tech' ),
			'subject_ph'     => __( 'Selectează subiectul', 'ac-tech' ),
			'subjects'       => array(
				'oferta'      => __( 'Cerere ofertă', 'ac-tech' ),
				'servicii'    => __( 'Informații servicii', 'ac-tech' ),
				'programare'  => __( 'Programare / disponibilitate', 'ac-tech' ),
				'parteneriat' => __( 'Parteneriat', 'ac-tech' ),
				'altele'      => __( 'Altele', 'ac-tech' ),
			),
			'message_label'  => __( 'Mesajul tău', 'ac-tech' ),
			'message_ph'     => __( 'Descrie solicitarea ta...', 'ac-tech' ),
			'submit'         => __( 'Trimite mesajul', 'ac-tech' ),
			'disclaimer'     => __( 'Datele tale sunt folosite doar pentru a răspunde solicitării.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_contact_form() {
	return ac_tech_get_contact_form_base();
}

/**
 * @return array<string, string>
 */
function ac_tech_get_contact_info_base() {
	$phone = function_exists( 'ac_tech_get_business_phone_display' ) ? ac_tech_get_business_phone_display() : '';
	$email = function_exists( 'ac_tech_get_business_email' ) ? ac_tech_get_business_email() : 'contact@ac-tech.ro';
	$schedule = function_exists( 'ac_tech_get_business_info' ) ? (string) ( ac_tech_get_business_info()['schedule'] ?? '' ) : __( 'Luni – Vineri: 09:00 – 18:00', 'ac-tech' );

	return apply_filters(
		'ac_tech_contact_info_defaults',
		array(
			'title'    => __( 'Date de contact', 'ac-tech' ),
			'email'    => $email,
			'phone'    => $phone,
			'schedule' => $schedule,
			'address'  => function_exists( 'ac_tech_get_business_address_line' ) ? ac_tech_get_business_address_line() : '',
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_contact_success() {
	return apply_filters(
		'ac_tech_contact_success',
		array(
			'title' => __( 'Mesaj trimis!', 'ac-tech' ),
			'text'  => __( 'Mulțumim pentru mesaj. Echipa AC-Tech îți va răspunde în curând la adresa de e-mail indicată.', 'ac-tech' ),
			'done'  => __( 'Închide', 'ac-tech' ),
		)
	);
}
