jQuery(document).ready(function($) {

    $('.cq-loadingslideshow').each(function(index, el) {
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
        $('.cq-loadingslideshow-imgcontainer', _this).each(function(index) {
            _tooltipArr[index] = $(this).attr('title');
        });


        var _dotcolorArr = [];
        $('.cq-loadingslideshow-item', _this).each(function(index) {
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
                el: '.cq-loadingslideshow-nav',
                clickable: true,
                renderBullet: function (index, className) {
                  return '<div class="' + className + '" title="' + _tooltipArr[index] + '" style=""></div>';
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

        var _loadingID = 0;
        $('.cq-loadingslideshow-progress', _this).on('animationend transitionend webkitTransitionEnd oTransitionEnd', function () {
            var _loadingbar = $(this);
            $(this).removeClass('cq-isloading-' + _autoslide);
            clearTimeout(_loadingID);
            _loadingID = setTimeout(function(){
              _loadingbar.addClass('cq-isloading-' + _autoslide);
              swiper.slideNext();
            }, 100)
        });

        _this.on('mouseover', function(event) {
           $('.cq-loadingslideshow-progress', _this).css("-webkit-animation-play-state", "paused");
          event.preventDefault();
        }).on('mouseleave', function(event) {
           $('.cq-loadingslideshow-progress', _this).css("-webkit-animation-play-state", "running");
          event.preventDefault();
        });

        $('.cq-loadingslideshow-avatar', _this).each(function(index) {
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
