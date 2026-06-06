<?php
/**
 * Homepage editable content — ACF on front page (all sections).
 *
 * @package AC-Tech
 */

define( 'AC_TECH_HOME_SEED_OPTION', 'ac_tech_home_seeded_v4' );

define( 'AC_TECH_HOME_CAROUSEL_SEED_OPTION', 'ac_tech_home_carousel_seeded_v5' );

/**
 * @deprecated Use AC_TECH_HOME_SEED_OPTION.
 */
define( 'AC_TECH_HOME_HERO_SEED_OPTION', 'ac_tech_home_hero_seeded_v1' );

/**
 * Carousel slide image fallback choices.
 *
 * @return array<string, string>
 */
function ac_tech_home_carousel_image_fallback_choices() {
	return array(
		'hero-hvac'          => 'hero-hvac',
		'service-instalare'  => 'service-instalare',
		'service-igienizare' => 'service-igienizare',
		'service-diagnostic' => 'service-diagnostic',
		'service-mentenanta' => 'service-mentenanta',
	);
}

/**
 * @return int
 */
function ac_tech_home_hero_slide_count() {
	return 3;
}

/**
 * @param int $slide_index Slide number 1–3.
 * @return string
 */
function ac_tech_home_hero_slide_field_name( $slide_index, $suffix ) {
	return 'hero_slide_' . (int) $slide_index . '_' . $suffix;
}

/**
 * @return string[]
 */
function ac_tech_home_hero_slide_acf_field_names() {
	$suffixes = array(
		'badge_icon',
		'badge_text',
		'title',
		'title_accent',
		'text',
		'cta_label',
		'cta_url',
		'image',
		'image_fallback',
	);
	$names    = array();

	for ( $i = 1; $i <= ac_tech_home_hero_slide_count(); $i++ ) {
		foreach ( $suffixes as $suffix ) {
			$names[] = ac_tech_home_hero_slide_field_name( $i, $suffix );
		}
	}

	return $names;
}

/**
 * Default ACF values for one carousel slide.
 *
 * @param int $slide_index Slide number 1–3.
 * @return array<string, string|int>
 */
function ac_tech_get_home_hero_slide_field_defaults( $slide_index ) {
	$slide_index = max( 1, min( ac_tech_home_hero_slide_count(), (int) $slide_index ) );
	$base_slides = ac_tech_get_home_hero_carousel_base();
	$slide       = isset( $base_slides[ $slide_index - 1 ] ) ? $base_slides[ $slide_index - 1 ] : array();
	$fallback    = '';

	if ( ! empty( $slide['image']['slug'] ) ) {
		$fallback = (string) $slide['image']['slug'];
	}

	return array(
		ac_tech_home_hero_slide_field_name( $slide_index, 'badge_icon' )     => (string) ( $slide['badge_icon'] ?? 'sell' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'badge_text' )     => (string) ( $slide['badge_text'] ?? '' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'title' )          => (string) ( $slide['title'] ?? '' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'title_accent' )    => (string) ( $slide['title_accent'] ?? '' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'text' )           => (string) ( $slide['text'] ?? '' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'cta_label' )      => (string) ( $slide['cta_label'] ?? '' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'cta_url' )        => (string) ( $slide['cta_url'] ?? '' ),
		ac_tech_home_hero_slide_field_name( $slide_index, 'image' )          => 0,
		ac_tech_home_hero_slide_field_name( $slide_index, 'image_fallback' )   => $fallback,
	);
}

/**
 * @return array<string, string|int>
 */
function ac_tech_get_home_hero_slide_all_field_defaults() {
	$defaults = array();

	for ( $i = 1; $i <= ac_tech_home_hero_slide_count(); $i++ ) {
		$defaults = array_merge( $defaults, ac_tech_get_home_hero_slide_field_defaults( $i ) );
	}

	return $defaults;
}

/**
 * @deprecated Hero text fields replaced by carousel repeater.
 *
 * @return array<string, string>
 */
function ac_tech_home_hero_editable_text_map() {
	return array();
}

/**
 * Simple (non-repeater) ACF field names for load_value / seed.
 *
 * @return string[]
 */
