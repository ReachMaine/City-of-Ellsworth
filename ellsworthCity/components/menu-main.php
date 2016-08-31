<?php /*
 * mods:
 *  21jun16 zig - add mobile menu.
 */ ?>
<?php if ( has_nav_menu( 'main' ) ) : ?>

	<!-- MAIN MENU : begin -->
	<nav class="main-menu">

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'main',
				'container'       => '',
				//'menu_id'         => 'menu-main-items',
				'menu_class'      => 'menu-items hide_mobile clearfix',
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			)
		); 

		if (has_nav_menu('mobile-menu')) {
 			wp_nav_menu(
				array(
					'theme_location'  => 'mobile-menu',
					'container'       => '',
					//'menu_id'         => 'menu-main-items',
					'menu_class'      => 'menu-items clearfix show_desktop',
					'fallback_cb'     => '',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
		} 

		?>


	</nav>
	<!-- MAIN MENU : end -->

<?php endif; ?>