<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Resonar
 * @since Resonar 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<style type="text/css">
.blog.has-fullscreen-featured-post .site-header { position: absolute; z-index: 1001; }
.blog.has-fullscreen-featured-post .site-header .menu a,
.blog.has-fullscreen-featured-post .site-header .nav-menu a { color: #FFF; }
.blog.has-fullscreen-featured-post .sidebar-toggle:before { color: #FFF; }
.blog.has-fullscreen-featured-post .site-branding a img { -webkit-filter: invert(100%); filter: invert(100%); }

.secondary-menus .jetpack-social-navigation a { font-size:18px; padding:0; }
.site-header .nav-menu>li+li { border-color: hsla(0,0%,98%,.5); }
.blog.has-fullscreen-featured-post .site-header .nav-menu ul li a { color: #000; }
.fixed .fixed-nav .fixed-nav-wrap { width: 100%; }

@media only screen and (max-width: 924px) {
	.blog.has-fullscreen-featured-post .site-branding a img { -webkit-filter: invert(0%); filter: invert(0%); }
	.blog.has-fullscreen-featured-post .sidebar-toggle:before { color: #000; }
}
</style>
<script>jQuery(window).scroll(function(){
	var scroll = jQuery(window).scrollTop();
	var sidebar_scroll = jQuery(".fixed-nav .fixed-nav-wrap").position().top;
	if(scroll > sidebar_scroll) {
		jQuery("body").addClass("fixed");
	} else {
		jQuery("body").removeClass("fixed");
	}
});</script>
</head>
<?php #$post_feature_class = (get_post_meta(get_the_ID, "bb_featured", true) == "featured") ? "" : ""; ?>
<?php
	$bb_featured = get_post_meta(get_the_ID(), "bb_featured", true);
	if(is_single()) {
		$body_class = ($bb_featured == "featured") ? "blog has-fullscreen-featured-post" : "";
	} elseif(is_home()) {
		$body_class = "blog has-fullscreen-featured-post";
	} else {
	}
?>

<body <?php body_class($body_class); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'resonar' ); ?></a>

	<?php /*if ( get_header_image() ) : ?>
		<div class="header-image">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</a>
		</div>
	<?php endif; // End header image check. ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php resonar_the_site_logo(); ?>

			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<button id="sidebar-toggle" class="sidebar-toggle"></button>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="main-navigation" role="navigation">
				<?php
					// Primary navigation menu.
					wp_nav_menu( array(
						'menu_class'     => 'nav-menu',
						'theme_location' => 'primary',
					) );
				?>
			</nav><!-- .main-navigation -->
		<?php endif; ?>
	</header><!-- .site-header --> */ ?>


    <header id="masthead" class="site-header" role="banner">
        <div class="secondary-menus">
            <nav class="secondary-navigation" role="secondary-navigation"><?php wp_nav_menu(array("menu_class" => "menu-secondary-menu-container", "menu_id" => "menu-secondary-menu", "menu_class" => "nav-menu", "theme_location" => "secondary")); ?></nav><!-- .main-navigation -->
            <nav class="jetpack-social-navigation jetpack-social-navigation-svg" role="navigation" aria-label="Social Links Menu"><?php wp_nav_menu(array("theme_location" => "social")); ?></nav><!-- .jetpack-social-navigation -->
        </div>
        <div class="site-branding">
			<a href="<?php echo site_url("/"); ?>" class="site-logo-link" rel="home" itemprop="url"><img width="300" height="113" src="<?php $custom_logo_id = get_theme_mod( 'custom_logo' ); $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' ); if(has_custom_logo()) { echo esc_url($logo[0]); } ?>" alt="" data-size="medium" itemprop="logo" data-lazy-loaded="1" sizes="(max-width: 300px) 100vw, 300px"></a>
        </div><!-- .site-branding -->
        <button id="sidebar-toggle" class="sidebar-toggle" aria-expanded="false">Widgets</button>
        <nav class="main-navigation" role="navigation"><?php wp_nav_menu(array("menu_class" => "nav-menu", "theme_location" => "primary")); ?></nav><!-- .main-navigation -->
    </header>

	<div id="content" class="site-content">
