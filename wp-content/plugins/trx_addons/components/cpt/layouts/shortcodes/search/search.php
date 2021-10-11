<?php
/**
 * Shortcode: Display Search form
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_search_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_search_merge_styles');
	add_filter("trx_addons_filter_merge_styles_layouts", 'trx_addons_sc_layouts_search_merge_styles');
	function trx_addons_sc_layouts_search_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/_search.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_layouts_search_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_layouts_search_merge_scripts');
	function trx_addons_sc_layouts_search_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/search.js';
		return $list;
	}
}

// Add 'Search' form
if (!function_exists('trx_addons_add_search_form')) {
	add_action('trx_addons_action_search', 'trx_addons_add_search_form', 10, 3);
	function trx_addons_add_search_form($style='normal', $class='', $ajax=true) {

		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'trx_addons-sc_layouts_search', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/search.js'), array('jquery'), null, true );

		trx_addons_get_template_part('templates/tpl.search-form.php',
   									'trx_addons_args_search',
   									array(
										'style' => $style,
										'class' => $class,
										'ajax' => $ajax
										)
									);
	}
}

// AJAX incremental search
if ( !function_exists( 'trx_addons_callback_ajax_search' ) ) {
	add_action('wp_ajax_ajax_search',			'trx_addons_callback_ajax_search');
	add_action('wp_ajax_nopriv_ajax_search',	'trx_addons_callback_ajax_search');
	function trx_addons_callback_ajax_search() {
		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();

		$response = array('error'=>'', 'data' => '');
		
		$s = $_REQUEST['text'];
	
		if (!empty($s)) {
			$args = apply_filters( 'trx_addons_ajax_search_query', array(
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'desc', 
				'posts_per_page' => 4,
				's' => esc_html($s),
				)
			);	

			$query = new WP_Query( $args );

			set_query_var('trx_addons_output_widgets_posts', '');

			$post_number = 0;
			while ( $query->have_posts() ) { $query->the_post();
				$post_number++;
				trx_addons_get_template_part('templates/tpl.posts-list.php',
												'trx_addons_args_widgets_posts', 
												array(
													'show_image' => 1,
													'show_date' => 1,
													'show_author' => 1,
													'show_counters' => 1,
										            'show_categories' => 0
								   	            )
											);
			}
			$response['data'] = get_query_var('trx_addons_output_widgets_posts');
			if (empty($response['data'])) {
				$response['data'] .= '<article class="post_item">' . esc_html__('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'trx_addons') . '</article>';
			} else {
				$response['data'] .= '<article class="post_item"><a href="#" class="post_more search_more">' . esc_html__('More results ...', 'trx_addons') . '</a></article>';
			}
		} else {
			$response['error'] = '<article class="post_item">' . esc_html__('The query string is empty!', 'trx_addons') . '</article>';
		}
		
		echo json_encode($response);
		die();
	}
}



// trx_sc_layouts_search
//-------------------------------------------------------------
/*
[trx_sc_layouts_search id="unique_id" style="normal|expand|fullscreen" ajax="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_search' ) ) {
	function trx_addons_sc_layouts_search($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_search', $atts, array(
			// Individual params
			"type" => "default",
			"style" => "normal",
			"ajax" => "1",
			"hide_on_desktop" => "0",
			"hide_on_notebook" => "0",
			"hide_on_tablet" => "0",
			"hide_on_mobile" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'search/tpl.default.php'
										), 
										'trx_addons_args_sc_layouts_search',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_search', $atts, $content);
	}
}


// Add [trx_sc_layouts_search] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_search_add_in_vc')) {
	function trx_addons_sc_layouts_search_add_in_vc() {
		
		if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_search", "trx_addons_sc_layouts_search");
		
		if (!trx_addons_exists_visual_composer()) return;

		vc_lean_map("trx_sc_layouts_search", 'trx_addons_sc_layouts_search_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Layouts_Search extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_layouts_search_add_in_vc', 15);
}

// Return params
if (!function_exists('trx_addons_sc_layouts_search_add_in_vc_params')) {
	function trx_addons_sc_layouts_search_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_search",
				"name" => esc_html__("Layouts: Search form", 'trx_addons'),
				"description" => wp_kses_data( __("Insert search form to the custom layout", 'trx_addons') ),
				"category" => esc_html__('Layouts', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_search',
				"class" => "trx_sc_layouts_search",
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
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons'),
							), 'trx_sc_layouts_search')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "style",
							"heading" => esc_html__("Style", 'trx_addons'),
							"description" => wp_kses_data( __("Select form's style", 'trx_addons') ),
							"admin_label" => true,
							"std" => "normal",
							"value" => array_flip(apply_filters('trx_addons_sc_style', trx_addons_get_list_sc_layouts_search(), 'trx_sc_layouts_search')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "ajax",
							"heading" => esc_html__("AJAX search", 'trx_addons'),
							"description" => wp_kses_data( __("Use AJAX incremental search", 'trx_addons') ),
							"admin_label" => true,
							"std" => "0",
							"value" => array(esc_html__("AJAX search", 'trx_addons') => "1" ),
							"type" => "checkbox"
						)
					),
					trx_addons_vc_add_hide_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_search');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_search_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_search_add_in_elementor' );
	function trx_addons_sc_layouts_search_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Layouts_Search extends TRX_Addons_Elementor_Layouts_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_layouts_search';
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
				return __( 'Layouts: Search', 'trx_addons' );
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
				return 'fa fa-search';
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
				return ['trx_addons-layouts'];
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
					'section_sc_layouts_search',
					[
						'label' => __( 'Layouts: Search', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', array(
								'default' => esc_html__('Default', 'trx_addons'),
							), 'trx_sc_layouts_search'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'style',
					[
						'label' => __( 'Style', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_style', trx_addons_get_list_sc_layouts_search(), 'trx_sc_layouts_search'),
						'default' => 'normal'
					]
				);

				$this->add_control(
					'ajax',
					[
						'label' => __( 'AJAX search', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Add menu button instead menu on mobile devices. When it clicked - open menu", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . "search/tpe.search.php",
										'trx_addons_args_sc_layouts_search',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts_Search() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Layouts_Search extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_layouts_search',
				esc_html__('ThemeREX Layouts: Search', 'trx_addons'),
				array(
					'classname' => 'widget_layouts_search',
					'description' => __('Insert search form to the custom layout', 'trx_addons')
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
						"description" => wp_kses_data( __("Select shortcodes's type", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', array(
							'default' => esc_html__('Default', 'trx_addons')
						), $this->get_sc_name()),
						'type' => 'select'
					),
					"style" => array(
						"label" => esc_html__("Style", 'trx_addons'),
						"description" => wp_kses_data( __("Select form's style", 'trx_addons') ),
						"options" => apply_filters('trx_addons_sc_style', trx_addons_get_list_sc_layouts_search(), $this->get_sc_name()),
						"default" => "default",
						"type" => "select"
					),
					'ajax' => array(
						'label' => __('AJAX search', 'trx_addons'),
						"description" => wp_kses_data( __("Use AJAX incremental search", 'trx_addons') ),
						'default' => false,
						'type' => 'checkbox'
					)
				),
				trx_addons_sow_add_hide_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_layouts_search', __FILE__, 'TRX_Addons_SOW_Widget_Layouts_Search');
}
?>