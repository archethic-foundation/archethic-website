<?php
/**
 * Widget: Posts or Revolution slider
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_slider_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_slider_load' );
	function trx_addons_widget_slider_load() {
		register_widget( 'trx_addons_widget_slider' );
	}
}

// Widget Class
class trx_addons_widget_slider extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_slider', 'description' => esc_html__('Display theme slider', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_slider', esc_html__('ThemeREX Slider', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$engine = isset($instance['engine']) ? $instance['engine'] : 'swiper';

		// Before widget (defined by themes)
		trx_addons_show_layout($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title)	trx_addons_show_layout($before_title . $title . $after_title);

		// Widget body
		$html = '';
		if (in_array($engine, array('swiper', 'elastistack'))) {
			$slider_id = isset($instance['id']) ? $instance['id'] : '';
			$slider_style = isset($instance['slider_style']) ? $instance['slider_style'] : 'default';
			$effect = isset($instance['effect']) ? $instance['effect'] : 'slide';
			$slides_per_view = in_array($effect, array('slide', 'coverflow')) && isset($instance['slides_per_view'])
									? $instance['slides_per_view'] 
									: 1;
			$slides_space = isset($instance['slides_space']) ? $instance['slides_space'] : 1;
			$slides = isset($instance['slides']) ? $instance['slides'] : array();
			$slides_type = isset($instance['slides_type']) ? $instance['slides_type'] : 'bg';
			$slides_ratio = isset($instance['slides_ratio']) ? $instance['slides_ratio'] : '16:9';
			$noresize = isset($instance['noresize']) ? (int) $instance['noresize'] : 0;
			$height = isset($instance['height']) ? $instance['height'] : 0;
			$post_type = isset($instance['post_type']) ? $instance['post_type'] : 'post';
			$taxonomy = isset($instance['taxonomy']) ? $instance['taxonomy'] : 'category';
			$category = isset($instance['category']) ? (int) $instance['category'] : 0;
			$posts = isset($instance['posts']) ? $instance['posts'] : 5;
			$interval = isset($instance['interval']) ? max(0, (int) $instance['interval']) : mt_rand(5000, 10000);
			$titles = isset($instance['titles']) ? $instance['titles'] : 'center';
			$large = isset($instance['large']) && $instance['large'] > 0 ? "on" : "off";
			$controls = isset($instance['controls']) && $instance['controls'] > 0 ? "on" : "off";
			$controls_pos = isset($instance['controls_pos']) ? $instance['controls_pos'] : "side";
			$label_prev = isset($instance['label_prev']) ? $instance['label_prev'] : '';
			$label_next = isset($instance['label_next']) ? $instance['label_next'] : '';
			$pagination = isset($instance['pagination']) && $instance['pagination'] > 0 ? "on" : "off";
			$pagination_type = isset($instance['pagination_type']) ? $instance['pagination_type'] : "bullets";
			$pagination_pos = isset($instance['pagination_pos']) ? $instance['pagination_pos'] : "bottom";
			$direction = isset($instance['direction']) && $instance['direction'] == 'vertical' ? "vertical" : "horizontal";
			$count = $ids = $posts;
			if (strpos($ids, ',')!==false) {
				$count = 0;
			} else {
				$ids = '';
				if (empty($count)) $count = count($slides) > 1 ? count($slides) : 3;
			}
			if ($count > 0 || !empty($ids)) {
				$html = trx_addons_get_slider_layout(
							apply_filters('trx_addons_filter_widget_args',
								array(
									'mode' => empty($slides) ? 'posts' : 'custom',
									'engine' => $engine,
									'style' => $slider_style,
									'slides_type' => $slides_type,
									'slides_ratio' => $slides_ratio,
									'noresize' => $noresize,
									'effect' => $effect,
									'controls' => $controls,
									'controls_pos' => $controls_pos,
									'label_prev' => $label_prev,
									'label_next' => $label_next,
									'pagination' => $pagination,
									'pagination_type' => $pagination_type,
									'pagination_pos' => $pagination_pos,
									'direction' => $direction,
									'titles' => $titles,
									'large' => $large,
									'interval' => $interval,
									'height' => $height,
									'per_view' => $slides_per_view,
									'slides_space' => $slides_space,
									'post_type' => $post_type,
									'taxonomy' => $taxonomy,
									'cat' => $category,
									'ids' => $ids,
									'count' => $count,
									'orderby' => "date",
									'order' => "desc",
									'class' => "",	// "slider_height_fixed"
									'id' => $slider_id
									),
								$instance, 'trx_addons_widget_slider'),
							$slides);
			}

        } else if ( $engine == 'revo' ) {
            $alias = isset( $instance['alias'] ) ? $instance['alias'] : '';
            if ( ! empty( $alias ) ) {
                // -- Fix to compatibility with RevSlider 6.5+ (part 1)
                global $rs_loaded_by_editor;
                if ( function_exists( 'trx_addons_elm_is_edit_mode' ) && trx_addons_elm_is_edit_mode() ) {
                    $rs_loaded_by_editor = true;
                }
                // -- End fix (part 1)
                $html = do_shortcode( '[rev_slider alias="' . esc_attr( $alias ) . '"][/rev_slider]' );
                if ( empty( $html ) ) {
                    $html = do_shortcode( '[rev_slider ' . esc_attr($alias) . '][/rev_slider]' );
                }
                // -- Fix to compatibility with RevSlider 6.5+ (part 2)
                if ( ! empty( $html ) ) {
                    $html = sprintf( '<div class="wp-block-themepunch-revslider %2$d">%1$s</div>', $html, $rs_loaded_by_editor );
                }
                if ( function_exists( 'trx_addons_elm_is_edit_mode' ) && trx_addons_elm_is_edit_mode() ) {
                    $rs_loaded_by_editor = false;
                }
                // -- End fix (part 2)
            }
        }
		if (!empty($html)) {
			?>
			<div class="slider_wrap slider_engine_<?php echo esc_attr($engine); ?><?php if ($engine=='revo') echo ' slider_alias_'.esc_attr($alias); ?>">
				<?php trx_addons_show_layout($html); ?>
			</div>
			<?php 
		}

		// After widget (defined by themes)
		trx_addons_show_layout($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['engine'] = strip_tags( $new_instance['engine'] );
		$instance['slider_style'] = strip_tags( $new_instance['slider_style'] );
		$instance['slides_per_view'] = intval( $new_instance['slides_per_view'] );
		$instance['slides_space'] = intval( $new_instance['slides_space'] );
		$instance['effect'] = strip_tags( $new_instance['effect'] );
		$instance['height'] = intval( $new_instance['height'] );
		$instance['post_type'] = strip_tags( $new_instance['post_type'] );
		$instance['taxonomy'] = strip_tags( $new_instance['taxonomy'] );
		$instance['category'] = intval( $new_instance['category'] );
		$instance['posts'] = strip_tags( $new_instance['posts'] );
		$instance['interval'] = intval( $new_instance['interval'] );
		$instance['titles'] = strip_tags( $new_instance['titles'] );
		$instance['large'] = max(0, min(1, intval( $new_instance['large'] )));
		$instance['controls'] = max(0, min(1, intval( $new_instance['controls'] )));
		$instance['pagination'] = max(0, min(1, intval( $new_instance['pagination'] )));
		$instance['direction'] = strip_tags( $new_instance['direction'] );
		if (isset($new_instance['alias']))
			$instance['alias'] = strip_tags( $new_instance['alias'] );
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_slider');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'engine' => 'swiper',
			'slider_style' => 'default',
			'slides_per_view' => '1',
			'slides_space' => '0',
			'effect' => 'slide',
			'height' => '345',
			'alias' => '',
			'titles' => 'center',
			'large' => 0,
			'controls' => 0,
			'pagination' => 0,
			'direction' => 'horizontal',
			'post_type' => 'post',
			'taxonomy' => 'category',
			'category' => '0',
			'posts' => '5',
			'interval' => '7000'
			), 'trx_addons_widget_slider')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_slider');

		// Prepare lists
		$sliders_list = array(
			"swiper" => esc_html__("Posts slider (Swiper)", 'trx_addons')
		);
		if (trx_addons_exists_revslider())
			$sliders_list["revo"] = esc_html__("Layer slider (Revolution)", 'trx_addons');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_slider');
		
		$this->show_field(array('name' => 'engine',
								'title' => __('Slider engine:', 'trx_addons'),
								'value' => $instance['engine'],
								'options' => $sliders_list,
								'type' => 'select'));
		
		$this->show_field(array('name' => 'height',
								'title' => __('Slider height:', 'trx_addons'),
								'value' => $instance['height'],
								'type' => 'text'));

		if ( trx_addons_exists_revslider() && trx_addons_components_is_allowed('api', 'revslider') ) {
			$this->show_field(array('name' => 'alias',
									'title' => __('Revolution Slider alias:', 'trx_addons'),
									'value' => $instance['alias'],
									'options' => trx_addons_get_list_revsliders(),
									'type' => 'select'));
		}

		$this->show_field(array('name' => 'slider_style',
								'title' => __('Swiper style:', 'trx_addons'),
								'value' => $instance['slider_style'],
								'options' => trx_addons_components_get_allowed_layouts('widgets', 'slider'),
								'type' => 'select'));

		$this->show_field(array('name' => 'effect',
								'title' => __('Swiper effect:', 'trx_addons'),
								'value' => $instance['effect'],
								'options' => array(
													'slide' => __('Slide', 'trx_addons'),
													'fade' => __('Fade', 'trx_addons'),
													'cube' => __('Cube', 'trx_addons'),
													'flip' => __('Flip', 'trx_addons'),
													'coverflow' => __('Coverflow', 'trx_addons')
													),
								'type' => 'select'));
		
		$this->show_field(array('name' => 'post_type',
								'title' => __('Post type:', 'trx_addons'),
								'value' => $instance['post_type'],
								'options' => trx_addons_get_list_posts_types(),
								'class' => 'trx_addons_post_type_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'taxonomy',
								'title' => __('Taxonomy:', 'trx_addons'),
								'value' => $instance['taxonomy'],
								'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
								'class' => 'trx_addons_taxonomy_selector',
								'type' => 'select'));
		
		$tax_obj = get_taxonomy($instance['taxonomy']);
		$this->show_field(array('name' => 'category',
								'title' => __('Category:', 'trx_addons'),
								'value' => $instance['category'],
								'options' => trx_addons_array_merge(
													array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
													trx_addons_get_list_terms(false, $instance['taxonomy'], array('pad_counts' => true))
											),
								'class' => 'trx_addons_terms_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'posts',
								'title' => __('Number of posts to show in Swiper:', 'trx_addons'),
								'value' => (int) $instance['posts'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'slides_per_view',
								'title' => __('Slides per view in the Swiper:', 'trx_addons'),
								'value' => (int) $instance['slides_per_view'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'slides_space',
								'title' => __('Space between slides in the Swiper:', 'trx_addons'),
								'value' => (int) $instance['slides_space'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'interval',
								'title' => __('Swiper interval (in msec., 1000=1sec.)', 'trx_addons'),
								'value' => (int) $instance['interval'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'titles',
								'title' => __('Show titles in the Swiper:', 'trx_addons'),
								'value' => $instance['titles'],
								'options' => array(
													'no' => esc_html__('No titles', 'trx_addons'),
													'center' => esc_html__('Center', 'trx_addons'),
													'bottom' => esc_html__('Bottom Center', 'trx_addons'),
													'lb' => esc_html__('Bottom Left', 'trx_addons'),
													'rb' => esc_html__('Bottom Right', 'trx_addons')
													),
								'type' => 'select'));

		$this->show_field(array('name' => 'large',
								'title' => __('Only children of the current category:', 'trx_addons'),
								'value' => (int) $instance['large'],
								'options' => array(
													1 => __('Large', 'trx_addons'),
													0 => __('Small', 'trx_addons')
													),
								'type' => 'switch'));

		$this->show_field(array('name' => 'controls',
								'title' => __('Show arrows:', 'trx_addons'),
								'value' => (int) $instance['controls'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'pagination',
								'title' => __('Show pagination:', 'trx_addons'),
								'value' => (int) $instance['pagination'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'direction',
								'title' => __('Direction:', 'trx_addons'),
								'value' => $instance['direction'],
								'options' => trx_addons_get_list_sc_directions(),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_slider');
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_slider_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_slider_load_scripts_front');
	function trx_addons_widget_slider_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			// Attention! Slider's script will be loaded always, because it used not only in this widget, but in the many CPT, SC, etc.
			wp_enqueue_script( 'trx_addons-widget_slider', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge widget's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_slider_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_slider_merge_styles');
	function trx_addons_widget_slider_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'slider/_slider.scss';
		return $list;
	}
}


// Merge widget's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_slider_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_slider_merge_styles_responsive');
	function trx_addons_widget_slider_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'slider/_slider.responsive.scss';
		return $list;
	}
}

	
// Merge widget's specific scripts into single file
if ( !function_exists( 'trx_addons_widget_slider_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_widget_slider_merge_scripts');
	function trx_addons_widget_slider_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.js';
		return $list;
	}
}



// trx_widget_slider
//-------------------------------------------------------------
/*
[trx_widget_slider id="unique_id" title="Widget title" engine="revo" alias="home_slider_1"]
	[trx_slide title="Slide title" subtitle="Slide subtitle" link="" video_url="URL to video" video_embed="or HTML-code with iframe"]Slide content[/trx_slide]
	...
[/trx_widget_slider]
*/
if ( !function_exists( 'trx_addons_sc_widget_slider' ) ) {
	function trx_addons_sc_widget_slider($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_slider', $atts, array(
			// Individual params
			'title' => '',
			'engine' => 'swiper',
			'slider_style' => 'default',
			'slides_per_view' => '1',
			'slides_space' => '0',
			'slides_type' => 'bg',
			'slides_ratio' => '16:9',
			'noresize' => '0',
			'effect' => 'slide',
			'height' => '',
			'alias' => '',
			'post_type' => 'post',
			'taxonomy' => 'category',
			'category' => '0',
			'posts' => '5',
			'interval' => '7000',
			'titles' => 'center',
			'large' => 0,
			'controls' => 0,
			'controls_pos' => 'side',
			'label_prev' => esc_html__('Prev|PHOTO', 'trx_addons'),				// Label of the 'Prev Slide' button (Modern style)
			'label_next' => esc_html__('Next|PHOTO', 'trx_addons'),				// Label of the 'Next Slide' button (Modern style)
			'pagination' => 0,
			'pagination_type' => 'bullets',
			'pagination_pos' => 'bottom',
			'direction' => 'horizontal',
			'slides' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		global $wp_widget_factory, $TRX_ADDONS_STORAGE;

		if (!is_array($atts['slides']) && function_exists('vc_param_group_parse_atts'))
			$atts['slides'] = (array) vc_param_group_parse_atts( $atts['slides'] );
		if (count($atts['slides']) == 0 || count($atts['slides'][0]) == 0 || (empty($atts['slides'][0]['image']) && empty($atts['slides'][0]['video_url']) && empty($atts['slides'][0]['video_embed']))) {
			$atts['slides'] = $TRX_ADDONS_STORAGE['trx_slide_data'] = array();
			$content = do_shortcode($content);
			if (count($TRX_ADDONS_STORAGE['trx_slide_data']) > 0) {
				$atts['slides'] = $TRX_ADDONS_STORAGE['trx_slide_data'];
			}
		}
		if (empty($atts['id'])) $atts['id'] = 'sc_slider_'.mt_rand();
		$type = 'trx_addons_widget_slider';
		$output = '';
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div id="'.esc_attr($atts['id']).'"'
							. ' class="widget_area sc_widget_slider' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_slider wpb_content_element' : '') 
								. (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') 
								. '"'
							. ($atts['css'] ? ' style="'.esc_attr($atts['css']).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($atts['id'] ? $atts['id'].'_widget' : 'widget_slider', 'widget_slider') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_slider', $atts, $content);
	}
}


// Add [trx_widget_slider] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_slider_add_in_vc')) {
	function trx_addons_sc_widget_slider_add_in_vc() {

		add_shortcode("trx_widget_slider", "trx_addons_sc_widget_slider");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_slider", 'trx_addons_sc_widget_slider_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Slider extends WPBakeryShortCodesContainer {}
	}
	add_action('init', 'trx_addons_sc_widget_slider_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_slider_add_in_vc_params')) {
	function trx_addons_sc_widget_slider_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_widget_slider');
		// Prepare lists
		$post_type = $vc_edit && !empty($vc_params['post_type']) ? $vc_params['post_type'] : 'post';
		$taxonomy = $vc_edit && !empty($vc_params['taxonomy']) ? $vc_params['taxonomy'] : 'category';
		$taxonomies_objects = get_object_taxonomies($post_type, 'objects');
		$taxonomies = array();
		if (is_array($taxonomies_objects)) {
			foreach ($taxonomies_objects as $slug=>$taxonomy_obj) {
				$taxonomies[$slug] = $taxonomy_obj->label;
			}
		}
		$tax_obj = get_taxonomy($taxonomy);

		$sliders_list = array(
			"swiper" => esc_html__("Posts slider (Swiper)", 'trx_addons'),
			"elastistack" => esc_html__("Posts slider (ElastiStack)", 'trx_addons')
		);
		if (trx_addons_exists_revslider()) {
			$sliders_list["revo"] = esc_html__("Layer slider (Revolution)", 'trx_addons');
		}
		
		$params = array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Widget title", 'trx_addons'),
						"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"type" => "textfield"
					),
					array(
						"param_name" => "engine",
						"heading" => esc_html__("Slider engine", 'trx_addons'),
						"description" => wp_kses_data( __("Select engine to show slider", 'trx_addons') ),
						"admin_label" => true,
				        'save_always' => true,
						"value" => array_flip($sliders_list),
						'edit_field_class' => 'vc_col-sm-4',
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_type",
						"heading" => esc_html__("Type of the slides content", 'trx_addons'),
						"description" => wp_kses_data( __("Use images from slides as background (default) or insert it as tag inside each slide", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => "bg",
						"value" => array(
							esc_html__('Background', 'trx_addons') => 'bg',
							esc_html__('Image tag', 'trx_addons') => 'images'
						),
						"type" => "dropdown"
					)
				);
		if ( trx_addons_exists_revslider() && trx_addons_components_is_allowed('api', 'revslider') ) {
			$params[] = array(
						"param_name" => "alias",
						"heading" => esc_html__("RevSlider alias", 'trx_addons'),
						"description" => wp_kses_data( __("Select previously created Revolution slider", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'revo'
						),
						"value" => array_flip(trx_addons_get_list_revsliders()),
				        'save_always' => true,
						"type" => "dropdown"
					);
		}
		$params = array_merge($params,
				array(		
					array(
						"param_name" => "noresize",
						"heading" => esc_html__("No resize slide's content", 'trx_addons'),
						"description" => wp_kses_data( __("Disable resize slide's content, stretch images to cover slide", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => "0",
						"value" => array("No resize slide's content" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "slides_ratio",
						"heading" => esc_html__("Slides ratio", 'trx_addons'),
						"description" => wp_kses_data( __("Ratio to resize slides on tabs and mobile. If empty - 16:9", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'noresize',
							'is_empty' => true
						),
						"std" => "16:9",
						"type" => "textfield"
					),
					array(
						"param_name" => "height",
						"heading" => esc_html__("Slider height", 'trx_addons'),
						"description" => wp_kses_data( __("Initial height of the slider. If empty - calculate from width and aspect ratio", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'noresize',
							'not_empty' => true
						),
						"type" => "textfield"
					),
					array(
						"param_name" => "slider_style",
						"heading" => esc_html__("Swiper style", 'trx_addons'),
						"description" => wp_kses_data( __("Select style of the Swiper slider", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"admin_label" => true,
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => array_flip(trx_addons_components_get_allowed_layouts('widgets', 'slider')),
						"std" => "default",
						"type" => "dropdown"
					),
					array(
						"param_name" => "effect",
						"heading" => esc_html__("Swiper effect", 'trx_addons'),
						"description" => wp_kses_data( __("Select slides effect of the Swiper slider", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => array_flip(trx_addons_get_list_sc_slider_effects()),
						"std" => "slide",
				        'save_always' => true,
						"type" => "dropdown"
					),
					array(
						"param_name" => "direction",
						"heading" => esc_html__("Direction", 'trx_addons'),
						"description" => wp_kses_data( __("Select direction to change slides", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => array_flip(trx_addons_get_list_sc_slider_directions()),
						"std" => "horizontal",
				        'save_always' => true,
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_per_view",
						"heading" => esc_html__("Slides per view in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Specify slides per view in the Swiper", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Space between slides in the Swiper", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Interval between slides in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Specify interval between slides change in the Swiper", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want to show arrows to change slides?", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => "0",
						"value" => array("Show arrows" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "controls_pos",
						"heading" => esc_html__("Controls position", 'trx_addons'),
						"description" => wp_kses_data( __("Select controls position", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'controls',
							'not_empty' => true
						),
						"std" => "side",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_slider_controls('')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "label_prev",
						"heading" => esc_html__("Prev Slide", 'trx_addons'),
						"description" => wp_kses_data( __("Label of the 'Prev Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4 vc_col-sm-offset-4 vc_new_row',
						'dependency' => array(
								'element' => 'controls',
								'not_empty' => true
						),
						"std" => esc_html__('Prev|PHOTO', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "label_next",
						"heading" => esc_html__("Next Slide", 'trx_addons'),
						"description" => wp_kses_data( __("Label of the 'Next Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
								'element' => 'controls',
								'not_empty' => true
						),
						"std" => esc_html__('Next|PHOTO', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "pagination",
						"heading" => esc_html__("Pagination", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want to show bullets to change slides?", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "0",
						"value" => array("Show pagination" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "pagination_type",
						"heading" => esc_html__("Pagination type", 'trx_addons'),
						"description" => wp_kses_data( __("Select type of the pagination", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'pagination',
							'not_empty' => true
						),
						"std" => "bullets",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_slider_paginations_types()),
						"type" => "dropdown"
					),
					array(
						"param_name" => "pagination_pos",
						"heading" => esc_html__("Pagination position", 'trx_addons'),
						"description" => wp_kses_data( __("Select pagination position", 'trx_addons') ),
						"group" => esc_html__('Controls', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'pagination',
							'not_empty' => true
						),
						"std" => "bottom",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_slider_paginations('', true)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "titles",
						"heading" => esc_html__("Titles in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Show post's titles and categories on the slides", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => "center",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_slider_titles()),
						"type" => "dropdown"
					),
					array(
						"param_name" => "large",
						"heading" => esc_html__("Large titles", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want use large titles?", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => "0",
						"value" => array("Large titles" => "1" ),
						"type" => "checkbox"
					),

					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", 'trx_addons'),
						"description" => wp_kses_data( __("Select post type to get featured images from the posts", 'trx_addons') ),
						"group" => esc_html__('Slides', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-3',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => 'post',
						"value" => array_flip(trx_addons_get_list_posts_types()),
						"type" => "dropdown"
					),
					array(
						"param_name" => "taxonomy",
						"heading" => esc_html__("Taxonomy", 'trx_addons'),
						"description" => wp_kses_data( __("Select taxonomy to get featured images from the posts", 'trx_addons') ),
						"group" => esc_html__('Slides', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-3',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => 'category',
						"value" => array_flip($taxonomies),
						"type" => "dropdown"
					),
					array(
						"param_name" => "category",
						"heading" => esc_html__("Category", 'trx_addons'),
						"description" => wp_kses_data( __("Select category to get featured images from the posts", 'trx_addons') ),
						"group" => esc_html__('Slides', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-3',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => 0,
						"value" => array_flip(trx_addons_array_merge(array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
																	 $taxonomy == 'category' 
																	 	? trx_addons_get_list_categories() 
																		: trx_addons_get_list_terms(false, $taxonomy)
																	)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "posts",
						"heading" => esc_html__("Posts number", 'trx_addons'),
						"description" => wp_kses_data( __("Number of posts or comma separated post's IDs to show images", 'trx_addons') ),
						"group" => esc_html__('Slides', 'trx_addons'),
						'edit_field_class' => 'vc_col-sm-3',
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						"std" => "5",
						"type" => "textfield"
					),
					array(
						'param_name' => 'slides',
						'heading' => esc_html__( 'or create custom slides', 'trx_addons' ),
						"description" => wp_kses_data( __("Select icons, specify title and/or description for each item", 'trx_addons') ),
						"group" => esc_html__('Slides', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper', 'elastistack')
						),
						'value' => '',
						'type' => 'param_group',
						'params' => apply_filters('trx_addons_sc_param_group_params', array(
							array(
								'param_name' => 'title',
								'heading' => esc_html__( 'Title', 'trx_addons' ),
								'description' => esc_html__( 'Enter title of this slide', 'trx_addons' ),
								'edit_field_class' => 'vc_col-sm-4',
								'admin_label' => true,
								'type' => 'textfield'
							),
							array(
								'param_name' => 'subtitle',
								'heading' => esc_html__( 'Subtitle', 'trx_addons' ),
								'description' => esc_html__( 'Enter subtitle of this slide', 'trx_addons' ),
								'edit_field_class' => 'vc_col-sm-4',
								'type' => 'textfield'
							),
							array(
								'param_name' => 'link',
								'heading' => esc_html__( 'Link', 'trx_addons' ),
								'description' => esc_html__( 'URL to link of this slide', 'trx_addons' ),
								'edit_field_class' => 'vc_col-sm-4',
								'type' => 'textfield'
							),
							array(
								"param_name" => "image",
								"heading" => esc_html__("Image", 'trx_addons'),
								"description" => wp_kses_data( __("Select or upload image or specify URL from other site", 'trx_addons') ),
								"type" => "attach_image"
							),
							array(
								'param_name' => 'video_url',
								'heading' => esc_html__( 'Video URL', 'trx_addons' ),
								'description' => esc_html__( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
								'edit_field_class' => 'vc_col-sm-6',
								'type' => 'textfield'
							),
							array(
								'param_name' => 'video_embed',
								'heading' => esc_html__( 'Video embed code', 'trx_addons' ),
								'description' => esc_html__( 'or paste the HTML code to embed video in this slide', 'trx_addons' ),
								'edit_field_class' => 'vc_col-sm-6',
								'type' => 'textarea'
							)
						), 'trx_widget_slider')
					)
				),
				trx_addons_vc_add_id_param()
			);
		
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_slider",
				"name" => esc_html__("Slider", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_slider',
				"class" => "trx_widget_slider",
				"content_element" => true,
				'is_container' => true,
				'as_child' => array('except' => 'trx_widget_slider'),
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
				"as_parent" => array('only' => 'trx_slide'),
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_widget_slider' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_slider_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_slider_add_in_elementor' );
	function trx_addons_sc_slider_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Slider extends TRX_Addons_Elementor_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'height' => 'size+unit',
					'slides_per_view' => 'size',
					'slides_space' => 'size',
					'interval' => 'size'
				]);
			}

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_slider';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Slider', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-slideshow';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-elements'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				// If open params in Elementor Editor
				$params = $this->get_sc_params();
				// Prepare lists
				$post_type = !empty($params['post_type']) ? $params['post_type'] : 'post';
				$taxonomy = !empty($params['taxonomy']) ? $params['taxonomy'] : 'category';
				$tax_obj = get_taxonomy($taxonomy);

				$sliders_list = array(
					"swiper" => esc_html__("Posts slider (Swiper)", 'trx_addons'),
					"elastistack" => esc_html__("Posts slider (ElastiStack)", 'trx_addons')
				);
				if (trx_addons_exists_revslider()) {
					$sliders_list["revo"] = esc_html__("Layer slider (Revolution)", 'trx_addons');
				}
				
				$this->start_controls_section(
					'section_sc_slider',
					[
						'label' => __( 'Slider', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget title", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'engine',
					[
						'label' => __( 'Slider engine', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $sliders_list,
						'default' => 'swiper'
					]
				);

				$this->add_control(
					'slides_type',
					[
						'label' => __( 'Type of the slides content', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Use images from slides as background (default) or insert it as tag inside each slide", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'bg' => esc_html__('Background', 'trx_addons'),
							'images' => esc_html__('Image tag', 'trx_addons')
						),
						'default' => 'bg',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);
				
				if (trx_addons_exists_revslider()) {
					$this->add_control(
						'alias',
						[
							'label' => __( 'RevSlider alias', 'trx_addons' ),
							'label_block' => false,
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => trx_addons_get_list_revsliders(),
							'default' => '',
							'condition' => [
								'engine' => 'revo'
							]
						]
					);
				}

				$this->add_control(
					'noresize',
					[
						'label' => __( "No resize slide's content", 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Disable resize slide's content, stretch images to cover slide", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);
				
				$this->add_control(
					'slides_ratio',
					[
						'label' => __( 'Slides ratio', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Address", 'trx_addons' ),
						'default' => '16:9',
						'condition' => [
							'noresize' => '1'
						]
					]
				);

				$this->add_control(
					'height',
					[
						'label' => __( 'Slider height', 'trx_addons' ),
						'description' => wp_kses_data( __("Initial height of the slider. If empty - calculate from width and aspect ratio", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 350,
							'unit' => 'px'
						],
						'range' => [
							'px' => [
								'min' => 50,
								'max' => 1000
							],
							'em' => [
								'min' => 2,
								'max' => 100
							],
						],
						'size_units' => [ 'px', 'em' ],
						'condition' => [
							'noresize' => '1'
						]
					]
				);

				$this->add_control(
					'slider_style',
					[
						'label' => __( 'Swiper style', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_components_get_allowed_layouts('widgets', 'slider'),
						'default' => 'default',
						'condition' => [
							'engine' => 'swiper'
						]
					]
				);

				$this->add_control(
					'effect',
					[
						'label' => __( 'Swiper effect', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_effects(),
						'default' => 'slide',
						'condition' => [
							'engine' => 'swiper'
						]
					]
				);

				$this->add_control(
					'direction',
					[
						'label' => __( 'Slides change direction', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_directions(),
						'default' => 'horizontal',
						'condition' => [
							'engine' => 'swiper'
						]
					]
				);

				$this->add_control(
					'slides_per_view',
					[
						'label' => __( 'Slides per view', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 1
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 10
							],
						],
						'condition' => [
							'engine' => 'swiper'
						]
					]
				);

				$this->add_control(
					'slides_space',
					[
						'label' => __( 'Space between slides', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100
							],
						],
						'condition' => [
							'engine' => 'swiper'
						]
					]
				);

				$this->add_control(
					'interval',
					[
						'label' => __( 'Interval between slides change', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 7000
						],
						'range' => [
							'px' => [
								'min' => 500,
								'max' => 10000,
								'step' => 100
							],
						],
						'condition' => [
							'engine' => 'swiper'
						]
					]
				);
				
				$this->add_control(
					'slider_id',
					[
						'label' => __( 'Slider ID', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data(__('Specify ID if you want control this slider from Slider Controller or Slider Controls', 'trx_addons')),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Slider ID", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_slider_controls',
					[
						'label' => __( 'Controls', 'trx_addons' ),
						'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
					]
				);

				$this->add_control(
					'controls',
					[
						'label' => __( 'Controls', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'controls_pos',
					[
						'label' => __( 'Controls position', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_controls(''),
						'default' => 'side',
						'condition' => [
							'controls' => '1'
						]
					]
				);

				$this->add_control(
					'label_prev',
					[
						'label' => __( 'Prev Slide', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Label of the 'Prev Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Prev Slide", 'trx_addons' ),
						'default' => esc_html__('Prev|PHOTO', 'trx_addons'),
						'condition' => [
							'controls' => '1',
							'slider_style' => 'modern'
						]
					]
				);

				$this->add_control(
					'label_next',
					[
						'label' => __( 'Next Slide', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Label of the 'Next Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Next Slide", 'trx_addons' ),
						'default' => esc_html__('Next|PHOTO', 'trx_addons'),
						'condition' => [
							'controls' => '1',
							'slider_style' => 'modern'
						]
					]
				);

				$this->add_control(
					'pagination',
					[
						'label' => __( 'Pagination', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'pagination_type',
					[
						'label' => __( 'Pagination type', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_paginations_types(),
						'default' => 'bullets',
						'condition' => [
							'pagination' => '1'
						]
					]
				);

				$this->add_control(
					'pagination_pos',
					[
						'label' => __( 'Pagination position', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_paginations(),
						'default' => 'bottom',
						'condition' => [
							'pagination' => '1'
						]
					]
				);

				$this->end_controls_section();
				
				$this->start_controls_section(
					'section_sc_slider_slides',
					[
						'label' => __( 'Slides', 'trx_addons' ),
						'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
					]
				);

				$this->add_control(
					'titles',
					[
						'label' => __( 'Titles in the slides', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Show post's titles and categories on the slides", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_titles(),
						'default' => 'center',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'large',
					[
						'label' => __( 'Large titles', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'post_type',
					[
						'label' => __( 'Post type', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_posts_types(),
						'default' => 'post',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'taxonomy',
					[
						'label' => __( 'Taxonomy', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_taxonomies(false, $post_type),
						'default' => 'category',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'category',
					[
						'label' => __( 'Category', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
																		 $taxonomy == 'category' 
																			? trx_addons_get_list_categories() 
																			: trx_addons_get_list_terms(false, $taxonomy)
																		),
						'default' => '0',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);

				$this->add_control(
					'posts',
					[
						'label' => __( 'Posts number', 'trx_addons' ),
						'description' => wp_kses_data( __("Number of posts or comma separated post's IDs to show images", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '5',
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						]
					]
				);
				
				$this->add_control(
					'slides',
					[
						'label' => esc_html__( 'or create custom slides', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::REPEATER,
						'condition' => [
							'engine' => ['swiper', 'elastistack']
						],
						'fields' => apply_filters('trx_addons_sc_param_group_params',
							[
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Slide's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'subtitle',
									'label' => __( 'Subtitle', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Slide's subtitle", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'link',
									'label' => __( 'Link', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::URL,
									'placeholder' => __( 'http://your-link.com', 'trx_addons' ),
								],
								[
									'name' => 'image',
									'label' => __( 'Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								],
								[
									'name' => 'video_url',
									'label' => __( 'Video URL', 'trx_addons' ),
									'label_block' => false,
									'description' => __( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::TEXT,
									'default' => '',
								],
								[
									'name' => 'video_embed',
									'label' => __( 'Video embed code', 'trx_addons' ),
									'label_block' => true,
									'description' => __( 'or paste the HTML code to embed video in this slide', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::TEXTAREA,
									'rows' => 10,
									'separator' => 'none',
									'default' => '',
								]
							],
							'trx_widget_slider'),
						'title_field' => '{{{ title }}}',
					]
				);
				
				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Slider() );
	}
}



// trx_slide
//-------------------------------------------------------------
/*
[trx_slide title="Slide title" subtitle="Slide subtitle" link="" video_url="URL to video" video_embed="or HTML-code with iframe"]Slide content[/trx_slide]
*/
if ( !function_exists( 'trx_addons_sc_slide' ) ) {
	function trx_addons_sc_slide($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_slide', $atts, array(
			// Individual params
			'title' => '',
			'subtitle' => '',
			'link' => '',
			'image' => '',
			'video_url' => '',
			'video_embed' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		global $TRX_ADDONS_STORAGE;
		
		$atts['content'] = do_shortcode($content);
		$TRX_ADDONS_STORAGE['trx_slide_data'][] = $atts;

		return '';
	}
}


// Add [trx_slide] in the VC shortcodes list
if (!function_exists('trx_addons_sc_slide_add_in_vc')) {
	function trx_addons_sc_slide_add_in_vc() {

		add_shortcode("trx_slide", "trx_addons_sc_slide");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_slide", 'trx_addons_sc_slide_add_in_vc_params');
		class WPBakeryShortCode_Trx_Slide extends WPBakeryShortCodesContainer {}
	}
	add_action('init', 'trx_addons_sc_slide_add_in_vc', 20);
}


// Return params
if (!function_exists('trx_addons_sc_slide_add_in_vc_params')) {
	function trx_addons_sc_slide_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_slide",
				"name" => esc_html__("Custom Slide", 'trx_addons'),
				"description" => wp_kses_data( __("Insert the custom slide in the slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_slide',
				"class" => "trx_slide",
				"content_element" => true,
				'is_container' => true,
				"js_view" => 'VcTrxAddonsContainerView',	//'VcColumnView',
				"as_child" => array('only' => 'trx_widget_slider'),
				"as_parent" => array('except' => 'trx_widget_slider,trx_slide'),
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							'param_name' => 'title',
							'heading' => esc_html__( 'Title', 'trx_addons' ),
							'description' => esc_html__( 'Enter title of this slide', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'admin_label' => true,
							'type' => 'textfield'
						),
						array(
							'param_name' => 'subtitle',
							'heading' => esc_html__( 'Subtitle', 'trx_addons' ),
							'description' => esc_html__( 'Enter subtitle of this slide', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'type' => 'textfield'
						),
						array(
							'param_name' => 'link',
							'heading' => esc_html__( 'Link', 'trx_addons' ),
							'description' => esc_html__( 'URL to link of this slide', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'type' => 'textfield'
						),
						array(
							"param_name" => "image",
							"heading" => esc_html__("Image", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload image or specify URL from other site", 'trx_addons') ),
							"type" => "attach_image"
						),
						array(
							'param_name' => 'video_url',
							'heading' => esc_html__( 'Video URL', 'trx_addons' ),
							'description' => esc_html__( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'type' => 'textfield'
						),
						array(
							'param_name' => 'video_embed',
							'heading' => esc_html__( 'Video embed code', 'trx_addons' ),
							'description' => esc_html__( 'or paste the HTML code to embed video in this slide', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-8',
							'type' => 'textarea'
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_slide' );
	}
}


// trx_slider_controller
//-------------------------------------------------------------
/*
[trx_slider_controller id="unique_id" slider_id="controller_slider_id"]
*/
if ( !function_exists( 'trx_addons_sc_slider_controller' ) ) {
	function trx_addons_sc_slider_controller($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_slider_controller', $atts, array(
			// Individual params
			'controller_style' => 'thumbs',
			'slider_id' => '',
			'slides_per_view' => '3',
			'slides_space' => '0',
			'effect' => 'slide',
			'direction' => 'horizontal',
			'height' => '',
			'interval' => '7000',
			'controls' => 0,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		
		$output = '';
		if (!empty($atts['slider_id'])) {
			if (empty($atts['height']) && $atts['direction']!='vertical') $atts['height']=100;
	
			$output = '<div' . ($atts['id'] ? ' id="'.esc_attr($atts['id']).'"' : '')
							. ' class="sc_slider_controller'
								. ' sc_slider_controller_'.esc_attr($atts['controller_style']) 
								. ' sc_slider_controller_'.esc_attr($atts['direction']) 
								. ' sc_slider_controller_height_' . ((int)$atts['height']>0 ? 'fixed' : 'auto')
								. (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') 
								. '"'
							. ' data-slider-id="'.esc_attr($atts['slider_id']).'"'
							. ' data-style="'.esc_attr($atts['controller_style']).'"'
							. ' data-controls="' . esc_attr($atts['controls']>0 ? 1 : 0) . '"'
							. ' data-interval="'.esc_attr($atts['interval']).'"'
							. ' data-effect="'.esc_attr($atts['effect']).'"'
							. ' data-direction="'.esc_attr($atts['direction']=='vertical' ? 'vertical' : 'horizontal').'"'
							. ' data-slides-per-view="'.esc_attr($atts['slides_per_view']).'"'
							. ' data-slides-space="'.esc_attr($atts['slides_space']).'"'
							. ((int)$atts['height']>0 ? ' data-height="'.esc_attr(trx_addons_prepare_css_value($atts['height'])).'"' : '')
							. ($atts['css'] ? ' style="'.esc_attr($atts['css']).'"' : '')
						. '>'
						. '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_slider_controller', $atts, $content);
	}
}


// Add [trx_slider_controller] in the VC shortcodes list
if (!function_exists('trx_addons_sc_slider_controller_add_in_vc')) {
	function trx_addons_sc_slider_controller_add_in_vc() {

		add_shortcode("trx_slider_controller", "trx_addons_sc_slider_controller");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_slider_controller", 'trx_addons_sc_slider_controller_add_in_vc_params');
		class WPBakeryShortCode_Trx_Slider_Controller extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_slider_controller_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_slider_controller_add_in_vc_params')) {
	function trx_addons_sc_slider_controller_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_slider_controller",
				"name" => esc_html__("Slider Controller", 'trx_addons'),
				"description" => wp_kses_data( __("Insert controller for the specified slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_slider_controller',
				"class" => "trx_slider_controller",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "slider_id",
							"heading" => esc_html__("Slave slider ID", 'trx_addons'),
							"description" => wp_kses_data( __("ID of the slave slider", 'trx_addons') ),
							'admin_label' => true,
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "textfield"
						),
						array(
							"param_name" => "height",
							"heading" => esc_html__("Controller height", 'trx_addons'),
							"description" => wp_kses_data( __("Controller height", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "textfield"
						),
						array(
							"param_name" => "controls",
							"heading" => esc_html__("Controls", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want to show arrows to change slides?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "0",
							"value" => array("Show arrows" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "controller_style",
							"heading" => esc_html__("Style", 'trx_addons'),
							"description" => wp_kses_data( __("Select style of the Controller", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							'admin_label' => true,
					        'save_always' => true,
							"value" => array(
										esc_html__('Thumbs', 'trx_addons') => 'thumbs',
										esc_html__('Titles', 'trx_addons') => 'titles'
										),
							"std" => "thumbs",
							"type" => "dropdown"
						),
						array(
							"param_name" => "effect",
							"heading" => esc_html__("Effect", 'trx_addons'),
							"description" => wp_kses_data( __("Select slides effect of the Controller", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"value" => array_flip(trx_addons_get_list_sc_slider_effects()),
							"std" => "slide",
							"type" => "dropdown"
						),
						array(
							"param_name" => "direction",
							"heading" => esc_html__("Direction", 'trx_addons'),
							"description" => wp_kses_data( __("Select direction to change slides", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => 'horizontal',
							"value" => array_flip(trx_addons_get_list_sc_slider_directions()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "slides_per_view",
							"heading" => esc_html__("Slides per view", 'trx_addons'),
							"description" => wp_kses_data( __("Specify slides per view in the Controller", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "1",
							"type" => "textfield"
						),
						array(
							"param_name" => "slides_space",
							"heading" => esc_html__("Space between slides", 'trx_addons'),
							"description" => wp_kses_data( __("Space between slides in the Controller", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "0",
							"type" => "textfield"
						),
						array(
							"param_name" => "interval",
							"heading" => esc_html__("Interval between slides", 'trx_addons'),
							"description" => wp_kses_data( __("Specify interval between slides change in the Controller", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "7000",
							"type" => "textfield"
						),
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_slider_controller' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_slider_controller_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_slider_controller_add_in_elementor' );
	function trx_addons_sc_slider_controller_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Slider_Controller extends TRX_Addons_Elementor_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'height' => 'size+unit',
					'slides_per_view' => 'size',
					'slides_space' => 'size',
					'interval' => 'size'
				]);
			}

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_slider_controller';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Slider Controller', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-slider-device';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-elements'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				
				$this->start_controls_section(
					'section_sc_slider_controller',
					[
						'label' => __( 'Slider Controller', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'slider_id',
					[
						'label' => __( 'Slave slider ID', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Controlled ID", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'height',
					[
						'label' => __( 'Controller height', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 50,
							'unit' => 'px'
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 300
							],
							'em' => [
								'min' => 0,
								'max' => 20
							]
						],
						'size_units' => ['px', 'em']
					]
				);

				$this->add_control(
					'controls',
					[
						'label' => __( 'Controls', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'controller_style',
					[
						'label' => __( 'Style', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'thumbs' => esc_html__('Thumbs', 'trx_addons'),
							'titles' => esc_html__('Titles', 'trx_addons')
						),
						'default' => 'thumbs'
					]
				);

				$this->add_control(
					'effect',
					[
						'label' => __( 'Swiper effect', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_effects(),
						'default' => 'slide'
					]
				);

				$this->add_control(
					'direction',
					[
						'label' => __( 'Slides change direction', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_slider_directions(),
						'default' => 'horizontal'
					]
				);

				$this->add_control(
					'slides_per_view',
					[
						'label' => __( 'Slides per view', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 3
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 10
							],
						]
					]
				);

				$this->add_control(
					'slides_space',
					[
						'label' => __( 'Space between slides', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100
							],
						]
					]
				);

				$this->add_control(
					'interval',
					[
						'label' => __( 'Interval between slides change', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 7000
						],
						'range' => [
							'px' => [
								'min' => 500,
								'max' => 10000,
								'step' => 100
							],
						]
					]
				);
				
				$this->end_controls_section();
			}

			/**
			 * Render widget's template for the editor.
			 *
			 * Written as a Backbone JavaScript template and used to generate the live preview.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _content_template() {
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "slider/tpe.slider_controller.php",
										'trx_addons_args_widget_slider_controller',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Slider_Controller() );
	}
}


// trx_slider_controls
//-------------------------------------------------------------
/*
[trx_slider_controls id="unique_id" slider_id="controller_slider_id"]
*/
if ( !function_exists( 'trx_addons_sc_slider_controls' ) ) {
	function trx_addons_sc_slider_controls($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_slider_controls', $atts, array(
			// Individual params
			'slider_id' => '',
			'controls_style' => 'default',
			'align' => 'left',
			'hide_prev' => 0,
			'title_prev' => '',
			'hide_next' => 0,
			'title_next' => '',
			'show_progress' => 0,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		
		$output = '';
		if (!empty($atts['slider_id'])) {
			$output = '<div' . ($atts['id'] ? ' id="'.esc_attr($atts['id']).'"' : '')
							. ' class="sc_slider_controls sc_slider_controls_'.esc_attr($atts['controls_style'])
								. (!empty($atts['align']) ? ' sc_align_' . esc_attr($atts['align']) : '') 
								. (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') 
								. '"'
							. ' data-slider-id="'.esc_attr($atts['slider_id']).'"'
							. ' data-style="'.esc_attr($atts['controls_style']).'"'
							. ($atts['css'] ? ' style="'.esc_attr($atts['css']).'"' : '')
						. '>'
							. '<div class="slider_controls_wrap'
								. (empty($atts['hide_prev']) ? ' with_prev' : '')
								. (empty($atts['hide_next']) ? ' with_next' : '')
								. ($atts['show_progress'] ? ' with_progress' : '')
							.'">'
								. (empty($atts['hide_prev']) 
									? '<a class="slider_prev swiper-button-prev'.(!empty($atts['title_prev']) ? ' with_title' : '').'" href="#">'
										. (!empty($atts['title_prev']) ? esc_html($atts['title_prev']) : '')
										. '</a>' 
									: ''
									)
								. (empty($atts['hide_next']) 
									? '<a class="slider_next swiper-button-next'.(!empty($atts['title_next']) ? ' with_title' : '').'" href="#">'
										. (!empty($atts['title_next']) ? esc_html($atts['title_next']) : '')
										. '</a>' 
									: ''
									)
								. ($atts['show_progress']
									? '<span class="slider_progress"><span class="slider_progress_bar"></span></span>' 
									: ''
									)
							. '</div>'
						. '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_slider_controls', $atts, $content);
	}
}

// Add [trx_slider_controls] in the VC shortcodes list
if (!function_exists('trx_addons_sc_slider_controls_add_in_vc')) {
	function trx_addons_sc_slider_controls_add_in_vc() {

		add_shortcode("trx_slider_controls", "trx_addons_sc_slider_controls");

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_slider_controls", 'trx_addons_sc_slider_controls_add_in_vc_params');
		class WPBakeryShortCode_Trx_Slider_Controls extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_slider_controls_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_slider_controls_add_in_vc_params')) {
	function trx_addons_sc_slider_controls_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_slider_controls",
				"name" => esc_html__("Slider Controls", 'trx_addons'),
				"description" => wp_kses_data( __("Insert separate arrows for the specified slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_slider_controls',
				"class" => "trx_slider_controls",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "slider_id",
							"heading" => esc_html__("Slave slider ID", 'trx_addons'),
							"description" => wp_kses_data( __("ID of the slave slider", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							'admin_label' => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "controls_style",
							"heading" => esc_html__("Style", 'trx_addons'),
							"description" => wp_kses_data( __("Select style of the arrows", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"value" => array(
										esc_html__('Default', 'trx_addons') => 'default'
										),
							"std" => "default",
							"type" => "dropdown"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment of the arrows", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"value" => array_flip(trx_addons_get_list_sc_aligns(false, false)),
							"std" => "left",
					        'save_always' => true,
							"type" => "dropdown"
						),
						array(
							"param_name" => "hide_prev",
							"heading" => esc_html__("Hide button 'Prev'", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want to hide arrow 'Prev'?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "0",
							"value" => array("Hide 'Prev'" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "title_prev",
							"heading" => esc_html__("Title for button 'Prev'", 'trx_addons'),
							"description" => wp_kses_data( __("Specify title of the button 'Prev'. If empty - display arrow", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-8',
							'dependency' => array(
								'element' => 'hide_prev',
								'is_empty' => true
							),
							"std" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "hide_next",
							"heading" => esc_html__("Hide button 'Next'", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want to hide arrow 'Next'?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "0",
							"value" => array("Hide 'Next'" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "title_next",
							"heading" => esc_html__("Title for button 'Next'", 'trx_addons'),
							"description" => wp_kses_data( __("Specify title of the button 'Next'. If empty - display arrow", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-8',
							'dependency' => array(
								'element' => 'hide_next',
								'is_empty' => true
							),
							"std" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "show_progress",
							"heading" => esc_html__("Show progress bar", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want to show progress bar of specified slider?", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4 vc_new_row',
							"std" => "0",
							"value" => array("Show progress bar" => "1" ),
							"type" => "checkbox"
						),
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_slider_controls' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_slider_controls_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_slider_controls_add_in_elementor' );
	function trx_addons_sc_slider_controls_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Slider_Controls extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_slider_controls';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Slider Controls', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-post-navigation';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-elements'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				
				$this->start_controls_section(
					'section_sc_slider_controls',
					[
						'label' => __( 'Slider Controls', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'slider_id',
					[
						'label' => __( 'Slave slider ID', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Controlled ID", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'controls_style',
					[
						'label' => __( 'Style', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => array(
							'default' => esc_html__('Default', 'trx_addons')
						),
						'default' => 'default'
					]
				);

				$this->add_control(
					'align',
					[
						'label' => __( 'Alignment', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(false, false),
						'default' => 'left'
					]
				);

				$this->add_control(
					'hide_prev',
					[
						'label' => __( "Hide button 'Prev'", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'title_prev',
					[
						'label' => __( "Title for button 'Prev'", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Prev", 'trx_addons' ),
						'default' => '',
						'condition' => [
							'hide_prev' => ''
						]
					]
				);

				$this->add_control(
					'hide_next',
					[
						'label' => __( "Hide button 'Next'", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'title_next',
					[
						'label' => __( "Title for button 'Next'", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Next", 'trx_addons' ),
						'default' => '',
						'condition' => [
							'hide_next' => ''
						]
					]
				);

				$this->add_control(
					'show_progress',
					[
						'label' => __( "Show progress bar", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);
				
				$this->end_controls_section();
			}

			/**
			 * Render widget output in the editor.
			 *
			 * Written as a Backbone JavaScript template and used to generate the live preview.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _content_template() {
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "slider/tpe.slider_controls.php",
										'trx_addons_args_widget_slider_controls',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Slider_Controls() );
	}
}
?>