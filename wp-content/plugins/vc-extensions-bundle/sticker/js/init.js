jQuery(document).ready(function($) {
    "use strict";
    $(this).find('.cq-sticker').each(function(index) {
        var _size = parseInt($(this).data('size'));
        var _elementmargin = $(this).data('elementmargin');
        $(this).css({
            'margin': _elementmargin,
            'width': _size,
            'height': _size
        });
    });
    var _sticker = Sticker.init('.cq-sticker');
    $(this).find('.cq-sticker').each(function(index) {
        var _icon = $(this).data('icon');
        var _fontsize = $(this).data('fontsize');
        var _fontcolor = $(this).data('fontcolor');
        var _backgroundtype = $(this).data('backgroundtype');
        var _gradientcolor = $(this).data('gradientcolor');
        var _backgroundcolor = $(this).data('backgroundcolor');
        var _shadowopacity = $(this).data('shadowopacity');
        var _image = $(this).data('image');
        $(this).find('.sticker-img').addClass(_icon);
        $(this).find('.sticker-shadow').css('opacity', _shadowopacity);
        if(_backgroundtype=="image"){
            $(this).find('.sticker-img').css({
                'background-color': 'none',
                'background-image': 'url(' + _image + ')',
                'background-size': 'cover'
            });
        }else if(_backgroundtype=="gradient"){
            $(this).find('.sticker-img').css({
                'background-color': _gradientcolor,
                'background-image' : '-webkit-linear-gradient(top, hsl(0, 80%, 70%), ' + _gradientcolor + ')',
                'background-image' : '-moz-linear-gradient(top, hsl(0, 80%, 70%), ' + _gradientcolor + ')',
                'background-image' : 'o-linear-gradient(top, hsl(0, 80%, 70%), ' + _gradientcolor + ')',
                'background-image' : 'linear-gradient(to bottom, hsl(0, 80%, 70%), ' + _gradientcolor + ')'
            });
        }else{
             $(this).find('.sticker-img').css({
                'background-color': _backgroundcolor
            });
        }
        $(this).find('.sticker-img').css({
            'color': _fontcolor,
            'font-size': _fontsize
        });
    });
});


