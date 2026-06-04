<?php
/**
 * Post template 2 — newsletter band.
 *
 * @package AC-Tech
 */

$newsletter = ac_tech_get_post_template_2_newsletter();
?>
<section class="ac-tech-post-t2-newsletter ac-tech-container">
	<div class="ac-tech-post-t2-newsletter__box">
		<h3 class="ac-tech-post-t2-newsletter__title"><?php echo esc_html( $newsletter['title'] ); ?></h3>
		<p class="ac-tech-post-t2-newsletter__text"><?php echo esc_html( $newsletter['text'] ); ?></p>
		<form class="ac-tech-post-t2-newsletter__form" action="#" method="post">
			<label class="screen-reader-text" for="ac-tech-post-t2-email"><?php echo esc_html( $newsletter['placeholder'] ); ?></label>
			<input id="ac-tech-post-t2-email" class="ac-tech-post-t2-newsletter__input" type="email" name="email" placeholder="<?php echo esc_attr( $newsletter['placeholder'] ); ?>" required>
			<button class="ac-tech-btn ac-tech-btn--light ac-tech-post-t2-newsletter__btn" type="submit"><?php echo esc_html( $newsletter['button'] ); ?></button>
		</form>
	</div>
</section>
