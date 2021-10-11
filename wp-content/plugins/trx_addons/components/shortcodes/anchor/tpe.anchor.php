<?php
/**
 * Template to represent shortcode as a widget in the Elementor preview area
 *
 * Written as a Backbone JavaScript template and using to generate the live preview in the Elementor's Editor
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.41
 */

$args = get_query_var('trx_addons_args_sc_anchor');
?><#
// Default values
settings = trx_addons_array_merge({
									'type':	'default',
									'icon':	'',
									'url':	{'url': ''},
									'anchor_id': '',
									'title':''
									}, settings);
// Check values
if (settings.anchor_id == '') settings.anchor_id = (''+Math.random()).replace('.', '');

// Anchor's tag attributes
var atts = {
	'class': "sc_anchor sc_anchor_" + settings.type,
	'data-vc-icon': settings.icon,
	'data-url': settings.url.url
};

#><a id="sc_anchor_{{ settings.anchor_id }}" title="{{ settings.title }}"<#
	for (var k in atts) {
		print(' '+k+'="' + atts[k] + '"');
	}
#>></a>