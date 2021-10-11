<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_image_swap extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'image_id' 				=> '',
			'alt' 					=> '',
			'width' 				=> '',
			'img_width' 			=> '',
			'height'				=> '',
			'img_height'			=> '',
			'image_id2' 			=> '',
			'alt2' 					=> '',
			'caption_url' 			=> '',
			'caption_url_target' 	=> '',
			'border_width' 			=> '10',
			'border_style' 			=> 'solid',
			'border_color' 			=> '#fff',
			'front_anim_speed' 		=> '',
			'hover_effect' 			=> 'maw_img_swap_fade',
			'img_align' 			=> 'left',
		), $atts ) );
		$img_swap_rand_id = rand(5, 500);
		$caption_url = vc_build_link($caption_url);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		if ($image_id2 != '') {
			$image_url2 = wp_get_attachment_url( $image_id2 );		
		}
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
		
		<div style="text-align: <?php echo $img_align ?>;">
			<div style="display: inline-block;">
				<div class="maw_image_swap maw_image_swap_<?php echo $img_swap_rand_id; ?> ih-item <?php echo $hover_effect; ?>"
					style="border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_color; ?>; height: <?php echo $height; ?>px; max-width: <?php echo $width; ?>px; box-shadow: none;">
					<?php if (isset($caption_url['url']) && $caption_url['url'] != '') { ?>
						<a href="<?php echo esc_url($caption_url['url']); ?>" target="<?php echo $caption_url['target']; ?>" title="<?php echo esc_html($caption_url['title']); ?>">
					<?php }
					if (isset($caption_url['url']) && $caption_url['url'] == NULL) { ?>
						<a>
					<?php } ?>
				      <div class="img">
				      	<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>px; max-width: 100%;">
				      </div>
				      <?php if ($hover_effect != 'maw_img_swap_fade') { ?>
					      <div class="info" style="opacity: 1 !important;">
					      	<img src="<?php echo $image_url2; ?>" alt="<?php echo $alt2; ?>" style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>px; max-width: 100%;">
					      </div>
					   <?php } ?>
					   <?php if ($hover_effect == 'maw_img_swap_fade') { ?>
					      <div class="info">
					      	<img src="<?php echo $image_url2; ?>" alt="<?php echo $alt2; ?>" style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>px; max-width: 100%;">
					      </div>
					   <?php } ?>
				    </a>
				</div>
			</div>
		</div>
			
		<style>
			<?php if ($hover_effect != 'square effect2' && $hover_effect != 'maw_img_swap_fade') { ?>
				.maw_image_swap_<?php echo $img_swap_rand_id; ?>.square .info,
				.maw_image_swap_<?php echo $img_swap_rand_id; ?>.square .img {
					-webkit-transition: all <?php echo $front_anim_speed; ?>ms ease-in-out !important;
				    -moz-transition: all <?php echo $front_anim_speed; ?>ms ease-in-out !important;
				    transition: all <?php echo $front_anim_speed; ?>ms ease-in-out !important;
				}
			<?php } ?>
			<?php if ($hover_effect == 'maw_img_swap_fade' && $front_anim_speed != '') { ?>
				.maw_img_swap_fade .info {
					transition: <?php echo $front_anim_speed; ?>ms ease !important;
				}
			<?php } ?>
			<?php if ($img_width != '' || $img_height != '') { ?>
				@media only screen and (max-width: 767px) {
					.maw_image_swap_<?php echo $img_swap_rand_id; ?>.ih-item {
				        max-width: <?php echo $img_width; ?>px !important;
				        height: auto !important;
				        height: <?php echo $img_height; ?>px !important;
				    }
				    .maw_image_swap_<?php echo $img_swap_rand_id; ?>.ih-item img{
				        width: <?php echo $img_width; ?>px !important;
				        height: auto !important;
				        height: <?php echo $img_height; ?>px !important;
				    }
				}
			<?php } ?>
		</style>
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Image Swap', 'swap' ),
	"base" 			=> "image_swap",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Image over image hover effects', 'swap'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/img-swap.png',
	'params' => array(
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Front Image', 'swap' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'swap' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Flip Image', 'swap' ),
			"param_name" 	=> 	"image_id2",
			"description" 	=> 	__( 'It will show on hover', 'swap' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt2",
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),

        array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Image Width', 'ich-vc' ),
			"param_name" 	=> "width",
			"description" 	=> __( 'set in pixel e.g 250 or leave blank for default', 'ich-vc' ),
			"max"			=>	"",
			"suffix" 		=> 'px',
			"group" 		=> 'Image',
		),

	    array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Image Height', 'ich-vc' ),
			"param_name" 	=> "height",
			"description" 	=> __( 'set in pixel e.g 250 or leave blank for default', 'ich-vc' ),
			"max"			=>	"",
			"suffix" 		=> 'px',
			"group" 		=> 'Image',
		),

		array(
			"type" 			=> "vc_link",
			"heading" 		=> __( 'Link To', 'swap' ),
			"param_name" 	=> "caption_url",
			"description" 	=> __( 'Enter URL to link caption', 'swap' ),
			"group" 		=> 'Image',
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Image',
		),


		/* Border */

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border Width', 'swap' ),
			"param_name" 	=> "border_width",
			"description" 	=> __( 'Width of border, eg: 15. Leaving blank will disable border', 'swap' ),
			"group" 		=> 'Border',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Style', 'swap' ),
			"param_name" 	=> "border_style",
			"group" 		=> 'Border',
			"value"			=>	array(
				"Solid"		=>		"solid",
				"Dotted"	=>		"dotted",
				"Ridge"		=>		"ridge",
				"Dashed"	=>		"dashed",
				"Double"	=>		"double",
				"Groove"	=>		"groove",
				"Inset"		=>		"inset",
			)
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Border Color', 'swap' ),
			"param_name" 	=> "border_color",
			"description" 	=> __( 'Select the color for border', 'swap' ),
			"group" 		=> 'Border',
		),

		/* Hover Effects */

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Alignment', 'swap' ),
			"param_name" 	=> "img_align",
			"group" 		=> 'Settings',
			"value" 		=> array(
				'Left'      	=>      'left',
				'Center'      	=>      'center',
				'Right'      	=>      'right',
			)
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Animation Speed', 'ich-vc' ),
			"param_name" 	=> "front_anim_speed",
			"description" 	=> __( 'write value in ms, 1s = 1000ms', 'ich-vc' ),
			"min"			=>	"0",
			"max"			=>	"3000",
			"suffix" 		=> 'ms',
			"value" 		=> '300',
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Hover Effect', 'swap' ),
			"param_name" 	=> "hover_effect",
			"description" 	=> __( 'Choose hover effect <a href="https://addons.topdigitaltrends.net/image-swap/" target="_blank">See Demo</a>', 'swap' ),
			"group" 		=> 'Settings',
			"value" 		=> array(
				'Fade'      				=>      'maw_img_swap_fade',
				// 'Effect1 top to bottom'      =>      'square effect1 top_to_bottom',
				// 'Effect1 bottm to top'      =>      'square effect1 bottom_to_top',
				// 'Effect1 left and right'      =>      'square effect1 left_and_right',
				'Effect2'      				=>      'square effect2',
				'Effect5 left to right'      =>      'square effect5 left_to_right',
				'Effect5 right to left'      =>      'square effect5 right_to_left',
				'Effect7 fade simple'      		=>      'square effect7',
				'Effect8 scaleup'      		=>      'square effect8 scale_up',
				'Effect8 scaledown'      	=>      'square effect8 scale_down',
				'Effect9 bottom to top'      =>      'square effect9 bottom_to_top',
				'Effect9 left to right'      =>      'square effect9 left_to_right',
				'Effect9 right to left'      =>      'square effect9 right_to_left',
				'Effect9 top to bottom'      =>      'square effect9 top_to_bottom',
				'Effect10 left to right'      =>      'square effect10 left_to_right',
				'Effect10 right to left'      =>      'square effect10 right_to_left',
				'Effect10 top to bottom'      =>      'square effect10 top_to_bottom',
				'Effect10 bottom to top'      =>      'square effect10 bottom_to_top',
				'Effect11 left to right'      =>      'square effect11 left_to_right',
				'Effect11 right to left'      =>      'square effect11 right_to_left',
				'Effect11 top to bottom'      =>      'square effect11 top_to_bottom',
				'Effect11 bottom to top'      =>      'square effect11 bottom_to_top',
				'Effect12 left to right'      =>      'square effect12 left_to_right',
				'Effect12 right to left'      =>      'square effect12 right_to_left',
				'Effect12 top to bottom'      =>      'square effect12 top_to_bottom',
				'Effect12 bottom to top'      =>      'square effect12 bottom_to_top',
				'Effect13 left to right'      =>      'square effect13 left_to_right',
				'Effect13 right to left'      =>      'square effect13 right_to_left',
				'Effect13 top to bottom'      =>      'square effect13 top_to_bottom',
				'Effect13 bottom to top'      =>      'square effect13 bottom_to_top',
				'Effect14 left to right'      =>      'square effect14 left_to_right',
				'Effect14 right to left'      =>      'square effect14 right_to_left',
				'Effect14 top to bottom'      =>      'square effect14 top_to_bottom',
				'Effect14 bottom to top'      =>      'square effect14 bottom_to_top',
				'Effect15 left to right'      =>      'square effect15 left_to_right',
				'Effect15 right to left'      =>      'square effect15 right_to_left',
				'Effect15 top to bottom'      =>      'square effect15 top_to_bottom',
				'Effect15 bottom to top'      =>      'square effect15 bottom_to_top',
			)
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urls",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Image Size For Mobile</span>', 'megaaddons' ),
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Image Width', 'ich-vc' ),
			"param_name" 	=> "img_width",
			"max"			=>	"",
			"suffix" 		=> 'px',
			"group" 		=> 'Settings',
		),

	    array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Image Height', 'ich-vc' ),
			"param_name" 	=> "img_height",
			"max"			=>	"",
			"suffix" 		=> 'px',
			"group" 		=> 'Settings',
		),
	),
) );

