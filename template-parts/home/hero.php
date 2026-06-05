<?php
/**
 * Homepage hero — carousel from home_with_carosel.html.
 *
 * @package AC-Tech
 */

$slides = ac_tech_get_home_hero_carousel();

if ( empty( $slides ) ) {
	return;
}

$slide_count = count( $slides );
?>
<section
	class="ac-tech-home-carousel"
	aria-roledescription="carousel"
	aria-label="<?php esc_attr_e( 'Oferte și promoții', 'ac-tech' ); ?>"
	data-autoplay="6000"
>
	<div class="ac-tech-container">
		<div class="ac-tech-home-carousel__layout">
		<div class="ac-tech-home-carousel__content">
			<div class="ac-tech-home-carousel__slides">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<article
						class="ac-tech-home-carousel__slide<?php echo 0 === $index ? ' is-active' : ''; ?>"
						data-slide-index="<?php echo esc_attr( (string) $index ); ?>"
						aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>"
						<?php echo 0 === $index ? ' id="ac-tech-home-hero-title"' : ''; ?>
					>
						<?php if ( ! empty( $slide['badge_text'] ) ) : ?>
							<span class="ac-tech-home-badge ac-tech-home-carousel__badge">
								<?php ac_tech_icon( (string) ( $slide['badge_icon'] ?? 'campaign' ), 'ac-tech-home-badge__icon' ); ?>
								<?php echo esc_html( (string) $slide['badge_text'] ); ?>
							</span>
						<?php endif; ?>

						<h1 class="ac-tech-home-carousel__title">
							<?php
							echo ac_tech_highlight_carousel_promo_text( (string) ( $slide['title'] ?? '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							if ( ! empty( $slide['title_accent'] ) ) :
								?>
								<br>
								<span class="ac-tech-home-carousel__title-accent"><?php echo ac_tech_highlight_carousel_promo_text( (string) $slide['title_accent'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<?php endif; ?>
						</h1>

						<?php if ( ! empty( $slide['text'] ) ) : ?>
							<p class="ac-tech-home-carousel__text"><?php echo ac_tech_highlight_carousel_promo_text( (string) $slide['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $slide['cta_label'] ) && ! empty( $slide['cta_url'] ) ) : ?>
							<div class="ac-tech-home-carousel__actions">
								<a class="ac-tech-btn ac-tech-btn--primary ac-tech-home-btn" href="<?php echo esc_url( (string) $slide['cta_url'] ); ?>">
									<?php echo esc_html( (string) $slide['cta_label'] ); ?>
									<?php ac_tech_icon( (string) ( $slide['cta_icon'] ?? 'arrow_forward' ) ); ?>
								</a>
							</div>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>

			<?php if ( $slide_count > 1 ) : ?>
				<div class="ac-tech-home-carousel__dots" role="tablist" aria-label="<?php esc_attr_e( 'Slide-uri promo', 'ac-tech' ); ?>">
					<?php for ( $i = 0; $i < $slide_count; $i++ ) : ?>
						<button
							type="button"
							class="ac-tech-home-carousel__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
							role="tab"
							aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
							aria-controls="ac-tech-home-hero-title"
							data-slide-to="<?php echo esc_attr( (string) $i ); ?>"
						>
							<span class="screen-reader-text">
								<?php
								printf(
									/* translators: %d: slide number */
									esc_html__( 'Slide %d', 'ac-tech' ),
									$i + 1
								);
								?>
							</span>
						</button>
					<?php endfor; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="ac-tech-home-carousel__media">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<div class="ac-tech-home-carousel__media-item<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( (string) $index ); ?>">
					<?php
					$image_html = function_exists( 'ac_tech_render_home_carousel_slide_image' )
						? ac_tech_render_home_carousel_slide_image( $slide, 0 === $index )
						: '';
					if ( $image_html ) {
						echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
			<?php endforeach; ?>
			<div class="ac-tech-home-carousel__media-overlay" aria-hidden="true"></div>
		</div>
		</div>
	</div>
</section>
