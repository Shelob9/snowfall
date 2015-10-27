<?php
/**
 * snowfall functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */

add_action( 'after_setup_theme', 'snowfall_setup' );
/**
 * All setup functionalities.
 *
 * @since 1.0
 */
if( !function_exists( 'snowfall_setup' ) ) :
function snowfall_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 783;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'snowfall', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' );

	// Registering navigation menu.
	register_nav_menu( 'primary', __( 'Primary Menu', 'snowfall' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'snowfall' ) );

	// Cropping the images to different sizes to be used in the theme
   add_image_size( 'snowfall-featured-abt', 642, 349, true );
   add_image_size( 'snowfall-featured-post', 781, 512, true );
   add_image_size( 'snowfall-portfolio-image', 400, 350, true );
   add_image_size( 'snowfall-featured-image', 319, 142, true );
   add_image_size( 'snowfall-services', 470, 280, true );

	/*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
   add_theme_support('title-tag');

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );

	/*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
   add_theme_support('html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
   ));
}
endif;

/**
 * Define Directory Location Constants
 */
define( 'snowfall_PARENT_DIR', get_template_directory() );
define( 'snowfall_CHILD_DIR', get_stylesheet_directory() );

define( 'snowfall_INCLUDES_DIR', snowfall_PARENT_DIR. '/inc' );
define( 'snowfall_CSS_DIR', snowfall_PARENT_DIR . '/css' );
define( 'snowfall_JS_DIR', snowfall_PARENT_DIR . '/js' );
define( 'snowfall_LANGUAGES_DIR', snowfall_PARENT_DIR . '/languages' );

define( 'snowfall_ADMIN_DIR', snowfall_INCLUDES_DIR . '/admin' );
define( 'snowfall_WIDGETS_DIR', snowfall_INCLUDES_DIR . '/widgets' );

define( 'snowfall_ADMIN_IMAGES_DIR', snowfall_ADMIN_DIR . '/images' );

/**
 * Define URL Location Constants
 */
define( 'snowfall_PARENT_URL', get_template_directory_uri() );
define( 'snowfall_CHILD_URL', get_stylesheet_directory_uri() );

define( 'snowfall_INCLUDES_URL', snowfall_PARENT_URL. '/inc' );
define( 'snowfall_CSS_URL', snowfall_PARENT_URL . '/css' );
define( 'snowfall_JS_URL', snowfall_PARENT_URL . '/js' );
define( 'snowfall_LANGUAGES_URL', snowfall_PARENT_URL . '/languages' );

define( 'snowfall_ADMIN_URL', snowfall_INCLUDES_URL . '/admin' );
define( 'snowfall_WIDGETS_URL', snowfall_INCLUDES_URL . '/widgets' );

define( 'snowfall_ADMIN_IMAGES_URL', snowfall_ADMIN_URL . '/images' );

/** Load functions */
// require_once( snowfall_INCLUDES_DIR . '/custom-header.php' );
require_once( snowfall_INCLUDES_DIR . '/functions.php' );
require_once( snowfall_INCLUDES_DIR . '/header-functions.php' );
require_once( snowfall_INCLUDES_DIR . '/customizer.php' );

require_once( snowfall_ADMIN_DIR . '/meta-boxes.php' );

// /** Load Widgets and Widgetized Area */
require_once( snowfall_WIDGETS_DIR . '/widgets.php' );

?>
