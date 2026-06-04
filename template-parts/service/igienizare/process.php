<?php
/**
 * Igienizare AC process section.
 *
 * @package AC-Tech
 */

$steps   = ac_tech_get_service_igienizare_process_steps();
$gallery = ac_tech_get_service_igienizare_process_gallery();
?>
<section class="ac-tech-svc-ig-section ac-tech-svc-ig-process" aria-labelledby="ac-tech-svc-ig-process-title">
	<div class="ac-tech-container ac-tech-svc-ig-process__grid">
		<div class="ac-tech-svc-ig-process__gallery">
			<div class="ac-tech-svc-ig-process__gallery-col">
				<?php if ( ! empty( $gallery[0] ) ) : ?>
					<?php echo ac_tech_responsive_image( $gallery[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php endif; ?>
				<?php if ( ! empty( $gallery[1] ) ) : ?>
					<?php echo ac_tech_responsive_image( $gallery[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php endif; ?>
			</div>
			<div class="ac-tech-svc-ig-process__gallery-col ac-tech-svc-ig-process__gallery-col--offset">
				<?php if ( ! empty( $gallery[2] ) ) : ?>
					<?php echo ac_tech_responsive_image( $gallery[2] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php endif; ?>
				<div class="ac-tech-svc-ig-process__stat">
					<p class="ac-tech-svc-ig-process__stat-value">100%</p>
					<p class="ac-tech-svc-ig-process__stat-label"><?php esc_html_e( 'Eliminare bacterii & mucegai garantată', 'ac-tech' ); ?></p>
				</div>
			</div>
		</div>

		<div class="ac-tech-svc-ig-process__content">
			<h2 id="ac-tech-svc-ig-process-title" class="ac-tech-svc-ig-section__title"><?php esc_html_e( 'Procesul Nostru de Igienizare Pas cu Pas', 'ac-tech' ); ?></h2>
			<ol class="ac-tech-svc-ig-process__steps">
				<?php foreach ( $steps as $index => $step ) : ?>
					<li class="ac-tech-svc-ig-process__step">
						<span class="ac-tech-svc-ig-process__step-num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
						<div>
							<h3 class="ac-tech-svc-ig-process__step-title"><?php echo esc_html( $step['title'] ); ?></h3>
							<p class="ac-tech-svc-ig-process__step-text"><?php echo esc_html( $step['text'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
