<?php

/** 4Feb26 zig - Xout create_function for PHP 8 */

if ( ! isset( $content_width ) ) {

    $content_width = 500;

}



/* -----------------------------------------------------------------------------



    THEME SETUP



----------------------------------------------------------------------------- */



add_action( 'after_setup_theme', 'lsvr_theme_setup' );



function lsvr_theme_setup() {



    /* -------------------------------------------------------------------------

        LOAD TEXTDOMAIN

    ------------------------------------------------------------------------- */



    load_theme_textdomain( 'lsvrtheme', get_template_directory() . '/languages' );



    /* -------------------------------------------------------------------------

        INCLUDES

    ------------------------------------------------------------------------- */



    // FUNCTIONS

	require_once( 'includes/lsvr-functions.php' );



    // REDUX FRAMEWORK



		// extension loader

		require_once( dirname(__FILE__) . '/includes/redux/loader.php' );



		// metaboxes config

		if ( class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/includes/redux/meta-config.php' ) ) {

			require_once( dirname( __FILE__ ) . '/includes/redux/meta-config.php' );

		}



		// theme options config

		if ( ! isset( $theme_options ) && file_exists( dirname( __FILE__ ) . '/includes/redux/options-config.php' ) ) {

			require_once( dirname( __FILE__ ) . '/includes/redux/options-config.php' );

		}





    // TGM PLUGIN ACTIVATION

    require_once( 'includes/tgm-plugin-settings.php' );



    // COMMENT WALKER CLASS

    require_once( 'includes/lsvr-walker-comment.class.php' );



    // VISUAL COMPOSER SETTINGS

    require_once( 'includes/visual-composer-settings.php' );



    /* -------------------------------------------------------------------------

        REGISTER NAV MENUS

    ------------------------------------------------------------------------- */



    register_nav_menu( 'main', __( 'Main Menu', 'lsvrtheme' ) );

    register_nav_menu( 'footer', __( 'Footer Menu', 'lsvrtheme' ) );



    /* -------------------------------------------------------------------------

        REGISTER SIDEBARS

    ------------------------------------------------------------------------- */



	if ( ! function_exists( 'lsvr_register_sidebars' ) ) {

		function lsvr_register_sidebars() {



			// PRIMARY SIDEBAR

			register_sidebar( array(

				'name' => __( 'Default Left Sidebar', 'lsvrtheme' ),

				'id' => 'primary-sidebar',

				'class'         => '',

				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',

				'after_widget'  => '</div></div>',

				'before_title'  => '<h3 class="widget-title">',

				'after_title'   => '</h3>'

			));



			// SECONDARY SIDEBAR

			register_sidebar( array(

				'name' => __( 'Default Right Sidebar', 'lsvrtheme' ),

				'id' => 'secondary-sidebar',

				'class'         => '',

				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',

				'after_widget'  => '</div></div>',

				'before_title'  => '<h3 class="widget-title">',

				'after_title'   => '</h3>'

			));



			// BOTTOM PANEL

			global $theme_options;

			if ( ! empty( $theme_options[ 'bottom_panel_columns' ] ) && (int) $theme_options[ 'bottom_panel_columns' ] > 0 ) {

				$bottom_panel_columns = $theme_options[ 'bottom_panel_columns' ];

			}

			else {

				$bottom_panel_columns = 4;

			}

			$bottom_panel_col_number = 12 / (int) $bottom_panel_columns;

			register_sidebar( array(

				'name' => __( 'Bottom Panel', 'lsvrtheme' ),

				'id' => 'bottom-sidebar',

				'description'   => __( 'A widget area located in the footer of the site.', 'lsvrtheme' ),

				'class'         => '',

				'before_widget' => '<div class="widget-col col-md-' . esc_attr( $bottom_panel_col_number ) . '"><div id="%1$s" class="widget %2$s"><hr class="c-separator m-transparent hidden-lg hidden-md"><div class="widget-inner">',

				'after_widget'  => '</div></div></div>',

				'before_title'  => '<h3 class="widget-title">',

				'after_title'   => '</h3>'

			));



			// CUSTOM SIDEBARS

			if ( is_array( lsvr_get_field( 'custom_sidebars' ) ) ) {



				$sidebars_arr = lsvr_consolidate_repeater_field( lsvr_get_field( 'custom_sidebars' ), array( 'sidebar_id', 'sidebar_title' ) );

				if ( is_array( $sidebars_arr ) ) {

					$index = 0;

					foreach ( $sidebars_arr as $sidebar ) {

						if ( is_array( $sidebar ) ) {



							$index++;

							$sidebar_id = array_key_exists( 'sidebar_id', $sidebar ) ? sanitize_title( $sidebar['sidebar_id'] ) : false;

							$sidebar_id = ! $sidebar_id ? 'custom-sidebar-' . esc_attr( $index ) : $sidebar_id;

							$sidebar_title = array_key_exists( 'sidebar_title', $sidebar ) ? $sidebar['sidebar_title'] : __( 'Custom Sidebar', 'lsvrtheme' );



							register_sidebar( array(

								'name'          => $sidebar_title,

								'description'   => __( 'You can manage custom sidebars underTheme Options / Custom Sidebars.', 'lsvrtheme' ),

								'id'            => $sidebar_id,

								'class'         => '',

								'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',

								'after_widget'  => '</div></div>',

								'before_title'  => '<h3 class="widget-title">',

								'after_title'   => '</h3>'

							));



						}

					}

				}



			}



		}

	}

    add_action( 'widgets_init', 'lsvr_register_sidebars' );



    /* -------------------------------------------------------------------------

        ADD THEME SUPPORT

    ------------------------------------------------------------------------- */



	// BBPRESS

	add_theme_support( 'bbpress' );



	// FEATURED IMAGES

    add_theme_support( 'post-thumbnails' );



	// AUTOMATIC FEED LINKS

    add_theme_support( 'automatic-feed-links' );



	// TITLE TAG

	add_theme_support( 'title-tag' );



    /* -------------------------------------------------------------------------

        LOAD CSS

    ------------------------------------------------------------------------- */



	$theme = wp_get_theme();

    $theme_version = $theme->Version;



	if ( ! function_exists( 'lsvr_load_theme_styles' ) ) {

		function lsvr_load_theme_styles(){



			global $theme_version;



			// MAIN STYLE

			wp_register_style( 'main-style', get_bloginfo( 'stylesheet_url' ), array(), $theme_version );

			wp_enqueue_style( 'main-style' );



			// TYPOGRAPHY

			if ( lsvr_get_field( 'fonts_gf_enable', true, true ) ) {

				$primary_font = lsvr_get_field( 'font_primary' );

				$primary_font_family = is_array( $primary_font ) && array_key_exists( 'font-family', $primary_font ) ? $primary_font['font-family'] : 'Source Sans Pro';

				$primary_font_size = is_array( $primary_font ) && array_key_exists( 'font-size', $primary_font ) ? $primary_font['font-size'] : '16px';

				$primary_font_weight = is_array( $primary_font ) && array_key_exists( 'font-weight', $primary_font ) ? $primary_font['font-weight'] : '400';

				$primary_font_css = 'body { font-family: \'' . esc_attr( $primary_font_family ) . '\', Arial, sans-serif; font-size: ' . esc_attr( $primary_font_size ) . '; font-weight: ' . esc_attr( $primary_font_weight ) . '; }';

				wp_add_inline_style( 'main-style', $primary_font_css );

			}



			// CUSTOM COLOR SKIN

			if ( lsvr_get_field( 'skin_custom_enabled', false, true ) ){



				// FROM TEXTAREA

				if ( lsvr_get_field( 'skin_custom_code', '' ) !== '' ) {

					wp_add_inline_style( 'main-style', lsvr_get_field( 'skin_custom_code' ) );

				}



				// FROM FILE

				else {

					wp_register_style( 'custom-skin', get_stylesheet_directory_uri() . '/library/css/customskin.css', array(), $theme_version );

					wp_enqueue_style( 'custom-skin' );

				}



			}



			// PREDEFINED COLOR SKIN

			else {

				$theme_skin_file = '/library/css/skin/' . lsvr_get_field( 'skin_default', 'red' ) . '.css';

				wp_register_style( 'theme-skin', get_template_directory_uri() . $theme_skin_file, array(), $theme_version );

				wp_enqueue_style( 'theme-skin' );

			}



			// HEADER LOGO MAX WIDTH

			if ( (int) lsvr_get_field( 'header_logo_max_width', 120 ) > 0 || (int) lsvr_get_field( 'header_logo_max_width_large', 200 ) > 0 ) {

				$header_max_width_css = '';

				if ( (int) lsvr_get_field( 'header_logo_max_width_large', 200 ) > 0 ) {

					$header_max_width_css .= ' .header-branding.m-large-logo span { max-width: ' . (int) esc_attr( lsvr_get_field( 'header_logo_max_width_large', 200 ) ) . 'px; }';

				}

				if ( (int) lsvr_get_field( 'header_logo_max_width', 120 ) > 0 ) {

					$header_max_width_css .= ' .header-branding.m-small-logo span { max-width: ' . (int) esc_attr( lsvr_get_field( 'header_logo_max_width', 120 ) ) . 'px; }';

					$header_max_width_css .= ' @media ( max-width: 991px ) { .header-branding.m-small-logo span, .header-branding.m-large-logo span { max-width: ' . (int) esc_attr( lsvr_get_field( 'header_logo_max_width', 200 ) ) . 'px; } }';

				}

				wp_add_inline_style( 'main-style', $header_max_width_css );

			}



			// LOCALE WIDGET BG

			if ( lsvr_get_image_field( 'locale_widget_bg_image' ) ) {

				wp_add_inline_style( 'main-style', '.sidebar .widget-inner.m-has-bg { background-image: url( \'' . esc_url( lsvr_get_image_field( 'locale_widget_bg_image' ) ) . '\'); }' );

			}



			// CUSTOM CSS

			if ( trim( lsvr_get_field( 'custom_css_code' ) ) !== '' ){

				$custom_css_code_position = wp_style_is( 'theme-skin', 'enqueued' ) ? 'theme-skin' : 'main-style';

				$custom_css_code_position = wp_style_is( 'custom-skin', 'enqueued' ) ? 'custom-skin' : $custom_css_code_position;

				wp_add_inline_style( $custom_css_code_position, lsvr_get_field( 'custom_css_code' ) );

			}



		}

	}

    add_action( 'wp_enqueue_scripts', 'lsvr_load_theme_styles' );



    /* -------------------------------------------------------------------------

        LOAD JS

    ------------------------------------------------------------------------- */



	if ( ! function_exists( 'lsvr_load_theme_scripts' ) ) {

		function lsvr_load_theme_scripts() {



			global $theme_version;



			// MASONRY

			wp_enqueue_script( 'jquery-masonry' );



			// THIRD PARTY SCRIPTS

			wp_register_script( 'third-party', get_template_directory_uri() . '/library/js/third-party.js', array( 'jquery' ), $theme_version, true );

			wp_enqueue_script( 'third-party' );



			// SCRIPTS LIBRARY

			wp_register_script( 'scripts-library', get_template_directory_uri() . '/library/js/library.min.js', array( 'jquery' ), $theme_version, true );

			//wp_register_script( 'scripts-library', get_template_directory_uri() . '/library/js/library.js', array( 'jquery' ), $theme_version, true );

			wp_enqueue_script( 'scripts-library' );



			// MAIN SCRIPTS

			wp_register_script( 'main-scripts', get_template_directory_uri() . '/library/js/scripts.min.js', array( 'jquery' ), $theme_version, true );

			//wp_register_script( 'main-scripts', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), $theme_version, true );

			wp_enqueue_script( 'main-scripts' );



			// COMMENT REPLY

			if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }



			// Add JS vars

			if ( lsvr_get_field( 'header_gmap_api_key', '' ) !== '' ) {

				wp_add_inline_script( 'main-scripts', 'var lsvrGmapApiKey = "' . lsvr_get_field( 'header_gmap_api_key' ) . '";' );

			}



			// LOCAL WEATHER AJAX

			if ( lsvr_get_field( 'locale_weather_enable', false, true ) ) {

				wp_localize_script( 'main-scripts', 'lsvrMainScripts', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

			}



			// CUSTOM JS

			if ( lsvr_get_field( 'custom_js_code' ) !== '' ) {
	/* zig Xout  */
	//			$custom_js_code = create_function( '', 'echo "<script type=\"text/javascript\">/* <![CDATA[ */' . lsvr_get_field( 'custom_js_code' ) . '/* ]]> */</script>";' );

	//			add_action( 'wp_footer', $custom_js_code );

			}



			// CUSTOM CODE

			if ( lsvr_get_field( 'custom_any_code' ) !== '' ) {

				function lsvr_custom_footer_code() {

					echo lsvr_get_field( 'custom_any_code' );

				}

				add_action( 'wp_footer', 'lsvr_custom_footer_code' );

			}



		}

	}

    add_action( 'wp_enqueue_scripts', 'lsvr_load_theme_scripts' );



    /* -------------------------------------------------------------------------

        POST ACTIONS

    ------------------------------------------------------------------------- */



	// NAVIGATION FIX FOR BLOG

	if ( ! function_exists( 'lsvr_is_blog' ) ) {

		function lsvr_is_blog() {

			global $post;

			$posttype = get_post_type( $post );

			return ( ( $posttype == 'post' ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() || is_author() ) ) ? true : false;

		}

	}

	if ( ! function_exists( 'lsvr_fix_blog_link_on_cpt' ) ) {

		function lsvr_fix_blog_link_on_cpt( $classes, $item ) {

			if( ! lsvr_is_blog() ) {

				$blog_page_id = intval( get_option( 'page_for_posts' ) );

				if ( $blog_page_id != 0 && $item->object_id == $blog_page_id ) {

					unset( $classes[array_search( 'current_page_parent', $classes )] );

				}

			}

			return $classes;

		}

	}

	add_filter( 'nav_menu_css_class', 'lsvr_fix_blog_link_on_cpt', 10, 3 );



    /* -------------------------------------------------------------------------

        CPT ACTIONS

    ------------------------------------------------------------------------- */



	// NAVIGATION FIX FOR CPT

	if ( ! function_exists( 'lsvr_current_type_nav_class' ) ) {

		function lsvr_current_type_nav_class( $classes, $item ) {

			$post_type = get_query_var( 'post_type' );

			$taxonomy = get_query_var( 'taxonomy' );

			$post_type_url = '';

			if ( $post_type !== '' ) {

				$post_type_url = trim( get_post_type_archive_link( $post_type ), '/' );

			}

			elseif ( $post_type === '' && $taxonomy !== '' ) {

				$taxonomy_obj = get_taxonomy( $taxonomy );

				$post_type = $taxonomy_obj->object_type[0];

				$post_type_url = trim( get_post_type_archive_link( $post_type ), '/' );

			}

			if ( ( $post_type_url !== '' ) && ( trim( $item->url, '/' ) === $post_type_url ) ) {

				array_push( $classes, 'current-menu-item' );

			};

			return $classes;

		}

	}

	add_filter( 'nav_menu_css_class', 'lsvr_current_type_nav_class', 10, 2 );





	// NUMBER OF POSTS FOR NOTICES ARCHIVE

	if ( ! function_exists( 'lsvr_modify_notice_posts_per_page' ) ) {

		function lsvr_modify_notice_posts_per_page( $query ) {

			if ( $query->is_main_query() && ( $query->is_post_type_archive( 'lsvrnotice' ) || $query->is_tax( 'lsvrnoticecat' ) ) && ! is_admin() ) {

				$query->set( 'posts_per_page', lsvr_get_field( 'notice_list_items_per_page', 10 ) );

			}

		}

	}

	add_action( 'pre_get_posts', 'lsvr_modify_notice_posts_per_page' );





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



				// SHOW WITHOUT EXPIRED (ARCHIVED)

				else {

					$query->set( 'meta_query', array(

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

					));

				}



			}

		}

	}

	add_action( 'pre_get_posts', 'lsvr_modify_document_posts_per_page' );



	// NUMBER OF POSTS & SORTING FOR EVENTS ARCHIVE

	if ( ! function_exists( 'lsvr_modify_event_posts_per_page' ) ) {

		function lsvr_modify_event_posts_per_page( $query ) {

			if ( $query->is_main_query() && ( $query->is_post_type_archive( 'lsvrevent' ) || $query->is_tax( 'lsvreventcat' ) ) && ! is_admin() ) {

				$today = current_time( 'Y-m-d H:i' );

				$query->set( 'posts_per_page', lsvr_get_field( 'event_list_items_per_page', 20 ) );

				$query->set( 'orderby', 'meta_value meta_value_num' );

				$query->set( 'meta_key', 'meta_event_date' );



				$is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false;



				// SHOW AS ARCHIVE

				if ( $is_archive ) {

					$query->set( 'order', 'DESC' );

					$query->set( 'meta_query', array(

						array( 'key' => 'meta_event_date',

							'value' => $today,

							'compare' => '<',

							'type' => 'CHAR'

						)

					));

				}



				// SHOW WITHOUT EXPIRED (ARCHIVED)

				else {

					$query->set( 'order', 'ASC' );

					$query->set( 'meta_query', array(

						array( 'key' => 'meta_event_date',

							'value' => $today,

							'compare' => '>=',

							'type' => 'CHAR'

						)

					));

				}



			}

		}

	}

	add_action( 'pre_get_posts', 'lsvr_modify_event_posts_per_page' );



	// NUMBER OF POSTS FOR GALLERIES ARCHIVE

	if ( ! function_exists( 'lsvr_modify_gallery_posts_per_page' ) ) {

		function lsvr_modify_gallery_posts_per_page( $query ) {

			if ( $query->is_main_query() && ( $query->is_post_type_archive( 'lsvrgallery' ) || $query->is_tax( 'lsvrgallerycat' ) ) && ! is_admin() ) {

				$query->set( 'posts_per_page', lsvr_get_field( 'gallery_list_items_per_page', 20 ) );

			}

		}

	}

	add_action( 'pre_get_posts', 'lsvr_modify_gallery_posts_per_page' );



    /* -------------------------------------------------------------------------

        WIDGET ACTIONS

    ------------------------------------------------------------------------- */



	// ADD ICON FIELD TO ALL WIDGETS

	// http://kreativkonzentrat.de/en/blog/wordpress-input-felder-und-klassen-zu-bestehenden-widgets-hinzufugen.html

	if ( ! function_exists( 'lsvr_widget_ico_field' ) ) {

		function lsvr_widget_ico_field( $t, $return, $instance ) {

			if ( $t->id_base === 'archives' ) {

				$default = 'tp tp-archive';

			}

			elseif ( $t->id_base === 'calendar' ) {

				$default = 'tp tp-calendar-full';

			}

			elseif ( $t->id_base === 'categories' ) {

				$default = 'tp tp-list4';

			}

			elseif ( $t->id_base === 'nav_menu' ) {

				$default = 'tp tp-menu2';

			}

			elseif ( $t->id_base === 'lsvr_document_categories_widget' ) {

				$default = 'tp tp-list4';

			}

			elseif ( $t->id_base === 'lsvr_documents_widget' ) {

				$default = 'tp tp-papers';

			}

			elseif ( $t->id_base === 'lsvr_event_categories_widget' ) {

				$default = 'tp tp-list4';

			}

			elseif ( $t->id_base === 'lsvr_events_widget' ) {

				$default = 'tp tp-calendar-full';

			}

			elseif ( $t->id_base === 'lsvr_galleries_widget' ) {

				$default = 'tp tp-pictures';

			}

			elseif ( $t->id_base === 'lsvr_gallery_categories_widget' ) {

				$default = 'tp tp-list4';

			}

			elseif ( $t->id_base === 'lsvr_gallery_featured_widget' ) {

				$default = 'tp tp-pictures';

			}

			elseif ( $t->id_base === 'lsvr_locale_info_widget' ) {

				$default = 'tp tp-map-marker';

			}

			elseif ( $t->id_base === 'lsvr_mailchimp_subscribe_widget' ) {

				$default = 'tp tp-at-sign';

			}

			elseif ( $t->id_base === 'lsvr_notice_categories_widget' ) {

				$default = 'tp tp-list4';

			}

			elseif ( $t->id_base === 'lsvr_notices_widget' ) {

				$default = 'tp tp-bullhorn';

			}

			elseif ( $t->id_base === 'recent-comments' ) {

				$default = 'tp tp-bubble';

			}

			elseif ( $t->id_base === 'recent-posts' ) {

				$default = 'tp tp-reading';

			}

			elseif ( $t->id_base === 'search' ) {

				$default = 'tp tp-magnifier';

			}

			elseif ( $t->id_base === 'tag_cloud' ) {

				$default = 'tp tp-tags';

			}

			elseif ( $t->id_base === 'tag_cloud' ) {

				$default = 'tp tp-tags';

			}

			elseif ( $t->id_base === 'bbp_search_widget' ) {

				$default = 'tp tp-magnifier';

			}

			elseif ( $t->id_base === 'bbp_forums_widget' ) {

				$default = 'tp tp-bubbles';

			}

			elseif ( $t->id_base === 'bbp_login_widget' ) {

				$default = 'tp tp-key';

			}

			elseif ( $t->id_base === 'bbp_replies_widget' ) {

				$default = 'tp tp-bubbles';

			}

			elseif ( $t->id_base === 'bbp_topics_widget' ) {

				$default = 'tp tp-bubbles';

			}

			elseif ( $t->id_base === 'bbp_stats_widget' ) {

				$default = 'tp tp-graph';

			}

			elseif ( $t->id_base === 'bbp_views_widget' ) {

				$default = 'tp tp-bubbles';

			}

			else {

				$default = '';

			}

			$instance = wp_parse_args( (array) $instance, array( 'icoclass' => $default ) );

			if ( ! isset( $instance['icoclass'] ) ) {

				$instance['icoclass'] = null;

			}

			?>

			<p>

				<label for="<?php echo $t->get_field_id( 'icoclass' ); ?>"><?php _e( 'Icon Class:', 'lsvrtheme' ); ?></label>

				<input type="text" class="widefat" name="<?php echo esc_attr( $t->get_field_name( 'icoclass' ) ); ?>" id="<?php echo esc_attr( $t->get_field_id( 'icoclass' ) ); ?>" value="<?php echo esc_attr( $instance[ 'icoclass' ] );?>">

			</p>

			<p><?php _e( 'For example "fa fa-heart". Please refer to the documentation to learn more about icons.', 'lsvrtheme' ); ?></p>

			<?php

			$return = null;

			return array( $t, $return, $instance );

		}

	}

	add_action( 'in_widget_form', 'lsvr_widget_ico_field', 5, 3 );

	if ( ! function_exists( 'lsvr_widget_ico_field_update' ) ) {

		function lsvr_widget_ico_field_update( $instance, $new_instance, $old_instance ) {

			$instance['icoclass'] = strip_tags( $new_instance['icoclass'] );

			return $instance;

		}

	}

	add_filter( 'widget_update_callback', 'lsvr_widget_ico_field_update', 5, 3 );

	if ( ! function_exists( 'lsvr_widget_ico_field_params' ) ) {

		function lsvr_widget_ico_field_params( $params ) {

			global $wp_registered_widgets;

			$widget_id = $params[0]['widget_id'];

			$widget_obj = $wp_registered_widgets[$widget_id];



			if ( ! empty( $widget_obj['_wo_original_callback'][0]->option_name ) ) {

				$widget_opt = get_option( $widget_obj['_wo_original_callback'][0]->option_name );

			} else if ( ! empty( $widget_obj['callback'][0]->option_name ) ) {

				$widget_opt = get_option( $widget_obj['callback'][0]->option_name );

			}



			if ( ! empty( $widget_opt ) ) {

				$widget_num = $widget_obj['params'][0]['number'];

				if ( isset( $widget_opt[$widget_num]['icoclass'] ) && $widget_opt[$widget_num]['icoclass'] !== '' ){

					$params[0]['before_title'] = '<h3 class="widget-title m-has-ico"><i class="widget-ico ' . $widget_opt[$widget_num]['icoclass'] . '"></i>';

				}

			}



			return $params;



		}

	}

	add_filter( 'dynamic_sidebar_params', 'lsvr_widget_ico_field_params' );



	// ENABLE SHORTCODES FOR TEXT WIDGET

    add_filter( 'widget_text', 'do_shortcode' );



	// ENABLE HTML IN WIDGET TITLE

	if ( ! function_exists( 'lsvr_widget_title_html' ) ) {

		function lsvr_widget_title_html( $title ) {

			$title = str_replace( '[', '<', $title );

			$title = str_replace( '[/', '</', $title );

			$title = str_replace( 'strong]', 'strong>', $title );

			return $title;

		}

	}

	add_filter( 'widget_title', 'lsvr_widget_title_html' );



    /* -------------------------------------------------------------------------

        OTHER ACTIONS

    ------------------------------------------------------------------------- */



	// CONTACT FORM 7 DEREGISTER CSS

	if ( ! function_exists( 'lsvr_cf7_deregister_styles' ) ) {

		function lsvr_cf7_deregister_styles() {

			wp_deregister_style( 'contact-form-7' );

		}

	}

	add_action( 'wp_print_styles', 'lsvr_cf7_deregister_styles', 100 );



	// ENABLE SHORTCODES IN EXCERPT

	add_filter( 'the_excerpt', 'do_shortcode' );



	// REDIRECT AFTER LOGIN

	if ( lsvr_get_field( 'login_redirect_home', false, true ) ) {

		if ( ! function_exists( 'lsvr_login_redirect' ) ) {

			function lsvr_login_redirect() {

				return home_url();

			}

		}

		add_filter( 'login_redirect', 'lsvr_login_redirect', 10, 3 );

	}



	// TITLE FILTER

	if ( ! function_exists( 'lsvr_document_title_parts' ) ) {

		function lsvr_document_title_parts( $title ){



			$page_id = lsvr_get_current_page_id();



			if ( is_home() || is_tag() || is_day() || is_month() || is_year() || is_author() || is_category() ) {

				if ( get_option( 'page_for_posts' ) ) {

					$prefix = get_the_title( get_option( 'page_for_posts' ) );

				}

				elseif ( lsvr_get_field( 'articles_base_page' ) ) {

					$prefix = get_the_title( lsvr_get_field( 'articles_base_page' ) );

				}

				else {

					$prefix = __( 'Blog', 'lsvrtheme' );

				}

			}

			elseif ( is_singular( 'post' ) || is_singular( 'lsvrnotice' ) || is_singular( 'lsvrdocument' ) || is_singular( 'lsvrevent' ) || is_singular( 'lsvrgallery' ) ) {

				$prefix = get_the_title();

			}

			elseif ( is_page() ) {

				$prefix = get_the_title();

			}

			elseif ( $page_id && ( is_post_type_archive( 'lsvrnotice' ) || is_post_type_archive( 'lsvrdocument' ) || is_post_type_archive( 'lsvrevent' ) || is_post_type_archive( 'lsvrgallery' ) ) ){

				$prefix = get_the_title( $page_id );

			}

			elseif ( is_tax( 'lsvrnoticecat' ) || is_tax( 'lsvreventcat' ) ) {

				global $wp_query;

				$current_term = $wp_query->queried_object;

				$prefix = $current_term->name;

			}

			elseif ( is_search() ) {

				$prefix = __( 'Search Results', 'lsvrtheme' );

			}

			elseif ( is_404() ) {

				$prefix = __( '404 Page Not Found', 'lsvrtheme' );

			}

			else {

				$prefix = get_the_title();

			}

			$title['title'] = $prefix;

			return $title;



		}

	}

	add_filter( 'document_title_parts', 'lsvr_document_title_parts', 10, 2 );



	// TITLE SEPARATOR

	if ( ! function_exists( 'lsvr_document_title_separator' ) ) {

		function lsvr_document_title_separator( $sep ){

			$sep = '|';

			return $sep;

		}

	}

	add_filter( 'document_title_separator', 'lsvr_document_title_separator', 10 );



	// INCLUDE LOCAL WEATHER AJAX SCRIPT

	if ( ! function_exists( 'lsvr_add_local_weather_ajax' ) ) {

		function lsvr_add_local_weather_ajax() {

			if ( lsvr_get_field( 'locale_weather_enable', false, true ) ) {

				add_action( 'wp_ajax_lsvr_local_weather', 'lsvr_local_weather' );

				add_action( 'wp_ajax_nopriv_lsvr_local_weather', 'lsvr_local_weather' );

				function lsvr_local_weather() {

					include( 'ajax/local-weather.php' );

					die();

				}

			}

		}

	}

    add_action( 'init', 'lsvr_add_local_weather_ajax' );



}





