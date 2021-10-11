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

extract(get_query_var('trx_addons_args_sc_skills'));
?><#
var id = settings._element_id ? settings._element_id + '_sc' : 'sc_skills_'+(''+Math.random()).replace('.', ''),
	column_class = "<?php echo esc_attr(trx_addons_get_column_class(1, '##')); ?>",
	legend = '',
	data = '';

if (settings.max == '') {
	settings.max = 0;
	_.each(settings.values, function(item) {
		var value = (''+item.value).replace('%', '');
		if (settings.max < value) settings.max = value;
	});
} else
	settings.max = (''+settings.max).replace('%', '');

settings.columns = settings.compact == 0 
						? (settings.columns.size < 1 
							? settings.values.length
							: Math.min(settings.columns.size, settings.values.length)
							)
						: 1;

settings.cutout = Math.min(100, Math.max(0, settings.cutout.size));
settings.compact = settings.compact < 1 ? 0 : 1;

_.each(settings.values, function(item) {
	var icon = item.icon, img = '';
	if (typeof item.icon_type == 'undefined') item.icon_type = '';
	if (icon != '') {
		if (icon.indexOf('//') >= 0) {
			img = icon;
			icon = trx_addons_get_basename(icon);
			item.icon_type = 'image';
		}
	}
	var ed = (''+item.value).substr(-1)=='%' ? '%' : '',
		value = (''+item.value).replace('%', ''),
		percent = Math.round(value / settings.max * 100),
		start = 0,
		stop = value,
		steps = 100,
		step = Math.max(1, settings.max / steps),
		speed = Math.round(10 + Math.random()* 30),
		animation = Math.round((stop - start) / step * speed),
		item_color = item.color != '' 
						? item.color 
						: (settings.color!='' 
							? settings.color 
							: (settings.type == 'pie' 
								? '#efa758' 
								: ''
								)
							),
		bg_color = settings.bg_color != '' 
						? settings.bg_color 
						: '#f7f7f7',
		border_color = settings.border_color != '' 
						? settings.border_color 
						: '';
	
	if (settings.type == 'pie') {

		if (settings.compact == 1) {
			legend += '<div class="sc_skills_legend_item">'
							+ '<span class="sc_skills_legend_marker" style="background-color:' + item_color + '"></span>'
							+ '<span class="sc_skills_legend_title">' + item.title + '</span>'
							+ '<span class="sc_skills_legend_value">' + item.value + '</span>'
						+ '</div>';
			data += '<div class="pie"'
						+ ' data-start="' + start + '"'
						+ ' data-stop="' + stop + '"'
						+ ' data-step="' + step + '"'
						+ ' data-steps="' + steps + '"'
						+ ' data-max="' + settings.max + '"'
						+ ' data-speed="' + speed + '"'
						+ ' data-duration="' + animation + '"'
						+ ' data-color="' + item_color + '"'
						+ ' data-bg_color="' + bg_color + '"'
						+ ' data-border_color="' + border_color + '"'
						+ ' data-cutout="' + settings.cutout + '"'
						+ ' data-easing="easeOutCirc"'
						+ ' data-ed="' + ed + '"'
				+ '>'
					+ '<input type="hidden" class="text" value="' + item.title + '" />'
					+ '<input type="hidden" class="percent" value="' + percent + '" />'
					+ '<input type="hidden" class="color" value="' + item_color + '" />'
				+ '</div>';

		} else {
		
			var item_id = 'sc_skills_canvas_' + (''+Math.random()).replace('.','');
			data += (settings.columns > 0 ? '<div class="sc_skills_column ' + column_class.replace('##', settings.columns) + '">' : '')
					+ '<div class="sc_skills_item_wrap">'
						+ '<div class="sc_skills_item">'
							+ '<canvas id="' + item_id + '"></canvas>'
							+ '<div class="sc_skills_total"'
								+ ' data-start="' + start + '"'
								+ ' data-stop="' + stop + '"'
								+ ' data-step="' + step + '"'
								+ ' data-steps="' + steps + '"'
								+ ' data-max="' + settings.max + '"'
								+ ' data-speed="' + speed + '"'
								+ ' data-duration="' + animation + '"'
								+ ' data-color="' + item_color + '"'
								+ ' data-bg_color="' + bg_color + '"'
								+ ' data-border_color="' + border_color + '"'
								+ ' data-cutout="' + settings.cutout + '"'
								+ ' data-easing="easeOutCirc"'
								+ ' data-ed="' + ed + '">'
								+ start + ed
							+ '</div>'
						+ '</div>'
						+ (item.title != '' 
								? '<div class="sc_skills_item_title">'
										+ (icon != ''
											? '<span class="sc_skills_icon ' + icon + '">'
												+ (img != ''
													? '<img class="sc_icon_as_image" src="' + img + '" alt="">'
													: '')
												+ '</span>'
											: '') 
										+ item.title.replace(/\|/g, '\n').replace(/\n/g, '<br>')
									+ '</div>' 
								: '')
					+ '</div>'
				+ (settings.columns > 0 ? '</div>' : '');
		}

	} else {

		data += (settings.columns > 0 ? '<div class="sc_skills_column ' + column_class.replace('##', settings.columns) + '">' : '')
				+ '<div class="sc_skills_item_wrap">'
					+ '<div class="sc_skills_item">'
						+ (icon != ''
							? '<span class="sc_skills_icon ' + icon + '">'
								+ (img != ''
									? '<img class="sc_icon_as_image" src="' + img + '" alt="">'
									: '')
								+ '</span>'
							: '') 
						+ '<div class="sc_skills_total"'
							+ ' data-start="' + start + '"'
							+ ' data-stop="' + stop + '"'
							+ ' data-step="' + step + '"'
							+ ' data-max="' + settings.max + '"'
							+ ' data-speed="' + speed + '"'
							+ ' data-duration="' + animation + '"'
							+ ' data-ed="' + ed + '"'
							+ (item_color != '' ? ' style="color: ' + item_color + ';"' : '')
							+ '>'
							+ start + ed
						+ '</div>'
					+ '</div>'
					+ (item.title != '' ? '<div class="sc_skills_item_title">' + item.title.replace(/\|/g, '\n').replace(/\n/g, '<br>') + '</div>' : '')
				+ '</div>'
			+ (settings.columns > 0 ? '</div>' : '');
	}
});


if (settings.type == 'pie') {
	#><div id="{{ id }}"
		class="sc_skills sc_skills_pie sc_skills_compact_<# print(settings.compact>0 ? 'on' : 'off'); #>"
		data-type="pie"><#
} else {
	#><div id="{{ id }}"
		class="sc_skills sc_skills_counter"
		data-type="counter"><#
}

	#><?php $element->sc_show_titles('sc_skills'); ?><#

	if (settings.columns > 1) {
		#><div class="sc_skills_columns sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><#
	}
	if (settings.type == 'pie' && settings.compact == 1) {
		#><div class="sc_item_content sc_skills_content">
			<div class="sc_skills_legend">{{{ legend }}}</div>
			<div id="{{ id }}_pie_item" class="sc_skills_item">
				<canvas id="{{ id }}_pie" class="sc_skills_pie_canvas"></canvas>
				<div class="sc_skills_data" style="display:none;">{{{ data }}}</div>
			</div>
		</div><#
	} else {
		print(data);
	}

	if (settings.columns > 1) {
		#></div><#
	}

	#><?php $element->sc_show_links('sc_skills'); ?>

</div>