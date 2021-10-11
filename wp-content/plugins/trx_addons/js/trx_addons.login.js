/**
 * Login and Register
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).on('action.ready_trx_addons', function() {

	"use strict";

/*
	// Show/Hide user menu
	if (jQuery('.trx_addons_login_link:not(.inited)').length > 0) {
		jQuery('.trx_addons_login_link:not(.inited)').addClass('inited').on('click', function(e){
			jQuery(this).find('.trx_addons_login_menu').slideToggle().parent().toggleClass('menu_opened');
			e.preventDefault();
			return false;
		});
		jQuery('body').on('click', function(e){
			jQuery(this).find('.trx_addons_login_menu:visible').slideUp().parent().removeClass('menu_opened');
		});
	}
*/

	// Validate Login form
	jQuery('form.trx_addons_popup_form_login:not(.inited)').addClass('inited').submit(function(e){
		var rez = trx_addons_login_validate(jQuery(this));
		if (!rez)
			e.preventDefault();
		return rez;
	});
	
	// Validate Registration form
	jQuery('form.trx_addons_popup_form_register:not(.inited)').addClass('inited').submit(function(e){
		var rez = trx_addons_registration_validate(jQuery(this));
		if (!rez)
			e.preventDefault();
		return rez;
	});
	
	// Login form validation
	function trx_addons_login_validate(form) {
		form.find('input').removeClass('trx_addons_field_error');
		var error = trx_addons_form_validate(form, {
			error_message_time: 4000,
			exit_after_first_error: true,
			rules: [
				{
					field: "log",
					min_length: { value: 1, message: TRX_ADDONS_STORAGE['msg_login_empty'] },
					max_length: { value: 60, message: TRX_ADDONS_STORAGE['msg_login_long'] }
				},
				{
					field: "pwd",
					min_length: { value: 1, message: TRX_ADDONS_STORAGE['msg_password_empty'] },
					max_length: { value: 60, message: TRX_ADDONS_STORAGE['msg_password_long'] }
				}
			]
		});
		if (TRX_ADDONS_STORAGE['login_via_ajax'] && !error) {
			jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
				action: 'trx_addons_login_user',
				nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
				redirect_to: form.find('input[name="redirect_to"]').length == 1 ? form.find('input[name="redirect_to"]').val() : '',
				remember: form.find('input[name="rememberme"]').val(),
				user_log: form.find('input[name="log"]').val(),
				user_pwd: form.find('input[name="pwd"]').val()
			}).done(function(response) {
				var rez = {};
				try {
					rez = JSON.parse(response);
				} catch(e) {
					rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
					console.log(response);
				}
				var result = form.find(".trx_addons_message_box").toggleClass("trx_addons_message_box_error", false).toggleClass("trx_addons_message_box_success", false);
				if (rez.error === '') {
					result.addClass("trx_addons_message_box_success").html(TRX_ADDONS_STORAGE['msg_login_success']);
					setTimeout(function() { 
						if (rez.redirect_to != '') {
							location.href = rez.redirect_to;
						} else {
							location.reload(true); 
						}
					}, 3000);
				} else {
					result.addClass("trx_addons_message_box_error").html(TRX_ADDONS_STORAGE['msg_login_error'] + (rez.error!==undefined ?  '<br>' + rez.error : ''));
				}
				result.fadeIn().delay(3000).fadeOut();
			});
		}
		return !TRX_ADDONS_STORAGE['login_via_ajax'] && !error;
	}
	
	
	// Registration form validation
	function trx_addons_registration_validate(form) {
		form.find('input').removeClass('trx_addons_field_error');
		var error = trx_addons_form_validate(form, {
			error_message_time: 4000,
			exit_after_first_error: true,
			rules: [
				{
					field: "agree",
					state: { value: 'checked', message: TRX_ADDONS_STORAGE['msg_not_agree'] },
				},
				{
					field: "log",
					min_length: { value: 1, message: TRX_ADDONS_STORAGE['msg_login_empty'] },
					max_length: { value: 60, message: TRX_ADDONS_STORAGE['msg_login_long'] }
				},
				{
					field: "email",
					min_length: { value: 7, message: TRX_ADDONS_STORAGE['msg_email_not_valid'] },
					max_length: { value: 60, message: TRX_ADDONS_STORAGE['msg_email_long'] },
					mask: { value: TRX_ADDONS_STORAGE['email_mask'], message: TRX_ADDONS_STORAGE['msg_email_not_valid'] }
				},
				{
					field: "pwd",
					min_length: { value: 4, message: TRX_ADDONS_STORAGE['msg_password_empty'] },
					max_length: { value: 60, message: TRX_ADDONS_STORAGE['msg_password_long'] }
				},
				{
					field: "pwd2",
					equal_to: { value: 'pwd', message: TRX_ADDONS_STORAGE['msg_password_not_equal'] }
				}
			]
		});
		if (!error) {
			jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
				action: 'trx_addons_registration_user',
				nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
				redirect_to: form.find('input[name="redirect_to"]').length == 1 ? form.find('input[name="redirect_to"]').val() : '',
				user_name: 	form.find('input[name="log"]').val(),
				user_email: form.find('input[name="email"]').val(),
				user_pwd: 	form.find('input[name="pwd"]').val()
			}).done(function(response) {
				var rez = {};
				try {
					rez = JSON.parse(response);
				} catch (e) {
					rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
					console.log(response);
				}
				var result = form.find(".trx_addons_message_box").toggleClass("trx_addons_message_box_error", false).toggleClass("trx_addons_message_box_success", false);
				if (rez.error === '') {
					result.addClass("trx_addons_message_box_success").html(TRX_ADDONS_STORAGE['msg_registration_success']);
					setTimeout(function() { 
						if (rez.redirect_to != '') {
							location.href = rez.redirect_to;
						} else {
							jQuery('#trx_addons_login_popup .trx_addons_tabs_title_login > a').trigger('click'); 
						}
					}, 3000);
				} else {
					result.addClass("trx_addons_message_box_error").html(TRX_ADDONS_STORAGE['msg_registration_error'] + (rez.error!==undefined ?  '<br>' + rez.error : ''));
				}
				result.fadeIn().delay(3000).fadeOut();
			});
		}
		return false;
	}

});