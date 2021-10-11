<?php
/**
 * Plugin support: WPBakery Page Builder Extensions Bundle
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_vc_extensions' ) ) {
	function trx_addons_exists_vc_extensions() {
		return class_exists('Vc_Manager') && class_exists('VC_Extensions_CQBundle');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check VC Extensions in the required plugins
if ( !function_exists( 'trx_addons_vc_extensions_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_vc_extensions_importer_required_plugins', 10, 2 );
	function trx_addons_vc_extensions_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'vc-extensions-bundle')!==false && !trx_addons_exists_vc_extensions())
			$not_installed .= '<br>' . esc_html__('WPBakery Page Builder Extensions Bundle', 'trx_addons');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'trx_addons_vc_extensions_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_vc_extensions_importer_set_options' );
	function trx_addons_vc_extensions_importer_set_options($options=array()) {
		if ( trx_addons_exists_vc_extensions() && in_array('vc-extensions-bundle', $options['required_plugins']) ) {
			//$options['additional_options'][] = 'wpb_js_templates';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}
?>