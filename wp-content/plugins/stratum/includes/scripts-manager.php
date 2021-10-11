<?php

namespace Stratum\Managers;

use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class ScriptsManager
 * @package Stratum
 */
class Scripts_Manager {

	private $version;
	private $prefix;
	private $google_api_key;

	/**
	 * ScriptsManager constructor.
	 */
	public function __construct() {
		$settings = \Stratum\Settings::get_instance();

		$this->version = $settings->getVersion();
		$this->prefix  = $settings->getPrefix();

		$stratum_api = get_option( 'stratum_api', [] );
		$this->google_api_key = isset( $stratum_api['google_api_key'] ) ? $stratum_api['google_api_key'] : '';

		$this->init();
	}

	public function init() {
		//==============Actions==============
		add_action( 'elementor/init', [ $this, 'elementor_loaded' ] );

		//Editor
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_document_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_panel_styles' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_icons_font_styles' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_fontawesome_dependencies' ] );

		//Frontend
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_scripts_dependencies' ] );
		add_action( 'elementor/frontend/before_register_styles' , [ $this, 'register_styles_dependencies' ] );
		add_action( 'elementor/frontend/after_enqueue_styles'   , [ $this, 'register_fontawesome_dependencies' ] );

		add_action( 'elementor/frontend/after_enqueue_styles' , [ $this, 'enqueue_frontend_styles'  ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );

		//Preview
		add_action( 'elementor/editor/after_save', [ $this, 'on_save_options' ], 10, 2 );
	}

	public function elementor_loaded() {
		wp_enqueue_script(
			"{$this->prefix}-editor-panel-js",
			stratum_get_plugin_url( 'assets/js/editor-panel.min.js' ),
			apply_filters(
				'stratum/editor_blocks_js/dependencies',
				[
					'jquery',
				]
			),
			$this->version,
			true
		);
	}

	//JS load
	public function enqueue_frontend_scripts() {
		$this->load_locale_data();

		wp_enqueue_script(
			"{$this->prefix}-frontend-js",
			stratum_get_plugin_url( 'assets/js/frontend.min.js' ),
			apply_filters(
				'stratum/editor_blocks_js/dependencies',
				[
					'imagesloaded'
				]
			),
			$this->version,
			true
		);

		wp_localize_script(
			"{$this->prefix}-frontend-js",
			'stratum',
			apply_filters(
				'stratum/editor_blocks_js/localize_data',
				[
					'localeData' => $this->get_locale_data( 'stratum' ),
					'settings' => [
						'wide_support'   => get_theme_support( 'align-wide' ),
					],
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonces' => array(
						'get_articles' => wp_create_nonce( 'stratum_nonce_get_articles' ),
						'get_elementor_templates' => wp_create_nonce( 'stratum_nonce_get_elementor_templates' ),
					)
				]
			)
		);
	}

	public function register_scripts_dependencies() {

		//Countdown
		wp_register_script(
			'jquery-plugin',
			stratum_get_plugin_url( 'vendors/jquery.countdown/jquery.plugin.min.js' ),
			[ 'jquery' ],
			'1.0',
			true
		);

		wp_register_script(
			'jquery-countdown',
			stratum_get_plugin_url( 'vendors/jquery.countdown/jquery.countdown.min.js' ),
			[ 'jquery', 'jquery-plugin' ],
			'2.1.0',
			true
		);

		preg_match( '/^(.*)_/', get_locale(), $current_locale );
		$locale_prefix = isset( $current_locale[ 1 ] ) && $current_locale[ 1 ] !='en' ? $current_locale[ 1 ] : '';

		if ( $locale_prefix != '' ) {
			$locale_path = 'vendors/jquery.countdown/localization/jquery.countdown-' . $locale_prefix . '.js';

			if ( file_exists( stratum_get_plugin_url( $locale_path ) ) ) {
				wp_register_script(
					'jquery-countdown-' . $locale_prefix,
					stratum_get_plugin_url( $locale_path ),
					[ 'jquery-countdown' ],
					'2.1.0',
					true
				);
			}
		}

		//Image hotspots dependencies
		wp_register_script(
			'draggabilly',
			stratum_get_plugin_url( 'vendors/draggabilly/draggabilly.pkgd.min.js' ),
			[ 'jquery' ],
			'2.2.0',
			true
		);

		wp_register_script(
			'popper',
			stratum_get_plugin_url( 'vendors/tippy/popper.min.js' ),
			[ 'jquery' ],
			'2.4.0',
			true
		);

		wp_register_script(
			'tippy',
			stratum_get_plugin_url( 'vendors/tippy/tippy-bundle.umd.min.js' ),
			[ 'jquery', 'popper' ],
			'6.2.3',
			true
		);

		wp_register_script(
			'jquery-masonry',
			stratum_get_plugin_url( 'vendors/masonry/masonry.pkgd.min.js' ),
			[],
			'4.2.2',
			true
		);

        wp_register_script(
			'anim-on-scroll',
			stratum_get_plugin_url( 'vendors/AnimOnScroll/AnimOnScroll.js' ),
			[ 'modernizr-custom' ],
			'1.0.0',
			true
		);

        wp_register_script(
			'modernizr-custom',
			stratum_get_plugin_url( 'vendors/modernizr/modernizr.custom.js' ),
			[],
			'2.6.2',
			true
		);

		wp_register_script(
			'donutty',
			stratum_get_plugin_url( 'vendors/donutty/donutty-jquery.min.js' ),
			[],
			'2.0.0',
			true
        );

        wp_register_script(
			'waypoints',
			stratum_get_plugin_url( 'vendors/waypoints/jquery.waypoints.min.js' ),
			[ 'jquery' ],
			'4.0.1',
			true
		);

		wp_register_script(
			'countup',
			stratum_get_plugin_url( 'vendors/countup/countUp.min.js' ),
			[],
			'2.0.4',
			true
		);

		wp_register_script(
			'google-map-styles',
			stratum_get_plugin_url( 'vendors/stratum/google-map-styles.min.js' ),
			[],
			$this->version,
			true
		);

		wp_register_script(
			'google-map-api',
			'https://maps.googleapis.com/maps/api/js?key='.$this->google_api_key,
			[],
			'3.40',
			true
		);

		wp_register_script(
			'lottie-animations-api',
			stratum_get_plugin_url( 'vendors/lottie/lottie.min.js' ),
			[],
			'5.7.1',
			true
		);
	}

