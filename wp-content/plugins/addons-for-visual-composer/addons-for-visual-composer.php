<?php

/**
 * Plugin Name: Livemesh Addons for WPBakery Page Builder
 * Plugin URI: https://livemeshwp.com/wpbakery-addons
 * Description: A collection of premium quality addons or extensions for use in WPBakery Page Builder. WPBakery Page Builder must be installed and activated.
 * Author: Livemesh
 * Author URI: https://www.livemeshthemes.com/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Version: 2.8
 * Text Domain: livemesh-vc-addons
 * Domain Path: languages
 *
 * Livemesh Addons for WPBakery Page Builder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Livemesh Addons for WPBakery Page Builder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Livemesh Addons for WPBakery Page Builder. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 *
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Ensure the free version is deactivated if premium is running

if ( !function_exists( 'lvca_fs' ) ) {
    // Plugin version
    define( 'LVCA_VERSION', '2.8' );
    // Plugin Root File
    define( 'LVCA_PLUGIN_FILE', __FILE__ );
    // Plugin Folder Path
    define( 'LVCA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
    // Plugin Folder URL
    define( 'LVCA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    // Plugin Addons Folder Path
    define( 'LVCA_ADDONS_DIR', plugin_dir_path( __FILE__ ) . 'includes/addons/' );
    // Plugin Premium Addons Folder Path
    define( 'LVCA_PREMIUM_ADDONS_DIR', plugin_dir_path( __FILE__ ) . 'includes/addons/premium/' );
    // Plugin Folder URL
    define( 'LVCA_ADDONS_URL', plugin_dir_url( __FILE__ ) . 'includes/addons/' );
    // Plugin Folder URL
    define( 'LVCA_PREMIUM_ADDONS_URL', plugin_dir_url( __FILE__ ) . 'includes/addons/premium/' );
    // Plugin Help Page URL
    define( 'LVCA_PLUGIN_HELP_URL', admin_url() . 'admin.php?page=livemesh_vc_addons_documentation' );
    // Create a helper function for easy SDK access.
    function lvca_fs()
    {
        global  $lvca_fs ;
        
        if ( !isset( $lvca_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $lvca_fs = fs_dynamic_init( array(
                'id'             => '2182',
                'slug'           => 'addons-for-visual-composer',
                'type'           => 'plugin',
                'public_key'     => 'pk_1322c3f34412e56dc2d697e80ef14',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'    => 'livemesh_vc_addons',
                'support' => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $lvca_fs;
    }
    
    // Init Freemius.
    lvca_fs();
    // Signal that SDK was initiated.
    do_action( 'lvca_fs_loaded' );
    function lvca_fs_add_licensing_helper()
    {
        ?>
        <script type="text/javascript">
            (function () {
                window.lvca_fs = {can_use_premium_code: <?php 
        echo  json_encode( lvca_fs()->can_use_premium_code() ) ;
        ?>};
            })();
        </script>
        <?php 
    }
    
    add_action( 'wp_head', 'lvca_fs_add_licensing_helper' );
    require_once dirname( __FILE__ ) . '/plugin.php';
}
