<?php
/**
 * Site header — based on home.html glass navigation.
 *
 * @package AC-Tech
 */

$contact_url = function_exists( 'ac_tech_get_booking_url' ) ? ac_tech_get_booking_url() : home_url( '/contact/' );
$cta_label   = apply_filters( 'ac_tech_header_cta_label', __( 'Programează acum', 'ac-tech' ) );
$phone       = function_exists( 'ac_tech_get_business_phone_display' ) ? ac_tech_get_business_phone_display() : '';
$phone_tel   = function_exists( 'ac_tech_get_business_phone_tel' ) ? ac_tech_get_business_phone_tel() : '';
$site_name   = get_bloginfo( 'name', 'display' );
?>
<header id="masthead" class="site-header ac-tech-site-header">
	<div class="ac-tech-site-header__inner ac-tech-container">
		<a class="ac-tech-site-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				ac_tech_render_brand_logo();
			}
			?>
			<p class="ac-tech-site-header__title"><?php echo esc_html( $site_name ); ?></p>
		</a>

		<nav id="site-navigation" class="main-navigation ac-tech-site-header__nav" aria-label="<?php esc_attr_e( 'Navigare principală', 'ac-tech' ); ?>">
			<button class="menu-toggle ac-tech-site-header__toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Deschide meniul', 'ac-tech' ); ?></span>
				<span class="ac-tech-site-header__toggle-bar" aria-hidden="true"></span>
				<span class="ac-tech-site-header__toggle-bar" aria-hidden="true"></span>
				<span class="ac-tech-site-header__toggle-bar" aria-hidden="true"></span>
			</button>
			<div class="ac-tech-site-header__drawer">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'ac-tech-site-header__menu',
						'container'      => false,
						'fallback_cb'    => 'ac_tech_primary_nav_fallback',
						'depth'          => 0,
					)
				);
				?>
				<?php if ( $cta_label ) : ?>
					<div class="ac-tech-site-header__actions">
						<?php if ( $phone && $phone_tel ) : ?>
							<a class="ac-tech-site-header__phone" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone_tel ) ); ?>">
								<?php ac_tech_icon( 'phone_in_talk' ); ?>
								<span><?php echo esc_html( $phone ); ?></span>
							</a>
						<?php endif; ?>
						<a class="ac-tech-btn ac-tech-btn--primary ac-tech-site-header__cta" href="<?php echo esc_url( $contact_url ); ?>">
							<?php echo esc_html( $cta_label ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</nav>
	</div>
</header>
