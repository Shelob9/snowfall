<?php
/**
 * Theme Index Section for our theme.
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

					<?php if ( have_posts() ) :

						while ( have_posts() ) : the_post();

							get_template_part( 'content', '' );

						endwhile;

						get_template_part( 'navigation', 'none' );

					else :

						get_template_part( 'no-results', 'none' );

					endif; ?>
				</div><!-- #primary -->
				<?php snowfall_sidebar_select(); ?>
			</div>
		</main>
	</div>

	<?php do_action( 'snowfall_after_body_content' ); ?>

<?php get_footer(); ?>
