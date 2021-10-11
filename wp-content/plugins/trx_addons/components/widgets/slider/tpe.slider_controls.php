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

extract(get_query_var('trx_addons_args_widget_slider_controls'));
?><#
var id = settings._element_id ? settings._element_id + '_sc' : 'sc_slider_controls_'+(''+Math.random()).replace('.', '');
if (settings.slider_id !='') {
	#><div id="{{ id }}"
			class="sc_slider_controls sc_slider_controls_{{ settings.controls_style }} sc_align_{{ settings.align }}"
			data-slider-id="{{ settings.slider_id }}"
			data-style="{{ settings.controls_style }}">
		<div class="slider_controls_wrap<#
			if (settings.hide_prev == 0) print(' with_prev');
			if (settings.hide_next == 0) print(' with_next');
			if (settings.show_progress == 1) print (' with_progress');
		#>"><#
			if (settings.hide_prev == 0) { 
				#><a class="slider_prev swiper-button-prev<# if (settings.title_prev != '') print(' with_title'); #>" href="#">{{ settings.title_prev }}</a><#
			}
			if (settings.hide_next == 0) { 
				#><a class="slider_next swiper-button-next<# if (settings.title_next != '') print(' with_title'); #>" href="#">{{ settings.title_next }}</a><#
			}
			if (settings.show_progress == 1) { 
				#><span class="slider_progress"><span class="slider_progress_bar"></span></span><#
			}
		#></div>
	</div><#
}
#>