<?php
/**
 * Customizer — business NAP and Google Business Profile URLs.
 *
 * @package AC-Tech
 */

/**
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function ac_tech_customize_register_business( $wp_customize ) {
	$wp_customize->add_section(
		'ac_tech_business',
		array(
			'title'       => __( 'AC-tech — Date firmă (NAP / SEO)', 'ac-tech' ),
			'description' => __( 'Folosește aceleași date pe site, Google Business Profile și directoare locale.', 'ac-tech' ),
			'priority'    => 30,
		)
	);

	$fields = array(
		'ac_tech_business_phone'       => array( 'label' => __( 'Telefon (afișat)', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_phone_e164'  => array( 'label' => __( 'Telefon E.164 (tel: link, ex. +407xxxxxxxx)', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_whatsapp'    => array( 'label' => __( 'WhatsApp (doar cifre, ex. 407xxxxxxxx)', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_email'       => array( 'label' => __( 'Email public', 'ac-tech' ), 'type' => 'email' ),
		'ac_tech_business_street'      => array( 'label' => __( 'Adresă — stradă și număr', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_region'      => array( 'label' => __( 'Sector / zonă', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_locality'    => array( 'label' => __( 'Localitate', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_postal_code' => array( 'label' => __( 'Cod poștal', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_schedule'    => array( 'label' => __( 'Program', 'ac-tech' ), 'type' => 'text' ),
		'ac_tech_business_maps_url'    => array( 'label' => __( 'Link Google Maps', 'ac-tech' ), 'type' => 'url' ),
		'ac_tech_gbp_url'              => array( 'label' => __( 'Profil Google Business (Maps)', 'ac-tech' ), 'type' => 'url' ),
		'ac_tech_gbp_review_url'       => array( 'label' => __( 'Link solicitare recenzie Google', 'ac-tech' ), 'type' => 'url' ),
		'ac_tech_gbp_rating'           => array( 'label' => __( 'Rating Google (ex. 4.9) — afișat doar cu link recenzie', 'ac-tech' ), 'type' => 'text' ),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => '',
				'sanitize_callback' => 'ac_tech_sanitize_customizer_business_field',
			)
		);

		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'ac_tech_business',
				'type'    => $field['type'],
			)
		);
	}

	$wp_customize->add_section(
		'ac_tech_seo_tools',
		array(
			'title'       => __( 'AC-tech — SEO & Search Console', 'ac-tech' ),
			'description' => __( 'Verificare site Google Search Console (meta tag HTML).', 'ac-tech' ),
			'priority'    => 31,
		)
	);

	$wp_customize->add_setting(
		'ac_tech_google_site_verification',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'ac_tech_google_site_verification',
		array(
			'label'       => __( 'Cod verificare Google Search Console', 'ac-tech' ),
			'description' => __( 'Conținutul atributului content din meta tag-ul de verificare.', 'ac-tech' ),
			'section'     => 'ac_tech_seo_tools',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'ac_tech_customize_register_business', 20 );

/**
 * @param mixed $value Raw value.
 * @return string
 */
function ac_tech_sanitize_customizer_business_field( $value ) {
	$value = is_scalar( $value ) ? trim( (string) $value ) : '';
	if ( false !== strpos( $value, 'http' ) ) {
		return esc_url_raw( $value );
	}
	if ( is_email( $value ) ) {
		return sanitize_email( $value );
	}

	return sanitize_text_field( $value );
}
