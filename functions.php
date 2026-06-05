<?php
/**
 * AC-Tech functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AC-Tech
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.12.9' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ac_tech_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on AC-Tech, use a find and replace
		* to change 'ac-tech' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ac-tech', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ac-tech' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ac_tech_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ac_tech_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ac_tech_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ac_tech_content_width', 640 );
}
add_action( 'after_setup_theme', 'ac_tech_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ac_tech_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ac-tech' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ac-tech' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ac_tech_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ac_tech_scripts() {
	wp_enqueue_style( 'ac-tech-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ac-tech-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ac-tech-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ac_tech_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Template helpers (load before template-functions).
 */
require get_template_directory() . '/inc/template-helpers.php';

/**
 * Homepage static content helpers.
 */
require get_template_directory() . '/inc/home-editable.php';
require get_template_directory() . '/inc/home-acf-fields.php';
require get_template_directory() . '/inc/home-content.php';

/**
 * Igienizare AC service page content.
 */
require get_template_directory() . '/inc/service-igienizare-content.php';

/**
 * Booking page static content + custom booking engine.
 */
require get_template_directory() . '/inc/booking-content.php';
require get_template_directory() . '/inc/booking-cpt.php';
require get_template_directory() . '/inc/booking-acf-fields.php';
require get_template_directory() . '/inc/booking-availability.php';
require get_template_directory() . '/inc/booking-blocks.php';
require get_template_directory() . '/inc/booking-admin.php';
require get_template_directory() . '/inc/booking-emails.php';
require get_template_directory() . '/inc/booking-security.php';
require get_template_directory() . '/inc/booking-api.php';
require get_template_directory() . '/inc/booking-admin-calendar.php';

/**
 * Contact page static content.
 */
require get_template_directory() . '/inc/contact-content.php';
require get_template_directory() . '/inc/contact-editable.php';
require get_template_directory() . '/inc/contact-acf-fields.php';

/**
 * Blog index content helpers.
 */
require get_template_directory() . '/inc/blog-content.php';
require get_template_directory() . '/inc/blog-helpers.php';
require get_template_directory() . '/inc/blog-editable.php';
require get_template_directory() . '/inc/blog-acf-fields.php';
require get_template_directory() . '/inc/booking-editable.php';

/**
 * Single post templates — registration, helpers, editable content.
 */
require get_template_directory() . '/inc/post-templates-register.php';
require get_template_directory() . '/inc/post-template-helpers.php';
require get_template_directory() . '/inc/post-template-1-content.php';
require get_template_directory() . '/inc/post-template-2-content.php';
require get_template_directory() . '/inc/post-template-3-content.php';
require get_template_directory() . '/inc/post-template-editable.php';
require get_template_directory() . '/inc/post-template-acf-fields.php';
require get_template_directory() . '/inc/post-template-acf-load.php';

/**
 * Inline SVG icons.
 */
require get_template_directory() . '/inc/icons.php';

/**
 * Self-hosted responsive theme images.
 */
require get_template_directory() . '/inc/image-helpers.php';

/**
 * Page template registration (load early).
 */
require get_template_directory() . '/inc/page-templates-register.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-home-hero.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Presentation templates: assets and helpers.
 */
require get_template_directory() . '/inc/assets.php';

/**
 * ACF helpers (theme templates; safe without plugin).
 */
require get_template_directory() . '/inc/acf-helpers.php';

/**
 * ACF JSON paths (filters apply when Advanced Custom Fields is active).
 */
require get_template_directory() . '/inc/acf-fields.php';

/**
 * Page content reset helper (used by one-time maintenance scripts).
 */
require get_template_directory() . '/inc/page-content-reset.php';

