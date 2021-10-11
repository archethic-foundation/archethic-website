<?php
/**
 * The style "detailed" of the Events item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_events');

if ($args['slider']) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}

?><a href="<?php echo esc_url(get_permalink()); ?>" class="sc_events_item"><?php
	// Event's date
	$date = tribe_get_start_date(null, true, 'M. d');
	if (empty($date)) $date = get_the_date('M. d');
	$time = tribe_get_start_time(null, 'g:i A');
	// Event's date
	?><span class="sc_events_item_date_wrap"><span class="sc_events_item_date"><?php echo esc_html($date); ?></span></span><?php
	// Event's title
	?><span class="sc_events_item_title_wrap"><span class="sc_events_item_title"><?php the_title(); ?></span></span><?php
	// Event's time
	?><span class="sc_events_item_time_wrap"><span class="sc_events_item_time"><?php echo ($time ? esc_html($time) : esc_html__('Whole day', 'trx_addons')); ?></span></span><?php
	// Arrow (button)
	?><span class="sc_events_item_button_wrap"><span class="sc_events_item_button"><?php esc_html_e('Details', 'trx_addons'); ?></span></span><?php
?></a><?php

if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}

?>