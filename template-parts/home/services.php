<?php
/**
 * Homepage services — from home.html #servicii.
 *
 * @package AC-Tech
 */

$header   = ac_tech_get_home_services_header();
$services = ac_tech_get_home_services();
?>
<section class="ac-tech-home-section ac-tech-home-services" id="servicii" aria-labelledby="ac-tech-home-services-title">
	<div class="ac-tech-container">
		<div class="ac-tech-home-services__header">
			<div class="ac-tech-home-services__intro">
				<h2 id="ac-tech-home-services-title" class="ac-tech-home-section__title"><?php echo esc_html( $header['title'] ); ?></h2>
				<p class="ac-tech-home-section__lead"><?php echo esc_html( $header['text'] ); ?></p>
			</div>
			<a class="ac-tech-home-services__link" href="<?php echo esc_url( $header['link_url'] ); ?>">
				<?php echo esc_html( $header['link_label'] ); ?>
				<?php ac_tech_icon( 'arrow_forward' ); ?>
			</a>
		</div>

		<div class="ac-tech-home-services__grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="ac-tech-home-service-card">
					<div class="ac-tech-home-service-card__media">
						<?php
						$service_img = function_exists( 'ac_tech_render_home_media_item_image' )
							? ac_tech_render_home_media_item_image( $service, 'image', 'ac-tech-home-service-card__image' )
							: ( ! empty( $service['image'] ) ? ac_tech_responsive_image( $service['image'] ) : '' );
						if ( $service_img ) {
							echo $service_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
					</div>
					<div class="ac-tech-home-service-card__body">
						<h3 class="ac-tech-home-service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="ac-tech-home-service-card__text"><?php echo esc_html( $service['text'] ); ?></p>
						<a class="ac-tech-home-service-card__link" href="<?php echo esc_url( $service['link_url'] ); ?>">
							<?php echo esc_html( $service['link_label'] ); ?>
							<?php ac_tech_icon( 'chevron_right', 'ac-tech-home-service-card__link-icon' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
