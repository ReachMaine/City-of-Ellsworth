<?php /* custom code for searchwp */

// Link directly to Media files instead of Attachment pages in search results
function my_search_media_direct_link( $permalink, $post ) {
	if ( is_search() && 'attachment' === get_post_type( $post ) ) {
		$permalink = wp_get_attachment_url( $post->ID );
	}
	return esc_url( $permalink );
}
add_filter( 'the_permalink', 'my_search_media_direct_link', 10, 2 );

/* ***** function used on search.php page.  *** */
/* get_doc_link */
function get_lsrvdoc_link($docid) {
	if (get_post_meta( $docid, 'meta_document_file_location', true ) === '' ) {
		$document_file_location = 'local';
	} else {
		get_post_meta( $docid, 'meta_document_file_location', true );
	}
	$document_file_location = get_post_meta( $docid, 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( $docid, 'meta_document_file_location', true ); 
	if ( $document_file_location === 'external' ) {
		$document_link = get_post_meta( $docid, 'meta_document_external_file_url', true );
	} else {
		$document_file = get_post_meta( $docid, 'meta_document_file', true);
		if (is_array($document_file)) {
			reset( $document_file );
			$document_id = key( $document_file );
			$document_link = reset( $document_file );
		}
	}
	//return($document_file);
	return($document_link);

}

function get_lsrvdoc_linkid($docid) {
	if (get_post_meta( $docid, 'meta_document_file_location', true ) === '' ) {
		$document_file_location = 'local';
	} else {
		get_post_meta( $docid, 'meta_document_file_location', true );
	}
	$document_file_location = get_post_meta( $docid, 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( $docid, 'meta_document_file_location', true ); 
	if ( $document_file_location === 'external' ) {
		$document_file = get_post_meta( $docid, 'meta_document_external_file_url', true );
		$document_link = $document_file;
	} else {
		$document_file = get_post_meta( $docid, 'meta_document_file', true);
	}
	if (is_array($document_file)) {
		reset( $document_file );
		$document_id = key( $document_file );
	} else {
		$document_id = "not an array";
	}
	//return ($document_link);
	return($document_id);

}


/* find a lsrvdocument from a file attachment ID */
/* currently resets the $post */
function get_attachment_lsrvdoc($attid) {
	$return_id = "";
	$args = array(
	'post_type'		=>	'lsvrdocument',
	//'meta_key' => 'meta_document_file',
	
	'meta_query'	=>	array(
			array(
				'key' => 'meta_document_file',
				'value'	=>	'a:1:{i:'.$attid.';',
				'compare' => 'LIKE',
			)
		)
	);
	$my_query = new WP_Query( $args );
	//echo "<pre>"; var_dump($my_query); echo "</pre>";
	$return_id = "";
	while ( $my_query->have_posts() ) : $my_query->the_post(); 		
		
		$return_id = get_the_id();
		//$return_post = $post;
	endwhile;
	//wp_reset_postdata();
	return $return_id;
}
// returns the title of the document with size & icon if possible
function get_lrsvdoc_pretty_title($docid) {
	$return_html = "";
	return ($return_html);
}