jQuery('.ribbon-image').each(function() {
	var _float = jQuery(this).data('float');
	var _zindex = jQuery(this).data('zindex');
	jQuery(this).fluidbox({
		// stackIndex: _zindex
		stackIndex: 1000
	});
	/*
	jQuery('.fluidbox-wrap').css('overflow', 'hidden');
	jQuery(this).on('click', function(event) {
		var _wrap = jQuery(this).find('.fluidbox-wrap');
		if(_wrap.css('overflow')=="hidden"){
			_wrap.css('overflow', 'visible');
		}else{
			setTimeout(function() {
				_wrap.css('overflow', 'hidden');
			}, 500);
		}

	});
	*/
});
