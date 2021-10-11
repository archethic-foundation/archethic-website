<?php
/**
 * ThemeREX Addons: Sports Reviews Management (SRM). Support different sports, championships, rounds, matches and players.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.17
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "sport/sport.competitions.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "sport/sport.rounds.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "sport/sport.matches.php")) != '') { include_once $fdir; }
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . "sport/sport.players.php")) != '') { include_once $fdir; }

// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Add Admin menu item to show Sports management panel
if (!function_exists('trx_addons_cpt_sport_admin_menu')) {
	add_action( 'admin_menu', 'trx_addons_cpt_sport_admin_menu' );
	function trx_addons_cpt_sport_admin_menu() {
		add_menu_page(
			esc_html__('Sport', 'trx_addons'),	//page_title
			esc_html__('Sport', 'trx_addons'),	//menu_title
			'edit_posts',						//capability
			'trx_addons_sport',					//menu_slug
			'trx_addons_sport_page',			//callback
			'dashicons-universal-access',		//icon
			'53.7'								//menu position
		);
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'Sport' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_sport_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_sport_options');
	function trx_addons_cpt_sport_options($options) {
		trx_addons_array_insert_after($options, 'cpt_section', trx_addons_cpt_sport_get_list_options());
		return $options;
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
			'sport_favorite' => array(
				"title" => esc_html__('Default sport', 'trx_addons'),
				"desc" => wp_kses_data( __('Select default sport for the shortcodes editor', 'trx_addons') ),
				"std" => '',
				"options" => is_admin() ? trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY) : array(),
				"type" => "select"
			),
			'competitions_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the competitions archive', 'trx_addons') ),
				"std" => 'default_3',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'sport', 'arh'), 
											TRX_ADDONS_CPT_COMPETITIONS_PT),
				"type" => "select"
			)
		), 'sport');
	}
}
------------------- /Old way --------------------- */


// Return true if it's sport page
if ( !function_exists( 'trx_addons_is_sport_page' ) ) {
	function trx_addons_is_sport_page() {
		return defined('TRX_ADDONS_CPT_COMPETITIONS_PT') 
					&& !is_search()
					&& (
						(is_single() && in_array(get_post_type(), array(TRX_ADDONS_CPT_COMPETITIONS_PT,
																		TRX_ADDONS_CPT_ROUNDS_PT,
																		TRX_ADDONS_CPT_PLAYERS_PT,
																		TRX_ADDONS_CPT_MATCHES_PT)))
						|| is_post_type_archive(TRX_ADDONS_CPT_MATCHES_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_PLAYERS_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_ROUNDS_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_COMPETITIONS_PT)
						|| is_tax(TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY)
						);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_sport_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_sport_load_scripts_front');
	function trx_addons_cpt_sport_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script('trx_addons-cpt_sport', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'sport/sport.js'), array('jquery'), null, true );
		}
	}
}


// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cpt_sport_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_sport_merge_styles');
	function trx_addons_cpt_sport_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'sport/_sport.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_cpt_sport_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_cpt_sport_merge_styles_responsive');
	function trx_addons_cpt_sport_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'sport/_sport.responsive.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_cpt_sport_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_cpt_sport_merge_scripts');
	function trx_addons_cpt_sport_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'sport/sport.js';
		return $list;
	}
}


// Load required styles and scripts for the backend
if ( !function_exists( 'trx_addons_cpt_sport_load_scripts_admin' ) ) {
	add_action("admin_enqueue_scripts", 'trx_addons_cpt_sport_load_scripts_admin');
	function trx_addons_cpt_sport_load_scripts_admin() {
		wp_enqueue_script('trx_addons-cpt_sport', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'sport/sport.admin.js'), array('jquery'), null, true );
	}
}


// Admin utils
// -----------------------------------------------------------------

