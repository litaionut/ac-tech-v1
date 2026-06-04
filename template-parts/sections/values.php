<?php
/**
 * Values section for the about page.
 *
 * @package AC-Tech
 */

$section_title = '';
$values        = array();

if ( '' === $section_title && empty( $values ) ) {
	return;
}

$section_id = 'ac-tech-values-title';
?>
<section class="ac-tech-section ac-tech-values" aria-labelledby="<?php echo esc_attr( $section_id ); ?>">
	<div class="ac-tech-container">
		<?php if ( $section_title ) : ?>
			<h2 id="<?php echo esc_attr( $section_id ); ?>" class="ac-tech-section-header__title">
				<?php echo esc_html( $section_title ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $values ) ) : ?>
			<ul class="ac-tech-values__list">
				<?php foreach ( $values as $label => $text ) : ?>
					<?php if ( '' === $label && '' === $text ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<li class="ac-tech-values__item">
						<?php if ( $label ) : ?>
							<h3 class="ac-tech-values__label"><?php echo esc_html( $label ); ?></h3>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="ac-tech-values__text"><?php echo esc_html( $text ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
