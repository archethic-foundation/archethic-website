<?php
/**
 * The style "chess" of the Services item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');
$number = get_query_var('trx_addons_args_item_number');
$link = empty($args['no_links']) ? get_permalink() : '';
?>
<div <?php post_class( 'sc_services_item'
			. (empty($post_link) ? ' no_links' : '')
			. (!isset($args['hide_excerpt']) || (int)$args['hide_excerpt']==0 ? ' with_content' : ' without_content')
			. ($number-1 == $args['offset'] ? ' sc_services_item_active' : '')
			);
	if (!empty($args['popup'])) {
		?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
		?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_SERVICES_PT); ?>"<?php
	}
?>><?php
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_services_item_header',
														'show_no_image' => true,
														'no_links' => empty($link),
														'thumb_bg' => true,
														'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('masonry-big'), 'services-tabs')
														),
													'services-tabs'
													)
								);
	?><div class="sc_services_item_content">
		<div class="sc_services_item_content_inner">
			<h3 class="sc_services_item_title"><?php
				if (!empty($link)) {
					?><a href="<?php echo esc_url($link); ?>"><?php
				}
				the_title();
				if (!empty($link)) {
					?></a><?php
				}
			?></h3>
			<div class="sc_services_item_subtitle"><?php
				$terms = trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY);
				if (empty($link)) $terms = trx_addons_links_to_span($terms);
				trx_addons_show_layout($terms);
			?></div><?php
			if (!isset($args['hide_excerpt']) || (int)$args['hide_excerpt']==0) {
				?><div class="sc_services_item_text"><?php the_excerpt(); ?></div><?php
				if (!empty($link)) {
					?><div class="sc_services_item_button sc_item_button"><a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button sc_button_simple', 'sc_services', $args)); ?>"><?php esc_html_e('Learn more', 'trx_addons'); ?></a></div><?php
				}
			}
		?></div>
	</div>
</div>
