<?php
/**
 * Contact details sidebar block.
 *
 * @package AC-Tech
 */

$info = function_exists( 'ac_tech_get_contact_info' ) ? ac_tech_get_contact_info() : array();

$section_title = isset( $info['title'] ) ? $info['title'] : '';
$email         = isset( $info['email'] ) ? $info['email'] : '';
$phone         = isset( $info['phone'] ) ? $info['phone'] : '';
$schedule      = isset( $info['schedule'] ) ? $info['schedule'] : '';
$address       = isset( $info['address'] ) ? $info['address'] : '';
$maps_url      = function_exists( 'ac_tech_get_business_info' ) ? (string) ( ac_tech_get_business_info()['maps_url'] ?? '' ) : '';

if ( '' === $section_title && '' === $email && '' === $phone && '' === $schedule && '' === $address ) {
	return;
}
?>
<aside class="ac-tech-contact-info" aria-labelledby="ac-tech-contact-info-title">
	<?php if ( $section_title ) : ?>
		<h2 id="ac-tech-contact-info-title" class="ac-tech-contact-info__title">
			<?php echo esc_html( $section_title ); ?>
		</h2>
	<?php endif; ?>

	<ul class="ac-tech-contact-info__list">
		<?php if ( $email ) : ?>
			<li>
				<span class="ac-tech-contact-info__label"><?php esc_html_e( 'Email', 'ac-tech' ); ?></span>
				<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
			</li>
		<?php endif; ?>
		<?php if ( $phone ) : ?>
			<li>
				<span class="ac-tech-contact-info__label"><?php esc_html_e( 'Telefon', 'ac-tech' ); ?></span>
				<?php
				$tel = function_exists( 'ac_tech_get_business_phone_tel' ) ? ac_tech_get_business_phone_tel() : preg_replace( '/\s+/', '', $phone );
				?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $tel ) ); ?>"><?php echo esc_html( $phone ); ?></a>
			</li>
		<?php endif; ?>
		<?php if ( $address ) : ?>
			<li>
				<span class="ac-tech-contact-info__label"><?php esc_html_e( 'Adresă', 'ac-tech' ); ?></span>
				<?php if ( $maps_url && wp_http_validate_url( $maps_url ) ) : ?>
					<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $address ); ?></a>
				<?php else : ?>
					<span><?php echo esc_html( $address ); ?></span>
				<?php endif; ?>
			</li>
		<?php endif; ?>
		<?php if ( $schedule ) : ?>
			<li>
				<span class="ac-tech-contact-info__label"><?php esc_html_e( 'Program', 'ac-tech' ); ?></span>
				<span><?php echo esc_html( $schedule ); ?></span>
			</li>
		<?php endif; ?>
	</ul>
</aside>
