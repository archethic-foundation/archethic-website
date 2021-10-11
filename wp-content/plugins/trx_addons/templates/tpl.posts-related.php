<?php
/**
 * The template to show related posts for the single post
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

$trx_addons_args = get_query_var('trx_addons_args_related');

if ($trx_addons_args['posts_per_page'] > 0) {

	$trx_addons_args['columns'] = max(1, $trx_addons_args['columns']);
	
	$query_args = array(
			'ignore_sticky_posts' => true,
			'posts_per_page' => $trx_addons_args['posts_per_page'],
			'orderby' => 'rand',
			'order' => 'DESC',
			'post_type' => !empty($trx_addons_args['post_type']) ? $trx_addons_args['post_type'] : '',
			'post_status' => 'publish',
			'post__not_in' => array(),
			'category__in' => array()
			);
	
	if (!empty($trx_addons_args['post_type']))
		$query_args['post_type'] = $trx_addons_args['post_type'];
	
	$query_args['post__not_in'][] = get_the_ID();
		
	if (!empty($trx_addons_args['taxonomies'])) {
		$query_args['tax_query'] = array(
									'relation' => 'AND'
									);
		foreach($trx_addons_args['taxonomies'] as $taxonomy=>$term_id)
			$query_args['tax_query'][] = array(
											'taxonomy' => $taxonomy,
											'terms' => $term_id,
											'field' => 'term_id'
											);
	}
	if (!empty($trx_addons_args['meta'])) {
		$query_args['meta_query'] = array(
									'relation' => 'OR'
									);
		foreach($trx_addons_args['meta'] as $meta_key=>$meta_value)
			$query_args['meta_query'][] = array(
											'key' => $meta_key,
											'value' => $meta_value
											);
	}

	$query = new WP_Query( apply_filters('trx_addons_filter_query_args_related', $query_args) );
	
	if ($query->found_posts > 0) {
		?><section class="related_wrap<?php if (!empty($trx_addons_args['class'])) echo ' '.esc_attr($trx_addons_args['class']); ?>">
			<h3 class="section_title related_wrap_title"><?php
					if (!empty($title))
						echo esc_html($title);
					else
						esc_html_e('You May Also Like', 'trx_addons');
			?></h3>
			<div class="related_columns related_columns_<?php
								echo esc_attr($trx_addons_args['columns']);
								echo ' '.esc_attr(trx_addons_get_columns_wrap_class()) . ' columns_padding_bottom';
							?>"><?php
				while ( $query->have_posts() ) { $query->the_post();
					trx_addons_get_template_part($trx_addons_args['template'],
												$trx_addons_args['template_args_name'],
												$trx_addons_args
												);
				}
				wp_reset_postdata();
				?>
			</div>
		</section><?php
	}
}