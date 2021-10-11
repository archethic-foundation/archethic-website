<?php

//Settings
$text = 					($type == 'php') ? $settings['text'] : 						'{{{settings.text}}}';
$show_percents = 			($type == 'php') ? $settings['show_percents'] : 			'{{{settings.show_percents}}}';
$value = 					($type == 'php') ? $settings['value'] : 					'{{{settings.value}}}';
$round = 					($type == 'php') ? $settings['round'] : 					'{{{settings.round}}}';
$circle = 					($type == 'php') ? $settings['circle'] : 					'{{{settings.circle}}}';
$padding = 					($type == 'php') ? $settings['padding'] : 					'{{{settings.padding}}}';
$widget_width = 			($type == 'php') ? $settings['widget_width'] : 				'{{{settings.widget_width}}}';
$thickness = 				($type == 'php') ? $settings['thickness'] : 				'{{{settings.thickness}}}';
$line_color = 				($type == 'php') ? $settings['line_color'] : 				'{{{settings.line_color}}}';
$background_color = 		($type == 'php') ? $settings['background_color'] : 			'{{{settings.background_color}}}';

//=======================RENDER TYPE=======================
$js_settings = '';

//-----------PHP-----------
if ( $type == 'php' ) {
	$options = [
		'min' =>  0,
		'max' =>  100,
		'value' => isset($value['size']) ? $value['size'] : $value,
		'text' => ($show_percents == 'yes' ? true : false),
		'round' => ($round == 'yes' ? true : false),
		'circle' => ($circle == 'yes' ? true : false),
		'padding' => isset($padding['size']) ? $padding['size'] : $padding,
		'radius' => ($widget_width['size'] / 2),
		'thickness' => isset($thickness['size']) ? $thickness['size'] : $thickness,
		'bg' => $background_color,
		'color' => $line_color
	];

	$this->add_render_attribute( 'widget', [
		'class' => [ 'stratum-circle-progress-bar' ]
	] );

	$this->add_render_attribute( 'wrapper', [
		'class' => 'stratum-circle-progress-bar__wrapper',
		'data-options' => json_encode( $options )
	] );
//-----------/PHP-----------

}
//-----------JS (BACKBONE)-----------
elseif ( $type == 'js' ) {
	$js_settings = "
		<#
			const options = {
				min:  0,
				max:  100,
				value: (settings.value.size != '' ? settings.value.size : 0),
				text: (settings.show_percents == 'yes' ? true : false),
				round: (settings.round == 'yes' ? true : false),
				circle: (settings.circle == 'yes' ? true : false),
				padding: settings.padding.size,
				radius: (settings.widget_width.size / 2),
				thickness: settings.thickness.size,
				bg: settings.background_color,
				color: settings.line_color
			};

			view.addRenderAttribute( 'widget', {
				'class': [ 'stratum-circle-progress-bar' ]
			} );

			view.addRenderAttribute( 'wrapper', {
				'class': [ 'stratum-circle-progress-bar__wrapper' ],
				'data-options': JSON.stringify(options),
			} );
		#>
	";
}
//-----------/JS (BACKBONE)-----------

//Render attr
$attr_widget  = ($type == 'php') ? $this->get_render_attribute_string( 'widget' ) : "{{{ view.getRenderAttributeString( 'widget' ) }}}";
$attr_wrapper =	($type == 'php') ? $this->get_render_attribute_string( 'wrapper' ):	"{{{ view.getRenderAttributeString( 'wrapper' ) }}}";

$out = "";

	$out .= $js_settings;

	$out .= "<div ".$attr_widget.">";
			$out .= "<div ".$attr_wrapper.">";
				if ( $show_percents != 'yes' ) {
					if ( $type == 'php' ) {
						if ( ! empty( $text ) ) {
							$out .= "<span class='stratum-circle-progress-bar__title'>".esc_html( $text )."</span>";
						}
					} elseif ( $type == 'js' ) {
						$out .= "<# if ( settings.show_percents == '' && settings.text != '' ) { #>";
							$out .= "<span class='stratum-circle-progress-bar__title'>".esc_html( $text )."</span>";
						$out .= "<# } #>";
					}
				}
			$out .= "</div>";
	$out .= "</div>";

echo sprintf("%s", $out);
