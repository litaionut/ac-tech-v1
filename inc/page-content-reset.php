<?php
/**
 * Reset all page content and custom fields (ACF, featured image, etc.).
 *
 * @package AC-Tech
 */

/**
 * Meta keys to keep when clearing page content.
 *
 * @return string[]
 */
function ac_tech_page_meta_keys_to_keep() {
	return array(
		'_edit_lock',
		'_edit_last',
		'_wp_page_template',
		'_wp_trash_meta_status',
		'_wp_trash_meta_comments_status',
		'_wp_desired_post_slug',
	);
}

/**
 * Meta keys (with leading underscore) that should still be removed.
 *
 * @return string[]
 */
function ac_tech_page_meta_keys_to_remove() {
	return array(
		'_thumbnail_id',
		'_elementor_data',
		'_elementor_edit_mode',
		'_elementor_template_type',
		'_elementor_version',
	);
}

/**
 * Clear text/content from every page while keeping page records and templates.
 *
 * @return array{pages:int,meta:int,revisions:int}
 */
function ac_tech_reset_all_page_content() {
	$page_ids = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'posts_per_page'         => -1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$keep_keys   = ac_tech_page_meta_keys_to_keep();
	$remove_keys = ac_tech_page_meta_keys_to_remove();
	$meta_removed = 0;
	$pages_updated = 0;

	foreach ( $page_ids as $page_id ) {
		$page_id = (int) $page_id;

		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_content' => '',
				'post_excerpt' => '',
			),
			true
		);
		++$pages_updated;

		$meta_keys = get_post_custom_keys( $page_id );
		if ( ! is_array( $meta_keys ) ) {
			continue;
		}

		foreach ( $meta_keys as $meta_key ) {
			if ( in_array( $meta_key, $keep_keys, true ) ) {
				continue;
			}

			$should_remove = in_array( $meta_key, $remove_keys, true ) || 0 !== strpos( $meta_key, '_' );

			if ( $should_remove ) {
				delete_post_meta( $page_id, $meta_key );
				++$meta_removed;
			}
		}
	}

	$revisions_deleted = 0;
	$revision_ids      = get_posts(
		array(
			'post_type'      => 'revision',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'post_parent__in' => $page_ids,
		)
	);

	foreach ( $revision_ids as $revision_id ) {
		if ( wp_delete_post_revision( $revision_id ) ) {
			++$revisions_deleted;
		}
	}

	return array(
		'pages'     => $pages_updated,
		'meta'      => $meta_removed,
		'revisions' => $revisions_deleted,
	);
}
