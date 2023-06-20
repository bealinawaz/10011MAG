<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Resonar
 * @since Resonar 1.0
 */
?>

<?php $bb_featured = get_post_meta(get_the_ID(), "bb_featured", true); $author = get_the_author(); $categories = get_the_terms( get_the_ID(), 'category' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class("not-featured"); ?>>

    <header class="entry-header">
        <h2 class="entry-title"><a href="<?php echo get_the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <h3 class="entry-subtitle"><?php echo get_post_meta(get_the_ID(), "bb_sub_title", true); ?></h3>
        <div class="entry-metadata">
        <div class="entry-author"><span class="screen-reader-text">Posted by </span><a href="<?php echo get_the_author_link(); ?>" title="Posts by <?php echo $author; ?>" class="author url fn" rel="author"><?php echo $author; ?></a></div>
        <div class="entry-date"><span class="posted-on">
            <span class="screen-reader-text">Posted on </span><time class="entry-date published" datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
        </span></div>
        </div>
        <div class="entry-category">
            <?php $count = 1; $limit = count($categories); foreach( $categories as $category ) { ?>
                <a class="entry-primary-category" href="<?php echo get_the_permalink($category->term_id); ?>"><?php echo $category->name; ?></a> <?php if($count != $limit) { echo '—'; } ?>
            <?php $count++; } ?>
        </div>
    </header>
    <a class="wp-post-image" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>" aria-hidden="true"><?php the_post_thumbnail("full"); ?></a>
    <div class="entry-content"><?php echo wp_trim_words( get_the_content(), 60, '...' ); ?></div><!-- .entry-content -->

</article>

<?php /*
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) ); ?>
		</a>
	<?php endif; ?>

	<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-date">
			<?php resonar_entry_date(); ?>
		</div><!-- .entry-date -->
	<?php endif; ?>

	<?php the_title( sprintf( '<header class="entry-header"><h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2></header>' ); ?>

	<div class="entry-summary">
	    <?php
	        if ( strpos( $post->post_content, '<!--more' ) ) {
	            the_content();
				# translators: %s: Name of current post.
				#the_content( sprintf( wp_kses( __( 'Continue reading %s', 'resonar' ), array( 'span' => array( 'class' => array() ) ) ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ) );
	        } else {
	            the_excerpt();
	        }
	    ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->
*/ ?>