<?php
/**
 * The style "default" of the Layouts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.06
 */

$args = get_query_var('trx_addons_args_sc_layouts');
if (!empty($args['layout'])) {
	?><div <?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?>
		class="sc_layouts sc_layouts_<?php echo esc_attr($args['type']); ?> sc_layouts_<?php echo esc_attr($args['layout']);
				if (!empty($args['class'])) echo ' '.esc_attr($args['class']); ?>"><?php
		trx_addons_cpt_layouts_show_layout($args['layout']);
	?></div><?php
}
?>