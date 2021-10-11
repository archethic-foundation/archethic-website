<?php

namespace Stratum\License;

class License {

	private static $instance = null;

	private $licenseSettings = null;

	/**
	 * License constructor.
	*/
	public function __construct() {

		$this->licenseSettings = new LicenseSettings();

		add_action( 'admin_menu', array($this, 'admin_menu'), 99 );
		add_action( 'admin_init', array( $this, 'initAutoUpdater' ), 9 );
		add_action( 'admin_init', array( $this, 'stratum_save_license' ) );
	}

	public static function get_instance()
	{
		if (self::$instance == null)
		{
			self::$instance = new License();
		}
		return self::$instance;
	}

	public function stratum_save_license() {

		if ( empty( $_POST ) ) {
			return;
		}

		if ( isset( $_POST['action'] ) && $_POST['action'] === 'stratum_save_license' ) {

			if ( check_admin_referer( 'stratum_save_license', '_wpnonce' ) && current_user_can('manage_options') ) {

				if ( isset( $_POST['stratum_license_key'] ) ) {

					$this->licenseSettings->setLicenseKey( trim( $_POST['stratum_license_key'] ) );
				}
			}
		}

		//activate
		if ( isset( $_POST['edd_license_activate'] ) ) {
			if ( !check_admin_referer( 'stratum_edd_nonce', 'stratum_edd_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}
			$licenseData = $this->activateLicense();

			if ( $licenseData === false ) {
				return false;
			}

			if ( !$licenseData->success && $licenseData->error === 'item_name_mismatch' ) {
				$queryArgs['item-name-mismatch'] = 'true';
			}
		}

		//deactivate
		if ( isset( $_POST['edd_license_deactivate'] ) ) {
			// run a quick security check
			if ( !check_admin_referer( 'stratum_edd_nonce', 'stratum_edd_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}
			// retrieve the license from the database
			$licenseData = $this->deactivateLicense();

			if ( $licenseData === false ) {
				return false;
			}
		}

	}

	public function activateLicense(){
		// data to send in our API request
		$apiParams = array(
			'edd_action' => 'activate_license',
			'license'	 => $this->licenseSettings->getLicenseKey(),
			'item_id'	 => $this->licenseSettings->getProductId(),
			'url'		 => home_url(),
		);

		$activateUrl = add_query_arg( $apiParams, $this->licenseSettings->getStoreUrl() );

		// Call the custom API.
		$response = wp_remote_get( $activateUrl, array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			return false;
		}

		// decode the license data
		$licenseData = json_decode( wp_remote_retrieve_body( $response ) );

		// $licenseData->license will be either "active" or "inactive"
		$this->licenseSettings->setLicenseStatus( $licenseData->license );

		return $licenseData;
	}

	public function deactivateLicense(){

		// data to send in our API request
		$apiParams = array(
			'edd_action' => 'deactivate_license',
			'license'	 => $this->licenseSettings->getLicenseKey(),
			'item_id'	 => $this->licenseSettings->getProductId(),
			'url'		 => home_url(),
		);

		$deactivateUrl = add_query_arg( $apiParams, $this->licenseSettings->getStoreUrl() );

		// Call the custom API.
		$response = wp_remote_get( $deactivateUrl, array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			return false;
		}

		// decode the license data
		$licenseData = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if ( $licenseData->license == 'deactivated' ) {
			$this->licenseSettings->setLicenseStatus( '' );
		}

		return $licenseData;
	}

    public function admin_menu() {

        add_submenu_page(
	        'stratum',
	        esc_html__( 'License', 'stratum' ),
	        esc_html__( 'License', 'stratum' ),
	        'manage_options',
	        'stratum-license',
	        array( $this, 'license_page' )
	    );
    }

	public function initAutoUpdater(){

		$settings = \Stratum\Settings::get_instance();
		$pluginData = $settings->getPluginData();

		$apiData = array(
			'version'	 => isset( $pluginData['Version'] ) ? $pluginData['Version'] : '',
			'license'	 => $this->licenseSettings->getLicenseKey(),
			'item_id'	 => $this->licenseSettings->getProductId(),
			'author'	 => isset( $pluginData['Author'] ) ? $pluginData['Author'] : '',
		);

		new \Stratum\Libraries\EDD_Plugin_Updater\EDD_Plugin_Updater(
			$this->licenseSettings->getStoreUrl(),
			STRATUM_PLUGIN_FILE,
			$apiData
		);
	}

	public function license_page() {

		$stratum_license_key = $this->licenseSettings->getLicenseKey();

		if ( $stratum_license_key ) {
			$licenseData = $this->licenseSettings->getLicenseData();
		}

?>
<div class="wrap">
	<h1><?php esc_html_e( 'License', 'stratum' ); ?></h1>
	<p><?php esc_html_e( 'The License Key is required in order to get automatic plugin updates and support. You can manage your License Key in your personal account.', 'stratum' ); ?></p>

	<form action="<?php echo admin_url( 'admin.php?page=stratum-license' ); ?>" method="post">
		<input type="hidden" name="action" value="stratum_save_license">

		<?php wp_nonce_field( 'stratum_save_license', '_wpnonce' ); ?>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top"><?php esc_html_e( 'License Key', 'stratum' ); ?></th>
					<td>
						<input id="stratum_license_key" name="stratum_license_key" type="password"
							class="regular-text" value="<?php echo esc_attr( $stratum_license_key ); ?>"
							autocomplete="new-password">
						<?php if ( $stratum_license_key ) { ?>
							<i style="display:block;"><?php echo str_repeat( "&#8226;", 20 ) . substr( $stratum_license_key, -7 ); ?></i>
						<?php } ?>
					</td>
				</tr>
				<?php if ( isset( $licenseData, $licenseData->license ) ) { ?>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Status', 'stratum' ); ?>
						</th>
						<td>
							<?php
							switch ( $licenseData->license ) {
								case 'inactive' :
								case 'site_inactive' :
									esc_html_e( 'Inactive', 'stratum' );
									break;
								case 'valid' :
									if ( $licenseData->expires !== 'lifetime' ) {
										$date	 = ($licenseData->expires) ? new \DateTime( $licenseData->expires ) : false;
										$expires = ($date) ? ' ' . $date->format( 'd.m.Y' ) : '';
										echo esc_html__( 'Valid until', 'stratum' ) . $expires;
									} else {
										esc_html_e( 'Valid (Lifetime)', 'stratum' );
									}
									break;
								case 'disabled' :
									esc_html_e( 'Disabled', 'stratum' );
									break;
								case 'expired' :
									esc_html_e( 'Expired', 'stratum' );
									break;
								case 'invalid' :
									esc_html_e( 'Invalid', 'stratum' );
									break;
								case 'item_name_mismatch' :
									esc_html_e( 'Your License Key does not match the installed plugin.', 'stratum' );
									break;
								case 'invalid_item_id' :
									esc_html_e( 'Product ID is not valid', 'stratum' );
									break;
							}
							?>
						</td>
					</tr>
					<?php if ( in_array( $licenseData->license, array( 'inactive', 'site_inactive', 'valid', 'expired' ) ) ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php esc_html_e( 'Action', 'stratum' ); ?>
							</th>
							<td>
								<?php
								if ( $licenseData->license === 'inactive' || $licenseData->license === 'site_inactive' ) {
									wp_nonce_field( 'stratum_edd_nonce', 'stratum_edd_nonce' );
									?>
									<input type="submit" class="button-secondary" name="edd_license_activate"
										   value="<?php esc_attr_e( 'Activate License', 'stratum' ); ?>"/>

								<?php } elseif ( $licenseData->license === 'valid' ) { ?>
									<?php wp_nonce_field( 'stratum_edd_nonce', 'stratum_edd_nonce' ); ?>

									<input type="submit" class="button-secondary" name="edd_license_deactivate"
										   value="<?php esc_attr_e( 'Deactivate License', 'stratum' ); ?>"/>

								<?php } elseif ( $licenseData->license === 'expired' ) { ?>

									<a href="<?php echo $this->licenseSettings->getRenewUrl(); ?>"
									   class="button-secondary"
									   target="_blank">
										   <?php esc_html_e( 'Renew License', 'stratum' ); ?>
									</a>

									<?php
								}
								?>
							</td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
	}

}

new License();