<?php
/**
 * ThemeREX Addons Custom post type: Portfolio
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants
if ( ! defined('TRX_ADDONS_CPT_PORTFOLIO_PT') ) define('TRX_ADDONS_CPT_PORTFOLIO_PT', trx_addons_cpt_param('portfolio', 'post_type'));
if ( ! defined('TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY') ) define('TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY', trx_addons_cpt_param('portfolio', 'taxonomy'));

// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_portfolio_init')) {
	add_action( 'init', 'trx_addons_cpt_portfolio_init' );
	function trx_addons_cpt_portfolio_init() {
		
		// Add Portfolio parameters to the Meta Box support
		trx_addons_meta_box_register(TRX_ADDONS_CPT_PORTFOLIO_PT, array(
			"subtitle" => array(
				"title" => esc_html__("Item's subtitle",  'trx_addons'),
				"desc" => wp_kses_data( __("Portfolio item author's name or position or any other text", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"alter_link" => array(
				"title" => esc_html__("Item's link",  'trx_addons'),
				"desc" => wp_kses_data( __("Alternative link to the portfolio item's site. If empty - use this post's permalink", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			)
		));
		
		// Register post type and taxonomy
		register_post_type( TRX_ADDONS_CPT_PORTFOLIO_PT, array(
			'label'               => esc_html__( 'Portfolio', 'trx_addons' ),
			'description'         => esc_html__( 'Portfolio Description', 'trx_addons' ),
			'labels'              => array(
				'name'                => esc_html__( 'Portfolio', 'trx_addons' ),
				'singular_name'       => esc_html__( 'Portfolio', 'trx_addons' ),
				'menu_name'           => esc_html__( 'Portfolio', 'trx_addons' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
				'all_items'           => esc_html__( 'All Portfolio items', 'trx_addons' ),
				'view_item'           => esc_html__( 'View Portfolio item', 'trx_addons' ),
				'add_new_item'        => esc_html__( 'Add New Portfolio item', 'trx_addons' ),
				'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
				'edit_item'           => esc_html__( 'Edit Portfolio item', 'trx_addons' ),
				'update_item'         => esc_html__( 'Update Portfolio item', 'trx_addons' ),
				'search_items'        => esc_html__( 'Search Portfolio items', 'trx_addons' ),
				'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
			),
			'taxonomies'          => array(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY),
			'supports'            => trx_addons_cpt_param('portfolio', 'supports'),
			'public'              => true,
			'hierarchical'        => false,
			'has_archive'         => true,
			'can_export'          => true,
			'show_in_admin_bar'   => true,
			'show_in_menu'        => true,
			'menu_position'       => '53.2',
			'menu_icon'			  => 'dashicons-images-alt',
			'capability_type'     => 'post',
			'rewrite'             => array( 'slug' => trx_addons_cpt_param('portfolio', 'post_type_slug') )
			)
		);

		register_taxonomy( TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, TRX_ADDONS_CPT_PORTFOLIO_PT, array(
			'post_type' 		=> TRX_ADDONS_CPT_PORTFOLIO_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Portfolio Group', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Group', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Groups', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Groups', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Group', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Group:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Group', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Group', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Group', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Group Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Portfolio Groups', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => trx_addons_cpt_param('portfolio', 'taxonomy_slug') )
			)
		);
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'Portfolio' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_portfolio_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_portfolio_options');
	function trx_addons_cpt_portfolio_options($options) {
		trx_addons_array_insert_after($options, 'cpt_section', trx_addons_cpt_portfolio_get_list_options());
		return $options;
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_portfolio_get_list_options')) {
	function trx_addons_cpt_portfolio_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'portfolio_info' => array(
				"title" => esc_html__('Portfolio', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the portfolio archive', 'trx_addons') ),
				"type" => "info"
			),
			'portfolio_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the portfolio archive', 'trx_addons') ),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'portfolio', 'arh'),
											TRX_ADDONS_CPT_PORTFOLIO_PT),
				"type" => "select"
			)
		), 'portfolio');
	}
}
------------------- /Old way --------------------- */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cpt_portfolio_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_portfolio_merge_styles');
	function trx_addons_cpt_portfolio_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'portfolio/_portfolio.scss';
		return $list;
	}
}


// Return true if it's portfolio page
if ( !function_exists( 'trx_addons_is_portfolio_page' ) ) {
	function trx_addons_is_portfolio_page() {
		return defined('TRX_ADDONS_CPT_PORTFOLIO_PT') 
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_CPT_PORTFOLIO_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_PORTFOLIO_PT)
						|| is_tax(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY)
						);
	}
}



// Replace standard theme templates
//-------------------------------------------------------------

// Change standard single template for services posts
if ( !function_exists( 'trx_addons_cpt_portfolio_single_template' ) ) {
	add_filter('single_template', 'trx_addons_cpt_portfolio_single_template');
	function trx_addons_cpt_portfolio_single_template($template) {
		global $post;
		if (is_single() && $post->post_type == TRX_ADDONS_CPT_PORTFOLIO_PT)
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.single.php');
		return $template;
	}
}

