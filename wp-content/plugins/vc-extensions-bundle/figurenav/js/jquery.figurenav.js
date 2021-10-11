jQuery(document).ready(function($) {
	"use strict";
	$('.cq-figure-cover').each(function(index) {
			var _this = $(this);
			var _buttonwidth = $(this).data('buttonwidth');
			var _contentwidth = $(this).data('contentwidth');
			var _itemheight = $(this).data('itemheight');
			var _mintemwidth = $(this).data('mintemwidth');
			var _displaynum = Math.max(parseInt($(this).data('displaynum'))-1, 0);
			var _bordercolor = $(this).data('bordercolor');
			var _itemnum = $(this).find('.cq-figure-item').length;
			var _currentitem = null;

			$(this).find('.cq-figure-item').each(function(index) {
				var _btnmargintop = $(this).data('btnmargintop');
				var _bgcolor = $(this).data('bgcolor');
				var _fontcolor = $(this).data('fontcolor');
				if(_bgcolor!='') $(this).find('h2, h2>span').css({
					'color': _fontcolor,
					'background-color': _bgcolor
				});
				$(this).css({
					'color': _fontcolor,
					'background-color': _bgcolor,
					'min-width': _mintemwidth,
					'width': 100/_itemnum + '%'
				});
				$(this).find('.cq-figure').css({
				});
				$(this).find('.cq-figure-content').each(function(index) {
					$(this).css({
						width: _contentwidth
					});
				});
				$(this).find('a.vc_btn, a.wpb_button_a').each(function(index) {
					$(this).css({
						'width': _buttonwidth,
						'margin-top': _btnmargintop
					});
				});

				$(this).on('mouseenter', _enteritem).on('mouseleave', _leaveItem);
				if(_displaynum>=0&&index==_displaynum) {
					_currentitem = $(this).trigger('mouseenter');
				}


		})
		function _enteritem(event) {
			if(_currentitem) _currentitem.trigger('mouseleave');
			$(this).css({
				'margin-top': 0,
				'height': _itemheight,
				'box-shadow': '0 0 4px 1px rgba(0, 0, 0, 0.2)'
			}).animate({},
				300, function() {
			});

			$(this).find('figure.cq-figure').css({
				'height': 184,
				'opacity': 1
			});
			$(this).find('.cq-figure-content').stop(true).animate({'opacity': 1}, 300);

		};

		function _leaveItem(event){
			$(this).css({
				'box-shadow': 'none',
				'margin-top': 360,
				'height': 120
			});
			$(this).find('figure.cq-figure').css({
				'height': '0px',
				'border-bottom' : '4px solid ' + _bordercolor
			});
			$(this).find('.cq-figure-content').stop(true).animate({'opacity': 0, 'height': 0}, 300)

		}


	});
});
