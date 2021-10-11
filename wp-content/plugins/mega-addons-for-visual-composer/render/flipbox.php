<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_flip_box extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'			=> 		'horizental',
			'height'		=> 		'200',
			'info_opt'		=> 		'show_image',
			'front_bg'		=>		'',
			'border_st'		=>		'',
			'border_clr'	=>		'',
			'border_width'	=>		'0',
			'border_style'	=>		'solid',
			'link_st'		=>		'',
			'url'			=>		'',
			'url_txt'		=>		'',
			'url_clr'		=>		'',
			'url_bg'		=>		'',
			'image_id'		=> 		'',
			'radius'		=> 		'',
			'image_size'	=> 		'',
			'font_icon'		=> 		'',
			'icon_size'		=> 		'',
			'icon_color'	=> 		'',
			'lineheight'	=> 		'1.5',
			'title'			=> 		'',
			'size'			=> 		'15',
			'color'			=> 		'',
			'desc'			=> 		'',
			'descrsize'		=> 		'13',
			'descrcolor'	=> 		'',
			'bgcolor'		=> 		'',
			'class'			=> 		'',
			'titlesizembl'	=>		'',
			'descsizmbl'	=>		'',
			'heightmbl'		=>		'',
		), $atts ) );
		$url = vc_build_link($url);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$some_id = rand(5, 500);
		wp_enqueue_style( 'flip-box-css', plugins_url( '../css/flipbox.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
		<?php if ($style == 'vertical') { ?>
	      	<div class="hover vc-ihe-panel <?php echo $class; ?>" id="vc-flip-box-<?php echo $some_id; ?>" style="height: <?php echo $height; ?>px;">
			  <div class="front" style="background: <?php echo $front_bg; ?>;">
			  	<div style="display:table;width:100%;height:100%;">
				    <div class="pad" style="display: table-cell !important;vertical-align: middle !important; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_clr; ?>;">
				      <?php if ($info_opt == 'show_image') { ?>
						<img class="" src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="border-radius: <?php echo $radius; ?>; width: <?php echo $image_size; ?>px;">			
					  <?php } ?>
					  <?php if ($info_opt == 'show_icon') { ?>
						<i class="<?php echo $font_icon; ?>" aria-hidden="true" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_color; ?>;"></i>
					  <?php } ?>
				      <h4 class="flip-box-title" style="color: <?php echo $color; ?>; font-size: <?php echo $size; ?>px; line-height: <?php echo $lineheight; ?>;">
				      		<?php echo $title; ?>
				      </h4>
				      <p class="flip-box-desc" style="color: <?php echo $descrcolor; ?>; font-size: <?php echo $descrsize; ?>px;">
				        <?php echo $desc; ?>
				      </p>
				    </div>
			    </div>
			  </div>
			  <div class="back" style="background: <?php echo $bgcolor; ?>">
				<div style="display:table;width:100%;height:100%;">
			    	<div class="pad" style="display: table-cell !important;vertical-align: middle !important; padding: 10px;">
				      <?php echo $content; ?>
				      <p style="text-align: center;">
				      	<?php if (!empty($url_txt)) { ?>
					      	<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" class="mega_hvr_btn" style="color: <?php echo $url_clr; ?>; background: <?php echo $url_bg; ?>;">
					      		<?php echo $url_txt; ?>
					      	</a>			      		
				      	<?php } ?>
				      </p>
				    </div>
			    </div>
			  </div>
			</div> 	
	    <?php } ?>

	    <?php if ($style == 'horizental') { ?>
	      	<div class="hover vc-ihe-panel <?php echo $class; ?>" id="vc-flip-box-<?php echo $some_id; ?>" style="height: <?php echo $height; ?>px;">
			  <div class="front1" style="background: <?php echo $front_bg; ?>;">
			  	<div style="display:table;width:100%;height:100%;">
				    <div class="pad" style="display: table-cell !important;vertical-align: middle !important; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_clr; ?>;">
				      <?php if ($info_opt == 'show_image') { ?>
						<img class="" src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="border-radius: <?php echo $radius; ?>; width: <?php echo $image_size; ?>px;">			
					  <?php } ?>
					  <?php if ($info_opt == 'show_icon') { ?>
						<i class="<?php echo $font_icon; ?>" aria-hidden="true" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_color; ?>;"></i>
					  <?php } ?>
				      <h4 class="flip-box-title" style="color: <?php echo $color; ?>; font-size: <?php echo $size; ?>px; line-height: <?php echo $lineheight; ?>;">
				      		<?php echo $title; ?>
				      </h4>
				      <p class="flip-box-desc" style="color: <?php echo $descrcolor; ?>; font-size: <?php echo $descrsize; ?>px;">
				        <?php echo $desc; ?>
				      </p>
				    </div>
			    </div>

			  </div>
			  <div class="back1" style="background: <?php echo $bgcolor; ?>">
				<div style="display:table;width:100%;height:100%;">
			    	<div class="pad" style="display: table-cell !important;vertical-align: middle !important; padding: 10px;">
				      <?php echo $content; ?>
				      <p style="text-align: center;">
				      	<?php if (!empty($url_txt)) { ?>
					      	<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" class="mega_hvr_btn" style="color: <?php echo $url_clr; ?>; background: <?php echo $url_bg; ?>;">
					      		<?php echo $url_txt; ?>
					      	</a>			      		
				      	<?php } ?>
				      </p>
				    </div>
			    </div>
			  </div>
			</div>
		<?php } ?>

		<?php if ($style == '3d') { ?>
			<div id="vc-flip-box-<?php echo $some_id; ?>">
				<div class="flip-box-3d" style="height: <?php echo $height; ?>px;">
					<div class="cube <?php echo $class; ?>">
					    <div class="active-state" style="background: <?php echo $bgcolor; ?>; height: <?php echo $height; ?>px;transform-origin: center center -<?php echo $height/2; ?>px;">
					        <div style="display:table;width:100%;height:100%;">
						    	<div style="display: table-cell !important;vertical-align: middle !important; padding: 0 10px;">
							      <?php echo $content; ?>
							      <p style="text-align: center; padding-top: 4px;">
							      	<?php if (!empty($url_txt)) { ?>
								      	<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" class="mega_hvr_btn" style="color: <?php echo $url_clr; ?>; background: <?php echo $url_bg; ?>;">
								      		<?php echo $url_txt; ?>
								      	</a>			      		
							      	<?php } ?>
							      </p>
							    </div>
						    </div>
					    </div>
					    <div class="default-state <?php echo $css_class; ?>" style="height: <?php echo $height; ?>px; transform-origin: center center -<?php echo $height/2; ?>px; background: <?php echo $front_bg; ?>;">
					        <div style="display:table;width:100%;height:100%;">
					        	<div style="display: table-cell !important;vertical-align: middle !important; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_clr; ?>; padding: 0 10px;">
							        <?php if ($info_opt == 'show_image') { ?>
										<img class="" src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" width="<?php echo $image_size; ?>px" style="border-radius: <?php echo $radius; ?>;">			
									<?php } ?>
									<?php if ($info_opt == 'show_icon') { ?>
										<i class="<?php echo $font_icon; ?>" aria-hidden="true" style="font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_color; ?>;"></i>
									<?php } ?>
								    <h4 class="flip-box-title" style="color: <?php echo $color; ?>; font-size: <?php echo $size; ?>px; line-height: <?php echo $lineheight; ?>;">
								      	<?php echo $title; ?>
								    </h4>
								    <p class="flip-box-desc" style="color: <?php echo $descrcolor; ?>; font-size: <?php echo $descrsize; ?>px;">
								        <?php echo $desc; ?>
								    </p>
					    		</div>
					    	</div>
					    </div>
					</div>
				</div>
			</div>
		<?php } ?>

		<style>
			@media only screen and (max-width: 480px) {
				#vc-flip-box-<?php echo $some_id; ?> .flip-box-title {
					font-size: <?php echo $titlesizembl; ?>px !important;
				}
				#vc-flip-box-<?php echo $some_id; ?> .flip-box-desc {
					font-size: <?php echo $descsizmbl; ?>px !important;
				}
				#vc-flip-box-<?php echo $some_id; ?>.vc-ihe-panel, #vc-flip-box-<?php echo $some_id; ?> .flip-box-3d{
					height: <?php echo $heightmbl; ?>px !important;
				}
				#vc-flip-box-<?php echo $some_id; ?> .flip-box-3d .active-state, #vc-flip-box-<?php echo $some_id; ?> .flip-box-3d .default-state{
					height: <?php echo $heightmbl; ?>px !important;
				}
			}
		</style>

		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Flip Box', 'flipbox' ),
	"base" 			=> "mvc_flip_box",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Show flip box for Info', 'flipbox'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/flipbox.png',
	'params' => array(
			array(
				"type" 			=> "dropdown",
				"heading" 		=> __( 'Style Flip Box', 'flip-box-vc' ),
				"param_name" 	=> "style",
				"description" 	=> __( 'select style', 'flip-box-vc' ). ' <a target="_blank" href="https://addons.topdigitaltrends.net/flip-box/">Demo</a>',
				"group" 		=> 'General',
				"value" 		=> array(
					'Horizental'	=>	'horizental',
					'Vertical'	=>	'vertical',
					'3D'	=>	'3d',
				)
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Flip height', 'flip-box-vc' ),
				"param_name" 	=> "height",
				"description" 	=> __( 'Required. set flip box height e.g 200', 'flip-box-vc' ),
				'value' 		=> __( "200", 'flip-box-vc' ),
				"suffix" 		=> 'px',
				'max' 			=> '',
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Front Background', 'flip-box-vc' ),
				"param_name" 	=> "front_bg",
				"description" 	=> __( 'background color for front display', 'flip-box-vc' ),
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "dropdown",
				"heading" 		=> __( 'Border Styling', 'flip-box-vc' ),
				"param_name" 	=> "border_st",
				"group" 		=> 'General',
				"value"			=>	array(
					"Default"			=>		"default",
					"Custom Styling"	=>		"custom_border",
				)
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Border Color', 'flip-box-vc' ),
				"param_name" 	=> "border_clr",
				"description" 	=> __( 'border color for front display', 'flip-box-vc' ),
				"dependency" => array('element' => "border_st", 'value' => 'custom_border'),
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Border Width', 'flip-box-vc' ),
				"param_name" 	=> "border_width",
				"description" 	=> __( 'border width for front display', 'flip-box-vc' ),
				"dependency" => array('element' => "border_st", 'value' => 'custom_border'),
				"suffix" 		=> 'px',
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "dropdown",
				"heading" 		=> __( 'Border Style', 'flip-box-vc' ),
				"param_name" 	=> "border_style",
				"group" 		=> 'General',
				"dependency" => array('element' => "border_st", 'value' => 'custom_border'),
				"value"			=>	array(
						"Solid"		=>		"solid",
						"Dotted"	=>		"dotted",
						"Rige"		=>		"rige",
						"Dashed"	=>		"dashed",
						"Double"	=>		"double",
						"Groove"	=>		"groove",
						"Inset"		=>		"inset",
					)
			),
			array(
				"type" 			=> "dropdown",
				"heading" 		=> __( 'Link To', 'flip-box-vc' ),
				"param_name" 	=> "link_st",
				"group" 		=> 'General',
				"value"			=>	array(
					"None"			=>		"none",
					"Custom Link"	=>		"custom_link",
				)
			),
			array(
				"type" 			=> "vc_link",
				"heading" 		=> __( 'Link URL', 'flip-box-vc' ),
				"param_name" 	=> "url",
				"dependency" => array('element' => "link_st", 'value' => 'custom_link'),
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "textfield",
				"heading" 		=> __( 'Link Text', 'flip-box-vc' ),
				"param_name" 	=> "url_txt",
				"dependency" => array('element' => "link_st", 'value' => 'custom_link'),
				"description" 	=> __( 'button text', 'flip-box-vc' ),
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Link Color', 'flip-box-vc' ),
				"param_name" 	=> "url_clr",
				"dependency" => array('element' => "link_st", 'value' => 'custom_link'),
				"description" 	=> __( 'button text color', 'flip-box-vc' ),
				"group" 		=> 'General',
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Link Background', 'flip-box-vc' ),
				"param_name" 	=> "url_bg",
				"dependency" => array('element' => "link_st", 'value' => 'custom_link'),
				"description" 	=> __( 'button background color', 'flip-box-vc' ),
				"group" 		=> 'General',
			),
			array(
	            "type" 			=> 	"textfield",
				"heading" 		=> 	__( 'Extra Class', 'int_banner' ),
				"param_name" 	=> 	"class",
				"description" 	=> 	__( 'Add extra class name that will be applied to the icon process, and you can use this class for your customizations.', 'int_banner' ),
				"group" 		=> 	"General",
	        ),

	        array(
				"type" 			=> "vc_links",
				"param_name" 	=> "caption_url",
				"class"			=>	"ult_param_heading",
				"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
				"group" 		=> 'General',
			),

			// iCON/iMAGE
			
			array(
				"type" 			=> "dropdown",
				"heading" 		=> __( 'Select Image or Font icon', 'flip-box-vc' ),
				"param_name" 	=> "info_opt",
				"description" 	=> __( 'Select Image or Font icon', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
				"value" 		=> array(
					'Image'	=>	'show_image',
					'Icon'	=>	'show_icon',
				)
			),
			array(
                "type" 			=> 	"attach_image",
				"heading" 		=> 	__( 'Image', 'flip-box-vc' ),
				"param_name" 	=> 	"image_id",
				"description" 	=> 	__( 'Select the image', 'flip-box-vc' ),
				"group" 		=> 	'Front Display',
				"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
            ),
            array(
	            "type" 			=> 	"textfield",
				"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
				"param_name" 	=> 	"alt",
				"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
				"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
				"group" 		=> 	'Front Display',
	        ),
            array(
				"type" 			=> "textfield",
				"heading" 		=> __( 'Image Radius', 'flip-box-vc' ),
				"param_name" 	=> "radius",
				"description" 	=> __( 'Set Image radius in pixel or % e.g 50%', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
				"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Width', 'flip-box-vc' ),
				"param_name" 	=> "image_size",
				"description" 	=> __( 'Image width in pixel e.g 80', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
				"suffix" 		=> 'px',
				"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
			),
			array(
				"type" 			=> "iconpicker",
				"heading" 		=> __( 'Font icon', 'flip-box-vc' ),
				"param_name" 	=> "font_icon",
				"description" 	=> __( 'Select the font icon', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
				"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Font size', 'flip-box-vc' ),
				"param_name" 	=> "icon_size",
				"description" 	=> __( 'Set icon font size in pixel e.g 30', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
				"suffix" 		=> 'px',
				"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Font Color', 'flip-box-vc' ),
				"param_name" 	=> "icon_color",
				"description" 	=> __( 'Set icon color', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
				"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
			),

			// Fron Content 
			
			array(
				"type" 			=> "textfield",
				"heading" 		=> __( 'Title', 'flip-box-vc' ),
				"param_name" 	=> "title",
				"description" 	=> __( 'set title for front display', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
			),
			array(
				"type" 			=> "textarea",
				"heading" 		=> __( 'Description', 'flip-box-vc' ),
				"param_name" 	=> "desc",
				"description" 	=> __( 'set description for front display', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Line height', 'flip-box-vc' ),
				"param_name" 	=> "lineheight",
				"description" 	=> __( 'set line height for text e.g 1.5', 'flip-box-vc' ),
				'value' 		=> __( "1.5", 'flip-box-vc' ),
				"group" 		=> 'Front Display',
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Title (Font Size)', 'flip-box-vc' ),
				"param_name" 	=> "size",
				"description" 	=> __( 'set title font size for front display e.g 15', 'flip-box-vc' ),
				'value' 		=> __( "15", 'flip-box-vc' ),
				"suffix" 		=> 'px',
				"group" 		=> 'Front Display',
			),
			array(
				"type" 			=> "vc_number",
				"heading" 		=> __( 'Description (Font Size)', 'flip-box-vc' ),
				"param_name" 	=> "descrsize",
				"description" 	=> __( 'set description font size for front display e.g 13', 'flip-box-vc' ),
				'value' 		=> __( "13", 'flip-box-vc' ),
				"suffix" 		=> 'px',
				"group" 		=> 'Front Display',
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Title color', 'flip-box-vc' ),
				"param_name" 	=> "color",
				"description" 	=> __( 'set title color', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
			),
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Description color', 'flip-box-vc' ),
				"param_name" 	=> "descrcolor",
				"description" 	=> __( 'set description color', 'flip-box-vc' ),
				"group" 		=> 'Front Display',
			),


			// Back Display 
			
			array(
				"type" 			=> "colorpicker",
				"heading" 		=> __( 'Background color', 'flip-box-vc' ),
				"param_name" 	=> "bgcolor",
				"description" 	=> __( 'set background color', 'flip-box-vc' ),
				"group" 		=> 'Flip Display',
			),
			array(
	            "type" 			=> 	"textarea_html",
				"heading" 		=> 	__( 'Description', 'flip-box-vc' ),
				"param_name" 	=> 	"content",
				"description" 	=> 	__( 'write detail about flip box', 'flip-box-vc' ),
				"group" 		=> 	'Flip Display',
				"value"			=> '<h3>Caption Text Here</h3><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>',
        	),

	        	/* Typography
	        ================================================ */
        
	        array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Front Title Font Size (For Mobile)', 'flip-box-vc' ),
				"param_name" 	=> 	"titlesizembl",
				"description" 	=> 	__( 'set in pixel e.g 16', 'flip-box-vc' ),
				"suffix" 		=> 'px',
				"group" 		=> 	"Typography",
	        ),
	        array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Front Description Font Size (For Mobile)', 'flip-box-vc' ),
				"param_name" 	=> 	"descsizmbl",
				"description" 	=> 	__( 'set in pixel e.g 15', 'flip-box-vc' ),
				"suffix" 		=> 'px',
				"group" 		=> 	"Typography",
	        ),
	        array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Flip height (For Mobile)', 'flip-box-vc' ),
				"param_name" 	=> 	"heightmbl",
				"description" 	=> 	__( 'set in pixel e.g 200', 'flip-box-vc' ),
				"suffix" 		=> 'px',
				"group" 		=> 	"Typography",
	        ),
	),
) );

