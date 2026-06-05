<?php
/**
 * Template Name: Servicii — catalog
 * Template Post Type: page
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--services-all">

	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/services-all/hero' );
		get_template_part( 'template-parts/services-all/layout' );
	endwhile;
	?>

</main>

<?php
get_footer();
