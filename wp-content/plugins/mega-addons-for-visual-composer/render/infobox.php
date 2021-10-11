<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_infobox extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'info_style' 			=> 		'mega_info_box',
			'info_opt' 				=> 		'show_image',
			'image_id' 				=> 		'',
			'alt'	 				=> 		'',
			'image_size' 			=> 		'',
			'image_radius' 			=> 		'0px',
			'font_icon' 			=> 		'',
			'icon_size' 			=> 		'25',
			'icon_color' 			=> 		'',
			'hoverclr' 			=> 		'',
			'icon_height'			=>		'',
			'icon_bg'				=>		'',
			'hoverbg'				=>		'',
			'icon_radius'			=>		'0px',
			'border_width'			=>		'0',
			'border_style'			=>		'solid',
			'border_clr'			=>		'',
			'shadow'				=>		'nonesss',
			'hovershadow'			=>		'nones',
			'css' 		 			=> 		'',
			'info_title' 			=> 		'',
			'title_color' 			=> 		'#000',
			'title_size' 			=> 		'',
			'info_desc' 			=> 		'',
			'line_height' 			=> 		'1',
			'info_size' 			=> 		'',
			'desc_size' 			=> 		'15',
			'btn_visibility' 		=> 		'none',
			'btn_text' 				=> 		'',
			'link' 				=> 		'none',
			'btn_url' 				=> 		'',
			'btn_clr' 				=> 		'',
			'css'	 				=> 		'',
		), $atts ) );
		$some_id = rand(5, 500);
		$btn_url = vc_build_link($btn_url);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		wp_enqueue_style( 'info-box-css', plugins_url( '../css/infobox.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
		<?php if ($link == 'link_box') { ?>
			<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" style="text-decoration: none;color: #000;">
		<?php } ?>
		<?php if ($link != 'link_box') { ?>
			<a style="text-decoration: none;color: #000;">
		<?php } ?>
			<div class="<?php echo $info_style; ?> mega-info-box-<?php echo $some_id; ?> <?php echo $shadow; ?> <?php echo $hovershadow; ?> <?php echo $css_class; ?>">
				<div class="mega-info-header">
					<?php if ($info_opt == 'show_image') { ?>
						<img class="mega-info-img" src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $image_size; ?>px; border-radius: <?php echo $image_radius; ?>;">			
					<?php } ?>
					<?php if ($info_opt == 'show_icon') { ?>
						<i class="<?php echo $font_icon; ?>" aria-hidden="true" style="border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $border_clr; ?>; border-radius: <?php echo $icon_radius; ?>; background: <?php echo $icon_bg; ?>; width: <?php echo $icon_height; ?>px; height: <?php echo $icon_height; ?>px; line-height: <?php echo $icon_height-$border_width; ?>px; font-size: <?php echo $icon_size; ?>px; color: <?php echo $icon_color; ?>;"></i>
					<?php } ?>
				</div>
				<div class="mega-info-footer">
					<h3 class="mega-info-title" style="color: <?php echo $title_color ?>; font-size: <?php echo $title_size; ?>px; line-height: <?php echo $line_height; ?>;">
						<?php echo $info_title; ?>
					</h3>
					<div class="mega-info-desc" style="">
						<?php echo $content; ?>
					</div>
					<?php if ($link == 'link_btn') { ?>
						<a class="mega-info-btn" href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" style="color: <?php echo $btn_clr; ?>">
							<?php echo $btn_text; ?>
						</a>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</a>

		<style>
			.mega-info-box-<?php echo $some_id; ?>:hover .mega-info-header i {
				color: <?php echo $hoverclr; ?> !important;
				background: <?php echo $hoverbg; ?> !important;
			}
		</style>

		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Info Box', 'infobox' ),
	"base" 			=> "mvc_infobox",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Add icon box with custom font icon', 'infobox'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/infobox.png',
	'params' => array(
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Select Style', 'infobox' ),
			"param_name" 	=> "info_style",
			"description" 	=> __( 'Choose info style <a href="http://addons.topdigitaltrends.net/info-box/" target="_blank">See Demo</a>', 'infobox' ),
			"group" 		=> 'General',
			"value" 		=> array(
				'Vertical'	=>	'mega_info_box',
				'Horizontal'	=>	'mega_info_box_2',
			)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Select Image or Font icon', 'infobox' ),
			"param_name" 	=> "info_opt",
			"description" 	=> __( 'Select Image or Font icon', 'infobox' ),
			"group" 		=> 'General',
			"value" 		=> array(
				'Image'	=>	'show_image',
				'Font Icon'	=>	'show_icon',
			)
		),
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Image', 'infobox' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'infobox' ),
			"group" 		=> 	'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
			"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
			"group" 		=> 	'General',
        ),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Width', 'infobox' ),
			"param_name" 	=> "image_size",
			"description" 	=> __( 'Set the width in pixel e.g 80', 'infobox' ),
			"group" 		=> 'General',
			"suffix" 		=> 'px',
			"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Image Radius', 'infobox' ),
			"param_name" 	=> "image_radius",
			"description" 	=> __( 'set the image border radius', 'infobox' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_image'),
			"value"			=>	array(
					"None"		=>		"0px",
					"5px"		=>		"5px",
					"10px"		=>		"10px",
					"15px"		=>		"15px",
					"20px"		=>		"20px",
					"25px"		=>		"25px",
					"50%"		=>		"50%",
				)
		),
		array(
			"type" 			=> "iconpicker",
			"heading" 		=> __( 'Font icon', 'infobox' ),
			"param_name" 	=> "font_icon",
			"description" 	=> __( 'Select the font icon', 'infobox' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Font size', 'infobox' ),
			"param_name" 	=> "icon_size",
			"description" 	=> __( 'Set icon font size in pixel e.g 30', 'infobox' ),
			"group" 		=> 'General',
			"value"			=>	"25",
			"suffix" 		=> 'px',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Height/Width', 'infobox' ),
			"param_name" 	=> "icon_height",
			"description" 	=> __( 'height & width for icon, set in pixel', 'infobox' ),
			"group" 		=> 'General',
			"value"			=>	"",
			"suffix" 		=> 'px',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),
		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Font Color', 'infobox' ),
			"param_name" 	=> "icon_color",
			"description" 	=> __( 'Set icon color', 'infobox' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),
		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Color', 'infobox' ),
			"param_name" 	=> "hoverclr",
			"description" 	=> __( 'icon color on hover', 'infobox' ),
			"group" 		=> 'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),
		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Backgroud', 'infobox' ),
			"param_name" 	=> "icon_bg",
			"group" 		=> 'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),
		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Backgroud', 'infobox' ),
			"param_name" 	=> "hoverbg",
			"group" 		=> 'General',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Box Shadow', 'infobox' ),
			"param_name" 	=> "shadow",
			"group" 		=> 'General',
			"value"			=>	array(
				"No"			=>		"nonesss",
				"Yes"	=>		"vc_info_box_shadow",				)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Hover Shadow', 'infobox' ),
			"param_name" 	=> "hovershadow",
			"group" 		=> 'General',
			"value"			=>	array(
				"No"			=>		"nones",
				"Yes"	=>		"vc_info_box_hvr_shadow",				)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Link To', 'infobox' ),
			"param_name" 	=> "link",
			"group" 		=> 'General',
			"value"			=>	array(
					"None"			=>		"none",
					"Complete Box"	=>		"link_box",
					"Read More"		=>		"link_btn",
				)
		),

		array(
            "type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Url Link', 'infobox' ),
			"param_name" 	=> 	"btn_url",
			"dependency" => array('element' => "link", 'value' => array('link_box', 'link_btn')),
			"group" 		=> 	'General',
        ),

		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Button Text', 'infobox' ),
			"param_name" 	=> 	"btn_text",
			"description" 	=> 	__( 'Button text name', 'infobox' ),
			"dependency" => array('element' => "link", 'value' => 'link_btn'),
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Button Text color', 'infobox' ),
			"param_name" 	=> 	"btn_clr",
			"description" 	=> 	__( 'Set Button background color', 'infobox' ),
			"dependency" => array('element' => "link", 'value' => 'link_btn'),
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
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Radius', 'infobox' ),
			"param_name" 	=> "icon_radius",
			"description" 	=> __( 'set the border radius around icon', 'infobox' ),
			"group" 		=> 'Border',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
			"value"			=>	array(
					"None"		=>		"0px",
					"5px"		=>		"5px",
					"10px"		=>		"10px",
					"15px"		=>		"15px",
					"20px"		=>		"20px",
					"25px"		=>		"25px",
					"50%"		=>		"50%",
				)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Width', 'infobox' ),
			"param_name" 	=> "border_width",
			"description" 	=> __( 'select the border width', 'infobox' ),
			"group" 		=> 'Border',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
			"value"			=>	array(
					"0px"		=>		"0",
					"1px"		=>		"1",
					"2px"		=>		"2",
					"3px"		=>		"3",
					"5px"		=>		"5",
					"7px"		=>		"7",
					"10px"		=>		"10",
					"15px"		=>		"15",
				)
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Style', 'infobox' ),
			"param_name" 	=> "border_style",
			"group" 		=> 'Border',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
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
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Border Color', 'infobox' ),
			"param_name" 	=> "border_clr",
			"description" 	=> __( 'set the border color', 'infobox' ),
			"group" 		=> 'Border',
			"dependency" => array('element' => "info_opt", 'value' => 'show_icon'),
		),

		/* Detail */

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Line Height', 'infobox' ),
			"param_name" 	=> "line_height",
			"description" 	=> __( 'Set line height for text', 'infobox' ),
			"value"			=>	"1",
			"group" 		=> 'Detail',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Title', 'infobox' ),
			"param_name" 	=> "info_title",
			"description" 	=> __( 'Write title for heading', 'infobox' ),
			"group" 		=> 'Detail',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Title font size', 'infobox' ),
			"param_name" 	=> "title_size",
			"description" 	=> __( 'Set font size for title e.g 16', 'infobox' ),
			"suffix" 		=> 'px',
			"group" 		=> 'Detail',
		),
		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Title Color', 'infobox' ),
			"param_name" 	=> "title_color",
			"value" 		=> "#000",
			"group" 		=> 'Detail',
		),
		array(
			"type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Description', 'infobox' ),
			'holder' 		=> 'div',
			"param_name" 	=> 	"content",
			"value"			=>	"<p>write description of Info box.</p>",
			"group" 		=> 	'Detail',
		),
		array(
			"type" 			=> 	"css_editor",
			"heading" 		=> 	__( 'Display Design', 'infobox' ),
			"param_name" 	=> 	"css",
			"group" 		=>  'Design Options',
		),
	),
) );

