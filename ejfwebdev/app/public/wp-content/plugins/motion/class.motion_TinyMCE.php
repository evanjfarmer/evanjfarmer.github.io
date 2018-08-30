<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

/**
 * TinyMCE Shortcode Integration
 */
if ( !class_exists('Motion_TinyMCE') ) {

class Motion_TinyMCE {

	function __construct() {
		// Init
                add_action( 'admin_init', array( $this, 'init' ) );

                // wp_ajax_... is only run for logged users.
                add_action( 'wp_ajax_motion_check_url_action', array( $this, 'ajax_action_check_url' ) );
                add_action( 'wp_ajax_motion_nonce', array( $this, 'ajax_action_generate_nonce' ) );

                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );

                // Output the markup in the footer.
                add_action( 'admin_footer', array( $this, 'output_dialog_markup' ) );
	}
	
	// get everything started
        function init() {
                global $pagenow;

                if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) == 'true' && ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php' ) ) ) )  {

                       	// Add the tinyMCE buttons and plugins.
                       	add_filter( 'mce_buttons', array( $this, 'filter_mce_buttons' ) );
                       	add_filter( 'mce_external_plugins', array( $this, 'filter_mce_external_plugins' ) );

                       	wp_enqueue_style( 'motion-tinymce-shortcodes', MOTION_URL . 'admin/css/tinymce-shortcodes.css', false, MOTION_VERSION, 'all' );

			// main plugin css
	                wp_register_style( 'motion-plugin', MOTION_URL.'stylesheets/app.css', array(),  MOTION_VERSION, 'all' ) ;
                	wp_enqueue_style( 'motion-plugin' );

	                // main plugin js
        	        wp_register_script( 'motion-plugin',  MOTION_URL.'js/app.js', array('jquery'), MOTION_VERSION, true );
                	wp_enqueue_script( 'motion-plugin' );

			// admin js
			wp_register_script( 'motion-plugin-admin',  MOTION_URL.'admin/js/admin.js', array('jquery'), MOTION_VERSION, true );
                        wp_enqueue_script( 'motion-plugin-admin' );

	                add_action( 'in_admin_footer', Array(__CLASS__, 'script_in_footer'), 100 );
                }
        }

	// add new button to the tinyMCE editor
        function filter_mce_buttons( $buttons ) {
	        array_push( $buttons, '|', 'motion_button' );
                return $buttons;
        }

	// add functionality to the tinyMCE editor as an external plugin
        function filter_mce_external_plugins( $plugins ) {
 	       global $wp_version;
               $plugins['MOTIONTinyMCE'] = wp_nonce_url( esc_url( MOTION_URL . 'admin/shortcodes/editor.js?v=0.2' ), 'motion-tinymce' );
               return $plugins;
        }

	// checks if a given url (via GET or POST) exists
        function ajax_action_check_url() {
	        $hadError = true;
                $url = isset( $_REQUEST['url'] ) ? $_REQUEST['url'] : '';
                if ( strlen( $url ) > 0  && function_exists( 'get_headers' ) ) {
		        $url = esc_url( $url );
                        $file_headers = @get_headers( $url );
                        $exists = $file_headers && $file_headers[0] != 'HTTP/1.1 404 Not Found';
                        $hadError = false;
                }
                echo '{ "exists": '. ($exists ? '1' : '0') . ($hadError ? ', "error" : 1 ' : '') . ' }';
                die();
        }

	// generate a nonce
        function ajax_action_generate_nonce() {
	        echo wp_create_nonce( 'motion-tinymce' );
                die();
        }

        function enqueue_scripts() {
	        wp_register_script( 'motion-tinymce-dialog-script', plugins_url( 'admin/shortcodes/dialog.js', __FILE__ ), array( 'jquery' ), MOTION_VERSION, true );
                wp_enqueue_script( 'motion-tinymce-dialog-script' );
                $plugin_data = array(
         	       	'url' => MOTION_URL,
			'error_loading_details_for_shortcode' => __('Error loading details for shortcode', 'motion'),
			'transition_style_label' => __('Transition Style','motion'),
			'speed_label' => __('Speed','motion'),
			'speed_help' => __('normal (500ms), slow (750ms), fast (250ms)','motion'),
			'easing_label' => __('Easing','motion'),
			'delay_label' => __('Delay','motion'),
			'delay_help' => __('Delay before the animation starts, short-delay (300ms), long-delay (700ms)','motion'),
			'offset_label' => __('Offset','motion'),
			'offset_help' => __('Distance to start the animation in pixels (related to the browser bottom). (e.g. 10)','motion'),
			'custom_class_label' => __('Custom Class','motion'),
			'custom_class_help' => __('Any CSS classes you want to add.','motion')
                );
	        wp_localize_script( 'motion-tinymce-dialog-script', 'motion_plugin_data', $plugin_data );
        }
	
        // Output the HTML markup for the dialog box.
        function output_dialog_markup () {
	        // URL to TinyMCE plugin folder
                $plugin_url = MOTION_URL . '/includes/shortcodes/'; ?>

                <div id="motiondialog" style="display:none">
        	        <div class="buttons-wrapper">
                               <input type="button" id="motiondialog-cancel-button" class="button alignleft" name="cancel" value="<?php _e('Cancel', 'motion') ?>" accesskey="C" />
                 	       <input type="button" id="motiondialog-insert-button" class="button-primary alignright" name="insert" value="<?php _e('Insert', 'motion') ?>" accesskey="I" />
                               <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
			<div class="sandbox" id="motiondialog-sandbox">
				<section class="wow_motion"><img src='<?php echo MOTION_URL ;?>images/yeti239x200.png' width='239' height='200' alt=''></section>
				<div class="clear"></div>
				<button><?php _e('Motion it', 'motion'); ?></button>
			</div>
                        <h3 class="sc-options-title"><?php _e('Shortcode Options', 'motion') ?></h3>
                        <div id="motiondialog-shortcode-options" class="alignleft">
	                        <table id="motiondialog-options-table"></table>
                                <input type="hidden" id="motiondialog-selected-shortcode" value="">
                        </div>
                        <div class="clear"></div>
                </div><!-- /#motiondialog -->
        <?php }
	
	public static function script_in_footer(){
                $code = "<script type='text/javascript'>
                /* <![CDATA[ */
		jQuery(function(){
                wow_motion = new WOW_motion(
                      {
                        boxClass:     'wow_motion',    	// default wow_motion
                        offset:       0,            	// default 0
                        mobile:       true,             // default true
                        live:         true              // default true
                      }
                    )
                    wow_motion.init();
		});
                /* ]]> */
                </script>";
                echo $code;
        }
}
}
