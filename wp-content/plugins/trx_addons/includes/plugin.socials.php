<?php
/**
 * Social share and profiles
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Return share URL for the specified network
if ( !function_exists( 'trx_addons_get_share_url' ) ) {
	function trx_addons_get_share_url($soc='') {
		$list = array(
			'blogger' =>		'http://www.blogger.com/blog_this.pyra?t&u={link}&n={title}',
			'bobrdobr' =>		'http://bobrdobr.ru/add.html?url={link}&title={title}&desc={descr}',
			'delicious' =>		'http://delicious.com/save?url={link}&title={title}&note={descr}',
			'designbump' =>		'http://designbump.com/node/add/drigg/?url={link}&title={title}',
			'designfloat' =>	'http://www.designfloat.com/submit.php?url={link}',
			'digg' =>			'http://digg.com/submit?url={link}',
			'evernote' =>		'https://www.evernote.com/clip.action?url={link}&title={title}',
			'email' =>			'mailto:'.get_bloginfo('admin_email').'?subject={title}&body={link}',
//			'facebook' =>		'http://www.facebook.com/sharer.php?s=100&p[url]={link}&p[title]={title}&p[summary]={descr}&p[images][0]={image}',
			'facebook' =>		'http://www.facebook.com/sharer/sharer.php?u={link}',
			'friendfeed' =>		'http://www.friendfeed.com/share?title={title} - {link}',
			'google' =>			'http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk={link}&title={title}&annotation={descr}',
			'gplus' => 			'https://plus.google.com/share?url={link}', 
			'identi' => 		'http://identi.ca/notice/new?status_textarea={title} - {link}', 
			'juick' => 			'http://www.juick.com/post?body={title} - {link}',
			'linkedin' => 		'http://www.linkedin.com/shareArticle?mini=true&url={link}&title={title}&summary={descr}', 
			'liveinternet' =>	'http://www.liveinternet.ru/journal_post.php?action=n_add&cnurl={link}&cntitle={title}',
			'livejournal' =>	'http://www.livejournal.com/update.bml?event={link}&subject={title}',
			'mail' =>			'http://connect.mail.ru/share?url={link}&title={title}&description={descr}&imageurl={image}',
			'memori' =>			'http://memori.ru/link/?sm=1&u_data[url]={link}&u_data[name]={title}', 
			'mister-wong' =>	'http://www.mister-wong.ru/index.php?action=addurl&bm_url={link}&bm_description={title}', 
			'mixx' =>			'http://chime.in/chimebutton/compose/?utm_source=bookmarklet&utm_medium=compose&utm_campaign=chime&chime[url]={link}&chime[title]={title}&chime[body]={descr}', 
			'moykrug' =>		'http://share.yandex.ru/go.xml?service=moikrug&url={link}&title={title}&description={descr}',
			'myspace' =>		'http://www.myspace.com/Modules/PostTo/Pages/?u={link}&t={title}&c={descr}', 
			'newsvine' =>		'http://www.newsvine.com/_tools/seed&save?u={link}&h={title}',
			'odnoklassniki' =>	'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl={link}&title={title}', 
			'pikabu' =>			'http://pikabu.ru/add_story.php?story_url={link}',
			'pinterest' =>		'json:{"link": "http://pinterest.com/pin/create/button/",'
									. '"script": "//assets.pinterest.com/js/pinit.js",'
									. '"style": "",'
									. '"attributes": {'
													. '"data-pin-do": "buttonPin",'
													. '"data-pin-media": "{image}",'
													. '"data-pin-url": "{link}",'
													. '"data-pin-description": "{title}",'
													. '"data-pin-custom": "true",'
													. '"nopopup": "true"'
													. '}'
									. '}',
			'posterous' =>		'http://posterous.com/share?linkto={link}&title={title}',
			'postila' =>		'http://postila.ru/publish/?url={link}&agregator=themerex',
			'reddit' =>			'http://reddit.com/submit?url={link}&title={title}', 
			'rutvit' =>			'http://rutvit.ru/tools/widgets/share/popup?url={link}&title={title}', 
			'stumbleupon' =>	'http://www.stumbleupon.com/submit?url={link}&title={title}', 
			'surfingbird' =>	'http://surfingbird.ru/share?url={link}', 
			'technorati' =>		'http://technorati.com/faves?add={link}&title={title}', 
			'tumblr' =>			'http://www.tumblr.com/share?v=3&u={link}&t={title}&s={descr}', 
			'twitter' =>		'https://twitter.com/intent/tweet?text={title}&url={link}',
			'vk' =>				'http://vk.com/share.php?url={link}&title={title}&description={descr}',
			'vk2' =>			'http://vk.com/share.php?url={link}&title={title}&description={descr}',
			'vkontakte' =>		'http://vk.com/share.php?url={link}&title={title}&description={descr}',
			'webdiscover' =>	'http://webdiscover.ru/share.php?url={link}',
			'yahoo' =>			'http://bookmarks.yahoo.com/toolbar/savebm?u={link}&t={title}&d={descr}',
			'yandex' =>			'http://zakladki.yandex.ru/newlink.xml?url={link}&name={title}&descr={descr}',
			'ya' =>				'http://my.ya.ru/posts_add_link.xml?URL={link}&title={title}&body={descr}',
			'yosmi' =>			'http://yosmi.ru/index.php?do=share&url={link}'
		);
		return $soc 
					? (isset($list[$soc]) 
						? $list[$soc] 
						: '') 
					: $list;
	}
}


// Return (and show) share social links
if (!function_exists('trx_addons_get_share_links')) {
	function trx_addons_get_share_links($args) {

		$args = array_merge(array(
			'post_id' => 0,						// post ID
			'post_link' => '',					// post link
			'post_title' => '',					// post title
			'post_descr' => '',					// post descr
			'post_thumb' => '',					// post featured image
			'size' => 'tiny',					// icons size: tiny|small|medium|big
			'style' => trx_addons_get_setting('socials_type')=='images' ? 'bg' : 'icons', // style for show icons: icons|images|bg
			'type' => 'block',					// share block type: list|block|drop
			'popup' => true,					// open share url in new window or in popup window
			'counters' => true,					// show share counters
			'direction' => 'horizontal',		// share block direction
			'caption' => esc_html__('Share:', 'trx_addons'),			// share block caption
			'before' => '',						// HTML-code before the share links
			'after' => '',						// HTML-code after the share links
			'echo' => true						// if true - show on page, else - only return as string
			), $args);

		
		if (empty($args['post_id']))	$args['post_id'] = get_the_ID();
		if (empty($args['post_link']))	$args['post_link'] = get_permalink();
		if (empty($args['post_title']))	$args['post_title'] = get_the_title();
		if (empty($args['post_descr']))	$args['post_descr'] = strip_tags(get_the_excerpt());
		if (empty($args['post_thumb']))	{
			$args['post_thumb'] = trx_addons_get_attachment_url( get_post_thumbnail_id( $args['post_id'] ), trx_addons_get_thumb_size('big') );
		}
		
		$output = '';
		
		$list = trx_addons_get_option('share');

		if (is_array($list)) {
			foreach ($list as $social) {
				$sn = $social['name'];
				$fn = $args['style']=='icons' ? str_replace(array('icon-', 'trx_addons_icon-'), '', $sn) : trx_addons_get_file_name($sn);
				$title = !empty($social['title']) ? $social['title'] : ucfirst($fn);
				$url = $social['url'];
				if (substr($url, 0, 5) == 'json:') {
					$url = json_decode(substr($url, 5), true);
					if (is_null($url))
						continue;
				} else {
					$url = array('link' => $url);
				}
				if (!isset($url['attributes']))
					$url['attributes'] = array();
				$url['attributes']['href'] = $url['link'];
				$email = strpos($url['link'], 'mailto:')!==false;
				$popup = !empty($args['popup']) && !$email && empty($url['attributes']['nopopup']);
				if (!empty($popup))
					$url['attributes']['data-link'] = $url['link'];
				else
					$url['attributes']['target'] = '_blank';
				if ($args['counters'])
					$url['attributes']['data-count'] = $fn;				
				$output .= '<a class="social_item'.(!empty($popup) ? ' social_item_popup' : '').'"';
				foreach($url['attributes'] as $k=>$v) {
					$v = str_replace(
									array('{id}', '{link}', '{title}', '{descr}', '{image}'),
									array(
										$k=='href' ? urlencode($args['post_id']) : $args['post_id'],
										$k=='href' ? urlencode($args['post_link']) : $args['post_link'],
										$k=='href' && !$email ? urlencode(strip_tags($args['post_title'])) : strip_tags($args['post_title']),
										$k=='href' && !$email ? urlencode(strip_tags($args['post_descr'])) : strip_tags($args['post_descr']),
										$k=='href' ? urlencode($args['post_thumb']) : $args['post_thumb']
										),
									$v);
					$output .= " {$k}=\"" . ($k=='href' ? esc_url($v) : esc_attr($v)) . '"';
				}
				$output .= '>'
							. '<span class="social_icon social_icon_'.esc_attr($fn).'"'
								. ($args['style']=='bg' ? ' style="background-image: url('.esc_url($sn).');"' : '')
							. '>'
								. ($args['style']=='icons' 
									? '<span class="' . esc_attr($sn) . '"></span>' 
									: ($args['style']=='images' 
										? '<img src="'.esc_url($sn).'" alt="'.esc_attr($title).'" />' 
										: '<span class="social_hover" style="background-image: url('.esc_url($sn).');"></span>'
										)
									)
								//. ($args['counters'] ? '<span class="share_counter">0</span>' : '') 
								. ($args['type']=='drop' ? '<i>' . trim($title) . '</i>' : '')
							. '</span>'
						. '</a>';
				if (!empty($url['script'])) {
					if (!is_array($url['script']))
						$url['script'] = array($url['script']);
					$i = 0;
					foreach ($url['script'] as $s) {
						$i++;
						wp_enqueue_script( "trx_addons_share_{$fn}" . ($i > 1 ? "_{$i}" : ''), $url['script'], array(), null, true );
					}
				}
				if (!empty($url['style'])) {
					if (!is_array($url['style']))
						$url['style'] = array($url['style']);
					$i = 0;
					foreach ($url['style'] as $s) {
						$i++;
						wp_enqueue_style( "trx_addons_share_{$fn}" . ($i > 1 ? "_{$i}" : ''), $url['style'], array(), null );
					}
				}
			}
		}
		
		if (!empty($output)) {
			$output = $args['before']
						. '<div class="socials_share'
							. ' socials_size_'.esc_attr($args['size'])
							. ' socials_type_'.esc_attr($args['type'])
							. ' socials_dir_'.esc_attr($args['direction'])
							. ($args['type']!='drop' ? ' socials_wrap' : '')
							. '">'
							. ($args['caption']!='' 
								? ($args['type']=='drop' 
									? '<a href="#" class="socials_caption"><span class="socials_caption_label">'.($args['caption']).'</span></a>'
									: '<span class="socials_caption">'.($args['caption']).'</span>')
								: '')
							. '<span class="social_items">'
								. $output
							. '</span>'
						. '</div>'
					. $args['after'];
			if ($args['echo']) trx_addons_show_layout($output);
		}
		return $output;
	}
}


// Return social icons links
if (!function_exists('trx_addons_get_socials_links')) {
	function trx_addons_get_socials_links($style='', $show='icons') {
		return trx_addons_get_socials_links_custom(trx_addons_get_option('socials'), $style, $show);
	}
}


// Return social icons links from array
// $show = icons|names|icons_names
if (!function_exists('trx_addons_get_socials_links_custom')) {
	function trx_addons_get_socials_links_custom($icons, $style='', $show='icons') {
		if (empty($style))
			$style = trx_addons_get_setting('socials_type')=='images' ? 'bg' : 'icons';
		$output = '';
		if (is_string($icons)) {
			$tmp = explode("\n", $icons);
			$icons = array();
			foreach ($tmp as $str) {
				$tmp2 = explode("=", trim(chop($str)));
				if (count($tmp2)==2) {
					$icons[] = array(
						'name' => (strpos($tmp2[0], 'icon-')===false ? 'trx_addons_icon-' : '') . trim($tmp2[0]),
						'url' => trim($tmp2[1])
					);
				}
			}
		}
		$show_icons = strpos($show, 'icons') !== false;
		$show_names = strpos($show, 'names') !== false;
		if (is_array($icons) && !empty($icons[0])) {
			foreach ($icons as $social) {
				$sn = $social['name'];
				$fn = $style=='icons' ? str_replace(array('icon-', 'trx_addons_icon-'), '', $sn) : trx_addons_get_file_name($sn);
				$title = !empty($social['title']) ? $social['title'] : ucfirst($fn);
				$url = $social['url'];
				if (empty($url) || strtolower($sn)=='none') continue;
				$output .= '<a target="_blank" href="'.(strpos($url, 'mailto:')!==false || strpos($url, 'skype:')!==false
										? esc_attr($url)
										: esc_url($url)
										).'"'
								. ' class="social_item social_item_style_'.esc_attr($style).' social_item_type_'.esc_attr($show).'">'
							. ($show_icons
								? '<span class="social_icon social_icon_'.esc_attr($fn).'"'
									. ($style=='bg' ? ' style="background-image: url('.esc_url($sn).');"' : '')
									. '>'
										. ($style=='icons' 
											? '<span class="' . esc_attr($sn) . '"></span>' 
											: ($style=='images' 
												? '<img src="'.esc_url($sn).'" alt="'.esc_attr($title).'" />' 
												: '<span class="social_hover" style="background-image: url('.esc_url($sn).');"></span>'))
									. '</span>'
								: '')
							. ($show_names
								? '<span class="social_name social_'.esc_attr($fn).'">' . esc_html($title) . '</span>'
								: '')
						. '</a>';
			}
		}
		return $output;
	}
}


// Add Open Graph meta tags for post/page sharing
if (!function_exists('trx_addons_add_og_tags')) {
	add_action( 'wp_head', 'trx_addons_add_og_tags', 5 );
	function trx_addons_add_og_tags() {
		global $wp_query;
		if ( is_admin() || (int) trx_addons_get_option('add_og_tags') == 0) return;
		if (is_singular() && (!isset($wp_query->is_posts_page) || $wp_query->is_posts_page!=1)) {
			?><meta property="og:url" content="<?php echo esc_url(get_permalink()); ?> "/>
			<meta property="og:title" content="<?php echo esc_attr( strip_tags( get_the_title() ) ); ?>" />
			<meta property="og:description" content="<?php echo esc_attr( strip_tags( strip_shortcodes( get_the_excerpt()) ) ); ?>" />  
			<meta property="og:type" content="article" /><?php
			if ( has_post_thumbnail(get_the_ID()) ) {
				?>
				<meta property="og:image" content="<?php echo esc_url( trx_addons_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>"/>
				<?php
			}
		} else {
			?><meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
			<meta property="og:description" content="<?php echo esc_attr(get_bloginfo('description', 'display')); ?>" />
			<meta property="og:type" content="website" /><?php
			$logo = apply_filters('trx_addons_filter_theme_logo', '');
			if (is_array($logo)) $logo = !empty($logo['logo']) ? $logo['logo'] : '';
			if (!empty($logo)) {
				?>
				<meta property="og:image" content="<?php echo esc_url($logo); ?>" />
				<?php
			}
		}  		
	}
}


// Add Facebook Application ID
if (!function_exists('trx_addons_add_fb_app_id')) {
	add_action( 'wp_head', 'trx_addons_add_fb_app_id', 4 );
	function trx_addons_add_fb_app_id() {
		$id = trx_addons_get_option('api_fb_app_id');
		if ( !is_admin() && !empty($id)) {
			?>
			<meta property="fb:admins" content="<?php echo esc_attr($id); ?>" />
			<?php
		}
	}
}
?>