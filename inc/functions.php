<?php
/**
 * snowfall functions and definitions
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */

add_action( 'wp_enqueue_scripts', 'snowfall_scripts' );
/**
 * Enqueue scripts and styles.
 */
function snowfall_scripts() {
   // Load Google fonts
   wp_enqueue_style( 'snowfall-google-fonts', '//fonts.googleapis.com/css?family=Crimson+Text:700|Roboto:400,700,900,300' );

   // Load fontawesome
   wp_enqueue_style( 'snowfall-fontawesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css', array(), '4.3.0' );

   /**
   * Loads our main stylesheet.
   */
   wp_enqueue_style( 'snowfall-style', get_stylesheet_uri() );

   // Register magnific popup script
   wp_register_script( 'snowfall-featured-image-popup', snowfall_JS_URL. '/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0.0', true );

   wp_enqueue_style( 'snowfall-featured-image-popup-css', snowfall_JS_URL.'/magnific-popup/magnific-popup.css', array(), '1.0.0' );

   if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
   }

   // Register bxslider Script
   wp_register_script( 'snowfall-bxslider', snowfall_JS_URL . '/jquery.bxslider/jquery.bxslider.min.js', array( 'jquery' ), false, true );

   $slider = 0;
   for( $i=1; $i<=4; $i++ ) {
      $page_id = get_theme_mod( 'snowfall_slide'.$i );
      if ( !empty ( $page_id ) )  $slider++;
   }

   if( ( $slider > 1 ) && get_theme_mod( 'snowfall_slide_on_off', 0 ) == 1 && is_front_page() ) {
      wp_enqueue_script( 'snowfall-slider', snowfall_JS_URL . '/slider-setting.js', array( 'snowfall-bxslider' ), false, true );
   }
   // For smooth scrolling
   wp_enqueue_script( 'snowfall-onepagenav', snowfall_JS_URL . '/jquery.nav.js', array( 'jquery' ), '3.0.0', true );

   // Parallax effect
   wp_register_script( 'snowfall-parallax', snowfall_JS_URL . '/jquery.parallax-1.1.3.js', array( 'jquery' ), '1.1.3', true );

   if( is_front_page() ) {
      wp_enqueue_script( 'snowfall-background-parallax', snowfall_JS_URL . '/parallax-setting.js', array( 'snowfall-parallax' ), false, true );
   }

   // Magific popup setting
   wp_enqueue_script( 'snowfall-featured-image-popup-setting', snowfall_JS_URL. '/magnific-popup/image-popup-setting.js', array( 'snowfall-featured-image-popup' ), '1.0.0', true );

   $snowfall_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
   if(preg_match('/(?i)msie [1-8]/',$snowfall_user_agent)) {
      wp_enqueue_script( 'html5', snowfall_JS_URL . '/html5shiv.min.js', true );
   }

   // Register Custom Script
   wp_enqueue_script( 'snowfall-custom', snowfall_JS_URL . '/snowfall.js', array( 'jquery' ), false, true );
}

/**************************************************************************************/

/**
 * Add admin scripts
 */

add_action('admin_enqueue_scripts', 'snowfall_image_uploader');

function snowfall_image_uploader( $hook ) {
   global $post_type;
   if( $hook == 'widgets.php' || $hook == 'customize.php' ) {
	   //For image uploader
	   wp_enqueue_media();
	   wp_enqueue_script( 'snowfall-script', snowfall_JS_URL . '/image-uploader.js', false, '1.0', true );

	   //For Color Picker
	   wp_enqueue_style( 'wp-color-picker' );
	   wp_enqueue_script( 'snowfall-color-picker', snowfall_JS_URL . '/color-picker.js', array( 'wp-color-picker' ), false);
	}
   if( $post_type == 'page' ) {
      wp_enqueue_script( 'snowfall-meta-toggle', snowfall_JS_URL . '/metabox-toggle.js', false, '1.0', true );
   }
}

/****************************************************************************************/

