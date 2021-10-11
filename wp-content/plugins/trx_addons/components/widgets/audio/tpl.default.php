<?php
/**
 * The style "default" of the Widget "Audio"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var('trx_addons_args_widget_audio');
extract($args);

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);
	
// Widget body
?><div class="trx_addons_audio_player<?php
	echo !empty($cover) ? ' with_cover' : ' without_cover';
	?>"<?php 
	if (!empty($cover)) echo ' style="background-image:url('.esc_url($cover).');"';
?>><?php 

	if (!empty($author) || !empty($caption)) {
		?>
		<div class="audio_info">
			<?php if (!empty($author)) { ?>
				<h6 class="audio_author"><?php echo esc_html($author); ?></h6>
			<?php } ?>
			<?php if (!empty($caption)) { ?>
				<h5 class="audio_caption"><?php echo esc_html($caption); ?></h5>
			<?php } ?>
		</div>
		<?php 
	}

	?><div class="audio_frame audio_<?php echo esc_attr($embed ? 'embed' : 'local'); ?>"><?php 
		if ($embed)
			trx_addons_show_layout($embed);
		else if ($url)
			echo do_shortcode('[audio mp3="'.trim($url).'"]');
	?></div><?php

?></div><?php

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>