<?php 
/* languages customizations 
*/
	if ( !function_exists('eai_change_theme_text') ){
		function eai_change_theme_text( $translated_text, $text, $domain ) {
			 /* if ( is_singular() ) { */
			    switch ( $translated_text ) {

		            /* case 'Category' :
		                $translated_text = __( '',  $domain  );
		                break; */

		            case 'Blog':
		            	$translated_text = __( 'News',  $domain  );
		            	break;
		             case 'Older Post':
		            	$translated_text = __( 'Older News',  $domain  );
		            	break;
		             case 'Newer Post':
		            	$translated_text = __( 'More Recent News',  $domain  );
		            	break;
		           /* case 'Share this post:':
		            	$translated_text = __('Share', ' $domain );
		            	break; */
		        }
		    /* } */

	    	return $translated_text;
		}
		add_filter( 'gettext', 'eai_change_theme_text', 20, 3 );
	}

?>