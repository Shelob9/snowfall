<?php
/**
 * Front Page Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */
?>

<?php get_header(); ?>

	<div id="content" class="site-content">
		<?php
	   if( is_active_sidebar( 'snowfall_front_page_section' ) ) {
	   	if ( !dynamic_sidebar( 'snowfall_front_page_section' ) ):
	   	endif;
	   }

	   $snowfall_layout = snowfall_layout_class();

	   if( get_theme_mod( 'snowfall_hide_blog_front' , 0 ) != 1 ): ?>
		   <main id="main" class="clearfix <?php echo $snowfall_layout; ?>">
				<div class="tg-container">
					<div id="primary" class="content-area">

		            <?php if ( have_posts() ):

		               while ( have_posts() ) : the_post();

		                  if ( is_front_page() && is_home() ) {
		                  	get_template_part( 'content', '' );
		                  } elseif ( is_front_page() ) {
		                  	get_template_part( 'content', 'page' );
		                  }
		               endwhile;

		               get_template_part( 'navigation', 'none' );
		            else:
		               get_template_part( 'no-results', 'none' );
		            endif; ?>
			      </div>

			      <?php snowfall_sidebar_select(); ?>
			   </div>
			</main>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>
