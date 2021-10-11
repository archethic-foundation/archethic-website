jQuery(document).ready(function($) {
	"use strict";
	$('.cq-imgwitharrow-container').each(function(index) {
		var _this = $(this);
		var _textcolor = $(this).data('color');
		var _textbg = $(this).data('background');
		var _captionalign = $(this).data('captionalign');
		var _arrowleft = $(this).data('arrowleft');
		var _arrowtop = $(this).data('arrowtop');
		var _fontsize1 = $(this).data('fontsize1') || '13px';
		var _fontsize2 = $(this).data('fontsize2') || '11px';
		var _photo = $(this).find('.cq-imgwitharrow-photo');
		var _content = $(this).find('.cq-imgwitharrow-content');
		var _box = $(this).find('.cq-imgwitharrow-box');
		var _imageurl = _photo.data('url');
		var _iwidth = _this.data('iwidth');
		var _iheight = _this.data('iheight');
		var _twidth = _this.data('twidth');
		var _theight = _this.data('theight');
		var _arrowsize = _this.data('arrowsize');

		var _bordersizelarge = _arrowsize == "large" ? '20px' : '10px';
		var _borderoffsetlarge = _arrowsize == "large" ? '40px' : '20px';

		if(_imageurl!=""){
			_photo.css('background', 'url(' + _imageurl + ')');
			_photo.css({
				'background': 'url(' + _imageurl + ')',
				'background-size': 'cover',
				'background-position': 'center center'
			});
		}
		if(_textcolor){
			_content.css('color', _textcolor);
			_content.find('h2, h3, h4, h5').css('color', _textcolor);
			$(this).find('.cq-arrowborder1, .cq-arrowborder3').css({
				'background': _textbg
			});
			if(_captionalign=="right"){
				$(this).find('.cq-arrowborder1').css('height', _arrowtop);
				$(this).find('.cq-arrowborder2').css({
					'border-top': _bordersizelarge + ' solid ' + _textbg,
					'border-left': _bordersizelarge + ' solid transparent',
					'border-bottom': _bordersizelarge + ' solid ' + _textbg,
					'border-right': _bordersizelarge + ' solid ' + _textbg
				});
				_box.css({
					'left': 'calc(' + _iwidth + ' - '+ _bordersizelarge +')',
					'width': 'calc(' + _twidth + ' + '+ _bordersizelarge +')'
				});
			}
			if(_captionalign=="left"){
				$(this).find('.cq-arrowborder1').css('height', _arrowtop);
				$(this).find('.cq-arrowborder2').css({
					'border-top': _bordersizelarge + ' solid ' + _textbg,
					'border-left': _bordersizelarge + ' solid ' + _textbg,
					'border-bottom': _bordersizelarge + ' solid ' + _textbg,
					'border-right': _bordersizelarge + ' solid transparent'
				});
				_photo.css({'left': 'calc(' + _twidth + ' - '+ _bordersizelarge +')' });

			}
			if(_captionalign=="top"){
				$(this).find('.cq-arrowborder1').css('width', _arrowleft);
				if(_arrowleft>0) $(this).find('.cq-arrowborder3').css('width', 'calc(100% - ' + _arrowleft + 'px - ' + _borderoffsetlarge +')');
				else $(this).find('.cq-arrowborder3').css('width', 'calc(100% - ' + _arrowleft + ' - ' + _borderoffsetlarge +')');
				$(this).find('.cq-arrowborder2').css({
					'border-top': _bordersizelarge + ' solid ' + _textbg,
					'border-left': _bordersizelarge + ' solid ' + _textbg,
					'border-bottom': _bordersizelarge + ' solid transparent',
					'border-right': _bordersizelarge + ' solid ' + _textbg
				});
				_box.css({
					'height': 'calc(' + _theight + ' + ' + _bordersizelarge + ')'
				});
			}
			if(_captionalign=="bottom"){
				$(this).find('.cq-arrowborder1').css('width', _arrowleft);
				if(_arrowleft>0) $(this).find('.cq-arrowborder3').css('width', 'calc(100% - ' + _arrowleft + 'px - ' + _borderoffsetlarge +')');
				else $(this).find('.cq-arrowborder3').css('width', 'calc(100% - ' + _arrowleft + ' - ' + _borderoffsetlarge +')');
				$(this).find('.cq-arrowborder2').css({'border-top': _bordersizelarge + ' solid transparent',
					'border-left': _bordersizelarge + ' solid ' + _textbg,
					'border-bottom': _bordersizelarge + ' solid ' + _textbg,
					'border-right': _bordersizelarge + ' solid ' + _textbg
				});
				_box.css({
					'top': 'calc(' + _iheight + ' - ' + _bordersizelarge + ')'
				});
			}
		}

		_this.find('a.cq-lightbox').boxer({
	    	fixed: true
	    });


		_this.find('.cq-imgwitharrow-content, .cq-imgwitharrow-content p').css('font-size', _fontsize1);


	});
});
