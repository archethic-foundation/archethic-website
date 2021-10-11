<?php

$class = 'stratum-horizontal-timeline';
$out = '';

$alignment = $settings[ 'horizontal_alignment' ];
$this->add_render_attribute( 'widget', [
    'class' => [
        $class,
        $class.'--align-'. $alignment
    ]
] );

$widget_class = $this->get_render_attribute_string( 'widget' );

$out .= "<div ".$widget_class.">";
    $out .= "<div class='".esc_attr( $class.'__inner' )."'>";
        $out .= "<div class='".esc_attr( $class.'__track' )."'>";
            
            /* #region Render card */
            $layout = $settings[ 'horisontal_layout' ];
            $out .= "<div class='".esc_attr( $class.'__list '.$class.'__list--top' )."'>";
                foreach ( $settings[ 'items_content' ] as $index => $item ) {

                    $uniqid = uniqid();
                    $is_active = $item[ 'is_item_active' ];
                    $title_html_tag = $settings[ 'item_title_tag' ];
                    $this->add_render_attribute( 'item'.$uniqid, [ 'class' => [
                        $class . '-item',
                        !empty( $is_active ) ? 'is-active' : '',
                        'elementor-repeater-item-'.esc_attr( $item[ '_id' ] )
                    ] ] );

                    $item_class = $this->get_render_attribute_string( 'item'.$uniqid );

                    $out .= "<div ".$item_class.">";
                        if ( $layout != 'bottom' ) {
                            if ( $layout == 'chess' ) {
                                if ( (int)bcmod( strval( $index + 1 ), '2' ) != 0 ) {
                                    $out .= $this->_generate_card_content(
                                        $class,
                                        $item,
                                        $settings,
                                        $title_html_tag,
                                        $index
                                    );
                                } else {
                                    $out .= "<div class='".esc_attr( $class.'-item__meta' )."'>".esc_html( $item[ 'item_meta' ] )."</div>";
                                }
                            } else {
                                $out .= $this->_generate_card_content(
                                    $class,
                                    $item,
                                    $settings,
                                    $title_html_tag,
                                    $index
                                );
                            }
                        } else if ( $layout == 'bottom' ) {
                            $out .= "<div class='".esc_attr( $class.'-item__meta' )."'>".esc_html( $item[ 'item_meta' ] )."</div>";
                        }
                    $out .= "</div>";
                }
            $out .= "</div>";
            /* #endregion */

            /* #region Render points */
            $out .= "<div class='".esc_attr( $class.'__list '.$class.'__list--middle' )."'>";
                $out .= "<div class='".esc_attr( $class.'__line' )."'></div>";

                foreach ( $settings[ 'items_content' ] as $index => $item ) {
                    $uniqid = uniqid();
                    $is_active = $item[ 'is_item_active' ];
                    
                    $this->add_render_attribute( 'item'.$uniqid, [ 'class' => [
                        $class . '-item',
                        !empty( $is_active ) ? 'is-active' : '',
                        'elementor-repeater-item-'.esc_attr( $item[ '_id' ] )
                    ] ] );

                    $item_class = $this->get_render_attribute_string( 'item'.$uniqid );

                    $out .= "<div ".$item_class.">";
                        $out .= "<div class='".esc_attr( $class.'-item__point' )."'>";
                            $out .= $this->_generate_point_content( $class, $item, $index );
                        $out .= "</div>";
                    $out .= "</div>";
                }
            $out .= "</div>";
            /* #endregion */

            /* #region Render meta */
            $out .= "<div class='".esc_attr( $class.'__list '.$class.'__list--bottom' )."'>";
                foreach ( $settings[ 'items_content' ] as $index => $item ) {
                    $uniqid = uniqid();
                    $is_active = $item[ 'is_item_active' ];
                    $this->add_render_attribute( 'item'.$uniqid, [ 'class' => [
                        $class . '-item',
                        !empty( $is_active ) ? 'is-active' : '',
                        'elementor-repeater-item-'.esc_attr( $item[ '_id' ] )
                    ] ] );

                    $item_class = $this->get_render_attribute_string( 'item'.$uniqid );

                    $out .= "<div ".$item_class.">";
                        if ( $layout != 'bottom' ) {
                            if ( $layout == 'chess' ) {
                                if ( (int)bcmod( strval( $index + 1 ), '2' ) != 0 ) {
                                    $out .= "<div class='".esc_attr( $class.'-item__meta' )."'>".esc_html( $item[ 'item_meta' ] )."</div>";
                                } else {
                                    $out .= $this->_generate_card_content(
                                        $class,
                                        $item,
                                        $settings,
                                        $title_html_tag,
                                        $index
                                    );
                                }
                            } else {
                                $out .= "<div class='".esc_attr( $class.'-item__meta' )."'>".esc_html( $item[ 'item_meta' ] )."</div>";
                            }
                        } else if ( $layout == 'bottom' ) {
                            $out .= $this->_generate_card_content(
                                $class,
                                $item,
                                $settings,
                                $title_html_tag,
                                $index
                            );
                        }
                    $out .= "</div>";
                }
            $out .= "</div>";
            /* #endregion */

        $out .= "</div>";
    $out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );