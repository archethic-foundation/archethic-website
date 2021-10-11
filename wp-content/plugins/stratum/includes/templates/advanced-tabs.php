<?php

use Elementor\Frontend;
use Elementor\Icons_Manager;

extract( shortcode_atts( array(
	'tabs_items'    => array(),
	'item_icon' => '',
	'tabs_layout' => 'horizontal',
	'tabs_interactivity' => 'click',
	'equal_height' => '',
	'content_animation' => '',

), $settings ) );

$widget_class = 'stratum-advanced-tabs';

$is_active = false;
foreach ( $tabs_items as $index => $item ) {
	if ($item['active']){
		$is_active = true;
	}
}

$class = stratum_css_class([
	$widget_class,
	'tabs-layout-'.esc_attr($tabs_layout),
	($content_animation != 'none' ? $content_animation.'-animation' : ''),
]);

$accordion_options = [
	'tabs_interactivity' => $tabs_interactivity,
	'equal_height' => ($equal_height == 'yes' ? true : false),
];

$out = "";

$frontend = new Frontend;

ob_start();
	Icons_Manager::render_icon( $item_icon, [ 'aria-hidden' => 'true' ] );
$item_icon_html = ob_get_clean();

$once_active_nav = false;
$once_active_content = false;

$out .= "<div class='".esc_attr( $class )."' data-tabs-options='".json_encode($accordion_options)."'>";
	$out .= "<div class='".esc_attr( $widget_class . '__navigation' )."'>";
		foreach ( $tabs_items as $index => $item ) {
			$current_item = 'elementor-repeater-item-'.$item['_id'];

			$item_class = stratum_css_class([
				$widget_class . '__navigation-item',
				(($item['active'] == 'yes' && $once_active_nav == false) || ($index == 0 && $is_active == false) ? 'active-nav' : ''),
				$current_item
			]);

			if ($item['active'] == 'yes'){
				$once_active_nav = true;
			}

			ob_start();
				Icons_Manager::render_icon( $item['tab_icon'], [ 'aria-hidden' => 'true' ] );
			$item_icon_html = ob_get_clean();

			$out .= "<div data-tab-id=".esc_attr($index)." class='".esc_attr( $item_class )."'>";
				if (!empty($item['tab_title'])){
					$out .= "<div class='".esc_attr( $widget_class . '__title' )."'>";
						$out .= esc_html($item['tab_title']);
					$out .= "</div>";
				}
				if (!empty($item_icon_html)){
					$out .= "<div class='".esc_attr( $widget_class . '__icon' )."'>";
						$out .= "<span>{$item_icon_html}</span>";
					$out .= "</div>";
				}
			$out .= "</div>";
		}
	$out .= "</div>";

	$out .= "<div class='".esc_attr( $widget_class . '__content' )."'>";

		foreach ( $tabs_items as $index => $item ) {
			$current_item = 'elementor-repeater-item-'.$item['_id'];

			$item_class = stratum_css_class([
				$widget_class . '__content-item',
				(($item['active'] == 'yes' && $once_active_content == false ) || ($index == 0 && $is_active == false) ? 'active-content' : ''),
				$current_item
			]);

			if ($item['active'] == 'yes'){
				$once_active_content = true;
			}

			$out .= "<div data-tab-id=".esc_attr($index)." class='".esc_attr( $item_class )."'>";
				$out .= "<div class='".esc_attr( $widget_class . '__content-wrapper' )."'>";
					$out .= "<div class='".esc_attr( $widget_class . '__content-overlay' )."'></div>";

					$out .= "<div class='".esc_attr( $widget_class . '__text' )."'>";
						if ($item['content_type'] == 'text'){
							if (!empty($item['tab_text'])){
								$out .= $item['tab_text'];
							}
						} elseif ($item['content_type'] == 'template'){
							if (!empty($item['tab_template'])){
								$out .=  $frontend->get_builder_content($item['tab_template'], true);
							}
						}
					$out .= "</div>";
				$out .= "</div>";
			$out .= "</div>";
		}
	$out .= "</div>";

$out .= "</div>";

echo sprintf("%s", $out);