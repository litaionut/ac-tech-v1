<?php
/**
 * Blog index hero header.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_blog_header();
?>
<header class="ac-tech-blog-header">
	<span class="ac-tech-blog-header__badge"><?php echo esc_html( $header['badge'] ); ?></span>
	<h1 class="ac-tech-blog-header__title">
		<?php echo esc_html( $header['title'] ); ?>
		<span class="ac-tech-blog-header__accent"><?php echo esc_html( $header['accent'] ); ?></span>
		<?php esc_html_e( 'perfect.', 'ac-tech' ); ?>
	</h1>
	<p class="ac-tech-blog-header__text"><?php echo esc_html( $header['text'] ); ?></p>
</header>
