<?php
/**
 * ThemeREX Addons Custom post types
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Define list with CPT
if (!function_exists('trx_addons_cpt_setup')) {
	add_action( 'after_setup_theme', 'trx_addons_cpt_setup', 2 );
	function trx_addons_cpt_setup() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['cpt_resume_types'] = apply_filters('trx_addons_cpt_resume_types', array(
			'skills' => esc_html__('Skills', 'trx_addons'),
			'work' => esc_html__('Work experience', 'trx_addons'),
			'education' => esc_html__('Education', 'trx_addons'),
			'services' => esc_html__('Services', 'trx_addons')
		) );
		$TRX_ADDONS_STORAGE['cpt_list'] = apply_filters('trx_addons_cpt_list', array(
			'cars' => array(
				'title' => esc_html__('Cars', 'trx_addons'),
				'post_type' => 'cpt_cars',
				'post_type_slug' => 'cars',
				'taxonomy_type' => 'cpt_cars_type',
				'taxonomy_type_slug' => 'cars_type',
				'taxonomy_status' => 'cpt_cars_status',
				'taxonomy_status_slug' => 'cars_status',
				'taxonomy_maker' => 'cpt_cars_maker',
				'taxonomy_maker_slug' => 'cars_maker',
				'taxonomy_model' => 'cpt_cars_model',
				'taxonomy_model_slug' => 'cars_model',
				'taxonomy_features' => 'cpt_cars_features',
				'taxonomy_features_slug' => 'cars_features',
				'taxonomy_labels' => 'cpt_cars_labels',
				'taxonomy_labels_slug' => 'cars_labels',
				'taxonomy_city' => 'cpt_cars_city',
				'taxonomy_city_slug' => 'cars_city',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_1' => esc_html__('Default /1 column/', 'trx_addons'),
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'slider' => esc_html__('Slider', 'trx_addons')
					)
				),
				'cars_agents' => array(
					'slave' => true,	// Additional post type for the 'cars'
					'title' => esc_html__('Cars Agents', 'trx_addons'),
					'post_type' => 'cpt_cars_agents',
					'post_type_slug' => 'cars_agents',
					'taxonomy' => 'cpt_cars_agency',
					'taxonomy_slug' => 'cars_agency',
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
					),
			'certificates' => array(
				'title' => esc_html__('Certificates', 'trx_addons'),
				'post_type' => 'cpt_certificates',
				'post_type_slug' => 'certificates',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')
				),
			'courses' => array(
				'title' => esc_html__('Courses', 'trx_addons'),
				'post_type' => 'cpt_courses',
				'post_type_slug' => 'courses',
				'taxonomy' => 'cpt_courses_group',
				'taxonomy_slug' => 'courses_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons')
					)
				),
			'dishes' => array(
				'title' => esc_html__('Dishes', 'trx_addons'),
				'post_type' => 'cpt_dishes',
				'post_type_slug' => 'dishes',
				'taxonomy' => 'cpt_dishes_group',
				'taxonomy_slug' => 'dishes_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'float' => esc_html__('Float', 'trx_addons'),
					'compact' => esc_html__('Compact', 'trx_addons')
					)
				),
			'layouts' => array(
				'title' => esc_html__('Layouts', 'trx_addons'),
				'post_type' => 'cpt_layouts',
				'post_type_slug' => 'layouts',
				'taxonomy' => 'cpt_layouts_group',
				'taxonomy_slug' => 'layouts_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
				'layouts_sc' => array(
					'cart' => esc_html__('Cart', 'trx_addons'),
					'container' => esc_html__('Container', 'trx_addons'),
					'currency' => esc_html__('Currency switcher', 'trx_addons'),
					'featured' => esc_html__('Featured image', 'trx_addons'),
					'iconed_text' => esc_html__('Iconed text', 'trx_addons'),
					'layouts' => esc_html__('Insert layout', 'trx_addons'),
					'language' => esc_html__('Language selector', 'trx_addons'),
					'login' => esc_html__('Login and Register', 'trx_addons'),
					'logo' => esc_html__('Logo', 'trx_addons'),
					'menu' => esc_html__('Menu', 'trx_addons'),
					'search' => esc_html__('Search', 'trx_addons'),
					'title' => esc_html__('Title', 'trx_addons'),
					'widgets' => esc_html__('Widgets', 'trx_addons')
					),
				// Always enabled!!!
				'std' => 1,
				'hidden' => false
				),
			'portfolio' => array(
				'title' => esc_html__('Portfolio', 'trx_addons'),
				'post_type' => 'cpt_portfolio',
				'post_type_slug' => 'portfolio',
				'taxonomy' => 'cpt_portfolio_group',
				'taxonomy_slug' => 'portfolio_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'simple' => esc_html__('Simple', 'trx_addons')
					)
				),
			'post' => array(
				'title' => esc_html__('Post', 'trx_addons'),
				// Always enabled!!!
				'std' => 1,
				'hidden' => true
				),
			'properties' => array(
				'title' => esc_html__('Properties', 'trx_addons'),
				'post_type' => 'cpt_properties',
				'post_type_slug' => 'properties',
				'taxonomy_type' => 'cpt_properties_type',
				'taxonomy_type_slug' => 'properties_type',
				'taxonomy_status' => 'cpt_properties_status',
				'taxonomy_status_slug' => 'properties_status',
				'taxonomy_features' => 'cpt_properties_features',
				'taxonomy_features_slug' => 'properties_features',
				'taxonomy_labels' => 'cpt_properties_labels',
				'taxonomy_labels_slug' => 'properties_labels',
				'taxonomy_country' => 'cpt_properties_country',
				'taxonomy_country_slug' => 'properties_country',
				'taxonomy_state' => 'cpt_properties_state',
				'taxonomy_state_slug' => 'properties_state',
				'taxonomy_city' => 'cpt_properties_city',
				'taxonomy_city_slug' => 'properties_city',
				'taxonomy_neighborhood' => 'cpt_properties_neighborhood',
				'taxonomy_neighborhood_slug' => 'properties_neighborhood',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_1' => esc_html__('Default /1 column/', 'trx_addons'),
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'slider' => esc_html__('Slider', 'trx_addons'),
					'googlemap' => esc_html__('Google map', 'trx_addons')
					)
				),
				'agents' => array(
					'slave' => true,	// Additional post type for the 'properties'
					'title' => esc_html__('Agents', 'trx_addons'),
					'post_type' => 'cpt_agents',
					'post_type_slug' => 'agents',
					'taxonomy' => 'cpt_agency',
					'taxonomy_slug' => 'agency',
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
					),
			'resume' => array(
				'title' => esc_html__('Resume', 'trx_addons'),
				'post_type' => 'cpt_resume',
				'post_type_slug' => 'resume',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')
				),
			'services' => array(
				'title' => esc_html__('Services', 'trx_addons'),
				'post_type' => 'cpt_services',
				'post_type_slug' => 'services',
				'taxonomy' => 'cpt_services_group',
				'taxonomy_slug' => 'services_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons'),
					'light_2'   => esc_html__('Light /2 columns/', 'trx_addons'),
					'light_3'   => esc_html__('Light /3 columns/', 'trx_addons'),
					'callouts_2'=> esc_html__('Callouts /2 columns/', 'trx_addons'),
					'callouts_3'=> esc_html__('Callouts /3 columns/', 'trx_addons'),
					'chess_1'   => esc_html__('Chess /2 columns/', 'trx_addons'),
					'chess_2'   => esc_html__('Chess /4 columns/', 'trx_addons'),
					'chess_3'   => esc_html__('Chess /6 columns/', 'trx_addons'),
					'hover_2'   => esc_html__('Hover /2 columns/', 'trx_addons'),
					'hover_3'   => esc_html__('Hover /3 columns/', 'trx_addons'),
					'iconed_2'  => esc_html__('Iconed /2 columns/', 'trx_addons'),
					'iconed_3'  => esc_html__('Iconed /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'light' => esc_html__('Light', 'trx_addons'),
					'iconed' => esc_html__('Iconed', 'trx_addons'),
					'callouts' => esc_html__('Callouts', 'trx_addons'),
					'list' => esc_html__('List', 'trx_addons'),
					'hover' => esc_html__('Hover', 'trx_addons'),
					'chess' => esc_html__('Chess', 'trx_addons'),
					'timeline' => esc_html__('Timeline', 'trx_addons'),
					'tabs' => esc_html__('Tabs', 'trx_addons'),
					'tabs_simple' => esc_html__('Tabs (simple)', 'trx_addons')
					),
				// Always enabled!!!
				'std' => 1,
				'hidden' => false
				),
			'sport' => array(
				'title' => esc_html__('Sport Reviews', 'trx_addons'),
				'layouts_arh' => array(
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					)
				),
				'competitions' => array(
					'slave' => true,	// Additional post type for the 'sport'
					'title' => esc_html__('Competitions', 'trx_addons'),
					'post_type' => 'cpt_competitions',
					'post_type_slug' => 'competitions',
					'taxonomy' => 'cpt_competitions_sports',
					'taxonomy_slug' => 'sports',
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
					),
				'rounds' => array(
					'slave' => true,	// Additional post type for the 'sport'
					'title' => esc_html__('Rounds', 'trx_addons'),
					'post_type' => 'cpt_rounds',
					'post_type_slug' => 'rounds',
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
					),
				'matches' => array(
					'slave' => true,	// Additional post type for the 'sport'
					'title' => esc_html__('Matches', 'trx_addons'),
					'post_type' => 'cpt_matches',
					'post_type_slug' => 'matches',
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
					),
				'players' => array(
					'slave' => true,	// Additional post type for the 'sport'
					'title' => esc_html__('Players', 'trx_addons'),
					'post_type' => 'cpt_players',
					'post_type_slug' => 'players',
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields')
					),
			'team' => array(
				'title' => esc_html__('Team', 'trx_addons'),
				'post_type' => 'cpt_team',
				'post_type_slug' => 'team',
				'taxonomy' => 'cpt_team_group',
				'taxonomy_slug' => 'team_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
				'layouts_arh' => array(
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
					),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'short' => esc_html__('Short', 'trx_addons'),
					'featured' => esc_html__('Featured', 'trx_addons')
					),
				// Always enabled!!!
				'std' => 1,
				'hidden' => false
				),
			'testimonials' => array(
				'title' => esc_html__('Testimonials', 'trx_addons'),
				'post_type' => 'cpt_testimonials',
				'post_type_slug' => 'testimonials',
				'taxonomy' => 'cpt_testimonials_group',
				'taxonomy_slug' => 'testimonials_group',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
				'layouts_sc' => array(
					'default' => esc_html__('Default', 'trx_addons'),
					'simple' => esc_html__('Simple', 'trx_addons')
					),
				// Always enabled!!!
				'std' => 1,
				'hidden' => false
				)
			)
		);
		/* ------------------- Old way ---------------------
		// Load CPT
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt=>$params) {
				if ( empty($params['preloaded']) && empty($params['slave'])
					&& trx_addons_components_is_allowed('cpt', $cpt)
					&& (($fdir = !empty($params['fdir']) ? $params['fdir'] : '') != ''
						||
						($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "{$cpt}/{$cpt}.php")) != '')) {
					include_once $fdir;
				}
			}
		}
		------------------- /Old way --------------------- */

		/* ------------------------ New way -------------- */
		// Pre load CPT: Check if components are allowed and define constants
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			$last_allowed = false;
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt=>$params) {
				$allowed = trx_addons_components_is_allowed('cpt', $cpt);
				if (empty($params['slave'])) $last_allowed = $allowed;
				if ( empty($params['preloaded'])
					&& ((!empty($params['slave']) && $last_allowed)
						|| ($allowed && ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "{$cpt}/{$cpt}.php")) != ''))) { 
					// Store file location
					if (!empty($fdir))
						$TRX_ADDONS_STORAGE['cpt_list'][$cpt]['fdir'] = $fdir;
					// Define constant with post_type
					if (!empty($params['post_type'])) {
						$const = 'TRX_ADDONS_CPT_'.strtoupper($cpt).'_PT';
						if ( ! defined($const) )
							define($const, $params['post_type']);
					}
					// Define constant with taxonomy
					if (!empty($params['taxonomy'])) {
						$const = 'TRX_ADDONS_CPT_'.strtoupper($cpt).'_TAXONOMY';
						if ( ! defined($const) )
							define($const, $params['taxonomy']);
					}
				}
			}
		}
		/* ------------------------ /New way -------------- */
	}
}

