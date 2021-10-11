<?php
/**
 * The style "default" of the Login link
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

$args = get_query_var('trx_addons_args_sc_layouts_login');

?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_layouts_login sc_layouts_menu sc_layouts_menu_default<?php
		trx_addons_cpt_layouts_sc_add_classes($args);
	?>"<?php
	if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"'; ?>><?php

	do_action('trx_addons_action_login', $args);
	
?></div><!-- /.sc_layouts_login --><?php

trx_addons_sc_layouts_showed('login', true);
?>