<?php
/**
 * Contact form area — plugin shortcode or theme form.
 *
 * @package AC-Tech
 */

$title     = function_exists( 'ac_tech_get_contact_form_block_title' ) ? ac_tech_get_contact_form_block_title() : '';
$shortcode = function_exists( 'ac_tech_get_contact_form_shortcode' ) ? ac_tech_get_contact_form_shortcode() : '';
?>
<div class="ac-tech-booking-card ac-tech-contact-form-card<?php echo $shortcode ? ' ac-tech-contact-form-card--shortcode' : ''; ?>">
	<?php if ( $title ) : ?>
		<h2 class="ac-tech-booking-card__title"><?php echo esc_html( $title ); ?></h2>
	<?php endif; ?>

	<?php if ( $shortcode ) : ?>
		<div class="ac-tech-contact-form__plugin">
			<?php
			if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
				wpcf7_enqueue_scripts();
			}
			if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
				wpcf7_enqueue_styles();
			}
			echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output.
			?>
		</div>
	<?php else : ?>
		<?php get_template_part( 'template-parts/contact/form' ); ?>
	<?php endif; ?>
</div>
