<?php
/**
 * _s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( 'pezestudio_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pezestudio_setup() {

	// theme global vars
	if (!defined('PEZESTUDIO_BLOGNAME'))
	    define('PEZESTUDIO_BLOGNAME', get_bloginfo('name'));

	if (!defined('PEZESTUDIO_BLOGDESC'))
	    define('PEZESTUDIO_BLOGDESC', get_bloginfo('description','display'));

	if (!defined('PEZESTUDIO_BLOGURL'))
	    define('PEZESTUDIO_BLOGURL', esc_url( home_url( '/' ) ));

	if (!defined('PEZESTUDIO_BLOGTHEME'))
	    define('PEZESTUDIO_BLOGTHEME', get_bloginfo('template_directory'));

	if (!defined('PEZESTUDIO_BGIMAGE_AMMOUNT'))
	    define('PEZESTUDIO_BGIMAGE_AMMOUNT', '5' );

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', '_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'pezestudio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', '_s' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pezestudio_scripts() {
	wp_enqueue_style( 'pezestudio-fonts', get_template_directory_uri().'/fonts/style.css' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri().'/bootstrap/css/bootstrap.min.css',array('pezestudio-fonts'),'3.7.3' );
	wp_enqueue_style( 'fullpage-css', get_template_directory_uri().'/fullpagejs/jquery.fullPage.css',array('bootstrap-css'),'2.8.6' );
	wp_enqueue_style( 'pezestudio-css', get_stylesheet_uri(),array('bootstrap-css') );

	wp_dequeue_script('jquery');
	wp_dequeue_script('jquery-core');
	wp_dequeue_script('jquery-migrate');
	wp_enqueue_script('jquery', false, array(), false, true);
	wp_enqueue_script('jquery-core', false, array(), false, true);
	wp_enqueue_script('jquery-migrate', false, array(), false, true);
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '3.7.3', true );
	wp_enqueue_script( 'fullpage-js', get_template_directory_uri() . '/fullpagejs/jquery.fullPage.min.js', array('jquery'), '2.8.6', true );
//	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

//	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pezestudio_scripts' );

// load scripts for IE compatibility
function pezestudio_extra_scripts_styles() {
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src='https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js'></script>
	<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
	<![endif]-->
	";
	if ( is_user_logged_in() ) {
		echo "<style media='screen' type='text/css'>#top-navbar{margin-top: 32px;}</style>";
	}
}
/* Load scripts for IE compatibility */
add_action('wp_head','pezestudio_extra_scripts_styles',999);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Multiple Featured Images
 * it depends on MFI Reloaded plugin
 */
function pezestudio_register_custom_images_fullpage() {
	$label_name = __('Background image','_s');
	$label_set = __('Set background image','_s');
	$label_remove = __('Remove background image','_s');
	$count = 1;
	$bgimages = array();
	while ( PEZESTUDIO_BGIMAGE_AMMOUNT >= $count ) {
		$bgimages['bgimage-'.$count] = array(
			'post_types' => array('page'),
			'position' => 'normal',
			'labels' => array(
				'name' => $label_name.' '.$count,
				'set' => $label_set,
				'remove' => $label_remove,
				'popup_title' => $label_set,
				'popup_select' => $label_set
			)
		);
		$count++;
	}
	add_theme_support('mfi-reloaded', $bgimages );
}
add_action('after_setup_theme', 'pezestudio_register_custom_images_fullpage');
