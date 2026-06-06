<?php
/**
 * Site footer — from home.html.
 *
 * @package AC-Tech
 */

$site_name   = get_bloginfo( 'name', 'display' );
$address     = function_exists( 'ac_tech_get_business_address_line' ) ? ac_tech_get_business_address_line() : '';
$phone       = function_exists( 'ac_tech_get_business_phone_display' ) ? ac_tech_get_business_phone_display() : '';
$phone_tel   = function_exists( 'ac_tech_get_business_phone_tel' ) ? ac_tech_get_business_phone_tel() : '';
$email       = function_exists( 'ac_tech_get_business_email' ) ? ac_tech_get_business_email() : get_option( 'admin_email' );
$schedule    = function_exists( 'ac_tech_get_business_info' ) ? (string) ( ac_tech_get_business_info()['schedule'] ?? '' ) : '';
$maps_url    = function_exists( 'ac_tech_get_business_info' ) ? (string) ( ac_tech_get_business_info()['maps_url'] ?? '' ) : '';
$montaj_url  = function_exists( 'ac_tech_get_montaj_page_url' ) ? ac_tech_get_montaj_page_url() : home_url( '/montaj-aer-conditionat-bucuresti/' );
$igien_url   = function_exists( 'ac_tech_get_igienizare_page_url' ) ? ac_tech_get_igienizare_page_url() : home_url( '/igienizare-ac/' );
$services_url = function_exists( 'ac_tech_get_services_page_url' ) ? ac_tech_get_services_page_url() : home_url( '/servicii/' );
$booking_url = function_exists( 'ac_tech_get_booking_url' ) ? ac_tech_get_booking_url() : home_url( '/programare/' );
?>
<footer id="colophon" class="site-footer ac-tech-site-footer">
	<div class="ac-tech-site-footer__inner ac-tech-container">
		<div class="ac-tech-site-footer__grid">
			<div class="ac-tech-site-footer__brand">
				<a class="ac-tech-site-footer__brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php ac_tech_render_brand_logo(); ?>
					<span class="ac-tech-site-footer__brand-name"><?php echo esc_html( $site_name ); ?></span>
				</a>
				<p class="ac-tech-site-footer__tagline"><?php esc_html_e( 'Partenerul tău de încredere pentru climatizare inteligentă și aer curat în București și Ilfov.', 'ac-tech' ); ?></p>
			</div>

			<div class="ac-tech-site-footer__column">
				<h2 class="ac-tech-site-footer__column-title"><?php esc_html_e( 'Servicii', 'ac-tech' ); ?></h2>
				<ul class="ac-tech-site-footer__links">
					<li><a href="<?php echo esc_url( $montaj_url ); ?>"><?php esc_html_e( 'Montaj aer condiționat', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( $igien_url ); ?>"><?php esc_html_e( 'Igienizare AC', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( $services_url ); ?>"><?php esc_html_e( 'Prețuri & servicii', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( $booking_url ); ?>"><?php esc_html_e( 'Programare online', 'ac-tech' ); ?></a></li>
				</ul>
			</div>

			<div class="ac-tech-site-footer__column">
				<h2 class="ac-tech-site-footer__column-title"><?php esc_html_e( 'Companie', 'ac-tech' ); ?></h2>
				<ul class="ac-tech-site-footer__links">
					<li><a href="<?php echo esc_url( home_url( '/despre-noi/' ) ); ?>"><?php esc_html_e( 'Despre noi', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/termeni-si-conditii/' ) ); ?>"><?php esc_html_e( 'Termeni și condiții', 'ac-tech' ); ?></a></li>
				</ul>
			</div>

			<div class="ac-tech-site-footer__column">
				<h2 class="ac-tech-site-footer__column-title"><?php esc_html_e( 'Contact', 'ac-tech' ); ?></h2>
				<ul class="ac-tech-site-footer__links ac-tech-site-footer__links--icons">
					<?php if ( $email ) : ?>
						<li><?php ac_tech_icon( 'mail', 'ac-tech-site-footer__icon' ); ?> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
					<?php endif; ?>
					<?php if ( $phone && $phone_tel ) : ?>
						<li><?php ac_tech_icon( 'phone_in_talk', 'ac-tech-site-footer__icon' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone_tel ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
					<?php if ( $address ) : ?>
						<li>
							<?php ac_tech_icon( 'location_on', 'ac-tech-site-footer__icon' ); ?>
							<?php if ( $maps_url && wp_http_validate_url( $maps_url ) ) : ?>
								<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $address ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $address ); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( $schedule ) : ?>
						<li><?php ac_tech_icon( 'schedule', 'ac-tech-site-footer__icon' ); ?> <?php echo esc_html( $schedule ); ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<?php if ( function_exists( 'ac_tech_render_gbp_review_cta' ) ) : ?>
			<?php ac_tech_render_gbp_review_cta( 'ac-tech-site-footer__review' ); ?>
		<?php endif; ?>

		<div class="ac-tech-site-footer__bottom">
			<p class="ac-tech-site-footer__copyright">
				<?php
				printf(
					/* translators: 1: year, 2: site name */
					esc_html__( '© %1$s %2$s. Toate drepturile rezervate.', 'ac-tech' ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( $site_name )
				);
				?>
			</p>
		</div>
	</div>
</footer>
