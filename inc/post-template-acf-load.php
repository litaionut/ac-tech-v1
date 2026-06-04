<?php
/**
 * ACF load_value / load_field — demo defaults for post templates in admin.
 *
 * @package AC-Tech
 */

/**
 * @param int $post_id Post ID.
 * @return string Template filename or empty.
 */
function ac_tech_get_post_template_file_for_id( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return '';
	}

	$file = get_post_meta( $post_id, '_wp_page_template', true );

	return ( is_string( $file ) && 'default' !== $file ) ? $file : '';
}

/**
 * @param mixed $post_id ACF post ID (int or "post_123").
 * @return int
 */
function ac_tech_normalize_acf_post_id( $post_id ) {
	if ( is_numeric( $post_id ) ) {
		return (int) $post_id;
	}

	if ( is_string( $post_id ) && 0 === strpos( $post_id, 'post_' ) ) {
		return (int) substr( $post_id, 5 );
	}

	return 0;
}

/**
 * Repeater field names per template.
 *
 * @return string[]
 */
function ac_tech_post_template_repeater_field_names() {
	return array(
		'pt1_bento',
		'pt1_toc',
		'pt2_sections',
		'pt2_tips',
		'pt3_sections',
	);
}

/**
 * @param string[] $items List items.
 * @return string
 */
function ac_tech_join_lines_for_acf( $items ) {
	if ( ! is_array( $items ) ) {
		return '';
	}

	return implode( "\n", array_map( 'strval', $items ) );
}

/**
 * @param array<int, array{icon: string, text: string}> $items Section items.
 * @return string
 */
function ac_tech_format_pt2_section_items_for_acf( $items ) {
	if ( ! is_array( $items ) ) {
		return '';
	}

	$lines = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$icon = ! empty( $item['icon'] ) ? sanitize_key( (string) $item['icon'] ) : 'ac_unit';
		$text = ! empty( $item['text'] ) ? (string) $item['text'] : '';
		$lines[] = $icon . '|' . $text;
	}

	return implode( "\n", $lines );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_simple_field_defaults() {
	$header = ac_tech_get_post_template_1_header_base();
	$intro  = ac_tech_get_post_template_1_intro_base();
	$detail = ac_tech_get_post_template_1_detail_base();
	$cta    = ac_tech_get_post_template_1_cta_base();
	$expert = ac_tech_get_post_template_1_sidebar_expert_base();
	$side   = ac_tech_get_post_template_1_sidebar_cta_base();

	return array(
		'pt1_badge'              => isset( $header['badge'] ) ? (string) $header['badge'] : '',
		'pt1_series'             => isset( $header['series'] ) ? (string) $header['series'] : '',
		'pt1_read_label'         => isset( $header['read_label'] ) ? (string) $header['read_label'] : '',
		'pt1_intro'              => isset( $intro['text'] ) ? (string) $intro['text'] : '',
		'pt1_detail_title'       => isset( $detail['title'] ) ? (string) $detail['title'] : '',
		'pt1_detail_text'        => isset( $detail['text'] ) ? (string) $detail['text'] : '',
		'pt1_detail_quote'       => isset( $detail['quote'] ) ? (string) $detail['quote'] : '',
		'pt1_cta_title'          => isset( $cta['title'] ) ? (string) $cta['title'] : '',
		'pt1_cta_text'           => isset( $cta['text'] ) ? (string) $cta['text'] : '',
		'pt1_cta_button'         => isset( $cta['button'] ) ? (string) $cta['button'] : '',
		'pt1_cta_url'            => isset( $cta['url'] ) ? (string) $cta['url'] : '',
		'pt1_expert_name'        => isset( $expert['name'] ) ? (string) $expert['name'] : '',
		'pt1_expert_role'        => isset( $expert['role'] ) ? (string) $expert['role'] : '',
		'pt1_expert_text'        => isset( $expert['text'] ) ? (string) $expert['text'] : '',
		'pt1_sidebar_cta_badge'  => isset( $side['badge'] ) ? (string) $side['badge'] : '',
		'pt1_sidebar_cta_title'  => isset( $side['title'] ) ? (string) $side['title'] : '',
		'pt1_sidebar_cta_text'   => isset( $side['text'] ) ? (string) $side['text'] : '',
		'pt1_sidebar_cta_button' => isset( $side['button'] ) ? (string) $side['button'] : '',
		'pt1_sidebar_cta_url'    => isset( $side['url'] ) ? (string) $side['url'] : '',
	);
}

