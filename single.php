<?php
/**
 * Template Name: SINGLE POST
 *
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

<style>
</style>



		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<?php 
				if ( in_category('works-cs') || in_category('projekt')  || in_category('realizace') ||  in_category('works-en') || in_category('project')  || in_category('realisation') ):
					@include('template-parts/single-project.php');
			?>
			<?php 
				else:
			?>
				<div class="section" data-theme="default">
					<?php the_content(); ?>
				</div><!-- END SECTION CONTENT -->
			<?php
				endif;
			?>
		<?php endwhile; endif; ?>

		<?php 
			if ( in_category('works-cs') || in_category('projekt') || in_category('realizace') ||  in_category('works-en') || in_category('project')  || in_category('realisation') ):
				@include('template-parts/prev-all-next-project.php');
			endif;
		?>
		

<!-- MENU + SOCIAL LINKS -->
	<?php get_footer(); ?>