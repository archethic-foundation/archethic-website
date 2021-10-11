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

extract(get_query_var('trx_addons_args_widget_video'));

extract(trx_addons_prepare_widgets_args('widget_video_'.mt_rand(), 'widget_video'));

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
if (settings.link != '' && settings.embed == '') {
   settings.embed = trx_addons_get_embed_from_url(settings.link);
}
if (settings.link != '' || settings.embed != '') {
	var id = settings._element_id ? settings._element_id + '_sc' : 'sc_video_'+(''+Math.random()).replace('.', '');
	#><div id="{{ id }}" class="trx_addons_video_player <# print(settings.cover.url != '' ? 'with_cover hover_play' : 'without_cover'); #>"><#
		if (settings.cover.url != '') {
			#><img src="{{ settings.cover.url }}" alt="">
			<div class="video_mask"></div>
			<div class="video_hover" data-video="<# print(_.escape(settings.embed)); #>"></div><#
		}
		#>
		<div class="video_embed video_frame"><#
			if (settings.cover.url == '') {
				print(settings.embed);
			}
		#></div>
	</div><#
}
#><?php	

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>