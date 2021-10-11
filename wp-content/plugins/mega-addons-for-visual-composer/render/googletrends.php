<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_google_trends extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'css'		=>		'',
		), $atts ) );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		<div class="mega-google-trends <?php echo $css_class; ?>">
			<div class="googletrend-code">
				<?php echo $content; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Google Trends', 'trends' ),
	"base" 			=> "google_trends",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('show google trends', 'trends'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/trend.png',
	'params' => array(
		array(
			"type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Google Trend Embed Code', 'trends' ),
			"param_name" 	=> 	"content",
			"description" 	=> 	__( 'Visit <a href="https://www.google.com/trends/explore?date=all&q=Basketball,%20Rugby,%20Handball&hl=en-US">Google Trends</a> to create your map (Step by step: 1) Find Google Trend 2) Click the cog symbol in the right corner and select "embed code" 3) On modal window copy "Embed code on left side" 4) Copy code and paste it).', 'trends' ),
			"value"			=>	__('<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/884_RC03/embed_loader.js"></script> <script type="text/javascript"> trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"Basketball","geo":"","time":"all"},{"keyword":"Rugby","geo":"","time":"all"},{"keyword":"Handball","geo":"","time":"all"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=Basketball,Rugby,Handball&hl=en-US"}); </script> '),
			"group" 		=> 	'Embed Code',
		),
		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Embed Code',
		),
		array(
			"type" 			=> "css_editor",
			"heading" 		=> __( 'Display Design', 'trends' ),
			"param_name" 	=> "css",
			"group" 		=> "Design Options",
		),
	),
) );

