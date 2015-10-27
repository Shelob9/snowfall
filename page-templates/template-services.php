<?php
/**
 * Template Name: Service Template
 *
 * Displays the Service Template of the theme.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */
?>

<?php get_header(); ?>

	<?php do_action( 'snowfall_before_body_content' );

	$snowfall_layout = snowfall_layout_class(); ?>

	<div id="content" class="site-content">
	   <main id="main" class="clearfix <?php echo $snowfall_layout; ?>">
	      <div class="tg-container">

				<div id="primary">
					<div id="content-2">
						<?php while ( have_posts() ) : the_post();

							get_template_part( 'content', 'page' );

							do_action( 'snowfall_before_comments_template' );
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() )
								comments_template();
			      		do_action ( 'snowfall_after_comments_template' );

						endwhile; ?>
					</div><!-- #content-2 -->
				</div><!-- #primary -->

				<?php  snowfall_sidebar_select(); ?>
			</div>
		</main>
	</div>

	<?php do_action( 'snowfall_after_body_content' ); ?>

<?php get_footer(); ?>