/**
 * @param string $field_name Repeater name.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_1_repeater_defaults( $field_name ) {
	switch ( $field_name ) {
		case 'pt1_bento':
			$rows  = array();
			$cards = ac_tech_get_post_template_1_bento_cards_base();
			foreach ( $cards as $card ) {
				$row = array(
					'bento_variant'      => isset( $card['variant'] ) ? (string) $card['variant'] : 'light',
					'bento_icon'         => isset( $card['icon'] ) ? (string) $card['icon'] : '',
					'bento_title'        => isset( $card['title'] ) ? (string) $card['title'] : '',
					'bento_text'         => isset( $card['text'] ) ? (string) $card['text'] : '',
					'bento_items'        => ! empty( $card['items'] ) ? ac_tech_join_lines_for_acf( $card['items'] ) : '',
					'bento_progress'     => isset( $card['progress'] ) ? (int) $card['progress'] : '',
					'bento_progress_lbl' => isset( $card['progress_lbl'] ) ? (string) $card['progress_lbl'] : '',
				);
				$rows[] = $row;
			}
			return $rows;

		case 'pt1_toc':
			$rows = array();
			foreach ( ac_tech_get_post_template_1_sidebar_toc_base() as $item ) {
				$rows[] = array(
					'toc_label' => isset( $item['label'] ) ? (string) $item['label'] : '',
					'toc_url'   => isset( $item['url'] ) ? (string) $item['url'] : '',
				);
			}
			return $rows;

		default:
			return array();
	}
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_2_simple_field_defaults() {
	$hero    = ac_tech_get_post_template_2_hero_base();
	$intro   = ac_tech_get_post_template_2_intro_base();
	$news    = ac_tech_get_post_template_2_newsletter_base();
	$tips_h  = ac_tech_get_post_template_2_tips_header_base();
	$closing = ac_tech_get_post_template_2_closing_base();

	return array(
		'pt2_badge'                   => isset( $hero['badge'] ) ? (string) $hero['badge'] : '',
		'pt2_subtitle'                => isset( $hero['subtitle'] ) ? (string) $hero['subtitle'] : '',
		'pt2_intro_lead'              => isset( $intro['lead'] ) ? (string) $intro['lead'] : '',
		'pt2_intro_text'              => isset( $intro['text'] ) ? (string) $intro['text'] : '',
		'pt2_newsletter_title'        => isset( $news['title'] ) ? (string) $news['title'] : '',
		'pt2_newsletter_text'         => isset( $news['text'] ) ? (string) $news['text'] : '',
		'pt2_newsletter_placeholder'  => isset( $news['placeholder'] ) ? (string) $news['placeholder'] : '',
		'pt2_newsletter_button'       => isset( $news['button'] ) ? (string) $news['button'] : '',
		'pt2_tips_title'              => isset( $tips_h['title'] ) ? (string) $tips_h['title'] : '',
		'pt2_closing_title'           => isset( $closing['title'] ) ? (string) $closing['title'] : '',
		'pt2_closing_text'            => isset( $closing['text'] ) ? (string) $closing['text'] : '',
		'pt2_closing_button'          => isset( $closing['button'] ) ? (string) $closing['button'] : '',
		'pt2_closing_url'             => isset( $closing['url'] ) ? (string) $closing['url'] : '',
	);
}

/**
 * @param string $field_name Repeater name.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_2_repeater_defaults( $field_name ) {
	switch ( $field_name ) {
		case 'pt2_sections':
			$rows = array();
			foreach ( ac_tech_get_post_template_2_sections_base() as $section ) {
				$row = array(
					'section_reverse'      => ! empty( $section['reverse'] ) ? 1 : 0,
					'section_title'        => isset( $section['title'] ) ? (string) $section['title'] : '',
					'section_text'         => isset( $section['text'] ) ? (string) $section['text'] : '',
					'section_image'        => 0,
					'section_items'        => ! empty( $section['items'] ) ? ac_tech_format_pt2_section_items_for_acf( $section['items'] ) : '',
					'section_stat1_value'  => '',
					'section_stat1_label'  => '',
					'section_stat2_value'  => '',
					'section_stat2_label'  => '',
				);
				if ( ! empty( $section['stats'][0] ) ) {
					$row['section_stat1_value'] = isset( $section['stats'][0]['value'] ) ? (string) $section['stats'][0]['value'] : '';
					$row['section_stat1_label'] = isset( $section['stats'][0]['label'] ) ? (string) $section['stats'][0]['label'] : '';
				}
				if ( ! empty( $section['stats'][1] ) ) {
					$row['section_stat2_value'] = isset( $section['stats'][1]['value'] ) ? (string) $section['stats'][1]['value'] : '';
					$row['section_stat2_label'] = isset( $section['stats'][1]['label'] ) ? (string) $section['stats'][1]['label'] : '';
				}
				$rows[] = $row;
			}
			return $rows;

		case 'pt2_tips':
			$rows = array();
			foreach ( ac_tech_get_post_template_2_tips_base() as $tip ) {
				$rows[] = array(
					'tip_icon'  => isset( $tip['icon'] ) ? (string) $tip['icon'] : '',
					'tip_title' => isset( $tip['title'] ) ? (string) $tip['title'] : '',
					'tip_text'  => isset( $tip['text'] ) ? (string) $tip['text'] : '',
				);
			}
			return $rows;

		default:
			return array();
	}
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_3_simple_field_defaults() {
	$hero    = ac_tech_get_post_template_3_hero_base();
	$author  = ac_tech_get_post_template_3_author_base();
	$footer  = ac_tech_get_post_template_3_footer_blocks_base();
	$related = ac_tech_get_post_template_3_related_header_base();

	return array(
		'pt3_badge'                 => isset( $hero['badge'] ) ? (string) $hero['badge'] : '',
		'pt3_read_label'            => isset( $hero['read_label'] ) ? (string) $hero['read_label'] : '',
		'pt3_author_name'           => isset( $author['name'] ) ? (string) $author['name'] : '',
		'pt3_author_role'           => isset( $author['role'] ) ? (string) $author['role'] : '',
		'pt3_share_title'           => isset( $footer['share_title'] ) ? (string) $footer['share_title'] : '',
		'pt3_subscribe_title'       => isset( $footer['subscribe_title'] ) ? (string) $footer['subscribe_title'] : '',
		'pt3_subscribe_text'        => isset( $footer['subscribe_text'] ) ? (string) $footer['subscribe_text'] : '',
		'pt3_subscribe_placeholder' => isset( $footer['subscribe_placeholder'] ) ? (string) $footer['subscribe_placeholder'] : '',
		'pt3_subscribe_button'      => isset( $footer['subscribe_button'] ) ? (string) $footer['subscribe_button'] : '',
		'pt3_related_title'         => isset( $related['title'] ) ? (string) $related['title'] : '',
		'pt3_related_text'          => isset( $related['text'] ) ? (string) $related['text'] : '',
		'pt3_related_link'          => isset( $related['link'] ) ? (string) $related['link'] : '',
		'pt3_related_url'           => isset( $related['url'] ) ? (string) $related['url'] : '',
	);
}

/**
 * @param string $field_name Repeater name.
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_3_repeater_defaults( $field_name ) {
	if ( 'pt3_sections' !== $field_name ) {
		return array();
	}

	$rows = array();
	foreach ( ac_tech_get_post_template_3_sections_base() as $section ) {
		$type = isset( $section['type'] ) ? (string) $section['type'] : 'paragraph';
		$row  = array(
			'section_type'  => $type,
			'section_title' => isset( $section['title'] ) ? (string) $section['title'] : '',
			'section_text'  => isset( $section['text'] ) ? (string) $section['text'] : '',
			'section_quote' => isset( $section['quote'] ) ? (string) $section['quote'] : '',
			'section_cite'  => isset( $section['cite'] ) ? (string) $section['cite'] : '',
			'section_list'  => ! empty( $section['items'] ) ? ac_tech_join_lines_for_acf( $section['items'] ) : '',
		);
		$rows[] = $row;
	}

	return $rows;
}

/**
 * @param string $template     Template file.
 * @param string $field_name   ACF field name.
 * @return mixed|null Null if not managed.
 */
