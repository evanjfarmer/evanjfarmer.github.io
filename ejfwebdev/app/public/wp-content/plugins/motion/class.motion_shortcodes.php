<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('Motion_shortcodes') ) {

class Motion_shortcodes{
        function __construct(){
		add_shortcode('motion', array($this, 'motion'));
	}

	public static function motion( $atts, $content = null){
		ob_start();
                $content = do_shortcode(trim($content));
                $atts = array_map( 'esc_attr', (array)$atts );

		$a = shortcode_atts( array(
			'data-animate' 		=> '',
			'data-speed'		=> '',
			'data-easing'		=> '',
			'data-delay'		=> '',
			'data-animation'	=> '',
			'data-offset'		=> '',
		        'custom_class'          => ''
		), $atts );

		$data_animate = ($a["data-animate"]) 		? 'data-animate="'.$a["data-animate"].'"' : '' ;
		$data_offset        = ($a["data-offset"])       ? 'data-offset="'.$a["data-offset"].'"' : '' ;

		?>
		<section <?php echo $data_animate; ?> <?php echo $data_offset; ?> class="<?php echo get_option('motion_option_boxClass'); ?> <?php echo $a["custom_class"]; ?> <?php echo $a["data-speed"];?> <?php echo $a["data-easing"];?> <?php echo $a["data-delay"];?> <?php echo $a["data-animation"];?>"><?php echo $content; ?></section>
		<?php
		return ob_get_clean();
	}
}
}

