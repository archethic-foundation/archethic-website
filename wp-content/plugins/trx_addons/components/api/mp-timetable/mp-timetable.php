<?php
/**
 * Plugin support: MP Timetable
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */


if (!defined('TRX_ADDONS_MPTT_PT_EVENT')) define('TRX_ADDONS_MPTT_PT_EVENT', 'mp-event');
if (!defined('TRX_ADDONS_MPTT_PT_COLUMN')) define('TRX_ADDONS_MPTT_PT_COLUMN', 'mp-column');
if (!defined('TRX_ADDONS_MPTT_TAXONOMY_CATEGORY')) define('TRX_ADDONS_MPTT_TAXONOMY_CATEGORY', 'mp-event_category');


// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_mptt' ) ) {
	function trx_addons_exists_mptt() {
		return class_exists('Mp_Time_Table');
	}
}

// Return true, if current page is any mp_timetable page
if ( !function_exists( 'trx_addons_is_mptt_page' ) ) {
	function trx_addons_is_mptt_page() {
		$rez = false;
		if (trx_addons_exists_mptt())
			return !is_search()
						&& (
							(is_single() && get_post_type()==TRX_ADDONS_MPTT_PT_EVENT)
							|| is_post_type_archive(TRX_ADDONS_MPTT_PT_EVENT)
							|| is_tax(TRX_ADDONS_MPTT_TAXONOMY_CATEGORY)
							);
		return $rez;
	}
}


// Return taxonomy for current post type
if ( !function_exists( 'trx_addons_mptt_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_mptt_post_type_taxonomy', 10, 2 );
	function trx_addons_mptt_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == TRX_ADDONS_MPTT_PT_EVENT)
			$tax = TRX_ADDONS_MPTT_TAXONOMY_CATEGORY;
		return $tax;
	}
}