function ac_tech_home_simple_acf_field_names() {
	return array_merge(
		array_keys( ac_tech_home_hero_editable_text_map() ),
		ac_tech_home_hero_slide_acf_field_names(),
		array(
			'home_adv_title',
			'home_adv_text',
			'home_services_title',
			'home_services_text',
			'home_services_link_label',
			'home_services_link_url',
			'home_process_title',
			'home_process_text',
			'home_reviews_title',
			'home_reviews_rating',
			'home_cta_title',
			'home_cta_text',
			'home_cta_btn_text',
			'home_cta_btn_url',
		)
	);
}

/**
 * Repeater field names managed by theme.
 *
 * @return string[]
 */
function ac_tech_home_repeater_acf_field_names() {
	return array(
		'home_advantages',
		'home_services',
		'home_process',
		'home_reviews',
	);
}

/**
 * @param mixed $value Raw value.
 * @return bool
 */
function ac_tech_home_acf_value_is_empty( $value ) {
	if ( is_array( $value ) ) {
		return empty( $value );
	}

	return null === $value || false === $value || '' === $value || 0 === $value || '0' === $value;
}

/**
 * @param string $field_name ACF field name.
 * @param mixed  $default      Fallback.
 * @return mixed
 */
function ac_tech_get_home_acf_field( $field_name, $default = null ) {
	if ( function_exists( 'get_field' ) ) {
		$value = ac_tech_get_front_page_field( $field_name, null );
		if ( ! ac_tech_home_acf_value_is_empty( $value ) ) {
			return $value;
		}
	}

	return $default;
}

/**
 * Merge header array from simple ACF fields.
 *
 * @param array<string, string> $base     Defaults.
 * @param array<string, string> $field_map ACF field => array key.
 * @return array<string, string>
 */
function ac_tech_home_merge_header( $base, $field_map ) {
	foreach ( $field_map as $acf_name => $key ) {
		$current = isset( $base[ $key ] ) ? (string) $base[ $key ] : '';
		$value   = ac_tech_get_home_acf_field( $acf_name, null );

		if ( ac_tech_home_acf_value_is_empty( $value ) ) {
			continue;
		}

		if ( '_url' === substr( $key, -4 ) ) {
			$base[ $key ] = esc_url_raw( (string) $value );
		} else {
			$base[ $key ] = (string) $value;
		}
	}

	return $base;
}

/**
 * Hero text defaults for seed / load_value.
 *
 * @return array<string, string>
 */
function ac_tech_get_home_hero_editable_defaults() {
	return apply_filters( 'ac_tech_home_hero_editable_defaults', array() );
}

/**
 * All simple field defaults for seeding.
 *
 * @return array<string, string>
 */
function ac_tech_get_home_simple_field_defaults() {
	$defaults = ac_tech_get_home_hero_slide_all_field_defaults();

	$adv_h = ac_tech_get_home_advantages_header_base();
	$defaults['home_adv_title'] = $adv_h['title'];
	$defaults['home_adv_text']  = $adv_h['text'];

	$svc_h = ac_tech_get_home_services_header_base();
	$defaults['home_services_title']      = $svc_h['title'];
	$defaults['home_services_text']       = $svc_h['text'];
	$defaults['home_services_link_label'] = $svc_h['link_label'];
	$defaults['home_services_link_url']   = $svc_h['link_url'];

	$proc_h = ac_tech_get_home_process_header_base();
	$defaults['home_process_title'] = $proc_h['title'];
	$defaults['home_process_text']  = $proc_h['text'];

	$rev_h = ac_tech_get_home_reviews_header_base();
	$defaults['home_reviews_title']  = $rev_h['title'];
	$defaults['home_reviews_rating'] = $rev_h['rating'];

	$cta = ac_tech_get_home_cta_final_base();
	$defaults['home_cta_title']    = $cta['title'];
	$defaults['home_cta_text']     = $cta['text'];
	$defaults['home_cta_btn_text'] = $cta['btn_text'];
	$defaults['home_cta_btn_url']  = $cta['btn_url'];

	return apply_filters( 'ac_tech_home_simple_field_defaults', $defaults );
}

