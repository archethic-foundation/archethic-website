<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_modal_popup_box extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'animation'		=>		'Default',
			'top'			=>		'60',
			'width'			=>		'600',
			'bodybg'		=>		'#1a94ad',
			'btn_animation'	=>		'hvr-fade',
			'btnalign'		=>		'left',
			'btntext'		=>		'',
			'btntext2'		=>		'',
			'btnsize'		=>		'18',
			'leftpadding'	=>		'20',
			'toppadding'	=>		'5',
			'btn_border'	=>		'#269CE9',
			'border_width'	=>		'0',
			'btnradius'		=>		'3',
			'btnclr'		=>		'',
			'hoverclr'		=>		'',
			'btnbg'			=>		'',
			'btn_icon' 		=> 		'',
			'hoverbg'		=>		'',
			'titlealign'	=>		'left',
			'titletext'		=>		'Image Gallery',
			'titlesize'		=>		'20',
			'titleline'		=>		'2',
			'titleclr'		=>		'',
			'titlebg'		=>		'',
			'titleborder'	=>		'',
			'bgclr'			=>		'#ececec',
			'contentpad'	=>		'15',
			'contentpad2'	=>		'15',
		), $atts ) );
		$some_id = rand(5, 500);
		wp_enqueue_style( 'animate-css', plugins_url( '../css/animate.css' , __FILE__ ));
		wp_enqueue_style( 'modal-popup-btn', plugins_url( '../css/modal-popup-btn.css' , __FILE__ ));
		wp_enqueue_script( 'bpopup-js', plugins_url( '../js/bpopup.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		<!-- HTML DESIGN HERE -->
		<div class="maw__modal_popup_box" data-bodybg="<?php echo $bodybg; ?>" style="justify-content: <?php echo $btnalign; ?>; display: flex;">
			<?php if ($btn_animation == 'button--winona' || $btn_animation == 'hvr-fade') { ?>
				<button class="mega-uae-btn model-popup-btn popup-<?php echo $some_id; ?> <?php echo $btn_animation; ?>" data-id="popup-<?php echo $some_id; ?>" style="color: <?php echo $btnclr; ?>;background: <?php echo $btnbg; ?> ; border: <?php echo $border_width; ?>px solid <?php echo $btn_border ?>; border-radius: <?php echo $btnradius; ?>px; font-size: <?php echo $btnsize; ?>px; padding: <?php echo $toppadding; ?>px <?php echo $leftpadding; ?>px;" data-text=""> 
					<span><i style="padding-right: 5px;" class="fa <?php echo $btn_icon; ?>"> </i> <?php echo $btntext; ?></span>			
					<span style="background: <?php echo $hoverbg; ?>; padding: <?php echo $toppadding; ?>px 0; color: <?php echo $hoverclr; ?>;" class="modal-popup-after"><?php echo $btntext2; ?></span>
				</button>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if ($btn_animation == 'button--rayen' || $btn_animation == 'button--moema' || $btn_animation == 'button--ujarak') { ?>
				<button class="mega-uae-btn model-popup-btn popup-<?php echo $some_id; ?> <?php echo $btn_animation; ?>" data-id="popup-<?php echo $some_id; ?>" style="color: <?php echo $btnclr; ?>;background: <?php echo $btnbg; ?> ; border: <?php echo $border_width; ?>px solid <?php echo $btn_border ?>; border-radius: <?php echo $btnradius; ?>px; font-size: <?php echo $btnsize; ?>px; padding: <?php echo $toppadding; ?>px <?php echo $leftpadding; ?>px;" data-text=""> 
					<span style="background: <?php echo $hoverbg; ?>; padding: <?php echo $toppadding; ?>px 0; color: <?php echo $hoverclr; ?>;" class="modal-popup-before"><?php echo $btntext2; ?></span>
					<span><i style="padding-right: 5px;" class="fa <?php echo $btn_icon; ?>"> </i> <?php echo $btntext; ?></span>			
				</button>
				<div style="clear: both;"></div>
			<?php } ?>

			<div class="mega-model-popup <?php echo $animation; ?> animated" id="popup-<?php echo $some_id; ?>" style="position:fixed;display: none; margin-top: <?php echo $top; ?>px; width: 95%;max-width: <?php echo $width; ?>px; background: <?php echo $bgclr; ?>;">
				<span class="b-close"><span><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/cross.png"></span></span>
			    <div class="model-popup-container">
			    	<h2 style="border-bottom: 1px solid <?php echo $titleborder; ?>; text-align: <?php echo $titlealign; ?>; font-size: <?php echo $titlesize; ?>px; line-height: <?php echo $titleline; ?>; color: <?php echo $titleclr; ?>; background: <?php echo $titlebg; ?>; margin: 0px; padding: 0px 20px;">
			    		<?php echo $titletext; ?>
			    	</h2>
			      <span style="padding: <?php echo $contentpad ?>px <?php echo $contentpad2; ?>px; display: block;">
			      	<?php echo $content; ?>
			      </span>
			    </div>
			</div>
		</div>
		<style>
			.maw__modal_popup_box .popup-<?php echo $some_id; ?>:hover {
				background: <?php echo $hoverbg; ?> !important;
				color: <?php echo $hoverclr; ?> !important;
			}

		</style>
        <!-- HTML END DESIGN HERE -->
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Modal Popup', 'modal_popup' ),
	"base" 			=> "modal_popup_box",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Add modal box in your content', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/popup.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Animation Effect', 'modal_popup' ),
			"param_name" 	=> 	"animation",
			"description" 	=> 	__( 'animation style on visible <a href="https://addons.topdigitaltrends.net/modal-popup/" target="_blank">See Demo</a>', 'modal_popup' ),
			"group" 		=> 	'General',
			"value"			=>	array(
				"Default"		=>	"Default",
				"bounce"		=>	"bounce",
				"bounceIn"		=>	"bounceIn",
				"rubberBand"	=>	"rubberBand",
				"shake"			=>	"shake",
				"swing"			=>	"swing",
				"bounceInDown"	=>	"bounceInDown",
				"bounceInLeft"	=>	"bounceInLeft",
				"bounceInRight"	=>	"bounceInRight",
				"bounceInUp"	=>	"bounceInUp",
				"fadeInLeft"	=>	"fadeInLeft",
				"fadeInRight"	=>	"fadeInRight",
				"fadeInDown"	=>	"fadeInDown",
				"flash"			=>	"flash",
				"pulse"			=>	"pulse",
				"tada"			=>	"tada",
				"wobble"		=>	"wobble",
				"flip"			=>	"flip",
				"flipInX"		=>	"flipInX",
				"flipInY"		=>	"flipInY",
				"lightSpeedIn"	=>	"lightSpeedIn",
				"rotateIn"		=>	"rotateIn",
				"rotateInDownLeft"	=>	"rotateInDownLeft",
				"rotateInDownRight"	=>	"rotateInDownRight",
				"rotateInUpLeft"	=>	"rotateInUpLeft",
				"rotateInUpRight"	=>	"rotateInUpRight",
				"slideInUp"		=>	"slideInUp",
				"slideInDown"	=>	"slideInDown",
				"slideInRight"	=>	"slideInRight",
				"zoomIn"	=>	"zoomIn",
				"zoomInDown"	=>	"zoomInDown",
				"zoomInLeft"	=>	"zoomInLeft",
				"zoomInRight"	=>	"zoomInRight",
				"zoomInUp"		=>	"zoomInUp",
				"rollIn"		=>	"rollIn",
			)
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Top', 'modal_popup' ),
			"param_name" 	=> 	"top",
			"description" 	=> 	__( 'Popup position from top', 'modal_popup' ),
			"value" 		=> __( "60", "modal_popup" ),
			"suffix" 		=> 'px',
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Popup Width', 'modal_popup' ),
			"param_name" 	=> 	"width",
			"description" 	=> 	__( 'set in pixel', 'modal_popup' ),
			"suffix" 		=> 'px',
			"value" 		=> __( "600", "modal_popup" ),
			"group" 		=> 	'General',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Popup Background', 'modal_popup' ),
			"param_name" 	=> 	"bodybg",
			"description" 	=> 	__( 'Popup body background color', 'modal_popup' ),
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
			"type" 			=> "iconpicker",
			"heading" 		=> __( 'Select icon', 'button' ),
			"param_name" 	=> "btn_icon",
			"description" 	=> __( 'it will show within text', 'button' ),
			"group" 		=> 'Button Setting',
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Button Effects', 'modal_popup' ),
			"param_name" 	=> 	"btn_animation",
			"edit_field_class" => "vc_col-sm-6",
			"group" 		=> 	'Button Setting',
			"value"			=>	array(
				"Fade"				=>	"hvr-fade",
				"Winona"			=>	"button--winona",
				"Rayen"				=>	"button--rayen",
				"Moema"				=>	"button--moema",
				"Ujarak"			=>	"button--ujarak",
			)
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Button Align', 'modal_popup' ),
			"param_name" 	=> 	"btnalign",
			"edit_field_class" => "vc_col-sm-6",
			"group" 		=> 	'Button Setting',
			"value"			=>	array(
				"Left"			=>	"left",
				"Center"		=>	"center",
				"Right"			=>	"right",
			)
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Button Text', 'modal_popup' ),
			"param_name" 	=> 	"btntext",
			"description" 	=> 	__( 'text for button', 'modal_popup' ),
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Button Text 2', 'modal_popup' ),
			"param_name" 	=> 	"btntext2",
			"description" 	=> 	__( 'it will show on hover', 'modal_popup' ),
			"dependency" => array('element' => "btn_animation", 'value' => array('button--winona', 'button--rayen')),
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Padding', 'modal_popup' ),
			"param_name" 	=> 	"toppadding",
			"edit_field_class" => "vc_col-sm-4",
			"description" 	=> 	__( 'top bottom', 'modal_popup' ),
			"suffix" 		=> 'px',
			"value" 		=> __( "5", "modal_popup" ),
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Padding', 'modal_popup' ),
			"param_name" 	=> 	"leftpadding",
			"edit_field_class" => "vc_col-sm-4",
			"description" 	=> 	__( 'left, right', 'modal_popup' ),
			"suffix" 		=> 'px',
			"value" 		=> __( "20", "modal_popup" ),
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font Size', 'modal_popup' ),
			"param_name" 	=> 	"btnsize",
			"edit_field_class" => "vc_col-sm-4",
			"suffix" 		=> 'px',
			"value" 		=> __( "18", "modal_popup" ),
			"group" 		=> 	'Button Setting',
		),

		/** border **/

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Border Color', 'button' ),
			"param_name" 	=> "btn_border",
			"edit_field_class" => "vc_col-sm-4",
			"group" 		=> 'Button Setting',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border Width', 'button' ),
			"param_name" 	=> "border_width",
			"edit_field_class" => "vc_col-sm-4",
			"value"			=>	"0",
			"suffix" 		=> 'px',
			"group" 		=> 'Button Setting',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Border Radius', 'modal_popup' ),
			"param_name" 	=> 	"btnradius",
			"edit_field_class" => "vc_col-sm-4",
			"suffix" 		=> 'px',
			"value" 		=> __( "5", "modal_popup" ),
			"group" 		=> 	'Button Setting',
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Color Settings</span>', 'ihover' ),
			"group" 		=> 'Button Setting',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Color', 'modal_popup' ),
			"param_name" 	=> 	"btnclr",
			"edit_field_class" => "vc_col-sm-6",
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Hover Color', 'modal_popup' ),
			"param_name" 	=> 	"hoverclr",
			"edit_field_class" => "vc_col-sm-6",
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'modal_popup' ),
			"param_name" 	=> 	"btnbg",
			"edit_field_class" => "vc_col-sm-6",
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Hover Color', 'modal_popup' ),
			"param_name" 	=> 	"hoverbg",
			"edit_field_class" => "vc_col-sm-6",
			"group" 		=> 	'Button Setting',
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Title Align', 'modal_popup' ),
			"param_name" 	=> 	"titlealign",
			"group" 		=> 	'Title',
			"value"			=>	array(
				"Left"		=>	"left",
				"Center"		=>	"center",
				"Right"		=>	"right",
			)
		),
		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title', 'modal_popup' ),
			"param_name" 	=> 	"titletext",
			"description" 	=> 	__( 'title text', 'modal_popup' ),
			"value" 		=> __( "Image Gallery", "modal_popup" ),
			"group" 		=> 	'Title',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font Size', 'modal_popup' ),
			"param_name" 	=> 	"titlesize",
			"description" 	=> 	__( 'write in pixel e.g 20', 'modal_popup' ),
			"suffix" 		=> 'px',
			"value" 		=> __( "20", "modal_popup" ),
			"group" 		=> 	'Title',
		),
		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Line Height', 'modal_popup' ),
			"param_name" 	=> 	"titleline",
			"description" 	=> 	__( 'it increases the title section height, default 2', 'modal_popup' ),
			"value" 		=> __( "2", "modal_popup" ),
			"group" 		=> 	'Title',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Color', 'modal_popup' ),
			"param_name" 	=> 	"titleclr",
			"description" 	=> 	__( 'title color', 'modal_popup' ),
			"group" 		=> 	'Title',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'modal_popup' ),
			"param_name" 	=> 	"titlebg",
			"description" 	=> 	__( 'title background color', 'modal_popup' ),
			"group" 		=> 	'Title',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Border Color', 'modal_popup' ),
			"param_name" 	=> 	"titleborder",
			"description" 	=> 	__( 'below title border color', 'modal_popup' ),
			"group" 		=> 	'Title',
		),
		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'modal_popup' ),
			"param_name" 	=> 	"bgclr",
			"description" 	=> 	__( 'Content background color', 'modal_popup' ),
			"group" 		=> 	'Popup Content',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Padding [Top Bottom]', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "contentpad",
			"value"			=>	"15",
			"suffix"		=>	"px",
			"group" 		=> 'Popup Content',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Padding [Right Left]', 'megaaddons' ),
			"edit_field_class" => "vc_col-sm-4 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "contentpad2",
			"value"			=>	"15",
			"suffix"		=>	"px",
			"group" 		=> 'Popup Content',
		),
		array(
			"type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'You can also use shortcode', 'modal_popup' ),
			"param_name" 	=> 	"content",
			"group" 		=> 	'Popup Content',
		),
	),
) );

