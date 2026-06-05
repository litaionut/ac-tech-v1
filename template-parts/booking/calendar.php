<?php
/**
 * Booking calendar, time slots, summary.
 *
 * @package AC-Tech
 */

$calendar = ac_tech_get_booking_calendar();
$summary  = ac_tech_get_booking_summary();
$success  = ac_tech_get_booking_success();
?>
<div class="ac-tech-booking-card ac-tech-booking-card--sticky">
	<h3 class="ac-tech-booking-card__title ac-tech-booking-card__title--sm"><?php echo esc_html( $calendar['title'] ); ?></h3>

	<div class="ac-tech-booking-calendar" id="ac-tech-booking-calendar" data-weekdays="<?php echo esc_attr( wp_json_encode( array_values( $calendar['weekdays'] ) ) ); ?>">
		<div class="ac-tech-booking-calendar__nav">
			<span class="ac-tech-booking-calendar__month" id="ac-tech-booking-month-label"></span>
			<div class="ac-tech-booking-calendar__nav-btns">
				<button type="button" class="ac-tech-booking-calendar__nav-btn" id="ac-tech-booking-prev" aria-label="<?php esc_attr_e( 'Luna anterioară', 'ac-tech' ); ?>">
					<?php ac_tech_icon( 'chevron_left' ); ?>
				</button>
				<button type="button" class="ac-tech-booking-calendar__nav-btn" id="ac-tech-booking-next" aria-label="<?php esc_attr_e( 'Luna următoare', 'ac-tech' ); ?>">
					<?php ac_tech_icon( 'chevron_right' ); ?>
				</button>
			</div>
		</div>
		<div class="ac-tech-booking-calendar__weekdays" id="ac-tech-booking-weekdays"></div>
		<div class="ac-tech-booking-calendar__days" id="ac-tech-booking-days" role="grid"></div>
		<input type="hidden" name="date" id="ac-tech-booking-date" form="ac-tech-booking-form" value="">
	</div>

	<div class="ac-tech-booking-slots">
		<span class="ac-tech-booking-field__label"><?php echo esc_html( $calendar['slots_label'] ); ?></span>
		<p class="ac-tech-booking-slots__hint" id="ac-tech-booking-slots-hint"></p>
		<div class="ac-tech-booking-slots__grid" id="ac-tech-booking-slots" role="group" aria-label="<?php echo esc_attr( $calendar['slots_label'] ); ?>"></div>
		<input type="hidden" name="time_slot" id="ac-tech-booking-time" form="ac-tech-booking-form" value="">
	</div>

	<div class="ac-tech-booking-summary">
		<div class="ac-tech-booking-summary__cost">
			<span><?php echo esc_html( $summary['cost_label'] ); ?></span>
			<strong><?php echo esc_html( $summary['cost_value'] ); ?></strong>
		</div>
		<button type="submit" class="ac-tech-btn ac-tech-btn--primary ac-tech-booking-summary__submit" form="ac-tech-booking-form" id="ac-tech-booking-submit">
			<span><?php echo esc_html( $summary['submit'] ); ?></span>
			<?php ac_tech_icon( 'arrow_forward', 'ac-tech-booking-summary__submit-icon' ); ?>
		</button>
		<p class="ac-tech-booking-summary__disclaimer"><?php echo esc_html( $summary['disclaimer'] ); ?></p>
	</div>
</div>

<script type="application/json" id="ac-tech-booking-i18n">
<?php
echo wp_json_encode(
	array(
		'successDetail' => $success['text_detail'],
		'months'        => array(
			__( 'Ianuarie', 'ac-tech' ),
			__( 'Februarie', 'ac-tech' ),
			__( 'Martie', 'ac-tech' ),
			__( 'Aprilie', 'ac-tech' ),
			__( 'Mai', 'ac-tech' ),
			__( 'Iunie', 'ac-tech' ),
			__( 'Iulie', 'ac-tech' ),
			__( 'August', 'ac-tech' ),
			__( 'Septembrie', 'ac-tech' ),
			__( 'Octombrie', 'ac-tech' ),
			__( 'Noiembrie', 'ac-tech' ),
			__( 'Decembrie', 'ac-tech' ),
		),
	)
);
?>
</script>
