<?php

/*
Widget Name: Piecharts
Description: Display one or more piecharts depicting a percentage value in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Piecharts {

    protected $_bar_color;
    protected $_track_color;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_piecharts', array($this, 'shortcode_func'));

        add_shortcode('lvca_piechart_item', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-waypoints', LVCA_PLUGIN_URL . 'assets/js/jquery.waypoints' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-stats', LVCA_PLUGIN_URL . 'assets/js/jquery.stats' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-piecharts', plugin_dir_url(__FILE__) . 'js/piechart' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-piecharts', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $bar_color = $track_color = '';

        $settings = shortcode_atts(array(
            'per_line' => '4',
            'per_line_tablet' => '2',
            'per_line_mobile' => '1',
            'bar_color' => '#f94213',
            'track_color' => '#dddddd',

        ), $atts);

        extract($settings);

        $this->_bar_color = $bar_color;
        $this->_track_color = $track_color;

        $output = '<div class="lvca-piecharts lvca-grid-container ' . lvca_get_grid_classes($settings) . '">';

        $output .= do_shortcode($content);

        $output .= '</div>';


        return apply_filters('lvca_piecharts_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $stats_title = $percentage = '';
        $settings = shortcode_atts(array(
            'stats_title' => '',
            'percentage' => 50

        ), $atts);

        extract($settings);

        $bar_color = ' data-bar-color="' . esc_attr($this->_bar_color) . '"';
        $track_color = ' data-track-color="' . esc_attr($this->_track_color) . '"';

        $output = '<div class="lvca-grid-item lvca-piechart">';

        $output .= '<div class="lvca-percentage" ' . $bar_color . $track_color . ' data-percent = "' . round($percentage) . '">';

        $output .= '<span>' . round($percentage) . '<sup>%</sup></span>';

        $output .= '</div>';

        $output .= '<div class="lvca-label">' . esc_html($stats_title) . '</div>';

        $output .= '</div>';

        return apply_filters('lvca_piechart_output', $output, $content, $settings);

    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Piecharts", "livemesh-vc-addons"),
                "base" => "lvca_piecharts",
                "as_parent" => array('only' => 'lvca_piechart_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display piecharts in a multi-column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-piecharts',
                "params" => array(

                    array(
                        'type' => 'colorpicker',
                        'param_name' => 'bar_color',
                        'heading' => __('Bar color', 'livemesh-vc-addons'),
                        'value' => '#f94213'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'param_name' => 'track_color',
                        'heading' => __('Track color', 'livemesh-vc-addons'),
                        'value' => '#dddddd'
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 4,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Piecharts per row", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the piecharts", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_tablet",
                        "value" => 2,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Piecharts per row in Tablet Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the piecharts in tablet resolution", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_mobile",
                        "value" => 1,
                        "min" => 1,
                        "max" => 4,
                        "suffix" => '',
                        "heading" => __("Piecharts per row in Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the piecharts in mobile resolution", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Pierchart", "livemesh-vc-addons"),
                    "base" => "lvca_piechart_item",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_piecharts'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-piechart',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'stats_title',
                            "admin_label" => true,
                            'heading' => __('Stats Title', 'livemesh-vc-addons'),
                            'description' => __('Title for the piechart.', 'livemesh-vc-addons'),
                        ),
                        array(
                            "type" => "lvca_number",
                            "param_name" => "percentage",
                            "value" => 50,
                            "min" => 0,
                            "max" => 100,
                            "suffix" => '%',
                            "heading" => __("Percentage Value", "livemesh-vc-addons"),
                            "description" => __("The percentage value for the piechart . ", "livemesh-vc-addons")
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_piecharts extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_piechart_item extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Piecharts')) {
    new LVCA_Piecharts();
}