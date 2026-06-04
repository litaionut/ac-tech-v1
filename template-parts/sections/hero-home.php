<?php
/**
 * Homepage hero section.
 *
 * @package AC-Tech
 */

$eyebrow       = '';
$title         = '';
$lead          = '';
$cta_primary   = '';
$cta_primary_url = '';
$cta_secondary = '';
$cta_secondary_url = '';

if ( '' === $eyebrow && '' === $title && '' === $lead && '' === $cta_primary && '' === $cta_secondary ) {
	return;
}

$section_id = 'ac-tech-hero-title';
?>
<section class="ac-tech-section ac-tech-hero" aria-labelledby="<?php echo esc_attr( $section_id ); ?>">
	<div class="ac-tech-container ac-tech-hero__inner">
		<?php if ( $eyebrow ) : ?>
			<p class="ac-tech-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $title ) : ?>
			<h1 id="<?php echo esc_attr( $section_id ); ?>" class="ac-tech-hero__title">
				<?php echo esc_html( $title ); ?>
			</h1>
		<?php endif; ?>

		<?php if ( $lead ) : ?>
			<p class="ac-tech-hero__lead">
				<?php echo esc_html( $lead ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $cta_primary || $cta_secondary ) : ?>
			<div class="ac-tech-hero__actions">
				<?php if ( $cta_primary && $cta_primary_url ) : ?>
					<a class="ac-tech-btn ac-tech-btn--primary" href="<?php echo esc_url( $cta_primary_url ); ?>">
						<?php echo esc_html( $cta_primary ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $cta_secondary && $cta_secondary_url ) : ?>
					<a class="ac-tech-btn ac-tech-btn--ghost" href="<?php echo esc_url( $cta_secondary_url ); ?>">
						<?php echo esc_html( $cta_secondary ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
