<?php
/**
 * Theme SEO: titles, meta description, Open Graph, JSON-LD, robots.
 *
 * @package AC-Tech
 */

/**
 * SEO meta defaults per page context.
 *
 * @return array<string, string>
 */
function ac_tech_get_seo_meta_defaults() {
	$booking = function_exists( 'ac_tech_get_booking_url' ) ? ac_tech_get_booking_url() : home_url( '/programare/' );

	return apply_filters(
		'ac_tech_seo_meta_defaults',
		array(
			'front_page' => array(
				'title'       => __( 'Montaj & service aer condiționat București | AC-tech', 'ac-tech' ),
				'description' => __( 'Instalare, igienizare și reparații aer condiționat în București și Ilfov. Programare online, prețuri transparente și tehnicieni autorizați.', 'ac-tech' ),
			),
			'services'   => array(
				'title'       => __( 'Servicii aer condiționat București — prețuri & programare | AC-tech', 'ac-tech' ),
				'description' => __( 'Catalog complet: instalare, igienizare, diagnostic, mentenanță AC. Intervenții în toate sectoarele București și Ilfov. Programează online.', 'ac-tech' ),
			),
			'montaj'     => array(
				'title'       => __( 'Montaj aer condiționat București și Ilfov | Prețuri BTU | AC-tech', 'ac-tech' ),
				'description' => __( 'Montaj profesional AC pentru apartamente și birouri. Prețuri orientative 9.000–24.000 BTU, vacuum, punere în funcțiune. Programare rapidă.', 'ac-tech' ),
			),
			'igienizare' => array(
				'title'       => __( 'Igienizare aer condiționat București și Ilfov | AC-tech', 'ac-tech' ),
				'description' => __( 'Curățare profesională, dezinfectare și revizie AC. Intervenții în toate sectoarele București și Ilfov. Programează online sau sună acum.', 'ac-tech' ),
			),
			'contact'    => array(
				'title'       => __( 'Contact AC-tech — aer condiționat București', 'ac-tech' ),
				'description' => __( 'Contactează AC-tech pentru ofertă montaj, igienizare sau service AC în București și Ilfov. Răspundem rapid la solicitări.', 'ac-tech' ),
			),
			'booking'    => array(
				'title'       => __( 'Programare online aer condiționat | AC-tech București', 'ac-tech' ),
				'description' => __( 'Alege serviciul, data și ora pentru instalare, igienizare sau service AC. Confirmare rapidă prin email și SMS.', 'ac-tech' ),
			),
			'default'    => array(
				'title'       => '',
				'description' => get_bloginfo( 'description', 'display' ),
			),
		)
	);
}

/**
 * Detect SEO context key for current request.
 *
 * @return string
 */
function ac_tech_get_seo_context_key() {
	if ( is_front_page() ) {
		return 'front_page';
	}

	if ( is_page_template( 'template-services.php' ) ) {
		return 'services';
	}

	if ( is_page_template( 'template-montaj-ac.php' ) ) {
		return 'montaj';
	}

	if ( function_exists( 'ac_tech_is_igienizare_ac_page' ) && ac_tech_is_igienizare_ac_page() ) {
		return 'igienizare';
	}

	if ( function_exists( 'ac_tech_is_contact_page' ) && ac_tech_is_contact_page() ) {
		return 'contact';
	}

	if ( function_exists( 'ac_tech_is_booking_page' ) && ac_tech_is_booking_page() ) {
		return 'booking';
	}

	return 'default';
}

/**
 * Resolved meta for current page.
 *
 * @return array{title: string, description: string}
 */
