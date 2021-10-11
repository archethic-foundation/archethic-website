jQuery(document).ready(function($) {
    "use strict";
    $('.cq-compareslider').each(function(index) {
        var _this = $(this);
        var _autoslide = parseInt($(this).data('autoslide'))*1000;
        var _menucolorstyle = $(this).data('menucolorstyle');
        var _menubackgroundcolor = $(this).data('menubackgroundcolor');
        var _menutextcolor = $(this).data('menutextcolor');
        var _menuactivetextcolor = $(this).data('menuactivetextcolor');
        var _menupadding = $(this).data('menupadding');
        var _menumargin = $(this).data('menumargin');
        var _transitionstyle = $(this).data('transitionstyle');
        if(_transitionstyle == "normalFade") _transitionstyle = "fade";
        var _enabledrag = $(this).data('enabledrag') == "on" ? true : false;

        if(_autoslide==0) _autoslide = false;

        var _carousel = $('.cq-compareslider-imagecontainer', _this).owlCarouselOld({
            item: 1,
            navigation: false,
            singleItem: true,
            slideSpeed: 800,
            rewindSpeed: 100,
            pagination: false,
            autoPlay: _autoslide,
            mouseDrag : _enabledrag,
            touchDrag : _enabledrag,
            dragBeforeAnimFinish: false,
            stopOnHover: true,
            autoHeight: true,
            transitionStyle: _transitionstyle,
            afterAction: _afterAction
        });

        if(_menumargin!=""){
            $('.cq-compareslider-menucontainer', _this).css({
                'margin': _menumargin
            });
        }
        $('.cq-compareslider-menu li', _this).each(function(index) {
            if(_menupadding!=""){
                $(this).css({
                    'padding': _menupadding
                });
            }
            if(_menucolorstyle=="customized"){
                $(this).css({
                    'color': _menutextcolor,
                    'border-top': '1px solid ' + _menubackgroundcolor,
                    'border-bottom': '1px solid ' + _menubackgroundcolor,
                    'border-right': '1px solid ' + _menubackgroundcolor
                });
                if(index==0){
                    $(this).css({
                        'color': _menuactivetextcolor,
                        'background-color': _menubackgroundcolor
                    });
                    $(this).css('border-left', '1px solid ' + _menubackgroundcolor);
                }

                $(this).on('mouseover', function(event) {
                    if(!$(this).hasClass('active')){
                        $(this).css('color', _menubackgroundcolor);
                    }
                }).on('mouseleave', function(event) {
                   if(!$(this).hasClass('active')){
                        $(this).css('color', _menutextcolor);
                    }
                });

            }
        })

        var _isMoving = false;
        var _currentMenu;
        var _currentIndex;
        function _afterAction(){
            var _prevItem = this.owl.prevItem;
            var _currentItem = this.owl.currentItem;
            _currentIndex = _currentItem;
            $('.cq-compareslider-menu li', _this).each(function(index) {
                if(_prevItem == index){
                    if(_menucolorstyle=="customized"){
                        $(this).css({
                            'color': _menutextcolor,
                            'background-color': ''
                        });
                    }
                    $(this).removeClass('active');
                }
                if(_currentItem == index){
                    if(_menucolorstyle=="customized"){
                        $(this).css({
                            'color': _menuactivetextcolor,
                            'background-color': _menubackgroundcolor
                        });
                    }
                    $(this).addClass('active');
                }

            })
        }
        $('.cq-compareslider-menu li', _this).each(function(index) {
            if(index==0) _currentMenu = $(this).addClass('active');
            $(this).on('click', { 'index': index }, _clickMenu);
        });

        function _clickMenu(event){
            var _index = event.data.index;
            if(_index!=_currentIndex/*&&!_isMoving*/){
                _isMoving = true;
                if(_currentMenu) _currentMenu.removeClass('active');
                _carousel.trigger('owl.goTo', [_index]);
                _currentMenu = $(this).addClass('active');
            }
            event.preventDefault();
        }

        $(window).on('resize', function(event) {
            $('.cq-compareslider-menu li', _this).each(function(index) {
                if($(window).width()<=480){
                    $(this).addClass('smallscreen');
                    if(_menupadding!=""){
                        $(this).css({
                            'padding': ''
                        });
                    }
                }else{
                    $(this).removeClass('smallscreen')
                    if(_menupadding!=""){
                        $(this).css({
                            'padding': _menupadding
                        });
                    }
                }
            })

        });
        $(window).trigger('resize');


    });
});
