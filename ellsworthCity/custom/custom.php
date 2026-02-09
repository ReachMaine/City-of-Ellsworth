<?php
/* custom functions & shortcodes


/*  lsvrdocumentlist shortcode */

	 add_shortcode( 'lsvr_document', 'lsvr_document_shortcode' );
	 function lsvr_document_shortcode($atts) {
		$atts = shortcode_atts( array(
				'slug' => '',
				'title' => '',
				'show_filesize' => 'no',
                'show_icons' => 'no',
			), $atts, 'lsvr_document' );
		$htmlout = "";
		$slug = $atts['slug'];
        $show_filesize = esc_attr( $atts['show_filesize'] );
        $show_filesize = $show_filesize === 'yes' ? true : false;
        $show_icons = esc_attr( $atts['show_icons'] );
        $show_icons = $show_icons === 'yes' ? true : false;
        $today = current_time( 'Y-m-d H:i' );
        $title = $atts['title'];

		$q_args = array(
			'post_type' => 'lsvrdocument',
			'post_status' => array( 'publish' ),
			'suppress_filters' => false,
			//'include' => $doclist,
			'name' => $slug,
			'meta_query' => array(
				'relation' => 'OR',
					array( 'key' => 'meta_document_expiration_date',
						'value' => '',
						'compare' => 'NOT EXISTS',
					),
					array( 'key' => 'meta_document_expiration_date',
						'value' => '',
						'compare' => '=',
					),
					array( 'key' => 'meta_document_expiration_date',
						'value' => $today,
						'compare' => '>=',
						'type' => 'CHAR'
					)
			)
		);

		// GET POSTS
		$documents = get_posts( $q_args );
		if ( !empty( $documents ) ) {
			// should only be one, but JIC
			foreach ( $documents as $document ) {

				$htmlout .= "";
				$doc_title = $document->post_title; // defaults to document title.
				if ($title != "") {
					$doc_title = $title;
				}

				$document_file_location = get_post_meta( $document->ID, 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( $document->ID, 'meta_document_file_location', true );
				if ( $document_file_location === 'external' ) {
					$document_file = get_post_meta( $document->ID, 'meta_document_external_file_url', true );
				} else {
					$document_file = get_post_meta( $document->ID, 'meta_document_file', true );
				}
				//$htmlout .= "document file = {".$document_file."}";
				if ( ( $document_file_location === 'local' && is_array( $document_file ) ) || ( $document_file !== '' ) ) {

					$link_target = lsvr_get_field( 'document_new_tab_enable', true, true ) ? ' target="_blank"' : '';
					$document_file_location = get_post_meta( $document->ID, 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( $document->ID, 'meta_document_file_location', true );

					if ( $show_icons ) {
						//$htmlout .= "show icons";
						$document_type = get_post_meta( $document->ID, 'meta_document_type', true );
						$document_type = $document_type === '' ? 'default' : $document_type;
						$document_type_icon = '';
						$document_type_label = '';
						if ( $document_type === 'custom' ) {
							$document_type_icon = get_post_meta( $document->ID, 'meta_document_custom_icon', true );
							$document_type_label = get_post_meta( $document->ID, 'meta_document_custom_label', true );
						} else {
							$document_type = function_exists( 'lsvr_get_document_type' ) ? lsvr_get_document_type( $document_type ) : '';
							if ( is_array( $document_type ) ) {
								 $document_type_icon = $document_type['class'];
								 $document_type_label = $document_type['label'];
							}
						}
					}
					if ( $show_icons && $document_type_icon !== '' ) {
						$htmlout .= '<span class="document-icon reach-inline" title="'.esc_attr( $document_type_label ).'"><i class="'.esc_attr( $document_type_icon ).'"></i></span>';
					}
					if ( $document_file_location === 'external' ) {
							// EXTERNAL FILE
							//$htmlout .= "External  ";
							$htmlout .= '<a href="'.esc_url($document_file ).'" '.$link_target.'> '.$doc_title.' </a>';
							if ( $show_filesize && get_post_meta( $document->ID, 'meta_document_external_file_size', true ) !== '' ) {
								$htmlout .= '<span class="document-filesize">'.get_post_meta( $document->ID, 'meta_document_external_file_size', true ).' )</span>';
							}
					} else {
						// LOCAL FILE
						//$htmlout .= "Local  ";
						if ( $document_file_location === 'local' ) {
							reset( $document_file );
							$document_id = key( $document_file );
							$document_link = reset( $document_file );
						}

						$htmlout .= '<a href="'.esc_url( $document_link ).'" '.$link_target.' >'.$doc_title.'</a>';
						if ( $show_filesize ) {
							$document_size = (int) filesize( get_attached_file( $document_id ) );
							$document_size = $document_size > 0 ? lsvr_filesize_convert( $document_size ) : false;
							$htmlout .= '<span class="document-filesize">('.$document_size.' )</span>';
						}
					}
				} else {
					//$htmlout .= "nope.";
					$htmlout .= $doc_title;
				}
			}
		} else {
			//$htmlout .= "nada.";
		}
		return $htmlout;

	 } /* end lsvr_document_shortcode */

function alpha_order_docs( $query ) {
    if ( ! is_admin()  /* && $query->is_post_type_archive('lvsrdocument') */ && $query->is_main_query() && is_tax( 'lsvrdocumentcat' ) ) {
         $term = get_queried_object()->term_id;
	    if ($term) {
	    	$MetaValue = "";
	    	if (function_exists('wp_get_terms_meta')) {
			  $MetaValue = wp_get_terms_meta($term, 'sort_by_date' ,true);
			}
			if (!$MetaValue) {
				$query->set( 'orderby', 'title' );
	    		$query->set( 'order', 'ASC' );
			}
	    }
    }
}

add_action( 'pre_get_posts', 'alpha_order_docs' );

function theme_excerpt_length( $length ) {
    return 45;
}
add_filter( 'excerpt_length', 'theme_excerpt_length', 1999 );

//  sticky notices...return sticky notices of a custom post type.
if ( ! function_exists( 'reach_get_stickies' ) ) {
  // returns arrray of sticky notices int he given post type
	function reach_get_stickies($in_cpt) {
		$stickies = get_option( 'sticky_posts' );
    $sticky_posts = array();

    if ($stickies) {
      $args = array(
        'post_type' => $in_cpt,
        'post__in'  => $stickies,
      	'ignore_sticky_posts' => 1
      );
      $stickypost_results  = new WP_Query($args);
      if ($stickypost_results->post_count) {

        $sticky_posts = $stickypost_results->posts;
      }
    } // end if;
    return $sticky_posts;
	} // end reach_get_stickies
} // end if exists
