<?php
/**
 * Static content — post template 2 (wellness storytelling).
 *
 * @package AC-Tech
 */

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_2_hero_base() {
	return array(
		'badge'      => __( 'Wellness & design', 'ac-tech' ),
		'subtitle'   => __( 'Descoperă știința invizibilă din spatele confortului real și cum atmosfera potrivită îți transformă starea de bine.', 'ac-tech' ),
		'hero_image' => array(
			'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCKfRN7W0QTtaBp1uDy4Anm_oRJzcEskd5mUU7PYzo1YcYS4yoDGJ7c6tuWj4MErIu07pt_v4UlgGsKkqwQ6kcYFaMv_dlgpE-_40-XikPNmEAFt-zjrC1O_OdQY49Taw2LupiEM5JhNvsl_2jdwrf74yY_THT3d5GfiOtY0AvfgqtBAV8-h53mlWNIUCt_rpOgTnqel8zG9XrIYDhiqNnHYv2RwHQi9YD-8bueaiCbDSucUC1c6m_cMLBKI0ptWBMCVojb8a13tw8Q',
			'alt'          => __( 'Living modern luminos — confort și climat controlat', 'ac-tech' ),
			'width'        => 1920,
			'height'       => 921,
			'loading'      => 'eager',
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_2_hero() {
	return apply_filters( 'ac_tech_post_template_2_hero', ac_tech_get_post_template_2_hero_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_2_intro_base() {
	return array(
		'lead' => __( 'Adesea ne gândim la casă ca la structură — pereți, acoperiș, ferestre. Dar esența unui sanctuar stă în invizibil: aerul pe care îl respirăm și temperatura care ne înconjoară sunt cei mai importanți factori ai vitalității zilnice.', 'ac-tech' ),
		'text' => __( 'Studiile arată că mediul termic din locuință influențează direct sănătatea cardiovasculară și calitatea somnului REM. În acest ghid explorăm cum precizia tehnică în climatizare se întâlnește cu arta unui trai conștient.', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_2_intro() {
	return apply_filters( 'ac_tech_post_template_2_intro', ac_tech_get_post_template_2_intro_base() );
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_2_sections_base() {
	return array(
		array(
			'reverse' => false,
			'title'   => __( 'Ritmul circadian al aerului', 'ac-tech' ),
			'text'    => __( 'Corpul se răcește natural înainte de somn. Un sanctuar ar trebui să reflecte acest ritm: automatizarea temperaturii după apus semnalează sistemului nervos că e timpul de recuperare.', 'ac-tech' ),
			'items'   => array(
				array( 'icon' => 'ac_unit', 'text' => __( 'Temperatură optimă de somn: 18°C', 'ac-tech' ) ),
				array( 'icon' => 'air', 'text' => __( 'Filtrare HEPA pentru recuperare fără alergeni', 'ac-tech' ) ),
			),
			'image'   => array(
				'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCjC7pu5RASW6zKYxmc8H4OSXej2rVBffH5AuewQolBmpqeSRMe1Xpunt_i7tKGTvf4FQlPjnB0IMHFTQfEfoiLL8t3qlVa-sUebyQGr8J880c1NxgGyUhFMF0SICOUI_y6ERKmR7HhOQdc8rcGBYJrmNzAcvfT13b-HEc4_INXRKY37LWtwtEne0emdAZKY0jYcQ0q97wlxRBmyoCFiOVWcNP26_HNykxb6k9cUtWAIi-FnJRZfhrNwYXFme3u76uORn0ECHxgluEL',
				'alt'          => __( 'Dormitor luminos — somn odihnitor', 'ac-tech' ),
				'width'        => 800,
				'height'       => 600,
			),
		),
		array(
			'reverse' => true,
			'title'   => __( 'Umiditatea: arhitectul tăcut', 'ac-tech' ),
			'text'    => __( 'Dincolo de temperatură, umiditatea dictează percepția căldurii și funcționarea respiratorie. Un sanctuar menține 40–60% — protejează pielea și interiorul din lemn.', 'ac-tech' ),
			'stats'   => array(
				array( 'value' => '45%', 'label' => __( 'Nivel ideal', 'ac-tech' ) ),
				array( 'value' => __( 'Pur', 'ac-tech' ), 'label' => __( 'Calitate aer', 'ac-tech' ) ),
			),
			'image'   => array(
				'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAJ7HRc8KzQtexAJ_kYFmn-g1NfqnRmCA-JnYVBPI9oFdL7fesTJ8cdyVbEa1budgwBrH0VM_jKDrZu59VG4D2r8TYxyF-XJcf8_U5sS1GLLKp_xKDwJVvJZ6HxsdKnW2lOkR1kAbEAFZyL3OmnFniVpk8hwSz8mCZy0L6abHgIQnK31pkV-QNKluWlqUYIPh1Cec8v5hL4w2Vn1FprwsyGDv_WypEU2UlWifSSQOou6kSD4cCmIn8lDiIAmV5S_0eNesDXtGBknn4D',
				'alt'          => __( 'Bucătărie minimalistă — aer curat', 'ac-tech' ),
				'width'        => 800,
				'height'       => 600,
			),
		),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_2_sections() {
	return apply_filters( 'ac_tech_post_template_2_sections', ac_tech_get_post_template_2_sections_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_2_newsletter_base() {
	return array(
		'title'       => __( 'Rămâi la curent', 'ac-tech' ),
		'text'        => __( 'Alătură-te celor peste 15.000 de proprietari care primesc săptămânal sfaturi despre locuințe performante și calitatea aerului.', 'ac-tech' ),
		'placeholder' => __( 'Adresa ta de e-mail', 'ac-tech' ),
		'button'      => __( 'Abonează-te', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_2_newsletter() {
	return apply_filters( 'ac_tech_post_template_2_newsletter', ac_tech_get_post_template_2_newsletter_base() );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_2_tips_header_base() {
	return array(
		'title' => __( 'Sfaturi de la experți pentru sanctuarul tău', 'ac-tech' ),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_2_tips_header() {
	return apply_filters( 'ac_tech_post_template_2_tips_header', ac_tech_get_post_template_2_tips_header_base() );
}

/**
 * @return array<int, array{icon: string, title: string, text: string}>
 */
function ac_tech_get_post_template_2_tips_base() {
	return array(
		array(
			'icon'  => 'thermostat',
			'title' => __( 'Control pe zone', 'ac-tech' ),
			'text'  => __( 'Personalizează temperatura pe camere: sala de sport mai rece, camera copilului mai caldă.', 'ac-tech' ),
		),
		array(
			'icon'  => 'eco',
			'title' => __( 'Sincron biophilic', 'ac-tech' ),
			'text'  => __( 'Combină sistemul de climat cu plante — ele prosperă la temperaturi stabile și oxigenează spațiul.', 'ac-tech' ),
		),
		array(
			'icon'  => 'update',
			'title' => __( 'Programe inteligente', 'ac-tech' ),
			'text'  => __( 'Nu regla manual. Programează sosirea acasă — sanctuarul e gata înainte să intri.', 'ac-tech' ),
		),
	);
}

/**
 * @return array<int, array{icon: string, title: string, text: string}>
 */
function ac_tech_get_post_template_2_tips() {
	return apply_filters( 'ac_tech_post_template_2_tips', ac_tech_get_post_template_2_tips_base() );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_2_closing_base() {
	return array(
		'title'  => __( 'Atmosfera contează.', 'ac-tech' ),
		'text'   => __( 'Calea spre o viață mai sănătoasă începe în aer. Când controlezi mediul, controlezi liniștea. AC-Tech proiectează invizibilul, ca tu să te concentrezi pe ce contează.', 'ac-tech' ),
		'button' => __( 'Începe transformarea', 'ac-tech' ),
		'url'    => home_url( '/contact/' ),
		'image'  => array(
			'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAtUgC7ZTr2ZRqidQ7LbvSXIKtu0ggCXrHFesg3Po5nj4ONXtjN7bWT1xK3KBwzxHyNRJIfF6CoMUE2b-CZhJ86yDBXigVgnXrlDaQnTslQhkzu8e7A5Lbki-eBq2VjkWzsNDPsHUBqu-VoasRMH5Rx1Axtjk8kXQkzRKZgKlCKEEL_rclaGYxmF19a1RAGnPcw0WeneoAOrI8ppXvZ16jtTm0hvShOg91m8jpvg9LuWWdrmxmE5ecaXvrely_nnbxL8757vKlkZcJu',
			'alt'          => __( 'Lobby modern — climatizare profesională', 'ac-tech' ),
			'width'        => 800,
			'height'       => 500,
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_2_closing() {
	return apply_filters( 'ac_tech_post_template_2_closing', ac_tech_get_post_template_2_closing_base() );
}
