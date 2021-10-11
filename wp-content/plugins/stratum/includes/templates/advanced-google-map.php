<?php

$class = 'stratum-advanced-google-map';
$out = "";

//Get Api Key
$stratum_api = get_option( 'stratum_api', [] );
$api_key = isset( $stratum_api['google_api_key'] ) ? $stratum_api['google_api_key'] : '';

//If Empty Key
if ( empty( $api_key ) ) {
	if ( current_user_can( 'manage_options' ) ) {
        $out .= "<div class='".esc_attr( $class )."'>";
            $out .= "<div class='".esc_attr( $class. '__notice' )."'>";
                $out .= '<p>' . esc_html__( 'Whoops! It seems like you didn\'t set Google Map API key. You can set it from Stratum > Settings > API > Google Api Key', 'stratum' ) . '</p>';;
            $out .= "</div>";
        $out .= "</div>";
	} else {
		return '';
	}
}

$options = [
    'center' => [
        'mapLat' => esc_attr( $settings[ 'map_lat' ] ),
        'mapLng' => esc_attr( $settings[ 'map_lng' ] )
    ],
    'controls' => [
        'streetViewControl' => !empty( $settings[ 'street_view_control' ] ) ? true : false,
        'mapTypeControl'    => !empty( $settings[ 'map_type_control' ] )    ? true : false,
        'zoomControl'       => !empty( $settings[ 'zoom_control' ] )        ? true : false,
        'fullscreenControl' => !empty( $settings[ 'fullscreen_control' ] )  ? true : false
    ],
    'zoomLevel'       => $settings[ 'zoom_level' ],
    'markerTypeSetup' => $settings[ 'marker_type_setup' ],
    'mapTypeSetup'    => $settings[ 'map_type_setup' ],
    'interaction'     => $settings[ 'interaction' ],

    'markers'  => $this->get_markers_options( $settings ),
    'mapTheme' => $this->set_map_theme_style( $settings )
];

$map_options = json_encode( $options );

$out .= "<div class='".esc_attr( $class )."' "."data-map-options='".esc_attr( $map_options )."'>";
    $out .= "<div class='".esc_attr( $class.'__container' )."'>";
    $out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );