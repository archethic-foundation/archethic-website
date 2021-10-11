<?php
/**
 * Shortcode: Display post/page featured image
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_featured_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_featured_merge_styles');
	add_filter("trx_addons_filter_merge_styles_layouts", 'trx_addons_sc_layouts_featured_merge_styles');
	function trx_addons_sc_layouts_featured_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'featured/_featured.scss';
		return $list;
	}
}



// trx_sc_layouts_featured
//-------------------------------------------------------------
/*
[trx_sc_layouts_featured id="unique_id" height="40em"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_featured' ) ) {
	function trx_addons_sc_layouts_featured($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_featured', $atts, array(
			// Individual params
			"type" => "default",
			"height" => "",
			"align" => '',
			"hide_on_desktop" => "0",
			"hide_on_notebook" => "0",
			"hide_on_tablet" => "0",
			"hide_on_mobile" => "0",
			"hide_on_frontpage" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		$atts['content'] = do_shortcode($content);

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'featured/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'featured/tpl.default.php'
										),
										'trx_addons_args_sc_layouts_featured',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_featured', $atts, $content);
	}
}


// Add [trx_sc_layouts_featured] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_featured_add_in_vc')) {
	function trx_addons_sc_layouts_featured_add_in_vc() {
		
		if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_featured", "trx_addons_sc_layouts_featured");

		if (!trx_addons_exists_visual_composer()) return;

		vc_lean_map("trx_sc_layouts_featured", 'trx_addons_sc_layouts_featured_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Layouts_Featured extends WPBakeryShortCodesContainer {}

	}
	add_action('init', 'trx_addons_sc_layouts_featured_add_in_vc', 15);
}

// Return params
if (!function_exists('trx_addons_sc_layouts_featured_add_in_vc_params')) {
	function trx_addons_sc_layouts_featured_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_featured",
				"name" => esc_html__("Layouts: Featured image", 'trx_addons'),
				"description" => wp_kses_data( __("Insert post/page featured image", 'trx_addons') ),
				"category" => esc_html__('Layouts', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_featured',
				"class" => "trx_sc_layouts_featured",
				"content_element" => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_sc_layouts_featured'),
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
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
							), 'trx_sc_layouts_featured')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "height",
							"heading" => esc_html__("Height of the block", 'trx_addons'),
							"description" => wp_kses_data( __("Specify height of this block. If empty - use default height", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Content alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment of the inner content in this block", 'trx_addons') ),
							"admin_label" => true,
							"value" => array_flip(trx_addons_get_list_sc_aligns(true, false)),
							"std" => "inherit",
							"type" => "dropdown"
						)
					),
					trx_addons_vc_add_hide_param(false, true),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_featured');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_featured_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_featured_add_in_elementor' );
	function trx_addons_sc_layouts_featured_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Layouts_Featured extends TRX_Addons_Elementor_Layouts_Widget {

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
					'height' => 'size+unit'
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
				return 'trx_sc_layouts_featured';
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
				return __( 'Layouts: Featured', 'trx_addons' );
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
				return 'fa fa-file-image-o';
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
					'section_sc_layouts_featured',
					[
						'label' => __( 'Layouts: Featured', 'trx_addons' ),
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
							), 'trx_sc_layouts_featured'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'height',
					[
						'label' => __( 'Height of the block', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify height of this block. If empty - use default height", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0,
							'unit' => 'px'
						],
						'size_units' => ['px', 'em'],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 800
							],
							'em' => [
								'min' => 0,
								'max' => 50
							]
						],
						'selectors' => [
							'{{WRAPPER}} .sc_layouts_featured' => 'min-height: {{SIZE}}{{UNIT}};',
						]
					]
				);

				$this->add_control(
					'align', 
					[
						'label' => __("Content alignment", 'trx_addons'),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(true, false),
						'default' => 'inherit'
					]
				);

				$this->add_control(
					'hide_on_frontpage',
					[
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label' => __( 'Hide on Frontpage', 'trx_addons' ),
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "featured/tpe.featured.php",
										'trx_addons_args_sc_layouts_featured',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts_Featured() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Layouts_Featured extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_layouts_featured',
				esc_html__('ThemeREX Layouts: Featured', 'trx_addons'),
				array(
					'classname' => 'widget_layouts_featured',
					'description' => __('Insert post/page featured image', 'trx_addons')
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
					),
					"height" => array(
						"label" => esc_html__("Height of the block", 'trx_addons'),
						"description" => wp_kses_data( __("Specify height of this block. If empty - use default height", 'trx_addons') ),
						"type" => "measurement"
					),
					"align" => array(
						"label" => esc_html__("Content alignment", 'trx_addons'),
						"description" => wp_kses_data( __("Select alignment of the inner content in this block", 'trx_addons') ),
						"options" => trx_addons_get_list_sc_aligns(true, false),
						"default" => "inherit",
						"type" => "select"
					),
				),
				trx_addons_sow_add_hide_param(false, true),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_layouts_featured', __FILE__, 'TRX_Addons_SOW_Widget_Layouts_Featured');
}
?>