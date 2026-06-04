<?php
/**
 * Post template 1 — detail section.
 *
 * @package AC-Tech
 */

$detail = ac_tech_get_post_template_1_detail();
?>
<section id="ac-tech-post-t1-detail" class="ac-tech-post-t1-detail">
	<h2 class="ac-tech-post-t1-detail__title"><?php echo esc_html( $detail['title'] ); ?></h2>
	<p class="ac-tech-post-t1-detail__text"><?php echo esc_html( $detail['text'] ); ?></p>
	<blockquote class="ac-tech-post-t1-detail__quote">
		<?php echo esc_html( $detail['quote'] ); ?>
	</blockquote>
	<ul class="ac-tech-post-t1-detail__features">
		<?php foreach ( $detail['features'] as $feature ) : ?>
			<li>
				<?php ac_tech_icon( $feature['icon'], 'ac-tech-post-t1-detail__feature-icon' ); ?>
				<span><?php echo esc_html( $feature['label'] ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
