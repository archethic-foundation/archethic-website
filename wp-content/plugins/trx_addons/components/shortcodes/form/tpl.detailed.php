<?php
/**
 * The style "detailed" of the Contact form
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_form');
?><div
	<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> 
	class="sc_form sc_form_detailed<?php 
		if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
		if (!empty($args['align']) && !trx_addons_is_off($args['align'])) echo ' sc_align_'.esc_attr($args['align']); 
		?>"
	<?php if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"'; ?>
	><?php
	
	trx_addons_sc_show_titles('sc_form', $args);
	
	?><div class="<?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php

		// Contact form. Attention! Column's tags can't start from new line
		?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, 2)); ?>"><?php
				do_action('trx_addons_action_fields_start', $args);
				do_action('trx_addons_action_field_name', $args);
				do_action('trx_addons_action_field_email', $args);
				do_action('trx_addons_action_field_message', $args);
				do_action('trx_addons_action_field_send', $args);
				do_action('trx_addons_action_fields_end', $args);
		?></div><?php 
		
		// Contact data. Attention! Column's tags can't start from new line
		?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, 2)); ?>">
			<div class="sc_form_info"><?php
				if (!empty($args['phone'])) {
					$args['phone'] = explode('|', $args['phone']);
					?> 
					<div class="sc_form_info_item sc_form_info_item_phone">
						<span class="sc_form_info_icon"></span>
						<span class="sc_form_info_area">
							<span class="sc_form_info_title"><?php esc_html_e('Phone:', 'trx_addons'); ?></span>
							<span class="sc_form_info_data"><?php
								foreach ($args['phone'] as $item) {
									$item = trim($item);
									if (empty($item)) continue;
									echo '<a href="'.esc_attr(trx_addons_get_phone_link($item)).'">' . esc_html($item) . '</a>';
								}
							?></span>
						</span>
					</div>
					<?php
				}
				if (!empty($args['email'])) {
					$args['email'] = explode('|', $args['email']);
					?> 
					<div class="sc_form_info_item sc_form_info_item_email">
						<span class="sc_form_info_icon"></span>
						<span class="sc_form_info_area">
							<span class="sc_form_info_title"><?php esc_html_e('E-mail:', 'trx_addons'); ?></span>
						<span class="sc_form_info_data"><?php
							foreach ($args['email'] as $item) {
								$item = trim($item);
								if (empty($item)) continue;
								echo '<a href="'.(strpos($item, '@')!==false ? 'mailto:'.antispambot($item) : esc_url($item)).'">' 
										. (strpos($item, '@')!==false ? antispambot($item) : esc_html($item))
									. '</a>';
							}
						?></span>
						</span>
					</div>
					<?php
				}
				if (!empty($args['address'])) {
					$args['address'] = explode('|', $args['address']);
					?><div class="sc_form_info_item sc_form_info_item_address">
						<span class="sc_form_info_icon"></span>
						<span class="sc_form_info_area">
							<span class="sc_form_info_title"><?php esc_html_e('Address:', 'trx_addons'); ?></span>
							<span class="sc_form_info_data"><?php
								foreach ($args['address'] as $item) {
									$item = trim($item);
									if (empty($item)) continue;
									echo '<span>' . esc_html($item) . '</span>';
								}
							?></span>
						</span>
					</div><?php
				}
			?></div>
		</div>
	</div>
</div><!-- /.sc_form -->
