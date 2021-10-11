<?php
/**
 * Themes market support: REST API callbacks
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.34
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


//------------------------------------------------
//--  REST API support
//------------------------------------------------

// Register endpoints
if ( !function_exists( 'trx_addons_rest_register_endpoints' ) ) {
	add_action( 'rest_api_init', 'trx_addons_rest_register_endpoints');
	function trx_addons_rest_register_endpoints() {
		if (!trx_addons_edd_themes_market_enable()) return;
		// Return list of the themes for the widget
		register_rest_route( 'trx_addons/v1', '/themes/list', array(
			'methods' => 'GET,POST',
			'callback' => 'trx_addons_rest_get_list_themes',
			));
		// Check purchase code
		register_rest_route( 'trx_addons/v1', '/themes/check_purchase_code', array(
			'methods' => 'GET,POST',
			'callback' => 'trx_addons_rest_check_purchase_code',
			));
	}
}

// Return UID
if ( !function_exists( 'trx_addons_rest_get_uid' ) ) {
	function trx_addons_rest_get_uid($prefix='trx') {
		return sprintf( '%s-%s-%s', $prefix, wp_create_nonce(admin_url('admin-ajax.php')), uniqid() );
	}
}

// Return UID
if ( !function_exists( 'trx_addons_rest_check_uid' ) ) {
	function trx_addons_rest_check_uid($uid, $prefix='trx') {
		$tmp = sprintf( '%s-%s', $prefix, wp_create_nonce(admin_url('admin-ajax.php')) );
		return $tmp == substr($uid, 0, strlen($tmp));
	}
}


//------------------------------------------
//-- Return list of the themes from market
//------------------------------------------
if ( !function_exists( 'trx_addons_rest_get_list_themes' ) && class_exists( 'WP_REST_Request' ) ) {
	function trx_addons_rest_get_list_themes(WP_REST_Request $request) {
		
		// Get params from widget
		$params = $request->get_params();
		$page = !empty($params['page']) ? max(1, (int) $params['page']) : 1;
		$count = !empty($params['count']) ? max(1, min(50, (int) $params['count'])) : 10;
		$market = !empty($params['market']) ? array_map('intval', explode(',', $params['market'])) : array(0);
		$category = !empty($params['category']) ? array_map('intval', explode(',', $params['category'])) : array(0);
		$orderby = !empty($params['orderby']) && in_array($params['orderby'], array_keys(trx_addons_get_list_sc_query_orderby())) 
					? ($params['orderby'] == 'date' ? 'post_date' : $params['orderby'])
					: 'post_date';
		$order = !empty($params['order']) && in_array($params['order'], array_keys(trx_addons_get_list_sc_query_orders())) 
					? $params['order'] 
					: 'desc';
		
		// Get themes list
		$list = array();
		$query_args = array(
			'ignore_sticky_posts' => true,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'offset' => ($page-1)*$count,
			'meta_query' => array(
                            array(
                                'key' => 'trx_addons_edd_offer',
                                'value' => '1',
                                'compare' => '!='
                            )
                        )
		);
		$query_args = trx_addons_query_add_sort_order($query_args, $orderby, $order);
		$query_args = trx_addons_query_add_posts_and_cats($query_args, '', TRX_ADDONS_EDD_PT);
		if (count($category) > 1 || $category[0] > 0)
			$query_args = trx_addons_query_add_posts_and_cats($query_args, '', '', $category, TRX_ADDONS_EDD_TAXONOMY_CATEGORY);
		if (count($market) > 1 || $market[0] > 0)
			$query_args = trx_addons_query_add_posts_and_cats($query_args, '', '', $market, TRX_ADDONS_EDD_TAXONOMY_MARKET);
		$query = new WP_Query( $query_args );
		global $post;
		while ( $query->have_posts() ) { $query->the_post();
			$trx_addons_meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$list[] = array(
							'id' => get_the_ID(),
							'title' => get_the_title(),
							'content' => has_excerpt() ? get_the_excerpt() : '',
							'date_created' => $trx_addons_meta['date_created'],
							'date_created_unix' => strtotime($trx_addons_meta['date_created']),
							'date_created_string' => date_i18n(get_option('date_format'), strtotime($trx_addons_meta['date_created'])),
							'date_updated' => $trx_addons_meta['date_updated'],
							'date_updated_unix' => strtotime($trx_addons_meta['date_updated']),
							'date_updated_string' => date_i18n(get_option('date_format'), strtotime($trx_addons_meta['date_updated'])),
							'price' => edd_price(get_the_ID(), false),
							'version' => $trx_addons_meta['version'],
							'featured' => trx_addons_get_attachment_url(get_post_thumbnail_id(get_the_ID()), trx_addons_get_thumb_size('masonry-big')),
							'screenshot' => !empty($trx_addons_meta['screenshot_url']) 
												? trx_addons_get_attachment_url($trx_addons_meta['screenshot_url'], trx_addons_get_thumb_size('masonry-big'))
												: '',
							'download_url' => !empty($trx_addons_meta['download_url']) ? $trx_addons_meta['download_url'] : get_permalink(),
							'demo_url' => $trx_addons_meta['demo_url']
							);
		}
		
		// Prepare response
		$response = array(
						'uid' => trx_addons_rest_get_uid(),
						'css' => TRX_ADDONS_PLUGIN_URL . TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget.themes.css',
						'list' => $list
						);
	
		return new WP_REST_Response($response);
	}
}


//------------------------------------------------
//-- Check purchase code
//------------------------------------------------

if (!defined('TRX_ADDONS_EDD_PT_PAYMENT')) define('TRX_ADDONS_EDD_PT_PAYMENT', 'edd_payment');

// Add parameter 'Token' parameter in the ThemeREX Addons Options
if (!function_exists('trx_addons_rest_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_rest_options');
	function trx_addons_rest_options($options) {

		if (trx_addons_edd_themes_market_enable()) {

			trx_addons_array_insert_after($options, 'themes_market_section', array(
				'themes_market_rest_key' => array(
					"title" => esc_html__('Secure key to validate themes',  'trx_addons'),
					"desc" => wp_kses_data( __('Secure key to enable checking purchase code and get theme info',  'trx_addons') ),
					"std" => "",
					"type" => "text"
				)
			) );
		}

		return $options;
	}
}

// Check purchase code and return theme's data
if ( !function_exists( 'trx_addons_rest_check_purchase_code' ) && class_exists( 'WP_REST_Request' ) ) {
	function trx_addons_rest_check_purchase_code(WP_REST_Request $request) {
		// Get params
		$params = $request->get_params();
		$slug = !empty($params['slug']) ? $params['slug'] : '';
		$code = !empty($params['code']) ? $params['code'] : '';
		$key = !empty($params['key']) ? $params['key'] : '';

		// Check result
		$response = array(
						'hash' => md5($slug . $code . $key),
						'valid' => 0,
						'error' => ''
						);

		if (!empty($slug) && !empty($code) && !empty($key)) {
			if ($key == trx_addons_get_option('themes_market_rest_key')) {
				$query_args = array(
					'post_status' => 'publish',
					'post_type' => TRX_ADDONS_EDD_PT_PAYMENT,
					'posts_per_page' => 1,
					'meta_query' => array(
			                            array(
			                                'key' => '_edd_payment_purchase_key',
			                                'value' => $code,
			                                'compare' => '='
			                            )
		                        )
				);
				$meta = false;
				$query = new WP_Query( $query_args );
				global $post;
				while ( $query->have_posts() ) { $query->the_post();
					$meta = get_post_meta(get_the_ID(), '_edd_payment_meta', true);
					break;
				}
				if (!empty($meta) && is_array($meta)) {
					$posts = array();
					foreach ($meta['downloads'] as $v) {
						if (isset($v['id']))
							$posts[] = $v['id'];
					}
					$query_args = array(
						'post_status' => 'publish',
						'post_type' => TRX_ADDONS_EDD_PT,
						'posts_per_page' => 1,
						'posts__in' => $posts,
						'meta_query' => array(
				                            array(
				                                'key' => 'trx_addons_edd_slug',
				                                'value' => $slug,
				                                'compare' => '='
				                            )
			                        )
					);
					unset($query);
					$query = new WP_Query( $query_args );
					while ( $query->have_posts() ) { $query->the_post();
						$response['valid'] = 1;
						break;
					}
				} else {
					$response['error'] = __('Purchase code is invalid!', 'trx_addons');
				}
			} else {
				$response['error'] = __('Secure key is invalid!', 'trx_addons');
			}
		} else {
			$response['error'] = __('Required parameters are not filled!', 'trx_addons');
		}

		return new WP_REST_Response($response);
	}
}
?>