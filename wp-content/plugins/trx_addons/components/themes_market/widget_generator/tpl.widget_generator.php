<?php
/**
 * The template to display the Widget Generator
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.34
 */

/*
Template Name: Widget Generator
*/

get_header();

// Get template page's content
$trx_addons_page_content = '';
$trx_addons_content_mask = '%%CONTENT%%';
$trx_addons_content_subst = sprintf('<div class="widget_generator_data">%s</div>', $trx_addons_content_mask);
if ( have_posts() ) { the_post(); 
	if (($trx_addons_page_content = apply_filters('the_content', get_the_content())) != '') {
		if (($trx_addons_pos = strpos($trx_addons_page_content, $trx_addons_content_mask)) !== false) {
			$trx_addons_page_content = preg_replace('/(\<p\>\s*)?'.$trx_addons_content_mask.'(\s*\<\/p\>)/i', $trx_addons_content_subst, $trx_addons_page_content);
		} else
			$trx_addons_page_content .= $trx_addons_content_subst;
		$trx_addons_page_content = explode($trx_addons_content_mask, $trx_addons_page_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) trx_addons_add_inline_css(strip_tags($vc_custom_css));
	}
}

?>
<article id="trx_addons_widget_generator" <?php post_class( 'widget_generator_page itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

	<?php
	do_action('trx_addons_action_before_article', 'widget_generator_page');
	trx_addons_show_layout($trx_addons_page_content[0]);
	?>
		
	<section class="widget_generator_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>>
		<div class="<?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?>"><?php
			// Form
			$trx_addons_args = array(
				'style' => 'accent'	//trx_addons_get_option('input_hover')
			);
			?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, 3)); ?>">
				<h4 class="widget_generator_form_title"><?php esc_html_e('Widget parameters:', 'trx_addons'); ?></h4>
				<form name="widget_generator_form" class="widget_generator_form sc_form_form sc_form_custom <?php
					if ($trx_addons_args['style'] != 'default') echo 'sc_input_hover_'.esc_attr($trx_addons_args['style']);
				?>"><?php
					// Title
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
											'trx_addons_args_sc_form_field',
											array_merge($trx_addons_args, array(
														'labels'      => true,
														'field_name'  => 'title',
														'field_type'  => 'text',
														'field_value' => '',
														'field_req'   => false,
														'field_icon'  => 'trx_addons_icon-wpforms',
														'field_title' => __('Title', 'trx_addons'),
														'field_placeholder' => __('Title', 'trx_addons')
														))
										);

					// Mode
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'mode',
																'field_type'  => 'radio',
																'field_value' => 'widget',
																'field_title' => __('Mode', 'trx_addons'),
																'field_options'  => array(
																					'widget' => __('Widget', 'trx_addons'),
																					'showcase' => __('Showcase', 'trx_addons')
																					),
																'field_tooltip' => __('Select the operating mode: "Widget" - elements referred to our marketplace with your affiliate ID, "Showcase" - when you select an item the user fills in the order form that will be sent to the specified e-mail', 'trx_addons'),
																))
												);

					// Affiliate ID
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'affid',
																'field_type'  => 'text',
																'field_value' => '',
																'field_req'   => false,
																'field_icon'  => 'trx_addons_icon-user-alt',
																'field_title' => __('Affiliate link', 'trx_addons'),
																'field_placeholder' => __('Affiliate link', 'trx_addons'),
																'field_tooltip' => __('Parameter added to the URL containing your affiliate ID for the selected marketplace. For example: ref=johnsnow', 'trx_addons'),
																))
												);

					// Send mail method
					$list = trx_addons_get_list_terms(false, TRX_ADDONS_EDD_TAXONOMY_MARKET);
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'method',
																'field_type'  => 'select2',
																'field_multiple' => false,
																'field_value' => 'popup',
																'field_req'   => false,
																'field_title' => __('Send mail', 'trx_addons'),
																'field_options'  => array(
																					'popup' => __('Popup form', 'trx_addons'),
																					'web' => __('Web interface', 'trx_addons')
																					),
																'field_tooltip' => __('How to send your order: via the web interface mail website visitor or via a popup form?', 'trx_addons'),
																))
												);

					// E-mail to send order
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'affdata',
																'field_type'  => 'text',
																'field_value' => '',
																'field_req'   => false,
																'field_icon'  => 'trx_addons_icon-mail',
																'field_title' => __('E-mail', 'trx_addons'),
																'field_placeholder' => __('Your e-mail', 'trx_addons'),
																'field_tooltip' => __('E-mail to send the order from the showcase', 'trx_addons'),
																))
												);

					// reCAPTCHA 2 public key
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'captcha',
																'field_type'  => 'text',
																'field_value' => '',
																'field_req'   => false,
																'field_icon'  => 'trx_addons_icon-check',
																'field_title' => __('reCAPTCHA key', 'trx_addons'),
																'field_placeholder' => __('Public key', 'trx_addons'),
																'field_tooltip' => __('The public key from the Google reCAPTCHA 2 service', 'trx_addons'),
																))
												);

					// Market
					$list = trx_addons_get_list_terms(false, TRX_ADDONS_EDD_TAXONOMY_MARKET);
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'market',
																'field_type'  => 'select2',
																'field_multiple' => true,
																'field_value' => 0,
																'field_req'   => false,
																'field_title' => __('Marketplace', 'trx_addons'),
																'field_options'  => $list,
																))
												);

					// Category
					$list = trx_addons_get_list_terms(false, TRX_ADDONS_EDD_TAXONOMY_CATEGORY);
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'category',
																'field_type'  => 'select2',
																'field_multiple' => true,
																'field_value' => 0,
																'field_req'   => false,
																'field_title' => __('Category', 'trx_addons'),
																'field_options'  => $list
																))
												);

					// Count
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'count',
																'field_type'  => 'slider',
																'field_min'   => 1,
																'field_max'   => 25,
																'field_value' => 4,
																'field_title' => __('Count', 'trx_addons')
																))
												);

					// Columns
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'columns',
																'field_type'  => 'slider',
																'field_min'   => 1,
																'field_max'   => 5,
																'field_value' => 2,
																'field_title' => __('Columns', 'trx_addons')
																))
												);

					// Orderby
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'orderby',
																'field_type'  => 'select2',
																'field_value' => 'date',
																'field_title' => __('Order by', 'trx_addons'),
																'field_options'  => trx_addons_get_list_sc_query_orderby('', 'date,update,title,random')
																))
												);

					// Order
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'order',
																'field_type'  => 'select2',
																'field_value' => 'desc',
																'field_title' => __('Order', 'trx_addons'),
																'field_options'  => trx_addons_get_list_sc_query_orders()
																))
												);

					?><h6 class="widget_generator_form_title"><?php esc_html_e('Style your widget:', 'trx_addons'); ?></h6><?php
					
					// Style
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'style',
																'field_type'  => 'radio',
																'field_value' => 'modern',
																'field_title' => __('Style', 'trx_addons'),
																'field_options'  => array(
																					'modern' => __('Modern', 'trx_addons'),
																					'classic' => __('Classic', 'trx_addons')
																					)
																))
												);

					// Google font
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'font',
																'field_type'  => 'text',
																'field_value' => '',
																'field_req'   => false,
																'field_icon'  => 'trx_addons_icon-google',
																'field_title' => __('Google font', 'trx_addons'),
																'field_placeholder' => __('Font family', 'trx_addons'),
																'field_tooltip' => __('A font family from the Google fonts set to display titles and meta-data in the widget. If empty - inherit font family from the site', 'trx_addons'),
																))
												);

					// Image ratio
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'ratio',
																'field_type'  => 'radio',
																'field_value' => '1_1',
																'field_title' => __('Ratio', 'trx_addons'),
																'field_options'  => array(
																					'16_9'	=> __('16:9', 'trx_addons'),
																					'4_3'	=> __('4:3', 'trx_addons'),
																					'1_1'	=> __('1:1', 'trx_addons'),
																					'3_4'	=> __('3:4', 'trx_addons'),
																					'9_16'	=> __('9:16', 'trx_addons'),
																					)
																))
												);

					// Accent color 1
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'accent1',
																'field_type'  => 'color',
																'field_style' => 'internal',
																'field_value' => '#14e27f',
																'field_title' => __('Accent color 1', 'trx_addons'),
																))
												);

					// Accent color 2
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'accent2',
																'field_type'  => 'color',
																'field_style' => 'internal',
																'field_value' => '#0a1d33',
																'field_title' => __('Accent color 2', 'trx_addons'),
																))
												);

					// Accent color 3
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'accent3',
																'field_type'  => 'color',
																'field_style' => 'internal',
																'field_value' => '#fa4c77',
																'field_title' => __('Accent color 3', 'trx_addons'),
																))
												);
				
					// Hide background
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_background',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => __('Hide:', 'trx_addons'),
																'field_placeholder' => __('Hide background', 'trx_addons'),
																))
												);
				
					// Hide shadow
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_shadow',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide shadow', 'trx_addons'),
																))
												);
				
					// Hide title
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_title',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide title', 'trx_addons'),
																))
												);
				
					// Hide price
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_price',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide price', 'trx_addons'),
																))
												);
				
					// Hide meta
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_meta',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide date and version', 'trx_addons'),
																))
												);
				
					// Hide buttons
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_buttons',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide buttons', 'trx_addons'),
																))
												);
				
					// Hide logo
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_logo',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide logo', 'trx_addons'),
																))
												);
				
					// Hide pagination
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_pagination',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Hide pagination', 'trx_addons'),
																))
												);
				
					// Disable animation
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . 'form/tpl.form-field.php',
													'trx_addons_args_sc_form_field',
													array_merge($trx_addons_args, array(
																'labels'      => true,
																'field_name'  => 'hide_animation',
																'field_type'  => 'checkbox',
																'field_value' => 0,
																'field_title' => ' ',
																'field_placeholder' => __('Disable animation', 'trx_addons'),
																))
												);
					
				?></form>
			</div><?php

			// Preview
			?><div class="<?php echo esc_attr(trx_addons_get_column_class(2, 3)); ?>">
				<div class="widget_generator_preview"><?php
					
					// Devices selector
					?><div class="widget_generator_preview_devices"><?php
						// Desktop
						?><span class="widget_generator_preview_devices_desktop trx_addons_icon-desktop"></span><?php
						// Laptop
						?><span class="widget_generator_preview_devices_laptop trx_addons_icon-laptop"></span><?php
						// Tablet
						?><span class="widget_generator_preview_devices_tablet trx_addons_icon-tablet"></span><?php
						// Mobile
						?><span class="widget_generator_preview_devices_mobile trx_addons_icon-mobile"></span><?php
					?></div><?php
					
					// Widgets list
					?><div id="<?php echo esc_attr($GLOBALS['TRX_ADDONS_STORAGE']['widget_generator_uid']); ?>" class="widget_generator_preview_widgets"></div><?php
					
					// Textarea with widget's code
					?><div class="widget_generator_preview_code">
						<h4 class="widget_generator_preview_code_title"><?php
							esc_html_e('Insert the code below on the your homepage', 'trx_addons');
						?><a href="#" class="widget_generator_preview_code_copy"><?php esc_html_e('Copy', 'trx_addons'); ?></a></h4>
						<textarea class="widget_generator_preview_code_text" rows="10" cols="100" readonly></textarea>
					</div><?php
					
					// The link for downloading widget.themes.zip
					?><div class="widget_generator_download_widget">
						<h4 class="widget_generator_download_widget_title"><?php
							esc_html_e('And download archive (instruction inside)', 'trx_addons');
						?></h4>
						<a href="<?php echo esc_url(trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEMES_MARKET . 'widget_generator/widget.themes.zip')); ?>" class="widget_generator_download_widget_link sc_button theme_button"><?php esc_html_e('Download archive', 'trx_addons'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	trx_addons_show_layout($trx_addons_page_content[1]);
	do_action('trx_addons_action_after_article', 'widget_generator_page');
	?>

</article>

<?php get_footer(); ?>