function ac_tech_get_current_seo_meta() {
	$key      = ac_tech_get_seo_context_key();
	$defaults = ac_tech_get_seo_meta_defaults();
	$meta     = isset( $defaults[ $key ] ) ? $defaults[ $key ] : $defaults['default'];

	$title       = (string) ( $meta['title'] ?? '' );
	$description = (string) ( $meta['description'] ?? '' );

	if ( is_singular() && ! is_front_page() ) {
		$post_id = get_queried_object_id();
		if ( $post_id > 0 ) {
			if ( '' === $title ) {
				$title = wp_strip_all_tags( get_the_title( $post_id ) ) . ' | ' . get_bloginfo( 'name', 'display' );
			}

			$excerpt = get_post_field( 'post_excerpt', $post_id );
			if ( is_string( $excerpt ) && '' !== trim( $excerpt ) ) {
				$description = wp_strip_all_tags( $excerpt );
			}
		}
	}

	if ( '' === $description ) {
		$description = (string) ( $defaults['default']['description'] ?? '' );
	}

	$description = wp_trim_words( wp_strip_all_tags( $description ), 32, '' );

	return apply_filters(
		'ac_tech_current_seo_meta',
		array(
			'title'       => $title,
			'description' => $description,
		),
		$key
	);
}

/**
 * @param array<string, string> $title Title parts.
 * @return array<string, string>
 */
function ac_tech_document_title_parts( $title ) {
	if ( is_admin() ) {
		return $title;
	}

	$meta = ac_tech_get_current_seo_meta();
	if ( '' === $meta['title'] ) {
		return $title;
	}

	return array(
		'title' => $meta['title'],
	);
}
add_filter( 'document_title_parts', 'ac_tech_document_title_parts', 20 );

/**
 * Use full SEO title string (includes brand suffix where defined).
 *
 * @param string $title Document title.
 * @return string
 */
function ac_tech_pre_get_document_title( $title ) {
	if ( is_admin() ) {
		return $title;
	}

	$meta = ac_tech_get_current_seo_meta();
	if ( '' !== $meta['title'] ) {
		return $meta['title'];
	}

	return $title;
}
add_filter( 'pre_get_document_title', 'ac_tech_pre_get_document_title', 20 );

/**
 * Output meta description, OG, Twitter, site verification.
 */
function ac_tech_output_seo_head_tags() {
	if ( is_admin() ) {
		return;
	}

	$meta = ac_tech_get_current_seo_meta();
	$url  = is_singular() ? get_permalink() : home_url( '/' );

	if ( ! empty( $meta['description'] ) ) {
		printf(
			'<meta name="description" content="%s" />' . "\n",
			esc_attr( $meta['description'] )
		);
	}

	$og_title = ! empty( $meta['title'] ) ? $meta['title'] : wp_get_document_title();
	printf( '<meta property="og:type" content="%s" />' . "\n", esc_attr( is_singular( 'post' ) ? 'article' : 'website' ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $og_title ) );
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name', 'display' ) ) );
	printf( '<meta property="og:locale" content="ro_RO" />' . "\n" );

	if ( ! empty( $meta['description'] ) ) {
		printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $meta['description'] ) );
	}

	$image = ac_tech_get_seo_social_image_url();
	if ( $image ) {
		printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
	}

	printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );
	printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $og_title ) );
	if ( ! empty( $meta['description'] ) ) {
		printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $meta['description'] ) );
	}
	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) );
	}

	$verification = trim( (string) get_theme_mod( 'ac_tech_google_site_verification', '' ) );
	if ( '' !== $verification ) {
		printf(
			'<meta name="google-site-verification" content="%s" />' . "\n",
			esc_attr( $verification )
		);
	}
}
add_action( 'wp_head', 'ac_tech_output_seo_head_tags', 3 );

/**
 * @return string
 */
function ac_tech_get_seo_social_image_url() {
	if ( is_singular() && has_post_thumbnail() ) {
		$src = get_the_post_thumbnail_url( null, 'large' );
		if ( $src ) {
			return $src;
		}
	}

	if ( is_front_page() && function_exists( 'ac_tech_theme_image_url' ) ) {
		return ac_tech_theme_image_url( 'hero-hvac', 1200, 'home' );
	}

	return get_template_directory_uri() . '/screenshot.png';
}

/**
 * Append robots.txt rules.
 *
 * @param string $output Existing robots.txt.
 * @param bool   $public Whether site is public.
 * @return string
 */
function ac_tech_robots_txt( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}

	$lines   = array_filter( array_map( 'trim', explode( "\n", (string) $output ) ) );
	$lines[] = 'Sitemap: ' . home_url( '/wp-sitemap.xml' );
	$lines[] = 'Disallow: /wp-admin/';
	$lines[] = 'Allow: /wp-admin/admin-ajax.php';

	return implode( "\n", array_unique( $lines ) ) . "\n";
}
add_filter( 'robots_txt', 'ac_tech_robots_txt', 10, 2 );

