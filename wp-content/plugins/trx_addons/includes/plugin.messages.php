<?php
/**
 * System messages
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


//-------------------------------------------------------
//-- Admin messages
//-------------------------------------------------------

// Set message
if ( !function_exists( 'trx_addons_set_admin_message' ) ) {
	function trx_addons_set_admin_message($msg=false, $type=false, $next_session=false) {
		if ($next_session) {
			$store = array('error'=>'', 'success'=>'');
			if (!empty($type) && !empty($msg)) $store[$type] = $msg;
			update_option('trx_addons_admin_message', $store);
		} else if (!empty($msg)) {
			global $TRX_ADDONS_STORAGE;
			if (empty($type))
				$TRX_ADDONS_STORAGE['admin_message'] = is_array($msg) ? $msg : array('error'=>'', 'success'=>$msg);
			else
				$TRX_ADDONS_STORAGE['admin_message'][$type] = $msg;
		}
	}
}

// Get message
if ( !function_exists( 'trx_addons_get_admin_message' ) ) {
	function trx_addons_get_admin_message($type=false) {
		global $TRX_ADDONS_STORAGE;
		return empty($type) ? $TRX_ADDONS_STORAGE['admin_message'] : $TRX_ADDONS_STORAGE['admin_message'][$type];
	}
}

// Load message from the previous session
if ( !function_exists( 'trx_addons_init_admin_message' ) ) {
	function trx_addons_init_admin_message() {
		if (($msg = get_option('trx_addons_admin_message')) != '') {
			trx_addons_set_admin_message($msg);
			update_option('trx_addons_admin_message', '');
		}
	}
}
if (is_admin()) trx_addons_init_admin_message();


//-------------------------------------------------------
//-- Frontend messages
//-------------------------------------------------------

// Set message
if ( !function_exists( 'trx_addons_set_front_message' ) ) {
	function trx_addons_set_front_message($msg=false, $type=false, $next_session=false) {
		if ($next_session) {
			$store = array('error'=>'', 'success'=>'');
			if (!empty($type) && !empty($msg)) $store[$type] = $msg;
			update_option('trx_addons_front_message', $store);
		} else if (!empty($msg)) {
			global $TRX_ADDONS_STORAGE;
			if (empty($type))
				$TRX_ADDONS_STORAGE['front_message'] = is_array($msg) ? $msg : array('error'=>'', 'success'=>$msg);
			else
				$TRX_ADDONS_STORAGE['front_message'][$type] = $msg;
		}
	}
}

// Get message
if ( !function_exists( 'trx_addons_get_front_message' ) ) {
	function trx_addons_get_front_message($type=false) {
		global $TRX_ADDONS_STORAGE;
		return empty($type) ? $TRX_ADDONS_STORAGE['front_message'] : $TRX_ADDONS_STORAGE['front_message'][$type];
	}
}

// Load message from the previous session
if ( !function_exists( 'trx_addons_init_front_message' ) ) {
	function trx_addons_init_front_message() {
		if (($msg = get_option('trx_addons_front_message')) != '') {
			trx_addons_set_front_message($msg);
			update_option('trx_addons_front_message', '');
		}
	}
}
if (!is_admin()) trx_addons_init_front_message();

// Display message from previous session (if set)
if (!function_exists('trx_addons_show_front_message')) {
	add_action('wp_footer', 'trx_addons_show_front_message');
	function trx_addons_show_front_message() {
		$result = trx_addons_get_front_message();
		if (!empty($result['error'])) {
			?><div class="trx_addons_message_box trx_addons_message_box_system trx_addons_message_box_error">
				<h6 class="trx_addons_message_box_title"><?php esc_html_e('Error!', 'trx_addons'); ?></h6>
				<div class="trx_addons_message_box_text"><?php echo wp_kses_post($result['error']); ?></div>
			</div><?php
		} else if (!empty($result['success'])) {
			?><div class="trx_addons_message_box trx_addons_message_box_system trx_addons_message_box_success">
				<h6 class="trx_addons_message_box_title"><?php esc_html_e('Success!', 'trx_addons'); ?></h6>
				<div class="trx_addons_message_box_text"><?php echo wp_kses_post($result['success']); ?></div>
			</div><?php
		}
	}
}
