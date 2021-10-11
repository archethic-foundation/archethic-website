<?php
/**
 * Themes market support: Widget Generator
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.34
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


if (!function_exists('trx_addons_widget_generator_add_page_template')) {
	add_filter( 'theme_page_templates', 'trx_addons_widget_generator_add_page_template');
	function trx_addons_widget_generator_add_page_template( $templates ) {
		$templates['widget_generator'] = __('Widget Generator', 'trx_addons');
		return $templates;
	}
}


// Redirect current page to the Widget Generator
if (!function_exists('trx_addons_widget_generator_get_page_template')) {
	add_filter('page_template', 'trx_addons_widget_generator_get_page_template', 2000);
	function trx_addons_widget_generator_get_page_template($template) {
		if (($GLOBALS['TRX_ADDONS_STORAGE']['_wp_page_template'] = get_post_meta(get_the_ID(), '_wp_page_template', true)) == 'widget_generator') {
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/tpl.widget_generator.php');
		}
		return $template;
	}
}
	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_generator_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_generator_load_scripts_front', 11);
	function trx_addons_widget_generator_load_scripts_front() {
		if ($GLOBALS['TRX_ADDONS_STORAGE']['_wp_page_template']=='widget_generator') {
			wp_enqueue_script('trx_addons-widget_themes', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget.themes.js'), array(), null, true );
			wp_enqueue_style( 'trx_addons-widget_generator', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget_generator.css'), array(), null );
			wp_enqueue_script('trx_addons-widget_generator', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget_generator.js'), array('jquery'), null, true );
			$GLOBALS['TRX_ADDONS_STORAGE']['widget_generator_uid'] = trx_addons_rest_get_uid();
			wp_localize_script( 'trx_addons-widget_generator', 'TRX_ADDONS_WIDGET_GENERATOR', apply_filters('trx_addons_localize_script_widget_generator', array(
				'uid' => $GLOBALS['TRX_ADDONS_STORAGE']['widget_generator_uid'],
				'logo' => trx_addons_get_option('themes_market_logo'),
				'logo_link' => trx_addons_get_option('themes_market_logo_link'),
				'downloads_url' => home_url(),					// A site root url
				'widget_url' => trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget.themes.js'),
				'msg_clipboard_success' => esc_html__('The code has been successfully copied to the clipboard', 'trx_addons'),
				'msg_clipboard_error' => esc_html__('Error when copying code to the clipboard. Try to copy the code manually', 'trx_addons'),
				'msg_clipboard_unable' => esc_html__('Your browser does not support copying via JS. Try to copy the code manually', 'trx_addons'),
				'msg_no_themes' => esc_html__('No themes found', 'trx_addons'),
				'msg_error_fields' => esc_html__('Please, fill at least fields "Name" and "E-mail"', 'trx_addons'),
				'msg_error_service_unavailable' => esc_html__('Service temporary unavailable!', 'trx_addons'),
				'msg_error_incorrect_answer' => esc_html__('Incorrect server answer', 'trx_addons'),
				'msg_error_wait_for_answer' => esc_html__('Waiting for server answer!', 'trx_addons'),
				'msg_order_accepted' => esc_html__('Your request has been accepted. In the near future our manager will contact you', 'trx_addons'),
				'msg_error_unsupported_platform' => esc_html__('Unsupported platform: Unable to do remote requests because there is no XMLHTTPRequest implementation in your browser', 'trx_addons'),
				'msg_order_site' => esc_html__('Order site', 'trx_addons'),
				'msg_order_now' => esc_html__('Order now', 'trx_addons'),
				'msg_buy_now' => esc_html__('Buy now', 'trx_addons'),
				'msg_view_demo' => esc_html__('View demo', 'trx_addons'),
				'msg_field_label_name' => esc_html__('Name', 'trx_addons'),
				'msg_field_placeholder_name' => esc_html__('Your name', 'trx_addons'),
				'msg_field_label_email' => esc_html__('E-mail', 'trx_addons'),
				'msg_field_placeholder_email' => esc_html__('Your e-mail', 'trx_addons'),
				'msg_field_label_phone' => esc_html__('Phone', 'trx_addons'),
				'msg_field_placeholder_phone' => esc_html__('Your phone number', 'trx_addons'),
				'msg_field_label_message' => esc_html__('Additional info', 'trx_addons'),
				'msg_field_placeholder_message' => esc_html__('Additional information about your order', 'trx_addons'),
				'msg_field_button_order' => esc_html__('Order now', 'trx_addons'),
				'msg_email_subject' => esc_html__('Order the website "%s"', 'trx_addons'),
				'msg_email_text' => esc_html__('Hello, guys! I want to order the website "%s"', 'trx_addons')
				) )
			);
		}
	}
}
?>