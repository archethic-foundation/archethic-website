<?php
// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Define component's subfolder
if ( !defined('TRX_ADDONS_PLUGIN_IMPORTER') ) define('TRX_ADDONS_PLUGIN_IMPORTER', TRX_ADDONS_PLUGIN_COMPONENTS . 'importer/');

// Add component to the global list
if (!function_exists('trx_addons_importer_add_to_components')) {
	add_filter( 'trx_addons_components_list', 'trx_addons_importer_add_to_components' );
	function trx_addons_importer_add_to_components($list=array()) {
		$list['importer'] = array(
					'title' => __('Import/Export demo data', 'trx_addons'),
					'std' => 1,
					'hidden' => true
					);
		return $list;
	}
}

// Theme init
if (!function_exists('trx_addons_importer_theme_setup')) {
	add_action( 'after_setup_theme', 'trx_addons_importer_theme_setup' );
	function trx_addons_importer_theme_setup() {
		if (is_admin() && current_user_can('import')) {
			if (($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_IMPORTER . 'class.importer.php')) != '') { include_once $fdir; }
			new trx_addons_demo_data_importer();
		}
	}
}

if (!function_exists('trx_addons_importer_localize_script_admin')) {
	add_action( 'trx_addons_localize_script_admin', 'trx_addons_importer_localize_script_admin' );
	function trx_addons_importer_localize_script_admin($vars) {
		$vars['msg_importer_error'] = esc_html__('Errors that occurred during the import process:', 'trx_addons');
		return $vars;
	}
}
?>