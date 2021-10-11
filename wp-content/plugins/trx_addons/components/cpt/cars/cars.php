<?php
/**
 * ThemeREX Addons Custom post type: Cars
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants for 'Cars'
if ( ! defined('TRX_ADDONS_CPT_CARS_PT') )
		define('TRX_ADDONS_CPT_CARS_PT', trx_addons_cpt_param('cars', 'post_type'));

// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_cars_init')) {
	add_action( 'init', 'trx_addons_cpt_cars_init' );
	function trx_addons_cpt_cars_init() {
		
		trx_addons_meta_box_register(TRX_ADDONS_CPT_CARS_PT, array(
			"basic_section" => array(
				"title" => esc_html__('Basic information', 'trx_addons'),
				"desc" => wp_kses_data( __('Basic information about the car', 'trx_addons') ),
				"type" => "section"
			),
			"maker" => array(
				"title" => esc_html__("Manufacturer", 'trx_addons'),
				"desc" => wp_kses_data( __("Select the car's manufacturer", 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"options" => array(),
				"type" => "select"
			),
			"model" => array(
				"title" => esc_html__("Model", 'trx_addons'),
				"desc" => wp_kses_data( __("Select the car's model", 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"options" => array(),
				"type" => "select"
			),
			"produced" => array(
				"title" => esc_html__("Produced", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify the year when the car is produced (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => date('Y'),
				"options" => trx_addons_get_list_range(date('Y')-100, date('Y')),
				"type" => "text"
			),
			"id" => array(
				"title" => esc_html__("Car ID", 'trx_addons'),
				"desc" => wp_kses_data( __('Car ID - it will help you search this car directly', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"transmission" => array(
				"title" => esc_html__("Transmission", 'trx_addons'),
				"desc" => wp_kses_data( __('Type of transmission', 'trx_addons') ),
				"class" => "trx_addons_column-1_4 trx_addons_new_row",
				"std" => 'auto',
				"options" => trx_addons_cpt_cars_get_list_transmission(),
				"type" => "select"
			),
			"type_drive" => array(
				"title" => esc_html__("Type of drive", 'trx_addons'),
				"desc" => wp_kses_data( __('Type of drive', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => 'front_wheel',
				"options" => trx_addons_cpt_cars_get_list_type_of_drive(),
				"type" => "select"
			),
			"fuel" => array(
				"title" => esc_html__("Fuel", 'trx_addons'),
				"desc" => wp_kses_data( __('Fuel type', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => 'diesel',
				"options" => trx_addons_cpt_cars_get_list_fuel(),
				"type" => "select"
			),
			"engine_type" => array(
				"title" => esc_html__("Engine type", 'trx_addons'),
				"desc" => wp_kses_data( __('Engine type (i.e. TSI, Turbo, etc.)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"engine_size" => array(
				"title" => esc_html__("Engine size", 'trx_addons'),
				"desc" => wp_kses_data( __('Engine size (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4 trx_addons_new_row",
				"std" => "",
				"type" => "text"
			),
			"engine_size_prefix" => array(
				"title" => esc_html__("Engine size prefix", 'trx_addons'),
				"desc" => wp_kses_data( __('Engine size prefix (unit of measurement). Use ^ to make next digit as exponent, eq. cm^3', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"engine_power_horses" => array(
				"title" => esc_html__("Engine power (in horses)", 'trx_addons'),
				"desc" => wp_kses_data( __('Engine powes in horses (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"engine_power_wt" => array(
				"title" => esc_html__("Engine power (in watts)", 'trx_addons'),
				"desc" => wp_kses_data( __('Engine powes in watts (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"before_price" => array(
				"title" => esc_html__("Before price", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify any text to display it before the price', 'trx_addons') ),
				"class" => "trx_addons_column-1_4 trx_addons_new_row",
				"std" => "",
				"type" => "text"
			),
			"price" => array(
				"title" => esc_html__("Sale or Rent price", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify main price for this car (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),
			"price2" => array(
				"title" => esc_html__("Second price", 'trx_addons'),
				"desc" => wp_kses_data( __('Optional (rent) price (only digits)', 'trx_addons') ),
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
			"mileage" => array(
				"title" => esc_html__("Mileage", 'trx_addons'),
				"desc" => wp_kses_data( __('Mileage (only digits)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4 trx_addons_new_row",
				"std" => "",
				"type" => "text"
			),
			"mileage_prefix" => array(
				"title" => esc_html__("Mileage prefix", 'trx_addons'),
				"desc" => wp_kses_data( __('Mileage prefix (unit of measurement)', 'trx_addons') ),
				"class" => "trx_addons_column-1_4",
				"std" => "",
				"type" => "text"
			),


			"gallery_section" => array(
				"title" => esc_html__('Gallery', 'trx_addons'),
				"desc" => wp_kses_data( __('Images gallery for this car', 'trx_addons') ),
				"type" => "section"
			),
			"gallery" => array(
				"title" => esc_html__("Images gallery", 'trx_addons'),
				"desc" => wp_kses_data( __("Select images to create gallery on the single page of this car", 'trx_addons') ),
				"std" => "",
				"multiple" => true,
				"type" => "image"
			),
			"video" => array(
				"title" => esc_html__("Video", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify URL with cars video from popular video hosting (Youtube, Vimeo)', 'trx_addons') ),
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
			"attachments" => array(
				"title" => esc_html__("Attachments", 'trx_addons'),
				"desc" => wp_kses_data( __("Select additional files to attach its to this car", 'trx_addons') ),
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


			"details_section" => array(
				"title" => esc_html__('Additional features', 'trx_addons'),
				"desc" => wp_kses_data( __('Additional (custom) features for this car', 'trx_addons') ),
				"type" => "section"
			),
			"details_enable" => array(
				"title" => esc_html__("Display details", 'trx_addons'),
				"desc" => wp_kses_data( __("Show/Hide additional features on the single page with this car", 'trx_addons') ),
				"std" => "0",
				"type" => "checkbox"
			),
			"details" => array(
				"title" => esc_html__("Additional features", 'trx_addons'),
				"desc" => wp_kses_data( __("Add more features for this car by pair title-value", 'trx_addons') ),
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
						"desc" => wp_kses_data( __('Floor area size', 'trx_addons') ),
						"class" => "trx_addons_column-1_2",
						"std" => "",
						"type" => "text"
					)
				)
			),

			"contacts_section" => array(
				"title" => esc_html__('Contacts', 'trx_addons'),
				"desc" => wp_kses_data( __('City and Agent information', 'trx_addons') ),
				"type" => "section"
			),
			"agent_type" => array(
				"title" => esc_html__("Agent type", 'trx_addons'),
				"desc" => wp_kses_data( __("What display in the Agent information block: Agent, Post author or Car owner data?", 'trx_addons') ),
				"std" => "owner",
				"options" => array(
					"agent" => esc_html__('Agent', 'trx_addons'),
					"author" => esc_html__('Author', 'trx_addons'),
					"owner" => esc_html__('Car owner', 'trx_addons')
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
			),
			"owner_name" => array(
				"title" => esc_html__("Owner name", 'trx_addons'),
				"desc" => wp_kses_data( __('Name of the car owner', 'trx_addons') ),
				"dependency" => array(
					"agent_type" => array("owner")
				),
				"class" => "trx_addons_column-1_3",
				"std" => "",
				"type" => "text"
			),
			"owner_phone" => array(
				"title" => esc_html__("Owner phone", 'trx_addons'),
				"desc" => wp_kses_data( __('Phone of the car owner', 'trx_addons') ),
				"dependency" => array(
					"agent_type" => array("owner")
				),
				"class" => "trx_addons_column-1_3",
				"std" => "",
				"type" => "text"
			),
			"owner_email" => array(
				"title" => esc_html__("Owner email", 'trx_addons'),
				"desc" => wp_kses_data( __('E-mail of the car owner', 'trx_addons') ),
				"dependency" => array(
					"agent_type" => array("owner")
				),
				"class" => "trx_addons_column-1_3",
				"std" => "",
				"type" => "text"
			),
			"owner_skype" => array(
				"title" => esc_html__("Owner skype", 'trx_addons'),
				"desc" => wp_kses_data( __('Skype of the car owner', 'trx_addons') ),
				"dependency" => array(
					"agent_type" => array("owner")
				),
				"class" => "trx_addons_column-1_3",
				"std" => "",
				"type" => "text"
			)
		));
		
		// Register post type and taxonomy
		register_post_type( TRX_ADDONS_CPT_CARS_PT, array(
			'label'               => esc_html__( 'Cars', 'trx_addons' ),
			'description'         => esc_html__( 'Car Description', 'trx_addons' ),
			'labels'              => array(
				'name'                => esc_html__( 'Cars', 'trx_addons' ),
				'singular_name'       => esc_html__( 'Car', 'trx_addons' ),
				'menu_name'           => esc_html__( 'Cars', 'trx_addons' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
				'all_items'           => esc_html__( 'All Cars', 'trx_addons' ),
				'view_item'           => esc_html__( 'View Car', 'trx_addons' ),
				'add_new_item'        => esc_html__( 'Add New Car', 'trx_addons' ),
				'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
				'edit_item'           => esc_html__( 'Edit Car', 'trx_addons' ),
				'update_item'         => esc_html__( 'Update Car', 'trx_addons' ),
				'search_items'        => esc_html__( 'Search Car', 'trx_addons' ),
				'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
			),
			'taxonomies'          => array(TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE, 
										   TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS,
										   TRX_ADDONS_CPT_CARS_TAXONOMY_FEATURES,
										   TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS,
										   TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER,
										   TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL,
										   TRX_ADDONS_CPT_CARS_TAXONOMY_CITY
										   ),
			'supports'            => trx_addons_cpt_param('cars', 'supports'),
			'public'              => true,
			'hierarchical'        => false,
			'has_archive'         => true,
			'can_export'          => true,
			'show_in_admin_bar'   => true,
			'show_in_menu'        => true,
			'menu_position'       => '52.0',
			'menu_icon'			  => trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'cars/cars-icon.png'),
			'capability_type'     => 'post',
			'rewrite'             => array( 'slug' => trx_addons_cpt_param('cars', 'post_type_slug') )
			)
		);
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'Cars' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_cars_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_cars_options');
	function trx_addons_cpt_cars_options($options) {
		trx_addons_array_insert_after($options, 'cpt_section', trx_addons_cpt_cars_get_list_options());
		return $options;
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_cars_get_list_options')) {
	function trx_addons_cpt_cars_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'cars_info' => array(
				"title" => esc_html__('Cars', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the cars archive', 'trx_addons') ),
				"type" => "info"
			),
			'cars_blog_style' => array(
				"title" => esc_html__('Blog archive style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the cars archive', 'trx_addons') ),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'cars', 'arh'), 
											TRX_ADDONS_CPT_CARS_PT),
				"type" => "select"
			),
			'cars_single_style' => array(
				"title" => esc_html__('Single car style', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the single car's page", 'trx_addons') ),
				"std" => 'default',
				"options" => apply_filters('trx_addons_filter_cpt_single_styles', array(
					'default' => esc_html__('Default', 'trx_addons'),
					'tabs' => esc_html__('Tabs', 'trx_addons')
				), TRX_ADDONS_CPT_CARS_PT),
				"type" => "select"
			)
		), 'cars');
	}
}
------------------- /Old way --------------------- */


