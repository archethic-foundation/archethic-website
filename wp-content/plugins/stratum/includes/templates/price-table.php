<?php

extract( shortcode_atts( array(
	'title' 									=> '',
	'title_typography' 							=> array(),
	'title_typography_html_tag' 				=> '',
	'subtitle' 									=> '',
	'subtitles_typography' 						=> array(),
	'subtitles_typography_html_tag' 			=> '',
	'price_text' 								=> '',
	'price' 									=> '',
	'price_typography' 							=> array(),
	'price_typography_html_tag' 				=> '',
	'price_currency' 							=> '',
	'price_description' 						=> '',
	'content_items' 							=> '',
	'align' 									=> '',
	'button_show' 								=> '',
	'button_text' 								=> '',
	'button_url' 								=> '',
	'title_color' 								=> '',
	'title_color_hover' 						=> '',
	'subtitle_color' 							=> '',
	'subtitle_color_hover' 						=> '',
	'price_color' 								=> '',
	'price_color_hover' 						=> '',
	'price_text_color' 							=> '',
	'price_text_color_hover' 					=> '',
	'description_color' 						=> '',
	'description_color_hover' 					=> '',
	'content_color' 							=> '',
	'content_color_hover' 						=> '',
	'button_color_font' 						=> '',
	'button_color_font_hover' 					=> '',
	'button_color_background' 					=> '',
	'button_color_background_hover' 			=> '',
), $settings ) );

$class = 'stratum-price-table';

$title 	= wp_kses( $title, array(
	'span'		=> array(),
	'mark' 		=> array(),
	'b'			=> array(),
	'strong'	=> array(),
	'br'		=> array()
), $title );

$out = "";

$out .= "<div class='".esc_attr($class)."'>";
	$out .= "<div class='".esc_attr($class)."__wrapper'>";

		//Headers
		if( !empty($subtitle) || !empty($title) ){
			$out .= "<div class='".esc_attr($class)."__header'>";
				if( !empty($subtitle) ){
					$out .= "<".esc_attr($subtitles_typography_html_tag)." class='".esc_attr($class)."__subtitle'>".esc_html($subtitle)."</".esc_attr($subtitles_typography_html_tag).">";
				}
				if( !empty($title) ){
					$out .= "<".esc_attr($title_typography_html_tag)." class='".esc_attr($class)."__title'>".esc_html($title)."</".esc_attr($title_typography_html_tag).">";
				}
			$out .= "</div>";
		}

		//Price section
		if( !empty($price_text) || !empty($price) || !empty($price_description) ){
			$out .= "<div class='".esc_attr($class)."__price-wrapper'>";
				if( !empty($price_text) ){
					$out .= "<div class='".esc_attr($class)."__price-text'>".esc_html($price_text)."</div>";
				}
				if( !empty($price) ){
					!empty( $price_currency ) ? $currency = "<i class='".esc_attr($class)."__price-currency'>".esc_html($price_currency)."</i>" : "";
					$out .= "<p class='".esc_attr($class)."__price'>".esc_html($price).$currency."</p>";
				}
				if( !empty($price_description) ){
					$out .= "<p class='".esc_attr($class)."__price-description'>".esc_html($price_description)."</p>";
				}
			$out .= "</div>";
		}

		//Content section
		if( !empty($content_items) ){
			$out .= "<div class='".esc_attr($class)."__content-wrapper'>";
				$out .= "<ul>";

				foreach ($content_items as $key => $item) {
					$item_id = 'elementor-repeater-item-'.esc_attr($item['_id']);
					$out .= "<li class='".esc_attr($item_id)." ".esc_attr($class)."__content'>".(!empty($item['item_icon']) ? "<i class='".esc_attr($item['item_icon'])."'></i>" : '' )." ".esc_html($item['item_text'])."</li>";
				}
				$out .= "</ul>";
			$out .= "</div>";
		}

		if ($button_show == 'yes'){
			//Button
			$out .= "<div class='".esc_attr($class)."__button elementor-widget-button'>";
				$out .= "<a href='".esc_url($button_url['url'])."' class='button elementor-button'".($button_url['is_external'] ? " target='_blank'" : '').">".esc_html($button_text)."</a>";
			$out .= "</div>";
		}

	$out .= "</div>";
$out .= "</div>";

echo sprintf("%s", $out);
