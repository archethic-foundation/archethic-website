<?php

/*
Widget Name: Pricing Table
Description: Display pricing plans in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Pricing_Table {

    protected $_per_line;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_pricing_item', array($this, 'pricing_item_shortcode'));

        add_shortcode('lvca_pricing_table', array($this, 'shortcode_func'));

        add_shortcode('lvca_pricing_plan', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-pricing-table', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    /* Should be used as child of lvca_pricing_table/lvca_pricing_plan shortcodes for right output buffering */
    public function pricing_item_shortcode($atts, $content = null, $tag = "") {

        $title = $value = '';

        $settings = shortcode_atts(array(
            'title' => '',
            'value' => ''

        ), $atts);

        extract($settings);

        $output = '<div class="lvca-pricing-item">';

        $output .= '<div class="lvca-title">';

        $output .= htmlspecialchars_decode(wp_kses_post($title));

        $output .= '</div>';

        $output .= '<div class="lvca-value-wrap">';

        $output .= '<div class="lvca-value">';

        $output .= htmlspecialchars_decode(wp_kses_post($value));

        $output .= '</div>';

        $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $settings = shortcode_atts(array(
            'per_line' => '4',
            'per_line_tablet' => '2',
            'per_line_mobile' => '1',

        ), $atts);

        extract($settings);

        $output = '<div class="lvca-pricing-table lvca-grid-container ' . lvca_get_grid_classes($settings) . '">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        return apply_filters('lvca_pricing_table_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $pricing_title = $tagline = $price_tag = $highlight = $button_text = $button_url = $button_new_window = $pricing_img = $animation = '';

        $settings = shortcode_atts(array(
            'pricing_title' => '',
            'tagline' => '',
            'price_tag' => '',
            "highlight" => '',
            "button_text" => '',
            "button_url" => '#',
            "button_new_window" => '',
            "pricing_img" => '',
            'animation' => 'none'

        ), $atts);

        extract($settings);

        list($animate_class, $animation_attr) = lvca_get_animation_atts($animation);

        $price_tag = htmlspecialchars_decode(wp_kses_post($price_tag));

        if (function_exists('vc_build_link')) {
            $pricing_url = vc_build_link($button_url);
            $pricing_button = '<a class="lvca-button" href="' . $pricing_url['url']
                . '" title="' . $pricing_url['title']
                . '" target="' . $pricing_url['target']
                . '">' . $button_text . '</a>';
        }
        else {
            $pricing_button = '<a class="lvca-button" href="' . $button_url
                . '" title="' . $pricing_title
                . '" target="_blank">' . $button_text
                . '</a>';
        }


        $output = '<div class="lvca-grid-item lvca-pricing-plan ' . (!empty($highlight) ? ' lvca-highlight' : '') . $animate_class . '" ' . $animation_attr . '>';

        $output .= '<div class="lvca-top-header" >';

        if (!empty($tagline))
            $output .= '<p class="lvca-tagline center" > ' . $tagline . '</p > ';

        $output .= '<h3 class="lvca-center" > ' . $pricing_title . '</h3 > ';

        if (!empty($pricing_img)) :
            $output .= wp_get_attachment_image($pricing_img, 'full', false, array('class' => 'lvca-image full', 'alt' => $pricing_title));
        endif;

        $output .= '</div>';

        $output .= '<h4 class="lvca-plan-price lvca-plan-header lvca-center">';

        $output .= '<span class="lvca-text">';

        $output .= wp_kses_post($price_tag);

        $output .= '</span>';

        $output .= '</h4>';

        $output .= '<div class="lvca-plan-details">';

        $output .= do_shortcode($content);

        $output .= '</div><!-- .lvca-plan-details -->';

        $output .= '<div class="lvca-purchase">';

        $output .= $pricing_button;

        $output .= '</div>';

        $output .= '</div><!-- .lvca-pricing-plan -->';

        return $output;

        return apply_filters('lvca_pricing_plan_output', $output, $content, $settings);
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Pricing Table", "livemesh-vc-addons"),
                "base" => "lvca_pricing_table",
                "as_parent" => array('only' => 'lvca_pricing_plan'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display pricing table in a multi-column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-pricing-table',
                "params" => array(

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 4,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Pricing Plans per row", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the pricing table", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_tablet",
                        "value" => 2,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Pricing Plans per row in Tablet Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the pricing table in tablet resolution", "livemesh-vc-addons")
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_mobile",
                        "value" => 1,
                        "min" => 1,
                        "max" => 4,
                        "suffix" => '',
                        "heading" => __("Pricing Plans per row in Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the pricing table in mobile resolution", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Pricing Plan", "my-text-domain"),
                    "base" => "lvca_pricing_plan",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_pricing_table'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-pricing',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'pricing_title',
                            'heading' => __('Pricing Plan Title', 'livemesh-vc-addons'),
                            'description' => __('The title for the pricing plan', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'tagline',
                            'heading' => __('Tagline Text', 'livemesh-vc-addons'),
                            'description' => __('Provide any subtitle or taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'pricing_img',
                            'heading' => __('Pricing Image', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'price_tag',
                            'heading' => __('Price Tag', 'livemesh-vc-addons'),
                            'description' => __('Enter the price tag for the pricing plan. HTML is accepted.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'checkbox',
                            'param_name' => 'highlight',
                            'heading' => __('Highlight Pricing Plan', 'livemesh-vc-addons'),
                            'description' => __('Specify if you want to highlight the pricing plan.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Pricing Plan Details', 'livemesh-vc-addons'),
                            'description' => __('Enter the content for the pricing plan that include information about individual features of the pricing plan. For prebuilt styling, enter shortcodes content like - [lvca_pricing_item title="Storage Space" value="50 GB"] [lvca_pricing_item title="Video Uploads" value="50"][lvca_pricing_item title="Portfolio Items" value="20"]', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'button_text',
                            'heading' => __('Text for Pricing Link/Button', 'livemesh-vc-addons'),
                            'description' => __('Provide the text for the link or the button shown for this pricing plan.', 'livemesh-vc-addons'),
                            'group' => 'Pricing Link'
                        ),

                        array(
                            'type' => 'vc_link',
                            'param_name' => 'button_url',
                            'heading' => __('URL for the Pricing link/button', 'livemesh-vc-addons'),
                            'description' => __('Provide the target URL for the link or the button shown for this pricing plan.', 'livemesh-vc-addons'),
                            'group' => 'Pricing Link'
                        ),

                        array(
                            'type' => 'checkbox',
                            'param_name' => 'button_new_window',
                            'heading' => __('Open Button URL in a new window', 'livemesh-vc-addons'),
                            'group' => 'Pricing Link'
                        ),
                        array(
                            "type" => "dropdown",
                            "param_name" => "animation",
                            "heading" => __("Choose Animation Type", "livemesh-vc-addons"),
                            'value' => lvca_get_animation_options(),
                            'std' => 'none',
                            'group' => __('Settings', 'livemesh-vc-addons')
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_pricing_table extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_pricing_plan extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Pricing_Table')) {
    new LVCA_Pricing_Table();
}