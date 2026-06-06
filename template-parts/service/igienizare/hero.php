<?php
/**
 * Igienizare AC hero section.
 *
 * @package AC-Tech
 */

$hero = ac_tech_get_service_igienizare_hero();
?>
<section class="ac-tech-svc-ig-hero" aria-labelledby="ac-tech-svc-ig-hero-title">
	<div class="ac-tech-container ac-tech-svc-ig-hero__grid">
		<div class="ac-tech-svc-ig-hero__content">
			<span class="ac-tech-home-badge ac-tech-svc-ig-hero__badge">
				<?php ac_tech_icon( $hero['badge_icon'], 'ac-tech-home-badge__icon' ); ?>
				<?php echo esc_html( $hero['badge_text'] ); ?>
			</span>

			<h1 id="ac-tech-svc-ig-hero-title" class="ac-tech-svc-ig-hero__title">
				<?php echo esc_html( $hero['title'] ); ?>
				<span class="ac-tech-svc-ig-hero__title-accent"><?php echo esc_html( $hero['title_accent'] ); ?></span>
			</h1>

			<p class="ac-tech-svc-ig-hero__text"><?php echo esc_html( $hero['text'] ); ?></p>

			<div class="ac-tech-svc-ig-hero__actions">
				<?php if ( ! empty( $hero['phone'] ) ) : ?>
					<a class="ac-tech-btn ac-tech-btn--primary ac-tech-svc-ig-hero__btn" href="<?php echo esc_url( 'tel:+' . preg_replace( '/\D+/', '', (string) $hero['phone'] ) ); ?>">
						<?php ac_tech_icon( 'call' ); ?>
						<?php echo esc_html( $hero['phone_label'] ); ?>
					</a>
				<?php elseif ( function_exists( 'ac_tech_get_booking_url' ) ) : ?>
					<a class="ac-tech-btn ac-tech-btn--primary ac-tech-svc-ig-hero__btn" href="<?php echo esc_url( ac_tech_get_booking_url() ); ?>">
						<?php esc_html_e( 'Programează online', 'ac-tech' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $hero['whatsapp'] ) ) : ?>
					<a class="ac-tech-btn ac-tech-btn--secondary ac-tech-svc-ig-hero__btn ac-tech-svc-ig-hero__btn--outline" href="<?php echo esc_url( 'https://wa.me/' . $hero['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php ac_tech_icon( 'chat_bubble' ); ?>
						<?php echo esc_html( $hero['whatsapp_label'] ); ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="ac-tech-svc-ig-hero__trust">
				<?php foreach ( $hero['trust'] as $item ) : ?>
					<div class="ac-tech-svc-ig-hero__trust-item">
						<?php ac_tech_icon( $item['icon'], 'ac-tech-svc-ig-hero__trust-icon' ); ?>
						<div>
							<p class="ac-tech-svc-ig-hero__trust-title"><?php echo esc_html( $item['title'] ); ?></p>
							<p class="ac-tech-svc-ig-hero__trust-text"><?php echo esc_html( $item['text'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="ac-tech-svc-ig-hero__media">
			<div class="ac-tech-svc-ig-hero__image-wrap">
				<?php
				if ( ! empty( $hero['image'] ) ) {
					echo ac_tech_responsive_image( $hero['image'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
			<blockquote class="ac-tech-svc-ig-hero__review">
				<div class="ac-tech-svc-ig-hero__stars" aria-hidden="true">
					<?php for ( $i = 0; $i < 5; $i++ ) : ?>
						<?php ac_tech_icon( 'star', 'ac-tech-svc-ig-hero__star' ); ?>
					<?php endfor; ?>
				</div>
				<p class="ac-tech-svc-ig-hero__review-quote"><?php echo esc_html( $hero['review']['quote'] ); ?></p>
				<cite class="ac-tech-svc-ig-hero__review-author"><?php echo esc_html( $hero['review']['author'] ); ?></cite>
			</blockquote>
		</div>
	</div>
</section>
