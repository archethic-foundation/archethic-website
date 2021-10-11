<?php
/**
 * Plugin support: ThemeREX Donations
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_trx_donations' ) ) {
	function trx_addons_exists_trx_donations() {
		return class_exists('TRX_DONATIONS');
	}
}

// Return true, if current page is any trx_donations page
if ( !function_exists( 'trx_addons_is_trx_donations_page' ) ) {
	function trx_addons_is_trx_donations_page() {
		$rez = false;
		if (trx_addons_exists_trx_donations()) {
			$rez = (is_single() && get_query_var('post_type') == TRX_DONATIONS::POST_TYPE) 
					|| is_post_type_archive(TRX_DONATIONS::POST_TYPE) 
					|| is_tax(TRX_DONATIONS::TAXONOMY);
		}
		return $rez;
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_trx_donations_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_trx_donations_importer_required_plugins', 10, 2 );
	function trx_addons_trx_donations_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'trx_donations')!==false && !trx_addons_exists_trx_donations() )
			$not_installed .= '<br>' . esc_html__('trx_donations', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_trx_donations_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_trx_donations_importer_set_options' );
	function trx_addons_trx_donations_importer_set_options($options=array()) {
		if ( trx_addons_exists_trx_donations() && in_array('trx_donations', $options['required_plugins']) ) {
			$options['additional_options'][] = 'trx_donations_options';
		}
		return $options;
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_trx_donations_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_trx_donations_importer_check_row', 9, 4);
	function trx_addons_trx_donations_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'trx_donations')===false) return $flag;
		if ( trx_addons_exists_trx_donations() ) {
			if ($table == 'posts')
				$flag = $row['post_type']==TRX_DONATIONS::POST_TYPE;
		}
		return $flag;
	}
}


// VC support
//------------------------------------------------------------------------

// Add [trx_donations_form] and [trx_donations_list] in the VC shortcodes list
if (!function_exists('trx_addons_sc_trx_donations_add_in_vc')) {
	function trx_addons_sc_trx_donations_add_in_vc() {
	
		if (!trx_addons_exists_visual_composer() || !trx_addons_exists_trx_donations()) return;

		vc_lean_map( "trx_donations_form", 'trx_addons_sc_trx_donations_add_in_vc_params_df');
		class WPBakeryShortCode_Trx_Donations_Form extends WPBakeryShortCode {}

		vc_lean_map( "trx_donations_list", 'trx_addons_sc_trx_donations_add_in_vc_params_dl');
		class WPBakeryShortCode_Trx_Donations_List extends WPBakeryShortCode {}

		vc_lean_map( "trx_donations_info", 'trx_addons_sc_trx_donations_add_in_vc_params_di');
		class WPBakeryShortCode_Trx_Donations_Info extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_trx_donations_add_in_vc', 20);
}

// Return params for Donations form
if (!function_exists('trx_addons_sc_trx_donations_add_in_vc_params_df')) {
	function trx_addons_sc_trx_donations_add_in_vc_params_df() {
		$donations = TRX_DONATIONS::get_instance();
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_donations_form",
				"name" => esc_html__("Donations form", "trx_addons"),
				"description" => esc_html__("Insert form to allow visitors make donations", "trx_addons"),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				'icon' => 'icon_trx_sc_donations_form',
				"class" => "trx_sc_single trx_sc_donations_form",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "donation",
							"heading" => esc_html__("Donation", 'trx_addons'),
							"description" => wp_kses_data( __("Select donation to display form", 'trx_addons') ),
							"admin_label" => true,
							"value" => array_flip(trx_addons_get_list_posts(false, ['post_type' => TRX_DONATIONS::POST_TYPE, 'not_selected' => false])),
							"std" => "0",
							"type" => "dropdown"
						),
						array(
							"param_name" => "title",
							"heading" => esc_html__("Title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the form", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "subtitle",
							"heading" => esc_html__("Subtitle", 'trx_addons'),
							"description" => wp_kses_data( __("Subtitle of the form", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "description",
							"heading" => esc_html__("Description", 'trx_addons'),
							"description" => wp_kses_data( __("Description of the form", 'trx_addons') ),
							"type" => "textarea_safe"
						),
						array(
							"param_name" => "client_id",
							"heading" => esc_html__("PayPal Client ID", 'trx_addons'),
							"description" => wp_kses_data( __("Client ID from the PayPay application. If empty - used value from ThemeREX Donations options", 'trx_addons') ),
							"group" => esc_html__('PayPal', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "textfield"
						),
						array(
							"param_name" => "amount",
							"heading" => esc_html__("Default amount", 'trx_addons'),
							"description" => wp_kses_data( __("Specify default amount to make donation. If empty - used value from ThemeREX Donations options", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"group" => esc_html__('PayPal', 'trx_addons'),
							"type" => "textfield"
						),
						array(
							"param_name" => "sandbox",
							"heading" => esc_html__("Sandbox", 'trx_addons'),
							"description" => wp_kses_data( __("Enable sandbox mode to testing your payments without real money transfer", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"group" => esc_html__('PayPal', 'trx_addons'),
							"std" => "",
							"value" => array(
								esc_html__('Inherit', 'trx_addons') => '',
								esc_html__('On', 'trx_addons') => 'on',
								esc_html__('Off', 'trx_addons') => 'off'
							),
							"type" => "dropdown"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_donations_form' );
	}
}

// Return params for Donations list
if (!function_exists('trx_addons_sc_trx_donations_add_in_vc_params_dl')) {
	function trx_addons_sc_trx_donations_add_in_vc_params_dl() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_donations_list",
				"name" => esc_html__("Donations list", "trx_addons"),
				"description" => esc_html__("Insert list of donations", "trx_addons"),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				'icon' => 'icon_trx_sc_donations_list',
				"class" => "trx_sc_single trx_sc_donations_list",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "cat",
							"heading" => esc_html__("Category", 'trx_addons'),
							"description" => wp_kses_data( __("Donations category", 'trx_addons') ),
							"value" => array_merge(array(esc_html__('- Select category -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_DONATIONS::TAXONOMY))),
							"std" => "0",
							"type" => "dropdown"
						)
					),
					trx_addons_vc_add_query_param(''),
					array(
						array(
							"param_name" => "title",
							"heading" => esc_html__("Title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the donations list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "subtitle",
							"heading" => esc_html__("Subtitle", 'trx_addons'),
							"description" => wp_kses_data( __("Subtitle of the donations list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "description",
							"heading" => esc_html__("Description", 'trx_addons'),
							"description" => wp_kses_data( __("Description of the donations list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							"type" => "textarea_safe"
						),
						array(
							"param_name" => "link",
							"heading" => esc_html__("Link URL", 'trx_addons'),
							"description" => wp_kses_data( __("Specify URL for the button below list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "link_caption",
							"heading" => esc_html__("Link text", 'trx_addons'),
							"description" => wp_kses_data( __("Specify text for the button below list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_donations_list' );
	}
}

// Return params for Donations info
if (!function_exists('trx_addons_sc_trx_donations_add_in_vc_params_di')) {
	function trx_addons_sc_trx_donations_add_in_vc_params_di() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_donations_info",
				"name" => esc_html__("Donations info", "trx_addons"),
				"description" => esc_html__("Insert info about selected donation", "trx_addons"),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				'icon' => 'icon_trx_sc_donations_info',
				"class" => "trx_sc_single trx_sc_donations_info",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "donation",
							"heading" => esc_html__("Donation", 'trx_addons'),
							"description" => wp_kses_data( __("Donation", 'trx_addons') ),
							"admin_label" => true,
							"value" => array_flip(trx_addons_get_list_posts(false, ['post_type' => TRX_DONATIONS::POST_TYPE, 'not_selected' => false])),
							"std" => "0",
							"type" => "dropdown"
						),
						array(
							"param_name" => "show_featured",
							"heading" => esc_html__("Show image", 'trx_addons'),
							"description" => wp_kses_data( __("Show featured image", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "1",
							"value" => array(esc_html__("Show featured", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_title",
							"heading" => esc_html__("Show title", 'trx_addons'),
							"description" => wp_kses_data( __("Show title of the donation", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array(esc_html__("Show title", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_excerpt",
							"heading" => esc_html__("Show excerpt", 'trx_addons'),
							"description" => wp_kses_data( __("Show excerpt of the donation", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array(esc_html__("Show excerpt", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_goal",
							"heading" => esc_html__("Show goal", 'trx_addons'),
							"description" => wp_kses_data( __("Show goal value of the donation", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "1",
							"value" => array(esc_html__("Show goal", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_raised",
							"heading" => esc_html__("Show raised", 'trx_addons'),
							"description" => wp_kses_data( __("Show raised value of the donation", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array(esc_html__("Show raised", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_scale",
							"heading" => esc_html__("Show scale", 'trx_addons'),
							"description" => wp_kses_data( __("Show scale with raised value of the donation", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "1",
							"value" => array(esc_html__("Show scale", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_supporters",
							"heading" => esc_html__("Supporters", 'trx_addons'),
							"description" => wp_kses_data( __("How many supporters show in the list", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "3",
					        'save_always' => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "title",
							"heading" => esc_html__("Title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the donations list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6 vc_new_row',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "subtitle",
							"heading" => esc_html__("Subtitle", 'trx_addons'),
							"description" => wp_kses_data( __("Subtitle of the donations list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "description",
							"heading" => esc_html__("Description", 'trx_addons'),
							"description" => wp_kses_data( __("Description of the donations list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							"type" => "textarea_safe"
						),
						array(
							"param_name" => "link",
							"heading" => esc_html__("Link URL", 'trx_addons'),
							"description" => wp_kses_data( __("Specify URL for the button below list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "link_caption",
							"heading" => esc_html__("Link text", 'trx_addons'),
							"description" => wp_kses_data( __("Specify text for the button below list", 'trx_addons') ),
							"group" => esc_html__('Title', 'trx_addons'),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_donations_info' );
	}
}




// Elementor Widgets
//------------------------------------------------------

// Donation form
if (!function_exists('trx_addons_sc_trx_donations_add_in_elementor_df')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_trx_donations_add_in_elementor_df' );
	function trx_addons_sc_trx_donations_add_in_elementor_df() {

		if (!trx_addons_exists_trx_donations()) return;
		
		class TRX_Addons_Elementor_Widget_Trx_Donations_Form extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_donations_form';
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
				return __( 'Donations form', 'trx_addons' );
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
				return 'eicon-price-table';
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
				return ['trx_addons-support'];
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
					'section_sc_trx_donations_form',
					[
						'label' => __( 'Donations form', 'trx_addons' ),
					]
				);

				$donations_list = trx_addons_get_list_posts(false, ['post_type' => TRX_DONATIONS::POST_TYPE, 'not_selected' => false]);
				$default_donation = trx_addons_array_get_first($donations_list);

				$this->add_control(
					'donation',
					[
						'label' => __( 'Donation', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $donations_list,
						'default' => ''.$default_donation	// Make string for Elementor Editor
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'subtitle',
					[
						'label' => __( 'Subtitle', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'description',
					[
						'label' => __( 'Description', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => ''
					]
				);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_trx_donations_form_paypal',
					[
						'label' => __( 'PayPal Details', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'client_id',
					[
						'label' => __( 'PayPal Client ID', 'trx_addons' ),
						'description' => wp_kses_data( __("Client ID from the PayPay application. If empty - used value from ThemeREX Donations options", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);
				
				$this->add_control(
					'amount',
					[
						'label' => __( 'Default amount', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify default amount to make donation. If empty - used value from ThemeREX Donations options", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'sandbox',
					[
						'label' => __( 'Sandbox', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Enable sandbox mode to testing your payments without real money transfer", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => [
							'' => esc_html__('Inherit', 'trx_addons'),
							'on' => esc_html__('On', 'trx_addons'),
							'off' => esc_html__('Off', 'trx_addons')
						],
						'default' => ''
					]
				);

				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('trx_donations_form')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[trx_donations_form'
																	. ' donation="%1$s"'
																	. ' title="%2$s"'
																	. ' subtitle="%3$s"'
																	. ' description="%4$s"'
																	. ' client_id="%5$s"'
																	. ' amount="%6$s"'
																	. ' sandbox="%7$s"'
																. ']',
																$atts['donation'],
																$atts['title'],
																$atts['subtitle'],
																str_replace('"', "'", $atts['description']),
																$atts['client_id'],
																$atts['amount'],
																$atts['sandbox']
															)));
				} else
					$this->shortcode_not_exists('trx_donations_form', 'ThemeREX Donations');
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Trx_Donations_Form() );
	}
}



// Donation form
if (!function_exists('trx_addons_sc_trx_donations_add_in_elementor_dl')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_trx_donations_add_in_elementor_dl' );
	function trx_addons_sc_trx_donations_add_in_elementor_dl() {

		if (!trx_addons_exists_trx_donations()) return;
		
		class TRX_Addons_Elementor_Widget_Trx_Donations_List extends TRX_Addons_Elementor_Widget {

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
					'link' => 'url'
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
				return 'trx_donations_list';
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
				return __( 'Donations list', 'trx_addons' );
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
				return ['trx_addons-support'];
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
					'section_sc_trx_donations_list',
					[
						'label' => __( 'Donations list', 'trx_addons' ),
					]
				);

				$this->add_control(
					'cat',
					[
						'label' => __( 'Category', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Select category -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_DONATIONS::TAXONOMY)),
						'default' => '0'
					]
				);

				$this->add_query_param('');

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_trx_donations_list_titles',
					[
						'label' => __( 'Title & Button', 'trx_addons' ),
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'subtitle',
					[
						'label' => __( 'Subtitle', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'description',
					[
						'label' => __( 'Description', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => ''
					]
				);

				$this->add_control(
					'link',
					[
						'label' => __( 'Link', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::URL,
						'default' => ['url' => '']
					]
				);

				$this->add_control(
					'link_caption',
					[
						'label' => __( 'Link text', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('trx_donations_list')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[trx_donations_list'
																	. ' cat="%1$s"'
																	. ' title="%2$s"'
																	. ' subtitle="%3$s"'
																	. ' description="%4$s"'
																	. ' link="%5$s"'
																	. ' link_caption="%6$s"'
																	. ' ids="%7$s"'
																	. ' count="%8$s"'
																	. ' columns="%9$s"'
																	. ' offset="%10$s"'
																	. ' orderby="%11$s"'
																	. ' order="%12$s"'
																. ']',
																$atts['cat'],
																$atts['title'],
																$atts['subtitle'],
																str_replace('"', "'", $atts['description']),
																$atts['link'],
																$atts['link_caption'],
																$atts['ids'],
																$atts['count'],
																$atts['columns'],
																$atts['offset'],
																$atts['orderby'],
																$atts['order']
															)));
				} else
					$this->shortcode_not_exists('trx_donations_list', 'ThemeREX Donations');
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Trx_Donations_List() );
	}
}

// Donation form
if (!function_exists('trx_addons_sc_trx_donations_add_in_elementor_di')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_trx_donations_add_in_elementor_di' );
	function trx_addons_sc_trx_donations_add_in_elementor_di() {

		if (!trx_addons_exists_trx_donations()) return;
		
		class TRX_Addons_Elementor_Widget_Trx_Donations_Info extends TRX_Addons_Elementor_Widget {

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
					'show_supporters' => 'size'
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
				return 'trx_donations_info';
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
				return __( 'Donations info', 'trx_addons' );
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
				return 'eicon-info-box';
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
				return ['trx_addons-support'];
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
					'section_sc_trx_donations_info',
					[
						'label' => __( 'Donations info', 'trx_addons' ),
					]
				);

				$donations_list = trx_addons_get_list_posts(false, ['post_type' => TRX_DONATIONS::POST_TYPE, 'not_selected' => false]);
				$default_donation = trx_addons_array_get_first($donations_list);

				$this->add_control(
					'donation',
					[
						'label' => __( 'Donation', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $donations_list,
						'default' => ''.$default_donation	// Make string for Elementor Editor
					]
				);

				$this->add_control(
					'show_featured',
					[
						'label' => __( 'Show image', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'show_title',
					[
						'label' => __( 'Show title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'show_excerpt',
					[
						'label' => __( 'Show excerpt', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'show_goal',
					[
						'label' => __( 'Show goal', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'show_raised',
					[
						'label' => __( 'Show raised', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'show_scale',
					[
						'label' => __( 'Show scale', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'show_supporters',
					[
						'label' => __( 'Supporters', 'trx_addons' ),
						'description' => wp_kses_data( __("How many supporters show in the list", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 3
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 20
							]
						]
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_trx_donations_list_titles',
					[
						'label' => __( 'Title & Button', 'trx_addons' ),
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'subtitle',
					[
						'label' => __( 'Subtitle', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->add_control(
					'description',
					[
						'label' => __( 'Description', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => ''
					]
				);

				$this->add_control(
					'link',
					[
						'label' => __( 'Link', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::URL,
						'default' => ['url' => '']
					]
				);

				$this->add_control(
					'link_caption',
					[
						'label' => __( 'Link text', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('trx_donations_info')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[trx_donations_info'
																	. ' donation="%1$s"'
																	. ' title="%2$s"'
																	. ' subtitle="%3$s"'
																	. ' description="%4$s"'
																	. ' link="%5$s"'
																	. ' link_caption="%6$s"'
																	. ' show_featured="%7$s"'
																	. ' show_title="%8$s"'
																	. ' show_excerpt="%9$s"'
																	. ' show_goal="%10$s"'
																	. ' show_raised="%11$s"'
																	. ' show_scale="%12$s"'
																	. ' show_supporters="%13$s"'
																. ']',
																$atts['donation'],
																$atts['title'],
																$atts['subtitle'],
																str_replace('"', "'", $atts['description']),
																$atts['link'],
																$atts['link_caption'],
																$atts['show_featured'],
																$atts['show_title'],
																$atts['show_excerpt'],
																$atts['show_goal'],
																$atts['show_raised'],
																$atts['show_scale'],
																$atts['show_supporters']
															)));
				} else
					$this->shortcode_not_exists('trx_donations_info', 'ThemeREX Donations');
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Trx_Donations_Info() );
	}
}
?>