<?php

use Elementor\Utils;

extract( shortcode_atts( array(
	//Swiper
	'navigation'					=> 'both',
	'pagination_style'				=> 'bullets',
	'heading_typography_html_tag'	=> 'h3',
	'subtitle_typography_html_tag'	=> 'span',
	//--Swiper
), $settings ) );

$class = 'stratum-testimonial-carousel';
$slider_options = stratum_generate_swiper_options( $settings );

$out = "";

$out .= "<div class='".esc_attr( $class )."' data-slider-options='".json_encode( $slider_options )."'>";
    $out .= "<div class='swiper-container stratum-main-swiper'>";
        $out .= "<div class='swiper-wrapper'>";

            foreach ( $settings[ 'slides' ] as $index => $item ) {

                $current_item = 'elementor-repeater-item-'.$item[ '_id' ];
                $out .= "<div class='swiper-slide ".esc_attr( $current_item )."'>";
                	$out .= "<div class='".esc_attr( $class."__wrapper" )."'>";
						$out .= "<div class='".esc_attr( $class."__container" )."'>";
							$out .= "<div class='".esc_attr( $class."__container-inner" )."'>";
								$out .= "<div class='".esc_attr( $class."__footer" )."'>";

									list( , $id ) = array_values( $item[ 'image' ]  );

									if ( ! empty( $item[ 'image' ][ 'url' ] ) ) {
										$url_placeholder = Utils::get_placeholder_image_src();
										$srcset 		 = wp_get_attachment_image_srcset( $id, 'full' );
										$url    		 = wp_get_attachment_image_url   ( $id, 'full' );
										$src_url 		 = empty( $url ) ? $url_placeholder : $url;

										$out .= "<img src='".esc_url( $src_url )."' class='".esc_attr( $class.'__image' )." wp-image-".esc_attr( $id )."' srcset='".$srcset."'/>";
									}
								$out .= "</div>";

								$out .= "<div class='".esc_attr( $class."__content" )."'>";

									$out .= "<div class='".esc_attr( $class."__cite" )."'>";
										$out .= "<{$heading_typography_html_tag} class='".esc_attr( $class."__heading" )."'>".esc_html( $item[ 'heading' ] )."</{$heading_typography_html_tag}>";
										$out .= "<{$subtitle_typography_html_tag} class='".esc_attr( $class."__subtitle" )."'>".esc_html( $item[ 'subtitle' ] )."</{$subtitle_typography_html_tag}>";
									$out .= "</div>";

									$out .= "<div class='".esc_attr( $class."__text" )."'>".esc_html( $item[ 'content' ] )."</div>";
								$out .= "</div>";

							$out .= "</div>";
						$out .= "</div>";
                	$out .= "</div>";
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

echo sprintf( "%s", $out );
