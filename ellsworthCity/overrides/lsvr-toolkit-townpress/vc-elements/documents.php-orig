<?php

// CATEGORY PARAMETER
$category_param = array(
	'param_name' => 'category',
	'type' => 'dropdown',
	'heading' => __( 'Category', 'lsvrtoolkit' ),
	'description' => __( 'Category to load documents from. Choose <strong>None</strong> to load documents regardless of category.', 'lsvrtoolkit' ),
	'value' => array(),
);
if ( is_admin() ) {
	$categories_tax = get_categories( array(
		'type' => 'lsvrdocument',
		'taxonomy' => 'lsvrdocumentcat'
	));
	if ( count( $categories_tax ) > 0 ) {
		$cat_arr = array( __( 'None', 'lsvrtoolkit' ) => 'none' );
		foreach ( $categories_tax as $value ) {
			$cat_arr[$value->name] = $value->cat_ID;
		}
		$category_param[ 'value' ] = $cat_arr;
	}
}

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Documents', 'lsvrtoolkit' ),
	'description' => __( 'List of documents', 'lsvrtoolkit' ),
    'base' => 'lsvr_documents',
	'icon' => 'lsvr-vc-ico fa fa-file-text-o',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		$category_param,
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'icon',
            'type' => 'textfield',
            'heading' => __( 'Title Icon', 'lsvrtoolkit' ),
			'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
			'value' => 'tp tp-papers',
        ),
        array(
			'param_name' => 'number_of_items',
            'type' => 'dropdown',
			'value' => array( __( 'All', 'lsvrtoolkit' ) => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10 ),
            'heading' => __( 'Number of documents', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'show_filesize',
            'type' => 'checkbox',
            'heading' => __( 'Show file size', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
		array(
			'param_name' => 'show_icons',
            'type' => 'checkbox',
            'heading' => __( 'Show document type icons', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
		array(
			'param_name' => 'more_btn_label',
            'type' => 'textfield',
            'heading' => __( 'More button label', 'lsvrtoolkit' ),
			'description' => __( 'Link to all documents. Leave blank to hide it.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'custom_class',
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'lsvrtoolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
        ),
    ),
));

?>