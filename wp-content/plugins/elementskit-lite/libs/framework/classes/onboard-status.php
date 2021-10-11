<?php

namespace ElementsKit_Lite\Libs\Framework\Classes;

use ElementsKit_Lite\Traits\Singleton;

defined( 'ABSPATH' ) || exit;

class Onboard_Status {

	use Singleton;
	protected  $optionKey = 'elements_kit_onboard_status';
	protected  $optionValue = 'onboarded';

	public function onboard() {
		add_action('elementskit/admin/after_save', [$this, 'ajax_action']);
		
		if ( get_option( $this->optionKey ) ) {
			return true;
		}

		$param      = isset( $_GET['ekit-onboard-steps'] ) ? $_GET['ekit-onboard-steps'] : null;
		$requestUri = ( isset( $_GET['post_type'] ) ? $_GET['post_type'] : '' ) . ( isset( $_GET['page'] ) ? $_GET['page'] : '' );

		if ( strpos( $requestUri, 'elementskit' ) !== false && is_admin() ) {
			if ( $param !== 'loaded' && ! get_option( $this->optionKey ) ) {
				wp_redirect( $this->get_onboard_url() );
				exit;
			}
		}

		return true;
	}

	public  function ajax_action(){
		// finish on-boarding
		$this->finish_onboard();

		if ( isset( $_POST['settings']['tut_term'] ) && $_POST['settings']['tut_term'] == 'user_agreed' ) {
		 	Plugin_Data_Sender::instance()->send( 'diagnostic-data' ); // send non-sensitive diagnostic data and details about plugin usage.
		}

		if ( isset( $_POST['settings']['newsletter_email'] ) && !empty($_POST['settings']['newsletter_email'])) {
			$data = [
				'email'           => $_POST['settings']['newsletter_email'],
				'environment_id'  => 1,
				'contact_list_id' => 1,
			];

			$response = Plugin_Data_Sender::instance()->sendAutomizyData( 'email-subscribe', $data);
			echo print_r($response);
			exit;
		}
	}

	private  function get_onboard_url() {
		return add_query_arg(
			array(
				'page'               => 'elementskit',
				'ekit-onboard-steps' => 'loaded'
			),
			admin_url( 'admin.php' )
		);
	}

	public function redirect_onboard() {
		if ( ! get_option( $this->optionKey ) ) {
			wp_redirect( $this->get_onboard_url() );
			exit;
		}
	}

	public function exit_from_onboard() {
		if ( get_option( $this->optionKey ) ) {
			wp_redirect( $this->get_plugin_url() );
			exit;
		}
	}

	private static function get_plugin_url() {
		return add_query_arg(
			array(
				'page' => 'elementskit',
			),
			admin_url( 'admin.php' )
		);
	}

	public function finish_onboard() {
		if ( ! get_option( $this->optionKey ) ) {
			add_option( $this->optionKey,  $this->optionValue );
		}
	}

}