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
		if(!$term || is_null($term)) {
			get_footer();
			return;
		}
		/*/
		if(!$term || is_null($term)) :
			echo '<h1>no category_name </h1>';
		endif;
		//*/

		$ALL_TAGS = array();
		$seen_tag_ids = array();
		$TEMP_MARKUP = '';
		$TEMP_LIST_MARKUP = '';
		$TEMP_GRID_MARKUP = '';

		$works_query = new WP_Query( array(
			'post_type'              => 'post',
			'order'                  => 'ASC',
			'orderby'                => 'date',
			'post_status'            => 'publish',
			'category_name'          => strtolower( (string) $CAT_NAME ),
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => true,
		) );

		if ( $works_query->have_posts() ) :
			$posts_newest_first = array_reverse( $works_query->posts );
			foreach ( $posts_newest_first as $tag_post ) :
				$post_tags = wp_get_post_tags( $tag_post->ID );
				foreach ( $post_tags as $tag ) :
					if ( ! isset( $seen_tag_ids[ $tag->term_id ] ) ) :
						$seen_tag_ids[ $tag->term_id ] = true;
						$ALL_TAGS[] = $tag;
					endif;
				endforeach;
			endforeach;

			while ( $works_query->have_posts() ) :
				$works_query->the_post();

				$POST_ID = get_the_ID();
				$POST_CAT = wp_get_post_categories( $POST_ID, array( 'fields' => 'names' ) );
				$POST_TAGS = wp_get_post_tags( $POST_ID, array( 'fields' => 'names' ) );
				$CLS_LIST = '';

				if ( $POST_TAGS ) :
					foreach ( $POST_TAGS as $TAG_NAME ) :
						$CLS_LIST .= ' ';
						$CLS_LIST .= str_replace( ' ', '-', strtolower( (string) $TAG_NAME ) );
					endforeach;
				endif;

				$PROJ_YEAR = get_field( 'works_year', $POST_ID );
				$TEMP_TITLE = get_the_title();
				$TEMP_PERMALINK = get_the_permalink();
				$thumb_id = get_post_thumbnail_id( $POST_ID );
				$thumb_hover = $thumb_id ? wp_get_attachment_image_src( $thumb_id, 'medium_large' ) : false;
				$TEMP_THUMB_URL = ( $thumb_hover && ! empty( $thumb_hover[0] ) ) ? $thumb_hover[0] : '';
				$cat_label = ! empty( $POST_CAT[0] ) ? $POST_CAT[0] : '';
				$tag_label = ! empty( $POST_TAGS[0] ) ? $POST_TAGS[0] : '';

				$TEMP_GRID_MARKUP .= '<div class="items-item ' . esc_attr( $CLS_LIST ) . '">';
				$TEMP_GRID_MARKUP .= '<div class="items-item--img_container">';
				$TEMP_GRID_MARKUP .= get_the_post_thumbnail( $POST_ID, 'large', array(
					'class' => 'items-item--img',
					'alt'   => $TEMP_TITLE,
					'sizes' => '(min-width: 80rem) 33vw, (min-width: 40rem) 50vw, 100vw',
				) );
				$TEMP_GRID_MARKUP .= '</div>';
				$TEMP_GRID_MARKUP .= '<h4 class="items-item--title">';
				$TEMP_GRID_MARKUP .= esc_html( $TEMP_TITLE );
				$TEMP_GRID_MARKUP .= '</h4>';
				$TEMP_GRID_MARKUP .= '<a class="items-item--link abs-link" href="';
				$TEMP_GRID_MARKUP .= esc_url( $TEMP_PERMALINK );
				$TEMP_GRID_MARKUP .= '"></a>';
				$TEMP_GRID_MARKUP .= '</div><!-- END ITEMS-ITEM -->';
				$TEMP_LIST_MARKUP .= '<div class="items-item ' . esc_attr( $CLS_LIST ) . '" data-thumb="' . esc_url( $TEMP_THUMB_URL ) . '">';
				$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_L">';
				$TEMP_LIST_MARKUP .= '<h2 class="items-item--title">';
				$TEMP_LIST_MARKUP .= esc_html( $TEMP_TITLE );
				$TEMP_LIST_MARKUP .= '</h2></div>';
				$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_cat items-item--column_R"><h4 class="items-item--title_cat">';
				$TEMP_LIST_MARKUP .= esc_html( str_replace( ' ', '-', strtolower( (string) $cat_label ) ) );
				$TEMP_LIST_MARKUP .= '</h4></div>';
				$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_tag items-item--column_R"><h4 class="items-item--title_tag">';
				$TEMP_LIST_MARKUP .= esc_html( str_replace( ' ', '-', strtolower( (string) $tag_label ) ) );
				$TEMP_LIST_MARKUP .= '</h4></div>';
				$TEMP_LIST_MARKUP .= '<div class="items-item--column items-item--column_year items-item--column_R"><h4 class="items-item--title_year">';
				$TEMP_LIST_MARKUP .= esc_html( (string) $PROJ_YEAR );
				$TEMP_LIST_MARKUP .= '</h4></div>';
				$TEMP_LIST_MARKUP .= '<a class="items-item--link abs-link" href="';
				$TEMP_LIST_MARKUP .= esc_url( $TEMP_PERMALINK );
				$TEMP_LIST_MARKUP .= '"></a>';
				$TEMP_LIST_MARKUP .= '</div><!-- END ITEMS-ITEM -->';
			endwhile;
		endif;
		wp_reset_postdata();

		foreach ( $ALL_TAGS as $TAG ) :
			$TEMP_MARKUP .= '<div class="filter-list--item" data-filter-cat="';
			$TEMP_MARKUP .= esc_attr( str_replace( ' ', '-', strtolower( (string) $TAG->name ) ) );
			$TEMP_MARKUP .= '"><h3>';
			$TEMP_MARKUP .= esc_html( $TAG->name );
			$TEMP_MARKUP .= '</h3></div>';
		endforeach;
?>

<?php if ( $TEMP_LIST_MARKUP ) : ?>
<?php if ( $ALL_TAGS ) : ?>
<!-- SUBNAV: INDEX—FILTER—SEARCH -->
<div class="section section-filter-subnav">
    <ul id="menu-office-submenu" class="main-nav-list nav-list submenu-list sub-nav-list list-none">
    	<li class="menu-item"><a href="#" id="index_switch_ID"><?php _e( 'index', 'dharchitekti'); ?></a></li>
		<li class="menu-item"><a href="#" id="filter_btn_ID"><?php _e( 'filter', 'dharchitekti'); ?></a></li>
		<li class="menu-item menu-item-search"><div class="search-container"><?php get_search_form(); ?></div></li>
	</ul>
</div>
<?php endif; ?>

<div class="section section-all-works full-bleed" data-theme="default" id="allWorks_ID">
		<div class="all-works--filters">
			<?php print( $TEMP_MARKUP ); ?>
		</div> <!-- END FILTER-CONTAINER -->

	<div class="all-works--content full-bleed grid-view" id="allWorksContent_ID">

		<div class="section section-items--list" id="proj-listID">
			<?php print( $TEMP_LIST_MARKUP ); ?>
		</div><!-- END SECTION ITEMS-LIST -->

		<div class="section section-items--grid full-bleed" id="proj-gridID">
			<?php print( $TEMP_GRID_MARKUP ); ?>
		</div><!-- END SECTION ITEMS-GRID -->
		
	</div> <!-- END .section-all-works--content -->

</div><!-- END SECTION section-list-all-works -->
<?php endif; ?>

	<?php get_footer(); ?>