// Add query vars to filter posts
if (!function_exists('trx_addons_cpt_sport_pre_get_posts')) {
	add_action( 'pre_get_posts', 'trx_addons_cpt_sport_pre_get_posts' );
	function trx_addons_cpt_sport_pre_get_posts($query) {
		if (!$query->is_main_query()) return;
		$post_type = $query->get('post_type');
		// Filters and sort for the admin lists
		if (is_admin()) {
			$orderby = trx_addons_get_value_gp('orderby');
			$order = trx_addons_get_value_gp('order');
			if ($post_type == TRX_ADDONS_CPT_COMPETITIONS_PT) {
				// Sort competitions by start date
				if (empty($orderby) || $orderby=='trx_addons_competition_date') {
					$query->set('meta_key', 'trx_addons_competition_date');
					$query->set('orderby', 'meta_value');
					$query->set('order', $order == 'desc' ? 'DESC' : 'ASC');
				}
			} else if (in_array($post_type, array(TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_PLAYERS_PT))) {
				$competition = trx_addons_get_value_gp('competition');
				if ((int) $competition > 0) {
					//$query->set('meta_key', 'trx_addons_competition');
					//$query->set('meta_value', $competition);
					$query->set('post_parent', $competition);
					// Sort rounds by start date
					if ($post_type==TRX_ADDONS_CPT_ROUNDS_PT) {
						if (empty($orderby) || $orderby=='trx_addons_round_date') {
							$query->set('meta_key', 'trx_addons_round_date');
							$query->set('orderby', 'meta_value');
							$query->set('order', $order == 'desc' ? 'DESC' : 'ASC');
						}
					// Sort players
					} else {
						if (empty($orderby) || $orderby=='trx_addons_player_points') {
							$query->set('meta_key', 'trx_addons_player_points');
							$query->set('orderby', 'meta_value');
							$query->set('order', $order == 'asc' ? 'ASC' : 'DESC');
						}
					}
				}
			} else if ($post_type == TRX_ADDONS_CPT_MATCHES_PT) {
				$round = trx_addons_get_value_gp('round');
				if ((int) $round > 0) {
					//$query->set('meta_key', 'trx_addons_round');
					//$query->set('meta_value', $round);
					$query->set('post_parent', $round);
					// Sort matches by start date
					if (empty($orderby) || $orderby=='trx_addons_match_date') {
						$query->set('meta_key', 'trx_addons_match_date');
						$query->set('orderby', 'meta_value');
						$query->set('order', $order == 'desc' ? 'DESC' : 'ASC');
					}
				}
				
			}

		// Filters and sort for the foreground lists
		} else {
			if ($post_type == TRX_ADDONS_CPT_COMPETITIONS_PT) {
				$sport = trx_addons_get_value_gp('sport');
				// Filter competitions by sport
				if (!empty($sport)) {
				}
				$query->set('meta_key', 'trx_addons_competition_date');
				$query->set('orderby', 'meta_value');
				$query->set('order', 'ASC');
			} else if (in_array($post_type, array(TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_PLAYERS_PT))) {
				$competition = trx_addons_get_value_gp('competition');
				// Filter rounds and players by competition
				if ((int) $competition > 0) {
					$query->set('post_parent', $competition);
					// Sort rounds by start date
					if ($post_type==TRX_ADDONS_CPT_ROUNDS_PT) {
						$query->set('meta_key', 'trx_addons_round_date');
						$query->set('orderby', 'meta_value');
						$query->set('order', 'ASC');
					// Sort players
					} else {
						$query->set('meta_key', 'trx_addons_player_points');
						$query->set('orderby', 'meta_value');
						$query->set('order', 'DESC');
					}
				}
			} else if ($post_type == TRX_ADDONS_CPT_MATCHES_PT) {
				$round = trx_addons_get_value_gp('round');
				if ((int) $round > 0) {
					$query->set('post_parent', $round);
					$query->set('meta_key', 'trx_addons_match_date');
					$query->set('orderby', 'meta_value');
					$query->set('order', 'ASC');
				}
			}
		}
	}
}

