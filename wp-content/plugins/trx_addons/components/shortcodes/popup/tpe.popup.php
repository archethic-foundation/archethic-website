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

extract(get_query_var('trx_addons_args_sc_popup'));
?><div id="{{ settings.popup_id }}" class="sc_popup sc_popup_{{ settings.type }}">{{{ settings.content }}}</div><!-- /.sc_popup -->