/**
 * Repeater defaults for ACF seed / empty state.
 *
 * @param string $field_name Repeater field name.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_home_repeater_defaults( $field_name ) {
	switch ( $field_name ) {
		case 'home_advantages':
			$rows = array();
			foreach ( ac_tech_get_home_advantages_base() as $item ) {
				$rows[] = array(
					'advantage_icon'  => $item['icon'],
					'advantage_title' => $item['title'],
					'advantage_text'  => $item['text'],
				);
			}
			return $rows;

		case 'home_services':
			$rows = array();
			foreach ( ac_tech_get_home_services_base() as $item ) {
				$rows[] = array(
					'service_title'      => $item['title'],
					'service_text'       => $item['text'],
					'service_image'      => 0,
					'service_link_label' => $item['link_label'],
					'service_link_url'   => $item['link_url'],
				);
			}
			return $rows;

		case 'home_process':
			$rows = array();
			foreach ( ac_tech_get_home_process_steps_base() as $item ) {
				$rows[] = array(
					'process_step'      => $item['step'],
					'process_title'     => $item['title'],
					'process_text'      => $item['text'],
					'process_is_final'  => ! empty( $item['is_final'] ) ? 1 : 0,
				);
			}
			return $rows;

		case 'home_reviews':
			$rows = array();
			foreach ( ac_tech_get_home_reviews_base() as $item ) {
				$rows[] = array(
					'review_text'     => $item['text'],
					'review_name'     => $item['name'],
					'review_role'     => $item['role'],
					'review_avatar'   => 0,
					'review_featured' => ! empty( $item['featured'] ) ? 1 : 0,
				);
			}
			return $rows;

		default:
			return array();
	}
}

/**
 * Copy legacy repeater rows into flat slide fields when needed.
 *
 * @param int $page_id Front page ID.
 */
function ac_tech_migrate_home_hero_slides_repeater_to_flat( $page_id ) {
	if ( ! function_exists( 'update_field' ) || $page_id <= 0 ) {
		return;
	}

	foreach ( ac_tech_home_hero_slide_acf_field_names() as $field_name ) {
		$existing = ac_tech_get_home_acf_stored_value( $field_name, $page_id );
		if ( ! ac_tech_home_acf_value_is_empty( $existing ) ) {
			return;
		}
	}

	$rows = ac_tech_get_home_acf_stored_value( 'home_hero_slides', $page_id );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return;
	}

	$map = array(
		'hero_slide_badge_icon'     => 'badge_icon',
		'hero_slide_badge_text'     => 'badge_text',
		'hero_slide_title'          => 'title',
		'hero_slide_title_accent'   => 'title_accent',
		'hero_slide_text'           => 'text',
		'hero_slide_cta_label'      => 'cta_label',
		'hero_slide_cta_url'        => 'cta_url',
		'hero_slide_image'          => 'image',
		'hero_slide_image_fallback' => 'image_fallback',
	);

	for ( $i = 0; $i < min( ac_tech_home_hero_slide_count(), count( $rows ) ); $i++ ) {
		$row = $rows[ $i ];
		if ( ! is_array( $row ) ) {
			continue;
		}

		$slide_index = $i + 1;
		foreach ( $map as $legacy_key => $suffix ) {
			if ( ! isset( $row[ $legacy_key ] ) || ac_tech_home_acf_value_is_empty( $row[ $legacy_key ] ) ) {
				continue;
			}

			update_field(
				ac_tech_home_hero_slide_field_name( $slide_index, $suffix ),
				$row[ $legacy_key ],
				$page_id
			);
		}
	}
}

/**
 * Seed hero carousel flat fields on the front page.
 *
 * @param int $page_id Front page ID.
 */
function ac_tech_seed_home_hero_slide_fields( $page_id ) {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) || $page_id <= 0 ) {
		return;
	}

	ac_tech_migrate_home_hero_slides_repeater_to_flat( $page_id );

	foreach ( ac_tech_get_home_hero_slide_all_field_defaults() as $field_name => $value ) {
		if ( ac_tech_home_acf_value_is_empty( $value ) ) {
			continue;
		}

		$existing = ac_tech_get_home_acf_stored_value( $field_name, $page_id );
		if ( ! ac_tech_home_acf_value_is_empty( $existing ) ) {
			continue;
		}

		update_field( $field_name, $value, $page_id );
	}
}

/**
 * Read ACF value from the database only (skip load_value theme defaults).
 *
 * @param string $field_name Field name.
 * @param int    $post_id    Post ID.
 * @return mixed
 */
function ac_tech_get_home_acf_stored_value( $field_name, $post_id ) {
	if ( ! function_exists( 'get_field' ) || $post_id <= 0 ) {
		return null;
	}

	$filter  = 'ac_tech_acf_load_home_field_value';
	$removed = false;

	if ( has_filter( 'acf/load_value', $filter ) ) {
		remove_filter( 'acf/load_value', $filter, 10 );
		$removed = true;
	}

	$value = get_field( $field_name, $post_id, false );

	if ( $removed ) {
		add_filter( 'acf/load_value', $filter, 10, 3 );
	}

	return $value;
}

