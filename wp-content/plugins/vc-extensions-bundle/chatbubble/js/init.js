jQuery(document).ready(function($) {
    "use strict";
    $('.cq-chatbubble').each(function(index, el) {
        var _this = $(this);
        var _items = $(".cq-chatbubble-container", $(this));
        var _length = _items.length;
        var _itemArr = [];
        _items.each(function(index) {
            _itemArr[index] = $(this);
            var _bgstyle = $(this).data('bgstyle');
            var _backgroundcolor = $(this).data('backgroundcolor');
            var _contentcolor = $(this).data('contentcolor');
            var _iconcolor = $(this).data('iconcolor');
            var _iconsize = $(this).data('iconsize');
            var _labelcolor = $(this).data('labelcolor');
            var _infocolor = $(this).data('infocolor');
            if(_contentcolor!=""){
                $('.cq-chatbubble-content, .cq-chatbubble-content p', $(this)).css('color', _contentcolor);
            }
            if(_iconcolor!=""){
                $('.cq-chatbubble-icon', $(this)).css('color', _iconcolor);
            }
            if(_iconsize!=""){
                $('.cq-chatbubble-icon', $(this)).css('font-size', _iconsize);
            }
            if(_labelcolor!=""){
                $('.cq-chatbubble-label', $(this)).css('color', _labelcolor);
            }
            if(_infocolor!=""){
                $('.cq-chatbubble-detail, .cq-chatbubble-detail span', $(this)).css('color', _infocolor);
            }
            if(_bgstyle=="customized"&&_backgroundcolor!=""){
                $('.cq-chatbubble-content, .cq-chatbubble-avatar', $(this)).css('background-color', _backgroundcolor);
                $('.cq-chatbubble-arrowleft', $(this)).css('border-right-color', _backgroundcolor);
                $('.cq-chatbubble-arrowright', $(this)).css('border-left-color', _backgroundcolor);
            }
        });

    });
});
