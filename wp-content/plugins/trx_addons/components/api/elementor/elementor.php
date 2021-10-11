<?php
/**
 * Plugin support: Elementor
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Check if plugin 'Elementor' is installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_elementor' ) ) {
	function trx_addons_exists_elementor() {
		return class_exists('Elementor\Plugin');
	}
}
*/

// Return true if Elementor exists and current mode is preview
if ( !function_exists( 'trx_addons_elm_is_preview' ) ) {
	function trx_addons_elm_is_preview() {
		return trx_addons_exists_elementor() 
				&& (\Elementor\Plugin::$instance->preview->is_preview_mode()
					|| (trx_addons_get_value_gp('post') > 0
						&& trx_addons_get_value_gp('action') == 'elementor'
						)
					);
	}
}
	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_elm_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_elm_load_scripts_front');
	function trx_addons_elm_load_scripts_front() {
		if (trx_addons_exists_elementor()) {
			if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
				//wp_enqueue_script( 'trx_addons-elementor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'elementor/elementor.js'), array('jquery'), null, true );
			}
		}
	}
}

	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_elm_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_elm_merge_styles');
	function trx_addons_elm_merge_styles($list) {
		if (trx_addons_exists_elementor()) {
			$list[] = TRX_ADDONS_PLUGIN_API . 'elementor/_elementor.scss';
		}
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_elm_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_elm_merge_styles_responsive');
	function trx_addons_elm_merge_styles_responsive($list) {
		if (trx_addons_exists_elementor()) {
			$list[] = TRX_ADDONS_PLUGIN_API . 'elementor/_elementor.responsive.scss';
		}
		return $list;
	}
}

	
// Merge plugin's specific scripts into single file
if ( !function_exists( 'trx_addons_elm_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_elm_merge_scripts');
	function trx_addons_elm_merge_scripts($list) {
		if (trx_addons_exists_elementor()) {
			$list[] = TRX_ADDONS_PLUGIN_API . 'elementor/elementor.js';
		}
		return $list;
	}
}


// Add responsive sizes
if ( !function_exists( 'trx_addons_elm_sass_responsive' ) ) {
	add_filter("trx_addons_filter_sass_responsive", 'trx_addons_elm_sass_responsive', 11);
	function trx_addons_elm_sass_responsive($list) {
		if (!isset($list['md_lg']))
			$list['md_lg'] = array(
									'min' => $list['sm']['max']+1,
									'max' => $list['lg']['max']
									);
		return $list;
	}
}
	
// Load required styles and scripts for Elementor Editor mode
if ( !function_exists( 'trx_addons_elm_editor_load_scripts' ) ) {
	add_action("elementor/editor/before_enqueue_scripts", 'trx_addons_elm_editor_load_scripts');
	function trx_addons_elm_editor_load_scripts() {
		trx_addons_load_scripts_admin(true);
		trx_addons_localize_scripts_admin();
		wp_enqueue_style(  'trx_addons-elementor-editor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'elementor/elementor.editor.css'), array(), null );
		wp_enqueue_script( 'trx_addons-elementor-editor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'elementor/elementor.editor.js'), array('jquery'), null, true );
	}
}
	
// Load required scripts for Elementor Preview mode
if ( !function_exists( 'trx_addons_elm_preview_load_scripts' ) ) {
	add_action("elementor/frontend/after_enqueue_scripts", 'trx_addons_elm_preview_load_scripts');
	function trx_addons_elm_preview_load_scripts() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script( 'trx_addons-elementor-preview', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'elementor/elementor.js'), array('jquery'), null, true );
		}
		do_action('trx_addons_action_pagebuilder_preview_scripts');
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_elm_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_elm_black_list' );
	function trx_addons_elm_black_list($list) {
		// Shortcodes
		$list[] = 'TRX_Addons_SOW_Widget_Action';
		$list[] = 'TRX_Addons_SOW_Widget_Anchor';
		$list[] = 'TRX_Addons_SOW_Widget_Blogger';
		$list[] = 'TRX_Addons_SOW_Widget_Button';
		$list[] = 'TRX_Addons_SOW_Widget_Countdown';
		$list[] = 'TRX_Addons_SOW_Widget_Form';
		$list[] = 'TRX_Addons_SOW_Widget_Googlemap';
		$list[] = 'TRX_Addons_SOW_Widget_Icons';
		$list[] = 'TRX_Addons_SOW_Widget_Popup';
		$list[] = 'TRX_Addons_SOW_Widget_Price';
		$list[] = 'TRX_Addons_SOW_Widget_Promo';
		$list[] = 'TRX_Addons_SOW_Widget_Skills';
		$list[] = 'TRX_Addons_SOW_Widget_Socials';
		$list[] = 'TRX_Addons_SOW_Widget_Table';
		$list[] = 'TRX_Addons_SOW_Widget_Title';
		// Widgets
		$list[] = 'trx_addons_widget_aboutme';
		$list[] = 'trx_addons_widget_audio';
		$list[] = 'trx_addons_widget_banner';
		$list[] = 'trx_addons_widget_calendar';
		$list[] = 'trx_addons_widget_categories_list';
		$list[] = 'trx_addons_widget_contacts';
		$list[] = 'trx_addons_widget_flickr';
		$list[] = 'trx_addons_widget_popular_posts';
		$list[] = 'trx_addons_widget_recent_news';
		$list[] = 'trx_addons_widget_recent_posts';
		$list[] = 'trx_addons_widget_slider';
		$list[] = 'trx_addons_widget_socials';
		$list[] = 'trx_addons_widget_twitter';
		$list[] = 'trx_addons_widget_video';
		// CPT
		$list[] = 'TRX_Addons_SOW_Widget_Cars';
		$list[] = 'trx_addons_widget_cars_compare';
		$list[] = 'trx_addons_widget_cars_search';
		$list[] = 'trx_addons_widget_cars_sort';
		$list[] = 'TRX_Addons_SOW_Widget_Courses';
		$list[] = 'TRX_Addons_SOW_Widget_Dishes';
		$list[] = 'TRX_Addons_SOW_Widget_Portfolio';
		$list[] = 'TRX_Addons_SOW_Widget_Properties';
		$list[] = 'trx_addons_widget_properties_compare';
		$list[] = 'trx_addons_widget_properties_search';
		$list[] = 'trx_addons_widget_properties_sort';
		$list[] = 'TRX_Addons_SOW_Widget_Services';
		$list[] = 'TRX_Addons_SOW_Widget_Matches';
		$list[] = 'TRX_Addons_SOW_Widget_Points';
		$list[] = 'TRX_Addons_SOW_Widget_Team';
		$list[] = 'TRX_Addons_SOW_Widget_Testimonials';
		// Layouts
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Cart';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Content';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Currency';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Featured';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Iconed_Text';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Language';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Login';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Logo';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Menu';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Search';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Title';
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Widgets';
		// API
		$list[] = 'trx_addons_widget_woocommerce_search';
		// Themes Market
		$list[] = 'trx_addons_widget_themes_search';
		return $list;
	}
}



