<?php
/**
 * Shortcode: Table
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.3
 */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_table_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_table_merge_styles');
	function trx_addons_sc_table_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'table/_table.scss';
		return $list;
	}
}


// trx_sc_table
//-------------------------------------------------------------
/*
[trx_sc_table id="unique_id" style="default" aligh="left"]
*/
if ( !function_exists( 'trx_addons_sc_table' ) ) {
	function trx_addons_sc_table($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_table', $atts, array(
			// Individual params
			"type" => "default",
			"width" => "100%",
			"align" => "none",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_style" => 'default',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			"content" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		
		if (!empty($content))
			$atts['content'] = do_shortcode(str_replace(
												array('<p><table', 'table></p>', '><br />'),
												array('<table', 'table>', '>'),
												html_entity_decode($content, ENT_COMPAT, 'UTF-8')
												)
								);
		
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'table/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'table/tpl.default.php'
										),
										'trx_addons_args_sc_table', 
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_table', $atts, $content);
	}
}


// Add [trx_sc_table] in the VC shortcodes list
if (!function_exists('trx_addons_sc_table_add_in_vc')) {
	function trx_addons_sc_table_add_in_vc() {
		
		add_shortcode("trx_sc_table", "trx_addons_sc_table");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_table", 'trx_addons_sc_table_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Table extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_table_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_table_add_in_vc_params')) {
	function trx_addons_sc_table_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_table",
				"name" => esc_html__("Table", 'trx_addons'),
				"description" => wp_kses_data( __("Insert a table", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_table',
				"class" => "trx_sc_table",
				'content_element' => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_sc_table'),
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'table'), 'trx_sc_table')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Table alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment of the table", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-4',
							"value" => array_flip(trx_addons_get_list_sc_aligns()),
							"std" => "none",
							"type" => "dropdown"
						),
						array(
							"param_name" => "width",
							"heading" => esc_html__("Width", 'trx_addons'),
							"description" => wp_kses_data( __("Width of the table", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"value" => '100%',
							"type" => "textfield"
						),
						array(
							'heading' => __( 'Content', 'trx_addons' ),
							"description" => wp_kses_data( __("Content, created with any table-generator, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/", 'trx_addons') ),
							'param_name' => 'content',
							'value' => '',
							'holder' => 'div',
							'type' => 'textarea_html',
						)
					),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
				
			), 'trx_sc_table' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_table_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_table_add_in_elementor' );
	function trx_addons_sc_table_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Table extends TRX_Addons_Elementor_Widget {

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
					'width' => 'size+unit'
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
				return 'trx_sc_table';
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
				return __( 'Table', 'trx_addons' );
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
				return 'eicon-table';
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
					'section_sc_table',
					[
						'label' => __( 'Table', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'table'), 'trx_sc_table'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'align',
					[
						'label' => __( 'Alignment', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(),
						'default' => 'none',
					]
				);
				
				$this->add_control(
					'width',
					[
						'label' => __( 'Width', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 100,
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
								'max' => 1170
							]
						],
						'selectors' => [
							'{{WRAPPER}} .sc_table' => 'width:{{SIZE}}{{UNIT}};',
						]
					]
				);
				
				$descr = __("Replace this text with content, created with any table-generator, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/", 'trx_addons')
						. '<br>'
						. __("<b>Attention!</b> To save html tags please paste generated code in the tab 'Text' (not in the tab 'Visual')!", 'trx_addons');
				
				$this->add_control(
					'content',
					[
						'label' => __( 'Content', 'trx_addons' ),
						'label_block' => true,
						'description' => wp_kses_data( $descr ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => $descr
					]
				);

				$this->end_controls_section();

				$this->add_title_param();
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "table/tpe.table.php",
										'trx_addons_args_sc_table',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Table() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Table extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_table',
				esc_html__('ThemeREX Table', 'trx_addons'),
				array(
					'classname' => 'widget_table',
					'description' => __('Insert table from any table-generator', 'trx_addons')
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
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'table'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					),
					"align" => array(
						"label" => esc_html__("Table alignment", 'trx_addons'),
						"description" => wp_kses_data( __("Select alignment of the table", 'trx_addons') ),
						"options" => trx_addons_get_list_sc_aligns(),
						"default" => "none",
						"type" => "select"
					),
					"width" => array(
						"label" => esc_html__("Width", 'trx_addons'),
						"description" => wp_kses_data( __("Width of the table", 'trx_addons') ),
						"type" => "measurement"
					),
					"content" => array(
						"label" => esc_html__("Content", 'trx_addons'),
						"description" => wp_kses_data( __("Content, created with any table-generator, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/", 'trx_addons') ),
						"type" => "textarea"
					)
				),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_table', __FILE__, 'TRX_Addons_SOW_Widget_Table');
}
?>