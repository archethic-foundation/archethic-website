/* global jQuery:false */
/* global HOVEREX_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";

	var theme_init_counter = 0;
	
	hoverex_init_actions();
	
	// Theme init actions
	function hoverex_init_actions() {

		if (HOVEREX_STORAGE['vc_edit_mode'] && jQuery('.vc_empty-placeholder').length==0 && theme_init_counter++ < 30) {
			setTimeout(hoverex_init_actions, 200);
			return;
		}

		// Check fullheight elements
		jQuery(document).on('action.init_hidden_elements', hoverex_stretch_height);
		jQuery(document).on('action.sc_layouts_row_fixed_off', hoverex_stretch_height);
		jQuery(document).on('action.sc_layouts_row_fixed_on', hoverex_stretch_height);
	
		// Add resize on VC action vc-full-width-row
		// But we emulate 'action.resize_vc_row_start' and 'action.resize_vc_row_end'
		// to correct resize sliders and video inside 'boxed' pages
		var vc_resize = false;
		jQuery(document).on('action.resize_vc_row_start', function(e, el) {
			vc_resize = true;
			hoverex_resize_actions(el);
		});
	
		// Resize handlers
		jQuery(window).resize(function() {
			if (!vc_resize) {
				hoverex_resize_actions();
			}
		});
		
		// Scroll handlers
		HOVEREX_STORAGE['scroll_busy'] = true;
		jQuery(window).scroll(function() {
			if (window.requestAnimationFrame) {
				if (!HOVEREX_STORAGE['scroll_busy']){
					window.requestAnimationFrame(hoverex_scroll_actions);
					HOVEREX_STORAGE['scroll_busy'] = true;
				}
			} else {
				hoverex_scroll_actions();
			}
		});
		
		// First call to init core actions
		hoverex_ready_actions();
		hoverex_resize_actions();
		hoverex_scroll_actions();
		
		// Wait for logo load
		if (jQuery('body').hasClass('menu_style_side') && !hoverex_check_images_complete(jQuery('.menu_side_wrap .sc_layouts_logo'))) {
			setTimeout(function() {
				hoverex_stretch_sidemenu();
			}, 500);
		}
	}
	
	
	
	// Theme first load actions
	//==============================================
	function hoverex_ready_actions() {
	
		// Add scheme class and js support
		//------------------------------------
		document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'js');
		if (document.documentElement.className.indexOf(HOVEREX_STORAGE['site_scheme'])==-1)
			document.documentElement.className += ' ' + HOVEREX_STORAGE['site_scheme'];

		// Init background video
		//------------------------------------
		// Use Bideo to play local video
		if (HOVEREX_STORAGE['background_video'] && jQuery('.top_panel.with_bg_video').length > 0 && window.Bideo) {
			// Waiting 10ms after mejs init
			setTimeout(function() {
				jQuery('.top_panel.with_bg_video').prepend('<video id="background_video" loop muted></video>');
				var bv = new Bideo();
				bv.init({
					// Video element
					videoEl: document.querySelector('#background_video'),
					
					// Container element
					container: document.querySelector('.top_panel'),
					
					// Resize
					resize: true,
					
					// autoplay: false,
					
					isMobile: window.matchMedia('(max-width: 768px)').matches,
					
					playButton: document.querySelector('#background_video_play'),
					pauseButton: document.querySelector('#background_video_pause'),
					
					// Array of objects containing the src and type
					// of different video formats to add
					// For example:
					//	src: [
					//			{	src: 'night.mp4', type: 'video/mp4' }
					//			{	src: 'night.webm', type: 'video/webm;codecs="vp8, vorbis"' }
					//		]
					src: [
						{
							src: HOVEREX_STORAGE['background_video'],
							type: 'video/'+hoverex_get_file_ext(HOVEREX_STORAGE['background_video'])
						}
					],
					
					// What to do once video loads (initial frame)
					onLoad: function () {
						//document.querySelector('#background_video_cover').style.display = 'none';
					}
				});
			}, 10);
		
		// Use Tubular to play video from Youtube
		} else if (jQuery.fn.tubular) {
			jQuery('div#background_video').each(function() {
				var youtube_code = jQuery(this).data('youtube-code');
				if (youtube_code) {
					jQuery(this).tubular({videoId: youtube_code});
					jQuery('#tubular-player').appendTo(jQuery(this)).show();
					jQuery('#tubular-container,#tubular-shield').remove();
				}
			});
		}
	
		// Tabs
		//------------------------------------
		if (jQuery('.hoverex_tabs:not(.inited)').length > 0 && jQuery.ui && jQuery.ui.tabs) {
			jQuery('.hoverex_tabs:not(.inited)').each(function () {
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
				// Init tabs
				jQuery(this).addClass('inited').tabs({
					active: init,
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
		// AJAX loader for the tabs
		jQuery('.hoverex_tabs_ajax').on( "tabsbeforeactivate", function( event, ui ) {
			if (ui.newPanel.data('need-content')) hoverex_tabs_ajax_content_loader(ui.newPanel, 1, ui.oldPanel);
		});
		// AJAX loader for the pages in the tabs
		jQuery('.hoverex_tabs_ajax').on( "click", '.nav-links a', function(e) {
			var panel = jQuery(this).parents('.hoverex_tabs_content');
			var page = 1;
			var href = jQuery(this).attr('href');
			var pos = -1;
			if ((pos = href.lastIndexOf('/page/')) != -1 ) {
				page = Number(href.substr(pos+6).replace("/", ""));
				if (!isNaN(page)) page = Math.max(1, page);
			}
			hoverex_tabs_ajax_content_loader(panel, page);
			e.preventDefault();
			return false;
		});
	
		// Menu
		//----------------------------------------------
	
		// Open/Close side menu
		jQuery('.menu_side_button').on('click', function(e){
			jQuery(this).parent().toggleClass('opened');
			e.preventDefault();
			return false;
		});

		// Add images to the menu items with classes image-xxx
		jQuery('.sc_layouts_menu li[class*="image-"]').each(function() {
			var classes = jQuery(this).attr('class').split(' ');
			var icon = '';
			for (var i=0; i < classes.length; i++) {
				if (classes[i].indexOf('image-') >= 0) {
					icon = classes[i].replace('image-', '');
					break;
				}
			}
			if (icon) jQuery(this).find('>a').css('background-image', 'url('+HOVEREX_STORAGE['theme_url']+'/trx_addons/css/icons.png/'+icon+'.png');
		});
	
		// Add arrows to the mobile menu
		jQuery('.menu_mobile .menu-item-has-children > a,.sc_layouts_menu_dir_vertical .menu-item-has-children > a').append('<span class="open_child_menu"></span>');
	
		// Open/Close mobile menu
		jQuery('.sc_layouts_menu_mobile_button > a,.menu_mobile_button,.menu_mobile_description').on('click', function(e) {
			if (jQuery(this).parent().hasClass('sc_layouts_menu_mobile_button_burger') && jQuery(this).next().hasClass('sc_layouts_menu_popup')) return;
			jQuery('.menu_mobile_overlay').fadeIn();
			jQuery('.menu_mobile').addClass('opened');
			jQuery(document).trigger('action.stop_wheel_handlers');
			e.preventDefault();
			return false;
		});
		jQuery(document).on('keypress', function(e) {
			if (e.keyCode == 27) {
				if (jQuery('.menu_mobile.opened').length == 1) {
					jQuery('.menu_mobile_overlay').fadeOut();
					jQuery('.menu_mobile').removeClass('opened');
					jQuery(document).trigger('action.start_wheel_handlers');
					e.preventDefault();
					return false;
				}
			}
		});;
		jQuery('.menu_mobile_close, .menu_mobile_overlay').on('click', function(e){
			jQuery('.menu_mobile_overlay').fadeOut();
			jQuery('.menu_mobile').removeClass('opened');
			jQuery(document).trigger('action.start_wheel_handlers');
			e.preventDefault();
			return false;
		});
	
		// Open/Close mobile submenu
		jQuery('.menu_mobile,.sc_layouts_menu_dir_vertical').on('click', 'li a, li a .open_child_menu', function(e) {
			var $a = jQuery(this).hasClass('open_child_menu') ? jQuery(this).parent() : jQuery(this);
			if ($a.parent().hasClass('menu-item-has-children')) {
				if ($a.attr('href')=='#' || jQuery(this).hasClass('open_child_menu')) {
					if ($a.siblings('ul:visible').length > 0)
						$a.siblings('ul').slideUp().parent().removeClass('opened');
					else {
						jQuery(this).parents('li').siblings('li').find('ul:visible').slideUp().parent().removeClass('opened');
						$a.siblings('ul').slideDown(function() {
							// Init layouts
							if (!jQuery(this).hasClass('layouts_inited') && jQuery(this).parents('.menu_mobile').length > 0) {
								jQuery(this).addClass('layouts_inited');
								jQuery(document).trigger('action.init_hidden_elements', [jQuery(this)]);
							}
						}).parent().addClass('opened');
					}
				}
			}
			if (!jQuery(this).hasClass('open_child_menu') && jQuery(this).parents('.menu_mobile').length > 0 && hoverex_is_local_link($a.attr('href')))
				jQuery('.menu_mobile_close').trigger('click');
			if (jQuery(this).hasClass('open_child_menu') || $a.attr('href')=='#') {
				e.preventDefault();
				return false;
			}
		});
	
		if (!HOVEREX_STORAGE['trx_addons_exist'] || jQuery('.top_panel.top_panel_default .sc_layouts_menu_default').length > 0) {
			// Init superfish menus
			hoverex_init_sfmenu('.sc_layouts_menu:not(.inited) > ul:not(.inited)');
			// Show menu		
			jQuery('.sc_layouts_menu:not(.inited)').each(function() {
				if (jQuery(this).find('>ul.inited').length == 1) jQuery(this).addClass('inited');
			});
			// Generate 'scroll' event after the menu is showed
			jQuery(window).trigger('scroll');
		}

		
		// Forms
		//----------------------------------------------
	
		// Comment form
		jQuery("form#commentform").submit(function(e) {
			var rez = hoverex_comments_validate(jQuery(this));
			if (!rez)
				e.preventDefault();
			return rez;
		});
	
		jQuery("form").on('keypress', '.error_field', function() {
			if (jQuery(this).val() != '')
				jQuery(this).removeClass('error_field');
		});
		
		// CF7 checkboxes and radio - add class to correct check/uncheck pseudoelement when input at right side of the label
		jQuery('.wpcf7-checkbox > .wpcf7-list-item > .wpcf7-list-item-label,.wpcf7-radio > .wpcf7-list-item > .wpcf7-list-item-label').each(function() {
			if (jQuery(this).next('input[type="checkbox"],input[type="radio"]').length > 0)
				jQuery(this).addClass('wpcf7-list-item-right');
		});
		jQuery('.wpcf7-checkbox > .wpcf7-list-item > .wpcf7-list-item-label,.wpcf7-radio > .wpcf7-list-item > .wpcf7-list-item-label').on('click', function() {
			var chk = jQuery(this).siblings('input[type="checkbox"],input[type="radio"]');
			if (chk.attr('type') == 'radio') {
				jQuery(this).parents('.wpcf7-radio')
					.find('.wpcf7-list-item-label').removeClass('wpcf7-list-item-checked')
					.find('input[type="radio"]').each(function(){
						this.checked = false;
					});
			}
			if (chk.length > 0) {
				chk.get(0).checked = chk.get(0).checked ? false : true;
				jQuery(this).toggleClass('wpcf7-list-item-checked', chk.get(0).checked);
			}
		});
	
	
		// Blocks with stretch width
		//----------------------------------------------
		// Action to prepare stretch blocks in the third-party plugins
		jQuery(document).trigger('action.prepare_stretch_width');
		// Wrap stretch blocks
		jQuery('.trx-stretch-width').wrap('<div class="trx-stretch-width-wrap"></div>');
		jQuery('.trx-stretch-width').after('<div class="trx-stretch-width-original"></div>');
		hoverex_stretch_width();
			
	
		// Pagination
		//------------------------------------
	
		// Load more
		jQuery('.nav-links-more a').on('click', function(e) {
			if (HOVEREX_STORAGE['load_more_link_busy']) return;
			HOVEREX_STORAGE['load_more_link_busy'] = true;
			var more = jQuery(this);
			var page = Number(more.data('page'));
			var max_page = Number(more.data('max-page'));
			if (page >= max_page) {
				more.parent().hide();
				return;
			}
			more.parent().addClass('loading');
			var panel = more.parents('.hoverex_tabs_content');
			if (panel.length == 0) {															// Load simple page content
				jQuery.get(location.href, {
					paged: page+1
				}).done(function(response) {
					// Get inline styles and add to the page styles
					var selector = 'hoverex-inline-styles-inline-css';
					var p1 = response.indexOf(selector);
					if (p1 < 0) {
						selector = 'trx_addons-inline-styles-inline-css';
						p1 = response.indexOf(selector);
					}
					if (p1 > 0) {
						p1 = response.indexOf('>', p1) + 1;
						var p2 = response.indexOf('</style>', p1);
						var inline_css_add = response.substring(p1, p2);
						var inline_css = jQuery('#'+selector);
						if (inline_css.length == 0)
							jQuery('body').append('<style id="'+selector+'" type="text/css">' + inline_css_add + '</style>');
						else
							inline_css.append(inline_css_add);
					}
					// Get new posts and append to the .posts_container
					hoverex_loadmore_add_items(jQuery('.content .posts_container').eq(0),
											   jQuery(response).find('.content .posts_container > article,'
											   						+'.content .posts_container > div[class*="column-"],'
																	+'.content .posts_container > .masonry_item')
												);
				});
			} else {																			// Load tab's panel content
				jQuery.post(HOVEREX_STORAGE['ajax_url'], {
					nonce: HOVEREX_STORAGE['ajax_nonce'],
					action: 'hoverex_ajax_get_posts',
					blog_template: panel.data('blog-template'),
					blog_style: panel.data('blog-style'),
					posts_per_page: panel.data('posts-per-page'),
					cat: panel.data('cat'),
					parent_cat: panel.data('parent-cat'),
					post_type: panel.data('post-type'),
					taxonomy: panel.data('taxonomy'),
					page: page+1
				}).done(function(response) {
					var rez = {};
					try {
						rez = JSON.parse(response);
					} catch (e) {
						rez = { error: HOVEREX_STORAGE['strings']['ajax_error'] };
						console.log(response);
					}
					if (rez.error !== '') {
						panel.html('<div class="hoverex_error">'+rez.error+'</div>');
					} else {
						hoverex_loadmore_add_items(panel.find('.posts_container'), jQuery(rez.data).find('article'));
					}
				});
			}
			// Append items to the container
			function hoverex_loadmore_add_items(container, items) {
				if (container.length > 0 && items.length > 0) {
					container.append(items);
					if (container.hasClass('portfolio_wrap') || container.hasClass('masonry_wrap')) {
						container.masonry( 'appended', items ).masonry();
						if (container.hasClass('gallery_wrap')) {
							HOVEREX_STORAGE['GalleryFx'][container.attr('id')].appendItems();
						}
					}
					more.data('page', page+1).parent().removeClass('loading');
					// Remove TOC if exists (rebuild on init_hidden_elements)
					jQuery('#toc_menu').remove();
					// Trigger actions to init new elements
					HOVEREX_STORAGE['init_all_mediaelements'] = true;
					jQuery(document).trigger('action.init_hidden_elements', [container.parent()]);
				}
				if (page+1 >= max_page)
					more.parent().hide();
				else
					HOVEREX_STORAGE['load_more_link_busy'] = false;
				// Fire 'window.scroll' after clearing busy state
				jQuery(window).trigger('scroll');

				// Fire 'window.resize'
				jQuery( window ).trigger( 'resize' );
			}
			e.preventDefault();
			return false;
		});
	
		// Infinite scroll
		jQuery(document).on('action.scroll_hoverex', function(e) {
			if (HOVEREX_STORAGE['load_more_link_busy']) return;
			var container = jQuery('.content > .posts_container').eq(0);
			var inf = jQuery('.nav-links-infinite');
			if (inf.length == 0) return;
			if (container.offset().top + container.height() < jQuery(window).scrollTop() + jQuery(window).height()*1.5)
				inf.find('a').trigger('click');
		});


        // Checkbox with "I agree..."
		if (jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited)').length > 0) {
			jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited)')
				.addClass('inited')
				.on('change', function(e) {
					if (jQuery(this).get(0).checked)
						jQuery(this).parents('form').find('button,input[type="submit"]').removeAttr('disabled');
					else
						jQuery(this).parents('form').find('button,input[type="submit"]').attr('disabled', 'disabled');
				}).trigger('change');
		}

		// Other settings
		//------------------------------------
	
		jQuery(document).trigger('action.ready_hoverex');
	
		// Add theme-specific handlers
		jQuery(document).on('action.init_hidden_elements', hoverex_init_post_formats);
		jQuery(document).on('action.init_hidden_elements', hoverex_add_toc_to_sidemenu);
	
		// Init hidden elements (if exists)
		jQuery(document).trigger('action.init_hidden_elements', [jQuery('body').eq(0)]);
		
	} //end ready
	
	
	
	
	// Scroll actions
	//==============================================
	
	// Do actions when page scrolled
	function hoverex_scroll_actions() {

		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.scroll_hoverex');
		
		// Fix/unfix sidebar
		hoverex_fix_sidebar();

		// Shift top and footer panels when header position is 'Under content'
		hoverex_shift_under_panels();
		
		// Set flag about scroll actions are finished
		HOVEREX_STORAGE['scroll_busy'] = false;
	}

	// Shift top and footer panels when header position is 'Under content'
	function hoverex_shift_under_panels() {
		if (jQuery('body').hasClass('header_position_under') && !hoverex_browser_is_mobile()) {
			
			var header = jQuery('.top_panel');
			var footer = jQuery('.footer_wrap');
			var content = jQuery('.page_content_wrap');

			// Disable 'under' behavior on small screen
			if (jQuery('body').hasClass('mobile_layout')) {	//jQuery(window).width() < 768) {
				if (header.css('position')=='fixed') {
					// Header
					header.css({
						'position': 'relative',
						'left': 'auto',
						'top': 'auto',
						'width': 'auto',
						'transform': 'none',
						'zIndex': 3
					});
					header.find('.top_panel_mask').hide();
					// Content
					content.css({
						'marginTop': 0,
						'marginBottom': 0,
						'zIndex': 2
					});
					// Footer
					footer.css({
						'position': 'relative',
						'left': 'auto',
						'bottom': 'auto',
						'width': 'auto',
						'transform': 'none',
						'zIndex': 1
					});
					footer.find('.top_panel_mask').hide();
				}
				return;
			}
			var delta = 50;
			var scroll_offset = jQuery(window).scrollTop();
			var header_height = header.height();
			var shift = !(/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) || header.find('.slider_engine_revo').length == 0
							? 0	//1.2		// Parallax speed (if 0 - disable parallax)
							: 0;
			var adminbar = jQuery('#wpadminbar');
			var adminbar_height = adminbar.length == 0 ? 0 : adminbar.height();
			var mask = header.find('.top_panel_mask');
			var css = {};
			if (mask.length==0) {
				header.append('<div class="top_panel_mask"></div>');
				mask = header.find('.top_panel_mask');
			}
			if (header.css('position')!=='fixed') {
				content.css({
					'zIndex': 5,
					'marginTop': header_height+'px'
				});
				header.css({
					'position': 'fixed',
					'left': 0,
					'top': adminbar_height + 'px',
					'width': '100%',
					'zIndex': 3
				});
			} else {
				content.css('marginTop', header_height+'px');
			}
			if (scroll_offset > 0) {
				var offset = scroll_offset;	// - adminbar_height;
				if (offset <= header_height) {
					var mask_opacity = Math.max(0, Math.min(0.8, (offset-delta)/header_height));
					// Don't shift header with Revolution slider in Chrome
					if (shift) header.css('transform', 'translate3d(0px, '+(-Math.round(offset/shift))+'px, 0px)');
					mask.css({
						'opacity': mask_opacity,
						'display': offset==0 ? 'none' : 'block'
					});
				} else {
					if (shift) header.css('transform', 'translate3d(0px, '+(-Math.round(offset/shift))+'px, 0px)');
				}
			} else {
				if (shift) header.css('transform', 'none');
				if (mask.css('display')!='none') {
					mask.css({
						'opacity': 0,
						'display': 'none'
					});
				}
			}
			var footer_height = Math.min(footer.height(), jQuery(window).height());
			var footer_visible = (scroll_offset + jQuery(window).height()) - (header.outerHeight() + jQuery('.page_content_wrap').outerHeight());
			if (footer.css('position')!=='fixed') {
				content.css({
					'marginBottom': footer_height+'px'
				});
				footer.css({
					'position': 'fixed',
					'left': 0,
					'bottom': 0,
					'width': '100%',
					'zIndex': 2
				});
			} else {
				content.css('marginBottom', footer_height+'px');
			}
			if (footer_visible > 0) {
				if (footer.css('zIndex')==2) footer.css('zIndex', 4);
				mask = footer.find('.top_panel_mask');
				if (mask.length==0) {
					footer.append('<div class="top_panel_mask"></div>');
					mask = footer.find('.top_panel_mask');
				}
				if (footer_visible <= footer_height) {
					var mask_opacity = Math.max(0, Math.min(0.8, (footer_height - footer_visible)/footer_height));
					// Don't shift header with Revolution slider in Chrome
					if (shift) footer.css('transform', 'translate3d(0px, '+Math.round((footer_height - footer_visible)/shift)+'px, 0px)');
					mask.css({
						'opacity': mask_opacity,
						'display': footer_height - footer_visible <= 0 ? 'none' : 'block'
					});
				} else {
					if (shift) footer.css('transform', 'none');
					if (mask.css('display')!='none') {
						mask.css({
							'opacity': 0,
							'display': 'none'
						});
					}
				}
			} else {
				if (footer.css('zIndex')==4) footer.css('zIndex', 2);
			}
		}
	}
	
	
	// Resize actions
	//==============================================
	
	// Do actions when page scrolled
	function hoverex_resize_actions(cont) {
		hoverex_check_layout();
		hoverex_fix_sidebar();
		hoverex_fix_footer();
		hoverex_stretch_width(cont);
		hoverex_stretch_height(null, cont);
		hoverex_stretch_bg_video();
		hoverex_vc_row_fullwidth_to_boxed(cont);
		hoverex_stretch_sidemenu();
		hoverex_resize_video(cont);
		hoverex_shift_under_panels();
	
		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.resize_hoverex', [cont]);
	}
	
	// Stretch sidemenu (if present)
	function hoverex_stretch_sidemenu() {
		var toc_items = jQuery('.menu_side_wrap .toc_menu_item');
		if (toc_items.length == 0) return;
		var toc_items_height = jQuery(window).height() 
								- hoverex_fixed_rows_height(true, false) 
								- jQuery('.menu_side_wrap .sc_layouts_logo').outerHeight() 
								- toc_items.length;
		var th = Math.floor(toc_items_height / toc_items.length);
		var th_add = toc_items_height - th*toc_items.length;
		if (HOVEREX_STORAGE['menu_side_stretch'] && toc_items.length >= 5 && th >= 30) {
			toc_items.find(".toc_menu_description,.toc_menu_icon").css({
				'height': th+'px',
				'lineHeight': th+'px'
			});
			toc_items.eq(0).find(".toc_menu_description,.toc_menu_icon").css({
				'height': (th+th_add)+'px',
				'lineHeight': (th+th_add)+'px'
			});
		}
		//jQuery('.menu_side_wrap #toc_menu').height(toc_items_height + toc_items.length - toc_items.eq(0).height());
	}

	// Scroll sidemenu (if present)
	jQuery(document).on('action.toc_menu_item_active', function() {
		var toc_menu = jQuery('.menu_side_wrap #toc_menu');
		if (toc_menu.length == 0) return;
		var toc_items = toc_menu.find('.toc_menu_item');
		if (toc_items.length == 0) return;
		var th = toc_items.eq(0).height(),
			toc_menu_pos = parseFloat(toc_menu.css('top')),
			toc_items_height = toc_items.length * th,
			menu_side_height = jQuery(window).height() 
								- hoverex_fixed_rows_height(true, false) 
								- jQuery('.menu_side_wrap .sc_layouts_logo').outerHeight()
								- jQuery('.menu_side_wrap .sc_layouts_logo + .toc_menu_item').outerHeight();
		if (toc_items_height > menu_side_height) {
			var toc_item_active = jQuery('.menu_side_wrap .toc_menu_item_active').eq(0);
			if (toc_item_active.length == 1) {
				var toc_item_active_pos = (toc_item_active.index() + 1) * th;
				if (toc_menu_pos + toc_item_active_pos > menu_side_height - th)
					toc_menu.css('top', Math.max(-toc_item_active_pos + 3*th, menu_side_height - toc_items_height));
				else if (toc_menu_pos < 0 && toc_item_active_pos < -toc_menu_pos + 2*th)
					toc_menu.css('top', Math.min(-toc_item_active_pos + 3*th, 0));
			}
		} else if (toc_menu_pos < 0) {
			toc_menu.css('top', 0);
		}
	});
	
	// Check for mobile layout
	function hoverex_check_layout() {
		var resize = true;
		if (jQuery('body').hasClass('no_layout')) {
			jQuery('body').removeClass('no_layout');
			resize = false;
		}
		var w = window.innerWidth;
		if (w == undefined) 
			w = jQuery(window).width()+(jQuery(window).height() < jQuery(document).height() || jQuery(window).scrollTop() > 0 ? 16 : 0);
		if (HOVEREX_STORAGE['mobile_layout_width'] >= w) {
			if (!jQuery('body').hasClass('mobile_layout')) {
				jQuery('body').removeClass('desktop_layout').addClass('mobile_layout');
				if (resize) jQuery(window).trigger('resize');
			}
		} else {
			if (!jQuery('body').hasClass('desktop_layout')) {
				jQuery('body').removeClass('mobile_layout').addClass('desktop_layout');
				jQuery('.menu_mobile').removeClass('opened');
				jQuery('.menu_mobile_overlay').hide();
				if (resize) jQuery(window).trigger('resize');
			}
		}
		if (HOVEREX_STORAGE['mobile_device'] || hoverex_browser_is_mobile()) 
			jQuery('body').addClass('mobile_device');
	}
	
	// Stretch area to full window width
	function hoverex_stretch_width(cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.trx-stretch-width').each(function() {
			var $el = jQuery(this);
			var $el_cont = $el.parents('.page_wrap');
			var $el_cont_offset = 0;
			if ($el_cont.length == 0) 
				$el_cont = jQuery(window);
			else
				$el_cont_offset = $el_cont.offset().left;
			var $el_full = $el.next('.trx-stretch-width-original');
			var el_margin_left = parseInt( $el.css( 'margin-left' ), 10 );
			var el_margin_right = parseInt( $el.css( 'margin-right' ), 10 );
			var offset = $el_cont_offset - $el_full.offset().left - el_margin_left;
			var width = $el_cont.width();
			if (!$el.hasClass('inited')) {
				$el.addClass('inited invisible');
				$el.css({
					'position': 'relative',
					'box-sizing': 'border-box'
				});
			}
			$el.css({
				'left': offset,
				'width': $el_cont.width()
			});
			if ( !$el.hasClass('trx-stretch-content') ) {
				var padding = Math.max(0, -1*offset);
				var paddingRight = Math.max(0, width - padding - $el_full.width() + el_margin_left + el_margin_right);
				$el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
			}
			$el.removeClass('invisible');
		});
	}
	
	// Stretch area to the full window height
	function hoverex_stretch_height(e, cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.hoverex-full-height').each(function () {
			var fullheight_item = jQuery(this);
			// If item now invisible
			if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) {
				return;
			}
			var fullheight_row = jQuery(this).parents('.vc_row-o-full-height');
			if (fullheight_row.length > 0)
				fullheight_item.height(fullheight_row.height());
			else {
				var fh = hoverex_fixed_rows_height();
				var wh = jQuery(window).width() >= 960
							? jQuery(window).height() - fh
							: 'auto';
				if (wh > 0) {
					if (fullheight_item.data('display') != fullheight_item.css('display'))
						fullheight_item.css('display', fullheight_item.data('display'));
					fullheight_item.css('height', wh);
				} else if (wh=='auto' && fullheight_item.css('height')!='auto') {
					if (fullheight_item.data('display')==undefined)
						fullheight_item.attr('data-display', fullheight_item.css('display'));
					fullheight_item.css({'height': wh, 'display': 'block'});
				}
			}
		});
	}
	// Fit video frames to document width
	function hoverex_resize_video(cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('video').each(function() {
			// If item now invisible
			if (jQuery(this).hasClass('trx_addons_resize') || jQuery(this).addClass('hoverex_resize').parents('div:hidden,section:hidden,article:hidden').length > 0) {
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
					hoverex_set_mejs_player_dimensions(video, w_real, h_real);
				}
			}
			video.attr('data-last-width', w_real);
		});
		cont.find('.video_frame iframe, iframe').each(function() {
			// If item now invisible
			if (jQuery(this).hasClass('trx_addons_resize') || jQuery(this).addClass('hoverex_resize').parents('div:hidden,section:hidden,article:hidden').length > 0) {
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
	function hoverex_set_mejs_player_dimensions(video, w, h) {
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
	
	// Stretch background video
	function hoverex_stretch_bg_video() {
		var video_wrap = jQuery('div#background_video,.tourmaster-background-video');
		if (video_wrap.length == 0) return;
		var cont = video_wrap.hasClass('tourmaster-background-video') ? video_wrap.parent() : video_wrap,
			w = cont.width(),
			h = cont.height(),
			video = video_wrap.find('>iframe,>video');
		if (w/h < 16/9)
			w = h/9*16;
		else
			h = w/16*9;
		video
			.attr({'width': w, 'height': h})
			.css({'width': w, 'height': h});
	}
		
	// Recalculate width of the vc_row[data-vc-full-width="true"] when content boxed or menu_style=='left|right'
	function hoverex_vc_row_fullwidth_to_boxed(cont) {
		if (jQuery('body').hasClass('body_style_boxed') || jQuery('body').hasClass('menu_style_side')) {
			if (cont === undefined || !cont.hasClass('.vc_row') || !cont.data('vc-full-width'))
				cont = jQuery('.vc_row[data-vc-full-width="true"]');
			var width_content = jQuery('.page_wrap').width();
			var width_content_wrap = jQuery('.page_content_wrap .content_wrap').width();
			var indent = ( width_content - width_content_wrap ) / 2;
			var rtl = jQuery('html').attr('dir') == 'rtl';
			cont.each( function() {
				var mrg = parseInt(jQuery(this).css('marginLeft'));
				var stretch_content = jQuery(this).attr('data-vc-stretch-content');
				var in_content = jQuery(this).parents('.content_wrap').length > 0;
				jQuery(this).css({
					'width': width_content,
					'left': rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
					'right': !rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
					'padding-left': stretch_content ? 0 : indent + mrg,
					'padding-right': stretch_content ? 0 : indent + mrg
				});
			});
		}
	}
	
	
	// Fix/unfix footer
	function hoverex_fix_footer() {
		if (jQuery('body').hasClass('header_position_under') && !hoverex_browser_is_mobile()) {
			var ft = jQuery('.footer_wrap');
			if (ft.length > 0) {
				var ft_height = ft.outerHeight(false),
					pc = jQuery('.page_content_wrap'),
					pc_offset = pc.offset().top,
					pc_height = pc.height();
				if (pc_offset + pc_height + ft_height < jQuery(window).height()) {
					if (ft.css('position')!='absolute') {
						ft.css({
							'position': 'absolute',
							'left': 0,
							'bottom': 0,
							'width' :'100%'
						});
					}
				} else {
					if (ft.css('position')!='relative') {
						ft.css({
							'position': 'relative',
							'left': 'auto',
							'bottom': 'auto'
						});
					}
				}
			}
		}
	}
	
	
	// Fix/unfix sidebar
	function hoverex_fix_sidebar() {
		var sb = jQuery('.sidebar');
		var content = sb.siblings('.content');
		if (sb.length > 0) {
	
			// Unfix when sidebar is under content
			if (content.css('float') == 'none') {

				var old_style = sb.data('old_style');
				if (old_style !== undefined) sb.attr('style', old_style).removeAttr('data-old_style');
	
			} else {
	
				var sb_height = sb.outerHeight();
				var content_height = content.outerHeight();
				var content_top = content.offset().top;
				var scroll_offset = jQuery(window).scrollTop();
				
				var top_panel_fixed_height = hoverex_fixed_rows_height();
				
				// If sidebar shorter then content and page scrolled below the content's top
				if (sb_height < content_height && scroll_offset + top_panel_fixed_height > content_top) {
					
					var sb_init = {
							'position': 'undefined',
							'float': 'none',
							'top': 'auto',
							'bottom' : 'auto'
							};
					
					if (typeof HOVEREX_STORAGE['scroll_offset_last'] == 'undefined') {
						HOVEREX_STORAGE['sb_top_last'] = content_top;
						HOVEREX_STORAGE['scroll_offset_last'] = scroll_offset;
						HOVEREX_STORAGE['scroll_dir_last'] = 1;
					}
					var scroll_dir = scroll_offset - HOVEREX_STORAGE['scroll_offset_last'];
					if (scroll_dir == 0)
						scroll_dir = HOVEREX_STORAGE['scroll_dir_last'];
					else
						scroll_dir = scroll_dir > 0 ? 1 : -1;
					
					var sb_big = sb_height + 30 >= jQuery(window).height() - top_panel_fixed_height,
						sb_top = sb.offset().top;
						
					if (sb_top < 0) sb_top = HOVEREX_STORAGE['sb_top_last'];

					// If sidebar height greater then window height
					if (sb_big) {
	
						// If change scrolling dir
						if (scroll_dir != HOVEREX_STORAGE['scroll_dir_last'] && sb.css('position') == 'fixed') {
							sb_init.top = sb_top - content_top;
							sb_init.position = 'absolute';
	
						// If scrolling down
						} else if (scroll_dir > 0) {
							if (scroll_offset + jQuery(window).height() >= content_top + content_height + 30) {
								sb_init.bottom = 0;
								sb_init.position = 'absolute';
							} else if (scroll_offset + jQuery(window).height() >= (sb.css('position') == 'absolute' ? sb_top : content_top) + sb_height + 30) {
								
								sb_init.bottom = 30;
								sb_init.position = 'fixed';
							}
						
						// If scrolling up
						} else {
							if (scroll_offset + top_panel_fixed_height <= sb_top) {
								sb_init.top = top_panel_fixed_height;
								sb_init.position = 'fixed';
							}
						}
					
					// If sidebar height less then window height
					} else {
						if (scroll_offset + top_panel_fixed_height >= content_top + content_height - sb_height) {
							sb_init.bottom = 0;
							sb_init.position = 'absolute';
						} else {
							sb_init.top = top_panel_fixed_height;
							sb_init.position = 'fixed';
						}
					}
					
					if (sb_init.position != 'undefined') {
						// Detect horizontal position when resize
						var pos = 0;
						if (sb_init.position == 'fixed' || (!jQuery('body').hasClass('body_style_wide') && !jQuery('body').hasClass('body_style_boxed'))) {
							var sb_parent = sb.parent();
							pos = sb_parent.position();
							pos = pos.left + Math.max(0, parseInt(sb_parent.css('paddingLeft'), 10)) 
											+ Math.max(0, parseInt(sb_parent.css('marginLeft'), 10))
											+ (sb_init.position == 'fixed' && jQuery('body').hasClass('menu_style_right') && sb.hasClass('right')
												? Math.max(0, parseInt(jQuery('body').css('marginRight'), 10))
												: (sb_init.position == 'fixed' && jQuery('body').hasClass('menu_style_left') && sb.hasClass('left')
													? Math.max(0, parseInt(jQuery('body').css('marginLeft'), 10))
													: 0));
						}
						if (sb.hasClass('right'))
							sb_init.right = sb_init.position == 'fixed' || jQuery('body').hasClass('body_style_fullwide') ? pos : 0;
						else
							sb_init.left = sb_init.position == 'fixed' || jQuery('body').hasClass('body_style_fullwide') ? pos : 0;
						
						// Set position
						if (sb.css('position') != sb_init.position || HOVEREX_STORAGE['scroll_dir_last'] != scroll_dir) {
							if (sb.data('old_style') === undefined) {
								var style = sb.attr('style');
								if (!style) style = '';
								sb.attr('data-old_style', style);
							}
							sb.css(sb_init);
						}
					}

					HOVEREX_STORAGE['sb_top_last'] = sb_top;
					HOVEREX_STORAGE['scroll_offset_last'] = scroll_offset;
					HOVEREX_STORAGE['scroll_dir_last'] = scroll_dir;
	
				} else {
	
					// Unfix when page scrolling to top
					var old_style = sb.data('old_style');
					if (old_style !== undefined)
						sb.attr('style', old_style).removeAttr('data-old_style');
	
				}
			}
		}
	}
	
	
	
	
	
	// Navigation
	//==============================================
	
	// Init Superfish menu
	function hoverex_init_sfmenu(selector) {
		jQuery(selector).show().each(function() {
			// Do not init the mobile menu - only add class 'inited'
			if (jQuery(this).addClass('inited').parents('.menu_mobile').length > 0) return;
			var animation_in = jQuery(this).parent().data('animation_in');
			if (animation_in == undefined) animation_in = "none";
			var animation_out = jQuery(this).parent().data('animation_out');
			if (animation_out == undefined) animation_out = "none";
			jQuery(this).superfish({
				delay: 500,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: 		animation_in!='none' ? 500 : 200,
				speedOut:	animation_out!='none' ? 500 : 200,
				autoArrows: false,
				dropShadows: false,
				onBeforeShow: function(ul) {
					if (jQuery(this).parents("ul").length > 1){
						var w = jQuery('.page_wrap').width();  
						var par_offset = jQuery(this).parents("ul").offset().left;
						var par_width  = jQuery(this).parents("ul").outerWidth();
						var ul_width   = jQuery(this).outerWidth();
						if (par_offset+par_width+ul_width > w-20 && par_offset-ul_width > 0)
							jQuery(this).addClass('submenu_left');
						else
							jQuery(this).removeClass('submenu_left');
					}
					if (animation_in!='none') {
						jQuery(this).removeClass('animated fast '+animation_out);
						jQuery(this).addClass('animated fast '+animation_in);
					}
				},
				onBeforeHide: function(ul) {
					if (animation_out!='none') {
						jQuery(this).removeClass('animated fast '+animation_in);
						jQuery(this).addClass('animated fast '+animation_out);
					}
				},
				onShow: function(ul) {
					// Init layouts
					if (!jQuery(this).hasClass('layouts_inited')) {
						jQuery(this).addClass('layouts_inited');
						jQuery(document).trigger('action.init_hidden_elements', [jQuery(this)]);
					}
				}
			});
		});
	}
	

	// Add TOC in the side menu
	// Make this function global because it used in the elementor.js
	function hoverex_add_toc_to_sidemenu() {
		if (jQuery('.menu_side_inner').length > 0 && jQuery('#toc_menu').length > 0) {
			jQuery('#toc_menu').appendTo('.menu_side_inner');
			hoverex_stretch_sidemenu();
		}
	};
	
	
	
	// Post formats init
	//=====================================================
	
	function hoverex_init_post_formats(e, cont) {
		
		// Wrap select with .select_container
		cont.find('select:not(.esg-sorting-select):not([class*="trx_addons_attrib_"])').each(function() {
			var s = jQuery(this);
			if (s.css('display') != 'none' 
				&& s.parents('.select_container').length == 0
				&& !s.next().hasClass('select2') 
				&& !s.hasClass('select2-hidden-accessible'))
				s.wrap('<div class="select_container"></div>');
		});

		// MediaElement init
		hoverex_init_media_elements(cont);
		
		// Video play button
		cont.find('.format-video .post_featured.with_thumb .post_video_hover:not(.inited)')
			.addClass('inited')
			.on('click', function(e) {
				jQuery(this).parents('.post_featured')
					.addClass('post_video_play')
					.find('.post_video').html(jQuery(this).data('video'));
				jQuery(window).trigger('resize');
				e.preventDefault();
				return false;
			});
	}
	
	
	function hoverex_init_media_elements(cont) {
		if (HOVEREX_STORAGE['use_mediaelements'] && cont.find('audio:not(.inited),video:not(.inited)').length > 0) {
			if (window.mejs) {
				if (window.mejs.MepDefaults) window.mejs.MepDefaults.enableAutosize = true;
				if (window.mejs.MediaElementDefaults) window.mejs.MediaElementDefaults.enableAutosize = true;
				cont.find('audio:not(.inited),video:not(.inited)').each(function() {
					// If item now invisible
					if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) {
						return;
					}
					if (jQuery(this).addClass('inited').parents('.mejs-mediaelement').length == 0
						&& jQuery( this ).parents( '.wp-block-video' ).length == 0
						&& ! jQuery( this ).hasClass( 'wp-block-cover__video-background' )
							&& jQuery(this).parents('.elementor-background-video-container').length == 0
							&& (HOVEREX_STORAGE['init_all_mediaelements'] 
								|| (!jQuery(this).hasClass('wp-audio-shortcode') 
									&& !jQuery(this).hasClass('wp-video-shortcode') 
									&& !jQuery(this).parent().hasClass('wp-playlist')
								   )
							   )
					   	) {
						var media_tag = jQuery(this);
						var settings = {
							enableAutosize: true,
							videoWidth: -1,		// if set, overrides <video width>
							videoHeight: -1,	// if set, overrides <video height>
							audioWidth: '100%',	// width of audio player
							audioHeight: 30,	// height of audio player
							success: function(mejs) {
								if ( mejs.pluginType && 'flash' === mejs.pluginType && mejs.attributes ) {
									mejs.attributes.autoplay
										&& 'false' !== mejs.attributes.autoplay 
										&& mejs.addEventListener( 'canplay', function () {	mejs.play(); }, false );
									mejs.attributes.loop
										&& 'false' !== mejs.attributes.loop
										&& mejs.addEventListener( 'ended', function () {	mejs.play(); }, false );
								}
							}
						};
						jQuery(this).mediaelementplayer(settings);
					}
				});
			} else
				setTimeout(function() { hoverex_init_media_elements(cont); }, 400);
		}
		// Init all media elements after first run
		setTimeout(function() { HOVEREX_STORAGE['init_all_mediaelements'] = true; }, 1000);
	}
	
	
	// Load the tab's content
	function hoverex_tabs_ajax_content_loader(panel, page, oldPanel) {
		if (panel.html().replace(/\s/g, '')=='') {
			var height = oldPanel === undefined ? panel.height() : oldPanel.height();
			if (isNaN(height) || height < 100) height = 100;
			panel.html('<div class="hoverex_tab_holder" style="min-height:'+height+'px;"></div>');
		} else
			panel.find('> *').addClass('hoverex_tab_content_remove');
		panel.data('need-content', false).addClass('hoverex_loading');
		jQuery.post(HOVEREX_STORAGE['ajax_url'], {
			nonce: HOVEREX_STORAGE['ajax_nonce'],
			action: 'hoverex_ajax_get_posts',
			blog_template: panel.data('blog-template'),
			blog_style: panel.data('blog-style'),
			posts_per_page: panel.data('posts-per-page'),
			cat: panel.data('cat'),
			parent_cat: panel.data('parent-cat'),
			post_type: panel.data('post-type'),
			taxonomy: panel.data('taxonomy'),
			page: page
		}).done(function(response) {
			panel.removeClass('hoverex_loading');
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: HOVEREX_STORAGE['strings']['ajax_error'] };
				console.log(response);
			}
			if (rez.error !== '') {
				panel.html('<div class="hoverex_error">'+rez.error+'</div>');
			} else {
				panel.prepend(rez.data).fadeIn(function() {
					jQuery(document).trigger('action.init_hidden_elements', [panel]);
					jQuery(window).trigger('scroll');
					setTimeout(function() {
						panel.find('.hoverex_tab_holder,.hoverex_tab_content_remove').remove();
						jQuery(window).trigger('scroll');
					}, 600);
				});
			}
		});
	}
	
	
	// Forms validation
	//-------------------------------------------------------
	
	// Comments form
	function hoverex_comments_validate(form) {
		form.find('input').removeClass('error_field');
		var comments_args = {
			error_message_text: HOVEREX_STORAGE['strings']['error_global'],	// Global error message text (if don't write in checked field)
			error_message_show: true,									// Display or not error message
			error_message_time: 4000,									// Error message display time
			error_message_class: 'hoverex_messagebox hoverex_messagebox_style_error',	// Class appended to error message block
			error_fields_class: 'error_field',							// Class appended to error fields
			exit_after_first_error: false,								// Cancel validation and exit after first error
			rules: [
				{
					field: 'comment',
					min_length: { value: 1, message: HOVEREX_STORAGE['strings']['text_empty'] },
					max_length: { value: HOVEREX_STORAGE['comment_maxlength'], message: HOVEREX_STORAGE['strings']['text_long']}
				}
			]
		};
		if (form.find('.comments_author input[aria-required="true"]').length > 0) {
			comments_args.rules.push(
				{
					field: 'author',
					min_length: { value: 1, message: HOVEREX_STORAGE['strings']['name_empty']},
					max_length: { value: 60, message: HOVEREX_STORAGE['strings']['name_long']}
				}
			);
		}
		if (form.find('.comments_email input[aria-required="true"]').length > 0) {
			comments_args.rules.push(
				{
					field: 'email',
					min_length: { value: 1, message: HOVEREX_STORAGE['strings']['email_empty']},
					max_length: { value: 60, message: HOVEREX_STORAGE['strings']['email_long']},
					mask: { value: HOVEREX_STORAGE['email_mask'], message: HOVEREX_STORAGE['strings']['email_not_valid']}
				}
			);
		}
		var error = hoverex_form_validate(form, comments_args);
		return !error;
	}

	// Bubble submit() up for widget "Categories"

	var s = jQuery("select:not(.esg-sorting-select)");

	if ( s.parents( '.widget_categories' ).length > 0 ) {

	s.parent().each( function (ind, item) { jQuery(item).get(0).submit = function() {

	jQuery(item).closest('form').submit();

	}; }); }

	//Open new windows in new tab
	jQuery('a').filter(function() {
		"use strict";
		return this.hostname && this.hostname !== location.hostname;
	}).attr('target','_blank');

});