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

extract(get_query_var('trx_addons_args_widget_audio'));

extract(trx_addons_prepare_widgets_args('widget_audio_'.mt_rand(), 'widget_audio'));

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
#><div class="trx_addons_audio_player <# print(settings.cover.url != '' ? 'with_cover' : 'without_cover'); #>"<#
	if (settings.cover.url != '') print(' style="background-image:url(' + settings.cover.url + ');"');
#>><#

	if (settings.author != '' || settings.caption != '') {
		#><div class="audio_info"><#
			if (settings.author != '') {
				#><h6 class="audio_author">{{ settings.author }}</h6><#
			}
			if (settings.caption != '') {
				#><h5 class="audio_caption">{{ settings.caption }}</h5><#
			}
		#></div><#
	}

	#><div class="audio_frame audio_<# print(settings.embed != '' ? 'embed' : 'local'); #>"><#
		if (settings.embed != '')
			print(settings.embed);
		else if (settings.url != '') {
			#><audio src="{{ settings.url }}">
				<source type="audio/mpeg" src="{{ settings.url }}">
			</audio><#
		}
	#></div>

</div><?php	

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>