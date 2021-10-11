<?php
/**
 * Shortcode: Popup container
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_popup_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_popup_merge_styles');
	function trx_addons_sc_popup_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'popup/_popup.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_popup_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_popup_merge_scripts');
	function trx_addons_sc_popup_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'popup/popup.js';
		return $list;
	}
}


// trx_sc_popup
//-------------------------------------------------------------
/*
[trx_sc_popup id="unique_id"]Popup content[/trx_sc_popup]
*/
if ( !function_exists( 'trx_addons_sc_popup' ) ) {
	function trx_addons_sc_popup($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_popup', $atts, array(
			// Individual params
			'type' => 'default',
			// Common params
			"id" => "",
			"popup_id" => "",		// Alter name for id in Elementor ('id' is reserved by Elementor)
			"class" => "",
			"css" => "",
			// Content from non-containers PageBuilder
			"content" => ""
			)
		);
		
		$output = '';

		if (!empty($atts['popup_id']))
			$atts['id'] = $atts['popup_id'];

		$atts['content'] = str_replace('wp-audio-shortcode', 'wp-audio-shortcode-noinit', do_shortcode(empty($atts['content']) ? $content : $atts['content']));
		
		if (!empty($atts['content'])) {

			if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
				wp_enqueue_script( 'trx_addons-sc_popup', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'popup/popup.js'), array('jquery'), null, true );
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'popup/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'popup/tpl.default.php'
											),
											'trx_addons_args_sc_popup', 
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();

		}
		
		trx_addons_add_inline_html(apply_filters('trx_addons_sc_output', $output, 'trx_sc_popup', $atts, $content));
		return '';
	}
}


// Add [trx_sc_popup] in the VC shortcodes list
if (!function_exists('trx_addons_sc_popup_add_in_vc')) {
	function trx_addons_sc_popup_add_in_vc() {
		
		add_shortcode("trx_sc_popup", "trx_addons_sc_popup");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_popup", 'trx_addons_sc_popup_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Popup extends WPBakeryShortCodesContainer {}
	}
	add_action('init', 'trx_addons_sc_popup_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_popup_add_in_vc_params')) {
	function trx_addons_sc_popup_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_popup",
				"name" => esc_html__("Popup", 'trx_addons'),
				"description" => wp_kses_data( __("Create popup window with some content", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_popup',
				"class" => "trx_sc_popup",
				'content_element' => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_sc_popup'),
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							"admin_label" => true,
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'popup'), 'trx_sc_popup')),
							"type" => "dropdown"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_popup' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_popup_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_popup_add_in_elementor' );
	function trx_addons_sc_popup_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Popup extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_popup';
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
				return __( 'Popup', 'trx_addons' );
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
				return 'eicon-parallax';
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
					'section_sc_popup',
					[
						'label' => __( 'Popup', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'popup'), 'trx_sc_popup'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'popup_id',
					[
						'label' => __( "Popup's ID (required)", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Popup ID is required!", 'trx_addons' ),
						'default' => 'popup_1'
					]
				);

				$this->add_control(
					'content',
					[
						'label' => __( 'Content', 'trx_addons' ),
						'label_block' => true,
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => '',
						'separator' => 'none'
					]
				);

				$this->end_controls_section();
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "popup/tpe.popup.php",
										'trx_addons_args_sc_popup',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Popup() );
	}
}
?>