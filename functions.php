<?php
/**
 * PenBird functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PenBird
 */

if (!defined('penbird_VERSION')) {
	$penbird_theme = wp_get_theme();
	define('penbird_VERSION', $penbird_theme->get('Version'));
}

if ( ! function_exists( 'penbird_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function penbird_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on penbird, use a find and replace
		 * to change 'penbird' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'penbird', get_template_directory() . '/languages' );

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
		
		// Image Size
		add_image_size('penbird-blog-thumb', 500, 338, true);
		add_image_size('penbird-blog-single-thumb', 770, 380, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'penbird' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'penbird_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		
		/*
		* Enable support for wide alignment class for Gutenberg blocks.
		*/
		add_theme_support( 'align-wide' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		
		// Woocommerce
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		
	}
endif;
add_action( 'after_setup_theme', 'penbird_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function penbird_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Default Sidebar', 'penbird' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'penbird' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Post Sidebar', 'penbird' ),
			'id'            => 'penbird_post_sidebar',
			'description'   => esc_html__( 'Widgets for single posts. If empty, the Default Sidebar is used.', 'penbird' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 1', 'penbird' ),
		'id'            => 'penbird_footer_1',
		'description'   => esc_html__( 'Add footer widget here.', 'penbird' ),
		'before_widget' => '<div id="%1$s" class="penbird-footer__widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 2', 'penbird' ),
		'id'            => 'penbird_footer_2',
		'description'   => esc_html__( 'Add footer widget here.', 'penbird' ),
		'before_widget' => '<div id="%1$s" class="penbird-footer__widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 3', 'penbird' ),
		'id'            => 'penbird_footer_3',
		'description'   => esc_html__( 'Add footer widget here.', 'penbird' ),
		'before_widget' => '<div id="%1$s" class="penbird-footer__widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'penbird_widgets_init' );


function penbird_wpdocs_custom_excerpt_length( $length ) {
    $excerptlength = absint(get_theme_mod('penbird_post_excerpt',28));
    return $excerptlength;
}
add_filter( 'excerpt_length', 'penbird_wpdocs_custom_excerpt_length', 999 );


/**
 * Enqueue scripts and styles.
 */
function penbird_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/resource/css/bootstrap.css', array(), '5.1.3' );
	wp_enqueue_style( 'font-awesome-all', get_template_directory_uri() . '/resource/css/font-awesome-all.css', array(), '6.1.1' );
	wp_enqueue_style( 'penbird-theme-default', get_template_directory_uri() . '/resource/css/theme-default.css', array(), '1.0.0' );
	wp_enqueue_style( 'penbird-woocommerce', get_template_directory_uri() . '/resource/css/woowcommerce.css', array(), '1.0.0' );
	wp_enqueue_style( 'penbird-style', get_stylesheet_uri(), array(), penbird_VERSION );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/resource/js/bootstrap.js', array('jquery'), '5.1.3', true );
	wp_enqueue_script( 'penbird-navigation', get_template_directory_uri() . '/resource/js/navigation.js', array(), penbird_VERSION, true );
    wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'penbird-keyboard-nav', get_template_directory_uri() . '/resource/js/keyboard-nav.js', array('jquery'), penbird_VERSION, true );
	wp_enqueue_script( 'penbird-skip-link', get_template_directory_uri() . '/resource/js/skip-link-focus-fix.js', array('jquery'), penbird_VERSION, true );
	wp_enqueue_script( 'penbird-active', get_template_directory_uri() . '/resource/js/active.js', array('jquery'), penbird_VERSION, true );

	if ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_product_taxonomy() ) ) {
		wp_enqueue_script( 'penbird-shop-filters', get_template_directory_uri() . '/resource/js/shop-filters.js', array( 'jquery' ), penbird_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'penbird_scripts' );

require get_template_directory() . '/includes/class-penbird-options.php';
require get_template_directory() . '/includes/custom-header.php';
require get_template_directory() . '/includes/template-tags.php';
require get_template_directory() . '/includes/template-functions.php';
require get_template_directory() . '/includes/theme-font.php';
require get_template_directory() . '/includes/tgm/required-plugins.php';
require get_template_directory() . '/includes/customizer/customizer.php';
require get_template_directory() . '/includes/admin/class-penbird-dashboard.php';
require get_template_directory() . '/includes/admin/class-penbird-page-settings.php';
require get_template_directory() . '/includes/woow-default.php';
