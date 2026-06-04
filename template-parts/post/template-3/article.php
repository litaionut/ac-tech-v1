<?php
/**
 * Post template 3 — article body + footer blocks.
 *
 * @package AC-Tech
 */

$author  = ac_tech_get_post_template_3_author();
$sections = ac_tech_get_post_template_3_sections();
$footer  = ac_tech_get_post_template_3_footer_blocks();
?>
<article class="ac-tech-post-t3-article ac-tech-container">
	<div class="ac-tech-post-t3-article__author">
		<div class="ac-tech-post-t3-article__author-avatar">
			<?php ac_tech_render_post_image( $author['image'], 'ac-tech-post-t3-article__avatar-img', false ); ?>
		</div>
		<div>
			<p class="ac-tech-post-t3-article__author-name"><?php echo esc_html( $author['name'] ); ?></p>
			<p class="ac-tech-post-t3-article__author-meta">
				<?php
				echo esc_html( $author['role'] );
				echo ' • ';
				echo esc_html( get_the_date( 'j F Y' ) );
				?>
			</p>
		</div>
	</div>

	<div class="ac-tech-post-t3-article__body">
		<?php foreach ( $sections as $section ) : ?>
			<?php
			$type = isset( $section['type'] ) ? (string) $section['type'] : 'paragraph';
			switch ( $type ) {
				case 'lead':
					?>
					<p class="ac-tech-post-t3-article__lead"><?php echo esc_html( $section['text'] ); ?></p>
					<?php
					break;
				case 'heading':
					?>
					<h2 class="ac-tech-post-t3-article__h2"><?php echo esc_html( $section['title'] ); ?></h2>
					<?php
					break;
				case 'quote':
					?>
					<blockquote class="ac-tech-post-t3-article__quote">
						<p><?php echo esc_html( $section['quote'] ); ?></p>
						<cite><?php echo esc_html( $section['cite'] ); ?></cite>
					</blockquote>
					<?php
					break;
				case 'list':
					?>
					<ul class="ac-tech-post-t3-article__list">
						<?php foreach ( $section['items'] as $item ) : ?>
							<li>
								<?php ac_tech_icon( 'check_circle', 'ac-tech-post-t3-article__list-icon' ); ?>
								<span><?php echo esc_html( $item ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php
					break;
				default:
					?>
					<p class="ac-tech-post-t3-article__p"><?php echo esc_html( $section['text'] ); ?></p>
					<?php
			}
			?>
		<?php endforeach; ?>
	</div>

	<footer class="ac-tech-post-t3-article__footer">
		<div class="ac-tech-post-t3-article__share">
			<h4><?php echo esc_html( $footer['share_title'] ); ?></h4>
			<div class="ac-tech-post-t3-article__share-btns">
				<button type="button" class="ac-tech-post-t3-article__share-btn" aria-label="<?php esc_attr_e( 'Distribuie', 'ac-tech' ); ?>"><?php ac_tech_icon( 'share' ); ?></button>
				<button type="button" class="ac-tech-post-t3-article__share-btn" aria-label="<?php esc_attr_e( 'Copiază link', 'ac-tech' ); ?>"><?php ac_tech_icon( 'link' ); ?></button>
				<a class="ac-tech-post-t3-article__share-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" aria-label="<?php esc_attr_e( 'Contact', 'ac-tech' ); ?>"><?php ac_tech_icon( 'mail' ); ?></a>
			</div>
		</div>
		<div class="ac-tech-post-t3-article__subscribe">
			<h4><?php echo esc_html( $footer['subscribe_title'] ); ?></h4>
			<p><?php echo esc_html( $footer['subscribe_text'] ); ?></p>
			<form class="ac-tech-post-t3-article__subscribe-form" action="#" method="post">
				<input type="email" name="email" placeholder="<?php echo esc_attr( $footer['subscribe_placeholder'] ); ?>" required>
				<button type="submit" class="ac-tech-btn ac-tech-btn--primary"><?php echo esc_html( $footer['subscribe_button'] ); ?></button>
			</form>
		</div>
	</footer>
</article>
