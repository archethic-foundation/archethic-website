jQuery(document).ready(function($) {
	"use strict";
	$('.cqcarousel-container').each(function(index) {
		var _this = $(this);
		var _slidestoshow = $(this).data('slidestoshow');
		var _thumbstoshow = $(this).data('thumbstoshow');
		var _imgnum = $(this).data('imgnum');
		var _containerwidth = $(this).data('containerwidth') || '100%';
		var _dots = $(this).data('dots')=="yes"?true:false;
		var _arrows = $(this).data('arrows')=="yes"?true:false;
		var _isgallery = $(this).data('isgallery');
		var _largeimagearrows = $(this).data('largeimagearrows')=="yes"?true:false;
		var _focusonselect = _isgallery == "is-gallery" ? true : false;
		var _displaynum = _isgallery == "is-gallery" ? _thumbstoshow : _slidestoshow;
		var _autoplay = $(this).data('autoplay')=="yes"?true:false;
		var _autoplayspeed = $(this).data('autoplayspeed') || 5000;
		var _largeimagearrows = $(this).data('largeimagearrows')=="yes"?true:false;
		var _containermaxwidth = $(this).data('containermaxwidth') || '960px';
		var _bottomversion = $(this).data('dotbottom') || $(this).data('bottomversion');
		var _lightboxmode = $(this).data('lightboxmode');
		_this.css({
			'width': _containerwidth,
			'max-width': _containermaxwidth
		});
		var _index = index;
		$(window).on('resize', function(event) {
			if($(window).width()<=480){
				_this.css('width', '100%');
			}else{
				_this.css('width', _containerwidth);
			}
		});
		$(window).trigger('resize');

		if(!(_isgallery=="is-gallery")){
				if(_lightboxmode=="prettyphoto"){
					$("a[rel^='prettyPhoto']", _this).prettyPhoto({
					});
				}else{
					_this.find('a.cqcarousel-item').each(function(index) {
						$(this).attr('rel', 'cqcarousel-gallery'+_index).boxer({
							fixed : true
				   		});
					});
				}
		}

		var _gallery;
		var _slideID = 0;
		var _currentIndex = 0;
		var _thumbs;
		_gallery = $('.carousel-gallery', _this).slick({
		    slidesToShow: 1,
		    slidesToScroll: 1,
		    arrows: _largeimagearrows,
		    fade: true,
		    onBeforeChange: function(){

		    }

		});

		_gallery.on('afterChange', function(event, slick, currentSlide, nextSlide){
		    	if(_prevthumb) {
		    		_prevthumb.removeClass('slick-current')
		    	}
				_prevthumb = $('.slick-slide:eq(' + currentSlide + ')', _thumbs).addClass('slick-current');
				if(!_prevthumb.hasClass('slick-active')) _thumbs.slick('slickGoTo', currentSlide);
		    	_currentIndex = currentSlide;
		    	if(_autoplay) _slideshow();
        });


		if(_isgallery=="is-gallery"&&_autoplay) {
	        function _slideshow(){
	            clearTimeout(_slideID);
	            _slideID = setTimeout(function() {
	            	_currentIndex++;
		            if(_currentIndex>_imgnum-1) _currentIndex = 0;
		            _gallery.slick('slickGoTo', _currentIndex);
			    	if(_prevthumb) {
			    		_prevthumb.removeClass('slick-current')
			    	}
					_prevthumb = $('.slick-slide:eq(' + _currentIndex + ')', _thumbs).addClass('slick-current');
					if(!_prevthumb.hasClass('slick-active')) _thumbs.slick('slickGoTo', _currentIndex);

	            }, _autoplayspeed);
	        }
	        _slideshow();

		}

		var _thumbSlideID = 0;
		var _thumbautoplay = false;
		if(!_isgallery!="is-gallery") _thumbautoplay = _autoplay;
		if(_isgallery!="is-gallery"&&_thumbautoplay) {
	        function _thumbSlideshow(){
	            clearTimeout(_thumbSlideID);
	            _thumbSlideID = setTimeout(function() {
	            	_currentIndex++;
		            if(_currentIndex>_imgnum-_displaynum) _currentIndex = 0;
					_thumbs.slick('slickGoTo', _currentIndex);

	            }, _autoplayspeed);
	        }
	        _thumbSlideshow();

		}



		_gallery.on('mouseover', function(event) {
			var _prevbtn = $(this).find('.slick-prev');
			var _nextbtn = $(this).find('.slick-next');
			_prevbtn.show().animate({opacity: 1}, 300);
			_nextbtn.show().animate({opacity: 1}, 300);
			if(_autoplay) clearTimeout(_slideID);
		}).on('mouseleave', function(event) {
			var _prevbtn = $(this).find('.slick-prev');
			var _nextbtn = $(this).find('.slick-next');
			_nextbtn.animate({
				opacity: 0},
				300, function() {
					$(this).hide();
			});
			_prevbtn.animate({
				opacity: 0},
				300, function() {
					$(this).hide();
			});
			if(_autoplay) _slideshow();
		});



		if(_isgallery=="is-gallery"){
			_thumbs = $('.carousel-thumb', _this).slick({
				infinite: false,
			    slidesToShow: _displaynum,
			    slidesToScroll: 1,
			    autoplay: _thumbautoplay,
			    autoplaySpeed: _autoplayspeed,
			    arrows: _arrows,
			    dots: _dots
			});

		}else{
			_thumbs = $('.carousel-thumb', _this).slick({
				infinite: false,
			    slidesToShow: _displaynum,
			    slidesToScroll: 1,
			    arrows: _arrows,
			    dots: _dots
			});

			_thumbs.on('afterChange', function(event, slick, currentSlide, nextSlide){
				var _index = currentSlide;
				_thumbs.slick('slickGoTo', _index);
		    	_currentIndex = _index;
		    	if(_thumbautoplay) _thumbSlideshow();
	        });



		}


		if(_bottomversion!=""){
			_thumbs.find('.slick-dots').css('bottom', _bottomversion);
		}


		_thumbs.on('mouseover', function(event) {
			var _prevbtn = $(this).find('.slick-prev');
			var _nextbtn = $(this).find('.slick-next');
			_prevbtn.show().animate({opacity: 1}, 300);
			_nextbtn.show().animate({opacity: 1}, 300);
			if(_thumbautoplay&&!(_isgallery=="is-gallery")) clearTimeout(_thumbSlideID);
		}).on('mouseleave', function(event) {
			var _prevbtn = $(this).find('.slick-prev');
			var _nextbtn = $(this).find('.slick-next');
			_nextbtn.animate({
				opacity: 0},
				300, function() {
					$(this).hide();
			});
			_prevbtn.animate({
				opacity: 0},
				300, function() {
					$(this).hide();
			});
			if(_thumbautoplay&&!(_isgallery=="is-gallery")) _thumbSlideshow();
		});

		var _prevthumb = null;
		$('.slick-slide', _thumbs).each(function(index) {
			if($(this).attr('title')!=""){
				$(this).tooltipster({
			 		animation: 'grow',
			 		position: 'top',
			 		delay: 50,
			 		theme: 'tooltipster-shadow'
			 	});
			}

			if(index==0){
				_prevthumb = $(this).addClass('slick-current');
			}
			$(this).on('click', function(event) {
				if(_prevthumb) _prevthumb.removeClass('slick-current')
				_gallery.slick('slickGoTo', $(this).data('slickIndex'));
				_currentIndex = $(this).data('slickIndex');
				_prevthumb = $(this).addClass('slick-current');
			});
		});


	});


});
