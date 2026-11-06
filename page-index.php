<?php
/**
 * Template Name: PAGE INDEX-BY-CATEGORY
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
<script>
	document.getElementById("wrapper-id").classList.add("portrait-only-intro");
	if ( (window.innerWidth / window.innerHeight) <= 1) {
		document.getElementById("wrapper-id").classList.add("has-intro");
	}
</script>

<?php 
	include('template-parts/page-frontpage-logo-intro.php');
?>

	<?php 
		$term = get_field('category_to_list');
		if( $term ): 
			// $CAT_NAME = esc_html( $term->name );
			$CAT_NAME = esc_html( $term->slug );
			$CAT_NAME = strtolower($CAT_NAME);
			// echo '<h1>' .$CAT_NAME . '</h1>';
		endif; 
	
	// NO TERMS FOR LISTING POSTS, DO NOT LIST ANYTHING
		//*/
		if(!$term || is_null($term)) return;
		/*/
		if(!$term || is_null($term)) :
			echo '<h1>no category_name </h1>';
		endif;
		//*/

		/* / — / — / */
/* LIST ALL SUBCATEGORIES FROM CATEGORY */
/* / — / — / */
// $slug = 'docs';
/*
This code creates a new query using the WP_Query class, with the category_name parameter set to "works" and the posts_per_page parameter set to -1 to retrieve all posts in that category. It then iterates through each post in the query, uses wp_get_post_tags to get the tags for that post, and adds each unique tag to an array. Finally, it resets the query and you can use the $ALL_TAGS array to do whatever you need to do with the tags.
*/
$args = array(
    // 'category_name' => 'works-cs, works-en', // set the category name to 'works'
    'category_name' => strval($CAT_NAME), // set the category name to 'works'
    'posts_per_page' => -1 // set the number of posts to retrieve to all (-1)
);

$query = new WP_Query( $args ); // create a new query using the arguments above

if ( $query->have_posts() ) : // check if any posts were found
    $ALL_TAGS = array(); // initialize an empty array to store the tags

    while ( $query->have_posts() ) :
        $query->the_post(); // iterate through each post in the query

        $post_tags = wp_get_post_tags( get_the_ID() ); // get the tags for the current post

        foreach ( $post_tags as $tag ) :
            if ( ! in_array( $tag, $ALL_TAGS ) ) : // add the tag to the tags array if it's not already there
                $ALL_TAGS[] = $tag;
            endif;
        endforeach;
    endwhile;

    wp_reset_postdata(); // reset the query so other loops don't get affected

    // do something with the tags array here
endif;

if($ALL_TAGS) :
	$TEMP_MARKUP = "";
?>

<!-- SUBNAV: INDEX—FILTER—SEARCH -->
<div class="section section-filter-subnav">
    <ul id="menu-office-submenu" class="main-nav-list nav-list submenu-list sub-nav-list list-none">
    	<li class="menu-item"><a href="#" id="index_switch_ID"><?php _e( 'index', 'dharchitekti'); ?></a></li>
		<li class="menu-item"><a href="#" id="filter_btn_ID"><?php _e( 'filter', 'dharchitekti'); ?></a></li>
		<li class="menu-item menu-item-search"><div class="search-container"><?php get_search_form(); ?></div></li>
	</ul>
</div>

<div class="section section-all-works full-bleed" data-theme="default" id="allWorks_ID">
		<div class="all-works--filters">
			<?php
			// $SHOW_ALL_LABEL = _e('all', 'dharchitekti');
			$SHOW_ALL_LABEL = 'all';

				foreach($ALL_TAGS as $TAG) : 
				    $TEMP_MARKUP .= '<div class="filter-list--item" ';
				    $TEMP_MARKUP .= 'data-filter-cat="';
				    $TEMP_MARKUP .= str_replace(" ","-", strtolower(strval($TAG->name)) );
				    $TEMP_MARKUP .= '">';
				    $TEMP_MARKUP .= '<h3>';
				    $TEMP_MARKUP .= $TAG->name;
				    $TEMP_MARKUP .= '</h3>';
				    $TEMP_MARKUP .= '</div>';
				endforeach;
					/*
					$TEMP_MARKUP .= '<div class="filter-list--item reset active" data-filter-cat="show-all" id="reset-filtersID">';
					$TEMP_MARKUP .= '<h3>';
					$TEMP_MARKUP .= $SHOW_ALL_LABEL;
					$TEMP_MARKUP .= '</h3>';
					$TEMP_MARKUP .= '</div>';
					*/
				print($TEMP_MARKUP);
			?>
		<?php 
		endif;
		?>
		</div> <!-- END FILTER-CONTAINER -->
