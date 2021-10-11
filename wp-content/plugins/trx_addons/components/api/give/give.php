<?php
/**
 * Plugin support: Give
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */



// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_give' ) ) {
	function trx_addons_exists_give() {
		return class_exists( 'Give' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_give_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_give_importer_required_plugins', 10, 2 );
	function trx_addons_give_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'give')!==false && !trx_addons_exists_give() )
			$not_installed .= '<br>' . esc_html__('Give', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_give_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_give_importer_set_options' );
	function trx_addons_give_importer_set_options($options=array()) {
		if ( trx_addons_exists_give() && in_array('give', $options['required_plugins']) ) {
		    $options['additional_options'][]	= 'give_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_give'] = str_replace('name.ext', 'give.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_give_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_give_importer_show_params', 10, 1 );
	function trx_addons_give_importer_show_params($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'give',
				'title' => esc_html__('Import Give', 'trx_addons'),
				'part' => 1
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_give_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_give_importer_import', 10, 2 );
	function trx_addons_give_importer_import($importer, $action) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			if ( $action == 'import_give' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('give', esc_html__('Give meta', 'trx_addons'));

			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_give_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_give_importer_check_row', 9, 4);
	function trx_addons_give_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'give')===false) return $flag;
		if ( trx_addons_exists_give() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('give_forms', 'give_payment'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_give_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_give_importer_import_fields', 10, 1 );
	function trx_addons_give_importer_import_fields($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'give', 
				'title' => esc_html__('Give meta', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_give_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_give_importer_export', 10, 1 );
	function trx_addons_give_importer_export($importer) {

		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir ('give.txt'), serialize( array(
				"give_donors"		=> $importer->export_dump("give_donors"),
				"give_formmeta"		=> $importer->export_dump("give_formmeta"),
				"give_logmeta"		=> $importer->export_dump("give_logmeta"),
				"give_logs"			=> $importer->export_dump("give_logs"),
				"give_paymentmeta"	=> $importer->export_dump("give_paymentmeta")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_give_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_give_importer_export_fields', 10, 1 );
	function trx_addons_give_importer_export_fields($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'give',
				'title' => esc_html__('Give', 'trx_addons')
				)
			);
		}
	}
}
?>