<?php
/**
 * The style "googlemap" of the Properties
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

if (function_exists('trx_addons_sc_googlemap')) {
	$on_property_post = is_single() && get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT;
	$args = get_query_var('trx_addons_args_sc_properties');
	$query_args = trx_addons_cpt_properties_query_params_to_args(
					isset($_GET['properties_type']) 
					|| (is_single() && get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT)
					|| (is_single() && get_post_type()==TRX_ADDONS_CPT_AGENTS_PT)
					|| (is_post_type_archive(TRX_ADDONS_CPT_PROPERTIES_PT) && (int) trx_addons_get_value_gp('compare') == 1)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_NEIGHBORHOOD)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATE)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_COUNTRY)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS)
					|| is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_LABELS)
						? array()
						: array(
								'properties_type' => $args['properties_type'],
								'properties_status' => $args['properties_status'],
								'properties_labels' => $args['properties_labels'],
								'properties_country' => $args['properties_country'],
								'properties_state' => $args['properties_state'],
								'properties_city' => $args['properties_city'],
								'properties_neighborhood' => $args['properties_neighborhood'],
								'properties_order' => $args['orderby'] . '_' . $args['order']
								),
					true);
	if (!isset($_GET['properties_type'])) {
		if (is_single() && get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT) {
			$args['ids'] = get_the_ID();
			$query_args['post_type'] = TRX_ADDONS_CPT_PROPERTIES_PT;
		} else if (is_post_type_archive(TRX_ADDONS_CPT_PROPERTIES_PT) && (int) trx_addons_get_value_gp('compare') == 1) {
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
				$args['ids'] = join(',', $posts);
			}
		}
		$query_args['ignore_sticky_posts'] = true;
		if (empty($args['ids'])) {
			if (empty($query_args['posts_per_page'])) {
				$query_args['posts_per_page'] = $args['count'];
				$query_args['offset'] = $args['offset'];
			}
		} else
			$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids']);
	}
	$query = new WP_Query( $query_args );
	if ($query->found_posts > 0) {
		if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
		?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_properties sc_properties_<?php 
				echo esc_attr($args['type']);
				if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
				?>"<?php
			if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
			?>><?php
	
			trx_addons_sc_show_titles('sc_properties', $args);
			
			?><div class="sc_properties_content sc_item_content"><?php
	
			$markers = array();
			
			$default_icon = trx_addons_get_option('properties_marker');
			if (empty($default_icon)) $default_icon = trx_addons_remove_protocol(trx_addons_get_option('api_google_marker'));
			if (empty($default_icon)) $default_icon = trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'properties/properties.png');
			
			while ( $query->have_posts() ) { $query->the_post();
				$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
				if (($on_property_post && empty($meta['show_map'])) || empty($meta['location'])) continue;
				if (empty($meta['marker'])) {
					$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE);
					if (is_array($terms) && count($terms)>0) {
						$term = trx_addons_array_get_first($terms, false);
						$icon = trx_addons_get_term_meta(array(
														'taxonomy'	=> TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE,
														'term_id'	=> $term->term_id,
														'key'		=> 'image'
														));
					} else
						$icon = '';
				} else
					$icon = $meta['marker'];
				$latlng = explode(',', $meta['location']);
				$markers[] = array(
								'title' => get_the_title(),
								'description' => trx_addons_get_template_part_as_string(
													TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.default-item.php',
													'trx_addons_args_properties',
													$args),
								'address' => '',
								'latlng' => trim($latlng[0]).','.trim($latlng[1]),
								'icon' => !empty($icon) ? $icon : $default_icon
								);
			}
	
			wp_reset_postdata();
	
			// Display map
			trx_addons_show_layout(trx_addons_sc_googlemap(array(
				"markers" => $markers,
				"zoom" => count($markers)>1 ? 0 : 16,
				"height" => max(100, $args['googlemap_height']),
				"id" => !empty($args['id']) ? $args['id'].'_googlemap' : ""
			)));
		
			?></div><?php		// .sc_properties_content
	
			trx_addons_sc_show_links('sc_properties', $args);
	
		?></div><!-- /.sc_properties --><?php
	}
}
?>