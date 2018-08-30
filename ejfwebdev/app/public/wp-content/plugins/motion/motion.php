<?php
/*
        Plugin Name: Motion
        Version: 0.5
        Plugin URI: http://motion.tadam.co.il/
        Description: Provide user friendly solution to beautiful CSS3 animations.
        Author: Adam Pery
        Author URI: http://motion.tadam.co.il/about/
        Text Domain: motion
        Domain Path: languages/
        License URI: http://www.gnu.org/licenses/gpl-2.0.html
        Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE
*/

if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

/* DEFINES*/
if ( !function_exists( 'get_plugin_data' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$plugin_data = get_plugin_data(plugin_dir_path(__FILE__).'motion.php');
global $wpdb;

//Foundation plugin constant variables
define('MOTION_DIR', plugin_dir_path(__FILE__));
define('MOTION_URL', plugin_dir_url(__FILE__));
define('MOTION_DOMAIN', $plugin_data['TextDomain']);
define('MOTION_DOMAIN_DIR', $plugin_data['DomainPath']);
define('MOTION_VERSION', $plugin_data['Version']);
define('MOTION_NAME', $plugin_data['Name']);
define('MOTION_SLUG', plugin_basename( __FILE__ ));
define('MOTION_DB', $wpdb->prefix.MOTION_DOMAIN);

// Don't allow the plugin to be loaded directly
if ( ! function_exists( 'add_action' ) ) {
        _e( 'Please enable this plugin from your wp-admin.', 'motion' );
        exit;
}

/* REQUIRES */
include_once (MOTION_DIR.'class.motion.php');
include_once (MOTION_DIR.'class.motion_shortcodes.php');
include_once (MOTION_DIR.'class.motion_plugable.php');

/* LOADINGS */
add_action('plugins_loaded', array('Motion', 'settings'), 0);

register_activation_hook(__FILE__, array('Motion','set_options'));
register_deactivation_hook(__FILE__, array('Motion','unset_options'));

/* INIT */

if(is_admin()){
        include_once (MOTION_DIR.'class.motion_admin.php');
        include_once (MOTION_DIR.'class.motion_TinyMCE.php');
        $motion_admin = new Motion_admin();
}
else{ //client
        $motion_shortcodes = new Motion();
}



