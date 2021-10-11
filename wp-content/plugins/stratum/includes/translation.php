<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Load translations from the MO file.
 */
function stratum_load_textdomain() {
    load_plugin_textdomain( 'stratum', false, plugin_basename( STRATUM_PLUGIN_DIR ) . '/languages/' );
}

add_action( 'plugins_loaded', 'stratum_load_textdomain' );
