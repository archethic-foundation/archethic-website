<?php
/**
 * The style "default" of the Popup
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var('trx_addons_args_sc_popup');

?><div id="<?php echo esc_attr($args['id']); ?>"
		class="sc_popup sc_popup_<?php
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
			?>"<?php
		if ($args['css']!='') echo ' style="'.esc_attr($args['css']).'"';
?>><?php

	trx_addons_show_layout($args['content']);
	
?></div><!-- /.sc_popup -->