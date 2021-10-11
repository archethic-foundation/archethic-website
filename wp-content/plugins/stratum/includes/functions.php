<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Gets plugin's absolute directory path.
 *
 * @param string $path Relative path
 *
 * @return string
 */
function stratum_get_plugin_path( $path = '' ) {
	return STRATUM_PLUGIN_DIR . trim( $path, '/' );
}

/**
 * Gets plugin's URL.
 *
 * @param string $path
 *
 * @return string
 */
function stratum_get_plugin_url( $path = '' ) {
	return plugins_url( $path, STRATUM_PLUGIN_FILE );
}

//Check if this Elementor page
function stratum_is_elementor($id = '') {
	global $post;

	if (!empty($id)) {
		return \Elementor\Plugin::$instance->db->is_built_with_elementor($id);
	} else {
		return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
	}
}

function stratum_generate_swiper_options($settings = []){

	if (empty($settings)) return;

	extract( shortcode_atts( array(
		//Swiper
		'columns_count'				=> '1',
		'slides_in_columns'			=> '1',
		'slides_to_scroll'			=> '1',
		'slider_direction'			=> 'horizontal',
		'auto_height'				=> '',
		'navigation'				=> 'both',
		'pagination_style'			=> 'bullets',
		'dynamic_bullets'			=> '',
		'keyboard_control'			=> '',
		'mousewheel_control'		=> '',
		'item_center'				=> '',
		'spacing_slides'			=> '',
		'free_mode'					=> '',
		'slide_effects'				=> 'slide',
		'autoplay'					=> '',
		'autoplay_speed'			=> '',
		'pause_on_hover'			=> 'yes',
		'loop'						=> '',
		'animation_speed'			=> '',
		'simulate_touch'			=> '',
		//--Swiper

		//Extra options
		'slide_text_animation_delay' => 500,
		'coverflow_visible'			=> '',

		//Responsive
		'columns_count_tablet'		=> '',
		'columns_count_mobile'		=> '',

		'slides_in_columns_tablet'	=> '',
		'slides_in_columns_mobile'	=> '',

		'slides_to_scroll_tablet'	=> '',
		'slides_to_scroll_mobile'	=> '',

		'spacing_slides_tablet'		=> '',
		'spacing_slides_mobile'		=> ''
	), $settings ) );

	$options = array(
		'slidesPerView' => ($columns_count != 'auto') ? ( ($slide_effects == 'cube') ? 1 : (int)$columns_count ) : $columns_count,
		'slidesPerColumn' => (int)$slides_in_columns,
		'slidesPerColumnFill' => 'row', //column
		'slidesPerGroup' => (int)$slides_to_scroll,
		'direction' => $slider_direction,
		'autoHeight' => (($free_mode == 'yes' || (int)$slides_in_columns != 1) ? false : ($auto_height == 'yes')),
		'keyboard' => $keyboard_control == 'yes',
		'mousewheel' => $mousewheel_control == 'yes',
		'centeredSlides' => $item_center == 'yes',
		'spaceBetween' => $spacing_slides['size'],
		'freeMode' => $free_mode == 'yes',
		'effect' => (($slider_direction == 'vertical' && $slide_effects == 'cube') ? 'slide' : $slide_effects),
		'autoplay' => ($autoplay == 'yes') ? array('delay' => $autoplay_speed) : false,
		'autoplayPause' => ($autoplay == 'yes' && $pause_on_hover == 'yes'),
		'loop' => $loop == 'yes',
		'speed' => $animation_speed,
		'allowTouchMove' => $simulate_touch == 'yes',

		'textAnimationDelay' => (int) $slide_text_animation_delay,
		'coverflow_visible' => ($coverflow_visible == 'visible'),

		//Responsive
		'responsive' => array(
			'slidesPerView_tablet' => ( $columns_count_tablet != 'auto') ? (int)$columns_count_tablet : $columns_count_tablet,
			'slidesPerView_mobile' => ( $columns_count_mobile != 'auto') ? (int)$columns_count_mobile : $columns_count_mobile,

			'slidesPerColumn_tablet' => (int)$slides_in_columns_tablet,
			'slidesPerColumn_mobile' => (int)$slides_in_columns_mobile,

			'slidesPerGroup_tablet' => (int)$slides_to_scroll_tablet,
			'slidesPerGroup_mobile' => (int)$slides_to_scroll_mobile,

			'spaceBetween_tablet' => $spacing_slides_tablet['size'],
			'spaceBetween_mobile' => $spacing_slides_mobile['size'],
		)
	);

	if ($navigation != 'none'){
		//Arrows
		$navigation_arrows = true;

		//Bullets
		$navigation_pagination = array(
			'el' => '.swiper-pagination',
			'type' => $pagination_style,
			'clickable' => true,
			'dynamicBullets' => ($dynamic_bullets == 'yes'),
		);

		//Scrollbar
		$navigation_scrollbar = array(
			'el' => '.swiper-scrollbar',
			'draggable' => true
		);

		if ($navigation == 'both'){
			$options['navigation'] = $navigation_arrows;
			if ($pagination_style == 'scrollbar'){
				$options['scrollbar'] = $navigation_scrollbar;
			} else {
				$options['pagination'] = $navigation_pagination;
			}
		} else if ($navigation == 'arrows') {
			$options['navigation'] = $navigation_arrows;
		} else if ($navigation == 'pagination') {
			if ($pagination_style == 'scrollbar'){
				$options['scrollbar'] = $navigation_scrollbar;
			} else {
				$options['pagination'] = $navigation_pagination;
			}
		}
	}

	return $options;
}

