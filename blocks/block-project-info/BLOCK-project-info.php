<?php
/**
 * Block Name: BLOCK-project-info
 * Project Info Block Template.
 * 
 * @param   array $block The block settings and attributes.
 */

    // Create class attribute allowing for custom "className" values.
    $CLS_W = ' projdet-caption--columns';
    
    // Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;
    $id = 'project-info-' . $block['id'];
?>
    
    <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?>">
        <?php $allowed_inner_blocks = ['acf/proj-info-col']; ?>
        <InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_inner_blocks)); ?>" />
    </div>
    