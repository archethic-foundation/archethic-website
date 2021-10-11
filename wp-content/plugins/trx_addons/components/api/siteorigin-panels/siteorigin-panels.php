<?php
/**
 * Plugin support: SiteOrigin Panels
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Check if plugin 'SiteOrigin Panels' is installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_sop' ) ) {
	function trx_addons_exists_sop() {
		return class_exists('SiteOrigin_Panels');
	}
}
*/

// Check if plugin 'SiteOrigin Widgets bundle' is installed and activated
if ( !function_exists( 'trx_addons_exists_sow' ) ) {
	function trx_addons_exists_sow() {
		return class_exists('SiteOrigin_Widgets_Bundle');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_sop_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_sop_importer_required_plugins', 10, 2 );
	function trx_addons_sop_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'siteorigin-panels')!==false && !trx_addons_exists_visual_composer())
			$not_installed .= '<br>' . esc_html__('SiteOrigin Panels', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_sop_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_sop_importer_set_options' );
	function trx_addons_sop_importer_set_options($options=array()) {
		if ( trx_addons_exists_sop() && in_array('siteorigin-panels', $options['required_plugins']) ) {
			$options['additional_options'][] = 'siteorigin_panels_settings';
			$options['additional_options'][] = 'siteorigin_widgets_active';
		}
		return $options;
	}
}


// Class to create our widgets
//------------------------------------------------------------------------
if (trx_addons_exists_sop() && trx_addons_exists_sow()) {
	abstract class TRX_Addons_SOW_Widget extends SiteOrigin_Widget {

		protected $sc_name = '';

		function __construct($id, $name, $widget_options = array(), $control_options = array(), $form_options = array(), $base_folder = false) {
			$this->sc_name = str_replace(array('trx_addons_widget_', 'trx_addons_sow_widget_'), 'trx_sc_', $id);
			parent::__construct($id, $name, $widget_options, $control_options, $form_options, $base_folder);
		}

		// Return shortcode's name
		function get_sc_name() {
			return $this->sc_name;
		}

		// Return widget's layout
		function get_html_content($instance, $args, $template_vars, $css_name) {
			$output = '';
			$func_name = str_replace('trx_sc_', 'trx_addons_sc_', $this->get_sc_name());
			if (function_exists($func_name)) {
				trx_addons_sc_stack_push('trx_sc_layouts');	// To prevent wrap shortcodes output to the '<div class="sc_layouts_item"></div>'
				$output = call_user_func($func_name, $this->sc_prepare_atts($instance, $this->sc_name));
				trx_addons_sc_stack_pop();
			}
			return $output;
		}

		// Prepare params for our shortcodes
		protected function sc_prepare_atts($atts, $sc='') {
			if (is_array($atts)) {
				foreach($atts as $k=>$v) {
					// Bubble params from SOW Sections to the root
					if (substr($k, 0, 12) == 'sow_section_') {
						foreach ($v as $k1=>$v1)
							$atts[$k1] = $v1;
					}
					// Add icon_type='sow' if attr 'icon' is present
					if (is_array($v)) {
						foreach ($v as $k1=>$v1) {
							if (is_array($v1)) {
								foreach ($v1 as $k2=>$v2) {
									if ($k2 == 'icon' && trx_addons_is_sow_icon($v2))
										$atts[$k][$k1]['icon_type'] = 'sow';
								}
							} else if ($k1 == 'icon' && trx_addons_is_sow_icon($v1))
								$atts[$k]['icon_type'] = 'sow';
						}
					} else if ($k == 'icon' && trx_addons_is_sow_icon($v))
						$atts['icon_type'] = 'sow';
				}
			}
			return apply_filters('trx_addons_filter_sow_sc_prepare_atts', $atts, $sc);
		}
	}
}

// Check if icon name is from the SOW icons
if ( !function_exists( 'trx_addons_is_sow_icon' ) ) {
	function trx_addons_is_sow_icon($icon) {
		list($family, $icon) = (!empty($icon) && strpos($icon, '-' ) !== false) ? explode( '-', $icon, 2 ) : array('', '');
		return !empty($family) && in_array($family, array(
			'elegantline',
			'fontawesome',
			'genericons',
			'icomoon',
			'typicons',
			'ionicons',
		));
	}
}

