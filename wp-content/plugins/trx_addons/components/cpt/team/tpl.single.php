<?php
/**
 * The template to display the team member's page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

global $TRX_ADDONS_STORAGE;

get_header();

while ( have_posts() ) { the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'team_member_page itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

		<?php do_action('trx_addons_action_before_article', 'team.single'); ?>
		
		<?php
		$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

		// Image
		if ( !trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() ) {
			?><div class="team_member_featured">
				<div class="team_member_avatar">
					<?php
					the_post_thumbnail( trx_addons_get_thumb_size('masonry-big'), trx_addons_seo_image_params(array(
								'alt' => get_the_title()
								))
							);
					?>
				</div>
				<?php			
				if (!empty($meta['socials'])) {
					?><div class="team_member_socials socials_wrap"><?php trx_addons_show_layout(trx_addons_get_socials_links_custom($meta['socials'])); ?></div><?php
				}
				?>
			</div>
			<?php
		}
		
		// Title and Description
		?><div class="team_member_description"><?php
			if ( !trx_addons_sc_layouts_showed('title') ) {
				?><h2 class="team_member_title"><?php the_title(); ?></h2><?php
			}
			?>
			<h6 class="team_member_position"><?php echo esc_html($meta['subtitle']); ?></h6>
			<div class="team_member_details">
				<?php
				$meta_box = trx_addons_meta_box_get(get_post_type());
				foreach ($meta_box as $k=>$v) {
					if (!empty($v['details']) && !empty($meta[$k])) {
						?><div class="team_member_details_<?php echo esc_attr($k); ?>"><span class="team_member_details_label"><?php echo esc_html($v['title']); ?>: </span><span class="team_member_details_value"><a href="mailto:<?php echo antispambot($meta[$k]); ?>"><?php echo esc_html($meta[$k]); ?></a></span></div><?php
					}
				}
				?>
			</div>
			<?php
			if (!empty($meta['brief_info'])) {
				?>
				<div class="team_member_brief_info">
					<h5 class="team_member_brief_info_title"><?php esc_attr_e('Brief info', 'themerex'); ?></h5>
					<div class="team_member_brief_info_text"><?php echo wpautop($meta['brief_info']); ?></div>
				</div>
				<?php
			}
			?>
		</div>
		<?php

		// Post content
		?><div class="team_member_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
			the_content( );
		?></div><!-- .entry-content --><?php

		do_action('trx_addons_action_after_article', 'team.single');

	?></article><?php

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>