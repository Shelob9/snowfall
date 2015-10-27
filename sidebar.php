<?php
/**
 * The Right sidebar widget area.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */
?>

<div id="secondary">
	<?php do_action( 'snowfall_before_sidebar' ); ?>

		<?php if ( ! dynamic_sidebar( 'snowfall_right_sidebar' ) ) :

         the_widget( 'WP_Widget_Text',
            array(
               'title'  => __( 'Example Widget', 'snowfall' ),
               'text'   => sprintf( __( 'This is an example widget to show how the Right Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets is added than this will be replaced by those widgets.', 'snowfall' ), current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
               'filter' => true,
            ),
            array(
               'before_widget' => '<aside class="widget widget_text clearfix">',
               'after_widget'  => '</aside>',
               'before_title'  => '<h3 class="widget-title"><span>',
               'after_title'   => '</span></h3>'
            )
         );
      endif; ?>

	<?php do_action( 'snowfall_after_sidebar' ); ?>
</div>
