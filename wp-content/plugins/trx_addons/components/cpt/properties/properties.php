<?php
/**
 * ThemeREX Addons Custom post type: Properties
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants for 'Properties'
if ( ! defined('TRX_ADDONS_CPT_PROPERTIES_PT') )
		define('TRX_ADDONS_CPT_PROPERTIES_PT', trx_addons_cpt_param('properties', 'post_type'));

// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_properties_init')) {
	add_action( 'init', 'trx_addons_cpt_properties_init' );
	function trx_addons_cpt_properties_init() {
		
		trx_addons_meta_box_register(TRX_ADDONS_CPT_PROPERTIES_PT, array(
			"basic_section" => array(
				"title" => esc_html__('Basic information', 'trx_addons'),
				"desc" => wp_kses_data( __('Basic information about the property', 'trx_addons') ),
				"type" => "section"
			),
			"before_price" => array(
				"title" => esc_html__("Before price", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify any text to display it before the price', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"price" => array(
				"title" => esc_html__("Sale or Rent price", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify main price for this property (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"price2" => array(
				"title" => esc_html__("Second price", 'trx_addons'),
				"desc" => wp_kses_data( __('Optional price for rental or square feet/m (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"after_price" => array(
				"title" => esc_html__("After price", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify any text to display it after the second price', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"area_size" => array(
				"title" => esc_html__("Area size", 'trx_addons'),
				"desc" => wp_kses_data( __('Area size (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"area_size_prefix" => array(
				"title" => esc_html__("Area size prefix", 'trx_addons'),
				"desc" => wp_kses_data( __('Area size prefix (unit of measurement). Use ^ to make next digit as exponent, eg. m^2', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"land_size" => array(
				"title" => esc_html__("Land size", 'trx_addons'),
				"desc" => wp_kses_data( __('Land area size (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"land_size_prefix" => array(
				"title" => esc_html__("Land size prefix", 'trx_addons'),
				"desc" => wp_kses_data( __('Land area size prefix (unit of measurement). Use ^ to make next digit as exponent, eq. m^2', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"bedrooms" => array(
				"title" => esc_html__("Bedrooms", 'trx_addons'),
				"desc" => wp_kses_data( __('Bedrooms number (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => 0,
				"options" => trx_addons_get_list_range(0, 10),
				"type" => "select"
			),
			"bathrooms" => array(
				"title" => esc_html__("Bathrooms", 'trx_addons'),
				"desc" => wp_kses_data( __('Bathrooms number (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => 0,
				"options" => trx_addons_get_list_range(0, 10),
				"type" => "select"
			),
			"garages" => array(
				"title" => esc_html__("Garages", 'trx_addons'),
				"desc" => wp_kses_data( __('Garages number (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => 0,
				"options" => trx_addons_get_list_range(0, 10),
				"type" => "select"
			),
			"garage_size" => array(
				"title" => esc_html__("Garage size", 'trx_addons'),
				"desc" => wp_kses_data( __('Garage size. Eg. "2 auto" or "200 SqFt" or "45 m^2"', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"built" => array(
				"title" => esc_html__("Year built", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify or select the year when the property is built (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"type" => "text"
			),
			"id" => array(
				"title" => esc_html__("Property ID", 'trx_addons'),
				"desc" => wp_kses_data( __('Property ID - it will help you search this property directly', 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"type" => "text"
			),

			"map_section" => array(
				"title" => esc_html__('Location', 'trx_addons'),
				"desc" => wp_kses_data( __('Address and location on the map', 'trx_addons') ),
				"type" => "section"
			),
			"country" => array(
				"title" => esc_html__("Country", 'trx_addons'),
				"desc" => wp_kses_data( __("Select the property's country", 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"options" => array(),
				"type" => "select"
			),
			"state" => array(
				"title" => esc_html__("State", 'trx_addons'),
				"desc" => wp_kses_data( __("Select the property's state", 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"options" => array(),
				"type" => "select"
			),
			"city" => array(
				"title" => esc_html__("City", 'trx_addons'),
				"desc" => wp_kses_data( __("Select the property's city", 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"options" => array(),
				"type" => "select"
			),
			"neighborhood" => array(
				"title" => esc_html__("Neighborhood", 'trx_addons'),
				"desc" => wp_kses_data( __("Select the property's neighborhood", 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"options" => array(),
				"type" => "select"
			),
			"address" => array(
				"title" => esc_html__("Address in the city", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify only street and building number', 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"type" => "text"
			),
			"zip" => array(
				"title" => esc_html__("Zip", 'trx_addons'),
				"desc" => wp_kses_data( __('Zip code', 'trx_addons') ),
				"class" => "trx_addons_column-1_2",
				"std" => "",
				"type" => "text"
			),
			"show_map" => array(
				"title" => esc_html__("Show map", 'trx_addons'),
				"desc" => wp_kses_data( __("Show map on the property's single page", 'trx_addons') ),
				"std" => "0",
				"type" => "checkbox"
			),
			"marker" => array(
				"title" => esc_html__("Google map marker", 'trx_addons'),
				"desc" => wp_kses_data( __("Select image to represent this property on the Google map. If empty - use marker from 'Property type' or default marker", 'trx_addons') ),
				"std" => "",
				"dependency" => array(
					"show_map" => array("not_empty")
				),
				"type" => "image"
			),
			"location" => array(
				"title" => esc_html__("Google map location", 'trx_addons'),
				"desc" => wp_kses_data( __('Click on the map or drag marker or find location by address', 'trx_addons') ),
				"std" => "",
				"type" => "googlemap"
			),

			"gallery_section" => array(
				"title" => esc_html__('Gallery', 'trx_addons'),
				"desc" => wp_kses_data( __('Images gallery for this property', 'trx_addons') ),
				"type" => "section"
			),
			"gallery" => array(
				"title" => esc_html__("Images gallery", 'trx_addons'),
				"desc" => wp_kses_data( __("Select images to create gallery on the single page of this property", 'trx_addons') ),
				"std" => "",
				"multiple" => true,
				"type" => "image"
			),
			"video" => array(
				"title" => esc_html__("Video", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify URL with properties video from popular video hosting (Youtube, Vimeo)', 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"video_description" => array(
				"title" => esc_html__("Description", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify short description to the video above', 'trx_addons') ),
				"dependency" => array(
					"video" => array("not_empty")
				),
				"std" => "",
				"type" => "textarea"
			),
			"virtual_tour" => array(
				"title" => esc_html__("Virtual Tour", 'trx_addons'),
				"desc" => wp_kses_data( __('Enter virtual tour embeded code', 'trx_addons') ),
				"std" => "",
				"type" => "textarea"
			),
			"virtual_tour_description" => array(
				"title" => esc_html__("Description", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify short description to the virtual tour above', 'trx_addons') ),
				"dependency" => array(
					"virtual_tour" => array("not_empty")
				),
				"std" => "",
				"type" => "textarea"
			),
			"attachments" => array(
				"title" => esc_html__("Attachments", 'trx_addons'),
				"desc" => wp_kses_data( __("Select additional files to attach its to this property", 'trx_addons') ),
				"std" => "",
				"multiple" => true,
				"type" => "media"
			),
			"attachments_description" => array(
				"title" => esc_html__("Description", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify short description to the attachments above', 'trx_addons') ),
				"dependency" => array(
					"attachments" => array("not_empty")
				),
				"std" => "",
				"type" => "textarea"
			),

			"floor_section" => array(
				"title" => esc_html__('Floor plans', 'trx_addons'),
				"desc" => wp_kses_data( __('Floor plans with short description', 'trx_addons') ),
				"type" => "section"
			),
			"floor_plans_enable" => array(
				"title" => esc_html__("Display floor plans", 'trx_addons'),
				"desc" => wp_kses_data( __("Show/Hide floor plans on the single page with this property", 'trx_addons') ),
				"std" => "0",
				"type" => "checkbox"
			),
			"floor_plans" => array(
				"title" => esc_html__("Floor plans", 'trx_addons'),
				"desc" => wp_kses_data( __("Floor plans data fields", 'trx_addons') ),
				"dependency" => array(
					"floor_plans_enable" => '1'
				),
				"clone" => true,
				"std" => array(array()),
				"type" => "group",
				"fields" => array(
					"title" => array(
						"title" => esc_html__("Plan title", 'trx_addons'),
						"desc" => wp_kses_data( __('Current floor plan title', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"area" => array(
						"title" => esc_html__("Floor size", 'trx_addons'),
						"desc" => wp_kses_data( __('Floor area size', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"bedrooms" => array(
						"title" => esc_html__("Bedrooms", 'trx_addons'),
						"desc" => wp_kses_data( __('Bedrooms number or area', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"bathrooms" => array(
						"title" => esc_html__("Bathrooms", 'trx_addons'),
						"desc" => wp_kses_data( __('Bathrooms number or area', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"image" => array(
						"title" => esc_html__("Floor plan image", 'trx_addons'),
						"desc" => wp_kses_data( __("Select image with this floor's plan", 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "image"
					),
					"description" => array(
						"title" => esc_html__("Description", 'trx_addons'),
						"desc" => wp_kses_data( __('Specify short description for this floor (if need)', 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "textarea"
					)
				)
			),

			"details_section" => array(
				"title" => esc_html__('Additional features', 'trx_addons'),
				"desc" => wp_kses_data( __('Additional (custom) features for this property', 'trx_addons') ),
				"type" => "section"
			),
			"details_enable" => array(
				"title" => esc_html__("Display details", 'trx_addons'),
				"desc" => wp_kses_data( __("Show/Hide additional features on the single page with this property", 'trx_addons') ),
				"std" => "0",
				"type" => "checkbox"
			),
			"details" => array(
				"title" => esc_html__("Additional features", 'trx_addons'),
				"desc" => wp_kses_data( __("Add more features for this property by pair title-value", 'trx_addons') ),
				"dependency" => array(
					"details_enable" => '1'
				),
				"clone" => true,
				"std" => array(array()),
				"type" => "group",
				"fields" => array(
					"title" => array(
						"title" => esc_html__("Title", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature title', 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "text"
					),
					"value" => array(
						"title" => esc_html__("Value", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature value', 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "text"
					)
				)
			),

			"agent_section" => array(
				"title" => esc_html__('Agent', 'trx_addons'),
				"desc" => wp_kses_data( __('What display in the Agent information block?', 'trx_addons') ),
				"type" => "section"
			),
			"agent_type" => array(
				"title" => esc_html__("Agent type", 'trx_addons'),
				"desc" => wp_kses_data( __("What display in the Agent information block?", 'trx_addons') ),
				"std" => "agent",
				"options" => array(
					"agent" => esc_html__('Agent', 'trx_addons'),
					"author" => esc_html__('Author', 'trx_addons'),
					"none" => esc_html__('Hide block', 'trx_addons')
				),
				"type" => "radio"
			),
			"agent" => array(
				"title" => esc_html__("Select agent", 'trx_addons'),
				"desc" => wp_kses_data( __("Select agent", 'trx_addons') ),
				"std" => "0",
				"options" => array(),
				"dependency" => array(
					"agent_type" => array("agent")
				),
				"type" => "select"
			)
		));
		
		// Register post type and taxonomy
		register_post_type( TRX_ADDONS_CPT_PROPERTIES_PT, array(
			'label'               => esc_html__( 'Properties', 'trx_addons' ),
			'description'         => esc_html__( 'Property Description', 'trx_addons' ),
			'labels'              => array(
				'name'                => esc_html__( 'Properties', 'trx_addons' ),
				'singular_name'       => esc_html__( 'Property', 'trx_addons' ),
				'menu_name'           => esc_html__( 'Properties', 'trx_addons' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
				'all_items'           => esc_html__( 'All Properties', 'trx_addons' ),
				'view_item'           => esc_html__( 'View Property', 'trx_addons' ),
				'add_new_item'        => esc_html__( 'Add New Property', 'trx_addons' ),
				'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
				'edit_item'           => esc_html__( 'Edit Property', 'trx_addons' ),
				'update_item'         => esc_html__( 'Update Property', 'trx_addons' ),
				'search_items'        => esc_html__( 'Search Property', 'trx_addons' ),
				'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
			),
			'taxonomies'          => array(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE, 
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS,
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES,
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS,
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY,
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE,
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY,
										   TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD
										   ),
			'supports'            => trx_addons_cpt_param('properties', 'supports'),
			'public'              => true,
			'hierarchical'        => false,
			'has_archive'         => true,
			'can_export'          => true,
			'show_in_admin_bar'   => true,
			'show_in_menu'        => true,
			'menu_position'       => '53.3',
			'menu_icon'			  => 'dashicons-admin-multisite',
			'capability_type'     => 'post',
			'rewrite'             => array( 'slug' => trx_addons_cpt_param('properties', 'post_type_slug') )
			)
		);
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'Properties' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_properties_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_properties_options');
	function trx_addons_cpt_properties_options($options) {

		trx_addons_array_insert_after($options, 'cpt_section', trx_addons_cpt_properties_get_list_options());
		return $options;
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_properties_get_list_options')) {
	function trx_addons_cpt_properties_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'properties_info' => array(
				"title" => esc_html__('Properties', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the properties archive', 'trx_addons') ),
				"type" => "info"
			),
			'properties_blog_style' => array(
				"title" => esc_html__('Blog archive style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the properties archive', 'trx_addons') ),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'properties', 'arh'), 
											TRX_ADDONS_CPT_PROPERTIES_PT),
				"type" => "select"
			),
			'properties_single_style' => array(
				"title" => esc_html__('Single property style', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the single property's page", 'trx_addons') ),
				"std" => 'default',
				"options" => apply_filters('trx_addons_filter_cpt_single_styles', array(
					'default' => esc_html__('Default', 'trx_addons'),
					'tabs' => esc_html__('Tabs', 'trx_addons')
				), TRX_ADDONS_CPT_PROPERTIES_PT),
				"type" => "select"
			),
			'properties_marker' => array(
				"title" => esc_html__('Default marker', 'trx_addons'),
				"desc" => wp_kses_data( __('Default marker to show properties on the Google maps ', 'trx_addons') ),
				"std" => '',
				"type" => "image"
			)
		), 'properties');
	}
}
------------------- /Old way --------------------- */


