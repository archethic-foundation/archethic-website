<?php
/**
 * The template to display the service's single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

get_header();

while ( have_posts() ) { the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'services_single itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

		<?php do_action('trx_addons_action_before_article', 'services.single'); ?>
		
		<section class="services_page_header">	

			<?php
			// Get post meta: price, icon, etc.
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$price_showed = false;

			// Image
			if ( !trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() ) {
				?><div class="services_page_featured"><?php
					the_post_thumbnail( trx_addons_get_thumb_size('huge'), trx_addons_seo_image_params(array(
								'alt' => get_the_title()
								))
							);
					if (!empty($meta['price'])) {
						?><div class="sc_services_item_price"><?php echo esc_html($meta['price']); ?></div><?php
						$price_showed = true;
					}
				?></div><?php
			}

			// Title
			if ( !trx_addons_sc_layouts_showed('title') ) {
				?><h2 class="services_page_title<?php if (!$price_showed && !empty($meta['price'])) echo ' with_price'; ?>"><?php
					the_title();
					// Price
					if (!$price_showed && !empty($meta['price'])) {
						?><div class="sc_services_item_price"><?php echo esc_html($meta['price']); ?></div><?php
						$price_showed = true;
					}
				?></h2><?php
			}
			?>

		</section>
		<?php

		// Post content
		?><section class="services_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
			// Price
			if (!$price_showed && !empty($meta['price'])) {
				?><div class="sc_services_item_price"><?php echo esc_html($meta['price']); ?></div><?php
			}
			the_content( );
		?></section><!-- .entry-content --><?php

		// Link to the product
		if (!empty($meta['product']) && (int) $meta['product'] > 0) {
			?><div class="services_page_buttons">
				<a href="<?php echo esc_url(get_permalink($meta['product'])); ?>" class="sc_button theme_button"><?php esc_html_e('Order now', 'trx_addons'); ?></a>
			</div><?php
		}

		do_action('trx_addons_action_after_article', 'services.single');

	?></article><?php

	// Related items (select dishes with same category)
	$taxonomies = array();
	$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY);
	if ( !empty( $terms ) ) {
		$taxonomies[TRX_ADDONS_CPT_SERVICES_TAXONOMY] = array();
		foreach( $terms as $term )
			$taxonomies[TRX_ADDONS_CPT_SERVICES_TAXONOMY][] = $term->term_id;
	}

	$trx_addons_related_style   = explode('_', trx_addons_get_option('services_style'));
	$trx_addons_related_type    = $trx_addons_related_style[0];
	$trx_addons_related_columns = empty($trx_addons_related_style[1]) ? 1 : max(1, $trx_addons_related_style[1]);
	
	trx_addons_get_template_part('templates/tpl.posts-related.php',
										'trx_addons_args_related',
										apply_filters('trx_addons_filter_args_related', array(
															'class' => 'services_page_related sc_services sc_services_'.esc_attr($trx_addons_related_type),
															'posts_per_page' => $trx_addons_related_columns,
															'columns' => $trx_addons_related_columns,
															'template' => TRX_ADDONS_PLUGIN_CPT . 'services/tpl.'.trim($trx_addons_related_type).'-item.php',
															'template_args_name' => 'trx_addons_args_sc_services',
															'post_type' => TRX_ADDONS_CPT_SERVICES_PT,
															'taxonomies' => $taxonomies
															)
													)
									);

	// Open tabs wrapper
	$trx_addons_add_contacts = trx_addons_get_option('services_add_contact_form') == 1 && function_exists('trx_addons_sc_form');
    $trx_addons_add_contacts_7 = trx_addons_get_option('services_add_contact_form_7') != "" && trx_addons_exists_cf7();
	$trx_addons_add_comments = comments_open() || get_comments_number();
	if (($trx_addons_add_contacts || $trx_addons_add_contacts_7)  && $trx_addons_add_comments) {
		wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?><div class="trx_addons_tabs services_page_tabs">
			<ul class="trx_addons_tabs_titles">
				<li data-active="true"><a href="<?php echo esc_url(trx_addons_get_hash_link('#services_page_tab_comments')); ?>"><?php
					esc_html_e('Comments', 'trx_addons');
				?></a></li><?php
				?><li><a href="<?php echo esc_url(trx_addons_get_hash_link('#services_page_tab_contacts')); ?>"><?php
					esc_html_e('Contact Us', 'trx_addons');
				?></a></li>
			</ul><?php
	}
	// If comments are open or we have at least one comment, load up the comment template.
	if ($trx_addons_add_comments) {
		?><section id="services_page_tab_comments" class="services_page_section services_page_section_comments"><?php
			comments_template();
		?></section><!-- .comments --><?php
	}
	
	// Contact form
	if ($trx_addons_add_contacts) {
		?><section id="services_page_tab_contacts" class="services_page_section services_page_section_contacts"><?php
			trx_addons_show_layout(trx_addons_sc_form(array()));
		?></section><!-- .contacts --><?php
	}
    // Contact Form 7
    if ($trx_addons_add_contacts != 1 && $trx_addons_add_contacts_7) {
        ?><section id="services_page_tab_contacts" class="services_page_section services_page_section_contacts"><?php
        echo do_shortcode(trx_addons_get_option('services_add_contact_form_7'));
        ?></section><!-- .contacts --><?php
    }

	// Close tabs wrapper
	if ($trx_addons_add_contacts && $trx_addons_add_comments) {
		?></div><!-- /.trx_addons_tabs services_page_tabs --><?php
	}
}

get_footer();
?>