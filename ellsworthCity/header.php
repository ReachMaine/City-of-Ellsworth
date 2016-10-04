<?php /* mods 
    Sept16 zig - add coe_below_header widget area 
	4Oct16 zig - add gtm function call.
*/ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head data-template-uri="<?php echo get_template_directory_uri() ?>">
    <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( lsvr_get_image_field( 'favicon' ) ) { ?><link rel="shortcut icon" href="<?php echo lsvr_get_image_field( 'favicon' ); ?>"><?php } ?>
    <?php wp_head(); ?>
</head>

<?php $page_id = lsvr_get_current_page_id(); ?>

<?php // BODY CLASS
$body_class = defined( 'enable_style_switcher' ) && enable_style_switcher ? 'm-style-switcher' : '';
$body_class .= lsvr_get_image_field( 'header_bg_image' ) ? ' m-has-header-bg' : ''; ?>

<body <?php body_class( $body_class ); ?>>
	<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
	<?php if ( $page_id && get_post_meta( $page_id, 'meta_header_menu_enable', true ) === 'enable' ) {
		$enable_header_menu = true;
	} elseif ( $page_id && get_post_meta( $page_id, 'meta_header_menu_enable', true ) === 'disable' ) {
		$enable_header_menu = false;
	} else {
		$enable_header_menu = lsvr_get_field( 'header_menu_enable', false, true );
	}
	if ( $page_id && get_post_meta( $page_id, 'meta_header_gmap_enable', true ) === 'enable' ) {
		$enable_gmap = true;
	} elseif ( $page_id && get_post_meta( $page_id, 'meta_header_gmap_enable', true ) === 'disable' ) {
		$enable_gmap = false;
	} else {
		$enable_gmap = lsvr_get_field( 'header_gmap_enable', true, true );
	}
	$enable_header_search = lsvr_get_field( 'header_search_enable', true, true ) ? true : false;
	$enable_header_login = class_exists( 'bbPress' ) && lsvr_get_field( 'header_login_enable', false, true ) && lsvr_get_field( 'header_login_page' ) !== '' ? true : false;
	$enable_lang_switcher = function_exists( 'icl_object_id' ) && function_exists( 'icl_get_languages' ) && lsvr_get_field( 'localization_switcher_enable', 'wpml' ) === 'wpml' ? true : false;

	$header_class = has_nav_menu( 'main' ) && $enable_header_menu ? ' m-has-standard-menu' : '';
	$header_class .= $enable_gmap || $enable_header_search || $enable_header_login || $enable_lang_switcher ? ' m-has-header-tools' : '';
	$header_class .= $enable_gmap ? ' m-has-gmap' : '';
	$header_class .= $enable_header_search ? ' m-has-search' : '';
	$header_class .= $enable_header_login ? ' m-has-login' : '';
	$header_class .= $enable_lang_switcher ? ' m-has-lang-switcher' : '';
	$header_class = trim( $header_class ); ?>

	<!-- HEADER : begin -->
	<header id="header"<?php if ( $header_class !== '' ) { echo ' class="' . $header_class . '"'; } ?>>
		<div class="header-inner">

			<!-- HEADER CONTENT : begin -->
			<div class="header-content">
				<div class="c-container">
					<div class="header-content-inner">

						<?php if ( lsvr_get_image_field( 'header_logo' ) ) : ?>
						<!-- HEADER BRANDING : begin -->

						<?php $header_branding_class = 'm-small-logo'; ?>
						<?php if ( $page_id && get_post_meta( $page_id, 'meta_header_logo_size', true ) === 'small' ) : ?>
							<?php $header_branding_class = 'm-small-logo'; ?>
						<?php elseif ( $page_id && get_post_meta( $page_id, 'meta_header_logo_size', true ) === 'large' ) : ?>
							<?php $header_branding_class = 'm-large-logo'; ?>
						<?php else: ?>
							<?php $header_branding_class = 'm-' . lsvr_get_field( 'header_logo_size', 'small' ) . '-logo'; ?>
						<?php endif; ?>
						<div class="header-branding <?php echo esc_attr( $header_branding_class ); ?>">

							<a href="<?php echo esc_url( home_url() ); ?>"><span><img src="<?php echo esc_url( lsvr_get_image_field( 'header_logo' ) ); ?>"
							<?php if ( lsvr_get_image_field( 'header_logo_2x' ) ) { ?> data-hires="<?php echo esc_url( lsvr_get_image_field( 'header_logo_2x' ) ); ?>"<?php } ?>
							alt="<?php bloginfo( 'name' ); ?>"></span></a>

						</div>
						<!-- HEADER BRANDING : end -->
						<?php endif; ?>

						<!-- HEADER TOGGLE HOLDER : begin -->
						<div class="header-toggle-holder">

							<!-- HEADER TOGGLE : begin -->
							<button class="header-toggle" type="button">
								<i class="ico-open tp tp-menu"></i>
								<i class="ico-close tp tp-cross"></i>
								<span><?php _e( 'Menu', 'lsvrtheme' ); ?></span>
							</button>
							<!-- HEADER TOGGLE : end -->

							<?php if ( $enable_gmap ) : ?>
							<!-- HEADER GMAP SWITCHER : begin -->
							<button class="header-gmap-switcher" type="button" title="<?php _e( 'Show on Map', 'lsvrtheme' ); ?>">
								<i class="ico-open tp tp-map2"></i>
								<i class="ico-close tp tp-cross"></i>
							</button>
							<!-- HEADER GMAP SWITCHER : end -->
							<?php endif; ?>

						</div>
						<!-- HEADER TOGGLE HOLDER : end -->

						<?php if ( has_nav_menu( 'main' ) ) : ?>
						<!-- HEADER MENU : begin -->
						<div class="header-menu">
							<?php // MAIN MENU
							get_template_part( 'components/menu-main' ); ?>
						</div>
						<!-- HEADER MENU : end -->
						<?php endif; ?>

						<?php if ( $enable_header_search || $enable_header_login || $enable_gmap || $enable_lang_switcher ) : ?>
						<!-- HEADER TOOLS : begin -->
						<div class="header-tools">

							<?php if ( $enable_header_search ) : ?>
							<!-- HEADER SEARCH : begin -->
							<div class="header-search">
								<?php get_search_form() ?>
							</div>
							<!-- HEADER SEARCH : end -->
							<?php endif; ?>

							<?php if ( $enable_header_login ) : ?>
							<!-- HEADER LOGIN : begin -->
							<div class="header-login">
							<?php if ( is_user_logged_in() ) : ?>
								<?php $current_user = wp_get_current_user(); ?>
								<a href="<?php bbp_user_profile_edit_url( bbp_get_current_user_id() ); ?>" class="profile" title="<?php echo $current_user->display_name . ' ' . __( '(edit profile)', 'lsvrtheme' ); ?>"><?php echo get_avatar( $current_user->ID, 40 ); ?></a>
								<a href="<?php echo wp_logout_url( get_home_url() ); ?>" class="logout" title="<?php _e( 'Logout', 'lsvrtheme' ); ?>"><i class="tp tp-power-switch"></i></a>
							<?php else : ?>
								<a href="<?php echo get_page_link( (int) lsvr_get_field( 'header_login_page' ) ); ?>" class="login" title="<?php echo lsvr_get_field( 'header_login_label', __( 'Login', 'lsvrtheme' ) ); ?>"><i class="tp tp-key"></i> <span><?php echo lsvr_get_field( 'header_login_label', __( 'Login', 'lsvrtheme' ) ); ?></span></a>
							<?php endif; ?>
							</div>
							<!-- HEADER LOGIN : end -->
							<?php endif; ?>

							<?php if ( $enable_gmap ) : ?>
							<!-- HEADER GMAP SWITCHER : begin -->
							<button class="header-gmap-switcher" type="button" title="<?php _e( 'Show on Map', 'lsvrtheme' ); ?>">
								<?php if ( is_rtl() ) : ?>
									<span><?php _e( 'Map', 'lsvrtheme' ); ?></span>
								<?php endif; ?>
								<i class="ico-open tp tp-map2"></i>
								<i class="ico-close tp tp-cross"></i>
								<?php if ( ! is_rtl() ) : ?>
									<span><?php _e( 'Map', 'lsvrtheme' ); ?></span>
								<?php endif; ?>
							</button>
							<!-- HEADER GMAP SWITCHER : end -->
							<?php endif; ?>

							<?php if ( $enable_lang_switcher ) : ?>
								<?php $lang_arr = icl_get_languages( 'skip_missing=0' ); ?>
								<?php if ( is_array( $lang_arr ) && count( $lang_arr ) > 1 ) : ?>
								<!-- HEADER LANG SWITCHER : begin -->
								<div class="header-lang-switcher">
									<ul>
									<?php foreach ( $lang_arr as $lang ) : ?>
										<li><a href="<?php echo esc_url( $lang['url'] ); ?>"<?php if ( (bool) $lang['active'] ) { echo ' class="m-active"'; } ?>><?php echo $lang['language_code']; ?></a></li>
									<?php endforeach; ?>
									</ul>
								</div>
								<!-- HEADER LANG SWITCHER : end -->
								<?php endif; ?>
							<?php endif; ?>

						</div>
						<!-- HEADER TOOLS : end -->
						<?php endif; ?>

					</div>
				</div>

			</div>
			<!-- HEADER CONTENT : end -->

			<?php if ( $enable_gmap ) : ?>
			<!-- HEADER GOOGLE MAP : begin -->
			<div class="header-gmap">
				<div class="gmap-canvas"
					data-enable-mousewheel="<?php if ( lsvr_get_field( 'header_gmap_mouse_scroll_enable', true, true ) ) { echo 'true'; } else { echo 'false'; } ?>"
					data-maptype="<?php echo esc_attr( lsvr_get_field( 'header_gmap_type', 'satellite' ) ); ?>"
					data-zoom="<?php echo (int) esc_attr( lsvr_get_field( 'header_gmap_zoom', 17 ) ); ?>"
					<?php if ( lsvr_get_field( 'header_gmap_address', 'Main St, Stowe, VT 05672, USA' ) !== '' ) : ?>
					data-address="<?php echo esc_attr( lsvr_get_field( 'header_gmap_address', '8833 Sunset Blvd, West Hollywood, CA 90069, USA' ) ); ?>"
					<?php endif; ?>
					<?php if ( lsvr_get_field( 'header_gmap_latitude' ) !== '' ) : ?>
					data-latitude="<?php echo esc_attr( lsvr_get_field( 'header_gmap_latitude' ) ); ?>"
					<?php endif; ?>
					<?php if ( lsvr_get_field( 'header_gmap_longitude' ) !== '' ) : ?>
					data-longitude="<?php echo esc_attr( lsvr_get_field( 'header_gmap_longitude' ) ); ?>"
					<?php endif; ?>></div>
			</div>
			<!-- HEADER GOOGLE MAP : end -->
			<?php endif; ?>

		</div>
	</header>
	<!-- HEADER : end -->

	<!-- HEADER BG : begin -->
	<div class="header-bg">

		<!-- HEADER IMAGE : begin -->
		<div class="header-image" data-autoplay="<?php echo (int) esc_attr( lsvr_get_field( 'header_slideshow_speed', 5 ) ); ?>">
			<?php $image_layer_arr = array(); ?>
			<?php // FIRST IMAGE
			if ( ( ( is_singular( 'post' ) && lsvr_get_field( 'article_detail_thumb', 'header' ) === 'header' )
				|| ( is_singular( 'lsvrnotice' ) && lsvr_get_field( 'notice_detail_thumb', 'header' ) === 'header' )
				|| ( is_singular( 'lsvrevent' ) && lsvr_get_field( 'event_detail_thumb', 'header' ) === 'header' )
				|| ( is_singular( 'lsvrgallery' ) && lsvr_get_field( 'gallery_detail_thumb', 'header' ) === 'header' ) )
				&& has_post_thumbnail( get_queried_object_id() ) ) {

				$image_data = lsvr_get_image_data( get_post_thumbnail_id( get_queried_object_id() ) );
				array_push( $image_layer_arr, $image_data['full'] );

			} elseif ( $page_id && has_post_thumbnail( $page_id )
				&& ( ( is_singular( 'lsvrnotice' ) && ( ! has_post_thumbnail( get_queried_object_id() ) || lsvr_get_field( 'notice_detail_thumb', 'header' ) !== 'header' ) )
				|| is_post_type_archive( 'lsvrnotice' ) || is_tax( 'lsvrnoticecat' ) ) ) {

				$image_data = lsvr_get_image_data( get_post_thumbnail_id( $page_id ) );
				array_push( $image_layer_arr, $image_data['full'] );

			} elseif ( $page_id && has_post_thumbnail( $page_id )
				&& ( ( is_singular( 'lsvrevent' ) && ( ! has_post_thumbnail( get_queried_object_id() ) || lsvr_get_field( 'event_detail_thumb', 'header' ) !== 'header' ) )
				|| is_post_type_archive( 'lsvrevent' ) || is_tax( 'lsvreventcat' ) ) ) {

				$image_data = lsvr_get_image_data( get_post_thumbnail_id( $page_id ) );
				array_push( $image_layer_arr, $image_data['full'] );

			} elseif ( $page_id && has_post_thumbnail( $page_id )
				&& ( ( is_singular( 'lsvrgallery' ) && ( ! has_post_thumbnail( get_queried_object_id() ) || lsvr_get_field( 'gallery_detail_thumb', 'header' ) !== 'header' ) )
				|| is_post_type_archive( 'lsvrgallery' ) || is_tax( 'lsvrgallerycat' ) ) ) {

				$image_data = lsvr_get_image_data( get_post_thumbnail_id( $page_id ) );
				array_push( $image_layer_arr, $image_data['full'] );

			} elseif ( $page_id && has_post_thumbnail( $page_id )
				&& ( is_singular( 'lsvrdocument' )
				|| is_post_type_archive( 'lsvrdocument' ) || is_tax( 'lsvrdocumentcat' ) ) ) {

				$image_data = lsvr_get_image_data( get_post_thumbnail_id( $page_id ) );
				array_push( $image_layer_arr, $image_data['full'] );

			}
			elseif ( ( is_page() || is_home() ) && $page_id && has_post_thumbnail( $page_id ) ) {

				$image_data = lsvr_get_image_data( get_post_thumbnail_id( $page_id ) );
				array_push( $image_layer_arr, $image_data['full'] );

			}
			elseif ( lsvr_get_image_field( 'header_bg_image' ) ) {
				array_push( $image_layer_arr, lsvr_get_image_field( 'header_bg_image' ) );
			} ?>

			<?php // GET SLIDESHOW IMAGES
			if ( $page_id && get_post_meta( $page_id, 'meta_header_slideshow_enable', true ) === 'enable' ) {
				$enable_slideshow = true;
			} elseif ( $page_id && get_post_meta( $page_id, 'meta_header_slideshow_enable', true ) === 'disable' ) {
				$enable_slideshow = false;
			} else {
				$enable_slideshow = lsvr_get_field( 'header_slideshow_enable', true, true );
			}
			if ( $enable_slideshow && lsvr_get_field( 'header_slideshow_images', '' ) !== '' ) {
				$images_arr = explode( ',', lsvr_get_field( 'header_slideshow_images' ) );
				if ( is_array( $images_arr ) ) {
					foreach ( $images_arr as $image_id ) {
						$image_data = lsvr_get_image_data( $image_id );
						if ( $image_data ) {
							array_push( $image_layer_arr, $image_data['full'] );
						}
					}
				}
			} ?>

			<?php foreach ( $image_layer_arr as $layer ) : ?>
				<div class="image-layer" style="background-image: url( '<?php echo esc_url( $layer ); ?>' );"></div>
			<?php endforeach; ?>

		</div>
		<!-- HEADER IMAGE : begin -->

	</div>
	<!-- HEADER BG : end -->

	<!-- CORE : begin -->
	<div id="core" <?php post_class(); ?>>
		<?php if ( is_active_sidebar( 'coe_below_header') ) { // zig
				echo '<div class="c-container">';
					echo '<div class="row">';
						echo '<div id="coe_below_header" class="c-content-box">';
							dynamic_sidebar( 'coe_below_header' );
						echo '</div>';
					echo '</div>'; // end row
				echo '</div>'; // end container
		} ?>
		<div class="c-container">