// Fill 'options' arrays when its need in the admin mode
if (!function_exists('trx_addons_cpt_properties_before_show_options')) {
	add_filter('trx_addons_filter_before_show_options', 'trx_addons_cpt_properties_before_show_options', 10, 2);
	function trx_addons_cpt_properties_before_show_options($options, $post_type, $group='') {
		if ($post_type == TRX_ADDONS_CPT_PROPERTIES_PT) {
			foreach ($options as $id=>$field) {

				// Recursive call for options type 'group'
				if ($field['type'] == 'group' && !empty($field['fields'])) {
					$options[$id]['fields'] = trx_addons_cpt_properties_before_show_options($field['fields'], $post_type, $id);
					continue;
				}
				
				// Skip elements without param 'options'
				if (!isset($field['options']) || count($field['options'])>0) continue;

				// Fill the 'country' array
				if ($id == 'country') {
					$options[$id]['options'] = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY);

				// Fill the 'state' array
				} else if ($id == 'state') {
					$options[$id]['options'] = trx_addons_array_merge(
													array(esc_html__('- State -', 'trx_addons')),
													trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE, array(
														'meta_key' => 'country',
														'meta_value' => !empty($options['country']['val'])
																			? $options['country']['val']
																			: trx_addons_array_get_first($options['country']['options'])
														)));

				// Fill the 'city' array
				} else if ($id == 'city') {
					if ($options['state']['val'] > 0)
						$args = array(
										'meta_query' => array(
											array(
												'type' => 'NUMERIC',
												'key' => 'country',
												'value' => !empty($options['country']['val'])
																? $options['country']['val']
																: trx_addons_array_get_first($options['country']['options'])
											),
											array(
												'type' => 'NUMERIC',
												'key' => 'state',
												'value' => $options['state']['val']
											)
										)
									);
					else
						$args = array(
									'meta_key' => 'country',
									'meta_value' => !empty($options['country']['val'])
																? $options['country']['val']
																: trx_addons_array_get_first($options['country']['options'])
									);
					$options[$id]['options'] = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY, $args);

				// Fill the 'neighborhood' array
				} else if ($id == 'neighborhood') {
					$args = array(
									'meta_query' => array(
										array(
											'type' => 'NUMERIC',
											'key' => 'country',
											'value' => !empty($options['country']['val'])
																? $options['country']['val']
																: trx_addons_array_get_first($options['country']['options'])
										),
										array(
											'type' => 'NUMERIC',
											'key' => 'city',
											'value' => !empty($options['city']['val'])
																? $options['city']['val']
																: trx_addons_array_get_first($options['city']['options'])
										)
									)
								);
					if ($options['state']['val'] > 0)
						$args['meta_query'][] = array(
											'type' => 'NUMERIC',
											'key' => 'state',
											'value' => $options['state']['val']
										);
					$options[$id]['options'] = trx_addons_array_merge(
													array(esc_html__('- Neighborhood -', 'trx_addons')),
													trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD, $args)
													);

				// Fill the 'agent' array
				} else if ($id == 'agent') {
					$options[$id]['options'] = trx_addons_get_list_posts(false, array(
																'post_type' => TRX_ADDONS_CPT_AGENTS_PT,
																'orderby' => 'title',
																'order' => 'ASC'
																)
														);
				}
			}
		}
		return $options;
	}
}


