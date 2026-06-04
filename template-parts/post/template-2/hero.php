<?php
/**
 * Post template 2 — parallax hero.
 *
 * @package AC-Tech
 */

$hero = ac_tech_get_post_template_2_hero();
?>
<section class="ac-tech-post-t2-hero">
	<div class="ac-tech-post-t2-hero__bg" data-ac-tech-parallax>
		<?php ac_tech_render_post_image( $hero['hero_image'], 'ac-tech-post-t2-hero__image', true ); ?>
	</div>
	<div class="ac-tech-post-t2-hero__overlay" aria-hidden="true"></div>
	<div class="ac-tech-post-t2-hero__content ac-tech-container">
		<span class="ac-tech-post-t2-hero__badge"><?php echo esc_html( $hero['badge'] ); ?></span>
		<h1 class="ac-tech-post-t2-hero__title"><?php the_title(); ?></h1>
		<p class="ac-tech-post-t2-hero__subtitle"><?php echo esc_html( $hero['subtitle'] ); ?></p>
	</div>
</section>
