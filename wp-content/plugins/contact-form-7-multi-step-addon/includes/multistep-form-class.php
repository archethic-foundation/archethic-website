<?php

namespace trx_mscf;

if (!defined( 'WPINC')) {
    exit();
}

class Multistep_Form {

    protected static $instance;

    public static function init() {

        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * TRX_CF7_Multi_Step constructor.
     */
    public function __construct() {

        $this->add_shortcodes();

        // Ajax actions
        add_action( 'wp_ajax_trx_mscf_validate_fields', array($this, 'validate_fields_ajax') );
        add_action( 'wp_ajax_nopriv_trx_mscf_validate_fields', array($this, 'validate_fields_ajax') );

        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );

        if ( is_admin() ){
            add_action( 'wpcf7_admin_init', array($this, 'add_tag_generator_menu'), 25 );
        }

    }

    public function add_shortcodes() {
        wpcf7_add_form_tag( 'progressbar', array($this, 'progressbar_shortcode'), true );
        wpcf7_add_form_tag( 'step_start', array($this, 'step_start_shortcode'), true );
        wpcf7_add_form_tag( 'step_finish', array($this, 'step_finish_shortcode'), true );
        wpcf7_add_form_tag( 'next', array($this, 'next_shortcode'), true );
        wpcf7_add_form_tag( 'prev', array($this, 'prev_shortcode'), true );
    }

    public function add_tag_generator_menu() {
        $tag_generator = \WPCF7_TagGenerator::get_instance();

        $tag_generator->add( 'progressbar', esc_html__('Progressbar', 'trx-contact-form-7-multi-step-addon' ), array($this, 'progressbar_shortcode_generator'));

        $tag_generator->add( 'step_start', esc_html__('Step start', 'trx-contact-form-7-multi-step-addon' ), array($this, 'step_shortcode_generator'));
        $tag_generator->add( 'step_finish', esc_html__('Step finish', 'trx-contact-form-7-multi-step-addon' ), array($this, 'step_shortcode_generator'));

        $tag_generator->add( 'next', esc_html__('Next', 'trx-contact-form-7-multi-step-addon' ), array($this, 'next_shortcode_generator'));

        $tag_generator->add( 'prev', esc_html__('Prev', 'trx-contact-form-7-multi-step-addon' ), array($this, 'prev_shortcode_generator'));
    }


    /**
     * ----------------------------------------------------------
     * Progressbar
     * ----------------------------------------------------------
     */

    public function progressbar_shortcode($tag) {
        $atts = $this->prepare_cf_shortcode_attrs( array(
            'id' => '',
            'class' => '',
            'options' => array('type' => 'class')// option name => option value pattern
        ), $tag, 'progressbar' );

        // Current Contact Form tags
        $form_current = \WPCF7_ContactForm::get_current();
        $trx_mscf_steps = array_filter(
            (array)$form_current->scan_form_tags(), function($v, $k) {
                return $v->type == 'step_start';
            }, ARRAY_FILTER_USE_BOTH
        );
        $atts['trx_mscf_steps'] = $trx_mscf_steps;
        $trx_mscf_steps_count = count($trx_mscf_steps);

        if ($trx_mscf_steps_count > 0 && $trx_mscf_steps_count < 10) {
            $atts['trx_mscf_steps_width'] = number_format(100 / (float) $trx_mscf_steps_count, 2, '.', '') . '%';
        } else {
            $atts['trx_mscf_steps_width'] = apply_filters('trx_mscf_progressbar_step_width', '40px', $trx_mscf_steps_count);
        }

        return apply_filters('trx_mscf_get_progressbar', '', $atts);
    }

    public function progressbar_shortcode_generator($contact_form, $args = '') {
        $args = wp_parse_args( $args, array() );

        set_query_var( 'trx_shortcode_args', array(
            'attrs' => array(
                'type' => array(
                    'label' => esc_html__('Progressbar type', 'trx-contact-form-7-multi-step-addon'),
                    'type' => 'select',
                    'default' => 'bullets',
                    'options' => array(
                        'numbers' => esc_html__('Numbers', 'trx-contact-form-7-multi-step-addon'),
                        'bullets' => esc_html__('Bullets', 'trx-contact-form-7-multi-step-addon'),
                        'line' => esc_html__('Just Line', 'trx-contact-form-7-multi-step-addon'),
                    )
                )
            ),
            'args' => $args
        ) );

        trx_mscf_load_template('admin/shortcode-generator.php');

        wp_reset_query();
    }


