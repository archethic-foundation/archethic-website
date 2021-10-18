jQuery(document).ready(function($) {
    "use strict";
    $('.cq-imagetoggle').each(function(index) {
        var _this = $(this);
        var _isactived = 1;
        var _position = $(this).data('position');
        var _bgcolor = $(this).data('bgcolor');
        var _isdisplay = $(this).data('isdisplay');
        var _btnpos = "right";
        if(_position.indexOf("left")>-1) _btnpos = "left";
        var _btnclass = $('.cq-floatblock-icon', _this).attr('class');
        var _thisbtn = $(".cq-floatblock-button", _this);
        var _thiscontent = $(".cq-floatblock-content", _this);
        var _btnwidth = _thisbtn.outerWidth();
        var _elementwidth = parseInt($(this).data('elementwidth'), 10) || 300;
        var _autodelay = parseInt($(this).data('autodelay'), 10);

        var _autodelayID = 0;
        if(_autodelay > 0){
            clearTimeout(_autodelayID);
            _autodelayID = setTimeout(function(){
                _this.trigger('click');
            }, _autodelay*1000);
        }

        _this.on('mouseover', function(event) {
            if(_autodelay > 0){
                clearTimeout(_autodelayID);
            }
        }).on('mouseleave', function(event) {
             if(_autodelay > 0 && !$('.cq-imagetoggle-content', _this).hasClass('cq-imagetoggle-opened')){
                clearTimeout(_autodelayID);
                _autodelayID = setTimeout(function(){
                    _this.trigger('click');
                }, _autodelay*1000);
            }
        }).on('click', function(event) {
            $('.cq-imagetoggle-content', $(this)).toggleClass('cq-imagetoggle-opened');
            if(_bgcolor != ""){
                if(_this.hasClass('cq-imagetoggle-position-left')){
                    if($('.cq-imagetoggle-content', $(this)).hasClass('cq-imagetoggle-opened')){
                        $('.cq-imagetoggle-arrow', $(this)).css({
                            "border-top": "30px solid "+ _bgcolor +"",
                            "border-right": "30px solid transparent",
                            "border-left": "30px solid transparent",
                            "border-bottom": "30px solid transparent"
                        });
                    }else{
                        $('.cq-imagetoggle-arrow', $(this)).css({
                            "border-top": "30px solid transparent",
                            "border-right": "30px solid "+ _bgcolor +"",
                            "border-left": "30px solid transparent",
                            "border-bottom": "30px solid transparent"
                        });
                    }

                }else{
                    if($('.cq-imagetoggle-content', $(this)).hasClass('cq-imagetoggle-opened')){
                        $('.cq-imagetoggle-arrow', $(this)).css({
                            "border-top": "30px solid "+ _bgcolor +"",
                            "border-right": "30px solid transparent",
                            "border-left": "30px solid transparent",
                            "border-bottom": "30px solid transparent"
                        });
                    }else{
                        $('.cq-imagetoggle-arrow', $(this)).css({
                            "border-top": "30px solid transparent",
                            "border-left": "30px solid "+ _bgcolor +"",
                            "border-right": "30px solid transparent",
                            "border-bottom": "30px solid transparent"
                        });
                    }

                }

            }

            $('.cq-imagetoggle-moretext', $(this)).slideToggle(400);

        });
    });
});
