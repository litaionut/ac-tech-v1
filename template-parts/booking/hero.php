<?php
/**
 * Booking page hero.
 *
 * @package AC-Tech
 */

$hero = ac_tech_get_booking_hero();
?>
<header class="ac-tech-booking-hero">
	<h1 class="ac-tech-booking-hero__title"><?php echo esc_html( $hero['title'] ); ?></h1>
	<p class="ac-tech-booking-hero__text"><?php echo esc_html( $hero['text'] ); ?></p>
</header>
