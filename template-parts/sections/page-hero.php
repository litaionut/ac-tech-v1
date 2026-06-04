<?php
/**
 * Inner page hero.
 *
 * @package AC-Tech
 *
 * @var array<string, mixed> $args Template arguments.
 */

$title    = isset( $args['title'] ) ? $args['title'] : get_the_title();
$subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : '';
$class    = isset( $args['class'] ) ? $args['class'] : '';
?>
<section class="ac-tech-section ac-tech-page-hero <?php echo esc_attr( $class ); ?>">
	<div class="ac-tech-container ac-tech-page-hero__inner">
		<h1 class="ac-tech-page-hero__title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $subtitle ) : ?>
			<p class="ac-tech-page-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
</section>
