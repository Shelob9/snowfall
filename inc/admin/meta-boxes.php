<?php
/**
 * This fucntion is responsible for rendering metaboxes in single post area
 *
 * @package ThemeGrill
 * @subpackage snowfall
 * @since snowfall 1.0
 */

 add_action( 'add_meta_boxes', 'snowfall_add_custom_box' );
/**
 * Add Meta Boxes.
 */
function snowfall_add_custom_box() {
	// Adding layout meta box for Page
	add_meta_box( 'page-layout', __( 'Select Layout', 'snowfall' ), 'snowfall_layout_call', 'page', 'side', 'default' );
	// Adding layout meta box for Post
	add_meta_box( 'page-layout', __( 'Select Layout', 'snowfall' ), 'snowfall_layout_call', 'post', 'side', 'default' );
	//Adding fontawesome icons
	add_meta_box( 'services-icon', __( 'Icon class', 'snowfall' ), 'snowfall_icon_call', 'page', 'side'	);
	//Adding designation meta box
	add_meta_box( 'team-designation', __( 'Our Team Designation', 'snowfall' ), 'snowfall_designation_call', 'page', 'side'	);
}

/****************************************************************************************/

global $snowfall_page_layout, $snowfall_metabox_field_icons, $snowfall_metabox_field_designation;
$snowfall_page_layout = array(
							'default-layout' 	=> array(
														'id'			=> 'snowfall_page_layout',
														'value' 		=> 'default_layout',
														'label' 		=> __( 'Default Layout', 'snowfall' )
														),
							'right-sidebar' 	=> array(
														'id'			=> 'snowfall_page_layout',
														'value' 		=> 'right_sidebar',
														'label' 		=> __( 'Right Sidebar', 'snowfall' )
														),
							'left-sidebar' 	=> array(
														'id'			=> 'snowfall_page_layout',
														'value' 		=> 'left_sidebar',
														'label' 		=> __( 'Left Sidebar', 'snowfall' )
														),
							'no-sidebar-full-width' => array(
															'id'			=> 'snowfall_page_layout',
															'value' 		=> 'no_sidebar_full_width',
															'label' 		=> __( 'No Sidebar Full Width', 'snowfall' )
															),
							'no-sidebar-content-centered' => array(
															'id'			=> 'snowfall_page_layout',
															'value' 		=> 'no_sidebar_content_centered',
															'label' 		=> __( 'No Sidebar Content Centered', 'snowfall' )
															)
						);

$snowfall_metabox_field_icons = array(
	array(
		'id'			=> 'snowfall_font_icon',
		'label' 		=> __( 'fontawesome Icons', 'snowfall' )
	)
);

$snowfall_metabox_field_designation = array(
	array(
		'id'			=> 'snowfall_designation',
		'label' 		=> __( 'team designation', 'snowfall' )
	)
);

/****************************************************************************************/

function snowfall_layout_call() {
	global $snowfall_page_layout;
	snowfall_meta_form( $snowfall_page_layout );
}

function snowfall_icon_call() {
	global $snowfall_metabox_field_icons;
	snowfall_meta_form( $snowfall_metabox_field_icons );
}

function snowfall_designation_call() {
	global $snowfall_metabox_field_designation;
	snowfall_meta_form( $snowfall_metabox_field_designation );
}


/**
 * Displays metabox to for select layout option
 */
function snowfall_meta_form( $snowfall_metabox_field ) {
	global $post;

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'custom_meta_box_nonce' );

	foreach ( $snowfall_metabox_field as $field ) {
		$layout_meta = get_post_meta( $post->ID, $field['id'], true );
		switch( $field['id'] ) {

			// Layout
			case 'snowfall_page_layout':
				if( empty( $layout_meta ) ) { $layout_meta = 'default_layout'; } ?>

				<input class="post-format" type="radio" name="<?php echo $field['id']; ?>" value="<?php echo $field['value']; ?>" <?php checked( $field['value'], $layout_meta ); ?>/>
				<label class="post-format-icon"><?php echo $field['label']; ?></label><br/>
				<?php

			break;

			// Font icon
			case 'snowfall_font_icon':
				_e( 'If featured image is not used than display the icon in Services. </br>', 'snowfall' );
				echo '<input type="text" name="'.$field['id'].'" value="'.esc_html($layout_meta).'"/><br>';

				$url = 'http://fontawesome.io/icons/';
				$link = sprintf( __( '<a href="%s" target="_blank">Refer here</a> for icon class. For example: <strong>fa-mobile</strong>', 'snowfall' ), esc_url( $url ) );
				echo $link;

			break;

			// Team Designation
			case 'snowfall_designation':
				_e( 'Show designation in Our Team Widget. </br>', 'snowfall' );
				echo '<input type="text" name="'.$field['id'].'" value="'.esc_html($layout_meta).'"/><br>';

			break;
		}
	}
}

/****************************************************************************************/

add_action('save_post', 'snowfall_save_custom_meta');
/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function snowfall_save_custom_meta( $post_id ) {
	global $snowfall_page_layout, $snowfall_metabox_field_icons, $snowfall_metabox_field_designation, $post;

	// Verify the nonce before proceeding.
   if ( !isset( $_POST[ 'custom_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'custom_meta_box_nonce' ], basename( __FILE__ ) ) )
      return;

	// Stop WP from clearing custom fields on autosave
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
      return;

	if ('page' == $_POST['post_type']) {
      if (!current_user_can( 'edit_page', $post_id ) )
         return $post_id;
   }
   elseif (!current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
   }

   foreach ( $snowfall_page_layout as $field ) {
		//Execute this saving function
		$old = get_post_meta( $post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach

	if ('page' == $_POST['post_type']) {
   // loop through fields and save the data
	   foreach ( $snowfall_metabox_field_icons as $field ) {
	    	$old = get_post_meta( $post_id, $field['id'], true );
	      $new = $_POST[$field['id']];
	      if ($new && $new != $old) {
	     		update_post_meta( $post_id,$field['id'],$new );
	      } elseif ('' == $new && $old) {
	     	delete_post_meta($post_id, $field['id'], $old);
	    	}
	   } // end foreach

	   // loop through fields and save the data
	   foreach ( $snowfall_metabox_field_designation as $field ) {
	    	$old = get_post_meta( $post_id, $field['id'], true );
	      $new = $_POST[$field['id']];
	      if ($new && $new != $old) {
	     		update_post_meta( $post_id,$field['id'],$new );
	      } elseif ('' == $new && $old) {
	     	delete_post_meta($post_id, $field['id'], $old);
	    	}
	   } // end foreach
	}
}
