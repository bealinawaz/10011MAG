<?php
/**
 * Resonar functions and definitions
 *
 * @package Resonar
 * @since Resonar 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1088;
}

/**
 * Resonar only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'resonar_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function resonar_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Resonar, use a find and replace
	 * to change 'dev' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'dev', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 256, 256, true );
	add_image_size( 'resonar-large', 2000, 1500, true  );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'dev' ),
		'social'  => __( 'Social Links Menu', 'dev' ),
		'secondary'  => __( 'Secondary Menu', 'dev' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'resonar_custom_background_args', array(
		'default-color'    => 'ffffff',
		'wp-head-callback' => 'resonar_custom_background_cb'
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'editor-style.css', 'genericons/genericons.css', resonar_fonts_url() ) );
}
endif; // resonar_setup
add_action( 'after_setup_theme', 'resonar_setup' );

if ( ! function_exists( 'resonar_custom_background_cb' ) ) :
/**
 * Add a wp-head callback to the custom background
 *
 * @since Resonar 1.0.3
 */
function resonar_custom_background_cb() {
	$background_image = get_background_image();
	$color = get_background_color();
	if ( ! $background_image && ! $color ) { return; } ?>
	<style type="text/css" id="resonar-custom-background-css">
	<?php if ( ! empty ( $background_image ) ) { ?>
			body.custom-background {
				background-image: url(<?php echo esc_url( $background_image ); ?>);
			}

	<?php } elseif ( 'ffffff' != $color ) { ?>
			body.custom-background,
			.site-header .sub-menu li,
			.sidebar {
				background-color: #<?php echo esc_attr( $color ); ?>;
			}

			.site-header .nav-menu > li > .sub-menu:after {
				border-color: #<?php echo esc_attr( $color ); ?> transparent;
			}

			.pagination .prev:hover,
			.pagination .prev:focus,
			.pagination .next:hover,
			.pagination .next:focus,
			.widget_calendar tbody a,
			.widget_calendar tbody a:hover,
			.widget_calendar tbody a:focus,
			.page-links a,
			.page-links a:hover,
			.page-links a:focus {
				color: #<?php echo esc_attr( $color ); ?>;
			}
	<?php } ?>
	</style>
<?php } endif;

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function resonar_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'dev' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'dev' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar Area', 'dev' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'dev' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
} add_action( 'widgets_init', 'resonar_widgets_init' );

if ( ! function_exists( 'resonar_fonts_url' ) ) :
/**
 * Register Google fonts for Resonar.
 *
 * @since Resonar 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function resonar_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Libre Baskerville, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Libre Baskerville font: on or off', 'dev' ) ) {
		$fonts[] = 'Libre Baskerville:400,700,400italic';
	}

	/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'dev' ) ) {
		$fonts[] = 'Lato:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'dev' ) ) {
		$fonts[] = 'Playfair Display:400,700,400italic,700italic';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'dev' ) ) {
		$fonts[] = 'Inconsolata:400';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'cyrillic'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (cyrillic)', 'dev' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Resonar 1.0
 */
