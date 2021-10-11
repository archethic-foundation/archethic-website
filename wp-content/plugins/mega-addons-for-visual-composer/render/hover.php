<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_ihe extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'image_id' => '',
			'alt' => '',
			'height' => '',
			'width' => '',
			'popup' => 'disable',
			'caption_bg' => '#FFF',
			'caption_url' => '',
			'caption_url_target' => '',
			'border_width' => '10',
			'border_style' => 'solid',
			'border_color' => '#fff',
			'hover_effect' => 'ihe-fade square effect6 from_top_and_bottom',
		), $atts ) );
		$caption_url = vc_build_link($caption_url);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		// wp_enqueue_style( 'pretty-photo-css', plugins_url( '../css/ihover.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content);
		ob_start(); ?>
			<div class="ih-item <?php echo $hover_effect; ?>"
				style="border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_color; ?>; height: <?php echo $height; ?>px; width: <?php echo $width; ?>px;">
				<?php if (isset($caption_url['url']) && $caption_url['url'] != '') { ?>
					<a href="<?php echo esc_url($caption_url['url']); ?>" target="<?php echo $caption_url['target']; ?>" title="<?php echo esc_html($caption_url['title']); ?>" rel="<?php echo $popup ?><?php if ($popup == 'pretty') { echo "Photo[pp_gal]"; } ?>">
				<?php } ?>
				<?php if (isset($caption_url['url']) && $caption_url['url'] == NULL) { ?>
					<a>
				<?php } ?>
			      <div class="img">
			      <span style="box-shadow: inset 0 0 0 <?php echo $border_width; ?>px <?php echo $border_color; ?>, 0 1px 2px rgba(0, 0, 0, .3); opacity: 0.6;"></span>
			      	<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>px; max-width: 100%;">
			      </div>
			      <div class="info" style="background-color: <?php echo $caption_bg; ?>;">
				    <div style="display:table;width:100%;height:100%;">
			    		<div style="display: table-cell !important;vertical-align: middle !important;">
			      			<?php echo $content; ?>
			      		</div>
			      	</div>
			      </div>
			    </a>
			</div>
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Image Hover Effects', 'ihover' ),
	"base" 			=> "mvc_ihe",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Image Hover Effects', 'ihover'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/ihe.png',
	'params' => array(
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Image', 'ihover' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'ihover' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Image Alt', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"description" 	=> 	__( 'It will use as image alt attribute', 'info-banner-vc' ),
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
			"heading" 		=> __( 'Link To', 'ihover' ),
			"param_name" 	=> "caption_url",
			"description" 	=> __( 'Enter URL to link caption', 'ihover' ),
			"group" 		=> 'Image',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Lightbox (<a href="https://addons.topdigitaltrends.net/image-hover-effects-popup-demo/">Pro Version Demo</a>)', 'ihover' ),
			"param_name" 	=> "popup",
			"description" 	=> __( 'popup on click. paste image or video url in "Link To" field for opening popup on click', 'ihover' ),
			"group" 		=> 'Image',
			"value" 		=> array(
				'Disable'				=>	'disable',
				'LightBox'				=>	'image',
				'LightBox SlideShow'	=>	'images',
			)
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Image',
		),


		/* Caption */


		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Caption Background Color', 'ihover' ),
			"param_name" 	=> "caption_bg",
			"description" 	=> __( 'Background color for caption', 'ihover' ),
			"group" 		=> 'Caption',
		),
		array(
			"type" 			=> "textarea_html",
			"heading" 		=> __( 'Caption Text', 'ihover' ),
			"param_name" 	=> "content",
			"description" 	=> __( 'Provide Caption Here', 'ihover' ),
			"group" 		=> 'Caption',
			"value"			=> '<h2>Caption Text Here</h2>'
		),

		/* Border */

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border Width', 'ihover' ),
			"param_name" 	=> "border_width",
			"description" 	=> __( 'Width of border, eg: 15. Leaving blank will disable border', 'ihover' ),
			"value"			=>	"10",
			"suffix" 		=> 'px',
			"group" 		=> 'Border',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Style', 'ich-vc' ),
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
			"heading" 		=> __( 'Border Color', 'ihover' ),
			"param_name" 	=> "border_color",
			"description" 	=> __( 'Select the color for border', 'ihover' ),
			"group" 		=> 'Border',
		),

			/* Hover Effects */

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Hover Effect', 'ihover' ),
			"param_name" 	=> "hover_effect",
			"description" 	=> __( 'Choose hover effect <a href="http://gudh.github.io/ihover/dist/">See demo</a>', 'ihover' ),
			"group" 		=> 'Hover Effects',
			"value" 		=>  array(
				'Fade Effect'						=>		'ihe-fade square effect6 from_top_and_bottom',
				'circle effect2 left to right'      =>      'circle effect2 left_to_right',
				'circle effect2 right to left'      =>      'circle effect2 right_to_left',
				'circle effect2 top to bottom'      =>      'circle effect2 top_to_bottom',
				'circle effect2 bottom to top'      =>      'circle effect2 bottom_to_top',
				'circle effect3 left to right'      =>      'circle effect3 left_to_right',
				'circle effect3 right to left'      =>      'circle effect3 right_to_left',
				'circle effect3 bottom to top'      =>      'circle effect3 bottom_to_top',
				'circle effect3 top to bottom'      =>      'circle effect3 top_to_bottom',
				'circle effect4 left to right'      =>      'circle effect4 left_to_right',
				'circle effect4 right to left'      =>      'circle effect4 right_to_left',
				'circle effect4 top to bottom'      =>      'circle effect4 top_to_bottom',
				'circle effect4 bottom to top'      =>      'circle effect4 bottom_to_top',
				'circle effect5'      				=>      'circle effect5',
				'circle effect6 scale up'      		=>      'circle effect6 scale_up',
				'circle effect6 scale down'      	=>      'circle effect6 scale_down',
				'circle effect6 scale down up'      =>      'circle effect6 scale_down_up',
				'circle effect7 left to right'      =>      'circle effect7 left_to_right',
				'circle effect7 right to left'      =>      'circle effect7 right_to_left',
				'circle effect7 top to bottom'      =>      'circle effect7 top_to_bottom',
				'circle effect7 bottom to top'      =>      'circle effect7 bottom_to_top',
				'circle effect8 left to right'      =>      'circle effect8 left_to_right',
				'circle effect8 right to left'      =>      'circle effect8 right_to_left',
				'circle effect8 top to bottom'      =>      'circle effect8 top_to_bottom',
				'circle effect8 bottom to top'      =>      'circle effect8 bottom_to_top',
				'circle effect9 left to right'      =>      'circle effect9 left_to_right',
				'circle effect9 right to left'      =>      'circle effect9 right_to_left',
				'circle effect9 top to bottom'      =>      'circle effect9 top_to_bottom',
				'circle effect9 bottom to top'      =>      'circle effect9 bottom_to_top',
				'circle effect10 top to bottom'      =>      'circle effect10 top_to_bottom',
				'circle effect10 bottom to top'      =>      'circle effect10 bottom_to_top',
				'circle effect11 left to right'      =>      'circle effect11 left_to_right',
				'circle effect11 right to left'      =>      'circle effect11 right_to_left',
				'circle effect11 top to bottom'      =>      'circle effect11 top_to_bottom',
				'circle effect11 bottom to top'      =>      'circle effect11 bottom_to_top',
				'circle effect12 left to right'      =>      'circle effect12 left_to_right',
				'circle effect12 right to left'      =>      'circle effect12 right_to_left',
				'circle effect12 top to bottom'      =>      'circle effect12 top_to_bottom',
				'circle effect12 bottom to top'      =>      'circle effect12 bottom_to_top',
				'circle effect13 from left and right'    =>      'circle effect13 from_left_and_right',
				'circle effect13 top to bottom'      =>      'circle effect13 top_to_bottom',
				'circle effect13 bottom to top'      =>      'circle effect13 bottom_to_top',
				'circle effect14 left to right'      =>      'circle effect14 left_to_right',
				'circle effect14 right to left'      =>      'circle effect14 right_to_left',
				'circle effect14 top to bottom'      =>      'circle effect14 top_to_bottom',
				'circle effect14 bottom to top'      =>      'circle effect14 bottom_to_top',
				'circle effect15 left to right'      =>      'circle effect15 left_to_right',
				'circle effect16 left to right'      =>      'circle effect16 left_to_right',
				'circle effect16 right to left'      =>      'circle effect16 right_to_left',
				'circle effect17'      =>      'circle effect17',
				'circle effect18 bottom to top'      =>      'circle effect18 bottom_to_top',
				'circle effect18 left to right'      =>      'circle effect18 left_to_right',
				'circle effect18 right to left'      =>      'circle effect18 right_to_left',
				'circle effect18 top to bottom'      =>      'circle effect18 top_to_bottom',
				'circle effect19'      =>      'circle effect19',
				'circle effect20 top to bottom'      =>      'circle effect20 top_to_bottom',
				'circle effect20 bottom to top'      =>      'circle effect20 bottom_to_top',
				'square effect1 left and right'      =>      'square effect1 left_and_right',
				'square effect1 top to bottom'      =>      'square effect1 top_to_bottom',
				'square effect1 bottom to top'      =>      'square effect1 bottom_to_top',
				'square effect2'      =>      'square effect2',
				'square effect3 bottom to top'      =>      'square effect3 bottom_to_top',
				'square effect3 top to bottom'      =>      'square effect3 top_to_bottom',
				'square effect4'      =>      'square effect4',
				'square effect5 left to right'      =>      'square effect5 left_to_right',
				'square effect5 right to left'      =>      'square effect5 right_to_left',
				'square effect6 from top and bottom'      =>      'square effect6 from_top_and_bottom',
				'square effect6 from left and right'      =>      'square effect6 from_left_and_right',
				'square effect6 top to bottom'      =>      'square effect6 top_to_bottom',
				'square effect6 bottom to top'      =>      'square effect6 bottom_to_top',
				'square effect7'      =>      'square effect7',
				'square effect8 scaleup'      =>      'square effect8 scale_up',
				'square effect8 scaledown'      =>      'square effect8 scale_down',
				'square effect9 bottom to top'      =>      'square effect9 bottom_to_top',
				'square effect9 left to right'      =>      'square effect9 left_to_right',
				'square effect9 right to left'      =>      'square effect9 right_to_left',
				'square effect9 top to bottom'      =>      'square effect9 top_to_bottom',
				'square effect10 left to right'      =>      'square effect10 left_to_right',
				'square effect10 right to left'      =>      'square effect10 right_to_left',
				'square effect10 top to bottom'      =>      'square effect10 top_to_bottom',
				'square effect10 bottom to top'      =>      'square effect10 bottom_to_top',
				'square effect11 left to right'      =>      'square effect11 left_to_right',
				'square effect11 right to left'      =>      'square effect11 right_to_left',
				'square effect11 top to bottom'      =>      'square effect11 top_to_bottom',
				'square effect11 bottom to top'      =>      'square effect11 bottom_to_top',
				'square effect12 left to right'      =>      'square effect12 left_to_right',
				'square effect12 right to left'      =>      'square effect12 right_to_left',
				'square effect12 top to bottom'      =>      'square effect12 top_to_bottom',
				'square effect12 bottom to top'      =>      'square effect12 bottom_to_top',
				'square effect13 left to right'      =>      'square effect13 left_to_right',
				'square effect13 right to left'      =>      'square effect13 right_to_left',
				'square effect13 top to bottom'      =>      'square effect13 top_to_bottom',
				'square effect13 bottom to top'      =>      'square effect13 bottom_to_top',
				'square effect14 left to right'      =>      'square effect14 left_to_right',
				'square effect14 right to left'      =>      'square effect14 right_to_left',
				'square effect14 top to bottom'      =>      'square effect14 top_to_bottom',
				'square effect14 bottom to top'      =>      'square effect14 bottom_to_top',
				'square effect15 left to right'      =>      'square effect15 left_to_right',
				'square effect15 right to left'      =>      'square effect15 right_to_left',
				'square effect15 top to bottom'      =>      'square effect15 top_to_bottom',
				'square effect15 bottom to top'      =>      'square effect15 bottom_to_top',
			)
		),
	),
) );