<?php
/**
 * Widget: Calendar
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_calendar_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_calendar_load' );
	function trx_addons_widget_calendar_load() {
		register_widget('trx_addons_widget_calendar');
	}
}

// Widget Class
class trx_addons_widget_calendar extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_calendar', 'description' => esc_html__('Standard WP Calendar with short week days', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_calendar', esc_html__('ThemeREX Calendar', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$weekdays = isset($instance['weekdays']) ? $instance['weekdays'] : 'short';
		
		$output = get_calendar($weekdays=='initial', false);

		if (!empty($output)) {
	
			// Before widget (defined by themes)
			trx_addons_show_layout($before_widget);
			
			// Display the widget title if one was input (before and after defined by themes)
			if ($title) trx_addons_show_layout($before_title . $title . $after_title);
	
			// Display widget body
			trx_addons_show_layout($output);
			
			// After widget (defined by themes)
			trx_addons_show_layout($after_widget);
		}
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['weekdays'] = !empty($new_instance['weekdays']) && $new_instance['weekdays']=='short' ? 'short' : 'initial';
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'weekdays' => 'short'
			)
		);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));

		$this->show_field(array('name' => 'weekdays',
								'title' => __('Week days:', 'trx_addons'),
								'value' => $instance['weekdays'],
								'options' => array(
													'short' => __('3 letters (Sun Mon Tue Wed Thu Fri Sat)', 'trx_addons'),
													'initial' => __('First letter (S M T W T F S)', 'trx_addons')
													),
								'dir' => 'vertical',
								'type' => 'radio'));
	}
}



// trx_widget_calendar
//-------------------------------------------------------------
/*
[trx_widget_calendar id="unique_id" title="Widget title" weekdays="short|initial"]
*/
if ( !function_exists( 'trx_addons_sc_widget_calendar' ) ) {
	function trx_addons_sc_widget_calendar($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_calendar', $atts, array(
			// Individual params
			"title" => "",
			"weekdays" => "short",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if ($atts['weekdays']=='') $atts['weekdays'] = 'short';
		extract($atts);
		$type = 'trx_addons_widget_calendar';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_calendar' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_calendar wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_calendar', 'widget_calendar') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_calendar', $atts, $content);
	}
}


// Add [trx_widget_calendar] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_calendar_add_in_vc')) {
	function trx_addons_sc_widget_calendar_add_in_vc() {
		
		add_shortcode("trx_widget_calendar", "trx_addons_sc_widget_calendar");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_calendar", 'trx_addons_sc_widget_calendar_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Calendar extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_calendar_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_calendar_add_in_vc_params')) {
	function trx_addons_sc_widget_calendar_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_calendar",
				"name" => esc_html__("Calendar", 'trx_addons'),
				"description" => wp_kses_data( __("Insert standard WP Calendar, but allow user select week day's captions", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_calendar',
				"class" => "trx_widget_calendar",
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
						),
						array(
							"param_name" => "weekdays",
							"heading" => esc_html__("Week days", 'trx_addons'),
							"description" => wp_kses_data( __("Show captions for the week days as three letters (Sun, Mon, etc.) or as one initial letter (S, M, etc.)", 'trx_addons') ),
							"value" => array("Initial letter" => "initial" ),
							"type" => "checkbox"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_calendar' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_calendar_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_calendar_add_in_elementor' );
	function trx_addons_sc_widget_calendar_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Calendar extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_calendar';
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
				return __( 'Widget: Calendar', 'trx_addons' );
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
				return 'eicon-counter';
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
					'section_sc_calendar',
					[
						'label' => __( 'Widget: Calendar', 'trx_addons' ),
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
					'weekdays',
					[
						'label' => __( 'Week days', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Show captions for the week days as three letters (Sun, Mon, etc.) or as one initial letter (S, M, etc.)", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Three', 'trx_addons' ),
						'label_on' => __( 'One', 'trx_addons' ),
						'return_value' => 'initial'
					]
				);

				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Calendar() );
	}
}
?>