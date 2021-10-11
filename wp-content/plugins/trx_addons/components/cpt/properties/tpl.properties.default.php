<?php
/**
 * The style "default" of the Properties
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
	if ($args['columns'] < 1) $args['columns'] = $args['count'];
	//$args['columns'] = min($args['columns'], $args['count']);
	$args['columns'] = max(1, min(12, (int) $args['columns']));
	$args['slider'] = $args['slider'] > 0 && $args['count'] > $args['columns'];
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_properties sc_properties_<?php 
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php

		trx_addons_sc_show_titles('sc_properties', $args);
		
		if ($args['slider']) {
			$args['slides_min_width'] = 200;
			trx_addons_sc_show_slider_wrap_start('sc_services', $args);
		} else if ($args['columns'] > 1) {
			?><div class="sc_properties_columns sc_item_columns sc_item_columns_<?php
							echo esc_attr($args['columns']);
							echo ' '.esc_attr(trx_addons_get_columns_wrap_class()) . ' columns_padding_bottom';
						?>"><?php
		} else {
			?><div class="sc_properties_content sc_item_content sc_properties_columns_1 sc_item_columns_1"><?php
		}

		while ( $query->have_posts() ) { $query->the_post();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.'.trx_addons_esc($args['type']).'-item.php',
											TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.default-item.php'
											),
											'trx_addons_args_sc_properties',
											$args
										);
		}

		wp_reset_postdata();
	
		?></div><?php		// .swiper-wrapper || .sc_properties_columns || .sc_properties_content

		if ($args['slider']) {
			trx_addons_sc_show_slider_wrap_end('sc_properties', $args);
		}
		
		trx_addons_sc_show_links('sc_properties', $args);

	?></div><!-- /.sc_properties --><?php
}
?>