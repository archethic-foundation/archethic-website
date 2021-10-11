/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).on('action.ready_trx_addons', function() {

	"use strict";

	// Added to cart
	if (jQuery('.sc_layouts_cart').length > 0 && !jQuery('body').hasClass('added_to_cart_inited')) {
		jQuery('body').addClass('added_to_cart_inited');
		// Update amount on the cart button: WooCommerce Cart
		jQuery(document).on('added_to_cart removed_from_cart', function() {
			var total = jQuery('.widget_shopping_cart').eq(0).find('.total .amount').text();
			if (total != undefined) {
				jQuery('.sc_layouts_cart_summa').text(total);
			}
			// Update count items on the cart button
			var cnt = 0;
			jQuery('.widget_shopping_cart_content').eq(0).find('.cart_list li').each(function() {
				var q = jQuery(this).find('.quantity').html().split(' ', 2);
				if (!isNaN(q[0]))
					cnt += Number(q[0]);
			});
			var items = jQuery('.sc_layouts_cart_items').eq(0).text().split(' ', 2);
			items[0] = cnt;
			jQuery('.sc_layouts_cart_items').text(items[0]+(items.length > 1 ? ' '+items[1] : ''));
			jQuery('.sc_layouts_cart_items_short').text(items[0]);
			// Update data-attr on button
			jQuery('.sc_layouts_cart').data({
				'items': cnt ? cnt : 0,
				'summa': total ? total : 0
			});
		});
		// Update amount on the cart button: WooCommerce Cart
		jQuery(document.body).on('edd_cart_item_added edd_cart_item_removed edd_quantity_updated', function (e, data) {
			var items = jQuery('.sc_layouts_cart_items').eq(0).text().split(' ', 2);
			items[0] = data.cart_quantity ? data.cart_quantity : data.quantity;
			jQuery('.sc_layouts_cart_items').text(items[0]+(items.length > 1 ? ' '+items[1] : ''));
			jQuery('.sc_layouts_cart_items_short').text(items[0]);
			jQuery('.sc_layouts_cart_summa').text(data.total);
			// Update data-attr on button
			jQuery('.sc_layouts_cart').data({
				'items': data.cart_quantity ? data.cart_quantity : 0,
				'summa': data.total ? data.total : 0
			});
			
		});
		
		// Show/Hide cart 
		jQuery('.sc_layouts_cart:not(.inited)')
			.addClass('inited')
			.on('click', '.sc_layouts_cart_icon,.sc_layouts_cart_details', function(e) {
				var widget = jQuery(this).siblings('.sc_layouts_cart_widget'),
					row = jQuery(this).parents('.sc_layouts_row');
				if (widget.length > 0 && widget.text().replace(/\s*/g, '')!='') {
					row.toggleClass('sc_layouts_row_on_top');
					jQuery(this).parents('.sc_layouts_cart').toggleClass('sc_layouts_cart_opened');
					jQuery(this).siblings('.sc_layouts_cart_widget').fadeToggle();
				}
				e.preventDefault();
				return false;
			})
			.on('click', '.sc_layouts_cart_widget_close', function(e) {
				jQuery(this).parents('.sc_layouts_row').removeClass('sc_layouts_row_on_top');
				jQuery(this).parents('.sc_layouts_cart').removeClass('sc_layouts_cart_opened');
				jQuery(this).parent().fadeOut();
				e.preventDefault();
				return false;
			});
	}
});