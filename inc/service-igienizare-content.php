<?php
/**
 * Static content for the Igienizare AC service page.
 *
 * @package AC-Tech
 */

/**
 * @return array<string, mixed>
 */
function ac_tech_get_service_igienizare_hero() {
	return apply_filters(
		'ac_tech_service_igienizare_hero',
		array(
			'badge_icon'  => 'verified',
			'badge_text'  => __( 'AUTORIZAȚI AGFR & ANPC', 'ac-tech' ),
			'title'       => __( 'Igienizare Aer Condiționat București și Ilfov –', 'ac-tech' ),
			'title_accent'=> __( 'Curățare Profesională', 'ac-tech' ),
			'text'        => __( 'Protejați-vă sănătatea și prelungiți durata de viață a aparatului cu servicii de revizie completă. Intervenții rapide în toate sectoarele și localitățile din Ilfov.', 'ac-tech' ),
			'phone'       => '+40700000000',
			'phone_label' => __( 'Sună Acum', 'ac-tech' ),
			'whatsapp'    => '40700000000',
			'whatsapp_label' => __( 'WhatsApp', 'ac-tech' ),
			'trust'       => array(
				array(
					'icon'  => 'workspace_premium',
					'title' => __( '10+ Ani Experiență', 'ac-tech' ),
					'text'  => __( 'Lideri în climatizare', 'ac-tech' ),
				),
				array(
					'icon'  => 'engineering',
					'title' => __( 'Tehnicieni Autorizați', 'ac-tech' ),
					'text'  => __( 'Echipă specializată', 'ac-tech' ),
				),
			),
			'review'      => array(
				'quote'  => __( 'Servicii impecabile. Aerul se simte mult mai proaspăt în living acum!', 'ac-tech' ),
				'author' => __( 'Maria S., București', 'ac-tech' ),
			),
			'image'       => array(
				'slug'          => 'igienizare-hero',
				'dir'           => 'service-igienizare',
				'alt'           => __( 'Igienizare aer condiționat București', 'ac-tech' ),
				'width'         => 800,
				'height'        => 800,
				'widths'        => array( 400, 800, 1200 ),
				'sizes'         => '(min-width: 64rem) 50vw, 100vw',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'class'         => 'ac-tech-svc-ig-hero__image',
			),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_service_igienizare_benefits_header() {
	return apply_filters(
		'ac_tech_service_igienizare_benefits_header',
		array(
			'title' => __( 'De ce este Vitală Igienizarea Periodică?', 'ac-tech' ),
			'text'  => __( 'Un aparat neîngrijit nu doar că funcționează ineficient, dar poate deveni un pericol real pentru sănătatea familiei tale.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<int, array{icon: string, title: string, text: string}>
 */
function ac_tech_get_service_igienizare_benefits() {
	return apply_filters(
		'ac_tech_service_igienizare_benefits',
		array(
			array(
				'icon'  => 'microbiology',
				'title' => __( 'Eliminarea Bacteriilor', 'ac-tech' ),
				'text'  => __( 'Umiditatea din interiorul aparatului favorizează apariția mucegaiului și a bacteriei Legionella, cauzând alergii și afecțiuni respiratorii.', 'ac-tech' ),
			),
			array(
				'icon'  => 'bolt',
				'title' => __( 'Eficiență Energetică', 'ac-tech' ),
				'text'  => __( 'Filtrele și vaporizatorul curat permit un flux de aer optim, reducând consumul de energie cu până la 25% la final de lună.', 'ac-tech' ),
			),
			array(
				'icon'  => 'noise_control_off',
				'title' => __( 'Funcționare Silențioasă', 'ac-tech' ),
				'text'  => __( 'Depunerile de praf pe turbină cauzează vibrații și zgomote neplăcute. O curățare profesională redă liniștea căminului tău.', 'ac-tech' ),
			),
		)
	);
}

/**
 * @return array<int, array{title: string, text: string}>
 */
function ac_tech_get_service_igienizare_process_steps() {
	return apply_filters(
		'ac_tech_service_igienizare_process_steps',
		array(
			array(
				'title' => __( 'Dezasamblare Completă', 'ac-tech' ),
				'text'  => __( 'Scoatem carcasa, filtrele și tăvița de condens pentru a avea acces la componentele interne ascunse.', 'ac-tech' ),
			),
			array(
				'title' => __( 'Curățare cu Înaltă Presiune', 'ac-tech' ),
				'text'  => __( 'Folosim echipamente dedicate pentru a spăla vaporizatorul și turbina, eliminând praful întărit.', 'ac-tech' ),
			),
			array(
				'title' => __( 'Dezinfectare Eco-Friendly', 'ac-tech' ),
				'text'  => __( 'Aplicăm soluții dezinfectante profesionale, sigure pentru copii și animale de companie, care distrug 99.9% din germeni.', 'ac-tech' ),
			),
			array(
				'title' => __( 'Verificarea Parametrilor', 'ac-tech' ),
				'text'  => __( 'Măsurăm presiunea freonului și temperatura de ieșire pentru a ne asigura că aparatul funcționează la capacitate maximă.', 'ac-tech' ),
			),
		)
	);
}

/**
 * @return array<int, array{slug: string, alt: string, class: string, widths: int[], sizes: string, width: int, height: int}>
 */
function ac_tech_get_service_igienizare_process_gallery() {
	return apply_filters(
		'ac_tech_service_igienizare_process_gallery',
		array(
			array(
				'slug'   => 'igienizare-filtru',
				'dir'    => 'service-igienizare',
				'alt'    => __( 'Curățare filtru aparat de aer condiționat', 'ac-tech' ),
				'class'  => 'ac-tech-svc-ig-process__img ac-tech-svc-ig-process__img--sm',
				'widths' => array( 400, 768 ),
				'sizes'  => '(min-width: 64rem) 25vw, 50vw',
				'width'  => 768,
				'height' => 512,
			),
			array(
				'slug'   => 'igienizare-presiune',
				'dir'    => 'service-igienizare',
				'alt'    => __( 'Curățare profesională cu presiune', 'ac-tech' ),
				'class'  => 'ac-tech-svc-ig-process__img ac-tech-svc-ig-process__img--lg',
				'widths' => array( 400, 768 ),
				'sizes'  => '(min-width: 64rem) 25vw, 50vw',
				'width'  => 768,
				'height' => 512,
			),
			array(
				'slug'   => 'igienizare-dezinfectare',
				'dir'    => 'service-igienizare',
				'alt'    => __( 'Dezinfectare aparat de aer condiționat', 'ac-tech' ),
				'class'  => 'ac-tech-svc-ig-process__img ac-tech-svc-ig-process__img--lg',
				'widths' => array( 400, 768 ),
				'sizes'  => '(min-width: 64rem) 25vw, 50vw',
				'width'  => 768,
				'height' => 512,
			),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_service_igienizare_pricing_header() {
	return apply_filters(
		'ac_tech_service_igienizare_pricing_header',
		array(
			'title' => __( 'Pachete de Servicii Transparente', 'ac-tech' ),
			'text'  => __( 'Fără costuri ascunse. Alege planul care se potrivește nevoilor tale.', 'ac-tech' ),
		)
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_service_igienizare_pricing() {
	$contact = home_url( '/contact/' );

	return apply_filters(
		'ac_tech_service_igienizare_pricing',
		array(
			array(
				'name'        => __( 'Standard', 'ac-tech' ),
				'description' => __( 'Ideal pentru întreținere anuală', 'ac-tech' ),
				'price'       => '250',
				'currency'    => __( 'lei', 'ac-tech' ),
				'featured'    => false,
				'cta'         => __( 'Alege Standard', 'ac-tech' ),
				'cta_url'     => $contact,
				'features'    => array(
					array( 'text' => __( 'Curățare filtre praf', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Dezinfectare vaporizator', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Spălare turbină sub presiune', 'ac-tech' ), 'included' => false ),
					array( 'text' => __( 'Verificare presiune freon', 'ac-tech' ), 'included' => false ),
				),
			),
			array(
				'name'        => __( 'Complet', 'ac-tech' ),
				'description' => __( 'Curățare profundă & Igienizare', 'ac-tech' ),
				'price'       => '350',
				'currency'    => __( 'lei', 'ac-tech' ),
				'featured'    => true,
				'badge'       => __( 'RECOMANDAT', 'ac-tech' ),
				'cta'         => __( 'Alege Complet', 'ac-tech' ),
				'cta_url'     => $contact,
				'features'    => array(
					array( 'text' => __( 'Toate beneficiile Standard', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Spălare turbină sub presiune', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Dezinfectare tăviță condens', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Verificare conexiuni electrice', 'ac-tech' ), 'included' => true ),
				),
			),
			array(
				'name'        => __( 'Premium', 'ac-tech' ),
				'description' => __( 'Revizie totală UI + UE', 'ac-tech' ),
				'price'       => '450',
				'currency'    => __( 'lei', 'ac-tech' ),
				'featured'    => false,
				'cta'         => __( 'Alege Premium', 'ac-tech' ),
				'cta_url'     => $contact,
				'features'    => array(
					array( 'text' => __( 'Toate beneficiile Complet', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Igienizare unitate exterioară', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Verificare & Refill freon (până la 100g)', 'ac-tech' ), 'included' => true ),
					array( 'text' => __( 'Garanție extinsă 12 luni', 'ac-tech' ), 'included' => true ),
				),
			),
		)
	);
}

/**
 * @return array<int, array{question: string, answer: string, open: bool}>
 */
function ac_tech_get_service_igienizare_faq() {
	return apply_filters(
		'ac_tech_service_igienizare_faq',
		array(
			array(
				'question' => __( 'Cât durează igienizarea unui aparat de aer condiționat?', 'ac-tech' ),
				'answer'   => __( 'O intervenție standard durează între 45 și 75 de minute, în funcție de gradul de murdărie și de accesibilitatea aparatului.', 'ac-tech' ),
				'open'     => true,
			),
			array(
				'question' => __( 'Vă deplasați în toate sectoarele din București?', 'ac-tech' ),
				'answer'   => __( 'Da, acoperim Sectoarele 1, 2, 3, 4, 5 și 6, precum și toate localitățile din județul Ilfov fără costuri suplimentare de deplasare pentru pachetele Complet și Premium.', 'ac-tech' ),
				'open'     => false,
			),
			array(
				'question' => __( 'De câte ori pe an trebuie făcută revizia?', 'ac-tech' ),
				'answer'   => __( 'Recomandăm igienizarea profesională de două ori pe an: primăvara, înainte de sezonul de răcire, și toamna, dacă folosiți aparatul și pentru încălzire.', 'ac-tech' ),
				'open'     => false,
			),
			array(
				'question' => __( 'Ce soluții folosiți pentru curățare?', 'ac-tech' ),
				'answer'   => __( 'Folosim exclusiv detergenți biodegradabili și dezinfectanți avizați de Ministerul Sănătății, special concepuți pentru a nu coroda lamelele de aluminiu ale vaporizatorului.', 'ac-tech' ),
				'open'     => false,
			),
			array(
				'question' => __( 'Oferiți factură și garanție?', 'ac-tech' ),
				'answer'   => __( 'Absolut. Toate serviciile noastre sunt însoțite de factură fiscală și raport de service, oferind garanție pentru manopera efectuată.', 'ac-tech' ),
				'open'     => false,
			),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_service_igienizare_faq_sidebar() {
	return apply_filters(
		'ac_tech_service_igienizare_faq_sidebar',
		array(
			'title'       => __( 'Întrebări Frecvente', 'ac-tech' ),
			'text'        => __( 'Tot ce trebuie să știi despre serviciile noastre de igienizare în București.', 'ac-tech' ),
			'team_title'  => __( 'Echipa AC-Tech', 'ac-tech' ),
			'team_text'   => __( 'Suntem specialiști dedicați calității aerului, cu peste un deceniu de expertiză tehnică.', 'ac-tech' ),
			'team_tagline'=> __( 'Specialiștii tăi de încredere', 'ac-tech' ),
			'team_image'  => array(
				'slug'   => 'igienizare-echipa',
				'dir'    => 'service-igienizare',
				'alt'    => __( 'Echipa AC-Tech', 'ac-tech' ),
				'class'  => 'ac-tech-svc-ig-faq__team-img',
				'widths' => array( 128 ),
				'sizes'  => '64px',
				'width'  => 64,
				'height' => 64,
			),
		)
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_service_igienizare_cta() {
	return apply_filters(
		'ac_tech_service_igienizare_cta',
		array(
			'title'            => __( 'Aer Curat la un Telefon Distanță', 'ac-tech' ),
			'text'             => __( 'Nu lăsa praful și bacteriile să îți afecteze confortul. Programează astăzi o intervenție în București sau Ilfov.', 'ac-tech' ),
			'phone'            => '+40700000000',
			'phone_label'      => '+40 700 000 000',
			'whatsapp'         => '40700000000',
			'whatsapp_label'   => __( 'Cere Ofertă WhatsApp', 'ac-tech' ),
		)
	);
}
