<?php

use Elementor\Utils;

use Stratum\Ajax\Advanced_Posts_Ajax;

extract( shortcode_atts( array(
	'slide_animation_effect'   => '',
	'slide_text_animation_effect'   => '',
	'title_typography_html_tag'   => 'h3',
	'show_image' => '',
	'show_title' => '',
	'show_content' => '',
	'show_excerpt' => '',
	'show_read_more' => '',
	'read_more_text' => '',
	'open_new_tab' => '',
	'excerpt_length' => apply_filters( 'excerpt_length', 25 ),
	'show_meta' => array(),
	'meta_fields_divider' => '',
	'image_size' => '',
	'image_hover_effect' => '',
	'posts_layout' => '',
	'pagination' => '',
	'page_pagination_style' => '',
	'scroll_icon' => '',
	'load_more_text' => '',
	'column_gap' => '',
	'row_gap' => '',
	'masonry' => '',
	'columns' => '',
	'columns_tablet' => '',
	'columns_mobile' => '',
	'animate_on_scroll' => '',
	'animation_effects' => '',

	//Swiper
	'columns_count'				=> '1',
	'slides_in_columns'			=> '1',
	'navigation'				=> 'both',
	'pagination_style'			=> 'bullets',
	//--Swiper
), $settings ) );

//Query builder
$query_args = [];
stratum_build_custom_query( $query_args, $settings );

$q = new \WP_Query( $query_args );

$widget_class = 'stratum-advanced-posts';

$class = stratum_css_class([
	$widget_class,
	'layout-'.$posts_layout,
	($masonry == '' || intval($columns) == 1 || $posts_layout == 'carousel' || $posts_layout == 'list' ? 'masonry-disable' : 'masonry-enable'),
	(($posts_layout == 'grid' && $masonry == '') ? "elementor-grid-{$columns} elementor-grid-tablet-{$columns_tablet} elementor-grid-mobile-{$columns_mobile}" : ''),
	((($posts_layout == 'grid' || $posts_layout == 'list') && $image_hover_effect != 'none') ? "image-effect-".esc_attr( $image_hover_effect ) : ''),
	(($posts_layout == 'carousel' && $slide_animation_effect != 'none') ? "slide-effect-".esc_attr( $slide_animation_effect ) : ''),
	(($posts_layout == 'carousel' && $slide_text_animation_effect != 'none' && (intval($columns_count) == 1 && intval($slides_in_columns) == 1 )) ? "has-text-animation-".esc_attr( $slide_text_animation_effect ) : '')
]);

$wrapper_class = stratum_css_class([
	$widget_class . '__wrapper',
	(($posts_layout == 'grid' && $masonry == '') ? 'elementor-grid' : ''),
	((($posts_layout == 'grid' || $posts_layout == 'list') && ($animate_on_scroll == 'yes' || ($masonry == 'yes' && intval($columns) > 1))) ? "masonry-grid" : ''),
	((($posts_layout == 'grid' || $posts_layout == 'list') && $animate_on_scroll == 'yes') ? "animate_on_scroll ".esc_attr($animation_effects) : ''),
]);

$query_options = [
	//Query args
    'include_ids' => $settings['include_ids'],
    'post_type' => $settings['post_type'],
    'posts_per_page' => $settings['posts_per_page'],
    'order' => $settings['order'],
    'orderby' => $settings['orderby'],
    'ignore_sticky_posts' => $settings['ignore_sticky_posts'],
    'pagination' => $settings['pagination'],
    'exclude_ids' => $settings['exclude_ids'],
    'exclude_current' => $settings['exclude_current'],
    'taxonomies' => $settings['taxonomies'],
	'terms_relation' => $settings['terms_relation'],

	//Settings
	'posts_layout' => $settings['posts_layout'],
	'columns' => $settings['columns'],
	'masonry' => $settings['masonry'],
	'animate_on_scroll' => $settings['animate_on_scroll'],
	'show_title' => $settings['show_title'],
	'show_image' => $settings['show_image'],
	'image_size' => $settings['image_size'],
	'title_typography_html_tag' => $settings['title_typography_html_tag'],
	'title_over_image' => $settings['title_over_image'],
	'show_meta' => $settings['show_meta'],
	'meta_fields_divider' => $settings['meta_fields_divider'],
	'show_content' => $settings['show_content'],
	'show_excerpt' => $settings['show_excerpt'],
	'excerpt_length' => $settings['excerpt_length'],
	'show_read_more' => $settings['show_read_more'],
	'open_new_tab' => $settings['open_new_tab'],
	'read_more_text' => $settings['read_more_text'],
];

