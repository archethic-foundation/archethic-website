<?php
/**
 * The template to display block with post meta
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

extract(get_query_var('trx_addons_args_sc_show_post_meta'));

?><div class="<?php echo esc_attr($sc); ?>_post_meta post_meta"><?php
	$components = explode(',', $args['components']);
	foreach ($components as $comp) {
		$comp = trim($comp);
		// Post categories
		if ($comp == 'categories') {
			?><span class="post_meta_item post_categories"><?php the_category( ', ' ); ?></span><?php

		// Post tags
		} else if ($comp == 'tags') {
			the_tags( '<span class="post_meta_item post_tags">', ', ', '</span>' );

		// Post date
		} else if ($comp == 'date' && in_array( get_post_type(), array( 'post', 'page', 'attachment' ) ) ) {
			?><span class="post_meta_item post_date<?php if (!empty($args['seo'])) echo ' date updated'; ?>"<?php if (!empty($args['seo'])) trx_addons_seo_snippets('datePublished'); ?>><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo wp_kses_data(apply_filters('trx_addons_filter_get_post_date', get_the_date())); ?></a></span><?php

		// Post author
		} else if ($comp == 'author') {
			$author_id = get_the_author_meta('ID');
			if (empty($author_id) && !empty($GLOBALS['post']->post_author))
				$author_id = $GLOBALS['post']->post_author;
			if ($author_id > 0) {
				$author_link = get_author_posts_url($author_id);
				$author_name = get_the_author_meta('display_name', $author_id);
				?><span class="post_meta_item post_author"><a rel="author" href="<?php echo esc_url($author_link); ?>"><?php
					echo esc_html($author_name);
				?></a></span><?php
			}

		// Post counters
		} else if ($comp == 'counters') {
			echo str_replace('post_counters_item', 'post_meta_item post_counters_item', trx_addons_get_post_counters($args['counters']));

		// Socials share
		} else if ($comp == 'share') {
			$output = trx_addons_get_share_links(array(
					'type' => 'drop',
					'caption' => esc_html__('Share', 'trx_addons'),
					'echo' => false
				));
			if ($output) {
				?><span class="post_meta_item post_share"><?php trx_addons_show_layout($output); ?></span><?php
			}

		// Edit page link
		} else if ($comp == 'edit') {
			//edit_post_link( esc_html__( 'Edit', 'trx_addons' ), '<span class="post_meta_item post_edit">', '</span>' );
			edit_post_link( esc_html__( 'Edit', 'trx_addons' ), '', '', 0, 'post_meta_item post_edit trx_addons_icon-pencil' );
		}
	}
?></div><!-- .post_meta -->