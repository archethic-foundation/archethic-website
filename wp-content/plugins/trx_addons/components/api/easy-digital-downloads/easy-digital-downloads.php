<?php
/**
 * Plugin support: Easy Digital Downloads
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// -----------------------------------------------------------------
// -- Additional taxonomies and post's meta
// -----------------------------------------------------------------

if (!defined('TRX_ADDONS_EDD_PT')) define('TRX_ADDONS_EDD_PT', 'download');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_CATEGORY')) define('TRX_ADDONS_EDD_TAXONOMY_CATEGORY', 'download_category');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_MARKET')) define('TRX_ADDONS_EDD_TAXONOMY_MARKET', 'download_market');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_LABEL')) define('TRX_ADDONS_EDD_TAXONOMY_LABEL', 'download_label');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_TAG')) define('TRX_ADDONS_EDD_TAXONOMY_TAG', 'download_tag');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY') ) define('TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY', 'download_compatibility');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_BROWSERS') ) define('TRX_ADDONS_EDD_TAXONOMY_BROWSERS', 'download_browsers');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_PACKAGE') ) define('TRX_ADDONS_EDD_TAXONOMY_PACKAGE', 'download_package');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_PLUGINS') ) define('TRX_ADDONS_EDD_TAXONOMY_PLUGINS', 'download_plugins');


// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_edd' ) ) {
	function trx_addons_exists_edd() {
		return class_exists('Easy_Digital_Downloads');
	}
}
*/

// Return true, if current page is any edd page
if ( !function_exists( 'trx_addons_is_edd_page' ) ) {
	function trx_addons_is_edd_page() {
		$rez = trx_addons_exists_edd()
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_EDD_PT)
						|| is_post_type_archive(TRX_ADDONS_EDD_PT)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_CATEGORY)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_MARKET)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_LABEL)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_TAG)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_BROWSERS)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_PACKAGE)
						|| is_tax(TRX_ADDONS_EDD_TAXONOMY_PLUGINS)
						);
		return $rez;
	}
}


// Return taxonomy for current post type (this post_type have 2+ taxonomies)
if ( !function_exists( 'trx_addons_edd_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_edd_post_type_taxonomy', 10, 2 );
	function trx_addons_edd_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == TRX_ADDONS_EDD_PT)
			$tax = TRX_ADDONS_EDD_TAXONOMY_CATEGORY;
		return $tax;
	}
}

// Add EDD to the sc_cart in the layouts
if ( !function_exists( 'trx_addons_edd_add_cart_market' ) ) {
	add_filter( 'trx_addons_sc_cart_market', 'trx_addons_edd_add_cart_market', 10, 2);
	function trx_addons_edd_add_cart_market($list, $sc) {
		if ($sc == 'trx_sc_layouts_cart' && trx_addons_exists_edd())
			$list['edd'] = esc_html__('Easy Digital Downloads', 'trx_addons');
		return $list;
	}
}

// Add featured image to the cart item in EDD
if ( !function_exists( 'trx_addons_edd_add_cart_item_image' ) ) {
	add_filter( 'edd_cart_item', 'trx_addons_edd_add_cart_item_image', 10, 2);
	function trx_addons_edd_add_cart_item_image($item, $id = 0) {
		$item = str_replace( '&nbsp;@&nbsp;', '&nbsp;x&nbsp;', $item );
		if ($id > 0) {
			if (($image = trx_addons_get_attachment_url(get_post_thumbnail_id($id), trx_addons_get_thumb_size('tiny'))) != '') {
				$wrapper = '<li class="edd-cart-item">';
				$attr = trx_addons_getimagesize($image);
				$item = str_replace( $wrapper, $wrapper . '<span class="edd-cart-item-image"><img src="'.esc_url($image).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').' alt=""></span>', $item );
			}
		}
		return $item;
	}
}

// Add item to the current user menu
if ( !function_exists( 'trx_addons_edd_login_menu_settings' ) ) {
	add_action("trx_addons_action_login_menu_settings", 'trx_addons_edd_login_menu_settings');
	function trx_addons_edd_login_menu_settings() {
		if (trx_addons_exists_edd()) {
			$purchase_history = edd_get_option( 'purchase_history_page', 0 );
			if ( !empty( $purchase_history ) ) {
				?><li class="menu-item trx_addons_icon-basket"><a href="<?php echo esc_url(get_permalink( $purchase_history )); ?>"><span><?php esc_html_e('Purchase history', 'trx_addons'); ?></span></a></li><?php
			}
		}
	}
}

// Add hack on page 404 to prevent error message
if ( !function_exists( 'trx_addons_edd_create_empty_post_on_404' ) ) {
	add_action( 'wp_head', 'trx_addons_edd_create_empty_post_on_404', 1);
	function trx_addons_edd_create_empty_post_on_404() {
		if (is_404() && !isset($GLOBALS['post'])) {
			$GLOBALS['post'] = new stdClass();
			$GLOBALS['post']->ID = 0;
			$GLOBALS['post']->post_type = 'unknown';
			$GLOBALS['post']->post_content = '';
		}
	}
}



// Scripts and styles
//------------------------------------------------------------------------
	
// Merge specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_edd_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_edd_merge_styles');
	function trx_addons_edd_merge_styles($list) {
		if ( trx_addons_exists_edd() )
			$list[] = TRX_ADDONS_PLUGIN_API . 'easy-digital-downloads/_easy-digital-downloads.scss';
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_edd_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_edd_importer_required_plugins', 10, 2 );
	function trx_addons_edd_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'easy-digital-downloads')!==false && !trx_addons_exists_edd() )
			$not_installed .= '<br>' . esc_html__('Easy Digital Downloads', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_edd_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_edd_importer_set_options' );
	function trx_addons_edd_importer_set_options($options=array()) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $options['required_plugins']) ) {
			$options['additional_options'][] = 'edd_settings';					// Add slugs to export options for this plugin
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_edd'] = str_replace('name.ext', 'easy-digital-downloads.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_edd_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_edd_importer_show_params', 10, 1 );
	function trx_addons_edd_importer_show_params($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'edd',
				'title' => esc_html__('Import Easy Digital Downloads', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_edd_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_edd_importer_import', 10, 2 );
	function trx_addons_edd_importer_import($importer, $action) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			if ( $action == 'import_edd' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('easy-digital-downloads', esc_html__('Easy Digital Downloads meta', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_edd_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_edd_importer_check_row', 9, 4);
	function trx_addons_edd_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'easy-digital-downloads')===false) return $flag;
		if ( trx_addons_exists_edd() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('download', 'edd_log', 'edd_discount', 'edd_payment'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_edd_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_edd_importer_import_fields', 10, 1 );
	function trx_addons_edd_importer_import_fields($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'edd', 
				'title' => esc_html__('Easy Digital Downloads meta', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_edd_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_edd_importer_export', 10, 1 );
	function trx_addons_edd_importer_export($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('easy-digital-downloads.txt'), serialize( array(
				"edd_customers"		=> $importer->export_dump("edd_customers"),
				"edd_customermeta"	=> $importer->export_dump("edd_customermeta"),
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_edd_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_edd_importer_export_fields', 10, 1 );
	function trx_addons_edd_importer_export_fields($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'edd',
				'title' => esc_html__('Easy Digital Downloads', 'trx_addons')
				)
			);
		}
	}
}
?>