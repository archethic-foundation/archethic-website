<?php
/**
 * Shortcode: Skills
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_skills_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_skills_merge_styles');
	function trx_addons_sc_skills_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/_skills.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_skills_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_skills_merge_styles_responsive');
	function trx_addons_sc_skills_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/_skills.responsive.scss';
		return $list;
	}
}

	
// Merge skills specific scripts into single file
if ( !function_exists( 'trx_addons_sc_skills_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_skills_merge_scripts');
	function trx_addons_sc_skills_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.js';
		return $list;
	}
}


// Load shortcode's specific scripts if current mode is Preview in the PageBuilder
if ( !function_exists( 'trx_addons_sc_skills_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_preview_scripts", 'trx_addons_sc_skills_load_scripts');
	function trx_addons_sc_skills_load_scripts() {
		wp_enqueue_script( 'trx_addons-chart', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/chart.min.js'), array('jquery'), null, true );
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'trx_addons-sc_skills', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.js'), array('jquery'), null, true );
	}
}



// trx_sc_skills
//-------------------------------------------------------------
/*
[trx_sc_skills id="unique_id" type="pie" cutout="99" values="encoded json data"]
*/
if ( !function_exists( 'trx_addons_sc_skills' ) ) {
	function trx_addons_sc_skills($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_skills', $atts, array(
			// Individual params
			"type" => "counter",
			"cutout" => 0,
			"compact" => 0,
			"max" => 100,
			"color" => '',
			"bg_color" => '',
			"back_color" => '',		// Alter param name for VC (it broke bg_color)
			"border_color" => '',
			"columns" => "",
			"values" => "",
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
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['values']))
			$atts['values'] = (array) vc_param_group_parse_atts($atts['values']);

		$output = '';

		if (is_array($atts['values']) && count($atts['values']) > 0) {

			if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
				wp_enqueue_script( 'trx_addons-sc_skills', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.js'), array('jquery'), null, true );
	
			if (empty($atts['bg_color'])) $atts['bg_color'] = $atts['back_color'];
	
			$atts['cutout'] = min(100, max(0, (int) $atts['cutout']));
	
			if (empty($atts['max'])) {
				$atts['max'] = 0;
				foreach ($atts['values'] as $v) {
					$value = str_replace('%', '', $v['value']);
					if ($atts['max'] < $value) $atts['max'] = $value;
				}
			} else
				$atts['max'] = str_replace('%', '', $atts['max']);
	
			$atts['compact'] = $atts['compact']<1 ? 0 : 1;
			$atts['columns'] = $atts['compact']==0 
									? ($atts['columns'] < 1 
										? count($atts['values']) 
										: min($atts['columns'], count($atts['values']))
										)
									: 1;
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/tpl.counter.php'
											),
											'trx_addons_args_sc_skills', 
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_skills', $atts, $content);
	}
}


