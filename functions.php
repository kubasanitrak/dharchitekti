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
    // Custom colors stay off. The previous palette variable was never defined,
    // which threw a warning on PHP 8.2 and registered nothing.
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


// Editor stylesheet only. Previously this ran on every wp-admin screen.
function custom_gutenberg_editor_styles() {
    wp_enqueue_style(
        'dha-editor-styles',
        get_stylesheet_directory_uri() . '/style-editor.css',
        array(),
        dha_file_version( '/style-editor.css' )
    );
}
add_action( 'enqueue_block_editor_assets', 'custom_gutenberg_editor_styles' );

// Core pattern directory is a remote request during editor boot and this theme does not use those patterns.
add_action( 'after_setup_theme', function() {
    remove_theme_support( 'core-block-patterns' );
}, 20 );
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Cache-bust a theme file from its modification time.
 */
function dha_file_version( $relative ) {
	$path = get_template_directory() . $relative;
	return file_exists( $path ) ? (string) filemtime( $path ) : null;
}

/**
 * sizes attribute for a column that occupies $percent of the viewport.
 */
function dha_sizes_for_width( $percent ) {
	$percent = (int) $percent;
	if ( $percent <= 0 || $percent >= 100 ) {
		return '(max-width: 1600px) 100vw, 1600px';
	}
	return '(max-width: 1600px) ' . $percent . 'vw, ' . $percent . 'vw';
}

/**
 * Keep full-bleed content images from advertising a 2000px+ slot.
 */
function dha_cap_image_sizes( $sizes, $size ) {
	if ( is_admin() ) {
		return $sizes;
	}
	$width = is_array( $size ) ? (int) $size[0] : 0;
	if ( $width > 1600 ) {
		return '(max-width: 1600px) 100vw, 1600px';
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'dha_cap_image_sizes', 10, 2 );

function dha_needs_lightbox() {
	if ( is_admin() ) {
		return false;
	}
	if ( is_front_page() || is_singular( 'post' ) ) {
		return true;
	}
	$post = get_post();
	if ( ! $post ) {
		return false;
	}
	return has_block( 'acf/hp-grid-item', $post ) || has_block( 'acf/grid-row', $post );
}

function dha_needs_motion() {
	if ( is_admin() ) {
		return false;
	}
	$post = get_post();
	return $post && has_block( 'acf/team-m', $post );
}

function dha_enqueue_front_assets() {
	if ( is_admin() ) {
		return;
	}

	$uri = get_template_directory_uri();

	wp_enqueue_style( 'dha-style', $uri . '/assets/css/style.css', array(), dha_file_version( '/assets/css/style.css' ) );
	wp_enqueue_style( 'dha-block-fixes', $uri . '/assets/css/wp-block-fix-style.css', array( 'dha-style' ), dha_file_version( '/assets/css/wp-block-fix-style.css' ) );

	if ( dha_needs_lightbox() ) {
		wp_enqueue_style( 'dha-lightbox', $uri . '/assets/css/dha-simple-lightbox-override.css', array( 'dha-style' ), dha_file_version( '/assets/css/dha-simple-lightbox-override.css' ) );
	}

	wp_enqueue_script( 'dha-theme', $uri . '/assets/js/theme.js', array(), dha_file_version( '/assets/js/theme.js' ), true );
	wp_localize_script( 'dha-theme', 'dhaTheme', array(
		'gridLabel' => __( 'grid', 'dharchitekti' ),
	) );

	if ( is_page_template( 'page-index.php' ) ) {
		wp_enqueue_script( 'dha-index-thumbs', $uri . '/assets/js/index-thumbs.js', array(), dha_file_version( '/assets/js/index-thumbs.js' ), true );
	}

	if ( dha_needs_motion() ) {
		wp_enqueue_script( 'gsap', $uri . '/assets/js/libs/gsap.min.js', array(), dha_file_version( '/assets/js/libs/gsap.min.js' ), true );
		wp_enqueue_script( 'gsap-scrollto', $uri . '/assets/js/libs/ScrollToPlugin.min.js', array( 'gsap' ), dha_file_version( '/assets/js/libs/ScrollToPlugin.min.js' ), true );
		wp_enqueue_script( 'gsap-flip', $uri . '/assets/js/libs/Flip.min.js', array( 'gsap' ), dha_file_version( '/assets/js/libs/Flip.min.js' ), true );
		wp_enqueue_script( 'dha-motion', $uri . '/assets/js/theme-motion.js', array( 'gsap', 'gsap-scrollto', 'gsap-flip' ), dha_file_version( '/assets/js/theme-motion.js' ), true );
		wp_enqueue_script( 'dha-team-video', $uri . '/assets/js/team-video.js', array(), dha_file_version( '/assets/js/team-video.js' ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'dha_enqueue_front_assets' );

/**
 * Lightbox (and its jQuery, Infinite Scroll, and DOMPurify stack) only where a gallery is rendered.
 */
function dha_trim_plugin_assets() {
	if ( is_admin() || dha_needs_lightbox() ) {
		return;
	}

	$scripts = array(
		'responsive-lightbox',
		'responsive-lightbox-swipebox',
		'responsive-lightbox-infinite-scroll',
		'responsive-lightbox-sanitizer',
		'dompurify',
		'underscore',
		'jquery',
		'jquery-core',
		'jquery-migrate',
	);
	foreach ( $scripts as $handle ) {
		wp_dequeue_script( $handle );
	}
	wp_dequeue_style( 'responsive-lightbox-swipebox' );
}
add_action( 'wp_enqueue_scripts', 'dha_trim_plugin_assets', 100 );

function dha_defer_theme_scripts( $tag, $handle ) {
	$defer = array(
		'dha-theme',
		'dha-motion',
		'dha-index-thumbs',
		'dha-team-video',
		'gsap',
		'gsap-scrollto',
		'gsap-flip',
	);
	if ( in_array( $handle, $defer, true ) && strpos( $tag, ' defer' ) === false ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'dha_defer_theme_scripts', 10, 2 );
