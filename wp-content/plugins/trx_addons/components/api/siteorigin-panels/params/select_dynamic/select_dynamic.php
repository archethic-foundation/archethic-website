<?php
/**
 * Plugin support: SiteOrigin Panels
 *
 * Additional param's type 'select_dynamic': dropdown with dynamically changed options list
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

if (trx_addons_exists_sop() && trx_addons_exists_sow()) {
	class SiteOrigin_Widget_Field_Select_Dynamic extends SiteOrigin_Widget_Field_Select {
		protected function sanitize_field_input( $value, $instance ) {
			return $value;
		}
	}
}
?>