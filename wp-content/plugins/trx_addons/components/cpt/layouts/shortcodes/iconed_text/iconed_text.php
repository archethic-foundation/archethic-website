<?php
/**
 * Shortcode: Display icons with two text lines
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

	
// trx_sc_layouts_iconed_text
//-------------------------------------------------------------
/*
[trx_sc_layouts_iconed_text id="unique_id" icon="hours" text1="Opened hours" text2="8:00am - 5:00pm"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_iconed_text' ) ) {
	function trx_addons_sc_layouts_iconed_text($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_iconed_text', $atts, array(
			// Individual params
			"type" => "default",
			"icon_type" => '',
			"icon_fontawesome" => "",
			"icon_openiconic" => "",
			"icon_typicons" => "",
			"icon_entypo" => "",
			"icon_linecons" => "",
			"icon" => "",
			"text1" => "",
			"text2" => "",
			"link" => "",
			"hide_on_desktop" => "0",
			"hide_on_notebook" => "0",
			"hide_on_tablet" => "0",
			"hide_on_mobile" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (empty($atts['icon'])) {
			$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' 
								? $atts['icon_' . $atts['icon_type']] 
								: '';
			trx_addons_load_icons($atts['icon_type']);
		} else if (strtolower($atts['icon']) == 'none')
			$atts['icon'] = '';

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'iconed_text/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'iconed_text/tpl.default.php'
										),
										'trx_addons_args_sc_layouts_iconed_text',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_iconed_text', $atts, $content);
	}
}


// Add [trx_sc_layouts_iconed_text] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_iconed_text_add_in_vc')) {
	function trx_addons_sc_layouts_iconed_text_add_in_vc() {
		
		if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_iconed_text", "trx_addons_sc_layouts_iconed_text");

		if (!trx_addons_exists_visual_composer()) return;

		vc_lean_map("trx_sc_layouts_iconed_text", 'trx_addons_sc_layouts_iconed_text_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Layouts_Iconed_Text extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_layouts_iconed_text_add_in_vc', 15);
}

// Return params
if (!function_exists('trx_addons_sc_layouts_iconed_text_add_in_vc_params')) {
	function trx_addons_sc_layouts_iconed_text_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_iconed_text",
				"name" => esc_html__("Layouts: Iconed text", 'trx_addons'),
				"description" => wp_kses_data( __("Insert icon with two text lines to the custom layout", 'trx_addons') ),
				"category" => esc_html__('Layouts', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_iconed_text',
				"class" => "trx_sc_layouts_iconed_text",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons'),
							), 'trx_sc_layouts_iconed_text')),
							"type" => "dropdown"
						),
					),
					trx_addons_vc_add_icon_param(''),
					array(
						array(
							"param_name" => "text1",
							"heading" => esc_html__("Text line 1", 'trx_addons'),
							"description" => wp_kses_data( __("Text in the first line.", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "text2",
							"heading" => esc_html__("Text line 2", 'trx_addons'),
							"description" => wp_kses_data( __("Text in the second line.", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "link",
							"heading" => esc_html__("Link URL", 'trx_addons'),
							"description" => wp_kses_data( __("Specify link URL. If empty - show plain text without link", 'trx_addons') ),
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_hide_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_iconed_text');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_iconed_text_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_iconed_text_add_in_elementor' );
	function trx_addons_sc_layouts_iconed_text_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Layouts_Iconed_Text extends TRX_Addons_Elementor_Layouts_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_layouts_iconed_text';
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
				return __( 'Layouts: Iconed Text', 'trx_addons' );
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
				return 'fa fa-terminal';
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
				return ['trx_addons-layouts'];
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
					'section_sc_layouts_iconed_text',
					[
						'label' => __( 'Layouts: Iconed Ttext', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons'),
							), 'trx_sc_layouts_iconed_text'),
						'default' => 'default'
					]
				);

				$this->add_icon_param('');

				$this->add_control(
					'text1',
					[
						'label' => __( 'Text line 1', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'text2',
					[
						'label' => __( 'Text line 2', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'link', 
					[
						'label' => __("Link", 'trx_addons'),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::URL,
						'default' => [
							'url' => ''
						]
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "iconed_text/tpe.iconed_text.php",
										'trx_addons_args_sc_layouts_iconed_text',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts_Iconed_Text() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Layouts_Iconed_Text extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			
			parent::__construct(
				'trx_addons_sow_widget_layouts_iconed_text',
				esc_html__('ThemeREX Layouts: Iconed Text', 'trx_addons'),
				array(
					'classname' => 'widget_layouts_iconed_text',
					'description' => __('Insert icon with two text lines to the custom layout', 'trx_addons')
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
						"description" => wp_kses_data( __("Select shortcodes's type", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', array(
							'default' => esc_html__('Default', 'trx_addons')
						), $this->get_sc_name()),
						'type' => 'select'
					)
				),
				trx_addons_sow_add_icon_param(''),
				array(
					"text1" => array(
						"label" => esc_html__("Text line 1", 'trx_addons'),
						"description" => wp_kses_data( __("Text in the first line", 'trx_addons') ),
						"type" => "text"
					),
					"text2" => array(
						"label" => esc_html__("Text line 2", 'trx_addons'),
						"description" => wp_kses_data( __("Text in the second line", 'trx_addons') ),
						"type" => "text"
					),
					"link" => array(
						"label" => esc_html__("Link URL", 'trx_addons'),
						"description" => wp_kses_data( __("Specify link URL. If empty - show plain text without link", 'trx_addons') ),
						"type" => "link"
					),
				),
				trx_addons_sow_add_hide_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_layouts_iconed_text', __FILE__, 'TRX_Addons_SOW_Widget_Layouts_Iconed_Text');
}
?>