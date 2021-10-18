jQuery(document).ready(function($) {
    "use strict";
    $('.cq-gridpopup').each(function(index, el) {
        var _this = $(this);
        var _itemsize = $(this).data('itemsize');
        var _transparentitem = $(this).data('transparentitem') == "yes" ? true:false;
        var _labelfontsize = $(this).data('labelfontsize');
        var _subfontsize = $(this).data('subfontsize');
        var _itemheight = parseInt($(this).data('itemheight'), 10);;
        var _autoslide = parseInt($(this).data('autoslide'), 10);;
        var _currentIndex = 0;
        var _videomode = true;
        var _itemNums = $('.cq-gridpopup-item', _this).length;
        var _openfirst = $(this).data('openfirst') == "yes" ? false:true;
        var _slideID = 0;

        var _items = $('.cq-gridpopup-item', _this).each(function(item) {
            $(this).data('index', item);
            $(this).data('offsettop', $(this).offset().top);
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
                var _tooltip = $('.cq-gridpopup-face', _item).tooltipster({
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
                $('.cq-gridpopup-text, .cq-gridpopup-text p, .cq-gridpopup-text h2, .cq-gridpopup-text h3, .cq-gridpopup-text h4, .cq-gridpopup-text h5, .cq-gridpopup-text h6', _item).css('color', _contentcolor);
            }
            if(_labelcolor!=""){
                $('.cq-gridpopup-title', _item).css('color', _labelcolor);
            }
            if(_subtitlecolor!=""){
                $('.cq-gridpopup-subtitle', _item).css('color', _subtitlecolor);
            }
            if(_labelfontsize!=""){
                $('.cq-gridpopup-title', _item).css('font-size', _labelfontsize);
            }
            if(_subfontsize!=""){
                $('.cq-gridpopup-subtitle', _item).css('font-size', _subfontsize);
            }
            if(_itemheight>0&&_itemsize=="customized"){
                $('.cq-gridpopup-face', _item).css('height', _itemheight);
            }
            if(_backgroundcolor!=""&&_bgstyle=="customized"){
                $('.cq-gridpopup-face', _item).css('background-color', _backgroundcolor);
            }

            if(_iconcolor!=""){
                $('.cq-gridpopup-icon', _item).css('color', _iconcolor);
            }
            if(_iconsize!=""){
                $('.cq-gridpopup-icon', _item).css('font-size', _iconsize);
            }


            if(_avatartype=="image"&&_avatar!=""&&_avatar!="undefined"&&_avatar){
                $('.cq-gridpopup-avatar', _item).css({
                    'background-image': 'url(' + _avatar + ')'
                });
            }



        });

        var _thisItem = null;
        _this.on('mouseover', function(event) {
            clearInterval(_slideID);
        }).on('mouseleave', function(event) {
            if(_autoslide>0) _autoDelaySlide();
        });
        $('.cq-gridpopup-toggle', _items).click(function() {
            var _currentItem = $(this).closest('.cq-gridpopup-item');
            var _backgroundcolor = _currentItem.data('backgroundcolor');
            _currentIndex = _currentItem.data('index');
            clearInterval(_slideID);
            if(_thisItem&&!_currentItem.is(_thisItem)){
                _thisItem.removeClass('cq-gridpopup-openstate').addClass('cq-gridpopup-initstate');
                if(_transparentitem){
                    _items.removeClass('outfoucs');
                }

            }
            if (_currentItem.hasClass('cq-gridpopup-initstate')) {
                _thisItem = _currentItem.removeClass('cq-gridpopup-initstate').addClass('cq-gridpopup-openstate');

                if (_items.not(_currentItem).hasClass('outfoucs')) {

                } else {
                    if(_transparentitem)_items.not(_currentItem).addClass('outfoucs');
                }

            } else {
                _currentItem.removeClass('cq-gridpopup-openstate').addClass('cq-gridpopup-initstate');
                if(_transparentitem)_items.not(_currentItem).removeClass('outfoucs');
            }



        });



    });
});