/* ------------------------ New way --------------------- */

// Include files with CPT
if (!function_exists('trx_addons_cpt_load')) {
	add_action( 'after_setup_theme', 'trx_addons_cpt_load', 6 );
	function trx_addons_cpt_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt=>$params) {
				if ( empty($params['preloaded']) && empty($params['slave'])
					&& trx_addons_components_is_allowed('cpt', $cpt)
					&& trx_addons_is_off(trx_addons_get_option($cpt.'_disable', 0, false))
					&& (($fdir = !empty($params['fdir']) ? $params['fdir'] : '') != ''
						||
						($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "{$cpt}/{$cpt}.php")) != '')) {
					include_once $fdir;
				}
			}
		}
	}
}
/* ------------------------ /New way --------------------- */


// Add 'CPT' block to the ThemeREX Addons Components
if (!function_exists('trx_addons_cpt_components')) {
	add_filter( 'trx_addons_filter_components_blocks', 'trx_addons_cpt_components');
	function trx_addons_cpt_components($blocks=array()) {
		$blocks['cpt'] = __('Custom Post Types', 'trx_addons');
		return $blocks;
	}
}



// Return list of the allowed CPT
if (!function_exists('trx_addons_get_cpt_list')) {
	function trx_addons_get_cpt_list() {
		global $TRX_ADDONS_STORAGE;
		$list = array();
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt => $params) {
				if (!empty($params['post_type'])) $list[$params['post_type']] = $params['title'];
			}
		}
		return $list;
	}
}

