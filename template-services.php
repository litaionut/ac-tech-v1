<?php
/**
 * Template Name: Servicii
 * Template Post Type: page
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
				'class'    => 'page-hero--services',
			)
		);
		?>

		<?php get_template_part( 'template-parts/sections/services-grid' ); ?>

		<?php if ( get_the_content() ) : ?>
			<div class="ac-tech-container ac-tech-content">
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/sections/cta' ); ?>
		<?php
	endwhile;
	?>

</main>

<?php
get_footer();
