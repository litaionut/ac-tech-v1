<?php
/**
 * ACF helper functions for theme templates.
 *
 * @package AC-Tech
 */

/**
 * Output an ACF image field (attachment ID) with SEO-friendly attributes.
 *
 * @param int|string $attachment_id Attachment post ID.
 * @param string     $size          Image size slug.
 * @param array      $attr          Extra attributes for wp_get_attachment_image().
 * @return string HTML or empty string.
 */
function ac_tech_get_acf_image( $attachment_id, $size = 'large', $attr = array() ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id <= 0 ) {
		return '';
	}

	$defaults = array(
		'loading'  => 'lazy',
		'decoding' => 'async',
	);

	$attr = array_merge( $defaults, $attr );

	$image = wp_get_attachment_image( $attachment_id, $size, false, $attr );
	return $image ? $image : '';
}

/**
 * Resolve the static front page post ID.
 *
 * @return int
 */
function ac_tech_get_front_page_id() {
	$page_id = (int) get_option( 'page_on_front' );
	if ( $page_id > 0 ) {
		return $page_id;
	}

	if ( is_front_page() && is_singular( 'page' ) ) {
		return (int) get_queried_object_id();
	}

	return 0;
}

/**
 * Normalize ACF post_id values (e.g. "page_12" → 12) for admin load_value checks.
 *
 * @param mixed $post_id ACF post ID.
 * @return int
 */
function ac_tech_acf_resolve_post_id( $post_id ) {
	if ( is_numeric( $post_id ) ) {
		return (int) $post_id;
	}

	if ( ! is_string( $post_id ) || '' === $post_id ) {
		return 0;
	}

	if ( preg_match( '/_(\d+)$/', $post_id, $matches ) ) {
		return (int) $matches[1];
	}

	return 0;
}

/**
 * Default content for the text + image pilot section.
 *
 * @return array<string, string>
 */
function ac_tech_get_front_page_field( $field_name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$front_page_id = ac_tech_get_front_page_id();
	if ( $front_page_id <= 0 ) {
		return $default;
	}

	$value = get_field( $field_name, $front_page_id );
	if ( $value === null || $value === false || $value === '' ) {
		return $default;
	}

	return $value;
}
