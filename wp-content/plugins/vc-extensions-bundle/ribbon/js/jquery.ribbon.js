jQuery(document).ready(function($) {
	"use strict";
	$('.cq-ribbon-container').each(function(index) {
		var _ribbonwidth = $(this).data('ribbonwidth');
		var _ribbontop = $(this).data('ribbontop') || 15;
		var _ribbonleft = $(this).data('ribbonleft') || -30;
		var _ribboncolor = $(this).data('ribboncolor');
		var _textcolor = $(this).data('textcolor');
		var _containerbg = $(this).data('containerbg');
		var _textmargintop = $(this).data('textmargintop');
		var _cqribbon = $(this).find('.cq-ribbon');

		if(!$(this).find('p')[0]){
			$(this).css('box-shadow', 'none');
		}

		$(this).find('.cq-ribbon-text').css({
			'margin-top': _textmargintop,
			'color': _textcolor
		});

		if(_containerbg!=""){
			$(this).css('background-color', _containerbg);
		}

		_cqribbon.css({
			'width': _ribbonwidth,
			'height': _ribbonwidth
		});
		var _cqribbonbg = $(this).find('.cq-ribbon-bg');
		_cqribbonbg.css({
			'top': _ribbontop,
			'left': _ribbonleft,
			'width': _ribbonwidth
		});
		_cqribbonbg.find('a').css('color', _ribboncolor);
		if(_cqribbon.hasClass('left')){
			$(this).find('.cq-ribbon-bg').css({
				'left': _ribbonleft
			});
		}else{

		}

	});
});
