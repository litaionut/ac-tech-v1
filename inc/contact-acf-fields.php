<?php
/**
 * ACF field group: Contact page.
 *
 * @package AC-Tech
 */

/**
 * Register Contact page ACF fields.
 */
function ac_tech_register_contact_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_ac_tech_contact_page',
			'title'                 => __( 'Pagina Contact — Conținut', 'ac-tech' ),
			'fields'                => array(
				array(
					'key'   => 'field_ac_tech_contact_tab_hero',
					'label' => __( 'Hero', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_contact_hero_title',
					'label'        => __( 'Titlu', 'ac-tech' ),
					'name'         => 'contact_hero_title',
					'type'         => 'text',
					'instructions' => __( 'Gol = titlul paginii din WordPress.', 'ac-tech' ),
				),
				array(
					'key'   => 'field_ac_tech_contact_hero_text',
					'label' => __( 'Subtitlu', 'ac-tech' ),
					'name'  => 'contact_hero_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_contact_tab_form',
					'label' => __( 'Formular', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_contact_form_title',
					'label' => __( 'Titlu deasupra formularului', 'ac-tech' ),
					'name'  => 'contact_form_title',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_ac_tech_contact_form_shortcode',
					'label'        => __( 'Shortcode formular', 'ac-tech' ),
					'name'         => 'contact_form_shortcode',
					'type'         => 'textarea',
					'rows'         => 2,
					'instructions' => __( 'Ex.: [contact-form-7 id="123" title="Contact"]. Dacă completezi, înlocuiește formularul din temă. Gol = formularul implicit al temei.', 'ac-tech' ),
				),
				array(
					'key'   => 'field_ac_tech_contact_tab_info',
					'label' => __( 'Date contact (sidebar)', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_contact_info_title',
					'label' => __( 'Titlu bloc', 'ac-tech' ),
					'name'  => 'contact_info_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_contact_info_email',
					'label' => __( 'Email', 'ac-tech' ),
					'name'  => 'contact_info_email',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_contact_info_phone',
					'label' => __( 'Telefon', 'ac-tech' ),
					'name'  => 'contact_info_phone',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_contact_info_schedule',
					'label' => __( 'Program', 'ac-tech' ),
					'name'  => 'contact_info_schedule',
					'type'  => 'text',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-contact.php',
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
add_action( 'acf/init', 'ac_tech_register_contact_acf_field_group', 6 );
