<?php
/**
 * The style "default" of the Testimonials
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_testimonials');

$query_args = array(
	'post_type' => TRX_ADDONS_CPT_TESTIMONIALS_PT,
	'post_status' => 'publish',
	'ignore_sticky_posts' => true,
);
if (empty($args['ids'])) {
	$query_args['posts_per_page'] = $args['count'];
	$query_args['offset'] = $args['offset'];
}
$query_args = trx_addons_query_add_sort_order($query_args, $args['orderby'], $args['order']);
$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids'], TRX_ADDONS_CPT_TESTIMONIALS_PT, $args['cat'], TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY);
$query = new WP_Query( $query_args );
if ($query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	$args['columns'] = $args['columns'] < 1 ? $args['count'] : min($args['columns'], $args['count']);
	$args['columns'] = max(1, min(12, (int) $args['columns']));
	$args['slider'] = $args['slider'] > 0 && $args['count'] > $args['columns'];
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	$args['slides_min_width'] = 290;
	?><div <?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?>
		class="sc_testimonials sc_testimonials_<?php
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php

		trx_addons_sc_show_titles('sc_testimonials', $args);
		
		if ($args['slider']) {
			$pagination_bullets = '';
			if (!empty($args['slider_pagination_thumbs'])) {
				$args['slider_pagination_type'] = 'custom';
				$no_image = trx_addons_get_no_image('css/images/no-avatar.png');
			}
			trx_addons_sc_show_slider_wrap_start('sc_testimonials', $args);
		} else if ($args['columns'] > 1) {
			?><div class="sc_testimonials_columns_wrap sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php
		} else {
			?><div class="sc_testimonials_content sc_item_content"><?php
		}	

		while ( $query->have_posts() ) { $query->the_post();
			if ($args['slider'] && !empty($args['slider_pagination_thumbs'])) {
				$img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), apply_filters('trx_addons_filter_thumb_size', 
																trx_addons_get_thumb_size('tiny'), 
																'testimonials-'.$args['type'])
													);
				$img = !empty($img[0]) ? $img[0] : $no_image;
				$pagination_bullets .= '<span class="slider-pagination-button swiper-pagination-button"'
									. ($img ? ' style="background-image: url('.esc_url($img).');"' : '')
									. '>'
									. '</span>';
			}
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_CPT . 'testimonials/tpl.' . trx_addons_esc($args['type']) . '-item.php',
											TRX_ADDONS_PLUGIN_CPT . 'testimonials/tpl.default-item.php'
											),
											'trx_addons_args_sc_testimonials', 
											$args
										);
		}

		wp_reset_postdata();
	
		?></div><?php

		if ($args['slider']) {
			if (!empty($args['slider_pagination_thumbs']))
				$args['slider_pagination_buttons'] = $pagination_bullets;
			trx_addons_sc_show_slider_wrap_end('sc_testimonials', $args);
		}

		trx_addons_sc_show_links('sc_testimonials', $args);

	?></div><!-- /.sc_testimonials --><?php
}
?>