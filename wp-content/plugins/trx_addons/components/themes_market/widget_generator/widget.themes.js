/**
 * Widget "Themes List"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.33
 */

(function(){
	"use strict";

	window.TRX_Addons_Widget_Themes = function(params) {
		var widget = this;
		widget.request_busy = false;
		widget.params = params;
		widget.node = document.getElementById(widget.params.uid);
		if (!widget.node) return null;
		widget.node.innerHTML = '<div class="trx_addons_widget_themes">'
									+ '<div class="trx_addons_widget_themes_content">'
									+ '</div>'
									+ '<div class="trx_addons_widget_themes_footer'
										+ ' trx_addons_widget_themes_' + (widget.params['logo'] ? 'with' : 'without') + '_logo'
										+ '">'
										+ (widget.params['logo']
											? '<' + (widget.params['logo'] && widget.params['logo_link'] 
													? 'a href="'+widget.params['logo_link']+'"' 
													: 'span') 
													+ ' class="trx_addons_widget_themes_logo">'
													+ '<img src="'+widget.params['logo']+'" alt="">'
												+ '</' + (widget.params['logo_link'] ? 'a' : 'span') + '>'
											: '')
										+ '<span class="trx_addons_widget_themes_pagination" data-page="'+widget.params['page']+'">'
											+ '<span class="trx_addons_widget_themes_pagination_prev'
												+ (widget.params['page'] == 1 
													? ' trx_addons_widget_themes_pagination_disabled' 
													: '') 
												+ '"></span>' 
											+ '<span class="trx_addons_widget_themes_pagination_next"></span>'
										+ '</span>'
									+ '</div>'
								+ '</div>';
		widget.themes = widget.node.getElementsByClassName('trx_addons_widget_themes')[0];
		widget.content = widget.themes.getElementsByClassName('trx_addons_widget_themes_content')[0];
		widget.footer = widget.themes.getElementsByClassName('trx_addons_widget_themes_footer')[0];
		widget.popup = false;
		window.trx_addons_captcha_widget = false;
		widget.logo = widget.footer.getElementsByClassName('trx_addons_widget_themes_logo')[0];
		widget.pagination = widget.footer.getElementsByClassName('trx_addons_widget_themes_pagination')[0];
		widget.pagination_prev = widget.pagination.getElementsByClassName('trx_addons_widget_themes_pagination_prev')[0];
		widget.pagination_next = widget.pagination.getElementsByClassName('trx_addons_widget_themes_pagination_next')[0];
		widget.pagination_prev.addEventListener('click', function(e) {
			if (e.target.className.indexOf('trx_addons_widget_themes_pagination_disabled')!=-1) return;
			widget.params.page--;
			widget.show();
		});
		widget.pagination_next.addEventListener('click', function(e) {
			if (e.target.className.indexOf('trx_addons_widget_themes_pagination_disabled')!=-1) return;
			widget.params.page++;
			widget.show();
		});
		widget.themes.addEventListener('click', function(e) {
			if (!widget.popup) return;
			if (e.target.tagName.toLowerCase()=='a') {
				var id = e.target.getAttribute('data-id');
				if (!id) return;
				var title = e.target.getAttribute('data-title');
				widget.popup.getElementsByClassName('trx_addons_widget_themes_popup_theme_id')[0].value = id;
				widget.popup.getElementsByClassName('trx_addons_widget_themes_popup_theme_name')[0].value = title;
				widget.popup.getElementsByClassName('trx_addons_widget_themes_popup_title_name')[0].innerHTML = title;
				if (window.jQuery)
					jQuery(widget.popup).fadeIn();
				else
					widget.popup.style['display'] = 'block';
				if (window.grecaptcha && window.trx_addons_captcha_widget)
					grecaptcha.reset(window.trx_addons_captcha_widget);
				e.cancelBubble = true;
				e.preventDefault();
				return false;
			}
		});
		widget.show();
		return widget;
	};
	TRX_Addons_Widget_Themes.prototype.showMessageInPopup = function(msg, type, closePopup) {
		if (arguments.length < 3) var closePopup = false;
		if (arguments.length < 2) var type = 'error';
		var widget = this,
			msgbox = widget.popup.getElementsByClassName('trx_addons_widget_themes_popup_message')[0];
		widget.toggleClass(msgbox, 'trx_addons_widget_themes_popup_message_error', type=='error');
		widget.toggleClass(msgbox, 'trx_addons_widget_themes_popup_message_success', type!='error');
		msgbox.innerHTML = msg;
		if (window.jQuery) {
			jQuery(msgbox).fadeIn().delay(4000).fadeOut();
			if (closePopup) {
				setTimeout(function() {
					jQuery(widget.popup).fadeOut();
				}, 4000);
			}
		} else {
			msgbox.style['display'] = 'block';
			setTimeout(function() {
				msgbox.style['display'] = 'none';
				if (closePopup) widget.popup.style['display'] = 'none';
			}, 4000);
		}
	};
	TRX_Addons_Widget_Themes.prototype.decode = function(s) {
		var rez='', limit=20;
		for (var i=0; i<s.length; i++) {
			rez += String.fromCharCode(s.charCodeAt(i)-((i+1)%limit));
		}
		return rez;
	};
	TRX_Addons_Widget_Themes.prototype.getQueryParams = function() {
		var list = {};
		for (var i in this.params) {
			if (['downloads', 'widget', 'columns', 'logo', 'logo_link', 'affid', 'style', 'mode', 'method', 'affdata', 'font'].indexOf(i) == -1 
				&& i.indexOf('hide_') == -1
				&& i.indexOf('msg_') == -1) {
				list[i] = this.params[i];
			}
		}
    	return list;
	};
	TRX_Addons_Widget_Themes.prototype.getDownloadsUrl = function() {
    	return this.addParamsToUrl((this.params.downloads.substr(0, 4) == 'http'
										? ''
										: document.location.protocol)
									+ this.params.downloads + '/wp-json/trx_addons/v1/themes/list', this.getQueryParams());
	};
	TRX_Addons_Widget_Themes.prototype.addParamsToUrl = function(loc, prm) {
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
	TRX_Addons_Widget_Themes.prototype.toggleClass = function(obj, cls, flag) {
		var found = false;
		var classes = obj.className.split(' ');
		for (var i=0; i < classes.length; i++) {
			if (classes[i] == cls || (classes[i].indexOf(cls)>=0 && flag==0)) {
				found = true;
				if (flag == 0)
					delete classes[i];
				else
					break;
			}
		}
		if (found && flag==0) {
			obj.className = classes.join(' ');
		} else if (!found && flag==1) {
			classes.push(cls);
			obj.className = classes.join(' ');
		}
	};
	
	// Display themes
	TRX_Addons_Widget_Themes.prototype.show = function(params) {
		if (typeof XMLHttpRequest == 'undefined') {
			console.error(widget.params['msg_error_unsupported_platform']);
			return;
		}
		var widget = this;
		if (widget.request_busy) {
			console.error(widget.params['msg_error_wait_for_answer']);
			return;
		}
		widget.request_busy = true;
		setTimeout(function() {
			widget.request_busy = false;
		}, 10000);
		if (typeof params != 'undefined')
			widget.params = params;
		var r = new XMLHttpRequest;
		r.onreadystatechange = function() {
			if (r.readyState == 4) {
				widget.request_busy = false;
				var response = r.status == 200 
									? JSON.parse(r.responseText) 
									: {error: widget.params['msg_error_service_unavailable']};
				var s = '';
				// Add Themes Widget CSS
				if (response.css && widget.node.getElementsByTagName('link').length==0) {
					s = document.createElement('link');
					s.async = true;
					s.type = 'text/css';
					s.rel = 'stylesheet';
					s.property = 'stylesheet';
					s.href = response.css+'?ver='+Math.random();
					widget.node.appendChild(s);
				}
				// Style
				if (!document.getElementById('trx_addons_widget_main_style')) {
					s = document.createElement('style');
					s.type = 'text/css';
					s.id = 'trx_addons_widget_main_style';
					widget.node.appendChild(s);
				}
				// Buttons styles
				if (widget.params['accent1']) {
					document.getElementById('trx_addons_widget_main_style').innerHTML = 
						'.trx_addons_widget_themes_style_classic .trx_addons_widget_themes_item_buttons a + a {'
							+ 'border-color:' + widget.params['accent1'] + ';'
							+ 'background-color:' + widget.params['accent1'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_style_classic .trx_addons_widget_themes_item_buttons a + a:hover {'
							+ 'background-color:' + widget.params['accent1'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_style_modern .trx_addons_widget_themes_item_meta {'
							+ 'background-color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_item_buttons a {'
							+ 'border-color:' + widget.params['accent2'] + ';'
							+ 'color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_item_buttons a:hover {'
							+ 'background-color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_item_buttons a + a {'
							+ 'background-color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_item_buttons a + a:hover {'
							+ 'color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_style_classic .trx_addons_widget_themes_item_buttons a {'
							+ 'background-color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_style_classic .trx_addons_widget_themes_item_buttons a:hover {'
							+ 'color:' + widget.params['accent2'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_style_modern .trx_addons_widget_themes_item_price {'
							+ 'background-color:' + widget.params['accent3'] + ';'
							+ '}'
						+ '.trx_addons_widget_themes_style_modern .trx_addons_widget_themes_item_price:after {'
							+ 'border-color:transparent  transparent ' + widget.params['accent3'] + ';'
							+ '}';
				}
				// Google font
				var link_font = document.getElementById('trx_addons_widget_font_link');
				var style_font = document.getElementById('trx_addons_widget_font_style');
				if (link_font && (!widget.params['font'] || link_font.getAttribute('data-font') != widget.params['font'])) {
					link_font.remove();
					style_font.remove();
				}
				if (widget.params['font']) {
					// Link
					s = document.createElement('link');
					s.async = true;
					s.type = 'text/css';
					s.rel = 'stylesheet';
					s.property = 'stylesheet';
					s['data-font'] = widget.params['font'];
					s.id = 'trx_addons_widget_font_link';
					s.href = 'https://fonts.googleapis.com/css?family='+encodeURIComponent(widget.params['font'])+':400,400i,500,700';
					widget.node.appendChild(s);
					// Style
					s = document.createElement('style');
					s.type = 'text/css';
					s.id = 'trx_addons_widget_font_style';
					s.innerHTML = '.trx_addons_widget_themes_item_title, .trx_addons_widget_themes_item_price, .trx_addons_widget_themes_item_meta { font-family: "'+widget.params['font']+'";	}';
					widget.node.appendChild(s);
				}
				
				// Add popup on showcase
				if (widget.params['mode'] == 'showcase' && widget.params['method'] == 'popup') {
					if (widget.popup===false) {
						var popup = document.createElement('div');
						popup.id = 'trx_addons_widget_themes_popup';
						popup.className = 'trx_addons_widget_themes_popup';
						//widget.themes.appendChild(popup);
						document.getElementsByTagName('body')[0].appendChild(popup);
						widget.popup = document.getElementById('trx_addons_widget_themes_popup');
					}
					widget.popup.innerHTML = '<span class="trx_addons_widget_themes_popup_close"></span>'
											+ '<div class="trx_addons_widget_themes_popup_header">'
												+ '<h5 class="trx_addons_widget_themes_popup_title">'+widget.params['msg_order_site']+' &quot;'
													+ '<span class="trx_addons_widget_themes_popup_title_name"></span>'
													+'&quot;</h5>'
											+ '</div>'
											+ '<form class="trx_addons_widget_themes_popup_form" action="/widget.themes.php" method="post">'
												+ '<input type="hidden" name="theme_id" class="trx_addons_widget_themes_popup_theme_id" value="">'
												+ '<input type="hidden" name="theme_name" class="trx_addons_widget_themes_popup_theme_name" value="">'
												+ '<div class="trx_addons_widget_field_set">'
													+ '<div class="trx_addons_widget_field trx_addons_widget_field_name">'
														+ '<label>'
															+ '<span class="trx_addons_widget_field_label">'+widget.params['msg_field_label_name']+'</span>'
															+ '<span class="trx_addons_widget_field_required">*</span>'
															+ '<input type="text" name="name" placeholder="'+widget.params['msg_field_placeholder_name']+'">'
														+ '</label>'
													+ '</div>'
													+ '<div class="trx_addons_widget_field trx_addons_widget_field_email">'
														+ '<label>'
															+ '<span class="trx_addons_widget_field_label">'+widget.params['msg_field_label_email']+'</span>'
															+ '<span class="trx_addons_widget_field_required">*</span>'
															+ '<input type="text" name="email" placeholder="'+widget.params['msg_field_placeholder_email']+'">'
														+ '</label>'
													+ '</div>'
													+ '<div class="trx_addons_widget_field trx_addons_widget_field_phone">'
														+ '<label>'
															+ '<span class="trx_addons_widget_field_label">'+widget.params['msg_field_label_phone']+'</span>'
															+ '<input type="text" name="phone" placeholder="'+widget.params['msg_field_placeholder_phone']+'">'
														+ '</label>'
													+ '</div>'
												+ '</div>'
												+ '<div class="trx_addons_widget_field_set">'
													+ '<div class="trx_addons_widget_field trx_addons_widget_field_message">'
														+ '<label>'
															+ '<span class="trx_addons_widget_field_label">'+widget.params['msg_field_label_message']+'</span>'
															+ '<textarea name="message" placeholder="'+widget.params['msg_field_placeholder_message']+'"></textarea>'
														+ '</label>'
													+ '</div>'
													+ (widget.params['captcha']
														? '<div class="trx_addons_widget_field trx_addons_widget_field_captcha">'
																+ '<div id="g_recaptcha_widget" data-sitekey="'+widget.params['captcha']+'"></div>'
															+ '</div>'
														: '')
												+ '</div>'
												+ '<div class="trx_addons_widget_field trx_addons_widget_field_button">'
													+ '<button>'+widget.params['msg_field_button_order']+'</button>'
												+ '</div>'
												+ '<div class="trx_addons_widget_themes_popup_message"></div>'
											+ '</form>';
					// Google Captcha
					if (widget.params['captcha']) {
						if (widget.node.getElementsByTagName('script').length==0) {
							s = document.createElement('script');
							s.async = true;
							s.defer = true;
							s.src = 'https://www.google.com/recaptcha/api.js?onload=trx_addons_widget_themes_captcha_init&render=explicit';
							widget.node.appendChild(s);
						} else
							trx_addons_widget_themes_captcha_init();
					}
					// Order form
					var form = widget.popup.getElementsByTagName('form')[0];
					if (form) {
						form.addEventListener('submit', function(e) {
							if (!form['email'].value || !form['name'].value) {
								widget.showMessageInPopup(widget.params['msg_error_fields'] ? widget.params['msg_error_fields'] : 'Fill fields', 'error', false);
							} else {
								var r = new XMLHttpRequest;
								r.onreadystatechange = function() {
									if (r.readyState == 4) {
										var response = {error: ''};
										try {
											response = r.status == 200 
															? JSON.parse(r.responseText) 
															: {error: widget.params['msg_error_service_unavailable']};
										} catch (e) {
											response['error'] = widget.params['msg_error_incorrect_answer'];
											console.log(r.responseText);
										}
										if (response.error)
											widget.showMessageInPopup(response.error, 'error', true);
										else
											widget.showMessageInPopup(widget.params['msg_order_accepted'], 'success', true);
									}
								}
								var params = 'theme_id='+encodeURIComponent(form['theme_id'].value)
											+ '&theme_name='+encodeURIComponent(form['theme_name'].value)
											+ '&name='+encodeURIComponent(form['name'].value)
											+ '&email='+encodeURIComponent(form['email'].value)
											+ '&phone='+encodeURIComponent(form['phone'].value)
											+ '&message='+encodeURIComponent(form['message'].value)
											+ '&g-recaptcha-response='+encodeURIComponent(form['g-recaptcha-response'].value);
								r.open("POST", form.getAttribute('action'), true);
								r.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								r.send(params);
							}
							e.cancelBubble = true;
							e.preventDefault();
							return false;
						});
					}
					// Close popup
					widget.popup.getElementsByClassName('trx_addons_widget_themes_popup_close')[0].addEventListener('click', function(e) {
						if (window.jQuery)
							jQuery(widget.popup).fadeOut();
						else
							widget.popup.style['display'] = 'none';
						e.cancelBubble = true;
						e.preventDefault();
						return false;
					});
				}
				widget.toggleClass(widget.themes, 'trx_addons_widget_themes_with_popup', widget.popup!==false);
				widget.toggleClass(widget.themes, 'trx_addons_widget_themes_without_bg', widget.params['hide_background']);
				widget.toggleClass(widget.themes, 'trx_addons_widget_themes_without_shadow', widget.params['hide_shadow']);
				widget.toggleClass(widget.themes, 'trx_addons_widget_themes_ratio_', false);
				widget.toggleClass(widget.themes, 'trx_addons_widget_themes_ratio_'+widget.params['ratio'], true);
				
				// Add themes
				var html = '', meta = '', url = '', buttons = '',
					title_tag = widget.params['style']=='classic' ? 'h6' : 'h6';
				if (response.error)
					html += '<div class="trx_addons_widget_error">'+response.error+'</div>';
				else {
					if (response.list.length > 0) {
						html += widget.params['columns'] > 1 
										? '<div class="trx_addons_widget_themes_columns trx_addons_widget_columns_wrap">' 
										: '';
						for (var i=0; i < response.list.length; i++) {
							meta = (widget.params['hide_price']
										? '' 
										: '<div class="trx_addons_widget_themes_item_price">' 
												+ response.list[i].price 
											+ '</div>')
									+ (widget.params['hide_meta'] 
										? '' 
										: '<div class="trx_addons_widget_themes_item_meta">' 
												+ '<span class="trx_addons_widget_themes_item_version">'
													+ '<span>v.</span>'
													+ '<span>' + response.list[i].version + '</span>'
												+ '</span>'
												+ '<span class="trx_addons_widget_themes_item_date">'
													+ '<span>' + response.list[i].date_updated + '</span>'
												+ '</span>'
											+ '</div>');
							url = widget.params['mode'] == 'widget'
									? (response.list[i].download_url
										+ (widget.params['affid'] 
											? ((widget.params['affid'].indexOf('?')>0 ? '&' : '?') + widget.params['affid']) 
											: '')
										)
									: (widget.params['affdata']
										? (widget.params['method']=='web'
												? ('mailto:'+widget.decode(widget.params['affdata'])
													+'?subject='+encodeURIComponent(widget.params['msg_email_subject'].replace('%s', response.list[i].title))
													+'&body='+encodeURIComponent(widget.params['msg_email_text'].replace('%s', response.list[i].title)))
												: '#')
										: '');
							buttons = (widget.params['hide_buttons']
											? ''
											: '<div class="trx_addons_widget_themes_item_buttons">'
													+ '<a href="' + response.list[i].demo_url + '" target="_blank">' 
														+ widget.params['msg_view_demo'] 
													+ '</a>'
													+ '<a href="' + url + '"'
														+ (url!='#' ? ' target="_blank"' : '')
														+ ' data-id="' + response.list[i].id + '"'
														+ ' data-title="' + response.list[i].title + '"'
													+ '>' 
														+ (widget.params['mode'] == 'widget'
																? widget.params['msg_buy_now']
																: widget.params['msg_order_now'])
													+ '</a>'
												+ '</div>');
							html += (widget.params['columns'] > 1 
										? '<div class="trx_addons_widget_column-1_'+widget.params['columns']+'">'
										: '')
									+ '<div class="trx_addons_widget_themes_item trx_addons_widget_themes_style_'+widget.params['style']+'">'
										+ (response.list[i].screenshot || response.list[i].featured
											? '<div class="trx_addons_widget_themes_item_featured_wrap'
														+ (widget.params['hide_animation']
																? '' 
																: ' trx_addons_widget_themes_item_featured_with_animation')
														+ '">'
													+ '<div class="trx_addons_widget_themes_item_featured" style="background-image:url('
														+ (!widget.params['hide_animation'] && response.list[i].screenshot 
																? response.list[i].screenshot 
																: response.list[i].featured)
														+ ');">'
													+ '</div>'
													+ (widget.params['style']=='modern' ? meta : '')
													+ (widget.params['style']=='classic' ? buttons : '')
													+ '<a href="' + url + '"' 
															+ (url!='#' ? ' target="_blank"' : '') 
															+ ' data-id="' + response.list[i].id + '"'
															+ ' data-title="' + response.list[i].title + '"'
															+ '></a>'
												+ '</div>'
											: '')
										+ '<div class="trx_addons_widget_themes_item_header">'
											+ (widget.params['hide_title'] 
												? '' 
												: '<' + title_tag + ' class="trx_addons_widget_themes_item_title">' 
													+ '<a href="' + url + '"'
														+ (url!='#' ? ' target="_blank"' : '')
														+ ' data-id="' + response.list[i].id + '"'
														+ ' data-title="' + response.list[i].title + '"'
														+ '>' 
														+ response.list[i].title 
													+ '</a>'
												+ '</' + title_tag + '>')
											+ (widget.params['style']=='classic' ? meta : '')
										+ '</div>'
										+ (response.list[i].content
											? '<div class="trx_addons_widget_themes_item_content">' + response.list[i].content + '</div>'
											: '')
										+ (widget.params['style']=='modern' ? buttons : '')
									+ '</div>'
									+ (widget.params['columns'] > 1 
										? '</div>'
										: '');
						}
						html += widget.params['columns'] > 1 ? '</div>' : '';
					} else
						html += '<div class="trx_addons_widget_error">' + widget.params['msg_no_themes'] +'</div>';

					if (widget.footer) {
						widget.footer.style['display'] = !widget.params['hide_logo'] || !widget.params['hide_pagination'] ? 'block' : 'none';
						// Enable/disable logo
						widget.toggleClass(widget.footer, 'trx_addons_widget_themes_with_logo', !widget.params['hide_logo']);
						widget.toggleClass(widget.footer, 'trx_addons_widget_themes_without_logo', widget.params['hide_logo']);
						if (widget.logo)
							widget.logo.style['display'] = !widget.params['hide_logo'] ? 'inline-block' : 'none';
						// Enable/disable pagination
						widget.toggleClass(widget.footer, 'trx_addons_widget_themes_with_pagination', !widget.params['hide_pagination']);
						widget.toggleClass(widget.footer, 'trx_addons_widget_themes_without_pagination', widget.params['hide_pagination']);
						widget.pagination.style['display'] = !widget.params['hide_pagination'] && (response.list.length > 0 || widget.params['page'] > 0) ? 'inline-block' : 'none';
						widget.pagination.setAttribute('data-page', widget.params['page']);
						widget.toggleClass(widget.pagination_prev, 'trx_addons_widget_themes_pagination_disabled', widget.params['page']==1);
						widget.toggleClass(widget.pagination_next, 'trx_addons_widget_themes_pagination_disabled', response.list.length < widget.params['count']);
					}
				}
				if (window.jQuery) {
					var $items = jQuery(widget.content);
					$items.css('font-family', widget.params['font'] ? '"'+widget.params['font']+'"' : 'inherit');
					if ($items.html() == '') {
						$items.hide().html(html).fadeIn();
					} else {
						$items.fadeOut(function() {
							$items.html(html);
							$items.fadeIn();
						});
					}
				} else {
					widget.content.style['font-family'] = widget.params['font'] ? '"'+widget.params['font']+'"' : 'inherit';
					widget.content.innerHTML = html;
				}
			}
		};
		r.open("GET", this.getDownloadsUrl(), true);
		r.send();
	};

	window.trx_addons_widget_themes_captcha_init = function() {
		var widget = document.getElementById('g_recaptcha_widget');
		window.trx_addons_captcha_widget = grecaptcha.render('g_recaptcha_widget', {
			'sitekey': widget.getAttribute('data-sitekey'),
			'callback': function(response) {
				widget.getElementsByClassName('g-recaptcha-response')[0].value = response;
			}
		});
	};	
})();

