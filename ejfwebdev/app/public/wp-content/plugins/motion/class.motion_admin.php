<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('Motion_admin') ) {

class Motion_admin{

	public static $donate_link;
	public static $wordpress_plugin_page;
	public static $demo_link;

	function __construct(){
		add_action('init', array($this, 'init'), 0);	
		add_action('admin_menu', array($this, 'register_menu_page'));

		add_filter( 'plugin_action_links_' . MOTION_SLUG, array( $this, 'add_action_link' ), 10, 2 );
		
		self::$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" alt="PayPal - The safer, easier way to pay online!" /></a>';
		self::$wordpress_plugin_page = '<a href="https://wordpress.org/plugins/motion/">'.__('Wordpress Plugin Page', 'motion').'</a>';
		self::$demo_link = '<a href="http://motion.tadam.co.il/">'.__('Full Documantation & Demo','motion').'</a>';
	}
	
	public static function init(){
		// load styles
		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
		$motion_tinymce = new Motion_TinyMCE();

		// widjet class
                add_action('in_widget_form', array(__CLASS__,'extend_widget_form'),11,3);
                add_filter('widget_update_callback', array(__CLASS__,'update_widget_animation_class'),11,2);
	}

	public static function register_menu_page(){
		$admin_page = add_menu_page( __('Motion', 'motion'), __('Motion', 'motion'), 'manage_options', 'motion_dashboard', array(__CLASS__, 'load_page'), plugins_url('/images/icon-20x20.png', __FILE__), '99.2' );
		/**
                 * Filter: 'motion_manage_options_capability' - Allow changing the capability users need to view the settings pages
                 *
                 * @api string unsigned The capability
                 */
                $manage_options_cap = apply_filters( 'motion_manage_options_capability', 'manage_options' );
		
		//call register settings function
		add_action('admin_init', array(__CLASS__, 'page_init' )); //call register settings function

	}

	public static function load_page() {
		$page = filter_input( INPUT_GET, 'page' );
		switch ( $page ) {
			case 'motion_dashboard':
                        default:
                                require_once( MOTION_DIR . 'admin/pages/dashboard.php' );
                                break;
                }
	}

	public static function page_init() {
		register_setting( 'motion-options', 'motion_option_boxClass');
                register_setting( 'motion-options', 'motion_option_motionClass');
                register_setting( 'motion-options', 'motion_option_offset' );
                register_setting( 'motion-options', 'motion_option_mobile' );
                register_setting( 'motion-options', 'motion_option_live' );
                register_setting( 'motion-options', 'motion_option_customCSS' );
 	}

	public static function plugin_row_meta($input, $file){
		if ( MOTION_SLUG != $file ) {
                        return $input;
                }
                $links = array(
			self::$wordpress_plugin_page,
			self::$demo_link,
			self::$donate_link,
                );


                $input = array_merge( $input, $links );

                return $input;
	}

	/**
         * Adds form fields to Widget
         * @static
         * @param $widget
         * @param $return
         * @param $instance
         * @return array
         * @since 1.0
         */
        public static function extend_widget_form( $widget, $return, $instance ) {
                if ( !isset( $instance['motionDataAnimate'] ) ) $instance['motionDataAnimate'] = null;
                if ( !isset( $instance['motionDataSpeed'] ) ) $instance['motionDataSpeed'] = null;
                if ( !isset( $instance['motionDataEasing'] ) ) $instance['motionDataEasing'] = null;
                if ( !isset( $instance['motionDataDelay'] ) ) $instance['motionDataDelay'] = null;
                if ( !isset( $instance['motionDataAnimation'] ) ) $instance['motionDataAnimation'] = null;
                $fields = '';

		/* DATA ANIMATE */
		$Slide = Array('slideInUp','slideInRight','slideInDown','slideInLeft');
		$Fade = Array('fadeIn');
		$Spin = Array('spinIn','spinInCCW');
		$Scale = Array('scaleInUp','scaleInDown');
		$Hinge = Array('hingeInFromTop','hingeInFromRight','hingeInFromBottom','hingeInFromLeft','hingeInFromMiddleX','hingeInFromMiddleY');

		$data_animate_values = Array($Slide, $Fade, $Spin, $Scale, $Hinge);
		$data_animate_titles = Array( 	__("Slide","motion"), 
					__("Fade","motion"),
					__("Spin","motion"),
					__("Scale","motion"),
					__("Hinge","motion")
		);

                $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-motionDataAnimate'>".apply_filters( 'widget_css_motionDataAnimate_class', esc_html__( 'Motion Transition Style', 'motion' ) ).":</label>\n";
                $fields .= "\t<select name='widget-{$widget->id_base}[{$widget->number}][motionDataAnimate]' id='widget-{$widget->id_base}-{$widget->number}-motionDataAnimate' class='widefat'>\n";
                $fields .= "\t<option value=''>".esc_attr__( 'Select', 'motion' )."</option>\n";

		for ($i = 0; $i < count($data_animate_values); $i++) {
                        $preset_value = $data_animate_values[$i];
			$fields .= '<optgroup label="'.$data_animate_titles[$i].'">';

                        for($j = 0; $j < count($preset_value); $j++) {
				if (!$preset_value[$j]) continue;
				$fields .= "\t<option value='".esc_attr($preset_value[$j])."' ".selected( $instance['motionDataAnimate'], $preset_value[$j], 0 ).">".$preset_value[$j]."</option>\n";
			}
			$fields .= '</optgroup>';
		}
                $fields .= "</select>\n";

		/* END DATA ANIMATE */

		/* DATA SPEED  */
		$data_speed_values = Array('normal','slow','fast');
		$fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-motionDataSpeed'>".apply_filters( 'widget_css_motionDataSpeed_class', esc_html__( 'Motion Speed', 'motion' ) ).":</label>\n";
                $fields .= "\t<select name='widget-{$widget->id_base}[{$widget->number}][motionDataSpeed]' id='widget-{$widget->id_base}-{$widget->number}-motionDataSpeed' class='widefat'>\n";
		foreach ($data_speed_values as $preset_value){
			$fields .= "\t<option value='".esc_attr($preset_value)."' ".selected( $instance['motionDataSpeed'], $preset_value, 0 ).">".$preset_value."</option>\n";
		}
	
		$fields .= "</select>\n";
		/* END DATA SPEED  */

		/* DATA EASING */
		$data_easing_values = Array('linear','ease','easeIn','easeOut','easeInOut','bounce','bounceIn','bounceOut','bounceInOut');
                $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-motionDataEasing'>".apply_filters( 'widget_css_motionDataEasing_class', esc_html__( 'Motion Easing', 'motion' ) ).":</label>\n";
                $fields .= "\t<select name='widget-{$widget->id_base}[{$widget->number}][motionDataEasing]' id='widget-{$widget->id_base}-{$widget->number}-motionDataEasing' class='widefat'>\n";
                foreach ($data_easing_values as $preset_value){
                        $fields .= "\t<option value='".esc_attr($preset_value)."' ".selected( $instance['motionDataEasing'], $preset_value, 0 ).">".$preset_value."</option>\n";
                }
                $fields .= "</select>\n";
		/* END DATA EASING */

		/* DATA DELAY */
		$data_delay_values = Array('','short-delay','long-delay');
                $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-motionDataDelay'>".apply_filters( 'widget_css_motionDataDelay_class', esc_html__( 'Motion Delay', 'motion' ) ).":</label>\n";
                $fields .= "\t<select name='widget-{$widget->id_base}[{$widget->number}][motionDataDelay]' id='widget-{$widget->id_base}-{$widget->number}-motionDataDelay' class='widefat'>\n";
                foreach ($data_delay_values as $preset_value){
                        $fields .= "\t<option value='".esc_attr($preset_value)."' ".selected( $instance['motionDataDelay'], $preset_value, 0 ).">".$preset_value."</option>\n";
                }
                $fields .= "</select>\n";
		/* END DATA DELAY */

		/* DATA ANIMATION */
		/*
		$data_animation_values = Array('','shake','wiggle','spin-cw','spin-ccw');
                $fields .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-motionDataAnimation'>".apply_filters( 'widget_css_motionDataAnimation_class', esc_html__( 'Motion Animation', 'motion' ) ).":</label>\n";
                $fields .= "\t<select name='widget-{$widget->id_base}[{$widget->number}][motionDataAnimation]' id='widget-{$widget->id_base}-{$widget->number}-motionDataAnimation' class='widefat'>\n";
                foreach ($data_animation_values as $preset_value){
                        $fields .= "\t<option value='".esc_attr($preset_value)."' ".selected( $instance['motionDataAnimation'], $preset_value, 0 ).">".$preset_value."</option>\n";
                }
                $fields .= "</select>\n";
		*/
		/* END DATA ANIMATION */

		$fields .= "</p>\n";

                do_action( 'widget_css_classes_form', $fields, $instance );

                echo $fields;
                return $instance;
        }


	public static function update_widget_animation_class( $instance, $new_instance ) {
                $instance['motionDataAnimate'] = $new_instance['motionDataAnimate'];
                $instance['motionDataSpeed'] = $new_instance['motionDataSpeed'];
                $instance['motionDataEasing'] = $new_instance['motionDataEasing'];
                $instance['motionDataDelay'] = $new_instance['motionDataDelay'];
                $instance['motionDataAnimation'] = $new_instance['motionDataAnimation'];
                do_action( 'widget_css_classes_update', $instance, $new_instance );
                return $instance;
        }

	/**
         * Add a link to the settings page to the plugins list
         *
         * @staticvar string $this_plugin holds the directory & filename for the plugin
         *
         * @param array  $links array of links for the plugins, adapted when the current plugin is found.
         * @param string $file  the filename for the current plugin, which the filter loops through.
         *
         * @return array $links
         */
        function add_action_link( $links, $file ) {
                if ( MOTION_SLUG === $file ) {
                        $settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=motion_dashboard' ) ) . '">' . __( 'Settings', 'motion' ) . '</a>';
                        array_unshift( $links, $settings_link );
                }
                return $links;
        }	
}

}
