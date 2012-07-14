<?php
/*
Set this to be the twice as wide as the max-width of the main content area so that retina graphics can happen.
*/
if ( ! isset( $content_width ) ) $content_width = 2560;

function tdd_theme_setup() {

	/* Register our sidebars. */
	register_sidebar( array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => "</li>\n",
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => "</h2>\n"
	) );

	/* Register navigation menu slugs/locations for use in the theme files. */
	register_nav_menus( array(
		'Header' => 'Main navigation menu in the header'
	) );


	/**
	 * Add theme support for:
	 * auto feed links - inserts RSS feed discovery
	 * Post thumbnails - So darn useful
	 * Custom background - Generally no reason not to.
	 * And some others that I've left commented out
	 */

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background' ); // Accepts array of arguments http://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Background
	// add_theme_support( 'post-formats', array() );
	// add_theme_support( 'custom-header', array() );

	/* An approximation of what is shown on the front-end for TinyMCE. Typography, mostly. */
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tdd_theme_setup' );

/**
 * Enqueue Front-End Scripts and Styles
 */
function tdd_enqueue_scripts() {
	$min = defined( 'SCRIPT_DEBUG' ) ? 'min.' : '';

	// Styles
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/default-styles.' . $min . 'css', array(), null );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/style.css', array( 'normalize' ), null );

	// Scripts
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr-2.5.3-dev.' . $min . 'js', array(), '2.5.3', false ); // must be in header
	wp_enqueue_script( 'global', get_template_directory_uri() . '/js/global.js', array( 'jquery' ), null, true );
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	/* Set variables to use in javascript. e.g. phpVars.ajaxurl */
	/* Uncomment if needed
	$php_variables_for_javascript = array(
		'ajaxurl'                => admin_url( 'admin-ajax.php' ),
		'template_directory_uri' => get_template_directory_uri()
		);
	wp_localize_script( 'global', 'phpVars', $php_variables_for_javascript );
	*/
}

add_action( 'wp_enqueue_scripts', 'tdd_enqueue_scripts' );


/*
Clean-up <HEAD> by removing crap we don't need.

By default, Wordpress includes a lot of things in <head> that aren't totally necessary.
Since SEO read a finite number of bytes down the file, it'd behoove us to keep <head> as cleaned up as possible.

@todo: expand on these definitions and ensure their accuracy.
*/
add_action( 'init', 'tdd_shampoo' );
function tdd_shampoo() {
	remove_action( 'wp_head', 'rsd_link' ); //Really Simple Discovery. Need for some external editors
	remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer. Need for, well, Windows Live Writer
	remove_action( 'wp_head', 'wp_generator' ); //Adds a line in <head> that has the WP version

	// These may be helpful for screen readers on bloggy blogs, but by default I'm taking them out.
	remove_action( 'wp_head', 'parent_post_rel_link' ); //Adds a link rel=parent and the URL to the parent page
	remove_action( 'wp_head', 'start_post_rel_link' ); //Adds a link rel=start_post and the URL to that.
	remove_action( 'wp_head', 'index_rel_link' ); //Adds a link rel=index to your home page.
}

/*
This function filters the [caption] shortcode and outputs the same thing, but using HTML5's fancy new <figure> and <figcaption> semantic tags. It's mo' bettah
*/
add_filter( 'img_caption_shortcode', 'tdd_html5ize_captions', 10, 3 );
function tdd_html5ize_captions( $blank = '', $attr, $content ) {
	extract( shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	), $attr ) );

	if ( $id ) $id = 'id="' . esc_attr( $id ) . '" ';

	$return = '<figure ' . $id . ' class="wp-caption ' . esc_attr( $align ) . '" style="width: ' . ( 10 + (int) $width ) . 'px">' . $content;
	if ( $caption ) $return .= '<figcaption class="wp-caption-text">' . do_shortcode( $caption ) . '</figcaption>';
	$return .= '</figure>';

	return $return;
}

/*
This function deals with relative dates. It filters the time difference between now() and the_date() displaying strings for pretty much everything. Credit goes to the beautiful Terri Swallow: http://terriswallow.com/weblog/2008/relative-dates-in-wordpress-templates/ although the function name was renamed to fit with everything else in this package.

Also modified is that it simply returns
*/

function tdd_how_long_ago( $the_date, $d ) {
	$the_date   = strtotime( $the_date );
	$difference = time() - $the_date;

	if ( $difference >= 60 * 60 * 24 * 365 ) { // if more than a year ago
		//if more than a year, display the date according to date format.
		$r = date( get_option( 'date_format' ), $the_date );
		//	$int = intval($difference / (60*60*24*365));
		//	$s = ($int > 1) ? 's' : '';
		//	$r = $int . ' year' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 * 24 * 7 * 5 ) { // if more than five weeks ago
		$int = intval( $difference / ( 60 * 60 * 24 * 30 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' month' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 * 24 * 7 ) { // if more than a week ago
		$int = intval( $difference / ( 60 * 60 * 24 * 7 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' week' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 * 24 ) { // if more than a day ago
		$int = intval( $difference / ( 60 * 60 * 24 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' day' . $s . ' ago';
	} elseif ( $difference >= 60 * 60 ) { // if more than an hour ago
		$int = intval( $difference / ( 60 * 60 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' hour' . $s . ' ago';
	} elseif ( $difference >= 60 ) { // if more than a minute ago
		$int = intval( $difference / ( 60 ) );
		$s   = ( $int > 1 ) ? 's' : '';
		$r   = $int . ' minute' . $s . ' ago';
	} else { // if less than a minute ago
		$r = 'moments ago';
	}

	return $r;
}

add_filter( 'get_the_date', 'tdd_how_long_ago', 10, 2 );