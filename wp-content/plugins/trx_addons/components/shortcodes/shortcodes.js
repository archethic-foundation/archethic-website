/**
 * Shortcodes common scripts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */


(function() {

	"use strict";
	
	// Fullheight elements
	//jQuery(document).on('action.init_hidden_elements', trx_addons_sc_fullheight);
	//jQuery(document).on('action.resize_trx_addons', trx_addons_sc_fullheight);

	function trx_addons_sc_fullheight(e, container) {
	
		if (container === undefined) container = jQuery('body');
		if (container === undefined || container.length === undefined || container.length == 0) return;
	
		container.find('.trx_addons_stretch_height').each(function () {
			var fullheight_item = jQuery(this);
			// If item now invisible
			if (jQuery(this).parents('div:hidden,article:hidden').length > 0) {
				return;
			}
			var wh = 0;
			var fullheight_row = jQuery(this).parents('.vc_row-o-full-height');
			if (fullheight_row.length > 0) {
				wh = fullheight_row.css('height') != 'auto' ? fullheight_row.height() : 'auto';
			} else {
				if (jQuery(window).height() > 1000) {
					var adminbar = jQuery('#wpadminbar');
					wh = jQuery(window).height() - (adminbar.length > 0 ? adminbar.height() : 0);
				} else
					wh = 'auto';
			}
			if (wh == 'auto' || wh > 0) fullheight_item.height(wh);
		});
	}


	// Equal height elements
	jQuery(document).on('action.resize_trx_addons', trx_addons_sc_equalheight);

	function trx_addons_sc_equalheight(e, container) {
		if (container === undefined) container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;
		container.find('[data-equal-height],.trx_addons_equal_height').each(function () {
			var eh_wrap = jQuery(this);
			var eh_items_selector = eh_wrap.data('equal-height');
			if (eh_items_selector === undefined) eh_items_selector = '>*';
			var max_h = 0;
			var items = [];
			var row_y = 0;
			var i=0;
			eh_wrap.find(eh_items_selector).each(function() {
				var el = jQuery(this);
				el.css('visibility', 'hidden').height('auto');
				var el_height = el.height();
				var el_offset = el.offset().top;
				if (row_y == 0) row_y = el_offset;
				if (row_y < el_offset) {
					if (items.length > 0) {
						if (max_h > 0) {
							for (i=0; i<items.length; i++)
								items[i].css('visibility', 'visible').height(max_h);
						}
						items = [];
						max_h = 0;
					}
					row_y = el_offset;
				}
				if (el_height > max_h) max_h = el_height;
				items.push(el);
			});
			if (items.length > 0 && max_h > 0) {
				for (i=0; i<items.length; i++)
					items[i].css('visibility', 'visible').height(max_h);
			}
		});
	}

	// Load post's details by AJAX and show in the popup
	jQuery(document).on('action.ready_trx_addons', function() {
		"use strict";
		jQuery('.sc_post_details_popup:not(.inited)')
			.addClass('inited')
			.on('click', 'a', function(e) {
				trx_addons_show_post_details(jQuery(this).parents('[data-post_id]'), true);
				e.preventDefault();
				return false;
			});
		if (jQuery('.sc_post_details_popup.inited').length > 0) {
			jQuery('body:not(.sc_post_details_popup_inited)')
				.addClass('sc_post_details_popup_inited')
				.on('click', '#trx_addons_post_details_popup_overlay, .trx_addons_post_details_popup_close', function(e) {
					jQuery('#trx_addons_post_details_popup').fadeOut();
					jQuery('#trx_addons_post_details_popup_overlay').fadeOut();
				})
				.on('click', '.trx_addons_post_details_popup_prev,.trx_addons_post_details_popup_next', function(e) {
					var popup = jQuery('#trx_addons_post_details_popup');
					var post_item = popup.data('post_item');
					if (!post_item || post_item.length == 0) return;
					var posts_items = post_item.parents('.sc_item_columns,.sc_item_slider').find('[data-post_id]');
					var cur_idx = -1;
					posts_items.each(function(idx) {
						if (jQuery(this).data('post_id') == post_item.data('post_id')) cur_idx = idx;
					});
					if (cur_idx == -1) return;
					post_item = jQuery(this).hasClass('trx_addons_post_details_popup_prev') 
									? (cur_idx > 0 ? posts_items.eq(cur_idx-1) : false)
									: (cur_idx < posts_items.length-1 ? posts_items.eq(cur_idx+1) : false);
					if (!post_item || post_item.length == 0) return;
					popup.fadeOut();
					trx_addons_show_post_details(post_item, false);
				});
		}
		
		function trx_addons_show_post_details(post_item, show_overlay) {
			jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
				action: 'trx_addons_post_details_in_popup',
				nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
				post_id: post_item.data('post_id'),
				post_type: post_item.data('post_type')
			}).done(function(response) {
				var rez = {};
				if (response=='' || response==0) {
					rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
				} else {
					try {
						rez = JSON.parse(response);
					} catch (e) {
						rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
						console.log(response);
					}
				}
				var msg = rez.error === '' ? rez.data : rez.error;
				var popup = jQuery('#trx_addons_post_details_popup');
				var overlay = jQuery('#trx_addons_post_details_popup_overlay');
				if (popup.length == 0) {
					jQuery('body').append(
						'<div id="trx_addons_post_details_popup_overlay"></div>'
						+ '<div id="trx_addons_post_details_popup">'
							+ '<div class="trx_addons_post_details_content"></div>'
							+ '<span class="trx_addons_post_details_popup_close trx_addons_icon-cancel"></span>'
							+ '<span class="trx_addons_post_details_popup_prev trx_addons_icon-left"></span>'
							+ '<span class="trx_addons_post_details_popup_next trx_addons_icon-right"></span>'
						+ '</div>');
					popup = jQuery('#trx_addons_post_details_popup');
					overlay = jQuery('#trx_addons_post_details_popup_overlay');
				}
				popup.data('post_item', post_item).find('.trx_addons_post_details_content').html(msg);
				if (show_overlay) overlay.fadeIn();
				popup.fadeIn();
			});
		}
	});

})();