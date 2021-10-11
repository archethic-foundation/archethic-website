<?php

namespace Stratum;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class REST API
 * @package Stratum
 */
class Rest_API {

	protected $_namespace = 'Stratum/v1';

	/**
	 * RestAPI constructor.
	 */
	public function __construct( ) {
		add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
	}

	public function register_rest_route(){

		register_rest_route( $this->_namespace, '/templates', array(
			array(
				'methods'   => 'GET',
				'callback' => [ $this, 'get_templates' ],
				'permission_callback' => [ $this, 'permissions_check' ],
			),
			'schema' => array( $this, 'templates_schema' )
		) );
	}

	public function permissions_check( $request ) {
		if ( ! current_user_can( 'read' ) ) {
			return new \WP_Error(
				'rest_forbidden',
				esc_html__( 'Forbidden.' ),
				array( 'status' => $this->authorization_status_code() )
			);
		}
		return true;
	}

	// Sets up the proper HTTP status code for authorization.
	public function authorization_status_code() {

		$status = 401;

		if ( is_user_logged_in() ) {
			$status = 403;
		}

		return $status;
	}


	/**
     * Schema for a templates.
     *
     * @param WP_REST_Request $request Current request.
     */
    public function templates_schema() {
	}

	public function get_templates($object) {
	}
}