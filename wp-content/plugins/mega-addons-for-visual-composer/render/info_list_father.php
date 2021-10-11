<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_info_list_father extends WPBakeryShortCodesContainer {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'theme'			=>		'left',
			'connector_h'	=>		'30',
			'listwidth'		=>		'1',
			'liststyle'		=>		'solid',
			'listclr'		=>		'#000',
			'css'			=> '',
		), $atts ) );
		$GLOBALS['maw_infolist_theme'] = $theme; $GLOBALS['maw_infolist_connector_h'] = $connector_h; $GLOBALS['maw_infolist_listwidth'] = $listwidth;
		$GLOBALS['maw_infolist_liststyle'] = $liststyle; $GLOBALS['maw_infolist_listclr'] = $listclr;
		$content = wpb_js_remove_wpautop($content, true);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		wp_enqueue_style( 'info-list-css', plugins_url( '../css/infolist.css' , __FILE__ ));
		ob_start(); ?>
		<ul class="mega-info-list <?php echo $css_class; ?>" style="list-style-type: none; height: 100%;">
			<?php echo $content; ?>
		</ul>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "info_list_father",
	"name" 			=> __( 'Info List', 'infolist' ),
	"as_parent" 	=> array('only' => 'info_list_son'),
	"content_element" => true,
	"js_view" 		=> 'VcColumnView',
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Text blocks connected together in one list', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/infolist.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Style', 'infolist' ),
			"param_name" 	=> 	"theme",
			"description" 	=> 	__( 'choose style <a href="http://addons.topdigitaltrends.net/info-list/">See demo</a>', 'infolist' ),
			"group" 		=> 'Settings',
			"value"			=> array(
				"Left Align"			=>	"left",
				"Right Align"			=>	"right",
			)
		),
		
		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Connector Line Height', 'infolist' ),
			"param_name" 	=> 	"connector_h",
			"description" 	=> 	__( 'line between to info list. set in pixel default 30', 'infolist' ),
			"value"			=>	"30",
			"suffix" 		=> 'px',
			"group" 		=> 	'Settings',
        ),
		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Connector Width', 'infolist' ),
			"param_name" 	=> 	"listwidth",
			"description" 	=> 	__( 'set connector line width for info list in pixel eg, 1', 'infolist' ),
			"value"			=>	"1",
			"suffix" 		=> 'px',
			"group" 		=> 	'Settings',
        ),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Line Style', 'infolist' ),
			"param_name" 	=> 	"liststyle",
			"description" 	=> 	__( 'set border style for info list', 'infolist' ),
			"group" 		=> 'Settings',
			"value"			=> array(
				"Solid"			=>	"solid",
				"Dotted"		=>	"dotted",
				"Dashed"		=>	"dashed",
				"Inset"			=>	"inset",
			)
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Line color', 'infolist' ),
			"param_name" 	=> 	"listclr",
			"description" 	=> __('set connector line color for info list', 'infolist'),
			"group" 		=> 'Settings',
		),


		array(
			"type" 			=> 	"css_editor",
			"heading" 		=> 	__( 'Design Options', 'infolist' ),
			"param_name" 	=> 	"css",
			"group" 		=> 'Design Options',
		),
	)
) );
