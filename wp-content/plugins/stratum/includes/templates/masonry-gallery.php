<?php

extract( shortcode_atts( array(
	'gallery_images' => array(),
	'gallery_columns' => array(),
	'gutter' => array(),
	'animate_on_scroll'   => false,
	'animation_effects'   => '',
	'image_size' => '',
), $settings ) );

$class = 'stratum-masonry-gallery';

$gallery_id = uniqid( 'gallery-' );

$options = [
    'columns' => $gallery_columns['size'],
    'gutter'  => $gutter['size'],
    'animate' => ($animate_on_scroll == 'yes' ? true : false)
];

$out = "";

$out .= "<div class='".esc_attr( $class ).($animate_on_scroll == 'yes' ? ' animate_on_scroll' : '')." masonry-grid ".esc_attr($animation_effects)."' data-options='".json_encode($options)."'>";

    $out .= "<div class='grid-sizer masonry-col-".esc_attr($gallery_columns['size'])."'></div>";
    foreach ( $gallery_images as $index => $image ) {
		$data_img = $this->_get_image_attributes( $image[ 'id' ] );

		$url 	 = wp_get_attachment_image_url( $image[ 'id' ], $image_size );
		$srcset  = wp_get_attachment_image_srcset( $image[ 'id' ], $image_size );
		$caption = wp_get_attachment_caption( $image[ 'id' ] );

		$out .= "<div class='".esc_attr( $class . '__item' )." masonry-item'>";
			if (is_admin()){
				$out .= "<a href='#' class='".esc_attr( $class . '__link' )."'>";
			} else {
				$out .= "<a data-elementor-open-lightbox='default' data-elementor-lightbox-slideshow='".esc_attr($gallery_id)."' href='".esc_url($image['url'])."' class='".esc_attr( $class . '__link' )."'>";
			}
                $out .= "<div class='".esc_attr( $class . '__image' )."'>";
                	$out .= "<figure>";
                   		$out .= "<img class='wp-image-".esc_attr($image[ 'id' ])."' alt='" . $data_img[ 'alt' ] . "' src='".esc_url($url)."' srcset='".$srcset."'>";
                   		if ( ! empty( $caption ) ) {
                   			$out .= "<figcaption class='" . esc_attr( $class . '__caption' ) . "'>";
                   				$out .= $data_img[ 'caption' ];
                   			$out .= "</figcaption>";
                   		}
                	$out .= "</figure>";
                $out .= "</div>";
                $out .= "<div class='".esc_attr( $class . '__overlay' )."'></div>";
            $out .= "</a>";
        $out .= "</div>";
    }
$out .= "</div>";

echo sprintf( "%s", $out );