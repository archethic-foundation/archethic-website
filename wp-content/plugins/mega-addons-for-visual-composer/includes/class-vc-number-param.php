<?php
if (!class_exists('VC_Number_Param')) {
    class VC_Number_Param {
        function __construct() {
            if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('vc_number', array(&$this, 'number_field'));
                }
            }
            else {
                if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('vc_number', array(&$this, 'number_field'));
                }
            }
        }

        function number_field($settings, $value) {

            $defaults = array(
                'param_name' => '',
                'type' => '',
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'value' => 0,
                'suffix' => '',
                'class' => '',
            );
            $settings = wp_parse_args($settings, $defaults);

            $output = '<div class="lvca-number-wrap">';
            $output .= '<input type="number" min="' . esc_attr($settings['min']) . '" max="' . esc_attr($settings['max']) . '" step="' . esc_attr($settings['step']) . '" class="wpb_vc_param_value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . ' ' . esc_attr($settings['class']) . '" name="' . esc_attr($settings['param_name']) . '" value="' . esc_attr($value) . '"/>' . esc_attr($settings['suffix']);
            $output .= '</div>';
            return $output;
        }

    }
}


// Initialize Number Paramater Class
if (class_exists('VC_Number_Param')) {
    new VC_Number_Param();
}
