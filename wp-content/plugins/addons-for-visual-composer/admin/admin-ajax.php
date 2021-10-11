<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class LVCA_Admin_Ajax {

    // Instance of this class.
    protected $plugin_slug = 'livemesh_vc_addons';
    protected $ajax_data;
    protected $ajax_msg;


    public function __construct() {

        // retrieve all ajax string to localize
        $this->localize_strings();
        $this->init_hooks();

    }

    public function init_hooks() {

        // Register backend ajax action
        add_action('wp_ajax_lvca_admin_ajax', array($this, 'lvca_admin_ajax'));
        // Load admin ajax js script
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

    }

    public function ajax_response($success = true, $message = null, $content = null) {

        $response = array(
            'success' => $success,
            'message' => $message,
            'content' => $content
        );

        return $response;

    }

    public function lvca_check_nonce() {

        // retrieve nonce
        $nonce = (isset($_POST['nonce'])) ? $_POST['nonce'] : $_GET['nonce'];

        // nonce action for the grid
        $action = 'lvca_admin_nonce';

        // check ajax nounce
        if (!wp_verify_nonce($nonce, $action)) {
            // build response
            $response = $this->ajax_response(false, __('Sorry, an error occurred. Please refresh the page.', 'livemesh-vc-addons'));
            // die and send json error response
            wp_send_json($response);
        }

    }

    public function lvca_admin_ajax() {

        // check the nonce
        $this->lvca_check_nonce();

        // retrieve data
        $this->ajax_data = (isset($_POST)) ? $_POST : $_GET;

        // retrieve function
        $func = $this->ajax_data['func'];

        switch ($func) {
            case 'lvca_save_settings':
                $response = $this->save_settings_callback();
                break;
            case 'lvca_reset_settings':
                $response = $this->save_settings_callback();
                break;
            default:
                $response = ajax_response(false, __('Sorry, an unknown error occurred...', 'livemesh-vc-addons'), null);
                break;
        }

        // send json response and die
        wp_send_json($response);

    }

    public function save_settings_callback() {

        // retrieve data from jquery
        $setting_data = $this->ajax_data['setting_data'];

        lvca_update_options($setting_data);

        $template = false;
        // get new restore global settings panel
        if ($this->ajax_data['reset']) {
            ob_start();
            require_once('views/settings.php');
            $template = ob_get_clean();
        }

        $response = $this->ajax_response(true, $this->ajax_data['reset'], $template);
        return $response;

    }


    public function localize_strings() {
        
        $this->ajax_msg = array(
            'box_icons' => array(
                'before' => '<i class="tg-info-box-icon dashicons dashicons-admin-generic"></i>',
                'success' => '<i class="tg-info-box-icon dashicons dashicons-yes"></i>',
                'error' => '<i class="tg-info-box-icon dashicons dashicons-no-alt"></i>'
            ),
            'box_messages' => array(

                'lvca_save_settings' => array(
                    'before' => __('Saving plugin settings', 'livemesh-vc-addons'),
                    'success' => __('Plugin settings Saved', 'livemesh-vc-addons'),
                    'error' => __('Sorry, an error occurs while saving settings...', 'livemesh-vc-addons')
                ),
                'lvca_reset_settings' => array(
                    'before' => __('Resetting plugin settings', 'livemesh-vc-addons'),
                    'success' => __('Plugin settings resetted', 'livemesh-vc-addons'),
                    'error' => __('Sorry, an error occurred while resetting settings', 'livemesh-vc-addons')
                ),
            )
        );

    }

    public function admin_nonce() {

        return array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('lvca_admin_nonce')
        );

    }

    public function enqueue_admin_scripts() {

        $screen = get_current_screen();

        // enqueue only in grid panel
        if (strpos($screen->id, $this->plugin_slug) !== false) {
            // merge nonce to translatable strings
            $strings = array_merge($this->admin_nonce(), $this->ajax_msg);

            // Use minified libraries if LVCA_SCRIPT_DEBUG is turned off
            $suffix = (defined('LVCA_SCRIPT_DEBUG') && LVCA_SCRIPT_DEBUG) ? '' : '.min';

            // register and localize script for ajax methods
            wp_register_script('lvca-admin-ajax-scripts', LVCA_PLUGIN_URL . 'admin/assets/js/lvca-admin-ajax' . $suffix . '.js', array(), LVCA_VERSION, true);
            wp_enqueue_script('lvca-admin-ajax-scripts');

            wp_localize_script('lvca-admin-ajax-scripts', 'lvca_admin_global_var', $strings);

        }
    }

}

new LVCA_Admin_Ajax;