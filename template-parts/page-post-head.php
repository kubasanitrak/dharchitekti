<?php
/**
 * Displays page-post-head
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>
<div class="section section-header" id="headerID">
	<div class="nav">	
	<!-- CUSTOM MENU DIFFERENT FOR FRONT PAGE / INDEX / CONTACT / PROJECT DETAIL PAGE -->
			<div class="menu">
				<?php wp_nav_menu( array(
					'theme_location' => 'main-menu',
					'container' => '',
					'menu_class' => 'main-nav-list nav-list list-none',
				) ); ?>
				<!-- LANGSWITCH -->
				<?php do_action('wpml_add_language_selector'); ?>
				<!-- END LANGSWITCH -->
			</div><!-- END DIV CLASS MENU -->
	<!-- END MENU -->
	
	<!-- LOGO -->
		<?php require_once( 'logo.php' ); ?>
	<!-- END LOGO -->

	</div> <!-- END NAV -->
</div> <!-- END HEADER -->

<!-- <h1><?php #echo office_page_url(); ?></h1> -->

