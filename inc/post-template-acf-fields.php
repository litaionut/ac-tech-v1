<?php
/**
 * ACF field groups — single post templates 1–3.
 *
 * @package AC-Tech
 */

/**
 * @return array<string, string>
 */
function ac_tech_post_acf_icon_choices() {
	return ac_tech_home_advantage_icon_choices();
}

/**
 * @param string $key   Field key.
 * @param string $name  Field name.
 * @param string $label Label.
 * @return array<string, mixed>
 */
function ac_tech_post_acf_image_field( $key, $name, $label ) {
	return array(
		'key'           => $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'return_format' => 'id',
		'preview_size'  => 'medium',
		'instructions'  => __( 'Gol = imagine din temă sau imagine reprezentativă a articolului.', 'ac-tech' ),
	);
}

/**
 * @param string $key   Field key.
 * @param string $name  Field name.
 * @param string $label Label.
 * @return array<string, mixed>
 */
function ac_tech_post_acf_icon_field( $key, $name, $label ) {
	return array(
		'key'     => $key,
		'label'   => $label,
		'name'    => $name,
		'type'    => 'select',
		'choices' => ac_tech_post_acf_icon_choices(),
		'ui'      => 1,
		'allow_null' => 1,
	);
}

/**
 * Template 1 — Analiză tehnică.
 */
