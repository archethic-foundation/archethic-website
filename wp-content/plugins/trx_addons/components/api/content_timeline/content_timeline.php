<?php
/**
 * Plugin support: Content Timeline
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_addons_exists_content_timeline' ) ) {
	function trx_addons_exists_content_timeline() {
		return class_exists( 'ContentTimelineAdmin' );
	}
}

// Return Content Timelines list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_content_timelines' ) ) {
	function trx_addons_get_list_content_timelines($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_content_timeline()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT id, name FROM " . esc_sql($wpdb->prefix . 'ctimelines') );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->id] = $row->name;
					}
				}
			}
		}
		return $prepend_inherit ? array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_content_timeline_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_content_timeline_importer_required_plugins', 10, 2 );
	function trx_addons_content_timeline_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'content_timeline')!==false && !trx_addons_exists_content_timeline() )
			$not_installed .= '<br>' . esc_html__('Content Timeline', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_content_timeline_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_content_timeline_importer_set_options' );
	function trx_addons_content_timeline_importer_set_options($options=array()) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $options['required_plugins']) ) {
			//$options['additional_options'][] = 'content_timeline_calendar_options';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_content_timeline'] = str_replace('name.ext', 'content_timeline.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_content_timeline_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_content_timeline_importer_show_params', 10, 1 );
	function trx_addons_content_timeline_importer_show_params($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'content_timeline',
				'title' => esc_html__('Import Content Timeline', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_content_timeline_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_content_timeline_importer_import', 10, 2 );
	function trx_addons_content_timeline_importer_import($importer, $action) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			if ( $action == 'import_content_timeline' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('content_timeline', esc_html__('Content Timeline', 'trx_addons'));
			}
		}
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_content_timeline_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_content_timeline_importer_import_fields', 10, 1 );
	function trx_addons_content_timeline_importer_import_fields($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'	=> 'content_timeline', 
				'title'	=> esc_html__('Content Timeline', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_content_timeline_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_content_timeline_importer_export', 10, 1 );
	function trx_addons_content_timeline_importer_export($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('content_timeline.txt'), serialize( array(
				'ctimelines' => $importer->export_dump('ctimelines')
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_content_timeline_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_content_timeline_importer_export_fields', 10, 1 );
	function trx_addons_content_timeline_importer_export_fields($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'content_timeline',
				'title' => esc_html__('Content Timeline', 'trx_addons')
				)
			);
		}
	}
}



// VC support
//------------------------------------------------------------------------

// Add [content_timeline] in the VC shortcodes list
if (!function_exists('trx_addons_sc_content_timeline_add_in_vc')) {
	function trx_addons_sc_content_timeline_add_in_vc() {

		if (!trx_addons_exists_visual_composer() || !trx_addons_exists_content_timeline()) return;

		vc_lean_map( "content_timeline", 'trx_addons_sc_content_timeline_add_in_vc_params');
		class WPBakeryShortCode_Content_Timeline extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_content_timeline_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_content_timeline_add_in_vc_params')) {
	function trx_addons_sc_content_timeline_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "content_timeline",
				"name" => esc_html__("Content Timeline", 'trx_addons'),
				"description" => esc_html__("Insert Content timeline", 'trx_addons'),
				"category" => esc_html__('Content', 'trx_addons'),
				'icon' => 'icon_trx_sc_content_timeline',
				"class" => "trx_sc_content_timeline",
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "id",
						"heading" => esc_html__("Timeline", 'trx_addons'),
						"description" => esc_html__("Select Timeline to insert to the current page", 'trx_addons'),
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_content_timelines()),
						"type" => "dropdown"
					)
				)
			), 'content_timeline' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_content_timeline_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_content_timeline_add_in_elementor' );
	function trx_addons_sc_content_timeline_add_in_elementor() {

		if (!trx_addons_exists_content_timeline()) return;
		
		class TRX_Addons_Elementor_Widget_Content_Timeline extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_content_timeline';
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
				return __( 'Content Timeline', 'trx_addons' );
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
				return 'eicon-time-line';
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
					'section_sc_content_timeline',
					[
						'label' => __( 'Content Timeline', 'trx_addons' ),
					]
				);

				$timelines = trx_addons_get_list_content_timelines();
				$id = (int) trx_addons_array_get_first($timelines);

				$this->add_control(
					'timeline_id',
					[
						'label' => __( 'Timeline', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $timelines,
						'default' => ''.$id 	// Convert to string
					]
				);
				
				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('content_timeline')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[content_timeline id="%s"]', $atts['timeline_id'])));
				} else
					$this->shortcode_not_exists('content_timeline', 'Content Timeline');
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Content_Timeline() );
	}
}
?>