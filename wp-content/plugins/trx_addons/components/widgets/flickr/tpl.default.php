<?php
/**
 * The style "default" of the Widget "Flickr"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var('trx_addons_args_widget_flickr');
extract($args);
		
// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);
	
// Widget body
?><div class="flickr_images"><?php
	if (!empty($flickr_username) && !empty($flickr_api_key)) {
		$flickr_count = max(1, $flickr_count);
		$flickr_cache = sprintf("trx_addons_flickr_data_%s_%d",$flickr_username, $flickr_count);
		$resp = get_transient($flickr_cache);
		if (true || empty($resp)) {
			$resp = trx_addons_fgc('https://api.flickr.com/services/rest'
										. '?method=flickr.people.getPhotos'
										. '&user_id='.urlencode($flickr_username)
										. '&per_page='.intval($flickr_count)
										. '&api_key='.urlencode($flickr_api_key)
										. '&format=json'
										. '&nojsoncallback=1');
			if (substr($resp, 0, 1) == '{') 
				set_transient($flickr_cache, $resp, 60*60);
		}
		if (substr($resp, 0, 1) == '{') {
			try {
				$resp = json_decode($resp, true);
			} catch(Exception $e) {
				$resp = array();
			}
			if ($resp['stat']=='ok' && !empty($resp['photos']['photo']) && is_array($resp['photos']['photo'])) {
				foreach($resp['photos']['photo'] as $v) {
					$url = sprintf('https://farm%1$s.staticflickr.com/%2$s/%3$s_%4$s', $v['farm'], $v['server'], $v['id'], $v['secret']);
					printf('<a href="%1$s_b.jpg" title="%2$s" class="'.trx_addons_add_inline_css('width:'.round(100/$flickr_columns, 4).'%').'">'
						   . '<img src="%1$s_'.($flickr_columns < 3 ? 'b' : 'q').'.jpg" alt="%2$s" width="150" height="150">'
						   . '</a>', $url, $v['title']);
				}
			}
		}
	}
?></div><?php	

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>