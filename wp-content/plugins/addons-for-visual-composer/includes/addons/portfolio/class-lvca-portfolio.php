<?php

/*
Widget Name: Posts Grid
Description: Display posts or custom post types in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Portfolio {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_portfolio', array($this, 'shortcode_func'));

        // Do it as late as possible so that all taxonomies are registered
        add_action('init', array($this, 'map_vc_element'), 9999);

    }

    function load_scripts() {

        wp_enqueue_script('lvca-isotope', LVCA_PLUGIN_URL . 'assets/js/isotope.pkgd' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-imagesloaded', LVCA_PLUGIN_URL . 'assets/js/imagesloaded.pkgd' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-portfolio', plugin_dir_url(__FILE__) . 'js/portfolio' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-portfolio', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag = "") {

        $defaults = array_merge(
            array(
                'heading' => '',
                'posts_query' => '',
                'display_title_on_thumbnail' => '',
                'display_taxonomy_on_thumbnail' => '',
                'display_title' => '',
                'display_author' => '',
                'display_post_date' => '',
                'display_taxonomy' => '',
                'display_summary' => '',
                'display_read_more' => '',
                'read_more_text' => __('Read More', 'livemesh-vc-addons'),
                'image_linkable' => '',
                'post_link_new_window' => '',
                'filterable' => '',
                'post_type' => 'post',
                'taxonomy_filter' => 'category',
                'per_line' => 3,
                'per_line_tablet' => 2,
                'per_line_mobile' => 1,
                'layout_mode' => 'fitRows',
                'image_size' => 'large',
                'packed' => '',
                'gutter' => 20,
                'tablet_gutter' => 10,
                'tablet_width' => 800,
                'mobile_gutter' => 10,
                'mobile_width' => 480
            )

        );

        $settings = shortcode_atts($defaults, $atts);

        $current_page = get_queried_object_id();

        $posts_query = $settings['posts_query'];

        if (is_array($posts_query)) {
            $posts_query['post_status'] = 'publish';
        }
        else {
            $posts_query .= '|post_status:publish';
        }
        if (function_exists('vc_build_loop_query')) {

            $posts_query = apply_filters('lvca_posts_grid_posts_query', $posts_query, $settings);

            list($query_args, $loop) = vc_build_loop_query($posts_query);
        }
        else {
            $query_args = array('posts_per_page' => 8, 'post_type' => $settings['post_type']);

            $query_args = apply_filters('lvca_posts_grid_query_args', $query_args, $settings);

            // just display first 10 portfolio items if the user came directly to this shortcode
            $loop = new WP_Query($query_args);
        }

        $output = '';

        // Loop through the posts and do something with them.
        if ($loop->have_posts()) :

            // Check if any taxonomy filter has been applied
            list($chosen_terms, $taxonomies) = lvca_get_chosen_terms($query_args);
            if (empty($chosen_terms))
                $taxonomies[] = $settings['taxonomy_filter'];

            $target = $settings['post_link_new_window'] ? 'target="_blank"' : '';;

            $output .= '<div class="lvca-portfolio-wrap lvca-gapless-grid">';

            if (!empty($settings['heading']) || $settings['filterable']):

                $header_class = (trim($settings['heading']) === '') ? ' lvca-no-heading' : '';

                $grid_header = '<div class="lvca-portfolio-header ' . $header_class . '">';

                if (!empty($settings['heading'])):

                    $grid_header .= '<h3 class="lvca-heading">' . wp_kses_post($settings['heading']) . '</h3>';

                endif;

                if ($settings['filterable'])
                    $grid_header .= lvca_get_taxonomy_terms_filter($taxonomies, $chosen_terms);

                $grid_header .= '</div>';

                $output .= apply_filters('lvca_posts_grid_header', $grid_header, $settings);

            endif;

            $uniqueid = uniqid();

            $output .= '<div id="lvca-portfolio-' . $uniqueid . '"
                     class="lvca-portfolio js-isotope lvca-' . $settings['layout_mode'] . ' lvca-grid-container ' . lvca_get_grid_classes($settings) . '"
                     data-gutter="' . $settings['gutter'] . '"
                     data-tablet_gutter="' . $settings['tablet_gutter'] . '"
                     data-tablet_width="' . $settings['tablet_width'] . '"
                     data-mobile_gutter="' . $settings['mobile_gutter'] . '"
                     data-mobile_width="' . $settings['mobile_width'] . '"
                     data-isotope-options=\'{ "itemSelector": ".lvca-portfolio-item", "layoutMode": "' . esc_attr($settings['layout_mode']) . '" }\'>';

            while ($loop->have_posts()) : $loop->the_post();

                $post_id = get_the_ID();

                if ($post_id === $current_page)
                    continue; // skip the current page since they can run into infinite loop when users choose All option in build query


                $style = '';

                foreach ($taxonomies as $taxonomy) {

                    $terms = get_the_terms($post_id, $taxonomy);

                    if (!empty($terms) && !is_wp_error($terms)) {

                        foreach ($terms as $term) {
                            $style .= ' term-' . $term->term_id;
                        }
                    }
                }


                $entry_output = '<div data-id="id-' . $post_id . '" class="lvca-grid-item lvca-portfolio-item ' . $style . '">';

                $entry_output .= '<article id="post-' . $post_id . '" class="' . join(' ', get_post_class('', $post_id)) . '">';

                if ($thumbnail_exists = has_post_thumbnail()):

                    $entry_image = '<div class="lvca-project-image">';

                    if ($settings['image_linkable']):

                        $thumbnail_html = '<a href=" ' . get_the_permalink()
                            . '" ' . $target
                            . '>' . get_the_post_thumbnail($post_id, $settings['image_size'])
                            . '</a>';

                    else:

                        $thumbnail_html = get_the_post_thumbnail($post_id, $settings['image_size']);

                    endif;

                    $entry_image .= apply_filters('lvca_posts_grid_thumbnail_html', $thumbnail_html, $post_id, $settings);

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

                        $entry_image .= apply_filters('lvca_posts_grid_image_info', $image_info, $post_id, $settings);

                    endif;

                    $entry_image .= '</div>';

                    $entry_output .= apply_filters('lvca_posts_grid_entry_image', $entry_image, $post_id, $settings);

                endif;

                if ($settings['display_title'] || $settings['display_summary']) :

                    $entry_text = '<div class="lvca-entry-text-wrap ' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                    if ($settings['display_title']) :

                        $entry_title = '<h3 class="entry-title">';

                        $entry_title .= '<a href="' . get_permalink()
                            . '" title="' . get_the_title()
                            . '" ' . $target
                            . '" rel="bookmark">' . get_the_title()
                            . '</a>';

                        $entry_title .= '</h3>';

                        $entry_text .= apply_filters('lvca_posts_grid_entry_title', $entry_title, $post_id, $settings);

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

                        $entry_text .= apply_filters('lvca_posts_grid_entry_meta', $entry_meta, $post_id, $settings);

                    endif;

                    if ($settings['display_summary']) :

                        $excerpt = '<div class="entry-summary">';

                        $excerpt .= get_the_excerpt();

                        $excerpt .= '</div>';

                        $entry_text .= apply_filters('lvca_posts_grid_entry_excerpt', $excerpt, $post_id, $settings);

                    endif;

                    if ($settings['display_read_more']) :

                        $read_more_text = $settings['read_more_text'];

                        $read_more = '<div class="lvca-read-more">';

                        $read_more .= '<a href="' . get_the_permalink() . '"' . $target . '>' . $read_more_text . '</a>';

                        $read_more .= '</div>';

                        $entry_text .= apply_filters('lvca_posts_grid_read_more_link', $read_more, $post_id, $settings);

                    endif;

                    $entry_text .= '</div>';

                    $entry_output .= apply_filters('lvca_posts_grid_entry_text', $entry_text, $post_id, $settings);

                endif;

                $entry_output .= '</article><!-- .hentry -->';

                $entry_output .= '</div>';

                $output .= apply_filters('lvca_posts_grid_entry_output', $entry_output, $post_id, $settings);

            endwhile;

            wp_reset_postdata();

            $output .= '</div><!-- .lvca-portfolio -->';

            $output .= '</div><!-- .lvca-portfolio-wrap -->';

        endif;

        return apply_filters('lvca_posts_grid_output', $output, $settings);
    }


    function map_vc_element() {
        if (function_exists("vc_map")) {

            $general_params = array(

                array(
                    'type' => 'textfield',
                    'param_name' => 'heading',
                    'heading' => __('Heading for the portfolio/blog', 'livemesh-vc-addons'),
                ),

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
                    'description' => __('Create WordPress loop, to populate content from your site. After you build the query, make sure you choose the right taxonomy below to display for your posts and filter on, based on the post type selected during build query.', 'livemesh-vc-addons'),
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
                    'param_name' => 'taxonomy_filter',
                    'heading' => __('Choose the taxonomy to display and filter on.', 'livemesh-vc-addons'),
                    'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no query category/tag/taxonomy filters are specified when building query.', 'livemesh-vc-addons'),
                    'value' => lvca_get_taxonomies_map(),
                    'std' => 'post',
                    'group' => 'Options'
                ),

                array(
                    'type' => 'dropdown',
                    'param_name' => 'image_size',
                    'heading' => __('Image Size', 'livemesh-vc-addons'),
                    'std' => 'large',
                    'value' => lvca_get_image_sizes()
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
                    'heading' => __('Display posts title below the post/portfolio item?', 'livemesh-vc-addons'),
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
                    'heading' => __('Display taxonomy info below the post/portfolio item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_summary',
                    'heading' => __('Display post excerpt/summary below the post/portfolio item?', 'livemesh-vc-addons'),
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

            $display_params = array(

                array(
                    'type' => 'checkbox',
                    'param_name' => 'filterable',
                    'heading' => __('Filterable?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => 'Options'
                ),

                array(
                    'type' => 'dropdown',
                    'param_name' => 'layout_mode',
                    'heading' => __('Choose a layout for the portfolio/blog', 'livemesh-vc-addons'),
                    'value' => array(
                        __('Fit Rows', 'livemesh-vc-addons') => 'fitRows',
                        __('Masonry', 'livemesh-vc-addons') => 'masonry',
                    ),
                    'std' => 'fitRows',
                    'group' => 'Options'
                ),

                array(
                    "type" => "lvca_number",
                    "param_name" => "per_line",
                    "value" => 3,
                    "min" => 1,
                    "max" => 6,
                    "suffix" => '',
                    "heading" => __("Columns per row", "livemesh-vc-addons"),
                    "description" => __("The number of columns to display per row of the posts grid", "livemesh-vc-addons"),
                    'group' => __('Layout', 'livemesh-vc-addons')
                ),

                array(
                    "type" => "lvca_number",
                    "param_name" => "per_line_tablet",
                    "value" => 2,
                    "min" => 1,
                    "max" => 6,
                    "suffix" => '',
                    "heading" => __("Columns per row in Tablet Resolution", "livemesh-vc-addons"),
                    "description" => __("The number of columns to display per row of the posts grid in tablet resolution", "livemesh-vc-addons"),
                    'group' => __('Layout', 'livemesh-vc-addons')
                ),

                array(
                    "type" => "lvca_number",
                    "param_name" => "per_line_mobile",
                    "value" => 1,
                    "min" => 1,
                    "max" => 4,
                    "suffix" => '',
                    "heading" => __("Columns per row in Mobile Resolution", "livemesh-vc-addons"),
                    "description" => __("The number of columns to display per row of the posts grid in mobile resolution", "livemesh-vc-addons"),
                    'group' => __('Layout', 'livemesh-vc-addons')
                ),

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'gutter',
                    'heading' => __('Gutter', 'livemesh-vc-addons'),
                    'description' => __('Space between columns.', 'livemesh-vc-addons'),
                    'value' => 20,
                    'group' => 'Options'
                ),
            );

            $responsive_params = array(

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'tablet_gutter',
                    'heading' => __('Gutter in Tablets', 'livemesh-vc-addons'),
                    'description' => __('Space between columns in tablets.', 'livemesh-vc-addons'),
                    'value' => 10,
                    'group' => 'Responsive'
                ),

                array(
                    'type' => 'textfield',
                    'param_name' => 'tablet_width',
                    'heading' => __('Tablet Resolution', 'livemesh-vc-addons'),
                    'description' => __('The resolution to treat as a tablet resolution.', 'livemesh-vc-addons'),
                    'std' => 800,
                    'sanitize' => 'intval',
                    'group' => 'Responsive'
                ),

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'mobile_gutter',
                    'heading' => __('Gutter in Mobiles', 'livemesh-vc-addons'),
                    'description' => __('Space between columns in mobiles.', 'livemesh-vc-addons'),
                    'value' => 10,
                    'group' => 'Responsive'
                ),

                array(
                    'type' => 'textfield',
                    'param_name' => 'mobile_width',
                    'heading' => __('Mobile Resolution', 'livemesh-vc-addons'),
                    'description' => __('The resolution to treat as a mobile resolution.', 'livemesh-vc-addons'),
                    'std' => 480,
                    'sanitize' => 'intval',
                    'group' => 'Responsive'
                )
            );

            $params = array_merge($general_params, $display_params, $responsive_params);

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Posts Grid", "livemesh-vc-addons"),
                "base" => "lvca_portfolio",
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                'description' => __('Display posts or post types with a filterable grid.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-portfolio',
                "params" => $params
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_portfolio extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Portfolio')) {
    new LVCA_Portfolio();
}