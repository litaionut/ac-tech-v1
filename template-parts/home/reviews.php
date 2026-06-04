<?php
/**
 * Homepage reviews — from home.html #recenzii.
 *
 * @package AC-Tech
 */

$header  = ac_tech_get_home_reviews_header();
$reviews = ac_tech_get_home_reviews();
?>
<section class="ac-tech-home-section ac-tech-home-reviews" id="recenzii" aria-labelledby="ac-tech-home-reviews-title">
	<div class="ac-tech-container">
		<div class="ac-tech-home-section__header ac-tech-home-section__header--center">
			<h2 id="ac-tech-home-reviews-title" class="ac-tech-home-section__title"><?php echo esc_html( $header['title'] ); ?></h2>
			<div class="ac-tech-home-reviews__rating" aria-label="<?php echo esc_attr( $header['rating'] ); ?>">
				<?php for ( $i = 0; $i < 5; $i++ ) : ?>
					<?php ac_tech_icon( 'star', 'ac-tech-home-reviews__star' ); ?>
				<?php endfor; ?>
				<span class="ac-tech-home-reviews__score"><?php echo esc_html( $header['rating'] ); ?></span>
			</div>
		</div>

		<div class="ac-tech-home-reviews__grid">
			<?php foreach ( $reviews as $review ) : ?>
				<article class="ac-tech-home-review-card<?php echo ! empty( $review['featured'] ) ? ' ac-tech-home-review-card--featured' : ''; ?>">
					<div class="ac-tech-home-review-card__quote">
						<?php ac_tech_icon( 'format_quote' ); ?>
					</div>
					<p class="ac-tech-home-review-card__text"><?php echo esc_html( $review['text'] ); ?></p>
					<div class="ac-tech-home-review-card__author">
						<?php
						$avatar_html = function_exists( 'ac_tech_render_home_media_item_image' )
							? ac_tech_render_home_media_item_image( $review, 'avatar', 'ac-tech-home-review-card__avatar' )
							: ( ! empty( $review['avatar'] ) ? ac_tech_responsive_image( $review['avatar'] ) : '' );
						if ( $avatar_html ) {
							echo $avatar_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
						<div>
							<p class="ac-tech-home-review-card__name"><?php echo esc_html( $review['name'] ); ?></p>
							<p class="ac-tech-home-review-card__role"><?php echo esc_html( $review['role'] ); ?></p>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
