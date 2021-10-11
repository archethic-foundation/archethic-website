<?php
/**
 * Shortcode: Promo block
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_promo_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_promo_merge_styles');
	function trx_addons_sc_promo_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/_promo.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_promo_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_promo_merge_styles_responsive');
	function trx_addons_sc_promo_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/_promo.responsive.scss';
		return $list;
	}
}



// trx_sc_promo
//-------------------------------------------------------------
/*
[trx_sc_promo id="unique_id" title="Block title" 
subtitle="" link="#" link_text="Buy now"]Description[/trx_sc_promo]
*/
if (!function_exists('trx_addons_sc_promo')) {	
	function trx_addons_sc_promo($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_promo', $atts, array(
			// Individual params
			"type" => "default",
			"size" => "normal",
			"image" => "",
			"images" => "",				// Alter name for the 'image' ('image' reserved by Elementor)
			"image_position" => "left",
			"image_width" => "50%",
			"image_cover" => 1,
			"image_bg_color" => '',
			"video_url" => '',
			"video_embed" => '',
			"video_in_popup" => 0,
			"text_margins" => '',
			"text_align" => "none",
			"text_paddings" => 0,
			"text_float" => "none",
			"text_width" => "none",
			"text_bg_color" => '',
			"full_height" => 0,
			"gap" => 0,
			"icon" => "",
			"icon_type" => '',
			"icon_fontawesome" => "",
			"icon_openiconic" => "",
			"icon_typicons" => "",
			"icon_entypo" => "",
			"icon_linecons" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_style" => 'default',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"link2" => '',
			"link2_text" => esc_html__('Learn more', 'trx_addons'),
			"link2_style" => 'default',
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		$atts['content'] = $content;

		if (empty($atts['icon'])) {
			$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' 
								? $atts['icon_' . $atts['icon_type']] 
								: '';
			trx_addons_load_icons($atts['icon_type']);
		} else if (strtolower($atts['icon']) == 'none')
			$atts['icon'] = '';
		if (empty($atts['image']) && !empty($atts['images']) && is_array($atts['images'])) {
			$atts['image'] = '';
			foreach ($atts['images'] as $img)
				$atts['image'] .= (!empty($atts['image']) ? ',' : '') . $img['url'];
		}
		if (strpos($atts['image'], ',')!==false)
			$atts['image'] = explode(',', $atts['image']);
		else
			$atts['image'] = trx_addons_get_attachment_url($atts['image'], 'full');
		
		
		$atts['gap'] = !empty($atts['gap']) ? trx_addons_prepare_css_value($atts['gap']) : '';
		if (empty($atts['image'])) {
			$atts['text_width'] = '100%';
			$atts['image_width'] = '0%';
			$atts['gap'] = '';
		} else if (empty($atts['title']) && empty($atts['subtitle']) && empty($atts['description']) && empty($atts['content']) 
				&& (empty($atts['link']) || empty($atts['link_text']))) {
			$atts['image_width'] = '100%';
			$atts['text_width'] = '0%';
			$atts['gap'] = '';
		} else {
			$atts['image_width'] = !empty($atts['image_width']) ? trx_addons_prepare_css_value($atts['image_width']) : '50%';
			$image_ed = strpos($atts['image_width'], '%')!==false ? '%' : substr($atts['image_width'], -2);
			if ($atts['gap']) {
				$gap_ed = strpos($atts['gap'], '%')!==false ? '%' : substr($atts['gap'], -2);
				if ($image_ed == $gap_ed) {
					$atts['text_width'] = $image_ed == '%'
									? (100 - ((float)str_replace('%', '', $atts['gap']))/2 - (float)str_replace('%', '', $atts['image_width'])).'%'
									: 'calc(100% - '.esc_attr($atts['gap']).'/2 - '.esc_attr($atts['image_width']).')';
					$atts['image_width'] = ((float)str_replace($image_ed, '', $atts['image_width']) - ((float)str_replace($gap_ed, '', $atts['gap'])) / 2) . $image_ed;
				} else {
					$atts['text_width'] = 'calc(100% - '.esc_attr($atts['gap']).'/2 - '.esc_attr($atts['image_width']).')';
					$atts['image_width'] = 'calc('.esc_attr($atts['image_width']).' - '.esc_attr($atts['gap']).'/2)';
				}
			} else {
				$atts['text_width'] = $image_ed=='%' 
								? (100 - (float)str_replace('%', '', $atts['image_width'])).'%'
								: 'calc(100% - '.esc_attr($atts['image_width']).')';
			}
		}

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'promo/tpl.default.php'
										),
                                        'trx_addons_args_sc_promo',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_promo', $atts, $content);
	}
}



