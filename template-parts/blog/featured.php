<?php
/**
 * Featured bento layout — first 3 posts (blog home, page 1 only).
 *
 * @package AC-Tech
 */

if ( ! have_posts() ) {
	return;
}

$index = 0;
?>
<section class="ac-tech-blog-featured" aria-label="<?php esc_attr_e( 'Articole recomandate', 'ac-tech' ); ?>">
	<div class="ac-tech-blog-featured__grid">
		<?php if ( have_posts() ) : ?>
			<?php the_post(); ++$index; ?>
			<article <?php post_class( 'ac-tech-blog-featured__main' ); ?>>
				<a class="ac-tech-blog-card ac-tech-blog-card--featured" href="<?php the_permalink(); ?>">
					<div class="ac-tech-blog-card__media ac-tech-blog-card__media--wide">
						<?php ac_tech_render_blog_thumbnail(); ?>
						<?php if ( is_sticky() ) : ?>
							<span class="ac-tech-blog-card__badge"><?php esc_html_e( 'RECOMANDAT', 'ac-tech' ); ?></span>
						<?php endif; ?>
					</div>
					<div class="ac-tech-blog-card__body">
						<?php ac_tech_render_blog_meta( array( 'link_category' => false ) ); ?>
						<h2 class="ac-tech-blog-card__title ac-tech-blog-card__title--lg"><?php the_title(); ?></h2>
						<p class="ac-tech-blog-card__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
					</div>
				</a>
			</article>
		<?php endif; ?>

		<div class="ac-tech-blog-featured__side">
			<?php if ( have_posts() ) : ?>
				<?php the_post(); ++$index; ?>
				<article <?php post_class( 'ac-tech-blog-featured__side-item' ); ?>>
					<a class="ac-tech-blog-card ac-tech-blog-card--side" href="<?php the_permalink(); ?>">
						<div class="ac-tech-blog-card__media ac-tech-blog-card__media--square">
							<?php ac_tech_render_blog_thumbnail(); ?>
						</div>
						<div class="ac-tech-blog-card__body">
							<?php ac_tech_render_blog_meta( array( 'link_category' => false ) ); ?>
							<h3 class="ac-tech-blog-card__title"><?php the_title(); ?></h3>
						</div>
					</a>
				</article>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<?php the_post(); ++$index; ?>
				<article <?php post_class( 'ac-tech-blog-featured__side-item ac-tech-blog-featured__side-item--compact' ); ?>>
					<a class="ac-tech-blog-card ac-tech-blog-card--compact" href="<?php the_permalink(); ?>">
						<?php ac_tech_render_blog_meta( array( 'link_category' => false ) ); ?>
						<h3 class="ac-tech-blog-card__title"><?php the_title(); ?></h3>
					</a>
				</article>
			<?php endif; ?>
		</div>
	</div>
</section>