// Show breadcrumbs in the admin notices
if ( !function_exists( 'trx_addons_cpt_sport_admin_notice' ) ) {
	add_action('admin_notices', 'trx_addons_cpt_sport_admin_notice', 1);
	function trx_addons_cpt_sport_admin_notice() {
		if (in_array(trx_addons_get_value_gp('action'), array('vc_load_template_preview'))) return;
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (!is_object($screen) || !in_array($screen->post_type, array(TRX_ADDONS_CPT_COMPETITIONS_PT, TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_PLAYERS_PT, TRX_ADDONS_CPT_MATCHES_PT)) || $screen->base=='edit-tags') return;
		global $post;
		?>
		<div class="notice notice-info" id="trx_addons_sport_breadcrumbs">
			<h3 class="trx_addons_sport_breadcrumbs_title">
				<?php
				if ($screen->post_type == TRX_ADDONS_CPT_COMPETITIONS_PT) {
					$sport = trx_addons_get_value_gp('cpt_competitions_sports');
					if ( empty($sport) ) {
						$terms = get_the_terms($post->ID, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
						if (is_array($terms) && count($terms)>0) $sport = $terms[0];
					} else {
						$sport = get_term_by('slug', $sport, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
					}
					if (is_object($sport)) {
						if (substr($screen->id, 0, 5)!='edit-') {		// Edit single competition
							?><a href="<?php echo esc_url(get_admin_url(null, 'edit.php?post_type='.TRX_ADDONS_CPT_COMPETITIONS_PT.'&'.TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY.'='.$sport->slug)); ?>" class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($sport->name); ?></a><span class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($post->post_title); ?></span><?php
						} else {										// List of competitions
							?><span class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($sport->name); ?></span><?php
						}
					}

				} else if ( in_array($screen->post_type, array(TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_PLAYERS_PT, TRX_ADDONS_CPT_MATCHES_PT)) ) {
					// Detect round
					$round = null;
					if ($screen->post_type == TRX_ADDONS_CPT_MATCHES_PT) {
						$round = trx_addons_get_value_gp('round');
						//if ( (int) $round == 0) $round = get_post_meta($post->ID, 'trx_addons_round', true);
						if ( (int) $round == 0) $round = $post->post_parent;
						$round = get_post($round);
					}
					// Detect competition
					$competition = trx_addons_get_value_gp('competition');
					//if ( (int) $competition == 0) $competition = get_post_meta($post->ID, 'trx_addons_competition', true);
					if ( (int) $competition == 0) $competition = is_object($round) ? $round->post_parent : $post->post_parent;
					$competition = get_post($competition);
					// Detect sport
					$terms = get_the_terms($competition->ID, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
					$sport = is_array($terms) && count($terms)>0 ? $terms[0] : null;
					if (is_object($sport)) {
						?><a href="<?php echo esc_url(get_admin_url(null, 'edit.php?post_type='.TRX_ADDONS_CPT_COMPETITIONS_PT.'&'.TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY.'='.$sport->slug)); ?>" class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($sport->name); ?></a><?php
					}
					if (is_object($competition)) {
						// Competition link
						if (substr($screen->id, 0, 5)!='edit-' || $screen->post_type == TRX_ADDONS_CPT_MATCHES_PT) {
							?><a href="<?php echo esc_url(get_admin_url(null, 'edit.php?post_type='.($screen->post_type == TRX_ADDONS_CPT_PLAYERS_PT ? TRX_ADDONS_CPT_PLAYERS_PT : TRX_ADDONS_CPT_ROUNDS_PT).'&competition='.intval($competition->ID))); ?>" class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($competition->post_title); ?></a><?php
							// Round link
							if ($screen->post_type == TRX_ADDONS_CPT_MATCHES_PT) {
								if (substr($screen->id, 0, 5)!='edit-') {
									?><a href="<?php echo esc_url(get_admin_url(null, 'edit.php?post_type='.TRX_ADDONS_CPT_MATCHES_PT.'&competition='.intval($competition->ID).'&round='.intval($round->ID))); ?>" class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($round->post_title); ?></a><?php
								} else {											// List of matches
									// Current round title
									?><span class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($round->post_title); ?></span><?php
								}
							} else {
								if (substr($screen->id, 0, 5)!='edit-') {			// Edit single round/player
									// Current round/player/match title
									?><span class="trx_addons_sport_breadcrumbs_item"><?php echo !empty($post->post_title) ? esc_html($post->post_title) : esc_html__('New item', 'trx_addons'); ?></span><?php
								}
							}
						} else {													// List of rounds/players
							// Current competition title
							?><span class="trx_addons_sport_breadcrumbs_item"><?php echo esc_html($competition->post_title); ?></span><?php
						}
					}
				}
				?>
			</h3>
		</div>
		<?php
	}
}


// Get list competitions by specified sport
if ( !function_exists( 'trx_addons_cpt_sport_refresh_list_competitions' ) ) {
	add_filter('trx_addons_filter_refresh_list_competitions', 'trx_addons_cpt_sport_refresh_list_competitions', 10, 3);
	function trx_addons_cpt_sport_refresh_list_competitions($list, $sport, $not_selected=false) {
		return trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
													'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
													'taxonomy_value' => $sport,
													'meta_key' => 'trx_addons_competition_date',
													'orderby' => 'meta_value',
													'order' => 'ASC',
													'not_selected' => $not_selected
													));
	}
}


// Get list rounds by specified competition
if ( !function_exists( 'trx_addons_cpt_sport_refresh_list_rounds' ) ) {
	add_filter('trx_addons_filter_refresh_list_rounds', 'trx_addons_cpt_sport_refresh_list_rounds', 10, 3);
	function trx_addons_cpt_sport_refresh_list_rounds($list, $competition, $not_selected=false) {
		return trx_addons_array_merge(array(
											'last' => esc_html__('Last round', 'trx_addons'),
											'next' => esc_html__('Next round', 'trx_addons')
											),
										trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_CPT_ROUNDS_PT,
													'post_parent' => $competition,
													'meta_key' => 'trx_addons_round_date',
													'orderby' => 'meta_value',
													'order' => 'ASC',
													'not_selected' => $not_selected
													))
		);
	}
}


