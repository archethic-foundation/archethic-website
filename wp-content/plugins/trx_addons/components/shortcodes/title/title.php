<?php
/**
 * Shortcode: Content container
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_title_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_title_merge_styles');
	function trx_addons_sc_title_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'title/_title.scss';
		return $list;
	}
}


// trx_sc_title
//-------------------------------------------------------------
/*
[trx_sc_title id="unique_id" title="" subtitle="" description=""]
*/
if ( !function_exists( 'trx_addons_sc_title' ) ) {
	function trx_addons_sc_title($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_title', $atts, array(
			// Individual params
			'type' => '',
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
		
		$output = '';

		if (empty($atts['type'])) $atts['type'] = $atts['title_style'];
		else $atts['title_style'] = $atts['type'];
		
		if (!empty($atts['title']) || !empty($atts['subtitle']) || !empty($atts['description'])) {

			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'title/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'title/tpl.default.php'
											),
                                            'trx_addons_args_sc_title',
                                            $atts
                                        );
			$output = ob_get_contents();
			ob_end_clean();

		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_title', $atts, $content);
	}
}


// Add [trx_sc_content] in the VC shortcodes list
if (!function_exists('trx_addons_sc_title_add_in_vc')) {
	function trx_addons_sc_title_add_in_vc() {
		
		add_shortcode("trx_sc_title", "trx_addons_sc_title");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_title", 'trx_addons_sc_title_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Title extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_title_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_title_add_in_vc_params')) {
	function trx_addons_sc_title_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_title",
				"name" => esc_html__("Title", 'trx_addons'),
				"description" => wp_kses_data( __("Add title, subtitle and description", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_title',
				"class" => "trx_sc_title",
				'content_element' => true,
				'is_container' => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					trx_addons_vc_add_title_param(''),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_title' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_title_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_title_add_in_elementor' );
	function trx_addons_sc_title_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Title extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_title';
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
				return __( 'Title', 'trx_addons' );
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
				return 'eicon-t-letter';
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
					'section_sc_title',
					[
						'label' => __( 'Title', 'trx_addons' ),
					]
				);

				$this->add_title_param('', !trx_addons_elm_is_preview() ? [] : [
					'title_align' => ['default' => 'center'],
					'title' => ['default' => __('Title of the block', 'trx_addons')],
					'subtitle' => ['default' => $this->get_default_subtitle()],
					'description' => ['default' => $this->get_default_description()],
				]);

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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "title/tpe.title.php",
										'trx_addons_args_sc_title',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Title() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Title extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_title',
				esc_html__('ThemeREX Title', 'trx_addons'),
				array(
					'classname' => 'widget_title',
					'description' => __('Display title', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			return apply_filters('trx_addons_sow_map', array_merge(
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_title', __FILE__, 'TRX_Addons_SOW_Widget_Title');
}
?>