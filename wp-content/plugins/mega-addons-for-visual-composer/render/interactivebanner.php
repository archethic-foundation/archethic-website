<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_interective_banner extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'effects'		=>		'effect-lily',
			'image_id'		=>		'',
			'alt'			=>		'',
			'img_width'		=>		'',
			'height'		=>		'',
			'url'			=>		'',
			'title'			=>		'',
			'titlesize'		=>		'18',
			'desc'			=>		'',
			'descsize'		=>		'15',
			'clr'			=>		'#fff',
			'bgclr'			=>		'',
			'icon_bg'		=>		'#fff',
			'icon'			=>		'',
			'icon_url'		=>		'',
			'icon2'			=>		'',
			'icon_url2'		=>		'',
			'icon3'			=>		'',
			'icon_url3'		=>		'',
			'titlesizembl'	=>		'',
			'descsizmbl'	=>		'',
			'imgsizmbl'		=>		'',
			'class'			=>		'',
		), $atts ) );
		$url = vc_build_link($url);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		$some_id = rand(5, 500);
		wp_enqueue_style( 'int-banner-css', plugins_url( '../css/int_banner.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		<!-- HTML DESIGN HERE -->
		<div class="grid vc-interactive-banner <?php echo $class; ?>" id="vc-interactive-banner-<?php echo $some_id; ?>">
			<figure class="<?php echo $effects; ?>" style="background: <?php echo $bgclr; ?>; width: 100%; max-width: <?php echo $img_width; ?>px; width: 100%;">
				<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="height: <?php echo $height; ?>px; max-width: <?php echo $img_width; ?>px; width: 100%;" />
				<figcaption>
					<div>
						<h2 style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $clr; ?>; font-weight: 500;">
							<?php echo $title; ?>
						</h2>
						<p style="font-size: <?php echo $descsize; ?>px; color: <?php echo $clr; ?>;">
							<?php echo $desc; ?>

							<?php if (!empty($icon)) { ?>
								<a href="<?php echo $icon_url; ?>" style="font-size: <?php echo $descsize; ?>px; color: <?php echo $clr; ?>;"><i class="fa <?php echo $icon; ?>"></i></a>
							<?php } ?>
							<?php if (!empty($icon2)) { ?>
								<a href="<?php echo $icon_url2; ?>" style="font-size: <?php echo $descsize; ?>px; color: <?php echo $clr; ?>;"><i class="fa <?php echo $icon2; ?>"></i></a>
							<?php } ?>
							<?php if (!empty($icon3)) { ?>
								<a href="<?php echo $icon_url3; ?>" style="font-size: <?php echo $descsize; ?>px; color: <?php echo $clr; ?>;"><i class="fa <?php echo $icon3; ?>"></i></a>
							<?php } ?>
							
						</p>
					</div>
					<?php if (isset($url) && $url['url'] != '') { ?>
						<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>"></a>
					<?php } ?>
				</figcaption>			
			</figure>
		</div>
		<style>
			@media only screen and (max-width: 480px) {
				#vc-interactive-banner-<?php echo $some_id; ?> h2 {
					font-size: <?php echo $titlesizembl; ?>px !important;
				}
				#vc-interactive-banner-<?php echo $some_id; ?> p {
					font-size: <?php echo $descsizmbl; ?>px !important;
				}
				#vc-interactive-banner-<?php echo $some_id; ?> img {
					height: <?php echo $imgsizmbl; ?>px !important;
				}
			}
		</style>
        <!-- HTML END DESIGN HERE -->
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Interactive Banner', 'int_banner' ),
	"base" 			=> "interective_banner",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('great hover effects', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/int-banner.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Effects', 'int_banner' ),
			"param_name" 	=> 	"effects",
			"description" 	=> 	__( '<a href="http://addons.topdigitaltrends.net/interactive-banner/" target="_blank">See Demo</a> 10 More Effects in <a href="https://1.envato.market/02aNL" target="_blank">Pro Version</a>', 'int_banner' ),
			"group" 		=> 	'Image',
			"value"			=>	array(
				'LILY'			=>		'effect-lily',
				'SADIE'			=>		'effect-sadie',
				'HONEY'			=>		'effect-honey',
				'LAYLA'			=>		'effect-layla',
				'MARLEY'		=>		'effect-marley',
				'RUBY'			=>		'effect-ruby',
				'ROXY'			=>		'effect-roxy',
				'BUBBA'			=>		'effect-bubba',
				'ROMEO'			=>		'effect-romeo',
				'DEXTER'		=>		'effect-dexter',
				'SARAH'			=>		'effect-sarah',
				'CHICO'			=>		'effect-chico',
				'MILO'			=>		'effect-milo',
				'GOLIATH'		=>		'effect-goliath',
				'APOLLO'		=>		'effect-apollo',
				'MOSES'			=>		'effect-moses',
				'JAZZ'			=>		'effect-jazz',
				'MING'			=>		'effect-ming',
				'LEXI'			=>		'effect-lexi',
			)
		),
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Image', 'int_banner' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'int_banner' ),
			"group" 		=> 	'Image',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Alternate Text', 'info-banner-vc' ),
			"param_name" 	=> 	"alt",
			"description" 	=> 	__( 'It will be used as alt attribute of img tag', 'info-banner-vc' ),
			"group" 		=> 	'Image',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Image Width', 'int_banner' ),
			"param_name" 	=> 	"img_width",
			"description" 	=> 	__( 'set custom width in pixel or leave blank', 'int_banner' ),
			"suffix" 		=> 'px',
			"group" 		=> 	"Image",
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Image Height', 'int_banner' ),
			"param_name" 	=> 	"height",
			"description" 	=> 	__( 'set custom height in pixel eg, 230 or leave blank', 'int_banner' ),
			"suffix" 		=> 'px',
			"group" 		=> 	"Image",
        ),
		array(
            "type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Url', 'int_banner' ),
			"param_name" 	=> 	"url",
			"description" 	=> 	__( 'write url for moving to specific link', 'int_banner' ),
			"value"			=>	"#0",
			"group" 		=> 	"Image",
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Extra Class', 'int_banner' ),
			"param_name" 	=> 	"class",
			"description" 	=> 	__( 'Add extra class name that will be applied to the icon process, and you can use this class for your customizations.', 'int_banner' ),
			"group" 		=> 	"Image",
        ),
        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Image',
		),
		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Heading', 'int_banner' ),
			"param_name" 	=> 	"title",
			"description" 	=> 	__( 'write title', 'int_banner' ),
			"group" 		=> 	"Title",
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Heading Font Size', 'int_banner' ),
			"param_name" 	=> 	"titlesize",
			"description" 	=> 	__( 'set in pixel e.g 18', 'int_banner' ),
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 	"Title",
        ),
        array(
            "type" 			=> 	"textarea",
			"heading" 		=> 	__( 'Description', 'int_banner' ),
			"param_name" 	=> 	"desc",
			"description" 	=> 	__( 'write description', 'int_banner' ),
			"dependency" => array('element' => "effects", 'value' => array('effect-steve', 'effect-selena', 'effect-lily', 'effect-sadie', 'effect-honey', 'effect-layla', 'effect-zoe', 'effect-oscar', 'effect-marley', 'effect-ruby', 'effect-roxy', 'effect-bubba', 'effect-romeo', 'effect-dexter', 'effect-sarah', 'effect-chico', 'effect-milo', 'effect-goliath', 'effect-apollo', 'effect-moses', 'effect-jazz', 'effect-ming', 'effect-lexi', 'effect-duke', 'effect-julia',)),
			"group" 		=> 	"Title",
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Description/Icon Font Size', 'int_banner' ),
			"param_name" 	=> 	"descsize",
			"description" 	=> 	__( 'set in pixel e.g 15', 'int_banner' ),
			"value"			=>	"15",
			"suffix" 		=> 'px',
			"group" 		=> 	"Title",
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Content Color', 'int_banner' ),
			"param_name" 	=> 	"clr",
			"description" 	=> 	__( 'text color', 'int_banner' ),
			"value"			=>	"#fff",
			"group" 		=> 	"Title",
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Background Color', 'int_banner' ),
			"param_name" 	=> 	"bgclr",
			"group" 		=> 	"Title",
        ),

        /* Icon Category
        ============================= */

        array(
            "type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'First Icon', 'int_banner' ),
			"param_name" 	=> 	"icon",
			"dependency" => array('element' => "effects", 'value' => array('effect-hera', 'effect-winston', 'effect-terry', 'effect-phoebe', 'effect-kira',)),
			"description" 	=> 	__( 'choose Icon or leave blank', 'int_banner' ),
			"group" 		=> 	"Icons",
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'First Icon URL', 'int_banner' ),
			"param_name" 	=> 	"icon_url",
			"dependency" => array('element' => "effects", 'value' => array('effect-hera', 'effect-winston', 'effect-terry', 'effect-phoebe', 'effect-kira',)),
			"description" 	=> 	__( 'write first Icon URL eg, www.google.com', 'int_banner' ),
			"group" 		=> 	"Icons",
        ),

        array(
            "type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Second Icon', 'int_banner' ),
			"param_name" 	=> 	"icon2",
			"dependency" => array('element' => "effects", 'value' => array('effect-hera', 'effect-winston', 'effect-terry', 'effect-phoebe', 'effect-kira',)),
			"description" 	=> 	__( 'choose Icon or leave blank', 'int_banner' ),
			"group" 		=> 	"Icons",
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Second Icon URL', 'int_banner' ),
			"param_name" 	=> 	"icon_url2",
			"dependency" => array('element' => "effects", 'value' => array('effect-hera', 'effect-winston', 'effect-terry', 'effect-phoebe', 'effect-kira',)),
			"description" 	=> 	__( 'write second Icon URL eg, www.google.com', 'int_banner' ),
			"group" 		=> 	"Icons",
        ),

        array(
            "type" 			=> 	"iconpicker",
			"heading" 		=> 	__( 'Third Icon', 'int_banner' ),
			"param_name" 	=> 	"icon3",
			"dependency" => array('element' => "effects", 'value' => array('effect-hera', 'effect-winston', 'effect-terry', 'effect-phoebe', 'effect-kira',)),
			"description" 	=> 	__( 'choose Icon or leave blank', 'int_banner' ),
			"group" 		=> 	"Icons",
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Third Icon URL', 'int_banner' ),
			"param_name" 	=> 	"icon_url3",
			"dependency" => array('element' => "effects", 'value' => array('effect-hera', 'effect-winston', 'effect-terry', 'effect-phoebe', 'effect-kira',)),
			"description" 	=> 	__( 'write third Icon URL eg, www.google.com', 'int_banner' ),
			"group" 		=> 	"Icons",
        ),

        /* Typography
        ================================================ */
        
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Heading Font Size (For Mobile)', 'int_banner' ),
			"param_name" 	=> 	"titlesizembl",
			"description" 	=> 	__( 'set in pixel e.g 16', 'int_banner' ),
			"value"			=>	"16",
			"suffix" 		=> 'px',
			"group" 		=> 	"Typography",
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Description/Icon Font Size (For Mobile)', 'int_banner' ),
			"param_name" 	=> 	"descsizmbl",
			"description" 	=> 	__( 'set in pixel e.g 15', 'int_banner' ),
			"value"			=>	"15",
			"suffix" 		=> 'px',
			"group" 		=> 	"Typography",
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Image Height (For Mobile)', 'int_banner' ),
			"param_name" 	=> 	"imgsizmbl",
			"description" 	=> 	__( 'set custom height in pixel eg, 200 or leave blank', 'int_banner' ),
			"suffix" 		=> 'px',
			"group" 		=> 	"Typography",
        ),
	),
) );

