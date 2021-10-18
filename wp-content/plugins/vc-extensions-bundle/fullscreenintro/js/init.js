jQuery(document).ready(function($) {
	"use strict";
	$('.cq-fullscreen-intro').each(function(index) {
		var _this = $(this);
		var _backgroundtype = $(this).data('backgroundtype');
		var _backgroundcolor = $(this).data('backgroundcolor');
		var _image = $(this).data('image');
		var _imagerepeat = $(this).data('imagerepeat');
		var _textcolor = $(this).data('textcolor') || '#fff';
		var _textsize = $(this).data('textsize') || '2em';
		var _textfamily = $(this).data('textfamily');
		var _textposition = $(this).data('textposition');
		var _scrollto = $(this).data('scrollto');
		var _scrolloffset = $(this).data('scrolloffset');
		var _scrollspeed = $(this).data('scrollspeed') || 1000;
		var _containerheight = $(this).data('containerheight') || '100vh';
		var _textclickable = $(this).data('textclickable') == "yes" ? true : false;

		$(this).css({
			'height': _containerheight,
			'color': _textcolor,
			'font-size': _textsize,
			'font-family': _textfamily,
			'background-color': _backgroundcolor
		});

		$(this).find('i').css({
			'color': _textcolor
		});

		if(_image!=""&&_backgroundtype=="image"){
			$(this).css({
				'background-image': 'url('+_image+')'
			});
			if(_imagerepeat=="no-repeat"){
				$(this).css({
					'background-size': 'cover'
				});
			}else{
				$(this).css({
					'background-repeat': 'repeat'
				});
			}
		}
		$('.cq-intro-text', _this).css({
			'top': _textposition
		});
		if(_textclickable){
			$('.cq-intro-text', _this).css('cursor', 'pointer').on('click', function(event) {
				$.smoothScroll({
			      offset: _scrolloffset,
			      speed: _scrollspeed,
			      scrollTarget: _scrollto
			    });
			    return false;
				event.preventDefault();
			});

		}




	});
});
