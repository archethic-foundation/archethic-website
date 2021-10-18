/**
 * Init scripts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).ready(function() {

	"use strict";

	var vc_init_counter = 0;

	trx_addons_init_actions();
	
	// Show preloader
	jQuery(window).on('beforeunload', function(e) {
		if (jQuery.browser && !jQuery.browser.safari) {
			jQuery('#page_preloader').css({display: 'block', opacity: 0}).animate({opacity:0.8}, 300);
			setTimeout(trx_addons_hide_preloader, 5000);
		}
	});


	// Hide preloader
	function trx_addons_hide_preloader() {
		jQuery('#page_preloader').animate({opacity:0}, 800, function() {
									jQuery(this).css( {display: 'none'} );
									});
	}
		
	// Init actions
	function trx_addons_init_actions() {
		
		if (TRX_ADDONS_STORAGE['vc_edit_mode'] > 0 && jQuery('.vc_empty-placeholder').length==0 && vc_init_counter++ < 30) {
			setTimeout(trx_addons_init_actions, 200);
			return;
		}

		// Hide preloader
		trx_addons_hide_preloader();
		
		// Show system message
		var msg = jQuery('.trx_addons_message_box_system'),
			msg_delay = 5000;
		if (msg.length > 0) {
			setTimeout(function() {
				msg.fadeIn().delay(msg_delay).fadeOut();
			}, 1000);
			var login = jQuery('.trx_addons_login_link');
			if (msg.hasClass('trx_addons_message_box_error') && login.length > 0) {
				setTimeout(function() {
					login.trigger('click');
				}, 2000+msg_delay);
			}
		}

		// Shift page down to display hash-link if menu is fixed
		// (except WooCommerce product page, because WooCommerce has own handler of the hash url)
		if (typeof TRX_ADDONS_STORAGE['animate_to_hash']=='undefined' && !jQuery('body').hasClass('single-product')) {
			TRX_ADDONS_STORAGE['animate_to_hash'] = true;
			setTimeout(function() {
				// Hack for MailChimp - use our scroll to form, because his method damage layouts in the Chrome
				if (window.mc4wp_forms_config && window.mc4wp_forms_config.submitted_form && window.mc4wp_forms_config.submitted_form.element_id) {
					trx_addons_document_animate_to(window.mc4wp_forms_config.submitted_form.element_id);
				
				// Shift page down on fixed rows height
				} else if (location.hash != '') {
					var obj = jQuery(location.hash);
					if (obj.length > 0) {
						var off = obj.offset().top,
							scroll = jQuery(window).scrollTop(),
							fixed_height = trx_addons_fixed_rows_height();
						if (!isNaN(off) && ((fixed_height > 0 && off - scroll < fixed_height + 60) || scroll == 0)) {
							trx_addons_document_animate_to(off - fixed_height - 60);
						}
					}
				}
			}, 600);
		}
		
		// Check for Retina display
		trx_addons_set_cookie('trx_addons_is_retina', trx_addons_is_retina() ? 1 : 0, 365);
	
		// Add ready actions to the hidden elements actions
		var first_call = true;
		jQuery(document)
			.on('action.init_hidden_elements', function() {
				// Init core elements
				trx_addons_ready_actions();
				// Generate 'scroll' event after hidden elements are inited
				if (!first_call) jQuery(window).trigger('scroll');
				first_call = false;
			})
			// First call to init core actions
			.trigger('action.init_hidden_elements', [jQuery('body')]);

		// Add our handlers after the VC init
		var vc_js = false;
		jQuery(document).on('vc_js', function() {
			if (!vc_js)	{
				vc_js = true;
				trx_addons_add_handlers();
			}
		});

		// Add our handlers if VC is no activated
		setTimeout(function() {
			if (!vc_js)	{
				trx_addons_add_handlers();
			}
		}, 1);

		// Add our handlers
		function trx_addons_add_handlers() {		
			// Resize handlers
			trx_addons_resize_actions();
			jQuery(window).resize(function() {
				trx_addons_resize_actions();
			});

			// Scroll handlers
			TRX_ADDONS_STORAGE['scroll_busy'] = true;
			trx_addons_scroll_actions();
			jQuery(window).scroll(function() {
				if (window.requestAnimationFrame) {
					if (!TRX_ADDONS_STORAGE['scroll_busy']){
						window.requestAnimationFrame(trx_addons_scroll_actions);
						TRX_ADDONS_STORAGE['scroll_busy'] = true;
					}
				} else {
					trx_addons_scroll_actions();
				}
			});

			// Inject our code in the VC function wpb_prepare_tab_content()
			// to init our elements on the new VC tabs, tour and accordion activation
			typeof window.wpb_prepare_tab_content == "function"
				&& typeof window.wpb_prepare_tab_content_old == "undefined"
				&& (window.wpb_prepare_tab_content_old = window.wpb_prepare_tab_content)
				&& (window.wpb_prepare_tab_content = function(e, ui) {
					// Call ThemeREX Addons actions
					if (typeof ui.newPanel !== 'undefined' && ui.newPanel.length > 0) {
						jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
					} else if (typeof ui.panel !== 'undefined' && ui.panel.length > 0) {
						jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
					}
					// Call old VC handler
					window.wpb_prepare_tab_content_old(e, ui);
				});
			// Inject our code in the VC function vc_accordionActivate()
			// to init our elements on the old VC accordion activation
			typeof window.vc_accordionActivate == "function"
				&& typeof window.vc_accordionActivate_old == "undefined"
				&& (window.vc_accordionActivate_old = window.vc_accordionActivate)
				&& (window.vc_accordionActivate = function(e, ui) {
					// Call ThemeREX Addons actions
					if (typeof ui.newPanel !== 'undefined' && ui.newPanel.length > 0) {
						jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
					} else if (typeof ui.panel !== 'undefined' && ui.panel.length > 0) {
						jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
					}
					// Call old VC handler
					window.vc_accordionActivate_old(e, ui);
				});
		}
	}
	
	
	
	// Page first load actions
	//==============================================
	function trx_addons_ready_actions(e, container) {
	
		if (container === undefined) container = jQuery('body');

		// Animate to the page-inner links
		//----------------------------------------------
		if (TRX_ADDONS_STORAGE['animate_inner_links'] > 0 && !container.hasClass('animate_to_inited')) {
			container.addClass('animate_to_inited')
				.on('click', 'a', function(e) {
					var link_obj = jQuery(this);
					var link_parent = link_obj.parent();
					// Skip tabs and accordions
					if (link_parent.parent().hasClass('trx_addons_tabs_titles')	// trx_addons_tabs
						|| link_parent.hasClass('vc_tta-tab') 					// new VC tabs, old VC tabs, new VC tour
						|| link_obj.hasClass('vc_pagination-trigger')			// pagination in VC tabs
						|| link_obj.hasClass('ui-tabs-anchor') 					// old VC tour
						|| link_parent.hasClass('vc_tta-panel-title')			// new VC accordion
						|| link_parent.hasClass('wpb_accordion_header') 		// old VC accordion
						) return;
					var href = link_obj.attr('href');
					if (href == '#') return;
					if (trx_addons_is_local_link(href)) {
						var pos = href.indexOf('#'),
							offset = 0;
						if (pos >= 0) {
							href = href.substr(pos);
							if (jQuery(href).length > 0) {
								trx_addons_document_animate_to(href);
								e.preventDefault();
								return false;
							}
						}
					}
				});
		}
		
	
		// Tabs
		//------------------------------------
		if (jQuery.ui && jQuery.ui.tabs && container.find('.trx_addons_tabs:not(.inited)').length > 0) {
			container.find('.trx_addons_tabs:not(.inited)').each(function () {
				// Get initially opened tab
				var init = jQuery(this).data('active');
				if (isNaN(init)) {
					init = 0;
					var active = jQuery(this).find('> ul > li[data-active="true"]').eq(0);
					if (active.length > 0) {
						init = active.index();
						if (isNaN(init) || init < 0) init = 0;
					}
				} else {
					init = Math.max(0, init);
				}
				// Get disabled tabs
				var disabled = [];
				jQuery(this).find('> ul > li[data-disabled="true"]').each(function() {
					disabled.push(jQuery(this).index());
				});
				// Init tabs
				jQuery(this).addClass('inited').tabs({
					active: init,
					disabled: disabled,
					show: {
						effect: 'fadeIn',
						duration: 300
					},
					hide: {
						effect: 'fadeOut',
						duration: 300
					},
					create: function( event, ui ) {
						if (ui.panel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
					},
					activate: function( event, ui ) {
						if (ui.newPanel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
					}
				});
			});
		}
	
	
		// Accordion
		//------------------------------------
		if (jQuery.ui && jQuery.ui.accordion && container.find('.trx_addons_accordion:not(.inited)').length > 0) {
			container.find('.trx_addons_accordion:not(.inited)').each(function () {
				// Get headers selector
				var accordion = jQuery(this);
				var headers = accordion.data('headers');
				if (headers===undefined) headers = 'h5';
				// Get height style
				var height_style = accordion.data('height-style');
				if (height_style===undefined) height_style = 'content';
				// Get collapsible
				var collapsible = accordion.data('collapsible');
				if (collapsible===undefined) collapsible = false;
				// Get initially opened tab
				var init = accordion.data('active');
				var active = false;
				if (isNaN(init)) {
					init = 0;
					var active = accordion.find(headers+'[data-active="true"]').eq(0);
					if (active.length > 0) {
						while (!active.parent().hasClass('trx_addons_accordion')) {
							active = active.parent();
						}
						init = active.index();
						if (isNaN(init) || init < 0) init = 0;
					}
				} else {
					init = Math.max(0, init);
				}
				// Init accordion
				accordion.addClass('inited').accordion({
					active: init,
					collapsible: collapsible,
					header: headers,
					heightStyle: height_style,
					create: function( event, ui ) {
						if (ui.panel.length > 0) {
							jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
						} else if (active !== false && active.length > 0) {
							// If headers and panels wrapped into div
							active.find('>'+headers).trigger('click');
						}
					},
					activate: function( event, ui ) {
						if (ui.newPanel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
					}
				});
			});
		}
	
	
		// Color Picker
		var cp = container.find('.trx_addons_color_selector:not(.inited)'),
			cp_created = false;
		if (cp.length > 0) {
			cp.addClass('inited').each(function() {
				// Internal ColorPicker
				if (jQuery(this).hasClass('iColorPicker')) {
					if (!cp_created) {
						trx_addons_color_picker();
						cp_created = true;
					}
					trx_addons_change_field_colors(jQuery(this));
					jQuery(this)
						.on('focus', function (e) {
							trx_addons_color_picker_show(null, jQuery(this), function(fld, clr) {
								fld.val(clr).trigger('change');
								trx_addons_change_field_colors(fld);
							});
						}).on('change', function(e) {
							trx_addons_change_field_colors(jQuery(this));
						});
					
				// WP ColorPicker - Iris
				} else if (typeof jQuery.fn.wpColorPicker != 'undefined') {
					jQuery(this).wpColorPicker({
						// you can declare a default color here,
						// or in the data-default-color attribute on the input
						//defaultColor: false,
				
						// a callback to fire whenever the color changes to a valid color
						change: function(e, ui){
							jQuery(e.target).val(ui.color).trigger('change');
						},
				
						// a callback to fire when the input is emptied or an invalid color
						clear: function(e) {
							jQuery(e.target).prev().trigger('change')
						},
				
						// hide the color picker controls on load
						//hide: true,
				
						// show a group of common colors beneath the square
						// or, supply an array of colors to customize further
						//palettes: true
					});
				}
			});
		}
	
		// Change colors of the field
		function trx_addons_change_field_colors(fld) {
			var clr = fld.val(),
				hsb = trx_addons_hex2hsb(clr);
			fld.css({
				'backgroundColor': clr,
				'color': hsb['b'] < 70 ? '#fff' : '#000'
			});
		}


		// Range Slider
		//------------------------------------
		if (jQuery.ui && jQuery.ui.slider && container.find('.trx_addons_range_slider:not(.inited)').length > 0) {
			container.find('.trx_addons_range_slider:not(.inited)').each(function () {
				// Get parameters
				var range_slider = jQuery(this);
				var linked_field = range_slider.data('linked_field');
				if (linked_field===undefined) linked_field = range_slider.prev('input[type="hidden"]');
				else linked_field = jQuery('#'+linked_field);
				if (linked_field.length == 0) return;
				var range_slider_cur = range_slider.find('> .trx_addons_range_slider_label_cur');
				var range_slider_type = range_slider.data('range');
				if (range_slider_type===undefined) range_slider_type = 'min';
				var values = linked_field.val().split(',');
				var minimum = range_slider.data('min');
				if (minimum===undefined) minimum = 0;
				var maximum = range_slider.data('max');
				if (maximum===undefined) maximum = 0;
				var step = range_slider.data('step');
				if (step===undefined) step = 1;
				// Init range slider
				var init_obj = {
					range: range_slider_type,
					min: minimum,
					max: maximum,
					step: step,
					slide: function(event, ui) {
						var cur_values = range_slider_type === 'min' ? [ui.value] : ui.values;
						linked_field.val(cur_values.join(',')).trigger('change');
						for (var i=0; i < cur_values.length; i++) {
							range_slider_cur.eq(i)
									.html(cur_values[i])
									.css('left', Math.max(0, Math.min(100, (cur_values[i]-minimum)*100/(maximum-minimum)))+'%');
						}
					},
					create: function(event, ui) {
						for (var i=0; i < values.length; i++) {
							range_slider_cur.eq(i)
									.html(values[i])
									.css('left', Math.max(0, Math.min(100, (values[i]-minimum)*100/(maximum-minimum)))+'%');
						}
					}
				};
				if (range_slider_type === true)
					init_obj.values = values;
				else
					init_obj.value = values[0];
				range_slider.addClass('inited').slider(init_obj);
			});
		}
	
	
		// Select2
		//------------------------------------
		if (jQuery.fn && jQuery.fn.select2) {
			container.find('.trx_addons_select2:not(.inited)').addClass('inited').select2();
		}
		
	
		// Video player
		//----------------------------------------------
		if (container.find('.trx_addons_video_player.with_cover .video_hover:not(.inited)').length > 0) {
			container.find('.trx_addons_video_player.with_cover .video_hover:not(.inited)')
				.addClass('inited')
				.on('click', function(e) {
					
					// If video in the popup
					if (jQuery(this).hasClass('trx_addons_popup_link')) return;
					
					jQuery(this).parents('.trx_addons_video_player')
						.addClass('video_play')
						.find('.video_embed').html(jQuery(this).data('video'));
	
					// If video in the slide
					var slider = jQuery(this).parents('.slider_swiper');
					if (slider.length > 0) {
						var id = slider.attr('id');
						TRX_ADDONS_STORAGE['swipers'][id].stopAutoplay();
						// If slider have controller - stop it too
						id = slider.data('controller');
						if (id && TRX_ADDONS_STORAGE['swipers'][id+'_swiper'])
							TRX_ADDONS_STORAGE['swipers'][id+'_swiper'].stopAutoplay();
						
					}
	
					jQuery(document).trigger('action.init_hidden_elements', [jQuery(this).parents('.trx_addons_video_player')]);
					jQuery(window).trigger('resize');
					e.preventDefault();
					return false;
				});
		}
	
	
		// Popups
		//----------------------------------------------

		// PrettyPhoto Engine
		if (TRX_ADDONS_STORAGE['popup_engine'] == 'pretty') {
			// Display lightbox on click on the image
			container.find("a[href$='jpg']:not(.inited),a[href$='jpeg']:not(.inited),a[href$='png']:not(.inited),a[href$='gif']:not(.inited)").each(function() {
				if (!jQuery(this).parent().hasClass('woocommerce-product-gallery__image'))
					jQuery(this).attr('rel', 'prettyPhoto[slideshow]');
			});
			var images = container.find("a[rel*='prettyPhoto']:not(.inited):not(.esgbox):not([data-rel*='pretty']):not([rel*='magnific']):not([data-rel*='magnific'])").addClass('inited');
			try {
				images.prettyPhoto({
					social_tools: '',
					theme: 'facebook',
					deeplinking: false
				});
			} catch (e) {};
		
		// or Magnific Popup Engine
		} else if (TRX_ADDONS_STORAGE['popup_engine']=='magnific') {
			// Display lightbox on click on the image
			container.find("a[href$='jpg']:not(.inited),a[href$='jpeg']:not(.inited),a[href$='png']:not(.inited),a[href$='gif']:not(.inited)").each(function() {
				//if (!jQuery(this).parent().hasClass('woocommerce-product-gallery__image'))
				if (jQuery(this).parents('.cq-dagallery').length == 0)
					jQuery(this).attr('rel', 'magnific');
			});
			var images = container.find("a[rel*='magnific']:not(.inited):not(.esgbox):not(.prettyphoto):not([rel*='pretty']):not([data-rel*='pretty'])").addClass('inited');
			// Unbind prettyPhoto
			setTimeout(function() {	images.unbind('click.prettyphoto'); }, 100);
			// Bind Magnific
			try {
				images.magnificPopup({
					type: 'image',
					mainClass: 'mfp-img-mobile',
					closeOnContentClick: true,
					closeBtnInside: true,
					fixedContentPos: true,
					midClick: true,
					//removalDelay: 500, 
					preloader: true,
					tLoading: TRX_ADDONS_STORAGE['msg_magnific_loading'],
					gallery:{
						enabled: true
					},
					image: {
						tError: TRX_ADDONS_STORAGE['msg_magnific_error'],
						verticalFit: true
					},
					zoom: {
						enabled: true,
						duration: 300,
						easing: 'ease-in-out',
						opener: function(openerElement) {
							// openerElement is the element on which popup was initialized, in this case its <a> tag
							// you don't need to add "opener" option if this code matches your needs, it's defailt one.
							if (!openerElement.is('img')) {
								if (openerElement.parents('.trx_addons_hover').find('img').length > 0)
									openerElement = openerElement.parents('.trx_addons_hover').find('img');
								else if (openerElement.find('img').length > 0)
									 openerElement = openerElement.find('img');
								else if (openerElement.siblings('img').length > 0)
									 openerElement = openerElement.siblings('img');
								else if (openerElement.parent().parent().find('img').length > 0)
									 openerElement = openerElement.parent().parent().find('img');
							}
							return openerElement; 
						}
					},
					callbacks: {
						beforeClose: function(){
							jQuery('.mfp-figure figcaption').hide();
							jQuery('.mfp-figure .mfp-arrow').hide();
						}
					}
				});
			} catch (e) {};
	
			// Display lightbox on click on the popup link
			container.find(".trx_addons_popup_link:not(.popup_inited)").addClass('popup_inited').magnificPopup({
				type: 'inline',
				focus: 'input',
				closeBtnInside: true,
				callbacks: {
					// Will fire when this exact popup is opened
					// this - is Magnific Popup object
					open: function () {
						// Store popup content to the data-param or restore it when popup open again (second time)
						if (jQuery(this.content).data('popup-content') === undefined)
							jQuery(this.content).data('popup-content', jQuery(this.content).html());
						else
							jQuery(this.content).html(jQuery(this.content).data('popup-content'));
						// Remove class 'inited' to reinit elements
						jQuery(this.content).find('.inited').removeClass('inited');
						// Init hidden elements
						jQuery(document).trigger('action.init_hidden_elements', [jQuery(this.content)]);
						// Init third-party plugins in the popup
						jQuery(document).trigger('action.init_popup_elements', [jQuery(this.content)]);
						// If popup contain embedded video
						var frame = jQuery(this.content).find('.video_frame');
						if (frame.length > 0) {
							// Add autoplay to the embedded video
							frame.find('> iframe').each(function () {
								var src = jQuery(this).attr('src');
								if (src.indexOf('youtube')>=0 || src.indexOf('vimeo')>=0) {
									jQuery(this).attr('src', trx_addons_add_to_url(src, {'autoplay': 1}));
								}
							});
						}
						// If popup contain essential grid
						var frame = jQuery(this.content).find('.esg-grid');
						if (frame.length > 0) {
							var wrappers = [".esg-tc.eec", ".esg-lc.eec", ".esg-rc.eec", ".esg-cc.eec", ".esg-bc.eec"];
							for (var i=0; i<wrappers.length; i++) {
								frame.find(wrappers[i]+'>'+wrappers[i]).unwrap();
							}
						}
					},
					close: function () {
						// Remove video
						jQuery(this.content).empty();
					},
					// resize event triggers only when height is changed or layout forced
					resize: function () {
						trx_addons_resize_actions();
					}
				}
			});
		}
	
	
		// Likes counter
		//---------------------------------------------
		if (container.find('a.post_counters_likes:not(.inited),a.comment_counters_likes:not(.inited)').length > 0) {
			var likes_busy = false;
			container.find('a.post_counters_likes:not(.inited),a.comment_counters_likes:not(.inited)')
				.addClass('inited')
				.on('click', function(e) {
					if (!likes_busy) {
						likes_busy = true;
						var button = jQuery(this);
						var inc = button.hasClass('enabled') ? 1 : -1;
						var post_id = button.hasClass('post_counters_likes') ? button.data('postid') :  button.data('commentid');
						var cookie_likes = trx_addons_get_cookie(button.hasClass('post_counters_likes') ? 'trx_addons_likes' : 'trx_addons_comment_likes');
						if (cookie_likes === undefined || cookie_likes===null) cookie_likes = '';
						jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
							action: button.hasClass('post_counters_likes') ? 'post_counter' : 'comment_counter',
							nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
							post_id: post_id,
							likes: inc
						}).done(function(response) {
							var rez = {};
							try {
								rez = JSON.parse(response);
							} catch (e) {
								rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
								console.log(response);
							}
							if (rez.error === '') {
								var counter = rez.counter;
								if (inc == 1) {
									var title = button.data('title-dislike');
									button.removeClass('enabled trx_addons_icon-heart-empty').addClass('disabled trx_addons_icon-heart');
									cookie_likes += (cookie_likes.substr(-1)!=',' ? ',' : '') + post_id + ',';
								} else {
									var title = button.data('title-like');
									button.removeClass('disabled trx_addons_icon-heart').addClass('enabled trx_addons_icon-heart-empty');
									cookie_likes = cookie_likes.replace(','+post_id+',', ',');
								}
								button.data('likes', counter).attr('title', title).find(button.hasClass('post_counters_likes') ? '.post_counters_number' : '.comment_counters_number').html(counter);
								trx_addons_set_cookie(button.hasClass('post_counters_likes') ? 'trx_addons_likes' : 'trx_addons_comment_likes', cookie_likes, 365);
							} else {
								alert(TRX_ADDONS_STORAGE['msg_error_like']);
							}
							likes_busy = false;
						});
					}
					e.preventDefault();
					return false;
				});
		}
	
	
		// Emotions counter
		//---------------------------------------------
		if (container.find('.trx_addons_emotions:not(.inited)').length > 0) {
			var emotions_busy = false;
			container.find('.trx_addons_emotions:not(.inited)')
				.addClass('inited')
				.on('click', '.trx_addons_emotions_item', function(e) {
					if (!emotions_busy) {
						emotions_busy = true;
						var button = jQuery(this);
						var button_active = button.parent().find('.trx_addons_emotions_active');
						var post_id = button.data('postid');
						jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
							action: 'post_counter',
							nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
							post_id: post_id,
							emotion_inc: button.data('slug'),
							emotion_dec: button_active.length > 0 ? button_active.data('slug') : '',
						}).done(function(response) {
							var rez = {};
							try {
								rez = JSON.parse(response);
							} catch (e) {
								rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
								console.log(response);
							}
							if (rez.error === '') {
								var cookie_likes = trx_addons_get_cookie('trx_addons_emotions'),
									cookie_likes_new = ',';
								if (cookie_likes) {
									cookie_likes = cookie_likes.split(',');
									for (var i=0; i<cookie_likes.length; i++) {
										if (cookie_likes[i] == '') continue;
										var tmp = cookie_likes[i].split('=');
										if (tmp[0] != post_id) cookie_likes_new += cookie_likes[i] + ',';
									}
								}
								cookie_likes = cookie_likes_new;
								if (button_active.length > 0) {
									button_active.removeClass('trx_addons_emotions_active');
								}
								if (button_active.length == 0 || button.data('slug') != button_active.data('slug')) {
									button.addClass('trx_addons_emotions_active');
									cookie_likes += (cookie_likes.substr(-1)!=',' ? ',' : '') + post_id + '=' + button.data('slug') + ',';
								}
								for (var i in rez.counter)
									button.parent().find('[data-slug="'+i+'"] .trx_addons_emotions_item_number').html(rez.counter[i]);
								trx_addons_set_cookie('trx_addons_emotions', cookie_likes, 365);
							} else {
								alert(TRX_ADDONS_STORAGE['msg_error_like']);
							}
							emotions_busy = false;
						});
					}
					e.preventDefault();
					return false;
				});
		}
	
	
		// Socials share
		//----------------------------------------------
		if (container.find('.socials_share .socials_caption:not(.inited)').length > 0) {
			container.find('.socials_share .socials_caption:not(.inited)').each(function() {
				jQuery(this).addClass('inited').on('click', function(e) {
					jQuery(this).siblings('.social_items').slideToggle();	//.toggleClass('opened');
					e.preventDefault();
					return false;
				});
			});
		}
		if (container.find('.socials_share .social_items:not(.inited)').length > 0) {
			container.find('.socials_share .social_items:not(.inited)').each(function() {
				jQuery(this).addClass('inited').on('click', '.social_item_popup', function(e) {
					var url = jQuery(this).data('link');
					window.open(url, '_blank', 'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=480, height=400, toolbar=0, status=0');
					e.preventDefault();
					return false;
				});
			});
		}
		
		
		// Widgets decoration
		//----------------------------------------------
	
		// Decorate nested lists in widgets and side panels
		container.find('.widget ul > li').each(function() {
			if (jQuery(this).find('ul').length > 0) {
				jQuery(this).addClass('has_children');
			}
		});
	
		// Archive widget decoration
		container.find('.widget_archive a:not(.inited)').addClass('inited').each(function() {
			var val = jQuery(this).html().split(' ');
			if (val.length > 1) {
				val[val.length-1] = '<span>' + val[val.length-1] + '</span>';
				jQuery(this).html(val.join(' '))
			}
		});
	
	
		// Menu
		//----------------------------------------------
	
		// Prepare menus (if menu cache is used)
		jQuery('.sc_layouts_menu_nav').each(function() {
			if (jQuery(this).find('.current-menu-item').length == 0 || jQuery('body').hasClass('blog_template')) {
				if (TRX_ADDONS_STORAGE['menu_cache'] === undefined) TRX_ADDONS_STORAGE['menu_cache'] = [];
				var id = jQuery(this).attr('id');
				if (id === undefined) {
					id = ('sc_layouts_menu_nav_' + Math.random()).replace('.', '');
					jQuery(this).attr('id', id);
				}
				TRX_ADDONS_STORAGE['menu_cache'].push('#'+id);
			}
		});
		if (TRX_ADDONS_STORAGE['menu_cache'] && TRX_ADDONS_STORAGE['menu_cache'].length > 0) {
			// Mark the current menu item and its parent items in the cached menus
			var href = window.location.href;
			if (href.substr(-1)=='/') href = href.substr(0, href.length-1);
			var href2 = href + '/';
			for (var i = 0; i < TRX_ADDONS_STORAGE['menu_cache'].length; i++) {
				var menu = jQuery(TRX_ADDONS_STORAGE['menu_cache'][i]+':not(.prepared)');
				if (menu.length==0) continue;
				menu.addClass('prepared');
				menu.find('li').removeClass('current-menu-ancestor current-menu-parent current-menu-item current_page_item');
				menu.find('a[href="'+href+'"],a[href="'+href2+'"]').each(function(idx) {
					var li = jQuery(this).parent();
					li.addClass('current-menu-item');
					if (li.hasClass('menu-item-object-page')) li.addClass('current_page_item');
					var cnt = 0;
					while ((li = li.parents('li')).length > 0) {
						cnt++;
						li.addClass('current-menu-ancestor'+(cnt==1 ? ' current-menu-parent' : ''));
					}
				});
			}
		}
	
	
		// Other settings
		//------------------------------------
	
		// Scroll to top button
		container.find('.trx_addons_scroll_to_top:not(.inited)').addClass('inited').on('click', function(e) {
			jQuery('html,body').animate({
				scrollTop: 0
			}, 'slow');
			e.preventDefault();
			return false;
		});
	
		// Call plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.before_ready_trx_addons');
		jQuery(document).trigger('action.ready_trx_addons');
		jQuery(document).trigger('action.after_ready_trx_addons');
		
	} //end ready


	// Increment post views counter via AJAX
	if (TRX_ADDONS_STORAGE['ajax_views']) {
		jQuery(document).on('action.ready_trx_addons', function() {
			if (!TRX_ADDONS_STORAGE['post_views_counter_inited']) {
				TRX_ADDONS_STORAGE['post_views_counter_inited'] = true;
				setTimeout(function() {
					jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
						action: 'post_counter',
						nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
						post_id: TRX_ADDONS_STORAGE['post_id'],
						views: 1
					}).done(function(response) {
						var rez = {};
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: TRX_ADDONS_STORAGE['ajax_error'] };
							console.log(response);
						}
						if (rez.error === '') {
							jQuery('.post_counters_single .post_counters_views .post_counters_number,.sc_layouts_title_meta .post_counters_views .post_counters_number').html(rez.counter);
						}
					});
				}, 10);
			}
		});
	}


	
	// Scroll actions
	//==============================================
	
	// Do actions when page scrolled
	function trx_addons_scroll_actions() {

		var scroll_offset = jQuery(window).scrollTop();
		var scroll_to_top_button = jQuery('.trx_addons_scroll_to_top');
		var adminbar_height = Math.max(0, jQuery('#wpadminbar').height());
	
		// Scroll to top button show/hide
		if (scroll_to_top_button.length > 0) {
			if (scroll_offset > 100)
				scroll_to_top_button.addClass('show');
			else
				scroll_to_top_button.removeClass('show');
		}
	
		// Scroll actions for animated elements
		jQuery('[data-animation^="animated"]:not(.animated)').each(function() {
			if (jQuery(this).offset().top < scroll_offset + jQuery(window).height())
				jQuery(this).addClass(jQuery(this).data('animation'));
		});
	
		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.scroll_trx_addons');

		// Set flag about scroll actions are finished
		TRX_ADDONS_STORAGE['scroll_busy'] = false;
	}
	
	
	
	// Resize actions
	//==============================================
	
	// Do actions when page scrolled
	function trx_addons_resize_actions(cont) {
		if (cont===undefined) cont = jQuery('body');

		// Before plugin's resize actions
		jQuery(document).trigger('action.resize_vc_row_start', [cont]);

		// Call theme/plugins specific action (if exists)
		jQuery(document).trigger('action.resize_trx_addons', [cont]);

		// After plugin's resize actions
		jQuery(document).trigger('action.resize_vc_row_end', [cont]);
	}
	
	
	
	// Fit video frames to document width
	jQuery(document).on('action.resize_trx_addons', trx_addons_resize_video);
	function trx_addons_resize_video(e, cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('video').each(function() {
			// If item now invisible
			if (jQuery(this).addClass('trx_addons_resize').parents('div:hidden,section:hidden,article:hidden').length > 0) {
				return;
			}
			var video = jQuery(this).eq(0);
			var ratio = (video.data('ratio')!=undefined ? video.data('ratio').split(':') : [16,9]);
			ratio = ratio.length!=2 || ratio[0]==0 || ratio[1]==0 ? 16/9 : ratio[0]/ratio[1];
			var mejs_cont = video.parents('.mejs-video');
			var w_attr = video.data('width');
			var h_attr = video.data('height');
			if (!w_attr || !h_attr) {
				w_attr = video.attr('width');
				h_attr = video.attr('height');
				if (!w_attr || !h_attr) return;
				video.data({'width': w_attr, 'height': h_attr});
			}
			var percent = (''+w_attr).substr(-1)=='%';
			w_attr = parseInt(w_attr, 10);
			h_attr = parseInt(h_attr, 10);
			var w_real = Math.round(mejs_cont.length > 0 
									? Math.min(percent ? 10000 : w_attr, mejs_cont.parents('div,article').width()) 
									: Math.min(percent ? 10000 : w_attr, video.parents('div,article').width()) 
								   ),
				h_real = Math.round(percent ? w_real/ratio : w_real/w_attr*h_attr);
			if (parseInt(video.attr('data-last-width'), 10)==w_real)
				return;
			if (percent) {
				video.height(h_real);
			} else if (video.parents('.wp-video-playlist').length > 0) {
				if (mejs_cont.length === 0) {
					video.attr({'width': w_real, 'height': h_real});
				}
			} else {
				video.attr({'width': w_real, 'height': h_real}).css({'width': w_real+'px', 'height': h_real+'px'});
				if (mejs_cont.length > 0) {
					trx_addons_set_mejs_player_dimensions(video, w_real, h_real);
				}
			}
			video.attr('data-last-width', w_real);
		});
		cont.find('.video_frame iframe, iframe').each(function() {
			// If item now invisible
			if (jQuery(this).addClass('trx_addons_resize').parents('div:hidden,section:hidden,article:hidden').length > 0) {
				return;
			}
			var iframe = jQuery(this).eq(0);
			if (iframe.attr('src').indexOf('soundcloud')>0) return;
			var ratio = (iframe.data('ratio')!=undefined 
							? iframe.data('ratio').split(':') 
							: (iframe.parent().data('ratio')!=undefined 
								? iframe.parent().data('ratio').split(':') 
								: (iframe.find('[data-ratio]').length>0 
									? iframe.find('[data-ratio]').data('ratio').split(':') 
									: [16,9]
									)
								)
							);
			ratio = ratio.length!=2 || ratio[0]==0 || ratio[1]==0 ? 16/9 : ratio[0]/ratio[1];
			var w_attr = iframe.attr('width');
			var h_attr = iframe.attr('height');
			if (!w_attr || !h_attr) {
				return;
			}
			var percent = (''+w_attr).substr(-1)=='%';
			w_attr = parseInt(w_attr, 10);
			h_attr = parseInt(h_attr, 10);
			var pw = iframe.parent().width(),
				ph = iframe.parent().height(),
				w_real = pw,
				h_real = Math.round(percent ? w_real/ratio : w_real/w_attr*h_attr);
			if (iframe.parent().css('position') == 'absolute' && h_real > ph) {
				h_real = ph;
				w_real = Math.round(percent ? h_real*ratio : h_real*w_attr/h_attr)
			}
			if (parseInt(iframe.attr('data-last-width'), 10)==w_real) return;
			iframe.css({'width': w_real+'px', 'height': h_real+'px'});
			iframe.attr('data-last-width', w_real);
		});
	}
	
	
	// Set Media Elements player dimensions
	function trx_addons_set_mejs_player_dimensions(video, w, h) {
		if (mejs) {
			for (var pl in mejs.players) {
				if (mejs.players[pl].media.src == video.attr('src')) {
					if (mejs.players[pl].media.setVideoSize) {
						mejs.players[pl].media.setVideoSize(w, h);
					} else if (mejs.players[pl].media.setSize) {
						mejs.players[pl].media.setSize(w, h);
					}
					mejs.players[pl].setPlayerSize(w, h);
					mejs.players[pl].setControlsSize();
				}
			}
		}
	}
	

	// Fix columns
	jQuery(document).on('action.resize_trx_addons', trx_addons_fix_column);
	jQuery(document).on('action.scroll_trx_addons', trx_addons_fix_column);
	
	function trx_addons_fix_column(e, cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.sc_column_fixed').each(function() {
			var col = jQuery(this),
				row = col.parent();
			
			// Exit if non-standard responsive is used for this columns
			if (col.attr('class').indexOf('vc_col-lg-')!=-1 || col.attr('class').indexOf('vc_col-md-')!=-1) {
				return;

			// Unfix when sidebar is under content
			} else if (jQuery(window).width() < 768) {
				var old_style = col.data('old_style');
				if (old_style !== undefined) col.attr('style', old_style).removeAttr('data-old_style');
		
			} else {
		
				var col_height = col.outerHeight();
				var row_height = row.outerHeight();
				var row_top = row.offset().top;
				var scroll_offset = jQuery(window).scrollTop();
				var top_panel_fixed_height = trx_addons_fixed_rows_height();
	
				// If sidebar shorter then content and page scrolled below the content's top
				if (col_height < row_height && scroll_offset + top_panel_fixed_height > row_top) {
					
					var col_init = {
							'position': 'undefined',
							'top': 'auto',
							'bottom' : 'auto'
							};
					
					if (typeof TRX_ADDONS_STORAGE['scroll_offset_last'] == 'undefined') {
						TRX_ADDONS_STORAGE['col_top_last'] = row_top;
						TRX_ADDONS_STORAGE['scroll_offset_last'] = scroll_offset;
						TRX_ADDONS_STORAGE['scroll_dir_last'] = 1;
					}
					var scroll_dir = scroll_offset - TRX_ADDONS_STORAGE['scroll_offset_last'];
					if (scroll_dir == 0)
						scroll_dir = TRX_ADDONS_STORAGE['scroll_dir_last'];
					else
						scroll_dir = scroll_dir > 0 ? 1 : -1;
					
					var col_big = col_height + 30 >= jQuery(window).height() - top_panel_fixed_height,
						col_top = col.offset().top;

					if (col_top < 0) col_top = TRX_ADDONS_STORAGE['col_top_last'];


					// If column height greater then window height
					if (col_big) {
	
						// If change scrolling dir
						if (scroll_dir != TRX_ADDONS_STORAGE['scroll_dir_last'] && col.css('position') == 'fixed') {
							col_init.top = col_top - row_top;
							col_init.position = 'absolute';
	
						// If scrolling down
						} else if (scroll_dir > 0) {
							if (scroll_offset + jQuery(window).height() >= row_top + row_height + 30) {
								col_init.bottom = 0;
								col_init.position = 'absolute';
							} else if (scroll_offset + jQuery(window).height() >= (col.css('position') == 'absolute' ? col_top : row_top) + col_height + 30) {
								
								col_init.bottom = 30;
								col_init.position = 'fixed';
							}
					
						// If scrolling up
						} else {
							if (scroll_offset + top_panel_fixed_height <= col_top) {
								col_init.top = top_panel_fixed_height;
								col_init.position = 'fixed';
							}
						}
					
					// If column height less then window height
					} else {
						if (scroll_offset + top_panel_fixed_height >= row_top + row_height - col_height) {
							col_init.bottom = 0;
							col_init.position = 'absolute';
						} else {
							col_init.top = top_panel_fixed_height;
							col_init.position = 'fixed';
						}
					}
					
					if (col_init.position != 'undefined') {
						// Insert placeholder after this column
						var style = col.attr('style');
						if (!style) style = '';
						if (!col.prev().hasClass('sc_column_fixed_placeholder')) {
							col.css(col_init);
							TRX_ADDONS_STORAGE['scroll_dir_last'] = 0;
							col.before('<div class="sc_column_fixed_placeholder '+col.attr('class').replace('sc_column_fixed', '')+'"'
									   		+ (col.data('col') ? ' data-col="' + col.data('col') + '"' : '')
									   + '></div>');
						}
						// Detect horizontal position when resize
						col_init.left = col_init.position == 'fixed' ? col.prev().offset().left : col.prev().position().left;
						col_init.width = col.prev().width();
						// Set position
						if (col.css('position') != col_init.position 
							|| TRX_ADDONS_STORAGE['scroll_dir_last'] != scroll_dir
							|| col.width() != col_init.width) {
							if (col.data('old_style') === undefined) {
								col.attr('data-old_style', style);
							}
							col.css(col_init);
						}
					}

					TRX_ADDONS_STORAGE['col_top_last'] = col_top;
					TRX_ADDONS_STORAGE['scroll_offset_last'] = scroll_offset;
					TRX_ADDONS_STORAGE['scroll_dir_last'] = scroll_dir;
	
				} else {
	
					// Unfix when page scrolling to top
					var old_style = col.data('old_style');
					if (old_style !== undefined) {
						col.attr('style', old_style).removeAttr('data-old_style');
						if (col.prev().hasClass('sc_column_fixed_placeholder'))
							col.prev().remove();
					}

				}
			}
		});
	}

});