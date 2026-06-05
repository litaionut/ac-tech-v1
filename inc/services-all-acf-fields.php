<?php
/**
 * ACF field group: Services catalog page.
 *
 * @package AC-Tech
 */

/**
 * Register Services catalog ACF fields.
 */
function ac_tech_register_services_all_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_ac_tech_services_all_page',
			'title'  => __( 'Pagina Servicii — Conținut', 'ac-tech' ),
			'fields' => array(
				array(
					'key'   => 'field_ac_tech_services_all_tab_hero',
					'label' => __( 'Hero', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_services_all_hero_badge',
					'label' => __( 'Badge', 'ac-tech' ),
					'name'  => 'services_all_hero_badge',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_ac_tech_services_all_hero_title',
					'label'        => __( 'Titlu', 'ac-tech' ),
					'name'         => 'services_all_hero_title',
					'type'         => 'text',
					'instructions' => __( 'Gol = titlul paginii din WordPress.', 'ac-tech' ),
				),
				array(
					'key'   => 'field_ac_tech_services_all_hero_text',
					'label' => __( 'Text intro', 'ac-tech' ),
					'name'  => 'services_all_hero_text',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_ac_tech_services_all_tab_items',
					'label' => __( 'Servicii', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_services_all_items',
					'label'        => __( 'Blocuri servicii', 'ac-tech' ),
					'name'         => 'services_all_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă serviciu', 'ac-tech' ),
					'instructions' => __( 'Layout „Card”: două carduri consecutive apar pe același rând (desktop).', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_ac_tech_services_all_item_layout',
							'label'         => __( 'Layout', 'ac-tech' ),
							'name'          => 'item_layout',
							'type'          => 'select',
							'choices'       => array(
								'split'         => __( 'Split — text + imagine', 'ac-tech' ),
								'split_reverse' => __( 'Split invers — imagine + text', 'ac-tech' ),
								'card'          => __( 'Card compact', 'ac-tech' ),
								'panel'         => __( 'Panou evidențiat', 'ac-tech' ),
							),
							'default_value' => 'split',
						),
						array(
							'key'   => 'field_ac_tech_services_all_item_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'item_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_services_all_item_text',
							'label' => __( 'Descriere', 'ac-tech' ),
							'name'  => 'item_text',
							'type'  => 'textarea',
							'rows'  => 4,
						),
						array(
							'key'          => 'field_ac_tech_services_all_item_bullets',
							'label'        => __( 'Beneficii / listă', 'ac-tech' ),
							'name'         => 'item_bullets',
							'type'         => 'repeater',
							'layout'       => 'table',
							'button_label' => __( 'Adaugă element', 'ac-tech' ),
							'sub_fields'   => array(
								array(
									'key'          => 'field_ac_tech_services_all_bullet_icon',
									'label'        => __( 'Icon', 'ac-tech' ),
									'name'         => 'bullet_icon',
									'type'         => 'text',
									'instructions' => __( 'Ex.: check_circle, shield, construction', 'ac-tech' ),
								),
								array(
									'key'   => 'field_ac_tech_services_all_bullet_text',
									'label' => __( 'Text', 'ac-tech' ),
									'name'  => 'bullet_text',
									'type'  => 'text',
								),
							),
						),
						array(
							'key'          => 'field_ac_tech_services_all_item_highlights',
							'label'        => __( 'Highlight-uri (doar panou)', 'ac-tech' ),
							'name'         => 'item_highlights',
							'type'         => 'repeater',
							'layout'       => 'table',
							'button_label' => __( 'Adaugă highlight', 'ac-tech' ),
							'sub_fields'   => array(
								array(
									'key'   => 'field_ac_tech_services_all_highlight_icon',
									'label' => __( 'Icon', 'ac-tech' ),
									'name'  => 'highlight_icon',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_ac_tech_services_all_highlight_label',
									'label' => __( 'Etichetă', 'ac-tech' ),
									'name'  => 'highlight_label',
									'type'  => 'text',
								),
							),
						),
						array(
							'key'   => 'field_ac_tech_services_all_item_duration',
							'label' => __( 'Durată / etichetă meta', 'ac-tech' ),
							'name'  => 'item_duration',
							'type'  => 'text',
						),
						array(
							'key'           => 'field_ac_tech_services_all_item_duration_icon',
							'label'         => __( 'Icon durată', 'ac-tech' ),
							'name'          => 'item_duration_icon',
							'type'          => 'text',
							'default_value' => 'schedule',
						),
						array(
							'key'   => 'field_ac_tech_services_all_item_cta_label',
							'label' => __( 'Buton — text', 'ac-tech' ),
							'name'  => 'item_cta_label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_services_all_item_cta_url',
							'label' => __( 'Buton — link', 'ac-tech' ),
							'name'  => 'item_cta_url',
							'type'  => 'url',
						),
						array(
							'key'           => 'field_ac_tech_services_all_item_card_icon',
							'label'         => __( 'Icon card (doar layout Card)', 'ac-tech' ),
							'name'          => 'item_card_icon',
							'type'          => 'text',
							'default_value' => 'check_circle',
						),
						array(
							'key'           => 'field_ac_tech_services_all_item_image',
							'label'         => __( 'Imagine (split / panou)', 'ac-tech' ),
							'name'          => 'item_image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
						array(
							'key'   => 'field_ac_tech_services_all_item_image_alt',
							'label' => __( 'Alt imagine (opțional)', 'ac-tech' ),
							'name'  => 'item_image_alt',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_ac_tech_services_all_item_image_fallback',
							'label'        => __( 'Imagine implicită temă', 'ac-tech' ),
							'name'         => 'item_image_fallback_key',
							'type'         => 'select',
							'choices'      => array(
								''           => __( '— Fără —', 'ac-tech' ),
								'instalare'  => __( 'Instalare', 'ac-tech' ),
								'igienizare' => __( 'Igienizare', 'ac-tech' ),
								'freon'      => __( 'Freon / presiune', 'ac-tech' ),
								'diagnostic' => __( 'Diagnostic', 'ac-tech' ),
							),
							'instructions' => __( 'Folosit dacă nu încarci o imagine ACF.', 'ac-tech' ),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-services.php',
					),
				),
			),
			'active' => true,
		)
	);
}
add_action( 'acf/init', 'ac_tech_register_services_all_acf_field_group', 6 );
