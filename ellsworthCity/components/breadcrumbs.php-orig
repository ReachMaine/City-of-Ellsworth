<!-- BREADCRUMBS : begin -->
<div class="breadcrumbs"><ul>

<?php // HOME LINK
if ( lsvr_get_field( 'breadcrumbs_home_enable', true, true ) ) : ?>

	<?php if ( function_exists( 'pll__' ) ) : ?>
		<li class="home"><a href="<?php echo esc_url( home_url() ); ?>"><?php echo pll__( lsvr_get_field( 'header_breadcrumbs_home_label', __( 'Home', 'lsvrtheme' ) ) ); ?></a></li>
	<?php else: ?>
		<li class="home"><a href="<?php echo esc_url( home_url() ); ?>"><?php echo lsvr_get_field( 'header_breadcrumbs_home_label', __( 'Home', 'lsvrtheme' ) ); ?></a></li>
	<?php endif; ?>

<?php endif; ?>

<?php // BLOG
if ( get_option( 'page_for_posts' ) ) : ?>
	<?php $blog_page_html = '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a></li>';	?>
<?php elseif ( lsvr_get_field( 'articles_base_page' ) ) : ?>
	<?php $blog_page_html = '<li><a href="' . esc_url( home_url() ) . '">' . get_the_title( lsvr_get_field( 'articles_base_page' ) ) . '</a></li>';	?>
<?php else : ?>
	<?php $blog_page_html = '<li><a href="' . esc_url( home_url() ) . '">' . __( 'Blog', 'lsvrtheme' ) . '</a></li>';	?>
<?php endif; ?>

<?php if ( is_home() ) : ?>

	<?php echo $blog_page_html; ?>

<?php elseif ( is_tag() ) : ?>

	<?php echo $blog_page_html; ?>
	<li><?php echo single_tag_title( '', false ); ?></li>

<?php elseif ( is_day() ) : ?>

	<?php echo $blog_page_html; ?>
	<li><?php echo sprintf( __( 'Archive for %s', 'lsvrtheme' ), get_the_time( 'F jS, Y' ) ); ?></li>

<?php elseif ( is_year() ) : ?>

	<?php echo $blog_page_html; ?>
	<li><?php echo sprintf( __( 'Archive for %s', 'lsvrtheme' ), get_the_time( 'Y' ) ); ?></li>

<?php elseif ( is_author() ) : ?>

	<?php echo $blog_page_html; ?>
	<li><?php echo __( 'Author Archive', 'lsvrtheme' ); ?></li>

<?php elseif ( is_singular( 'post' ) ) : ?>

	<?php echo $blog_page_html; ?>
	<li><?php echo get_the_title(); ?></li>

<?php elseif ( is_category() ) : ?>

	<?php global $wp_query;
	$current_term = $wp_query->queried_object;
	$current_term_id = $current_term->term_id;
	$parent_ids = lsvr_get_term_parents( $current_term_id, 'category' );
	$parents_html = '';
	if ( is_array( $parent_ids ) ) {
		foreach( $parent_ids as $parent_id ){
			$parent = get_term( $parent_id, 'category' );
			$parents_html .= '<li><a href="' . esc_url( get_term_link( $parent, 'category' ) ) .'">' . $parent->name . '</a></li>';
		}
	} ?>

	<?php echo $blog_page_html . $parents_html; ?>
	<li><?php echo $current_term->name; ?></li>

<?php // PAGE
elseif ( is_page() ) : ?>

	<?php global $post;
	$parent_id  = $post->post_parent;
	$breadcrumbs = array();
	while ( $parent_id ) {
		$page = get_page( $parent_id );
		$breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '" title="">' . get_the_title( $page->ID ) . '</a>';
		$parent_id = $page->post_parent;
	}
	$breadcrumbs = array_reverse( $breadcrumbs );
	$parents_html = '';
	foreach ( $breadcrumbs as $crumb ) {
		$parents_html .= '<li>' . $crumb . '</li>';
	} ?>

	<?php echo $parents_html; ?>
	<li><?php echo get_the_title(); ?></li>

<?php // NOTICE CPT
elseif ( is_post_type_archive( 'lsvrnotice' ) ) : ?>

	<li><?php echo get_the_title( lsvr_get_current_page_id() ); ?></li>

<?php elseif ( is_singular( 'lsvrnotice' ) ) : ?>

	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrnotice' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<li><?php echo get_the_title(); ?></li>

<?php elseif ( is_tax( 'lsvrnoticecat' ) ) : ?>

	<?php global $wp_query; ?>
	<?php $current_term = $wp_query->queried_object; ?>
	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrnotice' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<?php $term_parents_arr = lsvr_get_term_parents( $current_term->term_id, 'lsvrnoticecat' ); ?>
	<?php if ( is_array( $term_parents_arr ) ) : ?>
		<?php foreach ( $term_parents_arr as $term_id ) : ?>
			<?php $term = get_term( $term_id, 'lsvrnoticecat' ); ?>
			<li><a href="<?php echo esc_url( get_term_link( $term, 'lsvrnoticecat' ) ); ?>"><?php echo $term->name; ?></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
	<li><?php echo $current_term->name; ?></li>

