<?php
/**
 * The template to display the cars agents archive
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

get_header(); 

do_action('trx_addons_action_start_archive');

if (have_posts()) {

	$trx_addons_agents_style   = explode('_', trx_addons_get_option('cars_agents_style'));
	$trx_addons_agents_type    = $trx_addons_agents_style[0];
	$trx_addons_agents_columns = empty($trx_addons_agents_style[1]) ? 1 : max(1, $trx_addons_agents_style[1]);

	?><div class="sc_agents sc_agents_default sc_team sc_team_default">
		
		<div class="sc_agents_columns_wrap sc_team_columns_wrap sc_agents_columns_<?php
			echo esc_attr($trx_addons_agents_columns);
			if ($trx_addons_agents_columns > 1) echo ' '.esc_attr(trx_addons_get_columns_wrap_class()) . ' columns_padding_bottom';
		?>"><?php
		
			while ( have_posts() ) { the_post(); 
				trx_addons_get_template_part(array(
												TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.agents.'.trim($trx_addons_agents_type).'-item.php',
												TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.agents.default-item.php'
												),
												'trx_addons_args_sc_agents',
												array(
													'type' => $trx_addons_agents_type,
													'columns' => $trx_addons_agents_columns,
													'slider' => false
												)
											);
			}
	
		?></div><!-- .trx_addons_agents_columns_wrap --><?php

    ?></div><!-- .sc_agents --><?php

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

get_footer();
?>