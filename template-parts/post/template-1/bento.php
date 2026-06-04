<?php
/**
 * Post template 1 — bento cards.
 *
 * @package AC-Tech
 */

$cards = ac_tech_get_post_template_1_bento_cards();
?>
<section id="ac-tech-post-t1-bento" class="ac-tech-post-t1-bento">
	<?php foreach ( $cards as $card ) : ?>
		<?php
		$variant = isset( $card['variant'] ) ? (string) $card['variant'] : 'light';
		$class   = 'primary' === $variant ? ' ac-tech-post-t1-bento__card--primary' : '';
		?>
		<div class="ac-tech-post-t1-bento__card<?php echo esc_attr( $class ); ?>">
			<div class="ac-tech-post-t1-bento__icon-wrap">
				<?php ac_tech_icon( $card['icon'], 'ac-tech-post-t1-bento__icon' ); ?>
			</div>
			<h3 class="ac-tech-post-t1-bento__title"><?php echo esc_html( $card['title'] ); ?></h3>
			<p class="ac-tech-post-t1-bento__text"><?php echo esc_html( $card['text'] ); ?></p>
			<?php if ( ! empty( $card['items'] ) ) : ?>
				<ul class="ac-tech-post-t1-bento__list">
					<?php foreach ( $card['items'] as $item ) : ?>
						<li>
							<?php ac_tech_icon( 'check_circle', 'ac-tech-post-t1-bento__check' ); ?>
							<span><?php echo esc_html( $item ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( ! empty( $card['progress'] ) ) : ?>
				<div class="ac-tech-post-t1-bento__progress" role="progressbar" aria-valuenow="<?php echo esc_attr( (string) $card['progress'] ); ?>" aria-valuemin="0" aria-valuemax="100">
					<div class="ac-tech-post-t1-bento__progress-bar" style="width: <?php echo esc_attr( (string) $card['progress'] ); ?>%"></div>
				</div>
				<p class="ac-tech-post-t1-bento__progress-label"><?php echo esc_html( $card['progress_lbl'] ); ?></p>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</section>
