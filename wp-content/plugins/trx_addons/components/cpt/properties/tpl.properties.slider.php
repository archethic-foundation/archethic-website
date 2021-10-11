<?php
/**
 * The style "slider" of the Properties
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

$args = get_query_var('trx_addons_args_sc_properties');
$query_args = trx_addons_cpt_properties_query_params_to_args(array(
				'properties_type' => $args['properties_type'],
				'properties_status' => $args['properties_status'],
				'properties_labels' => $args['properties_labels'],
				'properties_country' => $args['properties_country'],
				'properties_state' => $args['properties_state'],
				'properties_city' => $args['properties_city'],
				'properties_neighborhood' => $args['properties_neighborhood'],
				'properties_order' => $args['orderby'] . '_' . $args['order']
				), true);
$query_args['ignore_sticky_posts'] = true;
if (empty($args['ids'])) {
	$query_args['posts_per_page'] = $args['count'];
	$query_args['offset'] = $args['offset'];
} else
	$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids']);
$query = new WP_Query( $query_args );
if ($query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_properties sc_properties_<?php 
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php

		trx_addons_sc_show_titles('sc_properties', $args);
		
		$images = array();
		
		while ( $query->have_posts() ) { $query->the_post();
				$images[] = apply_filters('trx_addons_filter_slider_content', array(
						'url'  => trx_addons_get_attachment_url(get_post_thumbnail_id(get_the_ID()), trx_addons_get_thumb_size('big')),
						'title'=> get_the_title(),
						'cats' => trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE),
						'date' => apply_filters('trx_addons_filter_get_post_date', get_the_date()),
						'link' => get_permalink()
						),
						$args);
		}

		wp_reset_postdata();
	
		?><div class="sc_properties_content sc_item_content"><?php

			trx_addons_show_layout(trx_addons_get_slider_layout(array(
				'mode' => 'custom',
				'noresize' => 1,
				'controls' => !trx_addons_is_off($args['slider_controls']) ? 'yes' : 'no',
				'controls_pos' => $args['slider_controls'],
				'pagination' => !trx_addons_is_off($args['slider_pagination']) ? 'yes' : 'no',
				'pagination_pos' => $args['slider_pagination'],
				'slides_space' => !empty($args['slides_space']) ? $args['slides_space'] : 0,
				'id' => !empty($args['id']) ? $args['id'].'_slider' : ''
				), $images));

		?></div><?php
		
		trx_addons_sc_show_links('sc_properties', $args);

	?></div><!-- /.sc_properties --><?php
}
?>