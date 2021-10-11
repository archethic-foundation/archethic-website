<?php

/*
Widget Name: Clients
Description: Display list of your clients in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Clients {

    protected $_animation;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_clients', array($this, 'shortcode_func'));

        add_shortcode('lvca_single_client', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-clients', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $bar_color = $track_color = $animation = '';

        $settings = shortcode_atts(array(
            'per_line' => '4',
            'per_line_tablet' => '3',
            'per_line_mobile' => '2',
            'animation' => 'none'

        ), $atts);

        extract($settings);

        $this->_animation = $animation;

        $output = '<div class="lvca-clients lvca-gapless-grid">';

        $output .= '<div class="lvca-grid-container ' . lvca_get_grid_classes($settings) . '">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        $output .= '</div><!-- .lvca-clients -->';

        return apply_filters('lvca_clients_output', $output, $content, $settings);

    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $client_name = $client_image = $client_url = '';
        $settings = shortcode_atts(array(
            'client_name' => '',
            'client_url' => false,
            'client_image' => ''

        ), $atts);

        extract($settings);

        list($animate_class, $animation_attr) = lvca_get_animation_atts($this->_animation);

        $output = '<div class="lvca-grid-item lvca-client ' . $animate_class . '" ' . $animation_attr . '>';

        if (!empty($client_image)):

            $output .= wp_get_attachment_image($client_image, 'full', false, array('class' => 'lvca-image full', 'alt' => $client_name));

        endif;

        if (!empty($client_url) && function_exists('vc_build_link')):

            $output .= '<div class="lvca-client-name">';

            $client_url = vc_build_link($client_url);

            $output .= '<a href="' . esc_url($client_url['url'])
                . ' " title="' . esc_html($client_url['title'])
                . ' " target="' . esc_html($client_url['target'])
                . '" rel="nofollow">' . wp_kses_post($client_name) . '</a>';

            $output .= '</div>';

        else:

            $output .= '<div class="lvca-client-name">' . wp_kses_post($client_name) . '</div>';

        endif;

        $output .= '<div class="lvca-image-overlay"></div>';

        $output .= '</div><!-- .lvca-client -->';

        return apply_filters('lvca_client_item_output', $output, $content, $settings);
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Clients", "livemesh-vc-addons"),
                "base" => "lvca_clients",
                "as_parent" => array('only' => 'lvca_single_client'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display clients in a multi-column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-clients',
                "params" => array(

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 5,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Clients per row", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the clients", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_tablet",
                        "value" => 4,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Clients per row in Tablet Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the clients in tablet resolution", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_mobile",
                        "value" => 2,
                        "min" => 1,
                        "max" => 4,
                        "suffix" => '',
                        "heading" => __("Clients per row in Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the clients in mobile resolution", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "dropdown",
                        "param_name" => "animation",
                        "heading" => __("Choose Animation Type", "livemesh-vc-addons"),
                        'value' => lvca_get_animation_options(),
                        'std' => 'none',
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Client", "my-text-domain"),
                    "base" => "lvca_single_client",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_clients'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-client',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'client_name',
                            "admin_label" => true,
                            'heading' => __('Name', 'livemesh-vc-addons'),
                            'description' => __('Name of the client/customer.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'vc_link',
                            'param_name' => 'client_url',
                            'heading' => __('Client URL', 'livemesh-vc-addons'),
                            'description' => __('The website of the client/customer.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'client_image',
                            'heading' => __('Client Logo.', 'livemesh-vc-addons'),
                            'description' => __('The logo image for the client/customer.', 'livemesh-vc-addons'),
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_clients extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_single_client extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Clients')) {
    new LVCA_Clients();
}