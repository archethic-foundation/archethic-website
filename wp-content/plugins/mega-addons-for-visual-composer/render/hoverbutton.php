<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_button extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'btn_style' => 'animated',
			'anim_style' => 'transition',
			'anim_trans' => '',
			'bg_trans' => 'hvr-sweep-to-right',
			'shadow_trans' => 'hvr-shadow',
			'brdr_trans' => 'hvr-underline-from-left',
			'bubble_trans' => 'hvr-bubble-top',
			'align' => 'left',
			'padding_top' => '5',
			'padding_left' => '10',
			'btn_radius' => '',
			'btn_next' => '',
			'btn_url' => '',
			'btn_text' => '',
			'btn_size' => '18',
			'btn_icon' => '',
			'btn_border' => '',
			'border_width' => '1',
			'btn_clr' => '#000',
			'btn_bg' => '#fff',
			'btn_shadow' => '',
			'btn_hvrclr' => 'asda',
			'btn_hvrbg' => 'adsa',
		), $atts ) );
		$btn_url = vc_build_link($btn_url);
		wp_enqueue_style( 'hvr-btn-css', plugins_url( '../css/hoverbtn.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
		<div style="text-align: <?php echo $align; ?>;">
			<?php if ($btn_style == 'animated' && $anim_style == 'transition') { ?>
				<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onhoverbg="<?php echo $btn_hvrbg; ?>" data-onleavebg="<?php echo $btn_bg; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="mega_hvr_btn <?php echo $anim_trans; ?>" style="padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; border:<?php echo $border_width; ?>px solid <?php echo $btn_border; ?>; font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background-color: <?php echo $btn_bg; ?>; border-radius: <?php echo $btn_radius; ?>px">
					<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
				</a>
			<?php } ?>

			<!-- Background Transition -->
			<?php if ($btn_style == 'animated' && $anim_style == 'bg_transition') { ?>
				<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" style="padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; border:<?php echo $border_width; ?>px solid <?php echo $btn_border; ?>; font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background-color: <?php echo $btn_bg; ?>; border-radius: <?php echo $btn_radius; ?>px" class="mega_hvr_btn <?php echo $bg_trans; ?>">
					<span style="background: <?php echo $btn_hvrbg; ?>;"></span><i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
				</a>
			<?php } ?>

			<!-- Border Transition -->
			<?php if ($btn_style == 'animated' && $anim_style == 'brdr_transition') { ?>
				<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" style="padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; border:<?php echo $border_width; ?>px solid <?php echo $btn_border; ?>; font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background-color: <?php echo $btn_bg; ?>; border-radius: <?php echo $btn_radius; ?>px" class="mega_hvr_btn <?php echo $brdr_trans; ?>">
					<span style="background: <?php echo $btn_hvrbg; ?>;"></span><i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
				</a>
			<?php } ?>

			<!-- Shadow Transition -->
			<?php if ($btn_style == 'animated' && $anim_style == 'shadow') { ?>
				<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onhoverbg="<?php echo $btn_hvrbg; ?>" data-onleavebg="<?php echo $btn_bg; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="mega_hvr_btn <?php echo $shadow_trans; ?>" style="padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; border:<?php echo $border_width; ?>px solid <?php echo $btn_border; ?>; font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background-color: <?php echo $btn_bg; ?>; border-radius: <?php echo $btn_radius; ?>px">
					<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
				</a>
			<?php } ?>

			<!-- Speech Bubbles -->
			<?php if ($btn_style == 'animated' && $anim_style == 'speech_bubbles') { ?>
				<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="mega_hvr_btn <?php echo $bubble_trans; ?>" style="padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; border:<?php echo $border_width; ?>px solid <?php echo $btn_border; ?>; font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background-color: <?php echo $btn_bg; ?>; border-radius: <?php echo $btn_radius; ?>px">
					<span style="
						<?php echo ($bubble_trans == 'hvr-bubble-bottom' || $bubble_trans == 'hvr-bubble-float-top' || $bubble_trans == 'hvr-bubble-float-bottom') ? 'border-color: '.$btn_bg.' transparent transparent transparent;' : '' ; ?>
						<?php echo ($bubble_trans == 'hvr-bubble-float-right' || $bubble_trans == 'hvr-bubble-right') ? 'border-color: transparent transparent transparent '.$btn_bg.' ;' : '' ; ?>
						<?php echo ($bubble_trans == 'hvr-bubble-top' || $bubble_trans == 'hvr-bubble-float-top') ? 'border-color: transparent transparent '.$btn_bg.' transparent;' : '' ; ?>
						<?php echo ($bubble_trans == 'hvr-bubble-left' || $bubble_trans == 'hvr-bubble-float-left') ? 'border-color: transparent '.$btn_bg.' transparent transparent;' : '' ; ?>
					"></span><i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
				</a>
			<?php } ?>


			<!-- 3D button -->
			<?php if ($btn_style == '3D') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="push_button" style="font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; background: <?php echo $btn_bg; ?>; color: <?php echo $btn_clr; ?>; box-shadow: 0 0 0 1px <?php echo $btn_shadow; ?> inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 4px 0 0 <?php echo $btn_shadow; ?>, 0 8px 8px 1px rgba(0,0,0,0.5);">
					<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
				</a>
			<?php } ?>
		</div>

		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'CSS3 Button (OLD)', 'button' ),
	"base" 			=> "mvc_button",
	// "category" 		=> __('Mega Addons'),
	"description" 	=> __('Animated style buttons', 'button'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/hoverbutton.png',
	'params' => array(
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Style', 'button' ),
			"param_name" 	=> "btn_style",
			"description" 	=> __( 'Choose button style <a href="http://addons.topdigitaltrends.net/advanced-button-2/">See Demo</a>', 'button' ),
			"group" 		=> 'General',
			"value" 		=> array(
				'Animated Button' =>  'animated',
				'3D button' =>  '3D',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Animation Style', 'button' ),
			"param_name" 	=> "anim_style",
			"description" 	=> __( 'Choose animation style on hover', 'button' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "btn_style", 'value' => 'animated'),
			"value" 		=> array(
				'2D Transition' =>  'transition',
				'Background Transition' =>  'bg_transition',
				'Shadow and Glow' =>  'shadow',
				'Border Transition' =>  'brdr_transition',
				'Speech Bubbles' =>  'speech_bubbles',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( '2D Transition', 'button' ),
			"param_name" 	=> "anim_trans",
			"description" 	=> __( 'Choose animation style on hover', 'button' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "anim_style", 'value' => 'transition'),
			"value" 		=> array(
				'Grow' 			=>  'hvr-grow',
				'Shrink' 			=>  'hvr-shrink',
				'Pulse'		=>	'hvr-pulse',
				'Pulse Grow'	=>	'hvr-pulse-grow',
				'Pulse Shrink'	=>	'hvr-pulse-shrink',
				'Push'			=>	'hvr-push',
				'Pop'			=>	'hvr-pop',
				'Bounce In'		=>	'hvr-bounce-in',
				'Bounce Out'	=>	'hvr-bounce-out',
				'Rotate'		=>	'hvr-rotate',
				'Grow Rotate'	=>	'hvr-grow-rotate',
				'Float'			=>	'hvr-float',
				'Sink'			=>	'hvr-sink',
				'Bob'			=>	'hvr-bob',
				'Hang'			=>	'hvr-hang',
				'Skew'			=>	'hvr-skew',
				'Skew Forward'	=>	'hvr-skew-forward',
				'Skew Backward'	=>	'hvr-skew-backward',
				'Wobble Horizontal'	=>	'hvr-wobble-horizontal',
				'Wobble Vertical'	=>	'hvr-wobble-vertical',
				'Wobble To Bottom Right'	=>	'hvr-wobble-to-bottom-right',
				'Wobble To Top Right'	=>	'hvr-wobble-to-top-right',
				'Wobble Top'	=>	'hvr-wobble-top',
				'Wobble Bottom'	=>	'hvr-wobble-bottom',
				'Wobble Skew'	=>	'hvr-wobble-skew',
				'Buzz'			=>	'hvr-buzz',
				'Buzz Out'		=>	'hvr-buzz-out',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Background Transition', 'button' ),
			"param_name" 	=> "bg_trans",
			"description" 	=> __( 'Choose animation style on hover', 'button' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "anim_style", 'value' => 'bg_transition'),
			"value" 		=> array(
				'Fade' => 'hvr-fade',
				'Back Pulse' => 'hvr-back-pulse',
				'Sweep To Right' => 'hvr-sweep-to-right',
				'Sweep To Left' => 'hvr-sweep-to-left',
				'Sweep To Bottom' => 'hvr-sweep-to-bottom',
				'Sweep To Top' => 'hvr-sweep-to-top',
				'Bounce To Right' => 'hvr-bounce-to-right',
				'Bounce To Left' => 'hvr-bounce-to-left',
				'Bounce To Bottom' => 'hvr-bounce-to-bottom',
				'Bounce To Top' => 'hvr-bounce-to-top',
				'Radial Out' => 'hvr-radial-out',
				// 'Radial In' => 'hvr-radial-in',
				// 'Rectangle In' => 'hvr-rectangle-in',
				'Rectangle Out' => 'hvr-rectangle-out',
				// 'Shutter In Horizontal' => 'hvr-shutter-in-horizontal',
				'Shutter Out Horizontal' => 'hvr-shutter-out-horizontal',
				// 'Shutter In Vertical' => 'hvr-shutter-in-vertical',
				'Shutter Out Vertical' => 'hvr-shutter-out-vertical',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Transition', 'button' ),
			"param_name" 	=> "brdr_trans",
			"description" 	=> __( 'Choose animation style on hover', 'button' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "anim_style", 'value' => 'brdr_transition'),
			"value" 		=> array(
				'Underline From Left' => 'hvr-underline-from-left',
				'Underline From Center' => 'hvr-underline-from-center',
				'Underline From Right' => 'hvr-underline-from-right',
				'Underline Reveal' => 'hvr-underline-reveal',
				'Overline Reveal' => 'hvr-overline-reveal',
				'Overline From Left' => 'hvr-overline-from-left',
				'Overline From Center' => 'hvr-overline-from-center',
				'Overline From Right' => 'hvr-overline-from-right',
				'Reveal' => 'hvr-reveal',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Speech Bubbles', 'button' ),
			"param_name" 	=> "bubble_trans",
			"description" 	=> __( 'Choose animation style on hover', 'button' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "anim_style", 'value' => 'speech_bubbles'),
			"value" 		=> array(
				'Bubble Top' =>  'hvr-bubble-top',
				'Bubble Right' =>  'hvr-bubble-right',
				'Bubble Bottom' =>  'hvr-bubble-bottom',
				'Bubble Left' =>  'hvr-bubble-left',
				'Bubble Float Top' =>  'hvr-bubble-float-top',
				'Bubble Float Right' =>  'hvr-bubble-float-right',
				'Bubble Float Bottom' =>  'hvr-bubble-float-bottom',
				'Bubble Float Left' =>  'hvr-bubble-float-left',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Shadow and Glow', 'button' ),
			"param_name" 	=> "shadow_trans",
			"description" 	=> __( 'Choose animation style on hover', 'button' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "anim_style", 'value' => 'shadow'),
			"value" 		=> array(
				'Shadow'		=>	'hvr-shadow',
				'Grow Shadow'	=>		'hvr-grow-shadow',
				'Float Shadow'	=>		'hvr-float-shadow',
				'Glow'			=>		'hvr-glow',
				'Shadow Radial'	=>		'hvr-shadow-radial',
				'Box Shadow Outset'	=>		'hvr-box-shadow-outset',
				'Box Shadow Inset'	=>		'hvr-box-shadow-inset',
				'Sweep to Left'	=>		'hvr-sweep-to-left',
			)
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Button Align', 'button' ),
			"param_name" 	=> 	"align",
			"description" 	=> 	__( 'select text align', 'button' ),
			"group" 		=> 	'General',
				"value" 		=> array(
					"Left"		=> "left",
					"Center"		=> "center",
					"Right"		=> "right",
				)
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Padding [Top Bottom]', 'button' ),
			"param_name" 	=> "padding_top",
			"description" 	=> __( 'It will increase height of button e.g 10', 'button' ),
			"value"			=>	"5",
			"suffix" 		=> 'px',
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Padding [Left Right]', 'button' ),
			"param_name" 	=> "padding_left",
			"description" 	=> __( 'It will increase width of button e.g 20', 'button' ),
			"value"			=>	"10",
			"suffix" 		=> 'px',
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Radius', 'button' ),
			"param_name" 	=> "btn_radius",
			"description" 	=> __( 'set button radius e.g 5', 'button' ),
			"dependency" => array('element' => "btn_style", 'value' => 'animated'),
			"suffix" 		=> 'px',
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "iconpicker",
			"heading" 		=> __( 'Select icon', 'button' ),
			"param_name" 	=> "btn_icon",
			"description" 	=> __( 'it will be show within text', 'button' ),
			"group" 		=> 'Text',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button text', 'button' ),
			"param_name" 	=> "btn_text",
			"description" 	=> __( 'Write button text', 'button' ),
			"group" 		=> 'Text',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Text font size', 'button' ),
			"param_name" 	=> "btn_size",
			"description" 	=> __( 'Set font size in pixel e.g 18', 'button' ),
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 'Text',
		),
		array(
			"type" 			=> "vc_link",
			"heading" 		=> __( 'Button URL', 'button' ),
			"param_name" 	=> "btn_url",
			"description" 	=> __( 'Write button url as link', 'button' ),
			"group" 		=> 'Text',
		),

		/** border **/

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Border color', 'button' ),
			"param_name" 	=> "btn_border",
			"description" 	=> __( 'Set color of border e.g #269CE9', 'button' ),
			"dependency" => array('element' => "btn_style", 'value' => 'animated'),
			"group" 		=> 'Border',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border width', 'button' ),
			"param_name" 	=> "border_width",
			"description" 	=> __( 'Set width of border in pixel e.g 1', 'button' ),
			"dependency" => array('element' => "btn_style", 'value' => 'animated'),
			"value"			=>	"1",
			"suffix" 		=> 'px',
			"group" 		=> 'Border',
		),


		/** color **/

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Text color', 'button' ),
			"param_name" 	=> "btn_clr",
			"description" 	=> __( 'Set color of text e.g #ffff', 'button' ),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'button' ),
			"param_name" 	=> "btn_bg",
			"description" 	=> __( 'Set color of background e.g #269CE9', 'button' ),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background Shadow color', 'button' ),
			"param_name" 	=> "btn_shadow",
			"description" 	=> __( 'keep it same and much dark from background color', 'button' ),
			"dependency" => array('element' => "btn_style", 'value' => '3D'),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Text color', 'button' ),
			"param_name" 	=> "btn_hvrclr",
			"description" 	=> __( 'Set color of text on hover e.g #ffff', 'button' ),
			"dependency" => array('element' => "btn_style", 'value' => 'animated'),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'button' ),
			"param_name" 	=> "btn_hvrbg",
			"description" 	=> __( 'Set color of background on hover e.g #269CE9', 'button' ),
			"dependency" => array('element' => "btn_style", 'value' => 'animated'),
			"group" 		=> 'Color',
		),
	),
) );

