<?php
/**
 * Post template 2 — closing CTA section.
 *
 * @package AC-Tech
 */

$closing = ac_tech_get_post_template_2_closing();
?>
<section class="ac-tech-post-t2-closing ac-tech-container">
	<div class="ac-tech-post-t2-closing__grid">
		<div class="ac-tech-post-t2-closing__body">
			<h2 class="ac-tech-post-t2-closing__title"><?php echo esc_html( $closing['title'] ); ?></h2>
			<p class="ac-tech-post-t2-closing__text"><?php echo esc_html( $closing['text'] ); ?></p>
			<a class="ac-tech-btn ac-tech-btn--primary ac-tech-post-t2-closing__btn" href="<?php echo esc_url( $closing['url'] ); ?>">
				<?php echo esc_html( $closing['button'] ); ?>
			</a>
		</div>
		<div class="ac-tech-post-t2-closing__media">
			<?php ac_tech_render_post_image( $closing['image'], 'ac-tech-post-t2-closing__image', false ); ?>
		</div>
	</div>
</section>