// Return list of 'transmission'
if (!function_exists('trx_addons_cpt_cars_get_list_transmission')) {
	function trx_addons_cpt_cars_get_list_transmission() {
		return apply_filters('trx_addons_filter_cars_transmission', array(
					'auto' => esc_html__('Auto', 'trx_addons'),
					'tiptronic' => esc_html__('Tiptronic', 'trx_addons'),
					'mechanics' => esc_html__('Mechanics', 'trx_addons')
				));
	}
}


// Return list of 'fuel'
if (!function_exists('trx_addons_cpt_cars_get_list_fuel')) {
	function trx_addons_cpt_cars_get_list_fuel() {
		return apply_filters('trx_addons_filter_cars_fuel', array(
					'diesel' => esc_html__('Diesel', 'trx_addons'),
					'gasoline' => esc_html__('Gasoline', 'trx_addons'),
					'gas' => esc_html__('Gas', 'trx_addons'),
					'combo_gg' => esc_html__('Combo (Gasoline + Gas)', 'trx_addons'),
					'electric' => esc_html__('Electric', 'trx_addons'),
					'hybrid_ge' => esc_html__('Hybrid (Gasoline + Electric)', 'trx_addons'),
				));
	}
}


// Return list of 'type of drive'
if (!function_exists('trx_addons_cpt_cars_get_list_type_of_drive')) {
	function trx_addons_cpt_cars_get_list_type_of_drive() {
		return apply_filters('trx_addons_filter_cars_type_of_drive', array(
					'front_wheel' => esc_html__('Front-wheel drive', 'trx_addons'),
					'rear_wheel' => esc_html__('Rear-wheel drive', 'trx_addons'),
					'all_wheel' => esc_html__('All-wheel drive', 'trx_addons')
				));
	}
}

