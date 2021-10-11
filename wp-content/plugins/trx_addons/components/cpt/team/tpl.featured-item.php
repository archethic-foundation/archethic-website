<?php
/**
 * The style "featured" of the Team
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

$args = get_query_var('trx_addons_args_sc_team');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = empty($args['no_links']) ? get_permalink() : '';

if ($args['slider']) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
?>
<div <?php post_class( 'sc_team_item' . (empty($post_link) ? ' no_links' : '') ); ?>>
	<?php
	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
											'allow_theme_replace' => false,
											'singular' => false,
											'no_links' => empty($link),
											'class' => 'sc_team_item_thumb',
											'hover' => !empty($meta['socials']) ? 'info' : 'zoomin',
											'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('avatar'), 'team-featured'),
											'post_info' => !empty($meta['socials']) 
														? '<div class="trx_addons_hover_content">'
															. '<h4 class="sc_team_item_title trx_addons_hover_title">'
																. (!empty($link) ? '<a href="' . esc_url($link) . '">' : '')
																	. get_the_title()
																. (!empty($link) ? '</a>' : '')
															. '</h4>'
															. '<div class="sc_team_item_subtitle trx_addons_hover_title">'
																. (!empty($link) ? '<a href="' . esc_url($link) . '">' : '')
																	. esc_html($meta['subtitle'])
																. (!empty($link) ? '</a>' : '')
															. '</div>'
															. '<div class="sc_team_item_content trx_addons_hover_text">'
																. (!empty($link) ? '<a href="' . esc_url($link) . '">' : '')
																	. get_the_excerpt()
																. (!empty($link) ? '</a>' : '')
															. '</div>'
															. '<div class="sc_team_item_socials socials_wrap trx_addons_hover_info">' . trim(trx_addons_get_socials_links_custom($meta['socials'])) . '</div>'
															. '</div>'
														: ''
											), 'team-featured')
								);
	?>
</div>
<?php
if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
?>