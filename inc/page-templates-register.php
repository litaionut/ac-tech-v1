<?php
/**
 * Page template registration and theme cache refresh (Local + live).
 *
 * @package AC-Tech
 */

/**
 * Page templates (theme root — reliable on all hosts).
 *
 * @return string[]
 */
function ac_tech_get_page_templates() {
	return array(
		'template-about.php'         => __( 'Despre noi', 'ac-tech' ),
		'template-services.php'      => __( 'Servicii — catalog', 'ac-tech' ),
		'template-contact.php'       => __( 'Contact', 'ac-tech' ),
		'template-igienizare-ac.php' => __( 'Igienizare AC', 'ac-tech' ),
		'template-booking.php'       => __( 'Programare', 'ac-tech' ),
		'template-booking-settings.php' => __( 'Setări booking (admin)', 'ac-tech' ),
	);
}

/**
 * Register page templates in the block/classic editor.
 *
 * @param string[]     $templates Existing templates.
 * @param WP_Theme     $theme     Theme object.
 * @param WP_Post|null $post      Post being edited.
 * @return string[]
 */
function ac_tech_register_page_templates( $templates, $theme, $post ) {
	unset( $theme, $post );

	$registered = ac_tech_get_page_templates();

	foreach ( $registered as $file => $label ) {
		if ( ! isset( $templates[ $file ] ) ) {
			$templates[ $file ] = $label;
		}
	}

	return $templates;
}
add_filter( 'theme_page_templates', 'ac_tech_register_page_templates', 10, 3 );

/**
 * Exclude dev folders from theme file scans.
 *
 * @param string[] $exclusions Excluded directory names.
 * @return string[]
 */
function ac_tech_theme_scandir_exclusions( $exclusions ) {
	$exclusions[] = '.cursor';
	$exclusions[] = 'node_modules';

	return $exclusions;
}
add_filter( 'theme_scandir_exclusions', 'ac_tech_theme_scandir_exclusions' );

/**
 * Clear stale theme template cache when editing pages (fixes Local WP).
 */
function ac_tech_refresh_theme_template_cache() {
	$theme = wp_get_theme();
	if ( 'ac-tech' !== $theme->get_stylesheet() ) {
		return;
	}
	$theme->cache_delete();
}
add_action( 'load-post.php', 'ac_tech_refresh_theme_template_cache' );
add_action( 'load-post-new.php', 'ac_tech_refresh_theme_template_cache' );
add_action( 'after_switch_theme', 'ac_tech_refresh_theme_template_cache' );