// Add [trx_sc_promo] in the VC shortcodes list
if (!function_exists('trx_addons_sc_promo_add_in_vc')) {
	function trx_addons_sc_promo_add_in_vc() {
		
		add_shortcode("trx_sc_promo", "trx_addons_sc_promo");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_promo", 'trx_addons_sc_promo_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Promo extends WPBakeryShortCodesContainer {}
	}
	add_action('init', 'trx_addons_sc_promo_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_promo_add_in_vc_params')) {
	function trx_addons_sc_promo_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
			"base" => "trx_sc_promo",
			"name" => esc_html__("Promo", 'trx_addons'),
			"description" => wp_kses_data( __("Insert promo block", 'trx_addons') ),
			"category" => esc_html__('ThemeREX', 'trx_addons'),
			'icon' => 'icon_trx_sc_promo',
			"class" => "trx_sc_promo",
			'content_element' => true,
			'is_container' => true,
			'as_child' => array('except' => 'trx_sc_promo'),
			"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
			"show_settings_on_create" => true,
			"params" => array_merge(
				array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Layout", 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						"admin_label" => true,
						"std" => "default",
						"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'promo'), 'trx_sc_promo')),
						"type" => "dropdown"
					)
				),
				trx_addons_vc_add_icon_param(),
				trx_addons_vc_add_title_param(''),
				array(
					array(
						"param_name" => "link2",
						"heading" => esc_html__("Button 2 URL", 'trx_addons'),
						"description" => wp_kses_data( __("URL for the second button (at the side of the image)", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						'dependency' => array(
							'element' => 'type',
							'value' => 'modern'
						),
						"type" => "textfield"
					),
					array(
						"param_name" => "link2_text",
						"heading" => esc_html__("Button 2 text", 'trx_addons'),
						"description" => wp_kses_data( __("Caption for the second button (at the side of the image)", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'type',
							'value' => 'modern'
						),
						"type" => "textfield"
					),
					array(
						"param_name" => "link2_style",
						"heading" => esc_html__("Button 2 style", 'trx_addons'),
						"description" => wp_kses_data( __("Select the style (layout) of the second button", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'type',
							'value' => 'modern'
						),
				        'save_always' => true,
						"std" => "default",
						"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'button'), 'trx_sc_button')),
						"type" => "dropdown"
					),
					array(
						'param_name' => 'text_bg_color',
						'heading' => esc_html__( 'Text bg color', 'trx_addons' ),
						'description' => esc_html__( 'Select custom color, used as background of the text area', 'trx_addons' ),
						'edit_field_class' => 'vc_col-sm-6',
						'type' => 'colorpicker',
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Image", 'trx_addons'),
						"description" => wp_kses_data( __("Select the promo image from the library for this section. Show slider if you select 2+ images", 'trx_addons') ),
						"group" => esc_html__('Image', 'trx_addons'),
						"type" => "attach_images"
					),
					array(
						'param_name' => 'image_bg_color',
						'heading' => esc_html__( 'Image bg color', 'trx_addons' ),
						'description' => esc_html__( 'Select custom color, used as background of the image', 'trx_addons' ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						'type' => 'colorpicker',
					),
					array(
						"param_name" => "image_cover",
						"heading" => esc_html__("Image cover area", 'trx_addons'),
						"description" => wp_kses_data( __("Fit image into area or cover it", 'trx_addons') ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						"std" => "1",
						"value" => array(esc_html__("Image cover area", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "image_position",
						"heading" => esc_html__("Image position", 'trx_addons'),
						"description" => wp_kses_data( __("Place the image to the left or to the right from the text block", 'trx_addons') ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						"value" => array_flip(trx_addons_get_list_sc_promo_positions()),
				        'save_always' => true,
						"std" => "left",
						"type" => "dropdown"
					),
					array(
						"param_name" => "image_width",
						"heading" => esc_html__("Image width", 'trx_addons'),
						"description" => wp_kses_data( __("Width (in pixels or percents) of the block with image", 'trx_addons') ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						"value" => "50%",
						"type" => "textfield"
					),
					array(
						'param_name' => 'video_url',
						'heading' => esc_html__( 'Video URL', 'trx_addons' ),
						'description' => esc_html__( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						'type' => 'textfield'
					),
					array(
						'param_name' => 'video_embed',
						'heading' => esc_html__( 'Video embed code', 'trx_addons' ),
						'description' => esc_html__( 'or paste the HTML code to embed video in this block', 'trx_addons' ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						'type' => 'textarea'
					),
					array(
						"param_name" => "video_in_popup",
						"heading" => esc_html__("Video in the popup", 'trx_addons'),
						"description" => wp_kses_data( __("Open video in the popup window or insert it instead image", 'trx_addons') ),
						'dependency' => array(
							'element' => 'image',
							'not_empty' => true
						),
						"group" => esc_html__('Image', 'trx_addons'),
						"std" => "0",
						"value" => array(esc_html__("Video in the popup", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "size",
						"heading" => esc_html__("Size", 'trx_addons'),
						"description" => wp_kses_data( __("Size of the promo block: normal - one in the row, tiny - only image and title, small - insize two or greater columns, large - fullscreen height", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_promo_sizes()),
						"std" => "normal",
						"type" => "dropdown"
					),
					array(
						"param_name" => "full_height",
						"heading" => esc_html__("Full height", 'trx_addons'),
						"description" => wp_kses_data( __("Stretch the height of the element to the full screen's height", 'trx_addons') ),
						"admin_label" => true,
						"group" => esc_html__('Dimensions', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-6',
						"std" => "0",
						"value" => array(esc_html__("Full Height", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "text_width",
						"heading" => esc_html__("Text width", 'trx_addons'),
						"description" => wp_kses_data( __("Select width of the text block", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_flip(trx_addons_get_list_sc_promo_widths()),
						"std" => "none",
						"type" => "dropdown"
					),
					array(
						"param_name" => "text_float",
						"heading" => esc_html__("Text block floating", 'trx_addons'),
						"description" => wp_kses_data( __("Select alignment (floating position) of the text block", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_flip(trx_addons_get_list_sc_aligns()),
						"std" => "none",
						"type" => "dropdown"
					),
					array(
						"param_name" => "text_align",
						"heading" => esc_html__("Text alignment", 'trx_addons'),
						"description" => wp_kses_data( __("Align text to the left or to the right side inside the block", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_flip(trx_addons_get_list_sc_aligns()),
						"std" => "none",
						"type" => "dropdown"
					),
					array(
						"param_name" => "text_paddings",
						"heading" => esc_html__("Text paddings", 'trx_addons'),
						"description" => wp_kses_data( __("Add horizontal paddings from the text block", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "0",
						"value" => array(esc_html__("With paddings", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "text_margins",
						"heading" => esc_html__("Text margins", 'trx_addons'),
						"description" => wp_kses_data( __("Margins for the all sides of the text block (Example: 30px 10px 40px 30px = top right botton left OR 30px = equal for all sides)", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						"type" => "textfield"
					),
					array(
						"param_name" => "gap",
						"heading" => esc_html__("Gap", 'trx_addons'),
						"description" => wp_kses_data( __("Gap between text and image (in percent)", 'trx_addons') ),
						"group" => esc_html__('Dimensions', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
						"type" => "textfield"
					)
				),
				trx_addons_vc_add_id_param()
			)

		), 'trx_sc_promo' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_promo_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_promo_add_in_elementor' );
	function trx_addons_sc_promo_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Promo extends TRX_Addons_Elementor_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'gap' => 'size+unit',
					'image_width' => 'size+unit'
				]);
			}

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_promo';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Promo', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-image-before-after';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-elements'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				
				$this->start_controls_section(
					'section_sc_promo',
					[
						'label' => __( 'Promo', 'trx_addons' ),
					]
				);

					$this->add_control(
						'type',
						[
							'label' => __( 'Layout', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'promo'), 'trx_sc_promo'),
							'default' => 'default',
						]
					);

					$this->add_icon_param();

					$this->add_control(
						'text_bg_color',
						[
							'label' => __( 'Text bg color', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '',
							'scheme' => [
								'type' => \Elementor\Core\Schemes\Color::get_type(),
								'value' => \Elementor\Core\Schemes\Color::COLOR_1,
							],
							'selectors' => [
								'{{WRAPPER}} .sc_promo_text_inner' => 'background-color: {{VALUE}};',
							]
						]
					);

					$this->add_title_param('', !trx_addons_elm_is_preview() ? [] : [
						'title' => ['default' => __('Promo block', 'trx_addons')],
						'subtitle' => ['default' => $this->get_default_subtitle()],
						'description' => ['default' => $this->get_default_description()],
					]);

					$this->add_control(
						'link2',
						[
							'label' => __( 'Button 2 URL', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::URL,
							'default' => [
								'url' => ''
							],
							'contition' => [
								'type' => ['modern']
							]
						]
					);

					$this->add_control(
						'link2_text',
						[
							'label' => __( 'Button 2 text', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::TEXT,
							'default' => '',
							'contition' => [
								'type' => ['modern']
							]
						]
					);

					$this->add_control(
						'link2_style',
						[
							'label' => __( 'Button 2 style', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'button'), 'trx_sc_button'),
							'default' => 'default',
							'contition' => [
								'type' => ['modern']
							]
						]
					);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_promo_image',
					[
						'label' => __( 'Image & Video', 'trx_addons' ),
					]
				);
				
					$this->add_control(
						'images',
						[
							'label' => __( 'Image', 'trx_addons' ),
							'description' => wp_kses_data( __("Select the promo image from the library for this section. Show slider if you select 2+ images", 'trx_addons') ),
							'type' => \Elementor\Controls_Manager::GALLERY,
							'default' => !trx_addons_elm_is_preview() ? [] : [
								[ 'url' => trx_addons_get_no_image() ]
							]
						]
					);

					$this->add_control(
						'image_bg_color',
						[
							'label' => __( 'Image bg color', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '',
							'scheme' => [
								'type' => \Elementor\Core\Schemes\Color::get_type(),
								'value' => \Elementor\Core\Schemes\Color::COLOR_2,
							],
						]
					);

					$this->add_control(
						'image_cover',
						[
							'label' => __( 'Image cover area', 'trx_addons' ),
							'label_block' => false,
							"description" => wp_kses_data( __("Fit image into area or cover it", 'trx_addons') ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'default' => '1',
							'return_value' => '1',
						]
					);

					$this->add_control(
						'image_position',
						[
							'label' => __( 'Image position', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => trx_addons_get_list_sc_promo_positions(),
							'default' => 'left',
						]
					);

					$this->add_control(
						'image_width',
						[
							'label' => __( 'Image width', 'trx_addons' ),
							'description' => wp_kses_data( __("Specify number of columns for actions. If empty or 0 - auto detect by items number", 'trx_addons') ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'default' => [
								'size' => 50,
								'unit' => '%'
							],
							'size_units' => [ '%', 'px' ],
							'range' => [
								'%' => [
									'min' => 0,
									'max' => 100
								],
								'px' => [
									'min' => 0,
									'max' => 1920
								]
							],
						]
					);

					$this->add_control(
						'video_url',
						[
							'label' => __( 'Video URL', 'trx_addons' ),
							'label_block' => false,
							'description' => __( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
							'type' => \Elementor\Controls_Manager::TEXT,
							'default' => '',
						]
					);

					$this->add_control(
						'video_embed',
						[
							'label' => __( 'Video embed code', 'trx_addons' ),
							'label_block' => true,
							'description' => __( 'or paste the HTML code to embed video in this block', 'trx_addons' ),
							'type' => \Elementor\Controls_Manager::TEXTAREA,
							'rows' => 10,
							'separator' => 'none',
							'default' => '',
						]
					);

					$this->add_control(
						'video_in_popup',
						[
							'label' => __( 'Video in the popup', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1',
						]
					);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_promo_content',
					[
						'label' => __( 'Additional content', 'trx_addons' )
					]
				);

					$this->add_control(
						'content',
						[
							'label' => __( 'Content', 'trx_addons' ),
							'label_block' => true,
							'description' => wp_kses_data(__( "Custom content (html and shortcodes are allowed)", 'trx_addons' )),
							'type' => \Elementor\Controls_Manager::WYSIWYG,
							'default' => '',
							'separator' => 'none'
						]
					);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_promo_dimensions',
					[
						'label' => __( 'Dimensions', 'trx_addons' ),
						'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
					]
				);

					$this->add_control(
						'size',
						[
							'label' => __( 'Size', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => trx_addons_get_list_sc_promo_sizes(),
							'default' => 'normal'
						]
					);

					$this->add_control(
						'full_height',
						[
							'label' => __( 'Full height', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						]
					);

					$this->add_control(
						'text_width',
						[
							'label' => __( 'Text width', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => trx_addons_get_list_sc_promo_widths(),
							'default' => 'none'
						]
					);

					$this->add_control(
						'text_float',
						[
							'label' => __( 'Text block floating', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => trx_addons_get_list_sc_aligns(),
							'default' => 'none'
						]
					);

					$this->add_control(
						'text_align',
						[
							'label' => __( 'Text alignment', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => trx_addons_get_list_sc_aligns(),
							'default' => 'none'
						]
					);

					$this->add_control(
						'text_paddings',
						[
							'label' => __( 'Text paddings', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'default' => '1',
							'return_value' => '1'
						]
					);

					$this->add_control(
						'text_margins',
						[
							'label' => __( 'Text margins', 'trx_addons' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ '%', 'em', 'px' ],
							'selectors' => [
								'{{WRAPPER}} .sc_promo_text_inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							]
						]
					);

					$this->add_control(
						'gap',
						[
							'label' => __( 'Gap', 'trx_addons' ),
							"description" => wp_kses_data( __("Gap between text and image (in percent)", 'trx_addons') ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'default' => [
								'size' => 0
							],
							'size_units' => [ '%', 'em', 'px' ],
							'range' => [
								'%' => [
									'min' => 0,
									'max' => 50
								],
								'em' => [
									'min' => 0,
									'max' => 20
								],
								'px' => [
									'min' => 0,
									'max' => 300
								]
							]
						]
					);
				
				$this->end_controls_section();
			}

			// Prepare specific params for this shortcode
			protected function sc_prepare_atts($atts, $sc='', $level=0) {
				if (!empty($atts['text_margins']) && is_array($atts['text_margins'])) {
					if (!empty($atts['text_margins']['top']) || !empty($atts['text_margins']['right']) || !empty($atts['text_margins']['bottom']) || !empty($atts['text_margins']['left']))
						$atts['text_margins'] = (float) $atts['text_margins']['top'] . $atts['text_margins']['unit']
												. ' ' . (float) $atts['text_margins']['right'] . $atts['text_margins']['unit']
												. ' ' . (float) $atts['text_margins']['bottom'] . $atts['text_margins']['unit']
												. ' ' . (float) $atts['text_margins']['left'] . $atts['text_margins']['unit'];
					else
						$atts['text_margins'] = '';
						
				}
				return parent::sc_prepare_atts($atts, $sc, $level);
			}

			/**
			 * Render widget's template for the editor.
			 *
			 * Written as a Backbone JavaScript template and used to generate the live preview.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _content_template() {
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "promo/tpe.promo.php",
										'trx_addons_args_sc_promo',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Promo() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Promo extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_promo',
				esc_html__('ThemeREX Promo', 'trx_addons'),
				array(
					'classname' => 'widget_promo',
					'description' => __('Display promo block', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'state_emitter' => array(
							'callback' => 'conditional',
							'args'     => array(
								'use_type[modern]: val=="modern"',
								'use_type[hide]: val!="modern"',
							)
						),
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'promo'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					)
				),
				trx_addons_sow_add_icon_param(''),
				trx_addons_sow_add_title_param(''),
				array(
					'link2' => array(
						'label' => __('Second link URL', 'trx_addons'),
						'description' => esc_html__( 'URL for the second button (at the side of the image)', 'trx_addons' ),
						'state_handler' => array(
							"use_type[modern]" => array('show'),
							"use_type[hide]" => array('hide')
						),
						'type' => 'link'
					),
					'link2_text' => array(
						'label' => __('Link text', 'trx_addons'),
						"description" => wp_kses_data( __("Caption for the second button (at the side of the image)", 'trx_addons') ),
						'state_handler' => array(
							"use_type[modern]" => array('show'),
							"use_type[hide]" => array('hide')
						),
						'type' => 'text'
					),
					'text_bg_color' => array(
						'label' => __('Text bg color', 'trx_addons'),
						'description' => esc_html__( 'Select custom color, used as background of the text area', 'trx_addons' ),
						'type' => 'color'
					),
					'sow_section_image' => array(
						'label' => __('Image', 'trx_addons'),
						'hide' => true,
						'type' => 'section',
						'fields' => array(
							'image' => array(
								'label' => __('Image', 'trx_addons'),
								"description" => wp_kses_data( __("Select the promo image from the library for this section. Show slider if you select 2+ images", 'trx_addons') ),
								'state_emitter' => array(
									'callback' => 'conditional',
									'args'     => array(
										'use_image[show]: val',
										'use_image[hide]: ! val',
									)
								),
								'type' => 'media'
							),
							'image_bg_color' => array(
								'label' => __('Image bg color', 'trx_addons'),
								'description' => esc_html__( 'Select custom color, used as background of the image', 'trx_addons' ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								'type' => 'color'
							),
							"image_cover" => array(
								"label" => esc_html__("Cover area", 'trx_addons'),
								"description" => wp_kses_data( __("Fit image into area or cover it", 'trx_addons') ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								"default" => true,
								"type" => "checkbox"
							),
							'image_position' => array(
								'label' => __('Image position', 'trx_addons'),
								"description" => wp_kses_data( __("Place the image to the left or to the right from the text block", 'trx_addons') ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								'default' => 'left',
								'options' => trx_addons_get_list_sc_icon_positions(),
								'type' => 'select'
							),
							'image_width' => array(
								'label' => __('Image width', 'trx_addons'),
								"description" => wp_kses_data( __("Width (in pixels or percents) of the block with image", 'trx_addons') ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								'default' => '50%',
								'type' => 'measurement'
							),
							'video_url' => array(
								'label' => __('Video URL', 'trx_addons'),
								"description" => wp_kses_data( __("Enter link to the video (Note: read more about available formats at WordPress Codex page)", 'trx_addons') ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								'type' => 'text'
							),
							'video_embed' => array(
								'label' => __('Video embed code', 'trx_addons'),
								"description" => wp_kses_data( __("or paste the HTML code to embed video in this block", 'trx_addons') ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								'type' => 'textarea'
							),
							"video_in_popup" => array(
								"label" => esc_html__("Video in the popup", 'trx_addons'),
								"description" => wp_kses_data( __("Open video in the popup window or insert it instead image", 'trx_addons') ),
								'state_handler' => array(
									"use_image[show]" => array('show'),
									"use_image[hide]" => array('hide')
								),
								"default" => false,
								"type" => "checkbox"
							)
						)
					),
					'sow_section_dimensions' => array(
						'label' => __('Dimensions', 'trx_addons'),
						'hide' => true,
						'type' => 'section',
						'fields' => array(
							'size' => array(
								'label' => __('Size', 'trx_addons'),
								"description" => wp_kses_data( __("Size of the promo block: normal - one in the row, tiny - only image and title, small - insize two or greater columns, large - fullscreen height", 'trx_addons') ),
								'default' => 'normal',
								'options' => trx_addons_get_list_sc_promo_sizes(),
								'type' => 'select'
							),
							"full_height" => array(
								"label" => esc_html__("Full height", 'trx_addons'),
								"description" => wp_kses_data( __("Stretch the height of the element to the full screen's height", 'trx_addons') ),
								"default" => false,
								"type" => "checkbox"
							),
							'text_width' => array(
								'label' => __('Text width', 'trx_addons'),
								"description" => wp_kses_data( __("Select width of the text block", 'trx_addons') ),
								'default' => 'none',
								'options' => trx_addons_get_list_sc_promo_widths(),
								'type' => 'select'
							),
							'text_float' => array(
								'label' => __('Text block floating', 'trx_addons'),
								"description" => wp_kses_data( __("Select alignment (floating position) of the text block", 'trx_addons') ),
								'default' => 'none',
								'options' => trx_addons_get_list_sc_aligns(),
								'type' => 'select'
							),
							'text_align' => array(
								'label' => __('Text alignment', 'trx_addons'),
								"description" => wp_kses_data( __("Align text to the left or to the right side inside the block", 'trx_addons') ),
								'default' => 'none',
								'options' => trx_addons_get_list_sc_aligns(),
								'type' => 'select'
							),
							"text_paddings" => array(
								"label" => esc_html__("Text paddings", 'trx_addons'),
								"description" => wp_kses_data( __("Add horizontal paddings from the text block", 'trx_addons') ),
								"default" => false,
								"type" => "checkbox"
							),
							'text_margins' => array(
								'label' => __('Text margins', 'trx_addons'),
								"description" => wp_kses_data( __("Margins for the all sides of the text block (Example: 30px 10px 40px 30px = top right botton left OR 30px = equal for all sides)", 'trx_addons') ),
								'type' => 'text'
							),
							'gap' => array(
								'label' => __('Gap', 'trx_addons'),
								"description" => wp_kses_data( __("Gap between text and image (in percent)", 'trx_addons') ),
								'type' => 'measurement'
							),
						)
					)
				),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_promo', __FILE__, 'TRX_Addons_SOW_Widget_Promo');
}
?>