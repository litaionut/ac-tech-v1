<?php
/**
 * Theme image helpers for self-hosted responsive WebP assets.
 *
 * @package AC-Tech
 */

/**
 * Base directory for theme images.
 *
 * @param string $dir Subdirectory under assets/images/.
 * @return string
 */
function ac_tech_theme_images_dir( $dir = 'home' ) {
	$dir = sanitize_file_name( $dir );

	return get_template_directory() . '/assets/images/' . $dir;
}

/**
 * Resolve image directory from config.
 *
 * @param array<string, mixed> $image Image config.
 * @return string
 */
function ac_tech_theme_image_dir_from_config( $image ) {
	return ! empty( $image['dir'] ) ? sanitize_file_name( (string) $image['dir'] ) : 'home';
}

/**
 * Build a theme image URL for a slug and width variant.
 *
 * @param string               $slug  Image slug without width suffix.
 * @param int                  $width Pixel width variant.
 * @param string               $dir   Image subdirectory.
 * @return string
 */
function ac_tech_theme_image_url( $slug, $width, $dir = 'home' ) {
	$filename = sanitize_file_name( $slug . '-' . (int) $width . '.webp' );
	$dir      = sanitize_file_name( $dir );
	$url      = get_template_directory_uri() . '/assets/images/' . $dir . '/' . $filename;

	if ( defined( '_S_VERSION' ) ) {
		$url = add_query_arg( 'v', _S_VERSION, $url );
	}

	return $url;
}

/**
 * Build srcset string from image config.
 *
 * @param array<string, mixed> $image Image config.
 * @return string
 */
function ac_tech_theme_image_srcset( $image ) {
	if ( empty( $image['slug'] ) || empty( $image['widths'] ) || ! is_array( $image['widths'] ) ) {
		return '';
	}

	$dir   = ac_tech_theme_image_dir_from_config( $image );
	$parts = array();

	foreach ( $image['widths'] as $width ) {
		$width = (int) $width;
		$file  = ac_tech_theme_images_dir( $dir ) . '/' . sanitize_file_name( $image['slug'] . '-' . $width . '.webp' );
		if ( ! file_exists( $file ) ) {
			continue;
		}
		$parts[] = esc_url( ac_tech_theme_image_url( $image['slug'], $width, $dir ) ) . ' ' . $width . 'w';
	}

	return implode( ', ', $parts );
}

/**
 * Available width variants that exist on disk.
 *
 * @param array<string, mixed> $image Image config.
 * @return int[]
 */
function ac_tech_theme_image_available_widths( $image ) {
	if ( empty( $image['slug'] ) || empty( $image['widths'] ) || ! is_array( $image['widths'] ) ) {
		return array();
	}

	$dir     = ac_tech_theme_image_dir_from_config( $image );
	$widths  = array_map( 'intval', $image['widths'] );
	$found   = array();

	foreach ( $widths as $width ) {
		$file = ac_tech_theme_images_dir( $dir ) . '/' . sanitize_file_name( $image['slug'] . '-' . $width . '.webp' );
		if ( file_exists( $file ) ) {
			$found[] = $width;
		}
	}

	sort( $found, SORT_NUMERIC );

	return $found;
}

/**
 * Resolve default src (prefers src_width, else largest existing variant).
 *
 * @param array<string, mixed> $image Image config.
 * @return string
 */
function ac_tech_theme_image_default_src( $image ) {
	$available = ac_tech_theme_image_available_widths( $image );

	if ( empty( $available ) ) {
		return '';
	}

	$dir = ac_tech_theme_image_dir_from_config( $image );

	if ( ! empty( $image['src_width'] ) ) {
		$preferred = (int) $image['src_width'];
		if ( in_array( $preferred, $available, true ) ) {
			return ac_tech_theme_image_url( $image['slug'], $preferred, $dir );
		}
	}

	$width = end( $available );

	return ac_tech_theme_image_url( $image['slug'], $width, $dir );
}

/**
 * Build shared <img> attributes for theme responsive images.
 *
 * @param array<string, mixed> $image Image config.
 * @return array<string, string|int>
 */
function ac_tech_responsive_image_attrs( $image ) {
	$src     = ac_tech_theme_image_default_src( $image );
	$srcset  = ac_tech_theme_image_srcset( $image );
	$classes = isset( $image['class'] ) ? (string) $image['class'] : '';

	$attrs = array(
		'src'      => $src,
		'srcset'   => $srcset,
		'alt'      => isset( $image['alt'] ) ? (string) $image['alt'] : '',
		'decoding' => 'async',
		'loading'  => isset( $image['loading'] ) ? (string) $image['loading'] : 'lazy',
	);

	if ( empty( $image['omit_dimensions'] ) ) {
		if ( ! empty( $image['width'] ) ) {
			$attrs['width'] = (int) $image['width'];
		}
		if ( ! empty( $image['height'] ) ) {
			$attrs['height'] = (int) $image['height'];
		}
	}

	if ( ! empty( $image['sizes'] ) ) {
		$attrs['sizes'] = (string) $image['sizes'];
	}

	if ( ! empty( $image['fetchpriority'] ) ) {
		$attrs['fetchpriority'] = (string) $image['fetchpriority'];
	}

	if ( '' !== $classes ) {
		$attrs['class'] = $classes;
	}

	return $attrs;
}

