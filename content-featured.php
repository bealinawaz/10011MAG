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

<article id="post-<?php the_ID(); ?>" <?php post_class("featured"); ?>>

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
                        <?php $count = 1; $limit = count($categories); foreach( $categories as $category ) { ?>
                            <a class="entry-primary-category" href="<?php echo get_the_permalink($category->term_id); ?>"><?php echo $category->name; ?></a> <?php if($count != $limit) { echo '—'; } ?>
                        <?php $count++; } ?>
                    </div>
                </header>
                <div class="scroll-indicator-wrapper"><a href="#" id="scroll-indicator" class="scroll-indicator"><span class="screen-reader-text">Scroll down to see more content</span></a></div>
            </div>
        </div>
        <a class="mobile-image-link" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>" aria-hidden="true"></a>
    </div>

</article>