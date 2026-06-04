<?php
/**
 * Post template 1 — sidebar.
 *
 * @package AC-Tech
 */

$expert = ac_tech_get_post_template_1_sidebar_expert();
$toc    = ac_tech_get_post_template_1_sidebar_toc();
$cta    = ac_tech_get_post_template_1_sidebar_cta();
?>
<aside class="ac-tech-post-t1-sidebar" aria-label="<?php esc_attr_e( 'Informații suplimentare articol', 'ac-tech' ); ?>">
	<div class="ac-tech-post-t1-sidebar__expert">
		<div class="ac-tech-post-t1-sidebar__expert-head">
			<div class="ac-tech-post-t1-sidebar__expert-avatar">
				<?php ac_tech_render_post_image( $expert['image'], 'ac-tech-post-t1-sidebar__avatar-img', false ); ?>
			</div>
			<div>
				<h4 class="ac-tech-post-t1-sidebar__expert-name"><?php echo esc_html( $expert['name'] ); ?></h4>
				<p class="ac-tech-post-t1-sidebar__expert-role"><?php echo esc_html( $expert['role'] ); ?></p>
			</div>
		</div>
		<p class="ac-tech-post-t1-sidebar__expert-text"><?php echo esc_html( $expert['text'] ); ?></p>
		<div class="ac-tech-post-t1-sidebar__social">
			<a class="ac-tech-post-t1-sidebar__social-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Website', 'ac-tech' ); ?>">
				<?php ac_tech_icon( 'link' ); ?>
			</a>
			<a class="ac-tech-post-t1-sidebar__social-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" aria-label="<?php esc_attr_e( 'Contact', 'ac-tech' ); ?>">
				<?php ac_tech_icon( 'mail' ); ?>
			</a>
		</div>
	</div>

	<div class="ac-tech-post-t1-sidebar__toc">
		<h4 class="ac-tech-post-t1-sidebar__toc-title"><?php esc_html_e( 'Cuprins', 'ac-tech' ); ?></h4>
		<nav class="ac-tech-post-t1-sidebar__toc-nav">
			<?php foreach ( $toc as $index => $item ) : ?>
				<a class="ac-tech-post-t1-sidebar__toc-link<?php echo 0 === $index ? ' is-active' : ''; ?>" href="<?php echo esc_url( $item['url'] ); ?>">
					<span><?php echo esc_html( $item['label'] ); ?></span>
					<?php ac_tech_icon( 'chevron_right', 'ac-tech-post-t1-sidebar__toc-chevron' ); ?>
				</a>
			<?php endforeach; ?>
		</nav>
		<div class="ac-tech-post-t1-sidebar__cta-box">
			<span class="ac-tech-post-t1-sidebar__cta-badge"><?php echo esc_html( $cta['badge'] ); ?></span>
			<h5 class="ac-tech-post-t1-sidebar__cta-title"><?php echo esc_html( $cta['title'] ); ?></h5>
			<p class="ac-tech-post-t1-sidebar__cta-text"><?php echo esc_html( $cta['text'] ); ?></p>
			<a class="ac-tech-btn ac-tech-btn--light ac-tech-post-t1-sidebar__cta-btn" href="<?php echo esc_url( $cta['url'] ); ?>">
				<?php echo esc_html( $cta['button'] ); ?>
			</a>
		</div>
	</div>
</aside>
