<?php
/**
 * Montaj AC București — full page layout.
 *
 * @package AC-Tech
 */

$hero     = ac_tech_get_service_montaj_hero();
$includes = ac_tech_get_service_montaj_includes();
$inc_head = ac_tech_get_service_montaj_includes_header();
$price_h  = ac_tech_get_service_montaj_pricing_header();
$rows     = ac_tech_get_service_montaj_pricing_rows();
$zone_h   = ac_tech_get_service_montaj_zones_header();
$zones    = ac_tech_get_service_montaj_zones();
$cta      = ac_tech_get_service_montaj_cta();
?>
<section class="ac-tech-svc-montaj-hero" aria-labelledby="ac-tech-svc-montaj-hero-title">
	<div class="ac-tech-container ac-tech-svc-montaj-hero__grid">
		<div class="ac-tech-svc-montaj-hero__content">
			<?php if ( ! empty( $hero['badge'] ) ) : ?>
				<span class="ac-tech-home-badge"><?php echo esc_html( (string) $hero['badge'] ); ?></span>
			<?php endif; ?>
			<h1 id="ac-tech-svc-montaj-hero-title" class="ac-tech-svc-montaj-hero__title"><?php echo esc_html( (string) $hero['title'] ); ?></h1>
			<?php if ( ! empty( $hero['text'] ) ) : ?>
				<p class="ac-tech-svc-montaj-hero__text"><?php echo esc_html( (string) $hero['text'] ); ?></p>
			<?php endif; ?>
			<div class="ac-tech-svc-montaj-hero__actions">
				<?php if ( ! empty( $hero['cta_url'] ) && ! empty( $hero['cta_label'] ) ) : ?>
					<a class="ac-tech-btn ac-tech-btn--primary" href="<?php echo esc_url( (string) $hero['cta_url'] ); ?>">
						<?php echo esc_html( (string) $hero['cta_label'] ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $hero['phone'] ) ) : ?>
					<a class="ac-tech-btn ac-tech-btn--secondary" href="<?php echo esc_url( 'tel:' . (string) $hero['phone'] ); ?>">
						<?php ac_tech_icon( 'phone_in_talk' ); ?>
						<?php echo esc_html( (string) $hero['phone_label'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( ! empty( $hero['image'] ) ) : ?>
			<div class="ac-tech-svc-montaj-hero__media">
				<?php echo ac_tech_responsive_image( $hero['image'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="ac-tech-svc-montaj-section" aria-labelledby="ac-tech-svc-montaj-includes-title">
	<div class="ac-tech-container">
		<div class="ac-tech-svc-montaj-section__header">
			<h2 id="ac-tech-svc-montaj-includes-title" class="ac-tech-svc-montaj-section__title"><?php echo esc_html( $inc_head['title'] ); ?></h2>
			<p class="ac-tech-svc-montaj-section__lead"><?php echo esc_html( $inc_head['text'] ); ?></p>
		</div>
		<div class="ac-tech-svc-montaj-includes">
			<?php foreach ( $includes as $item ) : ?>
				<article class="ac-tech-svc-montaj-include">
					<?php ac_tech_icon( (string) ( $item['icon'] ?? 'check_circle' ), 'ac-tech-svc-montaj-include__icon' ); ?>
					<h3 class="ac-tech-svc-montaj-include__title"><?php echo esc_html( (string) $item['title'] ); ?></h3>
					<p class="ac-tech-svc-montaj-include__text"><?php echo esc_html( (string) $item['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ac-tech-svc-montaj-section ac-tech-svc-montaj-section--alt" aria-labelledby="ac-tech-svc-montaj-pricing-title">
	<div class="ac-tech-container">
		<div class="ac-tech-svc-montaj-section__header ac-tech-svc-montaj-section__header--center">
			<h2 id="ac-tech-svc-montaj-pricing-title" class="ac-tech-svc-montaj-section__title"><?php echo esc_html( $price_h['title'] ); ?></h2>
			<p class="ac-tech-svc-montaj-section__lead"><?php echo esc_html( $price_h['text'] ); ?></p>
		</div>
		<div class="ac-tech-svc-montaj-table-wrap">
			<table class="ac-tech-svc-montaj-table">
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Capacitate', 'ac-tech' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Cu kit (max. 3 m)', 'ac-tech' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Fără kit', 'ac-tech' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( (string) $row['capacity'] ); ?></th>
							<td><?php echo esc_html( (string) $row['with_kit'] ); ?></td>
							<td><?php echo esc_html( (string) $row['no_kit'] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<section class="ac-tech-svc-montaj-section" aria-labelledby="ac-tech-svc-montaj-zones-title">
	<div class="ac-tech-container">
		<div class="ac-tech-svc-montaj-section__header ac-tech-svc-montaj-section__header--center">
			<h2 id="ac-tech-svc-montaj-zones-title" class="ac-tech-svc-montaj-section__title"><?php echo esc_html( $zone_h['title'] ); ?></h2>
			<p class="ac-tech-svc-montaj-section__lead"><?php echo esc_html( $zone_h['text'] ); ?></p>
		</div>
		<ul class="ac-tech-svc-montaj-zones">
			<?php foreach ( $zones as $zone ) : ?>
				<li class="ac-tech-svc-montaj-zones__item">
					<a href="<?php echo esc_url( '#zone-' . (string) $zone['slug'] ); ?>">
						<?php
						/* translators: %s: sector or area name */
						printf( esc_html__( 'Montaj aer condiționat %s', 'ac-tech' ), esc_html( (string) $zone['label'] ) );
						?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<p class="ac-tech-svc-montaj-zones__note">
			<?php esc_html_e( 'Acoperim toate sectoarele municipiului București și localitățile din județul Ilfov. Pentru zone limitrofe, contactează-ne pentru confirmare rapidă.', 'ac-tech' ); ?>
		</p>
	</div>
</section>

<section class="ac-tech-svc-montaj-cta" aria-labelledby="ac-tech-svc-montaj-cta-title">
	<div class="ac-tech-container ac-tech-svc-montaj-cta__inner">
		<h2 id="ac-tech-svc-montaj-cta-title" class="ac-tech-svc-montaj-cta__title"><?php echo esc_html( (string) $cta['title'] ); ?></h2>
		<p class="ac-tech-svc-montaj-cta__text"><?php echo esc_html( (string) $cta['text'] ); ?></p>
		<div class="ac-tech-svc-montaj-cta__actions">
			<?php if ( ! empty( $cta['cta_url'] ) ) : ?>
				<a class="ac-tech-btn ac-tech-btn--primary" href="<?php echo esc_url( (string) $cta['cta_url'] ); ?>">
					<?php echo esc_html( (string) $cta['cta_label'] ); ?>
				</a>
			<?php endif; ?>
			<?php if ( ! empty( $cta['phone'] ) ) : ?>
				<a class="ac-tech-btn ac-tech-btn--secondary" href="<?php echo esc_url( 'tel:' . (string) $cta['phone'] ); ?>">
					<?php esc_html_e( 'Sună pentru ofertă', 'ac-tech' ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php if ( function_exists( 'ac_tech_render_gbp_review_cta' ) ) : ?>
			<?php ac_tech_render_gbp_review_cta( 'ac-tech-svc-montaj-cta__review' ); ?>
		<?php endif; ?>
	</div>
</section>
