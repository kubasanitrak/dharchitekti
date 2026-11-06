<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>
<!-- 
	NAVIGATION:
	kontakt
	LANGSWITCH
	LOGO=FRONTPAGE(SELECTION)

	HP SPECIFIC NAV:
	INDEX / SELECTION

	NAVIGATION FIXED / STICKY TOP PAD-T, RIGHT PAD-R
 -->

	<!-- <input type="checkbox" id="menuBtnID" class="desktop-hide nav-switch"> -->
	<!-- <input type="checkbox" id="menuBtnID" class="desktop-hide nav-switch" checked > -->
	<!-- <label for="menuBtnID" class="hamburger hamburger--htx desktop-hide">
		<span class="">menu</span>
	</label> -->
	<div class="menu">

		<!-- <div class="search-container"><?php #get_search_form(); ?></div> -->

		<?php wp_nav_menu( array(
			'theme_location' => 'main-menu',
			'container' => '',
			'menu_class' => 'main-nav-list nav-list list-none accord color-highlight',
		) ); ?>
		<!-- SEARCH -->
		<?php #get_search_form(); ?>
	</div><!-- END DIV CLASS MENU -->
