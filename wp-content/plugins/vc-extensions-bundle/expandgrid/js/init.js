jQuery(document).ready(function($) {
    "use strict";
    $('.cq-expandgrid').each(function(index, el) {
        var _this = $(this);
        var _itemsize = $(this).data('itemsize');
        var _transparentitem = $(this).data('transparentitem') == "yes" ? true:false;
        var _scrollto = $(this).data('scrollto') == "yes" ? true:false;
        var _labelfontsize = $(this).data('labelfontsize');
        var _subfontsize = $(this).data('subfontsize');
        var _itemheight = parseInt($(this).data('itemheight'), 10);;
        var _autoslide = parseInt($(this).data('autoslide'), 10);;
        var _scrolloffset = parseInt($(this).data('scrolloffset'), 10);;
        var _currentIndex = 0;
        var _videomode = true;
        var _itemNums = $('.cq-expandgrid-item', _this).length;
        var _openfirst = $(this).data('openfirst') == "yes" ? false:true;
        var _slideID = 0;

        var _items = $('.cq-expandgrid-item', _this).each(function(item) {
            $(this).data('index', item);
            $(this).data('offsettop', $(this).offset().top);
            var _image = $(this).data('image');
            var _avatar = $(this).data('avatar');
            var _backgroundcolor = $(this).data('backgroundcolor');
            var _iconcolor = $(this).data('iconcolor');
            var _iconsize = $(this).data('iconsize');
            var _contentcolor = $(this).data('contentcolor');
            var _labelcolor = $(this).data('labelcolor');
            var _subtitlecolor = $(this).data('subtitlecolor');
            var _bgstyle = $(this).data('bgstyle');
            var _avatartype = $(this).data('avatartype');
            var _item = $(this);

            var _tooltip = $(this).attr('title');
            if(_tooltip&&_tooltip!==""){
                var _tooltip = $('.cq-expandgrid-face', _item).tooltipster({
                    content: _tooltip,
                    position: 'top',
                    delay: 200,
                    interactive: true,
                    speed: 300,
                    touchDevices: true,
                    animation: 'grow',
                    theme: 'tooltipster-shadow',
                    contentAsHTML: true
                });
            }

            if(_contentcolor!=""){
                $('.cq-expandgrid-text, .cq-expandgrid-text p, .cq-expandgrid-text h2, .cq-expandgrid-text h3, .cq-expandgrid-text h4, .cq-expandgrid-text h5, .cq-expandgrid-text h6', _item).css('color', _contentcolor);
            }
            if(_labelcolor!=""){
                $('.cq-expandgrid-title', _item).css('color', _labelcolor);
            }
            if(_subtitlecolor!=""){
                $('.cq-expandgrid-subtitle', _item).css('color', _subtitlecolor);
            }
            if(_labelfontsize!=""){
                $('.cq-expandgrid-title', _item).css('font-size', _labelfontsize);
            }
            if(_subfontsize!=""){
                $('.cq-expandgrid-subtitle', _item).css('font-size', _subfontsize);
            }
            if(_itemheight>0&&_itemsize=="customized"){
                $('.cq-expandgrid-face', _item).css('height', _itemheight);
            }
            if(_backgroundcolor!=""&&_bgstyle=="customized"){
                $('.cq-expandgrid-face', _item).css('background-color', _backgroundcolor);
            }

            if(_iconcolor!=""){
                $('.cq-expandgrid-icon', _item).css('color', _iconcolor);
            }
            if(_iconsize!=""){
                $('.cq-expandgrid-icon', _item).css('font-size', _iconsize);
            }

            if(_image!=""&&_image!="undefined"&&_image){
                $('.cq-expandgrid-face', _item).css({
                    'background-image': 'url(' + _image + ')'
                });
            }

            if(_avatartype=="image"&&_avatar!=""&&_avatar!="undefined"&&_avatar){
                $('.cq-expandgrid-avatar', _item).css({
                    'background-image': 'url(' + _avatar + ')'
                });
            }




        });

        if(_scrollto){
            $(window).on('resize', function(event) {
                $('.cq-expandgrid-item', _this).each(function(item) {
                    $(this).data('offsettop', $(this).offset().top);
                })
            });
        }

        var _thisItem = null;
        _this.on('mouseover', function(event) {
            clearInterval(_slideID);
        }).on('mouseleave', function(event) {
            if(_autoslide>0) _autoDelaySlide();
        });
        $('.cq-expandgrid-toggle', _items).click(function() {
            var _currentItem = $(this).closest('.cq-expandgrid-item');
            var _backgroundcolor = _currentItem.data('backgroundcolor');
            _currentIndex = _currentItem.data('index');
            clearInterval(_slideID);
            if(_thisItem&&!_currentItem.is(_thisItem)){
                _thisItem.removeClass('cq-expandgrid-openstate').addClass('cq-expandgrid-initstate');
                if(_transparentitem){
                    _items.removeClass('outfoucs');
                }

                // reset the video src to stop it
                var _videoURL = $('iframe', _thisItem).attr('src');
                if(_videoURL&&_videoURL!=""){
                    if(_videoURL.indexOf('youtube')>-1||_videoURL.indexOf('vimeo')>-1){
                        $('iframe', _thisItem).attr('src', '');
                        $('iframe', _thisItem).attr('src', _videoURL);
                    }
                }
            }
            if (_currentItem.hasClass('cq-expandgrid-initstate')) {
                _thisItem = _currentItem.removeClass('cq-expandgrid-initstate').addClass('cq-expandgrid-openstate');
                if(_scrollto){
                    var _newtop = _thisItem.data('offsettop') + _scrolloffset;
                    $([document.documentElement, document.body]).stop(true, true).animate({
                        scrollTop: _newtop
                    }, 600);
                }

                if (_items.not(_currentItem).hasClass('outfoucs')) {

                } else {
                    if(_transparentitem)_items.not(_currentItem).addClass('outfoucs');
                }

            } else {
                _currentItem.removeClass('cq-expandgrid-openstate').addClass('cq-expandgrid-initstate');
                if(_transparentitem)_items.not(_currentItem).removeClass('outfoucs');
            }



        });

        if(_openfirst||_autoslide>0)$('.cq-expandgrid-toggle', _items).eq(0).trigger('click');
        if(_autoslide>0){
            function _autoDelaySlide(){
                _slideID = setInterval(function() {
                    clearInterval(_slideID);
                    _currentIndex++;
                    if(_currentIndex>_itemNums) _currentIndex = 0;
                    $('.cq-expandgrid-toggle', _items).eq(_currentIndex).trigger('click');
                    _autoDelaySlide();
                }, _autoslide*1000);
            }
            _autoDelaySlide();
        }


        _items.find('.cq-expandgrid-close').click(function() {

            var _currentItem = $(this).closest('.cq-expandgrid-item');

            _currentItem.removeClass('cq-expandgrid-openstate').addClass('cq-expandgrid-initstate');
            _items.not(_currentItem).removeClass('outfoucs');

        });

    });
});
