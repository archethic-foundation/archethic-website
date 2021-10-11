<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_timeline_son extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'date'			=>	'',
			'clr'			=>	'',
			'size'			=>	'',
			'centerstyle'	=>	'fonticon',
			'bgclr'			=>	'',
			'maintitle'		=>	'',
			'titlealign'	=>	'left',
			'titlepadding'	=>	'10',
			'titlesize'		=>	'',
			'titleclr'		=>	'',
			'titlebg'		=>	'',
			'image_id'		=>	'',
			'img_width'		=>	'',
			'icon'			=>	'',
			'icon_size'		=>	'',
			'css'			=>	'',
		), $atts ) );
		if ($image_id != '') { $image_url = wp_get_attachment_url( $image_id ); }
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
		<div class="cd-timeline-block">
			<?php if ($centerstyle == 'fonticon') { ?>
				<div class="cd-timeline-img cd-picture" style="background: <?php echo $bgclr; ?>; border-radius: 50%; text-align:center;">
					<i class="<?php echo $icon; ?>" aria-hidden="true" style="font-size: <?php echo $icon_size; ?>px; color: #fff;vertical-align: middle;"></i>
				</div>	
			<?php } ?>

			<?php if ($centerstyle == 'dot') { ?>
				<div class="cd-timeline-img cd-timeline-dot cd-picture" style="background: <?php echo $bgclr; ?>; border-radius: 50%;">
				</div>	
			<?php } ?>

			<div class="cd-timeline-content <?php echo $css_class; ?>">
				<span class="timeline-arrow" style="border-right-color: <?php echo $titlebg; ?>"></span>
				<span class="timeline-arrow" style="border-left-color: <?php echo $titlebg; ?>"></span>
				<span class="timeline-arrow" style="border-right: 7px solid <?php echo $titlebg; ?>;"></span>

				<h2 style="background: <?php echo $titlebg; ?>; color: <?php echo $titleclr; ?>; font-size: <?php echo $titlesize; ?>px; text-align: <?php echo $titlealign; ?>; padding: <?php echo $titlepadding ?>px 15px;">
					<?php echo $maintitle; ?>
				</h2>
				<?php if (isset($image_url)) { ?>
					<img src="<?php echo $image_url; ?>" style="max-width: 100%; width: <?php echo $img_width; ?>px">
				<?php } ?>
				<div class="cd-timeline-content-area" style="padding: 0 10px; display: block;">
					<?php echo $content; ?>
				</div>
				<span class="cd-date" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>px;">
					<?php echo $date ?>
				</span>
			</div>
		</div>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Timeline', 'timeline' ),
	"base" 			=> "mvc_timeline_son",
	"as_child" 	=> array('only' => 'mvc_timeline_father'),
	"content_element" => true,
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Add multiple images and text', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/timeline.png',
	'params' => array(
		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Date', 'timeline' ),
			"param_name" 	=> 	"date",
			"description" 	=> 	__( 'Write timeline date e.g Jan 15 <a target="_blank" href="https://addons.topdigitaltrends.net/timeline/">See Demo</a>', 'timeline' ),
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Color', 'timeline' ),
			"param_name" 	=> 	"clr",
			"description" 	=> 	__( 'color of the date', 'timeline' ),
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font size', 'timeline' ),
			"param_name" 	=> 	"size",
			"description" 	=> 	__( 'fone size of date in pixel e.g 17', 'timeline' ),
			"suffix" 		=> 'px',
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
			"heading" 		=> __( 'Select style', 'timeline' ),
			"param_name" 	=> "centerstyle",
			"description" 	=> __( 'style for center', 'timeline' ),
			"group" 		=> 'Timeline Center',
				"value" 		=> array(
					'Center With Font Icon'	=>	'fonticon',
					'Only Dot'	=>	'dot',
				)
			),

        array(
            "type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Font Icon', 'timeline' ),
			"param_name" 	=> 	"icon",
			"description" 	=> 	__( 'choose font awesome or leave blank', 'timeline' ),
			"dependency" => array('element' => "centerstyle", 'value' => 'fonticon'),
			"group" 		=> 	'Timeline Center',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background', 'timeline' ),
			"param_name" 	=> 	"bgclr",
			"description" 	=> 	__( 'Center dot background color', 'timeline' ),
			"group" 		=> 	'Timeline Center',
        ),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font size', 'timeline' ),
			"param_name" 	=> 	"icon_size",
			"description" 	=> 	__( 'Icon font size e.g 17', 'timeline' ),
			"dependency" => array('element' => "centerstyle", 'value' => 'fonticon'),
			"suffix" 		=> 'px',
			"group" 		=> 	'Timeline Center',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title', 'timeline' ),
			"param_name" 	=> 	"maintitle",
			"value"			=>	"Timeline Title",
			"group" 		=> 	'Content',
        ),

        array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Title Align', 'timeline' ),
			"param_name" 	=> "titlealign",
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"group" 		=> 'Content',
			"value" 		=> 	array(
				'Left'			=>		'left',
				'Center'		=>		'center',
				'Right'			=>		'right',
			)
		),

        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Title size', 'timeline' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"titlesize",
			"suffix" 		=> 'px',
			"group" 		=> 	'Content',
        ),

		array(
            "type" 				=> 	"vc_number",
			"heading" 			=> 	__( 'Padding [Top - Bottom]', 'timeline' ),
			"edit_field_class" 	=> "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 		=> 	"titlepadding",
			"value" 			=> '10',
			"suffix" 			=> 'px',
			"group" 			=> 	'Content',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'timeline' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"titleclr",
			"group" 		=> 	'Content',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Background', 'timeline' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> 	"titlebg",
			"group" 		=> 	'Content',
        ),

        array(
			"type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Select Image', 'timeline' ),
			"param_name" 	=> 	"image_id",
			"group" 		=> 	'Content',
		),

		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Image Width', 'timeline' ),
			"param_name" 	=> 	"img_width",
			"suffix" 		=> 'px',
			"group" 		=> 	'Content',
        ),

        array(
            "type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Content Details', 'timeline' ),
			"param_name" 	=> 	"content",
			"description" 	=> 	__( 'Add heading, details, pictures or video url', 'timeline' ),
			"group" 		=> 	'Content',
        ),

        
        array(
            "type" 			=> 	"css_editor",
			"heading" 		=> 	__( 'Styles', 'timeline' ),
			"param_name" 	=> 	"css",
			"group" 		=> 	'Design Option',
        ),
	)
) );
