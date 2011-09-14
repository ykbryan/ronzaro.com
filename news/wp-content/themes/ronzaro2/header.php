<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head id="www-ronzaro-com" data-template-set="ronzaro.com" profile="http://www.ronzaro.com/">
<meta charset="<?php bloginfo('charset'); ?>">

<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php if (is_search()) { ?>
<meta name="robots" content="noindex, nofollow" /> 
<?php } ?>

<title>
       <?php
          if (function_exists('is_tag') && is_tag()) {
             single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
          elseif (is_archive()) {
             wp_title(''); echo ' Archive - '; }
          elseif (is_search()) {
             echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
          elseif (!(is_404()) && (is_single()) || (is_page())) {
             wp_title(''); echo ' - '; }
          elseif (is_404()) {
             echo 'Not Found - '; }
          if (is_home()) {
             bloginfo('name'); echo ' - '; bloginfo('description'); }
          else {
              bloginfo('name'); }
          if ($paged>1) {
             echo ' - page '. $paged; }
       ?>
</title>

<meta name="title" content="<?php
          if (function_exists('is_tag') && is_tag()) {
             single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
          elseif (is_archive()) {
             wp_title(''); echo ' Archive - '; }
          elseif (is_search()) {
             echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
          elseif (!(is_404()) && (is_single()) || (is_page())) {
             wp_title(''); echo ' - '; }
          elseif (is_404()) {
             echo 'Not Found - '; }
          if (is_home()) {
             bloginfo('name'); echo ' - '; bloginfo('description'); }
          else {
              bloginfo('name'); }
          if ($paged>1) {
             echo ' - page '. $paged; }
       ?>">
<meta name="description" content="<?php bloginfo('description'); ?>">

<meta name="google-site-verification" content="">
<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->

<meta name="author" content="Your Name Here">
<meta name="Copyright" content="Copyright Your Name Here 2011. All Rights Reserved.">

<!-- Dublin Core Metadata : http://dublincore.org/ -->
<meta name="DC.title" content="Ronzaro">
<meta name="DC.subject" content="<?php bloginfo('description'); ?>">
<meta name="DC.creator" content="Ronzaro">

<link rel="shortcut icon" href="../favicon.ico">
     
<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon.png">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/index.css" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/lifestream.css" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/twitter.css" />
<script src="<?php bloginfo('template_directory'); ?>/_/js/modernizr-1.7.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery-1.6.2.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.lifestream.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.timeago.js"></script>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>
	
	<div id="page-wrap">

		<header id="header">
        	<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>">RONZARO</a></h1>			
		</header>
        <?php /* wp_nav_menu(array('theme_location' => 'main-menu',
								'menu-class' => 'dropdown',
								'container_id' => 'navigation',
								'fallback_cb' => 'wp_page_menu' )); */ ?>