add_filter( 'excerpt_length', 'snowfall_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function snowfall_excerpt_length( $length ) {
   return 25;
}

add_filter( 'excerpt_more', 'snowfall_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function snowfall_continue_reading() {
   return '';
}

/**************************************************************************************/

if ( ! function_exists( 'snowfall_excerpt' ) ) :
/**
 * Function to show the footer info, copyright information
 */
function snowfall_excerpt( $limit ) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
endif;

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function snowfall_gallery_atts( $out, $pairs, $atts ) {
   $atts = shortcode_atts( array(
   'size' => 'medium',
   ), $atts );

   $out['size'] = $atts['size'];

   return $out;
}
add_filter( 'shortcode_atts_gallery', 'snowfall_gallery_atts', 10, 3 );

/****************************************************************************************/

if ( ! function_exists( 'snowfall_entry_meta' ) ) :
/**
 * Shows meta information of post.
 */
function snowfall_entry_meta() {
   if ( 'post' == get_post_type() ) :
      echo '<div class="entry-meta">';

      $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
      if (  ( 'U' ) !== get_the_modified_time( 'U' ) ) {
         $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
      }
      $time_string = sprintf( $time_string,
         esc_attr( get_the_date( 'c' ) ),
         esc_html( get_the_date() ),
         esc_attr( get_the_modified_date( 'c' ) ),
         esc_html( get_the_modified_date() )
      );
      printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"> %3$s</a></span>', 'snowfall' ),
         esc_url( get_permalink() ),
         esc_attr( get_the_time() ),
         $time_string
      ); ?>

      <span class="byline author vcard"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>

      <?php
      if ( ! post_password_required() && comments_open() ) { ?>
         <span class="comments-link"><?php comments_popup_link( __( '0 Comment', 'snowfall' ), __( '1 Comment', 'snowfall' ), __( ' % Comments', 'snowfall' ) ); ?></span>
      <?php }

      if( has_category() ) { ?>
         <span class="cat-links"><?php the_category(', '); ?></span>
       <?php }

      $tags_list = get_the_tag_list( '<span class="tag-links">', ', ', '</span>' );
      if ( $tags_list ) echo $tags_list;

      edit_post_link( __( 'Edit', 'snowfall' ), '<span class="edit-link">', '</span>' );

      echo '</div>';
   endif;
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'snowfall_layout_class' ) ) :
/**
 * Return the layout as selected by user
 */
function snowfall_layout_class() {
   global $post;
   $classes = '';

   if( $post ) { $layout_meta = get_post_meta( $post->ID, 'snowfall_page_layout', true ); }

   if( is_home() ) {
      $queried_id = get_option( 'page_for_posts' );
      $layout_meta = get_post_meta( $queried_id, 'snowfall_page_layout', true );
   }
   if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }

   $snowfall_default_layout = get_theme_mod( 'snowfall_default_layout', 'right_sidebar' );
   $snowfall_default_page_layout = get_theme_mod( 'snowfall_default_page_layout', 'right_sidebar' );
   $snowfall_default_post_layout = get_theme_mod( 'snowfall_default_single_posts_layout', 'right_sidebar' );

   if( $layout_meta == 'default_layout' ) {
      if( is_page() ) {
         if( $snowfall_default_page_layout == 'right_sidebar' ) { $classes = 'right_sidebar'; }
         elseif( $snowfall_default_page_layout == 'left_sidebar' ) { $classes = 'left-sidebar'; }
         elseif( $snowfall_default_page_layout == 'no_sidebar_full_width' ) { $classes = 'no-sidebar-full-width'; }
         elseif( $snowfall_default_page_layout == 'no_sidebar_content_centered' ) { $classes = 'no-sidebar'; }
      }
      elseif( is_single() ) {
         if( $snowfall_default_post_layout == 'right_sidebar' ) { $classes = 'right_sidebar'; }
         elseif( $snowfall_default_post_layout == 'left_sidebar' ) { $classes = 'left-sidebar'; }
         elseif( $snowfall_default_post_layout == 'no_sidebar_full_width' ) { $classes = 'no-sidebar-full-width'; }
         elseif( $snowfall_default_post_layout == 'no_sidebar_content_centered' ) { $classes = 'no-sidebar'; }
      }
      elseif( $snowfall_default_layout == 'right_sidebar' ) { $classes = 'right_sidebar'; }
      elseif( $snowfall_default_layout == 'left_sidebar' ) { $classes = 'left-sidebar'; }
      elseif( $snowfall_default_layout == 'no_sidebar_full_width' ) { $classes = 'no-sidebar-full-width'; }
      elseif( $snowfall_default_layout == 'no_sidebar_content_centered' ) { $classes = 'no-sidebar'; }
   }
   elseif( $layout_meta == 'right_sidebar' ) { $classes = 'right_sidebar'; }
   elseif( $layout_meta == 'left_sidebar' ) { $classes = 'left-sidebar'; }
   elseif( $layout_meta == 'no_sidebar_full_width' ) { $classes = 'no-sidebar-full-width'; }
   elseif( $layout_meta == 'no_sidebar_content_centered' ) { $classes = 'no-sidebar'; }

   return $classes;
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'snowfall_sidebar_select' ) ) :
/**
 * Function to select the sidebar
 */