// Save some parameters (like 'price', 'agent', 'id', 'bedrooms', etc.) for search and sorting
// and store 'country', 'state', 'city' and 'neighborhood' as post's terms
if ( !function_exists( 'trx_addons_cpt_properties_save_post_options' ) ) {
	add_filter('trx_addons_filter_save_post_options', 'trx_addons_cpt_properties_save_post_options', 10, 3);
	function trx_addons_cpt_properties_save_post_options($options, $post_id, $post_type) {
		if ($post_type == TRX_ADDONS_CPT_PROPERTIES_PT) {
			global $post;
			// Update post meta and post terms for search and sort
			update_post_meta($post_id, 'trx_addons_properties_price', $options['price']);
			update_post_meta($post_id, 'trx_addons_properties_area_size', $options['area_size']);
			update_post_meta($post_id, 'trx_addons_properties_bathrooms', $options['bathrooms']);
			update_post_meta($post_id, 'trx_addons_properties_bedrooms', $options['bedrooms']);
			update_post_meta($post_id, 'trx_addons_properties_garages', $options['garages']);
			update_post_meta($post_id, 'trx_addons_properties_id', $options['id']);
			update_post_meta($post_id, 'trx_addons_properties_zip', $options['zip']);
			update_post_meta($post_id, 'trx_addons_properties_address', $options['address']);
			update_post_meta($post_id, 'trx_addons_properties_agent', $options['agent_type']=='none' 
																		? 0 
																		: ($options['agent_type']=='agent'
																			? $options['agent']
																			: -get_the_author_meta('ID', !empty($post->ID) && $post->ID==$post_id
																				? $post->post_author
																				: false)
																			)
							);
			wp_set_post_terms($post_id, array((int)$options['country']), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY, false);
			wp_set_post_terms($post_id, array((int)$options['state']), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE, false);
			wp_set_post_terms($post_id, array((int)$options['city']), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY, false);
			wp_set_post_terms($post_id, array((int)$options['neighborhood']), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD, false);
			// Update min and max values of the bedrooms, bathrooms, area, price, etc.
			trx_addons_cpt_properties_update_min_max();
		}
		return $options;
	}
}


// Update min and max values of the bedrooms, bathrooms, area, price, etc.
if ( !function_exists( 'trx_addons_cpt_properties_update_min_max' ) ) {
	function trx_addons_cpt_properties_update_min_max() {
		global $wpdb;
		$rez = $wpdb->get_results( "SELECT min(bedrooms.meta_value+0) as bed_min, max(bedrooms.meta_value+0) as bed_max,
										 min(bathrooms.meta_value+0) as bath_min, max(bathrooms.meta_value+0) as bath_max,
										 min(area.meta_value+0.0) as area_min, max(area.meta_value+0.0) as area_max,
										 min(price.meta_value+0.0) as price_min, max(price.meta_value+0.0) as price_max
									FROM {$wpdb->posts}
										INNER JOIN {$wpdb->postmeta} AS bedrooms ON {$wpdb->posts}.ID = bedrooms.post_id
										INNER JOIN {$wpdb->postmeta} AS bathrooms ON {$wpdb->posts}.ID = bathrooms.post_id
										INNER JOIN {$wpdb->postmeta} AS area ON {$wpdb->posts}.ID = area.post_id
										INNER JOIN {$wpdb->postmeta} AS price ON {$wpdb->posts}.ID = price.post_id
									WHERE 1=1
										AND ({$wpdb->posts}.post_status='publish')
										AND bedrooms.meta_key='trx_addons_properties_bedrooms'
										AND bathrooms.meta_key='trx_addons_properties_bathrooms'
										AND area.meta_key='trx_addons_properties_area_size'
										AND price.meta_key='trx_addons_properties_price'",
									ARRAY_A
									);
		update_option('trx_addons_properties_min_max', $rez[0]);
	}
}


