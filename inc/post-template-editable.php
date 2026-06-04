<?php
/**
 * Single post templates — merge ACF fields into theme defaults.
 *
 * @package AC-Tech
 */

/**
 * @param string $template Required template file.
 * @return bool
 */
function ac_tech_post_editable_template_is( $template ) {
	return ac_tech_get_post_template_file() === $template;
}

/**
 * @param string $field_name ACF field.
 * @param mixed  $default    Fallback.
 * @return mixed
 */
function ac_tech_get_post_editable_field( $field_name, $default = null ) {
	if ( ! is_singular( 'post' ) || ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $field_name, get_the_ID() );
	if ( ac_tech_editable_value_is_empty( $value ) ) {
		return $default;
	}

	return $value;
}

/**
 * @param string $field ACF image field.
 * @param array  $image Image config.
 * @return array
 */
function ac_tech_merge_post_editable_image( $field, $image ) {
	$id = (int) ac_tech_get_post_editable_field( $field, 0 );
	if ( $id > 0 ) {
		$image['attachment_id'] = $id;
		$alt                  = get_post_meta( $id, '_wp_attachment_image_alt', true );
		if ( $alt ) {
			$image['alt'] = (string) $alt;
		}
	}
	return $image;
}

/**
 * @param string $raw Multiline items.
 * @return string[]
 */
function ac_tech_parse_lines_field( $raw ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	$out   = array();
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$out[] = $line;
		}
	}
	return $out;
}

/* Template 1 */
function ac_tech_filter_post_template_1_header( $header ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $header;
	}

	foreach ( array( 'pt1_badge' => 'badge', 'pt1_series' => 'series', 'pt1_read_label' => 'read_label' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$header[ $key ] = (string) $val;
		}
	}

	if ( ! empty( $header['hero_image'] ) ) {
		$header['hero_image'] = ac_tech_merge_post_editable_image( 'pt1_hero_image', $header['hero_image'] );
	}

	return $header;
}
add_filter( 'ac_tech_post_template_1_header', 'ac_tech_filter_post_template_1_header', 20 );

function ac_tech_filter_post_template_1_intro( $intro ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $intro;
	}
	$text = ac_tech_get_post_editable_field( 'pt1_intro', null );
	if ( ! ac_tech_editable_value_is_empty( $text ) ) {
		$intro['text'] = (string) $text;
	}
	return $intro;
}
add_filter( 'ac_tech_post_template_1_intro', 'ac_tech_filter_post_template_1_intro', 20 );

function ac_tech_filter_post_template_1_bento( $cards ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $cards;
	}
	$rows = ac_tech_get_post_editable_field( 'pt1_bento', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $cards;
	}
	$out = array();
	foreach ( $rows as $i => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$base = isset( $cards[ $i ] ) ? $cards[ $i ] : array( 'variant' => 'light', 'icon' => 'bolt', 'title' => '', 'text' => '', 'items' => array() );
		$card = array(
			'variant' => ! empty( $row['bento_variant'] ) ? (string) $row['bento_variant'] : ( $base['variant'] ?? 'light' ),
			'icon'    => ! empty( $row['bento_icon'] ) ? sanitize_key( (string) $row['bento_icon'] ) : ( $base['icon'] ?? 'bolt' ),
			'title'   => ! empty( $row['bento_title'] ) ? (string) $row['bento_title'] : ( $base['title'] ?? '' ),
			'text'    => ! empty( $row['bento_text'] ) ? (string) $row['bento_text'] : ( $base['text'] ?? '' ),
			'items'   => ! empty( $row['bento_items'] ) ? ac_tech_parse_lines_field( $row['bento_items'] ) : ( $base['items'] ?? array() ),
		);
		if ( ! empty( $row['bento_progress'] ) ) {
			$card['progress']     = (int) $row['bento_progress'];
			$card['progress_lbl'] = ! empty( $row['bento_progress_lbl'] ) ? (string) $row['bento_progress_lbl'] : '';
		}
		$out[] = $card;
	}
	return ! empty( $out ) ? $out : $cards;
}
add_filter( 'ac_tech_post_template_1_bento_cards', 'ac_tech_filter_post_template_1_bento', 20 );

function ac_tech_filter_post_template_1_detail( $detail ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $detail;
	}
	foreach ( array( 'pt1_detail_title' => 'title', 'pt1_detail_text' => 'text', 'pt1_detail_quote' => 'quote' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$detail[ $key ] = (string) $val;
		}
	}
	return $detail;
}
add_filter( 'ac_tech_post_template_1_detail', 'ac_tech_filter_post_template_1_detail', 20 );

