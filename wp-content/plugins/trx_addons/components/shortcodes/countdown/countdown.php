<?php
/**
 * Shortcode: Countdown
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_countdown_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_countdown_merge_styles');
	function trx_addons_sc_countdown_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/_countdown.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_countdown_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_countdown_merge_styles_responsive');
	function trx_addons_sc_countdown_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/_countdown.responsive.scss';
		return $list;
	}
}

	
// Merge countdown specific scripts into single file
if ( !function_exists( 'trx_addons_sc_countdown_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_countdown_merge_scripts');
	function trx_addons_sc_countdown_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.plugin.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.countdown.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.js';
		return $list;
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_countdown_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_countdown_load_scripts_front');
	function trx_addons_sc_countdown_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script( 'jquery-plugin', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.plugin.js'), array('jquery'), null, true );
			wp_enqueue_script( 'jquery-countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.countdown.js'), array('jquery'), null, true );
			wp_enqueue_script( 'trx_addons-sc_countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.js'), array('jquery'), null, true );
		}
	}
}



// trx_sc_countdown
//-------------------------------------------------------------
/*
[trx_sc_countdown id="unique_id" date="2017-12-31" time="23:59:59"]
*/
if ( !function_exists( 'trx_addons_sc_countdown' ) ) {
	function trx_addons_sc_countdown($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_countdown', $atts, array(
			// Individual params
			"type" => "default",
			"date" => "",
			"time" => "",
			"date_time" => "",
			"align" => "center",
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

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/tpl.default.php'
										),
                                        'trx_addons_args_sc_countdown',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_countdown', $atts, $content);
	}
}


// Add [trx_sc_countdown] in the VC shortcodes list
if (!function_exists('trx_addons_sc_countdown_add_in_vc')) {
	function trx_addons_sc_countdown_add_in_vc() {
		
		add_shortcode("trx_sc_countdown", "trx_addons_sc_countdown");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_countdown", 'trx_addons_sc_countdown_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Countdown extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_countdown_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_countdown_add_in_vc_params')) {
	function trx_addons_sc_countdown_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_countdown",
				"name" => esc_html__("Countdown", 'trx_addons'),
				"description" => wp_kses_data( __("Put the countdown to the specified date and time", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_countdown',
				"class" => "trx_sc_countdown",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Type", 'trx_addons'),
							"description" => wp_kses_data( __("Select counter's type", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
					        'save_always' => true,
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'countdown'), 'trx_sc_countdown')),
							"std" => "default",
							"type" => "dropdown"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment of the countdown", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "none",
							"value" => array_flip(trx_addons_get_list_sc_aligns()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "date",
							"heading" => esc_html__("Date", 'trx_addons'),
							"description" => wp_kses_data( __("Target date. Attention! Write the date in the format: yyyy-mm-dd", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							'value' => '',
							"type" => "textfield"
						),
						array(
							'param_name' => 'time',
							'heading' => esc_html__( 'Time', 'trx_addons' ),
							'description' => esc_html__( 'Target time. Attention! Put the time in the 24-hours format: HH:mm:ss', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-6',
							'value' => '',
							'type' => 'textfield',
						),
					),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_countdown' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_countdown_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_countdown_add_in_elementor' );
	function trx_addons_sc_countdown_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Countdown extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_countdown';
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
				return __( 'Countdown', 'trx_addons' );
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
				return 'eicon-countdown';
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
					'section_sc_countdown',
					[
						'label' => __( 'Countdown', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'countdown'), 'trx_sc_countdown'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'align',
					[
						'label' => __( 'Alignment', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(),
						'default' => 'none'
					]
				);

				$this->add_control(
					'date_time',
					[
						'label' => __( 'Date & Time', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::DATE_TIME,
						'options' => trx_addons_get_list_sc_aligns(),
						'default' => date('Y-m-d H:i:s')
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "countdown/tpe.countdown.php",
										'trx_addons_args_sc_countdown',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Countdown() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Countdown extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_countdown',
				esc_html__('ThemeREX Countdown', 'trx_addons'),
				array(
					'classname' => 'widget_countdown',
					'description' => __('Display countdown to/from specified event', 'trx_addons')
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
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'countdown'), $this->get_sc_name(), 'sow' ),
						'type' => 'select'
					),
					"align" => array(
						"label" => esc_html__("Block alignment", 'trx_addons'),
						"description" => wp_kses_data( __("Select alignment of the countdown", 'trx_addons') ),
						"options" => trx_addons_get_list_sc_aligns(),
						"default" => "none",
						"type" => "select"
					),
					'date' => array(
						'label' => __('Date', 'trx_addons'),
						'description' => esc_html__( 'Target date. Attention! Write the date in the format: yyyy-mm-dd', 'trx_addons' ),
						'type' => 'text'
					),
					'time' => array(
						'label' => __('Time', 'trx_addons'),
						'description' => esc_html__( 'Target time. Attention! Put the time in the 24-hours format: HH:mm:ss', 'trx_addons' ),
						'type' => 'text'
					)
				),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_countdown', __FILE__, 'TRX_Addons_SOW_Widget_Countdown');
}
?>