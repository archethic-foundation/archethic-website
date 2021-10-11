<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_price_listing extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style' 				=> 'price_style_1',
			'offer_visibility' 		=> 'none',
			'offer_text' 			=> '',
			'offer_bg' 				=> '',
			'price_title' 			=> '',
			'subtitle' 				=> '',
			'price_visibility' 		=> 'block',
			'price_currency' 		=> '',
			'price_amount' 			=> '',
			'price_plan' 			=> '',
			'btn_text' 				=> '',
			'btn_url' 				=> '',
			'price_bg' 				=> '',
			'top_bg' 				=> '',
			'title_clr' 				=> '',
			'amount_clr' 				=> '',
			'featured' 				=> 'disable',
			'zoom' 					=> '0',
			'titlesize'				=>	'',
			'amountsize'			=>	'',
			'planesize'				=>	'',
			'btnsize'				=>	'',
		), $atts ) );	
		$btn_url = vc_build_link($btn_url);
		wp_enqueue_style( 'price-listing-css', plugins_url( '../css/price_listing.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>


		<?php switch ($style) {
			case 'design1':
				include 'price-table/price1.php';
				break;
			case 'mega-price-table-2':
				include 'price-table/price2.php';
				break;
			case 'mega-price-table-3':
				include 'price-table/price2.php';
				break;
			case 'mega-price-table-4':
				include 'price-table/price4.php';
				break;
			case 'mega-price-table-5':
				include 'price-table/price5.php';
				break;
			
			default:
				include 'price-table/price1.php';
				break;
		} ?>

		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Price Table', 'infobox' ),
	"base" 			=> "mvc_price_listing",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Create nice looking price tables', 'infobox'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/price.png',
	'params' => array(
		array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Select Layout', 'pt-vc' ),
			"param_name" 	=> 	"style",
			"group" 		=> 	'Price Header',
			"description" 	=> 	__( '<a href="https://addons.topdigitaltrends.net/price-table/" target="_blank">See Demo</a> 3 More Designs in <a href="https://1.envato.market/02aNL" target="_blank">Pro Version</a>', 'pt-vc' ),
			"value" 		=>  array(
				'Design 1'		=>  'design1',
				'Design 2'		=>  'mega-price-table-2',
				'Design 3'		=>  'mega-price-table-3',
				'Design 4'		=>  'mega-price-table-4',
				'Design 5'		=>  'mega-price-table-5',
			)
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Price Title', 'pt-vc' ),
			"param_name" 	=> 	"price_title",
			"description" 	=> 	__( 'It will be used as price package name', 'pt-vc' ),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Price Subtitle', 'pt-vc' ),
			"param_name" 	=> 	"subtitle",
			"description" 	=> 	__( 'It will show with title', 'pt-vc' ),
			"dependency" => array('element' => "style", 'value' => array('design7', 'design8')),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Show/Hide price amount', 'pt-vc' ),
			"param_name" 	=> 	"price_visibility",
			"description" 	=> 	__( 'Select Show or Hide amount and currency ', 'pt-vc' ),
			"group" 		=> 	'Price Header',
			"value" 		=>  array(
				'Show' =>  'block',
				'Hide' =>  'none',
			)
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Currency sign', 'pt-vc' ),
			"param_name" 	=> 	"price_currency",
			"description" 	=> 	__( 'Write currency sign e.g "$"', 'pt-vc' ),
			"dependency" => array('element' => "price_visibility", 'value' => 'block'),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Amount', 'pt-vc' ),
			"param_name" 	=> 	"price_amount",
			"description" 	=> 	__( 'Write amount in number e.g 299', 'pt-vc' ),
			"dependency" => array('element' => "price_visibility", 'value' => 'block'),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Price plan', 'pt-vc' ),
			"param_name" 	=> 	"price_plan",
			"description" 	=> 	__( 'Price plan e.g "per month"', 'pt-vc' ),
			"dependency" => array('element' => "price_visibility", 'value' => 'block'),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Set Featured', 'pt-vc' ),
			"param_name" 	=> 	"featured",
			"dependency" => array('element' => "style", 'value' => array('mega-price-table-2', 'mega-price-table-3', 'mega-price-table-4', 'mega-price-table-5', 'design6', 'design7', 'design8')),
			"group" 		=> 	'Price Header',
			"value"			=>	array(
				"Disable"		=>		"disable",
				"Enable"		=>		"transform",
			)
        ),
        array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Scale Zoom', 'pt-vc' ),
			"param_name" 	=> 	"zoom",
			"description" 	=> 	__( 'It will prominent than others price table', 'pt-vc' ),
			"dependency" => array('element' => "featured", 'value' => "transform"),
			"group" 		=> 	'Price Header',
			"value" 		=>  array(
				'3' 	=>  '3',
				'4' 	=>  '4',
				'5' 	=>  '5',
				'6' 	=>  '6',
				'7' 	=>  '7',
				'8' 	=>  '8',
				'9' 	=>  '9',
			)
        ),

        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Price Header',
		),

		array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Show/Hide Offer', 'pt-vc' ),
			"param_name" 	=> 	"offer_visibility",
			"description" 	=> 	__( 'Select Show or Hide offer ', 'pt-vc' ),
			"dependency" => array('element' => "style", 'value' => 'design1'),
			"group" 		=> 	'Offer',
			"value" 		=>  array(
				'Hide' =>  'none',
				'Show' =>  'block',
			)
        ),
		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Offer text', 'pt-vc' ),
			"param_name" 	=> 	"offer_text",
			"description" 	=> 	__( 'Write text for showing best offer in Ribbon e.g BEST', 'pt-vc' ),
			"dependency" => array('element' => "offer_visibility", 'value' => 'block'),
			"group" 		=> 	'Offer',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Offer Background color', 'pt-vc' ),
			"param_name" 	=> 	"offer_bg",
			"description" 	=> 	__( 'background color of offer', 'pt-vc' ),
			"dependency" => array('element' => "offer_visibility", 'value' => 'block'),
			"group" 		=> 	'Offer',
        ),
        /* Features */

        array(
			"type" 			=> "textarea_html",
			"heading" 		=> __( 'Caption Text', 'ich-vc' ),
			"param_name" 	=> "content",
			"description" 	=> __( 'Enter your pricing content. You can use a UL list as shown by default but anything would really work!', 'ich-vc' ),
			"group" 		=> 'Features',
			"value"			=> '<li>30GB Storage</li><li>512MB Ram</li><li>10 databases</li><li>1,000 Emails</li><li>25GB Bandwidth</li>'
		),

        /* Button */

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Button Text', 'pt-vc' ),
			"param_name" 	=> 	"btn_text",
			"description" 	=> 	__( 'Button text name', 'pt-vc' ),
			"group" 		=> 	'Button',
        ),

        array(
            "type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Button Url', 'pt-vc' ),
			"param_name" 	=> 	"btn_url",
			"description" 	=> 	__( 'Write Button URL for link', 'pt-vc' ),
			"group" 		=> 	'Button',
        ),

        /* colors */

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title color', 'pt-vc' ),
			"param_name" 	=> 	"title_clr",
			"description" 	=> 	__( 'set price title color', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Price Amount Color', 'pt-vc' ),
			"param_name" 	=> 	"amount_clr",
			"description" 	=> 	__( 'set price amount color', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Header Background color', 'pt-vc' ),
			"param_name" 	=> 	"top_bg",
			"description" 	=> 	__( 'Top Header and button background color', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Body Background', 'pt-vc' ),
			"param_name" 	=> 	"price_bg",
			"description" 	=> 	__( 'Set complete background color', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Title (Font Size)', 'pt-vc' ),
			"param_name" 	=> 	"titlesize",
			"description" 	=> 	__( 'Set in pixel eg, 30 or leave blank for default', 'pt-vc' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'Typography',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Price Amount (Font Size)', 'pt-vc' ),
			"param_name" 	=> 	"amountsize",
			"description" 	=> 	__( 'Set in pixel eg, 40 or leave blank for default', 'pt-vc' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'Typography',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Price Plan (Font Size)', 'pt-vc' ),
			"param_name" 	=> 	"planesize",
			"description" 	=> 	__( 'Set in pixel eg, 12 or leave blank for default', 'pt-vc' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'Typography',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Button Text (Font Size)', 'pt-vc' ),
			"param_name" 	=> 	"btnsize",
			"description" 	=> 	__( 'Set in pixel eg, 17 or leave blank for default', 'pt-vc' ),
			"suffix" 		=> 'px',
			"group" 		=> 	'Typography',
        ),
	),
) );

