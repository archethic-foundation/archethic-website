<?php

/*
Widget Name: Testimonials Slider
Description: Display responsive touch friendly slider of testimonials from clients/customers.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


class LVCA_Testimonials_Slider {

    protected $_per_line;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_testimonials_slider', array($this, 'shortcode_func'));

        add_shortcode('lvca_testimonial_slide', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-flexslider', LVCA_PLUGIN_URL . 'assets/js/jquery.flexslider' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-flexslider', LVCA_PLUGIN_URL . 'assets/css/flexslider.css', array(), LVCA_VERSION);

        wp_enqueue_script('lvca-testimonials-slider', plugin_dir_url(__FILE__) . 'js/testimonials' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-testimonials-slider', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        //$slideshow_speed = $animation_speed = $animation = $pause_on_action = $pause_on_hover = $direction_nav = $control_nav = '';

        $settings = shortcode_atts(array(
            'slideshow_speed' => 5000,
            'animation_speed' => 600,
            'animation' => 'slide',
            'pause_on_action' => '',
            'pause_on_hover' => '',
            'direction_nav' => '',
            'control_nav' => '',

        ), $atts);


        $output = '<div class="lvca-testimonials-slider lvca-flexslider lvca-container"  data-settings=\'' . wp_json_encode($settings) . '\'>';

        $output .= '<div class="lvca-slides">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        $output .= '</div>';

        return apply_filters('lvca_testimonials_slider_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $author = $credentials = $author_image = '';
        $settings = shortcode_atts(array(
            'author' => '',
            'credentials' => '',
            'author_image' => ''

        ), $atts);

        extract($settings);

        if (function_exists('wpb_js_remove_wpautop'))
            $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

        $output = '<div class="lvca-slide lvca-testimonial-wrapper">';

        $output .= '<div class="lvca-testimonial">';

        $output .= '<div class="lvca-testimonial-text">';

        $output .= '<i class="lvca-icon-quote"></i>';

        $output .= wp_kses_post($content);

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

        $output .= '</div>';

        return apply_filters('lvca_testimonials_slide_output', $output, $content, $settings);
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Testimonials Slider", "livemesh-vc-addons"),
                "base" => "lvca_testimonials_slider",
                "as_parent" => array('only' => 'lvca_testimonial_slide'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Capture client testimonials in a slider.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-testimonials-slider',
                "params" => array(

                    array(
                        'type' => 'lvca_number',
                        "param_name" => "slideshow_speed",
                        'heading' => __('Slideshow speed', 'livemesh-vc-addons'),
                        'value' => 5000
                    ),

                    array(
                        'type' => 'lvca_number',
                        "param_name" => "animation_speed",
                        'heading' => __('Animation Speed', 'livemesh-vc-addons'),
                        'value' => 600
                    ),

                    array(
                        'type' => 'checkbox',
                        "param_name" => "pause_on_action",
                        'heading' => __('Pause slider on action.', 'livemesh-vc-addons'),
                        'description' => __('Should the slideshow pause once user initiates an action using navigation/direction controls.', 'livemesh-vc-addons'),
                        "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    ),

                    array(
                        'type' => 'checkbox',
                        "param_name" => "pause_on_hover",
                        'heading' => __('Pause on Hover', 'livemesh-vc-addons'),
                        'description' => __('Should the slider pause on mouse hover over the slider.', 'livemesh-vc-addons'),
                        "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    ),

                    array(
                        'type' => 'checkbox',
                        "param_name" => "direction_nav",
                        'heading' => __('Direction Navigation', 'livemesh-vc-addons'),
                        'description' => __('Should the slider have direction navigation.', 'livemesh-vc-addons'),
                        "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    ),

                    array(
                        'type' => 'checkbox',
                        "param_name" => "control_nav",
                        'heading' => __('Navigation Controls', 'livemesh-vc-addons'),
                        'description' => __('Should the slider have navigation controls.', 'livemesh-vc-addons'),
                        "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Testimonial Slide", "livemesh-vc-addons"),
                    "base" => "lvca_testimonial_slide",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_testimonials_slider'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-testimonials-slide',
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
    class WPBakeryShortCode_lvca_testimonials_slider extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_testimonial_slide extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Testimonials_Slider')) {
    new LVCA_Testimonials_Slider();
}