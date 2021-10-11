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

extract(get_query_var('trx_addons_args_sc_price'));
?><#
var id = settings._element_id ? settings._element_id + '_sc' : 'sc_price_'+(''+Math.random()).replace('.', '');

if (settings.columns.size < 1) settings.columns.size = settings.prices.length;
settings.columns.size = Math.max(1, Math.min(settings.prices.length, settings.columns.size));
settings.slider = settings.slider > 0 && settings.prices.length > settings.columns.size;
settings.slides_space.size = Math.max(0, settings.slides_space.size);
if (settings.slider > 0 && settings.slider_pagination > 0) settings.slider_pagination = 'bottom';

var column_class = "<?php echo esc_attr(trx_addons_get_column_class(1, '##')); ?>";
var link_class = "<?php echo apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_price_item_link sc_button sc_button_size_small', 'sc_price'); ?>";
var link_class_over = "<?php echo apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_price_item_link sc_price_item_link_over', 'sc_price'); ?>";

#><div id="{{ id }}" class="sc_price sc_price_{{ settings.type }}">

	<?php $element->sc_show_titles('sc_price'); ?>

	<#
	if (settings.slider) {
		settings.slides_min_width = 250;
		#><?php $element->sc_show_slider_wrap_start('sc_price'); ?><#
	} else if (settings.columns.size > 1) {
		#><div class="sc_price_columns_wrap sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><#
	} else {
		#><div class="sc_price_content sc_item_content"><#
	}	

	_.each(settings.prices, function(item) {
		if (settings.slider == 1) {
			#><div class="slider-slide swiper-slide"><#
		} else if (settings.columns.size > 1) {
			#><div class="<# print(column_class.replace('##', settings.columns.size)); #>"><#
		}
		#><div class="sc_price_item sc_price_item_<#
			print(settings.type);
			if (item.bg_image.url != '' || item.bg_color != '') print(' with_image');
			if (item.bg_color != '') print(' with_bg_color');
			#>"<#
			if (item.bg_image.url != '' || item.bg_color != '') {
				print(' style="'
							+ (item.bg_color != '' ? 'background-color:'+item.bg_color+';' : '')
							+ (item.bg_image.url != '' ? 'background-image:url('+item.bg_image.url+');' : '')
							+ '"');
			}
		#>><#
			// Label
			if (item.label != '') {
				#><div class="sc_price_item_label">{{ item.label }}</div><#
			}
			// Mask for bg image
			if (item.bg_image.url != '' || item.bg_color != '') {
				#>
				<div class="sc_price_item_mask"></div>
				<div class="sc_price_item_inner">
				<#
			}
			if (item.image.url != '') {
				#><div class="sc_price_item_image"><img src="{{ item.image.url }}" alt=""></div><#
			} else {
				var icon = item.icon;
				if (typeof item.icon_type == 'undefined') item.icon_type = '';
				if (icon != '') {
					var img = '';
					if (icon.indexOf('//') >= 0) {
						img = icon;
						icon = trx_addons_get_basename(icon);
						item.icon_type = 'image';
					}
					#><div class="sc_price_item_icon sc_price_item_icon_type_{{ item.icon_type }} {{ icon }}"
						<#
						if (item.color != '') print(' style="color: ' + item.color + '"');
						#>><#
						if (img != '') {
							#><img class="sc_icon_as_image" src="{{ img }}" alt=""><#
						} else {
							#><span class="sc_price_item_icon_type_{{ item.icon_type }} {{ icon }}"
								<# if (item.color != '') print(' style="color: '+item.color+'"'); #>
							></span><#
						}
					#></div><#
				}
			}
			#><div class="sc_price_item_info"><#
				if (item.subtitle != '') {
					item.subtitle = item.subtitle.split('|');
					#><h6 class="sc_price_item_subtitle"><#
						_.each(item.subtitle, function(str) {
							print('<span>'+str+'</span>');
						});
					#></h6><#
				}
				if (item.title != '') {
					item.title = item.title.split('|');
					#><h3 class="sc_price_item_title"><#
						_.each(item.title, function(str) {
							print('<span>'+str+'</span>');
						});
					#></h3><#
				}
				if (item.description != '') {
					item.description = item.description
											.replace(/\[(.*)\]/g, '<b>$1</b>')
											.replace(/\n/, '|')
											.split('|');
					#><div class="sc_price_item_description"><#
						_.each(item.description, function(str) {
							print('<span>'+str+'</span>');
						});
					#></div><#
				}
				if (item.price != '') {
					var parts = trx_addons_parse_codes(item.price).split('.');
					#><div class="sc_price_item_price"><#
						if (item.before_price!='') {
							#><span class="sc_price_item_price_before"><# print(trx_addons_parse_codes(item.before_price)); #></span><#
						}
						#><span class="sc_price_item_price_value">{{ parts[0] }}</span><#
						if (parts.length > 1 && parts[1]!='') {
							#><span class="sc_price_item_price_decimals">{{ parts[1] }}</span><#
						}
						if (item.after_price !='') {
							#><span class="sc_price_item_price_after"><# print(trx_addons_parse_codes(item.after_price)); #></span><#
						}
					#></div><#
				}
				if (item.details != '') {
					#><div class="sc_price_item_details">{{{ item.details }}}</div><#
				}
				if (item.link.url != '' && item.link_text != '') {
					#><a href="{{ item.link.url }}" class="{{ link_class }}">{{ item.link_text }}</a><#
				}
			#></div><!-- /.sc_price_item_info --><#
			if (item.bg_image.url != '' || item.bg_color != '') {
				#></div><!-- /.sc_price_item_inner --><#
			}
			// Link over whole block - if 'link' is not empty and 'link_text' is empty
			if (item.link.url != '' && item.link_text == '') {
				#><a href="{{ item.link.url }}" class="{{ link_class_over }}"></a><#
			}
		#></div><!-- /.sc_price_item --><#

		if (settings.slider || settings.columns.size > 1) {
			#></div><!-- /.slider_slide || .column --><#
		}
	});

	#></div><!-- /.slider_slides || .sc_price_columns_wrap || sc_price_content_wrap --><#

	if (settings.slider) {
		#><?php $element->sc_show_slider_wrap_end('sc_price'); ?><#
	}

	#><?php $element->sc_show_links('sc_price'); ?>

</div><!-- /.sc_price -->