// Fill 'options' arrays when its need in the admin mode
if (!function_exists('trx_addons_cpt_cars_before_show_options')) {
	add_filter('trx_addons_filter_before_show_options', 'trx_addons_cpt_cars_before_show_options', 10, 2);
	function trx_addons_cpt_cars_before_show_options($options, $post_type, $group='') {
		if ($post_type == TRX_ADDONS_CPT_CARS_PT) {
			foreach ($options as $id=>$field) {

				// Recursive call for options type 'group'
				if ($field['type'] == 'group' && !empty($field['fields'])) {
					$options[$id]['fields'] = trx_addons_cpt_cars_before_show_options($field['fields'], $post_type, $id);
					continue;
				}
				
				// Skip elements without param 'options'
				if (!isset($field['options']) || count($field['options'])>0) continue;


				// Fill the 'maker' array
				if ($id == 'maker') {
					$options[$id]['options'] = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER);

				// Fill the 'model' array
				} else if ($id == 'model') {
					$options[$id]['options'] = trx_addons_array_merge(
													array(esc_html__('- Model -', 'trx_addons')),
													trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL, array(
														'meta_key' => 'maker',
														'meta_value' => !empty($options['maker']['val'])
																			? $options['maker']['val']
																			: trx_addons_array_get_first($options['maker']['options'])
														)));

				// Fill the 'agent' array
				} else if ($id == 'agent') {
					$options[$id]['options'] = trx_addons_get_list_posts(false, array(
																'post_type' => TRX_ADDONS_CPT_CARS_AGENTS_PT,
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


// Save some parameters (like 'price', 'id', 'engine', etc.) for search and sorting
if ( !function_exists( 'trx_addons_cpt_cars_save_post_options' ) ) {
	add_filter('trx_addons_filter_save_post_options', 'trx_addons_cpt_cars_save_post_options', 10, 3);
	function trx_addons_cpt_cars_save_post_options($options, $post_id, $post_type) {
		if ($post_type == TRX_ADDONS_CPT_CARS_PT) {
			global $post;
			// Update post meta and post terms for search and sort
			update_post_meta($post_id, 'trx_addons_cars_price', $options['price']);
			update_post_meta($post_id, 'trx_addons_cars_engine_size', $options['engine_size']);
			update_post_meta($post_id, 'trx_addons_cars_mileage', $options['mileage']);
			update_post_meta($post_id, 'trx_addons_cars_transmission', $options['transmission']);
			update_post_meta($post_id, 'trx_addons_cars_type_drive', $options['type_drive']);
			update_post_meta($post_id, 'trx_addons_cars_fuel', $options['fuel']);
			update_post_meta($post_id, 'trx_addons_cars_id', $options['id']);
			update_post_meta($post_id, 'trx_addons_cars_owner', $options['owner_name']);
			update_post_meta($post_id, 'trx_addons_cars_owner_phone', $options['owner_phone']);
			update_post_meta($post_id, 'trx_addons_cars_owner_email', $options['owner_email']);
			update_post_meta($post_id, 'trx_addons_cars_produced', $options['produced']);
			update_post_meta($post_id, 'trx_addons_cars_agent', $options['agent_type']=='owner' 
																		? 0
																		: ($options['agent_type']=='agent'
																			? $options['agent']
																			: -get_the_author_meta('ID', !empty($post->ID) && $post->ID==$post_id
																				? $post->post_author
																				: false)
																			)
							);
			wp_set_post_terms($post_id, array((int)$options['maker']), TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER, false);
			wp_set_post_terms($post_id, array((int)$options['model']), TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL, false);
			// Update min and max values of the price, engine_size, mileage, etc.
			trx_addons_cpt_cars_update_min_max();
		}
		return $options;
	}
}


// Update min and max values of the price, engine_size, mileage, etc.
if ( !function_exists( 'trx_addons_cpt_cars_update_min_max' ) ) {
	function trx_addons_cpt_cars_update_min_max() {
		global $wpdb;
		$rez = $wpdb->get_results( "SELECT min(mileage.meta_value+0) as mileage_min, max(mileage.meta_value+0) as mileage_max,
										 min(engine_size.meta_value+0) as engine_size_min, max(engine_size.meta_value+0) as engine_size_max,
										 min(produced.meta_value+0) as produced_min, max(produced.meta_value+0) as produced_max,
										 min(price.meta_value+0.0) as price_min, max(price.meta_value+0.0) as price_max
									FROM {$wpdb->posts}
										INNER JOIN {$wpdb->postmeta} AS mileage ON {$wpdb->posts}.ID = mileage.post_id
										INNER JOIN {$wpdb->postmeta} AS engine_size ON {$wpdb->posts}.ID = engine_size.post_id
										INNER JOIN {$wpdb->postmeta} AS produced ON {$wpdb->posts}.ID = produced.post_id
										INNER JOIN {$wpdb->postmeta} AS price ON {$wpdb->posts}.ID = price.post_id
									WHERE 1=1
										AND ({$wpdb->posts}.post_status='publish')
										AND mileage.meta_key='trx_addons_cars_mileage'
										AND engine_size.meta_key='trx_addons_cars_engine_size'
										AND produced.meta_key='trx_addons_cars_produced'
										AND price.meta_key='trx_addons_cars_price'",
									ARRAY_A
									);
		update_option('trx_addons_cars_min_max', $rez[0]);
	}
}


// Return min and max values of the price and other options with limits
if ( !function_exists( 'trx_addons_cpt_cars_get_min_max' ) ) {
	function trx_addons_cpt_cars_get_min_max($key='') {
		static $min_max=false;
		if ($min_max === false)
			$min_max = array_merge(array(
									'mileage_min' => 0,
									'mileage_max' => 2000000,
									'engine_size_min' => 0,
									'engine_size_max' => 10,
									'produced_min' => date('Y') - 100,
									'produced_max' => date('Y'),
									'price_min' => 0,
									'price_max' => 1000000
									),
								get_option('trx_addons_cars_min_max', array())
								);
		return empty($key) ? $min_max : $min_max[$key];
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_cars_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_cars_load_scripts_front');
	function trx_addons_cpt_cars_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script('trx_addons-cpt_cars', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'cars/cars.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cpt_cars_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_cars_merge_styles');
	function trx_addons_cpt_cars_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'cars/_cars.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_cpt_cars_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_cpt_cars_merge_styles_responsive');
	function trx_addons_cpt_cars_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'cars/_cars.responsive.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_cpt_cars_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_cpt_cars_merge_scripts');
	function trx_addons_cpt_cars_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'cars/cars.js';
		return $list;
	}
}


// Load required styles and scripts for the backend
if ( !function_exists( 'trx_addons_cpt_cars_load_scripts_admin' ) ) {
	add_action("admin_enqueue_scripts", 'trx_addons_cpt_cars_load_scripts_admin');
	function trx_addons_cpt_cars_load_scripts_admin() {
		wp_enqueue_script('trx_addons-cpt_cars', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'cars/cars.admin.js'), array('jquery'), null, true );
	}
}


// Return true if it's cars page
if ( !function_exists( 'trx_addons_is_cars_page' ) ) {
	function trx_addons_is_cars_page() {
		return defined('TRX_ADDONS_CPT_CARS_PT') 
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_CPT_CARS_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_CARS_PT)
						|| is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE)
						|| is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS)
						|| is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_FEATURES)
						|| is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS)
						|| is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER)
						|| is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL)
						);
	}
}


