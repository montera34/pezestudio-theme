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
		'lang' => esc_html__( 'Languages', '_s' ),
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
	wp_enqueue_style( 'fa-css', get_template_directory_uri().'/font-awesome/css/font-awesome.min.css',false,'4.6.3' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri().'/bootstrap/css/bootstrap.min.css',array('pezestudio-fonts'),'3.7.3' );
	if ( is_page_template('page-fullpage.php') ) wp_enqueue_style( 'fullpage-css', get_template_directory_uri().'/fullpagejs/jquery.fullPage.css',array('bootstrap-css'),'2.8.6' );
	wp_enqueue_style( 'pezestudio-css', get_stylesheet_uri(),array('bootstrap-css') );

	wp_dequeue_script('jquery');
	wp_dequeue_script('jquery-core');
	wp_dequeue_script('jquery-migrate');
	wp_enqueue_script('jquery', false, array(), false, true);
	wp_enqueue_script('jquery-core', false, array(), false, true);
	wp_enqueue_script('jquery-migrate', false, array(), false, true);
	wp_enqueue_script( 'menu', get_template_directory_uri() . '/js/dropdown.hover.js', array('jquery'), '0.1', true );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '3.7.3', true );
	if ( is_page_template('page-fullpage.php') ) {
		wp_enqueue_script( 'fullpage-js', get_template_directory_uri() . '/fullpagejs/jquery.fullPage.min.js', array('jquery'), '2.8.6', true );
		wp_enqueue_script( 'page-fullpage-js', get_template_directory_uri() . '/js/page-fullpage.js', array('fullpage-js'), '0.1', true );
	}
	if ( is_page() && !is_page_template('page-fullpage.php') || is_tax(array('line','topic','country','city','status')) || is_home() || is_singular('projects') ) {
		wp_enqueue_script( 'header-bgimage-js', get_template_directory_uri() . '/js/header-bgimage.js', array('jquery'), '0.1', true );
	}
	if ( is_tax(array('line','topic','country','city','status')) || is_post_type_archive('projects') || is_home() ) {
		wp_enqueue_script( 'images-loaded-js', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '4.1.1', true );
		wp_enqueue_script( 'masonry-js', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('images-loaded-js'), '4.1.1', true );
		wp_enqueue_script( 'masonry-options-js', get_template_directory_uri() . '/js/masonry.options.js', array('masonry-js'), '0.1', true );
	}
	if ( is_singular('projects') ) {
		wp_enqueue_script( 'horizontal-slider-js', get_template_directory_uri() . '/js/horizontal.slider.js', array('jquery'), '0.1', true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pezestudio_scripts' );

function pezestudio_scripts_admin() {
	wp_enqueue_style( 'wp-color-picker' ); 
	wp_enqueue_script( 'wp-color-picker' ); 
}
add_action( 'admin_enqueue_scripts', 'pezestudio_scripts_admin' );

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
		echo "<style media='screen' type='text/css'>html {margin-top: 0px !important;} #top-navbar{margin-top: 32px;}</style>";
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
 * Extra fields for attachment post type
 */
function pezestudio_metabox_attachment() {
	add_meta_box(
		'_pezestudio_metabox_attachment_url', // ID
		'URL', // title
		'pezestudio_metabox_attachment_render', // callback function
		'attachment', // post type
		'normal', // context: normal, side, advanced
		'default' // priority: high, core, default, low
	);
}
add_action( 'add_meta_boxes', 'pezestudio_metabox_attachment', 10, 2 );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function pezestudio_metabox_attachment_render( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'pezestudio_metabox_attachment_render', 'pezestudio_metabox_attachment_render_nonce' );

	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	$value = get_post_meta( $post->ID, '_pezestudio_metabox_attachment_url', true );

	echo '<label for="_pezestudio_metabox_attachment_url">URL</label> ';
	echo '<input type="text" id="_pezestudio_metabox_attachment_url" name="_pezestudio_metabox_attachment_url" value="' . esc_attr( $value ) . '" size="50%" />';

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function pezestudio_metabox_attachment_save( $post_id ) {

	/*
	* We need to verify this came from the our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/

	// Check if our nonce is set.
	if ( ! isset( $_POST['pezestudio_metabox_attachment_render_nonce'] ) )
		return $post_id;

	$nonce = $_POST['pezestudio_metabox_attachment_render_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'pezestudio_metabox_attachment_render' ) )
		return $post_id;

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;

	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
  
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	/* OK, its safe for us to save the data now. */

	// Sanitize user input.
	$mydata = sanitize_text_field( $_POST['_pezestudio_metabox_attachment_url'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_pezestudio_metabox_attachment_url', $mydata );
}
add_action( 'save_post', 'pezestudio_metabox_attachment_save' );

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
	$bgimages['bgimage-projects'] = array(
		'post_types' => array('projects'),
		'position' => 'side',
		'labels' => array(
			'name' => $label_name,
			'set' => $label_set,
			'remove' => $label_remove,
			'popup_title' => $label_set,
			'popup_select' => $label_set
		)
	);
	add_theme_support('mfi-reloaded', $bgimages );
}
add_action('after_setup_theme', 'pezestudio_register_custom_images_fullpage');

/*
 * SEARCH FORM OUTPUT */
function pezestudio_get_searchform($post_type,$form_classes,$submit_btn) {
	
	$filters_out = ( $post_type != false ) ? '<input type="hidden" name="post_type" value="'.$post_type.'" />' : '';
	$submit_out = ( $submit_btn != false ) ? '<input type="submit" id="searchsubmit" value="Search" />' : '';
	$form_out = '
	<form method="get" id="searchform" class="'.$form_classes.'" action="'.get_home_url().'/" role="search">
	<div class="form-group">
		'.$filters_out.'
		<label class="sr-only" for="s">'.__("Search projects","_s").'</label>
		<input class="form-control input-sm" type="text" value="" name="s" id="s" placeholder="'.__("Search projects","_s").'" />
		'.$submit_out.'
	</div>
	</form>
	';
	echo $form_out; return;
}


/**
 * EXTRA FIELDS FOR
 * FULL WIDTH IMAGE HEADER */
function pezestudio_metabox_header_data($post_type) {
	if ( $post_type == 'page' || $post_type == 'projects' ) {
		$fields = array(
			'_pezestudio_header_height' => array(
				'name' => __('Header height','_s'),
				'type' => 'text',
				'description' => __('% of screen height','_s')
			),
			'_pezestudio_header_bgcolor' => array(
				'name' => __('Background color','_s'),
				'type' => 'color',
				'description' => __('In case featured image not set.','_s')
			)
		);
		return $fields;
	}
}

function pezestudio_metabox_header() {
	add_meta_box(
		'_pezestudio_metabox_header', // ID
		__('Header settings','_s'), // title
		'pezestudio_metabox_header_render', // callback function
		array('page','projects'), // post type
		'side', // context: normal, side, advanced
		'low' // priority: high, core, default, low
	);
}
add_action( 'add_meta_boxes', 'pezestudio_metabox_header', 10, 2 );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function pezestudio_metabox_header_render( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'pezestudio_metabox_header_render', 'pezestudio_metabox_header_render_nonce' );

	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	foreach ( pezestudio_metabox_header_data(get_post_type()) as $id => $data ) {
		$value = get_post_meta( $post->ID, $id, true );

		echo '<fieldset>
			<label for="'.$id.'">'.$data["name"].'</label><br />
			<input type="text" class="'.$id.'" name="'.$id.'" value="' . esc_attr( $value ) . '" /><br /><span class="howto">'.$data["description"].'</span>';
 		if ( $data['type'] == 'color' ) {
			echo '<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".'.$id.'").wpColorPicker();
			});
			</script>';
		}
		echo '</fieldset>';
	}
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function pezestudio_metabox_header_save( $post_id ) {

	/*
	* We need to verify this came from the our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/

	// Check if our nonce is set.
	if ( ! isset( $_POST['pezestudio_metabox_header_render_nonce'] ) )
		return $post_id;

	$nonce = $_POST['pezestudio_metabox_header_render_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'pezestudio_metabox_header_render' ) )
		return $post_id;

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;

	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
  
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	/* OK, its safe for us to save the data now. */
	if ( is_page() ) $pt = "page";
	elseif ( get_post_type() ) $pt = "projects";
	foreach ( pezestudio_metabox_header_data($pt) as $id => $data ) {
		// Sanitize user input.
		$value = sanitize_text_field( $_POST[$id] );
		// Update the meta field in the database.
		update_post_meta( $post_id, $id, $value );
	}	
}
add_action( 'save_post', 'pezestudio_metabox_header_save' );

// Get attachment ID
// from URL
// https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
function pezestudio_get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
		return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}
	return $attachment_id;
}
