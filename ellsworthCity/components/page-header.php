<?php /* 
* 20jun16 zig - move above content widget here....
*/ ?>
<?php $page_id = lsvr_get_current_page_id(); ?>

<?php $enable_title = $page_id && get_post_meta( $page_id, 'meta_content_title_enable', true ) === '0' ? false : true; ?>
<?php $enable_breadcrumbs = $page_id && get_post_meta( $page_id, 'meta_content_breadcrumbs_enable', true ) === '0' ? false : true; ?>

<?php if ( $enable_title ) : ?>
	<?php if ( is_singular( 'post' ) || is_singular( 'lsvrnotice' ) || is_singular( 'lsvrdocument' ) || is_singular( 'lsvrevent' ) || is_singular( 'lsvrgallery' ) ) : ?>
		<?php $title_string = get_the_title(); ?>
	<?php elseif ( is_tag() || is_category() || is_tax() ) : ?>
		<?php global $wp_query; ?>
		<?php $current_term = $wp_query->queried_object; ?>
		<?php $title_string = $current_term->name; ?>
	<?php elseif ( is_404() ) : ?>
		<?php $title_string = __( 'Page Not Found', 'lsvrtheme' ); ?>
	<?php elseif ( is_search() ) : ?>
		<?php $title_string = __( 'Search Results', 'lsvrtheme' ); ?>
	<?php elseif ( $page_id && get_post_meta( $page_id, 'meta_content_title', true ) !== '' ) : ?>
		<?php $title_string = get_post_meta( $page_id, 'meta_content_title', true ); ?>
	<?php elseif ( $page_id ) : ?>
		<?php $title_string = get_the_title( $page_id ); ?>
	<?php else : ?>
		<?php $title_string = get_the_title(); ?>
	<?php endif; ?>
<?php endif; ?>

<?php if ( $enable_title && $title_string !== '' ) : ?>

	<?php $page_header_class = $enable_breadcrumbs ? ' m-has-breadcrumbs' : ''; ?>

	<!-- PAGE HEADER : begin -->
	<div id="page-header"<?php if ( $page_header_class !== '' ) { echo ' class="' . $page_header_class . '"'; } ?>>

		<!-- PAGE TITLE : begin -->
		<div class="page-title"><h1><?php echo $title_string; ?></h1></div>
		<!-- PAGE TITLE : end -->

		<?php if ( $enable_breadcrumbs ) : ?>
		<?php // BREADCRUMBS
		get_template_part( 'components/breadcrumbs' ); ?>
		<?php endif; ?>

	</div>
	<!-- PAGE HEADER : end -->

<?php endif; ?>
<?php /* zig  */ 
	if ( is_active_sidebar( 'coe_above_content') ) {
		echo '<div id="coe_above_content" class="c-content-box">';
		dynamic_sidebar( 'coe_above_content' );
		echo '</div>';
	}
?>
