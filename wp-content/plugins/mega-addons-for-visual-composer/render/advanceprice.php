<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_advance_listing extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'offer_visibility' 		=> 'none',
			'offer_text' 			=> '',
			'offer_bg' 				=> '',
			'price_margin' 			=> '',
			'price_title' 			=> '',
			'price_visibility' 		=> 'block',
			'price_amount' 			=> '',
			'price_fontsize' 		=> '35',
			'price_plan' 			=> 'month',
			'feature_align' 		=> '',
			'feature_size' 			=> '13px',
			'btn_visibility' 		=> '',
			'btn_text' 				=> '',
			'btn_url' 				=> '',
			'amount_clr' 			=> '',
			'price_bg' 				=> '',
			'top_bg' 				=> '',
			'text_clr' 				=> '',
		), $atts ) );
		$btn_url = vc_build_link($btn_url);
		wp_enqueue_style( 'advanced-listing-css', plugins_url( '../css/ad_listing.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
		<div class="price_table_2" style="background-color: <?php echo $price_bg; ?>; margin-top: <?php echo $price_margin; ?>px;">
			<div class="type" style="background-color: <?php echo $top_bg; ?>;">
				<div class="ribbon-right-side" style="display: <?php echo $offer_visibility; ?>;">
					<span style="background: <?php echo $offer_bg; ?>;"><?php echo $offer_text; ?></span>
				</div>
				<p><?php echo $price_title; ?></p>
			</div>

			<div class="plan">
				<div class="header" style="display: <?php echo $price_visibility; ?>;">
						<span class="amount" style="color: <?php echo $amount_clr; ?>; font-size: <?php echo $price_fontsize; ?>px">
							<?php echo $price_amount; ?> <span class="month">/<?php echo $price_plan; ?></span>
						</span>
				</div>
				<div class="content">
					<?php echo $content; ?>
				</div>			
				<div class="price" style="">
		      		<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="price-btn" style="display: <?php echo $btn_visibility; ?>; background-color: <?php echo $top_bg; ?>; box-shadow: inset 0 -2px <?php echo $top_bg; ?>;-webkit-box-shadow: inset 0 -2px <?php echo $top_bg; ?>;">
		      			<?php echo $btn_text; ?>
		      		</a>
				</div>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Advanced Pricing List', 'infobox' ),
	"base" 			=> "mvc_advance_listing",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Compare Listing', 'infobox'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/advanceprice.png',
	'params' => array(
		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Price margin (from top)', 'pt-vc' ),
			"param_name" 	=> 	"price_margin",
			"description" 	=> 	__( 'Set complete margin of price table from top to bottom in pixel e.g 30. It is recomend for first price listing from left side.', 'pt-vc' ),
			"suffix" 		=> 	'px',
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Price Title', 'pt-vc' ),
			"param_name" 	=> 	"price_title",
			"description" 	=> 	__( 'It will be used as price package name', 'pt-vc' ),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Show/Hide price amount', 'pt-vc' ),
			"param_name" 	=> 	"price_visibility",
			"description" 	=> 	__( 'Select Show or Hide amount and currency ', 'pt-vc' ),
			"group" 		=> 	'Price Header',
			"value" 		=> array(
				'Show' =>  'block',
				'Hide' =>  'none',
			)
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Currency and Amount', 'pt-vc' ),
			"param_name" 	=> 	"price_amount",
			"description" 	=> 	__( 'Write currency and amount e.g $299', 'pt-vc' ),
			"dependency" => array('element' => "price_visibility", 'value' => 'block'),
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Amount font size', 'pt-vc' ),
			"param_name" 	=> 	"price_fontsize",
			"description" 	=> 	__( 'Set font size of price amount e.g 35', 'pt-vc' ),
			"dependency" => array('element' => "price_visibility", 'value' => 'block'),
			"suffix" 		=> 	'px',
			"value"			=>	'35',
			"group" 		=> 	'Price Header',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Price plan', 'pt-vc' ),
			"param_name" 	=> 	"price_plan",
			"description" 	=> 	__( 'Price plan e.g "month"', 'pt-vc' ),
			"dependency" => array('element' => "price_visibility", 'value' => 'block'),
			"group" 		=> 	'Price Header',
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
			"group" 		=> 	'Offer',
			"value" 		=> array(
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
			"value"			=> '<li>30GB Storage</li><li>512MB Ram</li><li>[font_awesome link="" icon="check" color="#000"]</li><li>10 databases</li><li>1,000 Emails</li><li>25GB Bandwidth</li>'
		),

        /* Button */

        array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Show/Hide button', 'pt-vc' ),
			"param_name" 	=> 	"btn_visibility",
			"description" 	=> 	__( 'Select Show or Hide Button ', 'pt-vc' ),
			"group" 		=> 	'Button',
			"value" 		=> array(
				'Show' =>  'block',
				'Hide' =>  'none',
			)
        ),

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
			"description" 	=> 	__( 'Set Button URL for link', 'pt-vc' ),
			"group" 		=> 	'Button',
        ),

        /* colors */

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Header Background color', 'pt-vc' ),
			"param_name" 	=> 	"top_bg",
			"description" 	=> 	__( 'Top Header and button background color', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Amount color', 'pt-vc' ),
			"param_name" 	=> 	"amount_clr",
			"description" 	=> 	__( 'Set color of price amount', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Body background color', 'pt-vc' ),
			"param_name" 	=> 	"price_bg",
			"description" 	=> 	__( 'Set complete background color', 'pt-vc' ),
			"group" 		=> 	'Color',
        ),

	),
) );

