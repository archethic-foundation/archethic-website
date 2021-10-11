<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_vc_headings extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'			=>		'theme1',
			'style2'		=>		'icon',
			'linewidth'		=>		'230',
			'borderwidth'	=>		'2',
			'borderclr'		=>		'#000',
			'lineheight'	=>		'1',
			'icon'			=>		'',
			'iconalign'		=>		'center',
			'iconclr'		=>		'#000',
			'image_id'		=>		'',
			'align'			=>		'center',
			'title'			=>		'',
			'titlesize'		=>		'22',
			'titleclr'		=>		'#000',
			'desc_size'		=>		'',
			'use_theme_fonts' =>		'',
			'google_fonts' 	=>		'default',
			'transform' 	=>		'default',
			'classname' 	=>		'',
		), $atts ) );
		$some_id = rand(5, 500);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$content = wpb_js_remove_wpautop($content, true);
		wp_enqueue_style( 'vc-heading-css', plugins_url( '../css/heading.css' , __FILE__ ));
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
		<div class="mega-line-container ma_heading_wrap<?php echo $some_id ?> <?php echo $classname; ?>">
			<?php if ($style == 'theme1') { ?>
				<div class="mega-line-top" style="text-align: <?php echo $align; ?>;">  
			        <span style="width: <?php echo $linewidth; ?>px; border-top: <?php echo $borderwidth; ?>px solid <?php echo $borderclr; ?>;"></span>
			        <h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; line-height: <?php echo $lineheight; ?>;
			        text-transform: <?php echo $transform ?>; <?php echo $googleallfonts; ?>;">
			        	<?php echo $title; ?>
			        </h2>
			        <div class="heading_desc">
			        	<?php echo $content ?>
			        </div>
		      	</div>
			<?php } ?>

			<?php if ($style == 'theme2') { ?>
			    <div class="mega-line-center" style="text-align: <?php echo $align; ?>;">  
		        	<h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; text-transform: <?php echo $transform ?>; <?php echo $googleallfonts; ?>;">
			        	<?php echo $title; ?>
			        </h2>
			        <div style="line-height: <?php echo $lineheight; ?>;">
		        		<span style="width: <?php echo $linewidth; ?>px; border-top: <?php echo $borderwidth; ?>px solid <?php echo $borderclr; ?>;"></span>
		        	</div>
		        	<div class="heading_desc">
			        	<?php echo $content ?>
			        </div>
		      	</div>
		    <?php } ?>

		    <?php if ($style == 'theme3') { ?>
			    <div class="mega-line-bottom" style="text-align: <?php echo $align; ?>;">  
			        <h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; text-transform: <?php echo $transform ?>; <?php echo $googleallfonts; ?>;">
			        	<?php echo $title; ?>
			        </h2>
			        <div class="heading_desc" style="line-height: <?php echo $lineheight; ?>;">
			        	<?php echo $content ?>
			        </div>
			        <span style="width: <?php echo $linewidth; ?>px; border-top: <?php echo $borderwidth; ?>px solid <?php echo $borderclr; ?>;"></span>
			    </div>
		    <?php } ?>

		    <?php if ($style == 'theme4') { ?>
		        
			    <div class="mega-line-icon" style="text-align: <?php echo $align; ?>;">  
			        <div class="line-icon" style="text-align: <?php echo $iconalign; ?>; width: <?php echo $linewidth; ?>px; border-top: <?php echo $borderwidth; ?>px solid <?php echo $borderclr; ?>;">
		        		<?php if ($style2 == 'icon') { ?>
		        			<i class="<?php echo $icon; ?>" aria-hidden="true" style="color: <?php echo $iconclr; ?>"></i>
		        		<?php } ?>
		        		<?php if ($style2 == 'image') { ?>
		        		<img src="<?php echo $image_url; ?>">
		        	<?php } ?>
		        	</div>
			        <h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; line-height: <?php echo $lineheight; ?>; margin-bottom: -15px; text-transform: <?php echo $transform ?>; <?php echo $googleallfonts; ?>;">
			        	<?php echo $title; ?>
			        </h2>
			        <div class="heading_desc">
			        	<?php echo $content ?>
			        </div>
			    </div>
		    <?php } ?>

		    <?php if ($style == 'theme5') { ?>
			    <div class="mega-line-icon" style="text-align: <?php echo $align; ?>;">  
			        <h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; text-transform: <?php echo $transform ?>; <?php echo $googleallfonts; ?>;">
			        	<?php echo $title; ?>
			        </h2>
			        <div style="line-height: <?php echo $lineheight; ?>;">
				        <div class="line-icon" style="text-align: <?php echo $iconalign; ?>; width: <?php echo $linewidth; ?>px; border-top: <?php echo $borderwidth; ?>px solid <?php echo $borderclr; ?>;">
				        	<?php if ($style2 == 'icon') { ?>
				        		<i class="<?php echo $icon; ?>" aria-hidden="true" style="color: <?php echo $iconclr; ?>"></i>
				        	<?php } ?>
				        	<?php if ($style2 == 'image') { ?>
				        		<img src="<?php echo $image_url; ?>">
				        	<?php } ?>
				        </div>
			        </div>
			        <div class="heading_desc">
			        	<?php echo $content ?>
			        </div>
			    </div>
		    <?php } ?>

		    <?php if ($style == 'theme6') { ?>
				<div class="mega-line-icon" style="text-align: <?php echo $align; ?>;">  
			        <h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $titleclr; ?>; text-transform: <?php echo $transform ?>; <?php echo $googleallfonts; ?>;">
			        	<?php echo $title; ?>
			        </h2>
			        <div class="heading_desc" style="line-height: <?php echo $lineheight; ?>;">
			        	<?php echo $content ?>
			        </div>
			        <div class="line-icon" style="text-align: <?php echo $iconalign; ?>; width: <?php echo $linewidth; ?>px; border-top: <?php echo $borderwidth; ?>px solid <?php echo $borderclr; ?>;">
			        	<?php if ($style2 == 'icon') { ?>
			        		<i class="<?php echo $icon; ?>" aria-hidden="true" style="color: <?php echo $iconclr; ?>"></i>
			        	<?php } ?>
			        	<?php if ($style2 == 'image') { ?>
			        		<img src="<?php echo $image_url; ?>">
			        	<?php } ?>
			        </div>
			    </div>
		    <?php } ?>
      	</div>

      	<style>
			.ma_heading_wrap<?php echo $some_id ?> .heading_desc *{
				font-size: <?php echo $desc_size; ?>px;
				<?php echo $googleallfonts; ?>;
			}
      	</style>
		<?php
		return ob_get_clean();
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
	"name" 			=> __( 'Heading', 'heading' ),
	"base" 			=> "vc_headings",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Display stylish headings', 'heading'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/heading.png',
	'params' => array(
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Select Style', 'heading' ),
			"param_name" 	=> "style",
			"description" 	=> 'click to <a href="https://addons.topdigitaltrends.net/headings/" target="_blank">See Demo</a>',
			"group" 		=> "General",
			"value"			=>	array(
				"Simple Top Line"		=>	"theme1",
				"Simple Center Line"	=>	"theme2",
				"Simple Bottom Line"	=>	"theme3",
				"Top Icon/Image"		=>	"theme4",
				"Center Icon/Image"		=>	"theme5",
				"Bottom Icon/Image"		=>	"theme6",
			)
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Line length', 'heading' ),
			"param_name" 	=> "linewidth",
			"edit_field_class" => "vc_col-sm-4",
			"suffix" 		=> 	'px',
			"value"			=>	"230",
			'max' 			=> 	"",
			"group" 		=> 	"General",
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border Width', 'heading' ),
			"param_name" 	=> "borderwidth",
			"edit_field_class" => "vc_col-sm-4",
			"value"			=>	"2",
			"suffix" 		=> 'px',
			"group" 		=> "General",
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Border Color', 'heading' ),
			"param_name" 	=> "borderclr",
			"edit_field_class" => "vc_col-sm-4",
			"value"			=>	"#000",
			"group" 		=> "General",
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Seclect Icon/Image', 'heading' ),
			"param_name" 	=> "style2",
			"dependency" => array('element' => "style", 'value' => array('theme4', 'theme5', 'theme6')),
			"group" 		=> "General",
			"value"			=>	array(
				"Icon"			=>	"icon",
				"Image"			=>	"image",
			)
		),

		// Image/Icon Section

		array(
			"type" 			=> "iconpicker",
			"heading" 		=> __( 'Choose Icon', 'heading' ),
			"param_name" 	=> "icon",
			"dependency" => array('element' => "style2", 'value' => 'icon'),
			"group" 		=> "General",
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Icon Alignment', 'heading' ),
			"param_name" 	=> "iconalign",
			"dependency" => array('element' => "style2", 'value' => 'icon'),
			"group" 		=> "General",
			"value"			=>	array(
				"Center"	=>		"center",
				"Left"		=>		"left",
				"Right"		=>		"right",
			)
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Color for Icon', 'heading' ),
			"param_name" 	=> "iconclr",
			"dependency" => array('element' => "style2", 'value' => 'icon'),
			"group" 		=> "General",
		),

		array(
			"type" 			=> "attach_image",
			"heading" 		=> __( 'Choose Image', 'heading' ),
			"param_name" 	=> "image_id",
			"dependency" => array('element' => "style2", 'value' => 'image'),
			"group" 		=> "General",
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
			"description" 	=> __( '<span style="Background: #ddd;padding: 12px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'General',
		),

		// Heading Section

		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Title', 'heading' ),
			"param_name" 	=> "title",
			"value"			=>	"Title Here",
			"group" 		=> "Heading",
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Heading Alignment', 'heading' ),
			"param_name" 	=> "align",
			"group" 		=> "Heading",
			"value"			=>	array(
				"Center"	=>		"center",
				"Left"		=>		"left",
				"Right"		=>		"right",
			)
		),

		array(
			"type" 			=> "textarea_html",
			"heading" 		=> __( 'Description', 'heading' ),
			"param_name" 	=> "content",
			"value"			=>	"write your detail or leave blank",
			"group" 		=> "Heading",
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urls",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Google Fonts Option</span>', 'ihover' ),
			"group" 		=> 'Typography',
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Use theme default font family?', 'creativelink' ),
			"param_name" 	=> 	"use_theme_fonts",
			"description" 	=> 	__( 'Use font family from the theme.', 'creativelink' ),
			"group" 		=> 	'Typography',
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
			"group" 		=> 	'Typography',
			'weight' => 0,
			'dependency' => array(
				'element' => 'use_theme_fonts',
				'value_not_equal_to' => 'yes',
			),
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urlss",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Title Settings</span>', 'ihover' ),
			"group" 		=> 'Typography',
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

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Line Height', 'heading' ),
			"param_name" 	=> "lineheight",
			"edit_field_class" => "vc_col-sm-6",
			"description" 	=> __('margin between line and headings', 'heading'),
			"value"			=>	"1",
			"group" 		=> "Typography",
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Title [Font Size]', 'heading' ),
			"param_name" 	=> "titlesize",
			"edit_field_class" => "vc_col-sm-6",
			"value"			=>	"22",
			"suffix" 		=> 'px',
			"group" 		=> "Typography",
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Title Color', 'heading' ),
			"param_name" 	=> "titleclr",
			"value"			=>	"#000",
			"group" 		=> "Typography",
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urldesc",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Description Settings</span>', 'ihover' ),
			"group" 		=> 'Typography',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Description [Font Size]', 'ihover' ),
			"param_name" 	=> "desc_size",
			"suffix" 		=> 'px',
			"group" 		=> 'Typography',
		),
	),
) );

