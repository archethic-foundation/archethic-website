<?php

namespace Stratum\Managers;

use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Controls_Manager
 * @package Stratum
 */
class Controls_Manager {

	private $prefix;

	/**
	 * Controls_Manager constructor.
	 */
	public function __construct() {
		$settings = \Stratum\Settings::get_instance();

		$this->prefix  = $settings->getPrefix();

		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
	}

	public function register_controls() {
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Element_Base' ) ) {
			if ( class_exists( 'Elementor\Plugin' ) ) {
				if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {
					$elementor = Plugin::instance();
					if ( isset( $elementor->controls_manager ) ) {

						//Files controls list
						$controls = array(
							'group_control_typography',
							'ajax_control',
						);

						foreach ($controls as $key => $control_name) {
							$path = stratum_get_plugin_path( '/includes/controls/' . $control_name . '.php' );

							if ( file_exists( $path ) ) {
								require_once( $path );
							}
						}
					}
				}
			}
		}
	}
}