    /**
     * ----------------------------------------------------------
     * Step
     * ----------------------------------------------------------
     */

    public function step_start_shortcode($tag) {
        $atts = $this->prepare_cf_shortcode_attrs( array(
            'id' => '',
            'class' => ''
        ), $tag, 'step_start' );

        $additional_classes = apply_filters('trx_mscf_step_additional_classes', $atts['class'], $atts);
        $additional_classes = !empty($additional_classes) ? ' ' . $additional_classes : $additional_classes;
		$id = !empty($atts['id']) ? ' id="' . $atts['id'] . '"' : '';

        return apply_filters('trx_mscf_get_start_step', '<div class="trx_mscf_step'. $additional_classes .'"' . $id . '>', $tag);
    }

    public function step_finish_shortcode($tag) {
        return apply_filters('trx_mscf_get_finish_step', '</div>',$tag);
    }

    public function step_shortcode_generator($contact_form, $args = '') {
        $args = wp_parse_args( $args, array() );
        $attrs = array();

        if ($args['id'] === 'step_start') {
            $attrs['values'] = array(
                'label' => esc_html__('Label', 'trx-contact-form-7-multi-step-addon'),
                'type' => 'text',
                'default' => esc_html__('Step 1', 'trx-contact-form-7-multi-step-addon')
            );
        }

        set_query_var( 'trx_shortcode_args', array(
            'attrs' => $attrs,
            'show_additional_fields' => ( ($args['id'] === 'step_finish') ? false : true ),
            'args' => $args
        ) );

        trx_mscf_load_template('admin/shortcode-generator.php');

        wp_reset_query();
    }


    /**
     * ----------------------------------------------------------
     * Next
     * ----------------------------------------------------------
     */

    public function next_shortcode($tag) {
        $atts = $this->prepare_cf_shortcode_attrs( array(
            'label' => '',
            'id' => '',
            'class' => '',
        ), $tag, 'next');

        return apply_filters('trx_mscf_get_step_button', '', 'trx_mscf_next', $atts);
    }

    public function next_shortcode_generator($contact_form, $args = '') {
        $args = wp_parse_args( $args, array() );

        set_query_var( 'trx_shortcode_args', array(
            'attrs' => array(
                'values' => array(
                    'label' => esc_html__('Label', 'trx-contact-form-7-multi-step-addon'),
                    'type' => 'text',
                    'default' => esc_html__('Next', 'trx-contact-form-7-multi-step-addon')
                )
            ),
            'args' => $args
        ) );

        trx_mscf_load_template('admin/shortcode-generator.php');

        wp_reset_query();
    }


    /**
     * ----------------------------------------------------------
     * Prev
     * ----------------------------------------------------------
     */

    public function prev_shortcode($atts) {
        $atts = $this->prepare_cf_shortcode_attrs(array(
            'label' => '',
            'id' => '',
            'class' => ''
        ), $atts, 'prev');

        return apply_filters('trx_mscf_get_step_button', '', 'trx_mscf_prev', $atts);
    }

    public function prev_shortcode_generator($contact_form, $args = '') {
        $args = wp_parse_args( $args, array() );

        set_query_var( 'trx_shortcode_args', array(
            'attrs' => array(
                'values' => array(
                    'label' => esc_html__('Label', 'trx-contact-form-7-multi-step-addon'),
                    'type' => 'text',
                    'default' => esc_html__('Previous', 'trx-contact-form-7-multi-step-addon')
                )
            ),
            'args' => $args
        ) );

        trx_mscf_load_template('admin/shortcode-generator.php');

        wp_reset_query();
    }


