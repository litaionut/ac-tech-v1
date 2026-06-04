<?php
/**
 * Single post template registration (classic editor dropdown).
 *
 * @package AC-Tech
 */

/**
 * Registered single post templates.
 *
 * @return string[]
 */
function ac_tech_get_post_templates() {
	return array(
		'single-post-template-1.php' => __( 'Articol — Analiză tehnică (sidebar)', 'ac-tech' ),
		'single-post-template-2.php' => __( 'Articol — Storytelling wellness', 'ac-tech' ),
		'single-post-template-3.php' => __( 'Articol — Editorial + articole similare', 'ac-tech' ),
	);
}

/**
 * Register post templates in the editor.
 *
 * @param string[]     $templates  Existing templates.
 * @param WP_Theme     $theme      Theme.
 * @param WP_Post|null $post       Post.
 * @param string       $post_type  Post type.
 * @return string[]
 */
function ac_tech_register_post_templates( $templates, $theme, $post, $post_type ) {
	unset( $theme, $post );

	if ( 'post' !== $post_type ) {
		return $templates;
	}

	foreach ( ac_tech_get_post_templates() as $file => $label ) {
		if ( ! isset( $templates[ $file ] ) ) {
			$templates[ $file ] = $label;
		}
	}

	return $templates;
}
add_filter( 'theme_post_templates', 'ac_tech_register_post_templates', 10, 4 );

/**
 * Load selected single post template file.
 *
 * @param string $template Path to template.
 * @return string
 */
function ac_tech_filter_single_post_template( $template ) {
	if ( ! is_singular( 'post' ) ) {
		return $template;
	}

	$post_template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );

	if ( ! $post_template || 'default' === $post_template ) {
		return $template;
	}

	$registered = ac_tech_get_post_templates();
	if ( ! isset( $registered[ $post_template ] ) ) {
		return $template;
	}

	$located = locate_template( $post_template );
	if ( $located ) {
		return $located;
	}

	return $template;
}
add_filter( 'single_template', 'ac_tech_filter_single_post_template' );

/**
 * Clear theme template cache when editing posts (Local WP).
 */
function ac_tech_refresh_post_template_cache() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'post' !== $screen->post_type ) {
		return;
	}
	ac_tech_refresh_theme_template_cache();
}
add_action( 'load-post.php', 'ac_tech_refresh_post_template_cache' );
add_action( 'load-post-new.php', 'ac_tech_refresh_post_template_cache' );
