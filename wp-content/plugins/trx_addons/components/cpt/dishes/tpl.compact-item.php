<?php
/**
 * The style "compact" of the Dishes item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.09
 */

$args = get_query_var('trx_addons_args_sc_dishes');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = get_permalink();
$featured_position = !empty($args['featured_position']) ? $args['featured_position'] : 'top';
$image = '';
if ( has_post_thumbnail() ) {
	$image = trx_addons_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), trx_addons_get_thumb_size('masonry') );
}

if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?> "><?php
}
?>
<div class="sc_dishes_item with_image<?php
	echo ' sc_dishes_item_featured_'.esc_attr($featured_position);
	?>"<?php
	if (!empty($args['popup'])) {
		?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
		?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_DISHES_PT); ?>"<?php
	}
	?>>
	<div class="sc_dishes_item_header"<?php if (!empty($image)) echo ' style="background-image: url('.esc_url($image).');"'; ?>>
		<div class="sc_dishes_item_header_info">
			<?php
			// Price
			if (trim($meta['price']) != '') {
				?><div class="sc_dishes_item_price"><?php echo esc_html($meta['price']); ?></div><?php
			}
			// Title and Subtitle
			?>
			<h6 class="sc_dishes_item_title"><a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a></h6>
			<div class="sc_dishes_item_subtitle"><?php trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_DISHES_TAXONOMY));?></div>
		</div>
		<?php
		// Spicy level
		if (trim($meta['spicy']) != '') {
			$meta['spicy'] = max(1, min(5, $meta['spicy']));
			?><span class="dishes_page_spicy dishes_page_spicy_<?php echo esc_html($meta['spicy']); ?>">
				<span class="dishes_page_spicy_label"><?php esc_html_e('Spicy Level:', 'trx_addons'); ?></span>
				<span class="dishes_page_spicy_value"><?php echo esc_html($meta['spicy']); ?></span>
			</span><?php
		}
		?>
	</div>
	<div class="sc_dishes_item_content">
		<div class="sc_dishes_item_text"><?php the_excerpt(); ?></div>
		<div class="sc_dishes_item_button sc_item_button">
			<a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button sc_button_simple sc_dishes_button_more', 'sc_dishes', $args)); ?>"><?php esc_html_e('Learn more', 'trx_addons'); ?></a>
			<?php
			if ($meta['product'] > 0) {
				?><a href="<?php echo esc_url(get_permalink($meta['product'])); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button sc_button_simple sc_dishes_button_order', 'sc_dishes', $args)); ?>"><?php esc_html_e('Order now', 'trx_addons'); ?></a><?php
			}
			?>
		</div>
	</div>
</div>
<?php
if (!empty($args['slider']) || $args['columns'] > 1) {
	?></div><?php
}
?>