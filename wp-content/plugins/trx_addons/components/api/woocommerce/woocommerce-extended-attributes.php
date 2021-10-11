<?php
/**
 * Plugin support: WooCommerce Extended Attributes
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */


// Init attributes hooks
if (!function_exists('trx_addons_woocommerce_attrib_init')) {
	add_action('init',	'trx_addons_woocommerce_attrib_init');
	function trx_addons_woocommerce_attrib_init() {
		if (!trx_addons_exists_woocommerce()) return;
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( !empty($attribute_taxonomies) ) {
			foreach ( $attribute_taxonomies as $attribute ) {
				$tax = wc_attribute_taxonomy_name($attribute->attribute_name);
				add_action($tax.'_edit_form_fields', 'trx_addons_woocommerce_attrib_show_custom_fields', 10, 1);
				add_action($tax.'_add_form_fields', 'trx_addons_woocommerce_attrib_show_custom_fields', 10, 1);
				add_action('edited_'.$tax,	'trx_addons_woocommerce_attrib_save_custom_fields', 10, 1 );
				add_action('created_'.$tax,	'trx_addons_woocommerce_attrib_save_custom_fields', 10, 1 );
				add_filter('manage_edit-'.$tax.'_columns',	'trx_addons_woocommerce_attrib_add_custom_column', 9);
				add_action('manage_'.$tax.'_custom_column',	'trx_addons_woocommerce_attrib_fill_custom_column', 9, 3);
			}
		}
	}
}

// Add new attribute's types to the list
if ( !function_exists( 'trx_addons_woocommerce_attrib_add_types' ) ) {
	add_filter( 'product_attributes_type_selector',	'trx_addons_woocommerce_attrib_add_types' );
	function trx_addons_woocommerce_attrib_add_types($list=array()) {
		return array_merge($list, array(
									'color' => esc_html__('Color', 'trx_addons'),
									'image' => esc_html__('Image', 'trx_addons'),
									'button' => esc_html__('Button', 'trx_addons')
									)
							);
	}
}

// Check if taxomony is a Woocommerce product's attribute
if (!function_exists('trx_addons_woocommerce_attrib_get_type')) {
	add_action('init',	'trx_addons_woocommerce_attrib_get_type');
	function trx_addons_woocommerce_attrib_get_type($taxonomy) {
		if (!trx_addons_exists_woocommerce()) return;
		$type = '';
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( !empty($attribute_taxonomies) ) {
			foreach ( $attribute_taxonomies as $attribute ) {
				if ( wc_attribute_taxonomy_name($attribute->attribute_name) == $taxonomy ) {
					$type = $attribute->attribute_type;
					break;
				}
			}
		}
		return $type;
	}
}

// Return type's name of the Woocommerce product's attribute param
if (!function_exists('trx_addons_woocommerce_attrib_get_type_name')) {
	function trx_addons_woocommerce_attrib_get_type_name($type) {
		if ($type == 'image')		return __('Image', 'trx_addons');
		else if ($type == 'color')	return __('Color', 'trx_addons');
		else if ($type == 'button')	return __('Button', 'trx_addons');
		else if ($type == 'select') return __('Select', 'trx_addons');
		else 				 		return __('Text', 'trx_addons');
	}
}

// Add the fields to the "pa_xxx" taxonomy, using our callback function
if (!function_exists('trx_addons_woocommerce_attrib_show_custom_fields')) {
	//Hook of the add_action('pa_xxx_edit_form_fields',	'trx_addons_woocommerce_attrib_show_custom_fields', 10, 1 );
	//Hook of the add_action('pa_xxx_add_form_fields',	'trx_addons_woocommerce_attrib_show_custom_fields', 10, 1 );
	function trx_addons_woocommerce_attrib_show_custom_fields($term) {
		$term_id = !empty($term->term_id) ? $term->term_id : 0;
		$taxonomy = (int) $term_id > 0 ? $term->taxonomy : $term;
		$type = trx_addons_woocommerce_attrib_get_type($taxonomy);
		if (empty($type) || !in_array($type, array('color', 'image'))) return;
		$term_val = $term_id == 0 ? '' : trx_addons_get_term_meta($term_id); 
		$field_name = "trx_addons_{$taxonomy}_{$type}";
		echo ((int) $term_id > 0 ? '<tr' : '<div') . ' class="form-field">'
			. ((int) $term_id > 0 ? '<th valign="top" scope="row">' : '<div>');
		?><label for="<?php echo esc_attr($field_name); ?>"><?php echo esc_html(trx_addons_woocommerce_attrib_get_type_name($type)); ?>:</label><?php
		echo ((int) $term_id > 0 ? '</th>' : '</div>')
			. ((int) $term_id > 0 ? '<td valign="top">' : '<div>');
		if ($type == 'image') {
			?><input type="text" class="trx_addons_thumb_selector_field" id="<?php echo esc_attr($field_name); ?>" name="<?php echo esc_attr($field_name); ?>" value="<?php echo esc_url($term_val); ?>"><?php
			if (empty($term_val)) $term_val = apply_filters('trx_addons_filter_no_thumb', trx_addons_get_file_url('css/images/no-thumb.gif'));
			trx_addons_show_layout(trx_addons_options_show_custom_field($field_name.'_button', array('type' => 'mediamanager', 'linked_field_id' => $field_name), $term_val));
		} else if ($type == 'color') {
			?><input type="text" class="trx_addons_color_selector" name="<?php echo esc_attr($field_name); ?>" value="<?php echo esc_attr($term_val); ?>"><?php
		}
		echo (int) $term_id > 0 ? '</td></tr>' : '</div></div>';
	}
}

