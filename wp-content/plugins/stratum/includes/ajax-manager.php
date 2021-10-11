<?php

namespace Stratum\Managers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Ajax_Manager
 * @package Stratum
 */
class Ajax_Manager {

	/**
	 * Ajax_Manager constructor.
	 */
	public function __construct() {
		//Ajax (Admin)
		add_action( 'elementor/ajax/register_actions', [ $this, 'register_admin_ajax_actions' ] );
	}

	public function register_admin_ajax_actions($ajax_manager) {
		$ajax_manager->register_ajax_action( 'stratum_get_elementor_templates', [ $this, 'stratum_get_elementor_templates' ] );
	}

	public static function stratum_get_elementor_templates($data = []){
		$args = [
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
		];

		//Call from AJAX
		if (!empty($data)){
			//Check nonce
			$nonce = $data['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'stratum_nonce_get_elementor_templates' ) ) {
				wp_send_json_error();
			}
		}

		$page_templates = get_posts($args);
		$options = array();

		if (!empty($page_templates) && !is_wp_error($page_templates)) {
			foreach ($page_templates as $post) {
				$options[$post->ID] = $post->post_title;
			}
		}
		return $options;
	}

	public function register_ajax_action($action, $func){
		add_action( "wp_ajax_{$action}", [ $this, $func ] );
		add_action( "wp_ajax_nopriv_{$action}", [ $this, $func ] );
	}
}
