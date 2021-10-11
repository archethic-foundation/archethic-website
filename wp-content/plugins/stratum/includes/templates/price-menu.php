<?php

use Elementor\Utils;

extract( shortcode_atts( array(
	'title_price_connector' => false,
	'items_divider'			=> false,
	'menu_items'		    => array(),
), $settings ) );

$class = 'stratum-price-menu';
$out = "";

$out .= "<div class='".esc_attr( $class )."'>";
    $out .= "<div class='".esc_attr( $class.'__items' )."'>";
        foreach ( $menu_items as $index => $item ) {

            $current_item = 'elementor-repeater-item-'.$item['_id'];
            
            $out .= "<div class='".esc_attr($current_item)." ".esc_attr( $class.'__item-wrapper' )."'>";
                $out .= "<div class='".esc_attr( $class.'__item' )."'>";

                    $id = $item[ 'image' ][ 'id' ];

                    if ( $id && $item[ 'show_image' ] ) {
                        $image_size = $item[ 'image_size' ];
						$url = wp_get_attachment_image_url( $id, $image_size );
						$srcset = wp_get_attachment_image_srcset( $id, $image_size );

                        $out .= "<div class='".esc_attr( $class.'__image' )." image-align-".esc_attr( $item[ 'image_align' ] )."'>";
                            $out .= "<img class='wp-image-".esc_attr($id)."' src='".esc_url( $url )."' srcset='".$srcset."'/>";
                        $out .= "</div>";
                    }
                    $out .= "<div class='".esc_attr( $class.'__content' )."'>";
                        $out .= "<div class='".esc_attr( $class.'__header' )."'>";
                            $out .= "";
                                $tag_name   = $item[ 'title_html_tag' ];
                                $menu_title = $item[ 'menu_title' ];
                                $menu_price = $item[ 'menu_price' ];

                            $out .= "<{$tag_name} class='".esc_attr( $class.'__title' )."'>".esc_html( $menu_title )."</{$tag_name}>";
                            if ( $title_price_connector == 'yes' ) {
                                $out .= "<span class='".esc_attr( $class.'__connector' )."'></span>";
                            }
                            $out .= "<span class='".esc_attr( $class.'__price' )."'>".esc_html( $menu_price )."</span>";
                        $out .= "</div>";

                        $description = $item[ 'menu_description' ];

                        $out .= "<div class='".esc_attr( $class.'__description' )."'>".esc_html( $description )."</div>";
                        if ( $items_divider == 'yes') {
                            $out .= "<div class='".esc_attr( $class.'__divider' )."'></div>";
                        }
                    $out .= "</div>";
                $out .= "</div>";
            $out .= "</div>";
        }
    $out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );
