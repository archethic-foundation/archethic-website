<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_timeline_father extends WPBakeryShortCodesContainer {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title'	=>	'',
			'size'	=>	'',
			'clr'	=>	'',
			'bgclr'	=>	'',
			'width'	=>	'',
			'linebg'	=>	'',
		), $atts ) );
		$content = wpb_js_remove_wpautop($content, true);
		wp_enqueue_style( 'timeline-css', plugins_url( '../css/timeline.css' , __FILE__ ));
		wp_enqueue_script( 'timeline-js', plugins_url( '../js/timeline.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		wp_enqueue_script( 'animtimeline-js', plugins_url( '../js/animtimeline.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		ob_start(); ?>
		
			<div class="mega-timeline-title"><span style="font-size: <?php echo $size; ?>px; color: <?php echo $clr; ?>;background:<?php echo $bgclr; ?>;">
				<?php echo $title ?>
			</span></div>
			<div id="cd-timeline" class="cd-container">
				<span class="timeline-line" style="width: <?php echo $width; ?>px; background: <?php echo $linebg; ?>;"></span>
				<span></span>
				<?php echo $content; ?>
			</div>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "mvc_timeline_father",
	"name" 			=> __( 'Timeline', 'timeline' ),
	"as_parent" 	=> array('only' => 'mvc_timeline_son'),
	"content_element" => true,
	"js_view" 		=> 'VcColumnView',
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Add multiple images and text', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/timeline.png',
	'params' => array(
			array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title', 'timeline' ),
			"param_name" 	=> 	"title",
			"description" 	=> 	__( 'main title of timeline', 'timeline' ),
			"group" 		=> 	'General',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font Size', 'timeline' ),
			"param_name" 	=> 	"size",
			"description" 	=> 	__( 'title font size in pixel e.g 17', 'timeline' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'timeline' ),
			"param_name" 	=> 	"clr",
			"description" 	=> 	__( 'title color', 'timeline' ),
			"group" 		=> 	'General',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'timeline' ),
			"param_name" 	=> 	"bgclr",
			"description" 	=> 	__( 'title background color', 'timeline' ),
			"group" 		=> 	'General',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Line Width', 'timeline' ),
			"param_name" 	=> 	"width",
			"description" 	=> 	__( 'set timeline central line width in pixel default 4', 'timeline' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background', 'timeline' ),
			"param_name" 	=> 	"linebg",
			"description" 	=> 	__( 'central line background color', 'timeline' ),
			"group" 		=> 	'General',
        ),
		)
) );
