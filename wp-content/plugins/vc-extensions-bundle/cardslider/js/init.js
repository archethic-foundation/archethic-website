jQuery(document).ready(function($) {
    "use strict";
    $('.cq-cardslider').each(function(index, el) {
        var _this = $(this);
        var _itemsize = $(this).data('itemsize');
        var _transparentitem = $(this).data('transparentitem') == "yes" ? true:false;
        var _autoheight = $(this).data('autoheight') == "yes" ? true:false;
        var _labelfontsize = $(this).data('labelfontsize');
        var _subfontsize = $(this).data('subfontsize');
        var _transition = $(this).data('transition');
        var _itemheight = parseInt($(this).data('itemheight'), 10);
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

        $('.cq-cardslider-img').each(function(index) {
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

        var swiper = new Swiper( _this, {
              spaceBetween: 30,
              effect: _transition,
              autoHeight: _autoheight,
              loop: true,
              autoplay: _autoslideObj,
              on: {
                init: function () {
                    $(window).trigger('resize');
                }
              },
              pagination: {
                el: '.cq-cardslider-nav',
                clickable: true,
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


    });
});
