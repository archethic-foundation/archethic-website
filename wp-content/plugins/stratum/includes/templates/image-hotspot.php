<?php

use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Core\Settings\Manager;

if ( $type == 'php' ) {
    $dot_animation = $settings[ 'hotspot_dot_animation' ];

    $dot_classes = [
        'stratum-image-hotspot__dot',
        !empty( $dot_animation ) ? 'has-animation-pulse' : ''
    ];
} elseif ( $type == 'js' ) {
    $js_settings = "
        <#
            const { tooltip, open_by_default, placement, tooltip_arrow, tooltip_theme } = settings.hot_spots[ index ];
            const { tooltip_animation, tooltip_interactivity } = settings.hot_spots[ index ];

            let options;
            if ( tooltip != '' ) {
                options = {
                    open : open_by_default != '' ? true : false,
                    tooltipArrow: tooltip_arrow != '' ? true : false,
                    tooltipAnimation: tooltip_animation,
                    tooltipTrigger: tooltip_interactivity,
                    tooltipContent: item.tooltip_content,
                    tooltipTheme: tooltip_theme,
                    tooltipTitle: item.tooltip_title,
                    placement : placement
                }
            }

            view.addRenderAttribute( 'dot' + index, {
                'class': [
                    'stratum-image-hotspot__dot',
                    settings.hotspot_dot_animation != '' ? 'has-animation-pulse' : '',
                    'elementor-repeater-item-' + item._id
                ]
            } );

            view.addRenderAttribute( 'wrapper' + index, {
                'class': [ 'stratum-image-hotspot__dot-wrapper' ],
                ...tooltip && {
                    'data-options': JSON.stringify( options )
                }
            } );
        #>
    ";
}

$class = 'stratum-image-hotspot';

$out = "";
$url_placeholder = Utils::get_placeholder_image_src();

$out .= "<div class='".esc_attr( $class )."'>";
    $out .= "<div class='".esc_attr( $class.'__wrapper' )."'>";
        $out .= "<div class='".esc_attr( $class.'__image' )."'>";
            if ( $type == 'php' ) {

                list( , $id ) = array_values( $settings[ 'image' ]  );

                if ( empty( $id ) ) {
                    $out .= "<img src='".esc_url( $url_placeholder )."'/>";
                } else {
                    $out .= Group_Control_Image_Size::get_attachment_image_html( $settings );
                }
            } elseif ( $type == 'js' ) {
                $out .= "<# if ( settings.image.url != '' ) {
                	const image = {
						id: settings.image.id,
						url: settings.image.url,
						size: settings.image_size,
						model: view.getEditModel()
					};

					const image_url = elementor.imagesManager.getImageUrl( image );
                #>";
                    $out .= "<img class='wp-image-{{ settings.image.id }}' src='{{ image_url }}' />";
                $out .= "<# } else { #>";
                    $out .= "<img src='".esc_url( $url_placeholder )."'/>";
                $out .= "<# } #>";
            }
        $out .= "</div>";

        if ( $type == 'php' ) {
            foreach ( $settings[ 'hot_spots' ] as $index => $item ) {

                $icon_class = $item[ 'hotspot_icon' ];
                $merge = array_merge( $dot_classes, [ 'elementor-repeater-item-'.esc_attr( $item[ '_id' ] ) ] );

                $this->add_render_attribute( 'dot'.$index, [ 'class' => $merge ] );
                $dot_class = $this->get_render_attribute_string( 'dot'.$index );

                $wrapper = [
                    'class' => $class.'__dot-wrapper'
                ];

                if ( !empty( $item[ 'tooltip' ] ) ) {
                    $options = [
                        'open'             => !empty( $item[ 'open_by_default' ] ) ? true : false,
                        'tooltipArrow'     => !empty( $item[ 'tooltip_arrow' ] ) ? true : false,
                        'placement'        => $item[ 'placement' ],
                        'tooltipTheme'     => $item[ 'tooltip_theme' ],
                        'tooltipAnimation' => $item[ 'tooltip_animation' ],
                        'tooltipTrigger'   => $item[ 'tooltip_interactivity' ],
                        'tooltipContent'   => $item[ 'tooltip_content' ],
                        'tooltipTitle'     => $item[ 'tooltip_title' ]
                    ];

                    $wrapper[ 'data-options' ] = json_encode( $options );
                }

                $this->add_render_attribute( 'wrapper'.$index, $wrapper );
                $wrapper_class = $this->get_render_attribute_string( 'wrapper'.$index );

                $out .= $this->get_dot_template( $class, $dot_class, $wrapper_class, $icon_class, $type, $item );
            }
        } elseif ( $type == 'js' ) {
            $out .= "<# let index = 0; #>";
            $out .= "<# _.each( settings.hot_spots, item => { #>";
                $out .= $js_settings;
                $icon_class = "{{ item.hotspot_icon }}";

                $dot_class     = "{{{ view.getRenderAttributeString( 'dot' + index ) }}}";
                $wrapper_class = "{{{ view.getRenderAttributeString( 'wrapper' + index ) }}}";

                $out .= $this->get_dot_template( $class, $dot_class, $wrapper_class, $icon_class, $type );

            $out .= "<# index++; } ); #>";
        }
    $out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );
