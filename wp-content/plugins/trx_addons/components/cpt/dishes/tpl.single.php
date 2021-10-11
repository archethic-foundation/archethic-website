<?php
/**
 * The template to display the dish's single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.09
 */

get_header();

while ( have_posts() ) { the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'dishes_single itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

		<?php do_action('trx_addons_action_before_article', 'dishes.single'); ?>
		
		<section class="dishes_page_header">	

			<?php
			// Get post meta: price, spicy level, nutritions, ingredients, etc.
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			
			// Image
			if ( !trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() ) {
				?><div class="dishes_page_featured">
					<?php
					the_post_thumbnail( trx_addons_get_thumb_size('huge'), trx_addons_seo_image_params(array(
								'alt' => get_the_title()
								))
							);

					// Spicy level
					if (trim($meta['spicy']) != '') {
						$meta['spicy'] = max(1, min(5, $meta['spicy']));
						?><span class="dishes_page_spicy dishes_page_spicy_<?php echo esc_html($meta['spicy']); ?>">
							<span class="dishes_page_spicy_label"><?php esc_html_e('Spicy Level:', 'trx_addons'); ?></span>
							<span class="dishes_page_spicy_value"><?php echo esc_html($meta['spicy']); ?></span>
						</span><?php
					}

					// Price
					if ( trx_addons_sc_layouts_showed('title') ) {
						if (trim($meta['price']) != '') {
							?><span class="dishes_page_price"><?php echo esc_html($meta['price']); ?></span><?php
						}
					}
					?>
				</div>
				<?php
			}
			
			// Title
			if ( !trx_addons_sc_layouts_showed('title') ) {
				?><h2 class="dishes_page_title<?php if (trim($meta['price']) != '') echo ' with_price'; ?>"><?php 
					the_title();
					// Price
					if (trim($meta['price']) != '') {
						?><span class="dishes_page_price"><?php echo esc_html($meta['price']); ?></span><?php
					}
				?></h2><?php
			}
			?>
		</section>
		<?php

		// Post content
		?><section class="dishes_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
			the_content( );
		?></section><!-- .entry-content --><?php

		// Post details
		if ( !empty($meta['nutritions']) || !empty($meta['ingredients']) ) {
			
			?><section class="dishes_page_details">
				<h3 class="dishes_page_details_title"><?php esc_html_e('Details', 'trx_addons'); ?></h3>
				<?php
				// Nutritions list
				if ( !empty($meta['nutritions']) ) {
					$nutritions = explode("\n", $meta['nutritions']);
					?>
					<div class="dishes_page_details_nutritions">
						<h4 class="dishes_page_details_nutritions_title"><?php esc_html_e('Nutritions', 'trx_addons'); ?></h3>
						<ul class="dishes_page_details_nutritions_list">
							<?php
							foreach ($nutritions as $nutritions_item) {
								$nutritions_item = trim($nutritions_item);
								if (empty($nutritions_item)) continue;
								?><li><?php echo esc_html($nutritions_item); ?></li><?php
							}
							?>
						</ul>
					</div>
					<?php
				}
				// Ingredients list
				if ( !empty($meta['ingredients']) ) {
					$ingredients = explode("\n", $meta['ingredients']);
					?>
					<div class="dishes_page_details_ingredients">
						<h4 class="dishes_page_details_ingredients_title"><?php esc_html_e('Ingredients', 'trx_addons'); ?></h3>
						<ul class="dishes_page_details_ingredients_list">
							<?php
							foreach ($ingredients as $ingredients_item) {
								$ingredients_item = trim($ingredients_item);
								if (empty($ingredients_item)) continue;
								?><li><?php echo esc_html($ingredients_item); ?></li><?php
							}
							?>
						</ul>
					</div>
					<?php
				}
			?></section><!-- .dishes_page_details --><?php
		}

		// Link to the product
		if (!empty($meta['product']) && (int) $meta['product'] > 0) {
			?><div class="dishes_page_buttons">
				<a href="<?php echo esc_url(get_permalink($meta['product'])); ?>" class="sc_button theme_button"><?php esc_html_e('Order now', 'trx_addons'); ?></a>
			</div><?php
		}

		do_action('trx_addons_action_after_article', 'dishes.single');
		
	?></article><?php

	// Related items (select dishes with same category)
	$taxonomies = array();
	$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_DISHES_TAXONOMY);
	if ( !empty( $terms ) ) {
		$taxonomies[TRX_ADDONS_CPT_DISHES_TAXONOMY] = array();
		foreach( $terms as $term )
			$taxonomies[TRX_ADDONS_CPT_DISHES_TAXONOMY][] = $term->term_id;
	}

	$trx_addons_related_style   = explode('_', trx_addons_get_option('dishes_style'));
	$trx_addons_related_type    = $trx_addons_related_style[0];
	$trx_addons_related_columns = empty($trx_addons_related_style[1]) ? 1 : max(1, $trx_addons_related_style[1]);
	
	trx_addons_get_template_part('templates/tpl.posts-related.php',
										'trx_addons_args_related',
										apply_filters('trx_addons_filter_args_related', array(
															'class' => 'dishes_page_related sc_dishes sc_dishes_'.esc_attr($trx_addons_related_type),
															'posts_per_page' => $trx_addons_related_columns,
															'columns' => $trx_addons_related_columns,
															'template' => TRX_ADDONS_PLUGIN_CPT . 'dishes/tpl.'.trim($trx_addons_related_type).'-item.php',
															'template_args_name' => 'trx_addons_args_sc_dishes',
															'post_type' => TRX_ADDONS_CPT_DISHES_PT,
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