// Return taxonomy for the current post type (this post_type have 2+ taxonomies)
if ( !function_exists( 'trx_addons_cpt_cars_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_cpt_cars_post_type_taxonomy', 10, 2 );
	function trx_addons_cpt_cars_post_type_taxonomy($tax='', $post_type='') {
		if ( defined('TRX_ADDONS_CPT_CARS_PT') && $post_type == TRX_ADDONS_CPT_CARS_PT )
			$tax = TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE;
		return $tax;
	}
}


// Return link to the all posts for the breadcrumbs
if ( !function_exists( 'trx_addons_cpt_cars_get_blog_all_posts_link' ) ) {
	add_filter('trx_addons_filter_get_blog_all_posts_link', 'trx_addons_cpt_cars_get_blog_all_posts_link', 10, 2);
	function trx_addons_cpt_cars_get_blog_all_posts_link($link='', $args=array()) {
		if ($link=='') {
			if (trx_addons_is_cars_page() 
				&& (!is_post_type_archive(TRX_ADDONS_CPT_CARS_PT) || (int) trx_addons_get_value_gp('compare') == 1)) {
				if (($url = get_post_type_archive_link( TRX_ADDONS_CPT_CARS_PT )) != '') {
					$obj = get_post_type_object(TRX_ADDONS_CPT_CARS_PT);
					$link = '<a href="'.esc_url($url).'">' . esc_html($obj->labels->all_items) . '</a>';
				}
			}
		}
		return $link;
	}
}


// Return current page title
if ( !function_exists( 'trx_addons_cpt_cars_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'trx_addons_cpt_cars_get_blog_title');
	function trx_addons_cpt_cars_get_blog_title($title='') {
		if ( defined('TRX_ADDONS_CPT_CARS_PT') ) {
			if ( is_post_type_archive(TRX_ADDONS_CPT_CARS_PT) ) {
				if ( (int) trx_addons_get_value_gp('compare') == 1)
					$title = esc_html__('Compare Cars', 'trx_addons');
				else {
					$obj = get_post_type_object(TRX_ADDONS_CPT_CARS_PT);
					$title = $obj->labels->all_items;
				}
			}

		}
		return $title;
	}
}


// Parse query params from GET/POST and wp_query_parameters
if ( !function_exists( 'trx_addons_cpt_cars_query_params' ) ) {
	function trx_addons_cpt_cars_query_params($params=array()) {
		$q_obj = get_queried_object();
		if ( ($value = trx_addons_get_value_gp('cars_keyword')) != '' )		$params['cars_keyword'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('cars_order')) != '' )		$params['cars_order'] = sanitize_text_field($value);
		if ( is_single() && get_post_type()==TRX_ADDONS_CPT_CARS_AGENTS_PT)	$params['cars_agent'] = (int) $q_obj->ID;
		else if ( ($value = trx_addons_get_value_gp('cars_agent')) > 0 )	$params['cars_agent'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL))					$params['cars_model'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('cars_model')) > 0 )	$params['cars_model'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER))					$params['cars_maker'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('cars_maker')) > 0 )	$params['cars_maker'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE))						$params['cars_type'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('cars_type')) > 0 )		$params['cars_type'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS))					$params['cars_status'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('cars_status')) > 0 )	$params['cars_status'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS))					$params['cars_labels'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('cars_labels')) > 0 )	$params['cars_labels'] = (int) $value;
		if ( is_tax(TRX_ADDONS_CPT_CARS_TAXONOMY_CITY))						$params['cars_city'] = (int) $q_obj->term_id;
		else if ( ($value = trx_addons_get_value_gp('cars_city')) > 0 )		$params['cars_city'] = (int) $value;
		// Single meta values
		if ( ($value = trx_addons_get_value_gp('cars_transmission')) != '')	$params['cars_transmission'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('cars_type_drive')) != '')	$params['cars_type_drive'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('cars_fuel')) != '')			$params['cars_fuel'] = sanitize_text_field($value);
		// Ranges
		if ( ($value = trx_addons_get_value_gp('cars_mileage')) != '' )		$params['cars_mileage'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('cars_engine_size')) != '' )	$params['cars_engine_size'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('cars_produced')) != '')		$params['cars_produced'] = sanitize_text_field($value);
		if ( ($value = trx_addons_get_value_gp('cars_price')) != '' )		$params['cars_price'] = sanitize_text_field($value);
		// Collect cars_features_xxx to the single param
		foreach ($_GET as $k=>$v) {
			if ( strpos($k, 'cars_features') === 0 ) {
				if (!isset($params['cars_features'])) $params['cars_features'] = array();
				$params['cars_features'][] = (int) $v;
			}
		}
		return $params;
	}
}


