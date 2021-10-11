jQuery(document).ready(function($) {
	"use strict";
	$(window).scroll(function() {
		$(".cq-coveranimation").each(function(index) {
			var _this = $(this);
			var _enter = $(this).data('enter') == "no" ? false : true;
			_this.on('mouseover', function(event) {
				event.preventDefault();
				if(_enter) $(this).removeClass('cq-coveranimation-enter-true');
			});

			var _topviewport = $(window).scrollTop();
			// Declare variable for bottom of viewport
			var _bottomviewport = _topviewport + $(window).height();
			// Declare Bot = Top + viewport
			var _elementtop = _this.offset().top;
			// Get coordinates of element relative to the document.
			var _elementbottom = _elementtop + _this.height();
			if ((_elementbottom <= _bottomviewport) && (_elementtop >= _topviewport) && _enter) $(this).addClass('cq-coveranimation-enter-true');

		})
	})

});
