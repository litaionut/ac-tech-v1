<?php
/**
 * Template Name: Programare
 * Template Post Type: page
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--booking">

	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/booking/layout' );
	endwhile;
	?>

</main>

<?php
get_footer();
