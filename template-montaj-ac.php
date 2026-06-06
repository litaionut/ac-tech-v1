<?php
/**
 * Template Name: Montaj AC București
 * Template Post Type: page
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--service-montaj">

	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/service/montaj/layout' );
	endwhile;
	?>

</main>

<?php
get_footer();
