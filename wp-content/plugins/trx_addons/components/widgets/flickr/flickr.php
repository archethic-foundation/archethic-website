<?php
/**
 * Widget: Flickr
 *
 * @package WordPress
 * @subpackage trx_addons Addons
 * @since v1.1
 */

// Load widget
if (!function_exists('trx_addons_widget_flickr_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_flickr_load' );
	function trx_addons_widget_flickr_load() {
		register_widget('trx_addons_widget_flickr');
	}
}

// Widget Class
class trx_addons_widget_flickr extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_flickr', 'description' => esc_html__('Last flickr photos.', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_flickr', esc_html__('ThemeREX Flickr photos', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$flickr_api_key = isset($instance['flickr_api_key']) ? $instance['flickr_api_key'] : '';
		$flickr_username = isset($instance['flickr_username']) ? $instance['flickr_username'] : '';
		$flickr_count = isset($instance['flickr_count']) ? $instance['flickr_count'] : 1;
		$flickr_columns = isset($instance['flickr_columns']) ? min($flickr_count, (int) $instance['flickr_columns']) : 1;

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/tpl.default.php',
									'trx_addons_args_widget_flickr', 
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'flickr_api_key', 'flickr_username', 'flickr_count', 'flickr_columns')),
												$instance, 'trx_addons_widget_flickr')
									);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickr_api_key'] = strip_tags( $new_instance['flickr_api_key'] );
		$instance['flickr_username'] = strip_tags( $new_instance['flickr_username'] );
		$instance['flickr_count'] = (int) $new_instance['flickr_count'];
		$instance['flickr_columns'] = min($instance['flickr_count'], (int) $new_instance['flickr_columns']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_flickr');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '', 
			'flickr_api_key' => '', 
			'flickr_username' => '', 
			'flickr_count' => 8,
			'flickr_columns' => 4
			), 'trx_addons_widget_flickr')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_flickr');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_flickr');
		
		$this->show_field(array('name' => 'flickr_api_key',
								'title' => __('Flickr API key:', 'trx_addons'),
								'value' => $instance['flickr_api_key'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_username',
								'title' => __('Flickr ID:', 'trx_addons'),
								'value' => $instance['flickr_username'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_count',
								'title' => __('Number of photos:', 'trx_addons'),
								'value' => max(1, min(30, (int) $instance['flickr_count'])),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_columns',
								'title' => __('Columns:', 'trx_addons'),
								'value' => max(1, min(12, (int) $instance['flickr_columns'])),
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_flickr');
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_flickr_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_flickr_merge_styles');
	function trx_addons_widget_flickr_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/_flickr.scss';
		return $list;
	}
}



// trx_widget_flickr
//-------------------------------------------------------------
/*
[trx_widget_flickr id="unique_id" title="Widget title" flickr_count="6" flickr_username="Flickr@23"]
*/
if ( !function_exists( 'trx_addons_sc_widget_flickr' ) ) {
	function trx_addons_sc_widget_flickr($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_flickr', $atts, array(
			// Individual params
			"title"			=> "",
			'flickr_count'	=> 8,
			'flickr_columns' => 4,
			'flickr_username' => '',
			'flickr_api_key' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		extract($atts);
		$type = 'trx_addons_widget_flickr';
		$output = '';
		if ( (int) $atts['flickr_count'] > 0 && !empty($atts['flickr_username']) ) {
			global $wp_widget_factory;
			if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
				$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
								. ' class="widget_area sc_widget_flickr' 
									. (trx_addons_exists_visual_composer() ? ' vc_widget_flickr wpb_content_element' : '') 
									. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
				ob_start();
				the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_flickr', 'widget_flickr') );
				$output .= ob_get_contents();
				ob_end_clean();
				$output .= '</div>';
			}
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_flickr', $atts, $content);
	}
}


// Add [trx_widget_flickr] in the VC shortcodes list
if (!function_exists('trx_addons_widget_flickr_reg_shortcodes_vc')) {
	function trx_addons_widget_flickr_reg_shortcodes_vc() {

		add_shortcode("trx_widget_flickr", "trx_addons_sc_widget_flickr");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_flickr", 'trx_addons_widget_flickr_reg_shortcodes_vc_params');
		class WPBakeryShortCode_Trx_Widget_Flickr extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_widget_flickr_reg_shortcodes_vc', 20);
}

// Return params
if (!function_exists('trx_addons_widget_flickr_reg_shortcodes_vc_params')) {
	function trx_addons_widget_flickr_reg_shortcodes_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_flickr",
				"name" => esc_html__("Flickr photos", 'trx_addons'),
				"description" => wp_kses_data( __("Display the latest photos from Flickr account", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_flickr',
				"class" => "trx_widget_flickr",
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
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "flickr_api_key",
							"heading" => esc_html__("Flickr API key", 'trx_addons'),
							"description" => wp_kses_data( __("Specify API key from your Flickr application", 'trx_addons') ),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "flickr_username",
							"heading" => esc_html__("Flickr username", 'trx_addons'),
							"description" => wp_kses_data( __("Your Flickr username", 'trx_addons') ),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "flickr_count",
							"heading" => esc_html__("Number of photos", 'trx_addons'),
							"description" => wp_kses_data( __("How many photos to be displayed?", 'trx_addons') ),
							"class" => "",
							"value" => "8",
							"type" => "textfield"
						),
						array(
							"param_name" => "flickr_columns",
							"heading" => esc_html__("Columns", 'trx_addons'),
							"description" => wp_kses_data( __("Columns number", 'trx_addons') ),
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_flickr');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_flickr_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_flickr_add_in_elementor' );
	function trx_addons_sc_widget_flickr_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Flickr extends TRX_Addons_Elementor_Widget {

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
					'flickr_count' => 'size',
					'flickr_columns' => 'size'
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
				return 'trx_widget_flickr';
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
				return __( 'Widget: Flickr', 'trx_addons' );
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
				return 'eicon-insert-image';
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
				return ['trx_addons-widgets'];
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
					'section_sc_flickr',
					[
						'label' => __( 'Widget: Flickr', 'trx_addons' ),
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
				
				$this->add_control(
					'flickr_api_key',
					[
						'label' => __( 'API key', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data(__( 'API key from your Flickr application', 'trx_addons' )),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "API key", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'flickr_username',
					[
						'label' => __( 'User name', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "User name", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'flickr_count',
					[
						'label' => __( 'Number of photos', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 8
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 30
							]
						]
					]
				);
				
				$this->add_control(
					'flickr_columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 4
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 12
							]
						],
						'selectors' => [
							'{{WRAPPER}} .flickr_images > a' => 'width:calc(100%/{{SIZE}});',
						],
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "flickr/tpe.flickr.php",
										'trx_addons_args_widget_flickr',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Flickr() );
	}
}
?>