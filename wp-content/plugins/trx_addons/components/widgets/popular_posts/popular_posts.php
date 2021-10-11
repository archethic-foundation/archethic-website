<?php
/**
 * Widget: Popular posts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_popular_posts_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_popular_posts_load' );
	function trx_addons_widget_popular_posts_load() {
		register_widget('trx_addons_widget_popular_posts');
	}
}

// Widget Class
class trx_addons_widget_popular_posts extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_popular_posts', 'description' => esc_html__('The most popular and most commented blog posts', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_popular_posts', esc_html__('ThemeREX Most Popular & Commented Posts', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$tabs = array(
			array(
				'title' => isset($instance['title_popular']) 	? $instance['title_popular']	: '',
				'content' => ''
				),
			array(
				'title' => isset($instance['title_commented'])	? $instance['title_commented']	: '',
				'content' => ''
				),
			array(
				'title' => isset($instance['title_liked'])		? $instance['title_liked']		: '',
				'content' => ''
				)
			);

		$number = isset($instance['number']) ? (int) $instance['number'] : '';

		$tabs_count = 0;

		for ($i=0; $i<3; $i++) {
			if (empty($tabs[$i]['title'])) continue;
			$tabs_count++;
			$q_args = array(
				'post_type' => 'post',
				'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
				'post_password' => '',
				'posts_per_page' => $number,
				'ignore_sticky_posts' => true,
				'order' => 'DESC',
			);
			if ($i==0) {			// Most popular
				$q_args['meta_key'] = 'trx_addons_post_views_count';
				$q_args['orderby'] = 'meta_value_num';
			} else if ($i==2) {		// Most liked
				$q_args['meta_key'] = 'trx_addons_post_likes_count';
				$q_args['orderby'] = 'meta_value_num';
			} else {				// Most commented
				$q_args['orderby'] = 'comment_count';
			}
			
			$q = new WP_Query($q_args); 
			
			// Loop posts
			if ( $q->have_posts() ) {
				$post_number = 0;
				set_query_var('trx_addons_output_widgets_posts', '');
				while ($q->have_posts()) { $q->the_post();
					$post_number++;
					trx_addons_get_template_part('templates/tpl.posts-list.php',
												'trx_addons_args_widgets_posts',
												apply_filters('trx_addons_filter_widget_posts_args',
													array(
														'counters' => $i==0 ? 'views' : ($i==1 ? 'comments' : 'likes'),
														'show_image' => isset($instance['show_image']) ? (int) $instance['show_image'] : 0,
														'show_date' => isset($instance['show_date']) ? (int) $instance['show_date'] : 0,
														'show_author' => isset($instance['show_author']) ? (int) $instance['show_author'] : 0,
														'show_counters'	=> isset($instance['show_counters']) ? (int) $instance['show_counters'] : 0,
														'show_categories' => isset($instance['show_categories']) ? (int) $instance['show_categories'] : 0
														),
													$instance, 'trx_addons_widget_popular_posts')
												);
					if ($post_number >= $number) break;
				}
				$tabs[$i]['content'] .= get_query_var('trx_addons_output_widgets_posts');
			}
		}

		wp_reset_postdata();

		if ( $tabs[0]['title'].$tabs[0]['content'].$tabs[1]['title'].$tabs[1]['content'].$tabs[2]['title'].$tabs[2]['content'] ) {

			trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'popular_posts/tpl.default.php',
										'trx_addons_args_widget_popular_posts', 
										apply_filters('trx_addons_filter_widget_args',
											array_merge($args, compact('title', 'tabs', 'tabs_count')),
											$instance, 'trx_addons_widget_popular_posts')
										);

			if (!is_customize_preview() && $tabs_count > 1) {
				wp_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
				wp_enqueue_script('jquery-effects-fade', false, array('jquery','jquery-effects-core'), null, true);
			}
		}
	}

	// Update the widget settings
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_popular'] = strip_tags($new_instance['title_popular']);
		$instance['title_commented'] = strip_tags($new_instance['title_commented']);
		$instance['title_liked'] = strip_tags($new_instance['title_liked']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (int) $new_instance['show_date'];
		$instance['show_image'] = (int) $new_instance['show_image'];
		$instance['show_author'] = (int) $new_instance['show_author'];
		$instance['show_counters'] = (int) $new_instance['show_counters'];
		$instance['show_categories'] = (int) $new_instance['show_categories'];
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_popular_posts');
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '', 
			'title_popular' => '', 
			'title_commented' => '', 
			'title_liked' => '', 
			'number' => '4', 
			'show_date' => '1', 
			'show_image' => '1', 
			'show_author' => '1', 
			'show_counters' => '1',
			'show_categories' => '1'
			), 'trx_addons_widget_popular_posts')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_popular_posts');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_popular_posts');
		
		$this->show_field(array('name' => 'title_popular',
								'title' => __('"Most popular" tab title:', 'trx_addons'),
								'value' => $instance['title_popular'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'title_commented',
								'title' => __('"Most commented" tab title:', 'trx_addons'),
								'value' => $instance['title_commented'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'title_liked',
								'title' => __('"Most liked" tab title:', 'trx_addons'),
								'value' => $instance['title_liked'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'number',
								'title' => __('Number posts to show:', 'trx_addons'),
								'value' => max(1, (int) $instance['number']),
								'type' => 'text'));

		$this->show_field(array('name' => 'show_image',
								'title' => __("Show post's image:", 'trx_addons'),
								'value' => (int) $instance['show_image'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_author',
								'title' => __("Show post's author:", 'trx_addons'),
								'value' => (int) $instance['show_author'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_date',
								'title' => __("Show post's date:", 'trx_addons'),
								'value' => (int) $instance['show_date'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_counters',
								'title' => __("Show post's counters:", 'trx_addons'),
								'value' => (int) $instance['show_counters'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_categories',
								'title' => __("Show post's categories:", 'trx_addons'),
								'value' => (int) $instance['show_categories'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_popular_posts');
	}
}


// trx_widget_popular_posts
//-------------------------------------------------------------
/*
[trx_widget_popular_posts id="unique_id" title="Widget title" title_popular="title for the tab 'most popular'" title_commented="title for the tab 'most commented'" title_liked="title for the tab 'most liked'" number="4"]
*/
if ( !function_exists( 'trx_addons_sc_widget_popular_posts' ) ) {
	function trx_addons_sc_widget_popular_posts($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_popular_posts', $atts, array(
			// Individual params
			"title" => "",
			"title_popular" => "",
			"title_commented" => "",
			"title_liked" => "",
			"number" => 4,
			"show_date" => 1,
			"show_image" => 1,
			"show_author" => 1,
			"show_counters" => 1,
			"show_categories" => 1,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if ($atts['show_date']=='') $atts['show_date'] = 0;
		if ($atts['show_image']=='') $atts['show_image'] = 0;
		if ($atts['show_author']=='') $atts['show_author'] = 0;
		if ($atts['show_counters']=='') $atts['show_counters'] = 0;
		if ($atts['show_categories']=='') $atts['show_categories'] = 0;
		extract($atts);
		$type = 'trx_addons_widget_popular_posts';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_popular_posts' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_popular_posts wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_popular_posts', 'widget_popular_posts') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_popular_posts', $atts, $content);
	}
}