/**
 * Seed all homepage ACF fields on the static front page.
 */
function ac_tech_seed_home_acf_fields() {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	$page_id = ac_tech_get_front_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	if ( ! get_option( AC_TECH_HOME_SEED_OPTION ) ) {
		foreach ( ac_tech_get_home_simple_field_defaults() as $field_name => $value ) {
			if ( ac_tech_home_acf_value_is_empty( $value ) ) {
				continue;
			}
			$existing = ac_tech_get_home_acf_stored_value( $field_name, $page_id );
			if ( ! ac_tech_home_acf_value_is_empty( $existing ) ) {
				continue;
			}
			update_field( $field_name, $value, $page_id );
		}

		foreach ( ac_tech_home_repeater_acf_field_names() as $repeater_name ) {
			$existing = ac_tech_get_home_acf_stored_value( $repeater_name, $page_id );
			if ( ! ac_tech_home_acf_value_is_empty( $existing ) ) {
				continue;
			}
			$rows = ac_tech_get_home_repeater_defaults( $repeater_name );
			if ( ! empty( $rows ) ) {
				update_field( $repeater_name, $rows, $page_id );
			}
		}

		update_option( AC_TECH_HOME_SEED_OPTION, 1, false );
	}

	ac_tech_seed_home_hero_slide_fields( $page_id );
}
add_action( 'acf/init', 'ac_tech_seed_home_acf_fields', 25 );

/**
 * Seed carousel slide fields (runs even after main homepage seed).
 */
function ac_tech_seed_home_carousel_acf_fields() {
	$page_id = ac_tech_get_front_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	ac_tech_seed_home_hero_slide_fields( $page_id );
	update_option( AC_TECH_HOME_CAROUSEL_SEED_OPTION, 1, false );
}
add_action( 'acf/init', 'ac_tech_seed_home_carousel_acf_fields', 26 );

/** @deprecated */
function ac_tech_seed_home_hero_acf_fields() {
	ac_tech_seed_home_acf_fields();
}

/**
 * @param mixed  $value   Stored value.
 * @param mixed  $post_id Post ID.
 * @param array  $field   Field config.
 * @return mixed
 */
function ac_tech_acf_load_home_field_value( $value, $post_id, $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $value;
	}

	$field_name       = (string) $field['name'];
	$page_id          = ac_tech_get_front_page_id();
	$resolved_post_id = function_exists( 'ac_tech_acf_resolve_post_id' )
		? ac_tech_acf_resolve_post_id( $post_id )
		: (int) $post_id;

	if ( $page_id <= 0 || $resolved_post_id !== $page_id ) {
		return $value;
	}

	if ( ! ac_tech_home_acf_value_is_empty( $value ) ) {
		return $value;
	}

	if ( in_array( $field_name, ac_tech_home_repeater_acf_field_names(), true ) ) {
		return ac_tech_get_home_repeater_defaults( $field_name );
	}

	$simple = ac_tech_get_home_simple_field_defaults();
	if ( isset( $simple[ $field_name ] ) ) {
		return $simple[ $field_name ];
	}

	return $value;
}
add_filter( 'acf/load_value', 'ac_tech_acf_load_home_field_value', 10, 3 );

/**
 * @param array $field Field config.
 * @return array
 */
function ac_tech_acf_load_home_field_ui_defaults( $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $field;
	}

	$name = (string) $field['name'];

	if ( in_array( $name, ac_tech_home_repeater_acf_field_names(), true ) ) {
		return $field;
	}

	$simple = ac_tech_get_home_simple_field_defaults();
	if ( isset( $simple[ $name ] ) && '' !== $simple[ $name ] ) {
		$field['default_value'] = $simple[ $name ];
	}

	return $field;
}
add_filter( 'acf/load_field', 'ac_tech_acf_load_home_field_ui_defaults', 20 );

/**
 * @param string $field_name Field name.
 * @param string $default    Fallback.
 * @return string
 */
