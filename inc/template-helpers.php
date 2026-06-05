<?php
/**
 * Helpers for presentation page templates.
 *
 * @package AC-Tech
 */

/**
 * Whether the current view uses the presentation layout.
 *
 * @return bool
 */
function ac_tech_is_presentation_view() {
	return is_front_page() || is_page();
}

/**
 * Whether the current page uses the Igienizare AC service template.
 *
 * @return bool
 */
function ac_tech_is_igienizare_ac_page() {
	return is_page_template( 'template-igienizare-ac.php' );
}

/**
 * Whether the current page uses the Booking template.
 *
 * @return bool
 */
function ac_tech_is_booking_page() {
	return is_page_template( 'template-booking.php' );
}

/**
 * Whether the current page uses the Contact template.
 *
 * @return bool
 */
function ac_tech_is_contact_page() {
	return is_page_template( 'template-contact.php' );
}

/**
 * Whether the current page uses the Services catalog template.
 *
 * @return bool
 */
function ac_tech_is_services_all_page() {
	return is_page_template( 'template-services.php' );
}

/**
 * Default service cards for the services template and homepage preview.
 *
 * @return array<int, array{title: string, description: string, icon: string}>
 */
function ac_tech_get_default_services() {
	$services = array();

	return apply_filters( 'ac_tech_default_services', $services );
}

/**
 * Render a section page hero.
 *
 * @param array<string, mixed> $args Section arguments.
 */
function ac_tech_render_page_hero( $args = array() ) {
	$defaults = array(
		'title'    => '',
		'subtitle' => '',
		'class'    => '',
	);

	$args = wp_parse_args( $args, $defaults );

	get_template_part( 'template-parts/sections/page-hero', null, $args );
}

/**
 * Inline brand logo SVG from home.html mockup.
 */
function ac_tech_render_brand_logo() {
	?>
	<svg class="ac-tech-site-logo" width="32" height="32" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
		<path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
	</svg>
	<?php
}

/**
 * Fallback primary navigation when no WP menu is assigned.
 *
 * @param array<string, mixed> $args Menu arguments from wp_nav_menu().
 */
function ac_tech_primary_nav_fallback( $args ) {
	$links = array(
		array(
			'label' => __( 'Servicii', 'ac-tech' ),
			'url'   => home_url( '/#servicii' ),
		),
		array(
			'label' => __( 'Avantaje', 'ac-tech' ),
			'url'   => home_url( '/#avantaje' ),
		),
		array(
			'label' => __( 'Cum funcționează', 'ac-tech' ),
			'url'   => home_url( '/#proces' ),
		),
		array(
			'label' => __( 'Recenzii', 'ac-tech' ),
			'url'   => home_url( '/#recenzii' ),
		),
	);

	$links = apply_filters( 'ac_tech_primary_nav_fallback_links', $links );

	if ( empty( $links ) ) {
		return;
	}

	$menu_id = ! empty( $args['menu_id'] ) ? $args['menu_id'] : 'primary-menu';
	$menu_class = ! empty( $args['menu_class'] ) ? $args['menu_class'] : 'menu';

	echo '<ul id="' . esc_attr( $menu_id ) . '" class="' . esc_attr( $menu_class ) . '">';
	foreach ( $links as $link ) {
		if ( empty( $link['label'] ) || empty( $link['url'] ) ) {
			continue;
		}
		echo '<li><a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['label'] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Footer link columns from home.html structure.
 *
 * @return array<int, array{title: string, links: array<int, array{label: string, url: string}>}>
 */
function ac_tech_get_footer_columns() {
	$columns = array(
		array(
			'title' => __( 'Servicii', 'ac-tech' ),
			'links' => array(
				array(
					'label' => __( 'Instalare AC', 'ac-tech' ),
					'url'   => home_url( '/#servicii' ),
				),
				array(
					'label' => __( 'Igienizare AC', 'ac-tech' ),
					'url'   => home_url( '/igienizare-ac/' ),
				),
				array(
					'label' => __( 'Consultanță', 'ac-tech' ),
					'url'   => home_url( '/#servicii' ),
				),
			),
		),
		array(
			'title' => __( 'Companie', 'ac-tech' ),
			'links' => array(
				array(
					'label' => __( 'Despre noi', 'ac-tech' ),
					'url'   => home_url( '/despre-noi/' ),
				),
				array(
					'label' => __( 'Proces', 'ac-tech' ),
					'url'   => home_url( '/#proces' ),
				),
				array(
					'label' => __( 'Contact', 'ac-tech' ),
					'url'   => home_url( '/contact/' ),
				),
			),
		),
	);

	return apply_filters( 'ac_tech_footer_columns', $columns );
}
