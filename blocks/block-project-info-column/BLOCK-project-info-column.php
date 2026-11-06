<?php
/**
 * Block Name: BLOCK-project-info-column
 * Project Info Block Template.
 * 
 * @param   array $block The block settings and attributes.
 */

    // Create class attribute allowing for custom "className" values.
    $CLS_W = ' projdet-caption--col';

    $COL_TYPE = get_field('proj_info_col_type'); 
    if($COL_TYPE) :
        $CLS_W .= ' ';
        $CLS_W .= 'projdet-caption--col_' . strval($COL_TYPE);
    endif;

    $MARKUP_START = '';

    if(strval($COL_TYPE) === 'L') :
        $MARKUP_START .= '<div class="flow">';
        $MARKUP_END .= '</div>';
    endif;

    if(strval($COL_TYPE) === 'R') :
        $MARKUP_START .= '<input type="checkbox" id="creditsBtnID" class="desktop-hide credits-checkbox">';
        $MARKUP_START .= '<label for="creditsBtnID" class="hamburger desktop-hide">';
        $MARKUP_START .= '<span class="btn-view-switch">more</span>';
        $MARKUP_START .= '</label>';
        $MARKUP_START .= '<div class="flow portrait-accordeon">';
        $MARKUP_START .= '<div class="projdet-credits">';
        $MARKUP_END .= '</div>';
        $MARKUP_END .= '</div>';
    endif;
    
    // Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;

?>
    

    <div class="<?php echo esc_attr($classes); ?> ">

        <?php echo $MARKUP_START; ?>
            <InnerBlocks/>
        <?php echo $MARKUP_END; ?>
        
    </div> <!-- END .projdet-caption--col -->
    
    <!-- CAPTION -->
        <!--
        <div class="flow">
            INNERBLOCKS
        </div>
        -->
    
    <!-- OR CREDITS-->
    <!--
        <input type="checkbox" id="creditsBtnID" class="desktop-hide credits-checkbox">
        <label for="creditsBtnID" class="hamburger desktop-hide">
            <span class="btn-view-switch">more</span>
        </label>
        <div class="flow portrait-accordeon">
            <div class="projdet-credits">
            INNERBLOCKS
            </div>
        </div>
    -->
