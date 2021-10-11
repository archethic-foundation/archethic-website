jQuery(document).ready(function($) {
	"use strict";
	$('.productcover-content').each(function(index) {
		var _index = index;
		var _this = $(this);
		var _cover = $(this).find('.cover-image');
		var _cat = $(this).find('.productcover-cat');
		var img = _cover[0]; // Get my img elem
		var pic_real_width, pic_real_height;
		var _ratio;
		var _thumbtop = $(this).data('thumbtop') || '75%';
		var _captiontop = $(this).data('captiontop') || '40%';
		var _nothumblabel = $(this).data('nothumblabel');
		var _onclick = $(this).data('onclick');

		if(_nothumblabel=="on"){
			$(window).on('resize', function(event) {
				if($(this).width()<=720){
					$('.thumb-caption', _this).css('display', 'none');
				}else{
					$('.thumb-caption', _this).css('display', '');
				}
			});
			$(window).trigger('resize');
		}
		// Make in memory copy of image to avoid css issues
		$("<img/>").attr("src", $(img).attr("src")).load(function() {
	        pic_real_width = this.width;   // Note: $(this).width() will not
	        pic_real_height = this.height; // work for in memory images.
	        _ratio = pic_real_height/pic_real_width;
	        _this.css('height', _this.width()*_ratio);
	        _cat.css('height', _this.width()*_ratio);
	        $(window).on('resize', function(event) {
		        _this.css('height', _this.width()*_ratio);
		        _cat.css('height', _this.width()*_ratio);
	        });

	        var _catNum = _cat.find('li.productcover-thumb').length;
	        var _ulHeight;
	        _cat.find('li.productcover-thumb').each(function(index) {
	        	_ulHeight = $(this).find('img').height();
	        	$(this).css({
	        		'width': 1/_catNum*100+'%',
	        		'left': index/_catNum*100+'%'
	        	});

                if(_onclick=="link_image"){
	                $(this).find('a.productcover-link').attr('rel', 'gallery' + _index);
		        	$(this).find('a.productcover-link').boxer({
	                  fixed : true
	                });
                }else if(_onclick=="link_image_current"){
                	$(this).on('click', function(event) {
			        	var _thumburl = $(this).find('img').data('largeimage');
                		$('.cover-image', _this).attr('src', _thumburl).addClass('cover-image');
                	}).css('cursor', 'pointer');;

                }

	        });
	        _cat.on('mouseover', function(event) {
        		$(this).find('ul').css({
        			top: _thumbtop
        		});
        		$(this).find('span.productcover-caption').css({
        			top: _captiontop
        		});
        	}).on('mouseleave', function(event) {
        		$(this).find('ul').css({
        			top: '120%'
        		});
        		$(this).find('span.productcover-caption').css({
        			top: '100%'
        		});
        	});

		});
	});
});
