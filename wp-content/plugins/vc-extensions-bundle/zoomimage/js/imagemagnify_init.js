jQuery(document).ready(function($) {
  "use strict";
  $('.cq-magnify-image').each(function(index) {
    var _radius = $(this).data('radius');
    var _borderSize = $(this).data('bordersize');
    var _borderColor = $(this).data('bordercolor');
    var _filter = $(this).data('filter');
    var _glassFilter = $(this).data('glassfilter');
    var _imageFilter = $(this).data('imagefilter');
    var _pluginURL = $(this).data('pluginurl');
    $(this).animate({opacity: 1}, 300).cq_magnify({
      radius: _radius,
      x: $(this).data('x'),
      y: $(this).data('y')
    });
    if(_filter=="blur"){
      $(this).css({
        '-webkit-filter': 'blur(2px)',
        '-moz-filter': 'blur(2px)',
        '-ms-filter': 'blur(2px)',
        '-o-filter': 'blur(2px)',
        'filter': 'url('+_pluginURL + '/css/blur.svg#blur)'
      });
    }else if(_filter=="gray"){
      $(this).css({
        '-webkit-filter': 'grayscale(100%)',
        '-moz-filter': 'grayscale(100%)',
        '-ms-filter': 'grayscale(100%)',
        '-o-filter': 'grayscale(100%)',
        'filter': 'url('+_pluginURL + '/css/gray.svg#grayscale)'
      });

    }
    $(this).parent().find('.cq-magnify-glass').css({
      'width': _radius*2,
      'height': _radius*2,
      '-webkit-border-radius': _radius*2,
      '-moz-border-radius': _radius*2,
      'border-radius': _radius*2,
      'border-width': _borderSize + 'px',
      'border-color': _borderColor,
      '-webkit-filter': _glassFilter,
      '-moz-filter': _glassFilter,
      'filter': _glassFilter
    });

  });

});
