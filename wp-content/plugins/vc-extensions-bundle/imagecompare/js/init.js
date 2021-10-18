jQuery(document).ready(function($) {
    "use strict";
    $('.cq-imagecompare').each(function(index) {
        var _this = $(this);
        var _imagecontainer = $('.cq-imagecompare-imagecontainer', _this);
        var _autodelay = parseInt($(this).data('autodelay'), 10);
        var _minheight = parseInt($(this).data('minheight'), 10);
        var _firstclick = 0;

        var _autoSlideID = 0;


        if(_minheight>0){
            _this.css('min-height', _minheight + 'px');
            $('.cq-imagecompare-imagecontainer', _this).css('min-height', _minheight + 'px');
            $('.cq-imagecompare-captioncontainer, .cq-imagecompare-caption', _this).css('min-height', _minheight + 'px');
        }

        _this.on('mouseenter', function(event) {
            $('.cq-imagecompare-btn', _this).fadeIn('600');
        }).on('mouseleave', function(event) {
            $('.cq-imagecompare-btn', _this).delay(400).fadeOut('600');

        });
        $('.cq-imagecompare-btn', _this).on('click', function(event) {
            if (_firstclick != 1) {
                  _imagecontainer.addClass('cq-imagecompare-state1');
                  $('.cq-imagecompare-icon', _this).removeClass('entypo-icon-left-open-big').addClass('entypo-icon-right-open-big')
            } else {
                if(_imagecontainer.hasClass('cq-imagecompare-state2')){
                   _imagecontainer.removeClass('cq-imagecompare-state2').addClass('cq-imagecompare-state1');
                  $('.cq-imagecompare-icon', _this).removeClass('entypo-icon-left-open-big').addClass('entypo-icon-right-open-big')
                } else if(_imagecontainer.hasClass('cq-imagecompare-state1')){
                    _imagecontainer.removeClass('cq-imagecompare-state1').addClass('cq-imagecompare-state2');
                  $('.cq-imagecompare-icon', _this).removeClass('entypo-icon-right-open-big').addClass('entypo-icon-left-open-big')
                }
            }
            _firstclick = 1;
            event.preventDefault();
        });

        function _autoSlide() {
            if (_firstclick != 1) {
                  _imagecontainer.addClass('cq-imagecompare-state1');
                  $('.cq-imagecompare-icon', _this).removeClass('entypo-icon-left-open-big').addClass('entypo-icon-right-open-big')
            } else {
                if(_imagecontainer.hasClass('cq-imagecompare-state2')){
                   _imagecontainer.removeClass('cq-imagecompare-state2').addClass('cq-imagecompare-state1');
                  $('.cq-imagecompare-icon', _this).removeClass('entypo-icon-left-open-big').addClass('entypo-icon-right-open-big')
                } else if(_imagecontainer.hasClass('cq-imagecompare-state1')){
                    _imagecontainer.removeClass('cq-imagecompare-state1').addClass('cq-imagecompare-state2');
                  $('.cq-imagecompare-icon', _this).removeClass('entypo-icon-right-open-big').addClass('entypo-icon-left-open-big')
                }
            }
            _firstclick = 1;
            clearTimeout(_autoSlideID);
            if(_autodelay>0) _autoSlideID = setTimeout(_autoSlide, _autodelay*1000);
        }

        if(_autodelay>0) _autoSlideID = setTimeout(_autoSlide, _autodelay*1000);

        _this.on('mouseover', function(event) {
            if(_autodelay>0) clearTimeout(_autoSlideID);
        }).on('mouseleave', function(event) {
            if(_autodelay>0) _autoSlideID = setTimeout(_autoSlide, _autodelay*1000);
        });

    });

});