// Init Elementor's support
//--------------------------------------------------------

// Set Elementor's options at once
if (!function_exists('trx_addons_elm_init_once')) {
	add_action( 'init', 'trx_addons_elm_init_once', 2 );
	function trx_addons_elm_init_once() {
		if (trx_addons_exists_elementor() && !get_option('trx_addons_setup_elementor_options', false)) {
			// Set components specific values to the Elementor's options
			do_action('trx_addons_action_set_elementor_options');
			// Set flag to prevent change Elementor's options again
			update_option('trx_addons_setup_elementor_options', 1);
		}
	}
}


// Add widget's categories and prepare class to create our widgets
if (!function_exists('trx_addons_elm_init')) {
	add_action( 'elementor/init', 'trx_addons_elm_init' );
	function trx_addons_elm_init() {

		// Add a custom category for ThemeREX Addons Shortcodes
		\Elementor\Plugin::$instance->elements_manager->add_category( 
			'trx_addons-elements',
			array(
				'title' => __( 'ThemeREX Addons Elements', 'trx_addons' ),
				'icon' => 'eicon-apps', //default icon
			),
			1 // position
		);

		// Add a custom category for ThemeREX Addons Widgets
		\Elementor\Plugin::$instance->elements_manager->add_category( 
			'trx_addons-widgets',
			array(
				'title' => __( 'ThemeREX Addons Widgets', 'trx_addons' ),
				'icon' => 'eicon-gallery-grid', //default icon
			),
			2 // position
		);

		// Add a custom category for ThemeREX Addons CPT
		\Elementor\Plugin::$instance->elements_manager->add_category( 
			'trx_addons-cpt',
			array(
				'title' => __( 'ThemeREX Addons Extensions', 'trx_addons' ),
				'icon' => 'eicon-gallery-grid', //default icon
			),
			3 // position
		);

		// Add a custom category for third-party shortcodes
		\Elementor\Plugin::$instance->elements_manager->add_category( 
			'trx_addons-support',
			array(
				'title' => __( 'ThemeREX Addons Support', 'trx_addons' ),
				'icon' => 'eicon-woocommerce', //default icon
			),
			4 // position
		);
		
		
		// Template to create our classes with widgets
		//---------------------------------------------
		if (class_exists('\Elementor\Widget_Base') && !class_exists('TRX_Addons_Elementor_Widget')) {
			abstract class TRX_Addons_Elementor_Widget extends \Elementor\Widget_Base {

				// List of shortcodes params,
				// that must be plain and get its value from the elementor's array
				// 'param_name' => ['array_key']
				private $plain_params = array(
					'url' => 'url',
					'link' => 'url',
					'image' => 'url',
					'bg_image' => 'url',
					'columns' => 'size',
					'count' => 'size',
					'offset' => 'size',
					'slides_space' => 'size',
				);
				
				// Set shortcode-specific list of params,
				// that must bubble up to the plain value
				protected function set_plain_params($list) {
					$this->plain_params = $list;
				}
				
				// Add shortcode-specific list of params,
				// that must bubble up to the plain value
				protected function add_plain_params($list) {
					$this->plain_params = array_merge($this->plain_params, $list);
				}

				// Return string with default subtitle
				protected function get_default_subtitle() {
					return __('Subtitle', 'trx_addons');
				}

				// Return string with default description
				protected function get_default_description() {
					return __('Some description text for this item', 'trx_addons');
				}

				/**
				 * Retrieve the list of scripts the widget depended on.
				 *
				 * Used to set scripts dependencies required to run the widget.
				 *
				 * @since 1.6.41
				 *
				 * @access public
				 *
				 * @return array Widget scripts dependencies.
				 */
				public function get_script_depends() {
					return [ 'trx_addons-elementor-preview' ];
				}
				
				// Get all elements from specified post
				protected function get_post_elements($post_id = 0) {
					$meta = array();
					if ($post_id == 0 && trx_addons_get_value_gp('action')=='elementor')
						$post_id = trx_addons_get_value_gp('post');
					if ($post_id > 0) {
						$meta = get_post_meta( $post_id, '_elementor_data', true );
						if (substr($meta, 0, 1) == '[')
							$meta = json_decode( $meta, true );
					}
					return $meta;
				}
				
				// Get sc params from the current post or from the specified _elementor_data (2-nd parameter)
				protected function get_sc_params($sc='', $meta=false) {
					if ($meta === false)
						$meta = $this->get_post_elements();
					if (empty($sc))
						$sc = $this->get_name();
					$params = false;
					if (is_array($meta)) {
						foreach($meta as $v) {
							if (!empty($v['widgetType']) && $v['widgetType'] == $sc) {
								$params = $v['settings'];
								break;
							} else if (!empty($v['elements']) && count($v['elements']) > 0) {
								$params = $this->get_sc_params($sc, $v['elements']);
								if ($params !== false)
									break;
							}
						}
					}
					return $params;
				}

				// Return shortcode's name
				function get_sc_name() {
					return $this->get_name();
				}

				// Return shortcode function's name
				function get_sc_function() {
					return sprintf("trx_addons_%s", str_replace(array('trx_sc_', 'trx_widget_'), array('sc_', 'sc_widget_'), $this->get_sc_name()));
				}

				
				// ADD CONTROLS FOR COMMON PARAMETERS
				// Attention! You can use next tabs to create sections inside:
				// TAB_CONTENT | TAB_STYLE | TAB_ADVANCED | TAB_RESPONSIVE | TAB_LAYOUT | TAB_SETTINGS
				//------------------------------------------------------------

				// Create section with controls from params array
				protected function add_common_controls($group, $params, $add_params) {
					if (!empty($group['label'])) {
						$this->start_controls_section(
							'section_'.$group['section'].'_params',
							[
								'label' => $group['label'],
								'tab' => empty($group['tab']) 
											? \Elementor\Controls_Manager::TAB_CONTENT 
											: $group['tab']
							]
						);
					}
					foreach ($params as $param) {
						if (isset($add_params[$param['name']])) {
							if (empty($add_params[$param['name']]))
								continue;
							else
								$param = array_merge($param, $add_params[$param['name']]);
							unset($add_params[$param['name']]);
						}
						$this->add_control($param['name'], $param);
					}
					if (count($add_params) > 0) {
						foreach ($add_params as $k => $v) {
							if (!empty($v) && is_array($v))
								$this->add_control($k, $v);
						}
					}
					if (!empty($group['label'])) {
						$this->end_controls_section();
					}
				}
				
				// Return parameters of the control with icons selector
				protected function get_icon_param($only_socials=false) {
					if (trx_addons_get_setting('icons_selector') == 'vc') {
						$params = [
							[
								'name' => 'icon',
								'type' => \Elementor\Controls_Manager::ICON,
								'label' => __( 'Icon', 'trx_addons' ),
								'label_block' => false,
								'default' => '',
							]
						];
					} else {
						$style = $only_socials ? trx_addons_get_setting('socials_type') : trx_addons_get_setting('icons_type');
						$params = [
							[
								'name' => 'icon',
								'type' => 'trx_icons',
								'label' => __( 'Icon', 'trx_addons' ),
								'label_block' => false,
								'default' => '',
								'options' => $style == 'icons' 
												? trx_addons_array_from_list(trx_addons_get_list_icons()) 
												: trx_addons_get_list_files($only_socials ? 'css/socials' : 'css/icons.png', 'png'),
								'style' => $style
							]
						];
					}
					return apply_filters('trx_addons_filter_elementor_add_icon_param', $params, $only_socials);
				}

				// Create control with icons selector
				protected function add_icon_param($group='', $add_params=array()) {
					$this->add_common_controls(
						[
							'label' => $group===false ? __('Icon', 'trx_addons') : $group,
							'section' => 'icon'
						],
						$this->get_icon_param(!empty($add_params['only_socials'])),
						$add_params
					);
				}

				// Return 'Slider' parameters
				protected function get_slider_param() {
					$params = [
						[
							"name" => "slider",
							'type' => \Elementor\Controls_Manager::SWITCHER,
							"label" => __("Slider", 'trx_addons'),
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						],
						[
							"name" => "slides_space",
							'type' => \Elementor\Controls_Manager::SLIDER,
							"label" => __('Space', 'trx_addons'),
							"description" => wp_kses_data( __('Space between slides', 'trx_addons') ),
							'condition' => [
								'slider' => '1',
							],
							'default' => [
								'size' => 0
							],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100
								]
							]
						],
						[
							'name' => 'slider_controls',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Slider controls', 'trx_addons' ),
							'label_block' => false,
							'options' => trx_addons_get_list_sc_slider_controls(),
							'condition' => [
								'slider' => '1',
							],
							'default' => 'none',
						],
						[
							'name' => 'slider_pagination',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Slider pagination', 'trx_addons' ),
							'label_block' => false,
							'options' => trx_addons_get_list_sc_slider_paginations(),
							'condition' => [
								'slider' => '1',
							],
							'default' => 'none',
						]
					];
					return apply_filters('trx_addons_filter_elementor_add_slider_param', $params);
				}
				
				// Create controls with 'Slider' params
				protected function add_slider_param($group=false, $add_params=array()) {
					$this->add_common_controls(
						[
							'label' => $group===false ? __('Slider', 'trx_addons') : $group,
							'section' => 'slider',
							'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
						],
						$this->get_slider_param(),
						$add_params
					);
				}

				// Return 'Title' parameters
				protected function get_title_param($button=true) {
					$params = [
						[
							'name' => 'title_style',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Title style', 'trx_addons' ),
							'label_block' => false,
							'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'title'), 'trx_sc_title'),
							'default' => 'default',
						],
						[
							'name' => 'title_tag',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Title tag', 'trx_addons' ),
							'label_block' => false,
							'options' => trx_addons_get_list_sc_title_tags(),
							'default' => 'none',
						],
						[
							'name' => 'title_align',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Title alignment', 'trx_addons' ),
							'label_block' => false,
							'options' => trx_addons_get_list_sc_aligns(),
							'default' => 'none',
						],
						[
							'name' => 'title',
							'type' => \Elementor\Controls_Manager::TEXT,
							'label' => __( "Title", 'trx_addons' ),
							"description" => wp_kses_data( __("Title of the block. Enclose any words in {{ and }} to make them italic or in (( and )) to make them bold. If title style is 'accent' - bolded element styled as shadow, italic - as a filled circle", 'trx_addons') ),
							'placeholder' => __( "Title", 'trx_addons' ),
							'default' => ''
						],
						[
							'name' => 'subtitle',
							'type' => \Elementor\Controls_Manager::TEXT,
							'label' => __( "Subtitle", 'trx_addons' ),
							'placeholder' => __( "Title text", 'trx_addons' ),
							'default' => ''
						],
						[
							'name' => 'description',
							'type' => \Elementor\Controls_Manager::TEXTAREA,
							'label' => __( 'Description', 'trx_addons' ),
							'label_block' => true,
							'placeholder' => __( "Short description of this block", 'trx_addons' ),
							'default' => '',
							'separator' => 'none',
							'rows' => 10,
							'show_label' => false,
						]
					];
					// Add button's params
					if ($button) {
						$params[] = [
										'name' => 'link',
										'type' => \Elementor\Controls_Manager::URL,
										'label' => __( "Button's Link", 'trx_addons' ),
										'label_block' => false,
										'placeholder' => __( 'http://your-link.com', 'trx_addons' ),
									];
						$params[] = [
										'name' => 'link_text',
										'type' => \Elementor\Controls_Manager::TEXT,
										'label' => __( "Button's text", 'trx_addons' ),
										'label_block' => false,
										'placeholder' => __( "Link's text", 'trx_addons' ),
										'default' => ''
									];
						$params[] = [
										'name' => 'link_style',
										'type' => \Elementor\Controls_Manager::SELECT,
										'label' => __( "Button's style", 'trx_addons' ),
										'label_block' => false,
										'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'button'), 'trx_sc_button'),
										'default' => 'default',
									];
						$params[] = [
										'name' => 'link_image',
										'type' => \Elementor\Controls_Manager::MEDIA,
										'label' => __( "Button's image", 'trx_addons' ),
										'default' => [
											'url' => '',
										],
									];
					}
					return apply_filters('trx_addons_filter_elementor_add_title_param', $params);
				}
				
				// Create controls with 'Title' params
				protected function add_title_param($group=false, $add_params=array()) {
					$this->add_common_controls(
						[
							'label' => $group===false ? __('Title, Description & Button', 'trx_addons') : $group,
							'section' => 'title',
							'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
						],
						$this->get_title_param(!isset($add_params['button']) || $add_params['button']),
						$add_params
					);
				}

				// Return 'Query' parameters
				protected function get_query_param() {
					$params = [
						[
							'name' => 'ids',
							'type' => \Elementor\Controls_Manager::TEXT,
							'label' => __( "IDs to show", 'trx_addons' ),
							"description" => wp_kses_data( __("Comma separated IDs list to show. If not empty - parameters 'cat', 'offset' and 'count' are ignored!", 'trx_addons') ),
							'placeholder' => __( "IDs list", 'trx_addons' ),
							'default' => ''
						],
						[
							"name" => "count",
							'type' => \Elementor\Controls_Manager::SLIDER,
							"label" => __('Count', 'trx_addons'),
							'condition' => [
								'ids' => '',
							],
							'default' => [
								'size' => 3
							],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 100
								]
							]
						],
						[
							"name" => "columns",
							'type' => \Elementor\Controls_Manager::SLIDER,
							"label" => __('Columns', 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of columns. If empty - auto detect by items number", 'trx_addons') ),
							'default' => [
								'size' => 0
							],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 12
								]
							]
						],
						[
							"name" => "offset",
							'type' => \Elementor\Controls_Manager::SLIDER,
							"label" => __('Offset', 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of items to skip before showed items", 'trx_addons') ),
							'condition' => [
								'ids' => '',
							],
							'default' => [
								'size' => 0
							],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100
								]
							]
						],
						[
							'name' => 'orderby',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Order by', 'trx_addons' ),
							'label_block' => false,
							'options' => trx_addons_get_list_sc_query_orderby(),
							'default' => 'none',
						],
						[
							'name' => 'order',
							'type' => \Elementor\Controls_Manager::SELECT,
							'label' => __( 'Order', 'trx_addons' ),
							'label_block' => false,
							'options' => trx_addons_get_list_sc_query_orders(),
							'default' => 'asc',
						]
					];
					return apply_filters('trx_addons_filter_elementor_add_query_param', $params);
				}
				
				// Create controls with 'Query' params
				protected function add_query_param($group=false, $add_params=array()) {
					$this->add_common_controls(
						[
							'label' => $group===false ? __('Query', 'trx_addons') : $group,
							'section' => 'query'
						],
						$this->get_query_param(),
						$add_params
					);
				}

				// Return 'Hide' parameters
				protected function get_hide_param($hide_on_frontpage=false) {
					$params = [
						[
							'name' => 'hide_on_desktop',
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label' => __( 'Hide on desktops', 'trx_addons' ),
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						],
						[
							'name' => 'hide_on_notebook',
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label' => __( 'Hide on notebooks', 'trx_addons' ),
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						],
						[
							'name' => 'hide_on_tablet',
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label' => __( 'Hide on tablets', 'trx_addons' ),
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						],
						[
							'name' => 'hide_on_mobile',
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label' => __( 'Hide on mobile devices', 'trx_addons' ),
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						]
					];
					if ($hide_on_frontpage) {
						$params[] = [
							'name' => 'hide_on_frontpage',
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label' => __( 'Hide on Frontpage', 'trx_addons' ),
							'label_off' => __( 'Off', 'trx_addons' ),
							'label_on' => __( 'On', 'trx_addons' ),
							'return_value' => '1'
						];
					}
					return apply_filters('trx_addons_filter_elementor_add_hide_param', $params);
				}
				
				// Create controls with 'Hide' params
				protected function add_hide_param($group=false, $add_params=array()) {
					$this->add_common_controls(
						[
							'label' => $group===false ? __('Hide', 'trx_addons') : $group,
							'section' => 'hide',
							'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
						],
						$this->get_hide_param(!empty($add_params['hide_on_frontpage'])),
						$add_params
					);
				}

				
				// RENDER SHORTCODE'S CONTENT
				//------------------------------------------------------------

				// Return widget's layout
				public function render() {
					$sc_func = $this->get_sc_function();
					if (function_exists($sc_func)) {
						trx_addons_sc_stack_push('trx_sc_layouts');		// To prevent wrap shortcodes output to the '<div class="sc_layouts_item"></div>'
						$output = call_user_func($sc_func, $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name()));
						trx_addons_sc_stack_pop();
						trx_addons_show_layout($output);
					}
				}

				// Show message (placeholder) about not existing shortcode
				public function shortcode_not_exists($sc, $plugin) {
					?><div class="trx_addons_sc_not_exists">
						<h5 class="trx_addons_sc_not_exists_title"><?php echo esc_html(sprintf(__('Shortcode %s is not available!', 'trx_addons'), $sc)); ?></h5>
						<div class="trx_addons_sc_not_exists_description">
							<p><?php echo esc_html(sprintf(__('Shortcode "%1$s" from plugin "%2$s" is not available in Elementor Editor!', 'trx_addons'), $sc, $plugin)); ?></p>
							<p><?php esc_html_e('Possible causes:', 'trx_addons'); ?></p>
							<ol class="trx_addons_sc_not_exists_causes">
								<li><?php echo esc_html(sprintf(__('Plugin "%s" is not installed or not active', 'trx_addons'), $plugin)); ?></li>
								<li><?php esc_html_e('The plugin registers a shortcode later than it asks for Elementor Editor', 'trx_addons'); ?></li>
							</ol>
							<p><?php esc_html_e("So in the editor instead of the shortcode you see this message. To see the real shortcode's output - save the changes and open this page in Frontend", 'trx_addons'); ?></p>
						</div>
					</div><?php
				}

				// Prepare params for our shortcodes
				protected function sc_prepare_atts($atts, $sc='', $level=0) {
					if (is_array($atts)) {
						foreach($atts as $k=>$v) {
							// If current element is group (repeater)
							if (is_array($v) && isset($v[0]) && is_array($v[0])) {
								foreach ($v as $k1=>$v1) {
									$atts[$k][$k1] = $this->sc_prepare_atts($v1, $sc, $level+1);
								}

							// Sinchronize 'id' and '_element_id'
							} else {
								// Make 'xxx' as plain string
								// and add 'xxx_extra' for each plain param
								if (in_array($k, array_keys($this->plain_params))) {
									$prm = explode('+', $this->plain_params[$k]);
									$atts["{$k}_extra"] = $v;
									if (isset($v[$prm[0]])) 
										$atts[$k] = $v = $v[$prm[0]] . (!empty($prm[1]) && isset($v[$prm[1]]) ? $v[$prm[1]] : '');
								}

								if ($k == '_element_id') {
									if (empty($atts['id'])) {
										$atts['id'] = !empty($v) 
														? $v . '_sc' // original '_element_id' is already applied to element's wrapper
														: $this->get_sc_name() . '_' . str_replace('.', '', mt_rand());
									}
	/*
								// Sinchronize 'class' and '_css_classes'
								// Not used, because 'class' is already applied to element's wrapper
								} else if ($k == '_css_classes') {
									if (empty($atts['class'])) $atts['class'] = $v;
	*/
								// Add icon_type='elementor' if attr 'icon' is present and equal to the 'fa fa-xxx'
								} else if ($k == 'icon' && trx_addons_is_elementor_icon($v)) {
									$atts['icon_type'] = 'elementor';

								}
							}
						}
					}
					return $level == 0 ? apply_filters('trx_addons_filter_elementor_sc_prepare_atts', $atts, $sc) : $atts;
				}

				
				// DISPLAY TEMPLATE'S PARTS
				//------------------------------------------------------------
				
				// Display title, subtitle and description for some shortcodes
				public function sc_show_titles($sc, $size='') {
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_API . 'elementor/templates/tpe.sc_titles.php',
											'trx_addons_args_sc_show_titles',
											array('sc' => $sc, 'size' => $size, 'element' => $this)
										);
					
				}

				// Display link button or image for some shortcodes
				public function sc_show_links($sc) {
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_API . 'elementor/templates/tpe.sc_links.php',
											'trx_addons_args_sc_show_links',
											array('sc' => $sc, 'element' => $this)
										);
				}

				// Display template from the shortcode 'Button'
				public function sc_show_button($sc) {
					?><# 
					var settings_sc_button_old = settings;
					settings = {
						'title': settings.link_text,
						'link': settings.link,
						'type': settings.link_style,
						'class': 'sc_item_button sc_item_button_'+settings.link_style+' <?php echo esc_attr($sc); ?>_button',
						'align': settings.title_align ? settings.title_align : 'none'
					};
					#><?php
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'button/tpe.button.php',
											'trx_addons_args_sc_show_button',
											array('sc' => $sc, 'element' => $this)
										);
					?><#
					settings = settings_sc_button_old;
					#><?php
				}

				// Display begin of the slider layout for some shortcodes
				public function sc_show_slider_wrap_start($sc) {
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_API . 'elementor/templates/tpe.sc_slider_start.php',
											'trx_addons_args_sc_show_slider_wrap',
											apply_filters('trx_addons_filter_sc_show_slider_args', array('sc' => $sc, 'element' => $this))
										);
				}

				// Display end of the slider layout for some shortcodes
				public function sc_show_slider_wrap_end($sc) {
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_API . 'elementor/templates/tpe.sc_slider_end.php',
											'trx_addons_args_sc_show_slider_wrap', 
											apply_filters('trx_addons_filter_sc_show_slider_args', array('sc' => $sc, 'element' => $this))
										);
				}
			}
		}
	}
}


