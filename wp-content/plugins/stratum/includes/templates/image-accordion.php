<?php

extract(shortcode_atts([
    'direction'   => 'horizontal',
    'active_type' => 'activate-on-click',
    'skew_switcher'  => '',
    'skew_direction' => 'right',
    'content_align'  => 'center',
    'hovered_default_active' => 0,
    'opened_default_active'  => 0
], $settings ));

$class = $this->get_name();
$out = "";

/* #region Widget classes */
$widget_class = [ $class, 'image-accordion-'.esc_attr( $direction ), $active_type ];

$skew_class = '';
if ( $skew_switcher && $direction == 'horizontal' ) {
    $skew_class = 'skew-direction-'.$skew_direction;
    array_push(
        $widget_class,
        'image-accordion-skew'
    );
}

$this->add_render_attribute( 'widget', 'class', $widget_class );
$widget_class = $this->get_render_attribute_string( 'widget' );
/* #endregion */

$out .= "<div ".$widget_class.">";
    $out .= "<div class='".esc_attr( $class.'__container'.' '.$skew_class )."'>";

    foreach ( $settings[ 'image_content' ] as $index => $item ) {

        /* #region Item classes */
        $item_classes = [ $class.'__item' ,'elementor-repeater-item-'.esc_attr( $item[ '_id' ] ) ];
        $default_active = $active_type == 'activate-on-click' ? $opened_default_active : $hovered_default_active;

        if ( $default_active && ($default_active - 1) == $index ) {
            array_push( $item_classes, 'default-active' );
        }

        $this->add_render_attribute( 'item'.$index, [ 'class' => $item_classes ] );
        $item_classes = $this->get_render_attribute_string( 'item'.$index );
        /* #endregion */

        $out .= "<div ".$item_classes.">";
            $out .= "<div class='".esc_attr( $class.'__background' )."'></div>";
            $out .= "<div class='".esc_attr( $class.'__overlay' )."'>";

                /* #region Content classes */
                $this->add_render_attribute( 'content', [ 'class' => [ $class.'__content', 'image-accordion-'.$content_align ] ] );
                $content_classes = $this->get_render_attribute_string( 'content' );
                /* #endregion */

                if ( $item[ 'content_switcher' ] ) {

                    $title = $item[ 'item_title' ];
                    $description = $item[ 'item_description' ];

                    $out .= "<div ".$content_classes.">";
                        if ( $item[ 'icon_switcher' ] ) {
                            $icon = $item[ 'icon_updated' ];
                            $out .= "<i class='".esc_attr( $class.'__icon' ).' '.esc_attr( $icon )."'></i>";
                        }
                        $out .= "<h3 class='".esc_attr( $class.'__title' )."'>".esc_html( $title )."</h3>";
                        $out .= "<div class='".esc_attr( $class.'__description' )."'>".esc_html( $description )."</div>";

                        /* #region Render button */
                        $link 		 = $item[ 'link' ];
                        $button_text = $item[ 'button_text' ];
                        $show_button = $item[ 'show_button' ];

                        if ( ! empty( $button_text ) && $show_button == 'yes' ) {
                            $out .= $this->image_accordion_render_button( $index, $button_text, $link );
                        }
                        /* #endregion */
                    $out .= "</div>";
                }
            $out .= "</div>";
        $out .= "</div>";
    }
    $out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );