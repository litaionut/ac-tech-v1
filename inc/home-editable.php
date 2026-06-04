<?php
/**
 * Homepage editable content — ACF on front page (all sections).
 *
 * @package AC-Tech
 */

define( 'AC_TECH_HOME_SEED_OPTION', 'ac_tech_home_seeded_v2' );

/**
 * @deprecated Use AC_TECH_HOME_SEED_OPTION.
 */
define( 'AC_TECH_HOME_HERO_SEED_OPTION', 'ac_tech_home_hero_seeded_v1' );

/**
 * Map hero ACF fields to hero array keys.
 *
 * @return array<string, string>
 */
function ac_tech_home_hero_editable_text_map() {
	return array(
		'hero_badge_text'        => 'badge_text',
		'hero_title'             => 'title',
		'hero_title_accent'      => 'title_accent',
		'hero_text'              => 'text',
		'hero_cta_primary'       => 'cta_primary',
		'hero_cta_primary_url'   => 'cta_primary_url',
		'hero_cta_secondary'     => 'cta_secondary',
		'hero_cta_secondary_url' => 'cta_secondary_url',
		'hero_card_title'        => 'card_title',
		'hero_card_text'         => 'card_text',
	);
}

/**
 * Simple (non-repeater) ACF field names for load_value / seed.
 *
 * @return string[]
 */
function ac_tech_home_simple_acf_field_names() {
	return array_merge(
		array_keys( ac_tech_home_hero_editable_text_map() ),
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
			'home_cta_phone',
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
	$base = ac_tech_get_home_hero_base();
	$map  = ac_tech_home_hero_editable_text_map();
	$out  = array();

	foreach ( $map as $field_name => $hero_key ) {
		$out[ $field_name ] = isset( $base[ $hero_key ] ) ? (string) $base[ $hero_key ] : '';
	}

	return apply_filters( 'ac_tech_home_hero_editable_defaults', $out );
}

/**
 * All simple field defaults for seeding.
 *
 * @return array<string, string>
 */
function ac_tech_get_home_simple_field_defaults() {
	$defaults = ac_tech_get_home_hero_editable_defaults();

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
	$defaults['home_cta_phone']    = $cta['phone'];

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
 * Seed all homepage ACF fields on the static front page.
 */
function ac_tech_seed_home_acf_fields() {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	if ( get_option( AC_TECH_HOME_SEED_OPTION ) ) {
		return;
	}

	$page_id = ac_tech_get_front_page_id();
	if ( $page_id <= 0 ) {
		return;
	}

	foreach ( ac_tech_get_home_simple_field_defaults() as $field_name => $value ) {
		if ( '' === (string) $value ) {
			continue;
		}
		$existing = get_field( $field_name, $page_id );
		if ( ! ac_tech_home_acf_value_is_empty( $existing ) ) {
			continue;
		}
		update_field( $field_name, $value, $page_id );
	}

	foreach ( ac_tech_home_repeater_acf_field_names() as $repeater_name ) {
		$existing = get_field( $repeater_name, $page_id );
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
add_action( 'acf/init', 'ac_tech_seed_home_acf_fields', 25 );

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

	$field_name = (string) $field['name'];
	$page_id    = ac_tech_get_front_page_id();

	if ( $page_id <= 0 || (int) $post_id !== $page_id ) {
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
 * @param array<string, mixed> $hero Hero defaults.
 * @return array<string, mixed>
 */
function ac_tech_home_hero_apply_editable( $hero ) {
	foreach ( ac_tech_home_hero_editable_text_map() as $field_name => $hero_key ) {
		$current = isset( $hero[ $hero_key ] ) ? (string) $hero[ $hero_key ] : '';
		$value   = ac_tech_get_home_hero_field( $field_name, $current );

		if ( '' !== $value ) {
			if ( '_url' === substr( $hero_key, -4 ) ) {
				$hero[ $hero_key ] = esc_url_raw( $value );
			} else {
				$hero[ $hero_key ] = $value;
			}
		}
	}

	$image_id = ac_tech_get_home_hero_image_id();
	if ( $image_id > 0 ) {
		$hero['image_attachment_id'] = $image_id;
	}

	return $hero;
}

/**
 * @param array<string, mixed> $hero Hero data.
 * @return string
 */
function ac_tech_render_home_hero_image( $hero ) {
	$attachment_id = ! empty( $hero['image_attachment_id'] ) ? (int) $hero['image_attachment_id'] : 0;

	if ( $attachment_id > 0 ) {
		$attr = array(
			'class'         => 'ac-tech-home-hero__image',
			'loading'       => 'eager',
			'fetchpriority' => 'high',
			'decoding'      => 'async',
			'sizes'         => '(min-width: 64rem) 50vw, 100vw',
		);

		$html = ac_tech_get_acf_image( $attachment_id, 'large', $attr );
		return $html ? $html : '';
	}

	if ( ! empty( $hero['image'] ) && is_array( $hero['image'] ) ) {
		return ac_tech_responsive_image( $hero['image'] );
	}

	return '';
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
	return ac_tech_home_merge_header(
		$base,
		array(
			'home_cta_title'    => 'title',
			'home_cta_text'     => 'text',
			'home_cta_btn_text' => 'btn_text',
			'home_cta_btn_url'  => 'btn_url',
			'home_cta_phone'    => 'phone',
		)
	);
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
