<?php
/**
 * Booking form — personal info.
 *
 * @package AC-Tech
 */

$form = ac_tech_get_booking_form();
?>
<div class="ac-tech-booking-card">
	<h2 class="ac-tech-booking-card__title"><?php echo esc_html( $form['title'] ); ?></h2>
	<form class="ac-tech-booking-form" id="ac-tech-booking-form" novalidate>
		<div class="ac-tech-booking-form__row">
			<div class="ac-tech-booking-field">
				<label class="ac-tech-booking-field__label" for="ac-tech-booking-name"><?php echo esc_html( $form['name_label'] ); ?></label>
				<input class="ac-tech-booking-field__input" id="ac-tech-booking-name" name="name" type="text" placeholder="<?php echo esc_attr( $form['name_ph'] ); ?>" required autocomplete="name">
			</div>
			<div class="ac-tech-booking-field">
				<label class="ac-tech-booking-field__label" for="ac-tech-booking-phone"><?php echo esc_html( $form['phone_label'] ); ?></label>
				<input class="ac-tech-booking-field__input" id="ac-tech-booking-phone" name="phone" type="tel" placeholder="<?php echo esc_attr( $form['phone_ph'] ); ?>" required autocomplete="tel">
			</div>
		</div>
		<div class="ac-tech-booking-field">
			<label class="ac-tech-booking-field__label" for="ac-tech-booking-email"><?php echo esc_html( $form['email_label'] ); ?></label>
			<input class="ac-tech-booking-field__input" id="ac-tech-booking-email" name="email" type="email" placeholder="<?php echo esc_attr( $form['email_ph'] ); ?>" required autocomplete="email">
		</div>
		<div class="ac-tech-booking-field">
			<label class="ac-tech-booking-field__label" for="ac-tech-booking-address"><?php echo esc_html( $form['address_label'] ); ?></label>
			<input class="ac-tech-booking-field__input" id="ac-tech-booking-address" name="address" type="text" placeholder="<?php echo esc_attr( $form['address_ph'] ); ?>" required autocomplete="street-address">
		</div>
		<div class="ac-tech-booking-form__row">
			<div class="ac-tech-booking-field">
				<label class="ac-tech-booking-field__label" for="ac-tech-booking-service"><?php echo esc_html( $form['service_label'] ); ?></label>
				<select class="ac-tech-booking-field__input ac-tech-booking-field__select" id="ac-tech-booking-service" name="service" required>
					<option value="" disabled selected><?php echo esc_html( $form['service_ph'] ); ?></option>
					<?php foreach ( $form['services'] as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="ac-tech-booking-field">
				<span class="ac-tech-booking-field__label"><?php echo esc_html( $form['urgency_label'] ); ?></span>
				<div class="ac-tech-booking-urgency" role="group" aria-label="<?php echo esc_attr( $form['urgency_label'] ); ?>">
					<button type="button" class="ac-tech-booking-urgency__btn is-active" data-urgency="standard"><?php echo esc_html( $form['urgency_standard'] ); ?></button>
					<button type="button" class="ac-tech-booking-urgency__btn" data-urgency="urgent"><?php echo esc_html( $form['urgency_urgent'] ); ?></button>
				</div>
				<input type="hidden" name="urgency" id="ac-tech-booking-urgency" value="standard">
			</div>
		</div>
		<div class="ac-tech-booking-field">
			<label class="ac-tech-booking-field__label" for="ac-tech-booking-notes"><?php echo esc_html( $form['notes_label'] ); ?></label>
			<textarea class="ac-tech-booking-field__input ac-tech-booking-field__textarea" id="ac-tech-booking-notes" name="notes" rows="4" placeholder="<?php echo esc_attr( $form['notes_ph'] ); ?>"></textarea>
		</div>
	</form>
</div>
