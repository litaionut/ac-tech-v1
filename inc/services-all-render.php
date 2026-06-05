<?php
/**
 * Services catalog — render helpers.
 *
 * @package AC-Tech
 */

/**
 * @param array<string, mixed> $item Item data.
 */
function ac_tech_services_all_render_bullets( $item ) {
	if ( empty( $item['bullets'] ) || ! is_array( $item['bullets'] ) ) {
		return;
	}
	?>
	<ul class="ac-tech-services-all__bullets">
		<?php foreach ( $item['bullets'] as $bullet ) : ?>
			<li class="ac-tech-services-all__bullet">
				<?php ac_tech_icon( (string) ( $bullet['icon'] ?? 'check_circle' ), 'ac-tech-services-all__bullet-icon' ); ?>
				<span><?php echo esc_html( (string) ( $bullet['text'] ?? '' ) ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * @param array<string, mixed> $item Item data.
 */
function ac_tech_services_all_render_meta_cta( $item ) {
	$has_meta = ! empty( $item['duration'] );
	$has_cta  = ! empty( $item['cta_label'] ) && ! empty( $item['cta_url'] );

	if ( ! $has_meta && ! $has_cta ) {
		return;
	}
	?>
	<div class="ac-tech-services-all__actions">
		<?php if ( $has_meta ) : ?>
			<div class="ac-tech-services-all__meta">
				<?php ac_tech_icon( (string) ( $item['duration_icon'] ?? 'schedule' ), 'ac-tech-services-all__meta-icon' ); ?>
				<span><?php echo esc_html( (string) $item['duration'] ); ?></span>
			</div>
		<?php endif; ?>
		<?php if ( $has_cta ) : ?>
			<a class="ac-tech-btn ac-tech-btn--primary ac-tech-services-all__cta" href="<?php echo esc_url( (string) $item['cta_url'] ); ?>">
				<?php echo esc_html( (string) $item['cta_label'] ); ?>
			</a>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * @param array<string, mixed> $item Item data.
 */
function ac_tech_services_all_render_split( $item ) {
	$reverse = ( 'split_reverse' === ( $item['layout'] ?? '' ) );
	$image   = ac_tech_services_all_render_item_image( $item );
	?>
	<section class="ac-tech-services-all-split<?php echo $reverse ? ' ac-tech-services-all-split--reverse' : ''; ?> ac-tech-services-all-reveal">
		<div class="ac-tech-services-all-split__content">
			<h2 class="ac-tech-services-all-split__title"><?php echo esc_html( (string) $item['title'] ); ?></h2>
			<?php if ( ! empty( $item['text'] ) ) : ?>
				<p class="ac-tech-services-all-split__text"><?php echo esc_html( (string) $item['text'] ); ?></p>
			<?php endif; ?>
			<?php ac_tech_services_all_render_bullets( $item ); ?>
			<?php ac_tech_services_all_render_meta_cta( $item ); ?>
		</div>
		<?php if ( $image ) : ?>
			<div class="ac-tech-services-all-split__media ac-tech-services-all__media">
				<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>
	</section>
	<?php
}

/**
 * @param array<string, mixed> $item Item data.
 */
function ac_tech_services_all_render_panel( $item ) {
	$image = ac_tech_services_all_render_item_image( $item );
	?>
	<section class="ac-tech-services-all-panel ac-tech-services-all-reveal">
		<div class="ac-tech-services-all-panel__content">
			<h2 class="ac-tech-services-all-split__title"><?php echo esc_html( (string) $item['title'] ); ?></h2>
			<?php if ( ! empty( $item['text'] ) ) : ?>
				<p class="ac-tech-services-all-split__text"><?php echo esc_html( (string) $item['text'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $item['highlights'] ) && is_array( $item['highlights'] ) ) : ?>
				<div class="ac-tech-services-all-panel__highlights">
					<?php foreach ( $item['highlights'] as $highlight ) : ?>
						<div class="ac-tech-services-all-panel__highlight">
							<?php ac_tech_icon( (string) ( $highlight['icon'] ?? 'check_circle' ), 'ac-tech-services-all-panel__highlight-icon' ); ?>
							<div class="ac-tech-services-all-panel__highlight-label"><?php echo esc_html( (string) ( $highlight['label'] ?? '' ) ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $item['cta_label'] ) && ! empty( $item['cta_url'] ) ) : ?>
				<div class="ac-tech-services-all-panel__cta-wrap">
					<a class="ac-tech-btn ac-tech-btn--primary ac-tech-services-all__cta" href="<?php echo esc_url( (string) $item['cta_url'] ); ?>">
						<?php echo esc_html( (string) $item['cta_label'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $image ) : ?>
			<div class="ac-tech-services-all-panel__media ac-tech-services-all__media">
				<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>
	</section>
	<?php
}

/**
 * @param array<string, mixed> $item Item data.
 */
function ac_tech_services_all_render_card( $item ) {
	?>
	<article class="ac-tech-services-all-card ac-tech-services-all-reveal">
		<div class="ac-tech-services-all-card__body">
			<div class="ac-tech-services-all-card__icon-wrap">
				<?php ac_tech_icon( (string) ( $item['card_icon'] ?? 'check_circle' ), 'ac-tech-services-all-card__icon' ); ?>
			</div>
			<h3 class="ac-tech-services-all-card__title"><?php echo esc_html( (string) $item['title'] ); ?></h3>
			<?php if ( ! empty( $item['text'] ) ) : ?>
				<p class="ac-tech-services-all-card__text"><?php echo esc_html( (string) $item['text'] ); ?></p>
			<?php endif; ?>
			<?php ac_tech_services_all_render_bullets( $item ); ?>
		</div>
		<div class="ac-tech-services-all-card__footer">
			<?php if ( ! empty( $item['duration'] ) ) : ?>
				<span class="ac-tech-services-all-card__duration"><?php echo esc_html( (string) $item['duration'] ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $item['cta_label'] ) && ! empty( $item['cta_url'] ) ) : ?>
				<a class="ac-tech-services-all-card__link" href="<?php echo esc_url( (string) $item['cta_url'] ); ?>">
					<?php echo esc_html( (string) $item['cta_label'] ); ?>
				</a>
			<?php endif; ?>
		</div>
	</article>
	<?php
}

/**
 * @param array<int, array<string, mixed>> $cards Card items.
 */
function ac_tech_services_all_render_card_row( $cards ) {
	if ( empty( $cards ) ) {
		return;
	}
	?>
	<section class="ac-tech-services-all-cards ac-tech-services-all-reveal">
		<?php foreach ( $cards as $card ) : ?>
			<?php ac_tech_services_all_render_card( $card ); ?>
		<?php endforeach; ?>
	</section>
	<?php
}
