<?php

$class = 'stratum-vertical-timeline';
$out = "";

$alignment = $settings[ 'vertical_alignment' ];
$this->add_render_attribute( 'widget', [
    'class' => [
        $class,
        $class.'--align-'. $alignment
    ],
    'data-animation' => esc_attr( $settings[ 'animate_cards' ] )
]);

$this->add_render_attribute( 'inner', [
    'class' => [
        $class.'-item__inner',
        $class.'-item__inner'.$this->_get_alignment( $settings, 'vertical' )
    ]
]);

$item_classes = [
    $class.'-item',
    $this->_get_alignment( $settings, 'horizontal' )
];

$widget_classes = $this->get_render_attribute_string( 'widget' );
$inner_classes  = $this->get_render_attribute_string( 'inner' );

$out .= "<div ".$widget_classes.">";

    $out .= "<div class='".esc_attr( $class.'__line' )."'>";
        $out .= "<div class='".esc_attr( $class.'__line-progress' )."'></div>";
    $out .= "</div>";

    $out .= "<div class='".esc_attr( $class.'__list' )."'>";

        foreach ( $settings[ 'image_content' ] as $index => $item ) {

            $merge = array_merge( $item_classes, [ 'elementor-repeater-item-'.esc_attr( $item[ '_id' ] ) ] );
            $title_html_tag = $settings[ 'title_tag' ];

            $this->add_render_attribute( 'item'.$index, [ 'class' => $merge ] );
            $item_class = $this->get_render_attribute_string( 'item'.$index );

            $out .= "<div ".$item_class.">";
                $out .= "<div ".$inner_classes.">";
                    $out .= "<div class='".esc_attr( $class.'-item__card' )."'>";

                        $out .= "<div class='".esc_attr( $class.'-item__card-inner' )."'>";

                            /* #region Render image */
                            if ( !empty( $item[ 'show_item_image' ] ) ) {
                                $out .= $this->_get_timeline_image( $class, $item );
                            }
                            /* #endregion */

                            $out .= "<div class='".esc_attr( $class.'-item__card-content' )."'>";
                            	if ( ! empty( $item[ 'item_link' ][ 'url' ] ) ) {
									$this->add_link_attributes( 'url' . $index, $item[ 'item_link' ] );
									$out .= "<a class='".esc_attr( $class.'-item__card-link' )."' " . $this->get_render_attribute_string( 'url' . $index ) . ">";
								}
                                	$out .= "<{$title_html_tag} class='".esc_attr( $class.'-item__card-title' )."'>".esc_html( $item[ 'item_title' ] )."</{$title_html_tag}>";
								if ( ! empty( $item[ 'item_link' ][ 'url' ] ) ) {
									$out .= "</a>";
								}

								if ( $item[ 'item_description_type' ] === 'default' ) {
									$out .= "<div class='".esc_attr( $class.'-item__card-description' )."'>".esc_html( $item[ 'item_description' ] )."</div>";
								} else {
									$out .= "<div class='".esc_attr( $class.'-item__card-description' )."'>". $item[ 'item_description_editor' ] ."</div>";
								}
                            $out .= "</div>";

                            $out .= "<div class='".esc_attr( $class.'-item__card-arrow' )."'></div>";

                        $out .= "</div>";

                    $out .= "</div>";

                    $out .= "<div class='".esc_attr( $class.'-item__point' )."'>";
                        $out .= $this->_generate_point_content( $class, $item, $index );
                    $out .= "</div>";

                    $out .= "<div class='".esc_attr( $class.'-item__meta' )."'>";
                        $out .= "<div class='".esc_attr( $class.'-item__meta-content' )."'>".esc_html( $item[ 'item_meta' ] )."</div>";
                    $out .= "</div>";

                $out .= "</div>";
            $out .= "</div>";
        }

    $out .= "</div>";

$out .= "</div>";

echo sprintf( "%s", $out );