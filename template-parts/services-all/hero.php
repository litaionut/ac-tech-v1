<?php
/**
 * Services catalog — hero section.
 *
 * @package AC-Tech
 */

$hero = ac_tech_get_services_all_hero();
?>
<header class="ac-tech-services-all-hero ac-tech-container">
	<div class="ac-tech-services-all-hero__inner">
		<?php if ( ! empty( $hero['badge'] ) ) : ?>
			<span class="ac-tech-services-all-hero__badge"><?php echo esc_html( $hero['badge'] ); ?></span>
		<?php endif; ?>
		<h1 class="ac-tech-services-all-hero__title"><?php echo esc_html( $hero['title'] ); ?></h1>
		<?php if ( ! empty( $hero['text'] ) ) : ?>
			<p class="ac-tech-services-all-hero__text"><?php echo esc_html( $hero['text'] ); ?></p>
		<?php endif; ?>
	</div>
</header>
