<?php
/**
 * Shortcode: Content container
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */


// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_content_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_content_merge_styles');
	function trx_addons_sc_content_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'content/_content.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_content_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_content_merge_styles_responsive');
	function trx_addons_sc_content_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'content/_content.responsive.scss';
		return $list;
	}
}


// trx_sc_content
//-------------------------------------------------------------
/*
[trx_sc_content id="unique_id" width="1/2"]
*/
if ( !function_exists( 'trx_addons_sc_content' ) ) {
	function trx_addons_sc_content($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_content', $atts, array(
			// Individual params
			'type' => 'default',
			"width" => "",
			"size" => "none",
			"float" => 'center',
			"align" => "",
			"paddings" => "",
			"margins" => "",
			"push" => "",
			"push_hide_on_tablet" => 0,
			"push_hide_on_mobile" => 0,
			"pull" => "",
			"pull_hide_on_tablet" => 0,
			"pull_hide_on_mobile" => 0,
			"extra_bg" => "none",
			"extra_bg_mask" => 0,
			"shift_x" => "none",
			"shift_y" => "none",
			"number" => "",
			"number_position" => "br",
			"number_color" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_style" => 'default',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		
		$output = '';

		if (empty($atts['width']) && !empty($atts['size'])) $atts['width'] = $atts['size'];
		if (empty($atts['width']) && !empty($atts['content_width'])) $atts['width'] = $atts['content_width'];
		
		$atts['content'] = do_shortcode($content);
		
		if (!empty($atts['content']) || !empty($atts['title']) || !empty($atts['subtitle']) || !empty($atts['description'])) {

			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'content/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'content/tpl.default.php'
											),
                                            'trx_addons_args_sc_content', 
                                            $atts
                                        );
			$output = ob_get_contents();
			ob_end_clean();

		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_content', $atts, $content);
	}
}


