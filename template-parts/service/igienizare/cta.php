<?php
/**
 * Igienizare AC final CTA section.
 *
 * @package AC-Tech
 */

$cta = ac_tech_get_service_igienizare_cta();
?>
<section class="ac-tech-svc-ig-section ac-tech-svc-ig-cta-final" aria-labelledby="ac-tech-svc-ig-cta-title">
	<div class="ac-tech-container">
		<div class="ac-tech-svc-ig-cta-final__card">
			<h2 id="ac-tech-svc-ig-cta-title" class="ac-tech-svc-ig-cta-final__title"><?php echo esc_html( $cta['title'] ); ?></h2>
			<p class="ac-tech-svc-ig-cta-final__text"><?php echo esc_html( $cta['text'] ); ?></p>
			<div class="ac-tech-svc-ig-cta-final__actions">
				<?php if ( ! empty( $cta['phone'] ) ) : ?>
					<a class="ac-tech-btn ac-tech-svc-ig-cta-final__btn ac-tech-svc-ig-cta-final__btn--light" href="<?php echo esc_url( 'tel:+' . preg_replace( '/\D+/', '', (string) $cta['phone'] ) ); ?>">
						<?php ac_tech_icon( 'phone_in_talk' ); ?>
						<?php echo esc_html( $cta['phone_label'] ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $cta['whatsapp'] ) ) : ?>
					<a class="ac-tech-btn ac-tech-btn--primary ac-tech-svc-ig-cta-final__btn" href="<?php echo esc_url( 'https://wa.me/' . $cta['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php ac_tech_icon( 'sms' ); ?>
						<?php echo esc_html( $cta['whatsapp_label'] ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php if ( function_exists( 'ac_tech_render_gbp_review_cta' ) ) : ?>
				<?php ac_tech_render_gbp_review_cta( 'ac-tech-svc-ig-cta-final__review' ); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