function resonar_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	?><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"><?php
}
add_action( 'wp_head', 'resonar_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Resonar 1.0
 */
function resonar_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'resonar-fonts', resonar_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.3' );

	// Load our main stylesheet.
	wp_enqueue_style( 'resonar-style', get_stylesheet_uri() );

	// New Style 2
	wp_enqueue_style( 'style2', get_template_directory_uri() . '/style2.css', array(), '1.0' );

	// Jetpack CSS
	wp_enqueue_style( 'jetpack-css', get_template_directory_uri() . '/jetpack.css', array(), '1.0' );

	wp_enqueue_script( 'resonar-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20150302', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'resonar-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20150302' );
	}

	wp_enqueue_script( 'resonar-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150302', true );

	wp_localize_script( 'resonar-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'dev' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'dev' ) . '</span>',
	) );

	wp_localize_script( 'resonar-script', 'toggleButtonText', array(
		'menu'    => __( 'Menu', 'dev' ),
		'widgets' => __( 'Widgets', 'dev' ),
		'both'    => __( 'Menu &amp; Widgets', 'dev' ),
	) );
} add_action( 'wp_enqueue_scripts', 'resonar_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Resonar 1.0
 */
function resonar_admin_fonts() {
	wp_enqueue_style( 'resonar-fonts', resonar_fonts_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'resonar_admin_fonts' );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Resonar 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function resonar_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'resonar_search_form_modify' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function resonar_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'single';
	}

	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'custom-menu';
	}

	return $classes;
}
add_filter( 'body_class', 'resonar_body_classes' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


###################################################################################


require "components.php";
require "metaboxes.php";

#BB_METABOX_ARR
function BB_METABOX_ARR() { return array( #BB_METABOX_ARR

	array( #METABOX
		"id" => "bb-post-options", "title" => "Post Options",
		"pages" => array( "post" ), "context" => "normal", "priority" => "default",
		"option" =>  array( #OPTION
			array ("type" => "select", "title" => "Is post feature?", "description" => "chosoe the option.", "id" => "bb_featured", "class" => "bb_featured", "name" => "bb_featured", "option" => array("not_featured" => "Not Featured", "featured" => "Featured"), "default_value" => "", ),
			array ("type" => "text", "title" => "Post Sub Title", "description" => "write the text.", "id" => "bb_sub_title", "class" => "bb_sub_title", "name" => "bb_sub_title", "default_value" => "", ),
		), #OPTION
	), #METABOX

	array( #METABOX
		"id" => "bb-product-options", "title" => "Product Options",
		"pages" => array( "product" ), "context" => "normal", "priority" => "default",
		"option" =>  array( #OPTION
			array ("type" => "text", "title" => "Brand Name", "description" => "write the text.", "id" => "product-brand-name", "class" => "product-brand-name", "name" => "product-brand-name", "default_value" => "", ),
			array ("type" => "text", "title" => "Brand Link", "description" => "write the link.", "id" => "product-brand-link", "class" => "product-brand-link", "name" => "product-brand-link", "default_value" => "", ),

			array ("type" => "text", "title" => "Buy Link", "description" => "write the link.", "id" => "product-buy-link", "class" => "product-buy-link", "name" => "product-buy-link", "default_value" => "", ),
		), #OPTION
	), #METABOX

); } #BB_METABOX_ARR

function themename_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'themename_custom_logo_setup' );

function buy_guides_init() {
	#register_taxonomy( 'buy-guides', 'post', array( 'label' => __( 'Buy Guide' ), 'rewrite' => array( 'slug' => 'buy-guides' ), ) );

	/*register_post_type( 'product', array(
		'labels' => array( 'name' => __( 'Products' ), 'singular_name' => __( 'Product' ) ),
		'public' => true,
		'has_archive' => false,
		'rewrite' => array('slug' => 'buy'),
		'supports' => array("title", "author", "thumbnail", "excerpt"),
		'taxonomies' => array("post_tag", "category"),
	) );*/
	
	$labels = array(
		'name'              => _x( 'Gift Guides', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Gift Guide', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Gift Guides', 'textdomain' ),
		'all_items'         => __( 'All Gift Guides', 'textdomain' ),
		'parent_item'       => __( 'Parent Gift Guide', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Gift Guide:', 'textdomain' ),
		'edit_item'         => __( 'Edit Gift Guide', 'textdomain' ),
		'update_item'       => __( 'Update Gift Guide', 'textdomain' ),
		'add_new_item'      => __( 'Add New Gift Guide', 'textdomain' ),
		'new_item_name'     => __( 'New Gift Guide', 'textdomain' ),
		'menu_name'         => __( 'Gift Guide', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_in_rest'		=> true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'buy-guides' ),
	);

	register_taxonomy( 'productguide', array( 'product' ), $args );

} add_action( 'init', 'buy_guides_init' );

function remove_support_product() {
	remove_post_type_support( 'product', 'revisions' );
	remove_post_type_support( 'product', 'comments' );
} #add_action( 'init', 'remove_support_product' );


###################################################################################


add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

function woo_css() { ?><style type="text/css">
	.woocommerce ul.products { display: grid; grid-template-columns: 31% 31% 31%; grid-column-gap: 30px; grid-row-gap: 30px; }
	.woocommerce ul.products li.product { display: block !important; text-align: center; width: auto !important; float: none !important; grid-template-columns: auto !important; margin: 0; }
	.woocommerce ul.products li.product .button { margin-bottom: 2em; }
	.woocommerce .products ul::after, .woocommerce .products ul::before, .woocommerce ul.products::after, .woocommerce ul.products::before { display: none !important; }

	.woocommerce div.product { display: block !important; }
	.woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary { margin-right: 0; }
	.entry-content { margin: 0; }
</style><?php } add_action("wp_head", "woo_css");

function new_woocommerce_sidebar() { ?>
    <div id="fixednav" class="fixed-nav"><div class="fixed-nav-wrap">
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : dynamic_sidebar( 'sidebar-2' ); endif; // sidebar 2 ?>
    </div></div>
<?php } add_action("woocommerce_sidebar", "new_woocommerce_sidebar");