	//JS Elementor Document Scripts
	public function enqueue_editor_document_scripts() {
		wp_enqueue_script(
			"{$this->prefix}-editor-document-js",
			stratum_get_plugin_url( 'assets/js/editor-document.min.js' ),
			[
				'jquery',
			],
			$this->version,
			true
		);
	}

	//CSS load (Panel)
	public function enqueue_editor_panel_styles() {
		wp_enqueue_style(
			"{$this->prefix}-editor-panel",
			stratum_get_plugin_url( 'assets/css/editor-panel.min.css' ),
			apply_filters(
				'stratum/editor_css/dependencies',
				[]
			),
			$this->version
		);
	}

	//CSS load (in iframe)
	public function enqueue_frontend_styles() {
		wp_enqueue_style(
			"{$this->prefix}-widgets-style",
			stratum_get_plugin_url( 'assets/css/style.min.css' ),
			apply_filters(
				'stratum/frontend_css/dependencies',
				[]
			),
			$this->version
		);
	}

	public function register_styles_dependencies() {
		wp_register_style(
			'tippy-themes',
			stratum_get_plugin_url( 'vendors/tippy/themes.css' ),
			[],
			'6.2.3'
		);

		wp_register_style(
			'tippy-animation',
			stratum_get_plugin_url( 'vendors/tippy/animations.css' ),
			[],
			'6.2.3'
		);

		wp_register_style(
			'scroll-anim-effects',
			stratum_get_plugin_url( 'vendors/AnimOnScroll/scrollAnimEffects.css' )
		);
	}

	//CSS load (icons)
	public function enqueue_icons_font_styles() {
		wp_enqueue_style(
			"{$this->prefix}-icons-style",
			stratum_get_plugin_url( '/assets/css/stratum.min.css' ),
			apply_filters(
				'stratum/editor_css/dependencies',
				[]
			),
			$this->version
		);
	}

	//Register fontawesome
	public function register_fontawesome_dependencies() {
		wp_register_script(
			'font-awesome-4-shim',
			ELEMENTOR_ASSETS_URL . 'lib/font-awesome/js/v4-shims.min.js',
			[],
			ELEMENTOR_VERSION
		);

		wp_register_style(
            'font-awesome-5-all',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
            false,
            ELEMENTOR_VERSION
		);

		wp_register_style(
			'font-awesome-4-shim',
			ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/v4-shims.min.css',
			[],
			ELEMENTOR_VERSION
		);
	}

	public function on_save_options($post_id, $editor_data) {

		$settings = Plugin::$instance->documents->get( $post_id )->get_settings();
	}

	public function load_locale_data() {
		$locale_data = $this->get_locale_data( 'stratum' );
		wp_add_inline_script(
			'wp-i18n',
			'wp.i18n.setLocaleData( ' . json_encode( $locale_data ) . ', "'. $this->prefix .'"  );'
		);
	}

	public function get_locale_data($domain) {
		$translations = get_translations_for_domain( $domain );

		$locale = array(
			'' => array(
				'domain' => $domain,
				'lang'   => is_admin() ? get_user_locale() : get_locale()
			)
		);

		if ( ! empty( $translations->headers[ 'Plural-Forms' ] ) ) {
			$locale[ '' ][ 'plural_forms' ] = $translations->headers[ 'Plural-Forms' ];
		}

		foreach ( $translations->entries as $msgid => $entry ) {
			$locale[ $msgid ] = $entry->translations;
		}

		return $locale;
	}

	public function get_image_sizes() {

		global $_wp_additional_image_sizes;

		$sizes  = get_intermediate_image_sizes();
		$result = array();

		foreach ( $sizes as $size ) {
			if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
			} else {
				$result[ $size ] = sprintf(
					'%1$s (%2$sx%3$s)',
					ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
					$_wp_additional_image_sizes[ $size ][ 'width'  ],
					$_wp_additional_image_sizes[ $size ][ 'height' ]
				);
			}
		}

		return array_merge( array( 'full' => esc_html__( 'Full', 'stratum' ), ), $result );
	}
}