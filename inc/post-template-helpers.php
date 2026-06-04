<?php
/**
 * Helpers for single post templates.
 *
 * @package AC-Tech
 */

/**
 * Current post template filename or empty.
 *
 * @return string
 */
function ac_tech_get_post_template_file() {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	$file = get_post_meta( get_queried_object_id(), '_wp_page_template', true );

	return ( is_string( $file ) && 'default' !== $file ) ? $file : '';
}

/**
 * Whether a styled post template is active.
 *
 * @return bool
 */
function ac_tech_is_styled_post_template() {
	$file = ac_tech_get_post_template_file();

	return in_array( $file, array_keys( ac_tech_get_post_templates() ), true );
}

/**
 * Estimated read time in minutes from post content length.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function ac_tech_get_post_read_time( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );

	if ( $words < 50 ) {
		return 8;
	}

	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Render hero/card image: featured image, theme WebP, or external fallback.
 *
 * @param array<string, mixed> $image   Image config from content file.
 * @param string               $class   Extra CSS class.
 * @param bool                 $prefer_featured Use post thumbnail when available.
 */
function ac_tech_render_post_image( $image, $class = '', $prefer_featured = true ) {
	$classes = trim( 'ac-tech-post-img ' . $class );

	if ( ! empty( $image['attachment_id'] ) ) {
		echo wp_get_attachment_image(
			(int) $image['attachment_id'],
			'large',
			false,
			array(
				'class'    => $classes,
				'loading'  => ! empty( $image['loading'] ) ? (string) $image['loading'] : 'lazy',
				'decoding' => 'async',
			)
		);
		return;
	}

	if ( $prefer_featured && has_post_thumbnail() ) {
		the_post_thumbnail(
			'large',
			array(
				'class'    => $classes,
				'loading'  => ! empty( $image['loading'] ) ? (string) $image['loading'] : 'lazy',
				'decoding' => 'async',
			)
		);
		return;
	}

	if ( ! empty( $image['slug'] ) && ! empty( $image['widths'] ) ) {
		$image['class'] = $classes;
		$html           = ac_tech_responsive_image( $image );
		if ( $html ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}
	}

	if ( ! empty( $image['external_url'] ) ) {
		printf(
			'<img class="%1$s" src="%2$s" alt="%3$s" width="%4$d" height="%5$d" loading="%6$s" decoding="async">',
			esc_attr( $classes ),
			esc_url( (string) $image['external_url'] ),
			esc_attr( isset( $image['alt'] ) ? (string) $image['alt'] : '' ),
			isset( $image['width'] ) ? (int) $image['width'] : 1200,
			isset( $image['height'] ) ? (int) $image['height'] : 800,
			! empty( $image['loading'] ) ? esc_attr( (string) $image['loading'] ) : 'lazy'
		);
		return;
	}

	printf( '<div class="%s ac-tech-post-img--placeholder" aria-hidden="true"></div>', esc_attr( $classes ) );
}

/**
 * Related posts query (same category, exclude current).
 *
 * @param int $count Number of posts.
 * @return WP_Post[]
 */
function ac_tech_get_related_posts( $count = 3 ) {
	$post_id    = get_the_ID();
	$categories = wp_get_post_categories( $post_id );

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => $count,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( ! empty( $categories ) ) {
		$args['category__in'] = $categories;
	}

	$query = new WP_Query( $args );

	return $query->have_posts() ? $query->posts : array();
}

/**
 * Render related post card (template 3).
 *
 * @param WP_Post $post Post object.
 */
function ac_tech_render_related_post_card( $post ) {
	$category = ac_tech_get_post_primary_category( $post->ID );
	?>
	<article class="ac-tech-post-t3-related__item">
		<a class="ac-tech-post-t3-related__link" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
			<div class="ac-tech-post-t3-related__media">
				<?php
				if ( has_post_thumbnail( $post ) ) {
					echo get_the_post_thumbnail(
						$post,
						'medium_large',
						array(
							'class'   => 'ac-tech-post-t3-related__image',
							'loading' => 'lazy',
							'decoding'=> 'async',
						)
					);
				} else {
					echo '<div class="ac-tech-post-t3-related__placeholder" aria-hidden="true"></div>';
				}
				?>
			</div>
			<?php if ( $category ) : ?>
				<span class="ac-tech-post-t3-related__tag"><?php echo esc_html( $category->name ); ?></span>
			<?php endif; ?>
			<h3 class="ac-tech-post-t3-related__title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
			<p class="ac-tech-post-t3-related__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 18 ) ); ?></p>
		</a>
	</article>
	<?php
}
