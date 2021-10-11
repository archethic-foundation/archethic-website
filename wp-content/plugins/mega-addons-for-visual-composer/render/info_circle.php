<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_vc_info_circle extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'width'					=>		'60',
			'hide_icon'				=>		'',
			'heading_size'			=>		'18',
			'desc_size'				=>		'15',
			'captionclr'			=>		'',
			'bgclr'					=>		'',
			'outer_border'			=>		'2px solid #E1E1E1',
			'icon_size'				=>		'25',
			'icon_clr'				=>		'',
			'icon_bg'				=>		'',
			'border_clr'			=>		'0px solid #fff',
			'icon'					=>		'',
			'heading'				=>		'',
			'desc'					=>		'',
			'icon2'					=>		'',
			'heading2'				=>		'',
			'desc2'					=>		'',
			'icon3'					=>		'',
			'heading3'				=>		'',
			'desc3'					=>		'',
			'icon4'					=>		'',
			'heading4'				=>		'',
			'desc4'					=>		'',
			'icon5'					=>		'',
			'heading5'				=>		'',
			'desc5'					=>		'',
			'style'					=>		'icon',
			'image_id'				=>		'',
			'image_id2'				=>		'',
			'image_id3'				=>		'',
			'image_id4'				=>		'',
			'image_id5'				=>		'',
		), $atts ) );
		if ($image_id != '') { $image_url = wp_get_attachment_url( $image_id ); }
		if ($image_id2 != '') { $image_url2 = wp_get_attachment_url( $image_id2 ); }
		if ($image_id3 != '') { $image_url3 = wp_get_attachment_url( $image_id3 ); }
		if ($image_id4 != '') { $image_url4 = wp_get_attachment_url( $image_id4 ); }
		if ($image_id5 != '') { $image_url5 = wp_get_attachment_url( $image_id5 ); }
		$content = wpb_js_remove_wpautop($content, true);
		wp_enqueue_style( 'info-circle-css', plugins_url( '../css/info-circle.css' , __FILE__ ));
		wp_enqueue_script( 'info-circle-js', plugins_url( '../js/info-circle.js' , __FILE__ ), array('jquery'));
		ob_start(); ?>
		<div id="mega-info-circle" class="mega-info-circle" style="margin-top: 40px;">
        	<div class="mega-outer-section" style="border: <?php echo $outer_border; ?>;">
	        	<div class="mega-inner-section" style="background: <?php echo $bgclr; ?>; width: <?php echo $width; ?>%; height: <?php echo $width; ?>%;">
		        	<div style="display: table; width: 100%; height: 100%;">
		        		<div style="display: table-cell !important; vertical-align: middle !important;" class="mega-inner-section-div <?php echo $hide_icon; ?>">


			        	</div>
		        	</div>
	        	</div>

	        	<div class="info-circle-icon icon-wrapper" style="background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;">
	        		<div>
	        			<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url; ?>" style="width: 56px; height: 56px; border-radius: 50%;" />
	        			<?php } ?>
    					
    					<span class="info-circle-detail">
    						<h3 style="font-size: <?php echo $heading_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $heading; ?>
    						</h3>
    						<p style="font-size: <?php echo $desc_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $desc; ?>
    						</p>
    					</span>
    				</div>
    			</div>

    			<div class="info-circle-icon2 icon-wrapper" style="background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;">
    				<div>
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon2; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url2; ?>" style="width: 56px; height: 56px; border-radius: 50%;" />
	        			<?php } ?>

    					<span class="info-circle-detail">
    						<h3 style="font-size: <?php echo $heading_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $heading2; ?>
    						</h3>
    						<p style="font-size: <?php echo $desc_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $desc2; ?>
    						</p>
    					</span>
    				</div>
    			</div>

    			<div class="info-circle-icon3 icon-wrapper" style="background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;">
    				<div>
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon3; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url3; ?>" style="width: 56px; height: 56px; border-radius: 50%;" />
	        			<?php } ?>

    					<span class="info-circle-detail">
    						<h3 style="font-size: <?php echo $heading_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $heading3; ?>
    						</h3>
    						<p style="font-size: <?php echo $desc_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $desc3; ?>
    						</p>
    					</span>
    				</div>
    			</div>

    			<div class="info-circle-icon4 icon-wrapper" style="background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;">
    				<div>
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon4; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url4; ?>" style="width: 56px; height: 56px; border-radius: 50%;" />
	        			<?php } ?>

    					<span class="info-circle-detail">
    						<h3 style="font-size: <?php echo $heading_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $heading4; ?>
    						</h3>
    						<p style="font-size: <?php echo $desc_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $desc4; ?>
    						</p>
    					</span>
    				</div>
    			</div>

    			<div class="info-circle-icon5 icon-wrapper" style="background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;">
    				<div>
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon5; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url5; ?>" style="width: 56px; height: 56px; border-radius: 50%;" />
	        			<?php } ?>

    					<span class="info-circle-detail">
    						<h3 style="font-size: <?php echo $heading_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $heading5; ?>
    						</h3>
    						<p style="font-size: <?php echo $desc_size; ?>px; color: <?php echo $captionclr; ?>;">
    							<?php echo $desc5; ?>
    						</p>
    					</span>
    				</div>
    			</div>
        	</div>

			<!== Mobile View ==>
        	<ul class="info-circle-mobile" style="border-left: <?php echo $outer_border; ?>;">
        		<li class="info-circle-icon">
        				<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>; background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url; ?>" style="width: 65px; height: 65px; border-radius: 50%; float: left;" />
	        			<?php } ?>
    				
    				<span class="mobile-info-detail" style="">
						<h3 style="font-size: 18px; color: #000; margin: 5px 0;">
							<?php echo $heading; ?>
						</h3>
						<p style="font-size: 14px; color: #000;">
							<?php echo $desc; ?>
						</p>
					</span>
        		</li>

        		<li class="info-circle-icon">
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon2; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>; background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url2; ?>" style="width: 65px; height: 65px; border-radius: 50%; float: left;" />
	        			<?php } ?>
    				<span class="mobile-info-detail" style="">
						<h3 style="font-size: 18px; color: #000; margin: 5px 0;">
							<?php echo $heading2; ?>
						</h3>
						<p style="font-size: 14px; color: #000;">
							<?php echo $desc2; ?>
						</p>
					</span>
        		</li>

        		<li class="info-circle-icon">
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon3; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>; background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url3; ?>" style="width: 65px; height: 65px; border-radius: 50%; float: left;" />
	        			<?php } ?>
    				<span class="mobile-info-detail" style="">
						<h3 style="font-size: 18px; color: #000; margin: 5px 0;">
							<?php echo $heading3; ?>
						</h3>
						<p style="font-size: 14px; color: #000;">
							<?php echo $desc3; ?>
						</p>
					</span>
        		</li>

        		<li class="info-circle-icon">
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon4; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>; background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url4; ?>" style="width: 65px; height: 65px; border-radius: 50%; float: left;" />
	        			<?php } ?>
    				<span class="mobile-info-detail" style="">
						<h3 style="font-size: 18px; color: #000; margin: 5px 0;">
							<?php echo $heading4; ?>
						</h3>
						<p style="font-size: 14px; color: #000;">
							<?php echo $desc4; ?>
						</p>
					</span>
        		</li>

        		<li class="info-circle-icon" style="padding-bottom: 0;">
    					<?php if ($style == 'icon') { ?>
	        				<i class="<?php echo $icon5; ?>" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_clr; ?>; background: <?php echo $icon_bg; ?>; border: <?php echo $border_clr; ?>;"></i>
	        			<?php } ?>
	        			<?php if ($style == 'image') { ?>
	        				<img src="<?php echo $image_url5; ?>" style="width: 65px; height: 65px; border-radius: 50%; float: left;" />
	        			<?php } ?>
    				<span class="mobile-info-detail" style="">
						<h3 style="font-size: 18px; color: #000; margin: 5px 0;">
							<?php echo $heading5; ?>
						</h3>
						<p style="font-size: 14px; color: #000;">
							<?php echo $desc5; ?>
						</p>
					</span>
        		</li>
        	</ul>
        </div>
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Info Circle', 'circle' ),
	"base" 			=> "vc_info_circle",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('express info about your work', 'circle'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/infocircle.png',
	'params' => array(
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Caption Width <a href="https://addons.topdigitaltrends.net/info-circle/" target="_blank">See Demo</a>', 'circle' ),
			"param_name" 	=> 	"width",
			"description" 	=> 	__( 'width of inner container in % eg, 60. '),
			"suffix" 		=> '%',
			"value"			=>	"60",
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Hide Icon', 'circle' ),
			"param_name" 	=> 	"hide_icon",
			"description" 	=> 	__( 'hide icon for inner container'),
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Heading Font size', 'circle' ),
			"param_name" 	=> 	"heading_size",
			"description" 	=> 	__( 'set in pixel eg, 18'),
			"suffix" 		=> 'px',
			"value"			=>	"18",
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Description Font size', 'circle' ),
			"param_name" 	=> 	"desc_size",
			"description" 	=> 	__( 'set in pixel eg, 15'),
			"value"			=>	"15",
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
		),	
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Caption Text Color', 'circle' ),
			"param_name" 	=> 	"captionclr",
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Caption Background', 'circle' ),
			"param_name" 	=> 	"bgclr",
			"description" 	=> 	__( 'background for inner container'),
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Border Style', 'circle' ),
			"param_name" 	=> 	"outer_border",
			"description" 	=> 	__( 'border for outer container'),
			"value"			=>	"2px solid #E1E1E1",
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'General',
		),


		/* Font Icon Setting
		=======================================================*/

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Icon/Image', 'circle' ),
			"param_name" 	=> 	"style",
			"description" 	=> 	__( 'choose Icon or Image'),
			"group" 		=> 	'Icon',
			"value"			=>	array(
				"Icon"		=>		"icon",
				"Image"		=>		"image",
			)
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font Icon size', 'circle' ),
			"param_name" 	=> 	"icon_size",
			"description" 	=> 	__( 'set in pixel eg, 25'),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"value"			=>	"25",
			"suffix" 		=> 	'px',
			"group" 		=> 	'Icon',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Icon Color', 'circle' ),
			"param_name" 	=> 	"icon_clr",
			"description" 	=> 	__( 'color will apply on all icons'),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'circle' ),
			"param_name" 	=> 	"icon_bg",
			"description" 	=> 	__( 'background will apply on all icons'),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Border', 'circle' ),
			"param_name" 	=> 	"border_clr",
			"description" 	=> 	__( 'It will apply on all icons [width style color]'),
			"dependency" 	=> array('element' => "style", 'value' => 'icon'),
			"value"			=>	"0px solid #fff",
			"group" 		=> 	'Icon',
		),

		/* Icon List Setting
		=======================================================*/

		array(
			"type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Choose Icon', 'circle' ),
			"param_name" 	=> 	"icon",
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon List',
		),
		array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'circle' ),
			"param_name" 	=> 	"image_id",
			"dependency" => array('element' => "style", 'value' => 'image'),
			"group" 		=> 	'Icon List',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Heading', 'circle' ),
			"param_name" 	=> 	"heading",
			"group" 		=> 	'Icon List',
		),
		array(
			"type" 			=> 	"textarea",
			"heading" 		=> 	__( 'Description', 'circle' ),
			"param_name" 	=> 	"desc",
			"group" 		=> 	'Icon List',
		),

		/* Icon List 2 Setting
		=======================================================*/

		array(
			"type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Choose Icon', 'circle' ),
			"param_name" 	=> 	"icon2",
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon List 2',
		),
		array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'circle' ),
			"param_name" 	=> 	"image_id2",
			"dependency" => array('element' => "style", 'value' => 'image'),
			"group" 		=> 	'Icon List 2',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Heading', 'circle' ),
			"param_name" 	=> 	"heading2",
			"group" 		=> 	'Icon List 2',
		),
		array(
			"type" 			=> 	"textarea",
			"heading" 		=> 	__( 'Description', 'circle' ),
			"param_name" 	=> 	"desc2",
			"group" 		=> 	'Icon List 2',
		),

		/* Icon List 3 Setting
		=======================================================*/

		array(
			"type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Choose Icon', 'circle' ),
			"param_name" 	=> 	"icon3",
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon List 3',
		),
		array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'circle' ),
			"param_name" 	=> 	"image_id3",
			"dependency" => array('element' => "style", 'value' => 'image'),
			"group" 		=> 	'Icon List 3',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Heading', 'circle' ),
			"param_name" 	=> 	"heading3",
			"group" 		=> 	'Icon List 3',
		),
		array(
			"type" 			=> 	"textarea",
			"heading" 		=> 	__( 'Description', 'circle' ),
			"param_name" 	=> 	"desc3",
			"group" 		=> 	'Icon List 3',
		),

		/* Icon List 4 Setting
		=======================================================*/

		array(
			"type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Choose Icon', 'circle' ),
			"param_name" 	=> 	"icon4",
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon List 4',
		),
		array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'circle' ),
			"param_name" 	=> 	"image_id4",
			"dependency" => array('element' => "style", 'value' => 'image'),
			"group" 		=> 	'Icon List 4',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Heading', 'circle' ),
			"param_name" 	=> 	"heading4",
			"group" 		=> 	'Icon List 4',
		),
		array(
			"type" 			=> 	"textarea",
			"heading" 		=> 	__( 'Description', 'circle' ),
			"param_name" 	=> 	"desc4",
			"group" 		=> 	'Icon List 4',
		),

		/* Icon List 5 Setting
		=======================================================*/

		array(
			"type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Choose Icon', 'circle' ),
			"param_name" 	=> 	"icon5",
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon List 5',
		),
		array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'circle' ),
			"param_name" 	=> 	"image_id5",
			"dependency" => array('element' => "style", 'value' => 'image'),
			"group" 		=> 	'Icon List 5',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Heading', 'circle' ),
			"param_name" 	=> 	"heading5",
			"group" 		=> 	'Icon List 5',
		),
		array(
			"type" 			=> 	"textarea",
			"heading" 		=> 	__( 'Description', 'circle' ),
			"param_name" 	=> 	"desc5",
			"group" 		=> 	'Icon List 5',
		),
	),
) );

