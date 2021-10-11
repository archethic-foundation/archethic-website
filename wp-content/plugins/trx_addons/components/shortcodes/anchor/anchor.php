<?php
/**
 * Shortcode: Anchor
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_anchor_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_anchor_merge_styles');
	function trx_addons_sc_anchor_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/_anchor.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_anchor_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_anchor_merge_scripts');
	function trx_addons_sc_anchor_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.js';
		return $list;
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_anchor_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_anchor_load_scripts_front');
	function trx_addons_sc_anchor_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'trx_addons-sc_anchor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/anchor.js'), array('jquery'), null, true );
	}
}
	
// Add shortcode's specific vars into JS storage
if ( !function_exists( 'trx_addons_sc_anchor_localize_script' ) ) {
	add_filter("trx_addons_localize_script", 'trx_addons_sc_anchor_localize_script');
	function trx_addons_sc_anchor_localize_script($vars) {
		$is_preview = function_exists('trx_addons_elm_is_preview') && trx_addons_elm_is_preview();
		return array_merge($vars, array(
			'scroll_to_anchor' => $is_preview ? 0 : trx_addons_get_option('scroll_to_anchor'),
			'update_location_from_anchor' => $is_preview ? 0 : trx_addons_get_option('update_location_from_anchor')
		));
	}
}



// trx_sc_anchor
//-------------------------------------------------------------
/*
[trx_sc_anchor id="unique_id" style="default"]
*/
if ( !function_exists( 'trx_addons_sc_anchor' ) ) {
	function trx_addons_sc_anchor($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_anchor', $atts, array(
			// Individual params
			"type" => "default",
			"title" => "",
			"url" => "",
			"icon" => "",
			"icon_type" => 'fontawesome',
			"icon_fontawesome" => "",
			"icon_openiconic" => "",
			"icon_typicons" => "",
			"icon_entypo" => "",
			"icon_linecons" => "",
			// Common params
			"id" => "",
			"anchor_id" => ""		// Alter name for id in Elementor ('id' is reserved by Elementor)
			)
		);

		if (!empty($atts['anchor_id']))
			$atts['id'] = $atts['anchor_id'];
		if (empty($atts['icon'])) {
			$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' 
								? $atts['icon_' . $atts['icon_type']] 
								: '';
			trx_addons_load_icons($atts['icon_type']);
		} else if (strtolower($atts['icon']) == 'none')
			$atts['icon'] = '';
	
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'anchor/tpl.default.php'
										),
                                        'trx_addons_args_sc_anchor',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_anchor', $atts, $content);
	}
}


// Add [trx_sc_anchor] in the VC shortcodes list
if (!function_exists('trx_addons_sc_anchor_add_in_vc')) {
	function trx_addons_sc_anchor_add_in_vc() {
		
		add_shortcode("trx_sc_anchor", "trx_addons_sc_anchor");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_anchor", 'trx_addons_sc_anchor_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Anchor extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_anchor_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_anchor_add_in_vc_params')) {
	function trx_addons_sc_anchor_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_anchor",
				"name" => esc_html__("Anchor", 'trx_addons'),
				"description" => wp_kses_data( __("Insert anchor for the inner page navigation", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_anchor',
				"class" => "trx_sc_anchor",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge( array(
					array(
						"param_name" => "id",
						"heading" => esc_html__("Anchor ID", 'trx_addons'),
						"description" => wp_kses_data( __("ID of this anchor", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-6',
						"admin_label" => true,
						"type" => "textfield"
					), 
					array(
						'param_name' => 'title',
						'heading' => esc_html__( 'Title', 'trx_addons' ),
						'description' => esc_html__( 'Anchor title', 'trx_addons' ),
						'edit_field_class' => 'vc_col-sm-6',
						'type' => 'textfield',
					),
					array(
						'param_name' => 'url',
						'heading' => esc_html__( 'URL to navigate', 'trx_addons' ),
						'description' => esc_html__( "URL to navigate. If empty - use id to create anchor", 'trx_addons' ),
						'type' => 'textfield',
					 ) ),

					trx_addons_vc_add_icon_param('')
				)
			), 'trx_sc_anchor' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_anchor_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_anchor_add_in_elementor' );
	function trx_addons_sc_anchor_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Anchor extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_anchor';
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
				return __( 'Anchor', 'trx_addons' );
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
				return 'eicon-anchor';
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
					'section_sc_anchor',
					[
						'label' => __( 'Anchor', 'trx_addons' ),
					]
				);

				$this->add_control(
					'anchor_id',
					[
						'label' => __( "Anchor's ID", 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => false,
						'placeholder' => __( "Anchor's ID", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => false,
						'placeholder' => __( "Title", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'url',
					[
						'label' => __( 'URL', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::URL,
						'label_block' => false,
						'placeholder' => __( 'http://your-link.com', 'trx_addons' ),
					]
				);

				$this->add_icon_param();

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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "anchor/tpe.anchor.php",
										'trx_addons_args_sc_anchor',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Anchor() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Anchor extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_anchor',
				esc_html__('ThemeREX Anchor', 'trx_addons'),
				array(
					'classname' => 'widget_anchor',
					'description' => __('Add anchor to the page', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			return apply_filters('trx_addons_sow_map', array_merge(array(
					'id' => array(
						'label' => __('Anchor ID', 'trx_addons'),
						"description" => wp_kses_data( __("ID of this anchor", 'trx_addons') ),
						'type' => 'text'
					),
					'title' => array(
						'label' => __('Title', 'trx_addons'),
						'description' => esc_html__( 'Anchor title', 'trx_addons' ),
						'type' => 'text'
					),
					'url' => array(
						'type' => 'link',
						'label' => __('URL to navigate. If empty - use ID to create anchor', 'trx_addons'),
						'description' => esc_html__( "URL to navigate. If empty - use id to create anchor", 'trx_addons' ),
						'type' => 'text'
					)
				),
				trx_addons_sow_add_icon_param('')
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_anchor', __FILE__, 'TRX_Addons_SOW_Widget_Anchor');
}
?>