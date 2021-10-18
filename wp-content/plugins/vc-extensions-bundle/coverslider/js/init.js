jQuery(document).ready(function($) {
    "use strict";
    $('.cq-coverslider').each(function(index, el) {
        var _this = $(this);
        var _imageMaxHeight = $(this).data('imagemaxheight');
        var _buttonbackground = $(this).data('buttonbackground');
        var _buttonhoverbackground = $(this).data('buttonhoverbackground');
        var _contentcolor = $(this).data('contentcolor');
        var _delaytime = parseInt($(this).data('delaytime'));
        var _contentbackground = $(this).data('contentbackground');
        var _arrowcolor = $(this).data('arrowcolor');
        var _arrowhovercolor = $(this).data('arrowhovercolor');
        var _cover = $('.cq-coverslider-cover', _this);
        var _itemContainer = $('.cq-coverslider-itemcontainer', _this);
        var _itemWidth = _cover.width();
        var _itemNum = 0;
        var _index = index;

        if(_contentbackground!=""){
            $('.cq-coverslider-area', _this).css('background', _contentbackground);
        }


        var _autoplay = false;
        if(_delaytime>0) _autoplay = true;
        if($('.cq-coverslider-contentitem', _this).first().is(':empty')){
            $('.cq-coverslider-content', _this).empty();
        }
        if($('.cq-coverslider-imageitem', _this).first().is(':empty')){
            $('.cq-coverslider-itemcontainer', _this).empty();
        }
        var _imagecarousel = $('.cq-coverslider-itemcontainer', _this).slick({
            infinite: true,
            arrow: false,
            dots: false,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: _autoplay,
            speed: 800,
            draggable: false,
            swipe: false,
            asNavFor: $('.cq-coverslider-content', _this),
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
            prevArrow: $('.coverslider-navigation-prev', _this),
            nextArrow: $('.coverslider-navigation-next', _this),
            autoplaySpeed: _delaytime*1000,
            slidesToScroll: 1
        });
        var _textcarousel = $('.cq-coverslider-content', _this).slick({
            infinite: true,
            adaptiveHeight: true,
            slidesToShow: 1,
            arrow: false,
            dots: false,
            draggable: false,
            swipe: false,
            speed: 800,
            asNavFor: $('.cq-coverslider-itemcontainer', _this),
            prevArrow: $('.coverslider-navigation-prev', _this),
            nextArrow: $('.coverslider-navigation-next', _this),
            slidesToScroll: 1
        });



        $('a.cq-coverslider-lightbox', _this).each(function() {
            $(this)/*.attr('rel', 'cq-coverslider-gallery'+_index)*/.boxer({
                fixed : true
            });
        });


        _itemNum = $('.cq-coverslider-image', _this).length;

        var _currentItem = 0;

        $('.cq-coverslider-contentitem', _this).each(function() {
            if($(this).is(':empty')){
                $(this).css({
                    'padding-top': '0',
                    'padding-bottom': '0'
                });
            }else{
            }
        });

        if(_arrowcolor!=""){
            $('.coverslider-navigation-prev, .coverslider-navigation-next', _this).css('color', _arrowcolor);;
        }

        var _prevBtn = $('.coverslider-navigation-prev', _this);
        var _nextBtn = $('.coverslider-navigation-next', _this);


        if(_buttonbackground!=""){
            _nextBtn.css('background', _buttonbackground);
            _prevBtn.css('background', _buttonbackground);
        }
        _nextBtn.on('mouseover', function() {
            $(this).css('background', _buttonhoverbackground);
            if(_arrowhovercolor!=""){
                $(this).css('color', _arrowhovercolor);
            }
        }).on('mouseleave', function(event) {
            if(_buttonbackground!=""){
                $(this).css('background', _buttonbackground);
            }else{
                $(this).css('background', '');
            }
            if(_arrowhovercolor!=""){
                if(_arrowcolor!=""){
                    $(this).css('color', _arrowcolor);
                }else{
                    $(this).css('color', '');
                }
            }
        })

        _prevBtn.on('mouseover', function() {
            $(this).css('background', _buttonhoverbackground);
            if(_arrowhovercolor!=""){
                $(this).css('color', _arrowhovercolor);
            }
        }).on('mouseleave', function(event) {
            if(_buttonbackground!=""){
                $(this).css('background', _buttonbackground);
            }else{
                $(this).css('background', '');
            }

            if(_arrowhovercolor!=""){
                if(_arrowcolor!=""){
                    $(this).css('color', _arrowcolor);
                }else{
                    $(this).css('color', '');
                }
            }
        })





    });
});
