<?php
/**
 * Block Name: BLOCK-grid-row
 *
 * This is the template that displays the featured WORKS block.
 * @param   array $block The block settings and attributes.
 */
?>

<?php 
	
	$isMultiCol = get_field( 'grid_row_is_multicol' );

	$class_name = 'row';

	if ( ! empty( $isMultiCol ) ) :
    	$class_name .= ' ' . 'row-multi-col';
    else :
    	$class_name .= ' ' . 'row-single-col';
	endif;

	$alignRL = get_field( 'align_rl' );
	if( ! empty( $alignRL ) ) :
		$class_name .= ' ' . 'row--align_' . $alignRL;
	endif;

?>

<div class="section section-works section-hp-grid" data-theme="default">
	<div class="<?php echo esc_attr( $class_name ); ?>"	>
		<InnerBlocks/>
	</div>
</div>