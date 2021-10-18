jQuery(document).ready(function($) {
    "use strict";
    $('.cq-stepcard').each(function(index) {
        var _this = $(this);
        var _cardstyle = $(this).data('cardstyle');
        var _autoslide = parseInt($(this).data('autoslide'), 10);
        var _labelfontsize = $(this).data('labelfontsize');
        var _itemheight = parseInt($(this).data('itemheight'), 10);
        var content = $('.cq-stepcard-item', _this);
        var _itemNum = content.length;
        var _bgstyle =  $(this).data('bgstyle') == "yes" ? true : false;
        var _backgroundcolor = $(this).data('backgroundcolor');
        var _nextbtncolor = $(this).data('nextbtncolor');
        var _textcolor = $(this).data('textcolor');
        var _iconcolor = $(this).data('iconcolor');
        var _currentItem;


        if(_backgroundcolor!=""){
            $('.cq-stepcard-cardcontainer', _this).css('background-color', _backgroundcolor);
            $('cq-stepcard-cardbar', _this).css('background-color', _backgroundcolor);
        }
        if(_textcolor!=""){
            $('.cq-stepcard-cardcontainer, .cq-stepcard-text, .cq-stepcard-text p, .cq-stepcard-cardcontainer p', _this).css('color', _textcolor);
        }
        if(_iconcolor!=""){
            $('.cq-stepcard-icon', _this).css('color', _iconcolor);
        }
        if(_nextbtncolor!=""){
            $('.cq-stepcard-nextstep, .cq-stepcard-nextstep .cq-stepcard-button', _this).css('color', _nextbtncolor);
        }
        if(_itemheight>0){
            $('.cq-stepcard-cardcontainer', _this).css('height', _itemheight);
        }
        if(_labelfontsize!=""){
            $('.cq-stepcard-button', _this).css('font-size', _labelfontsize);
        }
        $('.cq-stepcard-item', _this).each(function(index) {
            if(index==0) {
                _currentItem = $(this);
                $(this).addClass('cq-stepcard-active');
                $(this).show();
            }
            $(this).data('index', index).css('z-index', _itemNum-index);;
        });

        if(_cardstyle!="transparent"){
            for (var i = _itemNum - 1; i >= 0; i--) {
                _this.prepend('<div class="cq-stepcard-cardbar"></div>');
            }

            $('.cq-stepcard-cardbar', _this).each(function(index) {
                $(this).css({
                    'margin': '0 ' + (_itemNum-index+1)*4 + 'px',
                    'opacity': 1 - index*0.05
                });
            });

        }

        var _slideID = 0;
        function _autoDelaySlide(){
            _slideID = setInterval(function(){
                if(_currentItem!=undefined){
                    $('.cq-stepcard-button', _currentItem).trigger('click');
                }
            }, _autoslide*1000);
        }
        if(_autoslide>0){
            _autoDelaySlide();
        }

        _this.on('mouseover', function(event) {
            if(_autoslide>0){
                clearInterval(_slideID);
            }
            event.preventDefault();
        }).on('mouseleave', function(event) {
            if(_autoslide>0){
                _autoDelaySlide();
            }
            event.preventDefault();
        });


        $('.cq-stepcard-cardbar', _this).each(function(index) {
            $(this).data('index', index);
            $(this).data('marginLeft', $(this).css('margin-left'));
            if(index==0) $(this).animate({height: '0', marginLeft:'0px', marginRight:'0px'}, 100, function(){
                $(this).hide();
            });
        });

        $('.cq-stepcard-step', _this).animate({width: 1/_itemNum*100 + "%"});
        $('.cq-stepcard-content', _this).perfectScrollbar({
            stopPropagationOnClick: false
        });


        $('.cq-stepcard-button', _this).click(function(event) {
            var nextItem = _currentItem.next();
            var lastItem = content.last();
            var contentFirst = content.first();

            _currentItem.css('z-index', '-1').removeClass('cq-stepcard-active');

            var _index = _currentItem.data('index');
            var _tempIndex = _index + 2;
            if(_tempIndex>_itemNum) _tempIndex = 1;

            $('.cq-stepcard-step', _this).animate({width: _tempIndex/_itemNum*100 + "%"});
            if(_index<_itemNum-1){
                $('.cq-stepcard-cardbar', _this).each(function(index) {
                    if((_itemNum - _index - 1)==index){
                        $(this).animate({height: '0', marginLeft:'0px', marginRight:'0px'}, 100, function(){
                                $(this).hide();
                        });
                    };
                });
            }else{
                $('.cq-stepcard-cardbar', _this).each(function(index) {
                    if(index>0){
                        var _marginLeft = $(this).data('marginLeft');
                        $(this).show().stop(true, true).animate({height: '8px', marginLeft:_marginLeft, marginRight:_marginLeft}, 100);
                    };
                });
            }

            var _zindex = _itemNum - _index;
            if (_currentItem.is(lastItem)) {
                _currentItem = contentFirst.css("z-index", _zindex).addClass('cq-stepcard-active');

            } else if (_currentItem.is(contentFirst)) {
                _currentItem = nextItem.css("z-index", _zindex).addClass('cq-stepcard-active');

            } else {
                _currentItem = nextItem.css("z-index", _zindex).addClass('cq-stepcard-active');
            }


            event.preventDefault();
        });




    });


});
