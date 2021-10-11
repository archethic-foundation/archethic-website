<?php
/*
Plugin Name: Contact Form 7 Multi-Step Addon
Description: ThemeRex Multi Step Form extends Contact Form 7.
Version: 1.0.1
Author: ThemeREX
Author URI: https://themerex.net/
License: GPLv2 or later
Text Domain: trx_mscf
Domain Path: /languages
*/
if (!defined( 'WPINC')) {
    exit();
}

use trx_mscf\Multistep_Form;


// If class `TRX_CF7_Multi_Step` doesn't exists yet.
if ( ! class_exists( 'TRX_CF7_Multi_Step' ) ) {
    class TRX_CF7_Multi_Step {

        /**
         * A reference to an instance of this class.
         *
         * @since 1.0.0
         * @access private
         * @var   object
         */
        private static $instance = null;
		/**
		 * A reference to an instance of Multistep_Form class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
        public $multistep_form = null;

        /**
         * TRX_CF7_Multi_Step constructor.
         */
        public function __construct() {
            // Set the constants needed by the plugin.
            $this->constants();

            // Internationalize the text strings used.
            add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ), 1 );

            // Load the include files.
            add_action( 'after_setup_theme', array( $this, 'includes' ), 4 );

            // Register activation and deactivation hook.
            register_activation_hook( __FILE__, array( $this, 'activation' ) );
            register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
        }

        /**
         * Include all files
         */
        public function includes() {
            require_once TRX_MSCF_PLUGIN_DIR . 'includes/plugin-utils.php';

            if (trx_mscf_cf7_is_active()) {
                require_once TRX_MSCF_PLUGIN_DIR . 'includes/multistep-form-class.php';
				$this->multistep_form = new Multistep_Form();
            }
        }

        /**
         * Defines constants for the plugin.
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function constants() {
            /**
             * Set the version number of the plugin.
             *
             * @since 1.0.0
             */
            define( 'TRX_MSCF_PLUGIN_VERSION', '1.0.1' );
            /**
             * Set the slug of the plugin.
             *
             * @since 1.0.0
             */
            define( 'TRX_MSCF_PLUGIN_SLUG', basename( dirname( __FILE__ ) ) );
            /**
             * Set constant path to the plugin directory.
             *
             * @since 1.0.0
             */
            define( 'TRX_MSCF_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
            /**
             * Set constant path to the plugin URI.
             *
             * @since 1.0.0
             */
            define( 'TRX_MSCF_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
            /**
             * Set constant file to the plugin URI.
             *
             * @since 1.0.0
             */
            if (!defined('TRX_MSCF_PLUGIN_FILE'))	define('TRX_MSCF_PLUGIN_FILE', __FILE__);
        }


        public function load_plugin_textdomain() {
            $domain = 'trx-contact-form-7-multi-step-addon';
            if (is_textdomain_loaded($domain) && !is_a($GLOBALS['l10n'][$domain], 'NOOP_Translations')) {
            	return;
			}
            load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . '/languages');
        }

        /**
         * On activation hook
         */
        public function activation() {
            // Register post types and taxonomies in the future
        }

        /**
         * On deactivation hook
         */
        public function deactivation() {
            // Clear all in the future
        }

        /**
         * Returns the instance.
         *
         * @since  1.0.0
         * @access public
         * @return object
         */
        public static function get_instance() {
            if (null === self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
}

if ( ! function_exists( 'trx_contact_form_extend' ) ) {
    /**
     * Returns instanse of the plugin class.
     *
     * @since  1.0.0
     * @return object
     */
    function trx_contact_form_extend() {
        return TRX_CF7_Multi_Step::get_instance();
    }
}
trx_contact_form_extend();