/**
 * Render <img> tag from attribute map.
 *
 * @param array<string, string|int> $attrs Attributes.
 * @return string
 */
function ac_tech_render_img_tag( $attrs ) {
	if ( empty( $attrs['src'] ) || empty( $attrs['srcset'] ) ) {
		return '';
	}

	$html = '<img';
	foreach ( $attrs as $name => $value ) {
		if ( 'src' === $name ) {
			$html .= sprintf( ' %s="%s"', esc_attr( $name ), esc_url( (string) $value ) );
			continue;
		}

		if ( 'srcset' === $name ) {
			$html .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( (string) $value ) );
			continue;
		}

		if ( in_array( $name, array( 'width', 'height' ), true ) ) {
			if ( (int) $value <= 0 ) {
				continue;
			}
			$html .= sprintf( ' %s="%d"', esc_attr( $name ), (int) $value );
			continue;
		}

		$html .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( (string) $value ) );
	}
	$html .= '>';

	return $html;
}

/**
 * Render hero-style <picture> with explicit desktop/mobile WebP sources.
 *
 * @param array<string, mixed> $image Image config.
 * @return string HTML or empty string.
 */
function ac_tech_responsive_image_picture( $image ) {
	$available = ac_tech_theme_image_available_widths( $image );
	if ( empty( $available ) || empty( $image['slug'] ) ) {
		return '';
	}

	$attrs = ac_tech_responsive_image_attrs( $image );
	if ( empty( $attrs['src'] ) ) {
		return '';
	}

	$dir  = ac_tech_theme_image_dir_from_config( $image );
	$slug = (string) $image['slug'];

	$html = '<picture>';
	if ( in_array( 1200, $available, true ) ) {
		$html .= sprintf(
			'<source media="(min-width: 64rem)" srcset="%s" />',
			esc_url( ac_tech_theme_image_url( $slug, 1200, $dir ) )
		);
	}
	if ( in_array( 800, $available, true ) ) {
		$html .= sprintf(
			'<source srcset="%s" />',
			esc_url( ac_tech_theme_image_url( $slug, 800, $dir ) )
		);
	}
	$html .= ac_tech_render_img_tag( $attrs );
	$html .= '</picture>';

	return $html;
}

/**
 * Render a responsive theme image.
 *
 * @param array<string, mixed> $image Image config.
 * @return string HTML or empty string.
 */
function ac_tech_responsive_image( $image ) {
	if ( empty( $image['slug'] ) || empty( $image['widths'] ) ) {
		return '';
	}

	if ( ! empty( $image['use_picture'] ) ) {
		return ac_tech_responsive_image_picture( $image );
	}

	$attrs = ac_tech_responsive_image_attrs( $image );

	return ac_tech_render_img_tag( $attrs );
}

/**
 * Preload LCP image for homepage or service pages.
 */
function ac_tech_preload_lcp_image() {
	if ( is_admin() ) {
		return;
	}

	$image = null;

	if ( is_front_page() ) {
		$hero = ac_tech_get_home_hero();
		if ( ! empty( $hero['image_attachment_id'] ) ) {
			$attachment_id = (int) $hero['image_attachment_id'];
			$src           = wp_get_attachment_image_url( $attachment_id, 'large' );
			if ( $src ) {
				$srcset = wp_get_attachment_image_srcset( $attachment_id, 'large' );
				if ( $srcset ) {
					$attrs = sprintf(
						'rel="preload" as="image" href="%1$s" imagesrcset="%2$s" imagesizes="(min-width: 64rem) 50vw, 100vw"',
						esc_url( $src ),
						esc_attr( $srcset )
					);
					printf( "<link %s>\n", $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
			return;
		}
		$image = ! empty( $hero['image'] ) ? $hero['image'] : null;
	} elseif ( ac_tech_is_igienizare_ac_page() ) {
		$hero  = ac_tech_get_service_igienizare_hero();
		$image = ! empty( $hero['image'] ) ? $hero['image'] : null;
	}

	if ( empty( $image ) || ! is_array( $image ) ) {
		return;
	}

	$srcset = ac_tech_theme_image_srcset( $image );
	$src    = ac_tech_theme_image_default_src( $image );

	if ( '' === $srcset || '' === $src ) {
		return;
	}

	$attrs = sprintf(
		'rel="preload" as="image" href="%1$s" imagesrcset="%2$s"',
		esc_url( $src ),
		esc_attr( $srcset )
	);

	if ( ! empty( $image['sizes'] ) ) {
		$attrs .= sprintf( ' imagesizes="%s"', esc_attr( $image['sizes'] ) );
	}

	printf( "<link %s>\n", $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
}
add_action( 'wp_head', 'ac_tech_preload_lcp_image', 2 );
