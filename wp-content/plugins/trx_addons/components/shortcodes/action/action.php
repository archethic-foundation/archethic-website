<?php
/**
 * Shortcode: Action
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

	
	
// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_action_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_action_merge_styles');
	function trx_addons_sc_action_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'action/_action.scss';
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_action_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_action_merge_styles_responsive');
	function trx_addons_sc_action_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'action/_action.responsive.scss';
		return $list;
	}
}



// trx_sc_action
//-------------------------------------------------------------
/*
[trx_sc_action id="unique_id" columns="2" values="encoded_json_data"]
*/
if ( !function_exists( 'trx_addons_sc_action' ) ) {
	function trx_addons_sc_action($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_action', $atts, array(
			// Individual params
			"type" => "default",
			"columns" => "",
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
			"actions" => "",
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
			"full_height" => 0,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['actions']))
			$atts['actions'] = (array) vc_param_group_parse_atts( $atts['actions'] );
		$output = '';
		if (is_array($atts['actions']) && count($atts['actions']) > 0) {
			if (empty($atts['columns'])) $atts['columns'] = count($atts['actions']);
			$atts['columns'] = max(1, min(count($atts['actions']), $atts['columns']));
			$atts['slider'] = $atts['slider'] > 0 && count($atts['actions']) > $atts['columns'];
			$atts['slides_space'] = max(0, (int) $atts['slides_space']);
			if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';
	
			foreach ($atts['actions'] as $k=>$v) {
				if (!empty($v['description']))
					$atts['actions'][$k]['description'] = preg_replace( '/\\[(.*)\\]/', '<b>$1</b>', function_exists('vc_value_from_safe') ? vc_value_from_safe( $v['description'] ) : $v['description'] );
			}
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'action/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'action/tpl.default.php'
											),
											'trx_addons_args_sc_action',
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_action', $atts, $content);
	}
}


