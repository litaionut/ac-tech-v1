<?php
/**
 * Homepage final CTA — from home.html.
 *
 * @package AC-Tech
 */

$cta = ac_tech_get_home_cta_final();
?>
<section class="ac-tech-home-section ac-tech-home-cta-final" aria-labelledby="ac-tech-home-cta-final-title">
	<div class="ac-tech-home-cta-final__pattern" aria-hidden="true"></div>
	<div class="ac-tech-container ac-tech-home-cta-final__inner">
		<div class="ac-tech-home-cta-final__card">
			<div class="ac-tech-home-cta-final__content">
				<h2 id="ac-tech-home-cta-final-title" class="ac-tech-home-cta-final__title"><?php echo esc_html( $cta['title'] ); ?></h2>
				<p class="ac-tech-home-cta-final__text"><?php echo esc_html( $cta['text'] ); ?></p>
			</div>
			<div class="ac-tech-home-cta-final__actions">
				<a class="ac-tech-btn ac-tech-btn--primary ac-tech-home-btn ac-tech-home-cta-final__btn" href="<?php echo esc_url( $cta['btn_url'] ); ?>">
					<?php echo esc_html( $cta['btn_text'] ); ?>
					<?php ac_tech_icon( 'bolt' ); ?>
				</a>
				<?php if ( ! empty( $cta['phone'] ) ) : ?>
					<p class="ac-tech-home-cta-final__phone">
						<?php ac_tech_icon( 'phone_in_talk' ); ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $cta['phone'] ) ); ?>"><?php echo esc_html( $cta['phone'] ); ?></a>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
