<?php
/**
 * The style "default" of the Cars
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

$args = get_query_var('trx_addons_args_sc_cars');
$query_args = trx_addons_cpt_cars_query_params_to_args(array(
				'cars_type' => $args['cars_type'],
				'cars_status' => $args['cars_status'],
				'cars_labels' => $args['cars_labels'],
				'cars_maker' => $args['cars_maker'],
				'cars_model' => $args['cars_model'],
				'cars_city' => $args['cars_city'],
				'cars_fuel' => $args['cars_fuel'],
				'cars_type_drive' => $args['cars_type_drive'],
				'cars_transmission' => $args['cars_transmission'],
				'cars_order' => $args['orderby'] . '_' . $args['order']
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
	?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_cars sc_cars_<?php 
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php

		trx_addons_sc_show_titles('sc_cars', $args);
		
		if ($args['slider']) {
			$args['slides_min_width'] = 200;
			trx_addons_sc_show_slider_wrap_start('sc_services', $args);
		} else if ($args['columns'] > 1) {
			?><div class="sc_cars_columns_wrap sc_item_columns sc_item_columns_<?php
							echo esc_attr($args['columns']);
							echo ' '.esc_attr(trx_addons_get_columns_wrap_class()) . ' columns_padding_bottom';
						?>"><?php
		} else {
			?><div class="sc_cars_content sc_item_content sc_cars_columns_1 sc_item_columns_1"><?php
		}

		while ( $query->have_posts() ) { $query->the_post();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.'.trx_addons_esc($args['type']).'-item.php',
											TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.default-item.php'
											),
											'trx_addons_args_sc_cars',
											$args
										);
		}

		wp_reset_postdata();
	
		?></div><?php		// .swiper-wrapper || .sc_cars_columns || .sc_cars_content

		if ($args['slider']) {
			trx_addons_sc_show_slider_wrap_end('sc_cars', $args);
		}
		
		trx_addons_sc_show_links('sc_cars', $args);

	?></div><!-- /.sc_cars --><?php
}
?>