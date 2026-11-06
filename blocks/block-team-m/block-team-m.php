<?php
/**
 * Block Name: Block team member
 *
 * This is the template that displays team members block.
 * @param   array $block The block settings and attributes.
 */
?>
<?php

// Create class attribute allowing for custom "className" values.
		$CLS_W = 'team-grid';

		// Create class attribute allowing for custom "className" values.
		$classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;
		$id = 'dha-' . $block['id'];




$TEAM_MEMBERS = get_field( 'office_team_members' );

if( $TEAM_MEMBERS ): ?>
    <!-- START TEAMGRID BLOCK -->
    <div id="<?php echo esc_attr( $id ) ?>" class="<?php echo esc_attr( $classes ); ?>">

    <?php foreach( $TEAM_MEMBERS as $TEAM_MEMBER ): 

        // $TEAM_MEMBER->ID = get($TEAM_MEMBER->ID);
        $thumbsize = "large";
        $post_SLUG = get_post_field( 'post_name', $TEAM_MEMBER->ID );
        $post_TITLE = get_post_field( 'post_title', $TEAM_MEMBER->ID );
        $post_CONTENT = get_post_field( 'post_content', $TEAM_MEMBER->ID );
        $TEAM_M_EMAIL = get_field('team_m-email', $TEAM_MEMBER->ID);
        $TEAM_M_PHONE = get_field('team_m-phone', $TEAM_MEMBER->ID);
        $LISTOF_WORKS = get_field('team_m-works', $TEAM_MEMBER->ID);
        $TEAM_M_MEDIA = get_field('team_m-media', $TEAM_MEMBER->ID);
        $TEAM_M_VIDEO_POSTER = get_field('team_m-video_poster', $TEAM_MEMBER->ID);

?>

         <div class="team-grid--item view-compact" id="<?php echo $post_SLUG; ?>">
                    <div class="team-grid--item---row team-grid--item---row_content">
                        <div class="team-grid--item---col team-grid--item---col_L">
                            <?php if($TEAM_M_MEDIA) : ?>
                            <div class="team-grid--item---row team-grid--item---img">
                                <?php
                                    if($TEAM_M_MEDIA === 'img') :
                                        $TEAM_M_PHOTO = get_field('team_m-img', $TEAM_MEMBER->ID);
                                ?>
                                <div class="team-grid--item_img_container team-grid--item---toggle">
                                    <?php
                                    if ( is_array( $TEAM_M_PHOTO ) && ! empty( $TEAM_M_PHOTO['ID'] ) ) :
                                        echo wp_get_attachment_image( $TEAM_M_PHOTO['ID'], 'large', false, array(
                                            'sizes'   => '(min-width: 52rem) 40vw, 90vw',
                                            'loading' => 'lazy',
                                        ) );
                                    elseif ( is_array( $TEAM_M_PHOTO ) && ! empty( $TEAM_M_PHOTO['url'] ) ) :
                                    ?>
                                    <img src="<?php echo esc_url( $TEAM_M_PHOTO['url'] ); ?>" alt="<?php echo esc_attr( $TEAM_M_PHOTO['alt'] ); ?>" />
                                    <?php endif; ?>
                                </div>
                                <?php
                                    elseif($TEAM_M_MEDIA === 'video' && get_field('team_m-video_mp4', $TEAM_MEMBER->ID) ) :
                                        $TEAM_M_VIDEO_POSTER = get_field('team_m-video_poster', $TEAM_MEMBER->ID);
                                ?>
                                <div class="inline-video-container team-grid--item---toggle">
                                    <?php
                                    $poster_url = '';
                                    if ( is_array( $TEAM_M_VIDEO_POSTER ) ) {
                                        $poster_url = ! empty( $TEAM_M_VIDEO_POSTER['sizes']['large'] ) ? $TEAM_M_VIDEO_POSTER['sizes']['large'] : $TEAM_M_VIDEO_POSTER['url'];
                                    }
                                    ?>
                                    <video playsinline muted loop preload="none" poster="<?php echo esc_url( $poster_url ); ?>" class="play-on-hover inline-video">
                                        <source src="<?php echo esc_attr(get_field('team_m-video_mp4', $TEAM_MEMBER->ID)); ?>" type="video/mp4">
                                        <!-- <source src="<?php #echo esc_attr(get_field('team_m-video_webm', $TEAM_MEMBER->ID)); ?>" type="video/webm"> -->
                                    </video>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <div class="team-grid--item---row team-grid--item---content">
                                <div class="team-grid--item---row team-grid--item---header">
                                    <p class="team-grid--item---title strong"> <?php echo $post_TITLE; ?> </p>
                                    <p class="team-grid--item---email plain"><a class="email" href="mailto:<?php echo $TEAM_M_EMAIL; ?>" ><?php echo $TEAM_M_EMAIL; ?></a></p>
                                    <p class="team-grid--item---phone plain">
                                        <?php
                                            if($TEAM_M_PHONE) : 
                                                echo $TEAM_M_PHONE; 
                                            else:
                                                echo '&nbsp;';
                                            endif;
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="team-grid--item---col team-grid--item---col_R">
                            <div class="team-grid--item---caption_container">
                                    <div class="team-grid--item---header">
                                        <p class="team-grid--item---title strong"> <?php echo $post_TITLE; ?> </p>
                                        <p class="team-grid--item---email plain"><a class="email" href="mailto:<?php echo $TEAM_M_EMAIL; ?>" ><?php echo $TEAM_M_EMAIL; ?></a></p>
                                        <p class="team-grid--item---phone plain">
                                            <?php
                                                if($TEAM_M_PHONE) : 
                                                    echo $TEAM_M_PHONE; 
                                                else:
                                                    echo '&nbsp;';
                                                endif;
                                            ?>
                                        </p>
                                    </div>
                                <!-- </div> -->
                                <div class="team-grid--item---row team-grid--item---caption">
                                <?php
                                    echo $post_CONTENT;
                                    # LIST OF WORKS
                                    if( !empty($LISTOF_WORKS) ) :
                                        $TEMP_MARKUP = '<ul class="works-list list-none">';
                                        foreach ($LISTOF_WORKS as $WORK => $TEMP_ID) :
                                                $TEMP_MARKUP .= '<li class="works-list--item">';
                                                $TEMP_MARKUP .= '<a class="works-list--item_link" href="';
                                                $TEMP_MARKUP .= get_permalink($TEMP_ID);
                                                $TEMP_MARKUP .= '">';
                                                $TEMP_MARKUP .= get_the_title($TEMP_ID);
                                                $TEMP_MARKUP .= '</a>';
                                                $TEMP_MARKUP .= '</li>';
                                        endforeach;
                                        $TEMP_MARKUP .= '</ul>';
                                        
                                        print $TEMP_MARKUP;
                                    endif;
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="team-grid--item---row team-grid--item---row_icon team-grid--item---view_icon team-grid--item---toggle">
                        <a class="btn btn-view-switch"></a>
                    </div>
                </div> <!-- END TEAMGRID--ITEM -->
       
    <?php endforeach; ?>
    </div> <!-- END TEAMGRID BLOCK -->
<?php endif; ?>