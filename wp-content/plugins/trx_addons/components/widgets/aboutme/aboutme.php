<?php
/**
 * Widget: About Me
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_aboutme_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_aboutme_load' );
	function trx_addons_widget_aboutme_load() {
		register_widget('trx_addons_widget_aboutme');
	}
}

// Widget Class
class trx_addons_widget_aboutme extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_aboutme',
							'description' => esc_html__('About me - photo and short description about the blog author', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_aboutme', esc_html__('ThemeREX About Me', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		
		$username = isset($instance['username']) ? $instance['username'] : '';
		$description = isset($instance['description']) ? $instance['description'] : '';
		$avatar = isset($instance['avatar']) ? $instance['avatar'] : '';
		$gravatar = empty($avatar);

		$blogusers = get_users( 'role=administrator' );
		if (count($blogusers) > 0) {
			if (empty($username) && empty($description))
				$description = $blogusers[0]->description;
			if (empty($username))
				$username = $blogusers[0]->display_name;
			if (empty($avatar)) {
				$mult = trx_addons_get_retina_multiplier();
				$avatar = get_avatar( $blogusers[0]->user_email, 220*$mult );
			}
		}
		if (!$gravatar && !empty($avatar)) {
			$avatar = trx_addons_get_attachment_url($avatar, trx_addons_get_thumb_size('masonry'));
			if (!empty($avatar)) {
				$attr = trx_addons_getimagesize($avatar);
				$avatar = '<img src="'.esc_url($avatar).'" alt="'.esc_attr($username).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
			}
		}

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/tpl.default.php',
									'trx_addons_args_widget_aboutme',
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'avatar', 'username', 'description')),
												$instance, 'trx_addons_widget_aboutme')
									);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['avatar'] = strip_tags($new_instance['avatar']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['description'] = strip_tags($new_instance['description']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_aboutme');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'avatar' => '',
			'username' => '',
			'description' => ''
			), 'trx_addons_widget_aboutme')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_aboutme');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_aboutme');

		$this->show_field(array('name' => 'avatar',
								'title' => __('Avatar (if empty - get gravatar by admin email):', 'trx_addons'),
								'value' => $instance['avatar'],
								'type' => 'image'));

		$this->show_field(array('name' => 'username',
								'title' => __('User name (if equal to # - not show):', 'trx_addons'),
								'value' => $instance['username'],
								'type' => 'text'));

		$this->show_field(array('name' => 'description',
								'title' => __('Short description about user (if equal to # - not show):', 'trx_addons'),
								'value' => $instance['description'],
								'type' => 'textarea'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_aboutme');
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_aboutme_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_aboutme_merge_styles');
	function trx_addons_widget_aboutme_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/_aboutme.scss';
		return $list;
	}
}



// trx_widget_aboutme
//-------------------------------------------------------------
/*
[trx_widget_aboutme id="unique_id" title="Widget title" avatar="image_url" username="User display name" description="short description"]
*/
if ( !function_exists( 'trx_addons_sc_widget_aboutme' ) ) {
	function trx_addons_sc_widget_aboutme($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_aboutme', $atts, array(
			// Individual params
			"title" => "",
			"avatar" => "",
			"username" => "",
			"description" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		extract($atts);
		$type = 'trx_addons_widget_aboutme';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_aboutme' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_aboutme wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_aboutme', 'widget_aboutme') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_aboutme', $atts, $content);
	}
}


// Add [trx_widget_aboutme] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_aboutme_add_in_vc')) {
	function trx_addons_sc_widget_aboutme_add_in_vc() {
		
		add_shortcode("trx_widget_aboutme", "trx_addons_sc_widget_aboutme");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_aboutme", 'trx_addons_sc_widget_aboutme_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Aboutme extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_aboutme_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_aboutme_add_in_vc_params')) {
	function trx_addons_sc_widget_aboutme_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_aboutme",
				"name" => esc_html__("About Me", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with blog owner's name, avatar and short description", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_aboutme',
				"class" => "trx_widget_aboutme",
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
							"param_name" => "avatar",
							"heading" => esc_html__("Avatar", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or write URL from other site for user's avatar. If empty - get gravatar from user's e-mail", 'trx_addons') ),
							"type" => "attach_image"
						),
						array(
							"param_name" => "username",
							"heading" => esc_html__("User name", 'trx_addons'),
							"description" => wp_kses_data( __("User display name. If empty - get display name of the first registered blog user", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "description",
							"heading" => esc_html__("Description", 'trx_addons'),
							"description" => wp_kses_data( __("Short description about user. If empty - get description of the first registered blog user", 'trx_addons') ),
							"type" => "textarea"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_aboutme' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_aboutme_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_aboutme_add_in_elementor' );
	function trx_addons_sc_widget_aboutme_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Aboutme extends TRX_Addons_Elementor_Widget {

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
					'avatar' => 'url'
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
				return 'trx_widget_aboutme';
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
				return __( 'Widget: About Me', 'trx_addons' );
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
				return 'eicon-icon-box';
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
					'section_sc_aboutme',
					[
						'label' => __( 'Widget: About Me', 'trx_addons' ),
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
					'avatar',
					[
						'label' => __( 'Avatar', 'trx_addons' ),
						'label_block' => true,
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						],
					]
				);
				
				$this->add_control(
					'username',
					[
						'label' => __( 'User name', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("User display name. If empty - get display name of the first registered blog user", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "User name", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'description',
					[
						'label' => __( 'Description', 'trx_addons' ),
						'label_block' => true,
						'description' => wp_kses_data( __("Short description about user. If empty - get description of the first registered blog user", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => ''
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "aboutme/tpe.aboutme.php",
										'trx_addons_args_widget_aboutme',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Aboutme() );
	}
}
?>