// Add [trx_widget_popular_posts] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_popular_posts_add_in_vc')) {
	function trx_addons_sc_widget_popular_posts_add_in_vc() {
		
		add_shortcode("trx_widget_popular_posts", "trx_addons_sc_widget_popular_posts");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_popular_posts", 'trx_addons_sc_widget_popular_posts_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Popular_Posts extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_popular_posts_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_popular_posts_add_in_vc_params')) {
	function trx_addons_sc_widget_popular_posts_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_popular_posts",
				"name" => esc_html__("Popular Posts", 'trx_addons'),
				"description" => wp_kses_data( __("Insert popular posts list with thumbs, post's meta and category", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_popular_posts',
				"class" => "trx_widget_popular_posts",
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
							"param_name" => "title_popular",
							"heading" => esc_html__("Most popular tab title", 'trx_addons'),
							"description" => wp_kses_data( __("Most popular tab title", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "title_commented",
							"heading" => esc_html__("Most commented tab title", 'trx_addons'),
							"description" => wp_kses_data( __("Most commented tab title", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "title_liked",
							"heading" => esc_html__("Most liked tab title", 'trx_addons'),
							"description" => wp_kses_data( __("Most liked tab title", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "number",
							"heading" => esc_html__("Number posts to show", 'trx_addons'),
							"description" => wp_kses_data( __("How many posts display in widget?", 'trx_addons') ),
							"admin_label" => true,
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "show_image",
							"heading" => esc_html__("Show post's image", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's featured image?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show image" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_author",
							"heading" => esc_html__("Show post's author", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's author?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show author" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_date",
							"heading" => esc_html__("Show post's date", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's publish date?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show date" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_counters",
							"heading" => esc_html__("Show post's counters", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's counters?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show counters" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_categories",
							"heading" => esc_html__("Show post's categories", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's categories?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show categories" => "1" ),
							"type" => "checkbox"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_popular_posts');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_popular_posts_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_popular_posts_add_in_elementor' );
	function trx_addons_sc_widget_popular_posts_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Popular_Posts extends TRX_Addons_Elementor_Widget {

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
				return 'trx_widget_popular_posts';
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
				return __( 'Widget: Popular Posts', 'trx_addons' );
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
				return 'eicon-post-list';
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
					'section_sc_popular_posts',
					[
						'label' => __( 'Widget: Popular Posts', 'trx_addons' ),
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
					'title_popular',
					[
						'label' => __( 'Most popular tab title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Popular", 'trx_addons' ),
						'default' => __( "Popular", 'trx_addons' )
					]
				);

				$this->add_control(
					'title_commented',
					[
						'label' => __( 'Most commented tab title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Commented", 'trx_addons' ),
						'default' => __( "Commented", 'trx_addons' )
					]
				);

				$this->add_control(
					'title_liked',
					[
						'label' => __( 'Most liked tab title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Liked", 'trx_addons' ),
						'default' => __( "Liked", 'trx_addons' )
					]
				);

				$this->add_control(
					'number',
					[
						'label' => __( 'Number posts to show', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 4,
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 12
							]
						]
					]
				);

				$this->add_control(
					'details',
					[
						'label' => __( 'Details', 'elementor' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'show_image',
					[
						'label' => __( "Show post's image", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'default' => 1,
						'return_value' => '1'
					]
				);

				$this->add_control(
					'show_author',
					[
						'label' => __( "Show post's author", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'default' => 1,
						'return_value' => '1'
					]
				);

				$this->add_control(
					'show_date',
					[
						'label' => __( "Show post's date", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'default' => 1,
						'return_value' => '1'
					]
				);

				$this->add_control(
					'show_counters',
					[
						'label' => __( "Show post's counters", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'default' => 1,
						'return_value' => '1'
					]
				);

				$this->add_control(
					'show_categories',
					[
						'label' => __( "Show post's categories", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'default' => 1,
						'return_value' => '1'
					]
				);

				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Popular_Posts() );
	}
}
?>