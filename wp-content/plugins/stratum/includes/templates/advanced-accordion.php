<?php

use Elementor\Frontend;
use Elementor\Icons_Manager;

extract( shortcode_atts( array(
	'accordion_items'    => array(),
	'expand_icon' => '',
	'expand_icon_active' => '',
	'accordion_type' => 'accordion',
	'accordion_collapsible' => '',
	'accordion_interactivity' => 'click',
	'equal_height' => '',

), $settings ) );

$widget_class = 'stratum-advanced-accordion';

$class = stratum_css_class([
	$widget_class,
]);

$accordion_options = [
	'accordion_type' => $accordion_type,
	'accordion_collapsible' => ($accordion_collapsible == 'yes'),
	'accordion_interactivity' => $accordion_interactivity,
	'equal_height' => (($equal_height == 'yes' && $accordion_type == 'accordion') ? true : false),
];

$out = "";

$frontend = new Frontend;

ob_start();
	Icons_Manager::render_icon( $expand_icon, [ 'aria-hidden' => 'true' ] );
$expand_icon_html = ob_get_clean();

ob_start();
	Icons_Manager::render_icon( $expand_icon_active, [ 'aria-hidden' => 'true' ] );
$expand_icon_active_html = ob_get_clean();

$once_active = false;

$out .= "<div class='".esc_attr( $class )."' data-accordion-options='".json_encode($accordion_options)."'>";
	$out .= "<div class='".esc_attr( $widget_class . '__wrapper' )."'>";
		foreach ( $accordion_items as $index => $item ) {
			$current_item = 'elementor-repeater-item-'.$item['_id'];

			$item_class = stratum_css_class([
				$widget_class . '__item',
				(($item['active'] == 'yes' && $once_active == false) ? 'active-accordion' : ''),
				$current_item
			]);

			if ($accordion_type == 'accordion' && $item['active'] == 'yes'){
				$once_active = true;
			}

			$out .= "<div class='".esc_attr( $item_class )."'>";
				$out .= "<div class='".esc_attr( $widget_class . '__item-header' )."'>";
					$out .= "<div class='".esc_attr( $widget_class . '__title' )."'>";
						ob_start();
							Icons_Manager::render_icon( $item['title_icon'], [ 'aria-hidden' => 'true' ] );
						$title_icon_html = ob_get_clean();

						ob_start();
							Icons_Manager::render_icon( $item['title_icon_active'], [ 'aria-hidden' => 'true' ] );
						$title_icon_active_html = ob_get_clean();

						if (!empty($title_icon_html) || !empty($title_icon_active_html)){
							$out .= "<span class='".esc_attr( $widget_class . '__title-icon' )."'>";
								if (!empty($title_icon_html)){
									$out .= "<span class='normal'>{$title_icon_html}</span>";
								}

								if (!empty($title_icon_active_html)){
									$out .= "<span class='active'>{$title_icon_active_html}</span>";
								}
							$out .= "</span>";
						}

						$out .= esc_html($item['title']);
					$out .= "</div>";
					$out .= "<div class='".esc_attr( $widget_class . '__expand-icon' )."'>";
						if (!empty($expand_icon_html)){
							$out .= "<span class='normal'>{$expand_icon_html}</span>";
						}

						if (!empty($expand_icon_active_html)){
							$out .= "<span class='active'>{$expand_icon_active_html}</span>";
						}
					$out .= "</div>";
				$out .= "</div>";

				$out .= "<div class='".esc_attr( $widget_class . '__item-content' )."'>";

					$out .= "<div class='".esc_attr( $widget_class . '__item-wrapper' )."'>";
						$out .= "<div class='".esc_attr( $widget_class . '__item-content-overlay' )."'></div>";
						$out .= "<div class='".esc_attr( $widget_class . '__text' )."'>";
							if ($item['content_type'] == 'text'){
								if (!empty($item['text'])){
									$out .= $item['text'];
								}
							} elseif ($item['content_type'] == 'template'){
								if (!empty($item['accordion_template'])){
									$out .=  $frontend->get_builder_content($item['accordion_template'], true);
								}
							}
						$out .= "</div>";
					$out .= "</div>";

				$out .= "</div>";
			$out .= "</div>";
		}
	$out .= "</div>";

$out .= "</div>";

echo sprintf("%s", $out);