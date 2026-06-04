<?php
/**
 * Post template 1 — header.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_post_template_1_header();
$read   = ac_tech_get_post_read_time();
?>
<header class="ac-tech-post-t1-header">
	<div class="ac-tech-post-t1-header__badge">
		<?php ac_tech_icon( $header['badge_icon'], 'ac-tech-post-t1-header__badge-icon' ); ?>
		<span><?php echo esc_html( $header['badge'] ); ?></span>
	</div>
	<h1 class="ac-tech-post-t1-header__title"><?php the_title(); ?></h1>
	<div class="ac-tech-post-t1-header__meta">
		<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
		<span class="ac-tech-post-t1-header__dot" aria-hidden="true"></span>
		<span><?php echo esc_html( (string) $read . ' ' . $header['read_label'] ); ?></span>
		<span class="ac-tech-post-t1-header__dot" aria-hidden="true"></span>
		<span><?php echo esc_html( $header['series'] ); ?></span>
	</div>
	<div class="ac-tech-post-t1-header__media">
		<?php ac_tech_render_post_image( $header['hero_image'], 'ac-tech-post-t1-header__image', true ); ?>
	</div>
</header>
