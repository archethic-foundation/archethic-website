<?php
/**
 * The template to display start of the slider's wrap for some shortcodes
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.20
 */

extract(get_query_var('trx_addons_args_sc_show_slider_wrap'));

if (empty($args['slider_controls'])) $args['slider_controls'] = 'none';
if (empty($args['slider_pagination'])) $args['slider_pagination'] = 'none';
if (empty($args['slider_pagination_type'])) $args['slider_pagination_type'] = 'bullets';
if (empty($args['slides_space'])) $args['slides_space'] = 0;
if (empty($args['columns'])) $args['columns'] = 1;

?><div<?php
	   if (!empty($args['id'])) echo ' id="' . esc_attr($args['id']) . '_outer"';
	   ?> class="<?php echo esc_attr($sc); ?>_slider sc_item_slider slider_swiper_outer slider_outer<?php
			echo ' slider_outer_' . esc_attr(trx_addons_is_off($args['slider_controls']) 
						? 'nocontrols'
						: 'controls slider_outer_controls_' . esc_attr($args['slider_controls']))
				. ' slider_outer_' . esc_attr(trx_addons_is_off($args['slider_pagination']) 
						? 'nopagination'
						: 'pagination slider_outer_pagination_'.esc_attr($args['slider_pagination_type']).' slider_outer_pagination_pos_'.esc_attr($args['slider_pagination']))
				. ' slider_outer_' . esc_attr($args['columns']>1 
						? 'multi' 
						: 'one');
		?>">
	<div<?php
		if (!empty($args['id'])) echo ' id="' . esc_attr($args['id']) . '_swiper"';
		?> class="slider_container swiper-slider-container slider_swiper slider_noresize<?php
			echo ' slider_' . esc_attr(trx_addons_is_off($args['slider_controls']) 
						? 'nocontrols'
						: 'controls slider_controls_' . esc_attr($args['slider_controls']))
				. ' slider_' . esc_attr(trx_addons_is_off($args['slider_pagination']) 
						? 'nopagination'
						: 'pagination slider_pagination_'.esc_attr($args['slider_pagination_type']).' slider_pagination_pos_'.esc_attr($args['slider_pagination']))
				. ' slider_' . esc_attr($args['columns']>1 
						? 'multi' 
						: 'one');
			?>"<?php
			echo ($args['columns'] > 1 
					? ' data-slides-per-view="' . esc_attr($args['columns']) . '"' 
					: '')
				. ($args['slides_space'] > 0 
					? ' data-slides-space="' . esc_attr($args['slides_space']) . '"' 
					: '')
				. ' data-slides-min-width="' . (!empty($args['slides_min_width']) ? $args['slides_min_width'] : 150) . '"'
				. ' data-pagination="'.esc_attr($args['slider_pagination_type']).'"';
		?>>
		<div class="slides slider-wrapper swiper-wrapper sc_item_columns_<?php echo esc_attr($args['columns']); ?>">