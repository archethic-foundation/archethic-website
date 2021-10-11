<?php
/**
 * The style "square" of the Countdown
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

$args = get_query_var('trx_addons_args_sc_countdown');
$link_color = '#efa758';
if (empty($args['date']) && empty($args['time']) && !empty($args['date_time'])) {
	$tmp = explode(' ', $args['date_time']);
	$args['date'] = $tmp[0];
	if (!empty($tmp[1])) $args['time'] = $tmp[1];
}
?><div id="<?php echo esc_attr($args['id']); ?>"
		class="sc_countdown sc_countdown_<?php
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
			if (!empty($args['align']) && $args['align']!='none') echo ' align'.esc_attr($args['align']);
			?>"<?php
		if ($args['css']!='') echo ' style="'.esc_attr($args['css']).'"';
		?>
		data-date="<?php echo esc_attr(empty($args['date']) ? date('Y-m-d') : $args['date']); ?>"
        data-time="<?php echo esc_attr(empty($args['time']) ? '00:00:00' : $args['time']); ?>"
><?php

	trx_addons_sc_show_titles('sc_countdown', $args);

	?>
    <div class="sc_countdown_content sc_item_content">

    	<div class="sc_countdown_inner"><?php
	
			// Days
			?><div class="sc_countdown_item sc_countdown_days"><?php
                if ($args['type'] == 'circle') { 
					?><canvas id="<?php echo esc_attr($args['id']); ?>_days"
                    			width="90" height="90"
                    			data-max-value="366"
                                data-color="<?php echo esc_attr($link_color); ?>"></canvas><?php
				}
				?>
				<span class="sc_countdown_digits"><span></span><span></span><span></span></span>
				<span class="sc_countdown_label"><?php esc_html_e('Days', 'trx_addons'); ?></span>
			 </div><?php
			
			// Separator
			?><div class="sc_countdown_separator">:</div><?php
			 
			// Hours
			?><div class="sc_countdown_item sc_countdown_hours"><?php
				if ($args['type'] == 'circle') { 
					?><canvas id="<?php echo esc_attr($args['id']); ?>_hours"
                    			width="90" height="90"
                                data-max-value="24"
                                data-color="<?php echo esc_attr($link_color); ?>"></canvas><?php
				}
				?>
				<span class="sc_countdown_digits"><span></span><span></span></span>
				<span class="sc_countdown_label"><?php esc_html_e('Hours', 'trx_addons'); ?></span>
			</div><?php
			
			// Separator
			?><div class="sc_countdown_separator">:</div><?php
			
			// Minutes
			?><div class="sc_countdown_item sc_countdown_minutes"><?php
                if ($args['type'] == 'circle') {
					?><canvas id="<?php echo esc_attr($args['id']); ?>_minutes"
                    			width="90" height="90"
                                data-max-value="60"
                                data-color="<?php echo esc_attr($link_color); ?>"></canvas><?php
				}
				?>
				<span class="sc_countdown_digits"><span></span><span></span></span>
				<span class="sc_countdown_label"><?php esc_html_e('Minutes', 'trx_addons'); ?></span>
			</div><?php
			
			// Separator
			?><div class="sc_countdown_separator">:</div><?php
		
			// Seconds
			?><div class="sc_countdown_item sc_countdown_seconds"><?php
                if ($args['type'] == 'circle') {
					?><canvas id="<?php echo esc_attr($args['id']); ?>_seconds"
                    			width="90" height="90"
                                data-max-value="60"
                                data-color="<?php echo esc_attr($link_color); ?>"></canvas><?php
				}
				?>
				<span class="sc_countdown_digits"><span></span><span></span></span>
				<span class="sc_countdown_label"><?php esc_html_e('Seconds', 'trx_addons'); ?></span>
			</div><?php
			
			// Placeholder
			?><div class="sc_countdown_placeholder hide"></div>

         </div>
		
	</div><?php

	trx_addons_sc_show_links('sc_countdown', $args);

?></div>