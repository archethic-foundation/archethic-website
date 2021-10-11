<?php

if (!class_exists('LVCA_Datetime_Picker_Param')) {

    class LVCA_Datetime_Picker_Param {

        function __construct() {

            if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('lvca_datetime_picker', array(&$this, 'datetime_picker_field'), plugins_url('js/timepicker-field' . LVCA_JS_SUFFIX . '.js', __FILE__));
                }
            }
            else {
                if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('lvca_datetime_picker', array(&$this, 'datetime_picker_field'), plugins_url('js/timepicker-field' . LVCA_JS_SUFFIX . '.js', __FILE__));
                }
            }

            add_action('admin_enqueue_scripts', array($this, 'load_scripts'));

        }

        function load_scripts() {

            /* load jQuery-ui datepicker */
            wp_enqueue_script('jquery-ui-datepicker');

            wp_enqueue_script('jquery-ui-slider');

            wp_enqueue_script('lvca-timepicker-addon', plugin_dir_url(__FILE__) . 'js/jquery-ui-timepicker-addon' . LVCA_JS_SUFFIX . '.js', array('jquery', 'jquery-ui-datepicker', 'jquery-ui-slider'), "1.6.3");

            wp_enqueue_style('lvca-timepicker-addon-css', plugin_dir_url(__FILE__) . 'css/jquery-ui-timepicker-addon.css', false, "1.6.3", false);

            wp_enqueue_style('lvca-datepicker-css', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', false, "1.11.4", false);
        }

        function datetime_picker_field($settings, $value) {

            $defaults = array(
                'param_name' => '',
                'type' => '',
                'value' => 0,
                'class' => '',
            );
            $settings = wp_parse_args($settings, $defaults);

            $output = '<div class="lvca-datetime_picker-wrap">';

            $output .= '<input type="text" class="wpb_vc_param_value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . ' ' . esc_attr($settings['class']) . '" name="' . esc_attr($settings['param_name']) . '" value="' . esc_attr($value) . '"/>';

            $output .= '</div>';

            return $output;
        }

    }
}


// Initialize Datetime_Picker Paramater Class
if (class_exists('LVCA_Datetime_Picker_Param')) {
    new LVCA_Datetime_Picker_Param();
}
