/**
 * Widget generator script
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.36
 */

(function(){
	"use strict";

	var widget_obj = null, widget_content = "\
<div id=\"{{uid}}\"></div>\n\
<script>\n\
	(function() {\n\
		var s = document.createElement('script');\n\
			s.type = 'text/javascript';\n\
			s.async = true;\n\
			s.src = '{{widget}}';\n\
			s.onload = function () {\n\
				new TRX_Addons_Widget_Themes({\n\
					downloads: '{{downloads}}',\n\
					uid: '{{uid}}',\n\
					logo: '{{logo}}',\n\
					logo_link: '{{logo_link}}',\n\
					style: '{{style}}',\n\
					font: '{{font}}',\n\
					mode: '{{mode}}',\n\
					method: '{{method}}',\n\
					affid: '{{affid}}',\n\
					affdata: '{{affdata}}',\n\
					captcha: '{{captcha}}',\n\
					title: '{{title}}',\n\
					market: [{{market}}],\n\
					category: [{{category}}],\n\
					page: 1,\n\
					count: {{count}},\n\
					columns: {{columns}},\n\
					orderby: '{{orderby}}',\n\
					order: '{{order}}',\n\
					ratio: '{{ratio}}',\n\
					accent1: '{{accent1}}',\n\
					accent2: '{{accent2}}',\n\
					accent3: '{{accent3}}',\n\
					hide_background: {{hide_background}},\n\
					hide_shadow: {{hide_shadow}},\n\
					hide_title: {{hide_title}},\n\
					hide_price: {{hide_price}},\n\
					hide_meta: {{hide_meta}},\n\
					hide_button: {{hide_buttons}},\n\
					hide_logo: {{hide_logo}},\n\
					hide_pagination: {{hide_pagination}},\n\
					hide_animation: {{hide_animation}},\n\
					msg_no_themes: '{{msg_no_themes}}',\n\
					msg_error_fields: '{{msg_error_fields}}',\n\
					msg_error_service_unavailable: '{{msg_error_service_unavailable}}',\n\
					msg_error_incorrect_answer: '{{msg_error_incorrect_answer}}',\n\
					msg_error_wait_for_answer: '{{msg_error_wait_for_answer}}',\n\
					msg_order_accepted: '{{msg_order_accepted}}',\n\
					msg_error_unsupported_platform: '{{msg_error_unsupported_platform}}',\n\
					msg_order_site: '{{msg_order_site}}',\n\
					msg_order_now: '{{msg_order_now}}',\n\
					msg_buy_now: '{{msg_buy_now}}',\n\
					msg_view_demo: '{{msg_view_demo}}',\n\
					msg_field_label_name: '{{msg_field_label_name}}',\n\
					msg_field_placeholder_name: '{{msg_field_placeholder_name}}',\n\
					msg_field_label_email: '{{msg_field_label_email}}',\n\
					msg_field_placeholder_email: '{{msg_field_placeholder_email}}',\n\
					msg_field_label_phone: '{{msg_field_label_phone}}',\n\
					msg_field_placeholder_phone: '{{msg_field_placeholder_phone}}',\n\
					msg_field_label_message: '{{msg_field_label_message}}',\n\
					msg_field_placeholder_message: '{{msg_field_placeholder_message}}',\n\
					msg_field_button_order: '{{msg_field_button_order}}',\n\
					msg_email_subject: '{{msg_email_subject}}',\n\
					msg_email_text: '{{msg_email_text}}'\n\
				});\n\
		};\n\
		var h = document.getElementsByTagName('script')[0];\n\
		h.parentNode.insertBefore(s, h);\n\
	})();\n\
</script>\
";

	jQuery(document).ready(function() {
		jQuery('.widget_generator_preview_code_copy').on('click', function(e) {
			jQuery('.widget_generator_preview_code_text').select();
			try {
				var rez = document.execCommand('copy');
				alert(TRX_ADDONS_WIDGET_GENERATOR['msg_clipboard_'+(rez ? 'success' : 'error')]);
			} catch (err) {
				alert(TRX_ADDONS_WIDGET_GENERATOR['msg_clipboard_unable']);
			}
			e.preventDefault();
			return false;
		});
		trx_addons_widget_generator_update(jQuery('.sc_form_field_mode input[name="mode"]').eq(0));
		jQuery('.widget_generator_form input, .widget_generator_form select').on('change', function() {
			trx_addons_widget_generator_update(jQuery(this));
		});
	});
	
	// Encode email
	function trx_addons_widget_generator_encode(s) {
		var rez = '', limit=20;
		for (var i=0; i<s.length; i++) {
			rez += String.fromCharCode(s.charCodeAt(i)+((i+1)%limit));
		}
		return rez;
	}
	
	// Get new parameters
	function trx_addons_widget_generator_get_values() {
		// Detect current page or 1 (if first run)
		var page = Math.max(1, Number(jQuery('.trx_addons_widget_themes_pagination').data('page')));
		if (isNaN(page)) page = 1;
		// Get data from fields
		var data = {
			style: jQuery('input[name="style"]:checked').val(),
			font: jQuery('input[name="font"]').val(),
			mode: jQuery('input[name="mode"]:checked').val(),
			method: jQuery('select[name="method"]').val(),
			affid: jQuery('input[name="affid"]').val(),
			affdata: trx_addons_widget_generator_encode(jQuery('input[name="affdata"]').val()),
			captcha: jQuery('input[name="captcha"]').val(),
			title: jQuery('input[name="title"]').val(),
			page: 1,	//page
			count: jQuery('input[name="count"]').val(),
			columns: jQuery('input[name="columns"]').val(),
			market: jQuery('select[name="market"]').val(),
			category: jQuery('select[name="category"]').val(),
			orderby: jQuery('select[name="orderby"]').val(),
			order: jQuery('select[name="order"]').val(),
			ratio: jQuery('input[name="ratio"]:checked').val(),
			accent1: jQuery('input[name="accent1"]').val(),
			accent2: jQuery('input[name="accent2"]').val(),
			accent3: jQuery('input[name="accent3"]').val(),
			hide_background: jQuery('input[name="hide_background"]:checked').length,
			hide_shadow: jQuery('input[name="hide_shadow"]:checked').length,
			hide_title: jQuery('input[name="hide_title"]:checked').length,
			hide_price: jQuery('input[name="hide_price"]:checked').length,
			hide_meta: jQuery('input[name="hide_meta"]:checked').length,
			hide_buttons: jQuery('input[name="hide_buttons"]:checked').length,
			hide_logo: jQuery('input[name="hide_logo"]:checked').length,
			hide_pagination: jQuery('input[name="hide_pagination"]:checked').length,
			hide_animation: jQuery('input[name="hide_animation"]:checked').length,
			widget: TRX_ADDONS_WIDGET_GENERATOR['widget_url'],
			downloads: TRX_ADDONS_WIDGET_GENERATOR['downloads_url'],
			uid: TRX_ADDONS_WIDGET_GENERATOR['uid'],
			logo: TRX_ADDONS_WIDGET_GENERATOR['logo'],
			logo_link: TRX_ADDONS_WIDGET_GENERATOR['logo_link'],
			msg_no_themes: TRX_ADDONS_WIDGET_GENERATOR['msg_no_themes'],
			msg_error_fields: TRX_ADDONS_WIDGET_GENERATOR['msg_error_fields'],
			msg_error_service_unavailable: TRX_ADDONS_WIDGET_GENERATOR['msg_error_service_unavailable'],
			msg_error_incorrect_answer: TRX_ADDONS_WIDGET_GENERATOR['msg_error_incorrect_answer'],
			msg_error_wait_for_answer: TRX_ADDONS_WIDGET_GENERATOR['msg_error_wait_for_answer'],
			msg_order_accepted: TRX_ADDONS_WIDGET_GENERATOR['msg_order_accepted'],
			msg_error_unsupported_platform: TRX_ADDONS_WIDGET_GENERATOR['msg_error_unsupported_platform'],
			msg_order_site: TRX_ADDONS_WIDGET_GENERATOR['msg_order_site'],
			msg_order_now: TRX_ADDONS_WIDGET_GENERATOR['msg_order_now'],
			msg_buy_now: TRX_ADDONS_WIDGET_GENERATOR['msg_buy_now'],
			msg_view_demo: TRX_ADDONS_WIDGET_GENERATOR['msg_view_demo'],
			msg_field_label_name: TRX_ADDONS_WIDGET_GENERATOR['msg_field_label_name'],
			msg_field_placeholder_name: TRX_ADDONS_WIDGET_GENERATOR['msg_field_placeholder_name'],
			msg_field_label_email: TRX_ADDONS_WIDGET_GENERATOR['msg_field_label_email'],
			msg_field_placeholder_email: TRX_ADDONS_WIDGET_GENERATOR['msg_field_placeholder_email'],
			msg_field_label_phone: TRX_ADDONS_WIDGET_GENERATOR['msg_field_label_phone'],
			msg_field_placeholder_phone: TRX_ADDONS_WIDGET_GENERATOR['msg_field_placeholder_phone'],
			msg_field_label_message: TRX_ADDONS_WIDGET_GENERATOR['msg_field_label_message'],
			msg_field_placeholder_message: TRX_ADDONS_WIDGET_GENERATOR['msg_field_placeholder_message'],
			msg_field_button_order: TRX_ADDONS_WIDGET_GENERATOR['msg_field_button_order'],
			msg_email_subject: TRX_ADDONS_WIDGET_GENERATOR['msg_email_subject'],
			msg_email_text: TRX_ADDONS_WIDGET_GENERATOR['msg_email_text']
		};
		if (!data.market) data.market = '';
		if (!data.category) data.category = '';
		return data;
	}
	
	// Update preview area with new parameters
	function trx_addons_widget_generator_update(fld) {
		// Get data from fields
		var data = trx_addons_widget_generator_get_values();
		// Update js code in textarea
		var src = widget_content
						.replace(/\{\{widget\}\}/g, data.widget)
						.replace(/\{\{downloads\}\}/g, data.downloads)
						.replace(/\{\{uid\}\}/g, data.uid)
						.replace(/\{\{style\}\}/g, data.style)
						.replace(/\{\{font\}\}/g, data.font)
						.replace(/\{\{mode\}\}/g, data.mode)
						.replace(/\{\{method\}\}/g, data.method)
						.replace(/\{\{logo\}\}/g, data.logo)
						.replace(/\{\{logo_link\}\}/g, data.logo_link)
						.replace(/\{\{msg_no_themes\}\}/g, data.msg_no_themes)
						.replace(/\{\{msg_error_fields\}\}/g, data.msg_error_fields)
						.replace(/\{\{msg_error_service_unavailable\}\}/g, data.msg_error_service_unavailable)
						.replace(/\{\{msg_error_incorrect_answer\}\}/g, data.msg_error_incorrect_answer)
						.replace(/\{\{msg_error_wait_for_answer\}\}/g, data.msg_error_wait_for_answer)
						.replace(/\{\{msg_order_accepted\}\}/g, data.msg_order_accepted)
						.replace(/\{\{msg_error_unsupported_platform\}\}/g, data.msg_error_unsupported_platform)
						.replace(/\{\{msg_order_site\}\}/g, data.msg_order_site)
						.replace(/\{\{msg_order_now\}\}/g, data.msg_order_now)
						.replace(/\{\{msg_buy_now\}\}/g, data.msg_buy_now)
						.replace(/\{\{msg_view_demo\}\}/g, data.msg_view_demo)
						.replace(/\{\{msg_field_label_name\}\}/g, data.msg_field_label_name)
						.replace(/\{\{msg_field_placeholder_name\}\}/g, data.msg_field_placeholder_name)
						.replace(/\{\{msg_field_label_email\}\}/g, data.msg_field_label_email)
						.replace(/\{\{msg_field_placeholder_email\}\}/g, data.msg_field_placeholder_email)
						.replace(/\{\{msg_field_label_phone\}\}/g, data.msg_field_label_phone)
						.replace(/\{\{msg_field_placeholder_phone\}\}/g, data.msg_field_placeholder_phone)
						.replace(/\{\{msg_field_label_message\}\}/g, data.msg_field_label_message)
						.replace(/\{\{msg_field_placeholder_message\}\}/g, data.msg_field_placeholder_message)
						.replace(/\{\{msg_field_button_order\}\}/g, data.msg_field_button_order)
						.replace(/\{\{msg_email_subject\}\}/g, data.msg_email_subject)
						.replace(/\{\{msg_email_text\}\}/g, data.msg_email_text)
						.replace(/\{\{affid\}\}/g, data.affid)
						.replace(/\{\{affdata\}\}/g, data.affdata)
						.replace(/\{\{captcha\}\}/g, data.captcha)
						.replace(/\{\{title\}\}/g, data.title)
						.replace(/\{\{market\}\}/g, data.market)
						.replace(/\{\{category\}\}/g, data.category)
						.replace(/\{\{count\}\}/g, data.count)
						.replace(/\{\{columns\}\}/g, data.columns)
						.replace(/\{\{orderby\}\}/g, data.orderby)
						.replace(/\{\{order\}\}/g, data.order)
						.replace(/\{\{ratio\}\}/g, data.ratio)
						.replace(/\{\{accent1\}\}/g, data.accent1)
						.replace(/\{\{accent2\}\}/g, data.accent2)
						.replace(/\{\{accent3\}\}/g, data.accent3)
						.replace(/\{\{hide_background\}\}/g, data.hide_background)
						.replace(/\{\{hide_shadow\}\}/g, data.hide_shadow)
						.replace(/\{\{hide_title\}\}/g, data.hide_title)
						.replace(/\{\{hide_price\}\}/g, data.hide_price)
						.replace(/\{\{hide_meta\}\}/g, data.hide_meta)
						.replace(/\{\{hide_buttons\}\}/g, data.hide_buttons)
						.replace(/\{\{hide_logo\}\}/g, data.hide_logo)
						.replace(/\{\{hide_pagination\}\}/g, data.hide_pagination)
						.replace(/\{\{hide_animation\}\}/g, data.hide_animation);
		jQuery('.widget_generator_preview_code > textarea').val(src);
		// Check fields visibility:
		if (fld.attr('name') == 'mode') {
			if (fld.val()=='widget') {
				jQuery('.sc_form_field_affid').show();
				jQuery('.sc_form_field_method').hide();
				//jQuery('.sc_form_field_hide_buttons').hide();
			} else {
				jQuery('.sc_form_field_affid').hide();
				jQuery('.sc_form_field_method').show();
				//jQuery('.sc_form_field_hide_buttons').show();
			}
		}
		// E-mail
		if (jQuery('.sc_form_field_mode input:checked').val()=='showcase' && jQuery('.sc_form_field_method select').val() == 'web')
			jQuery('.sc_form_field_affdata').show();
		else
			jQuery('.sc_form_field_affdata').hide();
		// Captcha
		if (jQuery('.sc_form_field_mode input:checked').val()=='showcase' && jQuery('.sc_form_field_method select').val() == 'popup') {
			jQuery('.sc_form_field_captcha').show();
			jQuery('.widget_generator_download_widget').show();
		} else {
			jQuery('.sc_form_field_captcha').hide();
			jQuery('.widget_generator_download_widget').hide();
		}
		// Refresh preview area
		if (typeof TRX_Addons_Widget_Themes != 'undefined') {
			if (!widget_obj)
				widget_obj = new TRX_Addons_Widget_Themes(data);
			else
				widget_obj.show(data);
		}
	}

})();