function ac_tech_filter_post_template_1_cta( $cta ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $cta;
	}
	foreach ( array( 'pt1_cta_title' => 'title', 'pt1_cta_text' => 'text', 'pt1_cta_button' => 'button' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$cta[ $key ] = (string) $val;
		}
	}
	$url = ac_tech_get_post_editable_field( 'pt1_cta_url', null );
	if ( ! ac_tech_editable_value_is_empty( $url ) ) {
		$cta['url'] = esc_url_raw( (string) $url );
	}
	return $cta;
}
add_filter( 'ac_tech_post_template_1_cta', 'ac_tech_filter_post_template_1_cta', 20 );

function ac_tech_filter_post_template_1_sidebar_expert( $expert ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $expert;
	}
	foreach ( array( 'pt1_expert_name' => 'name', 'pt1_expert_role' => 'role', 'pt1_expert_text' => 'text' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$expert[ $key ] = (string) $val;
		}
	}
	if ( ! empty( $expert['image'] ) ) {
		$expert['image'] = ac_tech_merge_post_editable_image( 'pt1_expert_image', $expert['image'] );
	}
	return $expert;
}
add_filter( 'ac_tech_post_template_1_sidebar_expert', 'ac_tech_filter_post_template_1_sidebar_expert', 20 );

function ac_tech_filter_post_template_1_sidebar_toc( $toc ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $toc;
	}
	$rows = ac_tech_get_post_editable_field( 'pt1_toc', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $toc;
	}
	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || empty( $row['toc_label'] ) ) {
			continue;
		}
		$out[] = array(
			'label' => (string) $row['toc_label'],
			'url'   => ! empty( $row['toc_url'] ) ? (string) $row['toc_url'] : '#',
		);
	}
	return ! empty( $out ) ? $out : $toc;
}
add_filter( 'ac_tech_post_template_1_sidebar_toc', 'ac_tech_filter_post_template_1_sidebar_toc', 20 );

function ac_tech_filter_post_template_1_sidebar_cta( $cta ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-1.php' ) ) {
		return $cta;
	}
	foreach ( array( 'pt1_sidebar_cta_badge' => 'badge', 'pt1_sidebar_cta_title' => 'title', 'pt1_sidebar_cta_text' => 'text', 'pt1_sidebar_cta_button' => 'button' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$cta[ $key ] = (string) $val;
		}
	}
	$url = ac_tech_get_post_editable_field( 'pt1_sidebar_cta_url', null );
	if ( ! ac_tech_editable_value_is_empty( $url ) ) {
		$cta['url'] = esc_url_raw( (string) $url );
	}
	return $cta;
}
add_filter( 'ac_tech_post_template_1_sidebar_cta', 'ac_tech_filter_post_template_1_sidebar_cta', 20 );

/* Template 2 */
function ac_tech_filter_post_template_2_hero( $hero ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $hero;
	}
	foreach ( array( 'pt2_badge' => 'badge', 'pt2_subtitle' => 'subtitle' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$hero[ $key ] = (string) $val;
		}
	}
	if ( ! empty( $hero['hero_image'] ) ) {
		$hero['hero_image'] = ac_tech_merge_post_editable_image( 'pt2_hero_image', $hero['hero_image'] );
	}
	return $hero;
}
add_filter( 'ac_tech_post_template_2_hero', 'ac_tech_filter_post_template_2_hero', 20 );

function ac_tech_filter_post_template_2_intro( $intro ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $intro;
	}
	$lead = ac_tech_get_post_editable_field( 'pt2_intro_lead', null );
	$text = ac_tech_get_post_editable_field( 'pt2_intro_text', null );
	if ( ! ac_tech_editable_value_is_empty( $lead ) ) {
		$intro['lead'] = (string) $lead;
	}
	if ( ! ac_tech_editable_value_is_empty( $text ) ) {
		$intro['text'] = (string) $text;
	}
	return $intro;
}
add_filter( 'ac_tech_post_template_2_intro', 'ac_tech_filter_post_template_2_intro', 20 );

