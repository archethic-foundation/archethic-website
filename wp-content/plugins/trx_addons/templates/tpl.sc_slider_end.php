<?php
/**
 * The template to display end of the slider's wrap for some shortcodes
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.20
 */

extract(get_query_var('trx_addons_args_sc_show_slider_wrap'));

if (empty($args['slider_controls'])) $args['slider_controls'] = 'none';
if (empty($args['slider_pagination'])) $args['slider_pagination'] = 'none';

$controls = '<div class="slider_controls_wrap">'
				. '<a class="slider_prev swiper-button-prev" href="#"></a>'
				. '<a class="slider_next swiper-button-next" href="#"></a>'
			. '</div>';
$pagination = '<div class="slider_pagination_wrap swiper-pagination">'
				. (!empty($args['slider_pagination_buttons']) ? $args['slider_pagination_buttons'] : '')
			. '</div>';

if (in_array($args['slider_controls'], apply_filters('trx_addons_filter_slider_controls_inside', array('side'), $args))) trx_addons_show_layout($controls);
if (in_array($args['slider_pagination'], apply_filters('trx_addons_filter_slider_pagination_inside', array('left', 'right'), $args))) trx_addons_show_layout($pagination);

?></div><?php	//slider-swiper

if (in_array($args['slider_controls'], apply_filters('trx_addons_filter_slider_controls_outside', array('top', 'bottom'), $args))) trx_addons_show_layout($controls);
if (in_array($args['slider_pagination'], apply_filters('trx_addons_filter_slider_pagination_outside', array('bottom', 'bottom_outside'), $args))) trx_addons_show_layout($pagination);

?></div><?php	//slider-swiper-outer

?>