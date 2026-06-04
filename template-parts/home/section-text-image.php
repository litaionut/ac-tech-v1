<?php
/**
 * Homepage section: text + image (ACF pilot).
 *
 * @package AC-Tech
 */

if ( ! is_front_page() ) {
	return;
}

$heading  = ac_tech_get_front_page_field( 'test_heading', '' );
$text     = ac_tech_get_front_page_field( 'test_text', '' );
$image_id = (int) ac_tech_get_front_page_field( 'test_image', 0 );

if ( '' === $heading && '' === $text && $image_id <= 0 ) {
	return;
}

$section_id = 'ac-tech-text-image-title';
?>
<section class="ac-tech-section ac-tech-text-image" aria-labelledby="<?php echo esc_attr( $section_id ); ?>">
	<div class="ac-tech-container ac-tech-text-image__grid">
		<div class="ac-tech-text-image__content">
			<?php if ( $heading ) : ?>
				<h2 id="<?php echo esc_attr( $section_id ); ?>" class="ac-tech-text-image__title">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<div class="ac-tech-text-image__text">
					<?php echo wp_kses_post( wpautop( $text ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $image_id > 0 ) : ?>
			<figure class="ac-tech-text-image__media">
				<?php
				echo ac_tech_get_acf_image(
					$image_id,
					'large',
					array(
						'class' => 'ac-tech-text-image__img',
					)
				);
				?>
			</figure>
		<?php endif; ?>
	</div>
</section>
