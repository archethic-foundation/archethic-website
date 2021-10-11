<?php
/**
 * Widget: Categories list
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_categories_list_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_categories_list_load' );
	function trx_addons_widget_categories_list_load() {
		register_widget('trx_addons_widget_categories_list');
	}
}

// Widget Class
class trx_addons_widget_categories_list extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_categories_list', 'description' => esc_html__('Display categories list with icons or images', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_categories_list', esc_html__('ThemeREX Categories list', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$style = isset($instance['style']) ? max(1, (int) $instance['style']) : 1;
		$number = isset($instance['number']) ? (int) $instance['number'] : '';
		$columns = isset($instance['columns']) ? (int) $instance['columns'] : '';
		$show_thumbs = isset($instance['show_thumbs']) ? (int) $instance['show_thumbs'] : 0;
		$show_posts = isset($instance['show_posts']) ? (int) $instance['show_posts'] : 0;
		$show_children = isset($instance['show_children']) ? (int) $instance['show_children'] : 0;
		$post_type = isset($instance['post_type']) ? $instance['post_type'] : '';
		$taxonomy = isset($instance['taxonomy']) ? $instance['taxonomy'] : '';
		$cat_list = isset($instance['cat_list']) ? $instance['cat_list'] : '';

		$q_obj = get_queried_object();

		$categories = get_categories(array(
			'type'                     => $post_type,
			'taxonomy'                 => $taxonomy,
			'include'                  => $cat_list,
			'number'                   => $number > 0 && empty($cat_list) ? $number : '',
			'parent'                   => $show_children
												? (is_category() 
														? (int) get_query_var('cat') 
														: (is_tax() && !empty($q_obj->term_id)
																? $q_obj->term_id
																: '')
													)
												: '',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 0,
			'pad_counts'               => $show_posts > 0 
		
		));

		// If result is empty - exit without output
		if (count($categories)==0) return;

		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/tpl.categories-list-'.trim($style).'.php',
										TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/tpl.categories-list-1.php'
										),
                                        'trx_addons_args_widget_categories_list',
										apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'style', 'number', 'columns',
																	'show_posts', 'show_children', 'show_thumbs',
																	'categories', 'post_type', 'taxonomy')),
												$instance, 'trx_addons_widget_categories_list')
                                    );
	}

	// Update the widget settings
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = (int) $new_instance['style'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['columns'] = (int) $new_instance['columns'];
		$instance['show_thumbs'] = !empty($new_instance['show_thumbs']) ? 1 : 0;
		$instance['show_posts'] = !empty($new_instance['show_posts']) ? 1 : 0;
		$instance['show_children'] = !empty($new_instance['show_children']) ? 1 : 0;
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
		$instance['cat_list'] = join(',', $new_instance['cat_list']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_categories_list');
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'style' => '1',
			'number' => '5',
			'columns' => '5',
			'show_thumbs' => '1',
			'show_posts' => '1',
			'show_children' => '0',
			'post_type' => 'post',
			'taxonomy' => 'category',
			'cat_list' => ''
			), 'trx_addons_widget_categories_list')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_categories_list');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_categories_list');
		
		$this->show_field(array('name' => 'style',
								'title' => __('Output style:', 'trx_addons'),
								'value' => (int) $instance['style'],
								'options' => trx_addons_components_get_allowed_layouts('widgets', 'categories_list'),
								'type' => 'switch'));
		
		$this->show_field(array('name' => 'post_type',
								'title' => __('Post type:', 'trx_addons'),
								'value' => $instance['post_type'],
								'options' => trx_addons_get_list_posts_types(),
								'class' => 'trx_addons_post_type_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'taxonomy',
								'title' => __('Taxonomy:', 'trx_addons'),
								'value' => $instance['taxonomy'],
								'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
								'class' => 'trx_addons_taxonomy_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'cat_list',
								'title' => __('Categories to show:', 'trx_addons'),
								'value' => $instance['cat_list'],
								'options' => trx_addons_get_list_terms(false, $instance['taxonomy']),
								'class' => 'trx_addons_terms_selector',
								'type' => 'checklist'));
		
		$this->show_field(array('name' => 'number',
								'title' => __('Number categories to show (if field above is empty):', 'trx_addons'),
								'value' => (int) $instance['number'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'columns',
								'title' => __('Columns number:', 'trx_addons'),
								'value' => (int) $instance['columns'],
								'type' => 'text'));

		$this->show_field(array('name' => 'show_thumbs',
								'title' => __('Show images:', 'trx_addons'),
								'value' => (int) $instance['show_thumbs'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_posts',
								'title' => __('Show posts count:', 'trx_addons'),
								'value' => (int) $instance['show_posts'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_children',
								'title' => __('Only children of the current category:', 'trx_addons'),
								'value' => (int) $instance['show_children'],
								'options' => array(
													1 => __('Children', 'trx_addons'),
													0 => __('From root', 'trx_addons')
													),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_categories_list');
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_categories_list_merge_styles');
	function trx_addons_widget_categories_list_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/_categories_list.scss';
		return $list;
	}
}


// Merge widget's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_categories_list_merge_styles_responsive');
	function trx_addons_widget_categories_list_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/_categories_list.responsive.scss';
		return $list;
	}
}



// trx_widget_categories_list
//-------------------------------------------------------------
/*
[trx_widget_categories_list id="unique_id" title="Widget title" style="1" number="4" columns="4" show_posts="0|1" show_children="0|1" cat_list="id1,id2,id3,..."]
*/
if ( !function_exists( 'trx_addons_sc_widget_categories_list' ) ) {
	function trx_addons_sc_widget_categories_list($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_categories_list', $atts, array(
			// Individual params
			"title" => '',
			'style' => '1',
			'number' => 5,
			'columns' => 5,
			'show_thumbs' => 1,
			'show_posts' => 1,
			'show_children' => 0,
			'post_type' => 'post',
			'taxonomy' => 'category',
			'cat_list' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		extract($atts);
		$type = 'trx_addons_widget_categories_list';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_categories_list' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_categories_list wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_categories_list', 'widget_categories_list') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_categories_list', $atts, $content);
	}
}


