<?php
/**
 * Post template 3 — related posts.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_post_template_3_related_header();
$posts  = ac_tech_get_related_posts( 3 );
?>
<section class="ac-tech-post-t3-related">
	<div class="ac-tech-container ac-tech-post-t3-related__inner">
		<div class="ac-tech-post-t3-related__header">
			<div>
				<h2 class="ac-tech-post-t3-related__title"><?php echo esc_html( $header['title'] ); ?></h2>
				<p class="ac-tech-post-t3-related__text"><?php echo esc_html( $header['text'] ); ?></p>
			</div>
			<a class="ac-tech-post-t3-related__all" href="<?php echo esc_url( $header['url'] ); ?>">
				<?php echo esc_html( $header['link'] ); ?>
				<?php ac_tech_icon( 'arrow_forward', 'ac-tech-post-t3-related__all-icon' ); ?>
			</a>
		</div>
		<?php if ( ! empty( $posts ) ) : ?>
			<div class="ac-tech-post-t3-related__grid">
				<?php foreach ( $posts as $related_post ) : ?>
					<?php ac_tech_render_related_post_card( $related_post ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
