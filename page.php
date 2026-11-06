<?php
/**
 * Template Name: PAGE
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

    get_header();
    include('template-parts/page-post-head.php');
?>



	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 

      if( is_front_page() ) :
         include('template-parts/page-frontpage-logo-intro.php');
			the_content();
      ?>
         <div class="section section--footnav" id="prevnext-proj-ID">
            <div class="footnav-link footnav-link--previous"></div>
   <?php include('template-parts/all-works-footnav.php');  ?>
            <div class="footnav-link footnav-link--next"></div>
         </div>
   <?php
      else :
   ?>

		<div class="section" data-theme="default">
         <?php the_content(); ?>
		</div><!-- END SECTION CONTENT -->
   <?php endif; ?>
		
	<?php endwhile; endif; ?>


	<?php get_footer(); ?>