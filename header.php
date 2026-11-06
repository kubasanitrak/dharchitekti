<?php #require_once('assets/config.php'); ?>
<?php 
	$SITE_DOMAIN = "dharchitekti.cz";
	$SITE_URL = "https://" . $SITE_DOMAIN;
	$SITE_TITLE = "dharchitekti";
	$SITE_DESC = "Navrhujeme, abychom postavili. pracujeme na domech od začátku do konce, od první skici do posledního detailu kliky.";
	$HIDE_LOGO_ON_MOBILE_CLASS = "";
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">

<meta name="robots" content= "index, follow">
<meta name="author" content="NIVB.CZ">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="<?php echo $SITE_DOMAIN; ?>">
<meta property="twitter:url" content="<?php echo $SITE_URL; ?>">
<meta name="twitter:title" content="<?php echo $SITE_TITLE; ?>">
<meta name="twitter:description" content="<?php echo $SITE_DESC; ?>">
<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/og-image.jpg">

<!-- fcbk Meta Tags -->
<meta property="og:url"         content="<?php echo $SITE_URL; ?>"/>
<meta property="og:type"        content="website"/>
<meta property="og:title"       content="<?php echo $SITE_TITLE; ?>"/>
<meta property="og:description" content="<?php echo $SITE_DESC; ?>"/>
<meta property="og:image"       content="<?php echo get_template_directory_uri(); ?>/assets/images/og-image.jpg"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/> 

<link rel="icon"	href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" sizes="any"><!-- 32×32 -->
<link rel="icon"	href="<?php echo get_template_directory_uri(); ?>/assets/icon.svg" type="image/svg+xml">
<link rel="apple-touch-icon"	href="<?php echo get_template_directory_uri(); ?>/assets/apple-touch-icon.png"><!-- 180×180 -->
<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifest.webmanifest">

<!-- <link href="<?php #echo get_template_directory_uri(); ?>/assets/apple-touch-icon.png" rel="apple-touch-icon">
<link rel="icon" type="image/svg+xml" href="<?php #echo get_template_directory_uri(); ?>/assets/favicon.svg">
<link rel="alternate icon" href="<?php #echo get_template_directory_uri(); ?>/assets/favicon.ico">
<link rel="mask-icon" href="<?php #echo get_template_directory_uri(); ?>/assets/safari-pinned-tab.svg" color=""> -->

<!-- START WP_HEAD() -->
<?php wp_head(); ?>
<!-- END WP_HEAD() -->

<!--[if lt IE]>
<style></style>
<![endif]-->


<style>
	/* CRITICAL CSS */
	@supports (--custom:property) {
		[style*="--aspect-ratio"] { position: relative; padding-bottom: 0; }
		[style*="--aspect-ratio"]::before { padding-bottom: calc(100% / (var(--aspect-ratio))); display: block; content: ""; }
		[style*="--aspect-ratio"] > :first-child:not(.play-button) { position: absolute; top: 0; left: 0; height: 100%; } 
	}

	:root {--modifier: calc((30rem - 100%) * 999); } .row, .row .acf-innerblocks-container {display: flex; flex-wrap: wrap; } @media screen and (orientation: landscape) {.row--align_right, .row--align_right .acf-innerblocks-container {justify-content: flex-end; } } .row--item {display: flex; flex-direction: column; } .row--item .image-container picture, .row--item .image-container img {display: block; min-width: 100%; max-width: 100%; } .row-multi-col .row--item, .row-multi-col .acf-innerblocks-container .row--item {flex-basis: max(var(--modifier), 0px); flex-grow: calc(var(--ratio)); } .row-multi-col .row--item .image-container, .row-multi-col .acf-innerblocks-container .row--item .image-container {aspect-ratio: var(--ratio); } .row-multi-col .row--item img, .row-multi-col .acf-innerblocks-container .row--item img {width: 100%; height: auto; } .row-single-col, .row-single-col .acf-innerblocks-container {max-width: 100%; } 
	/* .row-single-col .row--item, .row-single-col .acf-innerblocks-container .row--item {max-width: 100%; height: 100%; max-height: 100%; } */
		.row-single-col .row--item picture, .row-single-col .row--item img, .row-single-col .acf-innerblocks-container .row--item picture, .row-single-col .acf-innerblocks-container .row--item img {min-width: 100%; max-width: 100%; height: 100%; max-height: 100%; }


	/* LOADING */
	:root{--intro-mq-based-T:.65s}@media screen and (min-width:52.1rem){:root{--intro-mq-based-T:.85s}}@media screen and (min-width:100.1rem){:root{--intro-mq-based-T:1.25s}}.js .has-intro .logo-container{transform:translate(0);transition-delay:3s}.js .has-intro .fullpage-cover{-webkit-animation:fadeOutCover 1s cubic-bezier(.55,.29,.17,.97) 3.45s forwards;animation:fadeOutCover 1s cubic-bezier(.55,.29,.17,.97) 3.45s forwards}.js .has-intro .intro-dha-container{-webkit-animation:var(--intro-mq-based-T) cubic-bezier(.55,.29,.17,.97) 3s slideOffLogo forwards;animation:var(--intro-mq-based-T) cubic-bezier(.55,.29,.17,.97) 3s slideOffLogo forwards}.js .has-intro .dha-only{--delay-int:1.0}.js .has-intro .dha-only .logo-part-a,.js .has-intro .dha-only .logo-part-dh{transition-duration:var(--intro-mq-based-T)}.js .has-intro .dha-only .logo-part-a{--delay-int:1.25}.js .loading.has-intro .logo-container{transform:translateY(-20vh)}@-webkit-keyframes fadeOutCover{to{background-color:transparent}}@keyframes fadeOutCover{to{background-color:transparent}}@-webkit-keyframes slideOffLogo{to{opacity:.5;transform:translateY(-100vh)}}@keyframes slideOffLogo{to{opacity:.5;transform:translateY(-100vh)}}
	/* END LOADING */

	.current-menu-item a { color: var(--black); }
	.mar-T-1em { margin-top: 1em; }
	.mar-T-0 { margin-top: 0; }

</style>



<!-- section-header-on-hp -->

</head>
	<?php 
		$CURR_LANG = apply_filters( 'wpml_current_language', NULL );
		$HAS_INTRO_CLS = "";
		if( is_front_page() ) :
			$HAS_INTRO_CLS = "has-intro";
		endif;
	?>
<body class="<?php echo $CURR_LANG; ?>">

	<script> document.body.classList.add("js"); </script>

	<div class="wrapper loading <?php echo $HAS_INTRO_CLS; ?>" id="wrapper-id" data-theme="default">
		