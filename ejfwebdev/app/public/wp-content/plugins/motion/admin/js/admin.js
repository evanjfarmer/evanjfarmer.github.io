jQuery(function(){
	jQuery('#motiondialog-options-table').on("change", "#framework-data-animate", function() {
		var style = jQuery(this).val();
		var _class = jQuery("#framework-data-speed").val() + ' ' + jQuery("#framework-data-easing").val() + ' ' + jQuery("#framework-data-delay").val() + ' ' + jQuery("#framework-data-animation").val();

		jQuery('#motiondialog-sandbox section').remove();
		jQuery('#motiondialog-sandbox').prepend('<section class="wow_motion '+_class+'" data-animate="'+style+'"><img src="'+motion_plugin_data.url+'images/yeti239x200.png" width="239" height="200" alt=""></section>');
		MotionUI.animateIn( jQuery('#motiondialog-sandbox').find('wow_motion') , style, function() {
	        });
	});
	jQuery('#motiondialog-sandbox').on( "click", "button", function() {
		jQuery('#motiondialog-options-table #framework-data-animate').change();
	});
});
