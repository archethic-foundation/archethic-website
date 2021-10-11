<?php
/**
 * The style "default" of the Iconed text
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

$args = get_query_var('trx_addons_args_sc_layouts_iconed_text');

?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_layouts_iconed_text<?php
		trx_addons_cpt_layouts_sc_add_classes($args);
	?>"<?php
	if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"'; ?>><?php

	// Open link
	if (!empty($args['link'])) {
		?><a href="<?php echo esc_url($args['link']); ?>" class="sc_layouts_item_link sc_layouts_iconed_text_link"><?php
	}
	
	// Icon or Image
	if (!empty($args['icon'])) {
		?><span class="sc_layouts_item_icon sc_layouts_iconed_text_icon <?php echo esc_attr($args['icon']); ?>"></span><?php
	}
	if (!empty($args['text1']) || !empty($args['text2'])) {
		?><span class="sc_layouts_item_details sc_layouts_iconed_text_details"><?php
			if (!empty($args['text1'])) {
				?><span class="sc_layouts_item_details_line1 sc_layouts_iconed_text_line1"><?php echo esc_html($args['text1']); ?></span><?php
			}
			if (!empty($args['text2'])) {
				?><span class="sc_layouts_item_details_line2 sc_layouts_iconed_text_line2"><?php echo esc_html($args['text2']); ?></span><?php
			}
		?></span><!-- /.sc_layouts_iconed_text_details --><?php
	}

	// Close link
	if (!empty($args['link'])) {
		?></a><?php
	}
?></div><!-- /.sc_layouts_iconed_text --><?php

trx_addons_sc_layouts_showed('iconed_text', true);
?>