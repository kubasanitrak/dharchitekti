<?php
/**
 * Block Name: BLOCK-hp-grid-item
 *
 * This is the template that displays the featured WORKS block.
 * @param   array $block The block settings and attributes.
 */
?>

<?php 
	
	$imgOBJ = get_field( 'grid_item_img' );
	
	$imgID = $imgOBJ['ID'];

	// Thumbnail size attributes.
    $size = 'large';
    $thumb = $imgOBJ['sizes'][ $size ];
    $img_W = $imgOBJ['sizes'][ $size . '-width' ];
    $img_H = $imgOBJ['sizes'][ $size . '-height' ];
	
	$style = "--ratio: " . $img_W . "/" . $img_H;

	$isFullWidth = get_field( 'is_full_width' );
	$class_name = 'row--item';
	if ( ! empty( $isFullWidth ) ) :
    	$class_name .= ' ' . 'row--item---full_width';
	endif;

	$customWidth = get_field( 'width_perc' );
	if( ! empty( $customWidth ) ) :
		$class_name .= ' ' . 'row--item---width_' . $customWidth;
	endif;

	$linkToPOST = get_field( 'grid_item_link_to' );

	$IS_LINK = false;

	if(! empty($linkToPOST)) :
		$itemTITLE = get_the_title( $linkToPOST->ID );
		$linkURL = get_permalink($linkToPOST->ID);
		// $linkYEAR = get_field( 'proj_year', $linkToPOST->ID);
		$IS_LINK = true;
	endif;
?>

<div style="<?php echo esc_attr( $style ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="image-container" style="<?php echo esc_attr( $style ); ?>">
		<a href="<?php echo wp_get_attachment_image_url( $imgID, 'full' ); ?>" data-rel="lightbox-image-0" data-rl_title="" data-rl_caption="" title="" class="lightbox swipebox">
		<?php echo wp_get_attachment_image($imgID, 'full'); ?>
		</a>
	</div>
	<?php if($IS_LINK) : ?>
		<div class="image-caption">
			<p class="plain select-list--item_title"> <?php echo esc_attr( $itemTITLE ); ?></p>
		</div>
		<a href="<?php echo $linkURL; ?>" class="proj-det-link abs-link"></a>
	<?php endif; ?>
</div>