// Return SOW form params (if exists)
if ( !function_exists( 'trx_addons_get_sow_form_params' ) ) {
	function trx_addons_get_sow_form_params($widget_class) {
		// If open params in SOW Editor
		$vc_edit = is_admin() && trx_addons_get_value_gp('action')=='so_panels_widget_form' && trx_addons_get_value_gp('widget') == $widget_class;
		$vc_params = $vc_edit && isset($_POST['instance']) ? trx_addons_get_value_gp('instance') : array();
		if (!is_array($vc_params) && substr($vc_params, 0, 1) == '{') $vc_params = json_decode($vc_params, true);
		return array($vc_edit, $vc_params);
	}
}



// Shortcode's common params for SOW
//---------------------------------------------------------

// Return ID, Class
if ( !function_exists( 'trx_addons_sow_add_id_param' ) ) {
	function trx_addons_sow_add_id_param($group=false) {
		$params = array(
					// Common VC parameters
					'id' => array(
						"label" => esc_html__("Element ID", 'trx_addons'),
						"type" => "text"
					),
					'class' => array(
						"label" => esc_html__("Element CSS class", 'trx_addons'),
						"type" => "text"
					)
				);

		// Add param 'group' if not empty
		if ($group===false)
			$group = esc_html__('ID &amp; Class', 'trx_addons');
		if (!empty($group))
			$params = array(
				'sow_section_id' => array(
					'label' => $group,
					'hide' => true,
					'fields' => $params,
					'type' => 'section'
					)
				);

		return apply_filters('trx_addons_filter_sow_add_id_param', $params, $group);
	}
}

// Return slider params
if ( !function_exists( 'trx_addons_sow_add_slider_param' ) ) {
	function trx_addons_sow_add_slider_param($group=false, $add_params=array()) {
		$params = array(
					"slider" => array(
						"label" => esc_html__("Slider", 'trx_addons'),
						"default" => false,
						'state_emitter' => array(
							'callback' => 'conditional',
							'args'     => array(
								'use_slider[show]: val',
								'use_slider[hide]: ! val'
							),
						),
						"type" => "checkbox"
					),
					"slides_space" => array(
						"label" => esc_html__("Space", 'trx_addons'),
						"state_handler" => array(
							"use_slider[show]" => array('show'),
							"use_slider[hide]" => array('hide'),
						),
						"type" => "text"
					),
					"slider_controls" => array(
						"label" => esc_html__("Slider controls", 'trx_addons'),
						"state_handler" => array(
							"use_slider[show]" => array('show'),
							"use_slider[hide]" => array('hide'),
						),
						"default" => "none",
						"options" => trx_addons_get_list_sc_slider_controls(),
						"type" => "select"
					),
					"slider_pagination" => array(
						"label" => esc_html__("Slider pagination", 'trx_addons'),
						"state_handler" => array(
							"use_slider[show]" => array('show'),
							"use_slider[hide]" => array('hide'),
						),
						"default" => "none",
						"options" => trx_addons_get_list_sc_slider_paginations(),
						"type" => "select"
					)
				);

		// Additional params / Change default params
		if (is_array($add_params) && count($add_params) > 0) {
			foreach ($add_params as $k=>$v)
				$params[$k] = isset($params[$k]) ? array_merge($params[$k], $v) : $v;
		}

		// Add param 'group' if not empty
		if ($group===false)
			$group = esc_html__('Slider', 'trx_addons');
		if (!empty($group))
			$params = array(
				'sow_section_slider' => array(
					'label' => $group,
					'hide' => true,
					'fields' => $params,
					'type' => 'section'
					)
				);

		return apply_filters('trx_addons_filter_sow_add_slider_param', $params, $group, $add_params);
	}
}

