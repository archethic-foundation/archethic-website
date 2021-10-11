<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_info_banner_vc extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style_visibility'		=>		'top_to_bottom',
			'pic_width'				=>		'50',
			'content_width'			=>		'50',
			'box_shadow' 			=>		'none',
			'img_shadow' 			=>		'none',
			'btn_shadow' 			=>		'none',
			'img_radius' 			=>		'',
			'gradient_bg' 			=>		'none',
			'gr_primclr' 			=>		'#0DDABA',
			'gr_secndclr' 			=>		'#5419D5',
			'gr_angle' 				=>		'40',
			'image_id'				=>		'',
			'alt'					=>		'',
			'pic_size'				=>		'',
			'pic_height'			=>		'',
			'img_padding'			=>		'',
			'text_padding'			=>		'',
			'ribbon_text'			=>		'',
			'ribbon_clr'			=>		'',
			'ribbon_bg'				=>		'',
			'btn_icon'				=>		'',
			'btn_text'				=>		'',
			'btn_ptop'				=>		'20',
			'btn_pleft'				=>		'60',
			'btn_size'				=>		'18',
			'url'					=>		'',
			'border_style'			=>		'',
			'btn_radius'			=>		'5',
			'btn_clr'				=>		'',
			'btn_bg'				=>		'',
			'btn_hvrclr'			=>		'',
			'btn_hvrbg'				=>		'none',
			'css'					=>		'',
			'descsize'				=>		'',
			'use_theme_fonts'		=>		'',
			'google_fonts'			=>		'default',
			'styles'			=>		'',
			'classname' 			=>	'',
		), $atts ) );
		$url = vc_build_link($url);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$some_id = rand(5, 500);
		wp_enqueue_style( 'infobanner-css', plugins_url( '../css/infobanner.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		$googleallfonts = "";
		if($google_fonts != "default"){
			$fontsData = $this->getFontsData( $atts, 'google_fonts' );
			$googleFontsStyles = $this->googleFontsStyles( $fontsData );
			$this->enqueueGoogleFonts( $fontsData );
			if (empty($googleFontsStyles) == false){
				$googleallfonts = esc_attr( implode( ';', $googleFontsStyles ) );
			} else {
				$googleallfonts = $googleFontsStyles;
			}
		}
		ob_start(); ?>
		<div class="maw_infobanner_wrap<?php echo $some_id; ?>">
			<!-- Style1 & 2 info banner -->
			<?php if ($style_visibility == 'left' || $style_visibility == 'right') { ?>
				<div class="mega_info_bar info_bn_box <?php echo $css_class; ?> <?php echo $classname; ?>">		   
					<div class="ribbon">
						<span style="color: <?php echo $ribbon_clr; ?>; background-color: <?php echo $ribbon_bg; ?>">
							<?php echo $ribbon_text; ?>
						</span>
					</div>
					<div class="mega_wrap" style="width: <?php echo $pic_width-2; ?>%; float: <?php echo $style_visibility; ?>; padding: <?php echo $img_padding; ?>;">
						<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="display: block; max-width: 100%; width: <?php echo $pic_size; ?>; height: <?php echo $pic_height; ?>px; border-radius: <?php echo $img_radius; ?>px;">
					</div>

					<div class="mega_content" style="width: <?php echo $content_width-3; ?>%;">
						<div style="padding: <?php echo $text_padding; ?>;">
							<?php echo $content; ?>
							<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" class="mega_hvr_btn maw_banner_btn" style="font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_style; ?>; border-radius: <?php echo $btn_radius; ?>px; padding: <?php echo $btn_ptop/2; ?>px <?php echo $btn_pleft/2; ?>px;">
								<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
							</a>
						</div>

					</div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>


			<!-- Style3 info banner -->
			<?php if ($style_visibility == 'top_to_bottom') { ?>
				<div class="mega_info_bar_2 info_bn_box <?php echo $css_class; ?> <?php echo $classname; ?>">			   
					<div class="ribbon">
						<span style="color: <?php echo $ribbon_clr; ?>; background-color: <?php echo $ribbon_bg; ?>">
							<?php echo $ribbon_text; ?>
						</span>
					</div>
					<div class="mega_wrap" style="padding: <?php echo $img_padding; ?>;">
					<?php if (!empty($image_url)) { ?>
						<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="display: block; max-width: 100%; width: <?php echo $pic_size; ?>; height: <?php echo $pic_height; ?>px; border-radius: <?php echo $img_radius; ?>px;">					
					<?php } ?>
					</div>

					<div class="mega_content" style="padding: <?php echo $text_padding; ?>;">
						<?php echo $content; ?>
						<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" class="mega_hvr_btn maw_banner_btn" style="font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_style; ?>; padding: <?php echo $btn_ptop/2; ?>px <?php echo $btn_pleft/2; ?>px; border-radius: <?php echo $btn_radius; ?>px;">
							<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
						</a>
						<br>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>

			<!-- Style 4 info banner -->
			<?php if ($style_visibility == 'button') { ?>
				<div class="mega_info_bar_3 info_bn_box <?php echo $css_class; ?> <?php echo $classname; ?>" style="display: table; width: 100%;">		   
					<div class="ribbon">
						<span style="color: <?php echo $ribbon_clr; ?>; background-color: <?php echo $ribbon_bg; ?>">
							<?php echo $ribbon_text; ?>
						</span>
					</div>
					<div class="mega_wrap" style="width: 100%; float: left; display: table-cell;">
						<div style="padding: <?php echo $text_padding; ?>;">
							<?php echo $content; ?>
						</div>
					</div>

					<div class="mega_content" style="width: <?php echo $content_width-3; ?>%; display: table-cell; vertical-align: middle;">
						<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>" class="mega_hvr_btn maw_banner_btn" style="font-size: <?php echo $btn_size; ?>px; color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_style; ?>; border-radius: <?php echo $btn_radius; ?>px; padding: <?php echo $btn_ptop/2; ?>px <?php echo $btn_pleft/2; ?>px;">
							<i class="<?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?>
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
		</div>

		<style>
			<?php if ($gradient_bg == 'show') { ?>
				.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box {
					background-image: linear-gradient(<?php echo $gr_angle; ?>deg,<?php echo $gr_primclr; ?> 0%,<?php echo $gr_secndclr; ?> 100%);
				}
			<?php } 
			if ($box_shadow == 'shadow') { ?>
				.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box {
					box-<?php echo $box_shadow ?>: 0 25px 35px 0 rgba(0,9,78,.18) !important;
				}
			<?php }
			if ($btn_shadow == 'shadow') { ?>
				.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box .maw_banner_btn{
					box-<?php echo $btn_shadow ?>: 0 10px 20px 0 rgba(0,9,78,.12) !important;
				}
			<?php }
			if ($img_shadow == 'shadow') { ?>
				.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box img{
					box-<?php echo $img_shadow ?>: 0 10px 20px 0 rgba(0,9,78,.12) !important;
				}
			<?php } ?>
			.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box .maw_banner_btn:hover {
				color: <?php echo $btn_hvrclr; ?> !important;
    			background: <?php echo $btn_hvrbg ?> !important;
			}
			.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box *{
				<?php echo $googleallfonts; ?>;
			}
			@media only screen and (max-width: 480px) {
				.maw_infobanner_wrap<?php echo $some_id; ?> .info_bn_box .mega_content *{
					font-size: <?php echo $descsize; ?>px !important;
				}
			}
		</style>
		
		<?php return ob_get_clean();
	}

	protected function getFontsData( $atts, $paramName ) {
		$googleFontsParam = new Vc_Google_Fonts();
		$field = WPBMap::getParam( $this->shortcode, $paramName );
		$fieldSettings = isset( $field['settings'], $field['settings']['fields'] ) ? $field['settings']['fields'] : array();
		$fontsData = strlen( $atts[ $paramName ] ) > 0 ? $googleFontsParam->_vc_google_fonts_parse_attributes( $fieldSettings, $atts[ $paramName ] ) : '';

		return $fontsData;
	}

	protected function googleFontsStyles( $fontsData ) {
		// Inline styles
		$fontFamily = explode( ':', $fontsData['values']['font_family'] );
		$styles[] = 'font-family:' . $fontFamily[0];
		$fontStyles = explode( ':', $fontsData['values']['font_style'] );
		if(count($fontStyles)>1){
			$styles[] = 'font-weight:' . $fontStyles[1];
			$styles[] = 'font-style:' . $fontStyles[2];
			return $styles;
		} else {
			return "";
		}

	}

	protected function enqueueGoogleFonts( $fontsData ) {
		// Get extra subsets for settings (latin/cyrillic/etc)
		$settings = get_option( 'wpb_js_google_fonts_subsets' );
		if ( is_array( $settings ) && ! empty( $settings ) ) {
			$subsets = '&subset=' . implode( ',', $settings );
		} else {
			$subsets = '';
		}

		// We also need to enqueue font from googleapis
		if ( isset( $fontsData['values']['font_family'] ) ) {
			wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $fontsData['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $fontsData['values']['font_family'] . $subsets );
		}
	}
}


vc_map( array(
	"name" 			=> __( 'Info Banner', 'info-banner-vc' ),
	"base" 			=> "info_banner_vc",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Displays the banner information', 'info-banner-vc'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/infobanner.png',
	'params' => array(
		array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Style', 'info-banner-vc' ),
			"param_name" 	=> 	"style_visibility",
			"description" 	=> 	__( 'select styles for info banner <a href="http://addons.topdigitaltrends.net/info-banner/">See Demo</a>', 'info-banner-vc' ),
			"group" 		=> 	'General',
			"value" 		=>  array(
				'Top Image Bottom Content' =>  'top_to_bottom',
				'Left Image right Content' =>  'left',
				'Left Content right Image' =>  'right',
				'Left Content right Button' =>  'button',
			)
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Picture box width', 'info-banner-vc' ),
			"param_name" 	=> 	"pic_width",
			"description" 	=> 	__( 'Set the width of picture box in percentage e.g 50', 'info-banner-vc' ),
			"dependency" => array('element' => "style_visibility", 'value' => array('left', 'right', 'button')),
			"value"			=>	"50",
			"suffix" 		=> '%',
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Content box width', 'info-banner-vc' ),
			"param_name" 	=> 	"content_width",
			"description" 	=> 	__( 'Set the width of content box in percentage e.g 50', 'info-banner-vc' ),
			"dependency" => array('element' => "style_visibility", 'value' => array('left', 'right', 'button')),
			"value"			=>	"50",
			"suffix" 		=> 	'%',
			"group" 		=> 	'General',
        ),

        array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Shadow', 'button' ),
			"param_name" 	=> "box_shadow",
			"group" 		=> 'General',
			"value"			=>	array(
				"None"			=>		"none",
				"Shadow"		=>		"shadow",
			)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Gradient Background', 'button' ),
			"param_name" 	=> "gradient_bg",
			"description" 	=> 'if true then leave empty background color and image from Design Options.',
			"group" 		=> 'General',
			"value"			=>	array(
				"Hide"			=>		"hide",
				"Show"			=>		"show",
			)
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Primary Color', 'info-banner-vc' ),
			"param_name" 	=> "gr_primclr",
			"edit_field_class" => "vc_col-sm-4",
			"dependency" 	=> array('element' => "gradient_bg", 'value' => 'show'),
			"value" 		=> "#0DDABA",
			"group" 		=> 'General',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Secondary Color', 'info-banner-vc' ),
			"param_name" 	=> "gr_secndclr",
			"edit_field_class" => "vc_col-sm-4",
			"dependency" 	=> array('element' => "gradient_bg", 'value' => 'show'),
			"value" 		=> "#5419D5",
			"group" 		=> 'General',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Gradient Angle', 'info-banner-vc' ),
			"param_name" 	=> "gr_angle",
			"edit_field_class" => "vc_col-sm-4",
			"dependency" 	=> array('element' => "gradient_bg", 'value' => 'show'),
			"suffix" 		=> 'Deg',
			"value" 		=> "40",
			"group" 		=> 'General',
		),

		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Extra Class Name', 'megaaddons' ),
			"param_name" 	=> 	"classname",
			"description" 	=> 	"Style particular content element differently - add a class name and refer to it in custom CSS.",
			"group" 		=> 	'General',
        ),

        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urls",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;">Background Options</span>', 'ihover' ),
			"group" 		=> 'General',
		),

		array(
			"type" 			=> "css_editor",
			"param_name" 	=> "css",
			"group" 		=> 'General',
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'General',
		),

        // Image Section 

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Padding ', 'info-banner-vc' ),
			"param_name" 	=> 	"img_padding",
			"description" 	=> 	__( 'top right bottom left', 'info-banner-vc' ),
			"edit_field_class" => "vc_col-sm-4 edit_field_padding_top",
			"value"			=>	"0px 0px 0px 0px",
			"group" 		=> 	'Image',
        ),

        array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Shadow', 'button' ),
			"param_name" 	=> "img_shadow",
			"edit_field_class" => "vc_col-sm-4 edit_field_padding_top",
			"group" 		=> 'Image',
			"value"			=>	array(
				"None"			=>		"none",
				"Shadow"		=>		"shadow",
			)
		),

		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Border Radius', 'info-banner-vc' ),
			"param_name" 	=> 	"img_radius",
			"edit_field_class" => "vc_col-sm-4 edit_field_padding_top",
			"suffix" 		=> 	'px',
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Banner image', 'info-banner-vc' ),
			"param_name" 	=> 	"image_id",
			"edit_field_class" => "vc_col-sm-4",
			"description" 	=> 	__( 'Select image for banner logo', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"edit_field_class" => "vc_col-sm-8",
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Image width', 'info-banner-vc' ),
			"param_name" 	=> 	"pic_size",
			"description" 	=> 	__( 'set image width e.g 100px or 100%', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Image height', 'info-banner-vc' ),
			"param_name" 	=> 	"pic_height",
			"description" 	=> 	__( 'set image height in pixel e.g 100 or leave blank for default', 'info-banner-vc' ),
			"suffix" 		=> 	'px',
			"group" 		=> 	'Image',
        ),

        /*================== Content Section =================*/

        array(
            "type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Description', 'info-banner-vc' ),
			"param_name" 	=> 	"content",
			"description" 	=> 	__( 'write detail about info banner', 'info-banner-vc' ),
			"group" 		=> 	'Content',
			"value"			=> '<h2>Caption Title</h2><p>caption detail here</p>'
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Padding ', 'info-banner-vc' ),
			"param_name" 	=> 	"text_padding",
			"edit_field_class" => "vc_col-sm-6",
			"description" 	=> 	__( 'top right bottom left', 'info-banner-vc' ),
			"value"			=>	"0px 0px 0px 0px",
			"group" 		=> 	'Content',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Content Size [For Mobile]', 'info-banner-vc' ),
			"param_name" 	=> 	"descsize",
			"edit_field_class" => "vc_col-sm-6",
			"suffix" 		=> 'px',
			"group" 		=> 	'Content',
        ),

        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urlss",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Google Fonts Option</span>', 'ihover' ),
			"group" 		=> 'Content',
		),

        array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Use theme default font family?', 'creativelink' ),
			"param_name" 	=> 	"use_theme_fonts",
			"description" 	=> 	__( 'Use font family from the theme.', 'creativelink' ),
			"group" 		=> 	'Content',
			"value" 		=> array(
					"Yes"		=> "yes",
			)
		),

		array(
			'type' => 'google_fonts',
			'param_name' => 'google_fonts',
			'value' => 'default',
			'settings' => array(
				'fields' => array(
					'font_family_description' => __( 'Select font family.', 'js_composer' ),
					'font_style_description' => __( 'Select font styling.', 'js_composer' ),
				),
			),
			"group" 		=> 	'Content',
			'weight' => 0,
			'dependency' => array(
				'element' => 'use_theme_fonts',
				'value_not_equal_to' => 'yes',
			),
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
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Button Height', 'info-banner-vc' ),
			"param_name" 	=> "btn_ptop",
			"description" 	=> __( 'button height. set in pixel e.g 20', 'info-banner-vc' ),
			"value"			=>	"20",
			"suffix" 		=> 'px',
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Button Width', 'info-banner-vc' ),
			"param_name" 	=> "btn_pleft",
			"description" 	=> __( 'button width. set in pixel e.g 60', 'info-banner-vc' ),
			"value"			=>	"60",
			"suffix" 		=> 'px',
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Text font size', 'info-banner-vc' ),
			"param_name" 	=> "btn_size",
			"description" 	=> __( 'Set font size in pixel e.g 18', 'info-banner-vc' ),
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 'Button',
		),
		array(
			"type" 			=> "vc_link",
			"heading" 		=> __( 'Button URL', 'info-banner-vc' ),
			"param_name" 	=> "url",
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
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border Radius', 'info-banner-vc' ),
			"param_name" 	=> "btn_radius",
			"value"			=>	"5",
			"suffix" 		=> 'px',
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Shadow', 'button' ),
			"param_name" 	=> "btn_shadow",
			"group" 		=> 'Button',
			"value"			=>	array(
				"None"			=>		"none",
				"Shadow"		=>		"shadow",
			)
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Text color', 'info-banner-vc' ),
			"param_name" 	=> "btn_clr",
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'info-banner-vc' ),
			"param_name" 	=> "btn_bg",
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Text color', 'info-banner-vc' ),
			"param_name" 	=> "btn_hvrclr",
			"group" 		=> 'Button',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Background', 'info-banner-vc' ),
			"param_name" 	=> "btn_hvrbg",
			"group" 		=> 'Button',
		),
	),
) );

