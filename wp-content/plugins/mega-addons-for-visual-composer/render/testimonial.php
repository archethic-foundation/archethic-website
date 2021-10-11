<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_vc_testimonial extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'				=>		'theme1',
			'rating'			=>		'none',
			'link'				=>		'',
			'image_id'			=>		'',
			'alt'				=>		'',
			'width'				=>		'100',
			'radius'			=>		'50',
			'name'				=>		'#000',
			'namesize'			=>		'14',
			'nameclr'			=>		'',
			'prof'				=>		'',
			'profsize'			=>		'14',
			'profclr'			=>		'#000',
			'bgclr'				=>		'',
		), $atts ) );
		$link = vc_build_link($link);
		if ($image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		wp_enqueue_style( 'testimonial-css', plugins_url( '../css/testimonial.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		ob_start(); ?>
		<?php if ($style == 'theme1') { ?>
			<div class="mega-testimonial">
				<div class="tm-quotes" style="background: <?php echo $bgclr; ?>; padding: 15px 10px; font-style: italic; border-radius: 4px;">
					<?php echo $content; ?>
					<span class="tm-arrow" style="border-top: 8px solid <?php echo $bgclr; ?>;"></span>
				</div>
				<div class="tm-details">
					<div class="tm-profile">
						<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%">
					</div>
					<div class="tm-prof">
						<div class="tm-name">
							<span style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold;"><?php echo $name; ?></span>,
							<span><i><a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none;"><?php echo $prof; ?></a></i></span>
							<p style="padding-top: 5px; display: <?php echo $rating; ?>;">
								<img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png">
							</p>
						</div>
					</div>
					<div class="Clearfix"></div>
				</div>
			</div>			
		<?php } ?>

		<?php if ($style == 'theme2') { ?>
			<div class="mega-testimonial-2">
				<div class="tm-details">
					<div class="tm-prof">
						<div class="tm-name">
							<span style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold;"><?php echo $name; ?></span>,
							<p>
								<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none;"><?php echo $prof; ?></a>
							</p>
						</div>
					</div>
					<div class="tm-profile">
						<?php if ($rating !== 'none') { ?>
							<img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png">
						<?php } ?>
						<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%">
					</div>
					<div class="Clearfix"></div>
				</div>
				<div class="tm-quotes2" style="background: <?php echo $bgclr; ?>;">
					<?php echo $content; ?>
					<span class="tm-arrow2" style="border-bottom: 8px solid <?php echo $bgclr; ?>;"></span>
				</div>
			</div>
		<?php } ?>

		<?php if ($style == 'theme3') { ?>
			<div class="mega-testimonial-3">
				<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%; box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3);-webkit-box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3); -moz-box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3); -o-box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3); border: 1px solid #fff;">
					<i class="fa fa-quote-left" style="text-align: center; display: block; font-size: 20px;padding: 10px 0 4px 0;color: #000;"></i>
				<div class="tm-profile3">
					<p style="text-align: center; font-style: italic;">
						<?php echo $content; ?>
					</p>
				</div>
				<div class="tm-prof3" style="text-align: center; margin: 15px 0 5px 0;">
					<p style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold; text-align: center;"><?php echo $name; ?></p>
					<p style="text-align: center;">
						<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none; ">
							<?php echo $prof; ?>
						</a>
					</p>
				</div>
				<?php if ($rating !== 'none') { ?>
					<img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png">
				<?php } ?>
			</div>
		<?php } ?>

		<?php if ($style == 'theme4') { ?>
			<div class="mega-testimonial-4">
				<div class="tm-profile4">
					<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%;">
				</div>
				<div class="tm-right-box" style="padding-left: <?php echo $width+20; ?>px">
					<p class="tm-quotes" style="font-style: italic;">
						<?php echo $content; ?>
					</p><br>
					<div class="tm-prof4">
						<span style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold; text-align: center;"><?php echo $name; ?></span>
						<?php if ($rating !== 'none') { ?>
							<span><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png"></span>
						<?php } ?>
						<p><a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none; ">
							<?php echo $prof; ?>
						</a></p>
					</div>
				</div>
				<div class="Clearfix"></div>
			</div>
		<?php } ?>

		<?php if ($style == 'theme5') { ?>
			<div class="mega-testimonial-5">
				<div class="tm-quotes-5" style="font-style: italic; background: <?php echo $bgclr; ?>;">
					<?php echo $content; ?>
					<span class="icon-after" style="border-right: 8px solid <?php echo $bgclr; ?>;"></span>
				</div>
				<div class="tm-profile-5">
					<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%;">
					<div class="tm-prof4">
						<span style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold; text-align: center;"><?php echo $name; ?></span>
						<p><a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none; ">
							<?php echo $prof; ?>
						</a></p>
						<?php if ($rating !== 'none') { ?>
							<span><img style="border-radius: 0px;" src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png"></span>
						<?php } ?>
					</div>
				</div>
				<div class="Clearfix"></div>
			</div>
		<?php } ?>

		<?php if ($style == 'theme6') { ?>
			<div class="mega-testimonial-6">
				<div class="tm-quotes-6" style="font-style: italic;">
					<?php echo $content; ?>
				</div>
				<div class="tm-profile-6">
					<img class="tm-pic" src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%;">
					<div class="tm-prof6" style="text-align: center; padding-top: 6px;">
						<span style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold; text-align: center;"><?php echo $name; ?></span>
						<p style="text-align: center;">
							<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none; ">
								<?php echo $prof; ?>
							</a>
						</p>
						<?php if ($rating !== 'none') { ?>
							<span><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png"></span>
						<?php } ?>
					</div>
				</div>
				<div class="Clearfix"></div>
			</div>
		<?php } ?>

		<?php if ($style == 'theme7') { ?>
			<div class="mega-testimonial-7">
				<div class="tm-picture">
					<img src="<?php echo $image_url; ?>" alt="<?php echo $alt; ?>" style="width: <?php echo $width; ?>px; border-radius: <?php echo $radius; ?>%;">
				</div>
				<div class="tm-prof-7">
					<span style="font-size: <?php echo $namesize; ?>px; color: <?php echo $nameclr; ?>; font-weight: bold; text-align: center;"><?php echo $name; ?></span>
					<p>
						<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>" title="<?php echo esc_html($link['title']); ?>" style="color: <?php echo $profclr; ?>; font-size: <?php echo $profsize; ?>px; font-style: italic; text-decoration: none; ">
							<?php echo $prof; ?>
						</a>
					</p>
					<?php if ($rating !== 'none') { ?>
						<p style="padding-top: 5px;"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/<?php echo $rating; ?>.png"></p>
					<?php } ?>
				</div>
				<div class="Clearfix"></div>
				<div class="tm-quotes-7" style="font-style: italic;">
					<?php echo $content; ?>
				</div>
			</div>
		<?php } ?>
		
		<?php
		return ob_get_clean();
	}
}