function stratum_get_taxonomies($post_type){
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	$return = [];
	if (!empty($taxonomies)){
		foreach ($taxonomies as $key => $taxonomy_name) {
			$return[$key] = $taxonomy_name->labels->name;
		}
	}
	return $return;
}

function stratum_get_terms($taxonomy){
	$return = [];
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
		'hide_empty' => true,
	));

	if (!empty($terms)){
		foreach ($terms as $key => $term_name) {
			$taxonomy_obj = get_taxonomy( $term_name->taxonomy );
			$return[$term_name->slug] = $term_name->name;
		}
	}
	return $return;
}

function stratum_build_custom_query(&$query_args = [], $settings){

    if ((isset($settings['include_ids']) && $settings['include_ids'] != '')  || isset($settings['post_type'])){
        $query_args = array(
            'posts_per_page'      => $settings['posts_per_page'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish',
            'order'               => $settings['order'],
            'orderby'             => $settings['orderby'],
        );

        if ( isset($settings['ignore_sticky_posts']) ){
            $query_args['ignore_sticky_posts'] = $settings['ignore_sticky_posts'];
        }

		if (isset($settings['page'])){
			$paged = $settings['page'];
		} else {
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		}

        if ( isset($settings['pagination']) && $settings['pagination'] == 'yes' ){
            $query_args['paged'] = $paged;
        }

    }

	 //Exclude by IDs && Current Post ID
	 if ((isset($settings['exclude_ids']) && $settings['exclude_ids'] != '') || $settings['exclude_current']){

		$ids_arr = [];
		if ((isset($settings['exclude_ids']) && $settings['exclude_ids'] != '')){
			$ids_arr = array_map( 'intval', explode(',', $settings['exclude_ids']) );
		}

		if ($settings['exclude_current']){
			$ids_arr[] = get_the_ID();
		}

        $query_args['post__not_in'] = $ids_arr;
    }

    //Filter by IDs
    if (isset($settings['include_ids']) && $settings['include_ids'] != ''){

        $ids_arr = array_map( 'intval', explode(',', $settings['include_ids']) );
        $query_args['post__in'] = $ids_arr;

    }

    //Set post_type
    if ( isset($settings['post_type'])){

        $query_args['post_type'] = $settings['post_type'];

        if ( !empty($settings['taxonomies'])){

            $query_args['tax_query'] = array(
                'relation' => $settings['terms_relation'],
            );

			$taxonomy_arr = [];

			//Get terms from taxonomy (Make arr)
			foreach ($settings['taxonomies'] as $taxonomy_key => $taxonomy_name) {
				if (isset($settings[$taxonomy_name.'_terms'])){
					foreach ($settings[$taxonomy_name.'_terms'] as $term_key => $term_value) {
						$taxonomy_arr[$taxonomy_name][] = $term_value;
					}
				}
			}

            //Add array to query
            if (!empty($taxonomy_arr)){
                foreach ($taxonomy_arr as $taxonomy_name => $terms_arr) {
					foreach ($terms_arr as $term_index => $term_name) {
						$query_args['tax_query'][] = array(
							'taxonomy' => $taxonomy_name,
							'field' => 'slug',
							'terms' => $term_name
						);
					}
				}
			}
        }
	}
}

function stratum_css_class($class_array){
	return implode(' ', array_filter($class_array));
}
