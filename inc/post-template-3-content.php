<?php
/**
 * Static content — post template 3 (editorial hero + article body).
 *
 * @package AC-Tech
 */

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_3_hero_base() {
	return array(
		'badge'      => __( 'Întreținere', 'ac-tech' ),
		'read_label' => __( 'min citire', 'ac-tech' ),
		'hero_image' => array(
			'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAMvbNPdfWiWnNHfMzmbEGMQY9j0YK1bqK9WRkZcBRN_sJdcN6R7QaYwmOaUWKowFbdsdTC9yqAa3vL-VqfpEHqrWAZme8RBywXN7ariMtOYXCqBZ9_GQFDR-QrHtLe1OKtOA0RHAizvADuYHPDbQjqHJQb0aUBrdj35xCmZ6c6hy99BCjbd-h_Q12YPxsoRkMbK1pIJiybxt7Fgmwprjxm9pgM8-jElL7FirWCLbUDOxrecXmkujD5oxUEfhdXoZlc7bPPt95DKttU',
			'alt'          => __( 'Living modern luminos — aer curat', 'ac-tech' ),
			'width'        => 1920,
			'height'       => 716,
			'loading'      => 'eager',
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_3_hero() {
	return apply_filters( 'ac_tech_post_template_3_hero', ac_tech_get_post_template_3_hero_base() );
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_3_author_base() {
	return array(
		'name'  => __( 'Dr. Julian Vance', 'ac-tech' ),
		'role'  => __( 'Specialist mediu', 'ac-tech' ),
		'image' => array(
			'external_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfeNpCqXR9DrLd-GJ4GkQCZ3yjAWmAeWbKngaWuLcS8wTekvKTfTpyhdEtAYQeD87KKtbWycxjSOjqAPVcJDCzF7zOjxrg5Fa7aDXVwB0fQeYJObW_IYFcQnBaeGpshYXgKnaAV8EUwm7QkHF7_0i-eReVkBi2w_q58_1ZMxSS-SAWXLCzuwhcJifD9vRkHV9gEL3PJ7AnRMhLj-8TCaBni0Y1tOlm9kpd6aT5CO_Iwqk-LGKqUNrwwY8iZStFo4AwcINwGpvDVyYh',
			'alt'          => __( 'Portret autor articol', 'ac-tech' ),
			'width'        => 96,
			'height'       => 96,
		),
	);
}

/**
 * @return array<string, mixed>
 */
function ac_tech_get_post_template_3_author() {
	return apply_filters( 'ac_tech_post_template_3_author', ac_tech_get_post_template_3_author_base() );
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_3_sections_base() {
	return array(
		array(
			'type' => 'lead',
			'text' => __( 'Când ne gândim la poluare, vedem de obicei orașe încețoșate sau coșuri industriale. EPA arată însă că aerul din interior poate fi de până la cinci ori mai poluat decât cel de afară. În mediul climatizat, aparatul de aer condiționat este plămânii clădirii — fără întreținere regulată devine un teren fertil pentru poluanți.', 'ac-tech' ),
		),
		array(
			'type'  => 'heading',
			'title' => __( 'Amenințarea invizibilă: mucegai și creștere microbiană', 'ac-tech' ),
		),
		array(
			'type' => 'paragraph',
			'text' => __( 'Aparatele elimină umiditatea din aer, creând un mediu umed în serpentine și tăvi de condens. Netratat, praful casnic combină umiditatea cu substrat pentru mucegai, mildew și bacterii. Întreținerea anuală include curățare chimică a componentelor, astfel încât aerul din ventilație să nu transporte spori microscopici.', 'ac-tech' ),
		),
		array(
			'type'  => 'quote',
			'quote' => __( '„Un filtru curat e doar începutul; sănătatea internă a sistemului dictează sănătatea casei.”', 'ac-tech' ),
			'cite'  => __( '— Standardele de service AC-Tech', 'ac-tech' ),
		),
		array(
			'type'  => 'heading',
			'title' => __( 'Eficiență și filtrare alergeni', 'ac-tech' ),
		),
		array(
			'type' => 'paragraph',
			'text' => __( 'În timp, eficiența filtrării scade pe măsură ce particulele ocolește etanșările uzate sau se acumulează în conducte greu accesibile. La o vizită profesională nu se schimbă doar filtrul — se inspectează întregul traseu al aerului.', 'ac-tech' ),
		),
		array(
			'type'  => 'list',
			'items' => array(
				__( 'Curățare completă motor ventilator și palete pentru a preveni redistribuirea prafului.', 'ac-tech' ),
				__( 'Inspecție conducte pentru scurgeri care trag aer nefiltrat din pod sau subsol.', 'ac-tech' ),
				__( 'Verificare setări umiditate pentru intervalul ideal 30–50%.', 'ac-tech' ),
			),
		),
		array(
			'type' => 'paragraph',
			'text' => __( 'Investiția într-un control anual nu previne doar o pană la mijlocul verii — este un pas fundamental în managementul proactiv al sănătății familiei tale.', 'ac-tech' ),
		),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function ac_tech_get_post_template_3_sections() {
	return apply_filters( 'ac_tech_post_template_3_sections', ac_tech_get_post_template_3_sections_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_3_footer_blocks_base() {
	return array(
		'share_title'           => __( 'Distribuie articolul', 'ac-tech' ),
		'subscribe_title'       => __( 'Abonare', 'ac-tech' ),
		'subscribe_text'        => __( 'Primește cele mai noi sfaturi despre calitatea aerului direct în inbox.', 'ac-tech' ),
		'subscribe_placeholder' => __( 'E-mailul tău', 'ac-tech' ),
		'subscribe_button'      => __( 'Mă abonez', 'ac-tech' ),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_3_footer_blocks() {
	return apply_filters( 'ac_tech_post_template_3_footer_blocks', ac_tech_get_post_template_3_footer_blocks_base() );
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_3_related_header_base() {
	return array(
		'title' => __( 'Continuă lectura', 'ac-tech' ),
		'text'  => __( 'Explorează mai multe articole despre climatizarea locuinței.', 'ac-tech' ),
		'link'  => __( 'Vezi toate articolele', 'ac-tech' ),
		'url'   => ac_tech_get_blog_url(),
	);
}

/**
 * @return array<string, string>
 */
function ac_tech_get_post_template_3_related_header() {
	return apply_filters( 'ac_tech_post_template_3_related_header', ac_tech_get_post_template_3_related_header_base() );
}
