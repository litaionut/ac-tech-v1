<?php
/**
 * Theme Customizer — homepage hero (fallback when ACF is not used).
 *
 * @package AC-Tech
 */

/**
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function ac_tech_customize_register_home_hero( $wp_customize ) {
	$wp_customize->add_section(
		'ac_tech_home_hero',
		array(
			'title'       => __( 'Homepage — Hero', 'ac-tech' ),
			'description' => __( 'Hero-ul homepage folosește acum un carousel editabil din pagina Acasă (ACF → Slide-uri promo). Secțiunea de mai jos rămâne doar ca fallback vechi.', 'ac-tech' ),
			'priority'    => 32,
		)
	);

	$text_fields = array(
		'hero_badge_text'        => __( 'Badge', 'ac-tech' ),
		'hero_title'             => __( 'Titlu — rând 1', 'ac-tech' ),
		'hero_title_accent'      => __( 'Titlu — rând 2 (accent)', 'ac-tech' ),
		'hero_text'              => __( 'Paragraf', 'ac-tech' ),
		'hero_cta_primary'       => __( 'Buton principal — text', 'ac-tech' ),
		'hero_cta_primary_url'   => __( 'Buton principal — link', 'ac-tech' ),
		'hero_cta_secondary'     => __( 'Buton secundar — text', 'ac-tech' ),
		'hero_cta_secondary_url' => __( 'Buton secundar — link', 'ac-tech' ),
		'hero_card_title'        => __( 'Card imagine — titlu', 'ac-tech' ),
		'hero_card_text'         => __( 'Card imagine — text', 'ac-tech' ),
	);

	$hero_defaults = function_exists( 'ac_tech_get_home_hero_editable_defaults' )
		? ac_tech_get_home_hero_editable_defaults()
		: array();

	foreach ( $text_fields as $id => $label ) {
		$default = isset( $hero_defaults[ $id ] ) ? $hero_defaults[ $id ] : '';

		$wp_customize->add_setting(
			'ac_tech_' . $id,
			array(
				'default'           => $default,
				'sanitize_callback' => ( false !== strpos( $id, '_url' ) ) ? 'esc_url_raw' : 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'ac_tech_' . $id,
			array(
				'label'   => $label,
				'section' => 'ac_tech_home_hero',
				'type'    => 'hero_text' === $id ? 'textarea' : 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'ac_tech_hero_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'ac_tech_hero_image',
			array(
				'label'     => __( 'Imagine hero', 'ac-tech' ),
				'section'   => 'ac_tech_home_hero',
				'mime_type' => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'ac_tech_customize_register_home_hero', 20 );
