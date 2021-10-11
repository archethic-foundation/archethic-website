<?php
/**
 * The style "default" of the Cart
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

$args = get_query_var('trx_addons_args_sc_layouts_cart');

$show_cart = function_exists('trx_addons_elm_is_preview') && trx_addons_elm_is_preview() && get_post_type()==TRX_ADDONS_CPT_LAYOUTS_PT
				 ? 'preview' 
				 : '';

$cart_items = $cart_summa = 0;

if (empty($show_cart)) {
	// If it's a WooCommerce Cart
	if ($args['market'] == 'woocommerce' && trx_addons_exists_woocommerce() && !is_cart() && !is_checkout() && !empty(WC()->cart)) {
		$cart_items = WC()->cart->get_cart_contents_count();
		$cart_summa = strip_tags(WC()->cart->get_cart_subtotal());
		$show_cart = 'woocommerce';

	// If it's a EDD Cart
	} else if ($args['market'] == 'edd' && trx_addons_exists_edd()) {
		$cart_items = edd_get_cart_quantity();
		$cart_summa = edd_currency_filter( edd_format_amount( edd_get_cart_total() ) );
		$show_cart = 'edd';
	}
}

if (!empty($show_cart)) {

	?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_layouts_cart<?php
			trx_addons_cpt_layouts_sc_add_classes($args);
		?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"'; ?>>
		<span class="sc_layouts_item_icon sc_layouts_cart_icon trx_addons_icon-basket"></span>
		<span class="sc_layouts_item_details sc_layouts_cart_details">
			<?php if (!empty($args['text'])) { ?>
			<span class="sc_layouts_item_details_line1 sc_layouts_cart_label"><?php echo esc_html($args['text']); ?></span>
			<?php } ?>
			<span class="sc_layouts_item_details_line2 sc_layouts_cart_totals">
				<span class="sc_layouts_cart_items"><?php
					echo esc_html($cart_items) . ' ' . esc_html(_n('item', 'items', $cart_items, 'trx_addons'));
				?></span>
				- 
				<span class="sc_layouts_cart_summa"><?php trx_addons_show_layout($cart_summa); ?></span>
			</span>
		</span><!-- /.sc_layouts_cart_details -->
		<span class="sc_layouts_cart_items_short"><?php echo esc_html($cart_items); ?></span>
		<div class="sc_layouts_cart_widget widget_area">
			<span class="sc_layouts_cart_widget_close trx_addons_icon-cancel"></span>
			<?php
			// Show WooCommerce Cart
			if ($show_cart == 'woocommerce')
				the_widget( 'WC_Widget_Cart', 'title=&hide_if_empty=0' );

			// Show EDD Cart
			else if ($show_cart == 'edd')
				the_widget( 'edd_cart_widget', 'title=&hide_on_checkout=0&hide_on_empty=0' );

			// Show preview Cart
			else {
				?><div class="sc_layouts_cart_preview"><?php esc_html_e('Placeholder for Cart items'); ?></div><?php
			}
			?>
		</div><!-- /.sc_layouts_cart_widget -->
	</div><!-- /.sc_layouts_cart --><?php

	trx_addons_sc_layouts_showed('cart', true);
}
?>