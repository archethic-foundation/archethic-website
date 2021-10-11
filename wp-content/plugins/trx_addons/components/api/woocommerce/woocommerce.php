<?php
/**
 * Plugin support: WooCommerce
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_woocommerce' ) ) {
	function trx_addons_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}
*/

// Return true, if current page is any woocommerce page
if ( !function_exists( 'trx_addons_is_woocommerce_page' ) ) {
	function trx_addons_is_woocommerce_page() {
		$rez = false;
		if (trx_addons_exists_woocommerce())
			$rez = is_woocommerce() || is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		return $rez;
	}
}


// Return taxonomy for current post type (this post_type have 2+ taxonomies)
if ( !function_exists( 'trx_addons_woocommerce_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_woocommerce_post_type_taxonomy', 10, 2 );
	function trx_addons_woocommerce_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == 'product')
			$tax = 'product_cat';
		return $tax;
	}
}

// Return link to main shop page for the breadcrumbs
if ( !function_exists( 'trx_addons_woocommerce_get_blog_all_posts_link' ) ) {
	add_filter('trx_addons_filter_get_blog_all_posts_link', 'trx_addons_woocommerce_get_blog_all_posts_link', 10, 2);
	function trx_addons_woocommerce_get_blog_all_posts_link($link='', $args=array()) {
		if (empty($link) && trx_addons_is_woocommerce_page() && !is_shop()) {
			if (($url = trx_addons_woocommerce_get_shop_page_link()) != '') {
				$id = trx_addons_woocommerce_get_shop_page_id();
				$link = '<a href="'.esc_url($url).'">'.($id ? get_the_title($id) : esc_html__('Shop', 'trx_addons')).'</a>';
			}
		}
		return $link;
	}
}

// Return shop page ID
if ( !function_exists( 'trx_addons_woocommerce_get_shop_page_id' ) ) {
	function trx_addons_woocommerce_get_shop_page_id() {
		return get_option('woocommerce_shop_page_id');
	}
}

// Return shop page link
if ( !function_exists( 'trx_addons_woocommerce_get_shop_page_link' ) ) {
	function trx_addons_woocommerce_get_shop_page_link() {
		$url = '';
		$id = trx_addons_woocommerce_get_shop_page_id();
		if ($id) $url = get_permalink($id);
		return $url;
	}
}

