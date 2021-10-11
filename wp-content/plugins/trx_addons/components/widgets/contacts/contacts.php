<?php
/**
 * Widget: Display Contacts info
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_contacts_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_contacts_load' );
	function trx_addons_widget_contacts_load() {
		register_widget('trx_addons_widget_contacts');
	}
}

// Widget Class
class trx_addons_widget_contacts extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_contacts', 'description' => esc_html__('Contacts - logo and short description, address, phone and email', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_contacts', esc_html__('ThemeREX Contacts', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
	
		$logo = isset($instance['logo']) ? $instance['logo'] : '';
		$logo_retina = isset($instance['logo_retina']) ? $instance['logo_retina'] : '';
		// Uncomment next section (remove false from the condition)
		// if you want to get logo from current theme (if parameter 'logo' is empty)
		if (false && empty($logo)) {
			$logo = apply_filters('trx_addons_filter_theme_logo', '');
			if (is_array($logo)) {
				$logo = !empty($logo['logo']) ? $logo['logo'] : '';
				$logo_retina = !empty($logo['logo_retina']) ? $logo['logo_retina'] : $logo_retina;
			}
		}
		if (!empty($logo)) {
			$logo = trx_addons_get_attachment_url($logo, 'full');
			if (!empty($logo)) {
				$attr = trx_addons_getimagesize($logo);
				$logo = '<img src="'.esc_url($logo).'" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
			}
			// Logo for Retina
			if (!empty($logo_retina) && trx_addons_get_retina_multiplier() > 1) {
				$logo_retina = trx_addons_get_attachment_url($logo_retina, 'full');
				if (!empty($logo_retina)) {
					$logo = '<img src="'.esc_url($logo_retina).'" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
			}
		}

		$description = isset($instance['description']) ? $instance['description'] : '';
		$content = isset($instance['content']) ? $instance['content'] : '';

		$address = isset($instance['address']) ? $instance['address'] : '';
		$phone = isset($instance['phone']) ? $instance['phone'] : '';
		$email = isset($instance['email']) ? $instance['email'] : '';
		$columns = isset($instance['columns']) ? (int) $instance['columns'] : 0;
		$socials = isset($instance['socials']) ? (int) $instance['socials'] : 0;

		$googlemap = isset($instance['googlemap']) ? (int) $instance['googlemap'] : 0;
		$googlemap_height = !empty($instance['googlemap_height']) ? $instance['googlemap_height'] : 130;
		$googlemap_position = isset($instance['googlemap_position']) ? $instance['googlemap_position'] : 'top';

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'contacts/tpl.default.php',
									'trx_addons_args_widget_contacts', 
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'logo', 'logo_retina', 'description', 'content',
																			'email', 'columns', 'address', 'phone', 'socials', 'googlemap',
																			'googlemap_height', 'googlemap_position')),
												$instance, 'trx_addons_widget_contacts')
									);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['logo'] = strip_tags($new_instance['logo']);
		$instance['logo_retina'] = strip_tags($new_instance['logo_retina']);
		$instance['description'] = wp_kses_data($new_instance['description']);
		$instance['address'] = wp_kses_data($new_instance['address']);
		$instance['phone'] = wp_kses_data($new_instance['phone']);
		$instance['email'] = wp_kses_data($new_instance['email']);
		$instance['columns'] = isset( $new_instance['columns'] ) ? 1 : 0;
		$instance['socials'] = isset( $new_instance['socials'] ) ? 1 : 0;
		$instance['googlemap'] = isset( $new_instance['googlemap'] ) ? 1 : 0;
		$instance['googlemap_height'] = strip_tags($new_instance['googlemap_height']);
		$instance['googlemap_position'] = strip_tags($new_instance['googlemap_position']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_contacts');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'logo' => '',
			'logo_retina' => '',
			'description' => '',
			'address' => '',
			'phone' => '',
			'email' => '',
			'columns' => 1,
			'socials' => 1,
			'googlemap' => 1,
			'googlemap_height' => 140,
			'googlemap_position' => 'top',
			), 'trx_addons_widget_contacts')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_contacts');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_contacts');

		$this->show_field(array('name' => 'logo',
								'title' => __('Logo:', 'trx_addons'),
								'value' => $instance['logo'],
								'type' => 'image'));

		$this->show_field(array('name' => 'logo_retina',
								'title' => __('Logo for Retina:', 'trx_addons'),
								'value' => $instance['logo_retina'],
								'type' => 'image'));

		$this->show_field(array('name' => 'description',
								'title' => __('Short description about user:', 'trx_addons'),
								'value' => $instance['description'],
								'type' => 'textarea'));

		$this->show_field(array('name' => 'address',
								'title' => __('Address:', 'trx_addons'),
								'value' => $instance['address'],
								'type' => 'text'));

		$this->show_field(array('name' => 'phone',
								'title' => __('Phone:', 'trx_addons'),
								'value' => $instance['phone'],
								'type' => 'text'));

		$this->show_field(array('name' => 'email',
								'title' => __('E-mail:', 'trx_addons'),
								'value' => $instance['email'],
								'type' => 'text'));

		$this->show_field(array('name' => 'columns',
								'title' => '',
								'label' => __('Break on columns', 'trx_addons'),
								'value' => (int) $instance['columns'],
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'socials',
								'title' => '',
								'label' => __('Show Social icons', 'trx_addons'),
								'value' => (int) $instance['socials'],
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'googlemap',
								'title' => '',
								'label' => __('Show Google map', 'trx_addons'),
								'value' => (int) $instance['googlemap'],
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'googlemap_height',
								'title' => __('Google map height:', 'trx_addons'),
								'value' => $instance['googlemap_height'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'googlemap_position',
								'title' => __('Google map position:', 'trx_addons'),
								'value' => $instance['googlemap_position'],
								'options' => array(
													'top' => esc_html__('Top', 'trx_addons'),
													'left' => esc_html__('Left', 'trx_addons'),
													'right' => esc_html__('Right', 'trx_addons')
													),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_contacts');
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_contacts_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_contacts_merge_styles');
	function trx_addons_widget_contacts_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'contacts/_contacts.scss';
		return $list;
	}
}



// trx_widget_contacts
//-------------------------------------------------------------
/*
[trx_widget_contacts id="unique_id" title="Widget title" logo="image_url" logo_retina="image_url" description="short description" address="Address string" phone="Phone" email="Email" socials="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_widget_contacts' ) ) {
	function trx_addons_sc_widget_contacts($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_contacts', $atts, array(
			// Individual params
			"title" => "",
			"logo" => "",
			"logo_retina" => "",
			"description" => "",
			"googlemap" => 0,
			"googlemap_height" => 140,
			"googlemap_position" => "top",
			"address" => "",
			"phone" => "",
			"email" => "",
			"columns" => 0,
			"socials" => 0,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if ($atts['columns']=='') $atts['columns'] = 0;
		if ($atts['socials']=='') $atts['socials'] = 0;
		if ($atts['googlemap']=='') $atts['googlemap'] = 0;
		extract($atts);
		$atts['content'] = do_shortcode($content);
		$type = 'trx_addons_widget_contacts';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_contacts' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_contacts wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_contacts', 'widget_contacts') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_contacts', $atts, $content);
	}
}


// Add [trx_widget_contacts] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_contacts_add_in_vc')) {
	function trx_addons_sc_widget_contacts_add_in_vc() {
		
		add_shortcode("trx_widget_contacts", "trx_addons_sc_widget_contacts");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_contacts", 'trx_addons_sc_widget_contacts_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Contacts extends WPBakeryShortCodesContainer {}
	}
	add_action('init', 'trx_addons_sc_widget_contacts_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_contacts_add_in_vc_params')) {
	function trx_addons_sc_widget_contacts_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_contacts",
				"name" => esc_html__("Contacts", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with logo, short description and contacts", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_contacts',
				"class" => "trx_widget_contacts",
				"content_element" => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_widget_contacts'),
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
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
							"param_name" => "logo",
							"heading" => esc_html__("Logo", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or write URL from other site for site's logo.", 'trx_addons') ),
							"type" => "attach_image"
						),
						array(
							"param_name" => "logo_retina",
							"heading" => esc_html__("Logo Retina", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or write URL from other site: site's logo for the Retina display.", 'trx_addons') ),
							"type" => "attach_image"
						),
						array(
							"param_name" => "description",
							"heading" => esc_html__("Description", 'trx_addons'),
							"description" => wp_kses_data( __("Short description about user. If empty - get description of the first registered blog user", 'trx_addons') ),
							"type" => "textarea"
						),
						array(
							"param_name" => "address",
							"heading" => esc_html__("Address", 'trx_addons'),
							"description" => wp_kses_data( __("Address string. Use '|' to split this string on two parts", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "phone",
							"heading" => esc_html__("Phone", 'trx_addons'),
							"description" => wp_kses_data( __("Your phone", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "email",
							"heading" => esc_html__("E-mail", 'trx_addons'),
							"description" => wp_kses_data( __("Your e-mail address", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Break on columns", 'trx_addons'),
							"description" => wp_kses_data( __("Display address at left side and phone with email at right side", 'trx_addons') ),
							"std" => "0",
							"value" => array("Break on columns" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "googlemap",
							"heading" => esc_html__("Show Googlemap", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want to display Google map with address above", 'trx_addons') ),
							"std" => "0",
							"value" => array("Show Google map" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "googlemap_height",
							"heading" => esc_html__("Googlemap height", 'trx_addons'),
							"description" => wp_kses_data( __("Height of the Google map", 'trx_addons') ),
							'dependency' => array(
								'element' => 'googlemap',
								'value' => '1',
							),
							"type" => "textfield"
						),
						array(
							"param_name" => "googlemap_position",
							"heading" => esc_html__("Googlemap position", 'trx_addons'),
							"description" => wp_kses_data( __("Select position of the Google map", 'trx_addons') ),
							'dependency' => array(
								'element' => 'googlemap',
								'value' => '1',
							),
							"std" => "top",
							"value" => array(
								esc_html__('Top', 'trx_addons') => 'top',
								esc_html__('Left', 'trx_addons') => 'left',
								esc_html__('Right', 'trx_addons') => 'right'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "socials",
							"heading" => esc_html__("Show Social Icons", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want to display icons with links on your profiles in the Social networks?", 'trx_addons') ),
							"std" => "0",
							"value" => array("Show Social Icons" => "1" ),
							"type" => "checkbox"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_contacts');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_contacts_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_contacts_add_in_elementor' );
	function trx_addons_sc_widget_contacts_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Contacts extends TRX_Addons_Elementor_Widget {

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
					'logo' => 'url',
					'logo_retina' => 'url',
					'googlemap_height' => 'size+unit'
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
				return 'trx_widget_contacts';
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
				return __( 'Widget: Contacts', 'trx_addons' );
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
				return 'eicon-image-box';
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
					'section_sc_contacts',
					[
						'label' => __( 'Widget: Contacts', 'trx_addons' ),
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
					'logo',
					[
						'label' => __( 'Logo', 'trx_addons' ),
						'label_block' => true,
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						],
					]
				);

				$this->add_control(
					'logo_retina',
					[
						'label' => __( 'Logo for Retina', 'trx_addons' ),
						'label_block' => true,
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						],
					]
				);

				$this->add_control(
					'columns',
					[
						'label' => __( 'Break on columns', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Display address at left side and phone with email at right side", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'heading_description',
					[
						'label' => __( 'Description', 'elementor' ),
						'description' => wp_kses_data( __("Short description", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				
				$this->add_control(
					'description',
					[
						'label' => '',
						'label_block' => true,
						'show_label' => false,
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => ''
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_contacts_address',
					[
						'label' => __( 'Contacts', 'trx_addons' ),
					]
				);

				$this->add_control(
					'address',
					[
						'label' => __( 'Address', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Address", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'phone',
					[
						'label' => __( 'Phone', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Phone", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'email',
					[
						'label' => __( 'E-mail', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "E-mail", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'socials',
					[
						'label' => __( 'Show social icons', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_contacts_googlemap',
					[
						'label' => __( 'Google map', 'trx_addons' ),
					]
				);

				$this->add_control(
					'googlemap',
					[
						'label' => __( 'Show Google map', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'googlemap_height',
					[
						'label' => __( 'Height', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 130,
							'unit' => 'px'
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500
							],
							'em' => [
								'min' => 0,
								'max' => 50
							],
						],
						'size_units' => [ 'px', 'em' ],
						'condition' => [
							'googlemap' => '1'
						],
						'selectors' => [
							'{{WRAPPER}} .sc_googlemap' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'googlemap_position',
					[
						'label' => __( 'Position', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
								'top' => __('Top', 'trx_addons'),
								'left' => __('Left', 'trx_addons'),
								'right' => __('Right', 'trx_addons')
							),
						'default' => 'top',
						'condition' => [
							'googlemap' => '1'
						]
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "contacts/tpe.contacts.php",
										'trx_addons_args_widget_contacts',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Contacts() );
	}
}
?>