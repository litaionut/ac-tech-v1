<?php
/**
 * Call-to-action band.
 *
 * @package AC-Tech
 */

$title     = '';
$text      = '';
$btn_text  = '';
$btn_url   = '';

if ( '' === $title && '' === $text && '' === $btn_text ) {
	return;
}

$section_id = 'ac-tech-cta-title';
?>
<section class="ac-tech-section ac-tech-cta" aria-labelledby="<?php echo esc_attr( $section_id ); ?>">
	<div class="ac-tech-container ac-tech-cta__inner">
		<?php if ( $title ) : ?>
			<h2 id="<?php echo esc_attr( $section_id ); ?>" class="ac-tech-cta__title">
				<?php echo esc_html( $title ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<p class="ac-tech-cta__text">
				<?php echo esc_html( $text ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $btn_text && $btn_url ) : ?>
			<a class="ac-tech-btn ac-tech-btn--primary" href="<?php echo esc_url( $btn_url ); ?>">
				<?php echo esc_html( $btn_text ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
