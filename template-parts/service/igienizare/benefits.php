<?php
/**
 * Igienizare AC benefits section.
 *
 * @package AC-Tech
 */

$header   = ac_tech_get_service_igienizare_benefits_header();
$benefits = ac_tech_get_service_igienizare_benefits();
?>
<section class="ac-tech-svc-ig-section ac-tech-svc-ig-benefits" aria-labelledby="ac-tech-svc-ig-benefits-title">
	<div class="ac-tech-container">
		<div class="ac-tech-svc-ig-section__header ac-tech-svc-ig-section__header--center">
			<h2 id="ac-tech-svc-ig-benefits-title" class="ac-tech-svc-ig-section__title"><?php echo esc_html( $header['title'] ); ?></h2>
			<p class="ac-tech-svc-ig-section__lead"><?php echo esc_html( $header['text'] ); ?></p>
		</div>

		<div class="ac-tech-svc-ig-benefits__grid">
			<?php foreach ( $benefits as $item ) : ?>
				<article class="ac-tech-svc-ig-benefit-card">
					<div class="ac-tech-svc-ig-benefit-card__icon">
						<?php ac_tech_icon( $item['icon'] ); ?>
					</div>
					<h3 class="ac-tech-svc-ig-benefit-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<p class="ac-tech-svc-ig-benefit-card__text"><?php echo esc_html( $item['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
