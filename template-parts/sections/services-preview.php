<?php
/**
 * Services preview for the homepage.
 *
 * @package AC-Tech
 */

$section_title = '';
$section_lead  = '';
$link_text     = '';
$link_url      = '';
$services      = ac_tech_get_default_services();

if ( '' === $section_title && '' === $section_lead && empty( $services ) ) {
	return;
}

$section_id = 'ac-tech-services-preview-title';
?>
<section class="ac-tech-section ac-tech-services-preview" aria-labelledby="<?php echo esc_attr( $section_id ); ?>">
	<div class="ac-tech-container">
		<?php if ( $section_title || $section_lead ) : ?>
			<header class="ac-tech-section-header">
				<?php if ( $section_title ) : ?>
					<h2 id="<?php echo esc_attr( $section_id ); ?>" class="ac-tech-section-header__title">
						<?php echo esc_html( $section_title ); ?>
					</h2>
				<?php endif; ?>
				<?php if ( $section_lead ) : ?>
					<p class="ac-tech-section-header__lead">
						<?php echo esc_html( $section_lead ); ?>
					</p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php if ( ! empty( $services ) ) : ?>
			<ul class="ac-tech-card-grid">
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
		<?php endif; ?>

		<?php if ( $link_text && $link_url ) : ?>
			<p class="ac-tech-section-footer">
				<a class="ac-tech-link" href="<?php echo esc_url( $link_url ); ?>">
					<?php echo esc_html( $link_text ); ?> &rarr;
				</a>
			</p>
		<?php endif; ?>
	</div>
</section>