// Load required scripts and styles
//------------------------------------------------------------------------

	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_mptt_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_mptt_merge_styles');
	function trx_addons_mptt_merge_styles($list) {
		if (trx_addons_exists_mptt())
			$list[] = TRX_ADDONS_PLUGIN_API . 'mp-timetable/_mp-timetable.scss';
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_mptt_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_mptt_importer_required_plugins', 10, 2 );
	function trx_addons_mptt_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'mp-timetable')!==false && !trx_addons_exists_mptt() )
			$not_installed .= '<br>' . esc_html__('MP TimeTable', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_mptt_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_mptt_importer_set_options' );
	function trx_addons_mptt_importer_set_options($options=array()) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $options['required_plugins']) ) {
			//$options['additional_options'][]	= 'mptt_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_mp-timetable'] = str_replace('name.ext', 'mp-timetable.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_mptt_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_mptt_importer_show_params', 10, 1 );
	function trx_addons_mptt_importer_show_params($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'mp-timetable',
				'title' => esc_html__('Import MP TimeTable', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_mptt_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_mptt_importer_import', 10, 2 );
	function trx_addons_mptt_importer_import($importer, $action) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			if ( $action == 'import_mp-timetable' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('mp-timetable', esc_html__('MP TimeTable data', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_mptt_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_mptt_importer_check_row', 9, 4);
	function trx_addons_mptt_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'mp-timetable')===false) return $flag;
		if ( trx_addons_exists_mptt() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array(TRX_ADDONS_MPTT_PT_EVENT, TRX_ADDONS_MPTT_PT_COLUMN));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_mptt_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_mptt_importer_import_fields', 10, 1 );
	function trx_addons_mptt_importer_import_fields($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'mp-timetable', 
				'title' => esc_html__('MP TimeTable data', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_mptt_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_mptt_importer_export', 10, 1 );
	function trx_addons_mptt_importer_export($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('mp-timetable.txt'), serialize( array(
				"mp_timetable_data"	=> $importer->export_dump("mp_timetable_data")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_mptt_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_mptt_importer_export_fields', 10, 1 );
	function trx_addons_mptt_importer_export_fields($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'mp-timetable',
				'title' => esc_html__('MP TimeTable', 'trx_addons')
				)
			);
		}
	}
}


// VC support
//------------------------------------------------------------------------

// Add [mp-timetable] to the VC shortcodes list
if (!function_exists('trx_addons_sc_mptt_add_in_vc')) {
	function trx_addons_sc_mptt_add_in_vc() {

		if (!trx_addons_exists_visual_composer() || !trx_addons_exists_mptt()) return;
		
		vc_lean_map( "mp-timetable", 'trx_addons_sc_mptt_add_in_vc_params');
		class WPBakeryShortCode_Mp_Timetable extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_mptt_add_in_vc', 20);
}
			
// Params for mp_timetable
if (!function_exists('trx_addons_sc_mptt_add_in_vc_params')) {
	function trx_addons_sc_mptt_add_in_vc_params() {
		return array(
				"base" => "mp-timetable",
				"name" => esc_html__("MP Timetable", "trx_addons"),
				"description" => esc_html__("Insert timetable with events", "trx_addons"),
				"category" => esc_html__('Content', 'trx_addons'),
				'icon' => 'icon_trx_sc_mp_timetable',
				"class" => "trx_sc_single trx_sc_mp_timetable",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "col",
						"heading" => esc_html__("Column", "trx_addons"),
						"description" => esc_html__("Select columns to display", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "",
						"size" => 7,
						"multiple" => true,
						"value" => array_flip(trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_MPTT_PT_COLUMN,
													'not_selected' => false,
													'orderby' => 'none'
													)
												)
						),
						"type" => "select"
					),
					array(
						"param_name" => "events",
						"heading" => esc_html__("Events", "trx_addons"),
						"description" => esc_html__("Select events to display", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "",
						"size" => 7,
						"multiple" => true,
						"value" => array_flip(trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_MPTT_PT_EVENT,
													'not_selected' => false,
													'orderby' => 'title'
													)
												)
						),
						"type" => "select"
					),
					array(
						"param_name" => "event_categ",
						"heading" => esc_html__("Event categories", "trx_addons"),
						"description" => esc_html__("Select event categories to display", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "",
						"size" => 7,
						"multiple" => true,
						"value" => array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_MPTT_TAXONOMY_CATEGORY)),
						"type" => "select"
					),
					array(
						"param_name" => "increment",
						"heading" => esc_html__("Hour measure", "trx_addons"),
						"description" => esc_html__("Select measurement of the left column", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => "1",
						"value" => array(
							__( '4 hours', 'trx_addons' ) => '4',
							__( '2 hours', 'trx_addons' ) => '2',
							__( '1 hour', 'trx_addons' ) => '1',
							__( 'Half hour (30 min)', 'trx_addons' ) => '0.5',
							__( 'Quarter hour (15 min)', 'trx_addons' ) => '0.25'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "view",
						"heading" => esc_html__("Filter style", "trx_addons"),
						"description" => esc_html__("Select style of the filter", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "tabs",
				        'save_always' => true,
						"value" => array(
							__( 'Dropdown list', 'trx_addons' ) => 'dropdown_list',
							__( 'Tabs', 'mp-timetable' ) => 'tabs'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "label",
						"heading" => esc_html__("Filter label", "trx_addons"),
						"description" => esc_html__("Specify labels of the block with filters", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"type" => "textfield"
					),
					array(
						"param_name" => "hide_label",
						"heading" => esc_html__("Hide 'All Events' view", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to hide 'All Events' view", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => "0",
				        'save_always' => true,
						"value" => array(esc_html__("Hide 'All Events' view", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "hide_hrs",
						"heading" => esc_html__("Hide first (hours) column", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to hide the first (hours) column", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "0",
				        'save_always' => true,
						"value" => array(esc_html__("Hide first (hours) column", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "hide_empty_rows",
						"heading" => esc_html__("Hide empty rows", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to hide empty rows", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "1",
				        'save_always' => true,
						"value" => array(esc_html__("Hide empty rows", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to show the event's title", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => "1",
				        'save_always' => true,
						"value" => array(esc_html__("Show Title", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "sub-title",
						"heading" => esc_html__("Subtitle", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to show the event's subtitle", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "1",
				        'save_always' => true,
						"value" => array(esc_html__("Show Subtitle", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "time",
						"heading" => esc_html__("Time", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to show the event's time", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "1",
				        'save_always' => true,
						"value" => array(esc_html__("Show Time", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to show the event's description", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => "1",
				        'save_always' => true,
						"value" => array(esc_html__("Show Description", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "user",
						"heading" => esc_html__("User", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to show the event's user", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "0",
				        'save_always' => true,
						"value" => array(esc_html__("Show User", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "disable_event_url",
						"heading" => esc_html__("Disable event URL", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want to disable event URL", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "0",
				        'save_always' => true,
						"value" => array(esc_html__("Disable event URL", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "text_align",
						"heading" => esc_html__("Text align", "trx_addons"),
						"description" => esc_html__("Select text alignment", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => "center",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_aligns(false, false)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "row_height",
						"heading" => esc_html__("Row height", "trx_addons"),
						"description" => esc_html__("Specify row height (in px)", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"type" => "textfield"
					),
					array(
						"param_name" => "font_size",
						"heading" => esc_html__("Base font size", "trx_addons"),
						"description" => esc_html__("Specify base font size", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4',
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", "trx_addons"),
						"description" => esc_html__("Specify block ID (if need)", "trx_addons"),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"type" => "textfield"
					),
					array(
						"param_name" => "responsive",
						"heading" => esc_html__("Responsive", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want make this block responsive", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "1",
				        'save_always' => true,
						"value" => array(esc_html__("Responsive", 'trx_addons') => "1" ),
						"type" => "checkbox"
					)
				)
			);
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_mptt_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_mptt_add_in_elementor' );
	function trx_addons_sc_mptt_add_in_elementor() {

		if (!trx_addons_exists_mptt()) return;
		
		class TRX_Addons_Elementor_Widget_MP_Timetable extends TRX_Addons_Elementor_Widget {

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
					'row_height' => 'size',
					'font_size' => 'size+unit'
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
				return 'trx_sc_mptt';
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
				return __( 'MP Timetable', 'trx_addons' );
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
				return 'eicon-countdown';
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
					'section_sc_mptt',
					[
						'label' => __( 'MP Timetable', 'trx_addons' ),
					]
				);

				$this->add_control(
					'col',
					[
						'label' => __( 'Column', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT2,
						'options' => trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_MPTT_PT_COLUMN,
													'not_selected' => false,
													'orderby' => 'none'
													)
												),
						'multiple' => true,
						'default' => []
					]
				);

				$this->add_control(
					'events',
					[
						'label' => __( 'Events', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT2,
						'options' => trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_MPTT_PT_EVENT,
													'not_selected' => false,
													'orderby' => 'title'
													)
												),
						'multiple' => true,
						'default' => []
					]
				);

				$this->add_control(
					'event_categ',
					[
						'label' => __( 'Event categories', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT2,
						'options' => trx_addons_get_list_terms(false, TRX_ADDONS_MPTT_TAXONOMY_CATEGORY),
						'multiple' => true,
						'default' => []
					]
				);

				$this->add_control(
					'increment',
					[
						'label' => __( 'Hour measure', 'trx_addons' ),
						'label_block' => false,
						'description' => esc_html__("Select measurement of the left column", "trx_addons"),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'4' => __( '4 hours', 'trx_addons' ),
							'2' => __( '2 hours', 'trx_addons' ),
							'1' => __( '1 hour', 'trx_addons' ),
							'0.5' => __( 'Half hour (30 min)', 'trx_addons' ),
							'0.25' => __( 'Quarter hour (15 min)', 'trx_addons' )
						),
						'default' => '1'
					]
				);

				$this->add_control(
					'view',
					[
						'label' => __( 'Filter style', 'trx_addons' ),
						'label_block' => false,
						'description' => esc_html__("Select measurement of the left column", "trx_addons"),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'dropdown_list' => __( 'Dropdown list', 'trx_addons' ),
							'tabs' => __( 'Tabs', 'trx_addons' )
						),
						'default' => 'tabs'
					]
				);

				$this->add_control(
					'label',
					[
						'label' => __( 'Filter label', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Filter label", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'mptt_id',
					[
						'label' => __( 'Timetable ID', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "ID", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_mptt_lsyout',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
					]
				);

				$this->add_control(
					'text_align',
					[
						'label' => __( 'Text align', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(false, false),
						'default' => 'center'
					]
				);

				$this->add_control(
					'row_height',
					[
						'label' => __( 'Row height', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify row height (in px)", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500
							]
						]
					]
				);

				$this->add_control(
					'font_size',
					[
						'label' => __( 'Base font size', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 1,
							'unit' => 'em'
						],
						'size_units' => ['px', 'em', '%'],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 50
							],
							'em' => [
								'min' => 0.1,
								'max' => 3,
								'step' => 0.1
							],
							'%' => [
								'min' => 10,
								'max' => 300
							]
						]
					]
				);

				$this->add_control(
					'responsive',
					[
						'label' => __( "Responsive", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_mptt_details',
					[
						'label' => __( 'Details', 'trx_addons' ),
					]
				);

				$this->add_control(
					'hide_label',
					[
						'label' => __( "Hide 'All Events' view", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Show', 'trx_addons' ),
						'label_on' => __( 'Hide', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'hide_hrs',
					[
						'label' => __( "Hide first (hours) column", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Show', 'trx_addons' ),
						'label_on' => __( 'Hide', 'trx_addons' ),
						'return_value' => '1'
					]
				);				

				$this->add_control(
					'hide_empty_rows',
					[
						'label' => __( "Hide empty rows", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Show', 'trx_addons' ),
						'label_on' => __( 'Hide', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( "Show titles", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'sub-title',
					[
						'label' => __( "Show subtitles", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'time',
					[
						'label' => __( "Show event's time", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'description',
					[
						'label' => __( "Show description", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1',
						'default' => '1'
					]
				);

				$this->add_control(
					'user',
					[
						'label' => __( "Show user", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'disable_event_url',
					[
						'label' => __( "Disable event URL", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Enable', 'trx_addons' ),
						'label_on' => __( 'Disable', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('mp-timetable')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[mp-timetable'
																	. ' col="%1$s"'
																	. ' events="%2$s"'
																	. ' event_categ="%3$s"'
																	. ' increment="%4$s"'
																	. ' view="%5$s"'
																	. ' label="%6$s"'
																	. ' hide_label="%7$s"'
																	. ' hide_hrs="%8$s"'
																	. ' hide_empty_rows="%9$s"'
																	. ' title="%10$s"'
																	. ' sub-title="%11$s"'
																	. ' time="%12$s"'
																	. ' description="%13$s"'
																	. ' user="%14$s"'
																	. ' disable_event_url="%15$s"'
																	. ' text_align="%16$s"'
																	. ' row_height="%17$s"'
																	. ' font_size="%18$s"'
																	. ' id="%19$s"'
																	. ' responsive="%20$s"'
																. ']',
																is_array($atts['col']) ? join(',', $atts['col']) : '',
																is_array($atts['events']) ? join(',', $atts['events']) : '',
																is_array($atts['event_categ']) ? join(',', $atts['event_categ']) : '',
																$atts['increment'],
																$atts['view'],
																$atts['label'],
																$atts['hide_label'],
																$atts['hide_hrs'],
																$atts['hide_empty_rows'],
																$atts['title'],
																$atts['sub-title'],
																$atts['time'],
																$atts['description'],
																$atts['user'],
																$atts['disable_event_url'],
																$atts['text_align'],
																$atts['row_height'],
																$atts['font_size'],
																$atts['mptt_id'],
																$atts['responsive']
															)));
				} else
					$this->shortcode_not_exists('mp-timetable', 'MP Timetable');
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_MP_Timetable() );
	}
}
?>