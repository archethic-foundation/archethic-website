jQuery(document).ready(function($) {
	"use strict";
	var touch = Modernizr.touch;
	$('.cq-parallaxcontainer').each(function(index) {
		var _this = $(this);
		var _speed = $(this).data('speed') || 0.2;
		var _coverratio = $(this).data('coverratio') || 0.75;
		var _holderminheight = $(this).data('holderminheight') || 200;
		var _holdermaxheight = $(this).data('holdermaxheight') == "" ? null : parseInt($(this).data('holdermaxheight'));
		var _extraheight = $(this).data('extraheight') == "" ? 0 : parseInt($(this).data('extraheight'));
		var _linkArr = [];
		var _target = $(this).data('target');
		$('.cq-parallaximage', _this).each(function(linkIndex) {
			_linkArr[linkIndex] = $(this).data('link');
			var _link = $(this).data('link');
			if(_link!="") $(this).css('cursor', 'pointer');
			$(this).on('click', function(event) {
					var _link = $(this).data('link');
					if(_link&&_link!=""){
						if(_target=="_blank"){
							window.open(_link);
						}else{
							window.location = _link;
						}
					}

			});


		});
		$('.cq-parallaximage', _this).imageScroll({
		  container: _this,
		  speed: _speed,
		  coverRatio: _coverratio,
		  holderMinHeight: _holderminheight,
          holderMaxHeight: _holdermaxheight,
          extraHeight: _extraheight,
		  coverRatio: _coverratio,
		  holderClass: 'cq-parallaximgholder',
		  touch: touch
		});

		var _imageLength = $('.cq-parallaximage', _this).length;
		$('.cq-parallaximgholder', _this).each(function(holderIndex) {
			if(_linkArr[holderIndex]!="") $(this).css('cursor', 'pointer');
			$(this).data('index', _imageLength - holderIndex - 1);
			$(this).on('click', function(event) {
					var _link = _linkArr[$(this).data('index')];
					if(_link&&_link!=""){
						if(_target=="_blank"){
							window.open(_link);
						}else{
							window.location = _link;
						}
					}

			});
		});



	});



});
