<?php
/**
 * Template Name: Articol — Analiză tehnică (sidebar)
 * Template Post Type: post
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--post site-main--post-t1">

	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/post/template-1/layout' );
	endwhile;
	?>

</main>

<?php
get_footer();