function snowfall_sidebar_select() {
   global $post;

   if( $post ) { $layout_meta = get_post_meta( $post->ID, 'snowfall_page_layout', true ); }

   if( is_home() ) {
      $queried_id = get_option( 'page_for_posts' );
      $layout_meta = get_post_meta( $queried_id, 'snowfall_page_layout', true );
   }

   if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }

   $snowfall_default_layout = get_theme_mod( 'snowfall_default_layout', 'right_sidebar' );
   $snowfall_default_page_layout = get_theme_mod( 'snowfall_default_page_layout', 'right_sidebar' );
   $snowfall_default_post_layout = get_theme_mod( 'snowfall_default_single_posts_layout', 'right_sidebar' );

   if( $layout_meta == 'default_layout' ) {
      if( is_page() ) {
         if( $snowfall_default_page_layout == 'right_sidebar' ) { get_sidebar(); }
         elseif ( $snowfall_default_page_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
      }
      elseif( is_single() ) {
         if( $snowfall_default_post_layout == 'right_sidebar' ) { get_sidebar(); }
         elseif ( $snowfall_default_post_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
      }
      elseif( $snowfall_default_layout == 'right_sidebar' ) { get_sidebar(); }
      elseif ( $snowfall_default_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
   }
   elseif( $layout_meta == 'right_sidebar' ) { get_sidebar(); }
   elseif( $layout_meta == 'left_sidebar' ) { get_sidebar( 'left' ); }
}
endif;

/**************************************************************************************/

if ( ! function_exists( 'snowfall_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function snowfall_comment( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment;
   switch ( $comment->comment_type ) :
      case 'pingback' :
      case 'trackback' :
      // Display trackbacks differently than normal comments.
   ?>
   <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
      <p><?php _e( 'Pingback:', 'snowfall' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'snowfall' ), '<span class="edit-link">', '</span>' ); ?></p>
   <?php
         break;
      default :
      // Proceed with normal comments.
      global $post;
   ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
      <article id="comment-<?php comment_ID(); ?>" class="comment">
         <header class="comment-meta comment-author vcard">
            <?php
               echo get_avatar( $comment, 74 );
               printf( '<div class="comment-author-link"><i class="fa fa-user"></i>%1$s%2$s</div>',
                  get_comment_author_link(),
                  // If current post author is also comment author, make it known visually.
                  ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'snowfall' ) . '</span>' : ''
               );
               printf( '<div class="comment-date-time"><i class="fa fa-calendar-o"></i>%1$s</div>',
                  sprintf( __( '%1$s at %2$s', 'snowfall' ), get_comment_date(), get_comment_time() )
               );
               printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link"></i>Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
               edit_comment_link();
            ?>
         </header><!-- .comment-meta -->

         <?php if ( '0' == $comment->comment_approved ) : ?>
            <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'snowfall' ); ?></p>
         <?php endif; ?>

         <section class="comment-content comment">
            <?php comment_text(); ?>
            <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'snowfall' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
         </section><!-- .comment-content -->

      </article><!-- #comment-## -->
   <?php
      break;
   endswitch; // end comment_type check
}
endif;

