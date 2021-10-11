<?php

use \Elementor\Plugin;

$current_date = new \DateTime(current_time('Y-m-d H:i:s')); //Server time

try {
	$target_date = new \DateTime( $settings['date_time'] );
} catch ( Exception $e ) {
	return esc_html__( 'Invalid date.', 'stratum' );
}

if ( $current_date < $target_date ) {
	$dateTime_until = $current_date->diff( $target_date )->format( "+%yy +%mo +%dd +%hh +%im +%ss" );
} else {
	$dateTime_until = 'negative';
}

extract( shortcode_atts( array(
	'date_time'		 => $dateTime_until,
	'show_years' => 'yes',
	'show_months' => 'yes',
	'show_weeks' => 'yes',
	'show_days' => 'yes',
	'show_hours' => 'yes',
	'show_minutes' => 'yes',
	'show_seconds' => 'yes',

	'show_labels' => 'yes',
	'custom_labels' => '',
	'label_years' => 'Years',
	'label_months' => 'Months',
	'label_weeks' => 'Weeks',
	'label_days' => 'Days',
	'label_hours' => 'Hours',
	'label_minutes' => 'Minutes',
	'label_seconds' => 'Seconds',

	'stratum_expire_actions' => [],
	'message_after_expire' => '',
	'expire_redirect_url' => '',
), $settings ) );

if ($custom_labels == 'yes'){
	$custom_labels_arr = array(
		$label_years,
		$label_months,
		$label_weeks,
		$label_days,
		$label_hours,
		$label_minutes,
		$label_seconds
	);
}

$is_editor = Plugin::instance()->editor->is_edit_mode();

$countdown_options = array(
	( $show_years == 'yes' ? 'data-years="true"' : '' ),
	( $show_months == 'yes' ? 'data-months="true"' : '' ),
	( $show_weeks == 'yes' ? 'data-weeks="true"' : '' ),
	( $show_days == 'yes' ? 'data-days="true"' : '' ),
	( $show_hours == 'yes' ? 'data-hours="true"' : '' ),
	( $show_minutes == 'yes' ? 'data-minutes="true"' : '' ),
	( $show_seconds == 'yes' ? 'data-seconds="true"' : '' ),
	( $custom_labels == 'yes' ? "data-labels='".json_encode($custom_labels_arr)."'" : '' ),
	((!$is_editor && !empty( $settings['stratum_expire_actions'] )) ? "data-expire-actions='".json_encode($stratum_expire_actions)."'" : '' ),
	((!$is_editor && is_array($stratum_expire_actions) && in_array("redirect", $stratum_expire_actions) && $expire_redirect_url['url'] != '') ? "data-expire-url='".esc_url($expire_redirect_url['url'])."'" : '' ),
	((!$is_editor && is_array($stratum_expire_actions) && in_array("message", $stratum_expire_actions) && $message_after_expire != '') ? "data-expire-text='".$message_after_expire."'" : '' )
);

$countdown_options_str = implode( ' ', $countdown_options );

$widget_name = 'stratum-countdown';

$class = $block_name = 'stratum-countdown';

$wrapper_class = stratum_css_class([
	$widget_name . '__wrapper',
	($show_labels == 'yes' ? '' : 'hide_labels')
]);

$out = "";

$out .= "<div class='".esc_attr( $class )."'>";
	$out .= "<div class='".esc_attr( $wrapper_class )."'>";
		$out .= "<div class='".esc_attr( $widget_name )."__content' data-datetime='".esc_attr( !empty( $dateTime_until ) ? $dateTime_until : '' )."' ".$countdown_options_str.">";
		$out .= "</div>";
	$out .= "</div>";
$out .= "</div>";

echo sprintf("%s", $out);