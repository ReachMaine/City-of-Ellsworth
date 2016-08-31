<?php /* Mods
* 17Jun16 zig - make content area 7 cols & Right column 2
*/ ?>
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

<?php if ( $primary_sidebar_enabled || $secondary_sidebar_enabled ) : ?>
	<hr class="c-separator m-margin-top-small m-margin-bottom-small m-transparent hidden-lg hidden-md">
<?php endif; ?>

</div>

<?php $side_menu_class = $sidebar_menu_position === 'left' ? ' m-left-side' : ' m-right-side'; ?>
<?php $side_menu_class .= lsvr_get_field( 'sidebar_menu_submenu_visible', true, true ) ? ' m-show-submenu' : ''; ?>

<?php if ( $primary_sidebar_enabled ) : ?>
<?php $left_column_class = ( $primary_sidebar_enabled && $secondary_sidebar_enabled ) ? ' col-md-pull-7' : ' col-md-pull-9'; ?>
<div class="col-md-3 left-column<?php echo esc_attr( $left_column_class ); ?>">

	<?php if ( $sidebar_menu_position === 'left' ) : ?>
		<div class="side-menu<?php echo esc_attr( $side_menu_class ); ?>">
			<?php // MAIN MENU
			get_template_part( 'components/menu-main' ); ?>
		</div>
	<?php endif; ?>

	<?php // PRIMARY SIDEBAR
	get_template_part( 'components/sidebar-primary' ); ?>

</div>
<?php endif; ?>

<?php if ( $secondary_sidebar_enabled ) : ?>
<div class="col-md-2 right-column">

	<?php if ( $sidebar_menu_position === 'right' ) : ?>
		<div class="side-menu<?php echo esc_attr( $side_menu_class ); ?>">
			<?php // MAIN MENU
			get_template_part( 'components/menu-main' ); ?>
		</div>
	<?php endif; ?>

	<?php // SECONDARY SIDEBAR
	get_template_part( 'components/sidebar-secondary' ); ?>

</div>
<?php endif; ?>

</div>