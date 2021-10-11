<?php
/**
 * The style "default" of the Menu
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

$args = get_query_var('trx_addons_args_sc_layouts_menu');

$is_ubermenu = !empty($args['location']) && function_exists('trx_addons_ubermenu_check_location') && trx_addons_ubermenu_check_location($args['location']);

$trx_addons_menu = !empty($args['location']) || !empty($args['menu']) ? trx_addons_get_nav_menu($args['location'], $args['menu']) : '';
if (!empty($trx_addons_menu)) {
	// Store menu layout for the mobile menu
	if (trx_addons_is_on($args['mobile_menu'])) trx_addons_sc_layouts_menu_add_to_mobile_menu($trx_addons_menu);
	// Show menu
	if ($is_ubermenu) {
		?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"';
				?> class="sc_layouts_menu_uber<?php
						trx_addons_cpt_layouts_sc_add_classes($args);
						?>"<?php
				if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
			?>><?php
			trx_addons_show_layout($trx_addons_menu);
		?></div><!-- /.sc_layouts_menu --><?php
	} else {
		?><nav class="sc_layouts_menu sc_layouts_menu_<?php
					echo esc_attr($args['type']);
					echo ' sc_layouts_menu_dir_'.esc_attr($args['direction']);
					if (!empty($args['hover'])) echo ' menu_hover_'.esc_attr($args['hover']);
					trx_addons_cpt_layouts_sc_add_classes($args);
					?>"<?php
				trx_addons_seo_snippets('', 'SiteNavigationElement');
				if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"';
				if (!empty($args['animation_in'])) echo ' data-animation-in="'.esc_attr($args['animation_in']).'"';
				if (!empty($args['animation_out'])) echo ' data-animation-out="'.esc_attr($args['animation_out']).'"';
				if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
				?>
		><?php
			trx_addons_show_layout($trx_addons_menu);
		?></nav><!-- /.sc_layouts_menu --><?php
	}
	trx_addons_sc_layouts_showed('menu', true);
}
// Add button to open mobile menu
if (trx_addons_is_on($args['mobile_button']) && !$is_ubermenu) {
	?><div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
		<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
			<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
		</a>
	</div><?php
	trx_addons_sc_layouts_showed('menu_button', true);
}
?>