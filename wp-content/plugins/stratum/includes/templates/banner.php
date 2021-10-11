<?php

use Elementor\Utils;

extract( shortcode_atts( [
	'image'					=> '',
    'image_size' 			=> '',
    'hosted_url'            => '',
	'title' 				=> '',
	'text'       			=> '',
	'title_typography_html_tag'	=> 'h5',
	'link'       			=> '',
	'link_target' 			=> '',
	'link_rel'    			=> '',
	'animation_effect' 		=> 'none',
	'text_animation_effect' => 'none',
	'background_type' 		=> 'image'
], $settings ) );

$class = 'stratum-banner';

$id = $image[ 'id' ];
$link = !empty( $link ) ? $link : "#";
$url = wp_get_attachment_image_url( $image[ 'id' ], $image_size );
$srcset = wp_get_attachment_image_srcset($image[ 'id' ], $image_size);

$out = "";

$out .= "<figure class='".esc_attr( $class )." stratum-effect-".esc_attr( $animation_effect )." has-text-animation-".esc_attr( $text_animation_effect)."'>";
        $out .= "<a href='".esc_url( $link )."' class='".esc_attr( $class.'__link' )."'";
        if ( ! empty( $link_target ) ) {
            $out .= "target='".esc_attr( $link_target )."'";
            }
        if ( ! empty( $link_rel ) ) {
            $out .= "rel='".esc_attr( $link_rel )."'";
        }
        $out .= ">";
        if ( $link ) {
            $out .= "<div class='".esc_attr( $class.'__wrapper' )."'>";
                if ( $background_type == 'video' ) {
                    $out .= "<video class='".esc_attr( $class.'__video' )."' autoplay muted loop>";
                        $out .= "<source src='".esc_url( $hosted_url[ 'url' ] )."' type='video/mp4'>";
                    $out .= "</video>";
                } else {
                    $out .= "<img src='".(empty( $id ) ? Utils::get_placeholder_image_src() : esc_url( $url ))."' class='".esc_attr( $class.'__image' )." wp-image-".esc_attr($id)."' srcset='".$srcset."'/>";
                }
	            $out .= "<div class='".esc_attr( $class.'__overlay' )."'></div>";
                $out .= "<figcaption class='".esc_attr( $class.'__content' )."'>";
					$out .= "<div class='".esc_attr( $class.'__content-wrapper' )."'>";

						$out .= "<div class='".esc_attr( $class.'__content-container' )."'>";
							$out .= "<{$title_typography_html_tag} class='".esc_attr( $class.'__title' )."'>".esc_html( $title )."</{$title_typography_html_tag}>";
							$out .= "<div class='".esc_attr( $class.'__text' )."'>".esc_html( $text )."</div>";
						$out .= "</div>";

                    $out .= "</div>";
                $out .= "</figcaption>";
            $out .= "</div>";
        }
    $out .= "</a>";
$out .= "</figure>";

echo sprintf( "%s", $out );