// Change standard archive template for services posts
if ( !function_exists( 'trx_addons_cpt_portfolio_archive_template' ) ) {
	add_filter('archive_template',	'trx_addons_cpt_portfolio_archive_template');
	function trx_addons_cpt_portfolio_archive_template( $template ) {
		if ( is_post_type_archive(TRX_ADDONS_CPT_PORTFOLIO_PT) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.archive.php');
		return $template;
	}	
}

// Change standard category template for services categories (groups)
if ( !function_exists( 'trx_addons_cpt_portfolio_taxonomy_template' ) ) {
	add_filter('taxonomy_template',	'trx_addons_cpt_portfolio_taxonomy_template');
	function trx_addons_cpt_portfolio_taxonomy_template( $template ) {
		if ( is_tax(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.archive.php');
		return $template;
	}	
}



// Admin utils
// -----------------------------------------------------------------

// Show <select> with portfolio categories in the admin filters area
if (!function_exists('trx_addons_cpt_portfolio_admin_filters')) {
	add_action( 'restrict_manage_posts', 'trx_addons_cpt_portfolio_admin_filters' );
	function trx_addons_cpt_portfolio_admin_filters() {
		trx_addons_admin_filters(TRX_ADDONS_CPT_PORTFOLIO_PT, TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
	}
}
  
// Clear terms cache on the taxonomy save
if (!function_exists('trx_addons_cpt_portfolio_admin_clear_cache')) {
	add_action( 'edited_'.TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, 'trx_addons_cpt_portfolio_admin_clear_cache', 10, 1 );
	add_action( 'delete_'.TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, 'trx_addons_cpt_portfolio_admin_clear_cache', 10, 1 );
	add_action( 'created_'.TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, 'trx_addons_cpt_portfolio_admin_clear_cache', 10, 1 );
	function trx_addons_cpt_portfolio_admin_clear_cache( $term_id=0 ) {  
		trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
	}
}


// trx_sc_portfolio
//-------------------------------------------------------------
/*
[trx_sc_portfolio id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_portfolio' ) ) {
	function trx_addons_sc_portfolio($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_portfolio', $atts, array(
			// Individual params
			"type" => "default",
			"columns" => "",
			"cat" => "",
			"count" => 3,
			"offset" => 0,
			"orderby" => '',
			"order" => '',
			"ids" => '',
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
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

		if (!empty($atts['ids'])) {
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['count'] = max(1, (int) $atts['count']);
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'title';
		if (empty($atts['order'])) $atts['order'] = 'asc';
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.default.php'
										), 
										'trx_addons_args_sc_portfolio',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_portfolio', $atts, $content);
	}
}


// Add [trx_sc_portfolio] in the VC shortcodes list
if (!function_exists('trx_addons_sc_portfolio_add_in_vc')) {
	function trx_addons_sc_portfolio_add_in_vc() {

		add_shortcode("trx_sc_portfolio", "trx_addons_sc_portfolio");
		
		if (!trx_addons_exists_visual_composer()) return;
	
		vc_lean_map("trx_sc_portfolio", 'trx_addons_sc_portfolio_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Portfolio extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_portfolio_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_portfolio_add_in_vc_params')) {
	function trx_addons_sc_portfolio_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_portfolio",
				"name" => esc_html__("Portfolio", 'trx_addons'),
				"description" => wp_kses_data( __("Display portfolio items from specified group", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_portfolio',
				"class" => "trx_sc_portfolio",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							"admin_label" => true,
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'portfolio', 'sc'), 'trx_sc_portfolio')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "cat",
							"heading" => esc_html__("Group", 'trx_addons'),
							"description" => wp_kses_data( __("Portfolio group", 'trx_addons') ),
							"value" => array_merge(array(esc_html__('- Select category -', 'trx_addons') => 0), 
													array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY))),
							"std" => "0",
							"type" => "dropdown"
						)
					),
					trx_addons_vc_add_query_param(''),
					trx_addons_vc_add_slider_param(),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_portfolio' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_portfolio_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_portfolio_add_in_elementor' );
	function trx_addons_sc_portfolio_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Portfolio extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_portfolio';
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
				return __( 'Portfolio', 'trx_addons' );
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
				return 'eicon-gallery-grid';
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
					'section_sc_portfolio',
					[
						'label' => __( 'Portfolio', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'portfolio', 'sc'), 'trx_sc_portfolio'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'cat',
					[
						'label' => __( 'Group', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Select category -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY)),
						'default' => '0'
					]
				);
				
				$this->add_query_param('');

				$this->end_controls_section();
				
				$this->add_slider_param();
				
				$this->add_title_param();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Portfolio() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Portfolio extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_portfolio',
				esc_html__('ThemeREX Portfolio', 'trx_addons'),
				array(
					'classname' => 'widget_portfolio',
					'description' => __('Display portfolio posts', 'trx_addons')
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
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'portfolio', 'sc'), $this->get_sc_name(), 'sow' ),
						'type' => 'select'
					),
					"cat" => array(
						"label" => esc_html__("Group", 'trx_addons'),
						"description" => wp_kses_data( __("Select portfolio group", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Select category -', 'trx_addons')),
															trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY)
															),
						"type" => "select"
					)
				),
				trx_addons_sow_add_query_param(''),
				trx_addons_sow_add_slider_param(),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_portfolio', __FILE__, 'TRX_Addons_SOW_Widget_Portfolio');
}
?>