function ac_tech_get_home_hero_field( $field_name, $default = '' ) {
	$value = ac_tech_get_home_acf_field( $field_name, null );
	if ( ! ac_tech_home_acf_value_is_empty( $value ) ) {
		return is_string( $value ) ? $value : (string) $value;
	}

	$mod = get_theme_mod( 'ac_tech_' . $field_name, '' );
	if ( '' !== $mod && null !== $mod ) {
		return (string) $mod;
	}

	return $default;
}

/**
 * @return int
 */
function ac_tech_get_home_hero_image_id() {
	$acf_id = (int) ac_tech_get_home_acf_field( 'hero_image', 0 );
	if ( $acf_id > 0 ) {
		return $acf_id;
	}

	return (int) get_theme_mod( 'ac_tech_hero_image', 0 );
}

/**
 * @param array<int, array<string, mixed>> $base Carousel slides.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_home_merge_hero_carousel( $base ) {
	$out = array();

	for ( $i = 1; $i <= ac_tech_home_hero_slide_count(); $i++ ) {
		$item = isset( $base[ $i - 1 ] ) ? $base[ $i - 1 ] : array(
			'badge_icon'   => 'sell',
			'badge_text'   => '',
			'title'        => '',
			'title_accent' => '',
			'text'         => '',
			'cta_label'    => '',
			'cta_url'      => '',
			'cta_icon'     => 'arrow_forward',
			'image'        => ac_tech_get_home_carousel_image_config( 'hero-hvac' ),
		);

		$badge_icon = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'badge_icon' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $badge_icon ) ) {
			$item['badge_icon'] = sanitize_key( (string) $badge_icon );
		}

		$badge_text = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'badge_text' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $badge_text ) ) {
			$item['badge_text'] = (string) $badge_text;
		}

		$title = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'title' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $title ) ) {
			$item['title'] = (string) $title;
		}

		$title_accent = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'title_accent' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $title_accent ) ) {
			$item['title_accent'] = (string) $title_accent;
		}

		$text = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'text' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $text ) ) {
			$item['text'] = (string) $text;
		}

		$cta_label = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'cta_label' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $cta_label ) ) {
			$item['cta_label'] = (string) $cta_label;
		}

		$cta_url = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'cta_url' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $cta_url ) ) {
			$item['cta_url'] = esc_url_raw( (string) $cta_url );
		}

		$image_id = (int) ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'image' ), 0 );
		if ( $image_id > 0 ) {
			$item['image_attachment_id'] = $image_id;
		}

		$fallback = ac_tech_get_home_acf_field( ac_tech_home_hero_slide_field_name( $i, 'image_fallback' ), null );
		if ( ! ac_tech_home_acf_value_is_empty( $fallback ) ) {
			$fallback_key = sanitize_key( (string) $fallback );
			if ( isset( ac_tech_home_carousel_image_fallback_choices()[ $fallback_key ] ) ) {
				$item['image'] = ac_tech_get_home_carousel_image_config( $fallback_key );
			}
		}

		$out[] = $item;
	}

	return ! empty( $out ) ? $out : $base;
}

/**
 * @param array<string, mixed> $slide Slide data.
 * @param bool                 $is_first Whether this is the first (LCP) slide.
 * @return string
 */
function ac_tech_render_home_carousel_slide_image( $slide, $is_first = false ) {
	$attachment_id = ! empty( $slide['image_attachment_id'] ) ? (int) $slide['image_attachment_id'] : 0;

	if ( $attachment_id > 0 ) {
		$attr = array(
			'class'    => 'ac-tech-home-carousel__media-img',
			'loading'  => $is_first ? 'eager' : 'lazy',
			'decoding' => 'async',
			'sizes'    => '(min-width: 64rem) 50vw, 100vw',
		);

		if ( $is_first ) {
			$attr['fetchpriority'] = 'high';
		}

		$html = ac_tech_get_acf_image( $attachment_id, 'large', $attr );
		return $html ? $html : '';
	}

	if ( ! empty( $slide['image'] ) && is_array( $slide['image'] ) ) {
		$config = $slide['image'];
		if ( $is_first ) {
			$config['loading']       = 'eager';
			$config['fetchpriority'] = 'high';
		} else {
			$config['loading'] = 'lazy';
			unset( $config['fetchpriority'] );
		}
		$config['class'] = 'ac-tech-home-carousel__media-img';
		return ac_tech_responsive_image( $config );
	}

	return '';
}