function ac_tech_get_post_template_acf_default( $template, $field_name ) {
	if ( in_array( $field_name, ac_tech_post_template_repeater_field_names(), true ) ) {
		switch ( $template ) {
			case 'single-post-template-1.php':
				return ac_tech_get_post_template_1_repeater_defaults( $field_name );
			case 'single-post-template-2.php':
				return ac_tech_get_post_template_2_repeater_defaults( $field_name );
			case 'single-post-template-3.php':
				return ac_tech_get_post_template_3_repeater_defaults( $field_name );
		}
		return null;
	}

	$simple = array();
	switch ( $template ) {
		case 'single-post-template-1.php':
			$simple = ac_tech_get_post_template_1_simple_field_defaults();
			break;
		case 'single-post-template-2.php':
			$simple = ac_tech_get_post_template_2_simple_field_defaults();
			break;
		case 'single-post-template-3.php':
			$simple = ac_tech_get_post_template_3_simple_field_defaults();
			break;
	}

	if ( isset( $simple[ $field_name ] ) ) {
		return $simple[ $field_name ];
	}

	return null;
}

/**
 * All simple defaults for a template (for load_field UI hints).
 *
 * @param string $template Template file.
 * @return array<string, string>
 */
function ac_tech_get_post_template_simple_defaults_for_template( $template ) {
	switch ( $template ) {
		case 'single-post-template-1.php':
			return ac_tech_get_post_template_1_simple_field_defaults();
		case 'single-post-template-2.php':
			return ac_tech_get_post_template_2_simple_field_defaults();
		case 'single-post-template-3.php':
			return ac_tech_get_post_template_3_simple_field_defaults();
		default:
			return array();
	}
}

