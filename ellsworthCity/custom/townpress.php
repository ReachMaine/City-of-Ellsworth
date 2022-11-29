<?php 
/* zig - overwrite townpress function for documents s.t. also check for blank expiration date. */

// NUMBER OF POSTS FOR DOCUMENTS & ARCHIVE
	if ( ! function_exists( 'lsvr_modify_document_posts_per_page' ) ) {
		function lsvr_modify_document_posts_per_page( $query ) {
			if ( $query->is_main_query() && ( $query->is_post_type_archive( 'lsvrdocument' ) || $query->is_tax( 'lsvrdocumentcat' ) ) && ! is_admin() ) {
				$query->set( 'posts_per_page', lsvr_get_field( 'document_list_items_per_page', 20 ) );
				//$query->set( 'order', 'ASC' );
				//$query->set( 'orderby', 'title', 20 );
				$today = current_time( 'Y-m-d H:i' );
				$is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false;

				// SHOW AS ARCHIVE
				if ( $is_archive ) {
					$query->set( 'meta_query', array(
						array( 'key' => 'meta_document_expiration_date',
							'value' => $today,
							'compare' => '<=',
							'type' => 'CHAR'
						)
					));
				}

				// SHOW WITHOUT EXPIRED (ARCHIVED) - zig check for blank (as well as not exists)
				else {
					$query->set( 'meta_query', array(
						'relation' => 'OR',
						array( 'key' => 'meta_document_expiration_date',
									'value' => $today,
									'compare' => '>=',
									'type' => 'CHAR'
								), 
							array(
								'relation' => 'OR',
								array( 'key' => 'meta_document_expiration_date',
									'value' => '',
									'compare' => 'NOT EXISTS',

								),
								array( 'key' => 'meta_document_expiration_date',
								'value' => ' ',
								'compare' => '=',
								'type' => 'CHAR'
								)
							)

					));
				}

			}
		}
	}

