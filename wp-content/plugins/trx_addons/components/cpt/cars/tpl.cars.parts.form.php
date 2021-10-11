<?php
/**
 * The template's part to display the agent's or author's contact form
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

$trx_addons_args = get_query_var('trx_addons_args_cars_form');
$trx_addons_meta = $trx_addons_args['meta'];
$trx_addons_agent = $trx_addons_args['agent'];

$form_style = $trx_addons_args['style'] = empty($trx_addons_args['style']) || trx_addons_is_inherit($trx_addons_args['style']) 
					? trx_addons_get_option('input_hover') 
					: $trx_addons_args['style'];

?><div class="sc_form cars_page_agent_form">
	<h5 class="cars_page_agent_form_title"><?php printf(esc_html__('Contact %s', 'trx_addons'), $trx_addons_agent['name']); ?></h5>
	<form class="sc_form_form <?php
				if ($form_style != 'default') echo 'sc_input_hover_'.esc_attr($form_style);
				?>" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<input type="hidden" name="car_agent" value="<?php
				echo esc_attr($trx_addons_meta['agent_type']=='author' ? -get_the_author_meta('ID') : $trx_addons_meta['agent']); ?>">
		<input type="hidden" name="car_id" value="<?php
				echo esc_attr(is_single() && get_post_type()==TRX_ADDONS_CPT_CARS_PT ? get_the_ID() : ''); ?>">
		<?php
		// Field 'Name'
		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
										'trx_addons_args_sc_form_field',
										array_merge($trx_addons_args, array(
													'field_name'  => 'name',
													'field_type'  => 'text',
													'field_req'   => true,
													'field_icon'  => 'trx_addons_icon-user-alt',
													'field_title' => __('Name', 'trx_addons'),
													'field_placeholder' => __('Your name', 'trx_addons')
													))
									);
		// Field 'E-mail'
		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
										'trx_addons_args_sc_form_field',
										array_merge($trx_addons_args, array(
													'field_name'  => 'email',
													'field_type'  => 'text',
													'field_req'   => true,
													'field_icon'  => 'trx_addons_icon-mail',
													'field_title' => __('E-mail', 'trx_addons'),
													'field_placeholder' => __('Your e-mail', 'trx_addons')
													))
									);
		// Field 'Phone'
		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
										'trx_addons_args_sc_form_field',
										array_merge($trx_addons_args, array(
													'field_name'  => 'phone',
													'field_type'  => 'text',
													'field_req'   => true,
													'field_icon'  => 'trx_addons_icon-phone',
													'field_title' => __('Phone', 'trx_addons'),
													'field_placeholder' => __('Your phone', 'trx_addons')
													))
									);
		// Field 'Message'
		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
										'trx_addons_args_sc_form_field',
										array_merge($trx_addons_args, array(
													'field_name'  => 'message',
													'field_type'  => 'textarea',
													'field_req'   => true,
													'field_icon'  => 'trx_addons_icon-feather',
													'field_title' => __('Message', 'trx_addons'),
													'field_placeholder' => __('Your message', 'trx_addons'),
													'field_value' => is_single() && get_post_type()==TRX_ADDONS_CPT_CARS_PT
														? sprintf(__("Hi, %s.\nI'm interested in '%s' [ID = %s].\nPlease, get in touch with me.", 'trx_addons'),
															$trx_addons_agent['name'], get_the_title(), $trx_addons_meta['id'])
														: sprintf(__("Hi, %s.\nI saw your profile on '%s' and wanted to see if you could help me.", 'trx_addons'),
															$trx_addons_agent['name'], get_bloginfo('name'))
													))
									);
		?>
		<div class="sc_form_field sc_form_field_button"><button><?php esc_html_e('Send Message', 'trx_addons'); ?></button></div>
		<div class="trx_addons_message_box sc_form_result"></div>
	</form>
</div><!-- /.sc_form -->