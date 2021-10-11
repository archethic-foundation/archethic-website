<?php
/**
 * The style "default" of the Button
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.3
 */

$args = get_query_var('trx_addons_args_sc_button');

$args['css'] .= (!empty($args['bg_image']) ? 'background-image:url(' . esc_url($args['bg_image']) . ');' : '');

if (!trx_addons_is_off($args['align'])) {
?><div class="sc_item_button sc_button_wrap<?php if (!trx_addons_is_off($args['align'])) echo ' sc_align_'.esc_attr($args['align']); ?>"><?php
}
	?><a href="<?php echo esc_url($args['link']); ?>"<?php
		if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"';
		?> class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes',
											'sc_button sc_button_'.$args['type']
												. (!empty($args['class']) ? ' '.$args['class'] : '')
        	                                    . (!empty($args['size']) ? ' sc_button_size_'.$args['size'] : '')
            	                                . (!empty($args['bg_image']) ? ' sc_button_bg_image' : '')
                	                            . (!empty($args['image']) ? ' sc_button_with_image' : '')
                    	                        . (!empty($args['icon']) ? ' sc_button_with_icon' : '')
                        	                    . (!empty($args['icon_position']) ? ' sc_button_icon_'.$args['icon_position'] : ''),
                                            'sc_button', $args)); ?>"<?php
		if (!empty($args['new_window'])) echo ' target="_blank"';
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php
	
	// Icon or Image
	if (!empty($args['image']) || !empty($args['icon'])) {
		?><span class="sc_button_icon"><?php
			if (!empty($args['image'])) {
				$attr = trx_addons_getimagesize($args['image']);
				?><img class="sc_icon_as_image" src="<?php echo esc_url($args['image']); ?>" alt=""<?php echo (!empty($attr[3]) ? ' '.trim($attr[3]) : ''); ?>><?php
			} else if (trx_addons_is_url($args['icon'])) {
				$attr = trx_addons_getimagesize($args['icon']);
				?><img class="sc_icon_as_image" src="<?php echo esc_url($args['icon']); ?>" alt=""<?php echo (!empty($attr[3]) ? ' '.trim($attr[3]) : ''); ?>><?php
			} else if (!empty($args['icon_type']) && $args['icon_type'] == 'sow') {
				echo siteorigin_widget_get_icon($args['icon']);
			} else {
				?><span class="<?php echo esc_attr($args['icon']); ?>"></span><?php
			}
		?></span><?php
	}
	if (!empty($args['title']) || !empty($args['subtitle'])) {
		?><span class="sc_button_text<?php if (!trx_addons_is_off($args['text_align'])) echo ' sc_align_'.esc_attr($args['text_align']); ?>"><?php
			if (!empty($args['subtitle'])) {
				?><span class="sc_button_subtitle"><?php echo esc_html($args['subtitle']); ?></span><?php
			}
			if (!empty($args['title'])) {
				?><span class="sc_button_title"><?php echo esc_html($args['title']); ?></span><?php
			}
		?></span><!-- /.sc_button_text --><?php
	}
?></a><!-- /.sc_button --><?php
if (!trx_addons_is_off($args['align'])) {
?></div><!-- /.sc_item_button --><?php
}