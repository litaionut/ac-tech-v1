<?php
/**
 * Services catalog page — ACF editable content.
 *
 * @package AC-Tech
 */

define( 'AC_TECH_SERVICES_ALL_SEED_OPTION', 'ac_tech_services_all_seeded_v1' );

/**
 * @return int
 */
function ac_tech_get_services_all_page_id() {
	if ( is_page() && is_page_template( 'template-services.php' ) ) {
		return (int) get_queried_object_id();
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'template-services.php',
		)
	);

	return ! empty( $pages[0] ) ? (int) $pages[0] : 0;
}

/**
 * @param mixed $value Raw value.
 * @return bool
 */
function ac_tech_services_all_acf_value_is_empty( $value ) {
	if ( is_array( $value ) ) {
		return empty( $value );
	}

	return null === $value || false === $value || '' === $value;
}

/**
 * @return string[]
 */
function ac_tech_services_all_simple_acf_field_names() {
	return array(
		'services_all_hero_badge',
		'services_all_hero_title',
		'services_all_hero_text',
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_services_all_simple_field_defaults() {
	$hero = ac_tech_get_services_all_hero_base();

	return apply_filters(
		'ac_tech_services_all_simple_field_defaults',
		array(
			'services_all_hero_badge' => $hero['badge'],
			'services_all_hero_title' => '',
			'services_all_hero_text'  => $hero['text'],
		)
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_services_all_acf_rows_from_base() {
	$rows = array();

	foreach ( ac_tech_get_services_all_items_base() as $item ) {
		$bullets = array();
		if ( ! empty( $item['bullets'] ) && is_array( $item['bullets'] ) ) {
			foreach ( $item['bullets'] as $bullet ) {
				$bullets[] = array(
					'bullet_icon' => (string) ( $bullet['icon'] ?? 'check_circle' ),
					'bullet_text' => (string) ( $bullet['text'] ?? '' ),
				);
			}
		}

		$highlights = array();
		if ( ! empty( $item['highlights'] ) && is_array( $item['highlights'] ) ) {
			foreach ( $item['highlights'] as $highlight ) {
				$highlights[] = array(
					'highlight_icon'  => (string) ( $highlight['icon'] ?? 'check_circle' ),
					'highlight_label' => (string) ( $highlight['label'] ?? '' ),
				);
			}
		}

		$rows[] = array(
			'item_layout'             => (string) ( $item['layout'] ?? 'split' ),
			'item_title'              => (string) ( $item['title'] ?? '' ),
			'item_text'               => (string) ( $item['text'] ?? '' ),
			'item_bullets'            => $bullets,
			'item_highlights'         => $highlights,
			'item_duration'           => (string) ( $item['duration'] ?? '' ),
			'item_duration_icon'      => (string) ( $item['duration_icon'] ?? 'schedule' ),
			'item_cta_label'          => (string) ( $item['cta_label'] ?? '' ),
			'item_cta_url'            => (string) ( $item['cta_url'] ?? '' ),
			'item_card_icon'          => (string) ( $item['card_icon'] ?? 'check_circle' ),
			'item_image'              => 0,
			'item_image_alt'          => '',
			'item_image_fallback_key' => (string) ( $item['image_fallback_key'] ?? '' ),
		);
	}

	return $rows;
}

/**
 * @param string $field_name Field name.
 * @param mixed  $default    Fallback.
 * @return mixed
 */
function ac_tech_get_services_all_page_field( $field_name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$page_id = ac_tech_get_services_all_page_id();
	if ( $page_id <= 0 ) {
		return $default;
	}

	$value = get_field( $field_name, $page_id );
	if ( ac_tech_services_all_acf_value_is_empty( $value ) ) {
		return $default;
	}

	return $value;
}

/**
 * Seed services page ACF fields.
 */
function ac_tech_seed_services_all_acf_fields() {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	if ( get_option( AC_TECH_SERVICES_ALL_SEED_OPTION ) ) {
		return;
	}

	$page_id = ac_tech_get_services_all_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	foreach ( ac_tech_get_services_all_simple_field_defaults() as $field_name => $value ) {
		if ( '' === (string) $value ) {
			continue;
		}

		$existing = get_field( $field_name, $page_id );
		if ( ! ac_tech_services_all_acf_value_is_empty( $existing ) ) {
			continue;
		}

		update_field( $field_name, $value, $page_id );
	}

	$existing_items = get_field( 'services_all_items', $page_id );
	if ( ac_tech_services_all_acf_value_is_empty( $existing_items ) ) {
		update_field( 'services_all_items', ac_tech_services_all_acf_rows_from_base(), $page_id );
	}

	update_option( AC_TECH_SERVICES_ALL_SEED_OPTION, 1, false );
}
add_action( 'acf/init', 'ac_tech_seed_services_all_acf_fields', 25 );

/**
 * @param mixed $value   Value.
 * @param mixed $post_id Post ID.
 * @param array $field   Field.
 * @return mixed
 */
function ac_tech_acf_load_services_all_field_value( $value, $post_id, $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $value;
	}

	$page_id = ac_tech_get_services_all_page_id();
	if ( $page_id <= 0 || (int) $post_id !== $page_id ) {
		return $value;
	}

	$field_name = (string) $field['name'];

	if ( 'services_all_items' === $field_name ) {
		if ( ! ac_tech_services_all_acf_value_is_empty( $value ) ) {
			return $value;
		}
		return ac_tech_services_all_acf_rows_from_base();
	}

	if ( ! in_array( $field_name, ac_tech_services_all_simple_acf_field_names(), true ) ) {
		return $value;
	}

	if ( ! ac_tech_services_all_acf_value_is_empty( $value ) ) {
		return $value;
	}

	$defaults = ac_tech_get_services_all_simple_field_defaults();

	return isset( $defaults[ $field_name ] ) ? $defaults[ $field_name ] : $value;
}
add_filter( 'acf/load_value', 'ac_tech_acf_load_services_all_field_value', 10, 3 );

/**
 * @param array $field Field config.
 * @return array
 */
function ac_tech_acf_load_services_all_field_ui_defaults( $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $field;
	}

	$defaults = ac_tech_get_services_all_simple_field_defaults();
	$name     = (string) $field['name'];

	if ( isset( $defaults[ $name ] ) && '' !== (string) $defaults[ $name ] ) {
		$field['default_value'] = $defaults[ $name ];
	}

	return $field;
}
add_filter( 'acf/load_field', 'ac_tech_acf_load_services_all_field_ui_defaults', 20 );

/**
 * @return array{badge: string, title: string, text: string}
 */
function ac_tech_get_services_all_hero() {
	$base  = ac_tech_get_services_all_hero_base();
	$title = (string) ac_tech_get_services_all_page_field( 'services_all_hero_title', '' );

	if ( '' === $title && is_page() ) {
		$title = get_the_title();
	}

	return array(
		'badge' => (string) ac_tech_get_services_all_page_field( 'services_all_hero_badge', $base['badge'] ),
		'title' => $title,
		'text'  => (string) ac_tech_get_services_all_page_field( 'services_all_hero_text', $base['text'] ),
	);
}

/**
 * @param array<string, mixed> $row ACF row.
 * @return array<string, mixed>
 */
function ac_tech_services_all_normalize_item_row( $row ) {
	if ( ! is_array( $row ) ) {
		return array();
	}

	$layout = sanitize_key( (string) ( $row['item_layout'] ?? 'split' ) );
	if ( ! in_array( $layout, array( 'split', 'split_reverse', 'card', 'panel' ), true ) ) {
		$layout = 'split';
	}

	$bullets = array();
	if ( ! empty( $row['item_bullets'] ) && is_array( $row['item_bullets'] ) ) {
		foreach ( $row['item_bullets'] as $bullet ) {
			if ( ! is_array( $bullet ) ) {
				continue;
			}
			$text = trim( (string) ( $bullet['bullet_text'] ?? '' ) );
			if ( '' === $text ) {
				continue;
			}
			$bullets[] = array(
				'icon' => sanitize_key( (string) ( $bullet['bullet_icon'] ?? 'check_circle' ) ) ?: 'check_circle',
				'text' => $text,
			);
		}
	}

	$highlights = array();
	if ( ! empty( $row['item_highlights'] ) && is_array( $row['item_highlights'] ) ) {
		foreach ( $row['item_highlights'] as $highlight ) {
			if ( ! is_array( $highlight ) ) {
				continue;
			}
			$label = trim( (string) ( $highlight['highlight_label'] ?? '' ) );
			if ( '' === $label ) {
				continue;
			}
			$highlights[] = array(
				'icon'  => sanitize_key( (string) ( $highlight['highlight_icon'] ?? 'check_circle' ) ) ?: 'check_circle',
				'label' => $label,
			);
		}
	}

	$cta_url = trim( (string) ( $row['item_cta_url'] ?? '' ) );
	if ( '' === $cta_url ) {
		$cta_url = ac_tech_services_all_default_cta_url();
	}

	return array(
		'layout'             => $layout,
		'title'              => (string) ( $row['item_title'] ?? '' ),
		'text'               => (string) ( $row['item_text'] ?? '' ),
		'bullets'            => $bullets,
		'highlights'         => $highlights,
		'duration'           => (string) ( $row['item_duration'] ?? '' ),
		'duration_icon'      => sanitize_key( (string) ( $row['item_duration_icon'] ?? 'schedule' ) ) ?: 'schedule',
		'cta_label'          => (string) ( $row['item_cta_label'] ?? __( 'Programează acum', 'ac-tech' ) ),
		'cta_url'            => $cta_url,
		'card_icon'          => sanitize_key( (string) ( $row['item_card_icon'] ?? 'check_circle' ) ) ?: 'check_circle',
		'image_id'           => (int) ( $row['item_image'] ?? 0 ),
		'image_alt'          => (string) ( $row['item_image_alt'] ?? '' ),
		'image_fallback_key' => sanitize_key( (string) ( $row['item_image_fallback_key'] ?? '' ) ),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_services_all_items() {
	$rows = ac_tech_get_services_all_page_field( 'services_all_items', null );

	if ( ac_tech_services_all_acf_value_is_empty( $rows ) ) {
		return apply_filters( 'ac_tech_services_all_items', ac_tech_get_services_all_items_base() );
	}

	$items = array();
	if ( is_array( $rows ) ) {
		foreach ( $rows as $row ) {
			$item = ac_tech_services_all_normalize_item_row( $row );
			if ( '' === $item['title'] ) {
				continue;
			}
			$items[] = $item;
		}
	}

	if ( empty( $items ) ) {
		$items = ac_tech_get_services_all_items_base();
	}

	return apply_filters( 'ac_tech_services_all_items', $items );
}

/**
 * @param array<string, mixed> $item Normalized item.
 * @return string HTML.
 */
function ac_tech_services_all_render_item_image( $item ) {
	$image_id = (int) ( $item['image_id'] ?? 0 );
	$alt      = trim( (string) ( $item['image_alt'] ?? '' ) );

	if ( $image_id > 0 ) {
		$attr = array(
			'class'    => 'ac-tech-services-all__media-img',
			'loading'  => 'lazy',
			'decoding' => 'async',
		);
		if ( '' !== $alt ) {
			$attr['alt'] = $alt;
		}
		$html = ac_tech_get_acf_image( $image_id, 'large', $attr );
		if ( $html ) {
			return $html;
		}
	}

	$key = (string) ( $item['image_fallback_key'] ?? '' );
	if ( '' === $key ) {
		return '';
	}

	$fallback = ac_tech_get_services_all_image_fallback( $key );
	if ( empty( $fallback ) || ! is_array( $fallback ) ) {
		return '';
	}

	if ( '' !== $alt ) {
		$fallback['alt'] = $alt;
	}

	return ac_tech_responsive_image( $fallback );
}