function ac_tech_filter_post_template_2_sections( $sections ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $sections;
	}
	$rows = ac_tech_get_post_editable_field( 'pt2_sections', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $sections;
	}
	$out = array();
	foreach ( $rows as $i => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$base = isset( $sections[ $i ] ) ? $sections[ $i ] : array( 'reverse' => false, 'title' => '', 'text' => '', 'items' => array(), 'image' => array() );
		$sec  = array(
			'reverse' => ! empty( $row['section_reverse'] ),
			'title'   => ! empty( $row['section_title'] ) ? (string) $row['section_title'] : ( $base['title'] ?? '' ),
			'text'    => ! empty( $row['section_text'] ) ? (string) $row['section_text'] : ( $base['text'] ?? '' ),
			'image'   => $base['image'] ?? array(),
			'items'   => array(),
		);
		if ( ! empty( $row['section_items'] ) ) {
			foreach ( ac_tech_parse_lines_field( $row['section_items'] ) as $line ) {
				$parts = array_map( 'trim', explode( '|', $line, 2 ) );
				$sec['items'][] = array(
					'icon' => isset( $parts[0] ) ? sanitize_key( $parts[0] ) : 'ac_unit',
					'text' => isset( $parts[1] ) ? $parts[1] : $line,
				);
			}
		} elseif ( ! empty( $base['items'] ) ) {
			$sec['items'] = $base['items'];
		}
		if ( ! empty( $row['section_stat1_value'] ) ) {
			$sec['stats'] = array(
				array(
					'value' => (string) $row['section_stat1_value'],
					'label' => ! empty( $row['section_stat1_label'] ) ? (string) $row['section_stat1_label'] : '',
				),
			);
			if ( ! empty( $row['section_stat2_value'] ) ) {
				$sec['stats'][] = array(
					'value' => (string) $row['section_stat2_value'],
					'label' => ! empty( $row['section_stat2_label'] ) ? (string) $row['section_stat2_label'] : '',
				);
			}
		}
		$img_id = ! empty( $row['section_image'] ) ? (int) $row['section_image'] : 0;
		if ( $img_id > 0 ) {
			$sec['image'] = array( 'attachment_id' => $img_id );
		}
		$out[] = $sec;
	}
	return ! empty( $out ) ? $out : $sections;
}
add_filter( 'ac_tech_post_template_2_sections', 'ac_tech_filter_post_template_2_sections', 20 );

function ac_tech_filter_post_template_2_newsletter( $data ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $data;
	}
	foreach ( array( 'pt2_newsletter_title' => 'title', 'pt2_newsletter_text' => 'text', 'pt2_newsletter_placeholder' => 'placeholder', 'pt2_newsletter_button' => 'button' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$data[ $key ] = (string) $val;
		}
	}
	return $data;
}
add_filter( 'ac_tech_post_template_2_newsletter', 'ac_tech_filter_post_template_2_newsletter', 20 );

function ac_tech_filter_post_template_2_tips_header( $data ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $data;
	}
	$title = ac_tech_get_post_editable_field( 'pt2_tips_title', null );
	if ( ! ac_tech_editable_value_is_empty( $title ) ) {
		$data['title'] = (string) $title;
	}
	return $data;
}
add_filter( 'ac_tech_post_template_2_tips_header', 'ac_tech_filter_post_template_2_tips_header', 20 );

function ac_tech_filter_post_template_2_tips( $tips ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $tips;
	}
	$rows = ac_tech_get_post_editable_field( 'pt2_tips', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $tips;
	}
	$out = array();
	foreach ( $rows as $i => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$base = isset( $tips[ $i ] ) ? $tips[ $i ] : array( 'icon' => 'bolt', 'title' => '', 'text' => '' );
		$out[] = array(
			'icon'  => ! empty( $row['tip_icon'] ) ? sanitize_key( (string) $row['tip_icon'] ) : ( $base['icon'] ?? 'bolt' ),
			'title' => ! empty( $row['tip_title'] ) ? (string) $row['tip_title'] : ( $base['title'] ?? '' ),
			'text'  => ! empty( $row['tip_text'] ) ? (string) $row['tip_text'] : ( $base['text'] ?? '' ),
		);
	}
	return ! empty( $out ) ? $out : $tips;
}
add_filter( 'ac_tech_post_template_2_tips', 'ac_tech_filter_post_template_2_tips', 20 );

function ac_tech_filter_post_template_2_closing( $closing ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-2.php' ) ) {
		return $closing;
	}
	foreach ( array( 'pt2_closing_title' => 'title', 'pt2_closing_text' => 'text', 'pt2_closing_button' => 'button' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$closing[ $key ] = (string) $val;
		}
	}
	$url = ac_tech_get_post_editable_field( 'pt2_closing_url', null );
	if ( ! ac_tech_editable_value_is_empty( $url ) ) {
		$closing['url'] = esc_url_raw( (string) $url );
	}
	if ( ! empty( $closing['image'] ) ) {
		$closing['image'] = ac_tech_merge_post_editable_image( 'pt2_closing_image', $closing['image'] );
	}
	return $closing;
}
add_filter( 'ac_tech_post_template_2_closing', 'ac_tech_filter_post_template_2_closing', 20 );