// Return title params
if ( !function_exists( 'trx_addons_sow_add_title_param' ) ) {
	function trx_addons_sow_add_title_param($group=false, $button=true) {
		$params = array(
					"title_style" => array(
						"label" => esc_html__("Title style", 'trx_addons'),
						"default" => "default",
						"options" => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'title'), 'trx_sc_title' ),
						"type" => "select"
					),
					"title_tag" => array(
						"label" => esc_html__("Title tag", 'trx_addons'),
						"default" => "none",
						"options" => trx_addons_get_list_sc_title_tags(),
						"type" => "select"
					),
					"title_align" => array(
						"label" => esc_html__("Title alignment", 'trx_addons'),
						"default" => "none",
						"options" => trx_addons_get_list_sc_aligns(),
						"type" => "select"
					),
					"title" => array(
						"label" => esc_html__("Title", 'trx_addons'),
						"type" => "text"
					),
					"subtitle" => array(
						"label" => esc_html__("Subtitle", 'trx_addons'),
						"type" => "text"
					),
					"description" => array(
						"label" => esc_html__("Description", 'trx_addons'),
						"type" => "tinymce"
					),
				);
		
		// Add button's params
		if ($button)
			$params = array_merge($params, array(
					"link" => array(
						"label" => esc_html__("Button's URL", 'trx_addons'),
						"type" => "link"
					),
					"link_text" => array(
						"label" => esc_html__("Button's text", 'trx_addons'),
						"type" => "text"
					),
					'link_style' => array(
						'label' => esc_html__("Button's style", 'trx_addons'),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'button'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					),
					"link_image" => array(
						"label" => esc_html__("Button's image", 'trx_addons'),
						"type" => "media"
					)
				)
			);

		// Add param 'group' if not empty
		if ($group===false)
			$group = esc_html__('Titles', 'trx_addons');
		if (!empty($group))
			$params = array(
				'sow_section_title' => array(
					'label' => $group,
					'hide' => true,
					'fields' => $params,
					'type' => 'section'
					)
				);

		return apply_filters('trx_addons_filter_sow_add_title_param', $params, $group, $button);
	}
}

// Return query params
if ( !function_exists( 'trx_addons_sow_add_query_param' ) ) {
	function trx_addons_sow_add_query_param($group=false, $add_params=array(), $del_params=array()) {
		$params = array(
					"ids" => array(
						"label" => esc_html__("IDs to show", 'trx_addons'),
						'state_emitter' => array(
							'callback' => 'conditional',
							'args'     => array(
								'use_ids[show]: ! val',
								'use_ids[hide]: val'
							)
						),
						"type" => "text"
					),
					"count" => array(
						"label" => esc_html__("Count", 'trx_addons'),
						'state_handler' => array(
							"use_ids[show]" => array('show'),
							"use_ids[hide]" => array('hide')
						),
						"type" => "number"
					),
					"columns" => array(
						"label" => esc_html__("Columns", 'trx_addons'),
						"type" => "number"
					),
					"offset" => array(
						"label" => esc_html__("Offset", 'trx_addons'),
						'state_handler' => array(
							"use_ids[show]" => array('show'),
							"use_ids[hide]" => array('hide')
						),
						"type" => "number"
					),
					"orderby" => array(
						"label" => esc_html__("Order by", 'trx_addons'),
						"options" => trx_addons_get_list_sc_query_orderby(),
						"default" => "none",
						"type" => "select"
					),
					"order" => array(
						"label" => esc_html__("Order", 'trx_addons'),
						"options" => trx_addons_get_list_sc_query_orders(),
						"default" => "asc",
						"type" => "select"
					)
				);

		// Additional params / Change default params
		if (is_array($add_params) && count($add_params) > 0) {
			foreach ($add_params as $k=>$v)
				$params[$k] = array_merge($params[$k], $v);
		}

		// Remove params
		if (is_array($del_params) && count($del_params) > 0) {
			foreach ($del_params as $v)
				if (isset($params[$v])) unset($params[$v]);
		}

		// Add param 'group' if not empty
		if ($group===false)
			$group = esc_html__('Query', 'trx_addons');
		if (!empty($group))
			$params = array(
				'sow_section_query' => array(
					'label' => $group,
					'hide' => true,
					'fields' => $params,
					'type' => 'section'
					)
				);

		return apply_filters('trx_addons_filter_sow_add_query_param', $params, $group, $add_params, $del_params);
	}
}

