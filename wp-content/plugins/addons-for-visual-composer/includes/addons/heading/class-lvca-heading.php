<?php

/*
Widget Name: Heading
Description: Create heading for display on the top of a section.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Heading {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_heading', array($this, 'shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-heading', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $heading = $style = $align = $subtitle = $short_text = $animation = '';

        $settings = shortcode_atts(array(

            'heading' => '',
            'subtitle' => false,
            'short_text' => false,
            'style' => 'style1',
            'align' => 'center',
            'animation' => 'none'

        ), $atts);

        extract($settings);

        list($animate_class, $animation_attr) = lvca_get_animation_atts($animation);

        $output = '<div class="lvca-heading lvca-' . $style . ' lvca-align' . $align . ' ' . $animate_class . '" ' . $animation_attr . '>';

        if ($style == 'style2' && !empty($subtitle)):

            $output .= '<div class="lvca-subtitle">' . esc_html($subtitle) . '</div>';

        endif;

        $output .= '<h3 class="lvca-title">' . wp_kses_post($heading) . '</h3>';

        if ($style != 'style3' && !empty($short_text)):

            $output .= '<p class="lvca-text">' . wp_kses_post($short_text) . '</p>';

        endif;

        $output .= '</div>';


        return apply_filters('lvca_heading_output', $output, $content, $settings);
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Heading", "livemesh-vc-addons"),
                "base" => "lvca_heading",
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                'description' => __('Create heading for a section.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-heading',
                "params" => array(
                    // add params same as with any other content element
                    array(
                        'type' => 'textfield',
                        'param_name' => 'heading',
                        "admin_label" => true,
                        'heading' => __('Title', 'livemesh-vc-addons'),
                        'description' => __('Title for the heading.', 'livemesh-vc-addons'),
                    ),
                    array(
                        'type' => 'textfield',
                        'param_name' => 'subtitle',
                        'heading' => __('Subheading or Subtitle', 'livemesh-vc-addons'),
                        'description' => __('A subtitle displayed above the title heading.', 'livemesh-vc-addons'),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'style2',
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'param_name' => 'short_text',
                        'heading' => __('Short Text', 'livemesh-vc-addons'),
                        'description' => __('Short text generally displayed below the heading title.', 'livemesh-vc-addons'),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('style1', 'style2'),
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of heading you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
                            __('Style 3', 'livemesh-vc-addons') => 'style3',
                        ),
                        'std' => 'style1',
                        'group' => __('Settings', 'livemesh-vc-addons')
                    ),
                    array(
                        "type" => "dropdown",
                        "param_name" => "align",
                        "heading" => __("Align", "livemesh-vc-addons"),
                        "description" => __("Alignment of the heading", "livemesh-vc-addons"),
                        'value' => array(
                            __('Center', 'livemesh-vc-addons') => 'center',
                            __('Left', 'livemesh-vc-addons') => 'left',
                            __('Right', 'livemesh-vc-addons') => 'right',
                        ),
                        'std' => 'center',
                        'group' => __('Settings', 'livemesh-vc-addons')
                    ),
                    array(
                        "type" => "dropdown",
                        "param_name" => "animation",
                        "heading" => __("Choose Animation Type", "livemesh-vc-addons"),
                        'value' => lvca_get_animation_options(),
                        'std' => 'none',
                        'group' => __('Settings', 'livemesh-vc-addons')
                    ),
                ),
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_heading extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Heading')) {
    new LVCA_Heading();
}