// Add [trx_sc_action] in the VC shortcodes list
if (!function_exists('trx_addons_sc_action_add_in_vc')) {
	function trx_addons_sc_action_add_in_vc() {
		
		add_shortcode("trx_sc_action", "trx_addons_sc_action");
		
		if (!trx_addons_exists_visual_composer()) return;

		vc_lean_map("trx_sc_action", 'trx_addons_sc_action_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Action extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_action_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_action_add_in_vc_params')) {
	function trx_addons_sc_action_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_action",
				"name" => esc_html__("Action", 'trx_addons'),
				"description" => wp_kses_data( __("Insert 'Call to action' or custom Events as slider or columns layout", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_action',
				"class" => "trx_sc_action",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"admin_label" => true,
					        'save_always' => true,
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'action'), 'trx_sc_action')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of columns for icons. If empty - auto detect by items number", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "textfield"
						),
						array(
							"param_name" => "full_height",
							"heading" => esc_html__("Full height", 'trx_addons'),
							"description" => wp_kses_data( __("Stretch the height of the element to the full screen's height", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"admin_label" => true,
							"std" => 0,
							"value" => array(esc_html__("Full Height", 'trx_addons') => 1 ),
							"type" => "checkbox"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'actions',
							'heading' => esc_html__( 'Actions', 'trx_addons' ),
							"description" => wp_kses_data( __("Select icons, specify title and/or description for each item", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
											array(
												'position' => 'mc',
												'title' => esc_html__( 'One', 'trx_addons' ),
												'subtitle' => '',
												'date' => '',
												'info' => '',
												'description' => '',
												'link' => '',
												'link_text' => '',
												'color' => '',
												'bg_color' => '',
												'image' => '',
												'bg_image' => '',
												'height' => '',
												'icon' => '',
												'icon_fontawesome' => 'empty',
												'icon_openiconic' => 'empty',
												'icon_typicons' => 'empty',
												'icon_entypo' => 'empty',
												'icon_linecons' => 'empty'
											),
										), 'trx_sc_action') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array_merge(array(
									array(
										"param_name" => "position",
										"heading" => esc_html__("Text position", 'trx_addons'),
										"description" => wp_kses_data( __("Select position of the titles", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-6',
										"std" => "mc",
										"value" => array_flip(trx_addons_get_list_sc_positions()),
										"type" => "dropdown"
									),
									array(
										"param_name" => "height",
										"heading" => esc_html__("Height", 'trx_addons'),
										"description" => wp_kses_data( __("Height of the block", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-6',
										"type" => "textfield"
									),
									array(
										'param_name' => 'title',
										'heading' => esc_html__( 'Title', 'trx_addons' ),
										'description' => esc_html__( 'Enter title of the item', 'trx_addons' ),
										'admin_label' => true,
										'edit_field_class' => 'vc_col-sm-6 vc_new_row',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'subtitle',
										'heading' => esc_html__( 'Subtitle', 'trx_addons' ),
										'description' => esc_html__( 'Enter subtitle of the item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'date',
										'heading' => esc_html__( 'Date', 'trx_addons' ),
										'description' => esc_html__( 'Specify date (and/or time) of this event', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6 vc_new_row',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'info',
										'heading' => esc_html__( 'Info', 'trx_addons' ),
										'description' => esc_html__( 'Additional info for this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'description',
										'heading' => esc_html__( 'Description', 'trx_addons' ),
										'description' => esc_html__( 'Enter short description of the item', 'trx_addons' ),
										'type' => 'textarea_safe'
									),
									array(
										'param_name' => 'link',
										'heading' => esc_html__( 'Link', 'trx_addons' ),
										'description' => esc_html__( 'URL to link this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'textfield'
									),
									array(
										"param_name" => "link_text",
										"heading" => esc_html__("Link's text", 'trx_addons'),
										"description" => wp_kses_data( __("Caption of the link", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-6',
										"type" => "textfield"
									),
									array(
										'param_name' => 'color',
										'heading' => esc_html__( 'Color', 'trx_addons' ),
										'description' => esc_html__( 'Select custom color of this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'colorpicker'
									),
									array(
										'param_name' => 'bg_color',
										'heading' => esc_html__( 'Background Color', 'trx_addons' ),
										'description' => esc_html__( 'Select custom background color of this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'colorpicker'
									),
									array(
										"param_name" => "image",
										"heading" => esc_html__("Image", 'trx_addons'),
										"description" => wp_kses_data( __("Select or upload image or specify URL from other site to use it as icon", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-6',
										"type" => "attach_image"
									),
									array(
										"param_name" => "bg_image",
										"heading" => esc_html__("Background image", 'trx_addons'),
										"description" => wp_kses_data( __("Select or upload image or specify URL from other site to use it as background of this item", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-6',
										"type" => "attach_image"
									)
								),
								trx_addons_vc_add_icon_param('')
							), 'trx_sc_action')
						)
					),
					trx_addons_vc_add_slider_param(),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_action' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_action_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_action_add_in_elementor' );
	function trx_addons_sc_action_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Action extends TRX_Addons_Elementor_Widget {

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
				return 'trx_sc_action';
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
				return __( 'Actions', 'trx_addons' );
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
				return 'eicon-call-to-action';
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
					'section_sc_action',
					[
						'label' => __( 'Actions', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'action'), 'trx_sc_action'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify number of columns for actions. If empty or 0 - auto detect by items number", 'trx_addons') ),
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
					'actions',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'position' => 'mc',
								'height' => ['size' => 0, 'unit' => 'px'],
								'title' => esc_html__( 'First action', 'trx_addons' ),
								'subtitle' => $this->get_default_subtitle(),
								'date' => '',
								'info' => '',
								'description' => $this->get_default_description(),
								'link' => ['url' => ''],
								'link_text' => '',
								'icon' => 'icon-star-empty',
								'image' => ['url' => ''],
								'color' => '',
								'bg_color' => '#aa0000',
								'bg_image' => ['url' => ''],
							],
							[
								'position' => 'mc',
								'height' => ['size' => 0, 'unit' => 'px'],
								'title' => esc_html__( 'Second action', 'trx_addons' ),
								'subtitle' => $this->get_default_subtitle(),
								'date' => '',
								'info' => '',
								'description' => $this->get_default_description(),
								'link' => ['url' => ''],
								'link_text' => '',
								'icon' => 'icon-heart-empty',
								'image' => ['url' => ''],
								'color' => '',
								'bg_color' => '#00aa00',
								'bg_image' => ['url' => ''],
							],
							[
								'position' => 'mc',
								'height' => ['size' => 0, 'unit' => 'px'],
								'title' => esc_html__( 'Third action', 'trx_addons' ),
								'subtitle' => $this->get_default_subtitle(),
								'date' => '',
								'info' => '',
								'description' => $this->get_default_description(),
								'link' => ['url' => ''],
								'link_text' => '',
								'icon' => 'icon-clock-empty',
								'image' => ['url' => ''],
								'color' => '',
								'bg_color' => '#0000aa',
								'bg_image' => ['url' => ''],
							]
						], 'trx_sc_action'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							[
								[
									'name' => 'position',
									'label' => __( 'Position', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::SELECT,
									'options' => trx_addons_get_list_sc_positions(),
									'default' => 'mc',
									// Not work in the group params - hide always!
									//'condition' => [
									//	'type' => ['default', 'simple']
									//]
								],
								[
									'name' => 'height',
									'label' => __( 'Height', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::SLIDER,
									'default' => [
										'size' => 0,
										'unit' => 'px'
									],
									'range' => [
										'px' => [
											'min' => 0,
											'max' => 1000
										],
										'em' => [
											'min' => 0,
											'max' => 100,
											'step' => 0.1
										],
									],
									'size_units' => [ 'px', 'em' ]
								],
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Item's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'subtitle',
									'label' => __( 'Subtitle', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Item's subtitle", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'date',
									'label' => __( 'Date', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Event's date", 'trx_addons' ),
									'default' => '',
									'contition' => ['type' => 'event']
								],
								[
									'name' => 'info',
									'label' => __( 'Additional info', 'trx_addons' ),
									'label_block' => true,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Additional info about this item", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'description',
									'label' => __( 'Description', 'trx_addons' ),
									'label_block' => true,
									'type' => \Elementor\Controls_Manager::TEXTAREA,
									'placeholder' => __( "Short description of this item", 'trx_addons' ),
									'default' => '',
									'separator' => 'none',
									'rows' => 10,
									'show_label' => false,
								],
								[
									'name' => 'link',
									'label' => __( 'Link', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::URL,
									'placeholder' => __( 'http://your-link.com', 'trx_addons' ),
								],
								[
									'name' => 'link_text',
									'label' => __( "Link's text", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Link's text", 'trx_addons' ),
									'default' => ''
								],
							],
							$this->get_icon_param(),
							[
								[
									'name' => 'image',
									'label' => __( 'Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
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
								],
								[
									'name' => 'bg_color',
									'label' => __( 'Background Color', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::COLOR,
									'default' => '',
									'scheme' => [
										'type' => \Elementor\Core\Schemes\Color::get_type(),
										'value' => \Elementor\Core\Schemes\Color::COLOR_2,
									],
								],
								[
									'name' => 'bg_image',
									'label' => __( 'Background Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								]
							]),
							'trx_sc_action'),
						'title_field' => '{{{ title }}}',
					]
				);

				$this->end_controls_section();

				$this->add_slider_param();
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "action/tpe.action.php",
										'trx_addons_args_sc_action',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Action() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Action extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_action',
				esc_html__('ThemeREX Action', 'trx_addons'),
				array(
					'classname' => 'widget_action',
					'description' => __('Display action', 'trx_addons')
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
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'action'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					),
					"columns" => array(
						"label" => esc_html__("Columns", 'trx_addons'),
						"description" => wp_kses_data( __("Specify number of columns for icons. If empty - auto detect by items number", 'trx_addons') ),
						"type" => "number"
					),
					"full_height" => array(
						"label" => esc_html__("Full height", 'trx_addons'),
						"description" => wp_kses_data( __("Stretch the height of the element to the full screen's height", 'trx_addons') ),
						"default" => false,
						"type" => "checkbox"
					),
					'actions' => array(
						'label' => __('Actions', 'trx_addons'),
						'item_name'  => __( 'Action', 'trx_addons' ),
						'item_label' => array(
							'selector'     => "[name*='title']",
							'update_event' => 'change',
							'value_method' => 'val'
						),
						'type' => 'repeater',
						'fields' => apply_filters('trx_addons_sc_param_group_fields', array_merge(array(
								'position' => array(
									'label' => __('Text position inside item', 'trx_addons'),
									"description" => wp_kses_data( __("Select position of the titles", 'trx_addons') ),
									'default' => 'mc',
									'options' => trx_addons_get_list_sc_positions(),
									'type' => 'select'
								),
								'title' => array(
									'label' => __('Item title', 'trx_addons'),
									'description' => esc_html__( 'Enter title of the item', 'trx_addons' ),
									'type' => 'text'
								),
								'subtitle' => array(
									'label' => __('Item subtitle', 'trx_addons'),
									'description' => esc_html__( 'Enter subtitle of the item', 'trx_addons' ),
									'type' => 'text'
								),
								'date' => array(
									'label' => __('Action date', 'trx_addons'),
									'description' => esc_html__( 'Specify date (and/or time) of this event', 'trx_addons' ),
									'type' => 'text'
								),
								'info' => array(
									'label' => __('Brief info', 'trx_addons'),
									'description' => esc_html__( 'Additional info for this item', 'trx_addons' ),
									'type' => 'text'
								),
								'description' => array(
									'rows' => 10,
									'label' => __('Item description', 'trx_addons'),
									'description' => esc_html__( 'Enter short description of the item', 'trx_addons' ),
									'type' => 'tinymce'
								),
								'link' => array(
									'label' => __('Link', 'trx_addons'),
									'description' => esc_html__( 'URL to link this item', 'trx_addons' ),
									'type' => 'link'
								),
								'link_text' => array(
									'label' => __('Link text', 'trx_addons'),
									"description" => wp_kses_data( __("Caption of the link", 'trx_addons') ),
									'type' => 'text'
								)
							),
							trx_addons_sow_add_icon_param(''),
							array(
								'image' => array(
									'label' => __('or Icon image', 'trx_addons'),
									"description" => wp_kses_data( __("Select or upload image or specify URL from other site to use it as icon", 'trx_addons') ),
									'type' => 'media'
								),
								'color' => array(
									'label' => __('Text color', 'trx_addons'),
									'description' => esc_html__( 'Select custom color of this item', 'trx_addons' ),
									'type' => 'color'
								),
								'bg_color' => array(
									'label' => __('Background color', 'trx_addons'),
									'description' => esc_html__( 'Select custom background color of this item', 'trx_addons' ),
									'type' => 'color'
								),
								'bg_image' => array(
									'label' => __('or Background image', 'trx_addons'),
									"description" => wp_kses_data( __("Select or upload image or specify URL from other site to use it as background of this item", 'trx_addons') ),
									'type' => 'media'
								),
								'height' => array(
									'label' => __('Item height', 'trx_addons'),
									"description" => wp_kses_data( __("Height of the block", 'trx_addons') ),
									'type' => 'measurement'
								)
							)
						), $this->get_sc_name())
					)
				),
				trx_addons_sow_add_slider_param(),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_action', __FILE__, 'TRX_Addons_SOW_Widget_Action');
}
?>