// Return min and max values of the bedrooms, bathrooms, area, price, etc.
if ( !function_exists( 'trx_addons_cpt_properties_get_min_max' ) ) {
	function trx_addons_cpt_properties_get_min_max($key='') {
		static $min_max=false;
		if ($min_max === false)
			$min_max = array_merge(array(
									'bed_min' => 0,
									'bed_max' => 10,
									'bath_min' => 0,
									'bath_max' => 10,
									'area_min' => 0,
									'area_max' => 1000,
									'price_min' => 0,
									'price_max' => 1000000
									),
								get_option('trx_addons_properties_min_max', array())
								);
		return empty($key) ? $min_max : $min_max[$key];
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_properties_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_properties_load_scripts_front');
	function trx_addons_cpt_properties_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script('trx_addons-cpt_properties', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'properties/properties.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cpt_properties_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_properties_merge_styles');
	function trx_addons_cpt_properties_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'properties/_properties.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_cpt_properties_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_cpt_properties_merge_styles_responsive');
	function trx_addons_cpt_properties_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'properties/_properties.responsive.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_cpt_properties_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_cpt_properties_merge_scripts');
	function trx_addons_cpt_properties_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'properties/properties.js';
		return $list;
	}
}


// Load required styles and scripts for the backend
if ( !function_exists( 'trx_addons_cpt_properties_load_scripts_admin' ) ) {
	add_action("admin_enqueue_scripts", 'trx_addons_cpt_properties_load_scripts_admin');
	function trx_addons_cpt_properties_load_scripts_admin() {
		wp_enqueue_script('trx_addons-cpt_properties', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'properties/properties.admin.js'), array('jquery'), null, true );
	}
}


// Return true if it's properties page
if ( !function_exists( 'trx_addons_is_properties_page' ) ) {
	function trx_addons_is_properties_page() {
		return defined('TRX_ADDONS_CPT_PROPERTIES_PT') 
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_PROPERTIES_PT)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY)
						|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD)
						);
	}
}


// Return taxonomy for the current post type
if ( !function_exists( 'trx_addons_cpt_properties_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_cpt_properties_post_type_taxonomy', 10, 2 );
	function trx_addons_cpt_properties_post_type_taxonomy($tax='', $post_type='') {
		if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $post_type == TRX_ADDONS_CPT_PROPERTIES_PT )
			$tax = TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE;
		return $tax;
	}
}


// Return link to the all posts for the breadcrumbs
if ( !function_exists( 'trx_addons_cpt_properties_get_blog_all_posts_link' ) ) {
	add_filter('trx_addons_filter_get_blog_all_posts_link', 'trx_addons_cpt_properties_get_blog_all_posts_link', 10, 2);
	function trx_addons_cpt_properties_get_blog_all_posts_link($link='', $args=array()) {
		if ($link=='') {
			if (trx_addons_is_properties_page() 
				&& (!is_post_type_archive(TRX_ADDONS_CPT_PROPERTIES_PT) || (int) trx_addons_get_value_gp('compare') == 1)) {
				if (($url = get_post_type_archive_link( TRX_ADDONS_CPT_PROPERTIES_PT )) != '') {
					$obj = get_post_type_object(TRX_ADDONS_CPT_PROPERTIES_PT);
					$link = '<a href="'.esc_url($url).'">' . esc_html($obj->labels->all_items) . '</a>';
				}
			}
		}
		return $link;
	}
}


// Return current page title
if ( !function_exists( 'trx_addons_cpt_properties_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'trx_addons_cpt_properties_get_blog_title');
	function trx_addons_cpt_properties_get_blog_title($title='') {
		if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') ) {
			if ( is_post_type_archive(TRX_ADDONS_CPT_PROPERTIES_PT) ) {
				if ( (int) trx_addons_get_value_gp('compare') == 1)
					$title = esc_html__('Compare Properties', 'trx_addons');
				else {
					$obj = get_post_type_object(TRX_ADDONS_CPT_PROPERTIES_PT);
					$title = $obj->labels->all_items;
				}
			}

		}
		return $title;
	}
}


// Parse query params from GET/POST and wp_query_parameters
if ( !function_exists( 'trx_addons_cpt_properties_query_params' ) ) {
	function trx_addons_cpt_properties_query_params($params=array()) {
		$q_obj = get_queried_object();
		if ( ($value = trx_addons_get_value_gp('properties_keyword')) != '' )	$params['properties_keyword'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('properties_order')) != '' )		$params['properties_order'] = sanitize_text_field($value);
		if ( is_single() && get_post_type()==TRX_ADDONS_CPT_AGENTS_PT)			$params['properties_agent'] = (int) $q_obj->ID;
		else if ( ($value = trx_addons_get_value_gp('properties_agent')) > 0 )	$params['properties_agent'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD))			$params['properties_neighborhood'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_neighborhood')) > 0) $params['properties_neighborhood'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY))					$params['properties_city'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_city')) > 0 )	$params['properties_city'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE))					$params['properties_state'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_state')) > 0 )	$params['properties_state'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY))				$params['properties_country'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_country')) > 0 )$params['properties_country'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE))					$params['properties_type'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_type')) > 0 )	$params['properties_type'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS))					$params['properties_status'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_status')) > 0 )	$params['properties_status'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS))					$params['properties_labels'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('properties_labels')) > 0 )	$params['properties_labels'] = (int) $value;
		if ( ($value = trx_addons_get_value_gp('properties_bedrooms')) != '' )	$params['properties_bedrooms'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('properties_bathrooms')) != '' )	$params['properties_bathrooms'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('properties_area')) != '' )		$params['properties_area'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('properties_price')) != '' )		$params['properties_price'] = sanitize_text_field($value);
		// Collect properties_features_xxx to the single param
		foreach ($_GET as $k=>$v) {
			if ( strpos($k, 'properties_features') === 0 ) {
				if (!isset($params['properties_features'])) $params['properties_features'] = array();
				$params['properties_features'][] = (int) $v;
			}
		}
		return $params;
	}
}


