<?php
/**
 * Plugin support: Easy Digital Downloads (Themes market support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Define component's subfolder
if ( !defined('TRX_ADDONS_PLUGIN_THEMES_MARKET') ) define('TRX_ADDONS_PLUGIN_THEMES_MARKET', TRX_ADDONS_PLUGIN_COMPONENTS . 'themes_market/');


// Add component to the global list
if (!function_exists('trx_addons_edd_themes_market_add_to_components')) {
	add_filter( 'trx_addons_components_list', 'trx_addons_edd_themes_market_add_to_components' );
	function trx_addons_edd_themes_market_add_to_components($list=array()) {
		$list['themes_market'] = array(
					'title' => __('Themes market', 'trx_addons')
					);
		return $list;
	}
}


// -----------------------------------------------------------------
// -- Additional taxonomies and post's meta
// -----------------------------------------------------------------

if (!defined('TRX_ADDONS_EDD_PT')) define('TRX_ADDONS_EDD_PT', 'download');
if (!defined('TRX_ADDONS_EDD_PT_PAYMENT')) define('TRX_ADDONS_EDD_PT_PAYMENT', 'edd_payment');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_CATEGORY')) define('TRX_ADDONS_EDD_TAXONOMY_CATEGORY', 'download_category');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_MARKET')) define('TRX_ADDONS_EDD_TAXONOMY_MARKET', 'download_market');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_LABEL')) define('TRX_ADDONS_EDD_TAXONOMY_LABEL', 'download_label');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_TAG')) define('TRX_ADDONS_EDD_TAXONOMY_TAG', 'download_tag');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY') ) define('TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY', 'download_compatibility');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_BROWSERS') ) define('TRX_ADDONS_EDD_TAXONOMY_BROWSERS', 'download_browsers');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_PACKAGE') ) define('TRX_ADDONS_EDD_TAXONOMY_PACKAGE', 'download_package');
if (!defined('TRX_ADDONS_EDD_TAXONOMY_PLUGINS') ) define('TRX_ADDONS_EDD_TAXONOMY_PLUGINS', 'download_plugins');


// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_edd' ) ) {
	function trx_addons_exists_edd() {
		return class_exists('Easy_Digital_Downloads');
	}
}

// Check if Themes Market is enabled
if (!function_exists('trx_addons_edd_themes_market_enable')) {
	function trx_addons_edd_themes_market_enable() {
		static $enable = null;
		if ($enable === null) {
			$enable = trx_addons_components_is_allowed('components', 'themes_market') 
											&& trx_addons_exists_edd()
											&& apply_filters('trx_addons_filter_edd_themes_market', false);
		}
		return $enable;
	}
}

// Load Themes Market components
if (!function_exists('trx_addons_edd_themes_market_load')) {
	add_action( 'after_setup_theme', 'trx_addons_edd_themes_market_load', 2 );
	function trx_addons_edd_themes_market_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		if (trx_addons_edd_themes_market_enable()) {
			if (file_exists(TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'themes_market_rest_api.php')) {
				require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'themes_market_rest_api.php';
			}
			if (file_exists(TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget.themes_search.php')) {
				require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget.themes_search.php';
			}
			if (file_exists(TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget_generator.php')) {
				require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget_generator.php';
			}
		}
	}
}

// Disable load themes if user is not logged in
if (!function_exists('trx_addons_edd_themes_market_check_user_before_download')) {
	add_action( 'edd_file_download_has_access', 'trx_addons_edd_themes_market_check_user_before_download', 100, 3);
	function trx_addons_edd_themes_market_check_user_before_download($allow=false, $payment=0, $args=array()) {
		if ( $allow && is_user_logged_in() ) {
			$user = get_current_user_id();
			if ( 0 === $user ) return false;
			$by_user_id = is_numeric( $user ) ? true : false;
			$customer   = new EDD_Customer( $user, $by_user_id );
			if ( !empty( $customer->payment_ids ) ) {
				$payments = array_map( 'absint', explode( ',', $customer->payment_ids ) );
				$allow = in_array($payment, $payments);
			} else
				$allow = false;
		} else
			$allow = false;
		if (!$allow) {
			trx_addons_set_front_message(__('You do not have permission to download this file!<br>Please, login and try again!', 'trx_addons'),
										'error',
										true);
			wp_safe_redirect(home_url());
			die();
		}
		return $allow;
	}
}


// Redirect subscribers
if (!function_exists('trx_addons_edd_themes_market_redirect_subscribers')) {
	add_filter( 'login_redirect', 'trx_addons_edd_themes_market_redirect_subscribers', 100, 3 );
	function trx_addons_edd_themes_market_redirect_subscribers( $redirect_to, $request, $user ) {
		if ( (is_user_logged_in() || ($user instanceof WP_User))
				&& (($user instanceof WP_User) && !$user->has_cap('edit_posts'))
				&& ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) ) {
			$purchase_history = edd_get_option( 'purchase_history_page', 0 );
			return !empty( $purchase_history ) ? get_permalink( $purchase_history ) : home_url();
		}
		return $redirect_to;
	}
}


// Add 'Themes Market' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_edd_themes_market_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_edd_themes_market_options');
	function trx_addons_edd_themes_market_options($options) {

		if (trx_addons_edd_themes_market_enable()) {

			trx_addons_array_insert_before($options, 'theme_specific_section', array(
			
				// Section 'Theme Specific'
				'themes_market_section' => array(
					"title" => esc_html__('Themes Market', 'trx_addons'),
					"desc" => wp_kses_data( __("Themes market settings", 'trx_addons') ),
					"type" => "section"
				),
				'themes_market_info' => array(
					"title" => esc_html__('Themes Market', 'trx_addons'),
					"desc" => wp_kses_data( __("Affiliate parameters from marketplaces", 'trx_addons') ),
					"type" => "info"
				),
				'themes_market_logo' => array(
					"title" => esc_html__('Logo in the Themes Widget',  'trx_addons'),
					"desc" => wp_kses_data( __('Select or upload image with logo to place it in the Themes Widget',  'trx_addons') ),
					"std" => "",
					"type" => "image"
				),
				'themes_market_logo_link' => array(
					"title" => esc_html__('Link from Logo in the Themes Widget',  'trx_addons'),
					"desc" => wp_kses_data( __('URL to link logo in the Themes Widget',  'trx_addons') ),
					"std" => "",
					"type" => "text"
				),
				'themes_market_regular_price_description' => array(
					"title" => esc_html__('Regular price description',  'trx_addons'),
					"desc" => wp_kses_data( __('Description under the regular price',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				),
				'themes_market_extended_price_description' => array(
					"title" => esc_html__('Extended price description',  'trx_addons'),
					"desc" => wp_kses_data( __('Description under the extended price',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				),
				'themes_market_price_info' => array(
					"title" => esc_html__('Info below the price',  'trx_addons'),
					"desc" => wp_kses_data( __('Additional info after the price selector',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				),
				'themes_market_free_info' => array(
					"title" => esc_html__('Info about free items',  'trx_addons'),
					"desc" => wp_kses_data( __('Additional info about free items above the "Download" link',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				),
				'themes_market_referals' => array(
					"title" => esc_html__("Referals", 'trx_addons'),
					"desc" => wp_kses_data( __("Affiliate parameters from marketplaces", 'trx_addons') ),
					"clone" => true,
					"std" => array(array()),
					"type" => "group",
					"fields" => array(
						'url' => array(
							"title" => esc_html__("Part of the marketplace's URL", 'trx_addons'),
							"desc" => wp_kses_data( __("If product's URL have this substring - next param should be added", 'trx_addons') ),
							"class" => "trx_addons_column-1_2 trx_addons_new_row",
							"std" => "",
							"type" => "text"
						),
						'param' => array(
							"title" => esc_html__('Parameters to add', 'trx_addons'),
							"desc" => wp_kses_data( __("Parameters to add to the URL (as key1=value1&key2=value2...)", 'trx_addons') ),
							"class" => "trx_addons_column-1_2",
							"std" => "",
							"type" => "text"
						)
					)
				)
			) );

		}
		
		return $options;
	}
}


// Register additional taxonomies
if (!function_exists('trx_addons_edd_themes_market_init')) {
	add_action( 'init', 'trx_addons_edd_themes_market_init' );
	function trx_addons_edd_themes_market_init() {

		if (!trx_addons_edd_themes_market_enable()) return;

		// Add Downloads parameters to the Meta Box support
		trx_addons_meta_box_register(TRX_ADDONS_EDD_PT, array(
			"general_section" => array(
				"title" => esc_html__("General", 'trx_addons'),
				"desc" => wp_kses_data( __('General options', 'trx_addons') ),
				"type" => "section"
			),
			"slug" => array(
				"title" => esc_html__("Slug", 'trx_addons'),
				"desc" => wp_kses_data( __('Slug to create the demo link', 'trx_addons') ),
				"std" => '',
				"type" => "text"
			),
			"date_created" => array(
				"title" => esc_html__("Date created", 'trx_addons'),
				"desc" => wp_kses_data( __('The creation date of the item in the format "YYYY-mm-dd"', 'trx_addons') ),
				"std" => date('Y-m-d'),
				"type" => "date"
			),
			"date_updated" => array(
				"title" => esc_html__("Last update", 'trx_addons'),
				"desc" => wp_kses_data( __('Date of last update of this item in the format "YYYY-mm-dd"', 'trx_addons') ),
				"std" => date('Y-m-d'),
				"type" => "date"
			),
			"version" => array(
				"title" => esc_html__("Version", 'trx_addons'),
				"desc" => wp_kses_data( __("Current version of this product", 'trx_addons') ),
				"std" => '1.0',
				"type" => "text"
			),
			"screenshot_url" => array(
				"title" => esc_html__("Screenshot URL", 'trx_addons'),
				"desc" => wp_kses_data( __("Select local or specify remote URL with the item's screenshot", 'trx_addons') ),
				"std" => '',
				"type" => "image"
			),
			"demo_url" => array(
				"title" => esc_html__("Product preview URL", 'trx_addons'),
				"desc" => wp_kses_data( __("Specify URL of the item's demo site", 'trx_addons') ),
				"std" => '',
				"type" => "text"
			),
			"download_url" => array(
				"title" => esc_html__("Product download URL", 'trx_addons'),
				"desc" => wp_kses_data( __("The URL for downloading this item, if this item placed on some marketplace. If empty - internal shop is used to sale this item", 'trx_addons') ),
				"std" => '',
				"type" => "text"
			),
			"doc_url" => array(
				"title" => esc_html__("Online documentation URL", 'trx_addons'),
				"desc" => wp_kses_data( __("Specify URL of the item's online documentation", 'trx_addons') ),
				"std" => '',
				"type" => "text"
			),
			"features_section" => array(
				"title" => esc_html__("Features", 'trx_addons'),
				"desc" => wp_kses_data( __('Main features', 'trx_addons') ),
				"type" => "section"
			),
			"retina" => array(
				"title" => esc_html__("Retina ready", 'trx_addons'),
				"desc" => wp_kses_data( __("High resolution ready", 'trx_addons') ),
				"std" => 1,
				"type" => "checkbox"
			),
			"responsive" => array(
				"title" => esc_html__("Responsive", 'trx_addons'),
				"desc" => wp_kses_data( __("Are responsive styles and layouts included?", 'trx_addons') ),
				"std" => 1,
				"type" => "checkbox"
			),
			"columns" => array(
				"title" => esc_html__("Columns", 'trx_addons'),
				"desc" => wp_kses_data( __("Columns number in the layouts of this item", 'trx_addons') ),
				"std" => '4+',
				"options" => array(
					'1' => esc_html__('1 column', 'trx_addons'),
					'2' => esc_html__('2 columns', 'trx_addons'),
					'3' => esc_html__('3 columns', 'trx_addons'),
					'4+' => esc_html__('4+ columns', 'trx_addons')
				),
				"dir" => "horizontal",
				"type" => "radio"
			),
			"widgets" => array(
				"title" => esc_html__("Widgets", 'trx_addons'),
				"desc" => wp_kses_data( __("If there are widgets in the package", 'trx_addons') ),
				"std" => '10+',
				"options" => array(
					'none' => esc_html__('No widgets', 'trx_addons'),
					'up_5' => esc_html__('Up to 5', 'trx_addons'),
					'up_10' => esc_html__('Up to 10', 'trx_addons'),
					'10+' => esc_html__('More than 10', 'trx_addons')
				),
				"dir" => "horizontal",
				"type" => "radio"
			),
			"shortcodes" => array(
				"title" => esc_html__("Shortcodes", 'trx_addons'),
				"desc" => wp_kses_data( __("If there are shortcodes in the package", 'trx_addons') ),
				"std" => '20+',
				"options" => array(
					'none' => esc_html__('No shortcodes', 'trx_addons'),
					'up_10' => esc_html__('Up to 10', 'trx_addons'),
					'up_20' => esc_html__('Up to 20', 'trx_addons'),
					'20+' => esc_html__('More than 20', 'trx_addons')
				),
				"dir" => "horizontal",
				"type" => "radio"
			),
			"support" => array(
				"title" => esc_html__("Support", 'trx_addons'),
				"desc" => wp_kses_data( __("Support type of this item", 'trx_addons') ),
				"std" => 'standard',
				"options" => array(
					'none' => esc_html__('No support', 'trx_addons'),
					'standard' => esc_html__('30 days', 'trx_addons'),
					'premium' => esc_html__('Premium', 'trx_addons')
				),
				"type" => "select"
			),
			"documentation" => array(
				"title" => esc_html__("Documentation", 'trx_addons'),
				"desc" => wp_kses_data( __("Documentation of this item", 'trx_addons') ),
				"std" => 'well',
				"options" => array(
					'none' => esc_html__('None', 'trx_addons'),
					'medium' => esc_html__('Medium', 'trx_addons'),
					'well' => esc_html__('Well documented', 'trx_addons')
				),
				"type" => "select"
			),

			"additional_section" => array(
				"title" => esc_html__('Additional features', 'trx_addons'),
				"desc" => wp_kses_data( __('Additional (custom) features for this download', 'trx_addons') ),
				"type" => "section"
			),
			"details" => array(
				"title" => esc_html__("Additional features", 'trx_addons'),
				"desc" => wp_kses_data( __("Add more features for this download by pair title-value", 'trx_addons') ),
				"clone" => true,
				"std" => array(array()),
				"type" => "group",
				"fields" => array(
					"title" => array(
						"title" => esc_html__("Title", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature title', 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "text"
					),
					"value" => array(
						"title" => esc_html__("Value", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature value', 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "text"
					)
				)
			),
		));
		
		// Marketplace of the download: Envato, Mojo, CM, etc.
		register_taxonomy( TRX_ADDONS_EDD_TAXONOMY_MARKET, TRX_ADDONS_EDD_PT, array(
			'post_type' 		=> TRX_ADDONS_EDD_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Markets', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Market', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Market', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Markets', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Market', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Market:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Market', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Market', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Market', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Market Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Markets', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
			)
		);
		
		// Labels of the download: Sale, New, Featured, etc.
		register_taxonomy( TRX_ADDONS_EDD_TAXONOMY_LABEL, TRX_ADDONS_EDD_PT, array(
			'post_type' 		=> TRX_ADDONS_EDD_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Labels', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Label', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Label', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Labels', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Label', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Label:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Label', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Label', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Label', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Label Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Labels', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
			)
		);
		
		// Compatibility with different products: WP, WooCommerce, RevSlider, etc.
		register_taxonomy( TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY, TRX_ADDONS_EDD_PT, array(
			'post_type' 		=> TRX_ADDONS_EDD_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Compatibilities', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Compatibility', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Compatibilities', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Compatibilities', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Compatibility', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Compatibility:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Compatibility', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Compatibility', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Compatibility', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Compatibility Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Compatibilities', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
			)
		);

		// Compatibility with different browsers: IE9, IE10, IE11, Firefox, Chrome, Opera, Safari, etc.
		register_taxonomy( TRX_ADDONS_EDD_TAXONOMY_BROWSERS, TRX_ADDONS_EDD_PT, array(
			'post_type' 		=> TRX_ADDONS_EDD_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Browsers', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Browser', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Browsers', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Browsers', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Browser', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Browser:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Browser', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Browser', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Browser', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Browser Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Browsers', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
			)
		);

		// Plugins presents in the package
		register_taxonomy( TRX_ADDONS_EDD_TAXONOMY_PLUGINS, TRX_ADDONS_EDD_PT, array(
			'post_type' 		=> TRX_ADDONS_EDD_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Plugins in the package', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Plugin', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Plugins', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Plugins', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Plugin', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Plugin:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Plugin', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Plugin', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Plugin', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Plugin Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Plugins in the package', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
			)
		);

		// Attachments presents in the package
		register_taxonomy( TRX_ADDONS_EDD_TAXONOMY_PACKAGE, TRX_ADDONS_EDD_PT, array(
			'post_type' 		=> TRX_ADDONS_EDD_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'The Package', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Package', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Packages', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Packages', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Package', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Package:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Package', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Package', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add new Package', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Package Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'The Package', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
			)
		);

	}
}


// Save download's dates for search, sorting, etc.
if ( !function_exists( 'trx_addons_edd_themes_market_save_post_options' ) ) {
	add_filter('trx_addons_filter_save_post_options', 'trx_addons_edd_themes_market_save_post_options', 10, 3);
	function trx_addons_edd_themes_market_save_post_options($options, $post_id, $post_type) {
		if ($post_type == TRX_ADDONS_EDD_PT && trx_addons_edd_themes_market_enable()) { 
			update_post_meta($post_id, 'trx_addons_edd_slug', $options['slug']);
			update_post_meta($post_id, 'trx_addons_edd_date_created', $options['date_created']);
			update_post_meta($post_id, 'trx_addons_edd_date_updated', $options['date_updated']);
		}
		return $options;
	}
}


// Show details of the current product in the single post
if ( !function_exists( 'trx_addons_edd_themes_market_after_download_content' ) ) {
	add_action( 'edd_after_download_content', 'trx_addons_edd_themes_market_after_download_content', 9, 1 );
	function trx_addons_edd_themes_market_after_download_content($post_id=0) {
		if (is_single() && get_post_type()==TRX_ADDONS_EDD_PT && trx_addons_edd_themes_market_enable()) {
			// Remove 'Buy' link after the download content if this download placed on the external marketplace
			remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

			if (false) {
				if ($post_id == 0) $post_id = get_the_ID();
	
				// Show download's details after the content if shortcode 'trx_sc_edd_details' is not present in the content
				if (strpos(get_the_content(), '[trx_sc_edd_details')===false) {
					set_query_var('trx_addons_args_sc_edd_details', array('class' => 'downloads_page_info'));
					require_once trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'tpl.edd_details.default.php');
				}
	
				// Add buttons
				trx_addons_edd_themes_market_add_buttons($post_id);
			}
		}
	}
}


// Show buttons 'Live Demo' and 'Purchase' after the download's content
if ( !function_exists( 'trx_addons_edd_themes_market_add_buttons' ) ) {
	function trx_addons_edd_themes_market_add_buttons($post_id=0, $demo=true) {
		if ($post_id == 0 && is_single() && get_post_type()==TRX_ADDONS_EDD_PT) $post_id = get_the_ID();
		set_query_var('trx_addons_edd_demo', $demo);
		?><div class="trx_addons_buttons trx_addons_edd_purchase_buttons"><?php
			$free = edd_is_free_download($post_id);
			// Show price block and info for single-price items
			if (is_single() && !edd_has_variable_prices($post_id)) {
				?><div class="trx_addons_edd_purchase_price">
					<div class="trx_addons_edd_purchase_price_label">
						<span class="edd_price_option_name"><?php esc_html_e('Regular price', 'trx_addons'); ?></span><?php
						?><span class="edd_price_option_price"><?php
							if ($free)
								esc_html_e('Free', 'trx_addons');
							else
								edd_price($post_id);
						?></span>
					</div>
				</div><?php
				// Additional info (from shortcode)
				$trx_addons_args = get_query_var('trx_addons_args_sc_edd_add_to_cart');
				trx_addons_show_layout(!empty($trx_addons_args['content']) 
											? $trx_addons_args['content'] 
											: ($free
													? trx_addons_get_option('themes_market_free_info')
													: trx_addons_get_option('themes_market_price_info')
												),
										'<div class="trx_addons_edd_purchase_info">',
										'</div>');
			}
			// Add buttons
			$trx_addons_meta = get_post_meta($post_id, 'trx_addons_options', true);
			if (!empty($trx_addons_meta['download_url'])) {
				?><div class="edd_download_purchase_form"><?php
					?><a href="<?php echo esc_url(trx_addons_add_referals_to_url($trx_addons_meta['download_url'],
												  trx_addons_get_option('themes_market_referals')));
							?>" class="sc_button" target="_blank"><?php
							echo $free
									? esc_html__('Download', 'trx_addons')
									: wp_kses_data(sprintf(__('%s - Purchase', 'trx_addons'), edd_price($post_id, false)));
					?></a><?php
					trx_addons_edd_themes_market_add_demo_button($post_id, array(), $trx_addons_meta);
				?></div><?php
			} else {
				edd_append_purchase_link($post_id);
			}
		?></div><?php
	}
}

// Show variable price header in the single post
if ( !function_exists( 'trx_addons_edd_themes_market_add_buttons_title' ) ) {
	//add_action( 'edd_purchase_link_top', 'trx_addons_edd_themes_market_add_buttons_title', 9, 2 );
	function trx_addons_edd_themes_market_add_buttons_title($post_id, $args) {
		if (is_single() && edd_has_variable_prices($post_id)) {
			?><h5 class="edd_download_purchase_form_title"><?php esc_html_e("Select item's option to purchase", 'trx_addons'); ?></h5><?php
		}
	}
}

// Show 'Demo' or 'Details' after the 'Buy now' button
if ( !function_exists( 'trx_addons_edd_themes_market_add_demo_button' ) ) {
	add_action( 'edd_purchase_link_end', 'trx_addons_edd_themes_market_add_demo_button', 10, 2 );
	function trx_addons_edd_themes_market_add_demo_button($post_id=0, $args=array(), $trx_addons_meta=false) {
	    if (!trx_addons_edd_themes_market_enable()) return;
		$details = !get_query_var('trx_addons_edd_demo', true);
		$url = $details ? get_permalink($post_id) : '';
		if (empty($url)) {
			if ($trx_addons_meta === false) $trx_addons_meta = get_post_meta($post_id, 'trx_addons_options', true);
			$url = defined('TRX_ADDONS_DEMO_PARAM')
						? trx_addons_get_demo_page_link($trx_addons_meta['slug'])
						: (!empty($trx_addons_meta['demo_url']) ? $trx_addons_meta['demo_url'] : '');
		}
		if (!empty($url)) {
			?><a href="<?php echo esc_url($url); ?>" class="sc_button"<?php if (!$details) echo ' target="_blank"'; ?>><?php
				if ($details)
					esc_html_e('View details', 'trx_addons');
				else
					esc_html_e('Live demo', 'trx_addons');
			?></a><?php
		}
	}
}


// Remove '.00' from price
if ( !function_exists( 'trx_addons_edd_themes_market_remove_decimals' ) ) {
	add_filter( 'edd_format_amount', 'trx_addons_edd_themes_market_remove_decimals', 10, 5 );
	function trx_addons_edd_themes_market_remove_decimals($formatted, $amount, $decimals, $decimal_sep, $thousands_sep) {
		return str_replace($decimal_sep.str_repeat('0', $decimals), '', $formatted);
	}
}


// Remove currency symbol from the free (price == 0)
if ( !function_exists( 'trx_addons_edd_themes_market_edd_purchase_link_args' ) ) {
	add_filter( 'edd_purchase_link_args', 'trx_addons_edd_themes_market_edd_purchase_link_args', 20 );
	function trx_addons_edd_themes_market_edd_purchase_link_args($args) {
		if (strpos($args['text'], __('Free', 'trx_addons'))!==false)
			$args['text'] = __('Download', 'trx_addons');
		return $args;
	}
}




// Show Regular | Extended price selector before the options list
if ( !function_exists( 'trx_addons_edd_themes_market_add_price_selector' ) ) {
	add_action( 'edd_before_price_options', 'trx_addons_edd_themes_market_add_price_selector', 10, 1 );
	function trx_addons_edd_themes_market_add_price_selector($post_id=0) {
	    if (trx_addons_edd_themes_market_enable()) {
			// If we've already generated a form ID for this download ID, append -#
			global $edd_displayed_form_ids;
			$form_id = '';
			if ( $edd_displayed_form_ids[ $post_id ] > 1 ) {
				$form_id .= '-' . $edd_displayed_form_ids[ $post_id ];
			}
			$ext_present = false;
			$prices = array();
			if (edd_has_variable_prices($post_id)) {
				$prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $post_id ), $post_id );
				if (is_array($prices)) {
					foreach ($prices as $key => $price) {
						if (!empty($price['name']) && strpos(strtolower($price['name']), 'extended')!==false) {
							$ext_present = true;
							break;
						}
					}
				}
			}
			if (empty($prices[1]['name'])) {
				$prices = array(
								1 => array(
									'name' => __('Regular license', 'trx_addons'),
									'amount' => edd_get_download_price($post_id)
									)
								);
			}
			?><div class="trx_addons_edd_purchase_price<?php echo esc_attr($ext_present ? ' trx_addons_edd_purchase_price_selector' : ''); ?>"><?php
				foreach ($prices as $key => $price) {
					$free = edd_is_free_download($post_id, $key);
					$free_label = __('Free', 'trx_addons');
					?><div class="trx_addons_edd_purchase_price_label"><?php
						trx_addons_show_layout( apply_filters('edd_price_option_output',
											 '<span class="edd_price_option_name">' 
												. esc_html( $price['name'] ) 
											. '</span>'
											. '<span class="edd_price_option_price">'
												. esc_html($free ? $free_label : edd_currency_filter(edd_format_amount($price['amount'])))
											. '</span>'
											. (!empty($price['regular_amount'])
												? '<span class="edd_price_option_price"><del>'
													. esc_html($free ? $free_label : edd_currency_filter(edd_format_amount($price['regular_amount'])))
												. '</del></span>'
												: ''
												),
											$post_id, $key, $price, $form_id, ''));
					?></div><?php
					break;
				}
				// Prices
				if ($ext_present) {
					?><div class="trx_addons_edd_purchase_price_list"><?php
						$num = 0;
						foreach ($prices as $key => $price) {
							$num++;
							?><div class="trx_addons_edd_purchase_price_list_item">
								<div class="trx_addons_edd_purchase_price_list_item_label"><?php
									trx_addons_show_layout( apply_filters('edd_price_option_output',
														 '<span class="edd_price_option_name">' 
															. esc_html( $price['name'] ) 
														. '</span>'
														. '<span class="edd_price_option_price">'
															. esc_html($free ? $free_label : edd_currency_filter(edd_format_amount($price['amount'])))
														. '</span>'
														. (!empty($price['regular_amount'])
															? '<span class="edd_price_option_price"><del>'
																. esc_html($free ? $free_label : edd_currency_filter(edd_format_amount($price['regular_amount'])))
															. '</del></span>'
															: ''
															),
														$post_id, $key, $price, $form_id, ''));
								?></div><?php
								// Description
								if (($desc = trx_addons_get_option('themes_market_'.($num==1 ? 'regular' : 'extended').'_price_description')) != '') {
									?><div class="trx_addons_edd_purchase_price_list_item_description"><?php
										trx_addons_show_layout($desc);
									?></div><?php
								}
							?></div><?php
							if ($num == 2) break;
						}
					?></div><?php
				}
			?></div><?php
			
			// Additional info (from shortcode)
			$trx_addons_args = get_query_var('trx_addons_args_sc_edd_add_to_cart');
			trx_addons_show_layout(!empty($trx_addons_args['content']) 
										? $trx_addons_args['content'] 
										: trx_addons_get_option('themes_market_price_info'),
									'<div class="trx_addons_edd_purchase_info">',
									'</div>');
		}
	}
}


// Show Subtotal after the options list
if ( !function_exists( 'trx_addons_edd_themes_market_add_subtotal' ) ) {
	add_action( 'edd_after_price_options_list', 'trx_addons_edd_themes_market_add_subtotal', 10, 3 );
	function trx_addons_edd_themes_market_add_subtotal($post_id=0, $prices=array(), $type='') {
	    if (trx_addons_edd_themes_market_enable() && edd_has_variable_prices($post_id) && $type=='checkbox') {
			$old_price = 0;
			$type = edd_get_download_type($post_id);
			if (!get_query_var('trx_addons_edd_demo', true) && $type == 'bundle') {
				$list = edd_get_bundled_products($post_id);
				if (is_array($list) && count($list) > 0) {
					foreach ($list as $id) {
						$old_price += edd_get_download_price($id);
					}
				}
			}
			?><div class="trx_addons_edd_purchase_subtotal trx_addons_edd_purchase_subtotal_<?php echo esc_attr($old_price > 0 ? $type : 'default'); ?>"><?php
				// Title
				?><span class="trx_addons_edd_purchase_subtotal_label"><?php esc_html_e('Subtotal:', 'trx_addons'); ?></span><?php
				// Value
				?><span class="trx_addons_edd_purchase_subtotal_value"><?php edd_price($post_id); ?></span><?php
				// Old Value
				if ($old_price > 0) {
				?><span class="trx_addons_edd_purchase_subtotal_value_old"><?php echo esc_html(edd_currency_filter(edd_format_amount($old_price))); ?></span><?php
				}
			?></div><?php
		}
	}
}



// Show purchase key in the View Order Details
if ( !function_exists( 'trx_addons_edd_themes_market_payment_receipt_after' ) ) {
	add_action( 'edd_payment_receipt_after', 'trx_addons_edd_themes_market_payment_receipt_after', 10, 2 );
	function trx_addons_edd_themes_market_payment_receipt_after($payment, $args) {
	    if (!trx_addons_edd_themes_market_enable()) return;
		$meta = edd_get_payment_meta( $payment->ID );
		if (!empty($meta['key'])) {
			?>
			<tr>
				<th class="edd_receipt_payment_key"><strong><?php esc_html_e( 'Purchase Key', 'trx_addons' ); ?>:</strong></th>
				<th class="edd_receipt_payment_key"><?php echo esc_html($meta['key']); ?></th>
			</tr>
			<?php
		}
	}
}


// Add class 'download_market_[internal|external]' to the <article> on the single page
if ( !function_exists( 'trx_addons_edd_themes_market_post_class' ) ) {
	add_filter( 'post_class', 'trx_addons_edd_themes_market_post_class', 11 );
	function trx_addons_edd_themes_market_post_class($classes) {
		if (get_post_type() == TRX_ADDONS_EDD_PT && trx_addons_edd_themes_market_enable()) {
			$trx_addons_meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$classes[] = 'download_market_'.(!empty($trx_addons_meta['download_url']) ? 'external' : 'internal');
		}
		return $classes;
	}
}


// Load required scripts and styles
//------------------------------------------------------------------------
	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_edd_themes_market_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_edd_themes_market_load_scripts_front', 11);
	function trx_addons_edd_themes_market_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && trx_addons_edd_themes_market_enable()) {
			wp_enqueue_script( 'trx_addons-edd_themes_market', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'themes_market.js'), array('jquery'), null, true );
		}
	}
}


// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_edd_themes_market_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_edd_themes_market_merge_styles');
	function trx_addons_edd_themes_market_merge_styles($list) {
	    if (trx_addons_edd_themes_market_enable()) $list[] = TRX_ADDONS_PLUGIN_THEMES_MARKET . '_themes_market.scss';
		return $list;
	}
}


// Merge specific styles into single stylesheet (responsive)
if ( !function_exists( 'trx_addons_edd_themes_market_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_edd_themes_market_merge_styles_responsive');
	function trx_addons_edd_themes_market_merge_styles_responsive($list) {
	    if (trx_addons_edd_themes_market_enable()) $list[] = TRX_ADDONS_PLUGIN_THEMES_MARKET . '_themes_market.responsive.scss';
		return $list;
	}
}

	
// Merge specific scripts into single file
if ( !function_exists( 'trx_addons_edd_themes_market_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_edd_themes_market_merge_scripts');
	function trx_addons_edd_themes_market_merge_scripts($list) {
		if (trx_addons_edd_themes_market_enable()) $list[] = TRX_ADDONS_PLUGIN_THEMES_MARKET . 'themes_market.js';
		return $list;
	}
}


// Query parameters
//------------------------------------------------------------------------

// Parse query params from GET/POST and wp_query_parameters
if ( !function_exists( 'trx_addons_edd_themes_market_query_params' ) ) {
	function trx_addons_edd_themes_market_query_params($params=array()) {
		$q_obj = get_queried_object();
		if (($value = trx_addons_get_value_gp('themes_keyword')) != '')				$params['themes_keyword'] = sanitize_text_field($value);
		if (($value = trx_addons_get_value_gp('themes_order')) != '')				$params['themes_order'] = sanitize_text_field($value);
		if (is_tax(TRX_ADDONS_EDD_TAXONOMY_CATEGORY))								$params['themes_category'] = (int) $q_obj->term_id;
		else if (($value = trx_addons_get_value_gp('themes_category')) > 0)			$params['themes_category'] = array_map('intval', $value);
		if (is_tax(TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY))							$params['themes_compatibility'] = (int) $q_obj->term_id;
		else if (($value = trx_addons_get_value_gp('themes_compatibility')) > 0)	$params['themes_compatibility'] = array_map('intval', $value);
		if (is_tax(TRX_ADDONS_EDD_TAXONOMY_LABEL))									$params['themes_label'] = (int) $q_obj->term_id;
		else if (($value = trx_addons_get_value_gp('themes_label')) > 0)			$params['themes_label'] = array_map('intval', $value);
		return $params;
	}
}


// Make new query to search properties or return $wp_query object if haven't search parameters
if ( !function_exists( 'trx_addons_edd_themes_market_query_params_to_args' ) ) {
	function trx_addons_edd_themes_market_query_params_to_args($params=array(), $new_query=false) {
		$params = trx_addons_edd_themes_market_query_params($params);
		$args = $keywords = array();
		if (!empty($params['themes_keyword']))
			$args['s'] = $params['themes_keyword'];
		if (!empty($params['themes_category']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_EDD_TAXONOMY_CATEGORY, $params['themes_category']);
		if (!empty($params['themes_compatibility']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY, $params['themes_compatibility']);
		if (!empty($params['themes_label']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_EDD_TAXONOMY_LABEL, $params['themes_label']);
		if (!empty($params['themes_order'])) {
			$order = explode('_', $params['themes_order']);
			if (count($order) == 1)
				$order[] = 'asc';
			if ($order[0] == 'title')
				$args['orderby'] = 'title';
			else if ($order[0] == 'rand')
				$args['orderby'] = 'rand';
			else if ($order[0] == 'date')
				$args['orderby'] = 'date';
			if (!empty($args['orderby']))
				$args['order'] = $order[1] == 'asc' ? 'ASC' : 'DESC';
		}

		// Prepare args for new query (not in 'pre_query')
		if ($new_query) {	// && count($args) > 0) {
			$args = array_merge(array(
						'post_type' => TRX_ADDONS_EDD_PT,
						'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') 
											? array('publish', 'private') 
											: 'publish'
					), $args);
			$page_number = get_query_var('paged') 
								? get_query_var('paged') 
								: (get_query_var('page') 
									? get_query_var('page') 
									: 1);
			if ($page_number > 1) {
				$args['paged'] = $page_number;
				$args['ignore_sticky_posts'] = true;
			}
			$ppp = get_option('posts_per_page');
			if ((int) $ppp == 0) $ppp = 10;
			$args['posts_per_page'] = (int) $ppp;
		}
		return $args;
	}
}


// Add query vars to filter posts
if (!function_exists('trx_addons_edd_themes_market_pre_get_posts')) {
	add_action( 'pre_get_posts', 'trx_addons_edd_themes_market_pre_get_posts' );
	function trx_addons_edd_themes_market_pre_get_posts($query) {
		if (!$query->is_main_query() || is_admin()) return;
		if ($query->get('post_type') == TRX_ADDONS_EDD_PT) {
			$args = trx_addons_edd_themes_market_query_params_to_args(array(), (int) trx_addons_get_value_gp('themes_query'));
			if (is_array($args) && count($args) > 0) {
				foreach ($args as $k=>$v)
					$query->set($k, $v);
			}
		}
	}
}
	

// Admin utils
// -----------------------------------------------------------------

// Create additional column in the posts list
if (!function_exists('trx_addons_edd_themes_market_add_custom_column')) {
	add_filter('manage_edit-'.TRX_ADDONS_EDD_PT.'_columns',	'trx_addons_edd_themes_market_add_custom_column', 11);
	function trx_addons_edd_themes_market_add_custom_column( $columns ){
		if (trx_addons_edd_themes_market_enable()) {
			if (is_array($columns) && count($columns)>0) {
				$new_columns = array();
				foreach($columns as $k=>$v) {
					if ($k=='price')
						$new_columns['edd_slug'] = esc_html__('Slug', 'trx_addons');
					$new_columns[$k] = $v;
				}
				$columns = $new_columns;
			}
	    }
		return $columns;
	}
}

// Fill custom columns in the posts list
if (!function_exists('trx_addons_edd_themes_market_fill_custom_column')) {
	add_action('manage_'.TRX_ADDONS_EDD_PT.'_posts_custom_column', 'trx_addons_edd_themes_market_fill_custom_column', 11, 2);
	function trx_addons_edd_themes_market_fill_custom_column($column_name='', $post_id=0) {
		if ($column_name == 'edd_slug') {
			$slug = get_post_meta($post_id, 'trx_addons_edd_slug', true);
			if (!empty($slug)) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_label"><?php echo esc_html($slug); ?></span>
				</div><?php
			}
		}
	}
}


// trx_sc_edd_details
//-------------------------------------------------------------
/*
[trx_sc_edd_details id="unique_id" type="default"]
*/
if ( !function_exists( 'trx_addons_sc_edd_details' ) ) {
	function trx_addons_sc_edd_details($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_edd_details', $atts, array(
			// Individual params
			"type" => "default",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			));

		$atts['class'] .= ($atts['class'] ? ' ' : '') . 'sc_edd_details';

		$output = '';
		if (is_single() && get_post_type()==TRX_ADDONS_EDD_PT && trx_addons_edd_themes_market_enable()) {
			ob_start();
			trx_addons_get_template_part(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'tpl.edd_details.'.trx_addons_esc($atts['type']).'.php',
										'trx_addons_args_sc_edd_details',
										$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_edd_details', $atts, $content);
	}
}


