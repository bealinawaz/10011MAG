<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Resonar
 * @since Resonar 1.0
 */
?>
		<?php get_sidebar(); ?>

	</div><!-- .site-content -->

	<?php /*
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'resonar' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'resonar' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'resonar' ), 'Resonar', '<a href="http://wordpress.com/themes/resonar/" rel="designer">WordPress.com</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->
	*/ ?>
    

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-info">
            <div class="blog-info">
                <a href="<?php echo site_url("/"); ?>" rel="home"><?php echo get_bloginfo("name"); ?></a>
            </div>
            <div class="blog-credits">
                <a href="<?php echo site_url("/"); ?>" class="uppercase" target="_blank"><?php echo get_bloginfo("name"); ?></a>
			</div>
		</div><!-- .site-info -->
    </footer>
    
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