// trx_sc_matches
//-------------------------------------------------------------
/*
[trx_sc_matches id="unique_id" type="default" sport="sport_slug or id" competition="id" round="id" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_matches' ) ) {
	function trx_addons_sc_matches($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_matches', $atts, array(
			// Individual params
			"type" => "default",
			"main_matches" => 0,
			"position" => 'top',
			"slider" => 0,
			"sport" => '',
			"competition" => '',
			"round" => '',
			"count" => 3,
			"offset" => 0,
			"orderby" => '',
			"order" => '',
			"ids" => '',
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

		if (empty($atts['sport'])) 
			$atts['sport'] = trx_addons_get_option('sport_favorite');
		if (!empty($atts['ids'])) {
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'post_date';
		if (empty($atts['order'])) $atts['order'] = 'asc';

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'sport/tpl.sc_matches.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'sport/tpl.sc_matches.default.php'
										),
                                        'trx_addons_args_sc_matches',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_matches', $atts, $content);
	}
}


// Add [trx_sc_matches] in the VC shortcodes list
if (!function_exists('trx_addons_sc_matches_add_in_vc')) {
	function trx_addons_sc_matches_add_in_vc() {
		
		add_shortcode("trx_sc_matches", "trx_addons_sc_matches");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_matches", 'trx_addons_sc_matches_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Matches extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_matches_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_matches_add_in_vc_params')) {
	function trx_addons_sc_matches_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_sc_matches');
		// Prepare lists
		$sports_list = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
		$sport_default = trx_addons_get_option('sport_favorite');
		$sport = $vc_edit && !empty($vc_params['sport']) ? $vc_params['sport'] : $sport_default;
		if (empty($sport) && count($sports_list) > 0) {
			$keys = array_keys($sports_list);
			$sport = $keys[0];
		}
		$competitions_list = trx_addons_get_list_posts(false, array(
														'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
														'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
														'taxonomy_value' => $sport,
														'meta_key' => 'trx_addons_competition_date',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														'not_selected' => false
														));
		$competition = $vc_edit && !empty($vc_params['competition']) ? $vc_params['competition'] : '';
		if ((empty($competition) || !isset($competitions_list[$competition])) && count($competitions_list) > 0) {
			$keys = array_keys($competitions_list);
			$competition = $keys[0];
		}
		$rounds_list = trx_addons_array_merge(array(
											'last' => esc_html__('Last round', 'trx_addons'),
											'next' => esc_html__('Next round', 'trx_addons')
											), trx_addons_get_list_posts(false, array(
														'post_type' => TRX_ADDONS_CPT_ROUNDS_PT,
														'post_parent' => $competition,
														'meta_key' => 'trx_addons_round_date',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														'not_selected' => false
														)
											)
						);
		
		$params = array_merge(
				array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Layout", 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
						"admin_label" => true,
						"std" => "default",
						"value" => array_flip(apply_filters('trx_addons_sc_type', array(
							'default' => esc_html__('Default', 'trx_addons')
						), 'trx_sc_matches')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "sport",
						"heading" => esc_html__("Sport", 'trx_addons'),
						"description" => wp_kses_data( __("Select Sport to display matches", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
						"std" => $sport_default,
				        'save_always' => true,
						"value" => array_flip($sports_list),
						"type" => "dropdown"
					),
					array(
						"param_name" => "competition",
						"heading" => esc_html__("Competition", 'trx_addons'),
						"description" => wp_kses_data( __("Select competition to display matches", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_flip($competitions_list),
						"type" => "dropdown"
					),
					array(
						"param_name" => "round",
						"heading" => esc_html__("Round", 'trx_addons'),
						"description" => wp_kses_data( __("Select round to display matches", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_flip($rounds_list),
						"type" => "dropdown"
					),
					array(
						"param_name" => "main_matches",
						"heading" => esc_html__("Main matches", 'trx_addons'),
						"description" => wp_kses_data( __("Show large items marked as main match of the round", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
						"std" => 0,
						"value" => array(esc_html__("Main matches", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position of the matches list", 'trx_addons'),
						"description" => wp_kses_data( __("Select the position of the matches list", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
						'dependency' => array(
							'element' => 'main_matches',
							'not_empty' => true
						),
						"std" => "top",
						"value" => array_flip(trx_addons_get_list_sc_matches_positions()),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", 'trx_addons'),
						"description" => wp_kses_data( __("Show main matches as slider (if two and more)", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"admin_label" => true,
						'dependency' => array(
							'element' => 'main_matches',
							'not_empty' => true
						),
						"std" => 0,
						"value" => array(esc_html__("Show main matches as slider", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
				),
				trx_addons_vc_add_query_param(''),
				trx_addons_vc_add_title_param(),
				trx_addons_vc_add_id_param()
		);
		
		// Remove 'columns' from params list
		$params = trx_addons_vc_remove_param($params, 'columns');
												
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_matches",
				"name" => esc_html__("Sport: Matches", 'trx_addons'),
				"description" => wp_kses_data( __("Display matches from specified sport, competition and round", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_matches',
				"class" => "trx_sc_matches",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_sc_matches' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_matches_add_in_elementor')) {
	
	// Load required styles and scripts for Elementor Editor mode
	if ( !function_exists( 'trx_addons_sc_matches_elm_editor_load_scripts' ) ) {
		add_action("elementor/editor/before_enqueue_scripts", 'trx_addons_sc_matches_elm_editor_load_scripts');
		function trx_addons_sc_matches_elm_editor_load_scripts() {
			wp_enqueue_script( 'trx_addons-sc_sport-elementor-editor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'sport/sport.elementor.editor.js'), array('jquery'), null, true );
		}
	}
	
	// Register widgets
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_matches_add_in_elementor' );
	function trx_addons_sc_matches_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Matches extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_matches';
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
				return __( 'Matches', 'trx_addons' );
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
				return 'eicon-accordion';
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
				$sports_list = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
				$sport_default = trx_addons_get_option('sport_favorite');
				$sport = !empty($params['sport']) ? $params['sport'] : $sport_default;
				if (empty($sport) && count($sports_list) > 0) {
					$keys = array_keys($sports_list);
					$sport = $keys[0];
				}
				$competitions_list = trx_addons_get_list_posts(false, array(
																'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
																'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
																'taxonomy_value' => $sport,
																'meta_key' => 'trx_addons_competition_date',
																'orderby' => 'meta_value',
																'order' => 'ASC',
																'not_selected' => false
																));
				$competition = !empty($params['competition']) ? $params['competition'] : '';
				if ((empty($competition) || !isset($competitions_list[$competition])) && count($competitions_list) > 0) {
					$competition = trx_addons_array_get_first($competitions_list);
				}
				$rounds_list = trx_addons_array_merge(array(
													'last' => esc_html__('Last round', 'trx_addons'),
													'next' => esc_html__('Next round', 'trx_addons')
													), trx_addons_get_list_posts(false, array(
																'post_type' => TRX_ADDONS_CPT_ROUNDS_PT,
																'post_parent' => $competition,
																'meta_key' => 'trx_addons_round_date',
																'orderby' => 'meta_value',
																'order' => 'ASC',
																'not_selected' => false
																)
													)
								);

				$this->start_controls_section(
					'section_sc_matches',
					[
						'label' => __( 'Matches', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', array(
																			'default' => esc_html__('Default', 'trx_addons')
																			), 'trx_sc_matches'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'sport',
					[
						'label' => __( 'Sport', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $sports_list,
						'default' => $sport_default
					]
				);

				$this->add_control(
					'competition',
					[
						'label' => __( 'Competition', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $competitions_list
					]
				);

				$this->add_control(
					'round',
					[
						'label' => __( 'Round', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $rounds_list
					]
				);

				$this->add_control(
					'main_matches',
					[
						'label' => __( 'Main matches', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Show large items marked as main match of the round", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'position',
					[
						'label' => __( 'Position of the matches list', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_matches_positions(),
						'default' => 'top',
						'condition' => [
							'main_matches' => '1'
						]
					]
				);

				$this->add_control(
					'slider',
					[
						'label' => __( 'Slider', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Show main matches as slider (if two and more)", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => [
							'main_matches' => '1'
						]
					]
				);

				$this->add_query_param('', ['columns' => false]);

				$this->end_controls_section();
				
				$this->add_title_param();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Matches() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Matches extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_matches',
				esc_html__('ThemeREX Matches', 'trx_addons'),
				array(
					'classname' => 'widget_matches',
					'description' => __('Display matches', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			// Prepare lists
			list($vc_edit, $vc_params) = trx_addons_get_sow_form_params('TRX_Addons_SOW_Widget_Matches');
			// Prepare lists
			$sports_list = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
			$sport_default = trx_addons_get_option('sport_favorite');
			$sport = $vc_edit && !empty($vc_params['sport']) ? $vc_params['sport'] : $sport_default;
			if (empty($sport) && count($sports_list) > 0) {
				$keys = array_keys($sports_list);
				$sport = $keys[0];
			}
			$competitions_list = trx_addons_get_list_posts(false, array(
															'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
															'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
															'taxonomy_value' => $sport,
															'meta_key' => 'trx_addons_competition_date',
															'orderby' => 'meta_value',
															'order' => 'ASC',
															'not_selected' => false
															));
			$competition = $vc_edit && !empty($vc_params['competition']) ? $vc_params['competition'] : '';
			if ((empty($competition) || !isset($competitions_list[$competition])) && count($competitions_list) > 0) {
				$keys = array_keys($competitions_list);
				$competition = $keys[0];
			}
			$rounds_list = trx_addons_array_merge(array(
												'last' => esc_html__('Last round', 'trx_addons'),
												'next' => esc_html__('Next round', 'trx_addons')
												), trx_addons_get_list_posts(false, array(
															'post_type' => TRX_ADDONS_CPT_ROUNDS_PT,
															'post_parent' => $competition,
															'meta_key' => 'trx_addons_round_date',
															'orderby' => 'meta_value',
															'order' => 'ASC',
															'not_selected' => false
															)
												)
							);
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', array(
							'default' => esc_html__('Default', 'trx_addons')
						), $this->get_sc_name()),
						'type' => 'select'
					),
					"sport" => array(
						"label" => esc_html__("Sport", 'trx_addons'),
						"description" => wp_kses_data( __("Select Sport to display matches", 'trx_addons') ),
						"default" => $sport_default,
						"options" => $sports_list,
						"type" => "select"
					),
					"competition" => array(
						"label" => esc_html__("Competition", 'trx_addons'),
						"description" => wp_kses_data( __("Select competition to display matches", 'trx_addons') ),
						"default" => 0,
						"options" => $competitions_list,
						"type" => "select_dynamic"
					),
					"round" => array(
						"label" => esc_html__("Round", 'trx_addons'),
						"description" => wp_kses_data( __("Select round to display matches", 'trx_addons') ),
						"default" => 0,
						"options" => $rounds_list,
						"type" => "select_dynamic"
					),
					"main_matches" => array(
						"label" => esc_html__("Main matches", 'trx_addons'),
						"description" => wp_kses_data( __("Show large items marked as main match of the round", 'trx_addons') ),
						'state_emitter' => array(
							'callback' => 'conditional',
							'args'     => array(
								'matches[show]: val',
								'matches[hide]: !val',
							)
						),
						"default" => false,
						"type" => "checkbox"
					),
					"position" => array(
						"label" => esc_html__("Position of the matches list", 'trx_addons'),
						"description" => wp_kses_data( __("Select the position of the matches list", 'trx_addons') ),
						'state_handler' => array(
							"matches[show]" => array('show'),
							"matches[hide]" => array('hide')
						),
						"default" => "top",
						"options" => trx_addons_get_list_sc_matches_positions(),
						"type" => "select"
					),
					"slider" => array(
						"label" => esc_html__("Slider", 'trx_addons'),
						"description" => wp_kses_data( __("Show main matches as slider (if two and more)", 'trx_addons') ),
						'state_handler' => array(
							"matches[show]" => array('show'),
							"matches[hide]" => array('hide')
						),
						"default" => false,
						"type" => "checkbox"
					)
				),
				trx_addons_sow_add_query_param('', array(), array('columns')),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_matches', __FILE__, 'TRX_Addons_SOW_Widget_Matches');
}



// trx_sc_points
//-------------------------------------------------------------
/*
[trx_sc_points id="unique_id" type="default" sport="sport_slug or id" competition="id"]
*/
if ( !function_exists( 'trx_addons_sc_points' ) ) {
	function trx_addons_sc_points($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_points', $atts, array(
			// Individual params
			"type" => "default",
			"sport" => '',
			"competition" => '',
			"logo" => 0,
			"accented_top" => 3,
			"accented_bottom" => 3,
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

		$atts['accented_top'] = empty($atts['accented_top']) ? 0 : max(0, (int) $atts['accented_top']);
		$atts['accented_bottom'] = empty($atts['accented_bottom']) ? 0 : max(0, (int) $atts['accented_bottom']);

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'sport/tpl.sc_points.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'sport/tpl.sc_points.default.php'
										),
										'trx_addons_args_sc_points',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_points', $atts, $content);
	}
}


