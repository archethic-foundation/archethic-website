<?php
/**
 * The style "default" of the Services
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

$args = get_query_var('trx_addons_args_sc_services');
$query_args = array(
	'post_status' => 'publish',
	'ignore_sticky_posts' => true
);
if (empty($args['ids'])) {
	$query_args['posts_per_page'] = $args['count'];
	$query_args['offset'] = $args['offset'];
}
$query_args = trx_addons_query_add_sort_order($query_args, $args['orderby'], $args['order']);
$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids'], $args['post_type'], $args['cat'], $args['taxonomy']);
$query = new WP_Query( $query_args );
if ($query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	if ($args['columns'] < 1) $args['columns'] = $args['count'];
	//$args['columns'] = min($args['columns'], $args['count']);
	$args['columns'] = max(1, min(12, (int) $args['columns']));
	$args['slider'] = $args['slider'] > 0 && $args['count'] > $args['columns'];
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_services sc_services_<?php 
			echo esc_attr($args['type']);
			echo ' sc_services_featured_'.esc_attr($args['featured_position']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		if ($args['type']=='timeline' && $args['featured_position']=='bottom') echo ' data-equal-height=".sc_services_item"';
		?>><?php

		trx_addons_sc_show_titles('sc_services', $args);
		
		if ($args['slider']) {
			$args['slides_min_width'] = $args['type']=='iconed' ? 250 : 200;
			trx_addons_sc_show_slider_wrap_start('sc_services', $args);
		} else if ($args['columns'] > 1) {
			?><div class="sc_services_columns_wrap sc_item_columns sc_item_columns_<?php
							echo esc_attr($args['columns']);
							echo ' '.esc_attr(trx_addons_get_columns_wrap_class()) . ($args['type']!='list' ? ' columns_padding_bottom' : '');
							if ($args['no_margin']==1) echo ' no_margin';
						?>"><?php
		} else {
			?><div class="sc_services_content sc_item_content sc_item_columns_1"><?php
		}	

		set_query_var('trx_addons_args_sc_services', $args);
		$trx_addons_number = $args['offset'];
		while ( $query->have_posts() ) { $query->the_post();
			$trx_addons_number++;
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_CPT . 'services/tpl.'.trx_addons_esc($args['type']).'-item.php',
                                            TRX_ADDONS_PLUGIN_CPT . 'services/tpl.default-item.php'
                                            ),
                                            'trx_addons_args_item_number',
                                            $trx_addons_number
                                        );
		}

		wp_reset_postdata();
	
		?></div><?php		// .swiper-wrapper || .sc_services_columns || .sc_services_content

		if ($args['slider']) {
			trx_addons_sc_show_slider_wrap_end('sc_services', $args);
		}
		
		trx_addons_sc_show_links('sc_services', $args);

	?></div><!-- /.sc_services --><?php
}
?>