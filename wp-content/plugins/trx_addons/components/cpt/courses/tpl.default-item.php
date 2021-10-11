<?php
/**
 * The style "default" of the Courses
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_courses');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
?>
<div class="sc_courses_item trx_addons_hover trx_addons_hover_style_links">
	<?php if (has_post_thumbnail()) { ?>
		<div class="sc_courses_item_thumb">
			<?php the_post_thumbnail( trx_addons_get_thumb_size($args['columns'] > 2 ? 'medium' : 'big'), array('alt' => get_the_title()) ); ?>
			<span class="sc_courses_item_categories"><?php trx_addons_show_layout(trx_addons_get_post_terms(' ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY)); ?></span>
		</div>
	<?php } ?>
	<div class="sc_courses_item_info">
		<div class="sc_courses_item_header">
			<h4 class="sc_courses_item_title"><?php the_title(); ?></h4>
			<div class="sc_courses_item_meta">
				<span class="sc_courses_item_meta_item sc_courses_item_meta_date"><?php
					$dt = $meta['date'];
					echo sprintf($dt < date('Y-m-d') ? esc_html__('Started on %s', 'trx_addons') : esc_html__('Starting %s', 'trx_addons'), '<span class="sc_courses_item_date">' . date_i18n(get_option('date_format'), strtotime($dt)) . '</span>');
				?></span>
				<span class="sc_courses_item_meta_item sc_courses_item_meta_duration"><?php echo esc_html($meta['duration']); ?></span>
            </div>
		</div>
		<div class="sc_courses_item_price"><?php
			$price = explode('/', $meta['price']);
			echo esc_html($price[0]) . (!empty($price[1]) ? '<span class="sc_courses_item_period">'.$price[1].'</span>' : '');
		?></div>
	</div>
	<div class="trx_addons_hover_mask"></div>
	<div class="trx_addons_hover_content">
		<h4 class="trx_addons_hover_title"><?php the_title(); ?></h4>
		<?php if (($excerpt = get_the_excerpt()) != '') { ?>
			<div class="trx_addons_hover_text"><?php echo esc_html($excerpt); ?></div>
		<?php } ?>
		<div class="trx_addons_hover_links">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'trx_addons_hover_link', 'sc_courses', $args)); ?>"><?php esc_html_e('More Info', 'trx_addons'); ?></a>
			<?php if (!empty($meta['product']) && (int) $meta['product'] > 0) { ?>
			<a href="<?php echo esc_url(get_permalink($meta['product'])); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'trx_addons_hover_link2', 'sc_courses', $args)); ?>"><?php esc_html_e('Buy Now', 'trx_addons'); ?></a>
			<?php } ?>
		</div>
	</div>
</div>
<?php
if (!empty($args['slider']) || $args['columns'] > 1) {
	?></div><?php
}
?>