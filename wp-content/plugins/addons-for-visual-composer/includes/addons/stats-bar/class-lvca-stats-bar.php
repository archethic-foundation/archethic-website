<?php

/*
Widget Name: Stats Bars
Description: Display multiple stats bars that talk about skills or other percentage stats.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Stats_Bars {


    protected $_default_bar_color;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_statsbars', array($this, 'shortcode_func'));

        add_shortcode('lvca_statsbar_item', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-waypoints', LVCA_PLUGIN_URL . 'assets/js/jquery.waypoints' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-stats-bar', plugin_dir_url(__FILE__) . 'js/stats-bar' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-stats-bar', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);
    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $default_bar_color = '';

        $settings = shortcode_atts(array(
            'default_bar_color' => '#fe5000',
        ), $atts);

        extract($settings);

        $this->_default_bar_color = $default_bar_color;

        $output = '<div class="lvca-stats-bars">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        return apply_filters('lvca_stats_bars_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $bar_color = $stats_title = $percentage = '';
        $settings = shortcode_atts(array(
            'stats_title' => '',
            'percentage' => 50,
            'bar_color' => false

        ), $atts);

        extract($settings);

        if (!empty($bar_color))
            $color_style = ' style="background:' . esc_attr($bar_color) . ';"';
        else
            $color_style = ' style="background:' . esc_attr($this->_default_bar_color) . ';"';

        $output = '<div class="lvca-stats-bar">';

        $output .= '<div class="lvca-stats-title">';

        $output .= esc_html($stats_title);

        $output .= '<span>' . esc_attr($percentage) . '%</span>';

        $output .= '</div>';

        $output .= '<div class="lvca-stats-bar-wrap">';

        $output .= '<div ' . $color_style . ' class="lvca-stats-bar-content" data-perc="' . esc_attr($percentage) . '"></div>';

        $output .= '<div class="lvca-stats-bar-bg"></div>';

        $output .= '</div>';

        $output .= '</div>';

        return apply_filters('lvca_stats_bar_output', $output, $content, $settings);

    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Stats Bars", "livemesh-vc-addons"),
                "base" => "lvca_statsbars",
                "as_parent" => array('only' => 'lvca_statsbar_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => false,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display stats bars of skills or percentage stats.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-statsbars',
                "params" => array(

                    array(
                        'type' => 'colorpicker',
                        'param_name' => 'default_bar_color',
                        'heading' => __('Default Bar color', 'livemesh-vc-addons'),
                        'description' => __('The default bar color to be used if none specified for individual stats bars', 'livemesh-vc-addons'),
                        'value' => '#fe5000'
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Stats Bar", "my-text-domain"),
                    "base" => "lvca_statsbar_item",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_statsbars'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-statsbar',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'stats_title',
                            "admin_label" => true,
                            'heading' => __('Stats Title', 'livemesh-vc-addons'),
                            'description' => __('Title for the stats bar.', 'livemesh-vc-addons'),
                        ),
                        array(
                            "type" => "lvca_number",
                            "param_name" => "percentage",
                            "value" => 50,
                            "min" => 0,
                            "max" => 100,
                            "suffix" => '%',
                            "heading" => __("Percentage Value", "livemesh-vc-addons"),
                            "description" => __("The percentage value for the stats.", "livemesh-vc-addons")
                        ),
                        array(
                            'type' => 'colorpicker',
                            'param_name' => 'bar_color',
                            'heading' => __('Bar color', 'livemesh-vc-addons'),
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_statsbars extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_statsbar_item extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Stats_Bars')) {
    new LVCA_Stats_Bars();
}