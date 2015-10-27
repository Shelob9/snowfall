<?php
/**
 * snowfall Theme Customizer
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */
function snowfall_customize_register($wp_customize) {

	// Start of the Header Options
   $wp_customize->add_panel('snowfall_header_options', array(
      'capabitity' => 'edit_theme_options',
      'description' => __('Contain all the Header related options', 'snowfall'),
      'priority' => 300,
      'title' => __('snowfall Header Options', 'snowfall')
   ));

   // Sticky Option
	$wp_customize->add_section('snowfall_sticky_section', array(
		'priority' => 310,
      'title' => __('Header Sticky/non-sticky', 'snowfall'),
      'description' => __('Header is sticky by default.', 'snowfall'),
      'panel' => 'snowfall_header_options'
   ));

	$wp_customize->add_setting('snowfall_sticky_on_off',	array(
		'default' => 0,
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_sanitize_checkbox'
	));
	$wp_customize->add_control('snowfall_sticky_on_off',	array(
		'type' => 'checkbox',
		'label' => __('Check to make header non-sticky', 'snowfall' ),
		'section' => 'snowfall_sticky_section'
	));

	// Header non-transparent Option
	$wp_customize->add_section('snowfall_transparent_section', array(
		'priority' => 315,
      'title' => __('Header Transparency', 'snowfall'),
      'description' => __('By default Header is transparent when slider is used.', 'snowfall'),
      'panel' => 'snowfall_header_options'
   ));

	$wp_customize->add_setting('snowfall_trans_off',	array(
		'default' => 0,
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_sanitize_checkbox'
	));
	$wp_customize->add_control('snowfall_trans_off',	array(
		'type' => 'checkbox',
		'label' => __('Make header non transparent.', 'snowfall' ),
		'section' => 'snowfall_transparent_section'
	));

   // Logo Option
	$wp_customize->add_section('snowfall_header_title_logo', array(
		'title'     => __( 'Header Title/Tagline and Logo', 'snowfall' ),
		'priority'  => 320,
		'description' => __( '<strong>Note:</strong> The recommended height for header logo image is 68px.', 'snowfall' ),
  		'panel' => 'snowfall_header_options'
	));

	$wp_customize->add_setting('snowfall_logo', array(
		'default' => '',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'snowfall_sanitize_url',
      'sanitize_js_callback' => 'snowfall_sanitize_js_url'
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control($wp_customize, 'snowfall_logo', array(
			'label' 		=> __( 'Header Logo Image Upload', 'snowfall' ),
			'section' 	=> 'snowfall_header_title_logo',
			'settings' 	=> 'snowfall_logo'
		))
	);

	$wp_customize->add_setting('snowfall_header_logo_placement', array(
      'default' => 'header_text_only',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'snowfall_radio_sanitize'
   ));
   $wp_customize->add_control('snowfall_header_logo_placement', array(
      'type' => 'radio',
      'label' => __('Choose the required option', 'snowfall'),
      'section' => 'snowfall_header_title_logo',
      'choices' => array(
         'header_logo_only' => __('Header Logo Only', 'snowfall'),
         'header_text_only' => __('Header Text Only', 'snowfall'),
         'show_both' => __('Show Both', 'snowfall'),
         'disable' => __('Disable', 'snowfall')
      )
   ));
	// End of the Header Options

 /**************************************************************************************/

	// Start of the Slider Options
   $wp_customize->add_panel('snowfall_slider_options', array(
   	'priority'  => 400,
      'capabitity' => 'edit_theme_options',
      'description' => __('Contain all the slider related options', 'snowfall'),
      'title' => __('snowfall Slider Options', 'snowfall')
   ));

   // Slider Section
	$wp_customize->add_section( 'snowfall_slider', array(
		'title'     => __( 'Slider Settings', 'snowfall' ),
		'priority'  => 410,
		'description' => '<strong>'.__( 'Note', 'snowfall').'</strong><br/>'.__( '1. To display the Slider first check Enable the slider below. Now create the page for each slider and enter title, text and featured image. Choose that pages in the dropdown options.', 'snowfall').'<br/>'.__( '2. The recommended size for the slider image is 1600 x 780 pixels. For better functioning of slider use equal size images for each slide.', 'snowfall' ).'<br/>'.__( '3. If page do not have featured Image than that page will not included in slider show.', 'snowfall' ),
      'panel' => 'snowfall_slider_options'
	));

	// Enable or Disable the Slider
	$wp_customize->add_setting('snowfall_slide_on_off', array(
		'default' => '',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'snowfall_sanitize_checkbox'
	));
	$wp_customize->add_control('snowfall_slide_on_off', array(
		'label' => __( 'Enable the slider', 'snowfall' ),
		'section' => 'snowfall_slider',
		'type'	=> 'checkbox',
		'priority' => 6
	));

   // Slider Page Select
   for( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting('snowfall_slide'.$i, array(
			'default' => '',
	      'capability' => 'edit_theme_options',
	      'sanitize_callback' => 'snowfall_sanitize_integer'
		));
		$wp_customize->add_control('snowfall_slide'.$i, array(
			'label' => __( 'Slider', 'snowfall' ).$i,
			'section' => 'snowfall_slider',
			'type'	=> 'dropdown-pages',
			'priority'  => $i*20+1
		));
	}
	// End of the Slider Options

 /**************************************************************************************/

	// Start of the Design Options
   $wp_customize->add_panel('snowfall_design_options', array(
   	'priority'  => 500,
      'capabitity' => 'edit_theme_options',
      'description' => __('Contain all the Design related options', 'snowfall'),
      'title' => __('snowfall Design Options', 'snowfall')
   ));

   class snowfall_Image_Radio_Control extends WP_Customize_Control {

 		public function render_content() {

			if ( empty( $this->choices ) )
				return;

			$name = '_customize-radio-' . $this->id;

			?>
			<style>
				#snowfall-img-container .snowfall-radio-img-img {
					border: 3px solid #DEDEDE;
					margin: 0 5px 5px 0;
					cursor: pointer;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
				}
				#snowfall-img-container .snowfall-radio-img-selected {
					border: 3px solid #AAA;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
				}
				input[type=checkbox]:before {
					content: '';
					margin: -3px 0 0 -4px;
				}
			</style>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="controls" id = 'snowfall-img-container'>
			<?php
				foreach ( $this->choices as $value => $label ) :
					$class = ($this->value() == $value)?'snowfall-radio-img-selected snowfall-radio-img-img':'snowfall-radio-img-img';
					?>
					<li style="display: inline;">
					<label>
						<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
					</label>
					</li>
					<?php
				endforeach;
			?>
			</ul>
			<script type="text/javascript">

				jQuery(document).ready(function($) {
					$('.controls#snowfall-img-container li img').click(function(){
						$('.controls#snowfall-img-container li').each(function(){
							$(this).find('img').removeClass ('snowfall-radio-img-selected') ;
						});
						$(this).addClass ('snowfall-radio-img-selected') ;
					});
				});

			</script>
			<?php
		}
	}

	// default layout setting
	$wp_customize->add_section('snowfall_default_layout_setting', array(
		'priority' => 520,
		'title' => __('Default layout', 'snowfall'),
		'panel'=> 'snowfall_design_options'
	));

	$wp_customize->add_setting('snowfall_default_layout', array(
		'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_radio_sanitize'
	));
	$wp_customize->add_control(
		new snowfall_Image_Radio_Control($wp_customize, 'snowfall_default_layout', array(
			'type' => 'radio',
			'label' => __('Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options', 'snowfall'),
			'section' => 'snowfall_default_layout_setting',
			'settings' => 'snowfall_default_layout',
			'choices' => array(
				'right_sidebar' => snowfall_ADMIN_IMAGES_URL . '/right-sidebar.png',
				'left_sidebar' => snowfall_ADMIN_IMAGES_URL . '/left-sidebar.png',
				'no_sidebar_full_width'	=> snowfall_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered'	=> snowfall_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
			)
		))
	);

	// default layout for pages
	$wp_customize->add_section('snowfall_default_page_layout_setting', array(
		'priority' => 521,
		'title' => __('Default layout for pages only', 'snowfall'),
		'panel'=> 'snowfall_design_options'
	));

	$wp_customize->add_setting('snowfall_default_page_layout', array(
		'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_radio_sanitize'
	));
	$wp_customize->add_control(
		new snowfall_Image_Radio_Control($wp_customize, 'snowfall_default_page_layout', array(
			'type' => 'radio',
			'label' => __('Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page', 'snowfall'),
			'section' => 'snowfall_default_page_layout_setting',
			'settings' => 'snowfall_default_page_layout',
			'choices' => array(
				'right_sidebar' => snowfall_ADMIN_IMAGES_URL . '/right-sidebar.png',
				'left_sidebar' => snowfall_ADMIN_IMAGES_URL . '/left-sidebar.png',
				'no_sidebar_full_width'	=> snowfall_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered'	=> snowfall_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
			)
		))
	);

	// default layout for single posts
	$wp_customize->add_section('snowfall_default_single_posts_layout_setting', array(
		'priority' => 522,
		'title' => __('Default layout for single posts only', 'snowfall'),
		'panel'=> 'snowfall_design_options'
	));

	$wp_customize->add_setting('snowfall_default_single_posts_layout', array(
		'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_radio_sanitize'
	));
	$wp_customize->add_control(
		new snowfall_Image_Radio_Control($wp_customize, 'snowfall_default_single_posts_layout', array(
			'type' => 'radio',
			'label' => __('Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post', 'snowfall'),
			'section' => 'snowfall_default_single_posts_layout_setting',
			'settings' => 'snowfall_default_single_posts_layout',
			'choices' => array(
				'right_sidebar' => snowfall_ADMIN_IMAGES_URL . '/right-sidebar.png',
				'left_sidebar' => snowfall_ADMIN_IMAGES_URL . '/left-sidebar.png',
				'no_sidebar_full_width'	=> snowfall_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered'	=> snowfall_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
			)
		))
	);

	// primary color options
   $wp_customize->add_section('snowfall_primary_color_setting', array(
      'panel' => 'snowfall_design_options',
      'priority' => 530,
      'title' => __('Primary color option', 'snowfall')
   ));

   $wp_customize->add_setting('snowfall_primary_color', array(
      'default' => '#32c4d1',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'snowfall_color_option_hex_sanitize',
      'sanitize_js_callback' => 'snowfall_color_escaping_option_sanitize'
   ));

   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'snowfall_primary_color', array(
      'label' => __('This will reflect in links, buttons and many others. Choose a color to match your site', 'snowfall'),
      'section' => 'snowfall_primary_color_setting',
      'settings' => 'snowfall_primary_color'
   )));

   // Footer Layout
	$wp_customize->add_section('snowfall_footer_layout_setting', array(
		'priority' => 540,
		'title' => __('Footer Layout Options', 'snowfall'),
		'panel'=> 'snowfall_design_options'
	));

	$wp_customize->add_setting('snowfall_footer_layout', array(
		'default' => 'footer-layout-one',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_radio_sanitize'
	));
	$wp_customize->add_control('snowfall_footer_layout', array(
		'type' => 'radio',
		'label' => __('Select the Footer Layout', 'snowfall'),
		'section' => 'snowfall_footer_layout_setting',
		'settings' => 'snowfall_footer_layout',
		'choices' => array(
			'footer-layout-one' => __('Choose Footer Layout One', 'snowfall'),
			'footer-layout-two' => __('Choose Footer Layout Two', 'snowfall')
		)
	));

   // Custom CSS setting
   class snowfall_Custom_CSS_Control extends WP_Customize_Control {

      public $type = 'custom_css';

      public function render_content() {
      ?>
         <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
         </label>
      <?php
      }
   }

   $wp_customize->add_section('snowfall_custom_css_setting', array(
      'priority' => 550,
      'title' => __('Custom CSS', 'snowfall'),
      'panel' => 'snowfall_design_options'
   ));

   $wp_customize->add_setting('snowfall_custom_css', array(
      'default' => '',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'sanitize_js_callback' => 'wp_filter_nohtml_kses'
   ));
   $wp_customize->add_control(
   	new snowfall_Custom_CSS_Control($wp_customize, 'snowfall_custom_css', array(
	      'label' => __('Write your custom css', 'snowfall'),
	      'section' => 'snowfall_custom_css_setting',
	      'settings' => 'snowfall_custom_css'
   	))
   );
   // End of the Design Options

 /**************************************************************************************/

 	// Start of the Additional Options
   $wp_customize->add_panel('snowfall_additional_options', array(
      'capabitity' => 'edit_theme_options',
      'description' => __('Contain additional options', 'snowfall'),
      'priority' => 600,
      'title' => __('snowfall Additional Options', 'snowfall')
   ));

   // FrontPage setting
	$wp_customize->add_section('snowfall_blog_on_front', array(
		'priority'  => 605,
      'title' => __('Hide Blog posts from the front page', 'snowfall'),
      'panel' => 'snowfall_additional_options'
   ));

	$wp_customize->add_setting('snowfall_hide_blog_front',	array(
		'default' => 0,
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_sanitize_checkbox'
	));
	$wp_customize->add_control('snowfall_hide_blog_front',	array(
		'type' => 'checkbox',
		'label' => __('Check to hide blog posts/static page on front page', 'snowfall' ),
		'section' => 'snowfall_blog_on_front'
	));

   // Excerpts or Full Posts setting
	$wp_customize->add_section('snowfall_content_setting', array(
		'priority' => 610,
		'title' => __('Excerpts or Full Posts option', 'snowfall'),
		'panel'=> 'snowfall_additional_options'
	));

	$wp_customize->add_setting('snowfall_content_show', array(
		'default' => 'show_full_post_content',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'snowfall_radio_sanitize'
	));
	$wp_customize->add_control('snowfall_content_show', array(
		'type' => 'radio',
		'label' => __('Toggle between displaying excerpts and full posts on your blog and archives.', 'snowfall'),
		'section' => 'snowfall_content_setting',
		'settings' => 'snowfall_content_show',
		'choices' => array(
			'show_full_post_content' => __('Show full post content', 'snowfall'),
			'show_excerpt' => __('Show excerpt', 'snowfall')
		)
	));
	// End of the Additional Options

 /**************************************************************************************/

	function snowfall_sanitize_checkbox($input) {
      if ( $input == 1 ) {
         return 1;
      } else {
         return '';
      }
   }
   function snowfall_sanitize_url( $input ) {
		$input = esc_url_raw( $input );
		return $input;
	}
	function snowfall_sanitize_js_url ( $input ) {
		$input = esc_url( $input );
		return $input;
	}
	function snowfall_sanitize_integer( $input ) {
    	if( is_numeric( $input ) ) {
        return intval( $input );
   	}
	}
   // color sanitization
   function snowfall_color_option_hex_sanitize($color) {
      if ($unhashed = sanitize_hex_color_no_hash($color))
         return '#' . $unhashed;

      return $color;
   }

   function snowfall_color_escaping_option_sanitize($input) {
      $input = esc_attr($input);
      return $input;
   }
   function snowfall_radio_sanitize( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}
add_action('customize_register', 'snowfall_customize_register');