// Check if icon name is from the Elementor icons
if ( !function_exists( 'trx_addons_is_elementor_icon' ) ) {
	function trx_addons_is_elementor_icon($icon) {
		return !empty($icon) && strpos($icon, 'fa ') !== false;
	}
}

// Prepare group atts for the new Elementor version: make associative array from list by key 'name'
// After the update Elementor 3.1.0+ (or near) internal structure of field type ::REPEATER was changed
// (fields list was converted to the associative array)
// and as result js-errors appears in the Elementor Editor:
// "Cannot read property 'global' of undefined"
// "TypeError: undefined is not an object (evaluating 't[o].global')"
if ( !function_exists( 'trx_addons_elm_prepare_group_params' ) ) {
	add_filter( 'trx_addons_sc_param_group_params', 'trx_addons_elm_prepare_group_params', 999 );
	function trx_addons_elm_prepare_group_params( $args ) {
		if ( is_array( $args ) && ! empty( $args[0]['name'] ) ) {
			$new = array();
			foreach( $args as $item ) {
				if ( isset( $item['name'] ) ) {
					$new[ $item['name'] ] = $item;
				}
			}
			$args = $new;
		}
		return $args;
	}
}

// Output inline CSS
// if current action is 'wp_ajax_elementor_render_widget' or 'admin_action_elementor'
// (called from Elementor Editor via AJAX or first load page content to the Editor)
//---------------------------------------------------------------------------------------
if (!function_exists('trx_addons_elm_print_inline_css')) {
	add_filter( 'elementor/widget/render_content', 'trx_addons_elm_print_inline_css', 10, 2 );
	function trx_addons_elm_print_inline_css($content, $widget=null) {
		if (doing_action('wp_ajax_elementor_render_widget') || doing_action('admin_action_elementor')) {
			$css = trx_addons_get_inline_css(true);
			if (!empty($css))
				$content .= sprintf('<style type="text/css">%s</style>', $css);
		}
		return $content;
	}
}



