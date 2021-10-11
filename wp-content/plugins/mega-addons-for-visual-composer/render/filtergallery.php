<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_filter_gallery_son extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'controlname'	=>	'',
			'image_id'		=>	'',
			'caption_bg'	=>	'rgba(29,161,245,0.7)',
			'caption_url'	=>	'',
			'popup'			=>	'disable',
			'caption_in_popup'	=>	'caption',
			'icon_width'	=>	'',
			'icon_border'	=>	'30',
			'icon_size'		=>	'20',
			'iconclr'		=>	'#fff',
			'iconbg'		=>	'transparent',
			'icon_margin'	=>	'7',
			'css'			=>	'',
		), $atts ) );
		$caption_url = vc_build_link($caption_url);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$content = wpb_js_remove_wpautop($content, true);
		ob_start();
		global $maw_filtergal_effect; global $maw_filtergal_linkicon; global $maw_filtergal_popupicon; global $maw_filtergal_imgheight; global $maw_filtergal_Gid;
		?>

		<?php $controlremovespace = str_replace(' ', '', $controlname); ?>
    	<div class="mix maw-fg-<?php echo $controlremovespace; ?> mix-<?php echo $maw_filtergal_Gid ?>">
    		<div class="maw_portfolioGallery_ihe">
	        	<div class="<?php echo $maw_filtergal_effect ?> <?php echo $css_class; ?>" style="height: <?php echo $maw_filtergal_imgheight; ?>px;">
				    <div class="a-tag">
				      <div class="img" style="display: flex;">
				      	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_url; ?>" style="height: <?php echo $maw_filtergal_imgheight; ?>px; max-width: 100%;">
				      </div>
				      <div class="info" style="background-color: <?php echo $caption_bg ?>;">
					    <div style="display:table;width:100%;height:100%;">
				    		<div style="display: table-cell !important;vertical-align: middle !important;">
				      			<?php echo $content; ?>
								<?php if ($popup == 'image') { ?>
									<a href="<?php echo $image_url; ?>" class="ihe-fancybox" data-fancybox="images" data-<?php echo $caption_in_popup; ?>="<?php echo wp_strip_all_tags ($content); ?>" style="margin-right: <?php echo $icon_margin ?>px;">
				      					<i class="<?php echo $maw_filtergal_popupicon; ?> portfolio_icon" style="width: <?php echo $icon_width ?>px; height: <?php echo $icon_width ?>px; line-height: <?php echo $icon_width ?>px; border-radius: <?php echo $icon_border ?>px;  color: <?php echo $iconclr ?>; background: <?php echo $iconbg ?>; font-size: <?php echo $icon_size; ?>px;"></i>
									</a>
								<?php } ?>
				      			
				      			<?php if (isset($caption_url['url']) && $caption_url['url'] != '') { ?>
				      				<a href="<?php echo esc_url($caption_url['url']); ?>" target="<?php echo $caption_url['target']; ?>" title="<?php echo esc_html($caption_url['title']); ?>">
				      					<i class="<?php echo $maw_filtergal_linkicon; ?> portfolio_icon" style="width: <?php echo $icon_width ?>px; height: <?php echo $icon_width ?>px; line-height: <?php echo $icon_width ?>px; border-radius: <?php echo $icon_border ?>px;  color: <?php echo $iconclr ?>; background: <?php echo $iconbg ?>; font-size: <?php echo $icon_size; ?>px;"></i>
				      				</a>
				      			<?php } ?>
				      		</div>
				      	</div>
				      </div>
				    </div>
				</div>
        	</div>
        </div>
			

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "filter_gallery_son",
	"name" 			=> __( 'Gallery List', 'megaaddons' ),
	"as_child" 		=> array('only' => 'filter_gallery_wrap'),
	"content_element" => true,
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('List Items', 'megaaddons'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/filtergallery.png',
	'params' => array(
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Control Name', 'megaaddons' ),
			"param_name" 	=> "controlname",
			'admin_label' 	=> 	true,
			"description" 	=> __( 'Use the gallery control name from Filterable Settings. Separate multiple items with comma (e.g. tech, innovation, web design)', 'megaaddons' ),
			"value"			=>	"Gallery",
			"group" 		=> 'Gallery Items',
		),
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Image', 'megaaddons' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'megaaddons' ),
			"group" 		=> 	'Gallery Items',
        ),

        array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Caption Background', 'megaaddons' ),
			"param_name" 	=> "caption_bg",
			"value"			=>	"rgba(29,161,245,0.7)",
			"group" 		=> 'Gallery Items',
		),

        array(
			"type" 			=> "textarea_html",
			"heading" 		=> __( 'Caption Text', 'megaaddons' ),
			"param_name" 	=> "content",
			"description" 	=> __( 'Provide Caption Here', 'megaaddons' ),
			"group" 		=> 'Gallery Items',
			"value"			=> '<h2>Caption Text Here</h2>'
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urls",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Link Settings</span>', 'megaaddons' ),
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "vc_link",
			"heading" 		=> __( 'Link To', 'megaaddons' ),
			"param_name" 	=> "caption_url",
			"description" 	=> __( 'Enter URL to link caption', 'megaaddons' ),
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Lightbox Button', 'megaaddons' ),
			"param_name" 	=> "popup",
			"group" 		=> 'Gallery Items',
			"value" 		=> array(
				'Disable'				=>	'disable',
				'LightBox'				=>	'image',
				'Video Gallery [Pro Option]'			=>	'',
			)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Caption Text In Popup', 'megaaddons' ),
			"param_name" 	=> "caption_in_popup",
			"dependency" 	=> array('element' => "popup", 'value' => 'image'),
			"group" 		=> 'Gallery Items',
			"value" 		=> array(
				'Show'			=>	'caption',
				'Hide'			=>	'hide',
			)
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urls",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Icon Settings</span>', 'megaaddons' ),
			"group" 		=> 'Gallery Items',
		),


		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Width/Height', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "icon_width",
			"value"			=>	"50",
			"suffix"			=>	"px",
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border Radius', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "icon_border",
			"value"			=>	"30",
			"suffix"			=>	"px",
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Icon [Font Size]', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "icon_size",
			"value"			=>	"20",
			"suffix"			=>	"px",
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Icon Color', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "iconclr",
			"value"			=>	"#fff",
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Icon Background', 'megaaddons' ),
			"param_name" 	=> "iconbg",
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"value"			=>	"#ff622a",
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Icon Margin', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "icon_margin",
			"value"			=>	"7",
			"suffix"			=>	"px",
			"group" 		=> 'Gallery Items',
		),

		array(
			"type" 			=> 	"css_editor",
			"heading" 		=> 	__( 'Border Settings', 'infobox' ),
			"param_name" 	=> 	"css",
			"group" 		=>  'Border Settings',
		),
	),
) );
