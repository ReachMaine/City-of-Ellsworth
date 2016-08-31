<?php $page_id = lsvr_get_current_page_id(); ?>

<?php if ( $page_id && get_post_meta( $page_id, 'meta_sidebar_menu_position', true ) === 'left' ) : ?>
	<?php $sidebar_menu_position = 'left'; ?>
<?php elseif ( $page_id && get_post_meta( $page_id, 'meta_sidebar_menu_position', true ) === 'right' ) : ?>
	<?php $sidebar_menu_position = 'right'; ?>
<?php elseif ( $page_id && get_post_meta( $page_id, 'meta_sidebar_menu_position', true ) === 'disable' ) : ?>
	<?php $sidebar_menu_position = 'disable'; ?>
<?php else : ?>
	<?php $sidebar_menu_position = lsvr_get_field( 'sidebar_menu_position', 'left' ); ?>
<?php endif; ?>
<?php $sidebar_menu_position = ! has_nav_menu( 'main' ) ? 'disable' : $sidebar_menu_position; ?>

<?php $meta_sidebar_primary = $page_id ? get_post_meta( $page_id, 'meta_sidebar_primary', true ) : ''; ?>
<?php $meta_sidebar_primary = $meta_sidebar_primary === '' ? 'primary-sidebar' : $meta_sidebar_primary; ?>
<?php $meta_sidebar_secondary = $page_id ? get_post_meta( $page_id, 'meta_sidebar_secondary', true ) : ''; ?>
<?php $meta_sidebar_secondary = $meta_sidebar_secondary === '' ? 'secondary-sidebar' : $meta_sidebar_secondary; ?>

<?php if ( $sidebar_menu_position === 'left' || ( $meta_sidebar_primary !== 'disable' && is_active_sidebar( $meta_sidebar_primary ) ) ) : ?>
	<?php $primary_sidebar_enabled = true; ?>
<?php else : ?>
	<?php $primary_sidebar_enabled = false; ?>
<?php endif; ?>

<?php if ( $sidebar_menu_position === 'right' || ( $page_id && $meta_sidebar_secondary !== 'disable' && is_active_sidebar( $meta_sidebar_secondary ) ) ) : ?>
	<?php $secondary_sidebar_enabled = true; ?>
<?php else : ?>
	<?php $secondary_sidebar_enabled = false; ?>
<?php endif; ?>

<div class="row">

<?php if ( $primary_sidebar_enabled && $secondary_sidebar_enabled ) : ?>
	<div class="col-md-6 middle-column col-md-push-3">
<?php elseif ( $primary_sidebar_enabled || $secondary_sidebar_enabled ) : ?>
	<div class="col-md-9 middle-column<?php if ( $primary_sidebar_enabled ) { echo ' col-md-push-3'; } ?>">
<?php else: ?>
	<div class="col-md-12 middle-column">
<?php endif; ?>

	<?php // PAGE HEADER
	get_template_part( 'components/page-header' ); ?>