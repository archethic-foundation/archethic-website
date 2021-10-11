<?php
/**
 * Plugin support: M Chart
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

if (!defined('TRX_ADDONS_CHART_CPT_CHART'))			define('TRX_ADDONS_CHART_CPT_CHART', 			'm-chart');

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_m_chart' ) ) {
	function trx_addons_exists_m_chart() {
		return function_exists('m_chart');
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_m_chart_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_m_chart_importer_required_plugins', 10, 2 );
	function trx_addons_m_chart_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'm-chart')!==false && !trx_addons_exists_m_chart() )
			$not_installed .= '<br>' . esc_html__('M Chart', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_m_chart_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_m_chart_importer_set_options' );
	function trx_addons_m_chart_importer_set_options($options=array()) {
		if ( trx_addons_exists_m_chart() && in_array('m-chart', $options['required_plugins']) ) {
			$options['additional_options'][] = 'm-chart';				// Add slugs to export options for this plugin
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_m_chart_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_m_chart_importer_show_params', 10, 1 );
	function trx_addons_m_chart_importer_show_params($importer) {
		if ( trx_addons_exists_m_chart() && in_array('m-chart', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'm-chart',
				'title' => esc_html__('Import M Chart', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_m_chart_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_m_chart_importer_check_row', 9, 4);
	function trx_addons_m_chart_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'm-chart')===false) return $flag;
		if ( trx_addons_exists_m_chart() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array(TRX_ADDONS_CHART_CPT_CHART));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_m_chart_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_m_chart_importer_import_fields', 10, 1 );
	function trx_addons_m_chart_importer_import_fields($importer) {
		if ( trx_addons_exists_m_chart() && in_array('m-chart', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'m-chart',
				'title' => esc_html__('M Chart', 'trx_addons')
				)
			);
		}
	}
}

?>