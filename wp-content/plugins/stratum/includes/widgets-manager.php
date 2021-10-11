<?php

namespace Stratum\Managers;

use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WidgetsManager
 * @package Stratum
 */
class Widgets_Manager {

	private $prefix;

	/**
	 * WidgetsManager constructor.
	 */
	public function __construct() {
		$settings = \Stratum\Settings::get_instance();

		$this->prefix  = $settings->getPrefix();

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ], 12 );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widgets_categories' ] );

		$this->register_ajax_templates();
	}

	//Group element under Theme slug
	public function register_widgets_categories() {
		Plugin::instance()->elements_manager->add_category(
			'stratum-widgets',
			[
				'title'  => esc_html__( 'Stratum Widgets', 'stratum' ),
				'icon' => 'font'
			],
			0
		);
	}

	public function unregister_standart_widgets() {
		Plugin::instance()->widgets_manager->unregister_widget_type( 'button' );
	}

	public function register_widgets() {

		require_once stratum_get_plugin_path( '/includes/stratum-widget-base.php' );

		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			if ( class_exists( 'Elementor\Plugin' ) ) {
				if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {
					$elementor = Plugin::instance();
					if ( isset( $elementor->widgets_manager ) ) {
						if ( method_exists( $elementor->widgets_manager, 'register_widget_type' ) ) {

							//Files widgets list
							$widgets_list = [];

							$stratum_get_widgets = get_option( 'stratum_widgets' );

							if ( empty( $stratum_get_widgets ) ) {
								//Get all files
								if ( $handle = opendir( stratum_get_plugin_path( '/includes/widgets/' ) ) ) {
									while ( ( $file = readdir( $handle ) ) !== false ) {
										if ( $file != "." && $file != ".." ) {
											$widgets_list[] = str_replace( ".php", '', $file );
										}
									}
									closedir( $handle );
								}
							} else {
								foreach ( $stratum_get_widgets as $widget_name => $enabled ) {
									if ( $enabled == 'on' ) {
										$widgets_list[] = $widget_name;
									}
								}
							}

							foreach ($widgets_list as $key => $widget_name) {
								$path = stratum_get_plugin_path( '/includes/widgets/' . $widget_name . '.php' );

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

	public function register_ajax_templates() {
		if ( class_exists( 'Elementor\Plugin' ) ) {
			if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {
				$widgets_list 		 = [];
				$stratum_get_widgets = get_option( 'stratum_widgets' );

				if ( empty( $stratum_get_widgets ) ) {
					//Get all files
					if ( $handle = opendir( stratum_get_plugin_path( '/includes/widgets/' ) ) ) {
						while ( ( $file = readdir( $handle ) ) !== false ) {
							if ( $file != "." && $file != ".." ) {
								$widgets_list[] = str_replace( ".php", '', $file );
							}
						}
						closedir( $handle );
					}
				} else {
					foreach ( $stratum_get_widgets as $widget_name => $enabled ) {
						if ( $enabled == 'on' ) {
							$widgets_list[] = $widget_name;
						}
					}
				}

				foreach ( $widgets_list as $key => $widget_name ) {
					$path = stratum_get_plugin_path( '/includes/ajax-templates/' . $widget_name . '.php' );

					if ( file_exists( $path ) ) {
						require_once( $path );
					}
				}
			}
		}
	}
}