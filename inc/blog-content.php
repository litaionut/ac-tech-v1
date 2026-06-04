<?php
/**
 * Blog index static content.
 *
 * @package AC-Tech
 */

/**
 * @return array<string, string>
 */
function ac_tech_get_blog_header_defaults() {
	return array(
			'badge'  => __( 'Publicația Oficială', 'ac-tech' ),
			'title'  => __( 'Ghidul tău pentru un', 'ac-tech' ),
			'accent' => __( 'climat interior', 'ac-tech' ),
			'text'   => __( 'Descoperă sfaturi de la experți, noutăți tehnologice și strategii pentru economisirea energiei, toate concepute pentru a-ți transforma casa într-o oază de confort.', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_blog_header() {
	return apply_filters( 'ac_tech_blog_header', ac_tech_get_blog_header_defaults() );
}

/**
 * Category filter items (slug => label). WP categories with matching slug are linked automatically.
 *
 * @return array<string, string>
 */
function ac_tech_get_blog_filter_categories_defaults() {
	return array(
			'intretinere-ac'        => __( 'Întreținere AC', 'ac-tech' ),
			'economie-de-energie'   => __( 'Economie de energie', 'ac-tech' ),
			'sfaturi-pentru-confort'=> __( 'Sfaturi pentru confort', 'ac-tech' ),
			'calitatea-aerului'     => __( 'Calitatea aerului', 'ac-tech' ),
			'noutati'               => __( 'Noutăți', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_blog_filter_categories() {
	return apply_filters( 'ac_tech_blog_filter_categories', ac_tech_get_blog_filter_categories_defaults() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_blog_newsletter_defaults() {
	return array(
			'title'       => __( 'Primește sfaturi direct în Inbox', 'ac-tech' ),
			'text'        => __( 'Abonează-te la newsletter-ul nostru lunar pentru a primi cele mai bune practici de întreținere și oferte exclusive pentru servicii.', 'ac-tech' ),
			'placeholder' => __( 'Adresa ta de e-mail', 'ac-tech' ),
			'button'      => __( 'Abonează-te', 'ac-tech' ),
			'disclaimer'  => __( 'Respectăm confidențialitatea datelor tale. Fără spam, oricând te poți dezabona.', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_blog_newsletter() {
	return apply_filters( 'ac_tech_blog_newsletter', ac_tech_get_blog_newsletter_defaults() );
}

/**
 * URL of the posts page (blog index).
 *
 * @return string
 */
function ac_tech_get_blog_url() {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id > 0 ) {
		return get_permalink( $posts_page_id );
	}

	return home_url( '/blog/' );
}
