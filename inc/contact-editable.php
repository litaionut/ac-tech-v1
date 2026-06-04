<?php
/**
 * Contact page — ACF editable content (hero, sidebar, form shortcode).
 *
 * @package AC-Tech
 */

define( 'AC_TECH_CONTACT_SEED_OPTION', 'ac_tech_contact_seeded_v1' );

/**
 * Page ID for the Contact template (current view or first matching page).
 *
 * @return int
 */
function ac_tech_get_contact_page_id() {
	if ( is_page() && is_page_template( 'template-contact.php' ) ) {
		return (int) get_queried_object_id();
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'template-contact.php',
		)
	);

	return ! empty( $pages[0] ) ? (int) $pages[0] : 0;
}

/**
 * @param string $field_name ACF field name.
 * @param mixed  $default    Fallback.
 * @return mixed
 */
function ac_tech_get_contact_page_field( $field_name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$page_id = ac_tech_get_contact_page_id();
	if ( $page_id <= 0 ) {
		return $default;
	}

	$value = get_field( $field_name, $page_id );
	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * @param mixed $value Raw value.
 * @return bool
 */
function ac_tech_contact_acf_value_is_empty( $value ) {
	if ( is_array( $value ) ) {
		return empty( $value );
	}

	return null === $value || false === $value || '' === $value;
}

/**
 * Simple ACF field names for contact page.
 *
 * @return string[]
 */
function ac_tech_contact_simple_acf_field_names() {
	return array(
		'contact_hero_title',
		'contact_hero_text',
		'contact_form_title',
		'contact_form_shortcode',
		'contact_info_title',
		'contact_info_email',
		'contact_info_phone',
		'contact_info_schedule',
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_contact_simple_field_defaults() {
	$hero_fallback = ac_tech_get_contact_hero_fallback_base();

	$defaults = array(
		'contact_hero_title'       => '',
		'contact_hero_text'        => $hero_fallback['text'],
		'contact_form_title'       => ac_tech_get_contact_form_base()['title'],
		'contact_form_shortcode'   => '',
		'contact_info_title'       => ac_tech_get_contact_info_base()['title'],
		'contact_info_email'       => ac_tech_get_contact_info_base()['email'],
		'contact_info_phone'       => ac_tech_get_contact_info_base()['phone'],
		'contact_info_schedule'    => ac_tech_get_contact_info_base()['schedule'],
	);

	return apply_filters( 'ac_tech_contact_simple_field_defaults', $defaults );
}

/**
 * Seed contact ACF fields.
 */
function ac_tech_seed_contact_acf_fields() {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	if ( get_option( AC_TECH_CONTACT_SEED_OPTION ) ) {
		return;
	}

	$page_id = ac_tech_get_contact_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	foreach ( ac_tech_get_contact_simple_field_defaults() as $field_name => $value ) {
		if ( '' === (string) $value ) {
			continue;
		}

		$existing = get_field( $field_name, $page_id );
		if ( ! ac_tech_contact_acf_value_is_empty( $existing ) ) {
			continue;
		}

		update_field( $field_name, $value, $page_id );
	}

	update_option( AC_TECH_CONTACT_SEED_OPTION, 1, false );
}
add_action( 'acf/init', 'ac_tech_seed_contact_acf_fields', 25 );

/**
 * @param mixed $value   Value.
 * @param mixed $post_id Post ID.
 * @param array $field   Field.
 * @return mixed
 */
function ac_tech_acf_load_contact_field_value( $value, $post_id, $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $value;
	}

	$field_name = (string) $field['name'];
	if ( ! in_array( $field_name, ac_tech_contact_simple_acf_field_names(), true ) ) {
		return $value;
	}

	$contact_id = ac_tech_get_contact_page_id();
	if ( $contact_id <= 0 || (int) $post_id !== $contact_id ) {
		return $value;
	}

	if ( ! ac_tech_contact_acf_value_is_empty( $value ) ) {
		return $value;
	}

	$defaults = ac_tech_get_contact_simple_field_defaults();

	return isset( $defaults[ $field_name ] ) ? $defaults[ $field_name ] : $value;
}
add_filter( 'acf/load_value', 'ac_tech_acf_load_contact_field_value', 10, 3 );

/**
 * @param array $field Field config.
 * @return array
 */
function ac_tech_acf_load_contact_field_ui_defaults( $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $field;
	}

	$defaults = ac_tech_get_contact_simple_field_defaults();
	$name     = (string) $field['name'];

	if ( isset( $defaults[ $name ] ) && '' !== (string) $defaults[ $name ] ) {
		$field['default_value'] = $defaults[ $name ];
	}

	return $field;
}
add_filter( 'acf/load_field', 'ac_tech_acf_load_contact_field_ui_defaults', 20 );

/**
 * @return array<string, string>
 */
function ac_tech_get_contact_hero() {
	$title = (string) ac_tech_get_contact_page_field( 'contact_hero_title', '' );
	$text  = (string) ac_tech_get_contact_page_field( 'contact_hero_text', ac_tech_get_contact_hero_fallback_base()['text'] );

	if ( '' === $title && is_page() ) {
		$title = get_the_title();
	}

	return array(
		'title' => $title,
		'text'  => $text,
	);
}

/**
 * Trimmed shortcode string or empty.
 *
 * @return string
 */
function ac_tech_get_contact_form_shortcode() {
	$raw = (string) ac_tech_get_contact_page_field( 'contact_form_shortcode', '' );
	$raw = trim( $raw );

	if ( '' === $raw ) {
		return '';
	}

	return $raw;
}

/**
 * Whether the theme demo form (not plugin shortcode) is shown.
 *
 * @return bool
 */
function ac_tech_contact_uses_theme_form() {
	return '' === ac_tech_get_contact_form_shortcode();
}

/**
 * @return array<string, string>
 */
function ac_tech_get_contact_info() {
	$base = ac_tech_get_contact_info_base();

	$map = array(
		'contact_info_title'    => 'title',
		'contact_info_email'    => 'email',
		'contact_info_phone'    => 'phone',
		'contact_info_schedule' => 'schedule',
	);

	foreach ( $map as $acf_name => $key ) {
		$value = ac_tech_get_contact_page_field( $acf_name, null );
		if ( ! ac_tech_contact_acf_value_is_empty( $value ) ) {
			$base[ $key ] = (string) $value;
		}
	}

	return apply_filters( 'ac_tech_contact_info', $base );
}

/**
 * Form block title (theme form or shortcode wrapper).
 *
 * @return string
 */
function ac_tech_get_contact_form_block_title() {
	$title = (string) ac_tech_get_contact_page_field( 'contact_form_title', '' );
	if ( '' !== $title ) {
		return $title;
	}

	return ac_tech_get_contact_form()['title'];
}
