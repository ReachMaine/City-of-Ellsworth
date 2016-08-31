<?php /* wp-job-manager custom code */

// Add your own function to filter the fields
add_filter( 'job_manager_job_listing_data_fields', 'custom_job_manager_job_listing_data_fields' );

// This is your function which takes the fields, modifies them, and returns them
// You can see the fields which can be changed here: https://github.com/mikejolley/WP-Job-Manager/blob/master/includes/admin/class-wp-job-manager-writepanels.php

function custom_job_manager_job_listing_data_fields( $fields ) {


	global $post;

	// default values for some
    $fields['_job_location']['value'] = metadata_exists( 'post', $post->ID, '_job_location' ) ? get_post_meta( $post->ID, '_job_location', true ) : "Ellsworth, Maine";
	$fields['_company_name']['value'] = metadata_exists( 'post', $post->ID, '_company_name' ) ? get_post_meta( $post->ID, '_company_name', true ) : "City of Ellsworth";

	// remove some
	unset($fields['_company_video']);
	unset($fields['_company_website']);

    return $fields;
}