<?php

$anim_url = $settings[ 'lottie_url' ];

if( empty( $anim_url ) ) {
    return;
}

$class = 'stratum-lottie-animations';
$out = "";

$this->add_render_attribute( 'wrapper', [
    'class' => [ $class.'__wrapper' ],
    'data-lottie-url' => $settings[ 'lottie_url' ],
    'data-lottie-render' => $settings[ 'lottie_renderer' ],
    'data-lottie-loop' => $settings[ 'lottie_loop' ],
    'data-lottie-reverse' => $settings[ 'lottie_reverse' ],
    'data-lottie-speed' => $settings[ 'lottie_speed' ],
    'data-lottie-hover' => $settings[ 'lottie_hover' ]
]);

if( $settings[ 'animate_on_scroll' ] ) {
    $this->add_render_attribute( 'wrapper', [
        'class' => 'stratum-lottie-scroll',
        'data-lottie-scroll' => 'true',
        'data-scroll-start' => $settings['animate_view']['sizes']['start'],
        'data-scroll-end' => $settings['animate_view']['sizes']['end'],
        'data-scroll-speed' => $settings[ 'animate_speed' ][ 'size' ]
    ]);
}

$wrapper_classes = $this->get_render_attribute_string( 'wrapper' );

$out .= "<div class='".esc_attr( $class )."'>";
    $out .= "<div ".$wrapper_classes."></div>";
$out .= "</div>";

echo sprintf( "%s", $out );