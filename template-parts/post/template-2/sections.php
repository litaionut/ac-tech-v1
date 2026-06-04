<?php
/**
 * Post template 2 — alternating image sections.
 *
 * @package AC-Tech
 */

$sections = ac_tech_get_post_template_2_sections();
foreach ( $sections as $section ) :
	$reverse = ! empty( $section['reverse'] );
	?>
	<section class="ac-tech-post-t2-section<?php echo $reverse ? ' ac-tech-post-t2-section--alt' : ''; ?>">
		<div class="ac-tech-container ac-tech-post-t2-section__inner<?php echo $reverse ? ' ac-tech-post-t2-section__inner--reverse' : ''; ?>">
			<div class="ac-tech-post-t2-section__media">
				<?php ac_tech_render_post_image( $section['image'], 'ac-tech-post-t2-section__image', false ); ?>
			</div>
			<div class="ac-tech-post-t2-section__body">
				<h2 class="ac-tech-post-t2-section__title"><?php echo esc_html( $section['title'] ); ?></h2>
				<p class="ac-tech-post-t2-section__text"><?php echo esc_html( $section['text'] ); ?></p>
				<?php if ( ! empty( $section['items'] ) ) : ?>
					<ul class="ac-tech-post-t2-section__list">
						<?php foreach ( $section['items'] as $item ) : ?>
							<li>
								<?php ac_tech_icon( $item['icon'], 'ac-tech-post-t2-section__list-icon' ); ?>
								<span><?php echo esc_html( $item['text'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( ! empty( $section['stats'] ) ) : ?>
					<div class="ac-tech-post-t2-section__stats">
						<?php foreach ( $section['stats'] as $stat ) : ?>
							<div class="ac-tech-post-t2-section__stat">
								<span class="ac-tech-post-t2-section__stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
								<span class="ac-tech-post-t2-section__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endforeach; ?>
