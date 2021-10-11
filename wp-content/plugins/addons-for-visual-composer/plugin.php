<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !class_exists( 'Livemesh_VC_Addons' ) ) {
    /**
     * Main Livemesh_VC_Addons Class
     *
     */
    final class Livemesh_VC_Addons
    {
        /** Singleton *************************************************************/
        private static  $instance ;
        /**
         * Main Livemesh_VC_Addons Instance
         *
         * Insures that only one instance of Livemesh_VC_Addons exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         */
        public static function instance()
        {
            
            if ( !isset( self::$instance ) && !self::$instance instanceof Livemesh_VC_Addons ) {
                self::$instance = new Livemesh_VC_Addons();
                self::$instance->setup_debug_constants();
                add_action( 'plugins_loaded', array( self::$instance, 'load_plugin_textdomain' ) );
                add_action( 'plugins_loaded', array( self::$instance, 'includes' ) );
                add_action( 'plugins_loaded', array( self::$instance, 'include_elements' ) );
                self::$instance->hooks();
            }
            
            return self::$instance;
        }
        
        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         */
        public function __clone()
        {
            // Cloning instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'livemesh-vc-addons' ), '2.8' );
        }
        
        /**
         * Disable unserializing of the class
         *
         */
        public function __wakeup()
        {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'livemesh-vc-addons' ), '2.8' );
        }
        
        private function setup_debug_constants()
        {
            $enable_debug = false;
            $settings = get_option( 'lvca_settings' );
            if ( $settings && isset( $settings['lvca_enable_debug'] ) && $settings['lvca_enable_debug'] == "true" ) {
                $enable_debug = true;
            }
            // Enable script debugging
            if ( !defined( 'LVCA_SCRIPT_DEBUG' ) ) {
                define( 'LVCA_SCRIPT_DEBUG', $enable_debug );
            }
            // Minified JS file name suffix
            if ( !defined( 'LVCA_JS_SUFFIX' ) ) {
                
                if ( $enable_debug ) {
                    define( 'LVCA_JS_SUFFIX', '' );
                } else {
                    define( 'LVCA_JS_SUFFIX', '.min' );
                }
            
            }
        }
        
        /**
         * Include required files
         *
         */
        public function includes()
        {
            if ( is_admin() ) {
                require_once LVCA_PLUGIN_DIR . 'admin/admin-init.php';
            }
            require_once LVCA_PLUGIN_DIR . 'includes/helper-functions.php';
            require_once LVCA_PLUGIN_DIR . 'includes/mapper-functions.php';
            /* Load WPBakery Page Builder Field Types */
            require_once LVCA_PLUGIN_DIR . 'includes/params/number/class-lvca-number-param.php';
            require_once LVCA_PLUGIN_DIR . 'includes/params/datetimepicker/class-lvca-datepicker-param.php';
            require_once LVCA_PLUGIN_DIR . 'includes/params/datetimepicker/class-lvca-datetimepicker-param.php';
        }
        
        /**
         * Include required files
         *
         */
        public function include_elements()
        {
            /* Load WPBakery Page Builder Addon Elements */
            $deactivate_element_accordion = lvca_get_option( 'lvca_deactivate_element_accordion', false );
            if ( !$deactivate_element_accordion ) {
                require_once LVCA_ADDONS_DIR . 'accordion/class-lvca-accordion.php';
            }
            $deactivate_element_carousel = lvca_get_option( 'lvca_deactivate_element_carousel', false );
            if ( !$deactivate_element_carousel ) {
                require_once LVCA_ADDONS_DIR . 'carousel/class-lvca-carousel.php';
            }
            $deactivate_element_clients = lvca_get_option( 'lvca_deactivate_element_clients', false );
            if ( !$deactivate_element_clients ) {
                require_once LVCA_ADDONS_DIR . 'clients/class-lvca-clients.php';
            }
            $deactivate_element_heading = lvca_get_option( 'lvca_deactivate_element_heading', false );
            if ( !$deactivate_element_heading ) {
                require_once LVCA_ADDONS_DIR . 'heading/class-lvca-heading.php';
            }
            $deactivate_element_odometers = lvca_get_option( 'lvca_deactivate_element_odometers', false );
            if ( !$deactivate_element_odometers ) {
                require_once LVCA_ADDONS_DIR . 'odometers/class-lvca-odometers.php';
            }
            $deactivate_element_piecharts = lvca_get_option( 'lvca_deactivate_element_piecharts', false );
            if ( !$deactivate_element_piecharts ) {
                require_once LVCA_ADDONS_DIR . 'piecharts/class-lvca-piecharts.php';
            }
            $deactivate_element_posts_carousel = lvca_get_option( 'lvca_deactivate_element_posts_carousel', false );
            if ( !$deactivate_element_posts_carousel ) {
                require_once LVCA_ADDONS_DIR . 'posts-carousel/class-lvca-posts-carousel.php';
            }
            $deactivate_element_pricing_table = lvca_get_option( 'lvca_deactivate_element_pricing_table', false );
            if ( !$deactivate_element_pricing_table ) {
                require_once LVCA_ADDONS_DIR . 'pricing-table/class-lvca-pricing-table.php';
            }
            $deactivate_element_spacer = lvca_get_option( 'lvca_deactivate_element_spacer', false );
            if ( !$deactivate_element_spacer ) {
                require_once LVCA_ADDONS_DIR . 'spacer/class-lvca-spacer.php';
            }
            $deactivate_element_services = lvca_get_option( 'lvca_deactivate_element_services', false );
            if ( !$deactivate_element_services ) {
                require_once LVCA_ADDONS_DIR . 'services/class-lvca-services.php';
            }
            $deactivate_element_stats_bar = lvca_get_option( 'lvca_deactivate_element_stats_bar', false );
            if ( !$deactivate_element_stats_bar ) {
                require_once LVCA_ADDONS_DIR . 'stats-bar/class-lvca-stats-bar.php';
            }
            $deactivate_element_tabs = lvca_get_option( 'lvca_deactivate_element_tabs', false );
            if ( !$deactivate_element_tabs ) {
                require_once LVCA_ADDONS_DIR . 'tabs/class-lvca-tabs.php';
            }
            $deactivate_element_team = lvca_get_option( 'lvca_deactivate_element_team', false );
            if ( !$deactivate_element_team ) {
                require_once LVCA_ADDONS_DIR . 'team/class-lvca-team.php';
            }
            $deactivate_element_testimonials = lvca_get_option( 'lvca_deactivate_element_testimonials', false );
            if ( !$deactivate_element_testimonials ) {
                require_once LVCA_ADDONS_DIR . 'testimonials/class-lvca-testimonials.php';
            }
            $deactivate_element_testimonials_slider = lvca_get_option( 'lvca_deactivate_element_testimonials_slider', false );
            if ( !$deactivate_element_testimonials_slider ) {
                require_once LVCA_ADDONS_DIR . 'testimonials-slider/class-lvca-testimonials-slider.php';
            }
            $deactivate_element_portfolio = lvca_get_option( 'lvca_deactivate_element_portfolio', false );
            if ( !$deactivate_element_portfolio ) {
                require_once LVCA_ADDONS_DIR . 'portfolio/class-lvca-portfolio.php';
            }
        }
        
        /**
         * Load Plugin Text Domain
         *
         * Looks for the plugin translation files in certain directories and loads
         * them to allow the plugin to be localised
         */
        public function load_plugin_textdomain()
        {
            $lang_dir = apply_filters( 'lvca_vc_addons_lang_dir', trailingslashit( LVCA_PLUGIN_DIR . 'languages' ) );
            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'livemesh-vc-addons' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'livemesh-vc-addons', $locale );
            // Setup paths to current locale file
            $mofile_local = $lang_dir . $mofile;
            
            if ( file_exists( $mofile_local ) ) {
                // Look in the /wp-content/plugins/livemesh-vc-addons/languages/ folder
                load_textdomain( 'livemesh-vc-addons', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'livemesh-vc-addons', false, $lang_dir );
            }
            
            return false;
        }
        
        /**
         * Setup the default hooks and actions
         */
        private function hooks()
        {
            add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_scripts' ), 10 );
            add_action( 'wp_enqueue_scripts', array( $this, 'localize_scripts' ), 999999 );
            add_action( 'init', array( $this, 'modify_existing_mappings' ), 100 );
            // Filter to replace default css class names for vc_row shortcode and vc_column
            add_filter(
                'vc_shortcodes_css_class',
                array( $this, 'custom_css_classes_for_vc_row' ),
                10,
                3
            );
        }
        
        /**
         * Load Frontend Scripts/Styles
         *
         */
        public function load_frontend_scripts()
        {
            // Use minified libraries if LVCA_SCRIPT_DEBUG is turned off
            $suffix = ( defined( 'LVCA_SCRIPT_DEBUG' ) && LVCA_SCRIPT_DEBUG ? '' : '.min' );
            wp_register_style(
                'lvca-animate-styles',
                LVCA_PLUGIN_URL . 'assets/css/animate.css',
                array(),
                LVCA_VERSION
            );
            wp_enqueue_style( 'lvca-animate-styles' );
            wp_register_style(
                'lvca-frontend-styles',
                LVCA_PLUGIN_URL . 'assets/css/lvca-frontend.css',
                array(),
                LVCA_VERSION
            );
            wp_enqueue_style( 'lvca-frontend-styles' );
            wp_register_style(
                'lvca-icomoon-styles',
                LVCA_PLUGIN_URL . 'assets/css/icomoon.css',
                array(),
                LVCA_VERSION
            );
            wp_enqueue_style( 'lvca-icomoon-styles' );
            wp_register_script(
                'lvca-waypoints',
                LVCA_PLUGIN_URL . 'assets/js/jquery.waypoints' . $suffix . '.js',
                array( 'jquery' ),
                LVCA_VERSION,
                false
            );
            wp_enqueue_script( 'lvca-waypoints' );
            wp_register_script(
                'lvca-frontend-scripts',
                LVCA_PLUGIN_URL . 'assets/js/lvca-frontend' . LVCA_JS_SUFFIX . '.js',
                array(),
                LVCA_VERSION,
                false
            );
            wp_enqueue_script( 'lvca-frontend-scripts' );
        }
        
        public function localize_scripts()
        {
            $panels_mobile_width = 780;
            // default
            $custom_css = lvca_get_option( 'lvca_custom_css', '' );
            wp_localize_script( 'lvca-frontend-scripts', 'lvca_settings', array(
                'mobile_width' => $panels_mobile_width,
                'custom_css'   => $custom_css,
            ) );
        }
        
        /**
         * Load Admin Scripts/Styles
         *
         */
        function modify_existing_mappings()
        {
            $attributes = array(
                'type'        => 'checkbox',
                'heading'     => "Dark Background?",
                'param_name'  => 'lvca_dark_bg',
                "value"       => array(
                __( "Yes", "livemesh-vc-addons" ) => 'true',
            ),
                'description' => __( "Indicate if this row has a dark background color. Dark color scheme will be applied for all elements in this row.", "livemesh-vc-addons" ),
            );
            
            if ( function_exists( 'vc_add_param' ) ) {
                vc_add_param( 'vc_row', $attributes );
                vc_add_param( 'vc_row_inner', $attributes );
            }
        
        }
        
        /**
         * Load Admin Scripts/Styles
         * Take care of situations where themes do not pass the atts value to the filter
         */
        function custom_css_classes_for_vc_row( $class_string, $tag = '', $atts = null )
        {
            if ( !empty($atts) && !empty($tag) ) {
                if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
                    if ( isset( $atts['lvca_dark_bg'] ) && $atts['lvca_dark_bg'] == 'true' ) {
                        $class_string .= ' lvca-dark-bg';
                    }
                }
            }
            return $class_string;
        }
    
    }
}
// End if class_exists check
/**
 * The main function responsible for returning the one true Livemesh_VC_Addons
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $lvca = LVCA(); ?>
 */
function LVCA()
{
    return Livemesh_VC_Addons::instance();
}

// Get LVCA Running
LVCA();