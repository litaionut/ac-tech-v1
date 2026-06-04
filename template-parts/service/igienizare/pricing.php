<?php
/**
 * Igienizare AC pricing section.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_service_igienizare_pricing_header();
$plans  = ac_tech_get_service_igienizare_pricing();
?>
<section class="ac-tech-svc-ig-section ac-tech-svc-ig-pricing" aria-labelledby="ac-tech-svc-ig-pricing-title">
	<div class="ac-tech-container">
		<div class="ac-tech-svc-ig-section__header ac-tech-svc-ig-section__header--center">
			<h2 id="ac-tech-svc-ig-pricing-title" class="ac-tech-svc-ig-section__title"><?php echo esc_html( $header['title'] ); ?></h2>
			<p class="ac-tech-svc-ig-section__lead"><?php echo esc_html( $header['text'] ); ?></p>
		</div>

		<div class="ac-tech-svc-ig-pricing__grid">
			<?php foreach ( $plans as $plan ) : ?>
				<article class="ac-tech-svc-ig-pricing-card<?php echo ! empty( $plan['featured'] ) ? ' ac-tech-svc-ig-pricing-card--featured' : ''; ?>">
					<?php if ( ! empty( $plan['badge'] ) ) : ?>
						<span class="ac-tech-svc-ig-pricing-card__badge"><?php echo esc_html( $plan['badge'] ); ?></span>
					<?php endif; ?>

					<div class="ac-tech-svc-ig-pricing-card__head">
						<h3 class="ac-tech-svc-ig-pricing-card__name"><?php echo esc_html( $plan['name'] ); ?></h3>
						<p class="ac-tech-svc-ig-pricing-card__desc"><?php echo esc_html( $plan['description'] ); ?></p>
						<p class="ac-tech-svc-ig-pricing-card__price">
							<span class="ac-tech-svc-ig-pricing-card__amount"><?php echo esc_html( $plan['price'] ); ?></span>
							<span class="ac-tech-svc-ig-pricing-card__currency"><?php echo esc_html( $plan['currency'] ); ?></span>
						</p>
					</div>

					<ul class="ac-tech-svc-ig-pricing-card__features">
						<?php foreach ( $plan['features'] as $feature ) : ?>
							<li class="ac-tech-svc-ig-pricing-card__feature<?php echo empty( $feature['included'] ) ? ' ac-tech-svc-ig-pricing-card__feature--excluded' : ''; ?>">
								<?php ac_tech_icon( ! empty( $feature['included'] ) ? 'check_circle' : 'cancel', 'ac-tech-svc-ig-pricing-card__feature-icon' ); ?>
								<?php echo esc_html( $feature['text'] ); ?>
							</li>
						<?php endforeach; ?>
					</ul>

					<a class="ac-tech-btn<?php echo ! empty( $plan['featured'] ) ? ' ac-tech-btn--primary' : ' ac-tech-btn--secondary ac-tech-svc-ig-pricing-card__btn-outline'; ?> ac-tech-svc-ig-pricing-card__btn" href="<?php echo esc_url( $plan['cta_url'] ); ?>">
						<?php echo esc_html( $plan['cta'] ); ?>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
