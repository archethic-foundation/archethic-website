<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_accordion_father extends WPBakeryShortCodesContainer {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'active'			=>		'false',
			'animation'			=>		'350',
			'event' 			=> 		'click',
			'titlemargin'		=>		'0',
			'activetabbg'		=>		'',
			'activetabclr'		=>		'',
			'class'				=>		'',
			'iconsize' 			=> 		'15',
			'icon' 				=> 		'fa fa-plus',
			'activeicon' 		=> 		'fa fa-minus',
			'icon_mblsize' 		=> 		'',
			'title_mblsize' 	=> 		'',
			'desc_mblsize' 		=> 		'',
		), $atts ) );
		$some_id = rand(5, 500);
		$GLOBALS['maw_accordion_margin'] = $titlemargin;
		$content = wpb_js_remove_wpautop($content);
		wp_enqueue_style( 'accordion-css', plugins_url( '../css/accordion.css' , __FILE__ ));
		wp_enqueue_script( 'accordion-js', plugins_url( '../js/accordion.js' , __FILE__ ), array('jquery', 'jquery-ui-accordion'));
		ob_start(); ?>
		<div class="mega-accordion maw_accordion_<?php echo $some_id; ?> <?php echo $class; ?>" data-active="<?php echo $active; ?>" data-anim="<?php echo $animation; ?>" data-event="<?php echo $event; ?>" data-closeicons="<?php echo $icon; ?>" data-activeicons="<?php echo $activeicon; ?>">
			<?php echo $content; ?>
		</div>

		<style>
			.maw_accordion_<?php echo $some_id; ?> .ac-style .ui-accordion-header-icon {
				font-size: <?php echo $iconsize; ?>px;
			}
			<?php if ($activetabbg != '' || $activetabclr != '') { ?>
				.maw_accordion_<?php echo $some_id; ?> .ui-state-active,
				.maw_accordion_<?php echo $some_id; ?> .ui-widget-content .ui-state-active, 
				.maw_accordion_<?php echo $some_id; ?> .ui-widget-header .ui-state-active {
					background: <?php echo $activetabbg; ?> !important;
					color: <?php echo $activetabclr; ?> !important;
				}
				.maw_accordion_<?php echo $some_id; ?> .ui-accordion-header:hover {
					background: <?php echo $activetabbg; ?> !important;
					color: <?php echo $activetabclr; ?> !important;
				}
			<?php } ?>

			@media only screen and (max-width: 767px) {
				.maw_accordion_<?php echo $some_id; ?> .ac-style {
					font-size: <?php echo $title_mblsize ?>px !important;
				}
				.maw_accordion_<?php echo $some_id; ?> .ac-style .ui-accordion-header-icon {
					font-size: <?php echo $icon_mblsize; ?>px !important;
				}
				.maw_accordion_<?php echo $some_id; ?> .mega-panel, 
				.maw_accordion_<?php echo $some_id; ?> .mega-panel * {
					font-size: <?php echo $title_mblsize ?>px !important;
				}
			}
		</style>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "accordion_father",
	"name" 			=> __( 'Accordion', 'accordion' ),
	"as_parent" 	=> array('only' => 'accordion_son'),
	"content_element" => true,
	"js_view" 		=> 'VcColumnView',
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('vertically stacked list of items', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/accordions.png',
	'params' => array(
			array(
				"type" 			=> 	"dropdown",
				"heading" 		=> 	__( 'Tab Open/Close', 'accordion' ),
				"param_name" 	=> 	"active",
				"description" 	=> 	__( 'click to <a href="https://addons.topdigitaltrends.net/accordion/" target="_blank">See Demo</a>', 'accordion' ),
				"group" 		=> 'General',
				"value"			=> array(
					"Close"		=>	"false",
					"Open"		=>	"0",
				)
			),

			array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Animation Speed', 'accordion' ),
				"param_name" 	=> 	"animation",
				"description" 	=> 	__( 'in millisecond', 'accordion' ),
				"value"			=>	"350",
				"suffix" 		=> 	'ms',
				"group" 		=> 	'General',
	        ),

			array(
				"type" 			=> 	"dropdown",
				"heading" 		=> 	__( 'Event', 'accordion' ),
				"param_name" 	=> 	"event",
				"description" 	=> 	__( 'select', 'accordion' ),
				"group" 		=> 'General',
				"value"			=> array(
					"Click"			=>	"click",
					"Mouseover"		=>	"mouseover",
				)
			),

			array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Margin', 'accordion' ),
				"param_name" 	=> 	"titlemargin",
				"description" 	=> 	__( 'margin between accordion titles.', 'accordion' ),
				"value"			=>	"0",
				"suffix" 		=> 	'px',
				"group" 		=> 	'General',
	        ),

	        array(
	            "type" 			=> 	"colorpicker",
				"heading" 		=> 	__( 'Active Tab Background', 'accordion' ),
				"param_name" 	=> 	"activetabbg",
				"group" 		=> 	'General',
	        ),

	        array(
	            "type" 			=> 	"colorpicker",
				"heading" 		=> 	__( 'Active Tab Hover Color', 'accordion' ),
				"param_name" 	=> 	"activetabclr",
				"group" 		=> 	'General',
	        ),

			array(
	            "type" 			=> 	"textfield",
				"heading" 		=> 	__( 'Extra Class', 'int_banner' ),
				"param_name" 	=> 	"class",
				"description" 	=> 	__( 'Add extra class name that will be applied to the accordion, and you can use this class for your customizations.', 'int_banner' ),
				"group" 		=> 	"General",
	        ),

			array(
				"type" 			=> "vc_links",
				"param_name" 	=> "caption_url",
				"class"			=>	"ult_param_heading",
				"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
				"group" 		=> 'General',
			),

			array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Icon Font Size', 'accordion' ),
				"param_name" 	=> 	"iconsize",
				"suffix" 		=> 	'px',
				"value"			=>	"15",
				"group" 		=> 	'Icon',
	        ),

			array(
				"type" 			=> "iconpicker",
				"heading" 		=> __( 'Icon', 'accordion' ),
				"param_name" 	=> "icon",
				"description" 	=> __( 'it will show by default', 'accordion' ),
				"group" 		=> 'Icon',
			),

			array(
				"type" 			=> "iconpicker",
				"heading" 		=> __( 'Active Icon', 'accordion' ),
				"param_name" 	=> "activeicon",
				"description" 	=> __( 'it will show when accordion is active', 'accordion' ),
				"group" 		=> 'Icon',
			),

			array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Icon Size [For Mobile]', 'accordion' ),
				"param_name" 	=> 	"icon_mblsize",
				"suffix" 		=> 	'px',
				"group" 		=> 	'Typography',
	        ),

			array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Title Size [For Mobile]', 'accordion' ),
				"param_name" 	=> 	"title_mblsize",
				"suffix" 		=> 	'px',
				"group" 		=> 	'Typography',
	        ),

	        array(
	            "type" 			=> 	"vc_number",
				"heading" 		=> 	__( 'Description Size [For Mobile]', 'accordion' ),
				"param_name" 	=> 	"desc_mblsize",
				"suffix" 		=> 	'px',
				"group" 		=> 	'Typography',
	        ),
		)
) );
