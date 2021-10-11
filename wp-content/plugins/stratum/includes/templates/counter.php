<?php

$start  = $type == 'php' ? $settings[ 'start' ]  : '{{{settings.start}}}';
$end    = $type == 'php' ? $settings[ 'end']     : '{{{settings.end}}}';
$prefix = $type == 'php' ? $settings[ 'prefix' ] : '{{{settings.prefix}}}';
$suffix = $type == 'php' ? $settings[ 'suffix' ] : '{{{settings.suffix}}}';

$duration = $type == 'php' ? $settings[ 'duration' ] : '{{{settings.duration}}}';
$numerals = $type == 'php' ? $settings[ 'numerals' ] : '{{{settings.numerals}}}';

$smooth_animation  = $type == 'php' ? $settings[ 'smooth_animation' ]  : '{{{settings.smooth_animation}}}';
$display_separator = $type == 'php' ? $settings[ 'display_separator' ] : '{{{settings.display_separator}}}';
$decimal_places    = $type == 'php' ? $settings[ 'decimal_places' ]    : '{{{settings.decimal_places}}}';
$animation_effect  = $type == 'php' ? $settings[ 'animation_effect' ]  : '{{{settings.animation_effect}}}';

$decimal_separator   = $type == 'php' ? $settings[ 'decimal_separator' ]   : '{{{settings.decimal_separator}}}';
$thousands_separator = $type == 'php' ? $settings[ 'thousands_separator' ] : '{{{settings.thousands_separator}}}';

//=======================RENDER TYPE=======================
$js_settings = '';

//-----------PHP-----------
if ( $type == 'php' ) {

	$options = [
		'start'         => !empty( $start )          ? $start 		   : 0,
		'end'           => !empty( $end )            ? $end            : 100,
		'decimalPlaces' => !empty( $decimal_places ) ? $decimal_places : 0,
		'duration'      => !empty( $duration )       ? $duration       : 3,

		'useEasing'     => !empty( $smooth_animation )  ? true : false,
		'useGrouping'   => !empty( $display_separator ) ? true : false,

		'separator' 	=> $thousands_separator,
		'decimal' 		=> $decimal_separator,
		'easingFn' 		=> $animation_effect,
		'numerals' 		=> $numerals
	];

	$this->add_render_attribute( 'widget', [
		'class' => [ 'stratum-counter' ]
	] );

	$this->add_render_attribute( 'wrapper', [
		'class' => 'stratum-counter__wrapper',
		'data-options' => json_encode( $options )
	] );
//-----------/PHP-----------
}
//-----------JS (BACKBONE)-----------
else if ( $type == 'js' ) {
	$js_settings = "
		<#
			const { start, end, decimal_places, duration, smooth_animation, display_separator, thousands_separator, decimal_separator, animation_effect, numerals } = settings;

			const options = {
				start: start != '' ? start: 0,
				end:   end   != '' ? end:   0,

				decimalPlaces: decimal_places != '' ? decimal_places : 0,
				duration: 	   duration       != '' ? duration       : 3,

				useEasing:   smooth_animation  != '' ? true : false,
				useGrouping: display_separator != '' ? true : false,

				separator: thousands_separator,
				decimal:   decimal_separator,
				easingFn:  animation_effect,
				numerals:  numerals
			};

			view.addRenderAttribute( 'widget', {
				'class': [ 'stratum-counter' ]
			} );

			view.addRenderAttribute( 'wrapper', {
				'class': [ 'stratum-counter__wrapper' ],
				'data-options': JSON.stringify( options )
			} );
		#>
	";
}
//-----------/JS (BACKBONE)-----------

$class = 'stratum-counter';

//Render attr
$widget_class   = $type == 'php' ? $this->get_render_attribute_string( 'widget'  ) : "{{{ view.getRenderAttributeString( 'widget' ) }}}";
$widget_wrapper = $type == 'php' ? $this->get_render_attribute_string( 'wrapper' ) : "{{{ view.getRenderAttributeString( 'wrapper' ) }}}";

$out = "";

$out .= $js_settings;


$out .= "<div ".$widget_class.">";
	$out .= "<div ".$widget_wrapper.">";
		if ( $type == 'php' ) {
			if ( ! empty( $prefix ) ) {
				$out .= "<p class='stratum-counter__prefix'>".esc_html( $prefix )."</p>";
			}
		} elseif ( $type == 'js' ) {
			$out .= "<# if ( settings.prefix != '' ) { #>";
				$out .= "<p class='stratum-counter__prefix'>".esc_html( $prefix )."</p>";
			$out .= "<# } #>";
		}

		$out .= "<span class='".esc_attr( $class )."__number'></span>";

		if ( $type == 'php' ) {
			if ( ! empty( $suffix ) ) {
				$out .= "<p class='stratum-counter__suffix'>".esc_html( $suffix )."</p>";
			}
		} elseif ( $type == 'js' ) {
			$out .= "<# if ( settings.suffix != '' ) { #>";
				$out .= "<p class='stratum-counter__suffix'>".esc_html( $suffix )."</p>";
			$out .= "<# } #>";
		}
	$out .= "</div>";
$out .= "</div>";

echo sprintf( "%s", $out );
