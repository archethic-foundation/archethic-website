jQuery(document).ready(function($) {
	"use strict";
	$('.appmockup-grid-container').each(function() {
		var _this = $(this);
		var _tooltipposition;
		var _width = $(this).data('width');
		var _height = $(this).data('height');
		var _margin = $(this).data('margin');
		var _offsetx = $(this).data('offsetx');
		var _offsety = $(this).data('offsety');
		var _tooltipoffsetx = $(this).data('tooltipoffsetx');
		var _tooltipoffsety = $(this).data('tooltipoffsety');
		var _imagedirection = $(this).data('imagedirection')=='l2r'?50:-50;
		var _is2d = $(this).data('is2d');
		var _isbackground = $(this).data('isbackground');
		var _bgheight = $(this).data('bgheight');
		var _retina = $(this).data('retina');
		var _transformimage = $(this).data('transformimage');

		if(_isbackground=="on"){
			$(this).parent('.appmockup-outside-container').css({
				'height': _bgheight,
				'overflow': 'hidden',
				'background': '-webkit-radial-gradient(#EFEFEF, #CCC)',
			  	'background': 'radial-gradient(#EFEFEF, #CCC)'
			});
		}

		$(this).css({
			'-webkit-transform': 'translateX(' + _offsetx + 'px) ' + 'translateY(' + _offsety + 'px)',
			'transform': 'translateX(' + _offsetx + 'px) ' + 'translateY(' + _offsety + 'px)'
		});

		if(_is2d=="off"&&_transformimage=="off"){
			$(this).find('.appmockup-grid').css({
				'-webkit-transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg)',
				'transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg)'
			});
		}

		$(this).find('li').each(function() {
			var _image = $(this).data('image');
			var _title = $(this).data('title');
			$(this).find('.appmockup-shadow').css({
				'width': _width - 50,
				'height': _height - 50
			});
			$(this).parent('a.appmockup-lightbox').boxer({
				retina: _retina=="on"?true:false,
		        fixed : true
		    });
			$(this).attr("onclick","return true");
			$(this).css({
				'width': _width,
				'height': _height,
				'margin': _margin,
				'background': '-webkit-linear-gradient(45deg, transparent, rgba(0, 0, 0, 0.2)), url("'+_image+'")',
				'background': 'linear-gradient(45deg, transparent, rgba(0, 0, 0, 0.2)), url("'+_image+'")',
				'background-size': _width + 'px ' + _height + 'px'
			});
			if(_transformimage=="on"){
				$(this).css({
					'-webkit-transform-style': 'preserve-3d',
					'transform-style': 'preserve-3d',
					'-webkit-transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg)',
					'transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg)',
					'margin-right': _width*0.5 + 20,
					'margin-bottom': -_height*0.5
				})
			}


			if(_transformimage=="on"){
				$(this).on('mouseover', function(event) {
					$(this).css({
						'-webkit-transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg) translateZ(20px)',
						'transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg) translateZ(20px)'
					});
				}).on('mouseleave', function(event) {
					$(this).css({
						'-webkit-transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg) translateZ(0px)',
						'transform': 'rotateX(60deg) rotateZ(' + _imagedirection + 'deg) translateZ(0px)'
					});
				});
			}

			if(_title!=""){
				$(this).tooltipster({
					content: _title,
					delay: 2600,
			 		animation: 'grow',
			 		position: 'top',
			 		offsetX: _width*0.25 + _tooltipoffsetx,
			 		offsetY: -_height*0.25 + _tooltipoffsety,
			 		delay: 50,
			 		theme: 'tooltipster-shadow'
			 	});

			}


		});
	});
});
