<?php
/**
 * Optional intro — uses front page content from the editor when set.
 *
 * @package AC-Tech
 */

if ( ! is_front_page() ) {
	return;
}

$front_page_id = (int) get_option( 'page_on_front' );
if ( ! $front_page_id ) {
	return;
}

$page = get_post( $front_page_id );
if ( ! $page || empty( $page->post_content ) ) {
	return;
}
?>
<section class="ac-tech-section ac-tech-intro">
	<div class="ac-tech-container ac-tech-content">
		<?php echo apply_filters( 'the_content', $page->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
