<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_timeline_son extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'date'		=>	'',
			'clr'		=>	'',
			'size'		=>	'',
			'centerstyle'		=>	'fonticon',
			'bgclr'		=>	'',
			'arrowclr'	=>	'',
			'icon'		=>	'',
			'icon_size'	=>	'',
			'css'		=>	'',
		), $atts ) );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
				<div class="cd-timeline-block">
					<?php if ($centerstyle == 'fonticon') { ?>
						<div class="cd-timeline-img cd-picture" style="background: <?php echo $bgclr; ?>; border-radius: 50%; text-align:center;">
							<i class="<?php echo $icon; ?>" aria-hidden="true" style="font-size: <?php echo $icon_size; ?>; color: #fff;vertical-align: middle;"></i>
						</div>	
					<?php } ?>

					<?php if ($centerstyle == 'dot') { ?>
						<div class="cd-timeline-img cd-timeline-dot cd-picture" style="background: <?php echo $bgclr; ?>; border-radius: 50%;">
						</div>	
					<?php } ?>

					<div class="cd-timeline-content <?php echo $css_class; ?>">
						<span class="timeline-arrow" style="border-right-color: <?php echo $arrowclr; ?>"></span>
						<span class="timeline-arrow" style="border-left-color: <?php echo $arrowclr; ?>"></span>
						<span class="timeline-arrow" style="border-right: 7px solid <?php echo $arrowclr; ?>;"></span>

						<?php echo $content; ?>
						<span class="cd-date" style="color: <?php echo $clr; ?>; font-size: <?php echo $size; ?>;">
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
			"description" 	=> 	__( 'Write timeline date e.g Jan 15', 'timeline' ),
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
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Font size', 'timeline' ),
			"param_name" 	=> 	"size",
			"description" 	=> 	__( 'fone size of date in pixel e.g 17px', 'timeline' ),
			"group" 		=> 	'General',
        ),

        array(
            "type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Content Details', 'timeline' ),
			"param_name" 	=> 	"content",
			"description" 	=> 	__( 'Add heading, details, pictures or video url', 'timeline' ),
			"value"			=> '<h3><b>Title of section</b></h3><p>Details here</p> <a href="#0" class="cd-read-more" >Read more</a>',
			"group" 		=> 	'Content',
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
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background', 'timeline' ),
			"param_name" 	=> 	"bgclr",
			"description" 	=> 	__( 'Center dot background color', 'timeline' ),
			"group" 		=> 	'Timeline Center',
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
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Font size', 'timeline' ),
			"param_name" 	=> 	"icon_size",
			"description" 	=> 	__( 'Icon font size e.g 17px', 'timeline' ),
			"dependency" => array('element' => "centerstyle", 'value' => 'fonticon'),
			"group" 		=> 	'Timeline Center',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Arrow Color', 'timeline' ),
			"param_name" 	=> 	"arrowclr",
			"description" 	=> 	__( 'set timeline arrow color', 'timeline' ),
			"group" 		=> 	'Design Option',
        ),
        
        array(
            "type" 			=> 	"css_editor",
			"heading" 		=> 	__( 'Styles', 'timeline' ),
			"param_name" 	=> 	"css",
			"group" 		=> 	'Design Option',
        ),
	)
) );
