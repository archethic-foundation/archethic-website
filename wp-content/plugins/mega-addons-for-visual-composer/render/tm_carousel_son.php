<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_tm_carousel_son extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'content_padding'	=>		'0',
			'contain_url'		=>		'',
			'image_id'			=>		'',
			'alt'				=>		'',
			'img_width'			=>		'',
			'img_height'		=>		'',
			'img_radius'		=>		'0',
			'title'				=>		'',
			'titlesize'			=>		'22',
			'titleclr'			=>		'',
			'fontweight'		=>		'normal',
			'line_height'		=>		'1',
			'align'				=>		'center',
			'line_width'		=>		'50',
			'line_style'		=>		'0px solid #fff',
			'btn_visibility'	=>		'hide',
			'line_visibility'	=> 		'hide',
			'btn_text'			=>		'',
			'btn_size'			=>		'15',
			'btn_border'		=>		'5',
			'btn_height'		=>		'20',
			'btn_width'			=>		'60',
			'btn_url'			=>		'',
			'btn_clr'			=>		'#fff',
			'btn_bg'			=>		'#000',
			'btn_border_style'	=>		'0px solid #fff',
		), $atts ) );
		$contain_url = vc_build_link($contain_url);
		$btn_url = vc_build_link($btn_url);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$content = wpb_js_remove_wpautop($content);
		// wp_enqueue_style( 'social-icons-css', plugins_url( '../css/socialicons.css' , __FILE__ ));
		ob_start(); ?>
		<div class="carousel-caption" style="background: none;">
		  <div>
		  	<?php if (isset($contain_url['url']) && $contain_url['url'] != '') { ?>
		  		<a href="<?php echo esc_url($contain_url['url']); ?>" target="<?php echo $contain_url['target']; ?>" title="<?php echo esc_html($contain_url['title']); ?>">		
			<?php } ?>
			<?php if (isset($contain_url['url']) && $contain_url['url'] == NULL) { ?>
				<a>
			<?php } ?>
			<?php if (!empty($image_url)) { ?>
			  	<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" class="ultimate-slide-img" style="max-width: 100%; width: <?php echo $img_width; ?>; height: <?php echo $img_height; ?>; border-radius: <?php echo $img_radius; ?>; margin-bottom: 15px;">
			<?php } ?>	
				</a>
		  	<span class="content-section" style="text-align: <?php echo $align ?>; display: block; top: <?php echo $content_padding ?>%;">
			  	<h2 class="tdt-slider-heading" style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; font-weight: <?php echo $fontweight; ?>; line-height: <?php echo $line_height; ?>;">
			  		<?php echo $title; ?>
			  	</h2>
			  	<?php if ($line_visibility == 'show') { ?>
				  	<span class="heading-line" style="display: block;">
				  		<span class="heading-line" style="width: <?php echo $line_width; ?>px; border-bottom: <?php echo $line_style; ?>; display: inline-block;"></span>
				  	</span>
			  	<?php } ?>
			  	
			  	<?php echo $content; ?><br>

			  	<?php if ($btn_visibility == 'show') { ?>
			  	<span class="carousel_btn_span">
			  		<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="ultimate_carousel_btn" style="padding: <?php echo $btn_height/2 ?>px <?php echo $btn_width/2 ?>px;font-size: <?php echo $btn_size; ?>px; border-radius: <?php echo $btn_border; ?>px; color: <?php echo $btn_clr; ?>; background-color: <?php echo $btn_bg; ?>;text-decoration: none;">
				  		<?php echo $btn_text; ?>
				  	</a>
				</span>
			  	<?php } ?>
			  	<p>&nbsp;</p>
		  	</span>
		  </div>
		</div>
		<?php

		return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "tm_carousel_son",
	"name" 			=> __( 'Slider Settings', 'tm-carousel' ),
	"as_child" 		=> array('only' => 'tm_carousel_father'),
	"content_element" => true,
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('show as slider', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/carousal-slider.png',
	'params' => array(
		array(
			"type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Link To', 'slider' ),
			"param_name" 	=> 	"contain_url",
			"description"	=>	"Add Slide Url or leave blank, use it if you select theme [top image bottom content]",
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'slider' ),
			"param_name" 	=> 	"image_id",
			"group" 		=> 'General',
		),
		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'slider' ),
			"group" 		=> 	'General',
        ),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Width', 'slider' ),
			"param_name" 	=> 	"img_width",
			"description"	=>	__( 'set in pixel or percentage or leave blank', 'slider' ),
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Height', 'slider' ),
			"param_name" 	=> 	"img_height",
			"description"	=>	__( 'set in pixel eg 100% or 500px or leave blank', 'slider' ),
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Image Radius', 'slider' ),
			"param_name" 	=> 	"img_radius",
			"description"	=>	__( 'border radius. set in pixel or percentage or leave blank', 'slider' ),
			"value"			=>	"0px",
			"group" 		=> 'General',
		),


		// Title Section
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Alignment', 'slider' ),
			"param_name" 	=> 	"align",
			"group" 		=> 'Heading',
			"value"			=>	array(
				"Center"		=>		'center',
				"Left"			=>		'left',
				"Right"			=>		'right',
			)
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title', 'slider' ),
			"param_name" 	=> 	"title",
			'admin_label' 	=> 	true,
			"group" 		=> 'Heading',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Title Font Size', 'slider' ),
			"param_name" 	=> 	"titlesize",
			"description"	=>	"set in pixel eg, 22",
			"value"			=>	"22",
			"suffix" 		=> 	'px',
			"group" 		=> 'Heading',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'slider' ),
			"param_name" 	=> 	"titleclr",
			"group" 		=> 'Heading',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Font Weight', 'slider' ),
			"param_name" 	=> 	"fontweight",
			"description"	=>	"lighter, normal, bold, 100, 300, 500..",
			"value"			=>	"normal",
			"group" 		=> 'Heading',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Line Height', 'slider' ),
			"param_name" 	=> 	"line_height",
			"description"	=>	"default value is 1",
			"value"			=>	"1",
			"group" 		=> 'Heading',
		),

		// Heading Line
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Enable/Disable', 'slider' ),
			"param_name" 	=> 	"line_visibility",
			"group" 		=> 'Heading Line',
			"value"			=>	array(
				"Hide"			=>		'hide',
				"Show"			=>		'show',
			)
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Line Width', 'slider' ),
			"param_name" 	=> 	"line_width",
			"description"	=>	"set in pixel. line will show at bottom of heading",
			"dependency" => array('element' => "line_visibility", 'value' => 'show'),
			"value"			=>	"50",
			"suffix" 		=> 	'px',
			"group" 		=> 'Heading Line',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Line Style', 'slider' ),
			"param_name" 	=> 	"line_style",
			"value"			=>	"0px solid #fff",
			"description"	=>	"[height style color]",
			"dependency" => array('element' => "line_visibility", 'value' => 'show'),
			"group" 		=> 'Heading Line',
		),

		// Button Setting
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Enable/Disable', 'slider' ),
			"param_name" 	=> 	"btn_visibility",
			"group" 		=> 'Button',
			"value"			=>	array(
				"Hide"			=>		'hide',
				"Show"			=>		'show',
			)
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Button Text', 'slider' ),
			"param_name" 	=> 	"btn_text",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Button URL', 'slider' ),
			"param_name" 	=> 	"btn_url",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Text Size', 'slider' ),
			"param_name" 	=> 	"btn_size",
			"value"			=>	"15",
			"description"	=>	"set in pixel eg 15",
			"suffix" 		=> 	'px',
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Button Height', 'slider' ),
			"param_name" 	=> 	"btn_height",
			"description"	=>	"set in pixel eg 20,",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"value"			=> 	"20",
			"suffix" 		=> 	'px',
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Button Width', 'slider' ),
			"param_name" 	=> 	"btn_width",
			"description"	=>	"set in pixel eg 60",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"value"			=> 	"60",
			"suffix" 		=> 	'px',
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Button Border Radius', 'slider' ),
			"param_name" 	=> 	"btn_border",
			"description"	=>	"set in pixel",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"value"			=> 	"5",
			"suffix" 		=> 	'px',
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Border Style', 'slider' ),
			"param_name" 	=> 	"btn_border_style",
			"description"	=>	"[height style color]",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"value"			=> 	"0px solid #fff",
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Text Color', 'slider' ),
			"param_name" 	=> 	"btn_clr",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'slider' ),
			"param_name" 	=> 	"btn_bg",
			"dependency" => array('element' => "btn_visibility", 'value' => 'show'),
			"group" 		=> 'Button',
		),

		// Description Section

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Padding Top', 'slider' ),
			"param_name" 	=> 	"content_padding",
			"description"	=>	__('set in %. padding will apply from top for the content. It works only if you select theme "Content Over Image" from carousel settings.', 'slider'),
			"suffix" 		=> 	'%',
			"value"			=>	"0",
			"group" 		=> 'Description',
		),
		array(
			"type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Carousel Detail', 'slider' ),
			"param_name" 	=> 	"content",
			"value"			=>	"<p style='text-align: center;'>write any text and make custom design that you want to show.</p>",
			"group" 		=> 'Description',
		),
	),
) );
