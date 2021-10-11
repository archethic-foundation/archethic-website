jQuery(document).ready(function($) {
	"use strict";
	$(".cq-morecaption").each(function(index) {
		var _this = $(this);
		var _captionby = $(this).data('captionby');
		var _item = $('.cq-morecaption-container', _this);
		_this.on('click', function(event) {
			if(_captionby == "click"){
				if(_item.hasClass('show')){
					_item.addClass('hide');
					_item.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
						if(_item.hasClass('hide')) _item.removeClass('show');
					});
				} else {
					_item.removeClass('show hide').addClass('show');
				}
				if(!_this.hasClass('cq-morecaption-byhover')){
				}
			}

		}).on('mouseover', function(event) {
			if(_this.hasClass('cq-morecaption-byhover')){
				_item.removeClass('show hide').addClass('show');
			}
			event.preventDefault();
		}).on('mouseleave', function(event) {
			if(_this.hasClass('cq-morecaption-byhover')){
				if(_item.hasClass('show')){
					_item.addClass('hide');
					_item.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
						if(_item.hasClass('hide')) _item.removeClass('show hide');
					});
				}

			}
			event.preventDefault();
		});

	})

});
