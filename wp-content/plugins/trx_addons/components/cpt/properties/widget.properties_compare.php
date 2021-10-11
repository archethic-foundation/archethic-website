<?php
/**
 * Widget: Properties Compare
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.24
 */

// Load widget
if (!function_exists('trx_addons_widget_properties_compare_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_properties_compare_load' );
	function trx_addons_widget_properties_compare_load() {
		register_widget('trx_addons_widget_properties_compare');
	}
}

// Widget Class
class trx_addons_widget_properties_compare extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_properties_compare', 'description' => esc_html__('Compare selected properties', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_properties_compare', esc_html__('ThemeREX Properties Compare', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');

		$list = trx_addons_get_value_gpc('trx_addons_properties_compare_list', array());
		if (!empty($list)) $list = json_decode($list, true);

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.widget.properties_compare.php',
										'trx_addons_args_widget_properties_compare',
										apply_filters('trx_addons_filter_widget_args',
											array_merge($args, compact('title', 'list')),
											$instance, 'trx_addons_widget_properties_compare')
									);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_properties_compare');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => ''
			), 'trx_addons_widget_properties_compare')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_properties_compare');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_properties_compare');
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_properties_compare');
	}
}



// trx_widget_properties_compare
//-------------------------------------------------------------
/*
[trx_widget_properties_compare id="unique_id" title="Widget title"]
*/
if ( !function_exists( 'trx_addons_sc_widget_properties_compare' ) ) {
	function trx_addons_sc_widget_properties_compare($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_properties_compare', $atts, array(
			// Individual params
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		extract($atts);
		$type = 'trx_addons_widget_properties_compare';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_properties_compare' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_properties_compare wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_properties_compare', 'widget_properties_compare') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_properties_compare', $atts, $content);
	}
}


// Add [trx_widget_properties_compare] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_properties_compare_add_in_vc')) {
	function trx_addons_sc_widget_properties_compare_add_in_vc() {
		
		add_shortcode("trx_widget_properties_compare", "trx_addons_sc_widget_properties_compare");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_properties_compare", 'trx_addons_sc_widget_properties_compare_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Properties_Compare extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_properties_compare_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_properties_compare_add_in_vc_params')) {
	function trx_addons_sc_widget_properties_compare_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_properties_compare",
				"name" => esc_html__("Properties Compare", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget to compare selected properties", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_properties_compare',
				"class" => "trx_widget_properties_compare",
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
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_properties_compare' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_properties_compare_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_properties_compare_add_in_elementor' );
	function trx_addons_sc_widget_properties_compare_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Properties_Compare extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_widget_properties_compare';
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
				return __( 'Properties Compare', 'trx_addons' );
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
				return 'eicon-columns';
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
				return ['trx_addons-cpt'];
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
					'section_sc_properties_compare',
					[
						'label' => __( 'Properties Compare', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget title", 'trx_addons' ),
						'default' => ''
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . "properties/tpe.widget.properties_compare.php",
										'trx_addons_args_widget_properties_compare',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Properties_Compare() );
	}
}
?>