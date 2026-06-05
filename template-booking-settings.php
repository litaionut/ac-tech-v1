<?php
/**
 * Template Name: Setări booking (admin)
 * Template Post Type: page
 *
 * Pagina există doar ca „container” pentru ACF fields.
 *
 * @package AC-Tech
 */

// Do not expose settings content on frontend.
if ( ! is_user_logged_in() ) {
	wp_safe_redirect( home_url( '/' ) );
	exit;
}

get_header();
?>

<main id="primary" class="site-main site-main--page">
	<div class="ac-tech-container" style="padding: 48px 0;">
		<h1><?php esc_html_e( 'Setări booking', 'ac-tech' ); ?></h1>
		<p><?php esc_html_e( 'Această pagină este folosită doar pentru administrarea câmpurilor ACF.', 'ac-tech' ); ?></p>
	</div>
</main>

<?php
get_footer();

