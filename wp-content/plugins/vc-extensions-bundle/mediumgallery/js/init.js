jQuery(document).ready(function($) {
	"use strict";
	$('.cq-medium-gallery').each(function(index) {
		var _this = $(this);
		var _width = $(this).data('gallerywidth') || '100%';
		var _gutter = $(this).data('gutter') || '0';
		var _lowreswidth = $(this).data('lowreswidth') || '500';
		var _background = $(this).data('background') || 'rgba(255,255,255,0.85)';
		var _layoutno = $(this).data('layoutno').toString() || '213433223433333';
		$(this).photosetGrid({
		  width: _width,
		  // Set the gutter between columns and rows
		  gutter: _gutter,
		  // Manually set the grid layout
		  layout: _layoutno,
		  // Wrap the images in links
		  highresLinks: false,
		  // Asign a common rel attribute
		  // rel: 'print-gallery',
		  lowresWidth: _lowreswidth,

		  onInit: function(){},
		  onComplete: function(){
			_this.find('img.mediumgallery-img').each(function(index) {
				var _imgurl = $(this).data('highres');
				var _galleryitem = $(this).wrap('<a href="'+_imgurl+'" class="mediumgallery-item"></a>');
			});
			$('.mediumgallery-item', _this).fluidbox({
				overlayColor: _background,
				stackIndex: 1000
			});

		  }
		});

	});




});
