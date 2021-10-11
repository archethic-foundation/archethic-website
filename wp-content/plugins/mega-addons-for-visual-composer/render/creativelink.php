<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_vc_creativelink extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'			=>		'cl-effect-1',
			'size'			=>		'18',
			'text_mblsize'	=>		'',
			'align'			=>		'left',
			'text'			=>		'',
			'url'			=>		'',
			'clr'			=>		'',
			'classname'		=>		'',
			'bgclr'			=>		'',
			'hoverclr'		=>		'',
			'hoverbg'		=>		'',
			'transform'		=>		'default',
			'google_fonts'	=>		'default',
		), $atts ) );
		$some_id = rand(5, 500);
		$url = vc_build_link($url);
		wp_enqueue_style( 'creative-css', plugins_url( '../css/creativelink.css' , __FILE__ ));
		wp_enqueue_script( 'creative-js', plugins_url( '../js/creativelink.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		<div class="<?php echo $style; ?> creative_link_wrapper creative_link_<?php echo $some_id; ?> <?php echo $classname; ?>" style="text-align: <?php echo $align; ?>;">
			<?php if ($style == 'cl-effect-1' || $style == 'cl-effect-13') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<?php echo $text; ?>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-2') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" data-hover="<?php echo $text; ?>" style="background: <?php echo $bgclr; ?>;">
						<span class="creativelink-" style="background: <?php echo $hoverbg; ?>;"><?php echo $text; ?></span>
						<?php echo $text; ?>
					</span>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-5') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink">
						<span class="creativelink-"><?php echo $text; ?></span>
						<?php echo $text; ?>
					</span>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-3' || $style == 'cl-effect-4') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<?php echo $text; ?>
					<span class="creativelink" style="background: <?php echo $hoverbg; ?>;"></span>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-6' || $style == 'cl-effect-7' || $style == 'cl-effect-14' || $style == 'cl-effect-18' || $style == 'cl-effect-21') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" data-hover="Umbrella" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" style="background: <?php echo $bgclr; ?>;"></span>
						<?php echo $text; ?>
					<span class="creativelink-" style="background: <?php echo $bgclr; ?>;"></span>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-8') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" style="border: 3px solid <?php echo $bgclr; ?>;"></span>
						<?php echo $text; ?>
					<span class="creativelink-" style="border-color: <?php echo $hoverbg; ?>;"></span>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-10') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" data-hover="<?php echo $text; ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" style="background: <?php echo $hoverbg; ?>;color: <?php echo $hoverclr; ?>;"><?php echo $text; ?></span>
					<span class="creativelink-" style="background: <?php echo $bgclr; ?>;"><?php echo $text; ?></span>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-11') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" data-hover="<?php echo $text; ?>" style="color: <?php echo $clr; ?>; border-top: 2px solid transparent; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" style="border-bottom: 2px solid <?php echo $hoverclr; ?>;color: <?php echo $hoverclr; ?>;"><?php echo $text; ?></span>
					<?php echo $text; ?>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-15') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" data-hover="<?php echo $text; ?>" style="color: <?php echo $hoverclr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" style="color: <?php echo $clr; ?>;"><?php echo $text; ?></span>
					<?php echo $text; ?>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-16') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" data-hover="<?php echo $text; ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span class="creativelink" style="color: <?php echo $hoverclr; ?>;"><?php echo $text; ?></span>
					<?php echo $text; ?>
				</a>
			<?php } ?>

			<?php if ($style == 'cl-effect-19' || $style == 'cl-effect-20') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px; text-transform: <?php echo $transform ?>;">
					<span data-hover="<?php echo $text; ?>" class="creativelink" style="background: <?php echo $bgclr; ?>;">
					<span class="creativelink-" style="background: <?php echo $hoverbg; ?>;color: <?php echo $hoverclr; ?>;"><?php echo $text; ?></span>
						<?php echo $text; ?>
					</span>
				</a>
			<?php } ?>
		</div>

		<style>
			.creative_link_<?php echo $some_id; ?>.cl-effect-13 a:hover::before, .creative_link_<?php echo $some_id; ?>.cl-effect-13 a:focus::before {
				color: <?php echo $clr; ?> !important;
		    	text-shadow: 10px 0 <?php echo $clr; ?>, -10px 0 <?php echo $clr; ?> !important;
			}	
			@media only screen and (max-width: 480px) {
				.creative_link_<?php echo $some_id; ?> a {
					font-size: <?php echo $text_mblsize; ?>px !important;
				}
			}
		</style>
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Creative Links', 'creativelink' ),
	"base" 			=> "vc_creativelink",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Creative links button', 'creativelink'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/creativelink.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Effect Style', 'creativelink' ),
			"param_name" 	=> 	"style",
			"description" 	=> 	__( 'Select effect style <a href="https://addons.topdigitaltrends.net/creative-link/" target="_blank">See Demo</a>', 'creativelink' ),
			"group" 		=> 	'General',
				"value" 		=> array(
					"Effect 1"		=> "cl-effect-1",
					"Effect 2"		=> "cl-effect-2",
					"Effect 3"		=> "cl-effect-3",
					"Effect 4"		=> "cl-effect-4",
					"Effect 5"		=> "cl-effect-5",
					"Effect 6"		=> "cl-effect-6",
					"Effect 7"		=> "cl-effect-7",
					"Effect 8"		=> "cl-effect-8",
					"Effect 10"		=> "cl-effect-10",
					"Effect 11"		=> "cl-effect-11",
					"Effect 13"		=> "cl-effect-13",
					"Effect 14"		=> "cl-effect-14",
					"Effect 15"		=> "cl-effect-15",
					"Effect 16"		=> "cl-effect-16",
					"Effect 18"		=> "cl-effect-18",
					"Effect 19"		=> "cl-effect-19",
					"Effect 20"		=> "cl-effect-20",
					"Effect 21"		=> "cl-effect-21",
				)
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Button Align', 'creativelink' ),
			"param_name" 	=> 	"align",
			"description" 	=> 	__( 'select text align', 'creativelink' ),
			"group" 		=> 	'General',
				"value" 		=> array(
					"Left"		=> "left",
					"Center"		=> "center",
					"Right"		=> "right",
				)
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Text', 'creativelink' ),
			"param_name" 	=> 	"text",
			"description" 	=> 	__( 'write button text', 'creativelink' ),
			"group" 		=> 	'General',
		),

		array(
			"type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Button URL', 'creativelink' ),
			"param_name" 	=> 	"url",
			"description" 	=> 	__( 'write url as link', 'creativelink' ),
			"group" 		=> 	'General',
		),

		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Extra class name', 'megaaddons' ),
			"param_name" 	=> 	"classname",
			"description" 	=> 	"Style particular content element differently - add a class name and refer to it in custom CSS.",
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
			"heading" 		=> 	__( 'Text Color', 'creativelink' ),
			"param_name" 	=> 	"clr",
			"description" 	=> 	__( 'select button color', 'creativelink' ),
			"group" 		=> 	'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'creativelink' ),
			"param_name" 	=> 	"bgclr",
			"description" 	=> 	__( 'select button background color', 'creativelink' ),
			"group" 		=> 	'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Hover Text Color', 'creativelink' ),
			"param_name" 	=> 	"hoverclr",
			"description" 	=> 	__( 'select button color on hover', 'creativelink' ),
			"group" 		=> 	'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Hover Background Color', 'creativelink' ),
			"param_name" 	=> 	"hoverbg",
			"description" 	=> 	__( 'select button background color on hover', 'creativelink' ),
			"group" 		=> 	'Color',
		),

		// ================ Typography ====================== //

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Text Size [PC]', 'creativelink' ),
			"param_name" 	=> 	"size",
			"edit_field_class" => "vc_col-sm-6",
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 	'Typography',
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Text Size [Mobile]', 'creativelink' ),
			"param_name" 	=> 	"text_mblsize",
			"edit_field_class" => "vc_col-sm-6",
			"suffix" 		=> 'px',
			"group" 		=> 	'Typography',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Transform', 'button' ),
			"param_name" 	=> "transform",
			"group" 		=> 'Typography',
			"value"			=>	array(
				"Default"		=>		"default",
				"Uppercase"		=>		"uppercase",
				"Lowercase"		=>		"lowercase",
				"Capitalize"	=>		"capitalize",
				"Normal"		=>		"normal",
			)
		),
	),
) );

