jQuery(document).ready(function($) {
    "use strict";
    $('.cq-dotselection').each(function(index, el) {
        var _this = $(this);
        var _itemsize = $(this).data('itemsize');
        var _transparentitem = $(this).data('transparentitem') == "yes" ? true:false;
        var _autoheight = $(this).data('autoheight') == "yes" ? true:false;
        var _labelfontsize = $(this).data('labelfontsize');
        var _subfontsize = $(this).data('subfontsize');
        var _transition = $(this).data('transition');
        var _autoslide = parseInt($(this).data('autoslide'), 10);

        var _currentIndex = 0;
        var _videomode = true;
        var _slideID = 0;

        var _autoslideObj;
        if(_autoslide > 0){
           _autoslideObj =  JSON.parse(JSON.stringify({delay: _autoslide*1000}));
        }else{
            _autoslideObj = false;
        }

        var _tooltipArr = [];
        $('.cq-dotselection-img', _this).each(function(index) {
            _tooltipArr[index] = $(this).attr('title');
        });


        var _dotcolorArr = [];
        $('.cq-dotselection-item', _this).each(function(index) {
              _dotcolorArr[index] = $(this).data('dotcolor');
        });

        var swiper = new Swiper( _this, {
              spaceBetween: 30,
              effect: _transition,
              autoHeight: _autoheight,
              loop: true,
              autoplay: _autoslideObj,
              disableOnInteraction: false,
              on: {
                init: function () {
                    $(window).trigger('resize');
                }
              },
              pagination: {
                el: '.cq-dotselection-nav',
                clickable: true,
                renderBullet: function (index, className) {
                  return '<div class="' + className + '" title="' + _tooltipArr[index] + '" style="border-color:'+ _dotcolorArr[index] +';"><span class="cq-dotselection-dot" style="background-color:'+ _dotcolorArr[index] +';"></span></div>';
                },
              },
              flipEffect: {
                rotate: 30,
                slideShadows: false,
              },
              cubeEffect: {
                shadow: false,
                slideShadows: false
              },
              coverflowEffect: {
                rotate: 30,
                slideShadows: false,
              }

        });


        $('.swiper-pagination-bullet', _this).each(function(index) {
            var _tooltip = $(this).attr('title');
            if(_tooltip&&_tooltip!==""){
                var _tooltip = $(this).tooltipster({
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

        });




    });
});
