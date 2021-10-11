<?php
/**
 * The template with loop of the properties archive
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

$args = get_query_var('trx_addons_args_properties_loop');

$trx_addons_need_reset_query = false;
if (!empty($args['query_params'])) {
	$query_args = trx_addons_cpt_properties_query_params_to_args($args['query_params'], true);
	if (count($query_args) > 0) query_posts($query_args);
	$trx_addons_need_reset_query = true;
}

do_action('trx_addons_action_start_archive');

if (have_posts()) {

	$trx_addons_properties_style   = explode('_', !empty($args['blog_style'])
															? $args['blog_style']
															: trx_addons_get_option('properties_blog_style')
											);
	$trx_addons_properties_type    = $trx_addons_properties_style[0];
	$trx_addons_properties_columns = empty($trx_addons_properties_style[1]) ? 1 : max(1, $trx_addons_properties_style[1]);

	?><div class="sc_properties sc_properties_default">
		
		<div class="sc_properties_columns_wrap sc_properties_columns_<?php
			echo esc_attr($trx_addons_properties_columns);
			if ($trx_addons_properties_columns > 1) echo ' ' . esc_attr(trx_addons_get_columns_wrap_class()) . ' columns_padding_bottom';
		?>"><?php

			while ( have_posts() ) { the_post(); 
				trx_addons_get_template_part(array(
												TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.'.trim($trx_addons_properties_type).'-item.php',
												TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.default-item.php'
												),
												'trx_addons_args_sc_properties',
												array(
													'type' => $trx_addons_properties_type,
													'columns' => $trx_addons_properties_columns,
													'slider' => false
												)
											);
			}
			wp_reset_postdata();

		?></div><!-- .sc_properties_columns_wrap --><?php

    ?></div><!-- .sc_properties --><?php

	the_posts_pagination( array(
		'mid_size'  => 2,
		'prev_text' => esc_html__( '<', 'trx_addons' ),
		'next_text' => esc_html__( '>', 'trx_addons' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'trx_addons' ) . ' </span>',
	) );

} else {

	trx_addons_get_template_part('templates/tpl.posts-none.php');

}

do_action('trx_addons_action_end_archive');

if ($trx_addons_need_reset_query) wp_reset_query();
?>