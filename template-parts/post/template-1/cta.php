<?php
/**
 * Post template 1 — bottom CTA.
 *
 * @package AC-Tech
 */

$cta = ac_tech_get_post_template_1_cta();
?>
<section id="ac-tech-post-t1-cta" class="ac-tech-post-t1-cta">
	<h2 class="ac-tech-post-t1-cta__title"><?php echo esc_html( $cta['title'] ); ?></h2>
	<p class="ac-tech-post-t1-cta__text"><?php echo esc_html( $cta['text'] ); ?></p>
	<a class="ac-tech-btn ac-tech-btn--primary ac-tech-post-t1-cta__btn" href="<?php echo esc_url( $cta['url'] ); ?>">
		<?php echo esc_html( $cta['button'] ); ?>
	</a>
</section>
