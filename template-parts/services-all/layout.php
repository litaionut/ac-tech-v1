<?php
/**
 * Services catalog — main items loop.
 *
 * @package AC-Tech
 */

$items = ac_tech_get_services_all_items();
?>
<div class="ac-tech-services-all ac-tech-container" aria-label="<?php esc_attr_e( 'Catalog servicii', 'ac-tech' ); ?>">
	<div class="ac-tech-services-all__stack">
		<?php
		$count = count( $items );
		for ( $i = 0; $i < $count; $i++ ) {
			$item = $items[ $i ];

			if ( 'card' === ( $item['layout'] ?? '' ) ) {
				$cards = array( $item );
				if ( isset( $items[ $i + 1 ] ) && 'card' === ( $items[ $i + 1 ]['layout'] ?? '' ) ) {
					$cards[] = $items[ $i + 1 ];
					$i++;
				}
				ac_tech_services_all_render_card_row( $cards );
				continue;
			}

			if ( 'panel' === ( $item['layout'] ?? '' ) ) {
				ac_tech_services_all_render_panel( $item );
				continue;
			}

			ac_tech_services_all_render_split( $item );
		}
		?>
	</div>
</div>