// Make new query to search properties or return $wp_query object if haven't search parameters
if ( !function_exists( 'trx_addons_cpt_properties_query_params_to_args' ) ) {
	function trx_addons_cpt_properties_query_params_to_args($params=array(), $new_query=false) {
		$params = trx_addons_cpt_properties_query_params($params);
		$args = $keywords = array();
		
		// Use only closest location
		if (!empty($params['properties_neighborhood']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD, $params['properties_neighborhood']);
		else if (!empty($params['properties_city']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY, $params['properties_city']);
		else if (!empty($params['properties_state']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE, $params['properties_state']);
		else if (!empty($params['properties_country']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY, $params['properties_country']);

		// Other params
		if (!empty($params['properties_agent']))
			$args = trx_addons_query_add_meta($args, 'trx_addons_properties_agent', $params['properties_agent']);
		if (!empty($params['properties_type']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE, $params['properties_type']);
		if (!empty($params['properties_status']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS, $params['properties_status']);
		if (!empty($params['properties_labels']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS, $params['properties_labels']);
		if (!empty($params['properties_features']))
			foreach ($params['properties_features'] as $v)
				$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES, $v);
		if (!empty($params['properties_bedrooms']))
			if ($params['properties_bedrooms']!=trx_addons_cpt_properties_get_min_max('bed_min').','.trx_addons_cpt_properties_get_min_max('bed_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_properties_bedrooms', $params['properties_bedrooms']);
		if (!empty($params['properties_bathrooms']))
			if ($params['properties_bathrooms']!=trx_addons_cpt_properties_get_min_max('bath_min').','.trx_addons_cpt_properties_get_min_max('bath_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_properties_bathrooms', $params['properties_bathrooms']);
		if (!empty($params['properties_area']))
			if ($params['properties_area']!=trx_addons_cpt_properties_get_min_max('area_min').','.trx_addons_cpt_properties_get_min_max('area_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_properties_area', $params['properties_area']);
		if (!empty($params['properties_price']))
			if ($params['properties_price']!=trx_addons_cpt_properties_get_min_max('price_min').','.trx_addons_cpt_properties_get_min_max('price_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_properties_price', $params['properties_price']);
		if (!empty($params['properties_keyword']))
			$keywords = array(
				'relation' => 'OR',
				array(
					'key' => 'trx_addons_properties_address',
					'value' => $params['properties_keyword'],
					'type' => 'CHAR',
					'compare' => 'LIKE'
				),
				array(
					'key' => 'trx_addons_properties_zip',
					'value' => $params['properties_keyword'],
					'type' => 'CHAR',
					'compare' => '='
				),
				array(
					'key' => 'trx_addons_properties_id',
					'value' => $params['properties_keyword'],
					'type' => 'CHAR',
					'compare' => '='
				)
			);
		if (!empty($params['properties_order'])) {
			$args['order'] = strpos($params['properties_order'], '_desc') !== false ? 'desc' : 'asc';
			$params['properties_order'] = str_replace(array('_asc', '_desc'), '' , $params['properties_order']);
			if ($params['properties_order'] == 'price') {
				$args['meta_key'] = 'trx_addons_properties_price';
				$args['orderby'] = 'meta_value_num';
			} else if (in_array($params['properties_order'], array('title', 'post_title')))
				$args['orderby'] = 'title';
			else if (in_array($params['properties_order'], array('date', 'post_date')))
				$args['orderby'] = 'date';
			else if ($params['properties_order'] == 'rand')
				$args['orderby'] = 'rand';
		}

		// Add keywords
		if (!empty($keywords)) {
			if (empty($args['meta_query']))
				$args['meta_query'] = $keywords;
			else
				$args['meta_query'] = array(
											'relation' => 'AND',
											$keywords,
											array(
												$args['meta_query']
											)
										);
		}

		// Prepare args for new query (not in 'pre_query')
		if ($new_query) {	// && count($args) > 0) {
			$args = array_merge(array(
						'post_type' => TRX_ADDONS_CPT_PROPERTIES_PT,
						'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') 
											? array('publish', 'private') 
											: 'publish'
					), $args);
			$page_number = get_query_var('paged') 
								? get_query_var('paged') 
								: (get_query_var('page') 
									? get_query_var('page') 
									: 1);
			if ($page_number > 1) {
				$args['paged'] = $page_number;
				$args['ignore_sticky_posts'] = true;
			}
			$ppp = get_option('posts_per_page');
			if ((int) $ppp == 0) $ppp = 10;
			$args['posts_per_page'] = (int) $ppp;
		}
		return $args;
	}
}


// Add query vars to filter posts
if (!function_exists('trx_addons_cpt_properties_pre_get_posts')) {
	add_action( 'pre_get_posts', 'trx_addons_cpt_properties_pre_get_posts' );
	function trx_addons_cpt_properties_pre_get_posts($query) {
		if (!$query->is_main_query()) return;

		if ($query->get('post_type') == TRX_ADDONS_CPT_PROPERTIES_PT) {
			
			// Filters and sort for the admin lists
			if (is_admin()) {
				$agent = trx_addons_get_value_gp('agent');
				if ((int) $agent < 0)
					$query->set('post_author', -$agent);
				else if ((int) $agent > 0) {
					$query->set('meta_key', 'trx_addons_properties_agent');
					$query->set('meta_value', $agent);
				}

			// Filters and sort for the foreground lists
			} else {
				$args = trx_addons_cpt_properties_query_params_to_args(array(), (int) trx_addons_get_value_gp('properties_query'));
				if (is_array($args) && count($args) > 0) {
					foreach ($args as $k=>$v)
						$query->set($k, $v);
				} else if ((int) trx_addons_get_value_gp('compare') == 1) {
					$posts = array();
					$list = trx_addons_get_value_gpc('trx_addons_properties_compare_list', array());
					if (!empty($list)) $list = json_decode($list, true);
					if (is_array($list)) {
						foreach ($list as $k=>$v) {
							$id = (int) str_replace('id_', '', $k);
							if ($id > 0) $posts[] = $id;
						}
					}
					if (count($posts) > 0) {
						$query->set('post__in', $posts);
					}
				}
			}
		}
	}
}


// Replace standard theme templates
//-------------------------------------------------------------

// Change standard single template for properties posts
if ( !function_exists( 'trx_addons_cpt_properties_single_template' ) ) {
	add_filter('single_template', 'trx_addons_cpt_properties_single_template');
	function trx_addons_cpt_properties_single_template($template) {
		global $post;
		if (is_single() && $post->post_type == TRX_ADDONS_CPT_PROPERTIES_PT)
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.single.php');
		return $template;
	}
}

// Change standard archive template for properties posts
if ( !function_exists( 'trx_addons_cpt_properties_archive_template' ) ) {
	add_filter('archive_template',	'trx_addons_cpt_properties_archive_template');
	function trx_addons_cpt_properties_archive_template( $template ) {
		if ( is_post_type_archive(TRX_ADDONS_CPT_PROPERTIES_PT) ) {
			if ((int) trx_addons_get_value_gp('compare') == 1)
				$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.compare.php');
			else
				$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.archive.php');
		}
		return $template;
	}	
}



// Admin utils
// -----------------------------------------------------------------

// Create additional column in the posts list
if (!function_exists('trx_addons_cpt_properties_add_custom_column')) {
	add_filter('manage_edit-'.trx_addons_cpt_param('properties', 'post_type').'_columns',	'trx_addons_cpt_properties_add_custom_column', 9);
	function trx_addons_cpt_properties_add_custom_column( $columns ){
		if (is_array($columns) && count($columns)>0) {
			$new_columns = array();
			foreach($columns as $k=>$v) {
				if (!in_array($k, array('author', 'comments', 'date', 'taxonomy-'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY)))
					$new_columns[$k] = $v;
				if ($k=='title') {
					$new_columns['cpt_properties_image'] = esc_html__('Photo', 'trx_addons');
					$new_columns['cpt_properties_id'] = esc_html__('ID', 'trx_addons');
					$new_columns['taxonomy-'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY] = esc_html__('City', 'trx_addons');
				}
			}
			$new_columns['cpt_properties_price'] = esc_html__('Price', 'trx_addons');
			$new_columns['cpt_properties_details'] = esc_html__('Details', 'trx_addons');
			$columns = $new_columns;
		}
		return $columns;
	}
}

// Fill custom columns in the posts list
if (!function_exists('trx_addons_cpt_properties_fill_custom_column')) {
	add_action('manage_'.trx_addons_cpt_param('properties', 'post_type').'_posts_custom_column', 'trx_addons_cpt_properties_fill_custom_column', 9, 2);
	function trx_addons_cpt_properties_fill_custom_column($column_name='', $post_id=0) {
		static $meta_buffer = array();
		if (empty($meta_buffer[$post_id])) $meta_buffer[$post_id] = get_post_meta($post_id, 'trx_addons_options', true);
		$meta = $meta_buffer[$post_id];
		if ($column_name == 'cpt_properties_image') {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), trx_addons_get_thumb_size('masonry') );
			if (!empty($image[0])) {
				?><img class="trx_addons_cpt_column_image_preview trx_addons_cpt_properties_image_preview" 
						src="<?php echo esc_url($image[0]); ?>" 
						alt=""<?php if (!empty($image[1])) echo ' width="'.intval($image[1]).'"'; ?><?php
						if (!empty($image[2])) echo ' height="'.intval($image[2]).'"'; ?>><?php
			}
		} else if ($column_name == 'cpt_properties_id') {
			if (!empty($meta['id'])) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_data"><?php echo esc_html($meta['id']); ?></span>
				</div><?php
			}
		} else if ($column_name == 'cpt_properties_price') {
			if (!empty($meta['price'])) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_label"><?php echo wp_kses_post(trx_addons_prepare_macros($meta['before_price'])); ?></span>
					<span class="trx_addons_meta_data"><?php echo esc_html(trx_addons_format_price($meta['price'])); ?></span>
					<?php if (empty($meta['price2'])) { ?>
					<span class="trx_addons_meta_label"><?php echo wp_kses_post(trx_addons_prepare_macros($meta['after_price'])); ?></span>
					<?php } ?>
				</div><?php
			}
			if (!empty($meta['price2'])) {
				?><div class="trx_addons_meta_row">
				<?php if (empty($meta['price'])) { ?>
					<span class="trx_addons_meta_label"><?php echo wp_kses_post(trx_addons_prepare_macros($meta['before_price'])); ?></span>
				<?php } ?>
					<span class="trx_addons_meta_data"><?php echo esc_html(trx_addons_format_price($meta['price2'])); ?></span>
					<span class="trx_addons_meta_label"><?php echo wp_kses_post(trx_addons_prepare_macros($meta['after_price'])); ?></span>
				</div><?php
			}
		} else if ($column_name == 'cpt_properties_details') {
			?><div class="trx_addons_meta_row">
				<span class="trx_addons_meta_label"><?php esc_html_e('Published', 'trx_addons'); ?></span>
				<span class="trx_addons_meta_label"><?php echo esc_html(get_the_date()); ?></span>
			</div><?php
			?><div class="trx_addons_meta_row">
				<span class="trx_addons_meta_label"><?php esc_html_e('by', 'trx_addons'); ?></span>
				<span class="trx_addons_meta_label"><?php the_author(); ?></span>
			</div><?php
			if ($meta['agent_type']!='none' && ($meta['agent_type']=='author' || $meta['agent']!=0)) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_label"><?php esc_html_e('Agent', 'trx_addons'); ?></span>
					<span class="trx_addons_meta_label"><a href="<?php
							echo esc_url(get_admin_url(null, 'edit.php?post_type='.TRX_ADDONS_CPT_PROPERTIES_PT
										.'&agent='.intval($meta['agent']))); 
							?>"><?php
							if ($meta['agent_type']=='author')
								the_author();
							else
								echo esc_html(get_the_title($meta['agent']));
						?></a>
					</span>
				</div><?php
			}
		}
	}
}


// AJAX handler for the send_form action
//-----------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_properties_ajax_send_sc_form' ) ) {
	// Use 9 priority to early handling action (before standard handler from shortcode 'sc_form')
	add_action('wp_ajax_send_sc_form',			'trx_addons_cpt_properties_ajax_send_sc_form', 9);
	add_action('wp_ajax_nopriv_send_sc_form',	'trx_addons_cpt_properties_ajax_send_sc_form', 9);
	function trx_addons_cpt_properties_ajax_send_sc_form() {

		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
	
		parse_str($_POST['data'], $post_data);
		
		if (empty($post_data['property_agent'])) return;
		$agent_id = (int) $post_data['property_agent'];
		$agent_email = '';
		if ($agent_id > 0) {			// Agent
			$meta = get_post_meta($agent_id, 'trx_addons_options', true);
			$agent_email = $meta['email'];
		} else if ($agent_id < 0) {		// Author
			$user_id = abs($agent_id);
			$user_data = get_userdata($user_id);
			$agent_email = $user_data->user_email;
		}
		if (empty($agent_email)) return;
		
		$property_id = !empty($post_data['property_id']) ? (int) $post_data['property_id'] : 0;
		$property_title = !empty($property_id) ? get_the_title($property_id) : '';

		$response = array('error'=>'');
		
		$user_name	= !empty($post_data['name']) ? stripslashes($post_data['name']) : '';
		$user_email	= !empty($post_data['email']) ? stripslashes($post_data['email']) : '';
		$user_phone	= !empty($post_data['phone']) ? stripslashes($post_data['phone']) : '';
		$user_msg	= !empty($post_data['message']) ? stripslashes($post_data['message']) : '';
		
		// Attention! Strings below not need html-escaping, because mail is a plain text
		$subj = $property_id > 0
					? sprintf(__('Query on property "%s" from "%s"', 'trx_addons'), $property_title, $user_name)
					: sprintf(__('Query on help from "%s"', 'trx_addons'), $user_name);
		$msg = (!empty($user_name)	? "\n".sprintf(__('Name: %s', 'trx_addons'), $user_name) : '')
			.  (!empty($user_email) ? "\n".sprintf(__('E-mail: %s', 'trx_addons'), $user_email) : '')
			.  (!empty($user_phone) ? "\n".sprintf(__('Phone:', 'trx_addons'), $user_phone) : '')
			.  (!empty($user_msg)	? "\n\n".trim($user_msg) : '')
			.  "\n\n............. " . get_bloginfo('site_name') . " (" . esc_url(home_url('/')) . ") ............";

		if (!wp_mail($agent_email, $subj, $msg)) {
			$response['error'] = esc_html__('Error send message!', 'trx_addons');
		}
	
		echo json_encode($response);
		die();
	}
}


// Prepare slides with Properties data
//----------------------------------------------------------------------------
if (!function_exists('trx_addons_cpt_properties_slider_content')) {
	add_filter('trx_addons_filter_slider_content', 'trx_addons_cpt_properties_slider_content', 10, 2);
	function trx_addons_cpt_properties_slider_content($image, $args) {
		if (get_post_type() == TRX_ADDONS_CPT_PROPERTIES_PT) {
			$image['content'] = trx_addons_get_template_part_as_string(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.slider-slide.php',
											'trx_addons_args_properties_slider_slide',
											compact('image', 'args')
										);
			$image['image'] = $image['link'] = $image['url'] = '';
		}
		return $image;
	}
}


// trx_sc_properties
//-------------------------------------------------------------
/*
[trx_sc_properties id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_properties' ) ) {
	function trx_addons_sc_properties($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_properties', $atts, array(
			// Individual params
			"type" => "default",
			"properties_type" => '',
			"properties_status" => '',
			"properties_labels" => '',
			"properties_country" => '',
			"properties_state" => '',
			"properties_city" => '',
			"properties_neighborhood" => '',
			"googlemap_height" => 350,
			"columns" => '',
			"count" => 3,
			"offset" => 0,
			"orderby" => '',
			"order" => '',
			"ids" => '',
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
			"title" => "",
			"subtitle" => "",
			"description" => "",
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
			)
		);

		if (!empty($atts['ids'])) {
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['count'] = max(1, (int) $atts['count']);
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'title';
		if (empty($atts['order'])) $atts['order'] = 'asc';
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.default.php'
										),
                                        'trx_addons_args_sc_properties',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_properties', $atts, $content);
	}
}


// Add [trx_sc_properties] in the VC shortcodes list
if (!function_exists('trx_addons_sc_properties_add_in_vc')) {
	function trx_addons_sc_properties_add_in_vc() {
		
		add_shortcode("trx_sc_properties", "trx_addons_sc_properties");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_properties", 'trx_addons_sc_properties_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Properties extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_properties_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_properties_add_in_vc_params')) {
	function trx_addons_sc_properties_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_sc_properties');
		// Prepare lists
		$country = $vc_edit && !empty($vc_params['properties_country']) ? $vc_params['properties_country'] : 0;
		$state = $vc_edit && !empty($vc_params['properties_state']) ? $vc_params['properties_state'] : 0;
		$city = $vc_edit && !empty($vc_params['properties_city']) ? $vc_params['properties_city'] : 0;
		$neighborhood = $vc_edit && !empty($vc_params['properties_neighborhood']) ? $vc_params['properties_neighborhood'] : 0;
		// List of states
		$list_states = trx_addons_array_merge(array(0 => esc_html__('- State -', 'trx_addons')),
										$country == 0
											? array()
											: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE, array(
												'meta_key' => 'country',
												'meta_value' => $country
												))
										);
		// List of cities
		$args = array();
		if ($state > 0)
			$args = array(
						'meta_key' => 'state',
						'meta_value' => $state
						);
		else if ($country > 0)
			$args = array(
						'meta_key' => 'country',
						'meta_value' => $country
						);
		$list_cities = trx_addons_array_merge(array(0 => esc_html__('- City -', 'trx_addons')),
										count($args) == 0
											? array()
											: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY, $args)
										);
		// List of neighborhoods
		$list_neighborhoods = trx_addons_array_merge(array(0 => esc_html__('- Neighborhood -', 'trx_addons')),
										$city == 0
											? array()
											: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD, array(
													'meta_key' => 'city',
													'meta_value' => $city
													))
										);
		// Prepare shortcode params
		$params = array_merge(
				array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Layout", 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "default",
				        'save_always' => true,
						"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'properties', 'sc'), 'trx_sc_properties')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "googlemap_height",
						"heading" => esc_html__("Googlemap height", 'trx_addons'),
						"description" => wp_kses_data( __("Specify height of the Google map with properties", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'type',
							'value' => array('googlemap')
						),
						"std" => "350",
				        'save_always' => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "properties_type",
						"heading" => esc_html__("Type", 'trx_addons'),
						"description" => wp_kses_data( __("Select the type to show properties that have it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"value" => array_merge(array(esc_html__('- Type -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "properties_status",
						"heading" => esc_html__("Status", 'trx_addons'),
						"description" => wp_kses_data( __("Select the status to show properties that have it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- Status -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "properties_labels",
						"heading" => esc_html__("Label", 'trx_addons'),
						"description" => wp_kses_data( __("Select the label to show properties that have it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- Label -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "properties_country",
						"heading" => esc_html__("Country", 'trx_addons'),
						"description" => wp_kses_data( __("Select the country to show properties from", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-3 vc_new_row',
				        'save_always' => true,
						"value" => array_merge(array(esc_html__('- Country -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "properties_state",
						"heading" => esc_html__("State", 'trx_addons'),
						"description" => wp_kses_data( __("Select the county/state to show properties from", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-3',
				        'save_always' => true,
						"value" => array_flip($list_states),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "properties_city",
						"heading" => esc_html__("City", 'trx_addons'),
						"description" => wp_kses_data( __("Select the city to show properties from", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-3',
				        'save_always' => true,
						"value" => array_flip($list_cities),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "properties_neighborhood",
						"heading" => esc_html__("Neighborhood", 'trx_addons'),
						"description" => wp_kses_data( __("Select the neighborhood to show properties from", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-3',
				        'save_always' => true,
						"value" => array_flip($list_neighborhoods),
						"std" => "0",
						"type" => "dropdown"
					)
				),
				trx_addons_vc_add_query_param(''),
				trx_addons_vc_add_slider_param(),
				trx_addons_vc_add_title_param(),
				trx_addons_vc_add_id_param()
		);
		
		// Add dependencies to params
		$params = trx_addons_vc_add_param_option($params, 'orderby', array( 
																		"value" => array_flip(trx_addons_get_list_sc_query_orderby('none', 'none,ID,post_date,price,title,rand'))
																		)
												);
		$params = trx_addons_vc_add_param_option($params, 'columns', array( 
																		'dependency' => array(
																			'element' => 'type',
																			'value' => array('default', 'slider')
																			)
																		)
												);
		$params = trx_addons_vc_add_param_option($params, 'slider', array( 
																		'dependency' => array(
																			'element' => 'type',
																			'value' => array('default', 'slider')
																			)
																		)
												);
		$params = trx_addons_vc_add_param_option($params, 'slider_pagination', array(
																			"value" => array_flip(array_merge(trx_addons_get_list_sc_slider_paginations(), array(
																				'bottom_outside' => esc_html__('Bottom Outside', 'trx_addons')
																			)))
																		)

												);
												
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_properties",
				"name" => esc_html__("Properties", 'trx_addons'),
				"description" => wp_kses_data( __("Display selected properties", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_properties',
				"class" => "trx_sc_properties",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_sc_properties' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_properties_add_in_elementor')) {
	
	// Load required styles and scripts for Elementor Editor mode
	if ( !function_exists( 'trx_addons_sc_properties_elm_editor_load_scripts' ) ) {
		add_action("elementor/editor/before_enqueue_scripts", 'trx_addons_sc_properties_elm_editor_load_scripts');
		function trx_addons_sc_properties_elm_editor_load_scripts() {
			wp_enqueue_script( 'trx_addons-sc_properties-elementor-editor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'properties/properties.elementor.editor.js'), array('jquery'), null, true );
		}
	}
	
	// Register widgets
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_properties_add_in_elementor' );
	function trx_addons_sc_properties_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Properties extends TRX_Addons_Elementor_Widget {

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
				return 'trx_sc_properties';
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
				return __( 'Properties', 'trx_addons' );
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
				return ['trx_addons-cpt'];
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
				// If open params in Elementor Editor
				$params = $this->get_sc_params();
				// Prepare lists                                                          
				$country = !empty($params['properties_country']) ? $params['properties_country'] : 0;
				$state = !empty($params['properties_state']) ? $params['properties_state'] : 0;
				$city = !empty($params['properties_city']) ? $params['properties_city'] : 0;
				$neighborhood = !empty($params['properties_neighborhood']) ? $params['properties_neighborhood'] : 0;
				// List of states
				$list_states = trx_addons_array_merge(array(0 => esc_html__('- State -', 'trx_addons')),
												$country == 0
													? array()
													: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE, array(
														'meta_key' => 'country',
														'meta_value' => $country
														))
												);
				// List of cities
				$args = array();
				if ($state > 0)
					$args = array(
								'meta_key' => 'state',
								'meta_value' => $state
								);
				else if ($country > 0)
					$args = array(
								'meta_key' => 'country',
								'meta_value' => $country
								);
				$list_cities = trx_addons_array_merge(array(0 => esc_html__('- City -', 'trx_addons')),
												count($args) == 0
													? array()
													: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY, $args)
												);
				// List of neighborhoods
				$list_neighborhoods = trx_addons_array_merge(array(0 => esc_html__('- Neighborhood -', 'trx_addons')),
												$city == 0
													? array()
													: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD, array(
															'meta_key' => 'city',
															'meta_value' => $city
															))
												);

				$this->start_controls_section(
					'section_sc_properties',
					[
						'label' => __( 'Properties', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'properties', 'sc'), 'trx_sc_properties'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'googlemap_height',
					[
						'label' => __( 'Height', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 350,
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
					'properties_type',
					[
						'label' => __( 'Type', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Type -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE)),
						'default' => '0'
					]
				);

				$this->add_control(
					'properties_status',
					[
						'label' => __( 'Status', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Status -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS)),
						'default' => '0'
					]
				);

				$this->add_control(
					'properties_labels',
					[
						'label' => __( 'Label', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Label -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS)),
						'default' => '0'
					]
				);

				$this->add_control(
					'properties_country',
					[
						'label' => __( 'Country', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Country -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY)),
						'default' => '0'
					]
				);

				$this->add_control(
					'properties_state',
					[
						'label' => __( 'State', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $list_states,
						'default' => '0'
					]
				);

				$this->add_control(
					'properties_city',
					[
						'label' => __( 'City', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $list_cities,
						'default' => '0'
					]
				);

				$this->add_control(
					'properties_neighborhood',
					[
						'label' => __( 'Neighborhood', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $list_neighborhoods,
						'default' => '0'
					]
				);

				$this->end_controls_section();
				
				$this->add_query_param(false, [
					'orderby' => [
								'options' => trx_addons_get_list_sc_query_orderby('none', 'none,ID,post_date,price,title,rand')
					],
					'columns' => [
								'condition' => [
									'type' => ['default', 'slider']
								]
					]
				]);
				
				$this->add_slider_param(false, [
					'slider' => [
								'condition' => [
									'type' => ['default', 'slider']
								]
					],
					'slider_pagination' => [
								'options' => trx_addons_array_merge(trx_addons_get_list_sc_slider_paginations(), array(
																			'bottom_outside' => esc_html__('Bottom Outside', 'trx_addons')
																			))
					]
				]);
				
				$this->add_title_param();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Properties() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Properties extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_properties',
				esc_html__('ThemeREX Properties', 'trx_addons'),
				array(
					'classname' => 'widget_properties',
					'description' => __('Display properties', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			// Prepare lists
			list($vc_edit, $vc_params) = trx_addons_get_sow_form_params('TRX_Addons_SOW_Widget_Properties');
			// Prepare lists
			$country = $vc_edit && !empty($vc_params['properties_country']) ? $vc_params['properties_country'] : 0;
			$state = $vc_edit && !empty($vc_params['properties_state']) ? $vc_params['properties_state'] : 0;
			$city = $vc_edit && !empty($vc_params['properties_city']) ? $vc_params['properties_city'] : 0;
			$neighborhood = $vc_edit && !empty($vc_params['properties_neighborhood']) ? $vc_params['properties_neighborhood'] : 0;
			// List of states
			$list_states = trx_addons_array_merge(array(0 => esc_html__('- State -', 'trx_addons')),
											$country == 0
												? array()
												: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE, array(
													'meta_key' => 'country',
													'meta_value' => $country
													))
											);
			// List of cities
			$args = array();
			if ($state > 0)
				$args = array(
							'meta_key' => 'state',
							'meta_value' => $state
							);
			else if ($country > 0)
				$args = array(
							'meta_key' => 'country',
							'meta_value' => $country
							);
			$list_cities = trx_addons_array_merge(array(0 => esc_html__('- City -', 'trx_addons')),
											count($args) == 0
												? array()
												: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY, $args)
											);
			// List of neighborhoods
			$list_neighborhoods = trx_addons_array_merge(array(0 => esc_html__('- Neighborhood -', 'trx_addons')),
											$city == 0
												? array()
												: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD, array(
														'meta_key' => 'city',
														'meta_value' => $city
														))
											);
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'properties', 'sc'), $this->get_sc_name(), 'sow' ),
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array('type')
						),
						'type' => 'select'
					),
					"googlemap_height" => array(
						"label" => esc_html__("Googlemap height", 'trx_addons'),
						"description" => wp_kses_data( __("Specify height of the Google map with properties", 'trx_addons') ),
						'state_handler' => array(
							"type[googlemap]" => array('show'),
							"_else[type]" => array('hide')
						),
						"default" => "350px",
						"type" => "measurement"
					),
					"properties_type" => array(
						"label" => esc_html__("Type", 'trx_addons'),
						"description" => wp_kses_data( __("Select the type to show properties that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Type -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE)),
						"type" => "select"
					),
					"properties_status" => array(
						"label" => esc_html__("Labels", 'trx_addons'),
						"description" => wp_kses_data( __("Select the label to show properties that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Label -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS)),
						"type" => "select"
					),
					"properties_labels" => array(
						"label" => esc_html__("Status", 'trx_addons'),
						"description" => wp_kses_data( __("Select the status to show properties that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Status -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS)),
						"type" => "select"
					),
					"properties_country" => array(
						"label" => esc_html__("Country", 'trx_addons'),
						"description" => wp_kses_data( __("Select the country to show properties from", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Country -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY)),
						"type" => "select"
					),
					"properties_state" => array(
						"label" => esc_html__("State", 'trx_addons'),
						"description" => wp_kses_data( __("Select the county/state to show properties from", 'trx_addons') ),
						"default" => 0,
						"options" => $list_states,
						"type" => "select_dynamic"
					),
					"properties_city" => array(
						"label" => esc_html__("City", 'trx_addons'),
						"description" => wp_kses_data( __("Select the city to show properties from", 'trx_addons') ),
						"default" => 0,
						"options" => $list_cities,
						"type" => "select_dynamic"
					),
					"properties_neighborhood" => array(
						"label" => esc_html__("Neighborhood", 'trx_addons'),
						"description" => wp_kses_data( __("Select the neighborhood to show properties from", 'trx_addons') ),
						"default" => 0,
						"options" => $list_neighborhoods,
						"type" => "select_dynamic"
					),
				),
				trx_addons_sow_add_query_param('', array(
					'orderby' => array( 
									"options" => trx_addons_get_list_sc_query_orderby('none', 'none,ID,post_date,price,title,rand')
								),
					'columns' => array( 
									'state_handler' => array(
										"type[default]" => array('show'),
										"type[slider]" => array('show'),
										"_else[type]" => array('hide')
									)
								)
				)),
				trx_addons_sow_add_slider_param(false, array(
					'slider' => array( 
									'state_handler' => array(
										"type[default]" => array('show'),
										"type[slider]" => array('show'),
										"_else[type]" => array('hide')
									)
								),
					'slider_pagination' => array(
									"options" => trx_addons_array_merge(trx_addons_get_list_sc_slider_paginations(), array(
										'bottom_outside' => esc_html__('Bottom Outside', 'trx_addons')
									))
								)
				)),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_properties', __FILE__, 'TRX_Addons_SOW_Widget_Properties');
}


// Include additional files
// Attention! Must be included after the post type 'Properties' registration
//----------------------------------------------------------------------------
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_type.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_status.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_features.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_labels.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_country.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_state.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_city.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.taxonomy_neighborhood.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/properties.agents.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/widget.properties_compare.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/widget.properties_sort.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "properties/widget.properties_search.php")) != '') { include_once $fdir; }
?>