/**
 * @param mixed $value   Stored value.
 * @param mixed $post_id Post ID.
 * @param array $field   Field config.
 * @return mixed
 */
function ac_tech_acf_load_post_template_field_value( $value, $post_id, $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $value;
	}

	$field_name = (string) $field['name'];
	if ( 0 !== strpos( $field_name, 'pt' ) ) {
		return $value;
	}

	$post_id = ac_tech_normalize_acf_post_id( $post_id );
	if ( $post_id <= 0 || 'post' !== get_post_type( $post_id ) ) {
		return $value;
	}

	$template = ac_tech_get_post_template_file_for_id( $post_id );
	if ( '' === $template ) {
		return $value;
	}

	if ( ! ac_tech_editable_value_is_empty( $value ) ) {
		return $value;
	}

	$default = ac_tech_get_post_template_acf_default( $template, $field_name );
	if ( null === $default ) {
		return $value;
	}

	return $default;
}
add_filter( 'acf/load_value', 'ac_tech_acf_load_post_template_field_value', 10, 3 );

/**
 * Placeholder hints on empty fields in field group editor.
 *
 * @param array $field Field config.
 * @return array
 */
function ac_tech_acf_load_post_template_field_ui_defaults( $field ) {
	if ( ! is_array( $field ) || empty( $field['name'] ) ) {
		return $field;
	}

	$name = (string) $field['name'];
	if ( 0 !== strpos( $name, 'pt' ) || in_array( $name, ac_tech_post_template_repeater_field_names(), true ) ) {
		return $field;
	}

	$defaults = array_merge(
		ac_tech_get_post_template_1_simple_field_defaults(),
		ac_tech_get_post_template_2_simple_field_defaults(),
		ac_tech_get_post_template_3_simple_field_defaults()
	);

	if ( isset( $defaults[ $name ] ) && '' !== (string) $defaults[ $name ] ) {
		$field['placeholder'] = wp_html_excerpt( (string) $defaults[ $name ], 120, '…' );
	}

	return $field;
}
add_filter( 'acf/load_field', 'ac_tech_acf_load_post_template_field_ui_defaults', 20 );

