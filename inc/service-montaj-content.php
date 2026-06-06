<?php
/**
 * Montaj aer condiționat București — page content.
 *
 * @package AC-Tech
 */

/**
 * @return string
 */
function ac_tech_get_service_montaj_booking_url() {
	if ( function_exists( 'ac_tech_get_booking_url' ) ) {
		return ac_tech_get_booking_url();
	}

	return home_url( '/programare/' );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_service_montaj_hero() {
	$phone = function_exists( 'ac_tech_get_business_phone_tel' ) ? ac_tech_get_business_phone_tel() : '';
	$phone_label = function_exists( 'ac_tech_get_business_phone_display' ) ? ac_tech_get_business_phone_display() : '';

	return apply_filters(
		'ac_tech_service_montaj_hero',
		array(
			'badge'       => __( 'Montaj autorizat', 'ac-tech' ),
			'title'       => __( 'Montaj aer condiționat București și Ilfov', 'ac-tech' ),
			'text'        => __( 'Instalare profesională pentru apartamente, case și spații comerciale. Vacuum, verificare de funcționare și garanție pentru manoperă — cu programare online rapidă.', 'ac-tech' ),
			'cta_label'   => __( 'Programează montajul', 'ac-tech' ),
			'cta_url'     => ac_tech_get_service_montaj_booking_url(),
			'phone'       => $phone,
			'phone_label' => $phone_label ? $phone_label : __( 'Sună acum', 'ac-tech' ),
			'image'       => array(
				'slug'          => 'hero-hvac',
				'dir'           => 'home',
				'alt'           => __( 'Montaj aer condiționat București', 'ac-tech' ),
				'width'         => 800,
				'height'        => 600,
				'widths'        => array( 800, 1200 ),
				'sizes'         => '(min-width: 64rem) 50vw, 100vw',
				'use_picture'   => true,
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'class'         => 'ac-tech-svc-montaj-hero__image',
			),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_service_montaj_includes_header() {
	return apply_filters(
		'ac_tech_service_montaj_includes_header',
		array(
			'title' => __( 'Ce include montajul', 'ac-tech' ),
			'text'  => __( 'Un montaj corect protejează garanția aparatului și reduce consumul pe termen lung.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<int, array{icon: string, title: string, text: string}>
 */
function ac_tech_get_service_montaj_includes() {
	return apply_filters(
		'ac_tech_service_montaj_includes',
		array(
			array(
				'icon'  => 'construction',
				'title' => __( 'Montaj unități', 'ac-tech' ),
				'text'  => __( 'Poziționare și fixare unitate interioară și exterioară conform normelor.', 'ac-tech' ),
			),
			array(
				'icon'  => 'engineering',
				'title' => __( 'Traseu frigorific', 'ac-tech' ),
				'text'  => __( 'Realizare traseu standard, izolație și etanșare corectă.', 'ac-tech' ),
			),
			array(
				'icon'  => 'verified',
				'title' => __( 'Vacuum & test', 'ac-tech' ),
				'text'  => __( 'Vidare instalație, verificare presiuni și punere în funcțiune.', 'ac-tech' ),
			),
			array(
				'icon'  => 'speed',
				'title' => __( 'Durată ~1 oră', 'ac-tech' ),
				'text'  => __( 'Pentru montaj standard; lucrările complexe pot dura mai mult.', 'ac-tech' ),
			),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_service_montaj_pricing_header() {
	return apply_filters(
		'ac_tech_service_montaj_pricing_header',
		array(
			'title' => __( 'Preț montaj aer condiționat București', 'ac-tech' ),
			'text'  => __( 'Prețuri orientative pentru traseu standard (max. 3 m). Oferta finală depinde de acces, etaj și lungimea traseului.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<int, array<string, string>>
 */
function ac_tech_get_service_montaj_pricing_rows() {
	return apply_filters(
		'ac_tech_service_montaj_pricing_rows',
		array(
			array(
				'capacity' => '9.000 – 12.000 BTU',
				'with_kit' => '550 lei',
				'no_kit'   => '700 lei',
			),
			array(
				'capacity' => '18.000 BTU',
				'with_kit' => '650 lei',
				'no_kit'   => '800 lei',
			),
			array(
				'capacity' => '24.000 BTU',
				'with_kit' => '750 lei',
				'no_kit'   => '900 lei',
			),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_service_montaj_zones_header() {
	return apply_filters(
		'ac_tech_service_montaj_zones_header',
		array(
			'title' => __( 'Zone acoperite', 'ac-tech' ),
			'text'  => __( 'Intervenim rapid în București (toate sectoarele) și în localitățile din Ilfov.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<int, array{label: string, slug: string}>
 */
function ac_tech_get_service_montaj_zones() {
	$zones = array(
		array( 'label' => __( 'Sector 1', 'ac-tech' ), 'slug' => 'sector-1' ),
		array( 'label' => __( 'Sector 2', 'ac-tech' ), 'slug' => 'sector-2' ),
		array( 'label' => __( 'Sector 3', 'ac-tech' ), 'slug' => 'sector-3' ),
		array( 'label' => __( 'Sector 4', 'ac-tech' ), 'slug' => 'sector-4' ),
		array( 'label' => __( 'Sector 5', 'ac-tech' ), 'slug' => 'sector-5' ),
		array( 'label' => __( 'Sector 6', 'ac-tech' ), 'slug' => 'sector-6' ),
		array( 'label' => __( 'Ilfov', 'ac-tech' ), 'slug' => 'ilfov' ),
	);

	return apply_filters( 'ac_tech_service_montaj_zones', $zones );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_service_montaj_cta() {
	$phone = function_exists( 'ac_tech_get_business_phone_tel' ) ? ac_tech_get_business_phone_tel() : '';

	return apply_filters(
		'ac_tech_service_montaj_cta',
		array(
			'title'     => __( 'Programează montajul AC', 'ac-tech' ),
			'text'      => __( 'Alege data și ora potrivite online sau contactează-ne pentru o ofertă personalizată.', 'ac-tech' ),
			'cta_label' => __( 'Programare online', 'ac-tech' ),
			'cta_url'   => ac_tech_get_service_montaj_booking_url(),
			'phone'     => $phone,
		)
	);
}

/**
 * Service schema for Montaj page.
 *
 * @return array<string, mixed>
 */
function ac_tech_get_service_montaj_schema() {
	$url = function_exists( 'ac_tech_get_montaj_page_url' ) ? ac_tech_get_montaj_page_url() : home_url( '/' );

	return array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Service',
		'name'        => __( 'Montaj aer condiționat București', 'ac-tech' ),
		'description' => __( 'Montaj profesional aparate aer condiționat rezidențiale și comerciale în București și Ilfov.', 'ac-tech' ),
		'provider'    => array(
			'@type' => 'HVACBusiness',
			'name'  => get_bloginfo( 'name', 'display' ),
			'url'   => home_url( '/' ),
		),
		'areaServed'  => array( 'București', 'Ilfov' ),
		'url'         => $url,
	);
}
