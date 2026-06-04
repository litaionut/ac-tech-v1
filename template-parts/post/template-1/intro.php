<?php
/**
 * Post template 1 — intro.
 *
 * @package AC-Tech
 */

$intro = ac_tech_get_post_template_1_intro();
?>
<section id="ac-tech-post-t1-intro" class="ac-tech-post-t1-intro">
	<p class="ac-tech-post-t1-intro__text"><?php echo esc_html( $intro['text'] ); ?></p>
</section>
