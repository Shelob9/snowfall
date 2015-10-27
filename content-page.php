<?php
/**
 * The template used for displaying page content.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <?php do_action( 'snowfall_before_post_content' ); ?>

   <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

   <div class="entry-content">
      <?php
         the_content();
         wp_link_pages( array(
            'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'snowfall' ),
            'after'             => '</div>',
            'link_before'       => '<span>',
            'link_after'        => '</span>'
         ) );
      ?>
   </div>

   <?php do_action( 'snowfall_after_post_content' ); ?>
</article>
