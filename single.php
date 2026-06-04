<?php
/**
 * Single post fallback (no custom template selected).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package AC-Tech
 */

get_header();
?>

<main id="primary" class="site-main site-main--page site-main--post site-main--post-t3">

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article class="ac-tech-container ac-tech-post-fallback">
			<header class="ac-tech-post-fallback__header">
				<h1 class="ac-tech-post-fallback__title"><?php the_title(); ?></h1>
				<time class="ac-tech-post-fallback__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="ac-tech-post-fallback__media">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>
			<div class="ac-tech-post-fallback__content entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>

</main>

<?php
get_footer();
