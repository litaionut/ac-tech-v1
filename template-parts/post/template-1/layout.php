<?php
/**
 * Post template 1 — full layout.
 *
 * @package AC-Tech
 */
?>
<div class="ac-tech-container ac-tech-post-t1">
	<div class="ac-tech-post-t1__grid">
		<article class="ac-tech-post-t1__main">
			<?php
			get_template_part( 'template-parts/post/template-1/header' );
			get_template_part( 'template-parts/post/template-1/intro' );
			get_template_part( 'template-parts/post/template-1/bento' );
			get_template_part( 'template-parts/post/template-1/detail' );
			get_template_part( 'template-parts/post/template-1/cta' );
			?>
		</article>
		<?php get_template_part( 'template-parts/post/template-1/sidebar' ); ?>
	</div>
</div>
