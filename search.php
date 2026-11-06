<?php
    get_header();
    include('template-parts/page-post-head.php');
?>
<?php if ( have_posts() ) : ?>
<div class="section section-search-res--header flow">
    <h2 class="scroll-trigger" id="mentions">
    	<?php printf( __( 'Search Results for: %s', 'dharchitekti' ), get_search_query() ); ?>
    </h2>
</div>
<div class="section zero-top  section-search-res--content border-T">
<?php while ( have_posts() ) :
	the_post();
?>
		<div class="search-res-item flow mar-B">
			<div class="flow">
				<div class="search-res-item--content">
					<div class="search-res-item--caption">
		    			<h2 class="search-res-item--caption_title"><a class="search-res-item--caption_title_link" href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
		        		<p class="search-res-item--caption_excerpt"><?php echo get_the_excerpt(); ?></p>
		        		<?php
		        			if (has_post_thumbnail()) :
		        				// $tempID = get_the_ID();
		        				// $TEMP_THUMB_URL = wp_get_attachment_image_src( get_post_thumbnail_id( $tempID ), 'full' );
		        		?>
		        		<div class="search-res-item--content_img">
		        			<?php 
		        				the_post_thumbnail('full', ['class' => 'items-item--img lazyload', 'loading' => 'lazy']);
		        			?>
		        			<a href="" class="abs-link"></a>
		        		</div>
		        		<?php
		        			endif;
		        		?>
					</div>
				</div>
				<div class="search-res-item--footer">
		            <!-- <div class="wp-block-button is-style-outline"> -->
		                <!-- <a class="wp-block-button__link" href="<?php #the_permalink();?>"><?php #_e('Read full article', 'dharchitekti'); ?></a> -->
		                <a class="text-link" href="<?php the_permalink();?>"><?php _e('Read full article', 'dharchitekti'); ?></a>
		            <!-- </div> -->
		        </div>
			</div>
		</div>
<?php endwhile; ?>
<?php else : ?>
	<div class="section section-search-res--header  border-T flow">
	    <h2 class="scroll-trigger" id="mentions"> <?php _e( 'Nothing Found', 'dharchitekti' ); ?> </h2>
		<p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'dharchitekti' ); ?></p>
	</div>
<?php endif; ?>
</div><!-- END SECTION CONTENT -->
<?php get_footer(); ?>