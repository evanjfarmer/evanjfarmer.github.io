<?php
/*
Plugin Name: Simple Full Screen Background Image
Plugin URI:  https://fullscreenbackgroundimages.com/
Description: Easily set an automatically scaled full-screen background image
Version: 1.2.4
Author: Scott DeLuzio
Author URI: http://scottdeluzio.com
*/

function sfsb_textdomain() {

	// Set filter for plugin's languages directory
	$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$lang_dir = apply_filters( 'sfsb_languages_directory', $lang_dir );

	// Load the translations
	load_plugin_textdomain( 'simple-full-screen-background-image', false, $lang_dir );
}
add_action( 'init', 'sfsb_textdomain' );

/*****************************************
* global
*****************************************/

$sfsb_options = get_option( 'fsb_settings' );

/*****************************************
* includes
*****************************************/
include('includes/admin-page.php');
include('includes/display-image.php');
include('includes/scripts.php');
include('includes/meta-box.php');


add_action( 'admin_init', 'sfsb_check_for_pro' );
function sfsb_check_for_pro(){
	// FSB_VERSION is defined in Pro, so this should be true if Pro is active.
	if( defined( 'FSB_VERSION' ) && is_string( FSB_VERSION ) ){
		global $wpdb;
		global $sfsb_options;
		$pro_table		= $wpdb->prefix . "fsb_images";

		// If pro is active, we want to add the existing image from Simple Full Screen Background Image to the Pro database. First need to check if the pro table exists.
		if ( $wpdb->get_var( "show tables like '$pro_table'" ) == $pro_table ) {
			// Pro table exists, so let's check to see if any images are in the pro table.
			$rowcount	= $wpdb->get_var( "SELECT COUNT(*) FROM $pro_table" );
			if( $rowcount == 0 ){
				// No images in the pro table, so we'll add the existing image from Simple Full Screen Background Image with a global context so the site does not lose it's appearance.
				$new_image = $wpdb->insert( $pro_table,
					array(
						'name'			=> $sfsb_options['image'],
						'url'			=> $sfsb_options['image'],
						'context'		=> 'global',
						'page_ids'		=> '',
						'needs_updated'	=> 0,
						'priority'		=> 1
					)
				);
			}
		}

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}