/** @deprecated Single hero editable merge — carousel uses ac_tech_home_merge_hero_carousel(). */
function ac_tech_home_hero_apply_editable( $hero ) {
	return $hero;
}

/**
 * Highlight discount percentages and "gratuit" variants in carousel copy.
 *
 * @param string $text Plain text.
 * @return string Safe HTML.
 */
function ac_tech_highlight_carousel_promo_text( $text ) {
	$text = (string) $text;
	if ( '' === $text ) {
		return '';
	}

	$escaped = esc_html( $text );

	$highlighted = preg_replace(
		'/(\d+\s*%)/u',
		'<span class="ac-tech-home-carousel__promo-highlight">$1</span>',
		$escaped
	);

	if ( is_string( $highlighted ) ) {
		$highlighted = preg_replace(
			'/(?<![\p{L}])((?:gratuit)(?:[aăe]?))(?![\p{L}])/iu',
			'<span class="ac-tech-home-carousel__promo-highlight">$1</span>',
			$highlighted
		);
	}

	if ( ! is_string( $highlighted ) ) {
		return $escaped;
	}

	return wp_kses(
		$highlighted,
		array(
			'span' => array(
				'class' => true,
			),
		)
	);
}

/** @deprecated */
function ac_tech_render_home_hero_image( $hero ) {
	return ac_tech_render_home_carousel_slide_image( $hero, true );
}

/**
 * @param array<string, string> $base Header defaults.
 * @return array<string, string>
 */
function ac_tech_home_merge_advantages_header( $base ) {
	return ac_tech_home_merge_header(
		$base,
		array(
			'home_adv_title' => 'title',
			'home_adv_text'  => 'text',
		)
	);
}

/**
 * @param array<int, array<string, mixed>> $base Items.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_home_merge_advantages( $base ) {
	$rows = ac_tech_get_home_acf_field( 'home_advantages', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $base;
	}

	$out = array();
	foreach ( $rows as $index => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item = isset( $base[ $index ] ) ? $base[ $index ] : array(
			'icon'  => 'bolt',
			'title' => '',
			'text'  => '',
		);

		if ( ! empty( $row['advantage_icon'] ) ) {
			$item['icon'] = sanitize_key( (string) $row['advantage_icon'] );
		}
		if ( ! empty( $row['advantage_title'] ) ) {
			$item['title'] = (string) $row['advantage_title'];
		}
		if ( ! empty( $row['advantage_text'] ) ) {
			$item['text'] = (string) $row['advantage_text'];
		}

		$out[] = $item;
	}

	return ! empty( $out ) ? $out : $base;
}

/**
 * @param array<string, mixed> $base Header.
 * @return array<string, mixed>
 */
function ac_tech_home_merge_services_header( $base ) {
	return ac_tech_home_merge_header(
		$base,
		array(
			'home_services_title'      => 'title',
			'home_services_text'       => 'text',
			'home_services_link_label' => 'link_label',
			'home_services_link_url'   => 'link_url',
		)
	);
}

/**
 * @param array<int, array<string, mixed>> $base Services.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_home_merge_services( $base ) {
	$rows = ac_tech_get_home_acf_field( 'home_services', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $base;
	}

	$out = array();
	foreach ( $rows as $index => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$item = isset( $base[ $index ] ) ? $base[ $index ] : array(
			'title'      => '',
			'text'       => '',
			'image'      => array(),
			'link_label' => '',
			'link_url'   => '',
		);

		if ( ! empty( $row['service_title'] ) ) {
			$item['title'] = (string) $row['service_title'];
		}
		if ( ! empty( $row['service_text'] ) ) {
			$item['text'] = (string) $row['service_text'];
		}
		if ( ! empty( $row['service_link_label'] ) ) {
			$item['link_label'] = (string) $row['service_link_label'];
		}
		if ( ! empty( $row['service_link_url'] ) ) {
			$item['link_url'] = esc_url_raw( (string) $row['service_link_url'] );
		}

		$image_id = ! empty( $row['service_image'] ) ? (int) $row['service_image'] : 0;
		if ( $image_id > 0 ) {
			$item['image_attachment_id'] = $image_id;
		}

		$out[] = $item;
	}

	return ! empty( $out ) ? $out : $base;
}

/**
 * @param array<string, string> $base Header.
 * @return array<string, string>
 */
function ac_tech_home_merge_process_header( $base ) {
	return ac_tech_home_merge_header(
		$base,
		array(
			'home_process_title' => 'title',
			'home_process_text'  => 'text',
		)
	);
}

