/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).on('action.ready_trx_addons', function() {
	"use strict";

	var rows = jQuery('.sc_layouts_row_fixed'),
		rows_always = jQuery('.sc_layouts_row_fixed_always');
	
	// If page contain fixed rows
	if (rows.length > 0) {
		// Add placeholders after each row
		rows.each(function() {
			if (!jQuery(this).next().hasClass('sc_layouts_row_fixed_placeholder'))
				jQuery(this).after('<div class="sc_layouts_row_fixed_placeholder" style="background-color:'+jQuery(this).css('background-color')+';"></div>');
		});
		jQuery(document).on('action.scroll_trx_addons', function() {
			trx_addons_cpt_layouts_fix_rows(rows, rows_always, false);
		});
		jQuery(document).on('action.resize_trx_addons', function() {
			trx_addons_cpt_layouts_fix_rows(rows, rows_always, true);
		});
	}

	function trx_addons_cpt_layouts_fix_rows(rows, rows_always, resize) {
		if (jQuery(window).width() < 768) {
			rows.each(function() {
				if (!jQuery(this).hasClass('sc_layouts_row_fixed_always')) {
					jQuery(this).removeClass('sc_layouts_row_fixed_on').css({'top': 'auto'});
				}
			});
			if (rows_always.length == 0)
				return;
			else
				rows = rows_always;
		}
		
		var scroll_offset = jQuery(window).scrollTop();
		var rows_offset = trx_addons_fixed_rows_height(true, false);	// Only admin bar height

		rows.each(function() {

			var placeholder = jQuery(this).next();
			var h = jQuery(this).outerHeight();
			if (jQuery(this).css('display')=='none' || h == 0) {
				placeholder.height(0);
				return;
			}
			var offset = parseInt(jQuery(this).hasClass('sc_layouts_row_fixed_on') ? placeholder.offset().top : jQuery(this).offset().top, 10);
			if (isNaN(offset)) offset = 0;
			// Fix/unfix row
			if (scroll_offset + rows_offset <= offset) {
				if (jQuery(this).hasClass('sc_layouts_row_fixed_on')) {
					jQuery(this).removeClass('sc_layouts_row_fixed_on').css({'top': 'auto'});
					jQuery(document).trigger('action.sc_layouts_row_fixed_off');
				}
			} else {
				if (!jQuery(this).hasClass('sc_layouts_row_fixed_on')) {
					if (rows_offset + h < jQuery(window).height() * 0.33) {
						placeholder.height(h);
						jQuery(this).addClass('sc_layouts_row_fixed_on').css({'top': rows_offset+'px'});
						h = jQuery(this).outerHeight();
						jQuery(document).trigger('action.sc_layouts_row_fixed_on');
					}
				} else if (resize && jQuery(this).hasClass('sc_layouts_row_fixed_on') && jQuery(this).offset().top != rows_offset) {
					jQuery(this).css({'top': rows_offset+'px'});
				}
				rows_offset += h;
			}
		});
	}
});