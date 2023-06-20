<?php
/**
 * @package Resonar
 * @since Resonar 1.0
 */
?>

<?php $bb_featured = get_post_meta(get_the_ID(), "bb_featured", true); $author = get_the_author(); $categories = get_the_terms( get_the_ID(), 'category' ); ?>

<?php if($bb_featured == "featured") { ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div class="entry-header-background" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), "full"); ?>); height: 723px; margin-left: -407.5px; margin-right: -407.5px;">
            <div class="entry-header-wrapper">
                <div class="entry-header-inner">
                    <header id="entry-header" class="entry-header">
                        <h2 class="entry-title"><a href="<?php echo get_the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <h3 class="entry-subtitle"><?php echo get_post_meta(get_the_ID(), "bb_sub_title", true); ?></h3>
                        <div class="entry-metadata">
                            <div class="entry-author"><span class="screen-reader-text">Posted by </span><a href="<?php echo get_the_author_link(); ?>" title="Posts by <?php echo $author; ?>" class="author url fn" rel="author"><?php echo $author; ?></a></div>
                            <div class="entry-date"><span class="posted-on"><span class="screen-reader-text">Posted on </span><time class="entry-date published" datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></span></div>
                        </div>
                        <div class="entry-category">
                            <?php foreach( $categories as $category ) { ?>
                                <a class="entry-primary-category" href="<?php echo get_the_permalink($category->term_id); ?>"><?php echo $category->name; ?></a>
                            <?php } ?>
                        </div>
                    </header>
                    <div class="scroll-indicator-wrapper"><a href="#" id="scroll-indicator" class="scroll-indicator"><span class="screen-reader-text">Scroll down to see more content</span></a></div>
                </div>
            </div>
            <a class="mobile-image-link" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>" aria-hidden="true"></a>
        </div>
    
    </article>

	<div class="entry-content"><?php the_content(); ?></div><!-- .entry-content -->
<?php } else { ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header id="entry-header" class="entry-header">
            <h1 class="entry-title"><a href="<?php echo get_the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <div class="entry-category">
                <?php foreach( $categories as $category ) { ?>
                    <a class="entry-primary-category" href="<?php echo get_the_permalink($category->term_id); ?>"><?php echo $category->name; ?></a>
                <?php } ?>
            </div>
        </header>

		<?php the_post_thumbnail("large-square-thumb"); ?>

        <div class="entry-content">
            <?php the_content(); ?>
            <div class="entry-metadata">
                <p>Added: <span class="posted-on">
                    <span class="screen-reader-text">Posted on </span>
                        <time class="entry-date published" datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
                        <time class="updated" datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
                    </span>
                </p>
            </div>
        </div><!-- .entry-content -->
        <footer class="entry-footer"><div class="posted-in">
            <span class="cat-links productcategory-links">
                <span class="screen-reader-text">Product Categories</span>
                <span class="posted-in-text">Posted in </span>
                <?php $cats = get_the_terms( get_the_ID(), 'category' ); foreach( $cats as $cat ) { #Category ?>
                    <a href="<?php echo get_the_permalink($cat->term_id); ?>" rel="category tag"><?php echo $cat->name; ?></a>
                <?php } #Category ?>
            </span>
        
            <span class="cat-links productguide-links">
                <span class="screen-reader-text">Product Guides</span>
                <span class="posted-in-text">Gift Guides: </span>
                <?php $terms = wp_get_post_terms( get_the_ID(), 'productguide', array( 'taxonomy' => 'productguide' ) ); foreach( $terms as $term ) { #Category ?>
                    <a href="<?php echo get_the_permalink($term->term_id); ?>" rel="category tag"><?php echo $term->name; ?></a>
                <?php } #Category ?>
            </span>
            
            <span class="tags-links">
                <span class="screen-reader-text">Tags</span>
                <?php $tags = wp_get_post_tags( get_the_ID() ); foreach( $tags as $tag ) { #Category ?>
                    <a href="<?php echo get_the_permalink($tag->term_id); ?>" rel="category tag"><?php echo $tag->name; ?></a>
                <?php } #Category ?>
            </span>
        </div></footer><!-- .entry-footer -->
    
	</article>

<?php } ?>

<?php /*
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( has_post_thumbnail() && ! post_password_required() ) : $featuredimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'resonar-large' ); ?>
		<div class="entry-header-background" style="background-image:url(<?php echo esc_url( $featuredimage[0] ); ?>)">
			<div class="entry-header-wrapper">
				<header id="entry-header" class="entry-header">
					<div class="entry-header-inner">
						<div class="entry-date"><?php resonar_entry_date(); ?></div>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</div>
					<div class="scroll-indicator-wrapper">
						<a href="#" id="scroll-indicator" class="scroll-indicator"><span class="screen-reader-text"><?php _e( 'Scroll down to see more content', 'resonar' );?></span></a>
					</div>
				</header>
			</div>
		</div>
	<?php else : ?>
		<header class="entry-header">
			<div class="entry-header-inner">
				<div class="entry-date"><?php resonar_entry_date(); ?></div>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</header>
	<?php endif; ?>

	<div class="entry-content-footer">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'resonar' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'resonar' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php get_template_part( 'author-bio' ); ?>
			<?php resonar_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'resonar' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
*/ ?>