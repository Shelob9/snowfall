<?php
/**
 * The template for displaying Archive pages
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
				<div id="primary" class="content-area">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
								snowfall_archive_title( '<h1 class="page-title">', '</h1>' );
								snowfall_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						</header><!-- .page-header -->

						<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );

						// End the loop.
						endwhile;

						get_template_part( 'navigation', 'archive' );

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'no-results', 'archive' );

					endif;
					?>
				</div><!-- #primary -->
				<?php snowfall_sidebar_select(); ?>
			</div><!-- .tg-container -->
		</main>
	</div>

	<?php //snowfall_sidebar_select(); ?>

	<?php do_action( 'snowfall_after_body_content' ); ?>

<?php get_footer(); ?>