/* Template 3 */
function ac_tech_filter_post_template_3_hero( $hero ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-3.php' ) ) {
		return $hero;
	}
	foreach ( array( 'pt3_badge' => 'badge', 'pt3_read_label' => 'read_label' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$hero[ $key ] = (string) $val;
		}
	}
	if ( ! empty( $hero['hero_image'] ) ) {
		$hero['hero_image'] = ac_tech_merge_post_editable_image( 'pt3_hero_image', $hero['hero_image'] );
	}
	return $hero;
}
add_filter( 'ac_tech_post_template_3_hero', 'ac_tech_filter_post_template_3_hero', 20 );

function ac_tech_filter_post_template_3_author( $author ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-3.php' ) ) {
		return $author;
	}
	foreach ( array( 'pt3_author_name' => 'name', 'pt3_author_role' => 'role' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$author[ $key ] = (string) $val;
		}
	}
	if ( ! empty( $author['image'] ) ) {
		$author['image'] = ac_tech_merge_post_editable_image( 'pt3_author_image', $author['image'] );
	}
	return $author;
}
add_filter( 'ac_tech_post_template_3_author', 'ac_tech_filter_post_template_3_author', 20 );

function ac_tech_filter_post_template_3_sections( $sections ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-3.php' ) ) {
		return $sections;
	}
	$rows = ac_tech_get_post_editable_field( 'pt3_sections', null );
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $sections;
	}
	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || empty( $row['section_type'] ) ) {
			continue;
		}
		$type = (string) $row['section_type'];
		$sec  = array( 'type' => $type );
		switch ( $type ) {
			case 'lead':
			case 'paragraph':
				if ( ! empty( $row['section_text'] ) ) {
					$sec['text'] = (string) $row['section_text'];
				}
				break;
			case 'heading':
				if ( ! empty( $row['section_title'] ) ) {
					$sec['title'] = (string) $row['section_title'];
				}
				break;
			case 'quote':
				if ( ! empty( $row['section_quote'] ) ) {
					$sec['quote'] = (string) $row['section_quote'];
				}
				if ( ! empty( $row['section_cite'] ) ) {
					$sec['cite'] = (string) $row['section_cite'];
				}
				break;
			case 'list':
				if ( ! empty( $row['section_list'] ) ) {
					$sec['items'] = ac_tech_parse_lines_field( $row['section_list'] );
				}
				break;
		}
		$out[] = $sec;
	}
	return ! empty( $out ) ? $out : $sections;
}
add_filter( 'ac_tech_post_template_3_sections', 'ac_tech_filter_post_template_3_sections', 20 );

function ac_tech_filter_post_template_3_footer_blocks( $blocks ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-3.php' ) ) {
		return $blocks;
	}
	$map = array(
		'pt3_share_title'             => 'share_title',
		'pt3_subscribe_title'         => 'subscribe_title',
		'pt3_subscribe_text'          => 'subscribe_text',
		'pt3_subscribe_placeholder'   => 'subscribe_placeholder',
		'pt3_subscribe_button'        => 'subscribe_button',
	);
	foreach ( $map as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$blocks[ $key ] = (string) $val;
		}
	}
	return $blocks;
}
add_filter( 'ac_tech_post_template_3_footer_blocks', 'ac_tech_filter_post_template_3_footer_blocks', 20 );

function ac_tech_filter_post_template_3_related_header( $header ) {
	if ( ! ac_tech_post_editable_template_is( 'single-post-template-3.php' ) ) {
		return $header;
	}
	foreach ( array( 'pt3_related_title' => 'title', 'pt3_related_text' => 'text', 'pt3_related_link' => 'link' ) as $acf => $key ) {
		$val = ac_tech_get_post_editable_field( $acf, null );
		if ( ! ac_tech_editable_value_is_empty( $val ) ) {
			$header[ $key ] = (string) $val;
		}
	}
	$url = ac_tech_get_post_editable_field( 'pt3_related_url', null );
	if ( ! ac_tech_editable_value_is_empty( $url ) ) {
		$header['url'] = esc_url_raw( (string) $url );
	}
	return $header;
}
add_filter( 'ac_tech_post_template_3_related_header', 'ac_tech_filter_post_template_3_related_header', 20 );
