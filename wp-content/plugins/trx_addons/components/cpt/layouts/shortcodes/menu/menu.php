<?php
/**
 * Shortcode: Display menu in the Layouts Builder
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */
	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_layouts_menu_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_layouts_menu_load_scripts_front');
	function trx_addons_sc_layouts_menu_load_scripts_front() {
		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/superfish.js'), array('jquery'), null, true );
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script( 'trx_addons-sc_layouts_menu', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/menu.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_menu_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_menu_merge_styles');
	add_filter("trx_addons_filter_merge_styles_layouts", 'trx_addons_sc_layouts_menu_merge_styles');
	function trx_addons_sc_layouts_menu_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/_menu.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_layouts_menu_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_layouts_menu_merge_styles_responsive');
	add_filter("trx_addons_filter_merge_styles_responsive_layouts", 'trx_addons_sc_layouts_menu_merge_styles_responsive');
	function trx_addons_sc_layouts_menu_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/_menu.responsive.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_layouts_menu_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_layouts_menu_merge_scripts');
	function trx_addons_sc_layouts_menu_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/menu.js';
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/jquery.slidemenu.js';
		return $list;
	}
}


// Load shortcode's specific scripts if current mode is Preview in the PageBuilder
if ( !function_exists( 'trx_addons_sc_layouts_menu_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_preview_scripts", 'trx_addons_sc_layouts_menu_load_scripts');
	function trx_addons_sc_layouts_menu_load_scripts() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'slidemenu', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/jquery.slidemenu.js'), array('jquery'), null, true );
	}
}


// Add menu layout to the mobile menu
if ( !function_exists( 'trx_addons_sc_layouts_menu_add_to_mobile_menu' ) ) {
	function trx_addons_sc_layouts_menu_add_to_mobile_menu($menu) {
		global $TRX_ADDONS_STORAGE;
		// Get menu items
		$tmp_pos1 = strpos($menu, '<ul');
		$tmp_pos1 = strpos($menu, '>', $tmp_pos1) + 1;
		$tmp_pos2 = strrpos($menu, '</ul>');
		$menu = substr($menu, $tmp_pos1, $tmp_pos2 - $tmp_pos1);
		// Add to the mobile menu
		if (!isset($TRX_ADDONS_STORAGE['menu_mobile'])) $TRX_ADDONS_STORAGE['menu_mobile'] = '';
		$TRX_ADDONS_STORAGE['menu_mobile'] .= $menu;
	}
}
	
// Return stored items as mobile menu
if ( !function_exists( 'trx_addons_sc_layouts_menu_get_mobile_menu' ) ) {
	add_filter("trx_addons_filter_get_mobile_menu", 'trx_addons_sc_layouts_menu_get_mobile_menu');
	function trx_addons_sc_layouts_menu_get_mobile_menu($menu) {
		global $TRX_ADDONS_STORAGE;
		return empty($TRX_ADDONS_STORAGE['menu_mobile']) 
					? '' 
					: "<ul id=\"menu_mobile_".esc_attr(mt_rand())."\">{$TRX_ADDONS_STORAGE['menu_mobile']}</ul>";
	}
}

// Add description to the menu item
if (!function_exists('trx_addons_sc_layouts_menu_add_menu_item_description')) {
	add_filter( 'nav_menu_item_title', 'trx_addons_sc_layouts_menu_add_menu_item_description', 10, 4 );
	function trx_addons_sc_layouts_menu_add_menu_item_description($title, $item, $args, $depth) {
		if (!empty($item->description)) {
			$title .= '<span class="sc_layouts_menu_item_description">' . trim($item->description) . '</span>';
		}
		return $title;
	}
}


