jQuery(document).ready(function($) {
	"use strict";
	$(".cq-infoblock").each(function(index) {
		var _this = $(this);
		var _iconcolor = $(this).data('iconcolor');
		var _iconbg = $(this).data('iconbg');
		var _iconhovercolor = $(this).data('iconhovercolor');
		var _iconhoverbg = $(this).data('iconhoverbg');
		var _bgcolor = $(this).data('bgcolor');
		var _barbgcolor = $(this).data('barbgcolor');
		var _bghovercolor = $(this).data('bghovercolor');
		var _barhoverbg = $(this).data('barhoverbg');


		if(_bghovercolor != ""){
			_this.on('mouseover', function(event) {
				$('.cq-infoblock-content', _this	).css('background-color', _bghovercolor);
			}).on('mouseleave', function(event) {
				$('.cq-infoblock-content', _this	).css('background-color', _bgcolor);
			});
		}

		if(_barhoverbg != ""){
			$('.cq-infoblock-bar', _this	).on('mouseover', function(event) {
				$(this).css('background-color', _barhoverbg);
			}).on('mouseleave', function(event) {
				$(this).css('background-color', _barbgcolor);
			});
		}




		if(_iconhovercolor != ""){
			_this.on('mouseover',  function(event) {
				$('.cq-infoblock-icon', $(this)).css('color', _iconhovercolor);
			}).on('mouseleave', function(event) {
				$('.cq-infoblock-icon', $(this)).css('color', _iconcolor);
			});
		}

		if(_iconhoverbg != ""){
			_this.on('mouseover', function(event) {
				$('.cq-infoblock-iconarea', _this).css('background-color', _iconhoverbg);
			}).on('mouseleave', function(event) {
				$('.cq-infoblock-iconarea', _this).css('background-color', _iconbg);
			});
		}


	})

});
