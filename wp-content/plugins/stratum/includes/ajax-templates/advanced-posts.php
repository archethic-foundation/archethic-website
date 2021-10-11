<?php

namespace Stratum\Ajax;

use Stratum\Managers\Ajax_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Posts_Ajax extends Ajax_Manager {

	private static $instance = null;

	public function __construct() {
		$this->register_ajax_action( 'stratum_ajax_get_articles', 'get_articles' );
	}

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
		}

        return self::$instance;
	}

	public function get_articles($settings, $type = 'ajax') {
		if ( $type == 'ajax' ) {
			$settings = $_POST['settings'];

			//Check nonce
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'stratum_nonce_get_articles' ) ) {
				wp_send_json_error();
			}
		}

		extract( shortcode_atts( array(
			'slide_animation_effect'   => '',
			'slide_text_animation_effect'   => '',
			'title_typography_html_tag'   => 'h3',
			'show_image' => '',
			'show_title' => '',
			'title_over_image' => '',
			'show_content' => '',
			'show_excerpt' => '',
			'show_read_more' => '',
			'read_more_text' => '',
			'open_new_tab' => '',
			'excerpt_length' => apply_filters( 'excerpt_length', 25 ),
			'show_meta' => array(),
			'meta_fields_divider' => '',
			'image_size' => '',
			'posts_layout' => '',
			'pagination' => '',
			'load_more_pagination' => '',
			'load_more_text' => '',
			'column_gap' => '',
			'row_gap' => '',
			'masonry' => '',
			'columns' => '',
			'columns_tablet' => '',
			'columns_mobile' => '',
			'animate_on_scroll' => '',

			//Swiper
			'navigation'				=> 'both',
			'pagination_style'			=> 'bullets',
			//--Swiper
		), $settings ) );

		$widget_class = 'stratum-advanced-posts';

		$out = "";

		//Query builder
		$query_args = [];
		stratum_build_custom_query( $query_args, $settings );

		$q = new \WP_Query( $query_args );

		if ( $q->have_posts() ){

			while( $q->have_posts() ):
				$q->the_post();

				$item_class = stratum_css_class([
					$widget_class . '__post',
					(($show_title == 'yes' && $title_over_image == 'yes') ? 'title_over_image' : ''),
					((($posts_layout == 'grid' || $posts_layout == 'list') && ($animate_on_scroll == 'yes' || ($masonry == 'yes' && intval($columns) > 1))) ? "masonry-item" : ''),
				]);

				$out .= "<article id='post-".esc_attr(get_the_ID())."' class='".esc_attr( $item_class )."'>";
					$out .= "<div class='".esc_attr( $widget_class . '__post-wrapper' )."'>";
						if ( $show_image == 'yes' ) {
							$out .= "<div class='".esc_attr( $widget_class . '__post-thumbnail' )."'>";
								$out .= "<a href='".esc_url(get_permalink())."' class='".esc_attr( $widget_class . '__post-link' )."'>";
									ob_start();
										the_post_thumbnail( $image_size,
											array(
												'alt' => the_title_attribute( 'echo=0' ),
												'class' => esc_attr( $widget_class . '__post-thumbnail-image' ),
											)
										);
									$out .= ob_get_clean();
									$out .= "<div class='".esc_attr( $widget_class . '__post-thumbnail-overlay' )."'></div>";
									if ( $show_title == 'yes' && $title_over_image == 'yes' ) {
										$out .= "<{$title_typography_html_tag} class='".esc_attr( $widget_class . '__post-title' )."'>";
											$out .= esc_html( get_the_title() );
										$out .= "</{$title_typography_html_tag}>";
									}
								$out .= "</a>";
							$out .= "</div>";
						}

						$out .= "<div class='".esc_attr( $widget_class . '__content-wrapper' )."'>";
							$out .= "<div class='".esc_attr( $widget_class . '__entry-header' )."'>";

								if ( $show_title == 'yes' && $title_over_image == '' ) {
									ob_start();
										the_title( '<'.esc_attr($title_typography_html_tag).' class="'.esc_attr( $widget_class . '__post-title' ).'"><a href="'.esc_url(get_permalink()).'">', '</a></'.esc_attr($title_typography_html_tag).'>' );
									$out .= ob_get_clean();
								}

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


							$out .= "</div>";

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
				$out .= "</article>";
			endwhile;
			wp_reset_postdata();

		} else {
			$out .= '<p>' . esc_html__( 'Nothing found.', 'stratum' ) . '</p>';
		}

		if ($type == 'render'){
			return $out;
		} elseif ($type == 'ajax'){
			echo $out;
			wp_die();
		}
	}

}

new Advanced_Posts_Ajax();