<?php
/**
 * ACF field group: Homepage (all sections).
 *
 * @package AC-Tech
 */

/**
 * Icon choices for advantage cards.
 *
 * @return array<string, string>
 */
function ac_tech_home_advantage_icon_choices() {
	$icons = array_keys( ac_tech_get_icon_svgs() );
	$pick  = array( 'bolt', 'engineering', 'construction', 'sell', 'verified', 'shield', 'speed', 'eco' );
	$choices = array();

	foreach ( $pick as $name ) {
		if ( in_array( $name, $icons, true ) ) {
			$choices[ $name ] = $name;
		}
	}

	return $choices;
}

/**
 * Register homepage ACF fields (local).
 */
function ac_tech_register_home_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_ac_tech_homepage',
			'title'                 => __( 'Homepage — Conținut', 'ac-tech' ),
			'fields'                => array(
				array(
					'key'   => 'field_ac_tech_home_tab_hero',
					'label' => __( 'Hero', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_hero_badge_text',
					'label' => __( 'Badge', 'ac-tech' ),
					'name'  => 'hero_badge_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_hero_title',
					'label' => __( 'Titlu — rând 1', 'ac-tech' ),
					'name'  => 'hero_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_hero_title_accent',
					'label' => __( 'Titlu — rând 2 (accent)', 'ac-tech' ),
					'name'  => 'hero_title_accent',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_hero_text',
					'label' => __( 'Paragraf', 'ac-tech' ),
					'name'  => 'hero_text',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_ac_tech_hero_cta_primary',
					'label' => __( 'Buton principal — text', 'ac-tech' ),
					'name'  => 'hero_cta_primary',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_hero_cta_primary_url',
					'label' => __( 'Buton principal — link', 'ac-tech' ),
					'name'  => 'hero_cta_primary_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_ac_tech_hero_cta_secondary',
					'label' => __( 'Buton secundar — text', 'ac-tech' ),
					'name'  => 'hero_cta_secondary',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_hero_cta_secondary_url',
					'label' => __( 'Buton secundar — link', 'ac-tech' ),
					'name'  => 'hero_cta_secondary_url',
					'type'  => 'url',
				),
				array(
					'key'           => 'field_ac_tech_hero_image',
					'label'         => __( 'Imagine hero', 'ac-tech' ),
					'name'          => 'hero_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'instructions'  => __( 'Gol = imagine WebP din temă.', 'ac-tech' ),
				),
				array(
					'key'   => 'field_ac_tech_hero_card_title',
					'label' => __( 'Card imagine — titlu', 'ac-tech' ),
					'name'  => 'hero_card_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_hero_card_text',
					'label' => __( 'Card imagine — text', 'ac-tech' ),
					'name'  => 'hero_card_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_tab_adv',
					'label' => __( 'Avantaje', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_home_adv_title',
					'label' => __( 'Titlu secțiune', 'ac-tech' ),
					'name'  => 'home_adv_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_adv_text',
					'label' => __( 'Text secțiune', 'ac-tech' ),
					'name'  => 'home_adv_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'          => 'field_ac_tech_home_advantages',
					'label'        => __( 'Carduri avantaje', 'ac-tech' ),
					'name'         => 'home_advantages',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă avantaj', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'     => 'field_ac_tech_adv_icon',
							'label'   => __( 'Icon', 'ac-tech' ),
							'name'    => 'advantage_icon',
							'type'    => 'select',
							'choices' => ac_tech_home_advantage_icon_choices(),
						),
						array(
							'key'   => 'field_ac_tech_adv_item_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'advantage_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_adv_item_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'advantage_text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_home_tab_services',
					'label' => __( 'Servicii', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_home_services_title',
					'label' => __( 'Titlu secțiune', 'ac-tech' ),
					'name'  => 'home_services_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_services_text',
					'label' => __( 'Text secțiune', 'ac-tech' ),
					'name'  => 'home_services_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_home_services_link_label',
					'label' => __( 'Link secțiune — text', 'ac-tech' ),
					'name'  => 'home_services_link_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_services_link_url',
					'label' => __( 'Link secțiune — URL', 'ac-tech' ),
					'name'  => 'home_services_link_url',
					'type'  => 'url',
				),
				array(
					'key'          => 'field_ac_tech_home_services',
					'label'        => __( 'Carduri servicii', 'ac-tech' ),
					'name'         => 'home_services',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă serviciu', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_ac_tech_service_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'service_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_service_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'service_text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
						array(
							'key'           => 'field_ac_tech_service_image',
							'label'         => __( 'Imagine', 'ac-tech' ),
							'name'          => 'service_image',
							'type'          => 'image',
							'return_format' => 'id',
							'instructions'  => __( 'Gol = imagine implicită din temă pentru acest card.', 'ac-tech' ),
						),
						array(
							'key'   => 'field_ac_tech_service_link_label',
							'label' => __( 'Link card — text', 'ac-tech' ),
							'name'  => 'service_link_label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_service_link_url',
							'label' => __( 'Link card — URL', 'ac-tech' ),
							'name'  => 'service_link_url',
							'type'  => 'url',
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_home_tab_process',
					'label' => __( 'Proces', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_home_process_title',
					'label' => __( 'Titlu secțiune', 'ac-tech' ),
					'name'  => 'home_process_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_process_text',
					'label' => __( 'Text secțiune', 'ac-tech' ),
					'name'  => 'home_process_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'          => 'field_ac_tech_home_process',
					'label'        => __( 'Pași', 'ac-tech' ),
					'name'         => 'home_process',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă pas', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_ac_tech_process_step',
							'label' => __( 'Număr pas', 'ac-tech' ),
							'name'  => 'process_step',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_process_item_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'process_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_process_item_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'process_text',
							'type'  => 'textarea',
							'rows'  => 2,
						),
						array(
							'key'           => 'field_ac_tech_process_is_final',
							'label'         => __( 'Pas final (stil accent)', 'ac-tech' ),
							'name'          => 'process_is_final',
							'type'          => 'true_false',
							'ui'            => 1,
							'default_value' => 0,
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_home_tab_reviews',
					'label' => __( 'Recenzii', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_home_reviews_title',
					'label' => __( 'Titlu secțiune', 'ac-tech' ),
					'name'  => 'home_reviews_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_reviews_rating',
					'label' => __( 'Text rating (sub titlu)', 'ac-tech' ),
					'name'  => 'home_reviews_rating',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_ac_tech_home_reviews',
					'label'        => __( 'Recenzii', 'ac-tech' ),
					'name'         => 'home_reviews',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă recenzie', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_ac_tech_review_text',
							'label' => __( 'Text recenzie', 'ac-tech' ),
							'name'  => 'review_text',
							'type'  => 'textarea',
							'rows'  => 4,
						),
						array(
							'key'   => 'field_ac_tech_review_name',
							'label' => __( 'Nume', 'ac-tech' ),
							'name'  => 'review_name',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_review_role',
							'label' => __( 'Rol / funcție', 'ac-tech' ),
							'name'  => 'review_role',
							'type'  => 'text',
						),
						array(
							'key'           => 'field_ac_tech_review_avatar',
							'label'         => __( 'Avatar', 'ac-tech' ),
							'name'          => 'review_avatar',
							'type'          => 'image',
							'return_format' => 'id',
						),
						array(
							'key'           => 'field_ac_tech_review_featured',
							'label'         => __( 'Card evidențiat', 'ac-tech' ),
							'name'          => 'review_featured',
							'type'          => 'true_false',
							'ui'            => 1,
							'default_value' => 0,
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_home_tab_cta',
					'label' => __( 'CTA final', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_home_cta_title',
					'label' => __( 'Titlu', 'ac-tech' ),
					'name'  => 'home_cta_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_cta_text',
					'label' => __( 'Text', 'ac-tech' ),
					'name'  => 'home_cta_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_home_cta_btn_text',
					'label' => __( 'Buton — text', 'ac-tech' ),
					'name'  => 'home_cta_btn_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_home_cta_btn_url',
					'label' => __( 'Buton — link', 'ac-tech' ),
					'name'  => 'home_cta_btn_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_ac_tech_home_cta_phone',
					'label' => __( 'Telefon', 'ac-tech' ),
					'name'  => 'home_cta_phone',
					'type'  => 'text',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'ac_tech_register_home_acf_field_group', 6 );