<?php // DOCUMENT CPT
elseif ( is_post_type_archive( 'lsvrdocument' ) ) : ?>

	<?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>

	<?php if ( $is_archive ) : ?>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrdocument' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
		<li><?php _e( 'Archive', 'lsvrtheme' ); ?></li>
	<?php else : ?>
		<li><?php echo get_the_title( lsvr_get_current_page_id() ); ?></li>
	<?php endif; ?>

<?php elseif ( is_singular( 'lsvrdocument' ) ) : ?>

	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrdocument' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<li><?php echo get_the_title(); ?></li>

<?php elseif ( is_tax( 'lsvrdocumentcat' ) ) : ?>

	<?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>

	<?php global $wp_query; ?>
	<?php $current_term = $wp_query->queried_object; ?>
	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrdocument' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<?php if ( $is_archive ) : ?>
		<li><a href="<?php echo esc_url( add_query_arg( array( 'archive' => 'true' ), get_post_type_archive_link( 'lsvrdocument' ) ) ); ?>"><?php _e( 'Archive', 'lsvrtheme' ); ?></a></li>
	<?php endif; ?>
	<?php $term_parents_arr = lsvr_get_term_parents( $current_term->term_id, 'lsvrdocumentcat' ); ?>
	<?php if ( is_array( $term_parents_arr ) ) : ?>
		<?php foreach ( $term_parents_arr as $term_id ) : ?>
			<?php $term = get_term( $term_id, 'lsvrdocumentcat' ); ?>
			<li><a href="<?php echo esc_url( get_term_link( $term, 'lsvrdocumentcat' ) ); ?>"><?php echo $term->name; ?></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
	<li><?php echo $current_term->name; ?></li>


<?php // EVENT CPT
elseif ( is_post_type_archive( 'lsvrevent' ) ) : ?>

	<?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>

	<?php if ( $is_archive ) : ?>
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrevent' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
		<li><?php _e( 'Archive', 'lsvrtheme' ); ?></li>
	<?php else : ?>
		<li><?php echo get_the_title( lsvr_get_current_page_id() ); ?></li>
	<?php endif; ?>

<?php elseif ( is_singular( 'lsvrevent' ) ) : ?>

	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrevent' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<li><?php echo get_the_title(); ?></li>

<?php elseif ( is_tax( 'lsvreventcat' ) ) : ?>

	<?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>

	<?php global $wp_query; ?>
	<?php $current_term = $wp_query->queried_object; ?>
	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrevent' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<?php if ( $is_archive ) : ?>
		<li><a href="<?php echo esc_url( add_query_arg( array( 'archive' => 'true' ), get_post_type_archive_link( 'lsvrevent' ) ) ); ?>"><?php _e( 'Archive', 'lsvrtheme' ); ?></a></li>
	<?php endif; ?>
	<?php $term_parents_arr = lsvr_get_term_parents( $current_term->term_id, 'lsvreventcat' ); ?>
	<?php if ( is_array( $term_parents_arr ) ) : ?>
		<?php foreach ( $term_parents_arr as $term_id ) : ?>
			<?php $term = get_term( $term_id, 'lsvreventcat' ); ?>
			<li><a href="<?php echo esc_url( get_term_link( $term, 'lsvreventcat' ) ); ?>"><?php echo $term->name; ?></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
	<li><?php echo $current_term->name; ?></li>

<?php // GALLERY CPT
elseif ( is_post_type_archive( 'lsvrgallery' ) ) : ?>

	<li><?php echo get_the_title( lsvr_get_current_page_id() ); ?></li>

<?php elseif ( is_singular( 'lsvrgallery' ) ) : ?>

	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrgallery' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<li><?php echo get_the_title(); ?></li>

<?php elseif ( is_tax( 'lsvrgallerycat' ) ) : ?>

	<?php global $wp_query; ?>
	<?php $current_term = $wp_query->queried_object; ?>
	<li><a href="<?php echo esc_url( get_post_type_archive_link( 'lsvrgallery' ) ); ?>"><?php echo get_the_title( lsvr_get_current_page_id() ); ?></a></li>
	<?php $term_parents_arr = lsvr_get_term_parents( $current_term->term_id, 'lsvrgallerycat' ); ?>
	<?php if ( is_array( $term_parents_arr ) ) : ?>
		<?php foreach ( $term_parents_arr as $term_id ) : ?>
			<?php $term = get_term( $term_id, 'lsvrgallerycat' ); ?>
			<li><a href="<?php echo esc_url( get_term_link( $term, 'lsvrgallerycat' ) ); ?>"><?php echo $term->name; ?></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
	<li><?php echo $current_term->name; ?></li>

<?php // FORUMS
elseif ( function_exists( 'is_bbpress' ) && function_exists( 'bbp_breadcrumb' ) && is_bbpress() ) : ?>

	<?php bbp_breadcrumb( array(
		'before' => '',
		'after' => '',
		'sep' => ' ',
		'crumb_before' => '<li>',
		'crumb_after' => '</li>',
		'include_home' => false,
	)); ?>

<?php // 404
elseif ( is_404() ) : ?>

	<li><?php echo __( 'Page Not Found', 'lsvrtheme' ); ?></li>

<?php // SEARCH
elseif ( is_search() ) : ?>

	<li><?php echo __( 'Search Results', 'lsvrtheme' ); ?></li>

<?php endif; ?>

</ul></div>
<!-- BREADCRUMBS : end -->