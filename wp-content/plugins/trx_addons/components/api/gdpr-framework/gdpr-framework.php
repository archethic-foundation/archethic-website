<?php
/**
 * Plugin support: The GDPR Framework
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_gdpr_framework' ) ) {
	function trx_addons_exists_gdpr_framework() {
		return defined( 'GDPR_FRAMEWORK_VERSION' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_gdpr_framework_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_gdpr_framework_importer_required_plugins', 10, 2 );
	function trx_addons_gdpr_framework_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'gdpr-framework')!==false && !trx_addons_exists_gdpr_framework() )
			$not_installed .= '<br>' . esc_html__('The GDPR Framework', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_gdpr_framework_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_gdpr_framework_importer_set_options' );
	function trx_addons_gdpr_framework_importer_set_options($options=array()) {
		if ( trx_addons_exists_mailchimp() && in_array('gdpr-framework', $options['required_plugins']) ) {
			if (is_array($options)) {
				$options['additional_options'][] = 'gdpr_%';
			}
		}
		return $options;
	}
}




// OCDI support
//------------------------------------------------------------------------

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_feed_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_gdpr_framework_feed_set_options' );
	function trx_addons_ocdi_gdpr_framework_feed_set_options($ocdi_options){
		$ocdi_options['import_gdpr-framework_file_url'] = 'gdpr-framework.txt';
		return $ocdi_options;		
	}
}

// Export plugin's data
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_export' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_gdpr_framework_export' );
	function trx_addons_ocdi_gdpr_framework_export($output){
		$list = array();
		if (trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database
			$options = array('gdpr_%');
			$list = trx_addons_ocdi_export_options($options, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/gdpr-framework.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('The GDPR Framework', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_import_field' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_gdpr_framework_import_field' );
	function trx_addons_ocdi_gdpr_framework_import_field($output){
		$list = array();
		if (trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="gdpr-framework" value="gdpr-framework">'. esc_html__( 'The GDPR Framework', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import plugin's data
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_gdpr_framework_import', 10, 1 );
	function trx_addons_ocdi_gdpr_framework_import( $import_plugins){
		if (trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', $import_plugins)) {
			trx_addons_ocdi_import_dump('gdpr-framework');
			echo esc_html__('The GDPR Framework import complete.', 'trx_addons') . "\r\n";
		}
	}
}