vc_map( array(
	"name" 			=> __( 'Testimonial', 'testimonial' ),
	"base" 			=> "vc_testimonial",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('show client comments as testimonial', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/testimonial.png',
	'params' => array(
		array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Style', 'testimonial' ),
			"param_name" 	=> 	"style",
			"description" 	=> 	'<a href="https://addons.topdigitaltrends.net/testimonial/" target="_blank">See Demo</a>',
			"group" 		=> 	'Settings',
			"value"			=>	array(
				"Theme 1"	=>	"theme1",
				"Theme 2"	=>	"theme2",
				"Theme 3"	=>	"theme3",
				"Theme 4"	=>	"theme4",
				"Theme 5"	=>	"theme5",
				"Theme 6"	=>	"theme6",
				"Theme 7"	=>	"theme7",
			)
        ),
        array(
            "type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Rating', 'testimonial' ),
			"param_name" 	=> 	"rating",
			"group" 		=> 	'Settings',
			"value"			=>	array(
				"Disable"	=>	"none",
				"5 Star"	=>	"5_stars",
				"4 Star"	=>	"4_stars",
				"3 Star"	=>	"3_stars",
			)
        ),
        array(
            "type" 			=> 	"vc_link",
			"heading" 		=> 	__( 'Link To', 'testimonial' ),
			"param_name" 	=> 	"link",
			"description" 	=> 	__( 'write url for open link', 'testimonial' ),
			"group" 		=> 	'Settings',
        ),
        array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'Settings',
		),
		array(
            "type" 			=> 	"attach_image",
			"heading" 		=> 	__( 'Image', 'testimonial' ),
			"param_name" 	=> 	"image_id",
			"description" 	=> 	__( 'Select the image', 'testimonial' ),
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
			"heading" 		=> 	__( 'Image Width', 'testimonial' ),
			"param_name" 	=> 	"width",
			"description" 	=> 	__( 'image width in pixel e.g 100', 'testimonial' ),
			"max"			=>	"",
			"suffix" 		=> 'px',
			"group" 		=> 	'Image',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Radius', 'testimonial' ),
			"param_name" 	=> 	"radius",
			"description" 	=> 	__( 'image border radius in pixel or percentage e,g 50', 'testimonial' ),
			"suffix" 		=> 	'%',
			"value"			=>	"50",
			"group" 		=> 	'Image',
        ),

        // Client Section

        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Client Name', 'testimonial' ),
			"param_name" 	=> 	"name",
			"group" 		=> 	'Client',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Name Font Size', 'testimonial' ),
			"param_name" 	=> 	"namesize",
			"value"			=>	"14",
			"suffix" 		=> 'px',
			"description" 	=> 	__( 'set in pixel e,g 14', 'testimonial' ),
			"group" 		=> 	'Client',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Color of Name', 'testimonial' ),
			"param_name" 	=> 	"nameclr",
			"value"			=>	"#000",
			"group" 		=> 	'Client',
        ),
        array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Client Profession', 'testimonial' ),
			"param_name" 	=> 	"prof",
			"group" 		=> 	'Client',
        ),
        array(
            "type" 			=> 	"vc_number",
			"heading" 		=> 	__( 'Profession Font Size', 'testimonial' ),
			"param_name" 	=> 	"profsize",
			"value"			=>	"14",
			"suffix" 		=> 'px',
			"description" 	=> 	__( 'set in pixel e,g 14', 'testimonial' ),
			"group" 		=> 	'Client',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Color of Profession', 'testimonial' ),
			"param_name" 	=> 	"profclr",
			"value"			=>	"#000",
			"group" 		=> 	'Client',
        ),
        array(
            "type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Comments Background', 'testimonial' ),
			"param_name" 	=> 	"bgclr",
			"group" 		=> 	'Comments',
        ),
        array(
            "type" 			=> 	"textarea_html",
			"heading" 		=> 	__( 'Client Comments', 'testimonial' ),
			"param_name" 	=> 	"content",
			"group" 		=> 	'Comments',
			"value"			=>	"write client comments here as feedback",
        ),
	),
) );

