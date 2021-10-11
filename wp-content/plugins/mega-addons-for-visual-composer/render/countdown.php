<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_countdown extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'id'		=>	'',
			'style'		=>	'YOWDHMS',
			'size'		=>	'',
			'lineheight'	=>	'',
			'textcolor'	=>	'white',
			'bgcolor'	=>	'',
			'periodsize'	=>	'',
			'periodcolor'	=>	'',
			'width'		=>	'100',
			'height'	=>	'100',
			'padding'	=>	'',
			'margin'	=>	'',
			'borderwidth'	=>	'0',
			'radius'	=>	'',
			'borderclr'	=>	'',
			'borderstyle'	=>	'solid',
			'year'		=>	'',
			'month'		=>	'',
			'date'		=>	'',
		), $atts ) );
		$content = wpb_js_remove_wpautop($content, true);
		wp_enqueue_style( 'countdown-css', plugins_url( '../css/jquery.countdown.css' , __FILE__ ));
		wp_enqueue_script( 'countdown-min-js', plugins_url( '../js/countdown.min.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		wp_enqueue_script( 'countdown-js', plugins_url( '../js/jquery.countdown.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		wp_enqueue_script( 'custom-countdown-js', plugins_url( '../js/front-js/countdown.js' , __FILE__ ), array('jquery') );
		ob_start(); ?>
		<div
			id="defaultCountdown<?php echo $id; ?>"
			style="width: 100%;"
			class="countdownapply"
			data-style="<?php echo $style; ?>"
			data-year="<?php echo $year; ?>"
			data-month="<?php echo $month; ?>"
			data-date="<?php echo $date; ?>"
		>

		</div>
		<style>
			#defaultCountdown<?php echo $id; ?>  .countdown-section {
				background-color: <?php echo $bgcolor; ?>;
				width: <?php echo $width; ?>px;
				height: <?php echo $height; ?>px;
				margin: 0 <?php echo $margin; ?>px;
				border: <?php echo $borderwidth; ?>px <?php echo $borderstyle; ?> <?php echo $borderclr; ?>;
				border-radius: <?php echo $radius; ?>;
				line-height: <?php echo $lineheight; ?>;
				display: inline-block;
			    float: none !important;
			}
			#defaultCountdown<?php echo $id; ?> {
				text-align: center;
			}
			#defaultCountdown<?php echo $id; ?>  .countdown-section .countdown-amount {
				font-size: <?php echo $size; ?>px;
				color: <?php echo $textcolor; ?>;
				padding-top: <?php echo $padding; ?>px;
				display: block;
			}
			#defaultCountdown<?php echo $id; ?>  .countdown-section .countdown-period {
				font-size: <?php echo $periodsize; ?>px;
				color: <?php echo $periodcolor; ?>;
			}
		</style>
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Countdown', 'countdown' ),
	"base" 			=> "mvc_countdown",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Set Countdown timer', 'countdown'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/countdown.png',
	'params' => array(
		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Unique ID', 'countdown' ),
			"param_name" 	=> 	"id",
			"description" 	=> 	__( 'Required: It should be different from other countdown time. Any Name or numbers <a target="_blank" href="https://addons.topdigitaltrends.net/countdown/">Demo</a>', 'countdown' ),
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Width', 'countdown' ),
			"param_name" 	=> 	"width",
			"description" 	=> 	__( 'set width in pixel for each week, hours, minutes and seconds e.g 100', 'countdown' ),
			"value"			=>	'100',
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Height', 'countdown' ),
			"param_name" 	=> 	"height",
			"description" 	=> 	__( 'set height in pixel for each week, hours, minutes and seconds e.g 100', 'countdown' ),
			"value"			=>	'100',
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),

		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Timer Font size', 'countdown' ),
			"param_name" 	=> 	"size",
			"description" 	=> 	__( 'Timer font size in pixel e.g 18', 'countdown' ),
			"value"			=>	'18',
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Period Font size', 'countdown' ),
			"param_name" 	=> 	"periodsize",
			"description" 	=> 	__( 'period font size in pixel e.g 18', 'countdown' ),
			"value"			=>	'18',
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Line Height', 'countdown' ),
			"param_name" 	=> 	"lineheight",
			"description" 	=> 	__( 'set line height between  e.g 1', 'countdown' ),
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Padding From Top', 'countdown' ),
			"param_name" 	=> 	"padding",
			"description" 	=> 	__( 'padding from top help to move time in center default 15', 'countdown' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Margin', 'countdown' ),
			"param_name" 	=> 	"margin",
			"description" 	=> 	__( 'set margin for each timer space between them from left and right side e.g 10', 'countdown' ),
			"value"			=>	"10",
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
        ),

        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'General',
		),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Timer Text Color', 'countdown' ),
			"param_name" 	=> 	"textcolor",
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Period Text Color', 'countdown' ),
			"param_name" 	=> 	"periodcolor",
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'countdown' ),
			"param_name" 	=> 	"bgcolor",
			"description" 	=> 	__( 'count down background color', 'countdown' ),
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Border Width', 'countdown' ),
			"param_name" 	=> 	"borderwidth",
			"description" 	=> 	__( 'set border width in pixel or leave blank e.g 10', 'countdown' ),
			"value"			=>	"0",
			"suffix" 		=>  'px',
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Border Radius', 'countdown' ),
			"param_name" 	=> 	"radius",
			"description" 	=> 	__( 'border radius in pixel or percentage e.g 5px or 50%', 'countdown' ),
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Border Color', 'countdown' ),
			"param_name" 	=> 	"borderclr",
			"description" 	=> 	__( 'set border color', 'countdown' ),
			"group" 		=> 	'Color',
        ),

        array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Style', 'countdown' ),
			"param_name" 	=> "borderstyle",
			"description" 	=> __( 'set border style', 'countdown' ),
			"group" 		=> 'Color',
				"value" 		=> array(
					'Solid'	=>	'solid',
					'Dotted'	=>	'dotted',
					'none'	=>	'none',
					'Dashed'	=>	'dashed',
					'Hidden'	=>	'hidden',
					'Double'	=>	'double',
					'Groove'	=>	'groove',
					'Ridge'	=>	'ridge',
					'Outset'	=>	'outset',
					'Initial'	=>	'initial',
				)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Select Style', 'countdown' ),
			"param_name" 	=> "style",
			"description" 	=> __( 'Visible countdown style in', 'countdown' ),
			"group" 		=> 'Countdown',
				"value" 		=> array(
					'Year'	=>	'YOWDHMS',
					'Month'	=>	'odHMS',
					'Week'	=>	'wdHMS',
					'Days'	=>	'DHMS',
					'Hours'	=>	'HMS',
				)
		),

		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Year', 'countdown' ),
			"param_name" 	=> 	"year",
			"description" 	=> 	__( 'just number start from 0 [ e.g 0 for current year, 1 for next year.. ]', 'countdown' ),
			"group" 		=> 	'Countdown',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Month', 'countdown' ),
			"param_name" 	=> 	"month",
			"description" 	=> 	__( 'just number between 1 to 12 for specific month [ e.g 3 ]', 'countdown' ),
			"group" 		=> 	'Countdown',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Date', 'countdown' ),
			"param_name" 	=> 	"date",
			"description" 	=> 	__( 'just number between 1 to 30 for specific date', 'countdown' ),
			"group" 		=> 	'Countdown',
        ),
	),
) );

