<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--contact">

	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/contact/layout' );
	endwhile;
	?>

</main>

<?php
get_footer();
