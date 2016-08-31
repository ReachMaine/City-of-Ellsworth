<?php

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

// Flushes rewrite rules on plugin activation to ensure project posts don't 404
// http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
if ( ! function_exists( 'lsvr_document_activation' ) ) {
	function lsvr_document_activation() {
		lsvr_document_init();
		flush_rewrite_rules();
	}
}
if ( ! function_exists( 'lsvr_document_init' ) ) {
	function lsvr_document_init() {

		// Enable custom post type
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => __( 'Documents', 'lsvrtoolkit' ),
			'singular_name' => __( 'Document', 'lsvrtoolkit' ),
			'add_new' => __( 'Add New Document', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Document', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Document', 'lsvrtoolkit' ),
			'new_item' => __( 'Add New Document', 'lsvrtoolkit' ),
			'view_item' => __( 'View Document', 'lsvrtoolkit' ),
			'search_items' => __( 'Search documents', 'lsvrtoolkit' ),
			'not_found' => __( 'No documents found', 'lsvrtoolkit' ),
			'not_found_in_trash' => __( 'No documents found in trash', 'lsvrtoolkit' ),
		);

		$args = array(
			'labels' => $labels,
			'exclude_from_search' => false,
			'public' => true,
			'supports' => array( 'title', 'custom-fields' ),
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => lsvr_get_field( 'documents_slug', 'documents' ) ), // Permalinks format
			'menu_position' => 5,
			'has_archive' => true,
			'show_in_nav_menus' => true,
			'menu_icon' => 'dashicons-media-default',
		);

		$args = apply_filters( 'lsvrdocumentposttype_args', $args );

		register_post_type( 'lsvrdocument', $args );

		// Register a taxonomy
		// http://codex.wordpress.org/Function_Reference/register_taxonomy
		$taxonomy_lsvrdocumentcat_labels = array(
			'name' => __( 'Document Categories', 'lsvrtoolkit' ),
			'singular_name' => __( 'Category', 'lsvrtoolkit' ),
			'search_items' => __( 'Search Categories', 'lsvrtoolkit' ),
			'popular_items' => __( 'Popular Categories', 'lsvrtoolkit' ),
			'all_items' => __( 'All Categories', 'lsvrtoolkit' ),
			'parent_item' => __( 'Parent Category', 'lsvrtoolkit' ),
			'parent_item_colon' => __( 'Parent Category:', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Category', 'lsvrtoolkit' ),
			'update_item' => __( 'Update Category', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Category', 'lsvrtoolkit' ),
			'new_item_name' => __( 'New Category Name', 'lsvrtoolkit' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'lsvrtoolkit' ),
			'add_or_remove_items' => __( 'Add or remove categories', 'lsvrtoolkit' ),
			'choose_from_most_used' => __( 'Choose from the most used categories', 'lsvrtoolkit' ),
			'menu_name' => __( 'Categories', 'lsvrtoolkit' )
		);
		$taxonomy_lsvrdocumentcat_args = array(
			'labels' => $taxonomy_lsvrdocumentcat_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => lsvr_get_field( 'document_cat_slug', 'document-category' ) ), // Permalinks format
			'query_var' => true

		);
		register_taxonomy( 'lsvrdocumentcat', array( 'lsvrdocument' ), $taxonomy_lsvrdocumentcat_args );

	}
}
register_activation_hook( __FILE__, 'lsvr_document_activation' );
add_action( 'init', 'lsvr_document_init' );


/* -----------------------------------------------------------------------------

    ADD TAXONOMY FILTER TO ADMIN
	http://pippinsplugins.com

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_add_documentcat_taxonomy_filters' ) ) {
	function lsvr_add_documentcat_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'lsvrdocumentcat' );

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'lsvrdocument' ) {

			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'lsvr_add_documentcat_taxonomy_filters' );

?>