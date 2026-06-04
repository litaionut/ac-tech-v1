<?php
/**
 * Homepage hero — from home.html.
 *
 * @package AC-Tech
 */

$hero = ac_tech_get_home_hero();
?>
<section class="ac-tech-home-hero" aria-labelledby="ac-tech-home-hero-title">
	<div class="ac-tech-container ac-tech-home-hero__grid">
		<div class="ac-tech-home-hero__content">
			<div class="ac-tech-home-hero__intro">
				<span class="ac-tech-home-badge">
					<?php ac_tech_icon( $hero['badge_icon'], 'ac-tech-home-badge__icon' ); ?>
					<?php echo esc_html( $hero['badge_text'] ); ?>
				</span>

				<h1 id="ac-tech-home-hero-title" class="ac-tech-home-hero__title">
					<?php echo esc_html( $hero['title'] ); ?>
					<br>
					<span class="ac-tech-home-hero__title-accent"><?php echo esc_html( $hero['title_accent'] ); ?></span>
				</h1>

				<p class="ac-tech-home-hero__text"><?php echo esc_html( $hero['text'] ); ?></p>
			</div>

			<div class="ac-tech-home-hero__actions">
				<a class="ac-tech-btn ac-tech-btn--primary ac-tech-home-btn" href="<?php echo esc_url( $hero['cta_primary_url'] ); ?>">
					<?php echo esc_html( $hero['cta_primary'] ); ?>
					<?php ac_tech_icon( $hero['cta_primary_icon'] ); ?>
				</a>
				<a class="ac-tech-btn ac-tech-btn--secondary ac-tech-home-btn ac-tech-home-btn--outline" href="<?php echo esc_url( $hero['cta_secondary_url'] ); ?>">
					<?php echo esc_html( $hero['cta_secondary'] ); ?>
				</a>
			</div>
		</div>

		<div class="ac-tech-home-hero__media">
			<div class="ac-tech-home-hero__image-wrap">
				<?php
				$hero_image_html = function_exists( 'ac_tech_render_home_hero_image' )
					? ac_tech_render_home_hero_image( $hero )
					: ( ! empty( $hero['image'] ) ? ac_tech_responsive_image( $hero['image'] ) : '' );
				if ( $hero_image_html ) {
					echo $hero_image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
				}
				?>
			</div>

			<div class="ac-tech-home-hero__card">
				<div class="ac-tech-home-hero__card-icon">
					<?php ac_tech_icon( $hero['card_icon'] ); ?>
				</div>
				<div>
					<p class="ac-tech-home-hero__card-title"><?php echo esc_html( $hero['card_title'] ); ?></p>
					<p class="ac-tech-home-hero__card-text"><?php echo esc_html( $hero['card_text'] ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>
