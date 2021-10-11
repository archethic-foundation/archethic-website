<?php

namespace Stratum;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Stratum {
	/**
	 * @var Stratum
	 */
	private static $instance = null;

	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * @var Scripts_Manager
	 */
	private $scripts_manager;

	/**
	 * @var Widgets_Manager
	 */
	private $widgets_manager;

	/**
	 * @var Controls_Manager
	 */
	private $controls_manager;

	/**
	 * @var Token_Manager
	 */
	private $token_manager;

	/**
	 * @var Ajax_Manager
	 */
	private $ajax_manager;

	/**
	 * @var VersionControl
	 */
	private $version_control;

	/**
	 * @var Rest_API
	 */
	private $rest_api;

	/**
	 * @var admin-page
	 */
	private $admin_page;

	private function __construct() {

		$this->scripts_manager  = new \Stratum\Managers\Scripts_Manager();
		$this->widgets_manager  = new \Stratum\Managers\Widgets_Manager();
		$this->controls_manager = new \Stratum\Managers\Controls_Manager();
		$this->token_manager    = new \Stratum\Managers\Token_Manager();
		$this->ajax_manager 	= new \Stratum\Managers\Ajax_Manager();
		$this->version_control  = new Version_Control();
		$this->rest_api         = new Rest_API();
		$this->admin_page       = new Admin_page();
	}

    /**
     * @return Scripts_Manager
     */
    public function get_scripts_manager() {
        return $this->scripts_manager;
    }

    /**
     * @return Widgets_Manager
     */
    public function get_widgets_manager() {
        return $this->widgets_manager;
	}

    /**
     * @return Controls_Manager
     */
    public function get_controls_manager() {
        return $this->controls_manager;
	}

    /**
     * @return Token_Manager
     */
    public function get_token_manager() {
        return $this->token_manager;
	}

    /**
     * @return Ajax_Manager
     */
    public function get_ajax_manager() {
        return $this->ajax_manager;
    }

    /**
     * @return Stratum
     */
    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
		}

        return self::$instance;
    }
}
