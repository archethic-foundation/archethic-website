/**
 * JS utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {

	"use strict";
	
	/* Cookies manipulations
	---------------------------------------------------------------- */
	
	window.trx_addons_get_cookie = function(name) {
		var defa = arguments[1]!=undefined ? arguments[1] : null;
		var start = document.cookie.indexOf(name + '=');
		var len = start + name.length + 1;
		if ((!start) && (name != document.cookie.substring(0, name.length))) {
			return defa;
		}
		if (start == -1)
			return defa;
		var end = document.cookie.indexOf(';', len);
		if (end == -1)
			end = document.cookie.length;
		return unescape(document.cookie.substring(len, end));
	};
	
	
	window.trx_addons_set_cookie = function(name, value, expires, path, domain, secure) {
		var expires = arguments[2]!=undefined ? arguments[2] : 0;
		var path    = arguments[3]!=undefined ? arguments[3] : '/';
		var domain  = arguments[4]!=undefined ? arguments[4] : '';
		var secure  = arguments[5]!=undefined ? arguments[5] : '';
		var today = new Date();
		today.setTime(today.getTime());
		if (expires) {
			expires = expires * 1000 * 60 * 60 * 24;
		}
		var expires_date = new Date(today.getTime() + (expires));
		document.cookie = name + '='
				+ escape(value)
				+ ((expires) ? ';expires=' + expires_date.toGMTString() : '')
				+ ((path)    ? ';path=' + path : '')
				+ ((domain)  ? ';domain=' + domain : '')
				+ ((secure)  ? ';secure' : '');
	};
	
	
	window.trx_addons_del_cookie = function(name, path, domain) {
		var path   = arguments[1]!=undefined ? arguments[1] : '/';
		var domain = arguments[2]!=undefined ? arguments[2] : '';
		if (trx_addons_get_cookie(name))
			document.cookie = name + '=' + ((path) ? ';path=' + path : '')
					+ ((domain) ? ';domain=' + domain : '')
					+ ';expires=Thu, 01-Jan-1970 00:00:01 GMT';
	};
	
	
	
	/* ListBox and ComboBox manipulations
	---------------------------------------------------------------- */
	
	window.trx_addons_clear_listbox = function(box) {
		for (var i=box.options.length-1; i >= 0; i--)
			box.options[i] = null;
	};
	
	window.trx_addons_add_listbox_item = function(box, val, text) {
		var item = new Option();
		item.value = val;
		item.text = text;
		box.options.add(item);
	};
	
	window.trx_addons_del_listbox_item_by_value = function(box, val) {
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].value == val) {
				box.options[i] = null;
				break;
			}
		}
	};
	
	window.trx_addons_del_listbox_item_by_text = function(box, txt) {
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].text == txt) {
				box.options[i] = null;
				break;
			}
		}
	};
	
	window.trx_addons_find_listbox_item_by_value = function(box, val) {
		var idx = -1;
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].value == val) {
				idx = i;
				break;
			}
		}
		return idx;
	};
	
	window.trx_addons_find_listbox_item_by_text = function(box, txt) {
		var idx = -1;
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].text == txt) {
				idx = i;
				break;
			}
		}
		return idx;
	};
	
	window.trx_addons_select_listbox_item_by_value = function(box, val) {
		for (var i = 0; i < box.options.length; i++) {
			box.options[i].selected = (val == box.options[i].value);
		}
	};
	
	window.trx_addons_select_listbox_item_by_text = function(box, txt) {
		for (var i = 0; i < box.options.length; i++) {
			box.options[i].selected = (txt == box.options[i].text);
		}
	};
	
	window.trx_addons_get_listbox_values = function(box) {
		var delim = arguments[1] ? arguments[1] : ',';
		var str = '';
		for (var i=0; i < box.options.length; i++) {
			str += (str ? delim : '') + box.options[i].value;
		}
		return str;
	};
	
	window.trx_addons_get_listbox_texts = function(box) {
		var delim = arguments[1] ? arguments[1] : ',';
		var str = '';
		for (var i=0; i < box.options.length; i++) {
			str += (str ? delim : '') + box.options[i].text;
		}
		return str;
	};
	
	window.trx_addons_sort_listbox = function(box)  {
		var temp_opts = new Array();
		var temp = new Option();
		for(var i=0; i<box.options.length; i++)  {
			temp_opts[i] = box.options[i].clone();
		}
		for(var x=0; x<temp_opts.length-1; x++)  {
			for(var y=(x+1); y<temp_opts.length; y++)  {
				if(temp_opts[x].text > temp_opts[y].text)  {
					temp = temp_opts[x];
					temp_opts[x] = temp_opts[y];
					temp_opts[y] = temp;
				}  
			}  
		}
		for(var i=0; i<box.options.length; i++)  {
			box.options[i] = temp_opts[i].clone();
		}
	};
	
	window.trx_addons_get_listbox_selected_index = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected)
				return i;
		}
		return -1;
	};
	
	window.trx_addons_get_listbox_selected_value = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected) {
				return box.options[i].value;
			}
		}
		return null;
	};
	
	window.trx_addons_get_listbox_selected_text = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected) {
				return box.options[i].text;
			}
		}
		return null;
	};
	
	window.trx_addons_get_listbox_selected_option = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected) {
				return box.options[i];
			}
		}
		return null;
	};
	
	
	
	/* Radio buttons manipulations
	---------------------------------------------------------------- */
	
	window.trx_addons_get_radio_value = function(radioGroupObj) {
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked) return radioGroupObj[i].value;
		return null;
	};
	
	window.trx_addons_set_radio_checked_by_num = function(radioGroupObj, num) {
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked && i!=num) radioGroupObj[i].checked=false;
			else if (i==num) radioGroupObj[i].checked=true;
	};
	
	window.trx_addons_set_radio_checked_by_value = function(radioGroupObj, val) {
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked && radioGroupObj[i].value!=val) radioGroupObj[i].checked=false;
			else if (radioGroupObj[i].value==val) radioGroupObj[i].checked=true;
	};
	
	
	
	/* Form validation
	---------------------------------------------------------------- */
	
	/*
	// Usage example:
	var error = trx_addons_form_validate(jQuery(form_selector), {	// -------- Options ---------
		error_message_show: true,									// Display or not error message
		error_message_time: 5000,									// Time to display error message
		error_message_class: 'trx_addons_message_box_error',		// Class, appended to error message block
		error_message_text: 'Global error text',					// Global error message text (if not specify message in the checked field)
		error_fields_class: 'trx_addons_field_error',				// Class, appended to error fields
		exit_after_first_error: false,								// Cancel validation and exit after first error
		rules: [
			{
				field: 'author',																// Checking field name
				min_length: { value: 1,	 message: 'The author name can\'t be empty' },			// Min character count (0 - don't check), message - if error occurs
				max_length: { value: 60, message: 'Too long author name'}						// Max character count (0 - don't check), message - if error occurs
			},
			{
				field: 'email',
				min_length: { value: 7,	 message: 'Too short (or empty) email address' },
				max_length: { value: 60, message: 'Too long email address'},
				mask: { value: '^([a-z0-9_\\-]+\\.)*[a-z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$', message: 'Invalid email address'}
			},
			{
				field: 'comment',
				min_length: { value: 1,	 message: 'The comment text can\'t be empty' },
				max_length: { value: 200, message: 'Too long comment'}
			},
			{
				field: 'pwd1',
				min_length: { value: 5,	 message: 'The password can\'t be less then 5 characters' },
				max_length: { value: 20, message: 'Too long password'}
			},
			{
				field: 'pwd2',
				equal_to: { value: 'pwd1',	 message: 'The passwords in both fields must be equals' }
			}
		]
	});
	*/
	
	window.trx_addons_form_validate = function(form, opt) {
		// Default options
		if (typeof(opt.error_message_show)=='undefined')		opt.error_message_show = true;
		if (typeof(opt.error_message_time)=='undefined')		opt.error_message_time = 5000;
		if (typeof(opt.error_message_class)=='undefined')		opt.error_message_class = 'trx_addons_message_box_error';
		if (typeof(opt.error_message_text)=='undefined')		opt.error_message_text = 'Incorrect data in the fields!';
		if (typeof(opt.error_fields_class)=='undefined')		opt.error_fields_class = 'trx_addons_field_error';
		if (typeof(opt.exit_after_first_error)=='undefined')	opt.exit_after_first_error = false;
		// Validate fields
		var error_msg = '';
		form.find(":input").each(function() {
			if (error_msg!='' && opt.exit_after_first_error) return;
			for (var i = 0; i < opt.rules.length; i++) {
				if (jQuery(this).attr("name") == opt.rules[i].field) {
					var val = jQuery(this).val();
					var error = false;
					if (typeof(opt.rules[i].min_length) == 'object') {
						if (opt.rules[i].min_length.value > 0 && val.length < opt.rules[i].min_length.value) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="trx_addons_error_item">' + (typeof(opt.rules[i].min_length.message)!='undefined' ? opt.rules[i].min_length.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].max_length) == 'object') {
						if (opt.rules[i].max_length.value > 0 && val.length > opt.rules[i].max_length.value) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="trx_addons_error_item">' + (typeof(opt.rules[i].max_length.message)!='undefined' ? opt.rules[i].max_length.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].mask) == 'object') {
						if (opt.rules[i].mask.value != '') {
							var regexp = new RegExp(opt.rules[i].mask.value);
							if (!regexp.test(val)) {
								if (error_msg=='') jQuery(this).get(0).focus();
								error_msg += '<p class="trx_addons_error_item">' + (typeof(opt.rules[i].mask.message)!='undefined' ? opt.rules[i].mask.message : opt.error_message_text ) + '</p>';
								error = true;
							}
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].state) == 'object') {
						if (opt.rules[i].state.value=='checked' && !jQuery(this).get(0).checked) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="trx_addons_error_item">' + (typeof(opt.rules[i].state.message)!='undefined' ? opt.rules[i].state.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].equal_to) == 'object') {
						if (opt.rules[i].equal_to.value != '' && val!=jQuery(jQuery(this).get(0).form[opt.rules[i].equal_to.value]).val()) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="trx_addons_error_item">' + (typeof(opt.rules[i].equal_to.message)!='undefined' ? opt.rules[i].equal_to.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if (opt.error_fields_class != '') jQuery(this).toggleClass(opt.error_fields_class, error);
				}
	
			}
		});
		if (error_msg!='' && opt.error_message_show) {
			var error_message_box = form.find(".trx_addons_message_box");
			if (error_message_box.length == 0) error_message_box = form.parent().find(".trx_addons_message_box");
			if (error_message_box.length == 0) {
				form.append('<div class="trx_addons_message_box"></div>');
				error_message_box = form.find(".trx_addons_message_box");
			}
			if (opt.error_message_class) error_message_box.toggleClass(opt.error_message_class, true);
			error_message_box.html(error_msg).fadeIn();
			setTimeout(function() { error_message_box.fadeOut(); }, opt.error_message_time);
		}
		return error_msg!='';
	};
	
	
	
	// Fill (refresh) list in specified field when parent fields is changed
	// -------------------------------------------------------------------------------------
	window.trx_addons_refresh_list = function(parent_type, parent_val, list_fld, list_lbl, list_not_selected) {

		// Need "- Select ... -"
		if (list_not_selected === undefined) {
			var list_not_selected = list_fld.data('not-selected')===true 							// field has data-not-selected="true"
								|| list_fld.parents('.vc_edit-form-tab').length > 0					// or field in the VC shortcodes form
								|| list_fld.parents('#elementor-controls').length > 0				// or field in the Elementor shortcodes form
								|| list_fld.parents('.siteorigin-widget-field').length > 0			// or field in the old SOW form
								|| list_fld.parents('[class*="widget_field_type_"]').length > 0		// or field in the new SOW form
								|| list_fld.parents('.widget-liquid-right').length > 0				// or field in the Widgets panel
								|| list_fld.parents('.widgets-holder-wrap').length > 0				// or field in the Widgets panel
								|| list_fld.parents('.customize-control-widget_form').length > 0	// or field in the Widget in the Customizer
		}

		var list_val = list_fld.val();
		if (list_lbl.find('.trx_addons_refresh').length == 0)
			list_lbl.append('<span class="trx_addons_refresh trx_addons_icon-spin3 animate-spin"></span>');

		// Prepare data
		var data = {
			action: 'trx_addons_refresh_list',
			nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
			parent_type: parent_type,
			parent_value: parent_val,
			list_not_selected: list_not_selected
		};
		jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], data, function(response) {
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
				console.log(response);
			}
			if (rez.error === '') {
				var opt_list = '';
				var list_type = list_fld.prop('tagName').toLowerCase();
				var list_name = list_type == 'select' ? list_fld.attr('name') : list_fld.data('field_name');
				for (var i in rez.data) {
					if (list_type != 'select' && rez.data[i]['key'] == 0) continue;
					opt_list += list_type == 'select'
						? '<option class="'+rez.data[i]['key']+'"'
									+ ' value="'+rez.data[i]['key']+'"'
									+ (rez.data[i]['key']==list_val ? ' selected="selected"' : '')
									+ '>'
									+ rez.data[i]['value']
									+ '</option>'
						: '<label><input type="checkbox"'
									+ ' value="' + rez.data[i]['key'] + '"'
									+ ' name="' + list_name + '"'
									+ '>'
								+ rez.data[i]['value']
							+ '</label>';
				}
				list_fld
					.html(opt_list);				// Replace list of the elements in the selector
					//.data('items', rez.data);		// Store items list for future usage
				if (list_type == 'select' && list_fld.find('option:selected').length == 0 && list_fld.find('option').length > 0)
					list_fld.find('option').get(0).selected = true;
				list_lbl.find('span.trx_addons_refresh').remove();
				list_fld.trigger('change');
			}
		});
		return false;
	};
	
	
	
	/* Document manipulations
	---------------------------------------------------------------- */
	
	// Animated scroll to selected id
	window.trx_addons_document_animate_to = function(id, callback) {
		var oft = !isNaN(id) ? Number(id) : 0;
		if (isNaN(id)) {
			if (id.indexOf('#')==-1) id = '#' + id;
			var obj = jQuery(id).eq(0);
			if (obj.length == 0) return;
			oft = obj.offset().top;
		}
		var st  = jQuery(window).scrollTop();
		var oft2 = Math.max(0, oft - trx_addons_fixed_rows_height());
		var speed = Math.min(1200, Math.max(300, Math.round(Math.abs(oft2-st) / jQuery(window).height() * 300)));
		// Recalc offset always (after the half animation time) to detect change size of the fullheight rows
		if (true || st == 0) {
			setTimeout(function() {
				if (isNaN(id)) oft = obj.offset().top;
				oft2 = Math.max(0, oft - trx_addons_fixed_rows_height());
				jQuery('body,html').stop(true).animate( {scrollTop: oft2}, Math.floor(speed/2), 'linear', callback );
			}, Math.floor(speed/2));
		}
		jQuery('body,html').stop(true).animate( {scrollTop: oft2}, speed, 'linear', callback );
	};
	
	// Detect fixed rows height
	window.trx_addons_fixed_rows_height = function() {
		var with_admin_bar = arguments.length>0 ? arguments[0] : true;
		var with_fixed_rows = arguments.length>1 ? arguments[1] : true;
		var oft = 0;
		// Admin bar height (if visible and fixed)
		if (with_admin_bar) {
			var admin_bar = jQuery('#wpadminbar');
			oft += admin_bar.length > 0 && admin_bar.css('display')!='none' && admin_bar.css('position')=='fixed' 
							? admin_bar.height()
							: 0;
		}
		// Fixed rows height
		if (with_fixed_rows) {
			jQuery('.sc_layouts_row_fixed_on').each(function() {
				if (jQuery(this).css('position')=='fixed')
					oft += jQuery(this).height();
			});
		}
		return oft;
	};
	
	// Change browser address without reload page
	window.trx_addons_document_set_location = function(curLoc){
		if (history.pushState===undefined || navigator.userAgent.match(/MSIE\s[6-9]/i) != null) return;
		try {
			history.pushState(null, null, curLoc);
			return;
		} catch(e) {}
		location.href = curLoc;
	};
	
	// Add/Change arguments to the url address
	window.trx_addons_add_to_url = function(loc, prm) {
		var ignore_empty = arguments[2] !== undefined ? arguments[2] : true;
		var q = loc.indexOf('?');
		var attr = {};
		if (q > 0) {
			var qq = loc.substr(q+1).split('&');
			var parts = '';
			for (var i=0; i < qq.length; i++) {
				var parts = qq[i].split('=');
				attr[parts[0]] = parts.length>1 ? parts[1] : ''; 
			}
		}
		for (var p in prm) {
			attr[p] = prm[p];
		}
		loc = (q > 0 ? loc.substr(0, q) : loc) + '?';
		var i = 0;
		for (p in attr) {
			if (ignore_empty && attr[p]=='') continue;
			loc += (i++ > 0 ? '&' : '') + p + '=' + attr[p];
		}
		return loc;
	};
	
	// Check if url is page-inner (local) link
	window.trx_addons_is_local_link = function(url) {
		var rez = url!==undefined;
		if (rez) {
			var url_pos = url.indexOf('#');
			if (url_pos == 0 && url.length == 1)
				rez = false;
			else {
				if (url_pos < 0) url_pos = url.length;
				var loc = window.location.href;
				var loc_pos = loc.indexOf('#');
				if (loc_pos > 0) loc = loc.substring(0, loc_pos);
				rez = url_pos==0;
				if (!rez) rez = loc == url.substring(0, url_pos);
			}
		}
		return rez;
	};
	
	// Get embed code from video URL
	window.trx_addons_get_embed_from_url = function(url, autoplay) {
		if (autoplay === undefined)
			var autoplay = true;
		url = url.replace('/watch?v=', '/embed/')
				 .replace('/vimeo.com/', '/player.vimeo.com/video/');
		if (autoplay) {
			url += (url.indexOf('?') > 0 ? '&' : '?') + '&autoplay=1';
		}
		return '<iframe src="'+url+'" border="0" width="1280" height="720"></iframe>';
	};
	
	
	/* Browsers detection
	---------------------------------------------------------------- */
	
	window.trx_addons_browser_is_mobile = function() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	};
	
	window.trx_addons_browser_is_ios = function() {
		return navigator.userAgent.match(/iPad|iPhone|iPod/i) != null || navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i)?true:false;
	};
	window.trx_addons_is_retina = function() {
		var mediaQuery = '(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-resolution: 1.5dppx)';
		return (window.devicePixelRatio > 1) || (window.matchMedia && window.matchMedia(mediaQuery).matches);
	};
	
	
	
	/* File functions
	---------------------------------------------------------------- */
	
	window.trx_addons_get_file_name = function(path) {
		path = path.replace(/\\/g, '/');
		var pos = path.lastIndexOf('/');
		if (pos >= 0)
			path = path.substr(pos+1);
		return path;
	};
	
	window.trx_addons_get_file_ext = function(path) {
		var pos = path.lastIndexOf('.');
		path = pos >= 0 ? path.substr(pos+1) : '';
		return path;
	};
	
	window.trx_addons_get_basename = function(path) {
		return trx_addons_get_file_name(path).replace('.'+trx_addons_get_file_ext(path), '');
	};
	
	
	
	/* Image functions
	---------------------------------------------------------------- */
	
	// Return true, if all images in the specified container are loaded
	window.trx_addons_check_images_complete = function(cont) {
		var complete = true;
		cont.find('img').each(function() {
			if (!complete) return;
			if (!jQuery(this).get(0).complete) complete = false;
		});
		return complete;
	};
	
	
	
	/* Numbers functions
	---------------------------------------------------------------- */
	
	// Round number to specified precision. 
	// For example: num=1.12345, prec=2,  rounded=1.12
	//              num=12345,   prec=-2, rounded=12300
	window.trx_addons_round_number = function(num) {
		var precision = arguments[1]!==undefined ? arguments[1] : 0;
		var p = Math.pow(10, precision);
		return Math.round(num*p)/p;
	};
	
	// Format money:
	// For example: (123456789.12345).formatMoney(2, '.', ',');
	Number.prototype.formatMoney = function(c, d, t) {
		var n = this, 
			c = c == undefined ? 2 : (isNaN(c = Math.abs(c)) ? 2 : c),
			d = d == undefined ? "." : d, 
			t = t == undefined ? "," : t, 
			s = n < 0 ? "-" : "", 
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s
				+ (j ? i.substr(0, j) + t : "") 
				+ i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) 
				+ (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

	
	/* Strings
	---------------------------------------------------------------- */

	// Make first letter of every word
	window.trx_addons_proper = function(str) {
		return str.replace(/(\b\w)/gi, function(m) { return m.toUpperCase(); });
	};

	// Replicate string several times
	window.trx_addons_replicate = function(str, num) {
		var rez = '';
		for (var i=0; i < num; i++) {
			rez += str;
		}
		return rez;
	};

	// Replace:
	// {{..}} to the <i>..</i>
	// ((..)) to the <b>..</b>
	// ||     to the <br>
	window.trx_addons_prepare_macros = function(str) {
		return str
			.replace(/\{\{/g, "<i>")
			.replace(/\}\}/g, "</i>")
			.replace(/\(\(/g, "<b>")
			.replace(/\)\)/g, "</b>")
			.replace(/\|\|/g, "<br>");
	};
	window.trx_addons_remove_macros = function(str) {
		return str
			.replace(/\{\{/g, "")
			.replace(/\}\}/g, "")
			.replace(/\(\(/g, "")
			.replace(/\)\)/g, "")
			.replace(/\|\|/g, "");
	};
	
	// Replace {{ and }} with < and >
	window.trx_addons_parse_codes = function(text, tag_start, tag_end) {
		if (tag_start === undefined) tag_start = '{{';
		if (tag_end === undefined) tag_end = '}}';
		var r1 = new RegExp(tag_start, 'g');
		var r2 = new RegExp(tag_end, 'g');
		return text.replace(r1, '<').replace(r2, '>');
	};

	// Check value for "on" | "off" | "inherit" values
	window.trx_addons_is_on = function(prm) {
		return prm>0 || ['true', 'on', 'yes', 'show'].indexOf((''+prm).toLowerCase()) >= 0;
	};
	window.trx_addons_is_off = function(prm) {
		return prm=='' || prm==0 || ['false', 'off', 'no', 'none', 'hide'].indexOf((''+prm).toLowerCase()) >= 0;
	};
	window.trx_addons_is_inherit = function(prm) {
		return ['inherit'].indexOf((''+prm).toLowerCase()) >= 0;
	};
	
	// Return icon class from classes string
	window.trx_addons_get_icon_class = function(classes) {
		var classes = classes.split(' ');
		var icon = '';
		for (var i=0; i < classes.length; i++) {
			if (classes[i].indexOf('icon-') >= 0) {
				icon = classes[i];
				break;
			}
		}
		return icon;
	};
	
	// Replace icon's class with new value
	window.trx_addons_chg_icon_class = function(classes, icon) {
		var chg = false;
		classes = classes.split(' ');
		for (var i=0; i < classes.length; i++) {
			if (classes[i].indexOf('icon-') >= 0) {
				classes[i] = icon;
				chg = true;
				break;
			}
		}
		if (!chg) {
			if (classes.length == 1 && classes[0] == '')
				classes[0] = icon;
			else
				classes.push(icon);
		}
		return classes.join(' ');
	};
	
	
	
	/* Colors functions
	---------------------------------------------------------------- */
	
	window.trx_addons_hex2rgb = function(hex) {
		hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
		return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
	};

	window.trx_addons_hex2rgba = function(hex, alpha) {
		var rgb = trx_addons_hex2rgb(hex);
		return 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+alpha+')';
	};

	window.trx_addons_rgb2hex = function(color) {
		var aRGB;
		color = color.replace(/\s/g,"").toLowerCase();
		if (color=='rgba(0,0,0,0)' || color=='rgba(0%,0%,0%,0%)')
			color = 'transparent';
		if (color.indexOf('rgba(')==0)
			aRGB = color.match(/^rgba\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
		else	
			aRGB = color.match(/^rgb\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
		
		if(aRGB) {
			color = '';
			for (var i=1; i <= 3; i++) 
				color += Math.round((aRGB[i][aRGB[i].length-1]=="%"?2.55:1)*parseInt(aRGB[i])).toString(16).replace(/^(.)$/,'0$1');
		} else 
			color = color.replace(/^#?([\da-f])([\da-f])([\da-f])$/i, '$1$1$2$2$3$3');
		return (color.substr(0,1)!='#' ? '#' : '') + color;
	};
	
	window.trx_addons_components2hex = function(r,g,b) {
		return '#'+
			Number(r).toString(16).toUpperCase().replace(/^(.)$/,'0$1') +
			Number(g).toString(16).toUpperCase().replace(/^(.)$/,'0$1') +
			Number(b).toString(16).toUpperCase().replace(/^(.)$/,'0$1');
	};
	
	window.trx_addons_rgb2components = function(color) {
		color = trx_addons_rgb2hex(color);
		var matches = color.match(/^#?([\dabcdef]{2})([\dabcdef]{2})([\dabcdef]{2})$/i);
		if (!matches) return false;
		for (var i=1, rgb = new Array(3); i <= 3; i++)
			rgb[i-1] = parseInt(matches[i],16);
		return rgb;
	};
	
	window.trx_addons_hex2hsb = function(hex) {
		var h = arguments[1]!==undefined ? arguments[1] : 0;
		var s = arguments[2]!==undefined ? arguments[2] : 0;
		var b = arguments[3]!==undefined ? arguments[3] : 0;
		var hsb = trx_addons_rgb2hsb(trx_addons_hex2rgb(hex));
		hsb.h = Math.min(359, hsb.h + h);
		hsb.s = Math.min(100, hsb.s + s);
		hsb.b = Math.min(100, hsb.b + b);
		return hsb;
	};
	
	window.trx_addons_hsb2hex = function(hsb) {
		var rgb = trx_addons_hsb2rgb(hsb);
		return trx_addons_components2hex(rgb.r, rgb.g, rgb.b);
	};
	
	window.trx_addons_rgb2hsb = function(rgb) {
		var hsb = {};
		hsb.b = Math.max(Math.max(rgb.r,rgb.g),rgb.b);
		hsb.s = (hsb.b <= 0) ? 0 : Math.round(100*(hsb.b - Math.min(Math.min(rgb.r,rgb.g),rgb.b))/hsb.b);
		hsb.b = Math.round((hsb.b /255)*100);
		if ((rgb.r==rgb.g) && (rgb.g==rgb.b))  hsb.h = 0;
		else if (rgb.r>=rgb.g && rgb.g>=rgb.b) hsb.h = 60*(rgb.g-rgb.b)/(rgb.r-rgb.b);
		else if (rgb.g>=rgb.r && rgb.r>=rgb.b) hsb.h = 60  + 60*(rgb.g-rgb.r)/(rgb.g-rgb.b);
		else if (rgb.g>=rgb.b && rgb.b>=rgb.r) hsb.h = 120 + 60*(rgb.b-rgb.r)/(rgb.g-rgb.r);
		else if (rgb.b>=rgb.g && rgb.g>=rgb.r) hsb.h = 180 + 60*(rgb.b-rgb.g)/(rgb.b-rgb.r);
		else if (rgb.b>=rgb.r && rgb.r>=rgb.g) hsb.h = 240 + 60*(rgb.r-rgb.g)/(rgb.b-rgb.g);
		else if (rgb.r>=rgb.b && rgb.b>=rgb.g) hsb.h = 300 + 60*(rgb.r-rgb.b)/(rgb.r-rgb.g);
		else 								   hsb.h = 0;
		hsb.h = Math.round(hsb.h);
		return hsb;
	};
	
	window.trx_addons_hsb2rgb = function(hsb) {
		var rgb = {};
		var h = Math.round(hsb.h);
		var s = Math.round(hsb.s*255/100);
		var v = Math.round(hsb.b*255/100);
		if (s == 0) {
			rgb.r = rgb.g = rgb.b = v;
		} else {
			var t1 = v;
			var t2 = (255-s)*v/255;
			var t3 = (t1-t2)*(h%60)/60;
			if (h==360) h = 0;
			if (h<60) 		{ rgb.r=t1;	rgb.b=t2;   rgb.g=t2+t3; }
			else if (h<120) { rgb.g=t1; rgb.b=t2;	rgb.r=t1-t3; }
			else if (h<180) { rgb.g=t1; rgb.r=t2;	rgb.b=t2+t3; }
			else if (h<240) { rgb.b=t1; rgb.r=t2;	rgb.g=t1-t3; }
			else if (h<300) { rgb.b=t1; rgb.g=t2;	rgb.r=t2+t3; }
			else if (h<360) { rgb.r=t1; rgb.g=t2;	rgb.b=t1-t3; }
			else 			{ rgb.r=0;  rgb.g=0;	rgb.b=0;	 }
		}
		return { r:Math.round(rgb.r), g:Math.round(rgb.g), b:Math.round(rgb.b) };
	};
	
	window.trx_addons_color_picker = function(){
		var id = arguments[0]!==undefined ? arguments[0] : "iColorPicker"+Math.round(Math.random()*1000);
		var colors = arguments[1]!==undefined ? arguments[1] : 
		'#f00,#ff0,#0f0,#0ff,#00f,#f0f,#fff,#ebebeb,#e1e1e1,#d7d7d7,#cccccc,#c2c2c2,#b7b7b7,#acacac,#a0a0a0,#959595,'
		+'#ee1d24,#fff100,#00a650,#00aeef,#2f3192,#ed008c,#898989,#7d7d7d,#707070,#626262,#555,#464646,#363636,#262626,#111,#000,'
		+'#f7977a,#fbad82,#fdc68c,#fff799,#c6df9c,#a4d49d,#81ca9d,#7bcdc9,#6ccff7,#7ca6d8,#8293ca,#8881be,#a286bd,#bc8cbf,#f49bc1,#f5999d,'
		+'#f16c4d,#f68e54,#fbaf5a,#fff467,#acd372,#7dc473,#39b778,#16bcb4,#00bff3,#438ccb,#5573b7,#5e5ca7,#855fa8,#a763a9,#ef6ea8,#f16d7e,'
		+'#ee1d24,#f16522,#f7941d,#fff100,#8fc63d,#37b44a,#00a650,#00a99e,#00aeef,#0072bc,#0054a5,#2f3192,#652c91,#91278f,#ed008c,#ee105a,'
		+'#9d0a0f,#a1410d,#a36209,#aba000,#588528,#197b30,#007236,#00736a,#0076a4,#004a80,#003370,#1d1363,#450e61,#62055f,#9e005c,#9d0039,'
		+'#790000,#7b3000,#7c4900,#827a00,#3e6617,#045f20,#005824,#005951,#005b7e,#003562,#002056,#0c004b,#30004a,#4b0048,#7a0045,#7a0026';
		var colorsList = colors.split(',');
		var tbl = '<table class="colorPickerTable"><thead>';
		for (var i=0; i < colorsList.length; i++) {
			if (i%16==0) tbl += (i>0 ? '</tr>' : '') + '<tr>';
			tbl += '<td style="background-color:'+colorsList[i]+'">&nbsp;</td>';
		}
		tbl += '</tr></thead><tbody>'
			+ '<tr style="height:60px;">'
			+ '<td colspan="8" id="'+id+'_colorPreview" style="vertical-align:middle;text-align:center;border:1px solid #000;background:#fff;">'
			+ '<input style="width:55px;color:#000;border:1px solid rgb(0, 0, 0);padding:5px;background-color:#fff;font:11px Arial, Helvetica, sans-serif;" maxlength="7" />'
			+ '<a href="#" id="'+id+'_moreColors" class="iColorPicker_moreColors"></a>'
			+ '</td>'
			+ '<td colspan="8" id="'+id+'_colorOriginal" style="vertical-align:middle;text-align:center;border:1px solid #000;background:#fff;">'
			+ '<input style="width:55px;color:#000;border:1px solid rgb(0, 0, 0);padding:5px;background-color:#fff;font:11px Arial, Helvetica, sans-serif;" readonly="readonly" />'
			+ '</td>'
			+ '</tr></tbody></table>';
	
		jQuery(document.createElement("div"))
			.attr("id", id)
			.css('display','none')
			.html(tbl)
			.appendTo("body")
			.addClass("iColorPickerTable")
			.on('mouseover', 'thead td', function(){
				var aaa = trx_addons_rgb2hex(jQuery(this).css('background-color'));
				jQuery('#'+id+'_colorPreview').css('background',aaa);
				jQuery('#'+id+'_colorPreview input').val(aaa);
			})
			.on('keypress', '#'+id+'_colorPreview input', function(key){
				var aaa = jQuery(this).val();
				if (key.which===13 && (aaa.length===4 || aaa.length===7)) {
					var fld  = jQuery('#'+id).data('field');
					var func = jQuery('#'+id).data('func');
					if (func!=null && func!='undefined') {
						func(fld, aaa);
					} else {
						fld.val(aaa).css('backgroundColor', aaa).trigger('change');
					}
					jQuery('#'+id+'_Bg').fadeOut(500);
					jQuery('#'+id).fadeOut(500);
					key.preventDefault();
					return false;
				}
			})
			.on('change', '#'+id+'_colorPreview input', function(key){
				var aaa = jQuery(this).val();
				if (aaa.substr(0,1)==='#' && (aaa.length===4 || aaa.length===7)) {
					jQuery('#'+id+'_colorPreview').css('background',aaa);
				}
			})
			.on('click', 'thead td', function(e){
				var fld  = jQuery('#'+id).data('field');
				var func = jQuery('#'+id).data('func');
				var aaa  = trx_addons_rgb2hex(jQuery(this).css('background-color'));
				if (func!=null && func!='undefined') {
					func(fld, aaa);
				} else {
					fld.val(aaa).css('backgroundColor', aaa).trigger('change');
				}
				jQuery('#'+id+'_Bg').fadeOut(500);
				jQuery('#'+id).fadeOut(500);
				e.preventDefault();
				return false;
			})
			.on('click', 'tbody .iColorPicker_moreColors', function(e){
				var thead  = jQuery(this).parents('table').find('thead');
				var out = '';
				if (thead.hasClass('more_colors')) {
					for (var i=0; i < colorsList.length; i++) {
						if (i%16==0) out += (i>0 ? '</tr>' : '') + '<tr>';
						out += '<td style="background-color:'+colorsList[i]+'">&nbsp;</td>';
					}
					thead.removeClass('more_colors').empty().html(out+'</tr>');
					jQuery('#'+id+'_colorPreview').attr('colspan', 8);
					jQuery('#'+id+'_colorOriginal').attr('colspan', 8);
				} else {
					var rgb=[0,0,0], i=0, j=-1;	// Set j=-1 or j=0 - show 2 different colors layouts
					while (rgb[0]<0xF || rgb[1]<0xF || rgb[2]<0xF) {
						if (i%18==0) out += (i>0 ? '</tr>' : '') + '<tr>';
						i++;
						out += '<td style="background-color:'+trx_addons_components2hex(rgb[0]*16+rgb[0],rgb[1]*16+rgb[1],rgb[2]*16+rgb[2])+'">&nbsp;</td>';
						rgb[2]+=3;
						if (rgb[2]>0xF) {
							rgb[1]+=3;
							if (rgb[1]>(j===0 ? 6 : 0xF)) {
								rgb[0]+=3;
								if (rgb[0]>0xF) {
									if (j===0) {
										j=1;
										rgb[0]=0;
										rgb[1]=9;
										rgb[2]=0;
									} else {
										break;
									}
								} else {
									rgb[1]=(j < 1 ? 0 : 9);
									rgb[2]=0;
								}
							} else {
								rgb[2]=0;
							}
						}
					}
					thead.addClass('more_colors').empty().html(out+'<td  style="background-color:#ffffff" colspan="8">&nbsp;</td></tr>');
					jQuery('#'+id+'_colorPreview').attr('colspan', 9);
					jQuery('#'+id+'_colorOriginal').attr('colspan', 9);
				}
				jQuery('#'+id+' table.colorPickerTable thead td')
					.css({
						'width':'12px',
						'height':'14px',
						'border':'1px solid #000',
						'cursor':'pointer'
					});
				e.preventDefault();
				return false;
			});
		jQuery(document.createElement("div"))
			.attr("id", id+"_Bg")
			.on('click', function(e) {
				jQuery("#"+id+"_Bg").fadeOut(500);
				jQuery("#"+id).fadeOut(500);
				e.preventDefault();
				return false;
			})
			.appendTo("body");
		jQuery('#'+id+' table.colorPickerTable thead td')
			.css({
				'width':'12px',
				'height':'14px',
				'border':'1px solid #000',
				'cursor':'pointer'
			});
		jQuery('#'+id+' table.colorPickerTable')
			.css({'border-collapse':'collapse'});
		jQuery('#'+id)
			.css({
				'border':'1px solid #ccc',
				'background':'#333',
				'padding':'5px',
				'color':'#fff'
			});
		jQuery('#'+id+'_colorPreview')
			.css({'height':'50px'});
		return id;
	};
	
	window.trx_addons_color_picker_show = function(id, fld, func) { 
		if (id===null || id==='') {
			id = jQuery('.iColorPickerTable').attr('id');
		}
		var eICP = fld.offset();
		var w = jQuery('#'+id).width();
		var h = jQuery('#'+id).height();
		var l = eICP.left + w < jQuery(window).width()-10 ? eICP.left : jQuery(window).width()-10 - w;
		var t = eICP.top + fld.outerHeight() + h < jQuery(document).scrollTop() + jQuery(window).height()-10 ? eICP.top + fld.outerHeight() : eICP.top - h - 13;
		jQuery("#"+id)
			.data({field: fld, func: func})
			.css({
				'top':t+"px",
				'left':l+"px",
				'position':'absolute',
				'z-index':999999
			})
			.fadeIn(500);
		jQuery("#"+id+"_Bg")
			.css({
				'position':'fixed',
				'z-index':999998,
				'top':0,
				'left':0,
				'width':'100%',
				'height':'100%'
			})
			.fadeIn(500);
		var def = fld.val().substr(0, 1)=='#' ? fld.val() : trx_addons_rgb2hex(fld.css('backgroundColor'));
		jQuery('#'+id+'_colorPreview input,#'+id+'_colorOriginal input').val(def);
		jQuery('#'+id+'_colorPreview,#'+id+'_colorOriginal').css('background',def);
	};
	
	
	/* Utils
	---------------------------------------------------------------- */
	
	// Merge two objects (arrays)
	window.trx_addons_array_merge = function(a1, a2) {
		for (var i in a2) a1[i] = a2[i];
		return a1;
	};

	// Generates a storable representation of a value
	window.trx_addons_serialize = function(mixed_val) {
		var obj_to_array = arguments.length==1 || argument[1]===true;
	
		switch ( typeof(mixed_val) ) {
	
			case "number":
				if ( isNaN(mixed_val) || !isFinite(mixed_val) )
					return false;
				else
					return (Math.floor(mixed_val) == mixed_val ? "i" : "d") + ":" + mixed_val + ";";
	
			case "string":
				return "s:" + mixed_val.length + ":\"" + mixed_val + "\";";
	
			case "boolean":
				return "b:" + (mixed_val ? "1" : "0") + ";";
	
			case "object":
				if (mixed_val == null)
					return "N;";
				else if (mixed_val instanceof Array) {
					var idxobj = { idx: -1 };
					var map = [];
					for (var i=0; i < mixed_val.length; i++) {
						idxobj.idx++;
						var ser = trx_addons_serialize(mixed_val[i]);
						if (ser)
							map.push(trx_addons_serialize(idxobj.idx) + ser);
					}                                      
					return "a:" + mixed_val.length + ":{" + map.join("") + "}";
				} else {
					var class_name = trx_addons_get_class(mixed_val);
					if (class_name == undefined)
						return false;
					var props = new Array();
					for (var prop in mixed_val) {
						var ser = trx_addons_serialize(mixed_val[prop]);
						if (ser)
							props.push(trx_addons_serialize(prop) + ser);
					}
					if (obj_to_array)
						return "a:" + props.length + ":{" + props.join("") + "}";
					else
						return "O:" + class_name.length + ":\"" + class_name + "\":" + props.length + ":{" + props.join("") + "}";
				}
	
			case "undefined":
				return "N;";
		}
		return false;
	};
	
	// Returns the name of the class of an object
	window.trx_addons_get_class = function(obj) {
		if (obj instanceof Object && !(obj instanceof Array) && !(obj instanceof Function) && obj.constructor) {
			var arr = obj.constructor.toString().match(/function\s*(\w+)/);
			if (arr && arr.length == 2) return arr[1];
		}
		return false;
	};

})();