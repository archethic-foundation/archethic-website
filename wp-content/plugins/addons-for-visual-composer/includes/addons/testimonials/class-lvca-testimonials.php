<?php

/*
Widget Name: Testimonials
Description: Display testimonials from your clients/customers in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


class LVCA_Testimonials {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_testimonials', array($this, 'shortcode_func'));

        add_shortcode('lvca_testimonial', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-testimonials', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $settings = shortcode_atts(array(
            'per_line' => '3',
            'per_line_tablet' => '2',
            'per_line_mobile' => '1',

        ), $atts);

        extract($settings);

        $output = '<div class="lvca-testimonials lvca-grid-container ' . lvca_get_grid_classes($settings) . '">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        return apply_filters('lvca_testimonials_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $author = $credentials = $author_image = $animation = '';
        $settings = shortcode_atts(array(
            'author' => '',
            'credentials' => '',
            'author_image' => '',
            'animation' => 'none'

        ), $atts);

        extract($settings);

        list($animate_class, $animation_attr) = lvca_get_animation_atts($animation);

        if (function_exists('wpb_js_remove_wpautop'))
            $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

        $output = '<div class="lvca-grid-item lvca-testimonial ' . $animate_class . '" ' . $animation_attr . '>';

        $output .= '<div class="lvca-testimonial-text">';

        $output .= do_shortcode(wp_kses_post($content));

        $output .= '</div>';

        $output .= '<div class="lvca-testimonial-user">';

        $output .= '<div class="lvca-image-wrapper">';

        $output .= wp_get_attachment_image($author_image, 'thumbnail', false, array('class' => 'lvca-image full'));

        $output .= '</div>';

        $output .= '<div class="lvca-text">';

        $output .= '<h4 class="lvca-author-name">' . esc_html($author) . '</h4>';

        $output .= '<div class="lvca-author-credentials">' . wp_kses_post($credentials) . '</div>';

        $output .= '</div>';

        $output .= '</div>';

        $output .= '</div>';

        return apply_filters('lvca_testimonial_output', $output, $content, $settings);

    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Testimonials", "livemesh-vc-addons"),
                "base" => "lvca_testimonials",
                "as_parent" => array('only' => 'lvca_testimonial'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display testimonials in a multi - column grid . ', 'livemesh - vc - addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-testimonials',
                "params" => array(
                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 3,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Testimonials per row", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the testimonials", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_tablet",
                        "value" => 2,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Testimonials per row in Tablet Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the testimonials in tablet resolution", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_mobile",
                        "value" => 1,
                        "min" => 1,
                        "max" => 4,
                        "suffix" => '',
                        "heading" => __("Testimonials per row in Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the testimonials in mobile resolution", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Testimonial", "my-text-domain"),
                    "base" => "lvca_testimonial",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_testimonials'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-testimonial',
                    "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'author',
                            "admin_label" => true,
                            'heading' => __('Name', 'livemesh - vc - addons'),
                            'description' => __('The author of the testimonial', 'livemesh - vc - addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'credentials',
                            'heading' => __('Author Details', 'livemesh - vc - addons'),
                            'description' => __('The details of the author like company name, position held, company URL etc . ', 'livemesh - vc - addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'author_image',
                            'heading' => __('Author Image', 'livemesh - vc - addons'),
                        ),
                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Text', 'livemesh - vc - addons'),
                            'description' => __('What your client / customer has to say', 'livemesh - vc - addons'),
                        ),
                        array(
                            "type" => "dropdown",
                            "param_name" => "animation",
                            "heading" => __("Choose Animation Type", "livemesh-vc-addons"),
                            'value' => lvca_get_animation_options(),
                            'std' => 'none',
                            'group' => __('Settings', 'livemesh - vc - addons')
                        ),
                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_testimonials extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_testimonial extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Testimonials')) {
    new LVCA_Testimonials();
}