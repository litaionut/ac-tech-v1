<?php
/**
 * Template Name: Igienizare AC
 * Template Post Type: page
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--service-igienizare">

	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/service/igienizare/hero' );
		get_template_part( 'template-parts/service/igienizare/benefits' );
		get_template_part( 'template-parts/service/igienizare/process' );
		get_template_part( 'template-parts/service/igienizare/pricing' );
		get_template_part( 'template-parts/service/igienizare/faq' );
		get_template_part( 'template-parts/service/igienizare/cta' );
	endwhile;
	?>

</main>

<?php
get_footer();
