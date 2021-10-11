<?php

/*
Widget Name: Posts Carousel
Description: Display blog posts or custom post types as a carousel.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Posts_Carousel {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_posts_carousel', array($this, 'shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-post-carousel', plugin_dir_url(__FILE__) . 'js/posts-carousel' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-slick-carousel', LVCA_PLUGIN_URL . 'assets/js/slick' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-slick', LVCA_PLUGIN_URL . 'assets/css/slick.css', array(), LVCA_VERSION);

        wp_enqueue_style('lvca-posts-carousel', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $defaults = array_merge(
            array('posts_query' => '',
                  'display_title_on_thumbnail' => '',
                  'display_taxonomy_on_thumbnail' => '',
                  'display_title' => '',
                  'display_summary' => '',
                  'display_author' => '',
                  'display_post_date' => '',
                  'display_taxonomy' => '',
                  'display_read_more' => '',
                  'read_more_text' => __('Read More', 'livemesh-vc-addons'),
                  'taxonomy_chosen' => 'category',
                  'image_linkable' => '',
                  'post_link_new_window' => '',
                  'image_size' => 'large',),
            lvca_get_default_atts_carousel()
        );

        $settings = shortcode_atts($defaults, $atts);

        $taxonomies = array();

        $posts_query = $settings['posts_query'];

        if (is_array($posts_query)) {
            $posts_query['post_status'] = 'publish';
        }
        else {
            $posts_query .= '|post_status:publish';
        }
        if (function_exists('vc_build_loop_query')) {


            $posts_query = apply_filters('lvca_posts_carousel_posts_query', $posts_query, $settings);

            list($query_args, $loop) = vc_build_loop_query($posts_query);
        }
        else {
            $query_args = array('posts_per_page' => 10, 'ignore_sticky_posts' => 1);

            $query_args = apply_filters('lvca_posts_carousel_query_args', $query_args, $settings);

            // just display first 10 posts if the user came directly to this shortcode
            $loop = new WP_Query($query_args);
        }

        $output = '';

        // Loop through the posts and do something with them.
        if ($loop->have_posts()) :

            $target = $settings['post_link_new_window'] ? 'target="_blank"' : '';;

            // get me all array key value pairs except for those keys listed
            $carousel_settings = array_diff_key($settings,
                array('posts_query' => '', 'image_linkable' => '', 'display_title' => '', 'display_summary' => ''));

            $uniqueid = uniqid();

            $output .= '<div id="lvca-posts-carousel-' . $uniqueid
                . '" class="lvca-posts-carousel lvca-container" data-settings=\'' . wp_json_encode($carousel_settings) . '\'>';

            // Check if any taxonomy filter has been applied
            list($chosen_terms, $taxonomies) = lvca_get_chosen_terms($query_args);
            if (empty($chosen_terms))
                $taxonomies[] = $settings['taxonomy_chosen'];

            while ($loop->have_posts()) : $loop->the_post();

                $post_id = get_the_ID();

                $entry_output = '<div data-id="id-' . $post_id . '" class="lvca-posts-carousel-item">';

                $entry_output .= '<article id="post-' . $post_id . '" class="' . join(' ', get_post_class('', $post_id)) . '">';

                if ($thumbnail_exists = has_post_thumbnail()):

                    $entry_image = '<div class="lvca-project-image">';

                    if ($settings['image_linkable']):

                        $thumbnail_html = '<a href="' . get_the_permalink()
                            . '" ' . $target
                            . '">' . get_the_post_thumbnail($post_id, $settings['image_size'])
                            . '</a>';

                    else:

                        $thumbnail_html = get_the_post_thumbnail($post_id, $settings['image_size']);

                    endif;

                    $entry_image .= apply_filters('lvca_posts_carousel_thumbnail_html', $thumbnail_html, $post_id, $settings);

                    if (($settings['display_title_on_thumbnail']) || ($settings['display_taxonomy_on_thumbnail'])):

                        $image_info = '<div class="lvca-image-info">';

                        $image_info .= '<div class="lvca-entry-info">';

                        if ($settings['display_title_on_thumbnail']):

                            $image_info .= '<h3 class="lvca-post-title">';

                            $image_info .= '<a href="' . get_permalink()
                                . '" title="' . get_the_title()
                                . '" ' . $target
                                . '" rel="bookmark">' . get_the_title()
                                . '</a>';

                            $image_info .= '</h3>';

                        endif;

                        if ($settings['display_taxonomy_on_thumbnail']):

                            $image_info .= lvca_get_info_for_taxonomies($taxonomies);

                        endif;

                        $image_info .= '</div>';

                        $image_info .= '</div><!-- .lvca-image-info -->';

                        $entry_image .= apply_filters('lvca_posts_carousel_image_info', $image_info, $post_id, $settings);

                    endif;

                    $entry_image .= '</div>';

                    $entry_output .= apply_filters('lvca_posts_carousel_entry_image', $entry_image, $post_id, $settings);


                endif;

                if ($settings['display_title'] || $settings['display_summary']) :

                    $entry_output .= '<div class="lvca-entry-text-wrap ' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                    if ($settings['display_title']) :

                        $entry_title = '<h3 class="entry-title">';

                        $entry_title .= '<a href="' . get_permalink()
                            . '" title="' . get_the_title()
                            . '" ' . $target
                            . '" rel="bookmark">' . get_the_title()
                            . '</a>';

                        $entry_title .= '</h3>';

                        $entry_output .= apply_filters('lvca_posts_carousel_entry_title', $entry_title, $post_id, $settings);

                    endif;

                    if ($settings['display_post_date'] || $settings['display_author'] || $settings['display_taxonomy']) :

                        $entry_meta = '<div class="lvca-entry-meta">';

                        if ($settings['display_author']):

                            $entry_meta .= lvca_entry_author();

                        endif;

                        if ($settings['display_post_date']):

                            $entry_meta .= lvca_entry_published();

                        endif;

                        if ($settings['display_taxonomy']):

                            $entry_meta .= lvca_get_info_for_taxonomies($taxonomies);

                        endif;

                        $entry_meta .= '</div>';

                        $entry_output .= apply_filters('lvca_posts_carousel_entry_meta', $entry_meta, $post_id, $settings);

                    endif;

                    if ($settings['display_summary']) :

                        $excerpt = '<div class="entry-summary">';

                        $excerpt .= get_the_excerpt();

                        $excerpt .= '</div>';

                        $entry_output .= apply_filters('lvca_posts_carousel_entry_excerpt', $excerpt, $post_id, $settings);

                    endif;

                    if ($settings['display_read_more']) :

                        $read_more_text = $settings['read_more_text'];

                        $read_more = '<div class="lvca-read-more">';

                        $read_more .= '<a href="' . get_the_permalink() . '"' . $target . '>' . $read_more_text . '</a>';

                        $read_more .= '</div>';

                        $entry_output .= apply_filters('lvca_posts_carousel_read_more_link', $read_more, $post_id, $settings);

                    endif;

                    $entry_output .= '</div>';

                endif;

                $entry_output .= '</article><!-- .hentry -->';

                $entry_output .= '</div><!-- .lvca-posts-carousel-item -->';

                $output .= apply_filters('lvca_posts_carousel_entry_output', $entry_output, $post_id, $settings);

            endwhile;

            wp_reset_postdata();

            $output .= '</div><!-- .lvca-posts-carousel -->';

        endif;

        return apply_filters('lvca_posts_carousel_output', $output, $settings);
    }


    function map_vc_element() {
        if (function_exists("vc_map")) {

            $carousel_params = array(

                array(
                    'type' => 'loop',
                    'param_name' => 'posts_query',
                    'heading' => __('Posts query', 'livemesh-vc-addons'),
                    'value' => 'size:10|order_by:date',
                    'settings' => array(
                        'size' => array(
                            'hidden' => false,
                            'value' => 10,
                        ),
                        'order_by' => array('value' => 'date'),
                        'post_type' => array(
                            'hidden' => false,
                            'value' => 'jetpack-portfolio',
                        ),
                    ),
                    'description' => __('Create WordPress loop, to populate content from your site.', 'livemesh-vc-addons'),
                    'admin_label' => true
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'image_linkable',
                    'heading' => __('Link Images to Posts?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'post_link_new_window',
                    'heading' => __('Open post links in new window?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                ),

                array(
                    'type' => 'dropdown',
                    'param_name' => 'image_size',
                    'heading' => __('Image Size', 'livemesh-vc-addons'),
                    'std' => 'large',
                    'value' => lvca_get_image_sizes()
                ),

                array(
                    'type' => 'dropdown',
                    'param_name' => 'taxonomy_chosen',
                    'heading' => __('Choose the taxonomy to display info.', 'livemesh-vc-addons'),
                    'description' => __('Choose the taxonomy to use for display of taxonomy information for posts/custom post types.', 'livemesh-vc-addons'),
                    'value' => lvca_get_taxonomies_map(),
                    'std' => 'category',
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_title_on_thumbnail',
                    'heading' => __('Display project title on post/project thumbnail?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_taxonomy_on_thumbnail',
                    'heading' => __('Display taxonomy info on post/project thumbnail?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_title',
                    'heading' => __('Display posts title below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_author',
                    'heading' => __('Display post author info below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_post_date',
                    'heading' => __('Display post date info below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),


                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_taxonomy',
                    'heading' => __('Display taxonomy info below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_summary',
                    'heading' => __('Display post excerpt/summary below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_read_more',
                    'heading' => __('Display read more link the post/portfolio item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'textfield',
                    'param_name' => 'read_more_text',
                    'heading' => __('Read More Text', 'livemesh-vc-addons'),
                    'std' => __('Read More', 'livemesh-vc-addons'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),
            );

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_options('Options'));

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_display_options());

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Posts Carousel", "livemesh-vc-addons"),
                "base" => "lvca_posts_carousel",
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                'description' => __('Display posts or post types as a carousel.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-posts-carousel',
                "params" => $carousel_params
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_posts_carousel extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Posts_Carousel')) {
    new LVCA_Posts_Carousel();
}