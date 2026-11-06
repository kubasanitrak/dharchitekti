<?php
/**
 * Template Name: PAGE INDEX-BY-CATEGORY BACKUP
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



<div class="section section-works" data-theme="default">
	<?php 
		$term = get_field('category_to_list');
		if( $term ): 
			$CAT_NAME = esc_html( $term->name );
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
$slug = strval($CAT_NAME);
$cat = get_category_by_slug($CAT_NAME); 
// HERE WE PASS THE $SLUG TO WORDPRESS’ 
// GET_CATEGORY_BY_SLUG() FUNCTION. 
// THAT GIVES US AN OBJECT OF USEFUL CATEGORY DATA, 
// INCLUDING THE ID, WHICH WE THEN CALL DIRECTLY:
$catID = $cat->term_id;
// TO SEE WHAT ELSE IS AVAILABLE 
// TRY ADDING THE FOLLOWING TO YOUR SCRIPT:
// print_r($cat);

// $args = array('child_of' => 17);
$args = array('child_of' => $catID);
/*
THIS WILL GET ALL CATEGORIES THAT ARE DESCENDANTS
(I.E. CHILDREN & GRANDCHILDREN).

IF YOU WANT TO DISPLAY ONLY CATEGORIES
THAT ARE DIRECT DESCENDANTS (I.E. CHILDREN ONLY)
YOU CAN USE 'PARENT' ATTRIBUTE.
$args = array('parent' => 17);
*/
$categories = get_categories( $args );
if($categories) :
	$TEMP_MARKUP = "";
?>
<!-- LIST ALL CATEGORIES AS FILTERS -->
	<!-- <ul class="filter-list list-none"> -->
	<input type="checkbox" id="listBtnID" class="nav-switch" checked >
	<label for="listBtnID" class="list-toggle">
		<span>show list</span>
	</label>
	<?php
		foreach($categories as $category) : 
		    #echo '<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
		    #echo '<p> Description:'. $category->description . '</p>';
		    #echo '<p> Post Count: '. $category->count . '</p>';  
		    $TEMP_MARKUP .= '<div class="filter-list--item" ';
		    $TEMP_MARKUP .= 'data-filter-cat="';
		    $TEMP_MARKUP .= str_replace(" ","-", strtolower(strval($category->name)) );
		    $TEMP_MARKUP .= '">';
		    $TEMP_MARKUP .= $category->name;
		    $TEMP_MARKUP .= '</div>';
		endforeach;
		print($TEMP_MARKUP);
	?>
	<!-- </ul> -->
<?php 
endif;

		$args = array(
			'post_type' => 'post',
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

					if( $POST_CAT ) :
						$CLS_LIST = "";
						foreach($POST_CAT as $CAT_NAME) :
							$CLS_LIST .= " ";
							$CLS_LIST .= str_replace(" ","-", strtolower(strval($CAT_NAME)) );
						endforeach;
					endif;

					$PROJ_YEAR = get_field( 'works_year', $POST_ID );
					$TEMP_TITLE = get_the_title();
					$TEMP_PERMALINK = get_the_permalink();
					$TEMP_THUMB_URL = wp_get_attachment_image_src( get_post_thumbnail_id( $POST_ID ), 'full' );

					
					$TEMP_GRID_MARKUP .= '<div class="items-item ';
					$TEMP_GRID_MARKUP .= $CLS_LIST;
					$TEMP_GRID_MARKUP .= '">';
					$TEMP_GRID_MARKUP .= get_the_post_thumbnail($POST_ID, 'full', ['class' => 'items-item--img lazyload', 'title' => $TEMP_TITLE, 'loading' => 'lazy']);
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
					$TEMP_LIST_MARKUP .= '<h3 class="items-item--title">';
					$TEMP_LIST_MARKUP .= $TEMP_TITLE;
					$TEMP_LIST_MARKUP .= '</h3></div>';
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
	<div class="section section-items--list full-bleed" id="proj-listID">
		<?php print($TEMP_LIST_MARKUP); ?>
	</div><!-- END SECTION ITEMS-LIST -->
	<div class="section section-items--grid full-bleed" id="proj-gridID">
		<?php print($TEMP_GRID_MARKUP); ?>
	</div><!-- END SECTION ITEMS-GRID -->
	
	<?php endif; 
		wp_reset_query(); 
	?>

</div><!-- END SECTION CONTENT -->

	<?php get_footer(); ?>
