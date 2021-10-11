<?php

/*
Widget Name: Team Members
Description: Display a list of your team members optionally in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


class LVCA_Team {

    protected $_style;
    protected $_image_size;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_team', array($this, 'shortcode_func'));

        add_shortcode('lvca_team_member', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-team-members', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $style = $image_size = '';

        $settings = shortcode_atts(array(
            'per_line' => '3',
            'per_line_tablet' => '2',
            'per_line_mobile' => '1',
            'style' => 'style1',
            'image_size' => 'large',

        ), $atts);

        extract($settings);

        $this->_style = $style;
        $this->_image_size = $image_size;

        $container_style = 'lvca-container';

        if ($style == 'style1'):

            $container_style = 'lvca-grid-container' . lvca_get_grid_classes($settings);

        endif;

        $output = '<div class="lvca-team-members lvca-' . $style . ' ' . $container_style . '">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        return apply_filters('lvca_team_members_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag = "") {

        $member_name = $member_image = $member_details = $member_position = $member_email = $animation = '';

        $settings = shortcode_atts(array(
            'member_name' => '',
            'member_image' => '',
            'member_details' => '',
            "member_position" => '',
            'member_email' => false,
            'facebook_url' => false,
            'twitter_url' => false,
            'flickr_url' => false,
            'youtube_url' => false,
            'linkedin_url' => false,
            'googleplus_url' => false,
            'vimeo_url' => false,
            'instagram_url' => false,
            'behance_url' => false,
            'pinterest_url' => false,
            'skype_url' => false,
            'dribbble_url' => false,
            'animation' => 'none',

        ), $atts);

        extract($settings);

        $style = $this->_style;

        $item_style = '';

        if ($style == 'style1') {
            $item_style = 'lvca-grid-item';
        }

        list($animate_class, $animation_attr) = lvca_get_animation_atts($animation);

        $output = '<div class="' . $item_style . ' lvca-team-member-wrapper">';

        $output .= '<div class="lvca-team-member ' . $animate_class . '" ' . $animation_attr . '>';

        $output .= '<div class="lvca-image-wrapper">';

        $output .= wp_get_attachment_image($member_image, $this->_image_size, false, array('class' => 'lvca-image full'));

        if ($style == 'style1'):

            ob_start();

            include 'social-profile.php';

            $output .= ob_get_clean();

        endif;

        $output .= '</div>';

        $output .= '<div class="lvca-team-member-text">';

        $output .= '<h3 class="lvca-title">' . esc_html($member_name) . '</h3>';

        $output .= '<div class="lvca-team-member-position">';

        $output .= esc_html($member_position);

        $output .= '</div>';

        $output .= '<div class="lvca-team-member-details">';

        $output .= wp_kses_post($member_details);

        $output .= '</div>';

        if ($style == 'style2'):

            ob_start();

            include 'social-profile.php';

            $output .= ob_get_clean();

        endif;

        $output .= '</div>';

        $output .= '</div>';

        $output .= '</div>';

        return apply_filters('lvca_team_member_output', $output, $content, $settings);

    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Team Members", "livemesh-vc-addons"),
                "base" => "lvca_team",
                "as_parent" => array('only' => 'lvca_team_member'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Create team members.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-team',
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of team you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
                        ),
                        'std' => 'style1',
                    ),
                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 3,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Team Members per row", "livemesh-vc-addons"),
                        "description" => __("The number of team members to display per row of the team", "livemesh-vc-addons"),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'style1',
                        ),
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_tablet",
                        "value" => 2,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Team Members per row in Tablet Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of team members to display per row of the team in tablet resolution", "livemesh-vc-addons"),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'style1',
                        ),
                    ),

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line_mobile",
                        "value" => 1,
                        "min" => 1,
                        "max" => 4,
                        "suffix" => '',
                        "heading" => __("Team Members per row in Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The number of team members to display per row of the team in mobile resolution", "livemesh-vc-addons"),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'style1',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'param_name' => 'image_size',
                        'heading' => __('Image Size', 'livemesh-vc-addons'),
                        'std' => 'large',
                        'value' => lvca_get_image_sizes()
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Team Member", "my-text-domain"),
                    "base" => "lvca_team_member",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_team'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-team-member',
                    "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'member_name',
                            "admin_label" => true,
                            'heading' => __('Team Member Name', 'livemesh-vc-addons'),
                            'description' => __('Name of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'member_image',
                            'heading' => __('Team Member Image.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'member_position',
                            'heading' => __('Position', 'livemesh-vc-addons'),
                            'description' => __('Specify the position/title of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea',
                            'param_name' => 'member_details',
                            'heading' => __('Short details', 'livemesh-vc-addons'),
                            'description' => __('Provide a short writeup for the team member', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'member_email',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Email Address', 'livemesh-vc-addons'),
                            'description' => __('Enter the email address of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'facebook_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Facebook Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Facebook page of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'twitter_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Twitter Profile URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Twitter page of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'linkedin_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('LinkedIn Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the LinkedIn profile of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'pinterest_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Pinterest Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Pinterest page for the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'dribbble_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Dribbble Profile URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Dribbble profile of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'google_plus_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('GooglePlus Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Google Plus page of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'instagram_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Instagram Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Instagram feed for the team member.', 'livemesh-vc-addons'),
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
    class WPBakeryShortCode_lvca_team extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_team_member extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Team')) {
    new LVCA_Team();
}