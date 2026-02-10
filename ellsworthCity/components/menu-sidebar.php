<?php 
/* added 10Feb26 for separate sidebar menu */
if ( has_nav_menu( 'sidebar-menu' ) ) : ?>

	<!-- SIDEBAR MENU : begin -->

	<nav class="main-menu"> <?/* keep class for JS */ ?>

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'sidebar-menu',
				'container'       => '',
				//'menu_id'         => 'menu-main-items',
				'menu_class'      => 'menu-items clearfix',
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			)
		); ?>

	</nav>
	<!-- SIDEBAR MENU : end -->

<?php endif; ?>