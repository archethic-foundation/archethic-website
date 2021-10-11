<?php
namespace Stratum;

use \Elementor\Control_Select2;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Stratum_AJAX_Control extends Control_Select2 {
	const QUERY = 'stratum_ajax_control';

	public function get_type() {
		return static::QUERY;
	}

	/**
	 * 'query' can be used for passing query args in the structure and format used by WP_Query.
	 * @return array
	 */
	protected function get_default_settings() {
		return array_merge(
			parent::get_default_settings(), [
				'query' => '',
			]
		);
	}

}

Plugin::instance()->controls_manager->register_control( 'stratum_ajax_control', new Stratum_AJAX_Control() );