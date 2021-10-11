<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_info_banners_vc extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style_visibility'		=>		'top_to_bottom',
			'pic_width'				=>		'50%',
			'content_width'			=>		'50%',
			'image_id'				=>		'',
			'pic_size'				=>		'',
			'pic_height'			=>		'',
			'img_padding'			=>		'',
			'text_padding'			=>		'',
			'ribbon_text'			=>		'',
			'ribbon_clr'			=>		'',
			'ribbon_bg'				=>		'',
			'btn_icon'				=>		'',
			'btn_text'				=>		'',
			'btn_ptop'				=>		'20px',
			'btn_pleft'				=>		'60px',
			'btn_size'				=>		'18px',
			'btn_url'				=>		'',
			'border_style'			=>		'',
			'btn_radius'			=>		'',
			'btn_clr'				=>		'',
			'btn_bg'				=>		'',
			'btn_hvrclr'			=>		'',
			'btn_hvrbg'				=>		'',
			'css'				=>		'',
		), $atts ) );
		$content = wpb_js_remove_wpautop($content);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		wp_enqueue_style( 'infobanner-css', plugins_url( '../css/infobanner.css' , __FILE__ ));
		ob_start(); ?>
			<!-- Style1 & 2 info banner -->
		<?php if ($style_visibility == 'left' || $style_visibility == 'right') { ?>
			<div id="mega_info_bar" class="<?php echo $css_class; ?>">		   
				<div class="ribbon">
					<span style="color: <?php echo $ribbon_clr; ?>; background-color: <?php echo $ribbon_bg; ?>">
						<?php echo $ribbon_text; ?>
					</span>
				</div>
				<div class="mega_wrap" style="width: <?php echo $pic_width-1; ?>%; float: <?php echo $style_visibility; ?>; padding: <?php echo $img_padding; ?>;">
					<img src="<?php echo $image_url; ?>" style="width: <?php echo $pic_size; ?>; height: <?php echo $pic_height; ?>;">
				</div>

				<div class="mega_content" style="width: <?php echo $content_width-1; ?>%; padding: <?php echo $text_padding; ?>;">
					<?php echo $content; ?><br>

					<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onhoverbg="<?php echo $btn_hvrbg; ?>" data-onleavebg="<?php echo $btn_bg; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo $btn_url; ?>" class="mega_hvr_btn <?php echo $anim_style; ?>" style="font-size: <?php echo $btn_size; ?>; color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_style; ?>; padding: <?php echo $btn_ptop/2; ?>px <?php echo $btn_pleft/2; ?>px; border-radius: <?php echo $btn_radius; ?>;">
						<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
					</a>
				</div>
				<div class="clearfix"></div>
			</div>
		<?php } ?>


		<!-- Style3 info banner -->
		<?php if ($style_visibility == 'top_to_bottom') { ?>
			<div id="mega_info_bar_2" class="<?php echo $css_class; ?>">			   
				<div class="ribbon">
					<span style="color: <?php echo $ribbon_clr; ?>; background-color: <?php echo $ribbon_bg; ?>">
						<?php echo $ribbon_text; ?>
					</span>
				</div>
				<div class="mega_wrap" style="padding: <?php echo $img_padding; ?>;">
					<img src="<?php echo $image_url; ?>" style="width: <?php echo $pic_size; ?>; height: <?php echo $pic_height; ?>;">
				</div>

				<div class="mega_content" style="padding: <?php echo $text_padding; ?>;">
						<?php echo $content; ?><br>
					<a data-onhovercolor="<?php echo $btn_hvrclr; ?>" data-onhoverbg="<?php echo $btn_hvrbg; ?>" data-onleavebg="<?php echo $btn_bg; ?>" data-onleavecolor="<?php echo $btn_clr; ?>" href="<?php echo $btn_url; ?>" class="mega_hvr_btn <?php echo $anim_style; ?>" style="font-size: <?php echo $btn_size; ?>; color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_style; ?>; padding: <?php echo $btn_ptop/2; ?>px <?php echo $btn_pleft/2; ?>px; border-radius: <?php echo $btn_radius; ?>;">
						<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
					</a>
					<br>
				</div>
				<div class="clearfix"></div>
			</div>
		<?php } ?>
		
		<?php return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Info Banner', 'info-banner-vc' ),
	"base" 			=> "info_banners_vc",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Info banners for poducts and sales', 'info-banner-vc'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/infobanner.png',
	'params' => array(
		array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Style', 'info-banner-vc' ),
			"param_name" 	=> 	"style_visibility",
			"description" 	=> 	__( 'select styles for info banner', 'info-banner-vc' ),
			"group" 		=> 	'General',
			"value" 		=>  array(
				'Top image bottom content' =>  'top_to_bottom',
				'Left image right content' =>  'left',
				'Left content right image' =>  'right',
			)
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Picture box width', 'info-banner-vc' ),
			"param_name" 	=> 	"pic_width",
			"description" 	=> 	__( 'Set the width of picture box in percentage e.g 50%', 'info-banner-vc' ),
			"dependency" => array('element' => "style_visibility", 'value' => array('left', 'right',)),
			"value"			=>	"50%",
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Content box width', 'info-banner-vc' ),
			"param_name" 	=> 	"content_width",
			"description" 	=> 	__( 'Set the width of content box in percentage e.g 50%', 'info-banner-vc' ),
			"dependency" => array('element' => "style_visibility", 'value' => array('left', 'right',)),
			"value"			=>	"50%",
			"group" 		=> 	'General',
        ),

        // Content Area 

        array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Banner image', 'info-banner-vc' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select image for banner logo', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Image width', 'info-banner-vc' ),
			"param_name" 	=> 	"pic_size",
			"description" 	=> 	__( 'set image width e.g 100px or leave blank for default', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Image height', 'info-banner-vc' ),
			"param_name" 	=> 	"pic_height",
			"description" 	=> 	__( 'set image height e.g 100px or leave blank for default', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Padding ', 'info-banner-vc' ),
			"param_name" 	=> 	"img_padding",
			"description" 	=> 	__( 'top right bottom left', 'info-banner-vc' ),
			"value"			=>	"0px 0px 0px 0px",
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Padding ', 'info-banner-vc' ),
			"param_name" 	=> 	"text_padding",
			"description" 	=> 	__( 'top right bottom left', 'info-banner-vc' ),
			"value"			=>	"0px 0px 0px 0px",
			"group" 		=> 	'Content',
        ),
        array(
            "type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Description', 'info-banner-vc' ),
			"param_name" 	=> 	"content",
			"description" 	=> 	__( 'write detail about info banner', 'info-banner-vc' ),
			"group" 		=> 	'Content',
			"value"			=> '<h2>Caption Title</h2><p>caption detail here</p>'
        ),


        /** Ribbon Setting **/

        array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Ribbon text', 'info-banner-vc' ),
			"param_name" 	=> "ribbon_text",
			"description" 	=> __( 'write ribbon text for special offer or leave blank', 'info-banner-vc' ),
			"group" 		=> 'Ribbon',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Text color', 'info-banner-vc' ),
			"param_name" 	=> "ribbon_clr",
			"description" 	=> __( 'Ribbon text color', 'info-banner-vc' ),
			"group" 		=> 'Ribbon',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'info-banner-vc' ),
			"param_name" 	=> "ribbon_bg",
			"description" 	=> __( 'Ribbon background color', 'info-banner-vc' ),
			"group" 		=> 'Ribbon',
		),


        /** Button Setting **/

		array(
			"type" 			=> "iconpicker",
			"heading" 		=> __( 'Select Icon', 'info-banner-vc' ),
			"param_name" 	=> "btn_icon",
			"description" 	=> __( 'it will be show within text', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button text', 'info-banner-vc' ),
			"param_name" 	=> "btn_text",
			"description" 	=> __( 'Write button text', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button Height', 'info-banner-vc' ),
			"param_name" 	=> "btn_ptop",
			"description" 	=> __( 'button height. set in pixel e.g 20px', 'info-banner-vc' ),
			"value"			=>	"20px",
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button Width', 'info-banner-vc' ),
			"param_name" 	=> "btn_pleft",
			"description" 	=> __( 'button width. set in pixel e.g 60px', 'info-banner-vc' ),
			"value"			=>	"60px",
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Text font size', 'info-banner-vc' ),
			"param_name" 	=> "btn_size",
			"description" 	=> __( 'Set font size in pixel e.g 18px', 'info-banner-vc' ),
			"value"			=>	"18px",
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button URL', 'info-banner-vc' ),
			"param_name" 	=> "btn_url",
			"description" 	=> __( 'Write button url as link', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Border Style', 'info-banner-vc' ),
			"param_name" 	=> "border_style",
			"description" 	=> __( 'height style color', 'info-banner-vc' ),
			"value"			=>	"0px solid #fff",
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Border Radius', 'info-banner-vc' ),
			"param_name" 	=> "btn_radius",
			"description" 	=> __( 'set in pixel eg 5px or leave blank', 'info-banner-vc' ),
			"value"			=>	"5px",
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Text color', 'info-banner-vc' ),
			"param_name" 	=> "btn_clr",
			"description" 	=> __( 'Set color of text e.g #ffff', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'info-banner-vc' ),
			"param_name" 	=> "btn_bg",
			"description" 	=> __( 'Set background color of text e.g #000', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Text color', 'info-banner-vc' ),
			"param_name" 	=> "btn_hvrclr",
			"description" 	=> __( 'Set color of text on hover e.g #ffff', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'info-banner-vc' ),
			"param_name" 	=> "btn_hvrbg",
			"description" 	=> __( 'Set color of background on hover e.g #269CE9', 'info-banner-vc' ),
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "css_editor",
			"heading" 		=> __( 'Styling Info Banner', 'info-banner-vc' ),
			"param_name" 	=> "css",
			"group" 		=> 'Design Options',
		),
	),
) );

