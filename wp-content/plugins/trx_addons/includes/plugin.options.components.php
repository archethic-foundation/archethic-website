<?php
/**
 * Plugin's components setup
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Return true if component is allowed
if (!function_exists('trx_addons_components_is_allowed')) {
	function trx_addons_components_is_allowed($type, $slug, $key='') {
		static $options = false;
		if ($options === false)	$options = apply_filters('trx_addons_filter_load_options', get_option('trx_addons_options'));
		return !empty($options['components_'.$type.'_'.$slug])
				? (is_array($options['components_'.$type.'_'.$slug])
					? !empty($options['components_'.$type.'_'.$slug][$key])
					: true)
				: false;
	}
}


// Return list of allowed layouts
if (!function_exists('trx_addons_components_get_allowed_layouts')) {
	function trx_addons_components_get_allowed_layouts($type, $slug, $layout='sc') {
		global $TRX_ADDONS_STORAGE;
		$list = isset($TRX_ADDONS_STORAGE[$type.'_list'][$slug]['layouts_'.$layout]) 
					? $TRX_ADDONS_STORAGE[$type.'_list'][$slug]['layouts_'.$layout]
					: array();
		if (is_array($list)) {
			$first = array();
			foreach ($list as $key => $name) {
				if (count($first) == 0)
					$first[$key] = $name;
				if (!trx_addons_components_is_allowed($type, $slug.'_layouts_'.$layout, $key))
					unset($list[$key]);
			}
			if (count($list) == 0)
				$list = $first;
		}
		return $list;
	}
}


// Add tab 'Components' to the plugin's options
if (!function_exists('trx_addons_components_init')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_components_init', 1 );
	function trx_addons_components_init($options) {
		if (is_admin() && apply_filters('trx_addons_filter_components_editor', false)) {
			global $TRX_ADDONS_STORAGE;
			
			// Section 'Components'
			$components = array(
/*
				'components_section' => array(
					"title" => esc_html__('Components', 'trx_addons'),
					"desc" => wp_kses_data( __('Select framework components to use with current theme', 'trx_addons') ),
					"type" => "section"
				),
*/
				'components_present' => array(
					"title" => esc_html__('Components present', 'trx_addons'),
					"desc" => wp_kses_data( __('Components settings are present in the options', 'trx_addons') ),
					"std" => 1,
					"type" => "hidden"
				)
			);
			
			$blocks = apply_filters('trx_addons_filter_components_blocks', array());

			// Components and layouts
			foreach ($blocks as $type=>$title) {
				$components['components_'.$type.'_info'] = array(
					"title" => esc_html($title, 'trx_addons'),
					"desc" => wp_kses_data( sprintf(__('Select required %s and their layouts', 'trx_addons'), $title) ),
					"type" => "info"
				);
				foreach ($TRX_ADDONS_STORAGE[$type.'_list'] as $k=>$v) {
					if (!empty($v['slave'])) continue;
					if (empty($v['title'])) $v['title'] = ucfirst(str_replace('_', ' ', $k));
					$components['components_'.$type.'_'.$k] = array(
						"title" => $v['title'],
						"desc" => '',
						"std" => !empty($v['std']) ? $v['std'] : 0,
						"type" => 'checkbox'
					);
					if (!empty($v['hidden']))
						$components['components_'.$type.'_'.$k]['hidden'] = true;
					if (isset($v['layouts_arh']) && count($v['layouts_arh']) > 1) {
						if (!empty($v['hidden'])) {
							$std = array();
							foreach ($v['layouts_arh'] as $k1 => $v1)
								$std[$k1] = 1;
						} else
							$std = array(trx_addons_array_get_first($v['layouts_arh']) => 1);
						$components['components_'.$type.'_'.$k.'_layouts_arh'] = array(
							"title" => sprintf(__('%s archive layouts', 'trx_addons'), $v['title']),
							"title_class" => 'trx_addons_options_item_subtitle',
							"desc" => '',
							"dependency" => array(
								'components_'.$type.'_'.$k => '1'
							),
							"dir" => 'horizontal',
							"sortable" => false,
							"std" => $std,
							"options" => $v['layouts_arh'],
							"type" => "checklist"
						);
						if (!empty($v['hidden']))
							$components['components_'.$type.'_'.$k.'_layouts_arh']['hidden'] = true;
					}
					if (isset($v['layouts_sc']) && count($v['layouts_sc']) > 1) {
						if (!empty($v['hidden'])) {
							$std = array();
							foreach ($v['layouts_sc'] as $k1 => $v1)
								$std[$k1] = 1;
						} else
							$std = array(trx_addons_array_get_first($v['layouts_sc']) => 1);
						$components['components_'.$type.'_'.$k.'_layouts_sc'] = array(
							"title" => sprintf(__('%s shortcode layouts', 'trx_addons'), $v['title']),
							"title_class" => 'trx_addons_options_item_subtitle',
							"desc" => '',
							"dependency" => array(
								'components_'.$type.'_'.$k => '1'
							),
							"dir" => 'horizontal',
							"sortable" => false,
							"std" => $std,
							"options" => $v['layouts_sc'],
							"type" => "checklist"
						);
						if (!empty($v['hidden']))
							$components['components_'.$type.'_'.$k.'_layouts_sc']['hidden'] = true;
					}
				}
			}
			$options = trx_addons_array_merge($options, $components);
		}
		return $options;
	}
}


// One-click import support
//------------------------------------------------------------------------

// Export components
if ( !function_exists( 'trx_addons_components_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export', 'trx_addons_components_importer_export', 10, 1 );
	function trx_addons_components_importer_export($importer) {
		$options = apply_filters('trx_addons_filter_load_options', get_option('trx_addons_options'));
		$output = '';
		if (is_array($options) && count($options) > 0) {
			$output = "<?php"
						. "\n//" . esc_html__('Allowed components', 'trx_addons')
						. "\n\$components = array(";
			$counter = 0;
			foreach ($options as $k=>$v) {
				if (strpos($k, 'components_') === 0) {
					$output .= ($counter++ ? ',' : '') 
								. "\n\t\t'{$k}' => ";
					if (is_array($v)) {
						$output .= "array(";
						$counter1 = 0;
						foreach ($v as $k1=>$v1) {
							$output .= ($counter1++ ? ',' : '') 
										. "\n\t\t\t\t'{$k1}' => {$v1}";
						}
						$output .= "\n\t\t\t\t)";
					} else
						$output .= "{$v}";
				}
			}
			$output .= "\n\t\t);"
						. "\n?>";
		}
		trx_addons_fpc($importer->export_file_dir('components.txt'), $output);
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_components_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_components_importer_export_fields', 11, 1 );
	function trx_addons_components_importer_export_fields($importer) {
		$importer->show_exporter_fields(array(
			'slug'	=> 'components',
			'title' => esc_html__('Allowed components', 'trx_addons'),
			'download' => 'trx_addons-components.php'
			)
		);
	}
}
