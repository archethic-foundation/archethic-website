<?php
/**
 * Media utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Set quality to save cropped images
if (!function_exists('trx_addons_set_images_quality')) {
	add_filter( 'wp_editor_set_quality', 'trx_addons_set_images_quality', 10, 2 );
	function trx_addons_set_images_quality($defa=90, $mime='') {
		$q = (int) trx_addons_get_option('images_quality');
		if ($q == 0) $q = 90;
		return max(1, min(100, $q));
	}
}

// Allow upload SVG images
if (!function_exists('trx_addons_allow_upload_svg')) {
	add_filter('upload_mimes', 'trx_addons_allow_upload_svg');
	function trx_addons_allow_upload_svg($mime_types) {
        global $TRX_ADDONS_STORAGE;
        if ( !empty( $TRX_ADDONS_STORAGE['settings']['allow_upload_svg'])) $mime_types['svg'] = 'image/svg+xml';
		return $mime_types;
	}
}

// Check if image in the uploads folder
if (!function_exists('trx_addons_is_from_uploads')) {
	function trx_addons_is_from_uploads($url) {
		$local = false;
		$url = trx_addons_remove_protocol($url);
		$uploads_info = wp_upload_dir();
		$uploads_url = trx_addons_remove_protocol($uploads_info['baseurl']);
		$uploads_dir = $uploads_info['basedir'];
		return $local = strpos($url, $uploads_url)!==false && file_exists(str_replace($uploads_url, $uploads_dir, $url));
	}
}

// Get image sizes from image url (if image in the uploads folder)
if (!function_exists('trx_addons_getimagesize')) {
	function trx_addons_getimagesize($url, $echo=false) {
		// Remove scheme from url
		$url = trx_addons_remove_protocol($url);
	
		// Get upload path & dir
		$upload_info = wp_upload_dir();

		// Where check file
		$locations = array(
			'uploads' => array(
				'dir' => $upload_info['basedir'],
				'url' => trx_addons_remove_protocol($upload_info['baseurl'])
				),
			'child' => array(
				'dir' => get_stylesheet_directory(),
				'url' => trx_addons_remove_protocol(get_stylesheet_directory_uri())
				),
			'theme' => array(
				'dir' => get_template_directory(),
				'url' => trx_addons_remove_protocol(get_template_directory_uri())
				)
			);
		
		$img_size = false;
		
		foreach($locations as $key=>$loc) {
			// Check if $img_url is local.
			if ( false === strpos($url, $loc['url']) ) continue;
			
			// Get path of image.
			$img_path = str_replace($loc['url'], $loc['dir'], $url);
		
			// Check if img path exists, and is an image indeed.
			if ( !file_exists($img_path)) continue;
	
			// Get image size
			$img_size = getimagesize($img_path);
			break;
		}
		
		if ($echo && $img_size!==false && !empty($img_size[3])) {
			echo ' '.trim($img_size[3]);
		}
		
		return $img_size;
	}
}

// Return image size name with @retina modifier (if need)
if (!function_exists('trx_addons_get_thumb_size')) {
	function trx_addons_get_thumb_size($ts) {
		$retina = trx_addons_get_retina_multiplier() > 1 ? '-@retina' : '';
		return apply_filters('trx_addons_filter_get_thumb_size', ($ts=='post-thumbnail' || strpos($ts, 'trx_addons-thumb-')===0 ? '' : 'trx_addons-thumb-') . $ts . $retina);
	}
}

// Clear thumb sizes from image name
if (!function_exists('trx_addons_clear_thumb_size')) {
	function trx_addons_clear_thumb_size($url) {
		$pi = pathinfo($url);
		$pi['dirname'] = trx_addons_remove_protocol($pi['dirname']);
		$parts = explode('-', $pi['filename']);
		$suff = explode('x', $parts[count($parts)-1]);
		if (count($suff)==2 && (int) $suff[0] > 0 && (int) $suff[1] > 0) {
			array_pop($parts);
			$url = $pi['dirname'] . '/' . join('-', $parts) . '.' . $pi['extension'];
		}
		return $url;
	}
}

// Add thumb sizes to image name
if (!function_exists('trx_addons_add_thumb_size')) {
	function trx_addons_add_thumb_size($url, $thumb_size, $check_exists=true) {
		
		if (empty($url)) return '';

		$pi = pathinfo($url);
		$pi['dirname'] = trx_addons_remove_protocol($pi['dirname']);

		// Remove image sizes from filename
		$parts = explode('-', $pi['filename']);
		$suff = explode('x', $parts[count($parts)-1]);
		if (count($suff)==2 && (int) $suff[0] > 0 && (int) $suff[1] > 0) {
			array_pop($parts);
		}
		$url = $pi['dirname'] . '/' . join('-', $parts) . '.' . $pi['extension'];

		// Add new image sizes
		global $_wp_additional_image_sizes;
		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) && in_array( $thumb_size, array_keys( $_wp_additional_image_sizes ) ) )
			$parts[] = intval( $_wp_additional_image_sizes[$thumb_size]['width'] ) . 'x' . intval( $_wp_additional_image_sizes[$thumb_size]['height'] );
		$pi['filename'] = join('-', $parts);
		$new_url = $pi['dirname'] . '/' . $pi['filename'] . '.' . $pi['extension'];

		// Check exists
		if ($check_exists) {
			$uploads_info = wp_upload_dir();
			$uploads_url = trx_addons_remove_protocol($uploads_info['baseurl']);
			$uploads_dir = $uploads_info['basedir'];
			if (strpos($new_url, $uploads_url)!==false) {
				if (!file_exists(str_replace($uploads_url, $uploads_dir, $new_url)))
					$new_url = $url;
			} else {
				$new_url = $url;
			}
		}
		return $new_url;
	}
}

// Return thumb dimensions by thumb size name
if (!function_exists('trx_addons_get_thumb_dimensions')) {
	function trx_addons_get_thumb_dimensions($thumb_size) {
		$dim = array('width' => 0, 'height' => 0);
		global $_wp_additional_image_sizes;
		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) && in_array( $thumb_size, array_keys( $_wp_additional_image_sizes ) ) ) {
			$dim['width']  = intval( $_wp_additional_image_sizes[$thumb_size]['width'] );
			$dim['height'] = intval( $_wp_additional_image_sizes[$thumb_size]['height'] );
		}
		return $dim;
	}
}

// Return image size multiplier
if (!function_exists('trx_addons_get_retina_multiplier')) {
	function trx_addons_get_retina_multiplier($force_retina=0) {
		$mult = min(4, max(1, $force_retina > 0 ? $force_retina : trx_addons_get_option("retina_ready")));
		if ($mult > 1 && (int) trx_addons_get_value_gpc('trx_addons_is_retina', 0) == 0)
			$mult = 1;
		return $mult;
	}
}

// Return 'no-image'
if (!function_exists('trx_addons_get_no_image')) {
	function trx_addons_get_no_image($img='css/images/no-image.jpg') {
		return apply_filters('trx_addons_filter_no_image', trx_addons_get_file_url($img));
	}
}


// Return slider layout
if (!function_exists('trx_addons_get_slider_layout')) {
	function trx_addons_get_slider_layout($args=array(), $images=array()) {
		$args = apply_filters('trx_addons_filter_slider_args', array_merge(array(
			'engine' => 'swiper',			// swiper | elastistack - slider's engine
			'style' => 'default',			// default | modern - style of the slider Swiper
			'mode' => 'gallery',			// gallery | posts | custom - fromwhere get images for slider - from current post's gallery or from featured images or from custom array with images
			'effect' => 'slide',			// slide | fade | cube | coverflow | flip - change slides effect
			'direction' => 'horizontal',	// horizontal | vertical - direction of slides change
			'slides_type' => 'bg',			// images|bg - Use image as slide's content or as slide's background
			'slides_ratio' => '16:9',		// Ratio to resize slides on the tabs and mobile
			'noresize' => 0,				// Disable autoresize slider
			'controls' => 'yes',			// Show Prev/Next arrows
			'controls_pos' => 'side',		// side | bottom - position of the slider controls
			'label_prev' => esc_html__('Prev|PHOTO', 'trx_addons'),				// Label of the 'Prev Slide' button (Modern style)
			'label_next' => esc_html__('Next|PHOTO', 'trx_addons'),				// Label of the 'Next Slide' button (Modern style)
			'pagination' => 'no',			// Show pagination bullets
			'pagination_type' => 'bullets',	// bullets | fraction | progress - type of the pagination
			'pagination_pos' => 'bottom',	// bottom | bottom_outside | left | right - position of the pagination
			'titles' => 'no',				// no | center | bottom | lb | rb | outside - where put post's title on slide
			'large' => 'no',				// Show large title on the slides
			'interval' => '',				// Slides change interval
			'per_view' => 1,				// Slides per view
			'slides_space' => 0,			// Space between slides
			'height' => '',					// Slides height (if empty - auto)
			'thumb_size' => '',				// Size of images (if empty - big)
			'post_type' => 'post',			// Post type to get posts
			'taxonomy' => 'category',		// Taxonomy to get posts
			'cat' => '',					// Category to get posts
			'ids' => '',					// Comma separated posts IDs
			'count' => 5,					// Posts number to show in slider
			'orderby' => 'date',			// Posts order by
			'order' => 'desc',				// Posts order
			'class' => '',					// Additional classes for slider container
			'id' => ''						// ID of the slider container
			), $args));

		if ($args['engine']=='swiper') {
			if ($args['pagination_type']=='progress') {
				if ($args['direction']=='vertical' && !in_array($args['pagination_pos'], array('left', 'right')))
					$args['pagination_pos'] = 'left';
				if ($args['direction']=='horizontal' && $args['pagination_pos']!='bottom')
					$args['pagination_pos'] = 'bottom';
			}
			$args['per_view'] = empty($args['per_view']) ? 1 : max(1, min(8, (int) $args['per_view']));
			$args['interval'] = $args['interval']=='' ? mt_rand(5000, 10000) : max(0, (int) $args['interval']);
		}
		
		if (empty($args['thumb_size'])) {
			$args['thumb_size'] = trx_addons_get_thumb_size( empty($args['height']) || intval($args['height']).'_' != $args['height'].'_' || $args['height'] >= 630
																	? 'full'
																	: ( $args['height'] >= 420
																		? 'huge'
																		: ( $args['height'] >= 210
																			? 'big'
																			: 'medium' 
																			) 
																		) 
															);
		}

		global $post;

		// Get images from first gallery in the current post
		if (empty($images) || !is_array($images)) {

			if ($args['mode'] == 'gallery') {						// Get images from first gallery in the current post

				$post_content = $post->post_content;
				
				if ( has_shortcode($post_content, 'gallery') ) {
					$gallery = get_post_gallery_images( $post );
					if (count($gallery) == 0) {
						$ids = trx_addons_get_tag_attrib($post_content, '[gallery]', 'ids');
						if (!empty($ids)) {
							$ids = explode(',', $ids);
							foreach ($ids as $id) {
								$attach = wp_get_attachment_image_src($id, 'full');
								if (isset($attach[0]) && $attach[0]!='')
									$gallery[] = trx_addons_remove_protocol($attach[0]);
							}
						}
					}
					$num = 0;
					$images = array();
					if (count($gallery) > 0) {
						foreach ( $gallery as $image_url ) {
							$num++;
							$images[] = array(
								'url' => trx_addons_add_thumb_size($image_url, $args['thumb_size']),
								'title' => '',
								'link' => is_singular() ? '' : get_permalink()
								);
							if ($num >= $args['count']) break;
						}
					}
				}

			} else {												// Get featured images from posts in the specified category

				if (!empty($args['ids'])) {
					$posts = explode(',', $args['ids']);
					$args['count'] = count($posts);
				}
			
				$q_args = array(
					'post_type' => $args['post_type'],
					'post_status' => 'publish',
					'posts_per_page' => $args['count'],
					'ignore_sticky_posts' => true,
					'order' => $args['order'] == 'asc' ? 'asc' : 'desc',
				);
		
				$q_args = trx_addons_query_add_sort_order($q_args, $args['orderby'], $args['order']);
				$q_args = trx_addons_query_add_filters($q_args, 'thumbs');
				$q_args = trx_addons_query_add_posts_and_cats($q_args, $args['ids'], $args['post_type'], $args['cat'], $args['taxonomy']);
				$query = new WP_Query( $q_args );
	
				$num = 0;
				
				$images = array();
				while ( $query->have_posts() ) { $query->the_post();
					$num++;
					$images[] = apply_filters('trx_addons_filter_slider_content', array(
						'url'  => trx_addons_get_attachment_url(get_post_thumbnail_id(get_the_ID()), $args['thumb_size']),
						'title'=> get_the_title(),
						'cats' => trx_addons_get_post_terms(', ', get_the_ID(), $args['taxonomy']),	//get_the_category_list(', '),
						'date' => apply_filters('trx_addons_filter_get_post_date', get_the_date()),
						'link' => get_permalink()
						),
						$args);
					if ($num >= $args['count']) break;
				}
				wp_reset_postdata();
			}

		} else {													// Get images from specified array

			foreach ( $images as $k=>$v ) {
				if (empty($v['url']) && !empty($v['image']))
					$images[$k]['url'] = trx_addons_get_attachment_url($v['image'], $args['thumb_size']);
				if (empty($v['cats']) && !empty($v['subtitle']))
					$images[$k]['cats']= $v['subtitle'];
			}

		}
		
		$num = 0;
		$output = '';
		if (is_array($images) && count($images) > 0) {
			$dim = trx_addons_get_thumb_dimensions($args['thumb_size']);
			if ($dim['height'] == 0) $dim['height'] = $dim['width'] / 16 * 9;
			$output .= '<div' . (!empty($args['id']) ? ' id="' . esc_attr($args['id']) . '_outer"' : '')
						. ' class="slider_outer slider_'.esc_attr($args['engine']).'_outer'
							. ($args['engine'] == 'swiper'
								? ' slider_style_' . esc_attr($args['style'])
									. ' slider_outer_direction_' . esc_attr($args['direction']) 
									. ' slider_outer_' . esc_attr($args['per_view']==1 
											? 'one' 
											: 'multi')
									. ' slider_outer_' . esc_attr(trx_addons_is_on($args['pagination']) 
											? 'pagination slider_outer_pagination_'.esc_attr($args['pagination_type']).' slider_outer_pagination_pos_'.esc_attr($args['pagination_pos']) 
											: 'nopagination')
								: '' )
							. ' slider_outer_' . esc_attr(trx_addons_is_on($args['controls']) 
									? 'controls slider_outer_controls_' . esc_attr($args['controls_pos']) 
									: 'nocontrols')
							. ' slider_outer_' . esc_attr(!trx_addons_is_off($args['titles']) 
									? 'titles_'.$args['titles'] 
									: 'notitles')
							. '"'
						. '>'
					. '<div' 
						. (!empty($args['id']) 
							? ' id="' . esc_attr($args['id']) . '_' . esc_attr($args['engine']) . '"' 
							: '')
						. ' class="slider_container slider_'.esc_attr($args['engine'])
							. (!empty($args['class']) ? ' '.esc_attr($args['class']) : '')
							. ' ' . esc_attr($args['engine']) . '-slider-container'
							. ' slider_' . esc_attr(trx_addons_is_on($args['controls']) 
									? 'controls slider_controls_' . esc_attr($args['controls_pos']) 
									: 'nocontrols')
							. ' slider_' . esc_attr(!trx_addons_is_off($args['titles']) 
									? 'titles_'.$args['titles'] 
									: 'notitles')
							. ' slider_' . esc_attr($args['noresize']==1 
									? 'noresize' 
									: 'resize')
							. ' slider_height_' . esc_attr((int)$args['height']==0 || $args['slides_type']!='bg' 
									? 'auto' 
									: 'fixed')
							. ($args['engine'] == 'swiper'
									? ' slider_direction_' . esc_attr($args['direction']) 
										. ' slider_' . esc_attr(trx_addons_is_on($args['pagination']) 
												? 'pagination slider_pagination_'.esc_attr($args['pagination_type']).' slider_pagination_pos_' . esc_attr($args['pagination_pos']) 
												: 'nopagination')
										. ' slider_' . esc_attr($args['per_view']==1 
												? 'one' 
												: 'multi')
										. ' slider_type_' . esc_attr($args['slides_type'])
									: '')
							.'"'
						.(!empty($args['slides_ratio']) || (!empty($dim['width']) && !empty($dim['height'])) 
							? ' data-ratio="'.esc_attr(!empty($args['slides_ratio']) ? $args['slides_ratio'] : $dim['width'].':'.$dim['height']).'"'
							: '')
						. ($args['engine'] == 'swiper'
							? ' data-interval="'.esc_attr($args['interval']).'"'
								. ' data-effect="'.esc_attr($args['effect']).'"'
								. ' data-pagination="'.esc_attr($args['pagination_type']).'"'
								. ' data-direction="'.esc_attr($args['direction']).'"'
								. ' data-slides-per-view="'.esc_attr($args['per_view']).'"'
								. ' data-slides-space="'.esc_attr($args['slides_space']).'"'
						   		. ' data-slides-min-width="' . esc_attr(!empty($args['slides_min_width']) ? $args['slides_min_width'] : 150) . '"'
							: '')
						. ((int)$args['height'] > 0 
							? ' style="'.esc_attr(trx_addons_get_css_position_from_values('', '', '', '', '', $args['height'])).'"' 
							: '')
						. '>'
						. '<div class="slider-wrapper'
									. ' ' . esc_attr($args['engine']) . '-wrapper'
									. ($args['engine'] == 'elastistack' ? ' stack' : '')
									. '">'
						. ($args['engine'] == 'elastistack' 
							? '<ul class="stack__images">' 
							: '');
			$titles_outside = '';
			foreach ($images as $image) {
				$num++;
				$titles = '';
				if (!trx_addons_is_off($args['titles']) ) {
					$titles_content = apply_filters('trx_addons_filter_slider_title', '', $image);
					if (empty($titles_content)) {
						if (!empty($image['cats'])) {
							$titles_content .= '<div class="slide_cats">' . trim($image['cats']) . '</div>';
						}
						if (!empty($image['title'])) {
							$titles_content .= '<h3 class="slide_title">'
										. ($image['link'] ? '<a href="'.esc_url($image['link']).'">' : '')
										. trim($image['title'])
										. ($image['link'] ? '</a>' : '')
										. '</h3>';
						}
						if (!empty($image['date'])) {
							$titles_content .= '<div class="slide_date">' . trim($image['date']) . '</div>';
						}
					}
					if (!empty($titles_content)) {
						$titles = '<div class="slide_info slide_info_'.(trx_addons_is_on($args['large']) ? 'large' : 'small').'">' 
										. trim($titles_content) 
									. '</div>';
						$titles_outside .= $titles;
					}
				}

				$video = trx_addons_get_video_layout(array(
														'link' => isset($image['video_url']) ? $image['video_url'] : '',
														'embed' => isset($image['video_embed']) ? $image['video_embed'] : '',
														'cover' => !empty($image['url']) ? $image['url'] : '',
														'show_cover' => false
														)
													);
				
				$output .= ($args['engine'] == 'elastistack' ? '<li ' : '<div ')
								. (!empty($image['id']) ? ' id="' . esc_attr($image['id']) . '"' : '') 
								. ' class="slider-slide '.esc_attr($args['engine']).'-slide'
									. (!empty($image['class']) ? ' ' . esc_attr($image['class']) : '') 
									. '"'
								. (!empty($image['url']) ? ' data-image="' . esc_url($image['url']) . '"' : '')
								. (!empty($image['cats']) ? ' data-cats="' . esc_attr($image['cats']) . '"' : '')
								. (!empty($image['title']) ? ' data-title="' . esc_attr($image['title']) . '"' : '')
								. (!empty($image['date']) ? ' data-date="' . esc_attr($image['date']) . '"' : '')
								. ' style="'
									. ($args['slides_type'] == 'bg' && !empty($image['url']) 
													? 'background-image:url(' . esc_url($image['url']) . ');' 
													: '')
//									. ((int)$args['height']>0 
//											? 'min-'.esc_attr(trx_addons_get_css_position_from_values('', '', '', '', '', $args['height'])) 
//											: '')
									. (!empty($image['css']) ? esc_attr($image['css']) : '')
									. '"'
								. '>'
								. ($args['slides_type'] == 'bg' || empty($image['url']) 
									? '' 
									: '<img src="' . esc_url($image['url']) . '" alt="'.(!empty($image['title']) ? esc_attr($image['title']) : '').'">')
								. (!empty($video)
									? $video
									: (!empty($titles) && $args['titles']!='outside'
											? '<div class="slide_overlay slide_overlay_'.(trx_addons_is_on($args['large']) ? 'large' : 'small').'"></div>' . trim($titles)
											: (!empty($image['link']) && $args['engine'] != 'elastistack' 
													? '<a href="'.esc_url($image['link']).'" class="slide_link"></a>' 
													: '')
											)
									)
								. (!empty($image['content']) 
										? '<div class="slide_content">' . trim($image['content']) . '</div>'
										: '')
								. ($args['engine'] == 'elastistack' ? '</li>' : '</div>');
			}
			
			$output .= ($args['engine'] == 'elastistack' 
							? '</ul>' 
							: '')
						. '</div><!-- /.slider-wrapper -->';

			// Prepare controls
			if ($args['style']=='modern' && trx_addons_is_on($args['controls'])) {
				$prev = explode('|', $args['label_prev']);
				$next = explode('|', $args['label_next']);
			}
			$controls_output = trx_addons_is_on($args['controls'])
								? ('<div class="slider_controls_wrap">'
										. '<a class="slider_prev '.esc_attr($args['engine']).'-button-prev" href="#">'
											. ($args['style']=='modern' && !empty($args['label_prev']) 
												? '<span class="slider_controls_label"><span>' . esc_html($prev[0]).'</span>' 
													. (!empty($prev[1]) ? '<span>' . esc_html($prev[1]).'</span>' : '') . '</span>' 
												: '' )
										. '</a>'
										. '<a class="slider_next '.esc_attr($args['engine']).'-button-next" href="#">'
											. ($args['style']=='modern' && !empty($args['label_next']) 
												? '<span class="slider_controls_label"><span>' . esc_html($next[0]).'</span>' 
													. (!empty($next[1]) ? '<span>' . esc_html($next[1]).'</span>' : '') . '</span>' 
												: '' )
										. '</a>'
									. '</div>')
								: '';
			
			// Prepare pagination
			$pagination_output = ($args['engine'] == 'swiper' && trx_addons_is_on($args['pagination']))
										? '<div class="slider_pagination_wrap swiper-pagination"></div>'
										: '';
			
			$out_pagination = $out_controls = false;

			// Output inside controls and pagination
			if ($args['pagination_type']=='progress' || $args['pagination_pos']!='bottom_outside') {
				$output .= $pagination_output;
				$out_pagination = true;
			}
			if ($args['style']!='modern' && $args['controls_pos'] == 'side') {
				$output .= $controls_output;
				$out_controls = true;
			}
		
			// Close inner container
			$output .= '</div><!-- /.slider_container -->';
			
			// Output outside titles, controls and pagination
			if (!$out_controls && $args['style']=='modern') {
				$output .= $controls_output;
			}
			if (!$out_pagination) {
				$output .= $pagination_output;
			}
			if (!$out_controls && $args['style']!='modern') {
				$output .= $controls_output;
			}
			if (!empty($titles_outside) && $args['titles']=='outside') {
				$output .= '<div class="slider_titles_outside_wrap">'.trim($titles_outside).'</div>';
			}
			
			// Close outer container
			$output .= '</div><!-- /.slider_outer -->';
		}
		if (!empty($output) && $args['engine']=='elastistack') trx_addons_enqueue_slider('elastistack');

		return apply_filters('trx_addons_filter_slider_layout', $output, $args);
	}
}


// Return video player layout
if (!function_exists('trx_addons_get_video_layout')) {
	function trx_addons_get_video_layout($args=array()) {
		$args = array_merge(array(
			'link' => '',					// Link to the video on Youtube or Vimeo
			'embed' => '',					// Embed code instead link
			'cover' => '',					// URL or ID of the cover image
			'show_cover' => true,			// Show cover image or only add classes
			'popup' => false,				// Open video in the popup window or insert instead cover image (default)
			'class' => '',					// Additional classes for slider container
			'id' => ''						// ID of the slider container
			), $args);

		if (empty($args['embed']) && empty($args['link'])) return '';
		if (empty($args['cover'])) $args['popup'] = false;
		if (empty($args['id'])) $args['id'] = 'sc_video_'.str_replace('.', '',mt_rand());
		
		$output = '<div id="'.esc_attr($args['id']).'"'
					. ' class="trx_addons_video_player' 
								. (!empty($args['cover']) ? ' with_cover hover_play' : ' without_cover')
								. (!empty($args['class']) ? ' ' . esc_attr($args['class']) : '')
							. '"'
					. '>';
		$args['embed'] = trx_addons_get_embed_layout(array(
														'link' => $args['link'],
														'embed' => $args['embed']
													));
		if (!empty($args['cover'])) {
			$args['cover'] = trx_addons_get_attachment_url($args['cover'], 
										apply_filters('trx_addons_filter_video_cover_thumb_size', trx_addons_get_thumb_size('huge')));
			if (!empty($args['cover'])) {
				if (empty($args['popup']))
					$args['embed'] = trx_addons_make_video_autoplay($args['embed']);
				if ($args['show_cover']) {
					$attr = trx_addons_getimagesize($args['cover']);
					$output .= '<img src="' . esc_url($args['cover']) . '" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				$output .= apply_filters('trx_addons_filter_video_mask',
								'<div class="video_mask"></div>'
								. ($args['popup']
										? '<a class="video_hover trx_addons_popup_link" href="#'.esc_attr($args['id']).'_popup"></a>'
										: '<div class="video_hover" data-video="'.esc_attr($args['embed']).'"></div>'
								),
								$args);
			}
		}
		if (empty($args['popup'])) {
			$output .= '<div class="video_embed video_frame">'
							. (empty($args['cover']) ? $args['embed'] : '')
						. '</div>';
		}
		$output .= '</div>';
		// Add popup
		if (!empty($args['popup'])) {
			$output .= '<!-- .sc_popup --><div id="'.esc_attr($args['id']).'_popup" class="sc_popup">'
						. '<div id="'.esc_attr($args['id']).'_popup_player"'
							. ' class="trx_addons_video_player without_cover'
										. (!empty($args['class']) ? ' ' . esc_attr($args['class']) : '')
									. '"'
							. '>'
								. '<div class="video_embed video_frame">'
									. $args['embed']
								. '</div>'
							. '</div>'
						. '</div>';
		}
		return apply_filters('trx_addons_filter_video_layout', $output, $args);
	}
}


// Return embeded code layout
if (!function_exists('trx_addons_get_embed_layout')) {
	function trx_addons_get_embed_layout($args=array()) {
		$args = array_merge(array(
			'link' => '',					// Link to the video on Youtube or Vimeo
			'embed' => ''					// Embed code instead link
			), $args);

		if (empty($args['embed']) && empty($args['link'])) return '';
		if (!empty($args['embed'])) {
			$args['embed'] = str_replace("`", '"', $args['embed']);
		} else {
			global $wp_embed;
			if (is_object($wp_embed))
				$args['embed'] = do_shortcode($wp_embed->run_shortcode( sprintf('[embed]%s[/embed]', $args['link']) ));
		}
		return apply_filters('trx_addons_filter_embed_layout', $args['embed'], $args);
	}
}


// Return the image url by attachment ID or URL
if (!function_exists('trx_addons_get_attachment_url')) {
	function trx_addons_get_attachment_url($image_id, $size='full') {
		if ( is_array( $image_id ) ) {
			$image_id = ! empty( $image_id[ 'id' ] )
							? (int) $image_id[ 'id' ]
							: ( ! empty( $image_id[ 'url' ] )
									? $image_id[ 'url' ]
									: ''
								);
		}
		if ( is_numeric( $image_id ) && (int) $image_id > 0 ) {
			$attach = wp_get_attachment_image_src($image_id, $size);
			$image_id = empty( $attach[0] ) ? '' : $attach[0];
		} else {
			$image_id = trx_addons_add_thumb_size($image_id, $size);
		}
		return $image_id;
	}
}


// Return url from first <img> tag inserted in post
if (!function_exists('trx_addons_get_post_image')) {
	function trx_addons_get_post_image($post_text='', $src=true) {
		global $post;
		$img = '';
		if (empty($post_text)) $post_text = $post->post_content;
		if (preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $post_text, $matches)) {
			$img = $matches[$src ? 1 : 0][0];
		}
		return $img;
	}
}


// Return url from first <audio> tag inserted in post
if (!function_exists('trx_addons_get_post_audio')) {
	function trx_addons_get_post_audio($post_text='', $src=true) {
		global $post;
		$img = '';
		if (empty($post_text)) $post_text = $post->post_content;
		if ($src) {
			if (preg_match_all('/<audio.+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $post_text, $matches)) {
				$img = $matches[1][0];
			}
		} else {
			$img = trx_addons_get_tag($post_text, '<audio', '</audio>');
			if (empty($img)) {
				$img = do_shortcode(trx_addons_get_tag($post_text, '[audio', '[/audio]'));
			}
			if (empty($img)) {
				$img = trx_addons_get_tag_attrib($post_text, '[trx_widget_audio]', 'url');
				if (!empty($img))
					$img = '<audio src="'.esc_url($img).'">';
			}
		}
		return $img;
	}
}


// Return url from first <video> tag inserted in post
if (!function_exists('trx_addons_get_post_video')) {
	function trx_addons_get_post_video($post_text='', $src=true) {
		global $post;
		$img = '';
		if (empty($post_text)) $post_text = do_shortcode($post->post_content);
		if ($src) {
			if (preg_match_all('/<video.+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $post_text, $matches)) {
				$img = $matches[1][0];
			}
		} else {
			$img = trx_addons_get_tag($post_text, '<video', '</video>');
			if (empty($img)) {
				$sc = trx_addons_get_tag($post_text, '[video', '[/video]');
				if (empty($sc)) $sc = trx_addons_get_tag($post_text, '[trx_widget_video', '');
				if (!empty($sc)) $img = do_shortcode($sc);
			}
		}
		return $img;
	}
}


// Add 'autoplay' feature in the video
if (!function_exists('trx_addons_make_video_autoplay')) {
	function trx_addons_make_video_autoplay($video) {
		if (($pos = strpos($video, '<video'))!==false) {
			$video = str_replace('<video', '<video autoplay="autoplay"', $video);
		} else if (($pos = strpos($video, '<iframe'))!==false) {
			if (preg_match('/(<iframe.+src=[\'"])([^\'"]+)([\'"][^>]*>)(.*)/i', $video, $matches)) {
				$video = $matches[1] . $matches[2] . (strpos($matches[2], '?')!==false ? '&' : '?') . 'autoplay=1' . $matches[3] . $matches[4];
			}
		}
		return $video;
	}
}


// Return url from first <iframe> tag inserted in post
if (!function_exists('trx_addons_get_post_iframe')) {
	function trx_addons_get_post_iframe($post_text='', $src=true) {
		global $post;
		$img = '';
		if (empty($post_text)) $post_text = do_shortcode($post->post_content);
		if ($src) {
			if (preg_match_all('/<iframe.+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $post_text, $matches)) {
				$img = $matches[1][0];
			}
		} else
			$img = trx_addons_get_tag($post_text, '<iframe', '</iframe>');
		return $img;
	}
}


// Return tag SVG from specified file
if (!function_exists('trx_addons_get_svg_from_file')) {
	function trx_addons_get_svg_from_file($svg) {
		$content = trx_addons_fgc($svg);
		preg_match("#<\s*?svg\b[^>]*>(.*?)</svg\b[^>]*>#s", $content, $matches);
		return !empty($matches[0]) ? $matches[0] : '';
	}
}


//  Add attachment's "alt" as attribute "title" to the links in WP gallery output
if (!function_exists( 'trx_addons_add_title_to_gallery_links' ) ) {
	add_filter( 'wp_get_attachment_link', 'trx_addons_add_title_to_gallery_links', 10, 2 );
	function trx_addons_add_title_to_gallery_links($link, $id) {
		if ((int) $id > 0) {
			$meta = get_post_meta(intval($id));
			$alt = '';
			if (!empty($meta['_wp_attachment_image_alt'][0]))
				$alt = $meta['_wp_attachment_image_alt'][0];
			else if (!empty($meta['_wp_attachment_metadata'][0])) {
				$meta = trx_addons_unserialize($meta['_wp_attachment_metadata'][0]);
				if (!empty($meta['image_meta']['caption']))
					$alt = $meta['image_meta']['caption'];
			}
			if (!empty($alt))
				$link = str_replace('<a','<a title="'.esc_attr($alt).'"', $link);
		}
		return $link;
	}
}