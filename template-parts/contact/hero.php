<?php
/**
 * Contact page hero.
 *
 * @package AC-Tech
 */

$hero = function_exists( 'ac_tech_get_contact_hero' )
	? ac_tech_get_contact_hero()
	: array(
		'title' => get_the_title(),
		'text'  => has_excerpt() ? get_the_excerpt() : '',
	);
?>
<header class="ac-tech-booking-hero ac-tech-contact-hero">
	<h1 class="ac-tech-booking-hero__title"><?php echo esc_html( $hero['title'] ); ?></h1>
	<?php if ( ! empty( $hero['text'] ) ) : ?>
		<p class="ac-tech-booking-hero__text"><?php echo esc_html( $hero['text'] ); ?></p>
	<?php endif; ?>
</header>
