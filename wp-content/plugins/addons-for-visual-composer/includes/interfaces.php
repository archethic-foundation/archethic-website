<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Interface for WPBakery Page Builder addons
 */
interface LVCA_Addon {

	public function map_vc_element();
    public function shortcode_func($atts, $content, $tag);
    public function load_scripts();
}

/**
 * Interface for container addons which have a child element
 */
interface LVCA_Container_Addon extends LVCA_Addon {

    public function map_child_vc_element();
    public function child_shortcode_func($atts, $content, $tag);
}