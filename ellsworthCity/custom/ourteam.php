<?php 
/* our team customizations
*/

//apply_filters( 'woothemes_our_team_member_contact_email', true )
// allow showing of email address.
add_filter('woothemes_our_team_member_contact_email', '__return_true'); 

//To add a new fields to the backend
add_filter( 'woothemes_our_team_member_fields', 'coe_new_fields' );
function coe_new_fields( $fields ) {
	$fields['street'] = array(
	    'name' 			=> __( 'Street Address', 'our-team-by-woothemes' ),
	    'description' 	=> __( 'Street Address', 'our-team-by-woothemes' ),
	    'type' 			=> 'text',
	    'default' 		=> '1 City Hall Plaza',
	    'section' 		=> 'info'
	);
	$fields['city'] = array(
	    'name' 			=> __( 'City', 'our-team-by-woothemes' ),
	    'description' 	=> __( 'City', 'our-team-by-woothemes' ),
	    'type' 			=> 'text',
	    'default' 		=> 'Ellsworth, ME 04605',
	    'section' 		=> 'info'
	);
	return $fields;
}


// Then to display the contents of that field on the frontend before the other member fields
add_filter( 'woothemes_our_member_fields_display', 'coe_new_fields_display' );
function coe_new_fields_display( $member_fields ) {
	global $post;
	$street = esc_attr( get_post_meta( $post->ID, '_street', true ) );
	$city = esc_attr( get_post_meta( $post->ID, '_city', true ) );
	$addr_out = '';
	if ( '' != $street ) {
		$addr_out .= '<li class="street">' . $street . '</li><!--/.street-->' . "\n";
	} 
	if ( '' != $city ) {
		$addr_out .= '<li class="city">' . $city . '</li><!--/.city-->' . "\n";
	}
	return $addr_out.$member_fields;
}
?>