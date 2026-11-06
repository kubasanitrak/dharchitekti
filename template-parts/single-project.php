<?php
/**
 * Displays single-project
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>
<!-- <h1>single project</h1> -->
<!-- 
TITLE
CAPTION
TAG LIST
ROK REALIZACE
LINKS
PHOTO CREDITS

PHOTOCONTENT
-->
<?php
    if(get_the_post_thumbnail()) :

        $thumbID = get_post_thumbnail_id();
?>
<div class="section section-projdet-hero full-bleed" data-theme="default">
    <a href="<?php echo wp_get_attachment_image_url( $thumbID, 'full' ); ?>" id="hero-img-gallery-linkID" data-rel="" data-rl_title="" data-rl_caption="" title="" class="lightbox swipebox">
        <?php the_post_thumbnail( 'full' ); ?>
    </a>
</div>
<?php
    endif;
?>

<style>
@media screen and (orientation: portrait) {
    .section-hp-grid:first-of-type, .section-projdet-hero {
       margin-top: 0; 
    }
}

</style>
<div class="section">
    <div class="projdet-title-container">
        <h1 class="projdet-title"><?php the_title(); ?></h1>
    </div>
    <div class="projdet-caption--columns">
        <div class="projdet-caption--col projdet-caption--col_L">
            <div class="flow">
            <?php 
                $projCAPTION = get_field( 'proj_caption' );
                if($projCAPTION) :
                    // echo esc_html($projCAPTION);
                    echo $projCAPTION;
                endif;
            ?>
            </div>
        </div>
        <div class="projdet-caption--col projdet-caption--col_R">
            <input type="checkbox" id="creditsBtnID" class="desktop-hide credits-checkbox">
            <label for="creditsBtnID" class="hamburger desktop-hide">
                <span class="btn-view-switch">more</span>
            </label>
            <div class="flow portrait-accordeon">
                <?php 
                // $projCREDITS = get_field( 'proj_credits' );
                // if($projCREDITS) :
                    // echo $projCREDITS;
                // endif;
                ?>
                <div class="projdet-credits">
                    <?php
                    if( have_rows('proj_credits_parent') ):
                        $TEMP_MARKUP = "";
                        

                        $OFFICE_MENU = wp_get_nav_menu_items( 'team-members' );
                        foreach ( (array) $OFFICE_MENU as $key => $OFFICE_MENU_ITEM ) :
                            if( str_contains(strtolower($OFFICE_MENU_ITEM->title), 'office') ) :
                                $OFFICE_URL = $OFFICE_MENU_ITEM->url;
                            endif;
                        endforeach;
                    ?>
                    <?php
                        // Loop through rows.
                        while( have_rows('proj_credits_parent') ) : 
                            the_row();
                            $TEMP_MARKUP .= '<div class="projdet-credits--columns">';
                            $TEMP_MARKUP .= '<div class="projdet-credits--col projdet-credits--col_L">';
                            $TEMP_MARKUP .= get_sub_field('proj_credits_item_label');
                            $TEMP_MARKUP .= '</div>';
                            $TEMP_MARKUP .= '<div class="projdet-credits--col projdet-credits--col_R">';
                            // CUSTOM POSTS - TEAM SELECTION
                            $LISTOF_AUTHORS = get_sub_field('proj_credits_item_team');
                            if( !empty($LISTOF_AUTHORS) ) :
                                
                                foreach ($LISTOF_AUTHORS as $AUTHOR => $TEMP_ID) :
                                    $TEMP_POST = get_post($TEMP_ID); 
                                    $TEMP_SLUG = $TEMP_POST->post_name;

                                    $TEMP_MARKUP .= '<a class="projdet-credits--col---link" title="';
                                    $TEMP_MARKUP .= get_the_title($TEMP_ID);
                                    $TEMP_MARKUP .= '" href="';
                                    $TEMP_MARKUP .= $OFFICE_URL;
                                    $TEMP_MARKUP .= '#';
                                    $TEMP_MARKUP .= $TEMP_SLUG;
                                    $TEMP_MARKUP .= '">';
                                    $TEMP_MARKUP .= get_the_title($TEMP_ID);
                                    $TEMP_MARKUP .= '</a><br/>';
                                endforeach;
                            endif; // END CUSTOM POSTS - TEAM SELECTION
                            // TEXTFIELD CONTENT
                            $TEMP_MARKUP .= get_sub_field('proj_credits_item_content'); // END TEXTFIELD CONTENT
                            $TEMP_MARKUP .= '</div>';
                            $TEMP_MARKUP .= '</div><!-- END ROW -->';
                        // End loop.
                        endwhile;
                        print $TEMP_MARKUP;
                    ?>
                    <?php
                        endif;
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="section full-bleed" id="proj-det-contentID">
    <?php the_content(); ?>
</div>
