<?php
/**
 * Blog posts index (Posts page).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--blog">

	<div class="ac-tech-container ac-tech-blog">
		<?php
		get_template_part( 'template-parts/blog/header' );
		get_template_part( 'template-parts/blog/filters' );

		if ( have_posts() && ! is_paged() ) {
			get_template_part( 'template-parts/blog/featured' );
		}

		get_template_part( 'template-parts/blog/grid' );
		get_template_part( 'template-parts/blog/newsletter' );
		?>
	</div>

</main>

<?php
get_footer();