// Save the fields to the "pa_xxx" taxonomy, using our callback function
if (!function_exists('trx_addons_woocommerce_attrib_save_custom_fields')) {
	//Hook of the add_action('edited_pa_xxx',	'trx_addons_woocommerce_attrib_save_custom_fields', 10, 1 );
	//Hook of the add_action('created_pa_xxx',	'trx_addons_woocommerce_attrib_save_custom_fields', 10, 1 );
	function trx_addons_woocommerce_attrib_save_custom_fields($term_id) {
		$taxonomy = str_replace(array('edited_', 'created_'), '' , current_action());
		$type = trx_addons_woocommerce_attrib_get_type($taxonomy);
		if (empty($type)) return;
		$field_name = "trx_addons_{$taxonomy}_{$type}";
		if (isset($_POST[$field_name])) trx_addons_set_term_meta($term_id, $_POST[$field_name]);
	}
}

// Create additional column for the 'pa_xxx' taxonomy
if (!function_exists('trx_addons_woocommerce_attrib_add_custom_column')) {
	//Hook of the add_filter('manage_edit-pa_xxx_columns',	'trx_addons_woocommerce_attrib_add_custom_column', 9);
	function trx_addons_woocommerce_attrib_add_custom_column( $columns ){
		$taxonomy = str_replace(array('manage_edit-', '_columns'), '' , current_action());
		$type = trx_addons_woocommerce_attrib_get_type($taxonomy);
		if (in_array($type, array('color', 'image'))) 
			$columns['pa_extended_attribute'] = esc_html(trx_addons_woocommerce_attrib_get_type_name($type));
		return $columns;
	}
}

// Fill custom column in the 'pa_xxx' taxonomy list
if (!function_exists('trx_addons_woocommerce_attrib_fill_custom_column')) {
	//Hook of the add_action('manage_pa_xxx_custom_column',	'trx_addons_woocommerce_attrib_fill_custom_column', 9, 3);
	function trx_addons_woocommerce_attrib_fill_custom_column($output='', $column_name='', $tax_id=0) {
		if ($column_name == 'pa_extended_attribute' && ($val = trx_addons_get_term_meta($tax_id))) {
			$taxonomy = str_replace(array('manage_', '_custom_column'), '' , current_action());
			$type = trx_addons_woocommerce_attrib_get_type($taxonomy);
			if ($type == 'image') {
				?><img class="trx_addons_thumb_selector_preview" src="<?php echo esc_url(trx_addons_add_thumb_size($val, trx_addons_get_thumb_size('tiny'))); ?>" alt=""><?php
			} else if ($type == 'color') {
				?><div class="trx_addons_color_selector_preview" style="background-color:<?php echo esc_attr($val); ?>"></div><?php
			}
		}
	}
}

