<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Resonar
 * @since Resonar 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
            
            <div class="active-product-categories"></div>
            <div id="main" class="product-grid-wrap" style="position: relative;">

				<?php // Start the Loop.
                while ( have_posts() ) : the_post();
    
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'content', 'productguide' );
    
                // End the loop.
                endwhile; ?>
            
            </div>

		<?php // If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->
    <div id="fixednav" class="fixed-nav"><div class="fixed-nav-wrap">
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : dynamic_sidebar( 'sidebar-2' ); endif; // sidebar 2 ?>
    </div></div>

	<?php
		if ( have_posts() ) :
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'resonar' ),
				'next_text'          => __( 'Next page', 'resonar' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'resonar' ) . ' </span>',
			) );
		endif;
	?>
<?php get_footer(); ?>
