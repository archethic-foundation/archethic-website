jQuery(document).ready(function($) {
	"use strict";
	$('body').addClass('metro');
	var _carouselindex = 0;
	jQuery('.carousel').each(function(index) {
		var _index = index;
		_carouselindex = _index;
		var _position = $(this).data('position') || 'bottom-left';
		var _buttontype = $(this).data('buttontype') || 'default';
		var _animation = $(this).data('animation') || 'slide';
		var _containermagin = $(this).data('containermagin');
		var _carouselheight = $(this).data('carouselheight') || 300;
		var _autoplay = $(this).data('autoplay') == "yes" ? true : false;
		var _autoplayspeed = $(this).data('autoplayspeed') || 4000;
		var _carouselbgcolor = $(this).data('carouselbgcolor') || 'none';
		$(this).css({
			'background-color': _carouselbgcolor,
			'height': _carouselheight,
			'margin': _containermagin
		});
		$(this).carousel({
		    auto: _autoplay,
		    height: 300,
		    effect: _animation,
		    period: _autoplayspeed,
		    duration: 600,
		    markers: {
		    	position: _position,
		        type: _buttontype
		    }
		});

		$(this).find('.carousel-item').each(function() {
			$(this).attr('rel', 'carousel-gallery'+_index).boxer({
				fixed : true
	   		});
		});
	});
	jQuery('.tile').each(function(index) {
		var _index = index + _carouselindex + 1;
		var _slideeffect = $(this).data('slideeffect') || 'slideLeft';
		var _tileheight = $(this).data('tileheight') || 300;
		var _containermagin = $(this).data('containermagin');
		var _tileautoplayspeed = $(this).data('tileautoplayspeed') || 4000;
		$(this).css({
			'height': _tileheight,
			'margin': _containermagin
		});;
		$(this).livetile({
			effect: _slideeffect,
            period: _tileautoplayspeed,
            duration: 800,
            easing: 'easeInOutExpo'
		});
		$(this).find('.carousel-item').each(function() {
			$(this).attr('rel', 'carousel-gallery'+_index).boxer({
				fixed : true
	   		});
		});
	});


	$(window).on('resize', function(event) {
		$('.tile').each(function(index) {
			var _mintilewidth = $(this).data('mintilewidth');
			var _mintileheight = $(this).data('mintileheight');
			var _tileheight = $(this).data('tileheight') || 300;
			if($(this).width()<=_mintilewidth){
				$(this).css('height', _mintileheight);
			}else{
				$(this).css('height', _tileheight);
			}
		});
		$('.carousel').each(function(index) {
			var _mincarouselwidth = $(this).data('mincarouselwidth');
			var _mincarouselheight = $(this).data('mincarouselheight');
			var _position = $(this).data('position');
			if(_position=="top-center"||_position=="bottom-center"){
				var _markers = $(this).find('.markers');
				_markers.css({
                    left: $(this).width()/2 - _markers.width()/2,
                    right: 'auto'
                });
			}
			var _carouselheight = $(this).data('carouselheight') || 300;
			if($(this).width()<=_mincarouselwidth){
				$(this).css('height', _mincarouselheight);
			}else{
				$(this).css('height', _carouselheight);
			}
		});

	});

	$(window).trigger('resize');


});
