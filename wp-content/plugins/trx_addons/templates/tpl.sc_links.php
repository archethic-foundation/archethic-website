<?php
/**
 * The template to display shortcode's link
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

extract(get_query_var('trx_addons_args_sc_show_links'));

$align = !empty($args['title_align']) ? ' sc_align_'.trim($args['title_align']) : '';
if (!empty($args['link_image']) && ($args['link_image'] = trx_addons_get_attachment_url($args['link_image'], trx_addons_get_thumb_size('medium')))!='') {
	$attr = trx_addons_getimagesize($args['link_image']);
	?><div class="<?php echo esc_attr($sc); ?>_button_image sc_item_button_image<?php echo esc_attr($align); ?>"><?php
		if (!empty($args['link'])) {
			?><a href="<?php echo esc_url($args['link']); ?>"><?php
		}
		?><img src="<?php echo esc_url($args['link_image']); ?>" alt=""<?php echo (!empty($attr[3]) ? ' '.trim($attr[3]) : ''); ?>><?php
		if (!empty($args['link'])) {
			?></a><?php
		}
	?></div><?php
} else if (!empty($args['link']) && !empty($args['link_text'])) {
	if (empty($args['link_style'])) $args['link_style'] = 'default';
	trx_addons_show_layout(trx_addons_sc_button(apply_filters('trx_addons_filter_sc_item_button_args', array(
																	'type' => $args['link_style'],
																	'title' => $args['link_text'],
																	'link' => $args['link'],
																	'class' => 'sc_item_button sc_item_button_'.esc_attr($args['link_style']).' '.esc_attr($sc).'_button',
																	'align' => !empty($args['title_align']) ? $args['title_align'] : 'none'
																	),
																	$sc, $args
														)
											)
					);
}
