<?php
/**
 * Blog index — ACF editable content (posts page).
 *
 * @package AC-Tech
 */

define( 'AC_TECH_BLOG_SEED_OPTION', 'ac_tech_blog_seeded_v1' );

/**
 * @return int
 */
function ac_tech_get_blog_page_id() {
	$page_id = (int) get_option( 'page_for_posts' );
	if ( $page_id > 0 ) {
		return $page_id;
	}

	if ( is_home() && ! is_front_page() ) {
		return (int) get_queried_object_id();
	}

	return 0;
}

/**
 * @param string $field_name Field name.
 * @param mixed  $default    Fallback.
 * @return mixed
 */
function ac_tech_get_blog_page_field( $field_name, $default = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$page_id = ac_tech_get_blog_page_id();
	if ( $page_id <= 0 ) {
		return $default;
	}

	$value = get_field( $field_name, $page_id );
	if ( ac_tech_editable_value_is_empty( $value ) ) {
		return $default;
	}

	return $value;
}

/**
 * @param mixed $value Value.
 * @return bool
 */
function ac_tech_editable_value_is_empty( $value ) {
	if ( is_array( $value ) ) {
		return empty( $value );
	}

	return null === $value || false === $value || '' === $value;
}

/**
 * @return array<string, string>
 */
function ac_tech_get_blog_simple_field_defaults() {
	$header = ac_tech_get_blog_header_defaults();
	$news   = ac_tech_get_blog_newsletter_defaults();

	return array(
		'blog_header_badge'  => $header['badge'],
		'blog_header_title'  => $header['title'],
		'blog_header_accent' => $header['accent'],
		'blog_header_text'   => $header['text'],
		'blog_newsletter_title'       => $news['title'],
		'blog_newsletter_text'        => $news['text'],
		'blog_newsletter_placeholder' => $news['placeholder'],
		'blog_newsletter_button'      => $news['button'],
		'blog_newsletter_disclaimer'  => $news['disclaimer'],
	);
}

/**
 * @return array<int, array<string, string>>
 */
function ac_tech_get_blog_filters_repeater_defaults() {
	$rows = array();
	foreach ( ac_tech_get_blog_filter_categories_defaults() as $slug => $label ) {
		$rows[] = array(
			'filter_slug'  => $slug,
			'filter_label' => $label,
		);
	}
	return $rows;
}

/**
 * Seed blog page ACF fields.
 */
function ac_tech_seed_blog_acf_fields() {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	if ( get_option( AC_TECH_BLOG_SEED_OPTION ) ) {
		return;
	}

	$page_id = ac_tech_get_blog_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	foreach ( ac_tech_get_blog_simple_field_defaults() as $field => $value ) {
		if ( '' === (string) $value ) {
			continue;
		}
		if ( ! ac_tech_editable_value_is_empty( get_field( $field, $page_id ) ) ) {
			continue;
		}
		update_field( $field, $value, $page_id );
	}

	if ( ac_tech_editable_value_is_empty( get_field( 'blog_filters', $page_id ) ) ) {
		update_field( 'blog_filters', ac_tech_get_blog_filters_repeater_defaults(), $page_id );
	}

	update_option( AC_TECH_BLOG_SEED_OPTION, 1, false );
}
add_action( 'acf/init', 'ac_tech_seed_blog_acf_fields', 25 );

/**
 * @param mixed  $value   Value.
 * @param mixed  $post_id Post ID.
 * @param array  $field   Field config.
 * @return mixed
 */
function ac_tech_acf_load_blog_field_value( $value, $post_id, $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $value;
	}

	$name = (string) $field['name'];
	if ( 0 !== strpos( $name, 'blog_' ) ) {
		return $value;
	}

	$blog_id = ac_tech_get_blog_page_id();
	if ( $blog_id <= 0 || (int) $post_id !== $blog_id ) {
		return $value;
	}

	if ( ! ac_tech_editable_value_is_empty( $value ) ) {
		return $value;
	}

	if ( 'blog_filters' === $name ) {
		return ac_tech_get_blog_filters_repeater_defaults();
	}

	$simple = ac_tech_get_blog_simple_field_defaults();
	return isset( $simple[ $name ] ) ? $simple[ $name ] : $value;
}
add_filter( 'acf/load_value', 'ac_tech_acf_load_blog_field_value', 10, 3 );

/**
 * @param array $field Field config.
 * @return array
 */
function ac_tech_acf_load_blog_field_ui_defaults( $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $field;
	}

	$name = (string) $field['name'];
	if ( 'blog_filters' === $name ) {
		return $field;
	}

	$simple = ac_tech_get_blog_simple_field_defaults();
	if ( isset( $simple[ $name ] ) && '' !== (string) $simple[ $name ] ) {
		$field['default_value'] = $simple[ $name ];
	}

	return $field;
}
add_filter( 'acf/load_field', 'ac_tech_acf_load_blog_field_ui_defaults', 20 );

/**
 * @param array<string, string> $header Header defaults.
 * @return array<string, string>
 */
function ac_tech_filter_blog_header( $header ) {
	$map = array(
		'blog_header_badge'  => 'badge',
		'blog_header_title'  => 'title',
		'blog_header_accent' => 'accent',
		'blog_header_text'   => 'text',
	);

	foreach ( $map as $acf => $key ) {
		$value = ac_tech_get_blog_page_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $value ) ) {
			$header[ $key ] = (string) $value;
		}
	}

	return $header;
}
add_filter( 'ac_tech_blog_header', 'ac_tech_filter_blog_header', 20 );

/**
 * @param array<string, string> $newsletter Newsletter defaults.
 * @return array<string, string>
 */
function ac_tech_filter_blog_newsletter( $newsletter ) {
	$map = array(
		'blog_newsletter_title'       => 'title',
		'blog_newsletter_text'        => 'text',
		'blog_newsletter_placeholder' => 'placeholder',
		'blog_newsletter_button'      => 'button',
		'blog_newsletter_disclaimer'  => 'disclaimer',
	);

	foreach ( $map as $acf => $key ) {
		$value = ac_tech_get_blog_page_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $value ) ) {
			$newsletter[ $key ] = (string) $value;
		}
	}

	return $newsletter;
}
add_filter( 'ac_tech_blog_newsletter', 'ac_tech_filter_blog_newsletter', 20 );

/**
 * @param array<string, string> $categories Slug => label.
 * @return array<string, string>
 */
function ac_tech_filter_blog_filter_categories( $categories ) {
	$rows = ac_tech_get_blog_page_field( 'blog_filters', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $categories;
	}

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || empty( $row['filter_slug'] ) ) {
			continue;
		}
		$slug = sanitize_title( (string) $row['filter_slug'] );
		if ( '' === $slug ) {
			continue;
		}
		$out[ $slug ] = ! empty( $row['filter_label'] ) ? (string) $row['filter_label'] : $slug;
	}

	return ! empty( $out ) ? $out : $categories;
}
add_filter( 'ac_tech_blog_filter_categories', 'ac_tech_filter_blog_filter_categories', 20 );
