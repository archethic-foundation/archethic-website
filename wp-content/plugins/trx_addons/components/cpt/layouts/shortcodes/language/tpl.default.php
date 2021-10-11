<?php
/**
 * The style "default" of the WPML Language Selector
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.18
 */

$args = get_query_var('trx_addons_args_sc_layouts_language');

if (trx_addons_exists_wpml() && function_exists('icl_get_languages')) {
	?><div<?php if (!empty($args['id'])) echo ' id="' . esc_attr($args['id']) . '"'; 
		?> class="sc_layouts_language sc_layouts_menu sc_layouts_menu_default<?php
			trx_addons_cpt_layouts_sc_add_classes($args);
			?>"<?php
			if (!empty($args['css'])) echo ' style="' . esc_attr($args['css']) . '"'; 
	?>><?php
		$languages = icl_get_languages('skip_missing=1');
		if (!empty($languages) && is_array($languages)) {
			$lang_list = '';
			$lang_active = '';
			foreach ($languages as $lang) {
				if ($lang['active']) $lang_active = $lang;
				$lang_list .= "\n"
					.'<li class="menu-item'.($lang['active'] ? ' current-menu-item' : '').'"><a rel="alternate" hreflang="' . esc_attr($lang['language_code']) . '" href="' . esc_url(apply_filters('WPML_filter_link', $lang['url'], $lang)) . '">'
						. (in_array($args['flag'], array('both', 'menu')) 
							? '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['translated_name']) . '" title="' . esc_attr($lang['translated_name']) . '" />'
							: '')
						. ($args['title_menu'] != 'none'
							? '<span class="menu-item-title">' . esc_html($args['title_menu']=='name' ? $lang['translated_name'] : strtoupper($lang['language_code'])) . '</span>'
							: '')
					.'</a></li>';
			}
			if ($lang_active !== '') {
				?>
				<ul class="sc_layouts_language_menu sc_layouts_dropdown sc_layouts_menu_nav">
					<li class="menu-item menu-item-has-children">
						<a href="#"><?php
							if (in_array($args['flag'], array('both', 'title'))) {
								?><img src="<?php echo esc_url($lang_active['country_flag_url']); ?>" alt="<?php echo esc_attr($lang_active['translated_name']); ?>" title="<?php echo esc_attr($lang_active['translated_name']); ?>" /><?php
							}
							if ($args['title_link'] != 'none') {
								?><span class="menu-item-title"><?php echo esc_html($args['title_link']=='name' ? $lang_active['translated_name'] : strtoupper($lang_active['language_code'])); ?></span><?php
							}
						?></a><?php
						if (count($languages) > 1) {
							?><ul><?php trx_addons_show_layout($lang_list); ?></ul><?php
						}
						?>
					</li>
				</ul>
				<?php
			}
		}
	?></div><!-- /.sc_layouts_language --><?php

	trx_addons_sc_layouts_showed('language', true);
}
?>