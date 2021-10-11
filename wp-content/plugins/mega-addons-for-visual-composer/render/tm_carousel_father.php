<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_tm_carousel_father extends WPBakeryShortCodesContainer {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'theme'				=>		'default-tdt',
			'mbl_height'		=>		'',
			'effect'			=>		'false',
			'arrows'			=>		'true',
			'dot'				=>		'true',
			'autoplay'			=>		'true',
			'speed'				=>		'2500',
			'animation_speed'	=>		'500',
			'spaces'			=>		'0',
			'slide_visible'		=>		'1',
			'slide_visible_mbl'	=>		'1',
			'tabs'				=>		'1',
			'slide_scroll'		=>		'1',
			'borderclr'			=>		'transparent',
			'arrowclr'			=>		'#000',
			'arrowbg'			=>		'',
			'arrowsize'			=>		'30',
			'dotclr'			=>		'#000',
			'dotsize'			=>		'30',
			'class'				=>		'',
		), $atts ) );
		$some_id = rand(5, 500);
		$content = wpb_js_remove_wpautop($content);
		wp_enqueue_style( 'slick-carousel-css', plugins_url( '../css/slick-carousal.css' , __FILE__ ));
		wp_enqueue_script( 'slick-js', plugins_url( '../js/slick.js' , __FILE__ ), array('jquery'));
		wp_enqueue_script( 'custom-js', plugins_url( '../js/custom-tm.js' , __FILE__ ), array('jquery'));
		ob_start(); ?>
		<section class="tm-slider slider <?php echo $class; ?> <?php echo $theme; ?>" id="tdt-slider-<?php echo $some_id ?>" data-mobiles="<?php echo $slide_visible_mbl ?>" data-tabs="<?php echo $tabs ?>" data-slick='{"arrows": <?php echo $arrows; ?>, "autoplaySpeed": <?php echo $speed; ?>, "speed": <?php echo $animation_speed; ?>, "dots": <?php echo $dot; ?>, "autoplay": true, "slidesToShow": <?php echo $slide_visible; ?>, "slidesToScroll": <?php echo $slide_scroll; ?>, "fade": <?php echo $effect; ?>}'>
		    <?php echo $content; ?>
		</section>

		<style>
			#tdt-slider-<?php echo $some_id ?> .slick-slide {
				padding: 0 <?php echo $spaces ?>px !important;
			}
			<?php if ($dot == 'true') { ?>
				#tdt-slider-<?php echo $some_id ?> .slick-dots li button:before{
					color: <?php echo $dotclr ?>;
					font-size: <?php echo $dotsize; ?>px !important;
					border: 2px solid <?php echo $borderclr ?>;
				}
			<?php } ?>
			<?php if ($arrows == 'true') { ?>
				#tdt-slider-<?php echo $some_id ?> .slick-next:before, #tdt-slider-<?php echo $some_id ?> .slick-prev:before {
					color: <?php echo $arrowclr ?> !important;
					background: <?php echo $arrowbg; ?> !important;
					font-size: <?php echo $arrowsize; ?>px !important;
				}
			<?php } ?>
			<?php if ($theme == 'content-over-slider') { ?>
				@media only screen and (max-width: 480px) {
					#tdt-slider-<?php echo $some_id ?>.content-over-slider .slick-slide .content-section {
						top: 35px !important;
					}
					#tdt-slider-<?php echo $some_id ?>.content-over-slider .ultimate-slide-img {
						height: <?php echo $mbl_height; ?>px !important;
						object-fit: cover;
					}
				}
			<?php } ?>
		</style>
		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "tm_carousel_father",
	"name" 			=> __( 'Advanced Carousel', 'tm-carousel' ),
	"as_parent" 	=> array('only' => 'tm_carousel_son'),
	"content_element" => true,
	"js_view" 		=> 'VcColumnView',
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('show as slider', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/carousal-slider.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Select Theme', 'slider' ),
			"param_name" 	=> 	"theme",
			"description"	=>	__('Use as carousal top image bottom content or as slider image over content <a href="https://addons.topdigitaltrends.net/carousal-slider/" target="_blank">See Demo</a>', 'slider'),
			"group" 		=> 'Settings',
				"value" 		=> 	array(
					"Top Image Bottom Content" 		=> 		"default-tdt",
					"Content Over Image" 			=> 		"content-over-slider",
				)
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Slide Effect', 'slider' ),
			"param_name" 	=> 	"effect",
			"description"	=>	__('choose slider effect', 'slider'),
			"group" 		=> 'Settings',
				"value" 		=> 	array(
					"Slide [Right To Left]" 		=> 		"false",
					"Fade" 			=> 		"true",
				)
		),
		
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Autoplay', 'slider' ),
			"param_name" 	=> 	"autoplay",
			"description"	=>	__('move auto or slide on click', 'slider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"True" 		=> 		"true",
				"False (available in pro)" 	=> 		"false",
			)
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Adaptive Height', 'slider' ),
			"param_name" 	=> 	"adaptiveheight",
			"description"	=>	__('resize height automatically to fill the gap If each slide has different height', 'slider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"False" 						=> 		"false",
				"True (available in pro)" 		=> 		"true",
			)
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Slider Speed', 'slider' ),
			"param_name" 	=> 	"speed",
			"edit_field_class" => "vc_col-sm-6",
			"description"	=>	__('Required: write in ms eg, 2000 [1s = 1000]', 'slider'),
			"value"			=>	"2500",
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Animation Speed', 'slider' ),
			"param_name" 	=> 	"animation_speed",
			"edit_field_class" => "vc_col-sm-6",
			"description"	=>	__('Required: Slide/Fade animation speed in ms', 'slider'),
			"value"			=>	"500",
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Spaces between two items [px]', 'slider' ),
			"param_name" 	=> 	"spaces",
			"value"			=>	"0",
			"group" 		=> 'Settings',
		),
		array(
			"type"             => "text",
			"param_name"       => "wdo_title_text_typography",
			"heading"          => "<b>" . __( "Slides to Show‏", "wdo-carousel" ) . "</b>",
			"value"            => "",
			"edit_field_class" => "vc_col-sm-12 wdo_margin_top",
			"group"            => "Settings"
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Desktop', 'slider' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"slide_visible",
			"description"	=>	__('set visible number of slides. default is 1', 'slider'),
			"value"			=>	"1",
			"group" 		=> 'Settings',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Tabs', 'slider' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"tabs",
			"value"			=>	"1",
			"group" 		=> 'Settings',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'On Mobile', 'slider' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"slide_visible_mbl",
			"value"			=>	"1",
			"group" 		=> 'Settings',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Slide To Scroll', 'slider' ),
			"param_name" 	=> 	"slide_scroll",
			"description"	=>	__('allow user to multiple slide on click or drag. default is 1', 'slider'),
			"value"			=>	"1",
			"group" 		=> 'Settings',
		),
		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Extra Class', 'int_banner' ),
			"param_name" 	=> 	"class",
			"description" 	=> 	__( 'Add extra class name that will be applied to the icon process, and you can use this class for your customizations.', 'int_banner' ),
			"group" 		=> 	"Settings",
        ),
        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Settings',
		),

		// Arrow Section Setting

        array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Arrows', 'slider' ),
			"param_name" 	=> 	"arrows",
			"description"	=>	__('Show/Hide on left & right', 'slider'),
			"group" 		=> 'Navigation',
				"value" 		=> 	array(
					"Show" 			=> 		"true",
					"Hide" 			=> 		"false",
				)
		),
		
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Arrow Color', 'slider' ),
			"param_name" 	=> 	"arrowclr",
			"dependency" 	=> array('element' => "arrows", 'value' => 'true'),
			"value"			=>	"#000",
			"group" 		=> 'Navigation',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Arrow background', 'slider' ),
			"param_name" 	=> 	"arrowbg",
			"dependency" 	=> array('element' => "arrows", 'value' => 'true'),
			"group" 		=> 'Navigation',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Arrow Font Size', 'slider' ),
			"param_name" 	=> 	"arrowsize",
			"description"	=>	"set in pixel eg, 20",
			"dependency" 	=> array('element' => "arrows", 'value' => 'true'),
			"suffix" 		=> 	'px',
			"value"			=>	"30",
			"group" 		=> 'Navigation',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Position [Pro Option]', 'slider' ),
			"param_name" 	=> 	"arrowposition",
			"description"	=>	"change the position of arrows on slider, with minus sign arrows move away from slider",
			"value"			=>	"",
			"dependency" 	=> array('element' => "arrows", 'value' => 'true'),
			"group" 		=> 'Navigation',
		),

		// Dot Section Setting 
		
		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Dot Settings</span>', 'ihover' ),
			"group" 		=> 'Navigation',
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Dots', 'slider' ),
			"param_name" 	=> 	"dot",
			"description"	=>	__('Show/Hide show at bottom', 'slider'),
			"group" 		=> 'Navigation',
				"value" 		=> 	array(
					"Show" 			=> 		"true",
					"Hide" 			=> 		"false",
				)
		),
		
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Dot/Border', 'slider' ),
			"param_name" 	=> 	"style",
			"group" 		=> 'Navigation',
			"dependency" => array('element' => "dot", 'value' => 'true'),
			"value"			=>	array(
				"Dot"		=>		"dot",
				"Border"	=>		"border",
			)
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Dot Color', 'slider' ),
			"param_name" 	=> 	"dotclr",
			"dependency" => array('element' => "style", 'value' => 'dot'),
			"value"			=>	"#000",
			"group" 		=> 'Navigation',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Dot Size [px]', 'slider' ),
			"dependency" => array('element' => "style", 'value' => 'dot'),
			"param_name" 	=> 	"dotsize",
			"value"			=>	"30",
			"group" 		=> 'Navigation',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Border Color', 'slider' ),
			"param_name" 	=> 	"borderclr",
			"dependency" => array('element' => "style", 'value' => 'border'),
			"value"			=>	"",
			"group" 		=> 'Navigation',
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Position [Pro Option]', 'slider' ),
			"param_name" 	=> 	"dotposition",
			"dependency" => array('element' => "dot", 'value' => 'true'),
			"description"	=>	"change the position of Dots on slider, with minus sign dots move away from slider",
			"value"			=>	"",
			"group" 		=> 'Navigation',
		),
		 

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Carousel Height (For Mobile)', 'slider' ),
			"param_name" 	=> 	"mbl_height",
			"description"	=>	__( 'set in pixel eg, 250 or leave blank', 'slider' ),
			"suffix" 		=> 	'px',
			"dependency" => array('element' => "theme", 'value' => 'content-over-slider'),
			"group" 		=> 'Mobile Option',
		),
	)
) );
