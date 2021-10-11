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

extract(get_query_var('trx_addons_args_sc_table'));
?><#

if (settings.content != '') {
	var id = settings._element_id ? settings._element_id + '_sc' : 'sc_table_'+(''+Math.random()).replace('.', '');
	#><div id="{{ id }}_wrap" class="sc_table_wrap">
		<?php $element->sc_show_titles('sc_table'); ?>
		<div id="{{ id }}"
			class="sc_table sc_table_{{ settings.type }}<#
					if (!trx_addons_is_off(settings.align)) print(' align'+settings.align);
					#>">{{{ settings.content }}}</div>
		<?php $element->sc_show_links('sc_table'); ?>
	</div><!-- /.sc_table_wrap --><#
}
#>