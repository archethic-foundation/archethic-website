jQuery(document).ready(function($) {
    "use strict";
    $('.cq-hovercardv2').each(function(index) {
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
            $('.cq-hovercardv2-avatar', _this).css({
                'width': _avatarwidth,
                'line-height': _avatarwidth + 'px',
                'height': _avatarwidth
            });;
            $('.cq-hovercardv2-avatarimage', _this).css('width', _avatarwidth + 'px');
            $('.cq-hovercardv2-avataricon', _this).css('width', _avatarwidth + 'px');
            $('.cq-hovercardv2-avataricon', _this).css('height', _avatarwidth + 'px');
            $('.cq-hovercardv2-avataricon', _this).css('line-height', _avatarwidth + 'px');
        }


        $('.cq-hovercardv2-listitem', _this).each(function(index) {
            var _iconhoverbg = $(this).data('iconhoverbg');
            var _iconhovercolor = $(this).data('iconhovercolor');
            var _socialiconbg = $(this).data('socialiconbg');
            var _socialiconbgcolor = $(this).data('socialiconbgcolor');
            if(_socialiconbg=="customized"&&_socialiconbgcolor!=""){
                    $('.cq-hovercardv2-itemlink', $(this)).css('background-color', _socialiconbgcolor);
            }
            if(_iconhoverbg!=""){
                $(this).on('mouseover', function(event) {
                    $('.cq-hovercardv2-itemlink', $(this)).css('background-color', _iconhoverbg);
                    event.preventDefault();
                }).on('mouseleave', function(event) {
                    $('.cq-hovercardv2-itemlink', $(this)).css('background-color', '');
                    event.preventDefault();
                });
            }
            if(_iconhovercolor!=""){
                $(this).on('mouseover', function(event) {
                    $('.cq-hovercardv2-icon', $(this)).css('color', _iconhovercolor);
                    event.preventDefault();
                }).on('mouseleave', function(event) {
                    $('.cq-hovercardv2-icon', $(this)).css('color', '');
                    event.preventDefault();
                });
            }

        });

        var _isFlipped = true;
        var _flipID = 0;
        function _autoFlip(_startFlip) {
            if(_startFlip === undefined) {
                  _startFlip = true;
            }
            if(!_isFlipped){
                if(_direction=="horizontal1"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateY(-90deg)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateX(0)',
                        'opacity': '1'
                    });
                }else if(_direction=="horizontal2"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateY(90deg)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateX(0)',
                        'opacity': '1'
                    });

                }else if(_direction=="vertical1"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateX(90deg)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateY(0)',
                        'opacity': '1'
                    });
                }else if(_direction=="vertical2"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateX(-90deg)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateY(0)',
                        'opacity': '1'
                    });
                }
                _isFlipped = true;
            }else{
                if(_direction=="horizontal1"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateY(0)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateX(30%)',
                        'opacity': '0.5'
                    });
                }else if(_direction=="horizontal2"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateY(0)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateX(-30%)',
                        'opacity': '0.5'
                    });
                }else if(_direction=="vertical1"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateX(0)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateY(30%)',
                        'opacity': '0.5'
                    });
                }else if(_direction=="vertical2"){
                    $('.cq-hovercardv2-content', _this).css({
                        'transform': 'perspective(2000px) rotateX(0)'
                    });
                    $('.cq-hovercardv2-img', _this).css({
                        'transform': 'translateY(-30%)',
                        'opacity': '0.5'
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
                _isFlipped = true;
                _autoFlip(false);
                clearTimeout(_flipID);
                event.preventDefault();
            }).on('mouseleave', function(event) {
                clearTimeout(_flipID);
                _isFlipped = false;
                _autoFlip();
                event.preventDefault();
            });
        }



    });

});
