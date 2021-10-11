<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_accordion_son extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title'				=>		'',
			'title_align'		=>		'left',
			'titleradius'		=>		'',
			'title_padding'		=>		'10',
			'size'				=>		'16',
			'clr'				=>		'',
			'acc_id'			=>		'',
			'borderwidth'		=>		'0px 0px 0px 0px',
			'borderwidth2'		=>		'0px 0px 0px 0px',
			'borderclr'			=>		'',
			'borderclr2'		=>		'',
			'bgclr'				=>		'',
			'gradientbg'		=>		'',
			'bodybg'			=>		'',
		), $atts ) );
		$content = wpb_js_remove_wpautop($content);
		ob_start();
		global $maw_accordion_margin;
		?>
		<h3 class="ac-style" id="<?php echo $acc_id; ?>" style="text-align: <?php echo $title_align; ?>; margin-top: <?php echo $maw_accordion_margin; ?>px; border-width: <?php echo $borderwidth; ?>; border-style: solid; border-color: <?php echo $borderclr; ?>; border-radius: <?php echo $titleradius; ?>px; color: <?php echo $clr; ?>; background: <?php echo $bgclr; ?> <?php echo $gradientbg; ?>; font-size: <?php echo $size; ?>px; padding-top: <?php echo $title_padding; ?>px; padding-bottom: <?php echo $title_padding; ?>px;">
			<?php echo $title; ?>
		</h3>
		<div class="mega-panel" style="margin-bottom: <?php echo $maw_accordion_margin; ?>px;background: <?php echo $bodybg; ?>; border-width: <?php echo $borderwidth2; ?>; border-style: solid; border-color: <?php echo $borderclr2; ?>;">
		  <?php echo $content; ?>
		</div>

		<?php return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Accordion Settings', 'accordion' ),
	"base" 			=> "accordion_son",
	"as_child" 		=> array('only' => 'accordion_father'),
	"content_element" => true,
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('vertically stacked list of items', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/accordions.png',
	'params' => array(

		// Title Section

		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title', 'accordion' ),
			"param_name" 	=> 	"title",
			'admin_label' 	=> 	true,
			"description" 	=> 	__( 'display title', 'accordion' ),
			"group" 		=> 	'Title',
        ),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Title Align', 'button' ),
			"param_name" 	=> 	"title_align",
			"group" 		=> 	'Title',
			"value"			=>	array(
				"Left"			=>	"left",
				"Center"		=>	"center",
				"Right"			=>	"right",
			)
		),

		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Title Padding', 'accordion' ),
			"param_name" 	=> 	"title_padding",
			"description" 	=> 	__( 'from top and bottom', 'accordion' ),
			"value"			=>	"10",
			"suffix" 		=> 	'px',
			"group" 		=> 	"Title",
        ),
		array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Font Size', 'accordion' ),
			"param_name" 	=> 	"size",
			"description" 	=> 	__( 'set in pixel eg, 16', 'accordion' ),
			"value"			=>	"16",
			"suffix" 		=> 	'px',
			"group" 		=> 	'Title',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'accordion' ),
			"param_name" 	=> 	"clr",
			"group" 		=> 	'Title',
        ),

        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Background', 'accordion' ),
			"param_name" 	=> 	"bgclr",
			"group" 		=> 	'Title',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title Background Gradient', 'accordion' ),
			"param_name" 	=> 	"gradientbg",
			"description" 	=> 	__( 'put three different colors inside for gradient effects or leave blank <a href="https://www.w3schools.com/csS/css3_gradients.asp">Further</a>', 'accordion' ),
			"value"			=>	"linear-gradient(141deg, #0fb8ad 0%, #9C27B0 51%, #FFEB3B 75%)",
			"group" 		=> 	'Title',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Extra ID', 'int_banner' ),
			"param_name" 	=> 	"acc_id",
			"description" 	=> 	__( 'Add extra ID name that will be applied to the accordion tabs, and you can use this ID for your customizations.', 'int_banner' ),
			"group" 		=> 	"Title",
        ),

        // Detail Section

        array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Body Background', 'accordion' ),
			"param_name" 	=> "bodybg",
			"group" 		=> "Detail",
		),

        array(
            "type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Detail', 'accordion' ),
			"param_name" 	=> 	"content",
			"group" 		=> 	'Detail',
        ),

        // Border Style
        
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title Border Width', 'accordion' ),
			"param_name" 	=> 	"borderwidth",
			"description" 	=> 	__( 'border width for title [top right bottom left]', 'accordion' ),
			"value"			=>	"0px 0px 0px 0px",
			"group" 		=> 	'Border',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Title [Border Radius]', 'accordion' ),
			"param_name" 	=> 	"titleradius",
			"suffix" 		=> 	'px',
			"group" 		=> 	'Border',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Border Color', 'accordion' ),
			"param_name" 	=> 	"borderclr",
			"description" 	=> 	__( 'color for title border', 'accordion' ),
			"group" 		=> 	'Border',
        ),

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Description Border Width', 'accordion' ),
			"param_name" 	=> 	"borderwidth2",
			"description" 	=> 	__( 'border width for description [top right bottom left]', 'accordion' ),
			"value"			=>	"0px 0px 0px 0px",
			"group" 		=> 	'Border',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Description Border Color', 'accordion' ),
			"param_name" 	=> 	"borderclr2",
			"description" 	=> 	__( 'color for description border', 'accordion' ),
			"group" 		=> 	'Border',
        ),

	),
) );