// trx_sc_layouts_menu
//-------------------------------------------------------------
/*
[trx_sc_layouts_menu id="unique_id" menu="menu_id" location="menu_location" burger="0|1" mobile="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_menu' ) ) {
	function trx_addons_sc_layouts_menu($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_menu', $atts, array(
			// Individual params
			"type" => "default",
			"direction" => "horizontal",
			"location" => "",
			"menu" => "",
			"mobile_menu" => "0",
			"mobile_button" => "0",
			"animation_in" => "",
			"animation_out" => "",
			"hover" => "fade",
			"hide_on_mobile" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (trx_addons_is_off($atts['menu'])) $atts['menu'] = '';
		if (trx_addons_is_off($atts['location'])) $atts['location'] = '';
		$atts['direction'] = $atts['direction'] == 'vertical' ? 'vertical' : 'horizontal';

		// Slide menu support
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && in_array($atts['hover'], array('slide_line', 'slide_box')) )
			wp_enqueue_script( 'slidemenu', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/jquery.slidemenu.js'), array('jquery'), null, true );

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'menu/tpl.default.php'
										),
										'trx_addons_args_sc_layouts_menu',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_menu', $atts, $content);
	}
}


// Add [trx_sc_layouts_menu] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_menu_add_in_vc')) {
	function trx_addons_sc_layouts_menu_add_in_vc() {
		
		//if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_menu", "trx_addons_sc_layouts_menu");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_layouts_menu", 'trx_addons_sc_layouts_menu_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Layouts_Menu extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_layouts_menu_add_in_vc', 15);
}

// Return params
if (!function_exists('trx_addons_sc_layouts_menu_add_in_vc_params')) {
	function trx_addons_sc_layouts_menu_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_menu",
				"name" => esc_html__("Layouts: Menu", 'trx_addons'),
				"description" => wp_kses_data( __("Insert any menu to the custom layout", 'trx_addons') ),
				"category" => esc_html__('Layouts', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_menu',
				"class" => "trx_sc_layouts_menu",
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
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_get_list_sc_layouts_menu(), 'trx_sc_layouts_menu')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "direction",
							"heading" => esc_html__("Direction", 'trx_addons'),
							"description" => wp_kses_data( __("Select direction of the menu items", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							'dependency' => array(
								'element' => 'type',
								'value' => array('default')
							),
							"std" => "horizontal",
							"value" => array_flip(trx_addons_get_list_sc_directions()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "location",
							"heading" => esc_html__("Location", 'trx_addons'),
							"description" => wp_kses_data( __("Select menu location to insert to the layout", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6 vc_new_row',
					        'save_always' => true,
							"value" => array_flip(trx_addons_get_list_menu_locations()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "menu",
							"heading" => esc_html__("Menu", 'trx_addons'),
							"description" => wp_kses_data( __("Select menu to insert to the layout. If empty - use menu assigned in the field 'Location'", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							'dependency' => array(
								'element' => 'location',
								'value' => 'none'
							),
					        'save_always' => true,
							"value" => array_flip(trx_addons_get_list_menus()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "hover",
							"heading" => esc_html__("Hover", 'trx_addons'),
							"description" => wp_kses_data( __("Select the menu items hover", 'trx_addons') ),
							'dependency' => array(
								'element' => 'type',
								'value' => 'default'
							),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "fade",
							"value" => array_flip(trx_addons_get_list_menu_hover()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "animation_in",
							"heading" => esc_html__("Submenu animation in", 'trx_addons'),
							"description" => wp_kses_data( __("Select animation to show submenu", 'trx_addons') ),
							'dependency' => array(
								'element' => 'type',
								'value' => 'default'
							),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "fadeIn",
							"value" => array_flip(trx_addons_get_list_animations_in()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "animation_out",
							"heading" => esc_html__("Submenu animation out", 'trx_addons'),
							"description" => wp_kses_data( __("Select animation to hide submenu", 'trx_addons') ),
							'dependency' => array(
								'element' => 'type',
								'value' => 'default'
							),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "fadeOut",
							"value" => array_flip(trx_addons_get_list_animations_out()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "mobile_button",
							"heading" => esc_html__("Mobile button", 'trx_addons'),
							"description" => wp_kses_data( __("Add menu button instead menu on mobile devices. When it clicked - open menu", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "0",
							"value" => array(esc_html__("Add button", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "mobile_menu",
							"heading" => esc_html__("Add to the mobile menu", 'trx_addons'),
							"description" => wp_kses_data( __("Use this menu items as mobile menu (if mobile menu not selected in the theme)", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "0",
							"value" => array(esc_html__("Use as mobile menu", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "hide_on_mobile",
							"heading" => esc_html__("Hide on mobile devices", 'trx_addons'),
							"description" => wp_kses_data( __("Hide this item on mobile devices", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							'dependency' => array(
								'element' => 'type',
								'value' => 'default'
							),
							"std" => "0",
							"value" => array(esc_html__("Hide on the mobile devices", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_menu');
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_menu_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_menu_add_in_elementor' );
	function trx_addons_sc_layouts_menu_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Layouts_Menu extends TRX_Addons_Elementor_Layouts_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_layouts_menu';
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
				return __( 'Layouts: Menu', 'trx_addons' );
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
				return 'fa fa-bars';
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
					'section_sc_layouts_menu',
					[
						'label' => __( 'Layouts: Menu', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_get_list_sc_layouts_menu(), 'trx_sc_layouts_menu'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'direction',
					[
						'label' => __( 'Direction', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_directions(),
						'default' => 'horizontal',
						'condition' => [
							'type' => 'default'
						]
					]
				);

				$this->add_control(
					'location',
					[
						'label' => __( 'Location', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_menu_locations(),
						'default' => 'none'
					]
				);

				$this->add_control(
					'menu',
					[
						'label' => __( 'Menu', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_menus(),
						'default' => 'none',
						'condition' => [
							'location' => 'none'
						]
					]
				);

				$this->add_control(
					'hover',
					[
						'label' => __( 'Hover', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_menu_hover(),
						'default' => 'fade',
						'condition' => [
							'type' => 'default'
						]
					]
				);

				$this->add_control(
					'animation_in',
					[
						'label' => __( 'Submenu animation in', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_animations_in(),
						'default' => 'fadeIn',
						'condition' => [
							'type' => 'default'
						]
					]
				);

				$this->add_control(
					'animation_out',
					[
						'label' => __( 'Submenu animation out', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_animations_out(),
						'default' => 'fadeOut',
						'condition' => [
							'type' => 'default'
						]
					]
				);

				$this->add_control(
					'mobile_button',
					[
						'label' => __( 'Mobile button', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Add menu button instead menu on mobile devices. When it clicked - open menu", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'mobile_menu',
					[
						'label' => __( 'Add to the mobile menu', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Use this menu items as mobile menu (if mobile menu not selected in the theme)", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'hide_on_mobile',
					[
						'label' => __( 'Hide on mobile devices', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);
				
				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts_Menu() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Layouts_Menu extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_layouts_menu',
				esc_html__('ThemeREX Layouts: Menu', 'trx_addons'),
				array(
					'classname' => 'widget_layouts_menu',
					'description' => __('Insert any menu to the custom layout', 'trx_addons')
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
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array('type')
						),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', trx_addons_get_list_sc_layouts_menu(), $this->get_sc_name()),
						'type' => 'select'
					),
					'direction' => array(
						'label' => __('Direction', 'trx_addons'),
						"description" => wp_kses_data( __("Select direction of the menu items", 'trx_addons') ),
						'default' => 'horizontal',
						'options' => trx_addons_get_list_sc_directions(),
						'type' => 'select'
					),
					'location' => array(
						'label' => __('Location', 'trx_addons'),
						"description" => wp_kses_data( __("Select menu location to insert to the layout", 'trx_addons') ),
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array('location')
						),
						'options' => trx_addons_get_list_menu_locations(),
						'type' => 'select'
					),
					'menu' => array(
						'label' => __('Menu', 'trx_addons'),
						"description" => wp_kses_data( __("Select menu to insert to the layout. If empty - use menu assigned in the field 'Location'", 'trx_addons') ),
						'state_handler' => array(
							"location[none]" => array('show'),
							"_else[location]" => array('hide')
						),
						'options' => trx_addons_get_list_menus(),
						'type' => 'select'
					),
					'hover' => array(
						'label' => __('Hover', 'trx_addons'),
						"description" => wp_kses_data( __("Select the menu items hover", 'trx_addons') ),
						'state_handler' => array(
							"type[default]" => array('show'),
							"_else[type]" => array('hide')
						),
						'default' => 'fade',
						'options' => trx_addons_get_list_menu_hover(),
						'type' => 'select'
					),
					'animation_in' => array(
						'label' => __('Submenu animation in', 'trx_addons'),
						"description" => wp_kses_data( __("Select animation to show submenu", 'trx_addons') ),
						'state_handler' => array(
							"type[default]" => array('show'),
							"_else[type]" => array('hide')
						),
						'default' => 'fadeIn',
						'options' => trx_addons_get_list_animations_in(),
						'type' => 'select'
					),
					'animation_out' => array(
						'label' => __('Submenu animation out', 'trx_addons'),
						"description" => wp_kses_data( __("Select animation to hide submenu", 'trx_addons') ),
						'state_handler' => array(
							"type[default]" => array('show'),
							"_else[type]" => array('hide')
						),
						'default' => 'fadeOut',
						'options' => trx_addons_get_list_animations_out(),
						'type' => 'select'
					),
					'mobile_button' => array(
						'label' => __('Mobile button', 'trx_addons'),
						"description" => wp_kses_data( __("Add menu button instead menu on mobile devices. When it clicked - open menu", 'trx_addons') ),
						'default' => false,
						'type' => 'checkbox'
					),
					'mobile_menu' => array(
						'label' => __('Add to the mobile menu', 'trx_addons'),
						"description" => wp_kses_data( __("Use this menu items as mobile menu (if mobile menu not selected in the theme)", 'trx_addons') ),
						'default' => false,
						'type' => 'checkbox'
					),
					'hide_on_mobile' => array(
						'label' => __('Hide on mobile devices', 'trx_addons'),
						"description" => wp_kses_data( __("Hide this menu on mobile devices", 'trx_addons') ),
						'state_handler' => array(
							"type[default]" => array('show'),
							"_else[type]" => array('hide')
						),
						'default' => false,
						'type' => 'checkbox'
					)
				),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_layouts_menu', __FILE__, 'TRX_Addons_SOW_Widget_Layouts_Menu');
}
?>