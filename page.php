<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AC-Tech
 */

get_header();
?>

	<main id="primary" class="site-main site-main--page">

		<?php
		while ( have_posts() ) :
			the_post();

			ac_tech_render_page_hero(
				array(
					'title'    => get_the_title(),
					'subtitle' => has_excerpt() ? get_the_excerpt() : '',
				)
			);
			?>

			<div class="ac-tech-container ac-tech-content">
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
			</div>

			<?php
			if ( comments_open() || get_comments_number() ) :
				echo '<div class="ac-tech-container">';
				comments_template();
				echo '</div>';
			endif;

		endwhile;
		?>

	</main><!-- #main -->

<?php
get_footer();
