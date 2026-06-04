<?php
/**
 * Site footer — from home.html.
 *
 * @package AC-Tech
 */

$site_name = get_bloginfo( 'name', 'display' );
?>
<footer id="colophon" class="site-footer ac-tech-site-footer">
	<div class="ac-tech-site-footer__inner ac-tech-container">
		<div class="ac-tech-site-footer__grid">
			<div class="ac-tech-site-footer__brand">
				<a class="ac-tech-site-footer__brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php ac_tech_render_brand_logo(); ?>
					<span class="ac-tech-site-footer__brand-name"><?php echo esc_html( $site_name ); ?></span>
				</a>
				<p class="ac-tech-site-footer__tagline"><?php esc_html_e( 'Partenerul tău de încredere pentru climatizare inteligentă și aer curat în toată România.', 'ac-tech' ); ?></p>
			</div>

			<div class="ac-tech-site-footer__column">
				<h2 class="ac-tech-site-footer__column-title"><?php esc_html_e( 'Servicii', 'ac-tech' ); ?></h2>
				<ul class="ac-tech-site-footer__links">
					<li><a href="<?php echo esc_url( home_url( '/#servicii' ) ); ?>"><?php esc_html_e( 'Instalare', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#servicii' ) ); ?>"><?php esc_html_e( 'Igienizare', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#servicii' ) ); ?>"><?php esc_html_e( 'Mentenanță', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#servicii' ) ); ?>"><?php esc_html_e( 'Diagnosticare', 'ac-tech' ); ?></a></li>
				</ul>
			</div>

			<div class="ac-tech-site-footer__column">
				<h2 class="ac-tech-site-footer__column-title"><?php esc_html_e( 'Companie', 'ac-tech' ); ?></h2>
				<ul class="ac-tech-site-footer__links">
					<li><a href="<?php echo esc_url( home_url( '/despre-noi/' ) ); ?>"><?php esc_html_e( 'Despre noi', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/servicii/' ) ); ?>"><?php esc_html_e( 'Prețuri', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'ac-tech' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/termeni-si-conditii/' ) ); ?>"><?php esc_html_e( 'Termeni și condiții', 'ac-tech' ); ?></a></li>
				</ul>
			</div>

			<div class="ac-tech-site-footer__column">
				<h2 class="ac-tech-site-footer__column-title"><?php esc_html_e( 'Contact', 'ac-tech' ); ?></h2>
				<ul class="ac-tech-site-footer__links ac-tech-site-footer__links--icons">
					<li><?php ac_tech_icon( 'mail', 'ac-tech-site-footer__icon' ); ?> <?php echo esc_html( get_option( 'admin_email' ) ); ?></li>
					<li><?php ac_tech_icon( 'location_on', 'ac-tech-site-footer__icon' ); ?> <?php esc_html_e( 'București, România', 'ac-tech' ); ?></li>
					<li><?php ac_tech_icon( 'schedule', 'ac-tech-site-footer__icon' ); ?> <?php esc_html_e( 'Luni-Vineri: 09:00 - 18:00', 'ac-tech' ); ?></li>
				</ul>
			</div>
		</div>

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
			<div class="ac-tech-site-footer__social">
				<a href="#" aria-label="<?php esc_attr_e( 'Website', 'ac-tech' ); ?>"><?php ac_tech_icon( 'language' ); ?></a>
				<a href="#" aria-label="<?php esc_attr_e( 'Social', 'ac-tech' ); ?>"><?php ac_tech_icon( 'public' ); ?></a>
				<a href="#" aria-label="<?php esc_attr_e( 'Recomandări', 'ac-tech' ); ?>"><?php ac_tech_icon( 'thumb_up' ); ?></a>
			</div>
		</div>
	</div>
</footer>
