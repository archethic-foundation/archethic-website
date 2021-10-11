<?php
/**
 * The style "default" of the Events
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
	$date = tribe_get_start_date(null, true, 'd-M');
	if (empty($date)) $date = get_the_date('d-M');
	$date = explode('-', $date);
	?><span class="sc_events_item_date">
		<span class="sc_events_item_day"><?php echo esc_html($date[0]); ?></span>
		<span class="sc_events_item_month"><?php echo esc_html($date[1]); ?></span>
	</span><?php
	// Event's title
	?><span class="sc_events_item_title"><?php the_title(); ?></span><?php
	// Arrow (button)
	?><span class="sc_events_item_button"></span><?php
?></a><?php

if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}

?>