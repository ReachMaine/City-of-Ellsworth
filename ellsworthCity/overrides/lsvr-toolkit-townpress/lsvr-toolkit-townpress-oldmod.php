<?php
/*
Plugin Name: LSVR Toolkit (TownPress)
Description: Adds theme-specific functionality.
Version: 1.2.2
Author: LSVRthemes
Author URI: http://themeforest.net/user/LSVRthemes/portfolio
License: GPLv2
Text Domain: lsvrtoolkit
Domain Path: /languages
*/
/*  13jun16 zig - remove built in events stuff.
*/

/* -----------------------------------------------------------------------------

    LOAD TEXTDOMAIN

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_load_toolkit_textdomain' ) ) {
	function lsvr_load_toolkit_textdomain() {
		load_plugin_textdomain( 'lsvrtoolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}
add_action( 'plugins_loaded', 'lsvr_load_toolkit_textdomain' );

/* -----------------------------------------------------------------------------

    LOAD SCRIPTS & STYLES

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_load_lsvr_toolkit_files' ) ) {
    function lsvr_load_lsvr_toolkit_files() {
        wp_register_script( 'lsvr-toolkit-scripts', plugins_url( 'lsvr-toolkit-townpress' ) . '/library/js/lsvr-toolkit.js', array('jquery') );
        wp_enqueue_script( 'lsvr-toolkit-scripts' );
    }
}
add_action( 'admin_enqueue_scripts', 'lsvr_load_lsvr_toolkit_files' );


/* -----------------------------------------------------------------------------

    INCLUDE

----------------------------------------------------------------------------- */

	// FUNCTIONS
	require_once( 'lsvr-functions.php' );

	// CUSTOM POST TYPES
	require_once( 'cpt/lsvr-notice.php' );
	require_once( 'cpt/lsvr-document.php' );
	//require_once( 'cpt/lsvr-event.php' ); // zig
	require_once( 'cpt/lsvr-gallery.php' );
	require_once( 'cpt/lsvr-slide.php' );

	// PAGE BUILDER
	require_once( 'lsvr-page-builder.php' );

	// SHORTCODE GENERATOR
	require_once( 'lsvr-shortcode-generator.php' );

	// WIDGETS
	require_once( 'lsvr-widgets.php' );

?>