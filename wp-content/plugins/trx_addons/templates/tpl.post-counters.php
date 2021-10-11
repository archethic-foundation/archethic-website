<?php
/**
 * The template to show post's counters: views, likes, comments
 *
 * Used for widget and shortcode Recent News and many other shortcodes
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

$trx_addons_args = get_query_var('trx_addons_args_post_counters');
$trx_addons_counters = !empty($trx_addons_args['counters']) ? $trx_addons_args['counters'] : 'views,likes,comments';
?>
<div class="post_counters<?php echo !empty($trx_addons_args['class']) ? ' '.esc_attr($trx_addons_args['class']) : ''; ?>"><?php

	// Counters
	trx_addons_get_post_counters($trx_addons_counters, true);
	
	// Socials share
	if ( !empty($trx_addons_args['share']) ) {
		$trx_addons_output = trx_addons_get_share_links(array(
				'type' => 'drop',
				'caption' => esc_html__('Share', 'trx_addons'),
				'echo' => false
			));
		if ($trx_addons_output) {
			?><div class="post_counters_item post_share"><?php trx_addons_show_layout($trx_addons_output); ?></div><?php
		}
	}

	// Edit page link
	//edit_post_link( esc_html__( 'Edit', 'trx_addons' ), '<span class="post_counters_item post_counters_edit trx_addons_icon-pencil">', '</span>' );
	edit_post_link( esc_html__( 'Edit', 'trx_addons' ), '', '', 0, 'post_counters_item post_counters_edit trx_addons_icon-pencil' );

?></div><?php