// Return current page title
if ( !function_exists( 'trx_addons_woocommerce_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'trx_addons_woocommerce_get_blog_title');
	function trx_addons_woocommerce_get_blog_title($title='') {
		if (trx_addons_exists_woocommerce() && trx_addons_is_woocommerce_page() && is_shop()) {
			$id = trx_addons_woocommerce_get_shop_page_id();
			$title = $id ? get_the_title($id) : esc_html__('Shop', 'trx_addons');
		}
		return $title;
	}
}
	
// Add item to the current user menu
if ( !function_exists( 'trx_addons_woocommerce_login_menu_settings' ) ) {
	add_action("trx_addons_action_login_menu_settings", 'trx_addons_woocommerce_login_menu_settings');
	function trx_addons_woocommerce_login_menu_settings() {
		if (trx_addons_exists_woocommerce()) {
			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( !empty( $myaccount_page_id ) ) {
				?><li class="menu-item trx_addons_icon-edit"><a href="<?php echo esc_url(get_permalink( $myaccount_page_id )); ?>"><span><?php esc_html_e('My account', 'trx_addons'); ?></span></a></li><?php
			}
		}
	}
}



// Load required scripts and styles
//------------------------------------------------------------------------


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_woocommerce_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_woocommerce_load_scripts_front', 11);
	function trx_addons_woocommerce_load_scripts_front() {
		if (trx_addons_exists_woocommerce() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script( 'trx_addons-woocommerce', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_woocommerce_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_woocommerce_merge_styles');
	function trx_addons_woocommerce_merge_styles($list) {
		if (trx_addons_exists_woocommerce())
			$list[] = TRX_ADDONS_PLUGIN_API . 'woocommerce/_woocommerce.scss';
		return $list;
	}
}

	
// Merge specific scripts into single file
if ( !function_exists( 'trx_addons_woocommerce_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_woocommerce_merge_scripts', 11);
	function trx_addons_woocommerce_merge_scripts($list) {
		if (trx_addons_exists_woocommerce())
			$list[] = TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.js';
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_woocommerce_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_woocommerce_importer_required_plugins', 10, 2 );
	function trx_addons_woocommerce_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'woocommerce')!==false && !trx_addons_exists_woocommerce() )
			$not_installed .= '<br>' . esc_html__('WooCommerce', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_woocommerce_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_woocommerce_importer_set_options' );
	function trx_addons_woocommerce_importer_set_options($options=array()) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'shop_%';					// Add slugs to export options for this plugin
			$options['additional_options'][]	= 'woocommerce_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_woocommerce'] = str_replace('name.ext', 'woocommerce.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Setup WooC pages after import posts complete
if ( !function_exists( 'trx_addons_woocommerce_importer_after_import_posts' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_after_import_posts',	'trx_addons_woocommerce_importer_after_import_posts', 10, 1 );
	function trx_addons_woocommerce_importer_after_import_posts($importer) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$wooc_pages = array(						// Options slugs and pages titles for WooCommerce pages
				'woocommerce_shop_page_id' 				=> 'Shop',
				'woocommerce_cart_page_id' 				=> 'Cart',
				'woocommerce_checkout_page_id' 			=> 'Checkout',
				'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
				'woocommerce_thanks_page_id' 			=> 'Order Received',
				'woocommerce_myaccount_page_id' 		=> 'My Account',
				'woocommerce_edit_address_page_id'		=> 'Edit My Address',
				'woocommerce_view_order_page_id'		=> 'View Order',
				'woocommerce_change_password_page_id'	=> 'Change Password',
				'woocommerce_logout_page_id'			=> 'Logout',
				'woocommerce_lost_password_page_id'		=> 'Lost Password'
			);
			foreach ($wooc_pages as $woo_page_name => $woo_page_title) {
				$woopage = get_page_by_title( $woo_page_title );
				if (!empty($woopage->ID)) {
					update_option($woo_page_name, $woopage->ID);
				}
			}
			// We no longer need to install pages
			delete_option( '_wc_needs_pages' );
			delete_transient( '_wc_activation_redirect' );
		}
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_woocommerce_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_woocommerce_importer_show_params', 10, 1 );
	function trx_addons_woocommerce_importer_show_params($importer) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'woocommerce',
				'title' => esc_html__('Import WooCommerce', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_woocommerce_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_woocommerce_importer_import', 10, 2 );
	function trx_addons_woocommerce_importer_import($importer, $action) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			if ( $action == 'import_woocommerce' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('woocommerce', esc_html__('WooCommerce meta', 'trx_addons'));
				delete_transient( 'wc_attribute_taxonomies' );
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_woocommerce_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_woocommerce_importer_check_row', 9, 4);
	function trx_addons_woocommerce_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'woocommerce')===false) return $flag;
		if ( trx_addons_exists_woocommerce() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('product', 'product_variation', 'shop_order', 'shop_order_refund', 'shop_coupon', 'shop_webhook'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_woocommerce_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_woocommerce_importer_import_fields', 10, 1 );
	function trx_addons_woocommerce_importer_import_fields($importer) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'woocommerce', 
				'title' => esc_html__('WooCommerce meta', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_woocommerce_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_woocommerce_importer_export', 10, 1 );
	function trx_addons_woocommerce_importer_export($importer) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('woocommerce.txt'), serialize( array(
				"woocommerce_attribute_taxonomies"				=> $importer->export_dump("woocommerce_attribute_taxonomies"),
				"woocommerce_downloadable_product_permissions"	=> $importer->export_dump("woocommerce_downloadable_product_permissions"),
				"woocommerce_order_itemmeta"					=> $importer->export_dump("woocommerce_order_itemmeta"),
				"woocommerce_order_items"						=> $importer->export_dump("woocommerce_order_items"),
				"woocommerce_termmeta"							=> $importer->export_dump("woocommerce_termmeta")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_woocommerce_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_woocommerce_importer_export_fields', 10, 1 );
	function trx_addons_woocommerce_importer_export_fields($importer) {
		if ( trx_addons_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'woocommerce',
				'title' => esc_html__('WooCommerce', 'trx_addons')
				)
			);
		}
	}
}

// Load WooCommerce Extended Attributes
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce-extended-attributes.php';

// Load WooCommerce Search Widget
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/widget.woocommerce_search.php';
?>