/**
 * @param array<int, array<string, mixed>> $base Steps.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_home_merge_process_steps( $base ) {
	$rows = ac_tech_get_home_acf_field( 'home_process', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $base;
	}

	$out = array();
	foreach ( $rows as $index => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$item = isset( $base[ $index ] ) ? $base[ $index ] : array(
			'step'     => (string) ( $index + 1 ),
			'title'    => '',
			'text'     => '',
			'is_final' => false,
		);

		if ( isset( $row['process_step'] ) && '' !== (string) $row['process_step'] ) {
			$item['step'] = (string) $row['process_step'];
		}
		if ( ! empty( $row['process_title'] ) ) {
			$item['title'] = (string) $row['process_title'];
		}
		if ( ! empty( $row['process_text'] ) ) {
			$item['text'] = (string) $row['process_text'];
		}
		$item['is_final'] = ! empty( $row['process_is_final'] );

		$out[] = $item;
	}

	return ! empty( $out ) ? $out : $base;
}

/**
 * @param array<string, string> $base Header.
 * @return array<string, string>
 */
function ac_tech_home_merge_reviews_header( $base ) {
	return ac_tech_home_merge_header(
		$base,
		array(
			'home_reviews_title'  => 'title',
			'home_reviews_rating' => 'rating',
		)
	);
}

/**
 * @param array<int, array<string, mixed>> $base Reviews.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_home_merge_reviews( $base ) {
	$rows = ac_tech_get_home_acf_field( 'home_reviews', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $base;
	}

	$out = array();
	foreach ( $rows as $index => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$item = isset( $base[ $index ] ) ? $base[ $index ] : array(
			'text'     => '',
			'name'     => '',
			'role'     => '',
			'avatar'   => array(),
			'featured' => false,
		);

		if ( ! empty( $row['review_text'] ) ) {
			$item['text'] = (string) $row['review_text'];
		}
		if ( ! empty( $row['review_name'] ) ) {
			$item['name'] = (string) $row['review_name'];
		}
		if ( ! empty( $row['review_role'] ) ) {
			$item['role'] = (string) $row['review_role'];
		}
		$item['featured'] = ! empty( $row['review_featured'] );

		$avatar_id = ! empty( $row['review_avatar'] ) ? (int) $row['review_avatar'] : 0;
		if ( $avatar_id > 0 ) {
			$item['avatar_attachment_id'] = $avatar_id;
		}

		$out[] = $item;
	}

	return ! empty( $out ) ? $out : $base;
}

/**
 * @param array<string, mixed> $base CTA block.
 * @return array<string, mixed>
 */
function ac_tech_home_merge_cta_final( $base ) {
	$base = ac_tech_home_merge_header(
		$base,
		array(
			'home_cta_title'    => 'title',
			'home_cta_text'     => 'text',
			'home_cta_btn_text' => 'btn_text',
			'home_cta_btn_url'  => 'btn_url',
		)
	);

	if ( function_exists( 'ac_tech_get_business_phone_display' ) ) {
		$base['phone'] = ac_tech_get_business_phone_display();
	}

	return $base;
}

/**
 * Render service or review image from attachment or theme WebP config.
 *
 * @param array<string, mixed> $item       Item with image or image_attachment_id / avatar_attachment_id.
 * @param string               $config_key Config key: image or avatar.
 * @param string               $css_class  Image class.
 * @return string
 */
function ac_tech_render_home_media_item_image( $item, $config_key, $css_class ) {
	$attach_key = ( 'avatar' === $config_key ) ? 'avatar_attachment_id' : 'image_attachment_id';
	$attach_id  = ! empty( $item[ $attach_key ] ) ? (int) $item[ $attach_key ] : 0;

	if ( $attach_id > 0 ) {
		$size = ( 'avatar' === $config_key ) ? 'thumbnail' : 'large';
		$html = ac_tech_get_acf_image(
			$attach_id,
			$size,
			array(
				'class'    => $css_class,
				'loading'  => 'lazy',
				'decoding' => 'async',
			)
		);
		return $html ? $html : '';
	}

	if ( ! empty( $item[ $config_key ] ) && is_array( $item[ $config_key ] ) ) {
		return ac_tech_responsive_image( $item[ $config_key ] );
	}

	return '';
}
