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

if ( '' === $section_title && '' === $email && '' === $phone && '' === $schedule ) {
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
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
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
