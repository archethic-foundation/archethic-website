<?php
/**
 * The style "default" of the Widget "Socials"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var('trx_addons_args_widget_socials');
extract($args);

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);
	
// Widget body
if ($description) {
	?><div class="socials_description"><?php echo wpautop($description); ?></div><?php
}

// Display widget body
if ( ($output = trx_addons_get_socials_links()) != '') {
	?><div class="socials_wrap<?php if (!empty($align)) echo ' sc_align_'.esc_attr($align); ?>"><?php trx_addons_show_layout($output); ?></div><?php
}
	
// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>