    /**
     * ----------------------------------------------------------
     * Enqueue scripts
     * ----------------------------------------------------------
     */
    public function enqueue_frontend_scripts() {
        $suffix =  (defined('WP_DEBUG') && true === WP_DEBUG) ? '' : '.min';
        wp_enqueue_style( "trx_mscf_style", TRX_MSCF_PLUGIN_URL . 'assets/css/style' . $suffix . '.css', array(), TRX_MSCF_PLUGIN_VERSION);

        wp_enqueue_script( "trx_mscf_scripts", TRX_MSCF_PLUGIN_URL . 'assets/js/scripts' . $suffix . '.js', array('jquery'), TRX_MSCF_PLUGIN_VERSION, true);
        wp_localize_script( "trx_mscf_scripts", "TRX_MSCF_GLOBALS", array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce(TRX_MSCF_PLUGIN_FILE)
        ) );
    }

    public function enqueue_admin_scripts() {

    }


    /**
     * ----------------------------------------------------------
     * Ajax callbacs
     * ----------------------------------------------------------
     */
    public function validate_fields_ajax() {
        if ( !wp_verify_nonce($_REQUEST['trx_ajax_nonce'], TRX_MSCF_PLUGIN_FILE)) {
            exit(esc_html__("Security error", 'trx-contact-form-7-multi-step-addon'));
        }

        $current_step_fields = explode(',', $_REQUEST['trx_fields_to_check']);

        $form = wpcf7_contact_form($_REQUEST['trx_form_id'] );
        $all_form_tags = $form->scan_form_tags();
        $invalid_fields = false;

        require_once WPCF7_PLUGIN_DIR . '/includes/validation.php';
        $result = new \WPCF7_Validation();

        $tags = array_filter(
            $all_form_tags, function($v, $k) use ($current_step_fields) {
                return in_array($v->name, $current_step_fields);
            }, ARRAY_FILTER_USE_BOTH
        );

        foreach ( $tags as $tag ) {
            $type = $tag['type'];

            if ( 'file*' === $type ) {
				$fdir = $_REQUEST[$tag->name];

				if ( $fdir ) {
					$_FILES[ $tag->name ] = array(
						'name' => wp_basename( $fdir ),
						'tmp_name' => $fdir,
					);
				}

			}
            $result = apply_filters("wpcf7_validate_{$type}", $result, $tag);
        }

        $result = apply_filters('wpcf7_validate', $result, $tags);

        $is_valid = $result->is_valid();

        if (!$is_valid) {
            $invalid_fields = $this->prepare_invalid_form_fields($result);
        }

        echo(json_encode( array(
                    'is_valid' => $is_valid,
                    'invalid_fields' => $invalid_fields
                )
            )
        );
        wp_die();
    }

    /**
     * ----------------------------------------------------------
     * Private functions
     * ----------------------------------------------------------
     */

    private function prepare_cf_shortcode_attrs ($defaults, $tag, $shortcode = '') {
        $atts = array();
        $additional_classes = apply_filters('trx_mscf_step_additional_classes', $tag->get_class_option( $defaults['class'] ), $shortcode, $tag);
        $atts['class'] = !empty($additional_classes) ? ' ' . $additional_classes : $additional_classes;

        if (isset($defaults['label'])) {
            $value = isset($tag->values[0]) ? $tag->values[0] : '';
            $atts['label'] = $value;
        }

        if (isset($defaults['id'])) {
            $parsed = explode(':', $tag->name);
            if ('id' == $parsed[0]) $atts['id'] = $parsed[1];
        }

        if (!empty($defaults['options'])) {
            foreach ($defaults['options'] as $option => $pattern) {
                $parsed = explode(':', $tag->name);
                if ($option ==  $parsed[0]) $atts['options'][$option] = $parsed[1];
            }
        }

        $atts = shortcode_atts( $defaults, $atts, $shortcode );

        return $atts;
    }

    private function prepare_invalid_form_fields ($result){
        $invalid_fields = array();

        foreach ((array)$result->get_invalid_fields() as $name => $field) {
            $invalid_fields[] = array(
                'into' => 'span.wpcf7-form-control-wrap.'
                    . sanitize_html_class($name),
                'message' => $field['reason'],
                'idref' => $field['idref'],
            );
        }

        return $invalid_fields;
    }

}