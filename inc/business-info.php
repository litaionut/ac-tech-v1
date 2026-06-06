<?php
/**
 * Canonical business NAP (Name, Address, Phone) for SEO and contact display.
 *
 * @package AC-Tech
 */

/**
 * Default business profile (override via Customizer or filters).
 *
 * @return array<string, string>
 */
function ac_tech_get_business_info_defaults() {
	return apply_filters(
		'ac_tech_business_info_defaults',
		array(
			'name'             => 'AC-tech',
			'legal_name'       => 'AC-tech',
			'phone_display'    => '',
			'phone_e164'       => '',
			'whatsapp'         => '',
			'email'            => 'contact@ac-tech.ro',
			'street_address'   => 'Strada Economu Cezarescu 34',
			'address_locality' => 'București',
			'address_region'   => 'Sector 3',
			'postal_code'      => '031773',
			'address_country'  => 'RO',
			'schedule'         => __( 'Luni–Vineri: 09:00–18:00', 'ac-tech' ),
			'area_served'      => __( 'București și Ilfov', 'ac-tech' ),
			'maps_url'         => 'https://maps.google.com/?q=Strada+Economu+Cezarescu+34,+Sector+3,+Bucure%C8%99ti',
			'gbp_url'          => '',
			'gbp_review_url'   => '',
			'gbp_rating'       => '',
		)
	);
}

/**
 * Resolved business profile (Customizer + defaults).
 *
 * @return array<string, string>
 */
function ac_tech_get_business_info() {
	$defaults = ac_tech_get_business_info_defaults();
	$mods     = array(
		'phone_display'    => (string) get_theme_mod( 'ac_tech_business_phone', '' ),
		'phone_e164'       => (string) get_theme_mod( 'ac_tech_business_phone_e164', '' ),
		'whatsapp'         => (string) get_theme_mod( 'ac_tech_business_whatsapp', '' ),
		'email'            => (string) get_theme_mod( 'ac_tech_business_email', '' ),
		'street_address'   => (string) get_theme_mod( 'ac_tech_business_street', '' ),
		'address_locality' => (string) get_theme_mod( 'ac_tech_business_locality', '' ),
		'address_region'   => (string) get_theme_mod( 'ac_tech_business_region', '' ),
		'postal_code'      => (string) get_theme_mod( 'ac_tech_business_postal_code', '' ),
		'schedule'         => (string) get_theme_mod( 'ac_tech_business_schedule', '' ),
		'maps_url'         => (string) get_theme_mod( 'ac_tech_business_maps_url', '' ),
		'gbp_url'          => (string) get_theme_mod( 'ac_tech_gbp_url', '' ),
		'gbp_review_url'   => (string) get_theme_mod( 'ac_tech_gbp_review_url', '' ),
		'gbp_rating'       => (string) get_theme_mod( 'ac_tech_gbp_rating', '' ),
	);

	$info = $defaults;
	foreach ( $mods as $key => $value ) {
		if ( '' !== trim( $value ) ) {
			$info[ $key ] = trim( $value );
		}
	}

	if ( '' === $info['phone_e164'] && '' !== $info['phone_display'] ) {
		$info['phone_e164'] = ac_tech_normalize_phone_e164( $info['phone_display'] );
	}

	if ( '' === $info['whatsapp'] && '' !== $info['phone_e164'] ) {
		$info['whatsapp'] = preg_replace( '/\D+/', '', $info['phone_e164'] );
	}

	return apply_filters( 'ac_tech_business_info', $info );
}

/**
 * @param string $phone Raw phone string.
 * @return string E.164-ish value for tel: links.
 */
function ac_tech_normalize_phone_e164( $phone ) {
	$digits = preg_replace( '/\D+/', '', (string) $phone );
	if ( '' === $digits ) {
		return '';
	}

	if ( 0 === strpos( $digits, '40' ) ) {
		return '+' . $digits;
	}

	if ( 0 === strpos( $digits, '0' ) ) {
		return '+4' . $digits;
	}

	return '+' . $digits;
}

/**
 * @return string
 */
function ac_tech_get_business_phone_display() {
	$info = ac_tech_get_business_info();
	return (string) ( $info['phone_display'] ?? '' );
}

/**
 * @return string tel: href target.
 */
function ac_tech_get_business_phone_tel() {
	$info = ac_tech_get_business_info();
	$tel  = (string) ( $info['phone_e164'] ?? '' );
	if ( '' !== $tel ) {
		return $tel;
	}

	return ac_tech_normalize_phone_e164( (string) ( $info['phone_display'] ?? '' ) );
}

/**
 * @return string
 */
function ac_tech_get_business_whatsapp_digits() {
	$info = ac_tech_get_business_info();
	return preg_replace( '/\D+/', '', (string) ( $info['whatsapp'] ?? '' ) );
}

/**
 * Single-line postal address for display.
 *
 * @return string
 */
function ac_tech_get_business_address_line() {
	$info = ac_tech_get_business_info();
	$parts = array_filter(
		array(
			$info['street_address'] ?? '',
			$info['address_region'] ?? '',
			$info['address_locality'] ?? '',
		)
	);

	return implode( ', ', $parts );
}

/**
 * @return string
 */
function ac_tech_get_business_email() {
	$info = ac_tech_get_business_info();
	$email = (string) ( $info['email'] ?? '' );
	if ( '' !== $email && is_email( $email ) ) {
		return $email;
	}

	$admin = (string) get_option( 'admin_email' );
	return is_email( $admin ) ? $admin : 'contact@ac-tech.ro';
}

/**
 * Whether a verifiable Google review link is configured.
 *
 * @return bool
 */
function ac_tech_has_gbp_review_url() {
	$url = (string) ( ac_tech_get_business_info()['gbp_review_url'] ?? '' );
	return '' !== $url && wp_http_validate_url( $url );
}

/**
 * Review rating label for display (only when configured).
 *
 * @return string
 */
function ac_tech_get_gbp_rating_label() {
	if ( ! ac_tech_has_gbp_review_url() ) {
		return '';
	}

	$rating = trim( (string) ( ac_tech_get_business_info()['gbp_rating'] ?? '' ) );
	if ( '' === $rating ) {
		return '';
	}

	/* translators: %s: rating value e.g. 4.9 */
	return sprintf( __( '%s/5 pe Google', 'ac-tech' ), $rating );
}

/**
 * @return string
 */
function ac_tech_get_montaj_page_url() {
	return home_url( '/montaj-aer-conditionat-bucuresti/' );
}

/**
 * @return string
 */
function ac_tech_get_igienizare_page_url() {
	return home_url( '/igienizare-ac/' );
}

/**
 * @return string
 */
function ac_tech_get_services_page_url() {
	return home_url( '/servicii/' );
}

/**
 * Render optional Google review CTA when URL is configured.
 *
 * @param string $class Optional wrapper class.
 */
function ac_tech_render_gbp_review_cta( $class = '' ) {
	if ( ! ac_tech_has_gbp_review_url() ) {
		return;
	}

	$url = (string) ( ac_tech_get_business_info()['gbp_review_url'] ?? '' );
	?>
	<p class="<?php echo esc_attr( trim( 'ac-tech-gbp-review-cta ' . $class ) ); ?>">
		<a class="ac-tech-gbp-review-cta__link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
			<?php esc_html_e( 'Ai folosit serviciile noastre? Lasă o recenzie pe Google', 'ac-tech' ); ?>
		</a>
	</p>
	<?php
}
