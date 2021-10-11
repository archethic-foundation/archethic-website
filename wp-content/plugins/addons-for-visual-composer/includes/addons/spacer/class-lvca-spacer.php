<?php

/*
Widget Name: Spacer
Description: Add spacer between rows and elements that changes based on device resolution.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Spacer {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_spacer', array($this, 'shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-spacer', plugin_dir_url(__FILE__) . 'js/spacer' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);
    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $settings = shortcode_atts(array(
            'desktop_spacing' => 50,
            'tablet_spacing' => 30,
            'tablet_width' => 960,
            'mobile_spacing' => 10,
            'mobile_width' => 480
        ), $atts);

        $uniqueid = uniqid();

        $output = '<div id="lvca-spacer-' . $uniqueid . '" class="lvca-spacer" data-settings=\'' . wp_json_encode($settings) . '\'></div>';

        return apply_filters('lvca_spacer_output', $output, $content, $settings);
    }


    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Spacer", "livemesh-vc-addons"),
                "base" => "lvca_spacer",
                "content_element" => true,
                "show_settings_on_create" => false,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                'description' => __('Add spacer between rows and elements.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-spacer',
                "params" => array(

                    array(
                        "type" => "lvca_number",
                        "heading" => __("Desktop Spacing", "livemesh-vc-addons"),
                        "description" => __("Space in pixels in Desktop Resolution", "livemesh-vc-addons"),
                        "param_name" => "desktop_spacing",
                        "admin_label" => true,
                        "value" => 50,
                        "min" => 1,
                        "max" => 500,
                        "suffix" => "px",
                    ),
                    array(
                        "type" => "lvca_number",
                        "heading" => __("Tablet Resolution", "livemesh-vc-addons"),
                        "description" => __("The resolution to treat as a tablet resolution", "livemesh-vc-addons"),
                        "param_name" => "tablet_width",
                        "admin_label" => true,
                        "value" => 960,
                        "min" => 600,
                        "max" => 1400,
                        "suffix" => "px",
                        "edit_field_class" => "vc_col-sm-6 vc_column"
                    ),
                    array(
                        "type" => "lvca_number",
                        "heading" => __("Tablet Spacing", "livemesh-vc-addons"),
                        "description" => __("Space in Tablet Resolution", "livemesh-vc-addons"),
                        "param_name" => "tablet_spacing",
                        "admin_label" => true,
                        "value" => 30,
                        "min" => 1,
                        "max" => 400,
                        "suffix" => "px",
                        "edit_field_class" => "vc_col-sm-6 vc_column"
                    ),
                    array(
                        "type" => "lvca_number",
                        "heading" => __("Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The resolution to treat as a mobile resolution", "livemesh-vc-addons"),
                        "param_name" => "mobile_width",
                        "admin_label" => true,
                        "value" => 480,
                        "min" => 320,
                        "max" => 800,
                        "suffix" => "px",
                        "edit_field_class" => "vc_col-sm-6 vc_column"
                    ),
                    array(
                        "type" => "lvca_number",
                        "heading" => __("Mobile Spacing", "livemesh-vc-addons"),
                        "description" => __("Space in Mobile Resolution", "livemesh-vc-addons"),
                        "param_name" => "mobile_spacing",
                        "admin_label" => true,
                        "value" => 10,
                        "min" => 1,
                        "max" => 300,
                        "suffix" => "px",
                        "edit_field_class" => "vc_col-sm-6 vc_column"
                    ),
                ),
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_spacer extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Spacer')) {
    new LVCA_Spacer();
}