<?php
/**
 * Homepage content defaults; hero overrides via ACF / Customizer (see home-hero-editable.php).
 *
 * @package AC-Tech
 */

/**
 * Default homepage hero (theme mockup) — without ACF / Customizer overrides.
 *
 * @return array<string, mixed>
 */
function ac_tech_get_home_hero_base() {
	$primary_url = function_exists( 'ac_tech_get_booking_url' )
		? ac_tech_get_booking_url()
		: home_url( '/programare/' );

	return apply_filters(
		'ac_tech_home_hero_base',
		array(
			'badge_icon'        => 'ac_unit',
			'badge_text'        => __( 'Service Autorizat', 'ac-tech' ),
			'title'             => __( 'Aer curat. Confort maxim.', 'ac-tech' ),
			'title_accent'      => __( 'Servicii profesionale.', 'ac-tech' ),
			'text'              => __( 'Instalare, mentenanță și igienizare profesională pentru locuințe și spații comerciale. Performanță garantată pentru orice sistem de climatizare.', 'ac-tech' ),
			'cta_primary'       => __( 'Programează o intervenție', 'ac-tech' ),
			'cta_primary_icon'  => 'calendar_today',
			'cta_secondary'     => __( 'Solicită ofertă', 'ac-tech' ),
			'cta_primary_url'   => $primary_url,
			'cta_secondary_url' => home_url( '/contact/' ),
			'image'             => array(
				'slug'            => 'hero-hvac',
				'alt'             => __( 'Tehnician HVAC inspectează un aparat de aer condiționat montat pe perete', 'ac-tech' ),
				'widths'          => array( 800, 1200 ),
				'src_width'       => 800,
				'sizes'           => '(min-width: 64rem) 50vw, 100vw',
				'loading'         => 'eager',
				'fetchpriority'   => 'high',
				'class'           => 'ac-tech-home-hero__image',
				'use_picture'     => true,
				'omit_dimensions' => true,
			),
			'card_icon'         => 'verified',
			'card_title'        => __( '100% Garanție', 'ac-tech' ),
			'card_text'         => __( 'Pentru orice lucrare', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_home_hero() {
	$hero = apply_filters( 'ac_tech_home_hero', ac_tech_get_home_hero_base() );

	if ( function_exists( 'ac_tech_home_hero_apply_editable' ) ) {
		$hero = ac_tech_home_hero_apply_editable( $hero );
	}

	return $hero;
}

/**
 * @return array<string, string>
 */
function ac_tech_get_home_advantages_header_base() {
	return apply_filters(
		'ac_tech_home_advantages_header',
		array(
			'title' => __( 'De ce să ne alegi pe noi?', 'ac-tech' ),
			'text'  => __( 'Excelență în fiecare intervenție pentru confortul tău termic, susținută de ani de experiență și mii de clienți mulțumiți.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_home_advantages_header() {
	$header = ac_tech_get_home_advantages_header_base();
	if ( function_exists( 'ac_tech_home_merge_advantages_header' ) ) {
		$header = ac_tech_home_merge_advantages_header( $header );
	}
	return $header;
}

/**
 * @return array<int, array{icon: string, title: string, text: string}>
 */
function ac_tech_get_home_advantages_base() {
	return apply_filters(
		'ac_tech_home_advantages',
		array(
			array(
				'icon'  => 'bolt',
				'title' => __( 'Intervenție Rapidă', 'ac-tech' ),
				'text'  => __( 'Ajungem la tine în cel mai scurt timp posibil pentru a restaura confortul locuinței tale.', 'ac-tech' ),
			),
			array(
				'icon'  => 'engineering',
				'title' => __( 'Tehnicieni Certificați', 'ac-tech' ),
				'text'  => __( 'Echipă calificată și autorizată cu vastă experiență în sisteme de climatizare moderne.', 'ac-tech' ),
			),
			array(
				'icon'  => 'construction',
				'title' => __( 'Echipamente Profesionale', 'ac-tech' ),
				'text'  => __( 'Utilizăm doar tehnologie de ultimă generație pentru diagnosticare și reparații precise.', 'ac-tech' ),
			),
			array(
				'icon'  => 'sell',
				'title' => __( 'Prețuri Transparente', 'ac-tech' ),
				'text'  => __( 'Fără costuri ascunse sau surprize neplăcute. Primești devizul clar înaintea începerii lucrării.', 'ac-tech' ),
			),
		)
	);
}

/**
 * @return array<int, array{icon: string, title: string, text: string}>
 */
function ac_tech_get_home_advantages() {
	$items = ac_tech_get_home_advantages_base();
	if ( function_exists( 'ac_tech_home_merge_advantages' ) ) {
		$items = ac_tech_home_merge_advantages( $items );
	}
	return $items;
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_home_services_header_base() {
	return apply_filters(
		'ac_tech_home_services_header',
		array(
			'title'      => __( 'Servicii Complete', 'ac-tech' ),
			'text'       => __( 'Acoperim întreaga gamă de necesități pentru sistemul tău de climatizare, de la montaj până la mentenanță preventivă.', 'ac-tech' ),
			'link_label' => __( 'Vezi lista de prețuri', 'ac-tech' ),
			'link_url'   => home_url( '/servicii/' ),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_home_services_header() {
	$header = ac_tech_get_home_services_header_base();
	if ( function_exists( 'ac_tech_home_merge_services_header' ) ) {
		$header = ac_tech_home_merge_services_header( $header );
	}
	return $header;
}

/**
 * @return array<int, array{title: string, text: string, image: array<string, mixed>, link_label: string, link_url: string}>
 */
function ac_tech_get_home_services_base() {
	return apply_filters(
		'ac_tech_home_services',
		array(
			array(
				'title'      => __( 'Instalare Profesională', 'ac-tech' ),
				'text'       => __( 'Montaj autorizat pentru orice marcă și model, respectând cele mai riguroase standarde de eficiență.', 'ac-tech' ),
				'image'      => array(
					'slug'    => 'service-instalare',
					'alt'     => __( 'Instalare aparat de aer condiționat', 'ac-tech' ),
					'width'   => 768,
					'height'  => 512,
					'widths'  => array( 400, 768 ),
					'sizes'   => '(min-width: 48rem) 40vw, 100vw',
					'class'   => 'ac-tech-home-service-card__image',
				),
				'link_label' => __( 'Detalii serviciu', 'ac-tech' ),
				'link_url'   => home_url( '/servicii/' ),
			),
			array(
				'title'      => __( 'Igienizare & Dezinfectare', 'ac-tech' ),
				'text'       => __( 'Curățare în profunzime a filtrelor și evaporatoarelor pentru a elimina bacteriile și mirosurile neplăcute.', 'ac-tech' ),
				'image'      => array(
					'slug'    => 'service-igienizare',
					'alt'     => __( 'Igienizare filtru aparat de aer condiționat', 'ac-tech' ),
					'width'   => 768,
					'height'  => 512,
					'widths'  => array( 400, 768 ),
					'sizes'   => '(min-width: 48rem) 40vw, 100vw',
					'class'   => 'ac-tech-home-service-card__image',
				),
				'link_label' => __( 'Detalii serviciu', 'ac-tech' ),
				'link_url'   => home_url( '/igienizare-ac/' ),
			),
			array(
				'title'      => __( 'Diagnostic & Reparații', 'ac-tech' ),
				'text'       => __( 'Identificarea rapidă a oricărei defecțiuni și remedierea acesteia folosind piese de schimb originale.', 'ac-tech' ),
				'image'      => array(
					'slug'    => 'service-diagnostic',
					'alt'     => __( 'Diagnostic aparat de aer condiționat', 'ac-tech' ),
					'width'   => 768,
					'height'  => 512,
					'widths'  => array( 400, 768 ),
					'sizes'   => '(min-width: 48rem) 40vw, 100vw',
					'class'   => 'ac-tech-home-service-card__image',
				),
				'link_label' => __( 'Detalii serviciu', 'ac-tech' ),
				'link_url'   => home_url( '/servicii/' ),
			),
			array(
				'title'      => __( 'Mentenanță Periodică', 'ac-tech' ),
				'text'       => __( 'Verificări de sezon pentru a asigura funcționarea optimă și a prelungi durata de viață a aparatului.', 'ac-tech' ),
				'image'      => array(
					'slug'    => 'service-mentenanta',
					'alt'     => __( 'Mentenanță aparat de aer condiționat', 'ac-tech' ),
					'width'   => 768,
					'height'  => 512,
					'widths'  => array( 400, 768 ),
					'sizes'   => '(min-width: 48rem) 40vw, 100vw',
					'class'   => 'ac-tech-home-service-card__image',
				),
				'link_label' => __( 'Detalii serviciu', 'ac-tech' ),
				'link_url'   => home_url( '/servicii/' ),
			),
		)
	);
}

/**
 * @return array<int, array{title: string, text: string, image: array<string, mixed>, link_label: string, link_url: string}>
 */
function ac_tech_get_home_services() {
	$services = ac_tech_get_home_services_base();
	if ( function_exists( 'ac_tech_home_merge_services' ) ) {
		$services = ac_tech_home_merge_services( $services );
	}
	return $services;
}

/**
 * @return array<string, string>
 */
function ac_tech_get_home_process_header_base() {
	return apply_filters(
		'ac_tech_home_process_header',
		array(
			'title' => __( 'Cum funcționează?', 'ac-tech' ),
			'text'  => __( 'Procesul nostru este simplu, rapid și complet digitalizat pentru confortul tău.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_home_process_header() {
	$header = ac_tech_get_home_process_header_base();
	if ( function_exists( 'ac_tech_home_merge_process_header' ) ) {
		$header = ac_tech_home_merge_process_header( $header );
	}
	return $header;
}

/**
 * @return array<int, array{step: string, title: string, text: string, is_final: bool}>
 */
function ac_tech_get_home_process_steps_base() {
	return apply_filters(
		'ac_tech_home_process_steps',
		array(
			array(
				'step'     => '1',
				'title'    => __( 'Alegi Serviciul', 'ac-tech' ),
				'text'     => __( 'Selectează tipul de intervenție necesară pentru unitatea ta.', 'ac-tech' ),
				'is_final' => false,
			),
			array(
				'step'     => '2',
				'title'    => __( 'Rezervare Online', 'ac-tech' ),
				'text'     => __( 'Alegi data și ora potrivite direct din calendarul nostru.', 'ac-tech' ),
				'is_final' => false,
			),
			array(
				'step'     => '3',
				'title'    => __( 'Confirmare', 'ac-tech' ),
				'text'     => __( 'Primești un SMS și un email cu detaliile programării.', 'ac-tech' ),
				'is_final' => false,
			),
			array(
				'step'     => '4',
				'title'    => __( 'Bucură-te de AC', 'ac-tech' ),
				'text'     => __( 'Echipa noastră intervine, iar tu te bucuri de aer curat.', 'ac-tech' ),
				'is_final' => true,
			),
		)
	);
}

/**
 * @return array<int, array{step: string, title: string, text: string, is_final: bool}>
 */
function ac_tech_get_home_process_steps() {
	$steps = ac_tech_get_home_process_steps_base();
	if ( function_exists( 'ac_tech_home_merge_process_steps' ) ) {
		$steps = ac_tech_home_merge_process_steps( $steps );
	}
	return $steps;
}

/**
 * @return array<string, string>
 */
function ac_tech_get_home_reviews_header_base() {
	return apply_filters(
		'ac_tech_home_reviews_header',
		array(
			'title'  => __( 'Ce spun clienții noștri', 'ac-tech' ),
			'rating' => __( '4.9/5 pe Google', 'ac-tech' ),
		)
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_home_reviews_header() {
	$header = ac_tech_get_home_reviews_header_base();
	if ( function_exists( 'ac_tech_home_merge_reviews_header' ) ) {
		$header = ac_tech_home_merge_reviews_header( $header );
	}
	return $header;
}

/**
 * @return array<int, array{text: string, name: string, role: string, avatar: array<string, mixed>, featured: bool}>
 */
function ac_tech_get_home_reviews_base() {
	return apply_filters(
		'ac_tech_home_reviews',
		array(
			array(
				'text'        => __( 'O echipă extrem de profesionistă. Au venit la ora stabilită, au lucrat curat și au explicat tot procesul de igienizare. Recomand cu mare drag!', 'ac-tech' ),
				'name'        => 'Elena Ionescu',
				'role'        => __( 'Proprietar Apartament', 'ac-tech' ),
				'avatar'      => array(
					'slug'    => 'avatar-review-1',
					'alt'     => '',
					'width'   => 48,
					'height'  => 48,
					'widths'  => array( 96 ),
					'sizes'   => '48px',
					'class'   => 'ac-tech-home-review-card__avatar',
				),
				'featured'    => false,
			),
			array(
				'text'        => __( 'Colaborăm cu AC Pro pentru spațiul nostru de birouri de peste 2 ani. Servicii de mentenanță impecabile, nu am avut nicio problemă chiar și în cele mai fierbinți zile de vară.', 'ac-tech' ),
				'name'        => 'Marius Popa',
				'role'        => __( 'Manager Operativ', 'ac-tech' ),
				'avatar'      => array(
					'slug'    => 'avatar-review-2',
					'alt'     => '',
					'width'   => 48,
					'height'  => 48,
					'widths'  => array( 96 ),
					'sizes'   => '48px',
					'class'   => 'ac-tech-home-review-card__avatar',
				),
				'featured'    => true,
			),
			array(
				'text'        => __( 'Instalarea a decurs perfect. Au fost atenți la detalii și au lăsat locul curat. Prețul a fost exact cel comunicat la început. Foarte mulțumit!', 'ac-tech' ),
				'name'        => 'Andreea Stoica',
				'role'        => __( 'Client Rezidențial', 'ac-tech' ),
				'avatar'      => array(
					'slug'    => 'avatar-review-3',
					'alt'     => '',
					'width'   => 48,
					'height'  => 48,
					'widths'  => array( 96 ),
					'sizes'   => '48px',
					'class'   => 'ac-tech-home-review-card__avatar',
				),
				'featured'    => false,
			),
		)
	);
}

/**
 * @return array<int, array{text: string, name: string, role: string, avatar: array<string, mixed>, featured: bool}>
 */
function ac_tech_get_home_reviews() {
	$reviews = ac_tech_get_home_reviews_base();
	if ( function_exists( 'ac_tech_home_merge_reviews' ) ) {
		$reviews = ac_tech_home_merge_reviews( $reviews );
	}
	return $reviews;
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_home_cta_final_base() {
	$booking_url = function_exists( 'ac_tech_get_booking_url' )
		? ac_tech_get_booking_url()
		: home_url( '/programare/' );

	return apply_filters(
		'ac_tech_home_cta_final',
		array(
			'title'    => __( 'Gata să respiri aer curat?', 'ac-tech' ),
			'text'     => __( 'Programarea ta este la doar câteva clicuri distanță. Simplu, rapid și profesionist.', 'ac-tech' ),
			'btn_text' => __( 'Programare rapidă online', 'ac-tech' ),
			'btn_url'  => $booking_url,
			'phone'    => '+40 700 000 000',
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_home_cta_final() {
	$cta = ac_tech_get_home_cta_final_base();
	if ( function_exists( 'ac_tech_home_merge_cta_final' ) ) {
		$cta = ac_tech_home_merge_cta_final( $cta );
	}
	return $cta;
}
