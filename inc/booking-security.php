<?php
/**
 * Booking security — rate limit and reservations toggle.
 *
 * @package AC-Tech
 */

define( 'AC_TECH_BOOKING_RATE_LIMIT_MAX', 5 );
define( 'AC_TECH_BOOKING_RATE_LIMIT_WINDOW', HOUR_IN_SECONDS );
define( 'AC_TECH_BOOKING_RESERVATIONS_OPTION', 'ac_tech_booking_reservations_open' );

/**
 * @return string
 */
function ac_tech_booking_get_client_ip() {
	$ip = '';

	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$parts = explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
		$ip    = trim( (string) $parts[0] );
	} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}

	if ( ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
		$ip = '0.0.0.0';
	}

	return $ip;
}

/**
 * @param string $ip Client IP.
 * @return string
 */
function ac_tech_booking_rate_limit_transient_key( $ip ) {
	return 'ac_tech_booking_rl_' . md5( (string) $ip );
}

/**
 * @return array{count: int, started: int}|null
 */
function ac_tech_booking_rate_limit_get_state() {
	$ip   = ac_tech_booking_get_client_ip();
	$key  = ac_tech_booking_rate_limit_transient_key( $ip );
	$data = get_transient( $key );

	if ( ! is_array( $data ) ) {
		return null;
	}

	$started = (int) ( $data['started'] ?? 0 );
	$count   = (int) ( $data['count'] ?? 0 );

	if ( $started <= 0 || ( time() - $started ) >= AC_TECH_BOOKING_RATE_LIMIT_WINDOW ) {
		delete_transient( $key );
		return null;
	}

	return array(
		'count'   => $count,
		'started' => $started,
	);
}

/**
 * @return true|WP_Error
 */
function ac_tech_booking_rate_limit_check() {
	$state = ac_tech_booking_rate_limit_get_state();

	if ( $state && $state['count'] >= AC_TECH_BOOKING_RATE_LIMIT_MAX ) {
		return new WP_Error(
			'rate_limited',
			__( 'Ai atins limita de 5 programări pe oră. Încearcă din nou mai târziu.', 'ac-tech' ),
			array( 'status' => 429 )
		);
	}

	return true;
}

/**
 * Record one booking submission attempt for the current IP.
 */
function ac_tech_booking_rate_limit_record_attempt() {
	$ip    = ac_tech_booking_get_client_ip();
	$key   = ac_tech_booking_rate_limit_transient_key( $ip );
	$state = ac_tech_booking_rate_limit_get_state();

	if ( null === $state ) {
		$state = array(
			'count'   => 1,
			'started' => time(),
		);
	} else {
		$state['count']++;
	}

	$ttl = max( 60, AC_TECH_BOOKING_RATE_LIMIT_WINDOW - ( time() - (int) $state['started'] ) );
	set_transient( $key, $state, $ttl );
}

/**
 * Read reservations flag from ACF/meta without treating false/0 as empty.
 *
 * @return bool|null Null when unset.
 */
function ac_tech_booking_reservations_read_acf_flag() {
	$page_id = ac_tech_get_booking_settings_id();
	if ( $page_id <= 0 ) {
		return null;
	}

	$meta = get_post_meta( $page_id, 'booking_reservations_enabled', true );
	if ( '' !== $meta && null !== $meta ) {
		return (bool) (int) $meta;
	}

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( 'booking_reservations_enabled', $page_id );
		if ( null !== $value && '' !== $value ) {
			return (bool) $value;
		}
	}

	return null;
}

/**
 * @return bool
 */
function ac_tech_booking_reservations_are_open() {
	$stored = get_option( AC_TECH_BOOKING_RESERVATIONS_OPTION, null );
	if ( null !== $stored ) {
		return (bool) (int) $stored;
	}

	$acf_flag = ac_tech_booking_reservations_read_acf_flag();
	if ( null !== $acf_flag ) {
		return $acf_flag;
	}

	return true;
}

/**
 * @param bool $open Whether reservations are accepted.
 * @return bool
 */
function ac_tech_set_booking_reservations_open( $open ) {
	$open    = (bool) $open;
	$stored  = $open ? 1 : 0;
	$saved   = update_option( AC_TECH_BOOKING_RESERVATIONS_OPTION, $stored, false );
	$page_id = ac_tech_get_booking_settings_id();

	if ( $page_id > 0 ) {
		update_post_meta( $page_id, 'booking_reservations_enabled', $stored );

		if ( function_exists( 'update_field' ) ) {
			update_field( 'field_ac_tech_booking_reservations_enabled', $stored, $page_id );
		}
	}

	return false !== $saved;
}

