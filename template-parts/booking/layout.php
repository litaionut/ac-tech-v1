<?php
/**
 * Booking page layout.
 *
 * @package AC-Tech
 */

$success = ac_tech_get_booking_success();
?>
<div class="ac-tech-container ac-tech-booking">
	<?php get_template_part( 'template-parts/booking/hero' ); ?>

	<section class="ac-tech-booking__grid" id="ac-tech-booking" aria-label="<?php esc_attr_e( 'Formular programare', 'ac-tech' ); ?>">
		<div class="ac-tech-booking__form-col">
			<?php get_template_part( 'template-parts/booking/form' ); ?>
		</div>
		<div class="ac-tech-booking__calendar-col">
			<?php get_template_part( 'template-parts/booking/calendar' ); ?>
		</div>
	</section>
</div>

<div class="ac-tech-booking-success" id="ac-tech-booking-success" hidden>
	<div class="ac-tech-booking-success__backdrop" data-ac-tech-booking-close></div>
	<div class="ac-tech-booking-success__dialog" role="dialog" aria-modal="true" aria-labelledby="ac-tech-booking-success-title">
		<div class="ac-tech-booking-success__icon-wrap">
			<?php ac_tech_icon( 'check_circle', 'ac-tech-booking-success__icon' ); ?>
		</div>
		<h2 id="ac-tech-booking-success-title" class="ac-tech-booking-success__title"><?php echo esc_html( $success['title'] ); ?></h2>
		<p class="ac-tech-booking-success__text" id="ac-tech-booking-success-message"><?php echo esc_html( $success['text'] ); ?></p>
		<div class="ac-tech-booking-success__actions">
			<button type="button" class="ac-tech-btn ac-tech-btn--primary ac-tech-booking-success__done" data-ac-tech-booking-close>
				<?php echo esc_html( $success['done'] ); ?>
			</button>
			<button type="button" class="ac-tech-booking-success__calendar" id="ac-tech-booking-add-calendar">
				<?php echo esc_html( $success['calendar'] ); ?>
			</button>
		</div>
	</div>
</div>
