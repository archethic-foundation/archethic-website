<?php
/**
 * Plugin's admin functions
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.17
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Refresh taxonomies list on change parent list
//--------------------------------------------------------------------------------------------

// Get specified list's items
if ( !function_exists( 'trx_addons_callback_refresh_list' ) ) {
	add_action('wp_ajax_trx_addons_refresh_list', 		'trx_addons_callback_refresh_list');
	add_action('wp_ajax_nopriv_trx_addons_refresh_list','trx_addons_callback_refresh_list');
	function trx_addons_callback_refresh_list() {
		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
		$list = apply_filters('trx_addons_filter_refresh_list_'.trim($_REQUEST['parent_type']),
								array(),
								$_REQUEST['parent_value'],
								is_string($_REQUEST['list_not_selected'])
									? $_REQUEST['list_not_selected']==='true' 
									: $_REQUEST['list_not_selected']
							);
		// Make simple list to save sort order of items
		$new_list = array();
		foreach ($list as $k=>$v) 
			$new_list[] = array('key' => $k, 'value' => $v);
		$response = array(
			'error' => '',
			'data' => $new_list
		);
		echo json_encode($response);
		die();
	}
}

// Get list taxonomies
if ( !function_exists( 'trx_addons_admin_refresh_list_taxonomies' ) ) {
	add_filter('trx_addons_filter_refresh_list_taxonomies', 'trx_addons_admin_refresh_list_taxonomies', 10, 3);
	function trx_addons_admin_refresh_list_taxonomies($list, $post_type, $not_selected=false) {
		return trx_addons_get_list_taxonomies(false, $post_type);
	}
}

// Get list terms
if ( !function_exists( 'trx_addons_admin_refresh_list_terms' ) ) {
	add_filter('trx_addons_filter_refresh_list_terms', 'trx_addons_admin_refresh_list_terms', 10, 3);
	function trx_addons_admin_refresh_list_terms($list, $taxonomy, $not_selected=false) {
		$rez = array();
		if ($not_selected) {
			$tax_obj = get_taxonomy($taxonomy);
			$rez[0] = sprintf(__('- %s -', 'trx_addons'), $tax_obj->label);
		}
		return trx_addons_array_merge(
					$rez, 
					trx_addons_get_list_terms(false, $taxonomy)
					);
	}
}


// Show <select> with categories in the admin filters area
//-----------------------------------------------------------------------------------
if (!function_exists('trx_addons_admin_filters')) {
	function trx_addons_admin_filters($post_type, $tax) {
		if (get_query_var('post_type') != $post_type) return;

		if ( !($terms = get_transient("trx_addons_terms_filter_".trim($tax)))) {
			$terms = get_terms($tax);
			set_transient("trx_addons_terms_filter_".trim($tax), $terms, 24*60*60);
		}

		$list = '';
		if (is_array($terms) && count($terms) > 0) {
			$tax_obj = get_taxonomy($tax);
			$list .= '<select name="'.esc_attr($tax).'" id="'.esc_attr($tax).'" class="postform">'
					.  "<option value=''>" . esc_html($tax_obj->labels->all_items) . "</option>";
			foreach ($terms as $term) {
				$list .= '<option value="'. esc_attr($term->slug) . '"'
							. (isset($_REQUEST[$tax]) 
								&& $_REQUEST[$tax] == $term->slug 
								|| (isset($_REQUEST['taxonomy']) 
										&& $_REQUEST['taxonomy'] == $tax 
										&& isset($_REQUEST['term']) 
										&& $_REQUEST['term'] == $term->slug
									) 
								? ' selected="selected"' 
								: '') 
							. '>' . esc_html($term->name) . '</option>';
			}
			$list .=  "</select>";
		}
		trx_addons_show_layout($list);
	}
}
  
// Clear terms cache on the taxonomy save
if (!function_exists('trx_addons_admin_clear_cache_terms')) {
	function trx_addons_admin_clear_cache_terms($tax) {  
		// verify nonce
		$ok = true;
		if (!empty($_REQUEST['_wpnonce_add-tag'])) {
			check_admin_referer( 'add-tag', '_wpnonce_add-tag' );
		} else if (!empty($_REQUEST['_wpnonce']) && !empty($_REQUEST['tag_ID'])) {
			$tag_ID = (int) $_REQUEST['tag_ID'];
			if ($_POST['action'] == 'editedtag')
				check_admin_referer( 'update-tag_' . $tag_ID );
			else if ($_POST['action'] == 'delete-tag')
				check_admin_referer( 'delete-tag_' . $tag_ID );
			else if ($_POST['action'] == 'delete')
				check_admin_referer( 'bulk-tags' );
			else if ($_POST['action'] == 'bulk-delete')
				check_admin_referer( 'bulk-tags' );
			else
				$ok = false;
		} else
			$ok = false;
		if ($ok) 
			set_transient("trx_addons_terms_filter_".trim($tax), '', 24*60*60);
	}
}
?>