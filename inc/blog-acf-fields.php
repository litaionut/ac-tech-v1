<?php
/**
 * ACF — Blog index (posts page).
 *
 * @package AC-Tech
 */

/**
 * Register blog page field group.
 */
function ac_tech_register_blog_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_ac_tech_blog_page',
			'title'  => __( 'Blog — Conținut pagină', 'ac-tech' ),
			'fields' => array(
				array(
					'key'   => 'field_ac_tech_blog_tab_header',
					'label' => __( 'Header', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_blog_header_badge',
					'label' => __( 'Badge', 'ac-tech' ),
					'name'  => 'blog_header_badge',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_blog_header_title',
					'label' => __( 'Titlu — rând 1', 'ac-tech' ),
					'name'  => 'blog_header_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_blog_header_accent',
					'label' => __( 'Titlu — accent', 'ac-tech' ),
					'name'  => 'blog_header_accent',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_blog_header_text',
					'label' => __( 'Text intro', 'ac-tech' ),
					'name'  => 'blog_header_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_blog_tab_filters',
					'label' => __( 'Filtre categorii', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_blog_filters',
					'label'        => __( 'Butoane filtru', 'ac-tech' ),
					'name'         => 'blog_filters',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Adaugă filtru', 'ac-tech' ),
					'instructions' => __( 'Slug-ul trebuie să corespundă unei categorii WordPress existente.', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_ac_tech_blog_filter_slug',
							'label' => __( 'Slug categorie', 'ac-tech' ),
							'name'  => 'filter_slug',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_blog_filter_label',
							'label' => __( 'Etichetă buton', 'ac-tech' ),
							'name'  => 'filter_label',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_blog_tab_newsletter',
					'label' => __( 'Newsletter', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_blog_newsletter_title',
					'label' => __( 'Titlu', 'ac-tech' ),
					'name'  => 'blog_newsletter_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_blog_newsletter_text',
					'label' => __( 'Text', 'ac-tech' ),
					'name'  => 'blog_newsletter_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_blog_newsletter_placeholder',
					'label' => __( 'Placeholder e-mail', 'ac-tech' ),
					'name'  => 'blog_newsletter_placeholder',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_blog_newsletter_button',
					'label' => __( 'Buton', 'ac-tech' ),
					'name'  => 'blog_newsletter_button',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_blog_newsletter_disclaimer',
					'label' => __( 'Notă legală', 'ac-tech' ),
					'name'  => 'blog_newsletter_disclaimer',
					'type'  => 'textarea',
					'rows'  => 2,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'posts_page',
					),
				),
			),
			'active' => true,
		)
	);
}
add_action( 'acf/init', 'ac_tech_register_blog_acf_field_group', 6 );
