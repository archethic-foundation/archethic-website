<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_mvc_advanced_button extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'btn_animation' =>		'hvr-fade',
			'align' 		=>		'left',
			'icon_position' =>		'left',
			'padding_top' 	=>		'10',
			'padding_left' 	=>		'25',
			'btn_block' 	=>		'',
			'btn_radius' 	=>		'',
			'btn_next' 		=>		'',
			'btn_url' 		=>		'',
			'btn_text' 		=>		'Start a Conversation',
			'btn_text2' 	=>		'Click Me!',
			'btn_icon' 		=>		'',
			'border_style' 	=>		'solid',
			'btn_border' 	=>		'',
			'border_width' 	=>		'0',
			'btn_clr' 		=>		'#000',
			'btn_bg' 		=>		'',
			'btn_hvrclr' 	=>		'#fff',
			'btn_hvrbg' 	=>		'',
			'btn_size' 		=>		'18',
			'icon_size' 	=>		'18',
			'icon_space' 	=>		'5',
			'transform' 	=>		'default',
			'text_style' 	=>		'default',
			'text_decoration' 	=>	'default',
			'btn_shadow' 	=>	'none',
			'use_theme_fonts'		=>		'',
			'google_fonts'	=>		'default',
			'classname' 	=>	'',
		), $atts ) );
		$some_id = rand(5, 500);
		$btn_url = vc_build_link($btn_url);
		wp_enqueue_style( 'advanced-button-css', plugins_url( '../css/advanced-buttons.css' , __FILE__ ));
		$content = wpb_js_remove_wpautop($content, true);
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		$googleallfonts = "";
		if($google_fonts != "default"){
			$fontsData = $this->getFontsData( $atts, 'google_fonts' );
			$googleFontsStyles = $this->googleFontsStyles( $fontsData );
			$this->enqueueGoogleFonts( $fontsData );
			if (empty($googleFontsStyles) == false){
				$googleallfonts = esc_attr( implode( ';', $googleFontsStyles ) );
			} else {
				$googleallfonts = $googleFontsStyles;
			}
		}
		ob_start(); ?>
		
		<div class="mega_uae_btn_<?php echo $some_id; ?> <?php echo $classname; ?>" style="justify-content: <?php echo $align; ?>; display: flex;">
			<?php if ($btn_animation == 'hvr-fade' || $btn_animation == 'button--saqui' || $btn_animation == 'button--sacnite') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="maw_advanced_btn <?php echo $btn_animation; ?> <?php echo $btn_block; ?>" style="color: <?php echo $btn_clr; ?>;background: <?php echo $btn_bg; ?> ; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?>; border-radius: <?php echo $btn_radius; ?>px; font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; <?php echo $googleallfonts; ?>;" data-text="<?php echo esc_attr($btn_text); ?>"> 
					<?php if ($icon_position == 'left') { ?>
						<i class="<?php echo $btn_icon; ?> icon__left"></i> 
					<?php } ?>
						<?php echo $btn_text; ?>
					<?php if ($icon_position == 'right') { ?>
						<i class="<?php echo $btn_icon; ?> icon__right"></i> 
					<?php } ?>
				</a>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if ($btn_animation == 'button--winona') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="maw_advanced_btn <?php echo $btn_animation; ?> <?php echo $btn_block; ?>" style="color: <?php echo $btn_clr; ?>;background: <?php echo $btn_bg; ?> ; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?>; border-radius: <?php echo $btn_radius; ?>px; font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; <?php echo $googleallfonts; ?>;" data-text=""> 
					<span>
						<?php if ($icon_position == 'left') { ?>
							<i class="<?php echo $btn_icon; ?> icon__left"> </i>
						<?php } ?>
							<?php echo $btn_text; ?>
						<?php if ($icon_position == 'right') { ?>
							<i class="<?php echo $btn_icon; ?> icon__right"> </i>
						<?php } ?>
					</span>			
					<span style="padding: <?php echo $padding_top; ?>px 0;" class="advanced-btn-after"><?php echo $btn_text2; ?></span>
				</a>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if ($btn_animation == 'button--rayen') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="maw_advanced_btn <?php echo $btn_animation; ?> <?php echo $btn_block; ?>" style="color: <?php echo $btn_clr; ?>;background: <?php echo $btn_bg; ?> ; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?>; border-radius: <?php echo $btn_radius; ?>px; font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; <?php echo $googleallfonts; ?>;" data-text=""> 
					<span style="background: <?php echo $btn_hvrbg; ?>; padding: <?php echo $padding_top; ?>px 0; color: <?php echo $btn_hvrclr; ?>;" class="advanced-btn-before"><?php echo $btn_text2; ?></span>
					<span>
						<?php if ($icon_position == 'left') { ?>
							<i class="<?php echo $btn_icon; ?> icon__left"> </i>
						<?php } ?>
							<?php echo $btn_text; ?>
						<?php if ($icon_position == 'right') { ?>
							<i class="<?php echo $btn_icon; ?> icon__right"> </i>
						<?php } ?>
					</span>			
				</a>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if ($btn_animation == 'button--wapasha' || $btn_animation == 'button--isi' || $btn_animation == 'button--moema' || $btn_animation == 'button--wayra' || $btn_animation == 'button--ujarak' || $btn_animation == 'button--aylen' || $btn_animation == 'button--nuka' || $btn_animation == 'button--shikoba' || $btn_animation == 'button--quidel') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="maw_advanced_btn <?php echo $btn_animation; ?> <?php echo $btn_block; ?>" style="color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?>; border-radius: <?php echo $btn_radius; ?>px; font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; <?php echo $googleallfonts; ?>;" data-text="">
					<?php if ($icon_position == 'left') { ?>
						<i class="<?php echo $btn_icon; ?> button__icon icon__left"> </i>
					<?php } ?>
					<span><?php echo $btn_text; ?></span>
					<?php if ($icon_position == 'right') { ?>
						<i class="<?php echo $btn_icon; ?> button__icon icon__right"> </i>
					<?php } ?>
				</a>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if ($btn_animation == 'button--antiman' || $btn_animation == 'button--pipaluk') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="maw_advanced_btn <?php echo $btn_animation; ?> <?php echo $btn_block; ?>" style="color: <?php echo $btn_clr; ?>; border-radius: <?php echo $btn_radius; ?>px; font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; <?php echo $googleallfonts; ?>;" data-text="">
					<?php if ($icon_position == 'left') { ?>
						<i class="<?php echo $btn_icon; ?> button__icon icon__left"> </i>
					<?php } ?>
					<span><?php echo $btn_text; ?></span>
					<?php if ($icon_position == 'right') { ?>
						<i class="<?php echo $btn_icon; ?> button__icon icon__right"> </i>
					<?php } ?>
				</a>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if ($btn_animation == 'button--float') { ?>
				<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="maw_advanced_btn <?php echo $btn_animation; ?> <?php echo $btn_block; ?>" style="color: <?php echo $btn_clr; ?>; background: <?php echo $btn_bg; ?>; border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?>; border-radius: <?php echo $btn_radius; ?>px; font-size: <?php echo $btn_size; ?>px; padding: <?php echo $padding_top; ?>px <?php echo $padding_left; ?>px; <?php echo $googleallfonts; ?>;">
					<?php echo $btn_text; ?>
					<i class="<?php echo $btn_icon; ?>" style="font-size: <?php echo $icon_size ?>px;"></i>
				</a>
			<?php } ?>
		</div>
		<style>
			.mega_uae_btn_<?php echo $some_id; ?> .maw_advanced_btn{
				text-transform: <?php echo $transform ?> !important;
				font-style: <?php echo $text_style ?> !important;
				text-decoration: <?php echo $text_decoration ?> !important;
				box-<?php echo $btn_shadow ?>: 0 10px 20px rgba(0, 0, 0, 0.3) !important;
			}
			<?php if ($icon_position == 'left') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .maw_advanced_btn .icon__left {
					font-size: <?php echo $icon_size ?>px !important;
					padding-right: <?php echo $icon_space ?>px !important;
				}
			<?php }
			if ($icon_position == 'right') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .maw_advanced_btn .icon__right {
					font-size: <?php echo $icon_size ?>px !important;
					padding-left: <?php echo $icon_space ?>px !important;
				}
			<?php } ?>
			
			.mega_uae_btn_<?php echo $some_id; ?> .button--antiman:hover,
			.mega_uae_btn_<?php echo $some_id; ?> .button--nuka:hover,
			.mega_uae_btn_<?php echo $some_id; ?> .button--aylen:hover,
			.mega_uae_btn_<?php echo $some_id; ?> .button--pipaluk:hover {
				color: <?php echo $btn_hvrclr; ?> !important;
			}

			<?php if ($btn_animation == 'hvr-fade') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .hvr-fade:hover{
					background: <?php echo $btn_hvrbg; ?> !important;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--moema') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--moema:hover {
					background: <?php echo $btn_hvrbg; ?> !important;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--winona') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--winona:hover {
					background: <?php echo $btn_hvrbg; ?> !important;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>
			
			<?php if ($btn_animation == 'button--rayen') { ?>
				/*.mega_uae_btn_<?php echo $some_id; ?> .button--rayen {
					background: <?php echo $btn_bg; ?> ;
					border: <?php echo $border_width; ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?>;
				}*/
			<?php } ?>
			<?php if ($btn_animation == 'button--wayra') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--wayra:hover {
					color: <?php echo $btn_hvrclr; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--wayra:hover::before {
					background: <?php echo $btn_hvrbg; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--ujarak') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--ujarak:hover {
					color: <?php echo $btn_hvrclr; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--ujarak::before {
					background: <?php echo $btn_hvrbg; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--isi') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--isi::before{
					background: <?php echo $btn_hvrbg; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--isi:hover {
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>
		
			<?php if ($btn_animation == 'button--saqui') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--saqui::after {
					padding: <?php echo $padding_top; ?>px 0;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--float') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--float:hover {
					padding-right: <?php echo $icon_space+45; ?>px !important;
					background: <?php echo $btn_hvrbg; ?> !important;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--sacnite') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--sacnite {
					background: none !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--sacnite::before {
					box-shadow: inset 0 0 0 35px <?php echo $btn_bg; ?>;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--sacnite:hover::before {
					box-shadow: inset 0 0 0 2px <?php echo $btn_hvrbg; ?>;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--sacnite:hover {
					background: none !important;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--quidel') { ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--quidel {
					background: <?php echo $btn_border; ?>;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--quidel::after {
					background: <?php echo $btn_bg; ?>;
					top: <?php echo $border_width; ?>px; left: <?php echo $border_width; ?>px;
				    right: <?php echo $border_width; ?>px; bottom: <?php echo $border_width; ?>px;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--quidel::before {
					background: <?php echo $btn_hvrbg; ?>;
				}
			<?php } ?>

			<?php if ($btn_animation == 'button--wapasha'): ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--wapasha:hover {
					background: <?php echo $btn_hvrbg; ?> !important;
					color: <?php echo $btn_hvrclr; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--wapasha::before{
					border-color: <?php echo $btn_border; ?> !important;
				}
			<?php endif ?>

			<?php if ($btn_animation == 'button--pipaluk'): ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--pipaluk::before{
					border-color: <?php echo $btn_border; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--pipaluk::after{
					background: <?php echo $btn_bg; ?> !important;
					color: <?php echo $btn_clr; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--pipaluk:hover::after {
					background: <?php echo $btn_hvrbg; ?> !important;
				}
			<?php endif ?>

			<?php if ($btn_animation == 'button--aylen'): ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--aylen{
					background: <?php echo $btn_bg; ?> !important;
					color: <?php echo $btn_clr; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--aylen::before,
				.mega_uae_btn_<?php echo $some_id; ?> .button--aylen::after{
					background: <?php echo $btn_hvrbg; ?> !important;
				}
			<?php endif ?>

			<?php if ($btn_animation == 'button--nuka'): ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--nuka::before{
					background: <?php echo $btn_border;; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--nuka::after{
					background: <?php echo $btn_bg; ?> !important;
					color: <?php echo $btn_clr; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--nuka:hover::after{
					background: <?php echo $btn_hvrbg; ?> !important;
				}
			<?php endif ?>

			<?php if ($btn_animation == 'button--antiman'): ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--antiman::after {
					background: <?php echo $btn_bg; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--antiman::before {
					background: <?php echo $btn_hvrbg; ?> !important;
					border: <?php echo $border_width ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?> !important;
				}
			<?php endif ?>

			<?php if ($btn_animation == 'button--shikoba'): ?>
				.mega_uae_btn_<?php echo $some_id; ?> .button--shikoba {
					background: <?php echo $btn_bg; ?> !important;
					border: <?php echo $border_width ?>px <?php echo $border_style; ?> <?php echo $btn_border; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--shikoba:hover {
					background: <?php echo $btn_hvrbg; ?> !important;
				}
				.mega_uae_btn_<?php echo $some_id; ?> .button--shikoba i {
					padding-top: <?php echo $padding_top; ?>px !important;
				}
			<?php endif ?>
		</style>

		<?php
		return ob_get_clean();
	}

	protected function getFontsData( $atts, $paramName ) {
		$googleFontsParam = new Vc_Google_Fonts();
		$field = WPBMap::getParam( $this->shortcode, $paramName );
		$fieldSettings = isset( $field['settings'], $field['settings']['fields'] ) ? $field['settings']['fields'] : array();
		$fontsData = strlen( $atts[ $paramName ] ) > 0 ? $googleFontsParam->_vc_google_fonts_parse_attributes( $fieldSettings, $atts[ $paramName ] ) : '';

		return $fontsData;
	}

	protected function googleFontsStyles( $fontsData ) {
		// Inline styles
		$fontFamily = explode( ':', $fontsData['values']['font_family'] );
		$styles[] = 'font-family:' . $fontFamily[0];
		$fontStyles = explode( ':', $fontsData['values']['font_style'] );
		if(count($fontStyles)>1){
			$styles[] = 'font-weight:' . $fontStyles[1];
			$styles[] = 'font-style:' . $fontStyles[2];
			return $styles;
		} else {
			return "";
		}

	}

	protected function enqueueGoogleFonts( $fontsData ) {
		// Get extra subsets for settings (latin/cyrillic/etc)
		$settings = get_option( 'wpb_js_google_fonts_subsets' );
		if ( is_array( $settings ) && ! empty( $settings ) ) {
			$subsets = '&subset=' . implode( ',', $settings );
		} else {
			$subsets = '';
		}

		// We also need to enqueue font from googleapis
		if ( isset( $fontsData['values']['font_family'] ) ) {
			wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $fontsData['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $fontsData['values']['font_family'] . $subsets );
		}
	}
}


vc_map( array(
	"name" 			=> __( 'Advanced Button', 'button' ),
	"base" 			=> "mvc_advanced_button",
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('Animated style buttons', 'button'),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/hoverbutton.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Button Align', 'button' ),
			"param_name" 	=> 	"align",
			"group" 		=> 	'General',
			"value"			=>	array(
				"Left"			=>	"left",
				"Center"		=>	"center",
				"Right"			=>	"flex-end",
			)
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Button Effects', 'button' ),
			"param_name" 	=> 	"btn_animation",
			"description" 	=> __( 'Choose button style <a href="http://addons.topdigitaltrends.net/advanced-button/">See Demo</a>', 'button' ),
			"group" 		=> 	'General',
			"value"			=>	array(
				"Fade"				=>	"hvr-fade",
				"Float"				=>	"button--float",
				"Winona"			=>	"button--winona",
				"Rayen"				=>	"button--rayen",
				"Ujarak"			=>	"button--ujarak",
				"Wayra"				=>	"button--wayra",
				"Pipaluk"			=>	"button--pipaluk",
				"Isi"				=>	"button--isi",
				"Aylen"				=>	"button--aylen",
				"Wapasha"			=>	"button--wapasha",
				"Nuka"				=>	"button--nuka",
				"Antiman"			=>	"button--antiman",
				"Shikoba"			=>	"button--shikoba",
				"Saqui"				=>	"button--saqui",
				"Moema"				=>	"button--moema",
				"Quidel"			=>	"button--quidel",
				"Sacnite"			=>	"button--sacnite",
				"Naira (Pro)"		=>	"pro",
				"Itzel (Pro)"		=>	"pro",
				"Tamaya (Pro)"		=>	"pro",
				"Dual Shade (Pro)"	=>	"pro",
				"Neon (Pro)"		=>	"pro",
				"Neon Shadow (Pro)"	=>	"pro",
				"Inity (Pro)"		=>	"pro",
			)
		),

		array(
			"type" 			=> "iconpicker",
			"heading" 		=> __( 'Select icon', 'button' ),
			"param_name" 	=> "btn_icon",
			"description" 	=> __( 'it will be show within text', 'button' ),
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Icon Align', 'button' ),
			"param_name" 	=> 	"icon_position",
			"group" 		=> 	'General',
			"value"			=>	array(
				"Left"			=>	"left",
				"Right"			=>	"right",
			)
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button text', 'button' ),
			"param_name" 	=> "btn_text",
			"value" 		=> "Start a Conversation",
			"description" 	=> __( 'Write button text', 'button' ),
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __( 'Button text 2', 'button' ),
			"param_name" 	=> "btn_text2",
			"description" 	=> 	__( 'it will show on hover', 'modal_popup' ),
			"value" 		=> "Click Me!",
			"dependency" 	=> array('element' => "btn_animation", 'value' => array('button--winona', 'button--rayen')),
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Padding [Top Bottom]', 'button' ),
			"edit_field_class" => "vc_col-sm-6 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "padding_top",
			"description" 	=> __( 'It will increase height of button e.g 10', 'button' ),
			"value"			=>	"10",
			"suffix" 		=> 'px',
			"group" 		=> 'General',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Padding [Left Right]', 'button' ),
			"edit_field_class" => "vc_col-sm-6 wdo_items_to_show wdo_margin_bottom",
			"param_name" 	=> "padding_left",
			"description" 	=> __( 'It will increase width of button e.g 20', 'button' ),
			"value"			=>	"25",
			"suffix" 		=> 'px',
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Set Full Width Button?', 'button' ),
			"param_name" 	=> 	"btn_block",
			"group" 		=> 	'General',
			"value" 		=> array(
				"Enable"		=> "btn_block",
			)
		),
		array(
			"type" 			=> "vc_link",
			"heading" 		=> __( 'Button URL', 'button' ),
			"param_name" 	=> "btn_url",
			"description" 	=> __( 'Write button url as link', 'button' ),
			"group" 		=> 'General',
		),

		array(
            "type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Extra class name', 'megaaddons' ),
			"param_name" 	=> 	"classname",
			"description" 	=> 	"Style particular content element differently - add a class name and refer to it in custom CSS.",
			"group" 		=> 	'General',
        ),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #0073aa;font-weight:600;"><a href="https://1.envato.market/02aNL" target="_blank" style="text-decoration: none;">Get the Pro version for more stunning elements and customization options.</a></span>', 'ihover' ),
			"group" 		=> 'General',
		),

		/** color **/

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Text color', 'button' ),
			"param_name" 	=> "btn_clr",
			"description" 	=> __( 'Set color of text e.g #ffff', 'button' ),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'button' ),
			"param_name" 	=> "btn_bg",
			"description" 	=> __( 'Set color of background e.g #269CE9', 'button' ),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Hover Text color', 'button' ),
			"param_name" 	=> "btn_hvrclr",
			"description" 	=> __( 'Set color of text on hover e.g #ffff', 'button' ),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Background color', 'button' ),
			"param_name" 	=> "btn_hvrbg",
			"description" 	=> __( 'Set color of background on hover e.g #269CE9', 'button' ),
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_url",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Border Styling</span>', 'ihover' ),
			"group" 		=> 'Color',
		),

		/** border **/

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Border Style', 'button' ),
			"param_name" 	=> "border_style",
			"group" 		=> 'Color',
			"value"			=>	array(
				"None"		=>		"none",
				"Solid"		=>		"solid",
				"Dotted"	=>		"dotted",
				"Ridge"		=>		"ridge",
				"Dashed"	=>		"dashed",
				"Double"	=>		"double",
				"Groove"	=>		"groove",
				"Inset"		=>		"inset",
			)
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Border width', 'button' ),
			"param_name" 	=> "border_width",
			"description" 	=> __( 'Set width of border in pixel e.g 1', 'button' ),
			"value"			=>	"0",
			"suffix" 		=> 'px',
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> "colorpicker",
			"heading" 		=> __( 'Border color', 'button' ),
			"param_name" 	=> "btn_border",
			"description" 	=> __( 'Set color of border e.g #269CE9', 'button' ),
			"group" 		=> 'Color',
		),
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Radius', 'button' ),
			"param_name" 	=> "btn_radius",
			"description" 	=> __( 'set button radius e.g 5', 'button' ),
			"suffix" 		=> 'px',
			"group" 		=> 'Color',
		),

		// =================== Settings ======================= //
		
		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Text Size', 'button' ),
			"param_name" 	=> "btn_size",
			"description" 	=> __( 'Set font size in pixel e.g 18', 'button' ),
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Icon Size', 'button' ),
			"param_name" 	=> "icon_size",
			"description" 	=> __( 'Set font size in pixel e.g 18', 'button' ),
			"value"			=>	"18",
			"suffix" 		=> 'px',
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> "vc_number",
			"heading" 		=> __( 'Icon Text Space', 'button' ),
			"param_name" 	=> "icon_space",
			"value"			=>	"5",
			"suffix" 		=> 'px',
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urls",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Typography</span>', 'ihover' ),
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Transform', 'button' ),
			"param_name" 	=> "transform",
			"group" 		=> 'Settings',
			"value"			=>	array(
				"Default"		=>		"default",
				"Uppercase"		=>		"uppercase",
				"Lowercase"		=>		"lowercase",
				"Capitalize"	=>		"capitalize",
				"Normal"		=>		"normal",
			)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Style', 'button' ),
			"param_name" 	=> "text_style",
			"group" 		=> 'Settings',
			"value"			=>	array(
				"Default"		=>		"default",
				"Normal"		=>		"normal",
				"Italic"		=>		"italic",
				"Oblique"		=>		"oblique",
			)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Decoration', 'button' ),
			"param_name" 	=> "text_decoration",
			"group" 		=> 'Settings',
			"value"			=>	array(
				"Default"		=>		"default",
				"Underline"		=>		"underline",
				"Overline"		=>		"overline",
				"Line Through"	=>		"line-through",
				"None"			=>		"none",
			)
		),

		array(
			"type" 			=> "dropdown",
			"heading" 		=> __( 'Shadow', 'button' ),
			"param_name" 	=> "btn_shadow",
			"group" 		=> 'Settings',
			"value"			=>	array(
				"None"			=>		"none",
				"Shadow"		=>		"shadow",
			)
		),

		array(
			"type" 			=> "vc_links",
			"param_name" 	=> "caption_urlss",
			"class"			=>	"ult_param_heading",
			"description" 	=> __( '<span style="Background: #ddd;padding: 10px; display: block; color: #302f2f;font-weight:600;">Google Fonts Option</span>', 'ihover' ),
			"group" 		=> 'Settings',
		),

		array(
			"type" 			=> 	"checkbox",
			"heading" 		=> 	__( 'Use theme default font family?', 'creativelink' ),
			"param_name" 	=> 	"use_theme_fonts",
			"description" 	=> 	__( 'Use font family from the theme.', 'creativelink' ),
			"group" 		=> 	'Settings',
			"value" 		=> array(
					"Yes"		=> "yes",
			)
		),

		array(
			'type' => 'google_fonts',
			'param_name' => 'google_fonts',
			'value' => 'default',
			'settings' => array(
				'fields' => array(
					'font_family_description' => __( 'Select font family.', 'js_composer' ),
					'font_style_description' => __( 'Select font styling.', 'js_composer' ),
				),
			),
			"group" 		=> 	'Settings',
			'weight' => 0,
			'dependency' => array(
				'element' => 'use_theme_fonts',
				'value_not_equal_to' => 'yes',
			),
		),
	),
) );