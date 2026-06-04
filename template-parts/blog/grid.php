<?php
/**
 * Blog posts grid + pagination.
 *
 * @package AC-Tech
 */

$show_section_header = ! is_paged();
?>
<section class="ac-tech-blog-grid-section" aria-labelledby="ac-tech-blog-grid-title">
	<?php if ( $show_section_header ) : ?>
		<div class="ac-tech-blog-grid-section__header">
			<h2 id="ac-tech-blog-grid-title" class="ac-tech-blog-grid-section__title"><?php esc_html_e( 'Ultimele Noutăți', 'ac-tech' ); ?></h2>
			<a class="ac-tech-blog-grid-section__link" href="<?php echo esc_url( ac_tech_get_blog_url() ); ?>">
				<?php esc_html_e( 'Vezi tot feed-ul', 'ac-tech' ); ?>
				<?php ac_tech_icon( 'arrow_forward', 'ac-tech-blog-grid-section__link-icon' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="ac-tech-blog-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$category = ac_tech_get_post_primary_category();
				?>
				<article <?php post_class( 'ac-tech-blog-grid__item' ); ?>>
					<a class="ac-tech-blog-card ac-tech-blog-card--grid" href="<?php the_permalink(); ?>">
						<div class="ac-tech-blog-card__media ac-tech-blog-card__media--grid">
							<?php ac_tech_render_blog_thumbnail(); ?>
						</div>
						<div class="ac-tech-blog-card__body ac-tech-blog-card__body--grid">
							<?php if ( $category ) : ?>
								<span class="ac-tech-blog-card__tag"><?php echo esc_html( $category->name ); ?></span>
							<?php endif; ?>
							<h3 class="ac-tech-blog-card__title"><?php the_title(); ?></h3>
							<p class="ac-tech-blog-card__excerpt ac-tech-blog-card__excerpt--clamp"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
							<div class="ac-tech-blog-card__author">
								<span class="ac-tech-blog-card__author-icon" aria-hidden="true">
									<?php ac_tech_icon( 'person' ); ?>
								</span>
								<span class="ac-tech-blog-card__author-name"><?php echo esc_html( ac_tech_get_blog_author_label() ); ?></span>
							</div>
						</div>
					</a>
				</article>
			<?php endwhile; ?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( 'Înapoi', 'ac-tech' ),
				'next_text' => __( 'Înainte', 'ac-tech' ),
				'class'     => 'ac-tech-blog-pagination',
			)
		);
		?>
	<?php else : ?>
		<p class="ac-tech-blog-empty"><?php esc_html_e( 'Nu există articole publicate încă.', 'ac-tech' ); ?></p>
	<?php endif; ?>
</section>
