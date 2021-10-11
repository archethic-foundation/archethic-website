jQuery(document).ready(function($) {
	"use strict";
	$(".cq-morecaptionv2").each(function(index) {
		var _this = $(this);
		var _cover = $(".cq-morecaptionv2-cover", _this);
		var _captionby = $(this).data('captionby');
		var _autodelay = parseInt(_this.data('autodelay'), 10);

		$('.cq-morecaptionv2-close', _this).on('click', function(event) {
			event.preventDefault();
			_this.addClass('hide');
			_this.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
				if(_this.hasClass('hide')) _this.removeClass('show');
			});
		});


		var _hoverID = 0;


		var _autodelayID = 0;
        if(_autodelay > 0){
            clearTimeout(_autodelayID);
            _autodelayID = setTimeout(function(){
                _cover.trigger('click');
	            clearTimeout(_autodelayID);
            }, _autodelay*1000);
        }


		_cover.on('click', function(event) {
				if(_this.hasClass('show')){
					_this.addClass('hide');
					$('.cq-morecaptionv2-container', _this).on('transitionend webkitTransitionEnd oTransitionEnd', function () {
						if(_this.hasClass('hide')) _this.removeClass('show');
					});
				} else {
					_this.removeClass('show hide').addClass('show');
				}
				if(!_this.hasClass('cq-morecaptionv2-byhover')){}

			if(_autodelay > 0){
	            clearTimeout(_autodelayID);
	        }

		});
		_this.on('mouseover', function(event) {
			if(_autodelay > 0){
	            clearTimeout(_autodelayID);
	        }
			if(_this.hasClass('cq-morecaptionv2-byhover')){

				_this.removeClass('show hide').addClass('show');

			}
			event.preventDefault();
		}).on('mouseleave', function(event) {
			if(_this.hasClass('cq-morecaptionv2-byhover')){
				if(_this.hasClass('show')){
					clearTimeout(_hoverID);
					_hoverID = setTimeout(function(){
						_this.addClass('hide');
						_this.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
							if(_this.hasClass('hide')) _this.removeClass('show hide');
						});

					}, 500);
				}

			}
			event.preventDefault();
		});

	})

});
