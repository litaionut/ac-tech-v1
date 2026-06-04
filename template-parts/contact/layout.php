<?php
/**
 * Contact page layout.
 *
 * @package AC-Tech
 */

$success = ac_tech_get_contact_success();
?>
<div class="ac-tech-container ac-tech-contact">
	<?php get_template_part( 'template-parts/contact/hero' ); ?>

	<section class="ac-tech-contact__grid" aria-label="<?php esc_attr_e( 'Formular contact', 'ac-tech' ); ?>">
		<div class="ac-tech-contact__form-col">
			<?php get_template_part( 'template-parts/contact/form-area' ); ?>
		</div>
		<div class="ac-tech-contact__aside-col">
			<?php get_template_part( 'template-parts/sections/contact-info' ); ?>
		</div>
	</section>
</div>

<?php if ( function_exists( 'ac_tech_contact_uses_theme_form' ) && ac_tech_contact_uses_theme_form() ) : ?>
<div class="ac-tech-booking-success ac-tech-contact-success" id="ac-tech-contact-success" hidden>
	<div class="ac-tech-booking-success__backdrop" data-ac-tech-contact-close></div>
	<div class="ac-tech-booking-success__dialog" role="dialog" aria-modal="true" aria-labelledby="ac-tech-contact-success-title">
		<div class="ac-tech-booking-success__icon-wrap">
			<?php ac_tech_icon( 'check_circle', 'ac-tech-booking-success__icon' ); ?>
		</div>
		<h2 id="ac-tech-contact-success-title" class="ac-tech-booking-success__title"><?php echo esc_html( $success['title'] ); ?></h2>
		<p class="ac-tech-booking-success__text"><?php echo esc_html( $success['text'] ); ?></p>
		<div class="ac-tech-booking-success__actions">
			<button type="button" class="ac-tech-btn ac-tech-btn--primary ac-tech-booking-success__done" data-ac-tech-contact-close>
				<?php echo esc_html( $success['done'] ); ?>
			</button>
		</div>
	</div>
</div>
<?php endif; ?>
