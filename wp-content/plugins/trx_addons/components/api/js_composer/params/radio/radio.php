<?php
/**
 * Plugin support: WPBakery Page Builder. Additional param's type 'radio': radiobuttons
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.28
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Add param's type to VC
if (!function_exists('trx_addons_vc_params_radio_init')) {
	add_action( 'init', 'trx_addons_vc_params_radio_init' );
	function trx_addons_vc_params_radio_init() {
		vc_add_shortcode_param( 'radio',
								'trx_addons_vc_params_radio_settings_field',
								trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'js_composer/params/radio/radio.js')
								);
	}
}

// Return param's field layout for VC editor
if (!function_exists('trx_addons_vc_params_radio_settings_field')) {
	function trx_addons_vc_params_radio_settings_field( $settings, $value ) {
		if (is_array($value) || $value=='Array') $value = "";
		$output = '<div class="trx_addons_vc_param_radio">'
					. '<input type="hidden"'
							. ' name="'.esc_attr($settings['param_name']).'"'
							. ' class="wpb_vc_param_value wpb-textinput '
									. esc_attr($settings['param_name'])
									. ' '
									. esc_attr($settings['type']).'_field"'
							. ' value="'.esc_attr($value).'" />';
		foreach ($settings['value'] as $title=>$slug)
			$output .= '<label>'
						. '<input type="radio"'
								. ' name="'.esc_attr($settings['param_name']).'_choices"'
								. ' value="'.esc_attr($slug).'"'
								. ($slug == $value ? ' checked="checked"' : '')
								. ' />'
						. esc_html($title)
						. '</label>';
		$output .= '</div>';
		return $output;
	}
}
?>