/* -----------------------------------------------------------------------------



    VARIOUS FUNCTIONS AND FIXES



----------------------------------------------------------------------------- */



    /* -------------------------------------------------------------------------

        REMOVE ADMIN BAR BUMP

    ------------------------------------------------------------------------- */



	add_action( 'get_header', 'lsvr_lore_remove_adminbar_bump' );

	if ( ! function_exists( 'lsvr_lore_remove_adminbar_bump' ) ) {

  		function lsvr_lore_remove_adminbar_bump() {

    		remove_action( 'wp_head', '_admin_bar_bump_cb' );

  		}

  	}



    /* -------------------------------------------------------------------------

        ENABLE STYLE SWITCHER

    ------------------------------------------------------------------------- */



	if ( defined( 'LSVR_DEMO' ) && true == LSVR_DEMO ) {

		add_filter( 'body_class', 'lsvr_townpress_style_switcher_body_class' );

		if ( ! function_exists( 'lsvr_townpress_style_switcher_body_class' ) ) {

			function lsvr_townpress_style_switcher_body_class( $classes ) {

				$classes[] = 'm-style-switcher';

				return $classes;

			}

		}

	}



    /* -------------------------------------------------------------------------

        EXPORT XML FIX

    ------------------------------------------------------------------------- */



	if ( ! function_exists( 'lsvr_dummy_wp_get_attachment_url' ) ) {

		function lsvr_dummy_wp_get_attachment_url( $url, $post_id ){

			return 'http://s2.postimg.org/n2r0cqtyh/dummy.jpg';

		}

	}

    //add_filter( 'wp_get_attachment_url' , 'lsvr_dummy_wp_get_attachment_url' , 10 , 2 );





?>