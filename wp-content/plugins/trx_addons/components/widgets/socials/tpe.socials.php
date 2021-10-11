<?php
/**
 * Template to represent shortcode as a widget in the Elementor preview area
 *
 * Written as a Backbone JavaScript template and using to generate the live preview in the Elementor's Editor
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.41
 */

extract(get_query_var('trx_addons_args_widget_socials'));

extract(trx_addons_prepare_widgets_args('widget_socials_'.mt_rand(), 'widget_socials'));

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
?><#
if (settings.title != '') {
	#><?php trx_addons_show_layout($before_title); ?><#
	print(settings.title);
	#><?php trx_addons_show_layout($after_title); ?><#
}

// Widget body
if (settings.description != '') {
	#><div class="socials_description">{{{ settings.description }}}</div><#
}
var socials = '<?php echo addslashes(trx_addons_get_socials_links()); ?>';
if ( socials != '') {
	#><div class="socials_wrap sc_align_{{ settings.align }}">{{{ socials }}}</div><#
}
#><?php	

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>