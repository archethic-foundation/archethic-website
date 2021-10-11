<?php

use Elementor\Utils;

extract( shortcode_atts( [
    'image' => '',
    'image_size' => 'full',
    'item_title' => '',
    'item_price' => '',
    'title_html_tag' => 'h3',
    'list_title' => '',
    'image_position' => '',
    'show_image' => 'no',
    'title_price_connector' => false
], $settings ) );

$class = 'stratum-price-list';

$out = "";

$out .= "<div class='".esc_attr( $class.' '.$image_position )."'>";
    if ( $image[ 'id' ] && $show_image == 'yes' ) {
		$url = wp_get_attachment_image_url( $image[ 'id' ], $image_size );
		$srcset = wp_get_attachment_image_srcset( $image[ 'id' ], $image_size );

        $out .= "<div class='".esc_attr( $class.'__image-wrapper' )."'>";
            $out .= "<img src='".esc_url( $url )."' class='wp-image-".esc_attr($image[ 'id' ])." ".esc_attr( $class.'__image' )."' srcset='".$srcset."'/>";
        $out .= "</div>";
    }
    $out .= "<div class='".esc_attr( $class.'__wrapper' )."'>";
        $out .= "<div class='".esc_attr( $class.'__content' )."'>";
            $out .= "<{$title_html_tag} class='".esc_attr( $class.'__heading' )."'>".esc_html( $list_title )."</{$title_html_tag}>";
            $out .= "<div class='".esc_attr( $class.'__items' )."'>";
                foreach ( $settings[ 'list_items' ] as $index => $item ) {
                    $out .= "<div class='".esc_attr( $class.'__item' )."'>";

                        $tag_name = $item[ 'title_html_tag' ];
                        $title    = $item[ 'item_title' ];
                        $price    = $item[ 'item_price' ];

                        $out .= "<{$tag_name} class='".esc_attr( $class.'__title' )."'>".esc_html( $title )."</{$tag_name}>";
                        if ( $title_price_connector == 'yes' ) {
                            $out .= "<span class='".esc_attr( $class.'__connector' )."'></span>";
                        }
                        $out .= "<span class='".esc_attr( $class.'__price' )."'>".esc_html( $price )."</span>";
                    $out .= "</div>";
                }
            $out .= "</div>";
        $out .= "</div>";
    $out .= "</div>";
$out .= "</div>";

echo sprintf("%s", $out);