// Return param's value from the CPT definition
if (!function_exists('trx_addons_cpt_param')) {
	function trx_addons_cpt_param($cpt='', $param='') {
		global $TRX_ADDONS_STORAGE;
		$rez = '';
		if (!empty($TRX_ADDONS_STORAGE['cpt_list'][$cpt]))
			$rez = $TRX_ADDONS_STORAGE['cpt_list'][$cpt][$param];
		else {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $slug => $params) {
				if (!empty($params['post_type']) && $params['post_type'] == $cpt) {
					$rez = $params[$param];
					break;
				}
			}
		}
		return $rez;
	}
}


// Add 'CPT' section in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_options');
	function trx_addons_cpt_options($options) {
		// Add section 'CPT'
		trx_addons_array_insert_before($options, 'api_section', array(
			'cpt_section' => array(
				"title" => esc_html__('CPT', 'trx_addons'),
				"desc" => wp_kses_data( __('CPT (Custom Post Types) options', 'trx_addons') ),
				"type" => "section"
			)
		));
/* ------------------------ New way --------------------- */
		// Add CPT options
		global $TRX_ADDONS_STORAGE;
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt=>$params) {
				if ( !empty($params['post_type']) && !defined('TRX_ADDONS_CPT_'.strtoupper($cpt).'_PT') )
					continue;
				$func = "trx_addons_cpt_{$cpt}_get_list_options";
				if (function_exists($func)) {
					trx_addons_array_insert_after($options,
												$cpt=='layouts' ? 'theme_specific_section' : 'cpt_section',
												call_user_func($func)
												);
				}
			}
		}
