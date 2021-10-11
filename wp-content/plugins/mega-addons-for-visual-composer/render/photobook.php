<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_photobook extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'image_ids' 	=> '',
			'speed' 		=> '1000',
			'direction' 	=> 'RTL',
			'padding' 		=> '0',
			'zoom_depth' 	=> '1',
			'auto_delay' 	=> '1000',
			'page_numbers' 	=> '',
			'closed_book' 	=> '',
			'zoom' 			=> '',
			'autoplay' 		=> '',
			'turn_by_click' => '',
			'keyboard' 		=> '',
			'tabs' 			=> '',
			'arrows' 		=> '',
		), $atts ) );
		wp_enqueue_style( 'photobook-css', plugins_url( '../css/photobook.css' , __FILE__ ));
        wp_enqueue_script( 'easing-js', plugins_url( '../js/jquery.easing.1.3.js' , __FILE__ ), array('jquery') );
        wp_enqueue_script( 'photobook-js', plugins_url(   '../js/jquery.booklet.latest.min.js' , __FILE__ ), array('jquery', 'jquery-ui-core', 'jquery-ui-draggable') );
        wp_enqueue_script( 'zoom-js', plugins_url( '../js/jquery.zoom.min.js' , __FILE__ ), array('jquery') );
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		
	    <div class="wcp-loader">
	    	
	    </div>
			<div class="flipbook"
					data-speed="<?php echo $speed; ?>"
					data-direction="<?php echo $direction; ?>"
					data-padding="<?php echo $padding; ?>"
					data-zoomdepth="<?php echo $zoom_depth; ?>"
					data-autodelay="<?php echo $auto_delay; ?>"
					data-pagenumbers="<?php echo $page_numbers; ?>"
					data-closedbook="<?php echo $closed_book; ?>"
					data-zoom="<?php echo $zoom; ?>"
					data-autoplay="<?php echo $autoplay; ?>"
					data-turnbyclick="<?php echo $turn_by_click; ?>"
					data-keyboard="<?php echo $keyboard; ?>"
					data-tabs="<?php echo $tabs; ?>"
					data-arrows="<?php echo $arrows; ?>"
					>
			<?php
			    if ($image_ids != '') {
			    	$all_images = explode(',', $image_ids);
			        foreach ($all_images as $image) {
			        	$image_url = wp_get_attachment_url( $image );
			            echo '<div><img src="'.$image_url.'"/></div>';
			        }
			    }
			?>
		</div>
		

		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Flip Book', 'photobook' ),
	"base" 			=> "mvc_photobook",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('3D Page Flip Book', 'photobook'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/photobook.png',
	'params' => array(
		array(
		"type" 			=> 	"attach_images",
		"heading" 		=> 	__( 'Images', 'photobook' ),
		"param_name" 	=> 	"image_ids",
		"description" 	=> 	__( 'Select the images that will be used as book pages', 'photobook' ),
		"group" 		=> 	'Pages',
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Speed', 'photobook' ),
			"param_name" 	=> 	"speed",
			"description" 	=> 	__( 'Speed of the transition between pages in milliseconds eg 1000', 'photobook' ),
			"value"			=>	"1000",
			"group" 		=> 	'Settings',
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Reading Direction', 'photobook' ),
			"param_name" 	=> 	"direction",
			"description" 	=> 	__( 'Direction of the overall page organization', 'photobook' ),
			"group" 		=> 	'Settings',
			"value" 		=> array(
					"Right to Left"		=> "RTL", 
					"Left to Right" 	=> "LTR",
			)
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Page Padding', 'photobook' ),
			"param_name" 	=> 	"padding",
			"description" 	=> 	__( 'Padding added to each page wrapper', 'photobook' ),
			"group" 		=> 	'Settings',
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Zoom Depth', 'photobook' ),
			"param_name" 	=> 	"zoom_depth",
			"description" 	=> 	__( 'The default value is 1, meaning the zoomed image should be at 100% of its natural width and height', 'photobook' ),
			"value"			=>	"1",
			"group" 		=> 	'Settings',
		),

		array(
			"type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'AutoPlay delay', 'photobook' ),
			"param_name" 	=> 	"auto_delay",
			"description" 	=> 	__( 'The time in milliseconds between each automatic page flip transition', 'photobook' ),
			"group" 		=> 	'Settings',
		),

		// options
		
		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Page Numbers', 'photobook' ),
			"param_name" 	=> 	"page_numbers",
			"description" 	=> 	__( 'Display page numbers on each page', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Show"		=> "show",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Closed Book', 'photobook' ),
			"param_name" 	=> 	"closed_book",
			"description" 	=> 	__( 'Gives the book the appearance of being closed', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Enable"		=> "enable",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Zoom on Hover', 'photobook' ),
			"param_name" 	=> 	"zoom",
			"description" 	=> 	__( 'Zoom in the page when hover the cursor', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Enable"		=> "enable",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'AutoPlay', 'photobook' ),
			"param_name" 	=> 	"autoplay",
			"description" 	=> 	__( 'Enables automatic navigation. Depends on AutoPlay delay in Settings', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Enable"		=> "enable",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Turn Page by clicking Image', 'photobook' ),
			"param_name" 	=> 	"turn_by_click",
			"description" 	=> 	__( 'Enables manual page turning by click on page. Zooming will not work when its enabled', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Enable"		=> "enable",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Keyboard Controls', 'photobook' ),
			"param_name" 	=> 	"keyboard",
			"description" 	=> 	__( 'Enables page navigation using arrows of Keyboard', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Enable"		=> "enable",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Navigation Tabs', 'photobook' ),
			"param_name" 	=> 	"tabs",
			"description" 	=> 	__( 'Adds tabs along the top of the booklet', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Show"		=> "show",
			)
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Arrows', 'photobook' ),
			"param_name" 	=> 	"arrows",
			"description" 	=> 	__( 'Adds arrows on both sides of the booklet', 'photobook' ),
			"group" 		=> 	'Options',
			"value" 		=> array(
					"Show"		=> "show",
			)
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Options',
		),
	),
) );

