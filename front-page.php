<?php
/**
 * Homepage template.
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--front">

	<?php
	get_template_part( 'template-parts/home/hero' );
	get_template_part( 'template-parts/home/advantages' );
	get_template_part( 'template-parts/home/services' );
	get_template_part( 'template-parts/home/process' );
	get_template_part( 'template-parts/home/reviews' );
	get_template_part( 'template-parts/home/cta-final' );
	?>

</main>

<?php
get_footer();
