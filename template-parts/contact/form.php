<?php
/**
 * Theme contact form fields (wrapper in form-area.php).
 *
 * @package AC-Tech
 */

$form = ac_tech_get_contact_form();
?>
<form class="ac-tech-booking-form" id="ac-tech-contact-form" novalidate>
	<div class="ac-tech-booking-form__row">
		<div class="ac-tech-booking-field">
			<label class="ac-tech-booking-field__label" for="ac-tech-contact-name"><?php echo esc_html( $form['name_label'] ); ?></label>
			<input class="ac-tech-booking-field__input" id="ac-tech-contact-name" name="name" type="text" placeholder="<?php echo esc_attr( $form['name_ph'] ); ?>" required autocomplete="name">
		</div>
		<div class="ac-tech-booking-field">
			<label class="ac-tech-booking-field__label" for="ac-tech-contact-phone"><?php echo esc_html( $form['phone_label'] ); ?></label>
			<input class="ac-tech-booking-field__input" id="ac-tech-contact-phone" name="phone" type="tel" placeholder="<?php echo esc_attr( $form['phone_ph'] ); ?>" required autocomplete="tel">
		</div>
	</div>
	<div class="ac-tech-booking-field">
		<label class="ac-tech-booking-field__label" for="ac-tech-contact-email"><?php echo esc_html( $form['email_label'] ); ?></label>
		<input class="ac-tech-booking-field__input" id="ac-tech-contact-email" name="email" type="email" placeholder="<?php echo esc_attr( $form['email_ph'] ); ?>" required autocomplete="email">
	</div>
	<div class="ac-tech-booking-field">
		<label class="ac-tech-booking-field__label" for="ac-tech-contact-subject"><?php echo esc_html( $form['subject_label'] ); ?></label>
		<select class="ac-tech-booking-field__input ac-tech-booking-field__select" id="ac-tech-contact-subject" name="subject" required>
			<option value="" disabled selected><?php echo esc_html( $form['subject_ph'] ); ?></option>
			<?php foreach ( $form['subjects'] as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="ac-tech-booking-field">
		<label class="ac-tech-booking-field__label" for="ac-tech-contact-message"><?php echo esc_html( $form['message_label'] ); ?></label>
		<textarea class="ac-tech-booking-field__input ac-tech-booking-field__textarea" id="ac-tech-contact-message" name="message" rows="5" placeholder="<?php echo esc_attr( $form['message_ph'] ); ?>" required></textarea>
	</div>
	<div class="ac-tech-contact-form__actions">
		<button type="submit" class="ac-tech-btn ac-tech-btn--primary ac-tech-booking-summary__submit" id="ac-tech-contact-submit">
			<span><?php echo esc_html( $form['submit'] ); ?></span>
			<?php ac_tech_icon( 'arrow_forward', 'ac-tech-booking-summary__submit-icon' ); ?>
		</button>
		<?php if ( ! empty( $form['disclaimer'] ) ) : ?>
			<p class="ac-tech-booking-summary__disclaimer"><?php echo esc_html( $form['disclaimer'] ); ?></p>
		<?php endif; ?>
	</div>
</form>