// Add [trx_sc_skills] in the VC shortcodes list
if (!function_exists('trx_addons_sc_skills_add_in_vc')) {
	function trx_addons_sc_skills_add_in_vc() {
		
		add_shortcode("trx_sc_skills", "trx_addons_sc_skills");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_skills", 'trx_addons_sc_skills_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Skills extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_skills_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_skills_add_in_vc_params')) {
	function trx_addons_sc_skills_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_skills",
				"name" => esc_html__("Skills", 'trx_addons'),
				"description" => wp_kses_data( __("Skill counters and pie charts", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_skills',
				"class" => "trx_sc_skills",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Type", 'trx_addons'),
							"description" => wp_kses_data( __("Select counter's type", 'trx_addons') ),
							"admin_label" => true,
					        'save_always' => true,
							'edit_field_class' => 'vc_col-sm-4',
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'skills'), 'trx_sc_skills')),
							"std" => "counter",
							"type" => "dropdown"
						),
						array(
							"param_name" => "cutout",
							"heading" => esc_html__("Cutout", 'trx_addons'),
							"description" => wp_kses_data( __("Specify pie cutout. You will see border width as (100% - cutout value)", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							'dependency' => array(
								'element' => 'type',
								'value' => 'pie'
							),
							"type" => "textfield"
						),
						array(
							"param_name" => "compact",
							"heading" => esc_html__("Compact pie", 'trx_addons'),
							"description" => wp_kses_data( __("Show all values in one pie or each value in the single pie", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-4',
							'dependency' => array(
								'element' => 'type',
								'value' => 'pie'
							),
							"std" => "0",
							"value" => array(esc_html__("Compact", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							'param_name' => 'color',
							'heading' => esc_html__( 'Color', 'trx_addons' ),
							'description' => esc_html__( 'Select custom color to fill each item', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							'value' => '#ff0000',
							'type' => 'colorpicker',
						),
						array(
							'param_name' => 'back_color',	// Alter name for bg_color in VC (it broke bg_color)
							'heading' => esc_html__( 'Background color', 'trx_addons' ),
							'description' => esc_html__( "Select custom color for item's background", 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'dependency' => array(
								'element' => 'type',
								'value' => 'pie'
							),
							'value' => '',
							'type' => 'colorpicker',
						),
						array(
							'param_name' => 'border_color',
							'heading' => esc_html__( 'Border color', 'trx_addons' ),
							'description' => esc_html__( "Select custom color for item's border", 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'dependency' => array(
								'element' => 'type',
								'value' => 'pie'
							),
							'value' => '',
							'type' => 'colorpicker',
						),
						array(
							'param_name' => 'max',
							'heading' => esc_html__( 'Max. value', 'trx_addons' ),
							'description' => esc_html__( 'Enter max value for all items', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-6 vc_new_row',
							'value' => 100,
							'type' => 'textfield',
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of columns for skills. If empty - auto detect by items number", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'values',
							'heading' => esc_html__( 'Values', 'trx_addons' ),
							"description" => wp_kses_data( __("Specify values for each counter", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
								array(
									'title' => esc_html__( 'One', 'trx_addons' ),
									'value' => '60',
									'color' => '',
									'icon' => '',
									'icon_fontawesome' => 'empty',
									'icon_openiconic' => 'empty',
									'icon_typicons' => 'empty',
									'icon_entypo' => 'empty',
									'icon_linecons' => 'empty'
								),
								array(
									'title' => esc_html__( 'Two', 'trx_addons' ),
									'value' => '40',
									'color' => '',
									'icon' => '',
									'icon_fontawesome' => 'empty',
									'icon_openiconic' => 'empty',
									'icon_typicons' => 'empty',
									'icon_entypo' => 'empty',
									'icon_linecons' => 'empty'
								),
							), 'trx_sc_skills') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array_merge(array(
									array(
										'param_name' => 'title',
										'heading' => esc_html__( 'Title', 'trx_addons' ),
										'description' => esc_html__( 'Enter title of this item', 'trx_addons' ),
										'admin_label' => true,
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'value',
										'heading' => esc_html__( 'Value', 'trx_addons' ),
										'description' => esc_html__( 'Enter value of this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'color',
										'heading' => esc_html__( 'Color', 'trx_addons' ),
										'description' => esc_html__( 'Select custom color of this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-4',
										'type' => 'colorpicker',
									),
								), trx_addons_vc_add_icon_param('')
							), 'trx_sc_skills' )
						)
					),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_skills' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_skills_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_skills_add_in_elementor' );
	function trx_addons_sc_skills_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Skills extends TRX_Addons_Elementor_Widget {

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
					'cutout' => 'size'
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
				return 'trx_sc_skills';
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
				return __( 'Skills', 'trx_addons' );
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
				return 'eicon-skill-bar';
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
					'section_sc_skills',
					[
						'label' => __( 'Skills', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'skills'), 'trx_sc_skills'),
						'default' => 'counter',
					]
				);

				$this->add_control(
					'cutout',
					[
						'label' => __( 'Cutout', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify pie cutout. You will see border width as (100% - cutout value)", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100
							]
						],
						'condition' => [
							'type' => ['pie']
						]
					]
				);

				$this->add_control(
					'compact',
					[
						'label' => __( 'Compact pie', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => [
							'type' => ['pie']
						]
					]
				);

				$this->add_control(
					'color',
					[
						'label' => __( 'Color', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'scheme' => [
							'type' => \Elementor\Core\Schemes\Color::get_type(),
							'value' => \Elementor\Core\Schemes\Color::COLOR_1,
						]
					]
				);

				$this->add_control(
					'bg_color',
					[
						'label' => __( 'Background color', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'scheme' => [
							'type' => \Elementor\Core\Schemes\Color::get_type(),
							'value' => \Elementor\Core\Schemes\Color::COLOR_2,
						],
						'condition' => [
							'type' => ['pie']
						]
					]
				);

				$this->add_control(
					'border_color',
					[
						'label' => __( 'Border color', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'scheme' => [
							'type' => \Elementor\Core\Schemes\Color::get_type(),
							'value' => \Elementor\Core\Schemes\Color::COLOR_3,
						],
						'condition' => [
							'type' => ['pie']
						]
					]
				);

				$this->add_control(
					'max',
					[
						'label' => __( 'Max. value', 'trx_addons' ),
						'label_block' => false,
						'placeholder' => __( 'Max. value', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '100'
					]
				);
				
				$this->add_control(
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify number of columns for skills. If empty or 0 - auto detect by items number", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 12
							]
						]
					]
				);

				$this->add_control(
					'values',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'title' => esc_html__( 'First item', 'trx_addons' ),
								'value' => '60',
								'color' => '',
								'icon' => 'icon-star-empty',
							],
							[
								'title' => esc_html__( 'Second item', 'trx_addons' ),
								'value' => '80',
								'color' => '',
								'icon' => 'icon-heart-empty',
							],
							[
								'title' => esc_html__( 'Third item', 'trx_addons' ),
								'value' => '75',
								'color' => '',
								'icon' => 'icon-clock-empty',
							]
						], 'trx_sc_skills'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							[
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'label_block' => true,
									'placeholder' => __( "Item's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'value',
									'label' => __( "Item's value", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Item's value", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'color',
									'label' => __( 'Color', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::COLOR,
									'default' => '',
									'scheme' => [
										'type' => \Elementor\Core\Schemes\Color::get_type(),
										'value' => \Elementor\Core\Schemes\Color::COLOR_1,
									],
								]
							],
							$this->get_icon_param() ),
							'trx_sc_skills'),
						'title_field' => '{{{ title }}}: {{{ value }}}',
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "skills/tpe.skills.php",
										'trx_addons_args_sc_skills',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Skills() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Skills extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_skills',
				esc_html__('ThemeREX Skills', 'trx_addons'),
				array(
					'classname' => 'widget_skills',
					'description' => __('Display skills chart', 'trx_addons')
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
								'use_type[pie]: val=="pie"',
								'use_type[hide]: val!="pie"',
							)
						),
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'skills'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					),
					"cutout" => array(
						"label" => esc_html__("Cutout", 'trx_addons'),
						"description" => wp_kses_data( __("Specify pie cutout. You will see border width as 100% - cutout value", 'trx_addons') ),
						'state_handler' => array(
							"use_type[pie]" => array('show'),
							"use_type[hide]" => array('hide')
						),
						"min" => 0,
						"max" => 99,
						"type" => "slider"
					),
					"compact" => array(
						"label" => esc_html__("Compact", 'trx_addons'),
						"description" => wp_kses_data( __("Show all values in one pie or each value in the single pie", 'trx_addons') ),
						'state_handler' => array(
							"use_type[pie]" => array('show'),
							"use_type[hide]" => array('hide')
						),
						"default" => false,
						"type" => "checkbox"
					),
					'color' => array(
						'label' => __('Color', 'trx_addons'),
						'description' => esc_html__( 'Select custom color to fill each item', 'trx_addons' ),
						"default" => '#ff0000',
						'type' => 'color'
					),
					'bg_color' => array(
						'label' => __('Background color', 'trx_addons'),
						'description' => esc_html__( "Select custom color for item's background", 'trx_addons' ),
						'state_handler' => array(
							"use_type[pie]" => array('show'),
							"use_type[hide]" => array('hide')
						),
						'type' => 'color'
					),
					'border_color' => array(
						'label' => __('Border color', 'trx_addons'),
						'description' => esc_html__( "Select custom color for item's border", 'trx_addons' ),
						'state_handler' => array(
							"use_type[pie]" => array('show'),
							"use_type[hide]" => array('hide')
						),
						'type' => 'color'
					),
					"max" => array(
						"label" => esc_html__("Max. value", 'trx_addons'),
						"description" => wp_kses_data( __("Enter max value for all items", 'trx_addons') ),
						"default" => 100,
						"type" => "number"
					),
					"columns" => array(
						"label" => esc_html__("Columns", 'trx_addons'),
						"description" => wp_kses_data( __("Specify number of columns for skills. If empty - auto detect by items number", 'trx_addons') ),
						"type" => "number"
					),
					'values' => array(
						'label' => __('Values', 'trx_addons'),
						'item_name'  => __( 'Skill value', 'trx_addons' ),
						'item_label' => array(
							'selector'     => "[name*='title']",
							'update_event' => 'change',
							'value_method' => 'val'
						),
						'type' => 'repeater',
						'fields' => apply_filters('trx_addons_sc_param_group_fields', array_merge(array(
								'title' => array(
									'label' => __('Title', 'trx_addons'),
									'description' => esc_html__( 'Enter title of the item', 'trx_addons' ),
									'type' => 'text'
								),
								'value' => array(
									'label' => __('Value', 'trx_addons'),
									"description" => wp_kses_data( __("Enter value of this item", 'trx_addons') ),
									'type' => 'text'
								),
								'color' => array(
									'label' => __('Color', 'trx_addons'),
									'description' => esc_html__( "Select custom color of this item", 'trx_addons' ),
									'type' => 'color'
								)
							),
							trx_addons_sow_add_icon_param('')
						), $this->get_sc_name())
					)
				),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_skills', __FILE__, 'TRX_Addons_SOW_Widget_Skills');
}
?>