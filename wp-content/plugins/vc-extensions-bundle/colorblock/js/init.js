jQuery(document).ready(function($) {
    "use strict";
    $('.cq-colorblock').each(function(index, el) {
        var _this = $(this);
        var _image = $(this).data('image');
        var _titlesize = $(this).data('titlesize');
        var _textblockbg = $(this).data('textblockbg');
        var _custombgcolor = $(this).data('custombgcolor');
        var _contentcolor = $(this).data('contentcolor');

        if(_titlesize!=""){
		    $('.cq-colorblock-title', _this).css('font-size', _titlesize);
        }

        if(_textblockbg=="customized"){
            if(_custombgcolor!=""){
               $(this).css('background', _custombgcolor);
            }
        }

        if(_contentcolor!=""){
            $('.cq-colorblock-title, .cq-colorblock-caption, .cq-colorblock-caption p', _this).css('color', _contentcolor);
        }

    });
});