// Add [trx_widget_categories_list] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_categories_list_add_in_vc')) {
	function trx_addons_sc_widget_categories_list_add_in_vc() {
		
		add_shortcode("trx_widget_categories_list", "trx_addons_sc_widget_categories_list");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_categories_list", 'trx_addons_sc_widget_categories_list_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Categories_List extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_categories_list_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_categories_list_add_in_vc_params')) {
	function trx_addons_sc_widget_categories_list_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_widget_categories_list');
		// Prepare lists
		$post_type = $vc_edit && !empty($vc_params['post_type']) ? $vc_params['post_type'] : 'post';
		$taxonomy = $vc_edit && !empty($vc_params['taxonomy']) ? $vc_params['taxonomy'] : 'category';
		$taxonomies_objects = get_object_taxonomies($post_type, 'objects');
		$taxonomies = array();
		if (is_array($taxonomies_objects)) {
			foreach ($taxonomies_objects as $slug=>$taxonomy_obj) {
				$taxonomies[$slug] = $taxonomy_obj->label;
			}
		}

		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_categories_list",
				"name" => esc_html__("Categories List", 'trx_addons'),
				"description" => wp_kses_data( __("Insert categories list with icons or images", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_categories_list',
				"class" => "trx_widget_categories_list",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "title",
							"heading" => esc_html__("Widget title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "style",
							"heading" => esc_html__("Style", 'trx_addons'),
							"description" => wp_kses_data( __("Select style to display categories list", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"std" => 1,
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('widgets', 'categories_list'), 'trx_widget_categories_list')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "post_type",
							"heading" => esc_html__("Post type", 'trx_addons'),
							"description" => wp_kses_data( __("Select post type to get taxonomies from", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-3',
							"admin_label" => true,
							"std" => 'post',
							"value" => array_flip(trx_addons_get_list_posts_types()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "taxonomy",
							"heading" => esc_html__("Taxonomy", 'trx_addons'),
							"description" => wp_kses_data( __("Select taxonomy to get terms from", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-3',
							"admin_label" => true,
							"std" => 'category',
							"value" => array_flip($taxonomies),
							"type" => "dropdown"
						),
						array(
							"param_name" => "cat_list",
							"heading" => esc_html__("List of the terms", 'trx_addons'),
							"description" => wp_kses_data( __("Comma separated list of the term's slugs to show. If empty - show 'number' terms (see the field below)", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "number",
							"heading" => esc_html__("Number of categories to show", 'trx_addons'),
							"description" => wp_kses_data( __("How many categories display in widget?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"value" => "5",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns number to show", 'trx_addons'),
							"description" => wp_kses_data( __("How many columns use to display categories list?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"value" => "5",
							"type" => "textfield"
						),
						array(
							"param_name" => "show_thumbs",
							"heading" => esc_html__("Show thumbs", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display term's thumbnails (if exists)?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array("Show thumbs" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_posts",
							"heading" => esc_html__("Show posts number", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display posts number?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array("Show posts number" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_children",
							"heading" => esc_html__("Show children", 'trx_addons'),
							"description" => wp_kses_data( __("Show only children of current category", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "0",
							"value" => array("Show children" => "1" ),
							"type" => "checkbox"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_categories_list');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_categories_list_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_categories_list_add_in_elementor' );
	function trx_addons_sc_widget_categories_list_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Categories_List extends TRX_Addons_Elementor_Widget {

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
					'number' => 'size'
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
				return 'trx_widget_categories_list';
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
				return __( 'Widget: Categories List', 'trx_addons' );
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
				return 'eicon-posts-grid';
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
				// If open params in Elementor Editor
				$params = $this->get_sc_params();
				// Prepare lists
				$post_type = !empty($params['post_type']) ? $params['post_type'] : 'post';
				$taxonomy = !empty($params['taxonomy']) ? $params['taxonomy'] : 'category';
				$tax_obj = get_taxonomy($taxonomy);

				$this->start_controls_section(
					'section_sc_categories_list',
					[
						'label' => __( 'Widget: Categories List', 'trx_addons' ),
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
					'style',
					[
						'label' => __( 'Style', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('widgets', 'categories_list'), 'trx_widget_categories_list'),
						'default' => 1,
					]
				);

				$this->add_control(
					'post_type',
					[
						'label' => __( 'Post type', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_posts_types(),
						'default' => 'post'
					]
				);

				$this->add_control(
					'taxonomy',
					[
						'label' => __( 'Taxonomy', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_taxonomies(false, $post_type),
						'default' => 'category'
					]
				);

				$this->add_control(
					'cat_list',
					[
						'label' => __( 'Categories', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT2,
						'options' => trx_addons_array_merge(array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
																		 $taxonomy == 'category' 
																			? trx_addons_get_list_categories() 
																			: trx_addons_get_list_terms(false, $taxonomy)
																		),
						'multiple' => true,
						'default' => []
					]
				);
				
				$this->add_control(
					'number',
					[
						'label' => __( 'Number', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify number of categories to show", 'trx_addons') ),
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
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify number of columns for categories. If empty or 0 - auto detect by items number", 'trx_addons') ),
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
					'show_thumbs',
					[
						'label' => __( 'Show thumbs', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'default' => '1',
						'return_value' => '1'
					]
				);

				$this->add_control(
					'show_posts',
					[
						'label' => __( 'Show posts number', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'default' => '1',
						'return_value' => '1'
					]
				);

				$this->add_control(
					'show_children',
					[
						'label' => __( 'Show children', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Show only children of current category", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'default' => '0',
						'return_value' => '1'
					]
				);

				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Categories_List() );
	}
}
?>