<?php
/**
 * Static content — post template 1 (technical analysis + sidebar).
 *
 * Titlul articolului vine din WordPress; restul textelor se editează aici.
 *
 * @package AC-Tech
 */

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_1_header_base() {
	return array(
		'badge_icon' => 'science',
		'badge'      => __( 'Analiză tehnică', 'ac-tech' ),
		'read_label' => __( 'min citire', 'ac-tech' ),
		'series'     => __( 'Seria tehnică #42', 'ac-tech' ),
		'hero_image' => array(
			'external_url'  => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCK7noUanPwb_jliLn1em6W6QfthA_sd_M-w-jfIG2AzV_bJ8Fm_wxtvPZYLCvKUAZ1bzeOvzvvVg0y70W42jFxx2gcLtCF9sGZGrcTJDpPlo9dwVGics8i60Gn7vw2WOrS2HO_7BqF0QhRRfAzWWldi5F8r5N5Yy1jqXhfi10KdDp-YsX4H5tjTQ8Xo0jraDZMVMRbEMx_WPih9ah4KhzjqFZKtd7sD3VU5n4Z-URNLgQV_VD9fESnqysEJXgU-1EpRm_sJ46eNC8v',
			'alt'           => __( 'Laborator de filtrare a aerului — echipamente moderne', 'ac-tech' ),
			'width'         => 1200,
			'height'        => 400,
			'loading'       => 'eager',
			'fetchpriority' => 'high',
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_1_header() {
	return apply_filters( 'ac_tech_post_template_1_header', ac_tech_get_post_template_1_header_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_intro_base() {
	return array(
		'text' => __( 'Pe măsură ce urbanizarea accelerează, densitatea poluanților microscopici din mediul urban a atins praguri critice. Ventilația tradițională nu mai este suficientă; cererea pentru filtrare de înaltă performanță care captează activ PM2.5, NO2 și compușii organici volatili (COV) a trecut de la un lux la o necesitate tehnică pentru sănătatea publică.', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_intro() {
	return apply_filters( 'ac_tech_post_template_1_intro', ac_tech_get_post_template_1_intro_base() );
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_1_bento_cards_base() {
	return array(
		array(
			'variant' => 'light',
			'icon'    => 'filter_alt',
			'title'   => __( 'HEPA H14 multi-etapă', 'ac-tech' ),
			'text'    => __( 'Captează 99,995% din particule până la 0,1 microni prin proces de difuziune mecanică în structuri de fibră de sticlă.', 'ac-tech' ),
			'items'   => array(
				__( 'Interceptare prin difuziune', 'ac-tech' ),
				__( 'Atracție electrostatică', 'ac-tech' ),
			),
		),
		array(
			'variant'      => 'primary',
			'icon'         => 'analytics',
			'title'        => __( 'Neutralizare moleculară', 'ac-tech' ),
			'text'         => __( 'Rețele avansate de carbon activ impregnate cu permanganat de potasiu pentru neutralizarea toxinelor gazoase urbane.', 'ac-tech' ),
			'progress'     => 88,
			'progress_lbl' => __( 'Eficiență neutralizare: 88%', 'ac-tech' ),
		),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_1_bento_cards() {
	return apply_filters( 'ac_tech_post_template_1_bento_cards', ac_tech_get_post_template_1_bento_cards_base() );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_1_detail_base() {
	return array(
		'title'    => __( 'Mecanica interceptării', 'ac-tech' ),
		'text'     => __( 'Sistemele moderne utilizează principiul mișcării browniene pentru cele mai mici particule. Spre deosebire de plase simple, membranele tehnice creează un traseu labirintic care crește probabilitatea coliziunii particulă-fibră.', 'ac-tech' ),
		'quote'    => __( '„Trecerea de la filtrarea pasivă la cea activă marchează începutul adevăratei autonomii climatice în arhitectura urbană.”', 'ac-tech' ),
		'features' => array(
			array( 'icon' => 'sensors', 'label' => __( 'Monitorizare IAQ în timp real', 'ac-tech' ) ),
			array( 'icon' => 'eco', 'label' => __( 'Design cu pierdere redusă de presiune', 'ac-tech' ) ),
			array( 'icon' => 'speed', 'label' => __( 'Sincronizare volum variabil de aer', 'ac-tech' ) ),
			array( 'icon' => 'shield', 'label' => __( 'Acoperire antimicrobiană', 'ac-tech' ) ),
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_1_detail() {
	return apply_filters( 'ac_tech_post_template_1_detail', ac_tech_get_post_template_1_detail_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_cta_base() {
	return array(
		'title'  => __( 'Descarcă whitepaper-ul tehnic', 'ac-tech' ),
		'text'   => __( 'Obține setul complet de date despre eficiența filtrării în cinci metropole majore, inclusiv protocoale de integrare HVAC.', 'ac-tech' ),
		'button' => __( 'Accesează raportul', 'ac-tech' ),
		'url'    => home_url( '/contact/' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_cta() {
	return apply_filters( 'ac_tech_post_template_1_cta', ac_tech_get_post_template_1_cta_base() );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_1_sidebar_expert_base() {
	return array(
		'name'  => __( 'Dr. Marcus Chen', 'ac-tech' ),
		'role'  => __( 'Director tehnic', 'ac-tech' ),
		'text'  => __( 'Cu peste 20 de ani în dinamica fluidelor atmosferice, Dr. Chen conduce cercetarea AC-Tech în tehnologii nanomembrană.', 'ac-tech' ),
		'image' => array(
			'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBhHGsoVD0KT-gPzx7ZN66EH-2zRuH1A5EiZzliOy43xsMNecdMCGRhxeVQ2zKBZvVSpiC4iWjPOCgTugWdz_H_eTHoPF9qsTseNJQ-PheLcoMksojxf1Fv9uBfSZNSGnSefccagEuHknZpGGNRE8IZ15T5O0yd31i3VANEKiI96cZ5pGCWXP5ZUmohF8ys3QxlLu1zww2XUXC9LPO3VgZDCQ70wm3mOBlfwmVcmAv7eX3P6_vX3r53L32gpdeG5i35nCBfaEt77pEi',
			'alt'          => __( 'Portret expert tehnic AC-Tech', 'ac-tech' ),
			'width'        => 128,
			'height'       => 128,
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_1_sidebar_expert() {
	return apply_filters( 'ac_tech_post_template_1_sidebar_expert', ac_tech_get_post_template_1_sidebar_expert_base() );
}

/**
 * @return array<int, array{label: string, url: string}>
 */
function ac_tech_get_post_template_1_sidebar_toc_base() {
	return array(
		array(
			'label' => __( 'Criza aerului urban', 'ac-tech' ),
			'url'   => '#ac-tech-post-t1-intro',
		),
		array(
			'label' => __( 'Clasificarea filtrelor (H13–U15)', 'ac-tech' ),
			'url'   => '#ac-tech-post-t1-bento',
		),
		array(
			'label' => __( 'Metode de neutralizare moleculară', 'ac-tech' ),
			'url'   => '#ac-tech-post-t1-detail',
		),
		array(
			'label' => __( 'Eficiență energetică și ciclu de viață', 'ac-tech' ),
			'url'   => '#ac-tech-post-t1-cta',
		),
	);
}

/**
 * @return array<int, array{label: string, url: string}>
 */
function ac_tech_get_post_template_1_sidebar_toc() {
	return apply_filters( 'ac_tech_post_template_1_sidebar_toc', ac_tech_get_post_template_1_sidebar_toc_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_sidebar_cta_base() {
	return array(
		'badge'  => __( 'Sisteme next-gen', 'ac-tech' ),
		'title'  => __( 'Îmbunătățește strategia de aer', 'ac-tech' ),
		'text'   => __( 'Programează o evaluare tehnică la fața locului pentru spațiul tău.', 'ac-tech' ),
		'button' => __( 'Programează inspecția', 'ac-tech' ),
		'url'    => home_url( '/contact/' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_1_sidebar_cta() {
	return apply_filters( 'ac_tech_post_template_1_sidebar_cta', ac_tech_get_post_template_1_sidebar_cta_base() );
}
