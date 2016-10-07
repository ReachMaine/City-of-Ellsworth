<?php 
/* custom functions & shortcodes

/* excise tax calculator */
/* these work with a CF7 form with known ids of field */
function est_tax_fill_vechicle_year($choices, $args=array()) {
	// this function returns an array of 
    // label => value pairs to be used in
    // a the select field
    $choices = array(
        '2016' => '0.024',
        '2015' => '0.0175',
        '2014' => '.0135',
        '2013' => '0.010',
        '2012' => '0.0065',
        '2011 and older' => '0.004'
    );
    return $choices;
}
add_filter('ext_tax_vehicle_year', 'est_tax_fill_vechicle_year', 10, 2);
function est_tax_fill_vanity_plate($choices, $args=array()) {
	// this function returns an array of 
    // label => value pairs to be used in
    // a the select field
    $choices = array(
        'No' => '0',
        'Yes' => '25'
    );
    return $choices;
}
add_filter('est_tax_vanity_plate', 'est_tax_fill_vanity_plate', 10, 2);

function est_tax_fill_plate_type($choices, $args=array()) {
	 $choices = array(
        'Standard (Chickadee)' => '38',
        'Sportsman' => '53',
        'Agriculture' => '53',
        'Breast Cancer' => '53',
        'Animal Welfare' => '53',
        'Lobster' => '53',
        'Conservation' => '53',
        'University of Maine' => '53',
        'Support Troops' => '53',
        'Black Bear' => '53'
    );
	 return $choices;
}
add_filter('est_tax_plate_type', 'est_tax_fill_plate_type', 10, 2);

if (!function_exists('est_excise_tax')) {
	function est_excise_tax( $atts ) {

		$atts = shortcode_atts( array(
			'button_text' => 'Estimate Tax',
			'icon' => 'fa-calculator',
		), $atts, 'bookingbutton' );


		// javascript for the onClick event
		$js_out = "";
		$js_out .= '<script>function estimate_tax(){';
		/* $js_out .= "  console.log (document.getElementById('MSRP').value);"; */
		$js_out .= " clear_tax(); ";
		$js_out .= " if ( document.getElementById('MSRP').value > 0) {";
		$js_out .= "  var etax = ( (document.getElementById('MSRP').value) * (document.getElementById('vehicle-year').value) ); "; 
		$js_out .= "  var reg = ( parseInt(document.getElementById('plate-type').value) + parseInt(document.getElementById('vanity-plate').value) );";
		$js_out .= "  var tot = etax + reg;";
		$js_out .= "  document.getElementById('ExciseTaxResults').style.display = 'block'; ";
		$js_out .= "  document.getElementById('ExciseTax').innerHTML = '$' + etax.toFixed(2); ";
		$js_out .= "  document.getElementById('Registration').innerHTML = '$' + reg.toFixed(2); ";
		$js_out .= "  document.getElementById('TotalTax').innerHTML = '$' + tot.toFixed(2); ";
		$js_out .= " } else {";
		$js_out .= "  document.getElementById('MSRP').style.borderColor = 'red'; ";
		$js_out .= "  document.getElementById('MSRP').style.borderWidth = '1px'; ";
		$js_out .= "  document.getElementById('MSRP').style.borderStyle = 'solid'; ";
		$js_out .= " } ";

		$js_out .= '  return false; }';
		$js_out .= '</script>'; 

		// html for the button.
		$html_out .= '<a class="c-button m-has-icon"  onClick="estimate_tax()">';
		$html_out .= '<i class="ico fa '.$atts['icon'].'"></i>';
		$html_out .= $atts['button_text'].'</a>';
		return $js_out.$html_out;
	} // end est_excise_tax
} // end if not exists est_excise_tax */
	add_shortcode( 'estimatetax', 'est_excise_tax' );

	add_shortcode('cleartax', 'clear_excise_tax');
	function clear_excise_tax( $atts ) {
		// javascript for the onClick event
		$js_out = "";
		$js_out .= '<script>function clear_tax(){';
		$js_out .= "  document.getElementById('MSRP').style.borderStyle = 'none'; ";
		$js_out .= "  document.getElementById('ExciseTaxResults').style.display = 'none'; ";
		$js_out .= "  document.getElementById('ExciseTax').innerHTML = ''; ";
		$js_out .= "  document.getElementById('Registration').innerHTML = ''; ";
		$js_out .= "  document.getElementById('TotalTax').innerHTML = ''; ";

		$js_out .= '  return false; }';
		$js_out .= '</script>'; 
		// html for the button.
		$html_out .= '<a class="c-button m-has-icon" onClick="clear_tax()">';
		$html_out .= '<i class="ico fa fa-eraser"></i>';
		$html_out .= 'Clear</a>';
		return $js_out.$html_out;
	} 


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
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

add_action( 'pre_get_posts', 'alpha_order_docs' );

function theme_excerpt_length( $length ) {
    return 45;
}
add_filter( 'excerpt_length', 'theme_excerpt_length', 1999 );