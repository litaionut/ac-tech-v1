<?php
/**
 * Blog category filter nav.
 *
 * @package AC-Tech
 */

$filters   = ac_tech_get_blog_filter_categories();
$blog_url  = ac_tech_get_blog_url();
$current   = is_category() ? get_queried_object() : null;
?>
<nav class="ac-tech-blog-filters" aria-label="<?php esc_attr_e( 'Filtre categorii blog', 'ac-tech' ); ?>">
	<a class="ac-tech-blog-filters__link<?php echo is_home() ? ' is-active' : ''; ?>" href="<?php echo esc_url( $blog_url ); ?>">
		<?php esc_html_e( 'Toate Articolele', 'ac-tech' ); ?>
	</a>
	<?php foreach ( $filters as $slug => $label ) : ?>
		<?php
		$term = get_category_by_slug( $slug );
		$url  = $term ? get_category_link( $term->term_id ) : add_query_arg( 'cat_preview', $slug, $blog_url );
		$active = $current instanceof WP_Term && $current->slug === $slug;
		?>
		<a class="ac-tech-blog-filters__link<?php echo $active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $url ); ?>">
			<?php echo esc_html( $label ); ?>
		</a>
	<?php endforeach; ?>
</nav>
