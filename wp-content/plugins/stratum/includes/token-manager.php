<?php

namespace Stratum\Managers;

class Token_Manager {

	public function __construct() {
		// Deactivation hook.
		register_deactivation_hook( STRATUM_PLUGIN_FILE, [ $this, 'clear_scheduled_event' ] );

		// Action hook to execute when the event is run
		add_action( 'stratum_refresh_instagram_token', [ $this, 'refresh_instagram_token' ] );
		add_filter( 'cron_schedules', [ $this , 'time_scheduled_event' ] );

		add_action( 'update_option', [ $this, 'update_option' ], 10, 3 );
		add_action( 'admin_init', [ $this, 'error_message' ] );
	}

	public function time_scheduled_event( $schedules ) {

		if ( ! isset( $schedules[ 'two_weeks' ] ) ) {
			/*
			 * https://developers.facebook.com/docs/instagram-basic-display-api/guides/long-lived-access-tokens/
		     */
			$schedules[ 'two_weeks' ] = [
				'interval' => WEEK_IN_SECONDS * 2,
				'display'  => 'Once in Two Weeks'
			];
		}

		return $schedules;
	}

	public function schedule_token_refresh_event() {
		if ( ! wp_next_scheduled( 'stratum_refresh_instagram_token' ) ) {
			wp_schedule_event( time(), 'two_weeks', 'stratum_refresh_instagram_token' );
		}
	}

	public function update_option( $option_name, $old_value, $value ) {
		if ( $option_name === 'stratum_api' ) {
			delete_option( 'stratum_instagram_token_cron_error_message' );

			if ( $value === '' ) {
				$this->clear_scheduled_event();
			}
		}
	}

	public function clear_scheduled_event() {
		$timestamp = wp_next_scheduled( 'stratum_refresh_instagram_token' );

		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'stratum_refresh_instagram_token' );
		}
	}

	public function refresh_instagram_token() {
		$stratum_api  			= get_option( 'stratum_api', [] );
		$instagram_access_token = isset($stratum_api['instagram_access_token']) ? $stratum_api['instagram_access_token'] : '';

		if ( ! empty( $instagram_access_token ) ) {
			$api_req  = 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $instagram_access_token;
			$response = wp_remote_get( $api_req );

			if ( is_wp_error( $response ) ) {
				update_option( 'stratum_instagram_token_cron_error_message', $response->get_error_message() );
			} else {
 				$response_body = json_decode( wp_remote_retrieve_body( $response ), false );

				if ( $response_body && json_last_error() === JSON_ERROR_NONE ) {
					if ( $response_body->error ) {
						update_option( 'stratum_instagram_token_cron_error_message', $response_body->error->message );
					} else {
						delete_option( 'stratum_instagram_token_cron_error_message' );

						if ( ! empty( $response_body->access_token ) ) {
							// Update token
							$stratum_api[ 'instagram_access_token' ] = $response_body->access_token;
							update_option( 'stratum_api', $stratum_api );
							// Delete cache data
							delete_transient( 'stratum_instagram_response_data' );
							// Schedule token refresh
							$this->schedule_token_refresh_event();
						}
					}
				} else {
					update_option( 'stratum_instagram_token_cron_error_message', __( 'Error in json_decode.', 'stratum' ) );
				}
			}
		}
	}

	public function stratum_instagram_notice_token_error() {
		$instagram_token_error_message = get_option( 'stratum_instagram_token_cron_error_message' );

		if ( ! empty( $instagram_token_error_message ) ) {
		?>
			<div class="notice notice-error">
				<p>
					<?php
						echo sprintf(
							//translators: %s is an error message
							__( 'Update Instagram Token. Error: %s', 'stratum' ),
							$instagram_token_error_message
						);
					?>
				</p>
			</div>
		<?php
		}
    }

	public function error_message() {
    	global $pagenow;

		if ( $pagenow && $pagenow == 'admin.php' && current_user_can( 'manage_options' ) ) {
			if ( get_option( 'stratum_instagram_token_cron_error_message' ) !== '' ) {
				add_action( 'admin_notices', [ $this, 'stratum_instagram_notice_token_error' ] );
			}
		}
    }
}