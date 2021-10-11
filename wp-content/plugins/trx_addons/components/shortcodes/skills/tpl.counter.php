<?php
/**
 * The style "counter" of the Skills
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_skills');

$icon_present = '';
$data = '';

foreach ($args['values'] as $v) {
	$icon = !empty($v['icon_type']) && !empty($v['icon_' . $v['icon_type']]) && $v['icon_' . $v['icon_type']] != 'empty' 
				? $v['icon_' . $v['icon_type']] 
				: '';
	if (!empty($icon)) {
		if (strpos($icon_present, $v['icon_type'])===false)
			$icon_present .= (!empty($icon_present) ? ',' : '') . $v['icon_type'];
	} else {
		if (!empty($v['icon']) && strtolower($v['icon'])!='none') $icon = $v['icon'];
	}
	$img = '';
	if (!empty($icon) && trx_addons_is_url($icon)) {
		$img = $icon;
		$icon = basename($icon);
	}
	$ed = substr($v['value'], -1)=='%' ? '%' : '';
	$value = str_replace('%', '', $v['value']);
	$percent = round($value / $args['max'] * 100);
	$start = 0;
	$stop = $value;
	$steps = 100;
	$step = max(1, $args['max']/$steps);
	$speed = mt_rand(10,40);
	$animation = round(($stop - $start) / $step * $speed);
	$item_color = !empty($v['color']) ? $v['color'] : (!empty($args['color']) ? $args['color'] : '');
	$data .= ($args['columns'] > 0 ? '<div class="sc_skills_column '.esc_attr(trx_addons_get_column_class(1, $args['columns'])).'">' : '')
			. '<div class="sc_skills_item_wrap">'
				. '<div class="sc_skills_item">'
					. (!empty($icon) 
						? (!empty($v['icon_type']) && $v['icon_type'] == 'sow'
							? siteorigin_widget_get_icon($icon)
							: '<div class="sc_skills_icon '.esc_attr($icon).'">'
								. (!empty($img)
									? '<img class="sc_icon_as_image" src="'.esc_url($img).'" alt="">'
									: '')
								. '</div>'
							)
						: '')
					. '<div class="sc_skills_total"'
						. ' data-start="'.esc_attr($start).'"'
						. ' data-stop="'.esc_attr($stop).'"'
						. ' data-step="'.esc_attr($step).'"'
						. ' data-max="'.esc_attr($args['max']).'"'
						. ' data-speed="'.esc_attr($speed).'"'
						. ' data-duration="'.esc_attr($animation).'"'
						. ' data-ed="'.esc_attr($ed).'"'
						. (!empty($item_color) ? ' style="color: '.esc_attr($item_color).'"' : '')
						. '>'
						. ($start) . ($ed)
					. '</div>'
				. '</div>'
				. (!empty($v['title']) ? '<div class="sc_skills_item_title">'.nl2br(str_replace('|', "\n", esc_html($v['title']))).'</div>' : '')
			. '</div>'
		. ($args['columns'] > 0 ? '</div>' : '');
}

?><div id="<?php echo esc_attr($args['id']); ?>"
		class="sc_skills sc_skills_counter<?php echo !empty($args['class']) ? ' '.esc_attr($args['class']) : ''; ?>"
		<?php echo !empty($args['css']) ? ' style="'.esc_attr($args['css']).'"' : ''; ?>
		data-type="counter"
		><?php

		trx_addons_sc_show_titles('sc_skills', $args);
		
		if ($args['columns'] > 1) {
			?><div class="sc_skills_columns sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php
		}
		trx_addons_show_layout($data);
		if ($args['columns'] > 1) {
			?></div><?php
		}

		trx_addons_sc_show_links('sc_skills', $args);
		
?></div><?php

trx_addons_load_icons($icon_present);
?>