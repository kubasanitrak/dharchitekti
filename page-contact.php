<?php
/**
 * Template Name: PAGE CONTACT
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

    get_header(); ?>

<div class="section section-header bg-solid" id="headerID">
    <div class="nav">   
    <!-- CUSTOM MENU DIFFERENT FOR FRONT PAGE / INDEX / CONTACT -->
            <!-- main-menu selekce-menu index-menu -->
            <div class="menu">
                <?php wp_nav_menu( array(
                    // 'theme_location' => 'main-menu',
                    'theme_location' => 'office-menu',
                    'container' => '',
                    'menu_class' => 'main-nav-list nav-list list-none',
                ) ); ?>
                <!-- LANGSWITCH -->
                <?php do_action('wpml_add_language_selector'); ?>
                <!-- END LANGSWITCH -->
            </div><!-- END DIV CLASS MENU -->
    <!-- END MENU -->
    
    <!-- LOGO -->

        <?php 
            $HIDE_LOGO_ON_MOBILE_CLASS = "landscape-only";
            require_once( 'template-parts/logo.php' );
        ?>

    </div> <!-- END NAV -->

<div class="section full-bleed section-subnav">
    <?php wp_nav_menu( array(
        'theme_location' => 'office-submenu',
        'container' => '',
        'menu_class' => 'main-nav-list nav-list list-none sub-nav-list',
    ) ); ?>
</div>
</div> <!-- END HEADER -->

<!-- dha LOGO = ANIMATION -->
<?php require_once( 'template-parts/logotyp.php' ); ?>


	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div class="section section-contact-content zero-top">
			<?php the_content(); ?>
            <!-- <div class="overlay fscreen" id="overlayID"></div> -->
            
		</div><!-- END SECTION CONTENT -->

		
	<?php endwhile; endif; ?>


<style>
    .contact-hide {display: none; pointer-events: none; visibility: hidden;}
</style>
	<?php get_footer(); ?>