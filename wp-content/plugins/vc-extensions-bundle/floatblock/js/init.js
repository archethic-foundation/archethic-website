jQuery(document).ready(function($) {
    "use strict";
    $('.cq-floatblock').each(function(index) {
        var _this = $(this);
        var _isactived = 1;
        var _position = $(this).data('position');
        var _isdisplay = $(this).data('isdisplay');
        var _btnpos = "right";
        if(_position.indexOf("left")>-1) _btnpos = "left";
        var _btnclass = $('.cq-floatblock-icon', _this).attr('class');
        var _thisbtn = $(".cq-floatblock-button", _this);
        var _thiscontent = $(".cq-floatblock-content", _this);
        var _btnwidth = _thisbtn.outerWidth();
        var _elementwidth = parseInt($(this).data('elementwidth'), 10) || 300;
        var _autodelay = parseInt($(this).data('autodelay'), 10);
        setTimeout(function(){
            _this.animate({'opacity': 1}, 300);
        }, 300);
        _thisbtn.on("click", function(){
            if (_isactived) {
               _hideBlock();
            } else {
                if(_btnpos=="right"){
                    _this.delay(150).animate({right: '0px'}, 300, function(){
                        _thiscontent.slideDown(300, function(){});
                        $(".cq-floatblock-image", _this).slideDown(300, function(){});
                    });
                    _thisbtn.animate({'right': '15px'}, 300, function() {
                        $('.cq-floatblock-icon', _thisbtn).removeClass().addClass('cq-floatblock-icon entypo-icon entypo-icon-cancel');
                    });
                }else{
                    _this.delay(300).animate({left: '0px'}, 300, function(){
                        _thiscontent.slideDown(300, function(){});
                        $(".cq-floatblock-image", _this).slideDown(300, function(){});
                    });
                    _thisbtn.animate({'left': _elementwidth - _btnwidth - 15 + 'px'}, 300, function() {
                        $('.cq-floatblock-icon', _thisbtn).removeClass().addClass('cq-floatblock-icon entypo-icon entypo-icon-cancel');
                    });

                }

                _isactived = 1;
            };
        });

        function _hideBlock(){
            $('.cq-floatblock-image', _this).slideUp(100);
            var _iframevideo = $('iframe', _thiscontent);
            var _videosrc = _iframevideo.attr("src");
            _iframevideo.attr("src", "");
            _iframevideo.attr("src", _videosrc);
            _thiscontent.slideUp(100, function(){
                if(_btnpos=="right"){
                    _this.animate({right: "-" + _elementwidth + "px"}, function(){
                        $('.cq-floatblock-icon', _thisbtn).removeClass().addClass(_btnclass);
                        _thisbtn.css({"right": _elementwidth + 15 + 'px'});
                    });
                }else{
                    _this.animate({left: '-' + _elementwidth + 'px'}, function(){
                        $('.cq-floatblock-icon', _thisbtn).removeClass().addClass(_btnclass);
                        _thisbtn.css({"left": _elementwidth + 15 + 'px'});
                    })
                }

            });
            _isactived = 0;
        }
        _hideBlock();
        if(_btnpos=="left"){
                _thisbtn.animate({'left': _elementwidth - _btnwidth - 15 + 'px'}, 300);
            }
        $('.cq-floatblock-icon', _thisbtn).removeClass().addClass('cq-floatblock-icon entypo-icon entypo-icon-cancel');
        if(_autodelay<=0){
        }else{
            setTimeout(function(){
                $(".cq-floatblock-button", _this).trigger('click');
            }, _autodelay*1000);
        }


    });
});
