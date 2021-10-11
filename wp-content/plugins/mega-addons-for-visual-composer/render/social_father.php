<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_social_vc_father extends WPBakeryShortCodesContainer {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'align' 	=> 'left',
		), $atts ) );
		$content = wpb_js_remove_wpautop($content, true);
		wp_enqueue_style( 'social-icons-css', plugins_url( 'css/socialicons.css' , __FILE__ ));
		ob_start(); ?>
		<div style="text-align: <?php echo $align; ?>;">
			<div id="mega_social_icons" style="display: inline-flex;">
				<?php echo $content; ?>
			</div>
		</div>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "social_vc_father",
	"name" 			=> __( 'Social Icons', 'socialicon' ),
	"as_parent" 	=> array('only' => 'social_vc_son'),
	"content_element" => true,
	"js_view" 		=> 'VcColumnView',
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('social icons with animated effects', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/social.png',
	'params' => array(
		array(
				"type" 			=> 	"dropdown",
				"heading" 		=> 	__( 'Social Position', 'socialicon' ),
				"param_name" 	=> 	"align",
				"group" 		=> 'General',
				"value" 		=> 	array(
					"Left" 			=> 	"left",
					"Center" 		=> 	"center",
					"Right" 		=> 	"right",
				)
			),
		)
) );