//Add terms from taxonomies list
if (!empty($settings['taxonomies'])){
	foreach ($settings['taxonomies'] as $taxonomy_key => $taxonomy_name) {
		if (isset($settings[$taxonomy_name.'_terms'])){
			$query_options[$taxonomy_name.'_terms'] = $settings[$taxonomy_name.'_terms'];
		}
	}
}

$masonry_options = [
    'columns' => $columns,
    'column_gap' => $column_gap['size'],
    'row_gap' => $row_gap['size'],
];

//Generate options for swiper
$slider_options = stratum_generate_swiper_options($settings);

$out = "";

if ($posts_layout == 'grid' || $posts_layout == 'list'){
	$out .= "<div class='".esc_attr( $class )."'".(($pagination == 'yes' && ($page_pagination_style == 'load_more_btn' || $page_pagination_style == 'load_more_scroll')) ? " data-query-options='".json_encode($query_options)."'" : '').">";
		$out .= "<div class='".esc_attr( $wrapper_class )."' data-masonry-options='".json_encode($masonry_options)."'>";
			if ($posts_layout == 'grid' && intval($columns) > 1 && $masonry == 'yes'){
				$out .= "<div class='grid-sizer masonry-col-".esc_attr($columns)."'></div>";
			}

			//Get Articles
			$out .= Advanced_Posts_Ajax::get_instance()->get_articles($settings, 'render');
		$out .= "</div>";

		if ( $pagination == 'yes' ){
			if ($page_pagination_style == 'load_more_btn' || $page_pagination_style == 'load_more_scroll'){
				$out .= "<nav class='ajax_load_more_pagination".($page_pagination_style == 'load_more_scroll' ? ' load_more_scroll' : '')."' role='navigation'>";
					if ($page_pagination_style == 'load_more_scroll'){
						$out .= "<span class='".esc_attr( $widget_class . '__ajax-load-more-arrow' )."'><i class='".esc_attr($scroll_icon)."'></i></span>";
					}
					$out .= "<a class='".esc_attr( $widget_class . '__ajax-load-more-btn' )."' href='#' data-current-page='1' data-max-page='".esc_attr($q->max_num_pages)."'>".esc_html($load_more_text)."</a>";
				$out .= "</nav>";
			} else if ($page_pagination_style == 'navigation') {
				$out .= "<nav class='navigation pagination' role='navigation'>";
					$out .= "<h2 class='screen-reader-text'>" . esc_html__('Posts navigation', 'stratum') . "</h2>";
					$out .= "<div class='nav-links'>";

						$pagination_args = array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $q->max_num_pages,
							'current'      => max( 1, get_query_var( 'paged' ) ),
							'format'       => '?paged=%#%',
							'show_all'     => false,
							'type'         => 'plain',
							'end_size'     => 2,
							'mid_size'     => 1,
							'prev_next'    => true,
							'prev_text'    => sprintf( '<i></i> %1$s', esc_html_x( '<', 'Previous post', 'stratum' ) ),
							'next_text'    => sprintf( '%1$s <i></i>', esc_html_x( '>', 'Next post', 'stratum' ) ),
							'add_args'     => false,
							'add_fragment' => ''
						);

						$pagination_args = apply_filters( 'stratum/widgets/advanced-posts/pagination_args', $pagination_args );
						$out .= paginate_links( $pagination_args );

					$out .= "</div>";
				$out .= "</nav>";
			}
		}

	$out .= "</div>";
} elseif ($posts_layout == 'carousel'){
	$out .= "<div class='".esc_attr( $class )."' data-slider-options='".json_encode($slider_options)."'>";
		$out .= "<div class='swiper-container'>";
			$out .= "<div class='swiper-wrapper'>";

				if ( $q->have_posts() ) {

					while( $q->have_posts() ):
						$q->the_post();

						$post_id = get_the_ID();
						$url = get_the_post_thumbnail_url($post_id, $image_size);

						$out .= "<div class='swiper-slide ".esc_attr( $widget_class . '__post' )."'>";
							$out .= "<div class='".esc_attr( $widget_class . '__image' )."' style='background-image: url(".esc_url($url).");'></div>";
							$out .= "<div class='".esc_attr( $widget_class . '__slide-content' )."'>";
								$out .= "<div class='".esc_attr( $widget_class . '__slide-wrapper' )."'>";
									$out .= "<div class='".esc_attr( $widget_class . '__slide-container' )."'>";

										if (!empty($show_meta)){
											$out .= "<div class='".esc_attr( $widget_class . '__entry-meta' )."'>";

											if (in_array("date", $show_meta)){
												$archive_year  = get_the_time('Y');
												$archive_month = get_the_time('m');
												$archive_day   = get_the_time('d');

												$out .= "<span class='".esc_attr( $widget_class . '__post-date' )."'>";

													$out .= "<time datetime='".esc_attr( get_the_date( 'c' ) )."'>";
														$out .= "<a href='".get_day_link( $archive_year, $archive_month, $archive_day)."'>";
															$out .= esc_html( get_the_date( '' ) );
														$out .= "</a>";
													$out .= "</time>";

												$out .= "</span>";
											}

											if (in_array("author", $show_meta)){
												$out .= in_array("date", $show_meta) ? "<span class='".esc_attr( $widget_class . '__meta-fields-divider' )."'>".esc_html($meta_fields_divider)."</span>" : '';

												$out .= "<div class='".esc_attr( $widget_class . '__post-author' )."'>";
													$out .= "<a href='".esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )."'>";
														$out .= esc_html( get_the_author() );
													$out .= "</a>";
												$out .= "</div>";
											}

											if (in_array("categories", $show_meta)){
												$out .= (in_array("date", $show_meta) || in_array("author", $show_meta)) ? "<span class='".esc_attr( $widget_class . '__meta-fields-divider' )."'>".esc_html($meta_fields_divider)."</span>" : '';

												$out .= "<div class='".esc_attr( $widget_class . '__post-categories' )."'>";
													$out .= get_the_category_list(', ');
												$out .= "</div>";
											}

											if (in_array("comments", $show_meta)){
												$out .= (in_array("date", $show_meta) || in_array("author", $show_meta) || in_array("categories", $show_meta)) ? "<span class='".esc_attr( $widget_class . '__meta-fields-divider' )."'>".esc_html($meta_fields_divider)."</span>" : '';

												$out .= "<div class='".esc_attr( $widget_class . '__post-comments' )."'>";
													$out .= "<a href='".esc_url( get_comments_link() )."'>";
														if ( get_comments_number() ) {
															$out .= esc_html(
																sprintf(
																	_n( '%d Comment', '%d Comments', get_comments_number(), 'stratum' ),
																	get_comments_number()
																)
															);
														} else {
															$out .= esc_html__( 'No comments', 'stratum' );
														}
													$out .= "</a>";
												$out .= "</div>";
											}

											$out .= "</div>";
										}

										if ( $show_title == 'yes' ) {
											ob_start();
												the_title( '<'.esc_attr($title_typography_html_tag).' class="'.esc_attr( $widget_class . '__post-title' ).'"><a href="'.esc_url(get_permalink()).'">', '</a></'.esc_attr($title_typography_html_tag).'>' );
											$out .= ob_get_clean();
										}

										if ( $show_content == 'yes' ) {
											$out .= "<div class='".esc_attr( $widget_class . '__post-content' )."'>";
												if ( $show_excerpt == 'yes' ) {

													if ( $excerpt_length ) {
														\Stratum\Excerpt_Helper::get_instance()->setExcerptLength( $excerpt_length );
														add_filter( 'excerpt_length', array( 'Stratum\Excerpt_Helper', 'excerpt_length' ), 999 );
													}

													$out .= get_the_excerpt();

													remove_filter( 'excerpt_length', array( 'Stratum\Excerpt_Helper', 'excerpt_length' ), 999 );

												} else {
													ob_start();
														the_content();
													$out .= ob_get_clean();
												}
											$out .= "</div>";
										}

										if ( $show_read_more == 'yes' ) {
											$out .= "<div class='".esc_attr( $widget_class . '__entry-footer' )."'>";

												$out .= "<div class='".esc_attr( $widget_class . '__read-more' )."'>";
													$out .= "<a href='".esc_url( get_permalink() )."'".($open_new_tab == 'yes' ? " target='_blank'" : '').">";
														$out .= esc_html($read_more_text);
													$out .= "</a>";
												$out .= "</div>";

											$out .= "</div>";
										}

									$out .= "</div>";
								$out .= "</div>";
							$out .= "</div>";
							$out .= "<div class='".esc_attr( $widget_class . '__overlay' )."'></div>";

						$out .= "</div>";

					endwhile;
					wp_reset_postdata();

				} else {
					$out .= '<p>' . esc_html__( 'Nothing found.', 'stratum' ) . '</p>';
				}
				$out .= "</div>"; //swiper-wrapper

			if ($navigation == 'both' || $navigation == 'pagination'){
				if ($pagination_style == 'scrollbar'){
					$out .= "<div class='swiper-scrollbar'></div>";
				} else {
					$out .= "<div class='swiper-pagination'></div>";
				}
			}
		$out .= "</div>"; //swiper-container

		if ($navigation == 'both' || $navigation == 'arrows'){
			$out .= "<div class='stratum-swiper-button-prev'></div>";
			$out .= "<div class='stratum-swiper-button-next'></div>";
		}
	$out .= "</div>";
}

echo sprintf("%s", $out);