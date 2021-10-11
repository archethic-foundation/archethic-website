<?php
/**
 * Shortcode: Google Map
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_googlemap_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_googlemap_merge_styles');
	function trx_addons_sc_googlemap_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/_googlemap.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_googlemap_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_googlemap_merge_styles_responsive');
	function trx_addons_sc_googlemap_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/_googlemap.responsive.scss';
		return $list;
	}
}


// Merge googlemap specific scripts to the single file
if ( !function_exists( 'trx_addons_sc_googlemap_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_googlemap_merge_scripts');
	function trx_addons_sc_googlemap_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/googlemap.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/cluster/markerclusterer.min.js';
		return $list;
	}
}


// Load shortcode's specific scripts if current mode is Preview in the PageBuilder
if ( !function_exists( 'trx_addons_sc_googlemap_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_preview_scripts", 'trx_addons_sc_googlemap_load_scripts');
	function trx_addons_sc_googlemap_load_scripts() {
		trx_addons_enqueue_googlemap();
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script( 'trx_addons-sc_googlemap', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/googlemap.js'), array('jquery'), null, true );
			wp_enqueue_script( 'markerclusterer', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/cluster/markerclusterer.min.js'), array('jquery'), null, true );
		}
	}
}

	
// Add messages for JS
if ( !function_exists( 'trx_addons_sc_googlemap_localize_script' ) ) {
	add_filter("trx_addons_localize_script", 'trx_addons_sc_googlemap_localize_script');
	function trx_addons_sc_googlemap_localize_script($storage) {
		$storage['msg_sc_googlemap_not_avail'] = esc_html__('Googlemap service is not available', 'trx_addons');
		$storage['msg_sc_googlemap_geocoder_error'] = esc_html__('Error while geocode address', 'trx_addons');
		return $storage;
	}
}


// trx_sc_googlemap
//-------------------------------------------------------------
/*
[trx_sc_googlemap id="unique_id" style="grey" zoom="16" markers="encoded json data"]
*/
if ( !function_exists( 'trx_addons_sc_googlemap' ) ) {
	function trx_addons_sc_googlemap($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_googlemap', $atts, array(
			// Individual params
			"type" => "default",
			"zoom" => 16,
			"style" => 'default',
			"address" => '',
			"markers" => '',
			"cluster" => '',
			"width" => "100%",
			"height" => "400",
			"title" => '',
			"subtitle" => '',
			"description" => '',
			"prevent_scroll" => 0,
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
			"css" => "",
			// Content from non-containers PageBuilder
			"content" => ""
			)
		);
		
		if (!is_array($atts['markers']) && function_exists('vc_param_group_parse_atts'))
			$atts['markers'] = (array) vc_param_group_parse_atts( $atts['markers'] );

		$output = '';
		if ((is_array($atts['markers']) && count($atts['markers']) > 0) || !empty($atts['address'])) {
			if (!empty($atts['address'])) {
				$atts['markers'] = array(
										array(
											'title' => '',
											'description' => '',
											'address' => $atts['address'],
											'latlng' => '',
											'icon' => trx_addons_remove_protocol(trx_addons_get_option('api_google_marker')),
											'icon_width' => '',
											'icon_height' => ''
										)
									);
			} else {
				foreach ($atts['markers'] as $k=>$v) {
					if (!empty($v['description']) && function_exists('vc_value_from_safe'))
						$atts['markers'][$k]['description'] = trim( vc_value_from_safe( $v['description'] ) );
					if (!empty($v['icon'])) {
						$atts['markers'][$k]['icon'] = trx_addons_get_attachment_url($v['icon'], 'full');
						if (!empty($v['icon_retina']) && trx_addons_get_retina_multiplier() > 1 
							&& (empty($v['icon_width']) || empty($v['icon_height']))) {
							$attr = trx_addons_getimagesize($atts['markers'][$k]['icon']);
							$atts['markers'][$k]['icon_width'] = $attr[0];
							$atts['markers'][$k]['icon_height'] = $attr[1];
						}
					} else
						$v['icon'] = trx_addons_remove_protocol(trx_addons_get_option('api_google_marker'));
					if (!empty($v['icon_retina']) && trx_addons_get_retina_multiplier() > 1)
						$atts['markers'][$k]['icon'] = trx_addons_get_attachment_url($v['icon_retina'], 'full');
				}
			}
			$atts['zoom'] = max(0, min(21, $atts['zoom']));
	
			if (count($atts['markers']) > 1) {
				if (empty($atts['cluster'])) 
					$atts['cluster'] = trx_addons_remove_protocol(trx_addons_get_option('api_google_cluster'));
				if (empty($atts['cluster']))
					$atts['cluster'] = trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/cluster/cluster-icon.png');
				else if ((int) $atts['cluster'] > 0)
					$atts['cluster'] = trx_addons_get_attachment_url($atts['cluster'], apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('masonry'), 'googlemap-cluster'));
			} else if ($atts['zoom'] == 0)
				$atts['zoom'] = 16;
	
			$atts['class'] .= (!empty($atts['class']) ? ' ' : '') . trx_addons_add_inline_css_class(trx_addons_get_css_dimensions_from_values($atts['width'], $atts['height']));
	
			if (empty($atts['style'])) $atts['style'] = 'default';
	
			$atts['content'] = do_shortcode(empty($atts['content']) ? $content : $atts['content']);
			
			trx_addons_enqueue_googlemap();
			if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
				wp_enqueue_script( 'trx_addons-sc_googlemap', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/googlemap.js'), array('jquery'), null, true );
				if (count($atts['markers']) > 1)
					wp_enqueue_script( 'markerclusterer', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/cluster/markerclusterer.min.js'), array('jquery'), null, true );
			}
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'googlemap/tpl.default.php'
											),
											'trx_addons_args_sc_googlemap', 
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_googlemap', $atts, $content);
	}
}


