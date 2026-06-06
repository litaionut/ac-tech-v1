<?php
/**
 * Homepage content defaults; hero overrides via ACF / Customizer (see home-hero-editable.php).
 *
 * @package AC-Tech
 */

/**
 * Default homepage hero carousel slides — without ACF overrides.
 *
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_home_hero_carousel_base() {
	$booking_url = function_exists( 'ac_tech_get_booking_url' )
		? ac_tech_get_booking_url()
		: home_url( '/programare/' );

	return apply_filters(
		'ac_tech_home_hero_carousel_base',
		array(
			array(
				'badge_icon'   => 'sell',
				'badge_text'   => __( 'Ofertă limitată', 'ac-tech' ),
				'title'        => __( 'Pregătește-te de vară!', 'ac-tech' ),
				'title_accent' => __( '30% reducere la a doua unitate internă instalată', 'ac-tech' ),
				'text'         => __( 'Echipa AC-Tech îți asigură confortul termic ideal. Profită acum de oferta noastră specială pentru instalări multiple.', 'ac-tech' ),
				'cta_label'    => __( 'Profită de ofertă', 'ac-tech' ),
				'cta_url'      => $booking_url,
				'cta_icon'     => 'arrow_forward',
				'image'        => ac_tech_get_home_carousel_image_config( 'hero-hvac' ),
			),
			array(
				'badge_icon'   => 'sell',
				'badge_text'   => __( 'Promoție instalare', 'ac-tech' ),
				'title'        => __( '30% reducere la a doua unitate internă instalată', 'ac-tech' ),
				'title_accent' => '',
				'text'         => __( 'Profită de reducerea pentru al doilea aparat montat în aceeași locuință sau spațiu comercial.', 'ac-tech' ),
				'cta_label'    => __( 'Programează acum', 'ac-tech' ),
				'cta_url'      => $booking_url,
				'cta_icon'     => 'arrow_forward',
				'image'        => ac_tech_get_home_carousel_image_config( 'service-instalare' ),
			),
			array(
				'badge_icon'   => 'verified',
				'badge_text'   => __( 'Ofertă', 'ac-tech' ),
				'title'        => __( 'Măsurarea eficienței gratuită', 'ac-tech' ),
				'title_accent' => __( 'la orice igienizare sau instalare', 'ac-tech' ),
				'text'         => __( 'Includem măsurarea eficienței fără cost suplimentar la fiecare igienizare sau instalare realizată de echipa AC-Tech.', 'ac-tech' ),
				'cta_label'    => __( 'Solicită ofertă', 'ac-tech' ),
				'cta_url'      => home_url( '/contact/' ),
				'cta_icon'     => 'arrow_forward',
				'image'        => ac_tech_get_home_carousel_image_config( 'service-igienizare' ),
			),
		)
	);
}

/**
 * Theme WebP config for a carousel slide image.
 *
 * @param string $slug Image slug under assets/images/home/.
 * @return array<string, mixed>
 */
function ac_tech_get_home_carousel_image_config( $slug ) {
	$alts = array(
		'hero-hvac'           => __( 'Tehnician HVAC inspectează un aparat de aer condiționat montat pe perete', 'ac-tech' ),
		'service-instalare'   => __( 'Instalare profesională aer condiționat', 'ac-tech' ),
		'service-igienizare'  => __( 'Igienizare profesională aer condiționat', 'ac-tech' ),
		'service-diagnostic'  => __( 'Diagnostic aer condiționat', 'ac-tech' ),
		'service-mentenanta'  => __( 'Mentenanță aer condiționat', 'ac-tech' ),
	);

	return array(
		'slug'            => sanitize_key( $slug ),
		'alt'             => isset( $alts[ $slug ] ) ? $alts[ $slug ] : __( 'Promoție AC-Tech', 'ac-tech' ),
		'widths'          => 'hero-hvac' === $slug ? array( 800, 1200 ) : array( 768, 1200 ),
		'src_width'       => 'hero-hvac' === $slug ? 800 : 768,
		'sizes'           => '(min-width: 64rem) 50vw, 100vw',
		'loading'         => 'eager',
		'fetchpriority'   => 'high',
		'class'           => 'ac-tech-home-carousel__media-img',
		'use_picture'     => true,
		'omit_dimensions' => true,
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_home_hero_carousel() {
	$slides = apply_filters( 'ac_tech_home_hero_carousel', ac_tech_get_home_hero_carousel_base() );

	if ( function_exists( 'ac_tech_home_merge_hero_carousel' ) ) {
		$slides = ac_tech_home_merge_hero_carousel( $slides );
	}

	return $slides;
}

/**
 * First carousel slide — used for LCP preload and legacy helpers.
 *
 * @return array<string, mixed>
 */
function ac_tech_get_home_hero() {
	$slides = ac_tech_get_home_hero_carousel();

	return ! empty( $slides[0] ) ? $slides[0] : array();
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
	$rating = function_exists( 'ac_tech_get_gbp_rating_label' ) ? ac_tech_get_gbp_rating_label() : '';

	return apply_filters(
		'ac_tech_home_reviews_header',
		array(
			'title'  => __( 'Ce spun clienții noștri', 'ac-tech' ),
			'rating' => $rating,
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
				'name'        => __( 'Client rezidențial', 'ac-tech' ),
				'role'        => __( 'Sector 3, București', 'ac-tech' ),
				'avatar'      => array(
					'slug'    => 'avatar-review-1',
					'alt'     => __( 'Client AC-tech', 'ac-tech' ),
					'width'   => 48,
					'height'  => 48,
					'widths'  => array( 96 ),
					'sizes'   => '48px',
					'class'   => 'ac-tech-home-review-card__avatar',
				),
				'featured'    => false,
			),
			array(
				'text'        => __( 'Colaborăm cu AC-tech pentru spațiul nostru de birouri de peste 2 ani. Servicii de mentenanță impecabile, nu am avut nicio problemă chiar și în cele mai fierbinți zile de vară.', 'ac-tech' ),
				'name'        => __( 'Client business', 'ac-tech' ),
				'role'        => __( 'Spațiu comercial, București', 'ac-tech' ),
				'avatar'      => array(
					'slug'    => 'avatar-review-2',
					'alt'     => __( 'Client AC-tech', 'ac-tech' ),
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
				'name'        => __( 'Client rezidențial', 'ac-tech' ),
				'role'        => __( 'Apartament, Ilfov', 'ac-tech' ),
				'avatar'      => array(
					'slug'    => 'avatar-review-3',
					'alt'     => __( 'Client AC-tech', 'ac-tech' ),
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
			'phone'    => function_exists( 'ac_tech_get_business_phone_display' ) ? ac_tech_get_business_phone_display() : '',
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
