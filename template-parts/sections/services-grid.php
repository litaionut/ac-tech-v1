<?php
/**
 * Full services grid for the services page template.
 *
 * @package AC-Tech
 */

$services = ac_tech_get_default_services();

if ( empty( $services ) ) {
	return;
}
?>
<section class="ac-tech-section ac-tech-services-grid" aria-labelledby="ac-tech-services-grid-title">
	<div class="ac-tech-container">
		<h2 id="ac-tech-services-grid-title" class="screen-reader-text">
			<?php esc_html_e( 'Lista serviciilor', 'ac-tech' ); ?>
		</h2>
		<ul class="ac-tech-card-grid ac-tech-card-grid--wide">
			<?php foreach ( $services as $service ) : ?>
				<?php if ( empty( $service['title'] ) && empty( $service['description'] ) ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<li class="ac-tech-card">
					<?php if ( ! empty( $service['title'] ) ) : ?>
						<h3 class="ac-tech-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $service['description'] ) ) : ?>
						<p class="ac-tech-card__text"><?php echo esc_html( $service['description'] ); ?></p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
