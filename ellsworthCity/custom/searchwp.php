<?php /* custom code for searchwp */

// Link directly to Media files instead of Attachment pages in search results
function my_search_media_direct_link( $permalink, $post ) {
	if ( is_search() && 'attachment' === get_post_type( $post ) ) {
		$permalink = wp_get_attachment_url( $post->ID );
	}
	return esc_url( $permalink );
}
add_filter( 'the_permalink', 'my_search_media_direct_link', 10, 2 );