/**
 * Noindex admin-only and utility templates.
 *
 * @param array<string, bool|string> $robots Robots directives.
 * @return array<string, bool|string>
 */
function ac_tech_wp_robots( $robots ) {
	if ( is_page_template( 'template-booking-settings.php' ) ) {
		$robots['noindex'] = true;
		$robots['nofollow'] = true;
	}

	return $robots;
}
add_filter( 'wp_robots', 'ac_tech_wp_robots' );

/**
 * LocalBusiness JSON-LD on public pages.
 */
function ac_tech_output_local_business_schema() {
	if ( is_admin() || ! function_exists( 'ac_tech_get_business_info' ) ) {
		return;
	}

	$info = ac_tech_get_business_info();
	$tel  = ac_tech_get_business_phone_tel();

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'HVACBusiness',
		'name'        => (string) ( $info['name'] ?? get_bloginfo( 'name', 'display' ) ),
		'url'         => home_url( '/' ),
		'email'       => ac_tech_get_business_email(),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => (string) ( $info['street_address'] ?? '' ),
			'addressLocality' => (string) ( $info['address_locality'] ?? '' ),
			'addressRegion'   => (string) ( $info['address_region'] ?? '' ),
			'postalCode'      => (string) ( $info['postal_code'] ?? '' ),
			'addressCountry'  => (string) ( $info['address_country'] ?? 'RO' ),
		),
		'areaServed'  => array(
			array(
				'@type' => 'City',
				'name'  => 'București',
			),
			array(
				'@type' => 'AdministrativeArea',
				'name'  => 'Ilfov',
			),
		),
		'openingHours' => ac_tech_schema_opening_hours(),
	);

	if ( '' !== $tel ) {
		$schema['telephone'] = $tel;
	}

	$maps = (string) ( $info['maps_url'] ?? '' );
	if ( '' !== $maps && wp_http_validate_url( $maps ) ) {
		$schema['hasMap'] = $maps;
	}

	$gbp = (string) ( $info['gbp_url'] ?? '' );
	if ( '' !== $gbp && wp_http_validate_url( $gbp ) ) {
		$schema['sameAs'] = array( $gbp );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'ac_tech_output_local_business_schema', 20 );

/**
 * @return string
 */
function ac_tech_schema_opening_hours() {
	$schedule = (string) ( ac_tech_get_business_info()['schedule'] ?? '' );
	if ( preg_match( '/(\d{1,2}:\d{2}).*?(\d{1,2}:\d{2})/u', $schedule, $m ) ) {
		return 'Mo-Fr ' . $m[1] . '-' . $m[2];
	}

	return 'Mo-Fr 09:00-18:00';
}

/**
 * FAQPage schema on Igienizare AC page.
 */
function ac_tech_output_faq_schema() {
	if ( ! function_exists( 'ac_tech_is_igienizare_ac_page' ) || ! ac_tech_is_igienizare_ac_page() ) {
		return;
	}

	if ( ! function_exists( 'ac_tech_get_service_igienizare_faq' ) ) {
		return;
	}

	$items = ac_tech_get_service_igienizare_faq();
	if ( empty( $items ) ) {
		return;
	}

	$entities = array();
	foreach ( $items as $item ) {
		if ( empty( $item['question'] ) || empty( $item['answer'] ) ) {
			continue;
		}
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => (string) $item['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => (string) $item['answer'],
			),
		);
	}

	if ( empty( $entities ) ) {
		return;
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'ac_tech_output_faq_schema', 21 );

/**
 * Service schema on Montaj page.
 */
function ac_tech_output_montaj_service_schema() {
	if ( ! is_page_template( 'template-montaj-ac.php' ) || ! function_exists( 'ac_tech_get_service_montaj_schema' ) ) {
		return;
	}

	$schema = ac_tech_get_service_montaj_schema();
	if ( empty( $schema ) ) {
		return;
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'ac_tech_output_montaj_service_schema', 21 );
