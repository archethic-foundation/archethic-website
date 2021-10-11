jQuery(document).ready(function($) {
	"use strict";
	jQuery('.cqlist-container').each(function(index) {
		var _this = $(this);
		var _isclickable = $(this).data('isclickable');
		var _clickedicon = $(this).data('clickedicon') || 'fa fa-check-square-o';

		$('.cqlist-signup a').on('mouseover', function(event) {
			var _signuphoverbackground = $(this).data('signuphoverbackground');
			$(this).css('background', _signuphoverbackground);
		}).on('mouseleave', function(event) {
			var _signupbackground = $(this).data('signupbackground');
			$(this).css('background', _signupbackground);
		});

		jQuery( ".cqlist ul > li > span.todolist-content", _this).each(function(index) {
			var _p = $(this).find('p');
			if(_p[0]&&_p.html()==""){
				_p.remove();
			}
		});
		if(_isclickable=="yes"){
			jQuery( ".cqlist ul > li > a", _this).on('click', function(event) {
				var _item = jQuery(this).parent( "li" );
				var _theicon = jQuery('.cq-todolist-icon', jQuery(this));
				var _icon = jQuery(this).data('icon');

				if(_item.hasClass('done')){
					_item.removeClass('done');
					_theicon.removeClass(_clickedicon).addClass(_icon);
				}else{
					_item.addClass('done');
					_theicon.removeClass(_icon).addClass(_clickedicon);
				}
				return false;
			}).css('cursor', 'pointer');;

		}else{
			jQuery( ".cqlist ul > li > a", _this).on('click', function(event) {
				return false;
			})
		}

	});
});



