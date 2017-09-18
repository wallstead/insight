<?php
/**
 * BF_FUTURETASTIC functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BF_FUTURETASTIC
 */


if ( ! function_exists( 'bf_futuretastic_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bf_futuretastic_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on BF_FUTURETASTIC, use a find and replace
	 * to change 'bf_futuretastic' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bf_futuretastic', get_template_directory() . '/languages' );

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
		'menu-1' => esc_html__( 'Primary', 'bf_futuretastic' ),
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
	add_theme_support( 'custom-background', apply_filters( 'bf_futuretastic_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'bf_futuretastic_setup' );


add_filter( 'rwmb_meta_boxes', 'your_prefix_meta_boxes' );
function your_prefix_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'Article Info', 'textdomain' ),
        'post_types' => 'post',
        'fields'     => array(
			array(
                'id'   => 'by_line',
                'name' => __( 'By Line', 'textdomain' ),
				'desc' => 'Name of writer',
                'type' => 'text',
            ),
			array(
                'id'   => 'excerpty',
                'name' => __( 'Excerpt', 'textdomain' ),
				'desc' => 'Displayed on home page. Keep to ~110 words.',
				'rows' => 6,
                'type' => 'textarea',
            ),

			array(
                'id'   => 'original_pub_date',
                'name' => __( 'Original Publication Date', 'textdomain' ),
				'desc' => 'Release date of physical publication',
                'type' => 'date',
            ),
			array(
				'id'   => 'color_text',
				'name' => __( 'Text Color', 'your-prefix' ),
				'type' => 'color',
				'std'  => '#ffffff'
			),

			array(
				'id'   => 'color_bg',
				'name' => __( 'Background Color', 'your-prefix' ),
				'type' => 'color',
				'std'  => '#000000'
			)
        ),
    );
    return $meta_boxes;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bf_futuretastic_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bf_futuretastic_content_width', 640 );
}
add_action( 'after_setup_theme', 'bf_futuretastic_content_width', 0 );


/* Registering custom post type */


// function create_post_type() {
//   register_post_type( 'artist_spotlight',
//     array(
//       'labels' => array(
//         'name' => __( 'Artist Spotlights' ),
//         'singular_name' => __( 'Artist Spotlight' )
//       ),
// 	  'public' => true,
// 	  'menu_position' => 20,
// 	  'supports' => array( 'title', 'editor', 'custom-fields' )
//     )
//   );
// }
// add_action( 'init', 'create_post_type' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bf_futuretastic_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bf_futuretastic' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bf_futuretastic' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bf_futuretastic_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bf_futuretastic_scripts() {
	// wp_enqueue_style( 'spectre', get_template_directory_uri() . '/styles/spectre.min.css' );

	wp_enqueue_style( 'bf_futuretastic-style', get_stylesheet_uri() );

	wp_enqueue_style( 'main', get_template_directory_uri() . '/styles/main.css' );

	wp_enqueue_style( 'hamburgers', get_template_directory_uri() . '/styles/hamburgers.min.css' );

	wp_enqueue_style( 'bf_futuretastic-pswp-style', get_template_directory_uri() . '/js/pswp/photoswipe.css' );

	wp_enqueue_style( 'bf_futuretastic-pswp-skin', get_template_directory_uri() . '/js/pswp/default-skin.css' );

	wp_enqueue_script( 'bf_futuretastic-flowtype', get_template_directory_uri() . '/js/flowtype.js', array(), '20151215', true );

	wp_enqueue_script( 'bf_futuretastic-pswp', get_template_directory_uri() . '/js/pswp/photoswipe.min.js', array(), '20151215', true );

	wp_enqueue_script( 'bf_futuretastic-pswp-ui-default', get_template_directory_uri() . '/js/pswp/photoswipe-ui-default.min.js', array(), '20151215', true );

	wp_enqueue_script( 'bf_futuretastic-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'bf_futuretastic-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bf_futuretastic_scripts' );

function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}

add_action('upload_mimes', 'add_file_types_to_uploads');

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
