<?php
/**
 * Igienizare AC FAQ section.
 *
 * @package AC-Tech
 */

$sidebar = ac_tech_get_service_igienizare_faq_sidebar();
$items   = ac_tech_get_service_igienizare_faq();
?>
<section class="ac-tech-svc-ig-section ac-tech-svc-ig-faq" aria-labelledby="ac-tech-svc-ig-faq-title">
	<div class="ac-tech-container ac-tech-svc-ig-faq__grid">
		<div class="ac-tech-svc-ig-faq__sidebar">
			<h2 id="ac-tech-svc-ig-faq-title" class="ac-tech-svc-ig-section__title"><?php echo esc_html( $sidebar['title'] ); ?></h2>
			<p class="ac-tech-svc-ig-faq__intro"><?php echo esc_html( $sidebar['text'] ); ?></p>

			<div class="ac-tech-svc-ig-faq__team">
				<p class="ac-tech-svc-ig-faq__team-title"><?php echo esc_html( $sidebar['team_title'] ); ?></p>
				<p class="ac-tech-svc-ig-faq__team-text"><?php echo esc_html( $sidebar['team_text'] ); ?></p>
				<?php
				if ( ! empty( $sidebar['team_image'] ) ) {
					echo ac_tech_responsive_image( $sidebar['team_image'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				<p class="ac-tech-svc-ig-faq__team-tagline"><?php echo esc_html( $sidebar['team_tagline'] ); ?></p>
			</div>
		</div>

		<div class="ac-tech-svc-ig-faq__list">
			<?php foreach ( $items as $item ) : ?>
				<details class="ac-tech-svc-ig-faq__item"<?php echo ! empty( $item['open'] ) ? ' open' : ''; ?>>
					<summary class="ac-tech-svc-ig-faq__question">
						<?php echo esc_html( $item['question'] ); ?>
						<?php ac_tech_icon( 'expand_more', 'ac-tech-svc-ig-faq__chevron' ); ?>
					</summary>
					<div class="ac-tech-svc-ig-faq__answer">
						<?php echo esc_html( $item['answer'] ); ?>
					</div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
