<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */

if ( ! function_exists( 'snowfall_featured_image_slider') ):
/**
 * display slider
 */
function snowfall_featured_image_slider() { ?>

   <div id="home" class="slider-wrapper">

      <div class="bxslider">
         <?php
         $page_array = array();
         for ( $i=1; $i<=4; $i++ ) {
            $page_id = get_theme_mod( 'snowfall_slide'.$i );
            if ( !empty ($page_id ) )
               array_push( $page_array, $page_id );
         }

         $get_featured_posts = new WP_Query( array(
            'posts_per_page'        => -1,
            'post_type'             =>  array( 'page' ),
            'post__in'              => $page_array,
            'orderby'               => 'date'
         ) );

         while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
            $snowfall_slider_title = get_the_title();
            $snowfall_slider_description = wptexturize( do_shortcode( get_the_content() ) );
            $snowfall_slider_image = get_the_post_thumbnail();

            if( !empty( $snowfall_slider_image ) ): ?>
            <div class="slides">

               <div class="parallax-overlay"> </div>

               <figure>
                  <?php echo $snowfall_slider_image; ?>
               </figure>

               <?php if( !empty( $snowfall_slider_title ) || !empty( $snowfall_slider_description ) ) { ?>
                  <div class="tg-container">

                     <?php if( !empty( $snowfall_slider_title ) ) { ?>
                        <h3 class="caption-title">
                           <span><?php echo $snowfall_slider_title; ?></span>
                        </h3>
                     <?php  }

                     if( !empty( $snowfall_slider_description ) ) { ?>
                        <div class="caption-sub">
                           <?php echo $snowfall_slider_description; ?>
                        </div>

                      
                     <?php  } ?>
                  </div>
               <?php  } ?>
            </div>
            <?php  endif;
         endwhile;
         // Reset Post Data
         wp_reset_query(); ?>
      </div><!-- bxslider -->
   </div>
<?php }
endif;
