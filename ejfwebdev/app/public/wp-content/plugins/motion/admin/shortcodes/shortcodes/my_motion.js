var Slide = ['slideInUp','slideInRight','slideInDown','slideInLeft'];
var Fade = ['fadeIn'];
var Spin = ['spinIn','spinInCCW'];
var Scale = ['scaleInUp','scaleInDown'];
var Hinge = ['hingeInFromTop','hingeInFromRight','hingeInFromBottom','hingeInFromLeft','hingeInFromMiddleX','hingeInFromMiddleY'];

frameworkShortcodeAtts={
	attributes:[
			{
                                label:motion_plugin_data.transition_style_label,
                                id:"data-animate",
                                controlType:"optgroup-select-control",
                                selectValues:[Slide,Fade,Spin,Scale,Hinge],
				selectTitles:["Slide","Fade","Spin","Scale","Hinge"],
                                defaultValue: 'slideInUp',
                                defaultText: 'slideInUp',
                        },
			{
                                label:motion_plugin_data.speed_label,
                                id:"data-speed",
                                controlType:"select-control",
                                selectValues:['normal', 'slow', 'fast'],
                                defaultValue: 'normal',
                                defaultText: 'normal',
				help: motion_plugin_data.speed_help
                        },
			{
                                label:motion_plugin_data.easing_label,
                                id:"data-easing",
                                controlType:"select-control",
                                selectValues:['linear','ease','easeIn','easeOut','easeInOut','bounce','bounceIn','bounceOut','bounceInOut'],
                                defaultValue: 'linear',
                                defaultText: 'linear'
                        },
			{
                                label:motion_plugin_data.delay_label,
                                id:"data-delay",
                                controlType:"select-control",
                                selectValues:['','short-delay','long-delay'],
                                defaultValue: '',
                                defaultText: '',
				help: motion_plugin_data.delay_help
                        },
			{
                                label:motion_plugin_data.offset_label,
                                id:"data-offset",
                                help:motion_plugin_data.offset_help
                        },
			{
				label:motion_plugin_data.custom_class_label,
				id:"custom_class",
				help:motion_plugin_data.custom_class_help
			}
	],
	defaultContent: "<img src='"+motion_plugin_data.url+"images/yeti239x200.png' width='239' height='200' alt=''>",
	shortcode:"motion"
};