// Return hide_on_mobile param
if ( !function_exists( 'trx_addons_sow_add_hide_param' ) ) {
	function trx_addons_sow_add_hide_param($group=false, $hide_on_frontpage=false) {
		$params = array(
					"hide_on_desktop" => array(
						"label" => esc_html__("Hide on desktop", 'trx_addons'),
						"description" => wp_kses_data( __("Hide this item on desktops", 'trx_addons') ),
						"type" => "checkbox"
					),
					"hide_on_notebook" => array(
						"label" => esc_html__("Hide on notebooks", 'trx_addons'),
						"description" => wp_kses_data( __("Hide this item on notebooks", 'trx_addons') ),
						"type" => "checkbox"
					),
					"hide_on_tablet" => array(
						"label" => esc_html__("Hide on tablets", 'trx_addons'),
						"description" => wp_kses_data( __("Hide this item on tablets", 'trx_addons') ),
						"type" => "checkbox"
					),
					"hide_on_mobile" => array(
						"label" => esc_html__("Hide on mobile devices", 'trx_addons'),
						"description" => wp_kses_data( __("Hide this item on mobile devices", 'trx_addons') ),
						"type" => "checkbox"
					)
				);
		if ($hide_on_frontpage) {
			$params["hide_on_frontpage"] = array(
						"label" => esc_html__("Hide on Front page", 'trx_addons'),
						"description" => wp_kses_data( __("Hide this item on Front page", 'trx_addons') ),
						"type" => "checkbox"
					);
		}
		
		// Add param 'group' if not empty
		if (!empty($group))
			$params = array(
				'sow_section_hide' => array(
					'label' => $group,
					'hide' => true,
					'fields' => $params,
					'type' => 'section'
					)
				);

		return apply_filters('trx_addons_filter_sow_add_hide_param', $params, $group);
	}
}

// Return icon params
if ( !function_exists( 'trx_addons_sow_add_icon_param' ) ) {
	function trx_addons_sow_add_icon_param($group=false, $only_socials=false) {
		if (trx_addons_get_setting('icons_selector') == 'vc') {
			
			// Standard SOW icons selector
			$params = array(
						'icon' => array(
							'label' => __('Icon', 'trx_addons'),
							"description" => wp_kses_data( __("Select item's icon", 'trx_addons') ),
							'type' => 'icon'
						)
					);

		} else {

			// Internal popup with icons list
			$style = $only_socials ? trx_addons_get_setting('socials_type') : trx_addons_get_setting('icons_type');
			$params = array(
				"icon" => array(
					"label" => esc_html__("Icon", 'trx_addons'),
					"description" => wp_kses_data( __("Select icon", 'trx_addons') ),
					"options" => $style == 'icons' 
									? trx_addons_array_from_list(trx_addons_get_list_icons()) 
									: trx_addons_get_list_files($only_socials ? 'css/socials' : 'css/icons.png', 'png'),
					"style" => $style,
					"type" => "icons"
				)
			);

		}
		
		// Add param 'group' if not empty
		if ($group===false)
			$group = esc_html__('Icons', 'trx_addons');
		if (!empty($group))
			$params = array(
				'sow_section_icon' => array(
					'label' => $group,
					'hide' => true,
					'fields' => $params,
					'type' => 'section'
					)
				);

		return apply_filters('trx_addons_filter_sow_add_icon_param', $params, $group, $only_socials);
	}
}



// Custom param's types for SOW
//-----------------------------------------------------------------------
if (trx_addons_exists_sop() && trx_addons_exists_sow()) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'siteorigin-panels/params/select_dynamic/select_dynamic.php';
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'siteorigin-panels/params/icons/icons.php';
}
?>