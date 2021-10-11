jQuery(document).ready(function($) {
    "use strict";
    $('.cq-testimoniallist').each(function(index, el) {
        var _this = $(this);
        var _avatarbg = $(this).data('avatarbg');
        var _avatarcolor = $(this).data('avatarcolor');
        var _avatarnum1 = parseInt($(this).data('avatarnum1')) || 3;
        var _avatarnum2 = parseInt($(this).data('avatarnum2')) || 3;
        var _avatarnum3 = parseInt($(this).data('avatarnum3')) || 3;
        var _delaytime = parseInt($(this).data('delaytime'));
        var _namecolor = $(this).data('namecolor');
        var _textalign = $(this).data('textalign');
        var _contentpadding = $(this).data('contentpadding');
        var _autoplay = false;
        var _autoplaytime;
        if(_delaytime>0){
            _autoplay = true;
            _autoplaytime = _delaytime;
        }
        if(_namecolor!=""){
            $('.cq-testimoniallist-name', _this).css('color', _namecolor);
            $('.cq-testimoniallist-label', _this).css('color', _namecolor);
        }
        if(_textalign=="center"||_textalign=="right"){
            $('.cq-testimoniallist-content, .cq-testimoniallist-content h4', _this).css('text-align', _textalign);
        }
        if(_contentpadding!=""){
            $('.cq-testimoniallist-content', _this).css('padding', _contentpadding);
        }
        if(_avatarbg!=""){
            $('.cq-testimoniallist-avatar', _this).css({
                'background': _avatarbg,
                'color': _avatarcolor
            });
        }
        if(_avatarcolor!=""){
            $('.cq-avatarwithpopup-icon', _this).css('color', _avatarcolor);
        }

        var _contentlen = $('.cq-testimoniallist-contentitem', _this).length;
        if(_contentlen<=_avatarnum1){
            _avatarnum1 = _avatarnum2 = _avatarnum3 = 1;
        }

        $('.cq-testimoniallist-contentsub', _this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            infinite: false,
            speed: 800,
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
            centerPadding: '0px',
            asNavFor: $('.cq-testimoniallist-avatarcontainer', _this)
        });
        $('.cq-testimoniallist-avatarcontainer', _this).slick({
            slidesToShow: _avatarnum1,
            slidesToScroll: 1,
            asNavFor: $('.cq-testimoniallist-contentsub', _this),
            dots: false,
            arrows: true,
            infinite: false,
            centerMode: true,
            focusOnSelect: true,
            speed: 800,
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
            prevArrow: null,
            nextArrow: null,
            autoplay: _autoplay,
            autoplaySpeed: _autoplaytime*1000,
            responsive: [
                {
                    breakpoint: 1280,
                    settings: {
                        slidesToShow: _avatarnum1
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: _avatarnum2
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: _avatarnum3
                    }
                }
            ]
        });



        var _maxContentHeight = 0;
        var _contentContainerHeight = $('.cq-testimoniallist-contentcontainer', _this).outerHeight();
        $('.cq-testimoniallist-contentitem', _this).each(function(contentIndex) {
            _maxContentHeight = Math.max($(this).outerHeight(), _maxContentHeight);
        });
        $('.cq-testimoniallist-contentitem', _this).each(function(contentIndex) {
            if(_maxContentHeight>0) {
                $(this).css('height', _maxContentHeight);
            }
        })

    });

});
