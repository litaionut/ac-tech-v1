<?php
/**
 * Blog newsletter section.
 *
 * @package AC-Tech
 */

$newsletter = ac_tech_get_blog_newsletter();
?>
<section class="ac-tech-blog-newsletter" aria-labelledby="ac-tech-blog-newsletter-title">
	<div class="ac-tech-blog-newsletter__inner">
		<?php ac_tech_icon( 'ac_unit', 'ac-tech-blog-newsletter__icon' ); ?>
		<h2 id="ac-tech-blog-newsletter-title" class="ac-tech-blog-newsletter__title"><?php echo esc_html( $newsletter['title'] ); ?></h2>
		<p class="ac-tech-blog-newsletter__text"><?php echo esc_html( $newsletter['text'] ); ?></p>
		<form class="ac-tech-blog-newsletter__form" action="#" method="post">
			<label class="screen-reader-text" for="ac-tech-blog-newsletter-email"><?php echo esc_html( $newsletter['placeholder'] ); ?></label>
			<input id="ac-tech-blog-newsletter-email" class="ac-tech-blog-newsletter__input" type="email" name="email" placeholder="<?php echo esc_attr( $newsletter['placeholder'] ); ?>" required>
			<button class="ac-tech-btn ac-tech-btn--primary ac-tech-blog-newsletter__btn" type="submit"><?php echo esc_html( $newsletter['button'] ); ?></button>
		</form>
		<p class="ac-tech-blog-newsletter__disclaimer"><?php echo esc_html( $newsletter['disclaimer'] ); ?></p>
	</div>
</section>
