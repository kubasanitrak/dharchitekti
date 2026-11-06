<?php
/**
 * Block Name: BLOCK-custom-column
 *
 * This is the template that displays the featured WORKS block.
 * @param   array $block The block settings and attributes.
 */
?>

<?php 
	
	$CLS_W = 'dhacols-col';

	$customWidth = get_field( 'width_pick' );
	if( ! empty( $customWidth ) ) :
		$CLS_W .= ' dhacols-col--w ' . ' dhacols-col--w_' . $customWidth;
	endif;
	
	$customAlign = get_field( 'vertical_align' );
	if( ! empty( $customAlign ) ) :
		$CLS_W .= ' dhacols-col--align_' . $customAlign;
	endif;

    $id = 'dha-' . $block['id'];
	// Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;
?>

<div id="<?php echo esc_attr( $id ) ?>"  class="<?php echo esc_attr( $classes ); ?>">
	<InnerBlocks/>
</div>
