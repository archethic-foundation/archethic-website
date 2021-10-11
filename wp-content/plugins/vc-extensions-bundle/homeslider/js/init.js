jQuery(document).ready(function($) {
    "use strict";
    $('.cq-homeslider').each(function(index, el) {
        var _this = $(this);
        var _maxheight = $(this).data('maxheight');
        var _captiontop = $(this).data('captiontop');
        var _captionleft = $(this).data('captionleft');
        var _captionwidth = $(this).data('captionwidth')==""?'400':$(this).data('captionwidth');
        var _minheight = $(this).data('minheight')==""?'360':$(this).data('minheight');
        var _contentcolor = $(this).data('contentcolor');
        var _delaytime = parseInt($(this).data('delaytime'));
        var _contentbackground = $(this).data('contentbackground');
        var _imagestretch = $(this).data('imagestretch');
        var _contentcolor = $(this).data('contentcolor');
        var _cover = $('.cq-homeslider-cover', _this);
        var _itemContainer = $('.cq-homeslider-itemcontainer', _this);
        var _contentContainer = $('.cq-homeslider-contentcontainer', _this);
        var _itemWidth = _cover.width();
        var _itemNum = 0;
        var _index = index;


        if(_minheight!=""){
            _contentContainer.css('min-height', _minheight);
        }
        if(_captionwidth!=""){
            _contentContainer.css('width', _captionwidth);
        }
        if(_contentcolor!=""){
            _contentContainer.css('color', _contentcolor);
            $('.cq-homeslider-title', _this).css('color', _contentcolor);
        }

        function _fullcover(){
            var el_margin_left = parseInt( _this.css( 'margin-left' ), 10 );
            var el_margin_right = parseInt( _this.css( 'margin-right' ), 10 );
            var offset = 0 - _this.offset().left - el_margin_left;
            var width = $(window).width();
            _cover.css( {
                'position': 'relative',
                'left': offset,
                'box-sizing': 'border-box',
                'width': $( window ).width()
            });
            if(width>640){
                if(_captiontop!=""||_captionleft!=""){
                    _contentContainer.css({
                        'width': _captionwidth,
                        'min-height': _minheight,
                        'top': _captiontop,
                        'left': _captionleft
                    });
                }
            }else{
                _contentContainer.css({
                    'top': 0,
                    'min-height': 0,
                    'left': offset,
                    'width': $( window ).width()
                });
            }
        }

        function _resetCover(){
            if(_imagestretch=="fullwidth"){
                _fullcover();
            }else{
                var width = $(window).width();
                if(width>640){
                if(_captiontop!=""||_captionleft!=""){
                        _contentContainer.css({
                            'min-height': _minheight,
                            'width': _captionwidth,
                            'top': _captiontop,
                            'left': _captionleft
                        });
                    }
                }else{
                    _contentContainer.css({
                        'width': '100%',
                        'max-width': '100%',
                        'min-height': 0,
                        'top': 0,
                        'left': 0
                    });
                }

            }
        }
        _resetCover();
        $(window).on('load resize', function(event) {
            _resetCover();
        });

        if(_captiontop!=""||_captionleft!=""){
            $('.cq-homeslider-contentcontainer', _this).css({
                'top': _captiontop,
                'left': _captionleft
            });
        }

        if(_contentbackground!=""){
            $('.cq-homeslider-contentcontainer', _this).css('background', _contentbackground);
        }

        if(_maxheight&&_maxheight!=""){
            _cover.css({
                'overflow': 'hidden',
                'max-height': _maxheight
            });
        }



        var _autoplay = false;
        if(_delaytime>0) _autoplay = true;
        if($('.cq-homeslider-contentitem', _this).first().is(':empty')){
            $('.cq-homeslider-content', _this).empty();
        }
        if($('.cq-homeslider-imageitem', _this).first().is(':empty')){
            $('.cq-homeslider-itemcontainer', _this).empty();
        }
        var _imagecarousel = $('.cq-homeslider-itemcontainer', _this).slick({
            asNavFor: $('.cq-homeslider-content', _this),
            infinite: true,
            arrow: false,
            dots: false,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: _autoplay,
            // pauseOnHover: false,
            pauseOnDotsHover: true,
            speed: 800,
            draggable: false,
            swipe: false,
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
            prevArrow: $('.homeslider-navigation-prev', _this),
            nextArrow: $('.homeslider-navigation-next', _this),
            autoplaySpeed: _delaytime*1000,
            slidesToScroll: 1
        });
        var _textcarousel = $('.cq-homeslider-content', _this).slick({
            asNavFor: $('.cq-homeslider-itemcontainer', _this),
            infinite: true,
            adaptiveHeight: true,
            slidesToShow: 1,
            arrow: false,
            dots: true,
            appendDots: _contentContainer,
            draggable: false,
            swipe: false,
            speed: 800,

            prevArrow: $('.homeslider-navigation-prev', _this),
            nextArrow: $('.homeslider-navigation-next', _this),

            slidesToScroll: 1
        });


        $('a.cq-homeslider-lightbox', _this).each(function() {
            $(this)/*.attr('rel', 'cq-homeslider-gallery'+_index)*/.boxer({
                fixed : true
            });
        });

        _itemNum = $('.cq-homeslider-image', _this).length;

        var _currentItem = 0;


        $('.cq-homeslider-contentitem', _this).each(function() {
            if($(this).is(':empty')){
                $(this).css({
                    'padding-top': '0',
                    'padding-bottom': '0'
                });
            }else{
            }
        });


        var _prevBtn = $('.homeslider-navigation-prev', _this);
        var _nextBtn = $('.homeslider-navigation-next', _this);


    });
});
