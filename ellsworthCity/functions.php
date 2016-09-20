<?php

/* -----------------------------------------------------------------------------

    LOAD PARENT THEME STYLE.CSS

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_enqueue_parent_styles' ) ) {
	function lsvr_enqueue_parent_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'lsvr_enqueue_parent_styles' );


/* -----------------------------------------------------------------------------

    LOAD CUSTOM SCRIPTS
	You can override all plugins defined in "library.js" file by adding your own definition
	of the plugin in "/library/js/scripts.js" file and uncommenting "add_action"

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_load_child_scripts' ) ) {
	function lsvr_load_child_scripts() {
		$theme = wp_get_theme();
		$theme_version = $theme->Version;
		wp_register_script( 'child-scripts', get_stylesheet_directory_uri() . '/library/js/scripts.js', array('jquery'), $theme_version, true );
		wp_enqueue_script( 'child-scripts' );
	}
}
add_action( 'wp_enqueue_scripts', 'lsvr_load_child_scripts' );
/* -----------------------------------------------------------------------------

    CUSTOM CODE

----------------------------------------------------------------------------- */

// add your code here
require_once(get_stylesheet_directory().'/custom/ourteam.php'); 
require_once(get_stylesheet_directory().'/custom/language.php'); 
require_once(get_stylesheet_directory().'/custom/custom.php'); 
require_once(get_stylesheet_directory().'/custom/tribe-events.php'); 
require_once(get_stylesheet_directory().'/custom/wp-job-manager.php'); 
require_once(get_stylesheet_directory().'/custom/searchwp.php'); 

add_filter('widget_text', 'do_shortcode'); // make text widget do shortcodes....

function reach_custom_widgets() {
	/* add widget for document list */
	require_once( 'widgets/documentList.php' );
	if ( class_exists( 'Lsvr_DocumentsList_Widget' ) ) {
		register_widget( 'Lsvr_DocumentsList_Widget' );
	}
	/* add widget area for above the content*/
	if ( function_exists('register_sidebar') ){

		 // alerts box at top of site 
		register_sidebar(array(
			'name' => 'Below Header',
			'id' => 'coe_below_header',
			'description' => 'Widget under header (for alerts)',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		)); 

		 register_sidebar(array(
			'name' => 'Above Content',
			'id' => 'coe_above_content',
			'description' => 'Widget under page title/above content',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		)); 

		 register_sidebar(array(
			'name' => 'Home Top',
			'id' => 'coe_home_banner',
			'description' => 'Widget above homepage content - for special notices',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		)); 

		
	} //function_exists('register_sidebar')	


}
add_action( 'widgets_init', 'reach_custom_widgets' );

	// trying to use mobile menu (instead of main menu) when on mobile
	register_nav_menu('mobile-menu', __( 'Mobile Menu', 'lsvrtheme' ));

	// allow shortcodes in contact form 7...
	add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
	function mycustom_wpcf7_form_elements( $form ) {
		$form = do_shortcode( $form );

		return $form;
	}

// how to order documents in arhive....works, but...
//  alpha is not really what we want...  (city counsel minutes should be default ordering....)
//	menu order - doesnt make sense unless it's ASC???
	/*add_action( 'pre_get_posts', 'my_change_sort_order'); 
	function my_change_sort_order($query){
		if ( get_query_var('lsvrdocumentcat') ) {
			//Set the order ASC or DESC
	        $query->set( 'order', 'ASC' );
	        //Set the orderby
	       //$query->set( 'orderby', 'title' );
	       $query->set( 'orderby', 'menu_order' );
		}
		return $query;
	}
*/
/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
	function coe_custom_excerpt_more( $output ) {
		if ( /* has_excerpt() && */ ! is_attachment() ) {
			$output .= '<a class="moretag" href="'. get_permalink($post->ID) . '"> ....Read More</a>';
		} else {
			$output .= "{same}";
		}
		return $output;
	}
	add_filter( 'get_the_excerpt', 'coe_custom_excerpt_more' );

	// Replaces the excerpt "Read More" text by a link
	function new_excerpt_more($more) {
	    global $post;
		//return '<a class="moretag" href="'. get_permalink($post->ID) . '"> ....Read More em</a>';
		return "";
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	/*  Branding */
	/*****  change the login screen logo ****/
	function my_login_logo() { ?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/admin-login.png);
				padding-bottom: 30px;
				background-size: contain;
				margin-left: -30px;
				margin-bottom: 0px;
				margin-right: 0px;
				width: 100%;
			}
		</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo' );

	/* put reach logo at bottom of login screen */
	add_action( 'login_footer', 'reach_login_branding' );
	function reach_login_branding() {
		$outstring = "";
		$outstring .= '<p style="text-align:center;">';
		$outstring .= 	'<img src="'.get_stylesheet_directory_uri().'/images/reach-favicon.png'.'">';
		$outstring .= 		'R<i style="color: #f58220">EA</i>CH Maine';
		$outstring .= '</p>';
		echo $outstring;
	}


	// custom post types installed by 
	function coe_custom_posts_supports() {
		add_post_type_support('lsvrdocument', array( 'page-attributes')); // allow as type attributes for ordering documents
		
	}
	add_action('init', 'coe_custom_posts_supports');
	
?>