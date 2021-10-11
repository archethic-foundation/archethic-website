<?php
/**
 * The style "tabs" of the Services
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');
$svg_present = false;

$query_args = array(
	'post_status' => 'publish',
	'ignore_sticky_posts' => true
);
if (empty($args['ids'])) {
	$query_args['posts_per_page'] = $args['count'];
	$query_args['offset'] = $args['offset'];
}
$query_args = trx_addons_query_add_sort_order($query_args, $args['orderby'], $args['order']);
$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids'], $args['post_type'], $args['cat'], $args['taxonomy']);
$query = new WP_Query( $query_args );
if ($query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	?><div <?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?>
		class="sc_services sc_services_<?php 
			echo esc_attr($args['type']);
			if ($args['type'] == 'tabs') echo ' effect_'.esc_attr($args['tabs_effect']);	//fade | slide | flip
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
	?>"><?php

		trx_addons_sc_show_titles('sc_services', $args);
		
		?><div class="sc_services_content sc_item_content"><?php
		
			// Container with items
			?><div class="sc_services_tabs_content">
				<?php
				$tabs_list = array();
				set_query_var('trx_addons_args_sc_services', $args);
				$trx_addons_number = $args['offset'];
				while ( $query->have_posts() ) { $query->the_post();
					$trx_addons_number++;
					set_query_var('trx_addons_args_item_number', $trx_addons_number);
					$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
					set_query_var('trx_addons_args_item_meta', $meta);
					$tabs_item = '<div class="sc_services_tabs_list_item' . ($trx_addons_number-1 == $args['offset'] ? ' sc_services_tabs_list_item_active' : '') . '">';
					$tabs_add = '';
					if ($args['featured']=='icon') {
						$svg = $img = '';
						if (trx_addons_is_url($meta['icon'])) {
							$img = $meta['icon'];
							$meta['icon'] = basename($meta['icon']);
						} else if (!empty($args['icons_animation']) && $args['icons_animation'] > 0 && ($svg = trx_addons_get_file_dir('css/icons.svg/'.trx_addons_esc($meta['icon']).'.svg')) != '')
							$svg_present = true;
						$tabs_add = '<span id="'.esc_attr($args['id'].'_'.trim($meta['icon']).'_'.trim($trx_addons_number)).'"'
											. ' class="sc_services_item_icon '
												. (!empty($svg) 
													? 'sc_icon_type_svg'
													: (!empty($img) 
														? 'sc_icon_type_img'
														: esc_attr($meta['icon'])
														)
													)
												. '"'
											. (!empty($meta['icon_color'])
												? ' style="color:'.esc_attr($meta['icon_color']).'"'
												: ''
												)
									. '>'
											. (!empty($svg) 
												? trx_addons_get_svg_from_file($svg) 
												: (!empty($img)
													? '<img class="sc_icon_as_image" src="'.esc_url($img).'" alt="">'
													: '')
												)
									. '</span>';
					} else if ($args['featured']=='pictogram' && !empty($meta['image'])) {
						$attr = trx_addons_getimagesize($meta['image']);
						$tabs_add = '<span class="sc_services_item_pictogram"><img src="' . esc_url($meta['image']) . '" alt=""'
									. (!empty($attr[3]) ? ' '.trim($attr[3]) : '') . '></span>';
					} else if ($args['featured']=='number') {
						$tabs_add = sprintf('<span class="sc_services_item_number">%02d</span>', $trx_addons_number);
					}
					$tabs_item .= '<h6 class="sc_services_item_title' . ($tabs_add ? ' with_icon' : '') . '">' 
										. $tabs_add 
										. '<span class="sc_services_item_label">' . get_the_title() . '</span>'
										. '</h6>';
					$tabs_list[] = $tabs_item . '</div>';
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'services/tpl.tabs-item.php');
				}
				wp_reset_postdata();
				?>	
			</div><?php
			
			// Tabs list
			?><div class="sc_services_tabs_list">
				<?php
				foreach ($tabs_list as $tabs_item)
					trx_addons_show_layout($tabs_item);
				?>
			</div>			
		</div><?php

		trx_addons_sc_show_links('sc_services', $args);

	?></div><!-- /.sc_services --><?php

	if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
		wp_enqueue_script( 'vivus', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/vivus.js'), array('jquery'), null, true );
		wp_enqueue_script( 'trx_addons-sc_icons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.js'), array('jquery'), null, true );
	}
}
?>