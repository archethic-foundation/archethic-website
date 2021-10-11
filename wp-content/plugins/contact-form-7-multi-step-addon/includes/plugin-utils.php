<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * Loading a template in a plugin, but allowing theme and child theme to override template
 * To override template create folder in your theme "trx-contact-form-extend/" and put your templates there
 */
if (!function_exists('trx_mscf_load_template')) {
    function trx_mscf_load_template($template_name, $echo = true, $path='') {
        $template_file = locate_template( 'trx-contact-form-extend/'. $template_name, false, false );
        if ( !$template_file ) {
            $path = empty($path) ? TRX_MSCF_PLUGIN_DIR .'templates/' : $path;
            $template_file = $path . $template_name;
        }
        if (!$echo) ob_start();
        load_template( $template_file, false );
        if (!$echo) return ob_get_clean();
        return '';
    }
}

/**
 * Check if Contact Form 7 plugin is active
 */
if (!function_exists('trx_mscf_cf7_is_active')) {
    function trx_mscf_cf7_is_active() {
        if(!function_exists('is_plugin_active')){
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        return is_plugin_active('contact-form-7/wp-contact-form-7.php');
    }
}

/**
 * Get Previous / Next button HTML
 */
if (!function_exists('trx_mscf_get_step_button_callback')) {
	add_filter( 'trx_mscf_get_step_button', 'trx_mscf_get_step_button_callback', 10, 3 );
    function trx_mscf_get_step_button_callback ($html='', $button_type='trx_mscf_prev', $args=array()) {
    	if (empty($html)) {
			$format = '<button class="%1$s" %2$s>%3$s</button>';
			$class = $button_type . (isset($args['class']) ? esc_attr($args['class']) : '');
			$id = empty($args['id']) ? '' : ' id="' . esc_attr($args['id']) . '"';
			$label = empty($args['label']) ? '' : esc_attr($args['label']);
			$html = sprintf($format, $class, $id, $label);
		}

    	return $html;
    }
}

/**
 * Get Progressbar HTML
 */
if (!function_exists('trx_mscf_get_progressbar_callback')) {
	add_filter( 'trx_mscf_get_progressbar', 'trx_mscf_get_progressbar_callback', 10, 2 );
    function trx_mscf_get_progressbar_callback ($html='', $args=array()) {
		if (empty($args['trx_mscf_steps'])) {
			return '';
		}

		if (empty($html)) {
			$class = (isset($args['class']) ? esc_attr($args['class']) : '');
			$id = empty($args['id']) ? '' : 'id="' . esc_attr($args['id']) . '"';
			$first = true;

			$text = sprintf('<ul class="trx_mscf_progressbar%1$s" %2$s>', $class, $id);
			foreach ($args['trx_mscf_steps'] as $key => $step) {
				$class = 'trx_mscf_' . (!empty($args['options']['type']) ? $args['options']['type'] : 'bullets') . ( ($first) ? ' active' : '' );
				$width = empty($args['trx_mscf_steps_width']) ? '40px' : $args['trx_mscf_steps_width'];
				$content = (is_array($step->values) && !empty($step->values)) ? $step->values[0] : '';
				$text .= sprintf('<li class="%1$s" style="width:%2$s;">%3$s</li>', $class, $width, $content);
				$first = false;
			}
			$text .= '</ul><p class="trx_hidden">';
			$html = $text;
		}


    	return $html;
    }
}