function ac_tech_register_post_template_1_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_ac_tech_post_template_1',
			'title'    => __( 'Articol — Analiză tehnică (sidebar)', 'ac-tech' ),
			'fields'   => array(
				array(
					'key'   => 'field_ac_tech_pt1_tab_header',
					'label' => __( 'Header & intro', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt1_badge',
					'label' => __( 'Badge', 'ac-tech' ),
					'name'  => 'pt1_badge',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_series',
					'label' => __( 'Serie / etichetă', 'ac-tech' ),
					'name'  => 'pt1_series',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_read_label',
					'label' => __( 'Sufix timp citire', 'ac-tech' ),
					'name'  => 'pt1_read_label',
					'type'  => 'text',
					'instructions' => __( 'Ex.: „min citire” — numărul vine din conținutul articolului.', 'ac-tech' ),
				),
				ac_tech_post_acf_image_field( 'field_ac_tech_pt1_hero_image', 'pt1_hero_image', __( 'Imagine hero', 'ac-tech' ) ),
				array(
					'key'   => 'field_ac_tech_pt1_intro',
					'label' => __( 'Introducere', 'ac-tech' ),
					'name'  => 'pt1_intro',
					'type'  => 'textarea',
					'rows'  => 5,
				),
				array(
					'key'   => 'field_ac_tech_pt1_tab_bento',
					'label' => __( 'Carduri bento', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_pt1_bento',
					'label'        => __( 'Carduri', 'ac-tech' ),
					'name'         => 'pt1_bento',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă card', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'     => 'field_ac_tech_pt1_bento_variant',
							'label'   => __( 'Variantă', 'ac-tech' ),
							'name'    => 'bento_variant',
							'type'    => 'select',
							'choices' => array(
								'light'   => __( 'Deschis', 'ac-tech' ),
								'primary' => __( 'Accent', 'ac-tech' ),
							),
						),
						ac_tech_post_acf_icon_field( 'field_ac_tech_pt1_bento_icon', 'bento_icon', __( 'Icon', 'ac-tech' ) ),
						array(
							'key'   => 'field_ac_tech_pt1_bento_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'bento_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt1_bento_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'bento_text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
						array(
							'key'          => 'field_ac_tech_pt1_bento_items',
							'label'        => __( 'Liste (câte un rând)', 'ac-tech' ),
							'name'         => 'bento_items',
							'type'         => 'textarea',
							'rows'         => 3,
						),
						array(
							'key'   => 'field_ac_tech_pt1_bento_progress',
							'label' => __( 'Progres % (opțional)', 'ac-tech' ),
							'name'  => 'bento_progress',
							'type'  => 'number',
							'min'   => 0,
							'max'   => 100,
						),
						array(
							'key'   => 'field_ac_tech_pt1_bento_progress_lbl',
							'label' => __( 'Etichetă progres', 'ac-tech' ),
							'name'  => 'bento_progress_lbl',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_pt1_tab_detail',
					'label' => __( 'Secțiune detaliu', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt1_detail_title',
					'label' => __( 'Titlu', 'ac-tech' ),
					'name'  => 'pt1_detail_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_detail_text',
					'label' => __( 'Text', 'ac-tech' ),
					'name'  => 'pt1_detail_text',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_ac_tech_pt1_detail_quote',
					'label' => __( 'Citat', 'ac-tech' ),
					'name'  => 'pt1_detail_quote',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_ac_tech_pt1_tab_cta',
					'label' => __( 'CTA & sidebar', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt1_cta_title',
					'label' => __( 'CTA — titlu', 'ac-tech' ),
					'name'  => 'pt1_cta_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_cta_text',
					'label' => __( 'CTA — text', 'ac-tech' ),
					'name'  => 'pt1_cta_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_pt1_cta_button',
					'label' => __( 'CTA — buton', 'ac-tech' ),
					'name'  => 'pt1_cta_button',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_cta_url',
					'label' => __( 'CTA — link', 'ac-tech' ),
					'name'  => 'pt1_cta_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_ac_tech_pt1_expert_name',
					'label' => __( 'Expert — nume', 'ac-tech' ),
					'name'  => 'pt1_expert_name',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_expert_role',
					'label' => __( 'Expert — rol', 'ac-tech' ),
					'name'  => 'pt1_expert_role',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_expert_text',
					'label' => __( 'Expert — bio scurt', 'ac-tech' ),
					'name'  => 'pt1_expert_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				ac_tech_post_acf_image_field( 'field_ac_tech_pt1_expert_image', 'pt1_expert_image', __( 'Expert — foto', 'ac-tech' ) ),
				array(
					'key'          => 'field_ac_tech_pt1_toc',
					'label'        => __( 'Cuprins (sidebar)', 'ac-tech' ),
					'name'         => 'pt1_toc',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Adaugă link', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_ac_tech_pt1_toc_label',
							'label' => __( 'Etichetă', 'ac-tech' ),
							'name'  => 'toc_label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt1_toc_url',
							'label' => __( 'Ancoră / URL', 'ac-tech' ),
							'name'  => 'toc_url',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_pt1_sidebar_cta_badge',
					'label' => __( 'Sidebar CTA — badge', 'ac-tech' ),
					'name'  => 'pt1_sidebar_cta_badge',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_sidebar_cta_title',
					'label' => __( 'Sidebar CTA — titlu', 'ac-tech' ),
					'name'  => 'pt1_sidebar_cta_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_sidebar_cta_text',
					'label' => __( 'Sidebar CTA — text', 'ac-tech' ),
					'name'  => 'pt1_sidebar_cta_text',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_ac_tech_pt1_sidebar_cta_button',
					'label' => __( 'Sidebar CTA — buton', 'ac-tech' ),
					'name'  => 'pt1_sidebar_cta_button',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt1_sidebar_cta_url',
					'label' => __( 'Sidebar CTA — link', 'ac-tech' ),
					'name'  => 'pt1_sidebar_cta_url',
					'type'  => 'url',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_template',
						'operator' => '==',
						'value'    => 'single-post-template-1.php',
					),
				),
			),
			'active' => true,
		)
	);
}

/**
 * Template 2 — Storytelling wellness.
 */
function ac_tech_register_post_template_2_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_ac_tech_post_template_2',
			'title'  => __( 'Articol — Storytelling wellness', 'ac-tech' ),
			'fields' => array(
				array(
					'key'   => 'field_ac_tech_pt2_tab_hero',
					'label' => __( 'Hero & intro', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt2_badge',
					'label' => __( 'Badge', 'ac-tech' ),
					'name'  => 'pt2_badge',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt2_subtitle',
					'label' => __( 'Subtitlu', 'ac-tech' ),
					'name'  => 'pt2_subtitle',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				ac_tech_post_acf_image_field( 'field_ac_tech_pt2_hero_image', 'pt2_hero_image', __( 'Imagine hero', 'ac-tech' ) ),
				array(
					'key'   => 'field_ac_tech_pt2_intro_lead',
					'label' => __( 'Intro — lead', 'ac-tech' ),
					'name'  => 'pt2_intro_lead',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_pt2_intro_text',
					'label' => __( 'Intro — paragraf', 'ac-tech' ),
					'name'  => 'pt2_intro_text',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_ac_tech_pt2_tab_sections',
					'label' => __( 'Secțiuni', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_pt2_sections',
					'label'        => __( 'Blocuri alternante', 'ac-tech' ),
					'name'         => 'pt2_sections',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă secțiune', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_ac_tech_pt2_section_reverse',
							'label'         => __( 'Imagine la dreapta', 'ac-tech' ),
							'name'          => 'section_reverse',
							'type'          => 'true_false',
							'ui'            => 1,
							'default_value' => 0,
						),
						array(
							'key'   => 'field_ac_tech_pt2_section_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'section_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt2_section_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'section_text',
							'type'  => 'textarea',
							'rows'  => 4,
						),
						ac_tech_post_acf_image_field( 'field_ac_tech_pt2_section_image', 'section_image', __( 'Imagine', 'ac-tech' ) ),
						array(
							'key'          => 'field_ac_tech_pt2_section_items',
							'label'        => __( 'Liste icon|text', 'ac-tech' ),
							'name'         => 'section_items',
							'type'         => 'textarea',
							'rows'         => 3,
							'instructions' => __( 'Câte un rând: icon_slug|text (ex.: ac_unit|Temperatură 18°C)', 'ac-tech' ),
						),
						array(
							'key'   => 'field_ac_tech_pt2_section_stat1_value',
							'label' => __( 'Stat 1 — valoare', 'ac-tech' ),
							'name'  => 'section_stat1_value',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt2_section_stat1_label',
							'label' => __( 'Stat 1 — etichetă', 'ac-tech' ),
							'name'  => 'section_stat1_label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt2_section_stat2_value',
							'label' => __( 'Stat 2 — valoare', 'ac-tech' ),
							'name'  => 'section_stat2_value',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt2_section_stat2_label',
							'label' => __( 'Stat 2 — etichetă', 'ac-tech' ),
							'name'  => 'section_stat2_label',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_pt2_tab_extra',
					'label' => __( 'Newsletter & tips', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt2_newsletter_title',
					'label' => __( 'Newsletter — titlu', 'ac-tech' ),
					'name'  => 'pt2_newsletter_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt2_newsletter_text',
					'label' => __( 'Newsletter — text', 'ac-tech' ),
					'name'  => 'pt2_newsletter_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_ac_tech_pt2_newsletter_placeholder',
					'label' => __( 'Newsletter — placeholder', 'ac-tech' ),
					'name'  => 'pt2_newsletter_placeholder',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt2_newsletter_button',
					'label' => __( 'Newsletter — buton', 'ac-tech' ),
					'name'  => 'pt2_newsletter_button',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt2_tips_title',
					'label' => __( 'Sfaturi — titlu secțiune', 'ac-tech' ),
					'name'  => 'pt2_tips_title',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_ac_tech_pt2_tips',
					'label'        => __( 'Carduri sfaturi', 'ac-tech' ),
					'name'         => 'pt2_tips',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă sfat', 'ac-tech' ),
					'sub_fields'   => array(
						ac_tech_post_acf_icon_field( 'field_ac_tech_pt2_tip_icon', 'tip_icon', __( 'Icon', 'ac-tech' ) ),
						array(
							'key'   => 'field_ac_tech_pt2_tip_title',
							'label' => __( 'Titlu', 'ac-tech' ),
							'name'  => 'tip_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt2_tip_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'tip_text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_pt2_tab_closing',
					'label' => __( 'Încheiere', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt2_closing_title',
					'label' => __( 'Titlu', 'ac-tech' ),
					'name'  => 'pt2_closing_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt2_closing_text',
					'label' => __( 'Text', 'ac-tech' ),
					'name'  => 'pt2_closing_text',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_ac_tech_pt2_closing_button',
					'label' => __( 'Buton', 'ac-tech' ),
					'name'  => 'pt2_closing_button',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt2_closing_url',
					'label' => __( 'Link buton', 'ac-tech' ),
					'name'  => 'pt2_closing_url',
					'type'  => 'url',
				),
				ac_tech_post_acf_image_field( 'field_ac_tech_pt2_closing_image', 'pt2_closing_image', __( 'Imagine încheiere', 'ac-tech' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_template',
						'operator' => '==',
						'value'    => 'single-post-template-2.php',
					),
				),
			),
			'active' => true,
		)
	);
}

/**
 * Template 3 — Editorial.
 */
function ac_tech_register_post_template_3_acf_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_ac_tech_post_template_3',
			'title'  => __( 'Articol — Editorial + similare', 'ac-tech' ),
			'fields' => array(
				array(
					'key'   => 'field_ac_tech_pt3_tab_hero',
					'label' => __( 'Hero & autor', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt3_badge',
					'label' => __( 'Badge', 'ac-tech' ),
					'name'  => 'pt3_badge',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_read_label',
					'label' => __( 'Sufix timp citire', 'ac-tech' ),
					'name'  => 'pt3_read_label',
					'type'  => 'text',
				),
				ac_tech_post_acf_image_field( 'field_ac_tech_pt3_hero_image', 'pt3_hero_image', __( 'Imagine hero', 'ac-tech' ) ),
				array(
					'key'   => 'field_ac_tech_pt3_author_name',
					'label' => __( 'Autor — nume', 'ac-tech' ),
					'name'  => 'pt3_author_name',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_author_role',
					'label' => __( 'Autor — rol', 'ac-tech' ),
					'name'  => 'pt3_author_role',
					'type'  => 'text',
				),
				ac_tech_post_acf_image_field( 'field_ac_tech_pt3_author_image', 'pt3_author_image', __( 'Autor — foto', 'ac-tech' ) ),
				array(
					'key'   => 'field_ac_tech_pt3_tab_body',
					'label' => __( 'Conținut articol', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ac_tech_pt3_sections',
					'label'        => __( 'Blocuri conținut', 'ac-tech' ),
					'name'         => 'pt3_sections',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Adaugă bloc', 'ac-tech' ),
					'sub_fields'   => array(
						array(
							'key'     => 'field_ac_tech_pt3_section_type',
							'label'   => __( 'Tip bloc', 'ac-tech' ),
							'name'    => 'section_type',
							'type'    => 'select',
							'choices' => array(
								'lead'      => __( 'Lead (paragraf mare)', 'ac-tech' ),
								'heading'   => __( 'Subtitlu', 'ac-tech' ),
								'paragraph' => __( 'Paragraf', 'ac-tech' ),
								'quote'     => __( 'Citat', 'ac-tech' ),
								'list'      => __( 'Listă', 'ac-tech' ),
							),
						),
						array(
							'key'   => 'field_ac_tech_pt3_section_title',
							'label' => __( 'Titlu (heading)', 'ac-tech' ),
							'name'  => 'section_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_ac_tech_pt3_section_text',
							'label' => __( 'Text', 'ac-tech' ),
							'name'  => 'section_text',
							'type'  => 'textarea',
							'rows'  => 4,
						),
						array(
							'key'   => 'field_ac_tech_pt3_section_quote',
							'label' => __( 'Citat', 'ac-tech' ),
							'name'  => 'section_quote',
							'type'  => 'textarea',
							'rows'  => 2,
						),
						array(
							'key'   => 'field_ac_tech_pt3_section_cite',
							'label' => __( 'Sursă citat', 'ac-tech' ),
							'name'  => 'section_cite',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_ac_tech_pt3_section_list',
							'label'        => __( 'Listă (câte un rând)', 'ac-tech' ),
							'name'         => 'section_list',
							'type'         => 'textarea',
							'rows'         => 4,
						),
					),
				),
				array(
					'key'   => 'field_ac_tech_pt3_tab_footer',
					'label' => __( 'Footer & similare', 'ac-tech' ),
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_ac_tech_pt3_share_title',
					'label' => __( 'Distribuire — titlu', 'ac-tech' ),
					'name'  => 'pt3_share_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_subscribe_title',
					'label' => __( 'Abonare — titlu', 'ac-tech' ),
					'name'  => 'pt3_subscribe_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_subscribe_text',
					'label' => __( 'Abonare — text', 'ac-tech' ),
					'name'  => 'pt3_subscribe_text',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_ac_tech_pt3_subscribe_placeholder',
					'label' => __( 'Abonare — placeholder', 'ac-tech' ),
					'name'  => 'pt3_subscribe_placeholder',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_subscribe_button',
					'label' => __( 'Abonare — buton', 'ac-tech' ),
					'name'  => 'pt3_subscribe_button',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_related_title',
					'label' => __( 'Similare — titlu', 'ac-tech' ),
					'name'  => 'pt3_related_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_related_text',
					'label' => __( 'Similare — text', 'ac-tech' ),
					'name'  => 'pt3_related_text',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_ac_tech_pt3_related_link',
					'label' => __( 'Similare — link text', 'ac-tech' ),
					'name'  => 'pt3_related_link',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ac_tech_pt3_related_url',
					'label' => __( 'Similare — URL', 'ac-tech' ),
					'name'  => 'pt3_related_url',
					'type'  => 'url',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_template',
						'operator' => '==',
						'value'    => 'single-post-template-3.php',
					),
				),
			),
			'active' => true,
		)
	);
}

/**
 * Register all post template field groups.
 */
function ac_tech_register_post_template_acf_field_groups() {
	ac_tech_register_post_template_1_acf_field_group();
	ac_tech_register_post_template_2_acf_field_group();
	ac_tech_register_post_template_3_acf_field_group();
}
add_action( 'acf/init', 'ac_tech_register_post_template_acf_field_groups', 6 );
