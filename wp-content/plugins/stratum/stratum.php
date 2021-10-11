<?php
/**
 * Plugin Name: Stratum - Elementor Widgets
 * Plugin URI: https://motopress.com/products/stratum/
 * Description: Advanced Elementor addon to extend page builder capabilities and add more advanced features.
 * Version: 1.3.10
 * Author: MotoPress
 * Author URI: https://motopress.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: stratum
 * Domain Path: /languages
 */

//  Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Stratum\Stratum' ) ) {

	define( 'STRATUM_PLUGIN_FILE', __FILE__ );
	define( 'STRATUM_PLUGIN_DIR', plugin_dir_path( STRATUM_PLUGIN_FILE ) ); // The path with trailing slash

	require_once plugin_dir_path( STRATUM_PLUGIN_FILE ) . 'includes/load.php';

    function stratum() {
        return \Stratum\Stratum::get_instance();
    }

	//Init Plugin
	stratum();
}