/* ------------------------ /New way --------------------- */
		return $options;
	}
}



/* ------------------------ New way --------------------- */

// Parameters in the ThemeREX Addons options - Section CPT
//-----------------------------------------------------------------

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_cars_get_list_options')) {
	function trx_addons_cpt_cars_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'cars_info' => array(
				"title" => esc_html__('Cars', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the cars archive', 'trx_addons') ),
				"type" => "info"
			),
			'cars_disable' => array(
				"title" => esc_html__('Disable post type "Cars"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'cars_blog_style' => array(
				"title" => esc_html__('Blog archive style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the cars archive', 'trx_addons') ),
				"dependency" => array(
					"cars_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'cars', 'arh'), 
											TRX_ADDONS_CPT_CARS_PT),
				"type" => "select"
			),
			'cars_single_style' => array(
				"title" => esc_html__('Single car style', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the single car's page", 'trx_addons') ),
				"dependency" => array(
					"cars_disable" => array(0)
				),
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

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_cars_agents_get_list_options')) {
	function trx_addons_cpt_cars_agents_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'cars_agents_info' => array(
				"title" => esc_html__('Cars agents', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the cars agents profile', 'trx_addons') ),
				"dependency" => array(
					"cars_disable" => array(0)
				),
				"type" => "info"
			),
			'cars_agents_style' => array(
				"title" => esc_html__('Style of the archive', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the agents archive", 'trx_addons') ),
				"dependency" => array(
					"cars_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', array(
					'default_1' => esc_html__('Default /1 column/', 'trx_addons'),
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
				), TRX_ADDONS_CPT_CARS_AGENTS_PT),
				"type" => "select"
			),
			'cars_agents_list_style' => array(
				"title" => esc_html__('Style of the cars list', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the cars archive on the Agent's profile page", 'trx_addons') ),
				"dependency" => array(
					"cars_disable" => array(0)
				),
				"std" => 'default_3',
				"options" => apply_filters('trx_addons_filter_cpt_single_styles', array(
					'default_1' => esc_html__('Default /1 column/', 'trx_addons'),
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
				), TRX_ADDONS_CPT_CARS_AGENTS_PT),
				"type" => "select"
			)
		), 'cars_agents');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_certificates_get_list_options')) {
	function trx_addons_cpt_certificates_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'certificates_info' => array(
				"title" => esc_html__('Certificates', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the post type "Certificates"', 'trx_addons') ),
				"type" => "info"
			),
			'certificates_disable' => array(
				"title" => esc_html__('Disable post type "Certificates"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			)
		), 'certificates');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_courses_get_list_options')) {
	function trx_addons_cpt_courses_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'courses_info' => array(
				"title" => esc_html__('Courses', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the courses archive', 'trx_addons') ),
				"type" => "info"
			),
			'courses_disable' => array(
				"title" => esc_html__('Disable post type "Courses"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'courses_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the courses archive', 'trx_addons') ),
				"dependency" => array(
					"courses_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'courses', 'arh'),
											TRX_ADDONS_CPT_COURSES_PT),
				"type" => "select"
			)
		), 'courses');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_dishes_get_list_options')) {
	function trx_addons_cpt_dishes_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'dishes_info' => array(
				"title" => esc_html__('Dishes', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the dishes archive', 'trx_addons') ),
				"type" => "info"
			),
			'dishes_disable' => array(
				"title" => esc_html__('Disable post type "Dishes"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'dishes_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the dishes archive', 'trx_addons') ),
				"dependency" => array(
					"dishes_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'dishes', 'arh'),
											TRX_ADDONS_CPT_DISHES_PT),
				"type" => "select"
			)
		), 'dishes');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_layouts_get_list_options')) {
	function trx_addons_cpt_layouts_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			// Layouts settings
			'layouts_info' => array(
				"title" => esc_html__('Custom Layouts', 'trx_addons'),
				"desc" => wp_kses_data( __('Create theme-specific custom layouts (headers, footers, etc.)', 'trx_addons') ),
				"type" => "info"
			),
			'layouts_create' => array(
				"title" => esc_html__('Create Layouts', 'trx_addons'),
				"desc" => wp_kses_data( __('Press button above to create set of layouts, prepared with this theme. Attention! If a post with the same name exist - it is skipped!', 'trx_addons') ),
				"std" => 'trx_addons_cpt_layouts_create',
				"type" => "button"
			)
		), 'layouts');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_portfolio_get_list_options')) {
	function trx_addons_cpt_portfolio_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'portfolio_info' => array(
				"title" => esc_html__('Portfolio', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the portfolio archive', 'trx_addons') ),
				"type" => "info"
			),
			'portfolio_disable' => array(
				"title" => esc_html__('Disable post type "Portfolio"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'portfolio_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the portfolio archive', 'trx_addons') ),
				"dependency" => array(
					"portfolio_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'portfolio', 'arh'),
											TRX_ADDONS_CPT_PORTFOLIO_PT),
				"type" => "select"
			)
		), 'portfolio');
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
			'properties_disable' => array(
				"title" => esc_html__('Disable post type "Properties"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'properties_blog_style' => array(
				"title" => esc_html__('Blog archive style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the properties archive', 'trx_addons') ),
				"dependency" => array(
					"properties_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'properties', 'arh'), 
											TRX_ADDONS_CPT_PROPERTIES_PT),
				"type" => "select"
			),
			'properties_single_style' => array(
				"title" => esc_html__('Single property style', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the single property's page", 'trx_addons') ),
				"dependency" => array(
					"properties_disable" => array(0)
				),
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
				"dependency" => array(
					"properties_disable" => array(0)
				),
				"std" => '',
				"type" => "image"
			)
		), 'properties');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_agents_get_list_options')) {
	function trx_addons_cpt_agents_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'agents_info' => array(
				"title" => esc_html__('Agents', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the agents profile', 'trx_addons') ),
				"dependency" => array(
					"properties_disable" => array(0)
				),
				"type" => "info"
			),
			'agents_style' => array(
				"title" => esc_html__('Style of the archive', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the agents archive", 'trx_addons') ),
				"dependency" => array(
					"properties_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', array(
					'default_1' => esc_html__('Default /1 column/', 'trx_addons'),
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
				), TRX_ADDONS_CPT_AGENTS_PT),
				"type" => "select"
			),
			'agents_properties_style' => array(
				"title" => esc_html__('Style of the properties', 'trx_addons'),
				"desc" => wp_kses_data( __("Style of the properties archive on the Agent's profile page", 'trx_addons') ),
				"dependency" => array(
					"properties_disable" => array(0)
				),
				"std" => 'default_3',
				"options" => apply_filters('trx_addons_filter_cpt_single_styles', array(
					'default_1' => esc_html__('Default /1 column/', 'trx_addons'),
					'default_2' => esc_html__('Default /2 columns/', 'trx_addons'),
					'default_3' => esc_html__('Default /3 columns/', 'trx_addons')
				), TRX_ADDONS_CPT_AGENTS_PT),
				"type" => "select"
			)
		), 'agents');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_resume_get_list_options')) {
	function trx_addons_cpt_resume_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'resume_info' => array(
				"title" => esc_html__('Resume', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the post type "Resume"', 'trx_addons') ),
				"type" => "info"
			),
			'resume_disable' => array(
				"title" => esc_html__('Disable post type "Resume"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			)
		), 'resume');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_services_get_list_options')) {
	function trx_addons_cpt_services_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'services_info' => array(
				"title" => esc_html__('Services', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the services archive', 'trx_addons') ),
				"type" => "info"
			),
			'services_disable' => array(
				"title" => esc_html__('Disable post type "Services"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'services_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the services archive', 'trx_addons') ),
				"dependency" => array(
					"services_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'services', 'arh'),
											TRX_ADDONS_CPT_SERVICES_PT),
				"type" => "select"
			),
			'services_add_contact_form' => array(
				"title" => esc_html__('Add contact form to the single service', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you want to add contacts form to the single post", 'trx_addons') ),
				"std" => 1,
				"type" => "checkbox"
			),
            'services_add_contact_form_7' => array(
                "title" => esc_html__('Add Contact Form 7 to the single service', 'trx_addons'),
                "desc" => wp_kses_data( __("Add shortcode Contact Form 7 if you want to add contacts form to the single post", 'trx_addons') ),
                "dependency" => array(
                    "services_add_contact_form" => array(0)
                ),
                "std" => '',
                "type" => "text"
            ),
		), 'services');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_sport_get_list_options')) {
	function trx_addons_cpt_sport_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'sport_info' => array(
				"title" => esc_html__('Sport', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the sport reviews system', 'trx_addons') ),
				"type" => "info"
			),
			'sport_disable' => array(
				"title" => esc_html__('Disable post type "Sport"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'sport_favorite' => array(
				"title" => esc_html__('Default sport', 'trx_addons'),
				"desc" => wp_kses_data( __('Select default sport for the shortcodes editor', 'trx_addons') ),
				"dependency" => array(
					"sport_disable" => array(0)
				),
				"std" => '',
				"options" => is_admin() 
								// Use trx_addons_cpt_param() instead constant,
								// because this function was called before the constant is created
								? trx_addons_get_list_terms(false, trx_addons_cpt_param('competitions', 'taxonomy'))	//TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY)
								: array(),
				"type" => "select"
			),
			'competitions_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the competitions archive', 'trx_addons') ),
				"dependency" => array(
					"sport_disable" => array(0)
				),
				"std" => 'default_3',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'sport', 'arh'), 
											// Use trx_addons_cpt_param() instead constant,
											// because this function was called before the constant is created
											trx_addons_cpt_param('competitions', 'post_type')),	//TRX_ADDONS_CPT_COMPETITIONS_PT),
				"type" => "select"
			)
		), 'sport');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_team_get_list_options')) {
	function trx_addons_cpt_team_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'team_info' => array(
				"title" => esc_html__('Team', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the team members archive', 'trx_addons') ),
				"type" => "info"
			),
			'team_disable' => array(
				"title" => esc_html__('Disable post type "Team"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			),
			'team_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the team archive', 'trx_addons') ),
				"dependency" => array(
					"team_disable" => array(0)
				),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'team', 'arh'),
											TRX_ADDONS_CPT_TEAM_PT),
				"type" => "select"
			)
		), 'team');
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_testimonials_get_list_options')) {
	function trx_addons_cpt_testimonials_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'testimonials_info' => array(
				"title" => esc_html__('Testimonials', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the post type "Testimonials"', 'trx_addons') ),
				"type" => "info"
			),
			'testimonials_disable' => array(
				"title" => esc_html__('Disable post type "Testimonials"', 'trx_addons'),
				"desc" => wp_kses_data( __("Check if you don't use this post type", 'trx_addons') ),
				"std" => 0,
				"type" => "checkbox"
			)
		), 'testimonials');
	}
}
/* ------------------------ /New way --------------------- */
?>