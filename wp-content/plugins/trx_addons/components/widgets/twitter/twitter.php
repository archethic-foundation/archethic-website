<?php
/**
 * Widget: Twitter
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_twitter_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_twitter_load' );
	function trx_addons_widget_twitter_load() {
		register_widget('trx_addons_widget_twitter');
	}
}

// Widget Class
class trx_addons_widget_twitter extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_twitter', 'description' => esc_html__('Last Twitter Updates. Version for new Twitter API 1.1', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_twitter', esc_html__('ThemeREX Twitter', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		if (empty($instance['twitter_username']) || empty($instance['twitter_consumer_key']) || empty($instance['twitter_consumer_secret']) || empty($instance['twitter_token_key']) || empty($instance['twitter_token_secret'])) return;

		$data = trx_addons_get_twitter_data(array(
			'mode'            => 'user_timeline',
			'consumer_key'    => $instance['twitter_consumer_key'],
			'consumer_secret' => $instance['twitter_consumer_secret'],
			'token'           => $instance['twitter_token_key'],
			'secret'          => $instance['twitter_token_secret']
			)
		);
		
		if (!$data || !isset($data[0]['text'])) return;
		$instance['data'] = $data;

		extract( $args );

		/* Our variables from the widget settings. */
		$layout = $instance['type'] = isset($instance['type']) ? $instance['type'] : 'list';
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$bg_image = isset($instance['bg_image']) ? $instance['bg_image'] : '';
		
		// Before widget (defined by themes)
		if (!empty($bg_image)) {
			$bg_image = trx_addons_get_attachment_url($bg_image, trx_addons_get_thumb_size('avatar'));
			if (!empty($bg_image)) {
				$before_widget = str_replace(
					'class="widget ',
					'style="background-image:url('.esc_url($bg_image).');"'
						.' class="widget widget_bg_image ',
					$before_widget
				);
			}
		}

		// Before widget (defined by themes)
		trx_addons_show_layout($before_widget);
			
		// Display the widget title if one was input (before and after defined by themes)
		trx_addons_show_layout($title, $before_title, $after_title);

		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/tpl.'.trx_addons_esc($layout).'.php',
										TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/tpl.default.php'
										),
										'trx_addons_args_widget_twitter', 
										apply_filters('trx_addons_filter_widget_args',
											$instance,
											$instance, 'trx_addons_widget_twitter')
									);
			
		// After widget (defined by themes). */
		trx_addons_show_layout($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['bg_image'] = strip_tags( $new_instance['bg_image'] );
		$instance['twitter_username'] = strip_tags( $new_instance['twitter_username'] );
		$instance['twitter_consumer_key'] = strip_tags( $new_instance['twitter_consumer_key'] );
		$instance['twitter_consumer_secret'] = strip_tags( $new_instance['twitter_consumer_secret'] );
		$instance['twitter_token_key'] = strip_tags( $new_instance['twitter_token_key'] );
		$instance['twitter_token_secret'] = strip_tags( $new_instance['twitter_token_secret'] );
		$instance['twitter_count'] = max( 1, (int) $new_instance['twitter_count'] );
		$instance['follow'] = isset( $new_instance['follow'] ) ? 1 : 0;
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_twitter');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'bg_image' => '',
			'twitter_username' => '',
			'twitter_consumer_key' => '',
			'twitter_consumer_secret' => '',
			'twitter_token_key' => '',
			'twitter_token_secret' => '',
			'twitter_count' => 2,
			'follow' => 1
			), 'trx_addons_widget_twitter')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_twitter');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_twitter');
		
		$this->show_field(array('name' => 'twitter_count',
								'title' => __('Tweets number:', 'trx_addons'),
								'value' => max(1, (int) $instance['twitter_count']),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_username',
								'title' => __('Username in Twitter:', 'trx_addons'),
								'value' => $instance['twitter_username'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_consumer_key',
								'title' => __('Consumer Key:', 'trx_addons'),
								'value' => $instance['twitter_consumer_key'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_consumer_secret',
								'title' => __('Consumer Secret:', 'trx_addons'),
								'value' => $instance['twitter_consumer_secret'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_token_key',
								'title' => __('Token Key:', 'trx_addons'),
								'value' => $instance['twitter_token_key'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_token_secret',
								'title' => __('Token Secret:', 'trx_addons'),
								'value' => $instance['twitter_token_secret'],
								'type' => 'text'));

		$this->show_field(array('name' => 'follow',
								'title' => '',
								'label' => __('Show "Follow us"', 'trx_addons'),
								'value' => (int) $instance['follow'],
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'bg_image',
								'title' => __('Background image:', 'trx_addons'),
								'value' => $instance['bg_image'],
								'type' => 'image'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_twitter');
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_twitter_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_twitter_merge_styles');
	function trx_addons_widget_twitter_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/_twitter.scss';
		return $list;
	}
}



// trx_widget_twitter
//-------------------------------------------------------------
/*
[trx_widget_twitter id="unique_id" title="Widget title" bg_image="image_url" number="3" follow="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_widget_twitter' ) ) {
	function trx_addons_sc_widget_twitter($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_twitter', $atts, array(
			// Individual params
			"type" => 'list',
			"title" => "",
			"username" => "",
			"bg_image" => "",
			'back_image' => '',			// Alter name for 'bg_image' in VC (it broke bg_image)
			"count" => 2,
			"columns" => 1,
			"follow" => 1,
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
			"consumer_key" => "",
			"consumer_secret" => "",
			"token_key" => "",
			"token_secret" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if ($atts['follow']=='') $atts['follow'] = 0;
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';
		if (empty($atts['bg_image'])) $atts['bg_image'] = $atts['back_image'];
		extract($atts);

		$type = 'trx_addons_widget_twitter';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$atts['twitter_username'] = $username;
			$atts['twitter_consumer_key'] = $consumer_key;
			$atts['twitter_consumer_secret'] = $consumer_secret;
			$atts['twitter_token_key'] = $token_key;
			$atts['twitter_token_secret'] = $token_secret;
			$atts['twitter_count'] = max(1, (int) $count);
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_twitter' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_twitter wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_twitter', 'widget_twitter') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_twitter', $atts, $content);
	}
}


// Add [trx_widget_twitter] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_twitter_add_in_vc')) {
	function trx_addons_sc_widget_twitter_add_in_vc() {
		
		add_shortcode("trx_widget_twitter", "trx_addons_sc_widget_twitter");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map( "trx_widget_twitter", 'trx_addons_sc_widget_twitter_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Twitter extends WPBakeryShortCode {}

	}
	add_action('init', 'trx_addons_sc_widget_twitter_add_in_vc', 20);
}


// Return params
if (!function_exists('trx_addons_sc_widget_twitter_add_in_vc_params')) {
	
	function trx_addons_sc_widget_twitter_add_in_vc_params() {
		
		$params = array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select widget's layout", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "list",
							"admin_label" => true,
					        'save_always' => true,
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('widgets', 'twitter'), 'trx_widget_twitter')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "title",
							"heading" => esc_html__("Widget title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "count",
							"heading" => esc_html__("Tweets number", 'trx_addons'),
							"description" => wp_kses_data( __("Tweets number to show in the feed", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"value" => "2",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of columns. If empty - auto detect by items number", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							'dependency' => array(
								'element' => 'type',
								'value' => 'default'
							),
							"type" => "textfield"
						),
						array(
							"param_name" => "follow",
							"heading" => esc_html__("Show Follow Us", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display Follow Us link below the feed?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array("Show Follow Us" => "1" ),
							"type" => "checkbox"
						),
					),
					trx_addons_vc_add_slider_param(''),
					array(
						array(
							"param_name" => "back_image",		// Alter name for 'bg_image' in VC (it broke bg_image)
							"heading" => esc_html__("Widget background", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or write URL from other site for use it as widget background", 'trx_addons') ),
							"type" => "attach_image"
						),
						array(
							"param_name" => "username",
							"heading" => esc_html__("Twitter Username", 'trx_addons'),
							"description" => wp_kses_data( __("Twitter Username", 'trx_addons') ),
							"group" => esc_html__('Twitter account', 'trx_addons'),
							"type" => "textfield"
						),
						array(
							"param_name" => "consumer_key",
							"heading" => esc_html__("Consumer Key", 'trx_addons'),
							"description" => wp_kses_data( __("Specify Consumer Key from Twitter application", 'trx_addons') ),
							"group" => esc_html__('Twitter account', 'trx_addons'),
							"type" => "textfield"
						),
						array(
							"param_name" => "consumer_secret",
							"heading" => esc_html__("Consumer Secret", 'trx_addons'),
							"description" => wp_kses_data( __("Specify Consumer Secret from Twitter application", 'trx_addons') ),
							"group" => esc_html__('Twitter account', 'trx_addons'),
							"type" => "textfield"
						),
						array(
							"param_name" => "token_key",
							"heading" => esc_html__("Token Key", 'trx_addons'),
							"description" => wp_kses_data( __("Specify Token Key from Twitter application", 'trx_addons') ),
							"group" => esc_html__('Twitter account', 'trx_addons'),
							"type" => "textfield"
						),
						array(
							"param_name" => "token_secret",
							"heading" => esc_html__("Token Secret", 'trx_addons'),
							"description" => wp_kses_data( __("Specify Token Secret from Twitter application", 'trx_addons') ),
							"group" => esc_html__('Twitter account', 'trx_addons'),
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_id_param()
				);
		
		$params = trx_addons_vc_add_param_option($params, 'slider', array( 
																		'dependency' => array(
																			'element' => 'type',
																			'value' => 'default'
																			)
																		)
												);

		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_twitter",
				"name" => esc_html__("Twitter feed", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with Twitter feed", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_twitter',
				"class" => "trx_widget_twitter",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_widget_twitter' );
			
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_twitter_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_twitter_add_in_elementor' );
	function trx_addons_sc_widget_twitter_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Twitter extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_twitter';
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
				return __( 'Widget: Twitter', 'trx_addons' );
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
				return 'eicon-twitter-feed';
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
					'section_sc_twitter_account',
					[
						'label' => __( 'Twitter API Keys', 'trx_addons' ),
						'description' => wp_kses_data( __("To get API keys you need to create an application in your Twitter account", 'trx_addons') ),
					]
				);

				$this->add_control(
					'username',
					[
						'label' => __( 'Twitter Username', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Username", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'consumer_key',
					[
						'label' => __( 'Consumer Key', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Consumer Key", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'consumer_secret',
					[
						'label' => __( 'Consumer Secret', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Consumer Secret", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'token_key',
					[
						'label' => __( 'Token Key', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Token Key", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'token_secret',
					[
						'label' => __( 'Token Secret', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Token Secret", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_twitter',
					[
						'label' => __( 'ThemeREX Twitter', 'trx_addons' ),
						'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('widgets', 'twitter'), 'trx_widget_twitter'),
						'default' => 'list'
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
					'count',
					[
						'label' => __( 'Count', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 2
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
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 1
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
					'follow',
					[
						'label' => __( 'Show Follow Us', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'default' => '1',
						'return_value' => '1'
					]
				);

				$this->add_control(
					'bg_image',
					[
						'label' => __( 'Background Image', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						],
					]
				);

				$this->add_slider_param('', [
					'slider' => [
									'condition' => ['type' => 'default']
								]
					]);

				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Twitter() );
	}
}
?>