/**
 * Keep wp_option in sync when the ACF toggle is saved on the settings page.
 *
 * @param int|string $post_id Post ID.
 */
function ac_tech_sync_booking_reservations_option_from_acf( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id !== ac_tech_get_booking_settings_id() ) {
		return;
	}

	$flag = ac_tech_booking_reservations_read_acf_flag();
	if ( null === $flag ) {
		return;
	}

	update_option( AC_TECH_BOOKING_RESERVATIONS_OPTION, $flag ? 1 : 0, false );
}
add_action( 'acf/save_post', 'ac_tech_sync_booking_reservations_option_from_acf', 20 );

/**
 * Admin banner + toggle on booking screens.
 */
function ac_tech_booking_admin_reservations_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen ) {
		return;
	}

	$allowed = array( 'edit-ac_booking', 'ac_booking', 'ac_booking_page_ac-tech-booking-calendar' );
	if ( ! in_array( $screen->id, $allowed, true ) ) {
		return;
	}

	if ( isset( $_GET['reservations_toggled'] ) ) {
		$is_open = ac_tech_booking_reservations_are_open();
		?>
		<div class="notice notice-success is-dismissible">
			<p>
				<?php
				echo esc_html(
					$is_open
						? __( 'Rezervările online au fost deschise.', 'ac-tech' )
						: __( 'Rezervările online au fost oprite.', 'ac-tech' )
				);
				?>
			</p>
		</div>
		<?php
	}

	$open = ac_tech_booking_reservations_are_open();

	if ( $open ) {
		$class   = 'notice notice-success';
		$message = __( 'Rezervările online sunt <strong>deschise</strong>. Vizitatorii pot trimite programări.', 'ac-tech' );
		$label   = __( 'Oprește rezervările', 'ac-tech' );
		$state   = '0';
	} else {
		$class   = 'notice notice-warning';
		$message = __( 'Rezervările online sunt <strong>oprite</strong>. Formularul nu acceptă programări noi.', 'ac-tech' );
		$label   = __( 'Deschide rezervările', 'ac-tech' );
		$state   = '1';
	}

	$url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'ac_tech_toggle_booking_reservations',
				'state'  => $state,
			),
			admin_url( 'admin-post.php' )
		),
		'ac_tech_toggle_booking_reservations'
	);
	?>
	<div class="<?php echo esc_attr( $class ); ?> ac-tech-booking-reservations-notice">
		<p>
			<?php echo wp_kses_post( $message ); ?>
			<a href="<?php echo esc_url( $url ); ?>" class="button button-secondary" style="margin-left: 0.75rem;">
				<?php echo esc_html( $label ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'ac_tech_booking_admin_reservations_notice' );

/**
 * Toggle reservations open/closed from admin button.
 */
function ac_tech_handle_toggle_booking_reservations() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Nu ai permisiunea necesară.', 'ac-tech' ) );
	}

	check_admin_referer( 'ac_tech_toggle_booking_reservations' );

	$state = isset( $_GET['state'] ) ? (int) $_GET['state'] : 1;
	ac_tech_set_booking_reservations_open( (bool) $state );

	$redirect = wp_get_referer();
	if ( ! $redirect ) {
		$redirect = admin_url( 'edit.php?post_type=ac_booking' );
	}

	$redirect = remove_query_arg( 'reservations_toggled', $redirect );
	$redirect = add_query_arg( 'reservations_toggled', '1', $redirect );

	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_post_ac_tech_toggle_booking_reservations', 'ac_tech_handle_toggle_booking_reservations' );

/**
 * One-time migration: sync option from existing ACF/meta value.
 */
function ac_tech_maybe_migrate_booking_reservations_option() {
	if ( null !== get_option( AC_TECH_BOOKING_RESERVATIONS_OPTION, null ) ) {
		return;
	}

	$acf_flag = ac_tech_booking_reservations_read_acf_flag();
	if ( null === $acf_flag ) {
		return;
	}

	update_option( AC_TECH_BOOKING_RESERVATIONS_OPTION, $acf_flag ? 1 : 0, false );
}
add_action( 'init', 'ac_tech_maybe_migrate_booking_reservations_option', 5 );
