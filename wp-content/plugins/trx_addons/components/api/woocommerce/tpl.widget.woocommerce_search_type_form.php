<?php
/**
 * The style "form" of the Widget "WooCommerce Search"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

$trx_addons_args = get_query_var('trx_addons_args_widget_woocommerce_search');
extract($trx_addons_args);

$params = trx_addons_widget_woocommerce_search_query_params($trx_addons_args['fields']);

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);
	
// Widget body
$form_style = $trx_addons_args['style'] = empty($trx_addons_args['style']) || trx_addons_is_inherit($trx_addons_args['style']) 
			? trx_addons_get_option('input_hover') 
			: $trx_addons_args['style'];
?><div
	<?php if (!empty($trx_addons_args['id'])) echo ' id="'.esc_attr($trx_addons_args['id']).'"'; ?>
	class="sc_form trx_addons_woocommerce_search trx_addons_woocommerce_search_type_<?php 
		echo esc_attr($trx_addons_args['type']);
		if (!empty($trx_addons_args['class'])) echo ' '.esc_attr($trx_addons_args['class']);
		?>"<?php
	if (!empty($trx_addons_args['css'])) echo ' style="'.esc_attr($trx_addons_args['css']).'"'; 
?>>
	<form class="trx_addons_woocommerce_search_form sc_form_form sc_form_custom <?php if ($form_style != 'default') echo 'sc_input_hover_'.esc_attr($form_style); ?>" action="<?php echo esc_url(trx_addons_woocommerce_get_shop_page_link()); ?>" method="get"><?php
		// Fields
		if (is_array($trx_addons_args['fields'])) {
			$not_empty = false;
			foreach ($trx_addons_args['fields'] as $fld) {
				if (trx_addons_is_off($fld['filter'])) continue;
				$tax_name = $fld['filter'];
				if (!trx_addons_is_off($params[$tax_name]))
					$not_empty = true;
				if (!in_array($tax_name, array('s', 'min_price', 'max_price'))) {
					$tax_obj = get_taxonomy($tax_name);
					$list = trx_addons_array_merge(
								array( ($tax_name == 'product_cat' ? '' : 0) => esc_html(sprintf(__('- %s -', 'trx_addons'), $tax_obj->label))),
								trx_addons_get_list_terms(false,
														$tax_name,
														array(
															'hide_empty' => 1,
															'return_key' => 'slug'
															)
														)
								);
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      	=> true,
																'field_title'  	=> $fld['text'],
																'field_name'  	=> $tax_name,
																'field_value' 	=> $params[$tax_name],
																'field_req'   	=> false,
																'field_options'  => $list,
																'field_type'  	=> 'select'
																))
												);
				} else {
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      	=> true,
																'field_title'  	=> $fld['text'],
																'field_name'  	=> $tax_name,
																'field_value' 	=> $params[$tax_name],
																'field_req'   	=> false,
																'field_type'  	=> 'text'
																))
												);
				}
			}
		}
		
		if (!empty($trx_addons_args['last_text'])) {
			?><label class="trx_addons_woocommerce_search_last_text"><?php echo esc_html($trx_addons_args['last_text']); ?></label><?php
		}

		// Basic Submit button
		?><button class="trx_addons_woocommerce_search_button trx_addons_icon-search"<?php if (!$not_empty) echo 'disable="disable"'; ?>><?php echo esc_attr(!empty($trx_addons_args['button_text']) ? $trx_addons_args['button_text'] : __('Start search', 'trx_addons')); ?></button>

	</form>
</div><!-- /.sc_form --><?php

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>