// Show custom attributes on the 'Attributes' tab in WooCommerce
if (!function_exists('trx_addons_woocommerce_attrib_add_fields_to_attributes_tab')) {
	add_action('woocommerce_product_option_terms',	'trx_addons_woocommerce_attrib_add_fields_to_attributes_tab', 10, 2);
	function trx_addons_woocommerce_attrib_add_fields_to_attributes_tab( $attribute_taxonomy, $i ){
		if ( in_array($attribute_taxonomy->attribute_type, array('image', 'color', 'button')) ) {
			global $thepostid;
			?><select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'trx_addons' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $i; ?>][]">
				<?php
				$args = array(
						'orderby'    => 'name',
						'hide_empty' => 0
						);
				$all_terms = get_terms( wc_attribute_taxonomy_name($attribute_taxonomy->attribute_name), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
				if ( is_array($all_terms) ) {
					foreach ( $all_terms as $term ) {
						echo '<option value="' 
								. esc_attr(version_compare(WOOCOMMERCE_VERSION, '3.0', '<') ? $term->term_slug : $term->term_id) . '" ' 
								. selected( has_term( absint( $term->term_id ), wc_attribute_taxonomy_name($attribute_taxonomy->attribute_name), $thepostid ), true, false ) 
								. '>' 
									. esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) 
								. '</option>';
					}
				}
			?></select>
			<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'trx_addons' ); ?></button>
			<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'trx_addons' ); ?></button>
			<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'trx_addons' ); ?></button>
			<?php
		}
	}
}

// Show custom attributes on the Single product post
if (!function_exists('trx_addons_woocommerce_attrib_show_single_product')) {
	add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'trx_addons_woocommerce_attrib_show_single_product', 10, 2 );
	function trx_addons_woocommerce_attrib_show_single_product( $html, $args ){
		$type = trx_addons_woocommerce_attrib_get_type($args['attribute']);
		if ( in_array($type, array('image', 'color', 'button')) ) {
			$output = '';
			if ( $args['show_option_none'] ) {
				$no_img = $type=='image' ? apply_filters('trx_addons_filter_no_thumb', trx_addons_get_file_url('css/images/no-thumb.gif')) : '';
				$output .= '<span class="trx_addons_attrib_item trx_addons_attrib_'.esc_attr($type).' trx_addons_tooltip' 
									. (sanitize_title( $args['selected'] ) == '' ? ' trx_addons_attrib_selected' : '') 
									. '"'
									. ' data-value=""'
									. ' data-tooltip="' . esc_attr($args['show_option_none']) . '"'
									. '>'
									. '<span>'
										. ($type=='image'
												? '<img src="' . esc_url($no_img) . '" alt="' . esc_attr($args['show_option_none']) . '">'
												: ($type=='button' ? esc_html($args['show_option_none']) : '')
											)
									. '</span>'
							. '</span>';
			}
			if ( !empty( $args['options'] ) ) {
				if ( $args['product'] && taxonomy_exists( $args['attribute'] ) ) {
					// Get terms if this is a taxonomy - ordered. We need the names too.
					$terms = wc_get_product_terms( $args['product']->get_id(), $args['attribute'], array( 'fields' => 'all' ) );
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $args['options'] ) ) {
							$term_val = trx_addons_get_term_meta($term->term_id);
							if ($type=='image') 
								$term_val = empty($term_val) ? $no_img : trx_addons_add_thumb_size($term_val, trx_addons_get_thumb_size('tiny'));
							else if ($type == 'color')
								$term_val = empty($term_val) ? $term->slug : $term_val;
							$output .= '<span class="trx_addons_attrib_item trx_addons_attrib_'.esc_attr($type).' trx_addons_tooltip'
												. (sanitize_title( $args['selected'] ) == $term->slug ? ' trx_addons_attrib_selected' : '') 
												. '"'
												. ' data-value="' . esc_attr($term->slug) . '"'
												. ' data-tooltip="' . esc_attr($term->name) . '"'
												. '>'
												. '<span' . ($type=='color' ? ' style="background-color:'.esc_attr($term_val).';"' : '') . '>'
													. ($type=='image'
															? '<img src="' . esc_url($term_val) . '" alt="' . esc_attr($term->name) . '">'
															: ($type=='button' ? esc_html($term->name) : '')
														)
												. '</span>'
										. '</span>';
						}
					}
				}
			}
			if ($output) {
				$html = str_replace('<select ', '<select class="trx_addons_attrib_'.esc_html($type).'" style="display:none;" ', $html);
				$html .= '<div id="' . esc_attr( $args['id'] ? $args['id'] : sanitize_title( $args['attribute'] ) ) . '_attrib_extended"'
							. ' class="' . esc_attr( $args['class'] ? $args['class'] : sanitize_title( $args['attribute'] ) ) . '_attrib_extended trx_addons_attrib_extended"'
							. ' data-attrib="' . esc_attr($args['attribute']) . '">'
							. $output
						. '</div>';
			}
		}
		return $html;
	}
}
?>