/**************************************************************************************/

add_action( 'snowfall_footer_copyright', 'snowfall_footer_copyright', 10 );
/**
 * Function to show the footer info, copyright information
 */
if ( ! function_exists( 'snowfall_footer_copyright' ) ) :
function snowfall_footer_copyright() {
   $site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" >' . get_bloginfo( 'name', 'display' ) . '</a>';

   $tg_link =  '<a href="'. 'http://themegrill.com/themes/snowfall' .'" target="_blank" title="'.esc_attr__( 'ThemeGrill', 'snowfall' ).'" rel="designer">'.__( 'ThemeGrill', 'snowfall') .'</a>';

   $default_footer_value = '<span class="copyright-text">' . sprintf( __( 'Copyright &copy; %1$s %2$s.', 'snowfall' ), date( 'Y' ), $site_link ).' '.sprintf( __( 'Design By: %1$s', 'snowfall' ), $tg_link ) . '</span>';

   $snowfall_footer_copyright = '<div class="copyright">'.$default_footer_value.'</div>';
   echo $snowfall_footer_copyright;
}
endif;

/**************************************************************************************/

add_action( 'wp_head', 'snowfall_custom_css' );
/**
 * Hooks the Custom Internal CSS to head section
 */
function snowfall_custom_css() {
   $primary_color = get_theme_mod( 'snowfall_primary_color', '#32c4d1' );;
   $snowfall_internal_css = '';
   if( $primary_color != '#32c4d1' ) {
      $snowfall_internal_css = ' .about-btn a:hover,.bttn:hover,.icon-img-wrap:hover,.navigation .nav-links a:hover,.service_icon_class .image-wrap:hover i,.slider-readmore:before,.subscribe-form .subscribe-submit .subscribe-btn,button,input[type=button]:hover,input[type=reset]:hover,input[type=submit]:hover{background:'.$primary_color.'}a{color:'.$primary_color.'}#site-navigation .menu li.current-one-page-item a,#site-navigation .menu li:hover a,.about-title a:hover,.caption-title a:hover,.header-wrapper.no-slider #site-navigation .menu li.current-one-page-item a,.header-wrapper.no-slider #site-navigation .menu li:hover a,.header-wrapper.no-slider .search-icon:hover,.header-wrapper.stick #site-navigation .menu li.current-one-page-item a,.header-wrapper.stick #site-navigation .menu li:hover a,.header-wrapper.stick .search-icon:hover,.scroll-down,.search-icon:hover,.service-title a:hover{color:'.$primary_color.'}.comments-area .comment-author-link span{background-color:'.$primary_color.'}.slider-readmore:hover{border:1px solid '.$primary_color.'}.icon-wrap:hover,.image-wrap:hover,.port-link a:hover{border-color:'.$primary_color.'}.main-title:after,.main-title:before{border-top:2px solid '.$primary_color.'}.blog-view,.port-link a:hover{background:'.$primary_color.'}.port-title-wrapper .port-desc{color:'.$primary_color.'}#top-footer a:hover,.blog-title a:hover,.entry-title a:hover,.footer-nav li a:hover,.footer-social a:hover,.widget ul li a:hover,.widget ul li:hover:before{color:'.$primary_color.'}.contact-form-wrapper input[type=submit],.default-wp-page a:hover,.team-desc-wrapper{background:'.$primary_color.'}.scrollup{background-color:'.$primary_color.'}#stick-navigation li.current-one-page-item a,#stick-navigation li:hover a,.blog-hover-link a:hover,.entry-btn .btn:hover{background:'.$primary_color.'}#secondary .widget-title:after,#top-footer .widget-title:after{background:'.$primary_color.'}.widget-tags a:hover{background:'.$primary_color.';border:1px solid '.$primary_color.'}.num-404{color:'.$primary_color.'}.error{background:'.$primary_color.'}';
   }

   if( !empty( $snowfall_internal_css ) ) {
      ?>
      <style type="text/css"><?php echo $snowfall_internal_css; ?></style>
      <?php
   }

   $snowfall_custom_css = get_theme_mod( 'snowfall_custom_css', '' );
   if( !empty( $snowfall_custom_css ) ) {
      echo '<!-- '.get_bloginfo('name').' Custom Styles -->';
      ?><style type="text/css"><?php echo esc_html( $snowfall_custom_css ); ?></style><?php
   }
}

