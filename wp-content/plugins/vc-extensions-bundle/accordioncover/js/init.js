jQuery(document).ready(function($) {
    "use strict";
    $('.cq-accordioncover').each(function(index, el) {
        var _this = $(this);
        var _itemnum = $('.cq-accordioncover-item', _this).length;
        var _elementheight = $(this).data('elementheight');
        var _captionbackground = $(this).data('captionbackground');
        var _contentcolor = $(this).data('contentcolor');
        var _overlaystyle = $(this).data('overlaystyle');
        var _index = index;

        if(_elementheight!=""){
            $(this).css('height', _elementheight);
        }
        if(_captionbackground!=""&&_overlaystyle=="customized"){
            $('.cq-accordioncover-overlay', _this).css('background', _captionbackground);
        }
        if(_contentcolor!=""&&_overlaystyle=="customized"){
            $('.cq-accordioncover-textcontainer, .cq-accordioncover-title', _this).css('color', _contentcolor);
        }

        $('a.cq-accordioncover-lightbox', _this).each(function() {
            $(this).attr('rel', 'cq-accordioncover-gallery'+_index).boxer({
                fixed : true
            });
        });

        $('.cq-accordioncover-item', _this).each(function() {
                var _image = $(this).data('image');
                if(_image!=""){
                    $('.cq-accordioncover-background', $(this)).css({
                        'background': 'url(' + _image + ') center no-repeat',
                        'background-size': 'cover'
                    });
                }
        });
    });
});
