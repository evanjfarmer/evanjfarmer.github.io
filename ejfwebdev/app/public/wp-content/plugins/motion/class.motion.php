<?php
/*
 * Load on client side
*/

if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('Motion') ) {

class Motion{

	public static $options_default_values;

        public function  __construct(){
                add_action('init', array($this, 'init'), 0);
		self::$options_default_values = Array('boxClass' => 'wow', 'offset' => 0, 'mobile' => true, 'live' => true, 'customCSS' => '');
        }

        public static function settings(){

                load_plugin_textdomain( MOTION_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/'.MOTION_DOMAIN_DIR);
	}

	public static function set_options(){
		add_option('motion_option_boxClass', 'wow_motion');
		add_option('motion_option_offset', 0);
		add_option('motion_option_mobile', true);
		add_option('motion_option_live', true);
		add_option('motion_option_customCSS', '');
        }
	public static function unset_options(){
		delete_option('motion_option_boxClass');
                delete_option('motion_option_offset');
                delete_option('motion_option_mobile');
                delete_option('motion_option_live');
                delete_option('motion_option_customCSS');
	}

        public static function init(){
                // main plugin css
                wp_register_style( 'motion-plugin', MOTION_URL.'stylesheets/app.css', array(),  MOTION_VERSION, 'all' ) ;
                wp_enqueue_style( 'motion-plugin' );

                // main plugin js
                wp_register_script( 'motion-plugin',  MOTION_URL.'js/app.js', array('jquery'), MOTION_VERSION, true );
                wp_enqueue_script( 'motion-plugin' );

		add_action( 'wp_footer', Array(__CLASS__, 'script_in_footer'), 30 );
		add_action( 'wp_head', Array(__CLASS__, 'script_in_head'), 30 );
	
                //shortcodes
                $motion_shortcodes = new Motion_shortcodes();

                // allow shortcodes in widgets
                add_filter('widget_text', 'do_shortcode');

		// widjet class
		add_filter('dynamic_sidebar_params', array(__CLASS__,'add_widget_animation_class'));
        }

	public static function script_in_head(){
		$code = '<style type="text/css" id="motion-plugin-header-css">'.get_option('motion_option_customCSS').'</style>';

		echo $code;
	}

	public static function script_in_footer(){
		$motion_option_mobile = (get_option('motion_option_mobile')) ? get_option('motion_option_mobile') : 'false' ;
		$motion_option_live = (get_option('motion_option_live')) ? get_option('motion_option_live') : 'false';
		$code = "<script type='text/javascript'>
		/* <![CDATA[ */
                wow_motion = new WOW_motion(
                      {
                        boxClass:     '".get_option('motion_option_boxClass')."',      	// default wow_motion
                        offset:       ".get_option('motion_option_offset').",          	// default 0
                        mobile:       ".$motion_option_mobile.",       			// default true
                        live:         ".$motion_option_live."        			// default true
                      }
                    )
                    wow_motion.init();
		/* ]]> */
                </script>";

		echo $code;
	}

	public static function add_widget_animation_class($params){
                global $wp_registered_widgets;
                $widget_id = $params[0]['widget_id'];
                $widget_obj = $wp_registered_widgets[$widget_id];
                $widget_opt = get_option($widget_obj['callback'][0]->option_name);
                $widget_num = $widget_obj['params'][0]['number'];

                if (isset($widget_opt[$widget_num]['motionDataAnimate']) && $widget_opt[$widget_num]['motionDataAnimate']){
                        $motion_animation_class 	= $widget_opt[$widget_num]['motionDataSpeed']." ".$widget_opt[$widget_num]['motionDataEasing']." ".$widget_opt[$widget_num]['motionDataDelay']." ".$widget_opt[$widget_num]['motionDataAnimation']." ".get_option('motion_option_boxClass');
			$motion_data_animate 		= $widget_opt[$widget_num]['motionDataAnimate'];
                        $params[0]['before_widget'] = preg_replace('/class="/', 'class=" '.esc_attr($motion_animation_class).' ',  $params[0]['before_widget'], 1);
                        $params[0]['before_widget'] = preg_replace('/class=/', ' data-animate="'.esc_attr($motion_data_animate).'" class=',  $params[0]['before_widget'], 1);
                }
                return $params;
        }
}

}
