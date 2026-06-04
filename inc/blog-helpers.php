<?php
/**
 * Blog template helpers.
 *
 * @package AC-Tech
 */

/**
 * Whether the current view is the styled blog listing.
 *
 * @return bool
 */
function ac_tech_is_blog_view() {
	return is_home() || is_category() || is_tag();
}

/**
 * Primary category for a post (first assigned).
 *
 * @param int $post_id Post ID.
 * @return WP_Term|null
 */
function ac_tech_get_post_primary_category( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$terms   = get_the_category( $post_id );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	return $terms[0];
}

/**
 * Formatted post date for blog cards.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function ac_tech_get_blog_post_date( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	return get_the_date( 'j F Y', $post_id );
}

/**
 * Author label for blog cards.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function ac_tech_get_blog_author_label( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	return get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) );
}

/**
 * Render post thumbnail or placeholder.
 *
 * @param string $class CSS class.
 * @param string $size  Image size.
 */
function ac_tech_render_blog_thumbnail( $class = '', $size = 'large' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail(
			$size,
			array(
				'class'   => trim( 'ac-tech-blog-card__image ' . $class ),
				'loading' => 'lazy',
				'decoding'=> 'async',
			)
		);
		return;
	}

	printf(
		'<div class="ac-tech-blog-card__placeholder %s" aria-hidden="true"></div>',
		esc_attr( trim( 'ac-tech-blog-card__image ' . $class ) )
	);
}

/**
 * Render meta line (date + category).
 *
 * @param array<string, bool> $args link_category — false inside a parent post link (avoids nested anchors).
 */
function ac_tech_render_blog_meta( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'link_category' => true,
		)
	);

	$category = ac_tech_get_post_primary_category();
	?>
	<div class="ac-tech-blog-card__meta">
		<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( ac_tech_get_blog_post_date() ); ?></time>
		<?php if ( $category ) : ?>
			<span class="ac-tech-blog-card__meta-dot" aria-hidden="true"></span>
			<?php if ( $args['link_category'] ) : ?>
				<a class="ac-tech-blog-card__category" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
			<?php else : ?>
				<span class="ac-tech-blog-card__category"><?php echo esc_html( $category->name ); ?></span>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php
}
