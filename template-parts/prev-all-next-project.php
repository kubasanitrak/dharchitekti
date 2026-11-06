<?php
/**
 * Displays single-next-project
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>
<!-- PREV/NEXT PROJECT -->

<div class="section section--footnav" id="prevnext-proj-ID">
<?php
	$post_id = $post->ID; // current post ID
	$post_cat = get_the_category(); 
	$post_cat_id = $post_cat[0]->cat_ID; // current category ID
	$cat_object = get_category($post_cat_id, false); // Get the Category object by the id of current category

	if(!empty($cat_object->parent)) :
		$query_ID = $cat_object->parent;
	else :
		$query_ID = $post_cat_id;
	endif;

	$args = array( 
		'category' => $query_ID,
		'orderby'  => 'post_date',
		'order'    => 'DESC'
	);
	$posts = get_posts( $args );
	// get IDs of posts retrieved from get_posts
	$ids = array();
	foreach ( $posts as $thepost ) :
		$ids[] = $thepost->ID;
	endforeach;
	// get and echo previous and next post in the same category
	$thisindex = array_search( $post_id, $ids );
	$ids_length = count($ids);
	$previd    = isset( $ids[ $thisindex - 1 ] ) ? $ids[ $thisindex - 1 ] : $ids[ $ids_length - 1 ];
	$nextid    = isset( $ids[ $thisindex + 1 ] ) ? $ids[ $thisindex + 1 ] : $ids[ 0 ];
?>
	<div class="footnav-link footnav-link--previous">
<?php
	if (false !== $previd ) :
?>
		<a rel="prev" href="<?php echo get_permalink($previd) ?>"><?php _e('previous', 'dharchitekti'); ?></a>
<?php
	endif;
?>

	</div>
	
	<?php include('all-works-footnav.php');  ?>

	<div class="footnav-link footnav-link--next">

<?php
	if (false !== $nextid ) :
?>
		<a rel="next" href="<?php echo get_permalink($nextid) ?>"><?php _e('next', 'dharchitekti'); ?></a>
<?php
	endif;
?>
	</div>

</div>