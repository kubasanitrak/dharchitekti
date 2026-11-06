<?php
/**
 * Displays all-works-footnav
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>

	<div class="footnav-link footnav-link--works">
		<!-- <a href="#"> <?php #_e('All_works', 'dharchitekti'); ?></a> -->
		<?php wp_nav_menu( array(
			'theme_location' => 'allworks',
			'container' => '',
			'menu_class' => 'footnav-link footnav-link--works list-none',
		) ); ?>
	</div>