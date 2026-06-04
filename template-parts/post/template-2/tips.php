<?php
/**
 * Post template 2 — tips grid.
 *
 * @package AC-Tech
 */

$header = ac_tech_get_post_template_2_tips_header();
$tips   = ac_tech_get_post_template_2_tips();
?>
<section class="ac-tech-post-t2-tips">
	<div class="ac-tech-container ac-tech-post-t2-tips__inner">
		<h2 class="ac-tech-post-t2-tips__title"><?php echo esc_html( $header['title'] ); ?></h2>
		<div class="ac-tech-post-t2-tips__grid">
			<?php foreach ( $tips as $tip ) : ?>
				<div class="ac-tech-post-t2-tips__card" data-ac-tech-reveal>
					<div class="ac-tech-post-t2-tips__icon-wrap">
						<?php ac_tech_icon( $tip['icon'], 'ac-tech-post-t2-tips__icon' ); ?>
					</div>
					<h4 class="ac-tech-post-t2-tips__card-title"><?php echo esc_html( $tip['title'] ); ?></h4>
					<p class="ac-tech-post-t2-tips__card-text"><?php echo esc_html( $tip['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
