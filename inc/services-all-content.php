<?php
/**
 * Default content for the Services catalog page (servicii_all.html).
 *
 * @package AC-Tech
 */

/**
 * @return string
 */
function ac_tech_services_all_default_cta_url() {
	if ( function_exists( 'ac_tech_get_booking_url' ) ) {
		return ac_tech_get_booking_url();
	}

	return home_url( '/contact/' );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_services_all_hero_base() {
	return apply_filters(
		'ac_tech_services_all_hero_base',
		array(
			'badge' => __( 'Servicii Premium', 'ac-tech' ),
			'title' => __( 'Expertiză tehnică pentru confortul tău absolut', 'ac-tech' ),
			'text'  => __( 'Asigurăm soluții complete de climatizare, de la instalări precise la mentenanță avansată. Fiecare serviciu este executat cu rigoare tehnică și grijă pentru calitatea aerului din casa ta.', 'ac-tech' ),
		)
	);
}

/**
 * @param string $key Fallback image key.
 * @return array<string, mixed>|null
 */
function ac_tech_get_services_all_image_fallback( $key ) {
	$map = apply_filters(
		'ac_tech_services_all_image_fallbacks',
		array(
			'instalare'  => array(
				'slug'    => 'service-instalare',
				'dir'     => 'home',
				'widths'  => array( 400, 768 ),
				'sizes'   => '(min-width: 64rem) 50vw, 100vw',
				'alt'     => __( 'Instalare profesională aer condiționat', 'ac-tech' ),
				'class'   => 'ac-tech-services-all__media-img',
				'loading' => 'lazy',
			),
			'igienizare' => array(
				'slug'    => 'service-igienizare',
				'dir'     => 'home',
				'widths'  => array( 400, 768 ),
				'sizes'   => '(min-width: 64rem) 50vw, 100vw',
				'alt'     => __( 'Igienizare profesională aer condiționat', 'ac-tech' ),
				'class'   => 'ac-tech-services-all__media-img',
				'loading' => 'lazy',
			),
			'freon'      => array(
				'slug'    => 'igienizare-presiune',
				'dir'     => 'service-igienizare',
				'widths'  => array( 400, 768 ),
				'sizes'   => '(min-width: 64rem) 50vw, 100vw',
				'alt'     => __( 'Verificare presiune freon', 'ac-tech' ),
				'class'   => 'ac-tech-services-all__media-img ac-tech-services-all__media-img--framed',
				'loading' => 'lazy',
			),
			'diagnostic' => array(
				'slug'    => 'service-diagnostic',
				'dir'     => 'home',
				'widths'  => array( 400, 768 ),
				'sizes'   => '(min-width: 64rem) 50vw, 100vw',
				'alt'     => __( 'Diagnostic tehnic aer condiționat', 'ac-tech' ),
				'class'   => 'ac-tech-services-all__media-img',
				'loading' => 'lazy',
			),
		)
	);

	$key = sanitize_key( (string) $key );

	return isset( $map[ $key ] ) ? $map[ $key ] : null;
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_services_all_items_base() {
	$cta_url = ac_tech_services_all_default_cta_url();

	return apply_filters(
		'ac_tech_services_all_items_base',
		array(
			array(
				'layout'              => 'split',
				'image_fallback_key'  => 'instalare',
				'title'               => __( 'Instalare aer condiționat', 'ac-tech' ),
				'text'                => __( 'O instalare corectă este fundamentul performanței pe termen lung. Echipa noastră autorizată utilizează echipamente profesionale pentru a asigura un montaj curat, estetic și eficient din punct de vedere energetic.', 'ac-tech' ),
				'bullets'             => array(
					array(
						'icon' => 'check_circle',
						'text' => __( 'Consultanță în alegerea locului optim de montaj', 'ac-tech' ),
					),
					array(
						'icon' => 'check_circle',
						'text' => __( 'Utilizarea kiturilor de instalare premium', 'ac-tech' ),
					),
					array(
						'icon' => 'check_circle',
						'text' => __( 'Testare riguroasă a presiunii și etanșeității', 'ac-tech' ),
					),
				),
				'duration'            => __( '3 - 5 ore', 'ac-tech' ),
				'duration_icon'       => 'schedule',
				'cta_label'           => __( 'Programează acum', 'ac-tech' ),
				'cta_url'             => $cta_url,
			),
			array(
				'layout'              => 'split_reverse',
				'image_fallback_key'  => 'igienizare',
				'title'               => __( 'Igienizare profesională', 'ac-tech' ),
				'text'                => __( 'Protejează sănătatea familiei tale prin eliminarea bacteriilor, mucegaiului și alergenilor. Folosim soluții virucide și bactericide avizate, sigure pentru mediu și locuință.', 'ac-tech' ),
				'bullets'             => array(
					array(
						'icon' => 'shield',
						'text' => __( 'Dezinfectare cu aburi la temperaturi înalte', 'ac-tech' ),
					),
					array(
						'icon' => 'shield',
						'text' => __( 'Aplicare tratament anti-fungic de lungă durată', 'ac-tech' ),
					),
					array(
						'icon' => 'shield',
						'text' => __( 'Eliminarea mirosurilor neplăcute persistente', 'ac-tech' ),
					),
				),
				'duration'            => __( '60 - 90 min', 'ac-tech' ),
				'duration_icon'       => 'schedule',
				'cta_label'           => __( 'Programează acum', 'ac-tech' ),
				'cta_url'             => home_url( '/igienizare-ac/' ),
			),
			array(
				'layout'        => 'card',
				'card_icon'     => 'filter_alt',
				'title'         => __( 'Curățare evaporator și condensator', 'ac-tech' ),
				'text'          => __( 'Optimizăm schimbul de căldură prin curățarea profundă a lamelor metalice, prevenind supraîncălzirea compresorului.', 'ac-tech' ),
				'bullets'       => array(
					array(
						'icon' => 'check_circle',
						'text' => __( 'Eficiență termică maximă', 'ac-tech' ),
					),
					array(
						'icon' => 'check_circle',
						'text' => __( 'Reducerea consumului electric', 'ac-tech' ),
					),
				),
				'duration'      => __( '~ 2 ore', 'ac-tech' ),
				'duration_icon' => 'schedule',
				'cta_label'     => __( 'Programează acum', 'ac-tech' ),
				'cta_url'       => $cta_url,
			),
			array(
				'layout'        => 'card',
				'card_icon'     => 'update',
				'title'         => __( 'Întreținere periodică', 'ac-tech' ),
				'text'          => __( 'Programul nostru de mentenanță preventivă prelungește viața aparatului și te scapă de costurile reparațiilor neprevăzute.', 'ac-tech' ),
				'bullets'       => array(
					array(
						'icon' => 'check_circle',
						'text' => __( 'Verificări sezoniere complete', 'ac-tech' ),
					),
					array(
						'icon' => 'check_circle',
						'text' => __( 'Prioritate la intervenții', 'ac-tech' ),
					),
				),
				'duration'      => __( 'Anual', 'ac-tech' ),
				'duration_icon' => 'schedule',
				'cta_label'     => __( 'Programează acum', 'ac-tech' ),
				'cta_url'       => $cta_url,
			),
			array(
				'layout'              => 'panel',
				'image_fallback_key'  => 'freon',
				'title'               => __( 'Verificare și încărcare freon', 'ac-tech' ),
				'text'                => __( 'Dacă aparatul nu mai răcește ca înainte, ar putea fi o pierdere de agent frigorific. Realizăm verificări manometrice și încărcări de precizie conform specificațiilor producătorului.', 'ac-tech' ),
				'highlights'          => array(
					array(
						'icon'  => 'sensors',
						'label' => __( 'Detectare scurgeri', 'ac-tech' ),
					),
					array(
						'icon'  => 'analytics',
						'label' => __( 'Cântărire electronică', 'ac-tech' ),
					),
				),
				'cta_label'           => __( 'Cere o verificare', 'ac-tech' ),
				'cta_url'             => $cta_url,
			),
			array(
				'layout'              => 'split_reverse',
				'image_fallback_key'  => 'diagnostic',
				'title'               => __( 'Diagnostic și reparații', 'ac-tech' ),
				'text'                => __( 'Zgomote neobișnuite? Coduri de eroare pe display? Identificăm rapid cauza defecțiunii și oferim soluții de reparație folosind piese de schimb originale.', 'ac-tech' ),
				'bullets'             => array(
					array(
						'icon' => 'construction',
						'text' => __( 'Reparații plăci electronice și senzori', 'ac-tech' ),
					),
					array(
						'icon' => 'construction',
						'text' => __( 'Înlocuire compresoare și motoare ventilatoare', 'ac-tech' ),
					),
					array(
						'icon' => 'construction',
						'text' => __( 'Garanție pentru orice manoperă efectuată', 'ac-tech' ),
					),
				),
				'duration'            => __( 'Intervenție rapidă', 'ac-tech' ),
				'duration_icon'       => 'bolt',
				'cta_label'           => __( 'Solicită diagnostic', 'ac-tech' ),
				'cta_url'             => $cta_url,
			),
		)
	);
}