// Add [trx_sc_content] in the VC shortcodes list
if (!function_exists('trx_addons_sc_content_add_in_vc')) {
	function trx_addons_sc_content_add_in_vc() {
		
		add_shortcode("trx_sc_content", "trx_addons_sc_content");
		add_shortcode("trx_sc_content_inner", "trx_addons_sc_content");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_content", 'trx_addons_sc_content_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Content extends WPBakeryShortCodesContainer {}
		
		vc_lean_map("trx_sc_content_inner", 'trx_addons_sc_content_inner_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Content_Inner extends WPBakeryShortCodesContainer {}
		
	}
	add_action('init', 'trx_addons_sc_content_add_in_vc', 20);
}

// Return params for 'section'
if (!function_exists('trx_addons_sc_content_inner_add_in_vc_params')) {
	function trx_addons_sc_content_inner_add_in_vc_params() {
		return trx_addons_sc_content_add_in_vc_params('content_inner');
	}
}

// Return params
if (!function_exists('trx_addons_sc_content_add_in_vc_params')) {
	function trx_addons_sc_content_add_in_vc_params($type='content') {
		$args = apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_content",
				"name" => esc_html__("Content area", 'trx_addons'),
				"description" => wp_kses_data( __("Limit content width inside the fullwide rows", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_content',
				"class" => "trx_sc_content",
				'content_element' => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_sc_content,trx_sc_content_inner'),
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'content'), 'trx_sc_content')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "size",	// Attention! Param 'width' is reserved by VC
							"heading" => esc_html__("Size", 'trx_addons'),
							"description" => wp_kses_data( __("Select size of the block", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
					        'save_always' => true,
							"value" => array_flip(trx_addons_get_list_sc_content_widths()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "paddings",
							"heading" => esc_html__("Inner paddings", 'trx_addons'),
							"description" => wp_kses_data( __("Select paddings around of the inner text in the block", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array_flip(trx_addons_get_list_sc_content_paddings_and_margins()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "margins",
							"heading" => esc_html__("Outer margin", 'trx_addons'),
							"description" => wp_kses_data( __("Select margin around of the block", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array_flip(trx_addons_get_list_sc_content_paddings_and_margins()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "float",
							"heading" => esc_html__("Block alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment (floating position) of the block", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"value" => array_flip(trx_addons_get_list_sc_aligns()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Text alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment of the inner text in the block", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"value" => array_flip(trx_addons_get_list_sc_aligns(false, true, true)),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "push",
							"heading" => esc_html__("Push block up", 'trx_addons'),
							"description" => wp_kses_data( __("Push this block up, so that it partially covers the previous block", 'trx_addons') ),
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6 vc_new_row',
							"value" => array_flip(trx_addons_get_list_sc_content_push_and_pull()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "push_hide_on_tablet",
							"heading" => esc_html__("On tablet", 'trx_addons'),
							"description" => wp_kses_data( __("Disable push on the tablets", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-3',
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							"std" => "0",
							'dependency' => array(
								'element' => 'push',
								'value' => array('tiny', 'small', 'medium', 'large')
							),
							"value" => array(esc_html__("Disable on tablet", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "push_hide_on_mobile",
							"heading" => esc_html__("On mobile", 'trx_addons'),
							"description" => wp_kses_data( __("Disable push on the mobile", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-3',
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							"std" => "0",
							'dependency' => array(
								'element' => 'push',
								'value' => array('tiny', 'small', 'medium', 'large')
							),
							"value" => array(esc_html__("Disable on mobile", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "pull",
							"heading" => esc_html__("Pull next block up", 'trx_addons'),
							"description" => wp_kses_data( __("Pull next block up, so that it partially covers this block", 'trx_addons') ),
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6 vc_new_row',
							"value" => array_flip(trx_addons_get_list_sc_content_push_and_pull()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "pull_hide_on_tablet",
							"heading" => esc_html__("On tablet", 'trx_addons'),
							"description" => wp_kses_data( __("Disable pull on the tablets", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-3',
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							"std" => "0",
							'dependency' => array(
								'element' => 'pull',
								'value' => array('^none')
							),
							"value" => array(esc_html__("Disable on tablet", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "pull_hide_on_mobile",
							"heading" => esc_html__("On mobile", 'trx_addons'),
							"description" => wp_kses_data( __("Disable pull on the mobile", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-3',
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							"std" => "0",
							'dependency' => array(
								'element' => 'pull',
								'value' => array('^none')
							),
							"value" => array(esc_html__("Disable on mobile", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "shift_x",
							"heading" => esc_html__("The X-axis shift", 'trx_addons'),
							"description" => wp_kses_data( __("Shift this block along the X-axis", 'trx_addons') ),
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6 vc_new_row',
							"value" => array_flip(trx_addons_get_list_sc_content_shift()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "shift_y",
							"heading" => esc_html__("The Y-axis shift", 'trx_addons'),
							"description" => wp_kses_data( __("Shift this block along the Y-axis", 'trx_addons') ),
							"group" => esc_html__('Push & Pull', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array_flip(trx_addons_get_list_sc_content_shift()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "number",
							"heading" => esc_html__("Number", 'trx_addons'),
							"description" => wp_kses_data( __("Number to display in the corner of this area", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"group" => esc_html__('Number', 'trx_addons'),
							"type" => "textfield"
						),
						array(
							"param_name" => "number_position",
							"heading" => esc_html__("Number position", 'trx_addons'),
							"description" => wp_kses_data( __("Select position to display number", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"group" => esc_html__('Number', 'trx_addons'),
							"std" => "br",
					        'save_always' => true,
							"value" => array_flip(trx_addons_get_list_sc_positions()),
							"type" => "dropdown"
						),
						array(
							'param_name' => 'number_color',
							'heading' => esc_html__( 'Color of the number', 'trx_addons' ),
							'description' => esc_html__( 'Select custom color of the number', 'trx_addons' ),
							"group" => esc_html__('Number', 'trx_addons'),
							'type' => 'colorpicker'
						)
					),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param(),
					array(
						array(
							"param_name" => "extra_bg",
							"heading" => esc_html__("Entended background", 'trx_addons'),
							"description" => wp_kses_data( __("Extend background of this block", 'trx_addons') ),
							"group" => esc_html__('Design Options', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array_flip(trx_addons_get_list_sc_content_extra_bg()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "extra_bg_mask",
							"heading" => esc_html__("Background mask", 'trx_addons'),
							"description" => wp_kses_data( __("Specify opacity of the background color to use it as mask for the background image", 'trx_addons') ),
							"group" => esc_html__('Design Options', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array_flip(trx_addons_get_list_sc_content_extra_bg_mask()),
							"std" => "none",
							"type" => "dropdown"
						)
					)
				)
			), 'trx_sc_content' );
		if ($type == 'content_inner') {
			$args['base'] = 'trx_sc_content_inner';
			$args['name'] = esc_html__("Content area (inner)", 'trx_addons');
			$args['description'] = wp_kses_data( __("Inner content area (used inside other content area)", 'trx_addons') );
			$args['as_child'] = array('only' => 'trx_sc_content,vc_column_inner');
		}
		return $args;
	}
}
?>