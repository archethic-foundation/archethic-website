<?php
/**
 * Widget: WooCommerce Search (Advanced search form)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

if (!defined('TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS')) define('TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS', 5);

// Load widget
if (!function_exists('trx_addons_widget_woocommerce_search_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_woocommerce_search_load' );
	function trx_addons_widget_woocommerce_search_load() {
		if (!trx_addons_exists_woocommerce()) return;
		register_widget('trx_addons_widget_woocommerce_search');
	}
}

// Widget Class
class trx_addons_widget_woocommerce_search extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_woocommerce_search', 'description' => esc_html__('Advanced search form for products', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_woocommerce_search', esc_html__('ThemeREX WooCommerce Search', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$type = isset($instance['type']) ? $instance['type'] : 'inline';
		if (!isset($instance['fields'])) {
			$fields = array();
			for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
				$fields[] = array(
					'text' => isset($instance["field{$i}_text"]) ? $instance["field{$i}_text"] : '',
					'filter' => isset($instance["field{$i}_filter"]) ? $instance["field{$i}_filter"] : ''
				);
			}
		} else
			$fields = $instance['fields'];
		$last_text = isset($instance['last_text']) ? $instance['last_text'] : '';
		$button_text = !empty($instance['button_text']) ? $instance['button_text'] : __('Filter now', 'trx_addons');

		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_API . 'woocommerce/tpl.widget.woocommerce_search_type_'.trx_addons_esc($type).'.php',
										TRX_ADDONS_PLUGIN_API . 'woocommerce/tpl.widget.woocommerce_search_type_form.php'
										),
									'trx_addons_args_widget_woocommerce_search',
									apply_filters('trx_addons_filter_widget_args',
										array_merge($args, compact('title', 'type', 'fields', 'last_text', 'button_text')),
										$instance, 'trx_addons_widget_woocommerce_search'
										)
								);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = strip_tags($new_instance['type']);
		for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
			$instance["field{$i}_text"] = strip_tags($new_instance["field{$i}_text"]);
			$instance["field{$i}_filter"] = strip_tags($new_instance["field{$i}_filter"]);
		}
		$instance["last_text"] = strip_tags($new_instance["last_text"]);
		$instance["button_text"] = strip_tags($new_instance["button_text"]);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_woocommerce_search');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$default = array(
			'title' => '',
			'type' => 'inline',
			'last_text' => '',
			'button_text' => ''
		);
		for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
			$default["field{$i}_text"] = '';
			$default["field{$i}_filter"] = '';
		}
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', $default, 'trx_addons_widget_woocommerce_search')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_woocommerce_search');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_woocommerce_search');

		$this->show_field(array('name' => "type",
								'title' => __('Type:', 'trx_addons'),
								'value' => $instance["type"],
								'options' => trx_addons_get_list_woocommerce_search_types(),
								'type' => 'select'));

		for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
			$this->show_field(array('name' => "field{$i}_text",
									'title' => sprintf(__('Field %d text:', 'trx_addons'), $i),
									'value' => $instance["field{$i}_text"],
									'type' => 'text'));
			$this->show_field(array('name' => "field{$i}_filter",
									'title' => sprintf(__('Field %d filter:', 'trx_addons'), $i),
									'value' => $instance["field{$i}_filter"],
									'options' => trx_addons_get_list_woocommerce_search_filters(),
									'type' => 'select'));
		}

		$this->show_field(array('name' => "last_text",
								'title' => __('Last text:', 'trx_addons'),
								'value' => $instance["last_text"],
								'type' => 'text'));

		$this->show_field(array('name' => "button_text",
								'title' => __('Button text:', 'trx_addons'),
								'value' => $instance["button_text"],
								'type' => 'text'));

		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_woocommerce_search');
	}
}
	

// Load required styles and scripts in the frontend
if ( !function_exists( 'trx_addons_widget_woocommerce_search_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_woocommerce_search_load_scripts_front');
	function trx_addons_widget_woocommerce_search_load_scripts_front() {
	}
}


// Parse query params from GET/POST and wp_query_parameters
if ( !function_exists( 'trx_addons_widget_woocommerce_search_query_params' ) ) {
	function trx_addons_widget_woocommerce_search_query_params($fields) {
		$params = array();
		$q_obj = get_queried_object();
		foreach ($fields as $fld) {
			if (trx_addons_is_off($fld['filter'])) continue;
			$tax_name = $fld['filter'];
			if ( is_tax($tax_name))
				$params[$tax_name] = $q_obj->slug;
			else if ( ($value = trx_addons_get_value_gp($tax_name)) != '')
				$params[$tax_name] = sanitize_text_field($value);
			else
				$params[$tax_name] = '';
		}
		return $params;
	}
}



// trx_widget_woocommerce_search
//-------------------------------------------------------------
/*
[trx_widget_woocommerce_search id="unique_id" title="Widget title" orderby="price" order="desc"]
*/
if ( !function_exists( 'trx_addons_sc_widget_woocommerce_search' ) ) {
	function trx_addons_sc_widget_woocommerce_search($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_woocommerce_search', $atts, array(
			// Individual params
			"title" => "",
			"type" => "inline",
			"fields" => "",
			"last_text" => "",
			"button_text" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['fields']))
			$atts['fields'] = (array) vc_param_group_parse_atts( $atts['fields'] );
		$wtype = 'trx_addons_widget_woocommerce_search';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $wtype ] ) ) {
			$output = '<div' . ($atts['id'] ? ' id="'.esc_attr($atts['id']).'"' : '')
							. ' class="widget_area sc_widget_woocommerce_search' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_woocommerce_search wpb_content_element' : '') 
								. (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') 
								. '"'
							. ($atts['css'] ? ' style="'.esc_attr($atts['css']).'"' : '')
						. '>';
			ob_start();
			the_widget( $wtype, $atts, trx_addons_prepare_widgets_args($atts['id'] ? $atts['id'].'_widget' : 'widget_woocommerce_search', 'widget_woocommerce_search') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_woocommerce_search', $atts, $content);
	}
}


// Add [trx_widget_woocommerce_search] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_woocommerce_search_add_in_vc')) {
	function trx_addons_sc_widget_woocommerce_search_add_in_vc() {
		
		if (!trx_addons_exists_woocommerce()) return;

		add_shortcode("trx_widget_woocommerce_search", "trx_addons_sc_widget_woocommerce_search");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_woocommerce_search", 'trx_addons_sc_widget_woocommerce_search_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Woocommerce_Search extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_woocommerce_search_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_woocommerce_search_add_in_vc_params')) {
	function trx_addons_sc_widget_woocommerce_search_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_woocommerce_search",
				"name" => esc_html__("WooCommerce Search", 'trx_addons'),
				"description" => wp_kses_data( __("Insert advanced form for search products", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_woocommerce_search',
				"class" => "trx_widget_woocommerce_search",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "title",
							"heading" => esc_html__("Widget title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "type",
							"heading" => esc_html__("Type", 'trx_addons'),
							"description" => wp_kses_data( __("Type of the widget", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "inline",
							"value" => array_flip(trx_addons_get_list_woocommerce_search_types()),
							"type" => "dropdown"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'fields',
							'heading' => esc_html__( 'Fields', 'trx_addons' ),
							"description" => wp_kses_data( __("Specify text and select filter for each item", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
											array(
												'text' => '',
												'filter' => ''
											),
										), 'trx_widget_woocommerce_search') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array(
								array(
									"param_name" => "text",
									"heading" => esc_html__("Field text", 'trx_addons'),
									"description" => '',
									'edit_field_class' => 'vc_col-sm-6',
									"type" => "textfield"
								),
								array(
									"param_name" => "filter",
									"heading" => esc_html__("Field filter", 'trx_addons'),
									"description" => '',
									'edit_field_class' => 'vc_col-sm-6',
									"std" => "none",
									"value" => array_flip(trx_addons_get_list_woocommerce_search_filters()),
									"type" => "dropdown"
								)
							), 'trx_widget_woocommerce_search')
						),
						array(
							"param_name" => "last_text",
							"heading" => esc_html__("Last text", 'trx_addons'),
							"description" => wp_kses_data( __("Text after the last filter", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "button_text",
							"heading" => esc_html__("Button text", 'trx_addons'),
							"description" => wp_kses_data( __("Text of the button after all filters", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_woocommerce_search' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_woocommerce_search_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_woocommerce_search_add_in_elementor' );
	function trx_addons_sc_widget_woocommerce_search_add_in_elementor() {

		if (!trx_addons_exists_woocommerce()) return;
		
		class TRX_Addons_Elementor_Widget_Woocommerce_Search extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_woocommerce_search';
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
				return __( 'Woocommerce Search', 'trx_addons' );
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
				return 'eicon-search';
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
				return ['trx_addons-support'];
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
					'section_sc_woocommerce_search',
					[
						'label' => __( 'Woocommerce Search', 'trx_addons' ),
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Widget title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Title", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'fields',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'text' => '',
								'filter' => ''
							]
						], 'trx_widget_woocommerce_search'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							[
								[
									'name' => 'text',
									'label' => __( 'Field text', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Text", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'filter',
									'label' => __( 'Field filter', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::SELECT,
									'options' => trx_addons_get_list_woocommerce_search_filters(),
									'default' => 'none'
								]
							]),
							'trx_widget_woocommerce_search'),
						'title_field' => '{{{ text }}} -> {{{ filter }}}',
					]
				);

				$this->add_control(
					'last_text',
					[
						'label' => __( 'Last text', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Last text", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'button_text',
					[
						'label' => __( 'Button text', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Text of the button after all filters", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Last text", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Woocommerce_Search() );
	}
}
?>