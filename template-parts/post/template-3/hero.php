<?php
/**
 * Post template 3 — hero overlay.
 *
 * @package AC-Tech
 */

$hero = ac_tech_get_post_template_3_hero();
$read = ac_tech_get_post_read_time();
?>
<section class="ac-tech-post-t3-hero">
	<div class="ac-tech-post-t3-hero__media">
		<?php ac_tech_render_post_image( $hero['hero_image'], 'ac-tech-post-t3-hero__image', true ); ?>
		<div class="ac-tech-post-t3-hero__gradient" aria-hidden="true"></div>
	</div>
	<div class="ac-tech-container ac-tech-post-t3-hero__content">
		<div class="ac-tech-post-t3-hero__meta">
			<span class="ac-tech-post-t3-hero__badge"><?php echo esc_html( $hero['badge'] ); ?></span>
			<span class="ac-tech-post-t3-hero__read"><?php echo esc_html( (string) $read . ' ' . $hero['read_label'] ); ?></span>
		</div>
		<h1 class="ac-tech-post-t3-hero__title"><?php the_title(); ?></h1>
	</div>
</section>
