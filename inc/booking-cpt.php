<?php
/**
 * Booking storage (CPT).
 *
 * @package AC-Tech
 */

/**
 * Register Booking post type.
 */
function ac_tech_register_booking_cpt() {
	$labels = array(
		'name'          => __( 'Programări', 'ac-tech' ),
		'singular_name' => __( 'Programare', 'ac-tech' ),
		'menu_name'     => __( 'Programări', 'ac-tech' ),
		'add_new_item'  => __( 'Adaugă programare', 'ac-tech' ),
		'edit_item'     => __( 'Editează programarea', 'ac-tech' ),
	);

	register_post_type(
		'ac_booking',
		array(
			'labels'              => $labels,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-calendar-alt',
			'supports'            => array( 'title' ),
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'ac_tech_register_booking_cpt', 6 );

/**
 * Meta keys used by booking engine.
 */
function ac_tech_booking_meta_keys() {
	return array(
		'service_slug',
		'booking_date',
		'booking_start_time',
		'booking_end_time',
		'start_ts',
		'end_ts',
		'service_start_ts',
		'service_end_ts',
		'name',
		'phone',
		'email',
		'address',
		'urgency',
		'notes',
		'status',
	);
}