// Register custom controls for Elementor
//------------------------------------------------------------------------
if (!function_exists('trx_addons_elm_register_custom_controls')) {
	add_action( 'elementor/controls/controls_registered', 'trx_addons_elm_register_custom_controls' );
	function trx_addons_elm_register_custom_controls($elementor) {
		$controls = array('trx_icons');
		foreach ($controls as $control_id) {
			$control_filename = str_replace('_', '-', $control_id);
			$control_filename = TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . "elementor/params/{$control_filename}/{$control_filename}.php";
			require_once $control_filename;
			$class_name = 'Trx_Addons_Elementor_Control_' . ucwords( $control_id );
			$elementor->register_control( $control_id, new $class_name() );
		}
	}
}


// Add/Modify/Remove standard Elementor's shortcodes params
//------------------------------------------------------------------------

// Add/Remove shortcodes params to the existings sections
if (!function_exists('trx_addons_elm_add_params_inside_section')) {
	add_action( 'elementor/element/before_section_end', 'trx_addons_elm_add_params_inside_section', 10, 3 );
	function trx_addons_elm_add_params_inside_section($element, $section_id, $args) {

		if (!is_object($element)) return;
		
		$el_name = $element->get_name();
		
		// Add 'Hide bg image on XXX' to the rows
		if ( ($el_name == 'section' && $section_id == 'section_background')
			|| ($el_name == 'column' && $section_id == 'section_style')
			) {

			$element->add_control( 'hide_bg_image_on_tablet', array(
									'type' => \Elementor\Controls_Manager::SWITCHER,
									'label' => __( 'Hide bg image on the tablet', 'trx_addons' ),
									'label_on' => __( 'Hide', 'trx_addons' ),
									'label_off' => __( 'Show', 'trx_addons' ),
									'return_value' => 'tablet',
									'prefix_class' => 'hide_bg_image_on_',
								) );
			$element->add_control( 'hide_bg_image_on_mobile', array(
									'type' => \Elementor\Controls_Manager::SWITCHER,
									'label' => __( 'Hide bg image on the mobile', 'trx_addons' ),
									'label_on' => __( 'Hide', 'trx_addons' ),
									'label_off' => __( 'Show', 'trx_addons' ),
									'return_value' => 'mobile',
									'prefix_class' => 'hide_bg_image_on_',
								) );
		}

		// Add 'Extend background' and 'Background mask' to the rows, columns and text-editor
		if ( ($el_name == 'section' && $section_id == 'section_background')
			|| ($el_name == 'column' && $section_id == 'section_style')
			|| ($el_name == 'text-editor' && $section_id == 'section_background')
			) {
			$element->add_control( 'extra_bg', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => __("Extend background", 'trx_addons'),
									'options' => trx_addons_get_list_sc_content_extra_bg(''),
									'default' => '',
									'prefix_class' => 'sc_extra_bg_'
									) );
			$element->add_control( 'extra_bg_mask', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => __("Background mask", 'trx_addons'),
									'options' => trx_addons_get_list_sc_content_extra_bg_mask(''),
									'default' => '',
									'prefix_class' => 'sc_bg_mask_'
									) );
		}

		// Add 'Alter height/gap' to the spacer and divider
		if ( ($el_name == 'spacer' && $section_id == 'section_spacer')
				  || ($el_name == 'divider' && $section_id == 'section_divider')) {
			$element->add_control( 'alter_height', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => $el_name == 'divider' ? __("Alter gap", 'trx_addons') : __("Alter height", 'trx_addons'),
									'label_block' => true,
									'options' => trx_addons_get_list_sc_empty_space_heights(''),
									'default' => '',
									'prefix_class' => 'sc_height_'
									) );
		}
	}
}


