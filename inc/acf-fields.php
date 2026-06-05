<?php
/**
 * ACF JSON paths.
 *
 * @package AC-Tech
 */

/**
 * Save and load ACF field groups from theme acf-json directory.
 *
 * @param string $path Default path.
 * @return string
 */
function ac_tech_acf_json_save_point( $path ) {
	return get_template_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'ac_tech_acf_json_save_point' );

/**
 * @param array $paths Load paths.
 * @return array
 */
function ac_tech_acf_json_load_point( $paths ) {
	if ( ! is_array( $paths ) ) {
		$paths = array();
	}

	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'ac_tech_acf_json_load_point' );

/**
 * Hide retired pilot field group if it still exists in the database.
 *
 * @param array|false $field_group Field group data.
 * @return array|false
 */
function ac_tech_disable_retired_pilot_field_group( $field_group ) {
	if ( ! is_array( $field_group ) ) {
		return $field_group;
	}

	$retired = array(
		'group_home_test_section',
		'group_ac_tech_home_hero',
	);

	if ( in_array( $field_group['key'] ?? '', $retired, true ) ) {
		$field_group['active'] = false;
	}

	// Prefer PHP-registered homepage fields (flat hero slide fields, ACF Free compatible).
	if ( 'group_ac_tech_homepage' === ( $field_group['key'] ?? '' ) && ! empty( $field_group['ID'] ) ) {
		$field_group['active'] = false;
	}

	return $field_group;
}
add_filter( 'acf/load_field_group', 'ac_tech_disable_retired_pilot_field_group' );

/**
 * Hide legacy repeater if a synced copy still exists in the database.
 *
 * @param array<string, mixed>|false $field ACF field.
 * @return array<string, mixed>|false
 */
function ac_tech_hide_retired_home_hero_slides_field( $field ) {
	return false;
}
add_filter( 'acf/load_field/name=home_hero_slides', 'ac_tech_hide_retired_home_hero_slides_field', 20 );
