<?php
/**
 * Post template 2 — intro columns.
 *
 * @package AC-Tech
 */

$intro = ac_tech_get_post_template_2_intro();
?>
<section class="ac-tech-post-t2-intro ac-tech-container">
	<div class="ac-tech-post-t2-intro__inner">
		<p class="ac-tech-post-t2-intro__lead"><?php echo esc_html( $intro['lead'] ); ?></p>
		<p class="ac-tech-post-t2-intro__text"><?php echo esc_html( $intro['text'] ); ?></p>
	</div>
</section>
