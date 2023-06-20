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

<article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
	<?php the_post_thumbnail("large-square-thumb"); ?>
    <div class="product-grid-item-overlay">
        <p class="product-brand-name product-brand-link"><a href="<?php echo get_post_meta(get_the_ID(), "product-brand-link", true); ?>" target="_blank"><?php echo get_post_meta(get_the_ID(), "product-brand-name", true); ?></a></p>
        <h2 class="entry-title product-title"><?php the_title(); ?></h2>
        <p class="product-price">$65</p>
        <a class="product-expand" href="https://coolhunting.com/buy/maison-for-recovery/"><span class="screen-reader-text">Expand product description</span></a>
    </div>
    <div class="product-details">
		<?php echo wpautop(get_the_excerpt()); ?>
        <div class="entry-metadata">
            <p>Added: <span class="posted-on">
                <span class="screen-reader-text">Posted on </span>
                <time class="entry-date published" datetime="2018-12-18T14:18:59+00:00"><?php echo get_the_date(); ?></time>
                <time class="updated" datetime="2018-12-17T20:20:37+00:00"><?php echo get_the_date(); ?></time>
            </span></p>
        </div>
        <p class="product-buy-button"><a href="<?php echo get_post_meta(get_the_ID(), "product-buy-link", true); ?>" target="_blank">Buy</a></p>
    </div>
</article>