/**
 * Persist demo content once per post (optional DB seed — survives after first save).
 */
function ac_tech_seed_post_template_acf_fields_for_post( $post_id ) {
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
		return;
	}

	$post_id = (int) $post_id;
	if ( $post_id <= 0 || 'post' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( get_post_meta( $post_id, '_ac_tech_pt_seeded', true ) ) {
		return;
	}

	$template = ac_tech_get_post_template_file_for_id( $post_id );
	if ( '' === $template ) {
		return;
	}

	$simple = ac_tech_get_post_template_simple_defaults_for_template( $template );
	foreach ( $simple as $field_name => $field_value ) {
		if ( '' === (string) $field_value ) {
			continue;
		}
		if ( ! ac_tech_editable_value_is_empty( get_field( $field_name, $post_id ) ) ) {
			continue;
		}
		update_field( $field_name, $field_value, $post_id );
	}

	$prefix = 'pt1_';
	if ( 'single-post-template-2.php' === $template ) {
		$prefix = 'pt2_';
	} elseif ( 'single-post-template-3.php' === $template ) {
		$prefix = 'pt3_';
	}

	foreach ( ac_tech_post_template_repeater_field_names() as $repeater_name ) {
		if ( 0 !== strpos( $repeater_name, $prefix ) ) {
			continue;
		}

		if ( ! ac_tech_editable_value_is_empty( get_field( $repeater_name, $post_id ) ) ) {
			continue;
		}

		$rows = ac_tech_get_post_template_acf_default( $template, $repeater_name );
		if ( is_array( $rows ) && ! empty( $rows ) ) {
			update_field( $repeater_name, $rows, $post_id );
		}
	}

	update_post_meta( $post_id, '_ac_tech_pt_seeded', '1' );
}

/**
 * Seed when a styled template is chosen in admin.
 *
 * @param int $post_id Post ID.
 */
function ac_tech_maybe_seed_post_template_on_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	ac_tech_seed_post_template_acf_fields_for_post( $post_id );
}
add_action( 'save_post_post', 'ac_tech_maybe_seed_post_template_on_save', 30 );

/**
 * Seed existing posts that already use a template (one-time per post).
 */
function ac_tech_seed_existing_post_templates_with_demo() {
	if ( ! function_exists( 'get_posts' ) ) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 50,
			'post_status'    => array( 'publish', 'draft', 'pending', 'future' ),
			'meta_query'     => array(
				array(
					'key'     => '_wp_page_template',
					'value'   => 'single-post-template-',
					'compare' => 'LIKE',
				),
			),
		)
	);

	foreach ( $posts as $post ) {
		ac_tech_seed_post_template_acf_fields_for_post( $post->ID );
	}
}
add_action( 'acf/init', 'ac_tech_seed_existing_post_templates_with_demo', 30 );