// Add [trx_sc_googlemap] in the VC shortcodes list
if (!function_exists('trx_addons_sc_googlemap_add_in_vc')) {
	function trx_addons_sc_googlemap_add_in_vc() {
		
		add_shortcode("trx_sc_googlemap", "trx_addons_sc_googlemap");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_googlemap", 'trx_addons_sc_googlemap_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Googlemap extends WPBakeryShortCodesContainer {}
	}
	add_action('init', 'trx_addons_sc_googlemap_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_googlemap_add_in_vc_params')) {
	function trx_addons_sc_googlemap_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_googlemap",
				"name" => esc_html__("Google Map", 'trx_addons'),
				"description" => wp_kses_data( __("Google map with custom styles and several markers", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_googlemap',
				"class" => "trx_sc_googlemap",
				'content_element' => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_sc_googlemap'),
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'googlemap'), 'trx_sc_googlemap')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "style",
							"heading" => esc_html__("Style", 'trx_addons'),
							"description" => wp_kses_data( __("Map's custom style", 'trx_addons') ),
							"admin_label" => true,
					        'save_always' => true,
							'edit_field_class' => 'vc_col-sm-6',
							"value" => array_flip(trx_addons_get_list_sc_googlemap_styles()),
							"std" => "default",
							"type" => "dropdown"
						),
						array(
							"param_name" => "zoom",
							"heading" => esc_html__("Zoom", 'trx_addons'),
							"description" => wp_kses_data( __("Map zoom factor from 1 to 20. If 0 or empty - fit bounds to markers", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"value" => "16",
							"type" => "textfield"
						),
						array(
							"param_name" => "prevent_scroll",
							"heading" => esc_html__("Prevent_scroll", 'trx_addons'),
							"description" => wp_kses_data( __("Disallow scrolling of the map", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"admin_label" => true,
							"std" => 0,
							"value" => array(esc_html__("Prevent scroll", 'trx_addons') => 1 ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "width",
							"heading" => esc_html__("Width", 'trx_addons'),
							"description" => wp_kses_data( __("Width of the element", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => '100%',
							"type" => "textfield"
						),
						array(
							"param_name" => "height",
							"heading" => esc_html__("Height", 'trx_addons'),
							"description" => wp_kses_data( __("Height of the element", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => 350,
							"type" => "textfield"
						),
						array(
							"param_name" => "address",
							"heading" => esc_html__("Address", 'trx_addons'),
							"description" => wp_kses_data( __("Specify address in this field if you don't need unique marker, title or latlng coordinates. Otherwise, leave this field empty and fill markers below", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => '',
							"type" => "textfield"
						),
						array(
							"param_name" => "cluster",
							"heading" => esc_html__("Cluster icon", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image for markers clusterer", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"value" => "",
							"type" => "attach_image"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'markers',
							'heading' => esc_html__( 'Markers', 'trx_addons' ),
							"description" => wp_kses_data( __("Add markers to the map", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
								array(
									'title' => esc_html__( 'One', 'trx_addons' ),
									'description' => '',
									'address' => '',
									'latlng' => '',
									'icon' => '',
									'icon_retina' => '',
									'icon_width' => '',
									'icon_height' => '',
								),
							), 'trx_sc_googlemap') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array(
								array(
									"param_name" => "address",
									"heading" => esc_html__("Address", 'trx_addons'),
									"description" => wp_kses_data( __("Address of this marker", 'trx_addons') ),
									'edit_field_class' => 'vc_col-sm-6',
									"admin_label" => true,
									"value" => "",
									"type" => "textfield"
								),
								array(
									"param_name" => "latlng",
									"heading" => esc_html__("Latitude and Longitude", 'trx_addons'),
									"description" => wp_kses_data( __("Comma separated coorditanes of the marker (instead Address)", 'trx_addons') ),
									'edit_field_class' => 'vc_col-sm-6',
									"admin_label" => true,
									"value" => "",
									"type" => "textfield"
								),
								array(
									"param_name" => "icon",
									"heading" => esc_html__("Marker image", 'trx_addons'),
									"description" => wp_kses_data( __("Select or upload image of this marker", 'trx_addons') ),
									'edit_field_class' => 'vc_col-sm-6 vc_new_row',
									"value" => "",
									"type" => "attach_image"
								),
								array(
									"param_name" => "icon_retina",
									"heading" => esc_html__("Marker for Retina", 'trx_addons'),
									"description" => wp_kses_data( __("Select or upload image of this marker for Retina device", 'trx_addons') ),
									'edit_field_class' => 'vc_col-sm-6',
									"value" => "",
									"type" => "attach_image"
								),
								array(
									"param_name" => "icon_width",
									"heading" => esc_html__("Width", 'trx_addons'),
									"description" => wp_kses_data( __("Width of this marker. If empty - use original size", 'trx_addons') ),
									'edit_field_class' => 'vc_col-sm-6 vc_new_row',
									"value" => "",
									"type" => "textfield"
								),
								array(
									"param_name" => "icon_height",
									"heading" => esc_html__("Height", 'trx_addons'),
									"description" => wp_kses_data( __("Height of this marker. If empty - use original size", 'trx_addons') ),
									'edit_field_class' => 'vc_col-sm-6',
									"value" => "",
									"type" => "textfield"
								),
								array(
									"param_name" => "title",
									"heading" => esc_html__("Title", 'trx_addons'),
									"description" => wp_kses_data( __("Title of the marker", 'trx_addons') ),
									"admin_label" => true,
									"value" => "",
									"type" => "textfield"
								),
								array(
									"param_name" => "description",
									"heading" => esc_html__("Description", 'trx_addons'),
									"description" => wp_kses_data( __("Description of the marker", 'trx_addons') ),
									"value" => "",
									"type" => "textarea_safe"
								)
							), 'trx_sc_googlemap')
						)
					),
					trx_addons_vc_add_title_param(),
					trx_addons_vc_add_id_param()
				)
				
			), 'trx_sc_googlemap' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_googlemap_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_googlemap_add_in_elementor' );
	function trx_addons_sc_googlemap_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Googlemap extends TRX_Addons_Elementor_Widget {

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
					'width' => 'size+unit',
					'height' => 'size',
					'zoom' => 'size',
					'cluster' => 'url',
					'icon' => 'url',
					'icon_retina' => 'url',
					'icon_width' => 'size',
					'icon_height' => 'size',
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
				return 'trx_sc_googlemap';
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
				return __( 'Google Map', 'trx_addons' );
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
				return 'eicon-google-maps';
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
				return ['trx_addons-elements'];
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
					'section_sc_googlemap',
					[
						'label' => __( 'Google Map', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'googlemap'), 'trx_sc_googlemap'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'style',
					[
						'label' => __( 'Style', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_googlemap_styles(),
						'default' => 'default',
					]
				);

				$this->add_control(
					'prevent_scroll',
					[
						'label' => __( 'Prevent scroll', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'address',
					[
						'label' => __( 'Address', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => __( "Address", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'zoom',
					[
						'label' => __( 'Zoom', 'trx_addons' ),
						'description' => wp_kses_data( __("Map zoom factor from 1 to 20. If 0 or empty - fit bounds to markers", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 16
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 20
							]
						]
					]
				);
				
				$this->add_control(
					'width',
					[
						'label' => __( 'Width', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 100,
							'unit' => '%'
						],
						'range' => [
							'%' => [
								'min' => 10,
								'max' => 100
							],
							'px' => [
								'min' => 50,
								'max' => 1920
							]
						],
						'size_units' => ['%', 'px'],
						'selectors' => [
							'{{WRAPPER}} .sc_googlemap' => 'width: {{SIZE}}{{UNIT}};',
						],
					]
				);
				
				$this->add_control(
					'height',
					[
						'label' => __( 'Height', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 350
						],
						'range' => [
							'px' => [
								'min' => 50,
								'max' => 1000
							]
						],
						'selectors' => [
							'{{WRAPPER}} .sc_googlemap' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_googlemap_markers',
					[
						'label' => __( 'Markers', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'markers',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'address' => __('London Eye, London, United Kingdom', 'trx_addons'),
								'latlng' => '',
								'icon' => ['url' => ''],
								'icon_retina' => ['url' => ''],
								'icon_width' => ['size' => 0, 'unit' => 'px'],
								'icon_height' => ['size' => 0, 'unit' => 'px'],
								'title' => __( 'One', 'trx_addons' ),
								'description' => ''
							]
						], 'trx_sc_googlemap'),
						'fields' => apply_filters('trx_addons_sc_param_group_params',
							[
								[
									'name' => 'address',
									'label' => __( "Address", 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Address", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'latlng',
									'label' => __( "Latitude and Longitude", 'trx_addons' ),
									'description' => wp_kses_data( __("Comma separated coorditanes of the marker (instead Address)", 'trx_addons') ),
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Address", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'icon',
									'label' => __( 'Icon', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								],
								[
									'name' => 'icon_retina',
									'label' => __( 'Icon for Retina', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								],
								[
									'name' => 'icon_width',
									'label' => __( "Icon's width", 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::SLIDER,
									'default' => [
										'size' => 0
									],
									'range' => [
										'px' => [
											'min' => 0,
											'max' => 128
										]
									]
								],
								[
									'name' => 'icon_height',
									'label' => __( "Icon's height", 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::SLIDER,
									'default' => [
										'size' => 0
									],
									'range' => [
										'px' => [
											'min' => 0,
											'max' => 128
										]
									]
								],
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Marker's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'description',
									'label' => __( 'Description', 'trx_addons' ),
									'label_block' => true,
									'type' => \Elementor\Controls_Manager::WYSIWYG,
									'default' => '',
									'separator' => 'none'
								],
							],
							'trx_sc_googlemap'),
						'title_field' => '{{{ title }}}',
					]
				);
				
				$this->add_control(
					'cluster',
					[
						'label' => __( 'Cluster icon', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => ''
						]
					]
				);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_googlemap_content',
					[
						'label' => __( 'Additional content', 'trx_addons' ),
					]
				);

				$this->add_control(
					'content',
					[
						'label' => __( 'Content', 'trx_addons' ),
						'label_block' => true,
						'description' => wp_kses_data(__( "Content to place over the map", 'trx_addons' )),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => '',
						'separator' => 'none'
					]
				);

				$this->end_controls_section();

				$this->add_title_param();
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "googlemap/tpe.googlemap.php",
										'trx_addons_args_sc_googlemap',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Googlemap() );
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Googlemap extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_googlemap',
				esc_html__('ThemeREX Google Map', 'trx_addons'),
				array(
					'classname' => 'widget_googlemap',
					'description' => __('Display Google map', 'trx_addons')
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
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'googlemap'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					),
					'style' => array(
						'label' => __('Style', 'trx_addons'),
						"description" => wp_kses_data( __("Map's custom style", 'trx_addons') ),
						'default' => 'default',
						'options' => trx_addons_get_list_sc_googlemap_styles(),
						'type' => 'select'
					),
					"zoom" => array(
						"label" => esc_html__("Zoom", 'trx_addons'),
						"description" => wp_kses_data( __("Map zoom factor from 1 to 20. If 0 or empty - fit bounds to markers", 'trx_addons') ),
						"min" => 0,
						"max" => 20,
						"type" => "slider"
					),
					"width" => array(
						"label" => esc_html__("Width", 'trx_addons'),
						"description" => wp_kses_data( __("Width of the map", 'trx_addons') ),
						"default" => "100%",
						"type" => "measurement"
					),
					"height" => array(
						"label" => esc_html__("Height", 'trx_addons'),
						"description" => wp_kses_data( __("Height of the map", 'trx_addons') ),
						"default" => "350px",
						"type" => "measurement"
					),
					'address' => array(
						'label' => __('Address', 'trx_addons'),
						'description' => esc_html__( "Specify address in this field if you don't need unique marker, title or latlng coordinates. Otherwise, leave this field empty and fill markers below", 'trx_addons' ),
						'type' => 'text'
					),
					'cluster' => array(
						'label' => __('Cluster icon', 'trx_addons'),
						'description' => esc_html__( "Select or upload image for markers clusterer", 'trx_addons' ),
						'type' => 'media'
					),
					'markers' => array(
						'label' => __('Markers', 'trx_addons'),
						'item_name'  => __( 'Marker', 'trx_addons' ),
						'item_label' => array(
							'selector'     => "[name*='title']",
							'update_event' => 'change',
							'value_method' => 'val'
						),
						'type' => 'repeater',
						'fields' => apply_filters('trx_addons_sc_param_group_fields', array(
							'address' => array(
								'label' => __('Address', 'trx_addons'),
								"description" => wp_kses_data( __("Address of this marker", 'trx_addons') ),
								'type' => 'text'
							),
							'latlng' => array(
								'label' => __('or Latitude and Longitude', 'trx_addons'),
								"description" => wp_kses_data( __("Comma separated coorditanes of the marker (instead Address above)", 'trx_addons') ),
								'type' => 'text'
							),
							'icon' => array(
								'label' => __('Marker image', 'trx_addons'),
								'description' => esc_html__( "Select or upload image of this marker", 'trx_addons' ),
								'type' => 'media'
							),
							'icon_retina' => array(
								'label' => __('Marker image for Retina', 'trx_addons'),
								'description' => esc_html__( "Select or upload image of this marker for Retina device", 'trx_addons' ),
								'type' => 'media'
							),
							'icon_width' => array(
								'label' => __('Marker width', 'trx_addons'),
								'description' => esc_html__( 'Width of the marker. If empty - use original size', 'trx_addons' ),
								'type' => 'text'
							),
							'icon_height' => array(
								'label' => __('Marker height', 'trx_addons'),
								'description' => esc_html__( 'Height of the marker. If empty - use original size', 'trx_addons' ),
								'type' => 'text'
							),
							'title' => array(
								'label' => __('Title', 'trx_addons'),
								'description' => esc_html__( 'Title of the marker', 'trx_addons' ),
								'type' => 'text'
							),
							'description' => array(
								'rows' => 10,
								'label' => __('Description', 'trx_addons'),
								'description' => esc_html__( 'Description of the marker', 'trx_addons' ),
								'type' => 'tinymce'
							)
						), $this->get_sc_name())
					)
				),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_googlemap', __FILE__, 'TRX_Addons_SOW_Widget_Googlemap');


// TRX_Addons Widget
//------------------------------------------------------
} else {

	class TRX_Addons_SOW_Widget_Googlemap extends TRX_Addons_Widget {
	
		function __construct() {
			$widget_ops = array('classname' => 'widget_googlemap', 'description' => esc_html__('Show Google map with specified address', 'trx_addons'));
			parent::__construct( 'trx_addons_sow_widget_googlemap', esc_html__('ThemeREX Google map', 'trx_addons'), $widget_ops );
		}
	
		// Show widget
		function widget($args, $instance) {
			extract($args);
	
			$widget_title = apply_filters('widget_title', isset($instance['widget_title']) ? $instance['widget_title'] : '');
	
			$output = '';
			if (!empty($instance['marker_address']) || !empty($instance['marker_latlng']))
				$output = trx_addons_sc_googlemap(apply_filters('trx_addons_filter_widget_args',
						array_merge($instance, array(
							'markers' => array(
											array(
												'address' => !empty($instance['marker_address']) ? $instance['marker_address'] : '',
												'latlng' => !empty($instance['marker_latlng']) ? $instance['marker_latlng'] : '',
												'icon' => !empty($instance['marker_icon']) ? $instance['marker_icon'] : '',
												'title' => !empty($instance['marker_title']) ? $instance['marker_title'] : '',
												'description' => !empty($instance['marker_description']) ? $instance['marker_description'] : '',
												)
											)
							)),
							$instance, 'trx_addons_sow_widget_googlemap')
						);
	
			if (!empty($output)) {
		
				// Before widget (defined by themes)
				trx_addons_show_layout($before_widget);
				
				// Display the widget title if one was input (before and after defined by themes)
				if ($widget_title) trx_addons_show_layout($before_title . $widget_title . $after_title);
		
				// Display widget body
				trx_addons_show_layout($output);
				
				// After widget (defined by themes)
				trx_addons_show_layout($after_widget);
			}
		}
	
		// Update the widget settings
		function update($new_instance, $instance) {
			$instance = array_merge($instance, $new_instance);
			$instance['hide_excerpt'] = isset( $new_instance['hide_excerpt'] ) ? 1 : 0;
			$instance['slider'] = isset( $new_instance['slider'] ) ? 1 : 0;
			return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_sow_widget_googlemap');
		}
	
		// Displays the widget settings controls on the widget panel
		function form($instance) {
			// Set up some default widget settings
			$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
				'widget_title' => '',
				// Layout params
				"type" => "default",
				"zoom" => 16,
				"style" => 'default',
				"marker_address" => '',
				"marker_latlng" => '',
				"marker_icon" => '',
				"marker_title" => '',
				"marker_description" => '',
				"width" => "100%",
				"height" => "400",
				// Title params
				"title" => '',
				"subtitle" => '',
				"description" => '',
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
				), 'trx_addons_sow_widget_googlemap')
			);
		
			do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_sow_widget_googlemap');
			
			$this->show_field(array('name' => 'widget_title',
									'title' => __('Widget title:', 'trx_addons'),
									'value' => $instance['widget_title'],
									'type' => 'text'));
		
			do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_sow_widget_googlemap');
			
			$this->show_field(array('title' => __('Layout parameters', 'trx_addons'),
									'type' => 'info'));
			
			$this->show_field(array('name' => 'type',
									'title' => __('Layout:', 'trx_addons'),
									'value' => $instance['type'],
									'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'googlemap'), 'trx_sc_googlemap'),
									'type' => 'select'));
			
			$this->show_field(array('name' => 'style',
									'title' => __('Style:', 'trx_addons'),
									'value' => $instance['style'],
									'options' => trx_addons_get_list_sc_googlemap_styles(),
									'type' => 'select'));
			
			$this->show_field(array('name' => 'zoom',
									'title' => __('Zoom:', 'trx_addons'),
									"description" => wp_kses_data( __("Map zoom factor from 1 to 21. If 0 or empty - fit bounds to markers", 'trx_addons') ),
									'value' => (int) $instance['zoom'],
									"std" => 16,
									"options" => trx_addons_get_list_range(0, 21),
									"type" => 'select'));

			$this->show_field(array('name' => 'width',
									'title' => __('Width:', 'trx_addons'),
									"description" => wp_kses_data( __("Width of the map. Any CSS measurement units are allowed. If unit is not specified - use 'px'", 'trx_addons') ),
									'value' => $instance['width'],
									"std" => "100%",
									"type" => 'text'));

			$this->show_field(array('name' => 'height',
									'title' => __('Height:', 'trx_addons'),
									"description" => wp_kses_data( __("Height of the map. Any CSS measurement units are allowed. If unit is not specified - use 'px'", 'trx_addons') ),
									'value' => $instance['height'],
									"std" => "350",
									"type" => 'text'));
			
			$this->show_field(array('title' => __('Marker', 'trx_addons'),
									'type' => 'info'));

			$this->show_field(array('name' => 'marker_address',
									'title' => __('Address:', 'trx_addons'),
									"description" => wp_kses_data( __("Specify address to place marker on the map", 'trx_addons') ),
									'value' => $instance['marker_address'],
									"std" => "",
									"type" => 'text'));

			$this->show_field(array('name' => 'marker_latlng',
									'title' => __('or Latitude and Longitude:', 'trx_addons'),
									"description" => wp_kses_data( __("Comma separated coorditanes of the marker (instead Address above)", 'trx_addons') ),
									'value' => $instance['marker_latlng'],
									"std" => "",
									"type" => 'text'));

			$this->show_field(array('name' => 'marker_icon',
									'title' => __('Marker image:', 'trx_addons'),
									"description" => wp_kses_data( __("Select or upload image for this marker", 'trx_addons') ),
									'value' => $instance['marker_icon'],
									"std" => "",
									"type" => 'image'));

			$this->show_field(array('name' => 'marker_title',
									'title' => __('Title:', 'trx_addons'),
									"description" => wp_kses_data( __("Title of the marker", 'trx_addons') ),
									'value' => $instance['marker_title'],
									"std" => "",
									"type" => 'text'));

			$this->show_field(array('name' => 'marker_description',
									'title' => __('Description:', 'trx_addons'),
									"description" => wp_kses_data( __("Description of the marker", 'trx_addons') ),
									'value' => $instance['marker_description'],
									"std" => "",
									"type" => 'textarea'));

			$this->show_fields_title_param($instance);
			$this->show_fields_id_param($instance);
		
			do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_sow_widget_googlemap');
		}
	}

	// Load widget
	if (!function_exists('trx_addons_sow_widget_googlemap_load')) {
		add_action( 'widgets_init', 'trx_addons_sow_widget_googlemap_load' );
		function trx_addons_sow_widget_googlemap_load() {
			register_widget('TRX_Addons_SOW_Widget_Googlemap');
		}
	}
}
?>