// Add/Remove shortcodes params to the new section
if (!function_exists('trx_addons_elm_add_params_in_new_section')) {
	add_action( 'elementor/element/after_section_end', 'trx_addons_elm_add_params_in_new_section', 10, 3 );
	function trx_addons_elm_add_params_in_new_section($element, $section_id, $args) {

		if ( !is_object($element) ) return;
		
		if ( in_array($element->get_name(), array('column')) && $section_id == 'layout' ) {
			
			$element->start_controls_section( 'section_trx_layout',	array(
																		'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
																		'label' => __( 'Position', 'trx_addons' )
																	) );
			// Add 'Fix column' to the columns
			$element->add_control( 'fix_column', array(
													'type' => \Elementor\Controls_Manager::SWITCHER,
													'label' => __( 'Fix column', 'trx_addons' ),
													'description' => wp_kses_data( __("Fix this column when page scrolling. Attention! At least one column in the row must have a greater height than this column", 'trx_addons') ),
													'label_on' => __( 'Fix', 'trx_addons' ),
													'label_off' => __( 'No', 'trx_addons' ),
													'return_value' => 'fixed',
													'prefix_class' => 'sc_column_',
												) );
			$element->add_control( 'shift_x', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => __("The X-axis shift", 'trx_addons'),
									'options' => trx_addons_get_list_sc_content_shift(''),
									'default' => '',
									'prefix_class' => 'sc_shift_x_'
									) );
			$element->add_control( 'shift_y', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => __("The Y-axis shift", 'trx_addons'),
									'options' => trx_addons_get_list_sc_content_shift(''),
									'default' => '',
									'prefix_class' => 'sc_shift_y_'
									) );

			$element->end_controls_section();
		}
	}
}

