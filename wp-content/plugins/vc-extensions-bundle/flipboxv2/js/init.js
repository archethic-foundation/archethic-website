jQuery(document).ready(function($) {
    "use strict";
    $('.cq-flipboxv2').each(function(index) {
        var _this = $(this);
        var _avatarwidth = parseInt($(this).data('avatarwidth'), 10);
        var _autodelay = parseInt($(this).data('autodelay'), 10);
        var _namecolor = $(this).data('namecolor');
        var _labelcolor = $(this).data('labelcolor');
        var _namefontsize = $(this).data('namefontsize');
        var _labelfontsize = $(this).data('labelfontsize');
        var _descolor = $(this).data('descolor');
        var _desfontsize = $(this).data('desfontsize');
        var _direction = $(this).data('direction');
        var _isheader = $(this).data('isheader');

        var _titlecolor = $(this).data('titlecolor');
        var _titlefontsize = $(this).data('titlefontsize');
        var _subtitlecolor = $(this).data('subtitlecolor');
        var _subtitlefontsize = $(this).data('subtitlefontsize');
        var _bordercolor = $(this).data('bordercolor');
        if(_avatarwidth>0&&_avatarwidth!=80){
            if(_isheader=="yes") $('.cq-flipboxv2-avatar', _this).css('margin-top', -_avatarwidth*0.5 + 'px');
            $('.cq-flipboxv2-avatarimage', _this).css('width', _avatarwidth + 'px');
            $('.cq-flipboxv2-avataricon', _this).css('width', _avatarwidth + 'px');
            $('.cq-flipboxv2-avataricon', _this).css('height', _avatarwidth + 'px');
            $('.cq-flipboxv2-avataricon', _this).css('line-height', _avatarwidth + 'px');
        }
        var _isFlipped = false;
        var _flidID = 0;
        function _autoFlip(_startFlip) {
            if(_startFlip === undefined) {
                  _startFlip = true;
            }
            if(!_isFlipped){
                if(_direction=="horizontal1"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateY(180deg)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateY(0)'
                    });
                }else if(_direction=="horizontal2"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateY(-180deg)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateY(0)'
                    });

                }else if(_direction=="vertical1"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateX(-180deg)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateX(0)'
                    });
                }else if(_direction=="vertical2"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateX(180deg)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateX(0)'
                    });
                }
                _isFlipped = true;
            }else{
                if(_direction=="horizontal1"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateY(0)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateY(-180deg)'
                    });
                }else if(_direction=="horizontal2"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateY(0)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateY(180deg)'
                    });
                }else if(_direction=="vertical1"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateX(0)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateX(180deg)'
                    });
                }else if(_direction=="vertical2"){
                    $('.cq-flipboxv2-front', _this).css({
                        'transform': 'perspective(4000px) rotateX(0)'
                    });
                    $('.cq-flipboxv2-back', _this).css({
                        'transform': 'perspective(4000px) rotateX(-180deg)'
                    });
                }

                _isFlipped = false;
            }
            clearTimeout(_flipID);
            if(_autodelay>0&&_startFlip) _flipID = setTimeout(_autoFlip, _autodelay*1000);

        }
        if(_autodelay>0){
            _flipID = setTimeout(_autoFlip, _autodelay*1000);
        }
        if(_autodelay>0){
            _this.on('mouseover', function(event) {
                _isFlipped = false;
                _autoFlip(false);
                clearTimeout(_flipID);
                event.preventDefault();
            }).on('mouseleave', function(event) {
                clearTimeout(_flipID);
                _isFlipped = true;
                _autoFlip();
                event.preventDefault();
            });
        }


        if(_namecolor!=""){
            $('.cq-flipboxv2-name', _this).css('color', _namecolor);
        }
        if(_labelcolor!=""){
            $('.cq-flipboxv2-label', _this).css('color', _labelcolor);
        }
        if(_namefontsize!=""){
            $('.cq-flipboxv2-name', _this).css('font-size', _namefontsize);
        }
        if(_labelfontsize!=""){
            $('.cq-flipboxv2-label', _this).css('font-size', _labelfontsize);
        }
        if(_descolor!=""){
            $('.cq-flipboxv2-description', _this).css('color', _descolor);
        }
        if(_desfontsize!=""){
            $('.cq-flipboxv2-description', _this).css('font-size', _desfontsize);
        }


    });

});