/**************************************************************************************/

if ( ! function_exists( 'snowfall_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function snowfall_archive_title( $before = '', $after = '' ) {
   if ( is_category() ) {
      $title = sprintf( esc_html__( 'Category: %s', 'snowfall' ), single_cat_title( '', false ) );
   } elseif ( is_tag() ) {
      $title = sprintf( esc_html__( 'Tag: %s', 'snowfall' ), single_tag_title( '', false ) );
   } elseif ( is_author() ) {
      $title = sprintf( esc_html__( 'Author: %s', 'snowfall' ), '<span class="vcard">' . get_the_author() . '</span>' );
   } elseif ( is_year() ) {
      $title = sprintf( esc_html__( 'Year: %s', 'snowfall' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'snowfall' ) ) );
   } elseif ( is_month() ) {
      $title = sprintf( esc_html__( 'Month: %s', 'snowfall' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'snowfall' ) ) );
   } elseif ( is_day() ) {
      $title = sprintf( esc_html__( 'Day: %s', 'snowfall' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'snowfall' ) ) );
   } elseif ( is_tax( 'post_format' ) ) {
      if ( is_tax( 'post_format', 'post-format-aside' ) ) {
         $title = esc_html_x( 'Asides', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
         $title = esc_html_x( 'Galleries', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
         $title = esc_html_x( 'Images', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
         $title = esc_html_x( 'Videos', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
         $title = esc_html_x( 'Quotes', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
         $title = esc_html_x( 'Links', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
         $title = esc_html_x( 'Statuses', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
         $title = esc_html_x( 'Audio', 'post format archive title', 'snowfall' );
      } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
         $title = esc_html_x( 'Chats', 'post format archive title', 'snowfall' );
      }
   } elseif ( is_post_type_archive() ) {
      $title = sprintf( esc_html__( 'Archives: %s', 'snowfall' ), post_type_archive_title( '', false ) );
   } elseif ( is_tax() ) {
      $tax = get_taxonomy( get_queried_object()->taxonomy );
      /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
      $title = sprintf( esc_html__( '%1$s: %2$s', 'snowfall' ), $tax->labels->singular_name, single_term_title( '', false ) );
   } else {
      $title = esc_html__( 'Archives', 'snowfall' );
   }

   /**
    * Filter the archive title.
    *
    * @param string $title Archive title to be displayed.
    */
   $title = apply_filters( 'get_the_archive_title', $title );

   if ( ! empty( $title ) ) {
      echo $before . $title . $after;  // WPCS: XSS OK.
   }
}
endif;

if ( ! function_exists( 'snowfall_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function snowfall_archive_description( $before = '', $after = '' ) {
   $description = apply_filters( 'get_the_archive_description', term_description() );

   if ( ! empty( $description ) ) {
      /**
       * Filter the archive description.
       *
       * @see term_description()
       *
       * @param string $description Archive description to be displayed.
       */
      echo $before . $description . $after;  // WPCS: XSS OK.
   }
}
endif;
