<?php if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
	?>

	<?php if ( !empty( get_the_content() ) ): ?>
		<div class="section" data-theme="default">

			<?php the_content(); ?>

		</div><!-- END SECTION CONTENT -->
	<?php endif; ?>

	<?php 
			endwhile;
		endif; 
		wp_reset_query();
	?>


<!-- ALL POST CATEGORIES AS CLASSES -->
					<div class="items-item <?php echo $CLS_LIST; ?>">
						<!-- THE_POST_THUMBNAIL -->
						<!-- <img src="" alt="" class="items-item--img"> -->
						<?php the_post_thumbnail('post-thumbnail', ['class' => 'items-item--img lazyload', 'title' => 'Feature image', 'loading' => 'lazy']); ?>
						<!-- PROJ_YEAR -->
						<p class="items-item--year"><?php echo $PROJ_YEAR; ?></p>
						<!-- THE_TITLE -->
						<h2 class="items-item--title"><?php the_title(); ?></h2>
						<!-- THE_PERMALINK -->
						<a class="items-item--link" href="<?php the_permalink();?>"></a>
					</div><!-- END ITEMS-ITEM -->


<?php 
	$PROFILE_IMG = get_field( 'profile_photo' );
	$PROFILE_NAME = get_field( 'profile_name' );
	$PROFILE_MEMBERSHIP = get_field( 'profile_membership' );
	$PROFILE_ROLE = get_field( 'profile_role' );
	#$PROFILE_LINKS = get_field( 'profile_links' );
?>

<!-- <div class="section section-content section-post-caption scroll-trigger line-top line-top--orange"> -->
<div class="section section-content section-post-caption ">
	<div class="scroll-trigger line-top line-top--orange mar-B"></div>

<?php if ( in_category('people') || in_category('lide')): ?>
	<div class="">
		<?php if($PROFILE_IMG) : ?>
		<div class="profile-pic">
			<img src="<?php echo $PROFILE_IMG['url']; ?>" alt="" class="profile-pic--img">
		</div>
		<?php endif; ?>
	</div> <!-- END SECTION POST CONTENT -->
<?php endif; ?>

	<div class="title-container">
		<h3 class="article-item--caption_title"><?php the_title(); ?></h3>
	<!-- </div> -->
	<?php 
		if ( $PROFILE_MEMBERSHIP || $PROFILE_ROLE):
	?>
	<!-- <div class="subtitle-container"> -->
		<?php if($PROFILE_NAME): ?>
			<h4><?php echo $PROFILE_NAME; ?></h4>
		<?php endif; ?>

		<?php if($PROFILE_MEMBERSHIP): ?>
			<h5 class="article-item--caption_excerpt-title"><?php echo $PROFILE_MEMBERSHIP; ?></h5>
		<?php endif; ?>

		<?php if($PROFILE_ROLE): ?>
			<p class="minor"><?php echo $PROFILE_ROLE; ?></p>
		<?php endif; ?>
	</div>
	<?php endif; ?>
			<?php if( have_rows('profile_links') ): ?>
				<?php while( have_rows('profile_links') ): the_row(); ?>
					<?php if( get_row_layout() == 'link_item' ): ?>
						<h5 class="profile-link--item"><a href="<?php the_sub_field('link_item_value'); ?>"></a></h5>
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
	<?php #endif; ?>

	<?php 
		if ( in_category('news') || in_category('novinky') ):
	?>
		<!-- FEATURED IMG -->
		<!-- NEWS META -->
		<?php require_once( 'template-parts/clanek-meta.php' ); ?>
	<?php endif; ?>

	<?php if ( get_the_content() && in_category('people') || in_category('lide')): ?>
		<!-- <div class="section scroll-trigger line-top line-top--blue" id="contentID"> -->
		<div class="pad-T" id="contentID">
			<div class="scroll-trigger line-top line-top--blue mar-B"></div>
	<?php endif; ?>

	<?php the_content(); ?>

	<?php #if ( in_category('people') || in_category('lide')): ?>
	<?php if ( get_the_content() && in_category('people') || in_category('lide')): ?>
		</div>
	<?php endif; ?>

</div> <!-- END SECTION POST CONTENT -->

<?php endwhile; endif; ?>

<!-- LIST POSTS FROM SAME CATEGORY -->
<!-- <div class="section scroll-trigger line-top line-top--blue section-article--list" id="clankyID"> -->
<div class="section-article--list" id="clankyID">
<div class="scroll-trigger line-top line-top--blue pad-T"></div>
<?php
	// Default arguments
	$args = array(
		'posts_per_page' => -1, // How many items to display
		'post__not_in'   => array( get_the_ID() ), // Exclude current post
		// 'order' => 'ASC',
		'order' => 'DESC',
		'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
	);

	// Check for current post category and add tax_query to the query arguments
	$cats = wp_get_post_terms( get_the_ID(), 'category' ); 
	$cats_ids = array();

	foreach( $cats as $wpex_related_cat ) :
		$cats_ids[] = $wpex_related_cat->term_id; 
	endforeach;

	if ( ! empty( $cats_ids ) ) :
		$args['category__in'] = $cats_ids;
	endif;

	// Query posts
	$wpex_query = new wp_query( $args );
?>

<?php if ( in_category('people') || in_category('lide') ): ?>
	<div class="page-title-container">
		<h2 class="page-title ">
			<?php #_e('Another from Category ', 'dharchitekti'); ?>
			<?php print get_the_category(get_the_ID())[0]->name; ?>
			<?php $TEMP_CAT_SLUG = get_the_category(get_the_ID())[0]->slug; ?>
		</h2>
	</div>
	<div class="section-article--list tile-view" id="">
<?php endif; ?>

<?php
	// Loop through posts
	foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); 
?>

<?php 
	if ( in_category('news') || in_category('novinky') ):
		include( 'template-parts/single-news-list.php');
	// elseif( in_category('coordination-board') || in_category('koordinacni-rada') ):
	elseif( in_category(strval($TEMP_CAT_SLUG)) ):
	
	$WITH_PICTURE = false;
	include( 'template-parts/people-board-list.php');
	
	endif; ?>

<?php endforeach; ?>

	</div> <!-- END section-article--list -->

<?php
	// Reset post data
	wp_reset_postdata();
?>