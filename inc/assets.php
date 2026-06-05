<?php
/**
 * Theme assets enqueue.
 *
 * @package AC-Tech
 */

/**
 * Preload self-hosted Inter woff2 files.
 */
function ac_tech_preload_fonts() {
	if ( is_admin() ) {
		return;
	}

	$font_uri = get_template_directory_uri() . '/assets/fonts/inter/';
	$weights  = array( '400', '700' );

	foreach ( $weights as $weight ) {
		printf(
			'<link rel="preload" href="%1$sinter-latin-%2$s-normal.woff2" as="font" type="font/woff2" crossorigin>%3$s',
			esc_url( $font_uri ),
			esc_attr( $weight ),
			"\n"
		);
	}
}
add_action( 'wp_head', 'ac_tech_preload_fonts', 1 );

/**
 * Enqueue global site chrome and self-hosted fonts.
 */
function ac_tech_enqueue_site_chrome_assets() {
	if ( is_admin() ) {
		return;
	}

	$fonts_path = get_template_directory() . '/assets/css/fonts.css';
	if ( file_exists( $fonts_path ) ) {
		wp_enqueue_style(
			'ac-tech-fonts',
			get_template_directory_uri() . '/assets/css/fonts.css',
			array( 'ac-tech-style' ),
			_S_VERSION
		);
	}

	if ( is_front_page() ) {
		return;
	}

	$tokens_path = get_template_directory() . '/assets/css/design-tokens.css';
	$chrome_path = get_template_directory() . '/assets/css/site-chrome.css';

	if ( ! file_exists( $tokens_path ) || ! file_exists( $chrome_path ) ) {
		return;
	}

	wp_enqueue_style(
		'ac-tech-design-tokens',
		get_template_directory_uri() . '/assets/css/design-tokens.css',
		array( 'ac-tech-fonts' ),
		_S_VERSION
	);

	wp_enqueue_style(
		'ac-tech-site-chrome',
		get_template_directory_uri() . '/assets/css/site-chrome.css',
		array( 'ac-tech-design-tokens' ),
		_S_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'ac_tech_enqueue_site_chrome_assets', 5 );

/**
 * Enqueue homepage bundle or inner page presentation styles.
 */
function ac_tech_enqueue_presentation_assets() {
	if ( is_admin() ) {
		return;
	}

	if ( is_front_page() ) {
		$bundle_path = get_template_directory() . '/assets/css/home-bundle.css';
		if ( file_exists( $bundle_path ) ) {
			wp_enqueue_style(
				'ac-tech-home-bundle',
				get_template_directory_uri() . '/assets/css/home-bundle.css',
				array( 'ac-tech-fonts' ),
				_S_VERSION
			);
		}

		wp_enqueue_script(
			'ac-tech-home',
			get_template_directory_uri() . '/js/home.js',
			array(),
			_S_VERSION,
			true
		);
		return;
	}

	$base_handle = 'ac-tech-presentation-base';
	$base_uri    = get_template_directory_uri() . '/assets/css/presentation-base.css';
	$base_path   = get_template_directory() . '/assets/css/presentation-base.css';

	if ( ! file_exists( $base_path ) ) {
		return;
	}

	if ( ! wp_style_is( 'ac-tech-site-chrome', 'enqueued' ) ) {
		ac_tech_enqueue_site_chrome_assets();
	}

	if ( is_page() ) {
		wp_enqueue_style( $base_handle, $base_uri, array( 'ac-tech-site-chrome' ), _S_VERSION );
		wp_enqueue_style(
			'ac-tech-page-inner',
			get_template_directory_uri() . '/assets/css/page-inner.css',
			array( $base_handle ),
			_S_VERSION
		);

		if ( ac_tech_is_igienizare_ac_page() ) {
			wp_enqueue_style(
				'ac-tech-service-igienizare',
				get_template_directory_uri() . '/assets/css/service-igienizare.css',
				array( 'ac-tech-page-inner' ),
				_S_VERSION
			);
			wp_enqueue_script(
				'ac-tech-service-igienizare',
				get_template_directory_uri() . '/js/service-igienizare.js',
				array(),
				_S_VERSION,
				true
			);
		}

		if ( ac_tech_is_booking_page() ) {
			wp_enqueue_style(
				'ac-tech-booking',
				get_template_directory_uri() . '/assets/css/booking.css',
				array( 'ac-tech-page-inner' ),
				_S_VERSION
			);
			wp_enqueue_script(
				'ac-tech-booking',
				get_template_directory_uri() . '/js/booking.js',
				array(),
				_S_VERSION,
				true
			);
			wp_localize_script(
				'ac-tech-booking',
				'acTechBooking',
				array(
					'restUrl'            => esc_url_raw( rest_url( 'ac-tech/v1/' ) ),
					'nonce'              => wp_create_nonce( 'wp_rest' ),
					'reservationsOpen'   => ac_tech_booking_reservations_are_open() ? 1 : 0,
					'messages'           => array(
						'selectService' => __( 'Selectează serviciul pentru a vedea intervalele.', 'ac-tech' ),
						'loadingSlots'  => __( 'Se încarcă intervalele...', 'ac-tech' ),
						'noSlots'       => __( 'Nu există intervale disponibile în această zi.', 'ac-tech' ),
						'selectSlot'    => __( 'Selectează un interval orar.', 'ac-tech' ),
						'submitting'    => __( 'Se trimite programarea...', 'ac-tech' ),
						'errorGeneric'  => __( 'Nu am putut finaliza programarea. Încearcă din nou.', 'ac-tech' ),
						'errorConflict' => __( 'Intervalul nu mai este disponibil. Alege alt interval.', 'ac-tech' ),
						'bookingsClosed'=> __( 'Rezervările online sunt temporar oprite. Te rugăm să ne contactezi telefonic.', 'ac-tech' ),
						'rateLimited'   => __( 'Ai atins limita de 5 programări pe oră. Încearcă din nou mai târziu.', 'ac-tech' ),
					),
				)
			);
		}

		if ( ac_tech_is_contact_page() ) {
			wp_enqueue_style(
				'ac-tech-booking',
				get_template_directory_uri() . '/assets/css/booking.css',
				array( 'ac-tech-page-inner' ),
				_S_VERSION
			);
			wp_enqueue_style(
				'ac-tech-contact',
				get_template_directory_uri() . '/assets/css/contact.css',
				array( 'ac-tech-booking' ),
				_S_VERSION
			);
			if ( ! function_exists( 'ac_tech_contact_uses_theme_form' ) || ac_tech_contact_uses_theme_form() ) {
				wp_enqueue_script(
					'ac-tech-contact',
					get_template_directory_uri() . '/js/contact.js',
					array(),
					_S_VERSION,
					true
				);
			}
		}

		return;
	}

	if ( ac_tech_is_blog_view() ) {
		wp_enqueue_style( $base_handle, $base_uri, array( 'ac-tech-site-chrome' ), _S_VERSION );
		wp_enqueue_style(
			'ac-tech-page-inner',
			get_template_directory_uri() . '/assets/css/page-inner.css',
			array( $base_handle ),
			_S_VERSION
		);
		wp_enqueue_style(
			'ac-tech-blog',
			get_template_directory_uri() . '/assets/css/blog.css',
			array( 'ac-tech-page-inner' ),
			_S_VERSION
		);
		return;
	}

	if ( is_singular( 'post' ) && ac_tech_is_styled_post_template() ) {
		wp_enqueue_style( $base_handle, $base_uri, array( 'ac-tech-site-chrome' ), _S_VERSION );
		wp_enqueue_style(
			'ac-tech-page-inner',
			get_template_directory_uri() . '/assets/css/page-inner.css',
			array( $base_handle ),
			_S_VERSION
		);
		wp_enqueue_style(
			'ac-tech-post-single',
			get_template_directory_uri() . '/assets/css/post-single.css',
			array( 'ac-tech-page-inner' ),
			_S_VERSION
		);

		if ( 'single-post-template-2.php' === ac_tech_get_post_template_file() ) {
			wp_enqueue_script(
				'ac-tech-post-template-2',
				get_template_directory_uri() . '/js/post-template-2.js',
				array(),
				_S_VERSION,
				true
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ac_tech_enqueue_presentation_assets', 20 );
