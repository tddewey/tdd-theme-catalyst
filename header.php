<!DOCTYPE html>
<!--[if IEMobile 7]><html class="no-js iem7 oldie"><![endif]-->
<!--[if lt IE 7]>
<html class="no-js ie6 oldie" <?php language_attributes(); ?>><![endif]-->
<!--[if (IE 7)&!(IEMobile)]>
<html class="no-js ie7 oldie" <?php language_attributes(); ?>><![endif]-->
<!--[if (IE 8)&!(IEMobile)]>
<html class="no-js ie8 oldie" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!-->
<html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title><?php wp_title( '' ); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/shortcut-icons/apple-touch-icon-precomposed.png">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/shortcut-icons/apple-touch-icon-precomposed.png">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/shortcut-icons/favicon.ico">
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="canonical" href=" <?php the_permalink(); ?> ">

	<?php wp_head(); ?>

</head>
<body <?php body_class( 'clearfix' ); ?> >
<header role="banner">
	<hgroup>
		<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'title' ); ?></a></h1>

		<h2><?php bloginfo( 'description' );  ?></h2>
	</hgroup>

	<?php wp_nav_menu( array(
	'container'      => 'nav',
	'theme_location' => 'Header',
	'fallback_cb'    => '',
) ); ?>

</header>
