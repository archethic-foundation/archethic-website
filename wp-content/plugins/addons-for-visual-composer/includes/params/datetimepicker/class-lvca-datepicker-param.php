<?php

if (!class_exists('LVCA_Date_Picker_Param')) {

    class LVCA_Date_Picker_Param {

        function __construct() {

            if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('lvca_date_picker', array(&$this, 'date_picker_field'), plugins_url('js/datepicker-field' . LVCA_JS_SUFFIX . '.js',__FILE__));
                }
            }
            else {
                if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('lvca_date_picker', array(&$this, 'date_picker_field'), plugins_url('js/datepicker-field' . LVCA_JS_SUFFIX . '.js',__FILE__));
                }
            }

            add_action('admin_enqueue_scripts', array($this, 'load_scripts'));

        }

        function load_scripts() {

            /* load jQuery-ui datepicker */
            wp_enqueue_script('jquery-ui-datepicker');

            wp_enqueue_style('lvca-datepicker-css', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', false, "1.11.4", false);
        }

        function date_picker_field($settings, $value) {

            $defaults = array(
                'param_name' => '',
                'type' => '',
                'value' => 0,
                'class' => '',
            );
            $settings = wp_parse_args($settings, $defaults);

            $output = '<div class="lvca-date_picker-wrap">';

            $output .= '<input type="text" class="wpb_vc_param_value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . ' ' . esc_attr($settings['class']) . '" name="' . esc_attr($settings['param_name']) . '" value="' . esc_attr($value) . '"/>';

            $output .= '</div>';

            return $output;
        }

    }
}


// Initialize Date_Picker Paramater Class
if (class_exists('LVCA_Date_Picker_Param')) {
    new LVCA_Date_Picker_Param();
}
