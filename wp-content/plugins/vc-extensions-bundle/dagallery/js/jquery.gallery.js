	jQuery('.cq-dagallery').each(function() {
		"use strict";
		var _width = jQuery(this).data('width');
		var _gallerywidth = jQuery(this).data('gallerywidth');
		var _height = jQuery(this).data('height');
		var _opacity = jQuery(this).data('opacity');
		var _margin = jQuery(this).data('margin');
		jQuery(this).find('a.normal').boxer({
	        fixed : true
	    });
		jQuery(this).find('li').each(function(index) {
			var _background = jQuery(this).find('.dagallery-info').css('backgroundColor');
			var _color = jQuery(this).find('.dagallery-info').css('color');
		    var _newColor = _color.replace('rgb', 'rgba').replace(')', ','+_opacity+')'); //rgba(100,100,100,.8)
		    var _newBg = _background.replace('rgb', 'rgba').replace(')', ','+_opacity+')'); //rgba(100,100,100,.8)
		    jQuery(this).find('.dagallery-info').css({
		    	'backgroundColor': _newBg
		    });
		    jQuery(this).find('.dagallery-info h3, .dagallery-info p').css({
		    	'color': _color
		    });
			var _imgHeight = jQuery(this).data('height');
			jQuery(this).css({
				width: _width,
				height: _height
			}).on('mouseover', function(event) {
				var w = jQuery(this).width(),
		        h = jQuery(this).height(),
		        x = (event.pageX - jQuery(this).offset().left - (w / 2) * (w > h ? (h / w) : 1)),
		        y = (event.pageY - jQuery(this).offset().top - (h / 2) * (h > w ? (w / h) : 1)),
		        d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
		        var class_suffix = '';
		        switch ( d ) {
			        case 0 : class_suffix = '-top';    break;
			        case 1 : class_suffix = '-right';  break;
			        case 2 : class_suffix = '-bottom'; break;
			        case 3 : class_suffix = '-left';   break;
			    }
			    jQuery(this).removeClass().addClass('in'+class_suffix);
				event.preventDefault();
			});

			jQuery(this).on('mouseout', function(event) {
				jQuery(this).removeClass();
				var w = jQuery(this).width(),
		        h = jQuery(this).height(),
		        x = (event.pageX - jQuery(this).offset().left - (w / 2) * (w > h ? (h / w) : 1)),
		        y = (event.pageY - jQuery(this).offset().top - (h / 2) * (h > w ? (w / h) : 1)),
		        d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
		        var class_suffix = '';
		        switch ( d ) {
			        case 0 : class_suffix = '-top';    break;
			        case 1 : class_suffix = '-right';  break;
			        case 2 : class_suffix = '-bottom'; break;
			        case 3 : class_suffix = '-left';   break;
			    }
			    jQuery(this).removeClass().addClass('out'+class_suffix);
				event.preventDefault();
			});

		});

	});
