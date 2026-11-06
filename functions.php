<?php
add_action( 'after_setup_theme', 'dha_theme_setup' );
function dha_theme_setup() {
	load_theme_textdomain( 'dharchitekti', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	
	if ( ! isset( $content_width ) ) $content_width = 640;

	register_nav_menus( array(
		'main-menu'    => __( 'Hlavni Menu', 'dharchitekti' ),
		'office-menu'    => __( 'Office Menu', 'dharchitekti' ),
		'office-submenu'    => __( 'Office SubMenu', 'dharchitekti' ),
		'fcbk-ig' => __( 'Social links', 'dharchitekti' ),
		'allworks' => __( 'All works', 'dharchitekti' ),
		'team-members' => __( 'Team Members', 'dharchitekti' ),
	) );
}

add_action( 'comment_form_before', 'dha_theme_enqueue_comment_reply_script' );
function dha_theme_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'dha_theme_title' );
function dha_theme_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}

function wp_example_excerpt_length( $length ) {
    return 28;
}
add_filter( 'excerpt_length', 'wp_example_excerpt_length');

// REMOVE HARDCODED WIDTH & HEIGHT INLINE IN THUMBNAIL
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
// END REMOVE WIDTH & HEIGHT

add_filter( 'wp_title', 'dha_theme_filter_wp_title' );
function dha_theme_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'dha_theme_widgets_init' );
function dha_theme_widgets_init() {
	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<!-- ',
		'after_title'   => ' -->',
		// 'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'before_widget' => ' ',
		// 'after_widget'  => '</div></div>',
		'after_widget'  => ' ',
	);

	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Footer', 'dharchitekti' ),
				'id' => 'footer-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title">',
				// 'after_title' => '</h3>',
			)
		)
	);
	/*
	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Rezervace', 'dharchitekti' ),
				'id' => 'rezervace-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title">',
				// 'after_title' => '</h3>',
			)
		)
	);
	*/
}
function dha_theme_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
	<?php 
}
add_filter( 'get_comments_number', 'dha_theme_comments_number' );

function dha_theme_comments_number( $count ) {
	if ( !is_admin() ) {
		global $id;
		$temp_comments = get_comments( 'status=approve&post_id=' . $id );
		$comments_by_type = separate_comments( $temp_comments );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* WRAP THE POST CONTENT IN CUSTOM DIV */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
function wrap_content_in_div($content) {
    global $post;
    return '<div class="flow">'.$content.'</div>';
}
add_filter('the_content', 'wrap_content_in_div');
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */


/*	 — — —  — — — — — — — — — — — — */
/*	 — — —  — — — — — — — — — — — — */
/*	 — — —  — — — — — — — — — — — — */
/*	 — — —  — — — — — — — — — — — — */
/* ACF CUSTOM BLOCKS
/*	 — — —  — — — — — — — — — — — — */


add_action( 'init', 'register_acf_blocks', 5 );
function register_acf_blocks() {
    // register_block_type( __DIR__ . '/blocks/testimonial' );
    register_block_type( __DIR__ . '/blocks/block-gmap' );
    register_block_type( __DIR__ . '/blocks/block-team-m' );
    register_block_type( __DIR__ . '/blocks/block-hp-grid-item');
    register_block_type( __DIR__ . '/blocks/block-grid-row' );
    register_block_type( __DIR__ . '/blocks/block-project-info' );
	register_block_type( __DIR__ . '/blocks/block-project-info-column' );
	register_block_type( __DIR__ . '/blocks/block-credits-item' );
	register_block_type( __DIR__ . '/blocks/block-custom-column' );
}

function sevenYearSelect($field) {
    $currentYear = date('Y');
    // Create choices array
    $field['choices'] = array();
    // Add blank first selection; remove if unnecessary
    // $field['choices'][''] = ' ';
    // Loop through a range of years and add to field 'choices'. Change range as needed.
    foreach(range($currentYear+3, $currentYear-8) as $year) {
            
        $field['choices'][$year] = $year;
            
    }
    // Return the field
    return $field;
}

// add_filter('acf/load_field/key=field_0000000000000', 'sevenYearSelect');
// Apply to fields named "proj_year".
add_filter('acf/load_field/name=proj_year', 'sevenYearSelect');

add_filter( 'acf/blocks/default_block_version', function() {
    return 3;
});

// Gutenberg custom stylesheet
#add_theme_support('editor-styles');
#add_editor_style( 'editor-style.css' ); // make sure path reflects where the file is located

/* / — / — / — / — / — / – */
/* / — / — / — / — / — / – */
/* CUSTOMIZE WP LOGIN PAGE */
/* / — / — / — / — / — / – */

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
						/*background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);*/
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/site-login-logo.png);
						height:65px;
						width:320px;
						background-size: contain;
						background-repeat: no-repeat;
						padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

// function my_login_logo_url_title() {
//     return $title . esc_attr( get_bloginfo( 'name' ) );
// }
// add_filter( 'login_headertext', 'my_login_logo_url_title' );

/* / — / — / — / — / — / – */
/* CUSTOMIZE WP LOGIN PAGE */
/* / — / — / — / — / — / – */
/* / — / — / — / — / — / – */



// Adds support for editor color palette.

function my_theme_add_new_features() {

    // The new colors we are going to add

    // Apply the color palette containing the original colors and 2 new colors:
    add_theme_support( 'editor-color-palette', $newColorPalette);
    // Disables color picker in block color palette.
    add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'my_theme_add_new_features' );



add_action( 'wp_head', 'wps_params', 10 );
function wps_params() {
	// $URL_PREFIX = '';
	// $CURR_LANG = apply_filters( 'wpml_current_language', NULL );
	// if($CURR_LANG === 'en') :
		// $URL_PREFIX = '/en';
	// endif;

	if(is_front_page()) :
    ?>
    
	<script>
	if ( (window.innerWidth / window.innerHeight) <= 1) {
	   window.location = window.location.pathname + "works-cs/";
	}
	</script>

    <?php
	endif;
}

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


function office_page_url() {

	$menu = get_term( $locations['team-members'], 'nav_menu' );
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    // $menu_items = wp_get_nav_menu_items('team-members');
    foreach( $menu_items as $menu_item ) {
        $link = $menu_item->url;
    }
    // echo $link;
    // return $link;
    print_r($menu_item);
    // USE IT
    // echo office_page_url();
}

// Load Gutenberg Editor Styles
function custom_gutenberg_editor_styles() {
    wp_enqueue_style(
        'admin-styles',
        get_stylesheet_directory_uri().'/style-editor.css?v23-04-2024.01'
    );
}
add_action( 'admin_enqueue_scripts', 'custom_gutenberg_editor_styles' );