/*
// Add classes with custom parameters to the standard elements in the backend
// Attention! This is an alter way to the parameter 'prefix_class' in the add_control()
//            Temporary leave in the code for the demo purpose
if (!function_exists('trx_addons_elm_add_params_classes_to_template')) {
	add_filter( 'elementor/element/print_template', 'trx_addons_elm_add_params_classes_to_template', 10, 2 );
	function trx_addons_elm_add_params_classes_to_template($template, $element) {
		if ( is_object($element) ) {
			if ( $element->get_name() == 'section' )
				$template = str_replace('elementor-row',
										'elementor-row'
										. ' {{ settings.hide_bg_image_on_tablet }}'
										. ' {{ settings.hide_bg_image_on_mobile }}',
										$template);
			else if ( $element->get_name() == 'column' )
				$template = str_replace('elementor-column-wrap',
										'elementor-column-wrap'
										. ' {{ settings.fix_column }}'
										. ' {{ settings.hide_bg_image_on_tablet }}'
										. ' {{ settings.hide_bg_image_on_mobile }}',
										$template);
		}
		return $template;
	}
}

// Add classes with custom parameters to the standard elements in the frontend
// Attention! This is an alter way to the parameter 'prefix_class' in the add_control()
//            Temporary leave in the code for the demo purpose
if (!function_exists('trx_addons_elm_add_params_classes_to_output')) {
	add_action( 'elementor/frontend/element/before_render', 'trx_addons_elm_add_params_classes_to_output' );
	function trx_addons_elm_add_params_classes_to_output($element) {
		if ( is_object($element) ) {
			if ( in_array($element->get_name(), array('section', 'column')) ) {
				$classes = array();
				if ( $element->get_settings('hide_bg_image_on_tablet') == 'hide_bg_image_on_tablet' )
					$classes[] = 'hide_bg_image_on_tablet';
				if ( $element->get_settings('hide_bg_image_on_mobile') == 'hide_bg_image_on_mobile' )
					$classes[] = 'hide_bg_image_on_mobile';
				if ( $element->get_settings('fix_column') == 'sc_column_fixed' )
					$classes[] = 'sc_column_fixed';
				if (count($classes) > 0) {
					$element->add_render_attribute( '_wrapper', array(
						'class' => $classes,
						//'data-my_data' => 'my-data-value',
						) );
				}
			}
		}
	}
}
*/

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_elm_wordpress_widget_args' ) ) {
	add_filter( 'elementor/widgets/wordpress/widget_args', 'trx_addons_elm_wordpress_widget_args', 10, 2 );
	function trx_addons_elm_wordpress_widget_args($widget_args, $widget) {
		return trx_addons_prepare_widgets_args($widget->get_name(), $widget->get_name());
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_elm_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_elm_importer_required_plugins', 10, 2 );
	function trx_addons_elm_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'elementor')!==false && !trx_addons_exists_elementor())
			$not_installed .= '<br>' . esc_html__('Elementor (free PageBuilder)', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_elm_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_elm_importer_set_options' );
	function trx_addons_elm_importer_set_options($options=array()) {
		if ( trx_addons_exists_elementor() && in_array('elementor', $options['required_plugins']) ) {
			$options['additional_options'][] = 'elementor%';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}
?>