<?php
/**
 * The template to display the car's single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.25
 */

wp_enqueue_script('jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true);
if (trx_addons_get_option('cars_single_style') == 'tabs')
	wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);

get_header();

while ( have_posts() ) { the_post();
	$trx_addons_meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'cars_page itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

		<?php do_action('trx_addons_action_before_article', 'cars.single'); ?>
	
		<section class="cars_page_section cars_page_header"><?php
			// Image
			if ( !trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() ) {
				?><div class="cars_page_featured"><?php
					the_post_thumbnail( trx_addons_get_thumb_size('huge'), trx_addons_seo_image_params(array(
								'alt' => get_the_title()
								))
							);
				?></div><?php
				if (!empty($trx_addons_meta['gallery'])) {
					$trx_addons_gallery = explode('|', $trx_addons_meta['gallery']);
					if (is_array($trx_addons_gallery)) {
						?><div class="cars_page_gallery"><?php
							array_unshift($trx_addons_gallery, get_post_thumbnail_id($id));
							$i = 0;
							foreach($trx_addons_gallery as $trx_addons_image) {
								$i++;
								if ($trx_addons_image != '') {
									$trx_addons_thumb = trx_addons_get_attachment_url($trx_addons_image, trx_addons_get_thumb_size('tiny'));
									$trx_addons_image = trx_addons_get_attachment_url($trx_addons_image, trx_addons_get_thumb_size('huge'));
									if (!empty($trx_addons_thumb)) {
										$attr = trx_addons_getimagesize($trx_addons_thumb);
										?><span class="cars_page_gallery_item<?php if ($i==1) echo " cars_page_gallery_item_active"; ?>" data-image="<?php echo esc_url($trx_addons_image); ?>"><?php
											?><img src="<?php echo esc_url($trx_addons_thumb); ?>" alt=""<?php
												if (!empty($attr[3])) echo ' '.trim($attr[3]);
											?>><?php
										?></span><?php
									}
								}
							}
						?></div><?php
					}
				}
			}
			
			// Title
			if ( true || !trx_addons_sc_layouts_showed('title') ) {
				?><div class="cars_page_title_wrap">
					<h3 class="cars_page_title">
						<?php the_title(); ?>
						<span class="cars_page_status"><?php
							trx_addons_show_layout(trx_addons_get_post_terms('', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS));
						?></span>
					</h3>
					<?php
					// Address
					?><div class="cars_page_title_address">
						<span class="cars_page_type"><?php
							trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE));
						?></span>
						<span class="cars_page_year"><?php
							trx_addons_show_layout($trx_addons_meta['produced']);
						?></span><?php
						if (($city = trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_CITY))!='') {
							?><span class="cars_page_city"><?php
								trx_addons_show_layout($city);
							?></span><?php
						}
					?></div><?php
					// Meta
					?><div class="cars_page_title_meta"><?php
						// Price
						if (!empty($trx_addons_meta['price']) || !empty($trx_addons_meta['price2'])) {
							?><div class="cars_page_title_price"><?php
								trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.parts.price.php',
																'trx_addons_args_cars_price',
																array('meta' => $trx_addons_meta)
															);
							?></div><?php
						}
						// Counters
						trx_addons_sc_show_post_meta('cars_single', apply_filters('trx_addons_filter_show_post_meta', array(
									'components' => 'counters,share',
									'counters' => 'views,comments,likes',
									'seo' => false
									), 'cars_single', 1)
								);
					?></div><?php
					trx_addons_sc_layouts_showed('postmeta', true);
				?></div><?php
			}
		?></section><?php

		
		// Section's titles
		$trx_addons_section_titles = array(
			'description' => __('Description', 'trx_addons'),
			'details' => __('Details', 'trx_addons'),
			'features' => __('Features', 'trx_addons'),
			'attachments' => __('Attachments', 'trx_addons'),
			'video' => __('Video', 'trx_addons'),
			'contacts' => __('Contacts', 'trx_addons')
		);
		$trx_addons_tabs_id = 'cars_page_tabs';

		// Tabs
		if (trx_addons_get_option('cars_single_style') == 'tabs') {
			if (empty($trx_addons_meta['attachments'])) unset($trx_addons_section_titles['attachments']);
			if (empty($trx_addons_meta['video'])) unset($trx_addons_section_titles['video']);
			?><div class="trx_addons_tabs cars_page_tabs">
				<ul class="trx_addons_tabs_titles"><?php
					foreach ($trx_addons_section_titles as $trx_addons_section_slug => $trx_addons_section_title) {
						$trx_addons_tab_id = $trx_addons_tabs_id.'_'.$trx_addons_section_slug;
						$trx_addons_tab_active = trx_addons_get_value_gp('tab')==$trx_addons_section_slug
										? ' data-active="true"' 
										: '';
						?><li<?php
							if (trx_addons_get_value_gp('tab')==$trx_addons_section_slug)
								echo ' data-active="true"';
							?>><a href="<?php echo esc_url(trx_addons_get_hash_link('#'.$trx_addons_tab_id.'_content')); ?>"><?php
								echo esc_html($trx_addons_section_title);
							?></a></li><?php
					}
				?></ul><?php
		}


		// Post content
		?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_description'); ?>_content" class="cars_page_section cars_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
			if (trx_addons_get_option('cars_single_style') == 'tabs') {
				?><h4 class="cars_page_section_title"><?php echo esc_html($trx_addons_section_titles['description']); ?></h4><?php
			}
			the_content( );
		?></section><!-- .entry-content --><?php


		// Details
		?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_details'); ?>_content" class="cars_page_section cars_page_details">
			<h4 class="cars_page_section_title"><?php echo esc_html($trx_addons_section_titles['details']); ?></h4>
			<?php
			// ID
			if (!empty($trx_addons_meta['id'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Car ID:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php trx_addons_show_layout($trx_addons_meta['id']); ?></span>
				</span><?php
			}
			// Manufacturer
			?><span class="cars_page_section_item">
				<span class="cars_page_label"><?php esc_html_e('Manufacturer:', 'trx_addons'); ?></span>
				<span class="cars_page_data"><?php
					trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER));
				?></span>
			</span><?php
			// Model
			?><span class="cars_page_section_item">
				<span class="cars_page_label"><?php esc_html_e('Model:', 'trx_addons'); ?></span>
				<span class="cars_page_data"><?php
					trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_MODEL));
				?></span>
			</span><?php
			// Transmission
			if (!empty($trx_addons_meta['transmission'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Transmission:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_CPT_CARS_PT, 'transmission', $trx_addons_meta['transmission']));
					?></span>
				</span><?php
			}
			// Type of drive
			if (!empty($trx_addons_meta['type_drive'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Type of drive:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_CPT_CARS_PT, 'type_drive', $trx_addons_meta['type_drive']));
					?></span>
				</span><?php
			}
			// Fuel
			if (!empty($trx_addons_meta['fuel'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Fuel:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_CPT_CARS_PT, 'fuel', $trx_addons_meta['fuel']));
					?></span>
				</span><?php
			}
			// Engine
			if (!empty($trx_addons_meta['engine_size']) || !empty($trx_addons_meta['engine_type'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Engine:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout($trx_addons_meta['engine_size']
											 . ($trx_addons_meta['engine_size_prefix'] 
														? ' ' . trx_addons_prepare_macros($trx_addons_meta['engine_size_prefix'])
														: '')
											 . ($trx_addons_meta['engine_type'] 
														? ' ' . trx_addons_prepare_macros($trx_addons_meta['engine_type'])
														: '')
											);
					?></span>
				</span><?php
			}
			// Engine power in horses
			if (!empty($trx_addons_meta['engine_power_horses'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Engine power:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout($trx_addons_meta['engine_power_horses'] . ' ' . esc_html__('horses', 'trx_addons'));
					?></span>
				</span><?php
			}
			// Engine power in watts
			if (!empty($trx_addons_meta['engine_power_wt'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Engine power:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout($trx_addons_meta['engine_power_wt'] . ' ' . esc_html__('watts', 'trx_addons'));
					?></span>
				</span><?php
			}
			// Mileage
			if (!empty($trx_addons_meta['mileage'])) {
				?><span class="cars_page_section_item">
					<span class="cars_page_label"><?php esc_html_e('Mileage:', 'trx_addons'); ?></span>
					<span class="cars_page_data"><?php
						trx_addons_show_layout(trx_addons_num2kilo($trx_addons_meta['mileage'])
											. ($trx_addons_meta['mileage_prefix'] 
													? ' ' . trx_addons_prepare_macros($trx_addons_meta['mileage_prefix'])
													: '')
											);
					?></span>
				</span><?php
			}
			// Additional details
			if (!empty($trx_addons_meta['details_enable']) && !empty($trx_addons_meta['details']) && is_array($trx_addons_meta['details'])) {
				foreach ($trx_addons_meta['details'] as $detail) {
					if (!empty($detail['title'])) {
						?><span class="cars_page_section_item">
							<span class="cars_page_label"><?php
								trx_addons_show_layout(trx_addons_prepare_macros($detail['title'])); 
							?>:</span>
							<span class="cars_page_data"><?php 
								trx_addons_show_layout(trx_addons_prepare_macros($detail['value'])); 
							?></span>
						</span><?php
					}
				}
			}
		?></section><!-- .cars_page_details --><?php

		// Features
		?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_features'); ?>_content" class="cars_page_section cars_page_features">
			<h4 class="cars_page_section_title"><?php echo esc_html($trx_addons_section_titles['features']); ?></h4>
			<div class="cars_page_features_list">
				<?php trx_addons_show_layout(trx_addons_get_post_terms('', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_FEATURES)); ?>
			</div>
		</section><!-- .cars_page_features --><?php


		// Attachments
		if (!empty($trx_addons_meta['attachments'])) {
			$trx_addons_meta['attachments'] = explode('|', !empty($trx_addons_meta['attachments']) ? $trx_addons_meta['attachments'] : '');
			if (is_array($trx_addons_meta['attachments']) && count($trx_addons_meta['attachments'])>0) {
				?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_attachments'); ?>_content" class="cars_page_section cars_page_attachments">
					<h4 class="cars_page_section_title"><?php echo esc_html($trx_addons_section_titles['attachments']); ?></h4><?php
					if (!empty($trx_addons_meta['attachments_description'])) {
						?><div class="cars_page_section_description"><?php
							echo wp_kses_post(nl2br($trx_addons_meta['attachments_description']));
						?></div><?php
					}
					?><div class="cars_page_attachments_list"><?php
						foreach ($trx_addons_meta['attachments'] as $file) {
							?><a href="<?php echo esc_url($file); ?>"><?php	echo esc_html(basename($file));	?></a><?php
						}
					?></div><?php
				?></section><!-- .cars_page_attachments --><?php
			}
		}


		// Video promo
		if (!empty($trx_addons_meta['video'])) {
			?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_video'); ?>_content" class="cars_page_section cars_page_video">
				<h4 class="cars_page_section_title"><?php echo esc_html($trx_addons_section_titles['video']); ?></h4><?php
					if (!empty($trx_addons_meta['video_description'])) {
						?><div class="cars_page_section_description"><?php
							echo wp_kses_post(nl2br($trx_addons_meta['video_description']));
						?></div><?php
					}
				?><div class="cars_page_video_wrap"><?php
					trx_addons_show_layout(trx_addons_get_video_layout(array(
																			'link' => $trx_addons_meta['video']
																		)));
				?></div><?php
			?></section><!-- .cars_page_video --><?php
		}


		// Agent info
		?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_contacts'); ?>_content" class="cars_page_section cars_page_agent">
			<h4 class="cars_page_section_title"><?php echo esc_html($trx_addons_section_titles['contacts']); ?></h4>
			<div class="cars_page_agent_wrap"<?php trx_addons_seo_snippets('author', 'Person'); ?>><?php
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.parts.agent.php',
												'trx_addons_args_cars_agent',
												array('meta' => $trx_addons_meta)
											);
			?></div>
		</section><!-- .cars_page_agent --><?php

		// Close tabs wrapper
		if (trx_addons_get_option('cars_single_style') == 'tabs') {
			?></div><!-- /.trx_addons_tabs cars_page_tabs --><?php
		}

		do_action('trx_addons_action_after_article', 'cars.single');

	?></article><?php
	
	
	// Related items (select cars with same type and status)
	$taxonomies = array();
	$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE);
	if ( !empty( $terms ) ) {
		$taxonomies[TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE] = array();
		foreach( $terms as $term )
			$taxonomies[TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE][] = $term->term_id;
	}
	$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS);
	if ( !empty( $terms ) ) {
		$taxonomies[TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS] = array();
		foreach( $terms as $term )
			$taxonomies[TRX_ADDONS_CPT_CARS_TAXONOMY_STATUS][] = $term->term_id;
	}

	$trx_addons_related_style   = explode('_', trx_addons_get_option('cars_blog_style'));
	$trx_addons_related_type    = $trx_addons_related_style[0];
	$trx_addons_related_columns = empty($trx_addons_related_style[1]) ? 1 : max(1, $trx_addons_related_style[1]);
	
	trx_addons_get_template_part('templates/tpl.posts-related.php',
										'trx_addons_args_related',
										apply_filters('trx_addons_filter_args_related', array(
															'class' => 'cars_page_related sc_cars sc_cars_'.esc_attr($trx_addons_related_type),
															'posts_per_page' => $trx_addons_related_columns,
															'columns' => $trx_addons_related_columns,
															'template' => TRX_ADDONS_PLUGIN_CPT . 'cars/tpl.cars.'.trim($trx_addons_related_type).'-item.php',
															'template_args_name' => 'trx_addons_args_sc_cars',
															'post_type' => TRX_ADDONS_CPT_CARS_PT,
															'taxonomies' => $taxonomies
															)
													)
									);

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>