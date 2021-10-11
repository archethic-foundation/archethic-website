<?php
/**
 * ThemeREX Addons Layouts: WPBakery Page Builder utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Add CPT 'Layouts' to the VC Editor default post_types
if (!function_exists('trx_addons_cpt_layouts_vc_setup')) {
	add_action( 'init', 'trx_addons_cpt_layouts_vc_setup', 1000 );
	function trx_addons_cpt_layouts_vc_setup() {
		if (is_admin() && current_user_can('manage_options') && function_exists('vc_editor_set_post_types')) {
			$list = vc_editor_post_types();
			if (is_array($list) && !in_array(TRX_ADDONS_CPT_LAYOUTS_PT, $list)) {
				$list[] = TRX_ADDONS_CPT_LAYOUTS_PT;
				vc_editor_set_post_types($list);
			}
		}
	}
}


// Init VC support
if (!function_exists('trx_addons_cpt_layouts_vc_init')) {
	add_action( 'init', 'trx_addons_cpt_layouts_vc_init');
	function trx_addons_cpt_layouts_vc_init() {

		// Row type
		$param = array(
			"param_name" => "row_type",
			"heading" => esc_html__("Row type", 'trx_addons'),
			"description" => wp_kses_data( __("Select row type to decorate header widgets. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"admin_label" => true,
			"value" => array_flip(trx_addons_get_list_sc_layouts_row_types()),
			"std" => "inherit",
			"type" => "dropdown"
		);
		vc_add_param("vc_row", $param);
		vc_add_param("vc_row_inner", $param);

		// Delimiter after the row
		$param = array(
			"param_name" => "row_delimiter",
			"heading" => esc_html__("Delimiter", 'trx_addons'),
			"description" => wp_kses_data( __("Show delimiter after the row", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"admin_label" => true,
			"std" => "0",
			"value" => array(esc_html__("Show delimiter", 'trx_addons') => "1" ),
			"type" => "checkbox"
		);
		vc_add_param("vc_row", $param);
		vc_add_param("vc_row_inner", $param);
		
		// Fix row when scroll
		$param = array(
			"param_name" => "row_fixed",
			"heading" => esc_html__("Fix this row when scroll", 'trx_addons'),
			"description" => wp_kses_data( __("Fix this row to the top of the window when scrolling down", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			'edit_field_class' => 'vc_col-sm-4',
			"admin_label" => true,
			"std" => "0",
			"value" => array(
						esc_html__("Don't fix", 'trx_addons') => "0",
						esc_html__("Fix on large screen ", 'trx_addons') => "1",
						esc_html__("Fix always", 'trx_addons') => "2"
						),
			"type" => "radio"
		);
		vc_add_param("vc_row", $param);
		
		// Hide row on xxx
		$params = trx_addons_vc_add_hide_param(esc_html__('Custom Layouts', 'trx_addons'), true);
		foreach ($params as $param)
			vc_add_param("vc_row", $param);

		// Alignment inner items in the column
		$param = array(
			"param_name" => "column_align",
			"heading" => esc_html__("Column alignment", 'trx_addons'),
			"description" => wp_kses_data( __("Select alignment of the inner widgets in this column. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			"admin_label" => true,
			"value" => array_flip(trx_addons_get_list_sc_aligns(true, false)),
			"std" => "inherit",
			"type" => "dropdown"
		);
		vc_add_param("vc_column", $param);
		vc_add_param("vc_column_inner", $param);
		
		// Icon's position in the inner items
		$param = array(
			"param_name" => "icons_position",
			"heading" => esc_html__("Icons position", 'trx_addons'),
			"description" => wp_kses_data( __("Select icons position of the inner widgets 'Layouts: xxx' in this column. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons') ),
			"group" => esc_html__('Custom Layouts', 'trx_addons'),
			"admin_label" => true,
			"value" => array_flip(trx_addons_get_list_sc_layouts_icons_positions()),
	        'save_always' => true,
			"type" => "dropdown"
		);
		vc_add_param("vc_column", $param);
		vc_add_param("vc_column_inner", $param);
		
		// Allow insert our container elements to the inner columns
		vc_map_update('vc_column_inner', array('allowed_container_element' => true));
	}
}

// Add params to the standard VC shortcodes
if ( !function_exists( 'trx_addons_cpt_layouts_vc_add_params_classes' ) ) {
	add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'trx_addons_cpt_layouts_vc_add_params_classes', 10, 3 );
	function trx_addons_cpt_layouts_vc_add_params_classes($classes, $sc, $atts) {
		if (in_array($sc, array('vc_row', 'vc_row_inner'))) {
			if (!empty($atts['row_type']) && !trx_addons_is_inherit($atts['row_type']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row sc_layouts_row_type_' . $atts['row_type'];
			if (!empty($atts['row_delimiter']) && !trx_addons_is_inherit($atts['row_delimiter']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row_delimiter';
			if ($sc == 'vc_row' && !empty($atts['row_fixed']) && !trx_addons_is_inherit($atts['row_fixed']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row_fixed' . ($atts['row_fixed'] > 1 ? ' sc_layouts_row_fixed_always' : '');
			if ($sc == 'vc_row' && !empty($atts['hide_on_desktop']) && !trx_addons_is_inherit($atts['hide_on_desktop']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_desktop';
			if ($sc == 'vc_row' && !empty($atts['hide_on_notebook']) && !trx_addons_is_inherit($atts['hide_on_notebook']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_notebook';
			if ($sc == 'vc_row' && !empty($atts['hide_on_tablet']) && !trx_addons_is_inherit($atts['hide_on_tablet']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_tablet';
			if ($sc == 'vc_row' && !empty($atts['hide_on_mobile']) && !trx_addons_is_inherit($atts['hide_on_mobile']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_mobile';
			if ($sc == 'vc_row' && !empty($atts['hide_on_frontpage']) && !trx_addons_is_inherit($atts['hide_on_frontpage']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_hide_on_frontpage';
		} else if (in_array($sc, array('vc_column', 'vc_column_inner'))) {
			if (!empty($atts['column_align']) && !trx_addons_is_inherit($atts['column_align']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_column sc_layouts_column_align_' . $atts['column_align'];
			if (!empty($atts['icons_position']) && !trx_addons_is_inherit($atts['icons_position']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_column_icons_position_' . $atts['icons_position'];
		}
		return $classes;
	}
}

// Generate content to show layout
//------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_vc_layout_content' ) ) {
	add_filter( 'trx_addons_filter_sc_layout_content', 'trx_addons_cpt_layouts_vc_layout_content', 11, 2 );
	function trx_addons_cpt_layouts_vc_layout_content($content, $post_id) {
		if (strpos($content, '[vc_row') !== false) {
			// In WordPress 4.9 post content wrapped with <p>...</p>
			// and shortcode_unautop() not remove it - do it manual
			if (strpos($content, '<p>[vc_row') !== false || strpos($content, '<p>[vc_section') !== false) {
				$content = str_replace(
								array('<p>[vc_row', '[/vc_row]</p>', '<p>[vc_section', '[/vc_section]</p>'),
								array('[vc_row', '[/vc_row]', '[vc_section', '[/vc_section]'),
								$content);
			}

			// Add VC custom styles to the inline CSS
			$vc_custom_css = get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );
			if ( !empty( $vc_custom_css ) ) trx_addons_add_inline_css(strip_tags(trx_addons_remove_protocol($vc_custom_css)));

			// Do shortcodes in the content
			$content = do_shortcode($content);
		}
		return $content;
	}
}


// One-click import support
//------------------------------------------------------------------------

// Export custom layouts
if ( !function_exists( 'trx_addons_cpt_layouts_vc_export_meta' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_cpt_layouts_export_meta', 'trx_addons_cpt_layouts_vc_export_meta', 10, 2 );
	function trx_addons_cpt_layouts_vc_export_meta($meta, $post) {
		$vc_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
		if (!empty($vc_custom_css))
			$meta['_wpb_shortcodes_custom_css'] = $vc_custom_css;
		return $meta;
	}
}
?>