// Make new query to search cars or return $wp_query object if haven't search parameters
if ( !function_exists( 'trx_addons_cpt_cars_query_params_to_args' ) ) {
	function trx_addons_cpt_cars_query_params_to_args($params=array(), $new_query=false) {
		$params = trx_addons_cpt_cars_query_params($params);
		$args = $keywords = array();
		
		// Use only model or maker
		if (!empty($params['cars_model']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL, $params['cars_model']);
		else if (!empty($params['cars_maker']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER, $params['cars_maker']);

		if (!empty($params['cars_agent']))
			$args = trx_addons_query_add_meta($args, 'trx_addons_cars_agent', $params['cars_agent']);
		if (!empty($params['cars_transmission']))
			$args = trx_addons_query_add_meta($args, 'trx_addons_cars_transmission', $params['cars_transmission']);
		if (!empty($params['cars_type_drive']))
			$args = trx_addons_query_add_meta($args, 'trx_addons_cars_type_drive', $params['cars_type_drive']);
		if (!empty($params['cars_fuel']))
			$args = trx_addons_query_add_meta($args, 'trx_addons_cars_fuel', $params['cars_fuel']);
		if (!empty($params['cars_type']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE, $params['cars_type']);
		if (!empty($params['cars_status']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS, $params['cars_status']);
		if (!empty($params['cars_labels']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS, $params['cars_labels']);
		if (!empty($params['cars_city']))
			$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_CITY, $params['cars_city']);
		if (!empty($params['cars_features']))
			foreach ($params['cars_features'] as $v)
				$args = trx_addons_query_add_taxonomy($args, TRX_ADDONS_CPT_CARS_TAXONOMY_FEATURES, $v);
		if (!empty($params['cars_mileage']))
			if ($params['cars_mileage']!=trx_addons_cpt_cars_get_min_max('mileage_min').','.trx_addons_cpt_cars_get_min_max('mileage_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_cars_mileage', $params['cars_mileage']);
		if (!empty($params['cars_engine_size']))
			if ($params['cars_engine_size']!=trx_addons_cpt_cars_get_min_max('engine_size_min').','.trx_addons_cpt_cars_get_min_max('engine_size_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_cars_engine_size', $params['cars_engine_size']);
		if (!empty($params['cars_produced']))
			if ($params['cars_produced']!=trx_addons_cpt_cars_get_min_max('produced_min').','.trx_addons_cpt_cars_get_min_max('produced_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_cars_produced', $params['cars_produced']);
		if (!empty($params['cars_price']))
			if ($params['cars_price']!=trx_addons_cpt_cars_get_min_max('price_min').','.trx_addons_cpt_cars_get_min_max('price_max'))
				$args = trx_addons_query_add_meta($args, 'trx_addons_cars_price', $params['cars_price']);
		if (!empty($params['cars_keyword']))
			$keywords = array(
				'relation' => 'OR',
				array(
					'key' => 'trx_addons_cars_owner_name',
					'value' => $params['cars_keyword'],
					'type' => 'CHAR',
					'compare' => 'LIKE'
				),
				array(
					'key' => 'trx_addons_cars_owner_phone',
					'value' => $params['cars_keyword'],
					'type' => 'CHAR',
					'compare' => 'LIKE'
				),
				array(
					'key' => 'trx_addons_cars_owner_email',
					'value' => $params['cars_keyword'],
					'type' => 'CHAR',
					'compare' => 'LIKE'
				),
				array(
					'key' => 'trx_addons_cars_id',
					'value' => $params['cars_keyword'],
					'type' => 'CHAR',
					'compare' => '='
				)
			);
		if (!empty($params['cars_order'])) {
			$args['order'] = strpos($params['cars_order'], '_desc') !== false ? 'desc' : 'asc';
			$params['cars_order'] = str_replace(array('_asc', '_desc'), '' , $params['cars_order']);
			if ($params['cars_order'] == 'price') {
				$args['meta_key'] = 'trx_addons_cars_price';
				$args['orderby'] = 'meta_value_num';
			} else if (in_array($params['cars_order'], array('title', 'post_title')))
				$args['orderby'] = 'title';
			else if (in_array($params['cars_order'], array('date', 'post_date')))
				$args['orderby'] = 'date';
			else if ($params['cars_order'] == 'rand')
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
						'post_type' => TRX_ADDONS_CPT_CARS_PT,
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
if (!function_exists('trx_addons_cpt_cars_pre_get_posts')) {
	add_action( 'pre_get_posts', 'trx_addons_cpt_cars_pre_get_posts' );
	function trx_addons_cpt_cars_pre_get_posts($query) {
		if (!$query->is_main_query()) return;

		if ($query->get('post_type') == TRX_ADDONS_CPT_CARS_PT) {

			// Filters and sort for the admin lists
			if (is_admin()) {
				$agent = trx_addons_get_value_gp('agent');
				if ((int) $agent < 0)
					$query->set('post_author', -$agent);
				else { //if ((int) $agent > 0) {
					$query->set('meta_key', 'trx_addons_cars_agent');
					$query->set('meta_value', $agent);
				}

			// Filters and sort for the foreground lists
			} else {
				$args = trx_addons_cpt_cars_query_params_to_args(array(), (int) trx_addons_get_value_gp('cars_query'));
				if (is_array($args) && count($args) > 0) {
					foreach ($args as $k=>$v)
						$query->set($k, $v);
				} else if ((int) trx_addons_get_value_gp('compare') == 1) {
					$posts = array();
					$list = trx_addons_get_value_gpc('trx_addons_cars_compare_list', array());
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

// Change standard single template for cars posts
if ( !function_exists( 'trx_addons_cpt_cars_single_template' ) ) {
	add_filter('single_template', 'trx_addons_cpt_cars_single_template');
	function trx_addons_cpt_cars_single_template($template) {
		global $post;
		if (is_single() && $post->post_type == TRX_ADDONS_CPT_CARS_PT)
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.single.php');
		return $template;
	}
}

// Change standard archive template for cars posts
if ( !function_exists( 'trx_addons_cpt_cars_archive_template' ) ) {
	add_filter('archive_template',	'trx_addons_cpt_cars_archive_template');
	function trx_addons_cpt_cars_archive_template( $template ) {
		if ( is_post_type_archive(TRX_ADDONS_CPT_CARS_PT) ) {
			if ((int) trx_addons_get_value_gp('compare') == 1)
				$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.compare.php');
			else
				$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.archive.php');
		}
		return $template;
	}	
}



// Admin utils
// -----------------------------------------------------------------

// Create additional column in the posts list
if (!function_exists('trx_addons_cpt_cars_add_custom_column')) {
	add_filter('manage_edit-'.trx_addons_cpt_param('cars', 'post_type').'_columns',	'trx_addons_cpt_cars_add_custom_column', 9);
	function trx_addons_cpt_cars_add_custom_column( $columns ){
		if (is_array($columns) && count($columns)>0) {
			$new_columns = array();
			foreach($columns as $k=>$v) {
				if (!in_array($k, array('author', 'comments', 'date', 'taxonomy-'.TRX_ADDONS_CPT_CARS_TAXONOMY_CITY)))
					$new_columns[$k] = $v;
				if ($k=='title') {
					$new_columns['cpt_cars_image'] = esc_html__('Photo', 'trx_addons');
					$new_columns['cpt_cars_id'] = esc_html__('ID', 'trx_addons');
					$new_columns['taxonomy-'.TRX_ADDONS_CPT_CARS_TAXONOMY_CITY] = esc_html__('City', 'trx_addons');
				}
			}
			$new_columns['cpt_cars_price'] = esc_html__('Price', 'trx_addons');
			$new_columns['cpt_cars_details'] = esc_html__('Details', 'trx_addons');
			$columns = $new_columns;
		}
		return $columns;
	}
}

// Fill custom columns in the posts list
if (!function_exists('trx_addons_cpt_cars_fill_custom_column')) {
	add_action('manage_'.trx_addons_cpt_param('cars', 'post_type').'_posts_custom_column', 'trx_addons_cpt_cars_fill_custom_column', 9, 2);
	function trx_addons_cpt_cars_fill_custom_column($column_name='', $post_id=0) {
		static $meta_buffer = array();
		if (empty($meta_buffer[$post_id])) $meta_buffer[$post_id] = get_post_meta($post_id, 'trx_addons_options', true);
		$meta = $meta_buffer[$post_id];
		if ($column_name == 'cpt_cars_image') {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), trx_addons_get_thumb_size('masonry') );
			if (!empty($image[0])) {
				?><img class="trx_addons_cpt_column_image_preview trx_addons_cpt_cars_image_preview" 
						src="<?php echo esc_url($image[0]); ?>" 
						alt=""<?php if (!empty($image[1])) echo ' width="'.intval($image[1]).'"'; ?><?php
						if (!empty($image[2])) echo ' height="'.intval($image[2]).'"'; ?>><?php
			}
		} else if ($column_name == 'cpt_cars_id') {
			if (!empty($meta['id'])) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_data"><?php echo esc_html($meta['id']); ?></span>
				</div><?php
			}
		} else if ($column_name == 'cpt_cars_price') {
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
		} else if ($column_name == 'cpt_cars_details') {
			?><div class="trx_addons_meta_row">
				<span class="trx_addons_meta_label"><?php esc_html_e('Published', 'trx_addons'); ?></span>
				<span class="trx_addons_meta_label"><?php echo esc_html(get_the_date()); ?></span>
				<span class="trx_addons_meta_label"><?php esc_html_e('by', 'trx_addons'); ?></span>
				<span class="trx_addons_meta_label"><?php the_author(); ?></span>
			</div><?php
			if ($meta['agent_type']=='owner' && !empty($meta['owner_name'])) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_label"><?php esc_html_e('Owner', 'trx_addons'); ?></span>
					<span class="trx_addons_meta_data"><?php echo esc_html($meta['owner_name']); ?></span>
				</div><?php
				if (!empty($meta['owner_phone'])) {
					?><div class="trx_addons_meta_row">
						<span class="trx_addons_meta_label"><?php esc_html_e('Phone', 'trx_addons'); ?></span>
						<span class="trx_addons_meta_data"><?php echo esc_html($meta['owner_phone']); ?></span>
					</div><?php
				}
			} else if ($meta['agent_type']=='author' || $meta['agent']!=0) {
				?><div class="trx_addons_meta_row">
					<span class="trx_addons_meta_label"><?php esc_html_e('Agent', 'trx_addons'); ?></span>
					<span class="trx_addons_meta_data"><a href="<?php
							echo esc_url(get_admin_url(null, 'edit.php?post_type='.TRX_ADDONS_CPT_CARS_PT
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
if ( !function_exists( 'trx_addons_cpt_cars_ajax_send_sc_form' ) ) {
	// Use 9 priority to early handling action (before standard handler from shortcode 'sc_form')
	add_action('wp_ajax_send_sc_form',			'trx_addons_cpt_cars_ajax_send_sc_form', 9);
	add_action('wp_ajax_nopriv_send_sc_form',	'trx_addons_cpt_cars_ajax_send_sc_form', 9);
	function trx_addons_cpt_cars_ajax_send_sc_form() {

		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
	
		parse_str($_POST['data'], $post_data);

		if (empty($post_data['car_id'])) return;
		$car_id = (int) $post_data['car_id'];
		$car_title = !empty($car_id) ? get_the_title($car_id) : '';
		
		if (empty($post_data['car_agent'])) return;
		$agent_id = (int) $post_data['car_agent'];
		$agent_email = '';
		if ($agent_id == 0) {				// Owner
			$meta = get_post_meta($car_id, 'trx_addons_options', true);
			$agent_email = $meta['owner_email'];
		} else if ($agent_id > 0) {			// Agent
			$meta = get_post_meta($agent_id, 'trx_addons_options', true);
			$agent_email = $meta['email'];
		} else if ($agent_id < 0) {			// Author
			$user_id = abs($agent_id);
			$user_data = get_userdata($user_id);
			$agent_email = $user_data->user_email;
		}
		if (empty($agent_email)) return;
		
		$response = array('error'=>'');
		
		$user_name	= !empty($post_data['name']) ? stripslashes($post_data['name']) : '';
		$user_email	= !empty($post_data['email']) ? stripslashes($post_data['email']) : '';
		$user_phone	= !empty($post_data['phone']) ? stripslashes($post_data['phone']) : '';
		$user_msg	= !empty($post_data['message']) ? stripslashes($post_data['message']) : '';
		
		// Attention! Strings below not need html-escaping, because mail is a plain text
		$subj = $car_id > 0
					? sprintf(__('Query on car "%s" from "%s"', 'trx_addons'), $car_title, $user_name)
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


// Prepare slides with Cars data
//----------------------------------------------------------------------------
if (!function_exists('trx_addons_cpt_cars_slider_content')) {
	add_filter('trx_addons_filter_slider_content', 'trx_addons_cpt_cars_slider_content', 10, 2);
	function trx_addons_cpt_cars_slider_content($image, $args) {
		if (get_post_type() == TRX_ADDONS_CPT_CARS_PT) {
			$image['content'] = trx_addons_get_template_part_as_string(TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.slider-slide.php',
											'trx_addons_args_cars_slider_slide',
											compact('image', 'args')
										);
			$image['image'] = $image['link'] = $image['url'] = '';
		}
		return $image;
	}
}


// trx_sc_cars
//-------------------------------------------------------------
/*
[trx_sc_cars id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_cars' ) ) {
	function trx_addons_sc_cars($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_cars', $atts, array(
			// Individual params
			"type" => "default",
			"cars_maker" => '',
			"cars_model" => '',
			"cars_city" => '',
			"cars_type" => '',
			"cars_status" => '',
			"cars_labels" => '',
			"cars_price" => '',
			"cars_produced" => '',
			"cars_mileage" => '',
			"cars_engine_size" => '',
			"cars_fuel" => '',
			"cars_type_drive" => '',
			"cars_transmission" => '',
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
										TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.default.php'
										),
                                        'trx_addons_args_sc_cars',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_cars', $atts, $content);
	}
}


// Add [trx_sc_cars] in the VC shortcodes list
if (!function_exists('trx_addons_sc_cars_add_in_vc')) {
	function trx_addons_sc_cars_add_in_vc() {
		
		add_shortcode("trx_sc_cars", "trx_addons_sc_cars");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_cars", 'trx_addons_sc_cars_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Cars extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_cars_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_cars_add_in_vc_params')) {
	function trx_addons_sc_cars_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_sc_cars');
		// Prepare lists                                                          
		$maker = $vc_edit && !empty($vc_params['cars_maker']) ? $vc_params['cars_maker'] : 0;
		$model = $vc_edit && !empty($vc_params['cars_model']) ? $vc_params['cars_model'] : 0;
		// List of models
		$list_models = trx_addons_array_merge(array(0 => esc_html__('- Model -', 'trx_addons')),
										$maker == 0
											? array()
											: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL, array(
												'meta_key' => 'maker',
												'meta_value' => $maker
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
						"std" => "default",
				        'save_always' => true,
						"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'cars', 'sc'), 'trx_sc_cars')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_type",
						"heading" => esc_html__("Type", 'trx_addons'),
						"description" => wp_kses_data( __("Select the type to show cars that have it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- Type -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_maker",
						"heading" => esc_html__("Manufacturer", 'trx_addons'),
						"description" => wp_kses_data( __("Select the car's manufacturer", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_merge(array(esc_html__('- Manufacturer -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_model",
						"heading" => esc_html__("Model", 'trx_addons'),
						"description" => wp_kses_data( __("Select the car's model", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
				        'save_always' => true,
						"value" => array_flip($list_models),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_status",
						"heading" => esc_html__("Status", 'trx_addons'),
						"description" => wp_kses_data( __("Select the status to show cars that have it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"value" => array_merge(array(esc_html__('- Status -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_labels",
						"heading" => esc_html__("Label", 'trx_addons'),
						"description" => wp_kses_data( __("Select the label to show cars that have it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- Label -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_city",
						"heading" => esc_html__("City", 'trx_addons'),
						"description" => wp_kses_data( __("Select the city to show cars from it", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- City -', 'trx_addons') => 0), array_flip(trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_CITY))),
						"std" => "0",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_transmission",
						"heading" => esc_html__("Transmission", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of the transmission", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"value" => array_merge(array(esc_html__('- Transmission -', 'trx_addons') => 0), array_flip(trx_addons_cpt_cars_get_list_transmission())),
						"std" => "none",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_type_drive",
						"heading" => esc_html__("Type of drive", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of drive", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- Type drive -', 'trx_addons') => 0), array_flip(trx_addons_cpt_cars_get_list_type_of_drive())),
						"std" => "none",
						"type" => "dropdown"
					),
					array(
						"param_name" => "cars_fuel",
						"heading" => esc_html__("Fuel", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of the fuel", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_merge(array(esc_html__('- Fuel -', 'trx_addons') => 0), array_flip(trx_addons_cpt_cars_get_list_fuel())),
						"std" => "none",
						"type" => "dropdown"
					),
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
				"base" => "trx_sc_cars",
				"name" => esc_html__("Cars", 'trx_addons'),
				"description" => wp_kses_data( __("Display selected cars", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_cars',
				"class" => "trx_sc_cars",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_sc_cars' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_cars_add_in_elementor')) {
	
	// Load required styles and scripts for Elementor Editor mode
	if ( !function_exists( 'trx_addons_sc_cars_elm_editor_load_scripts' ) ) {
		add_action("elementor/editor/before_enqueue_scripts", 'trx_addons_sc_cars_elm_editor_load_scripts');
		function trx_addons_sc_cars_elm_editor_load_scripts() {
			wp_enqueue_script( 'trx_addons-sc_cars-elementor-editor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'cars/cars.elementor.editor.js'), array('jquery'), null, true );
		}
	}
	
	// Register widgets
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_cars_add_in_elementor' );
	function trx_addons_sc_cars_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Cars extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_cars';
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
				return __( 'Cars', 'trx_addons' );
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
				$maker = !empty($params['cars_maker']) ? $params['cars_maker'] : 0;
				$model = !empty($params['cars_model']) ? $params['cars_model'] : 0;
				// List of models
				$list_models = trx_addons_array_merge(array(0 => esc_html__('- Model -', 'trx_addons')),
												$maker == 0
													? array()
													: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL, array(
														'meta_key' => 'maker',
														'meta_value' => $maker
														))
												);

				$this->start_controls_section(
					'section_sc_cars',
					[
						'label' => __( 'Cars', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'cars', 'sc'), 'trx_sc_cars'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'cars_type',
					[
						'label' => __( 'Type', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Type -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE)),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_maker',
					[
						'label' => __( 'Manufacturer', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Manufacturer -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER)),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_model',
					[
						'label' => __( 'Model', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $list_models,
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_status',
					[
						'label' => __( 'Status', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Status -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS)),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_labels',
					[
						'label' => __( 'Label', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Label -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS)),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_city',
					[
						'label' => __( 'City', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- City -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_CITY)),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_transmission',
					[
						'label' => __( 'Transmission', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Transmission -', 'trx_addons')), trx_addons_cpt_cars_get_list_transmission()),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_type_drive',
					[
						'label' => __( 'Type of drive', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Type drive -', 'trx_addons')), trx_addons_cpt_cars_get_list_type_of_drive()),
						'default' => '0'
					]
				);

				$this->add_control(
					'cars_fuel',
					[
						'label' => __( 'Fuel', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Fuel -', 'trx_addons')), trx_addons_cpt_cars_get_list_fuel()),
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
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Cars() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Cars extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_cars',
				esc_html__('ThemeREX Cars', 'trx_addons'),
				array(
					'classname' => 'widget_cars',
					'description' => __('Display cars', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}

		// Return array with all widget's fields
		function get_widget_form() {
			// Prepare lists
			list($vc_edit, $vc_params) = trx_addons_get_sow_form_params('TRX_Addons_SOW_Widget_Cars');
			// Prepare lists                                                          
			$maker = $vc_edit && !empty($vc_params['cars_maker']) ? $vc_params['cars_maker'] : 0;
			$model = $vc_edit && !empty($vc_params['cars_model']) ? $vc_params['cars_model'] : 0;
			// List of models
			$list_models = trx_addons_array_merge(array(0 => esc_html__('- Model -', 'trx_addons')),
											$maker == 0
												? array()
												: trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL, array(
													'meta_key' => 'maker',
													'meta_value' => $maker
													))
											);
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'cars', 'sc'), $this->get_sc_name(), 'sow' ),
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array('type')
						),
						'type' => 'select'
					),
					"cars_type" => array(
						"label" => esc_html__("Type", 'trx_addons'),
						"description" => wp_kses_data( __("Select the type to show cars that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Type -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE)),
						"type" => "select"
					),
					"cars_maker" => array(
						"label" => esc_html__("Manufacturer", 'trx_addons'),
						"description" => wp_kses_data( __("Select the car's manufacturer", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Manufacturer -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER)),
						"type" => "select"
					),
					"cars_model" => array(
						"label" => esc_html__("Model", 'trx_addons'),
						"description" => wp_kses_data( __("Select the car's model", 'trx_addons') ),
						"default" => 0,
						"options" => $list_models,
						"type" => "select_dynamic"
					),
					"cars_status" => array(
						"label" => esc_html__("Status", 'trx_addons'),
						"description" => wp_kses_data( __("Select the status to show cars that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Status -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS)),
						"type" => "select"
					),
					"cars_labels" => array(
						"label" => esc_html__("Label", 'trx_addons'),
						"description" => wp_kses_data( __("Select the label to show cars that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Label -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_LABELS)),
						"type" => "select"
					),
					"cars_city" => array(
						"label" => esc_html__("City", 'trx_addons'),
						"description" => wp_kses_data( __("Select the city to show cars that have it", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- City -', 'trx_addons')), trx_addons_get_list_terms(false, TRX_ADDONS_CPT_CARS_TAXONOMY_CITY)),
						"type" => "select"
					),
					"cars_transmission" => array(
						"label" => esc_html__("Transmission", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of the transmission", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Transmission -', 'trx_addons')), trx_addons_cpt_cars_get_list_transmission()),
						"type" => "select"
					),
					"cars_type_drive" => array(
						"label" => esc_html__("Type of drive", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of drive", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Type drive -', 'trx_addons')), trx_addons_cpt_cars_get_list_type_of_drive()),
						"type" => "select"
					),
					"cars_fuel" => array(
						"label" => esc_html__("Fuel", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of the fuel", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0 => esc_html__('- Fuel -', 'trx_addons')), trx_addons_cpt_cars_get_list_fuel()),
						"type" => "select"
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
	siteorigin_widget_register('trx_addons_sow_widget_cars', __FILE__, 'TRX_Addons_SOW_Widget_Cars');
}


// Include additional files
// Attention! Must be included after the post type 'Cars' registration
//----------------------------------------------------------------------------
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_type.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_status.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_maker.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_model.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_features.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_labels.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.taxonomy_city.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/cars.agents.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/widget.cars_compare.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/widget.cars_sort.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "cars/widget.cars_search.php")) != '') { include_once $fdir; }
?>