// Add [trx_sc_edd_details] in the VC shortcodes list
if (!function_exists('trx_addons_sc_edd_details_add_in_vc')) {
	function trx_addons_sc_edd_details_add_in_vc() {

		add_shortcode("trx_sc_edd_details", "trx_addons_sc_edd_details");

		if (!trx_addons_exists_visual_composer() || !trx_addons_edd_themes_market_enable()) return;

		vc_lean_map( "trx_sc_edd_details", 'trx_addons_sc_edd_details_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Edd_Details extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_edd_details_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_edd_details_add_in_vc_params')) {
	function trx_addons_sc_edd_details_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_edd_details",
				"name" => esc_html__("EDD Details", 'trx_addons'),
				"description" => wp_kses_data( __("Display current download's details", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_edd_details',
				"class" => "trx_sc_edd_details",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							"admin_label" => true,
							"std" => "default",
					        'save_always' => true,
							"value" => array_flip(apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons')
							), 'trx_sc_edd_details')),
							"type" => "dropdown"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_edd_details' );
	}
}


// trx_sc_edd_add_to_cart
//-------------------------------------------------------------
/*
[trx_sc_edd_add_to_cart id="unique_id" type="default|promo"]
*/
if ( !function_exists( 'trx_addons_sc_edd_add_to_cart' ) ) {
	function trx_addons_sc_edd_add_to_cart($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_edd_add_to_cart', $atts, array(
			// Individual params
			"type" => "default",
			"download" => 0,
			"content" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_style" => 'default',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			));

		$output = '';
		if (trx_addons_edd_themes_market_enable() && ($atts['download'] > 0 || is_single() && get_post_type()==TRX_ADDONS_EDD_PT)) {

			if (empty($atts['content']) && !empty($content)) $atts['content'] = do_shortcode($content);
			$atts['class'] .= ($atts['class'] ? ' ' : '') . 'sc_edd_add_to_cart sc_edd_add_to_cart_'.esc_attr($atts['type']);

			ob_start();
			trx_addons_get_template_part(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'tpl.edd_add_to_cart.'.trx_addons_esc($atts['type']).'.php',
										'trx_addons_args_sc_edd_add_to_cart',
										$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_edd_add_to_cart', $atts, $content);
	}
}


// Add [trx_sc_edd_add_to_cart] in the VC shortcodes list
if (!function_exists('trx_addons_sc_edd_add_to_cart_add_in_vc')) {
	function trx_addons_sc_edd_add_to_cart_add_in_vc() {

		add_shortcode("trx_sc_edd_add_to_cart", "trx_addons_sc_edd_add_to_cart");

		if (!trx_addons_exists_visual_composer() || !trx_addons_edd_themes_market_enable()) return;

		vc_lean_map( "trx_sc_edd_add_to_cart", 'trx_addons_sc_edd_add_to_cart_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Edd_Add_To_Cart extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_edd_add_to_cart_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_edd_add_to_cart_add_in_vc_params')) {
	function trx_addons_sc_edd_add_to_cart_add_in_vc_params() {
		$list = trx_addons_get_list_posts(false, array(
														'post_type' => TRX_ADDONS_EDD_PT,
														'orderby' => 'title',
														'order' => 'ASC',
														'not_selected' => true
														));
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_edd_add_to_cart",
				"name" => esc_html__("EDD Add to Cart", 'trx_addons'),
				"description" => wp_kses_data( __("Display 'Add to cart' block with current or specified download", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_edd_add_to_cart',
				"class" => "trx_sc_edd_add_to_cart",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"std" => "default",
					        'save_always' => true,
							"value" => array_flip(apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons'),
								'promo' => esc_html__('Promo', 'trx_addons')
							), 'trx_sc_edd_add_to_cart')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "download",
							"heading" => esc_html__("Download", 'trx_addons'),
							"description" => wp_kses_data( __("Select download to display 'Add to cart' block. If not selected - use current item (if we are on the single download page)", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							'save_always' => true,
							"value" => array_flip($list),
							"type" => "dropdown"
						),
						array(
							'heading' => esc_html__( 'Info', 'trx_addons' ),
							"description" => wp_kses_data( __("Additional info after the price block", 'trx_addons') ),
							'param_name' => 'content',
							'value' => '',
							'holder' => 'div',
							'type' => 'textarea_html',
						)
					),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_edd_add_to_cart' );
	}
}
?>