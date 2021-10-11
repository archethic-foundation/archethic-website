jQuery(document).ready(function($) {
	"use strict";
	$('.zoomimage').each(function(index) {
		var _this = $(this);
		var _position = $(this).data('position') || 'bottom';
		var _background = $(this).data('background');
		var _width = $(this).data('width');
		var _height = $(this).data('height');
		var _marginmax = $(this).data('marginmax')==undefined?80:$(this).data('marginmax');
		var _marginmin = $(this).data('marginmin')==undefined?20:$(this).data('marginmin');
		var _containerbgcolor = $(this).data('containerbgcolor');
		var _retina = $(this).data('retina') == "yes" ? true : false;
		$(this).css({
			'width': _width,
			'height': _height
		}).zoomer({
			controls: {
				position: _position
			},
			increment: 0.01,
			retina: _retina,
			marginMax: _marginmax,
			marginMin: _marginmin
		});
		$(this).find('.zoomer').css({
			'background-color': _containerbgcolor,
			'background-image': 'url(' + _background + ')',
			'background-repeat': 'repeat'
		});
	});
	$(window).on('resize', function(event) {
		$(".zoomimage").zoomer("resize");
	});



});
