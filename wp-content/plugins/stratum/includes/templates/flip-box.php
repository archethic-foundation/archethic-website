<?php

extract(shortcode_atts([
    'image' => [],
    'link'  => [],
    'image_size'     => 'full',
    'flip_effect'    => 'flip',
    'flip_direction' => 'right',
    'icon_shape'     => 'circle',
    'icon_view'      => 'default',
    'show_button'    => '',
    'button_text'    => ''
], $settings ));

$class = $this->get_name();
$out = "";

/* #region Flip Box classes */
$widget_class = [ $class, 'flip-box-effect-'.esc_attr( $flip_effect ) ];
$icon_class   = [ $class.'__icon-wrapper', 'stratum-view-'.$icon_view ];

if ( $flip_effect == 'flip' || $flip_effect == 'slide' || $flip_effect == 'push' ) {
    array_push(
        $widget_class,
        'flip-box-direction-'.esc_attr( $flip_direction )
    );
}

if ( $icon_view != 'default' && $icon_shape == 'circle' || $icon_shape == 'square' ) {
    array_push(
        $icon_class,
        'stratum-shape-'.esc_attr( $icon_shape )
    );
}

$this->add_render_attribute( 'widget', 'class', $widget_class );
$this->add_render_attribute( 'icon-wrapper', 'class', $icon_class );
/* #endregion */

$widget_class = $this->get_render_attribute_string( 'widget'  );

$out .= "<div ".$widget_class.">";
    $out .= "<div class='".esc_attr( $class.'__inner' )."'>";

        $out .= "<div class='".esc_attr( $class.'__layer ' ).esc_attr( $class.'__front' )."'>";
            $out .= "<div class='".esc_attr( $class.'__layer__overlay' )."'>";

                $out .= "<div class='".esc_attr( $class.'__layer__inner' )."'>";
                    $graphic = $settings[ 'graphic_element' ];

                    if ( $graphic == 'icon' ) {
                        $out .= $this->flip_box_render_icon( $settings );
                    } else if ( $graphic == 'image' ) {
                        $out .= $this->flip_box_render_image( $image, $image_size );
                    }
                    $title = $settings[ 'front_title_text' ];
                    $description = $settings[ 'front_description_text' ];

                    $out .= "<h3 class='".esc_attr( $class.'__title' )."'>".esc_html( $title )."</h3>";
                    $out .= "<div class='".esc_attr( $class.'__description' )."'>".esc_html( $description )."</div>";
                $out .= "</div>";

            $out .= "</div>";
        $out .= "</div>";

        $out .= "<div class='".esc_attr( $class.'__layer ' ).esc_attr( $class.'__back' )."'>";
            $out .= "<div class='".esc_attr( $class.'__layer__overlay' )."'>";

                $out .= "<div class='".esc_attr( $class.'__layer__inner' )."'>";
                    $title = $settings[ 'back_title_text' ];
                    $description = $settings[ 'back_description_text' ];

                    $out .= "<h3 class='".esc_attr( $class.'__title' )."'>".esc_html( $title )."</h3>";
                    $out .= "<div class='".esc_attr( $class.'__description' )."'>".esc_html( $description )."</div>";

                    if ( !empty($button_text) && $show_button == 'yes' ) {
                        $out .= $this->flip_box_render_button( $button_text, $link );
                    }
                $out .= "</div>";

            $out .= "</div>";
        $out .= "</div>";

    $out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );
