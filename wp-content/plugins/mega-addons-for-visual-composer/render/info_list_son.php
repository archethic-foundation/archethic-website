<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_info_list_son extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'			=>		'image',
			'image_id'		=>		'',
			'alt'			=>		'',
			'icon'			=>		'',
			'size'			=>		'30',
			'width'			=>		'80',
			'height'		=>		'80',
			'imgstyle'		=>		'img-rounded',
			'iconclr'		=>		'#000',
			'iconbg'		=>		'#fff',
			'borderwidth'	=>		'0',
			'borderstyle'	=>		'solid',
			'radius'		=>		'50%',
			'borderclr'		=>		'',
			'title'			=>		'',
			'titlesize'		=>		'18',
			'lineheight'	=>		'',
			'titleclr'		=>		'#000',
			'title_weight'	=>		'default',
			'desc'			=>		'',
			'descsize'		=>		'15',
			'descclr'		=>		'#000',
		), $atts ) );
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$content = wpb_js_remove_wpautop($content, true);
		ob_start();

		global $maw_infolist_theme; global $maw_infolist_connector_h; global $maw_infolist_listwidth; global $maw_infolist_liststyle; global $maw_infolist_listclr;
		?>
		<div class="vc_info_list_outer">
			<?php if ($maw_infolist_theme == 'left') { ?>			    	
		    	<li class="vc_info_list" style="padding-bottom: <?php echo $maw_infolist_connector_h; ?>px; border-left: <?php echo $maw_infolist_listwidth; ?>px <?php echo $maw_infolist_liststyle; ?> <?php echo $maw_infolist_listclr; ?>; display: table;margin-left: <?php echo $width/2+$borderwidth; ?>px; float: none; margin-bottom: 2px;">
			      	<div class="media">
					  <div class="media-left info-list-img" style="margin-left: -<?php echo $width/2+$borderwidth; ?>px; padding-right: 20px; float: left;">
					    <?php if ($style == 'image') { ?>
				        	<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;" class="<?php echo $imgstyle; ?>">
				        <?php } ?>
				        <?php if ($style == 'icon') { ?>
				        <div style="border: <?php echo $borderwidth; ?>px <?php echo $borderstyle; ?> <?php echo $borderclr; ?>; border-radius: <?php echo $radius; ?>; background: <?php echo $iconbg; ?>;">
					        <span style="display:table; width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; border-radius: <?php echo $radius; ?>; text-align: center;">
						    	<span style="display: table-cell !important;vertical-align: middle !important;">
						        
						        	<i class="<?php echo $icon; ?>" aria-hidden="true" style="font-size: <?php echo $size; ?>px; color: <?php echo $iconclr; ?>;"></i>
					       	 	
					       	 	</span>
						  	</span>
						</div>
						<?php } ?>
					  </div>
				  	  <div class="media-body">
				    	<h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; font-style: <?php echo $title_weight; ?>; line-height: <?php echo $lineheight; ?>;">
				    		<?php echo $title; ?>
				    	</h2>
				    		<?php echo $content; ?>
				  		</div>
					</div>
		    	</li>
			<?php } ?>

			<?php if ($maw_infolist_theme == 'right') { ?>
			    <li class="vc_info_list" style="padding-bottom: <?php echo $maw_infolist_connector_h; ?>px; border-right: <?php echo $maw_infolist_listwidth; ?>px <?php echo $maw_infolist_liststyle; ?> <?php echo $maw_infolist_listclr; ?>; display: table;margin-right: <?php echo $width/2+$borderwidth; ?>px; float: none; margin-bottom: 2px;">
					<div class="media" style="margin-right: -<?php echo $width/2+$borderwidth; ?>px;">
					   <div class="media-body text-right">
					     <h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; font-style: <?php echo $title_weight; ?>; line-height: <?php echo $lineheight; ?>;">
				    		<?php echo $title; ?>
					     </h2>
					     	<?php echo $content; ?>
					   </div>
					   <div class="media-right" style="padding-left: 20px;">
					     <?php if ($style == 'image') { ?>
				        	<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;" class="<?php echo $imgstyle; ?>">
				         <?php } ?>
				         <?php if ($style == 'icon') { ?>
					        <div style="background: <?php echo $iconbg; ?>; border: <?php echo $borderwidth; ?>px <?php echo $borderstyle; ?> <?php echo $borderclr; ?>; border-radius: <?php echo $radius; ?>;">
						        <span style="display:table; width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; border-radius: <?php echo $radius; ?>;text-align: center;">
							    	<span style="display: table-cell !important;vertical-align: middle !important;">
							        
							        	<i class="<?php echo $icon; ?>" aria-hidden="true" style="font-size: <?php echo $size; ?>px; color: <?php echo $iconclr; ?>;"></i>
						       	 	
						       	 	</span>
							  	</span>
							</div>
						<?php } ?>
					   </div>
					</div>
				</li>
			<?php } ?>	
		</div>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "info_list_son",
	"name" 			=> __( 'Info List Settings', 'infolist' ),
	"as_child" 		=> array('only' => 'info_list_father'),
	"content_element" => true,
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Info list for information', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/infolist.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Image/Icon', 'infolist' ),
			"param_name" 	=> 	"style",
			"description" 	=> 	__( 'select', 'infolist' ),
			"group" 		=> 'Icon/Image',
			"value"			=> array(
				"Image"			=>	"image",
				"Icon"			=>	"icon",
			)
		),
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Image', 'infolist' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'infolist' ),
			"dependency" => array('element' => "style", 'value' => 'image'),
			"group" 		=> 	'Icon/Image',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"dependency" => array('element' => "style", 'value' => 'image'),
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
			"group" 		=> 	'Icon/Image',
        ),
        array(
            "type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Icon', 'infolist' ),
			"param_name" 	=> 	"icon",
			"description" 	=> 	__( 'Select icon', 'infolist' ),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 	'Icon/Image',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font Size', 'infolist' ),
			"param_name" 	=> 	"size",
			"description" 	=> 	__( 'icon font size in pixel eg, 30', 'infolist' ),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"value"			=>	"30",
			"suffix" 		=> 'px',
			"group" 		=> 	'Icon/Image',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Width', 'infolist' ),
			"param_name" 	=> 	"width",
			"description" 	=> 	__( 'set width in pixel eg, 80', 'infolist' ),
			"suffix" 		=> 'px',
			"value"			=>	"80",
			"group" 		=> 	'Icon/Image',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Height', 'infolist' ),
			"param_name" 	=> 	"height",
			"description" 	=> 	__( 'set height in pixel eg, 80', 'infolist' ),
			"value"			=>	"80",
			"suffix" 		=> 'px',
			"group" 		=> 	'Icon/Image',
        ),
        array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Image Style', 'infolist' ),
			"param_name" 	=> 	"imgstyle",
			"description" 	=> 	__( 'choose style', 'infolist' ),
			"group" 		=> 'Icon/Image',
			"dependency" => array('element' => "style", 'value' => 'image'),
			"value"			=> array(
				"Rounded"		=>	"img-rounded",
				"Thumbnail"		=>	"img-thumbnail",
				"Circle"		=>	"img-circle",
			)
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Color', 'infolist' ),
			"param_name" 	=> 	"iconclr",
			"description" 	=> __('For icon', 'infolist'),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 'Icon/Image',
		),
        array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Backgroud color', 'infolist' ),
			"param_name" 	=> 	"iconbg",
			"description" 	=> __('For icon', 'infolist'),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 'Icon/Image',
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Icon/Image',
		),


		// Border
		
		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Border width', 'infolist' ),
			"param_name" 	=> 	"borderwidth",
			"description" 	=> 	__( 'set border width eg, 5', 'infolist' ),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"value"			=>	"0",
			"suffix" 		=> 'px',
			"group" 		=> 	'Icon/Image',
        ),

        array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Border Style', 'infolist' ),
			"param_name" 	=> 	"borderstyle",
			"description" 	=> 	__( 'select border style', 'infolist' ),
			"group" 		=> 'Icon/Image',
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"value"			=> array(
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
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Border Radius', 'infolist' ),
			"param_name" 	=> 	"radius",
			"description" 	=> 	__( 'set border radius eg, 5px or 5%', 'infolist' ),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"value"			=>	"50%",
			"group" 		=> 	'Icon/Image',
        ),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Border color', 'infolist' ),
			"param_name" 	=> 	"borderclr",
			"description" 	=> __('border color', 'infolist'),
			"dependency" => array('element' => "style", 'value' => 'icon'),
			"group" 		=> 'Icon/Image',
		),

		// Text File

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title', 'infolist' ),
			"param_name" 	=> 	"title",
			'admin_label' 	=> 	true,
			"group" 		=> 'Content',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Title Font Size', 'infolist' ),
			"param_name" 	=> 	"titlesize",
			"description" 	=> 	__('set in pixel, default 18', 'infolist'),
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 	'Content',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Line Height', 'infolist' ),
			"param_name" 	=> 	"lineheight",
			"group" 		=> 'Content',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'infolist' ),
			"param_name" 	=> 	"titleclr",
			"value"			=>	"#000",
			"group" 		=> 	'Content',
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Font Weight', 'infolist' ),
			"param_name" 	=> 	"title_weight",
			"group" 		=> 'Content',
			"value"			=> array(
				"Default"			=>	"default",
				"Bold"				=>	"bold",
				"Italic"			=>	"italic",
			)
		),

		array(
			"type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Description', 'infobox' ),
			"param_name" 	=> 	"content",
			"group" 		=> 	'Content',
		),
	),
) );