// Add [trx_sc_points] in the VC shortcodes list
if (!function_exists('trx_addons_sc_points_add_in_vc')) {
	function trx_addons_sc_points_add_in_vc() {
		
		add_shortcode("trx_sc_points", "trx_addons_sc_points");
		
		if (!trx_addons_exists_visual_composer()) return;

		vc_lean_map("trx_sc_points", 'trx_addons_sc_points_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Points extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_points_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_points_add_in_vc_params')) {
	function trx_addons_sc_points_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_sc_points');
		// Prepare lists
		$sports_list = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
		$sport_default = trx_addons_get_option('sport_favorite');
		$sport = $vc_edit && !empty($vc_params['sport']) ? $vc_params['sport'] : $sport_default;
		if (empty($sport) && count($sports_list) > 0) {
			$keys = array_keys($sports_list);
			$sport = $keys[0];
		}
		$competitions_list = trx_addons_get_list_posts(false, array(
														'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
														'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
														'taxonomy_value' => $sport,
														'meta_key' => 'trx_addons_competition_date',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														'not_selected' => false
														));
		
		$params = array_merge(
				array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Layout", 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
						"admin_label" => true,
						"std" => "default",
						"value" => array_flip(apply_filters('trx_addons_sc_type', array(
							'default' => esc_html__('Default', 'trx_addons')
						), 'trx_sc_points')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "sport",
						"heading" => esc_html__("Sport", 'trx_addons'),
						"description" => wp_kses_data( __("Select Sport to display points table", 'trx_addons') ),
						"admin_label" => true,
						"std" => $sport_default,
				        'save_always' => true,
						"value" => array_flip($sports_list),
						"type" => "dropdown"
					),
					array(
						"param_name" => "competition",
						"heading" => esc_html__("Competition", 'trx_addons'),
						"description" => wp_kses_data( __("Select competition to display points table", 'trx_addons') ),
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_flip($competitions_list),
						"type" => "dropdown"
					),
					array(
						"param_name" => "logo",
						"heading" => esc_html__("Logo", 'trx_addons'),
						"description" => wp_kses_data( __("Show logo (players photo) in the table", 'trx_addons') ),
						"admin_label" => true,
						"std" => 0,
						"value" => array(esc_html__("Show logo", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "accented_top",
						"heading" => esc_html__("Accented top", 'trx_addons'),
						"description" => wp_kses_data( __("How many rows should be accented at the top of the table?", 'trx_addons') ),
						"std" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "accented_bottom",
						"heading" => esc_html__("Accented bottom", 'trx_addons'),
						"description" => wp_kses_data( __("How many rows should be accented at the bottom of the table?", 'trx_addons') ),
						"std" => 3,
						"type" => "textfield"
					),
				),
				trx_addons_vc_add_title_param(),
				trx_addons_vc_add_id_param()
		);
		
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_points",
				"name" => esc_html__("Sport: Table of points", 'trx_addons'),
				"description" => wp_kses_data( __("Display table of points for specified competition", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_points',
				"class" => "trx_sc_points",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_sc_points' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_points_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_points_add_in_elementor' );
	function trx_addons_sc_points_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Points extends TRX_Addons_Elementor_Widget {

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
					'accented_top' => 'size',
					'accented_bottom' => 'size'
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
				return 'trx_sc_points';
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
				return __( 'Points', 'trx_addons' );
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
				return 'eicon-table';
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
				$sports_list = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
				$sport_default = trx_addons_get_option('sport_favorite');
				$sport = !empty($params['sport']) ? $params['sport'] : $sport_default;
				if (empty($sport) && count($sports_list) > 0) {
					$sport = trx_addons_array_get_first($sports_list);
				}
				$competitions_list = trx_addons_get_list_posts(false, array(
																'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
																'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
																'taxonomy_value' => $sport,
																'meta_key' => 'trx_addons_competition_date',
																'orderby' => 'meta_value',
																'order' => 'ASC',
																'not_selected' => false
																));

				$this->start_controls_section(
					'section_sc_points',
					[
						'label' => __( 'Points', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', array(
																			'default' => esc_html__('Default', 'trx_addons')
																			), 'trx_sc_points'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'sport',
					[
						'label' => __( 'Sport', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $sports_list,
						'default' => $sport_default
					]
				);

				$this->add_control(
					'competition',
					[
						'label' => __( 'Competition', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $competitions_list
					]
				);

				$this->add_control(
					'logo',
					[
						'label' => __( 'Show logo', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'return_value' => '1'
					]
				);
				
				$this->add_control(
					'accented_top',
					[
						'label' => __( 'Accented top', 'trx_addons' ),
						'description' => wp_kses_data( __("How many rows should be accented at the top of the table?", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 3
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 10
							]
						]
					]
				);
				
				$this->add_control(
					'accented_bottom',
					[
						'label' => __( 'Accented bottom', 'trx_addons' ),
						'description' => wp_kses_data( __("How many rows should be accented at the bottom of the table?", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 3
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 10
							]
						]
					]
				);

				$this->end_controls_section();
				
				$this->add_title_param();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Points() );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Points extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_points',
				esc_html__('ThemeREX Points', 'trx_addons'),
				array(
					'classname' => 'widget_points',
					'description' => __('Display players table with points', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			// If open params in SOW Editor
			list($vc_edit, $vc_params) = trx_addons_get_sow_form_params('TRX_Addons_SOW_Widget_Points');
			// Prepare lists
			$sports_list = trx_addons_get_list_terms(false, TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
			$sport_default = trx_addons_get_option('sport_favorite');
			$sport = $vc_edit && !empty($vc_params['sport']) ? $vc_params['sport'] : $sport_default;
			if (empty($sport) && count($sports_list) > 0) {
				$keys = array_keys($sports_list);
				$sport = $keys[0];
			}
			$competitions_list = trx_addons_get_list_posts(false, array(
															'post_type' => TRX_ADDONS_CPT_COMPETITIONS_PT,
															'taxonomy' => TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY,
															'taxonomy_value' => $sport,
															'meta_key' => 'trx_addons_competition_date',
															'orderby' => 'meta_value',
															'order' => 'ASC',
															'not_selected' => false
															));
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', array(
							'default' => esc_html__('Default', 'trx_addons')
						), $this->get_sc_name()),
						'type' => 'select'
					),
					"sport" => array(
						"label" => esc_html__("Sport", 'trx_addons'),
						"description" => wp_kses_data( __("Select Sport to display points table", 'trx_addons') ),
						"default" => $sport_default,
						"options" => $sports_list,
						"type" => "select"
					),
					"competition" => array(
						"label" => esc_html__("Competition", 'trx_addons'),
						"description" => wp_kses_data( __("Select competition to display points table", 'trx_addons') ),
						"default" => 0,
						"options" => $competitions_list,
						"type" => "select_dynamic"
					),
					"logo" => array(
						"label" => esc_html__("Logo", 'trx_addons'),
						"description" => wp_kses_data( __("Show logo (players photo) in the table", 'trx_addons') ),
						"default" => false,
						"type" => "checkbox"
					),
					"accented_top" => array(
						"label" => esc_html__("Accented top", 'trx_addons'),
						"description" => wp_kses_data( __("How many rows should be accented at the top of the table?", 'trx_addons') ),
						"default" => 3,
						"type" => "number"
					),
					"accented_bottom" => array(
						"label" => esc_html__("Accented bottom", 'trx_addons'),
						"description" => wp_kses_data( __("How many rows should be accented at the bottom of the table?", 'trx_addons') ),
						"default" => 3,
						"type" => "number"
					)
				),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_points', __FILE__, 'TRX_Addons_SOW_Widget_Points');
}
?>