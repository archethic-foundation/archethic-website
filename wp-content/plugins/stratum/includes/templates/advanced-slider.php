<?php

use Elementor\Utils;

extract( shortcode_atts( array(
	'animation_effect'   => '',
	'text_animation_effect'   => '',
	'sub_title_typography_html_tag'   => 'h3',
	'title_typography_html_tag'   => 'h3',
	'description_typography_html_tag'   => 'h3',
	'slides'    => array(),
	'image_size' => '',

	//Swiper
	'columns_count'				=> '1',
	'slides_in_columns'			=> '1',
	'navigation'				=> 'both',
	'pagination_style'			=> 'bullets',
	//--Swiper
), $settings ) );

$widget_class = 'stratum-advanced-slider';

$class = stratum_css_class([
	$widget_class,
	($animation_effect !='none' ? "stratum-effect-".esc_attr( $animation_effect ) : ''),
	(($text_animation_effect !='none' && (intval($columns_count) == 1 && intval($slides_in_columns) == 1 ) ) ? "has-text-animation-".esc_attr( $text_animation_effect ) : '')
]);

//Generate options for swiper
$slider_options = stratum_generate_swiper_options($settings);

$out = "";

$out .= "<div class='".esc_attr( $class )."' data-slider-options='".json_encode($slider_options)."'>";
	$out .= "<div class='swiper-container'>";
		$out .= "<div class='swiper-wrapper'>";

			foreach ( $slides as $index => $item ) {
				$id = $item[ 'image' ][ 'id' ];

				if ( $id ) {
					$url = wp_get_attachment_image_url($id, $image_size );
				} else {
					$url = Utils::get_placeholder_image_src();
				}
				$current_item = 'elementor-repeater-item-'.$item['_id'];

				$out .= "<div class='swiper-slide ".esc_attr($current_item)."'>";
					$out .= "<div class='".esc_attr( $widget_class . '__image' )."' style='background-image: url(".esc_url($url).");'></div>";
					$out .= "<div class='".esc_attr( $widget_class . '__slide-content' )."'>";
						$out .= "<div class='".esc_attr( $widget_class . '__slide-wrapper' )."'>";
							$out .= "<div class='".esc_attr( $widget_class . '__slide-container' )."'>";

							if (!empty($item['sub_title'])){
								$out .= "<div class='".esc_attr( $widget_class . '__sub-title' )."'>";
									$out .= esc_html($item['sub_title']);
								$out .= "</div>";
							}

							if (!empty($item['title'])){
								$out .= "<{$title_typography_html_tag} class='".esc_attr( $widget_class . '__title' )."'>";
									$out .= esc_html($item['title']);
								$out .= "</{$title_typography_html_tag}>";
							}

							if (!empty($item['description'])){
								$out .= "<div class='".esc_attr( $widget_class . '__description' )."'>";
									$out .= esc_html($item['description']);
								$out .= "</div>";
							}

							if (!empty($item['button_text'])){
								$out .= "<div class='".esc_attr( $widget_class . '__button' )."'>";
									$out .= "<a href='".esc_url($item['button_link']['url'])."'".($item['button_link']['is_external'] ? " target='_blank'" : '').">".esc_html($item['button_text'])."</a>";
								$out .= "</div>";
							}

							$out .= "</div>";
						$out .= "</div>";
					$out .= "</div>";
					$out .= "<div class='".esc_attr( $widget_class . '__overlay' )."'></div>";

				$out .= "</div>";
			}
			$out .= "</div>"; //swiper-wrapper

		if ($navigation == 'both' || $navigation == 'pagination'){
			if ($pagination_style == 'scrollbar'){
				$out .= "<div class='swiper-scrollbar'></div>";
			} else {
				$out .= "<div class='swiper-pagination'></div>";
			}
		}
	$out .= "</div>"; //swiper-container

	if ($navigation == 'both' || $navigation == 'arrows'){
		$out .= "<div class='stratum-swiper-button-prev'></div>";
		$out .= "<div class='stratum-swiper-button-next'></div>";
	}
$out .= "</div>";

echo sprintf("%s", $out);
