<?php

/*
Widget Name: Services
Description: Capture services in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
class LVCA_Services
{
    /**
     * Get things started
     */
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
        add_shortcode( 'lvca_services', array( $this, 'shortcode_func' ) );
        add_shortcode( 'lvca_service_item', array( $this, 'child_shortcode_func' ) );
        add_action( 'init', array( $this, 'map_vc_element' ) );
        add_action( 'init', array( $this, 'map_child_vc_element' ) );
    }
    
    function load_scripts()
    {
        wp_enqueue_script(
            'lvca-services',
            plugin_dir_url( __FILE__ ) . 'js/services' . LVCA_JS_SUFFIX . '.js',
            array( 'jquery' ),
            LVCA_VERSION
        );
        wp_enqueue_style(
            'lvca-services',
            plugin_dir_url( __FILE__ ) . 'css/style.css',
            array(),
            LVCA_VERSION
        );
    }
    
    public function shortcode_func( $atts, $content = null, $tag = "" )
    {
        $defaults = array(
            'per_line'        => '3',
            'per_line_tablet' => '2',
            'per_line_mobile' => '1',
            'style'           => 'style1',
            'icon_size'       => '',
            'icon_color'      => '',
            'hover_color'     => '',
        );
        $settings = shortcode_atts( $defaults, $atts );
        $output = '<div id="lvca-services' . uniqid() . '" data-settings=\'' . htmlspecialchars( json_encode( $settings ) ) . '\' class="lvca-services lvca-' . $settings['style'] . ' lvca-grid-container ' . lvca_get_grid_classes( $settings ) . '">';
        $output .= do_shortcode( $content );
        $output .= '</div>';
        return apply_filters(
            'lvca_services_output',
            $output,
            $content,
            $settings
        );
    }
    
    public function child_shortcode_func( $atts, $content = null, $tag = "" )
    {
        $title = $excerpt = $icon_image = $icon_type = $icon_family = $animation = '';
        $settings = shortcode_atts( array(
            'icon_type'        => 'icon',
            'icon_image'       => '',
            'icon_family'      => 'fontawesome',
            "icon_fontawesome" => '',
            "icon_openiconic"  => '',
            "icon_typicons"    => '',
            "icon_entypo"      => '',
            "icon_linecons"    => '',
            'title'            => '',
            'excerpt'          => '',
            'animation'        => 'none',
        ), $atts );
        extract( $settings );
        list( $animate_class, $animation_attr ) = lvca_get_animation_atts( $animation );
        $icon_type = esc_html( $icon_type );
        if ( $icon_type == 'icon' && !empty(${'icon_' . $icon_family}) && function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
            vc_icon_element_fonts_enqueue( $icon_family );
        }
        $output = '<div class="lvca-grid-item lvca-service-wrapper">';
        $output .= '<div class="lvca-service ' . $animate_class . '" ' . $animation_attr . '>';
        
        if ( $icon_type == 'icon_image' ) {
            $output .= '<div class="lvca-image-wrapper">';
            $output .= wp_get_attachment_image(
                $icon_image,
                'full',
                false,
                array(
                'class' => 'lvca-image full',
            )
            );
            $output .= '</div>';
        } else {
            
            if ( !empty(${'icon_' . $icon_family}) ) {
                $output .= '<div class="lvca-icon-wrapper">';
                $output .= lvca_get_icon( ${'icon_' . $icon_family} );
                $output .= '</div>';
            }
        
        }
        
        $output .= '<div class="lvca-service-text">';
        $output .= '<h3 class="lvca-title">' . esc_html( $title ) . '</h3>';
        
        if ( !empty($content) ) {
            $output .= '<div class="lvca-service-details">' . wp_kses_post( $content ) . '</div>';
        } else {
            $output .= '<div class="lvca-service-details">' . wp_kses_post( $excerpt ) . '</div>';
        }
        
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        return apply_filters(
            'lvca_service_item_output',
            $output,
            $content,
            $settings
        );
    }
    
    function map_vc_element()
    {
        
        if ( function_exists( "vc_map" ) ) {
            $style_options = array(
                __( 'Style 1', 'livemesh-vc-addons' ) => 'style1',
                __( 'Style 2', 'livemesh-vc-addons' ) => 'style2',
                __( 'Style 3', 'livemesh-vc-addons' ) => 'style3',
            );
            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map( array(
                "name"                    => __( "Services", "livemesh-vc-addons" ),
                "base"                    => "lvca_services",
                "as_parent"               => array(
                'only' => 'lvca_service_item',
            ),
                "content_element"         => true,
                "show_settings_on_create" => true,
                "category"                => __( "Livemesh Addons", "livemesh-vc-addons" ),
                "is_container"            => true,
                'description'             => __( 'Display services in a column grid.', 'livemesh-vc-addons' ),
                "js_view"                 => 'VcColumnView',
                "icon"                    => 'icon-lvca-services',
                "params"                  => array(
                // add params same as with any other content element
                array(
                    "type"        => "dropdown",
                    "param_name"  => "style",
                    "heading"     => __( "Choose Style", "livemesh-vc-addons" ),
                    "description" => __( "Choose the particular style of services you need", "livemesh-vc-addons" ),
                    'value'       => $style_options,
                    'std'         => 'style1',
                ),
                array(
                    "type"        => "lvca_number",
                    "param_name"  => "per_line",
                    "value"       => 3,
                    "min"         => 1,
                    "max"         => 6,
                    "suffix"      => '',
                    "heading"     => __( "Services per row", "livemesh-vc-addons" ),
                    "description" => __( "The number of columns to display per row of the services", "livemesh-vc-addons" ),
                ),
                array(
                    "type"        => "lvca_number",
                    "param_name"  => "per_line_tablet",
                    "value"       => 2,
                    "min"         => 1,
                    "max"         => 6,
                    "suffix"      => '',
                    "heading"     => __( "Services per row in Tablet Resolution", "livemesh-vc-addons" ),
                    "description" => __( "The number of columns to display per row of the services in tablet resolution", "livemesh-vc-addons" ),
                ),
                array(
                    "type"        => "lvca_number",
                    "param_name"  => "per_line_mobile",
                    "value"       => 1,
                    "min"         => 1,
                    "max"         => 4,
                    "suffix"      => '',
                    "heading"     => __( "Services per row in Mobile Resolution", "livemesh-vc-addons" ),
                    "description" => __( "The number of columns to display per row of the services in mobile resolution", "livemesh-vc-addons" ),
                ),
                array(
                    "type"       => "lvca_number",
                    "param_name" => "icon_size",
                    "value"      => '',
                    "min"        => 1,
                    "max"        => 256,
                    "suffix"     => 'px',
                    "heading"    => __( "Icon size in pixels", "livemesh-vc-addons" ),
                    'group'      => __( 'Customize', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => __( 'Icon color', 'js_composer' ),
                    'param_name'  => 'icon_color',
                    'description' => __( 'Custom color for the font icon.', 'js_composer' ),
                    'group'       => __( 'Customize', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => __( 'Icon Hover color', 'js_composer' ),
                    'param_name'  => 'hover_color',
                    'description' => __( 'Custom hover color for the font icon.', 'js_composer' ),
                    'group'       => __( 'Customize', 'livemesh-vc-addons' ),
                ),
            ),
            ) );
        }
    
    }
    
    function map_child_vc_element()
    {
        if ( function_exists( "vc_map" ) ) {
            vc_map( array(
                "name"            => __( "Service", "my-text-domain" ),
                "base"            => "lvca_service_item",
                "content_element" => true,
                "as_child"        => array(
                'only' => 'lvca_services',
            ),
                "icon"            => 'icon-lvca-service',
                "params"          => array(
                // add params same as with any other content element
                array(
                    'type'        => 'textfield',
                    'param_name'  => 'title',
                    "admin_label" => true,
                    'heading'     => __( 'Title', 'livemesh-vc-addons' ),
                    'description' => __( 'Title of the service.', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'       => 'dropdown',
                    'param_name' => 'icon_type',
                    'heading'    => __( 'Choose Icon Type', 'livemesh-vc-addons' ),
                    'std'        => 'icon',
                    'value'      => array(
                    __( 'Icon', 'livemesh-vc-addons' )       => 'icon',
                    __( 'Icon Image', 'livemesh-vc-addons' ) => 'icon_image',
                ),
                ),
                array(
                    'type'       => 'attach_image',
                    'param_name' => 'icon_image',
                    'heading'    => __( 'Service Image.', 'livemesh-vc-addons' ),
                    "dependency" => array(
                    'element' => "icon_type",
                    'value'   => 'icon_image',
                ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => __( 'Icon library', 'livemesh-vc-addons' ),
                    'value'       => array(
                    __( 'Font Awesome', 'livemesh-vc-addons' ) => 'fontawesome',
                    __( 'Open Iconic', 'livemesh-vc-addons' )  => 'openiconic',
                    __( 'Typicons', 'livemesh-vc-addons' )     => 'typicons',
                    __( 'Entypo', 'livemesh-vc-addons' )       => 'entypo',
                    __( 'Linecons', 'livemesh-vc-addons' )     => 'linecons',
                ),
                    'std'         => 'fontawesome',
                    'param_name'  => 'icon_family',
                    'description' => __( 'Select icon library.', 'livemesh-vc-addons' ),
                    "dependency"  => array(
                    'element' => "icon_type",
                    'value'   => 'icon',
                ),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __( 'Icon', 'livemesh-vc-addons' ),
                    'param_name'  => 'icon_fontawesome',
                    'value'       => 'fa fa-info-circle',
                    'settings'    => array(
                    'emptyIcon'    => false,
                    'iconsPerPage' => 4000,
                ),
                    'dependency'  => array(
                    'element' => 'icon_family',
                    'value'   => 'fontawesome',
                ),
                    'description' => __( 'Select icon from library.', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __( 'Icon', 'livemesh-vc-addons' ),
                    'param_name'  => 'icon_openiconic',
                    'settings'    => array(
                    'emptyIcon'    => false,
                    'type'         => 'openiconic',
                    'iconsPerPage' => 4000,
                ),
                    'dependency'  => array(
                    'element' => 'icon_family',
                    'value'   => 'openiconic',
                ),
                    'description' => __( 'Select icon from library.', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __( 'Icon', 'livemesh-vc-addons' ),
                    'param_name'  => 'icon_typicons',
                    'settings'    => array(
                    'emptyIcon'    => false,
                    'type'         => 'typicons',
                    'iconsPerPage' => 4000,
                ),
                    'dependency'  => array(
                    'element' => 'icon_family',
                    'value'   => 'typicons',
                ),
                    'description' => __( 'Select icon from library.', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'       => 'iconpicker',
                    'heading'    => __( 'Icon', 'livemesh-vc-addons' ),
                    'param_name' => 'icon_entypo',
                    'settings'   => array(
                    'emptyIcon'    => false,
                    'type'         => 'entypo',
                    'iconsPerPage' => 4000,
                ),
                    'dependency' => array(
                    'element' => 'icon_family',
                    'value'   => 'entypo',
                ),
                ),
                array(
                    'type'        => 'iconpicker',
                    'heading'     => __( 'Icon', 'livemesh-vc-addons' ),
                    'param_name'  => 'icon_linecons',
                    'settings'    => array(
                    'emptyIcon'    => false,
                    'type'         => 'linecons',
                    'iconsPerPage' => 4000,
                ),
                    'dependency'  => array(
                    'element' => 'icon_family',
                    'value'   => 'linecons',
                ),
                    'description' => __( 'Select icon from library.', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'        => 'textarea_html',
                    'param_name'  => 'content',
                    'heading'     => __( 'Service description', 'livemesh-vc-addons' ),
                    'description' => __( 'Provide a short description for the service', 'livemesh-vc-addons' ),
                ),
                array(
                    "type"       => "dropdown",
                    "param_name" => "animation",
                    "heading"    => __( "Choose Animation Type", "livemesh-vc-addons" ),
                    'value'      => lvca_get_animation_options(),
                    'std'        => 'none',
                    'group'      => __( 'Settings', 'livemesh-vc-addons' ),
                ),
                array(
                    'type'        => 'textarea',
                    'param_name'  => 'excerpt',
                    'heading'     => __( 'Short description (field will be removed in future - move text to Service description)', 'livemesh-vc-addons' ),
                    'description' => __( 'Provide a short description for the service ', 'livemesh-vc-addons' ),
                    'group'       => __( 'Deprecated', 'livemesh-vc-addons' ),
                ),
            ),
            ) );
        }
    }

}
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_lvca_services extends WPBakeryShortCodesContainer
    {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_lvca_service_item extends WPBakeryShortCode
    {
    }
}
// Initialize Element Class
if ( class_exists( 'LVCA_Services' ) ) {
    new LVCA_Services();
}