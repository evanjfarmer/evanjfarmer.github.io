<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}
?>
<div class="wrap motion-admin-page">
	<h2 id="motion-title"><?php _e('Motion Plugin', 'motion');?></h2>

	<h3>1. <?php _e('Settings', 'motion') ?></h3>
	<form method="post" action="<?php echo admin_url('options.php');?>">
                <?php settings_fields( 'motion-options' ); ?>
                <?php do_settings_sections( 'motion-options' ); ?>
                <table class="form-table">
                <tr>
                        <th scope="row"><label for="motion_option_boxClass">boxClass</label></th>
                        <td><input type="text" id="motion_option_boxClass" name="motion_option_boxClass" value="<?php echo esc_attr(get_option('motion_option_boxClass')); ?>"><br/>
			<small><?php _e("Class name that reveals the hidden box when user scrolls ('wow_motion' by default).", 'motion') ?></small></td>
                </tr>
		<tr>
                        <th scope="row"><label for="motion_option_offset">offset</label></th>
                        <td><input type="text" id="motion_option_offset" name="motion_option_offset" value="<?php echo esc_attr(get_option('motion_option_offset')); ?>"><br/>
                        <small><?php _e('Define the distance between the bottom of browser viewport and the top of hidden box. When the user scrolls and reach this distance the hidden box is revealed (0 by default).','motion'); ?></small></td>
                </tr>
		<tr>
                        <th scope="row"><label for="motion_option_mobile">mobile</label></th>
			<?php $checked = (get_option('motion_option_mobile')) ? 'checked="checked"' : '' ;?>
                        <td><input type="checkbox" id="motion_option_mobile" name="motion_option_mobile" value="true" <?php echo $checked;?>><br/>
                        <small><?php _e("Turn on/off WOW_motion.js on mobile devices ('true' by default).",'motion'); ?></small></td>
                </tr>
		<tr>
                        <th scope="row"><label for="motion_option_live">live</label></th>
                        <?php $checked = (get_option('motion_option_live')) ? 'checked="checked"' : '' ;?>
                        <td><input type="checkbox" id="motion_option_live" name="motion_option_live" value="true" <?php echo $checked;?>><br/>
                        <small><?php _e("Consatantly check for new WOW_motion elements on the page ('true' by default).",'motion'); ?></small></td>
                </tr>
		<tr>
                        <th scope="row"><label for="motion_option_customCSS"><?php _e('Custom CSS','motion');?></label></th>
                        <td><textarea name="motion_option_customCSS" id="motion_option_customCSS" dir="ltr" style="direction:ltr;" cols="25" rows="10"><?php echo get_option('motion_option_customCSS'); ?></textarea><br/>
			<small><?php _e('Add custom CSS', 'motion');?></small>
			</td>
                </tr>
                </table>

            <?php submit_button(); ?>

        </form>

	<hr/>

        <h3>2. <?php _e('Follow us, and do not miss anything!', 'motion') ?></h3>
        <!-- Facebook like button -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/<?php echo get_locale();?>/sdk.js#xfbml=1&version=v2.4&appId=100591450050015";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div class="fb-like" data-href="https://www.facebook.com/Motion-Wordpress-Plugin-1706905669541328/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

        <h3>3. <?php _e('We love stars', 'motion') ?></h3>
        <p><figure><img src="<?php echo MOTION_URL;?>images/stars.png" alt="5 stars" width="134" height="28"></figure></p>
        <p><?php echo sprintf( __('Please write %s review %s', 'motion'), '<a href="https://wordpress.org/support/view/plugin-reviews/motion/" target="_blank">', '</a>');?></p>

        <h3>4. <?php _e('Please help us to continue develop this free wordpress plug-in', 'motion') ?></h3>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE" target="_blank"><img src="<?php echo MOTION_URL;?>images/paypal_donate_button217x50.png" width="217" height="50" alt="paypal donate button"></a>

        <hr>

</div>
