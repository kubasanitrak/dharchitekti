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
                $projCREDITS = get_field( 'proj_credits' );
                if($projCREDITS) :
                    echo $projCREDITS;
                endif;
            ?>
            </div>
        </div>
    </div>
</div>
<div class="section full-bleed" id="proj-det-contentID">
    <?php the_content(); ?>
</div>
