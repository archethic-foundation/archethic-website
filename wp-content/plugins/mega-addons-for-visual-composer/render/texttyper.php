<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_text_type_vc extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'align'	 		=> 'left',
			'typespeed' 	=> '70',
			'backspeed' 	=> '500',
			'loop' 			=> '',
			'verticalclr' 	=> '#000',
			'checked' 		=> '',
			'before'		=>	'',
			'after'			=>	'',
			'size'			=>	'18',
			'textmblsize'	=>	'18',
			'typersize'		=>	'18',
			'typermblsize'	=>	'18',
			'clr'			=>	'',
		), $atts ) );
		$some_id = rand(5, 500);
		$content = wpb_js_remove_wpautop($content, true);
		wp_enqueue_script( 'typed-js', plugins_url( '../js/typed.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		wp_enqueue_script( 'typer-js', plugins_url( '../js/customTyper.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		wp_localize_script( 'typer-js', 'mega_text', array(
			'typespeed' => $typespeed,
			'backspeed' => $backspeed,
		) );
		ob_start(); ?>
		<!-- HTML DESIGN HERE -->

		<div class="type-wrap type-wrap-<?php echo $some_id; ?>"
			data-typespeed="<?php echo $typespeed; ?>"
			data-backspeed="<?php echo $backspeed; ?>"
			data-loop="<?php echo $loop; ?>"
			style="height: 50px; text-align: <?php echo $align; ?>;">
			<span class="mega-prefix" style="font-size: <?php echo $size; ?>px; color: <?php echo $clr; ?>;"> <?php echo $before; ?></span>
	            <div class="typed-strings">
	                <?php echo $content; ?>
	            </div>
	            <span class="typed" style="white-space:pre;"></span>
	            <?php if (!empty($checked)) { ?>
	            	<span class="blink_me" style="font-size: <?php echo $size; ?>px; color: <?php echo $verticalclr; ?>;">|</span>	            	
	            <?php } ?>
	        <span class="mega-suffix" style="font-size: <?php echo $size; ?>px;color: <?php echo $clr; ?>;"> <?php echo $after; ?></span>
        </div>

        <style>
			.type-wrap-<?php echo $some_id; ?> .typed{
				font-size: <?php echo $typersize; ?>px;
			}
			.type-wrap span {
				display: inline-block;
			}
			@media only screen and (max-width: 768px) {
				.type-wrap-<?php echo $some_id; ?> .typed,
				.type-wrap-<?php echo $some_id; ?> .blink_me {
					font-size: <?php echo $typermblsize; ?>px !important;
				}

				.type-wrap-<?php echo $some_id; ?> .mega-prefix,
				.type-wrap-<?php echo $some_id; ?> .mega-suffix {
					font-size: <?php echo $typermblsize; ?>px !important;
				}
			}
        </style>

        <!-- HTML END DESIGN HERE -->
		<?php 
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Text Type', 'text_type_vc' ),
	"base" 			=> "text_type_vc",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Fancy line with animation effects', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/texttype.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Text Align', 'texttype_vc' ),
			"param_name" 	=> 	"align",
			"description" 	=> 	__( 'set text align <a href="https://addons.topdigitaltrends.net/texttype-effects/" target="_blank">See Demo</a>', 'texttype_vc' ),
			"group" 		=> 	'General',
			"value"			=>	array(
				"Left" 			=> 	"left",
				"Center" 		=> 	"center",
				"Right" 		=> 	"right",
			)
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Prefix', 'texttype_vc' ),
			"param_name" 	=> 	"before",
			"description" 	=> 	__( 'write text that will show before typer text or leave blank', 'texttype_vc' ),
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Suffix', 'texttype_vc' ),
			"param_name" 	=> 	"after",
			"description" 	=> 	__( 'write text that will show after typer text or leave blank', 'texttype_vc' ),
			"group" 		=> 	'General',
		),
		array(
			"type"             => "text",
			"param_name"       => "wdo_title_text_typography",
			"heading"          => "<b>" . __( "Prefix/Suffix Text Font Size", "wdo-carousel" ) . "</b>",
			"value"            => "",
			"edit_field_class" => "vc_col-sm-12 wdo_margin_top",
			"group"            => "General"
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Desktop', 'texttype_vc' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"size",
			"suffix" 		=> 'px',
			'value' 		=> __( "18", 'texttype_vc' ),
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Mobile', 'slider' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"textmblsize",
			"suffix" 		=> 'px',
			"value"			=>	"18",
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Text Color', 'texttype_vc' ),
			"param_name" 	=> 	"clr",
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
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Show Vertical line|', 'texttype_vc' ),
			"param_name" 	=> 	"checked",
			"description" 	=> 	__( 'with and after typer text', 'texttype_vc' ),
			"group" 		=> 	'Typer Text',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Vertical line Color', 'texttype_vc' ),
			"param_name" 	=> 	"verticalclr",
			"group" 		=> 	'Typer Text',
		),
		array(
			"type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Provide text to display (each per line) [ Text must be wrapped in html markup ]', 'texttype_vc' ),
			"param_name" 	=> 	"content",
			"description" 	=> 	__( 'Text must be wrapped in html markup.', 'texttype_vc' ),
			'value' 		=> __( "I'm hello world", 'texttype_vc' ),
			"group" 		=> 	'Typer Text',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Text type speed', 'texttype_vc' ),
			"param_name" 	=> 	"typespeed",
			"description" 	=> 	__( 'in milli second, default 70 [1s = 1000]', 'texttype_vc' ),
			"max"			=>	"",
			'value' 		=> __( "70", 'texttype_vc' ),
			"group" 		=> 	'Setting',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Back delay speed', 'texttype_vc' ),
			"param_name" 	=> 	"backspeed",
			"description" 	=> 	__( 'in milli second, default 500 [1s = 1000]', 'texttype_vc' ),
			"max"			=>	"",
			'value' 		=> __( "500", 'texttype_vc' ),
			"group" 		=> 	'Setting',
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Loop', 'texttype_vc' ),
			"param_name" 	=> 	"loop",
			"description" 	=> 	__( 'Repeat text', 'texttype_vc' ),
			"group" 		=> 	'Setting',
			'value' 		=> 	 array( 'true', 'false' ),
		),
		array(
			"type"             => "text",
			"param_name"       => "wdo_title_text_typography",
			"heading"          => "<b>" . __( "TextTyper Font Size", "wdo-carousel" ) . "</b>",
			"value"            => "",
			"edit_field_class" => "vc_col-sm-12 wdo_margin_top",
			"group"            => "Setting"
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Desktop', 'texttype_vc' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"typersize",
			"suffix" 		=> 'px',
			'value' 		=> __( "18", 'texttype_vc' ),
			"group" 		=> 	'Setting',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Mobile', 'slider' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"typermblsize",
			"suffix" 		=> 'px',
			"value"			=>	"18",
			"group" 		=> 'Setting',
		),
	),
) );

