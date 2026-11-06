<?php
/**
 * Block Name: BLOCK-credits-item
 * 
 * @param   array $block The block settings and attributes.
 * 
 */
?>

<?php
// Create class attribute allowing for custom "className" values.
    $CLS_W = ' projdet-credits--columns';
    
    // Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;

    $CREDITS_LABEL = get_field('credits_label');
    
?>
    <div class="<?php echo esc_attr($classes); ?>">
        <!-- CREDITS LABEL -->
        <div class="projdet-credits--col projdet-credits--col_L"><?php echo $CREDITS_LABEL; ?></div>
        <!-- CREDITS CONTENT -->
        <div class="projdet-credits--col projdet-credits--col_R">
            <InnerBlocks/>
        </div>
    </div>