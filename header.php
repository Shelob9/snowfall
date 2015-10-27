<?php
/**
 * Theme Header Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
/**
 * This hook is important for wordpress plugins and other many things
 */
wp_head();
?>
</head>

<body <?php body_class(); ?>>
<?php	do_action( 'snowfall_before' ); ?>
<div id="page" class="hfeed site">
	<?php do_action( 'snowfall_before_header' ); ?>
	<header id="masthead" class="site-header clearfix" role="banner">
		<?php
			$snowfall_header_class = '';
			if( get_theme_mod( 'snowfall_sticky_on_off', 0 ) == 1 ) {
				$snowfall_header_class .= 'non-stick';
			}
			else {
				$snowfall_header_class .= 'stick';
			}
			if( get_theme_mod( 'snowfall_slide_on_off', 0 ) == 1 && is_front_page() && get_theme_mod( 'snowfall_trans_off', 0 ) != 1 ) {
				$snowfall_header_class .= ' transparent';
			}
			else {
				$snowfall_header_class .= ' non-transparent';
			}
			if(  get_theme_mod( 'snowfall_header_logo_placement', 'header_text_only' ) == 'show_both' ) {
				$snowfall_header_class .= ' show-both';
			}
		?>
		<div class="header-wrapper clearfix <?php echo $snowfall_header_class; ?>">
			<div class="tg-container">

				<?php if( ( get_theme_mod( 'snowfall_header_logo_placement', 'header_text_only' ) == 'show_both' || get_theme_mod( 'snowfall_header_logo_placement', 'header_text_only' ) == 'header_logo_only' ) && get_theme_mod( 'snowfall_logo', '' ) != '') {	?>

					<div class="logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'snowfall_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
					</div> <!-- logo-end -->
				<?php	}

				if(get_theme_mod( 'snowfall_header_logo_placement', 'header_text_only' ) == 'show_both' || get_theme_mod( 'snowfall_header_logo_placement', 'header_text_only' ) == 'header_text_only' ) { ?>

					<div id="header-text">
						<h1 id="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						</h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2><!-- #site-description -->
					</div><!-- #header-text -->
				<?php } ?>

				<div class="menu-search-wrapper">

					<div class="home-search">

						<div class="search-icon">
							<i class="fa fa-search"> </i>
						</div>

						<div class="search-box">
							<div class="close"> &times; </div>
							<?php get_search_form(); ?>
						</div>
					</div> <!-- home-search-end -->

					<nav id="site-navigation" class="main-navigation" role="navigation">
						<h4 class="menu-toggle hide"></h4>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-primary-container' ) ); ?>
					</nav> <!-- nav-end -->
				</div> <!-- Menu-search-wrapper end -->
			</div><!-- tg-container -->
		</div><!-- header-wrapepr end -->

		<?php if( get_theme_mod( 'snowfall_slide_on_off' ) == 1 && is_front_page() ) {				snowfall_featured_image_slider();

      } ?>
	</header>
   <?php do_action( 'snowfall_after_header' ); ?>
   <?php do_action( 'snowfall_before_main' ); ?>
