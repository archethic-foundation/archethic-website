<?php
/**
 * The template to display service's details page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.35
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'services_page post_details_page' ); ?>>
	
	<section class="services_page_header post_details_page_header">	

		<?php
		// Get post meta: price, icon, etc.
		$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
		
		// Image
		if ( has_post_thumbnail() ) {
			?><div class="services_page_featured post_details_page_featured">
				<?php
				the_post_thumbnail( trx_addons_get_thumb_size('huge'), trx_addons_seo_image_params(array(
							'alt' => get_the_title()
							))
						);
				?>
			</div>
			<?php
		}
		
		// Title
		?><h2 class="services_page_title post_details_page_title"><?php 
			the_title();
			// Price
			if (trim($meta['price']) != '') {
				?><span class="services_page_price post_details_page_price"><?php echo esc_html($meta['price']); ?></span><?php
			}
		?></h2>
	</section>
	<?php

	// Post content
	?><section class="services_page_content post_details_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
		the_content( );
	?></section><!-- .entry-content --><?php

	// Buttons
	if ( comments_open() || get_comments_number() || $meta['product'] > 0) {
		?><section class="services_page_button post_details_page_button sc_item_button"><?php
			if ( comments_open() || get_comments_number() ) {
				?><a href="<?php echo esc_url(get_comments_link()); ?>" class="sc_button"><?php esc_html_e('Comments', 'trx_addons'); ?></a><?php
			}
			if ($meta['product'] > 0) {
				?><a href="<?php echo esc_url(get_permalink($meta['product'])); ?>" class="sc_button"><?php esc_html_e('Order now', 'trx_addons'); ?></a><?php
			}
		?></section><?php
	}
	?>

</article>