<?php 
		$args = array(
			'post_type' => 'post',
			// 'order' => 'DESC',
			'order' => 'ASC',
			'post_status' => 'publish',
			'category_name' => strtolower(strval($CAT_NAME)),
			'posts_per_page' => -1,
		);
		$arr_posts = new WP_Query( $args );

		// $alltags = array();
		
		if ( $arr_posts->have_posts() ) :
				
		$TEMP_LIST_MARKUP = "";
		$TEMP_GRID_MARKUP = "";
			
				while ( $arr_posts->have_posts() ) :
					$arr_posts->the_post();

					$POST_ID = get_the_ID();
					$POST_CAT = wp_get_post_categories( $POST_ID, array( 'fields' => 'names' ) );
					$POST_TAGS = wp_get_post_tags( $POST_ID, array( 'fields' => 'names' ) );

					// if( $POST_CAT ) :
					// 	$CLS_LIST = "";
					// 	foreach($POST_CAT as $CAT_NAME) :
					// 		$CLS_LIST .= " ";
					// 		$CLS_LIST .= str_replace(" ","-", strtolower(strval($CAT_NAME)) );
					// 	endforeach;
					// endif;

					if( $POST_TAGS ) :
						$CLS_LIST = "";
						foreach($POST_TAGS as $TAG_NAME) :
							$CLS_LIST .= " ";
							$CLS_LIST .= str_replace(" ","-", strtolower(strval($TAG_NAME)) );
						endforeach;
					endif;

					$PROJ_YEAR = get_field( 'works_year', $POST_ID );
					$TEMP_TITLE = get_the_title();
					$TEMP_PERMALINK = get_the_permalink();
					$TEMP_THUMB_URL = wp_get_attachment_image_src( get_post_thumbnail_id( $POST_ID ), 'full' );

					
					$TEMP_GRID_MARKUP .= '<div class="items-item ';
					$TEMP_GRID_MARKUP .= $CLS_LIST;
					$TEMP_GRID_MARKUP .= '">';
					$TEMP_GRID_MARKUP .= '<div class="items-item--img_container >';
					$TEMP_GRID_MARKUP .= get_the_post_thumbnail($POST_ID, 'full', ['class' => 'items-item--img', 'title' => $TEMP_TITLE, 'loading' => 'lazy']);
					$TEMP_GRID_MARKUP .= '</div>';
					$TEMP_GRID_MARKUP .= '<h4 class="items-item--title">';
					$TEMP_GRID_MARKUP .= $TEMP_TITLE;
					$TEMP_GRID_MARKUP .= '</h4>';
					$TEMP_GRID_MARKUP .= '<a class="items-item--link abs-link" href="';
					$TEMP_GRID_MARKUP .= $TEMP_PERMALINK;
					$TEMP_GRID_MARKUP .= '"></a>';
					$TEMP_GRID_MARKUP .= '</div><!-- END ITEMS-ITEM -->';
					$TEMP_LIST_MARKUP .= '<div class="items-item ';
					$TEMP_LIST_MARKUP .= $CLS_LIST;
					$TEMP_LIST_MARKUP .= '" data-thumb="' . esc_url( $TEMP_THUMB_URL[0] ) . '">';
					$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_L">';
					$TEMP_LIST_MARKUP .= '<h2 class="items-item--title">';
					$TEMP_LIST_MARKUP .= $TEMP_TITLE;
					$TEMP_LIST_MARKUP .= '</h2></div>';
					$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_cat items-item--column_R"><h4 class="items-item--title_cat">';
					$TEMP_LIST_MARKUP .= str_replace(" ","-", strtolower(strval($POST_CAT[0])) );
					$TEMP_LIST_MARKUP .= '</h4></div>';
					$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_tag items-item--column_R"><h4 class="items-item--title_tag">';
					$TEMP_LIST_MARKUP .= str_replace(" ","-", strtolower(strval($POST_TAGS[0])) );
					$TEMP_LIST_MARKUP .= '</h4></div>';
					$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_year items-item--column_R"><h4 class="items-item--title_year">';
					$TEMP_LIST_MARKUP .= $PROJ_YEAR;
					$TEMP_LIST_MARKUP .= '</h4></div>';
					$TEMP_LIST_MARKUP .= '<a class="items-item--link abs-link" href="';
					$TEMP_LIST_MARKUP .= $TEMP_PERMALINK;
					$TEMP_LIST_MARKUP .= '"></a>';
					$TEMP_LIST_MARKUP .= '</div><!-- END ITEMS-ITEM -->';
					// $TEMP_GRID_MARKUP .= '';
		
		endwhile;
	?>

	<div class="all-works--content full-bleed grid-view" id="allWorksContent_ID">

		<div class="section section-items--list" id="proj-listID">
			<?php print($TEMP_LIST_MARKUP); ?>
		</div><!-- END SECTION ITEMS-LIST -->

		<div class="section section-items--grid full-bleed" id="proj-gridID">
			<?php print($TEMP_GRID_MARKUP); ?>
		</div><!-- END SECTION ITEMS-GRID -->
		
	</div> <!-- END .section-all-works--content -->

	
	<?php endif; 
		wp_reset_query(); 
	?>

</div><!-- END SECTION section-list-all-works -->


	<?php get_footer(); ?>
