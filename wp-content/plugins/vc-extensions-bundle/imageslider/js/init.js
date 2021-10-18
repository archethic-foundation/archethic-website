jQuery(document).ready(function($) {
    "use strict";
        // POST commands to YouTube or Vimeo API
        function postMessageToPlayer(player, command){
          if (player == null || command == null) return;
          player.contentWindow.postMessage(JSON.stringify(command), "*");
        }

        // When the slide is changing
        function playPauseVideo(slick, control){
          var currentSlide, slideType, startTime, player, video;

          currentSlide = slick.find(".slick-current");
          // slideType = currentSlide.attr("class").split(" ")[1];
          if($('iframe', currentSlide)[0]){
              if($('iframe', currentSlide).attr('src').indexOf('youtube') > -1){
                slideType = 'youtube';
              }else if($('iframe', currentSlide).attr('src').indexOf('vimeo') > -1){
                slideType = 'vimeo';
              }
          }

          player = currentSlide.find("iframe").get(0);
          startTime = currentSlide.data("video-start");

          if (slideType === "vimeo") {
            switch (control) {
              case "play":
                if ((startTime != null && startTime > 0 ) && !currentSlide.hasClass('started')) {
                  currentSlide.addClass('started');
                  postMessageToPlayer(player, {
                    "method": "setCurrentTime",
                    "value" : startTime
                  });
                }
                postMessageToPlayer(player, {
                  "method": "play",
                  "value" : 1
                });
                break;
              case "pause":
                postMessageToPlayer(player, {
                  "method": "pause",
                  "value": 1
                });
                break;
            }
          } else if (slideType === "youtube") {
            switch (control) {
              case "play":
                postMessageToPlayer(player, {
                  "event": "command"
                  // "func": "mute"
                });
                postMessageToPlayer(player, {
                  "event": "command",
                  "func": "playVideo"
                });
                break;
              case "pause":
                postMessageToPlayer(player, {
                  "event": "command",
                  "func": "pauseVideo"
                });
                break;
            }
          } else if (slideType === "video") {
            video = currentSlide.children("video").get(0);
            if (video != null) {
              if (control === "play"){
                video.play();
              } else {
                video.pause();
              }
            }
          }
        }



    $('.cq-imageslider').each(function(index, el) {

        var _this = $(this);
        var _buttonbackground = $(this).data('buttonbackground');
        var _buttonhoverbackground = $(this).data('buttonhoverbackground');
        var _contentcolor = $(this).data('contentcolor');
        var _dotanimation = $(this).data('dotanimation');
        var _autoslide = parseInt($(this).data('autoslide'));
        var _contentbackground = $(this).data('contentbackground');
        var _arrowcolor = $(this).data('arrowcolor');
        var _arrowhovercolor = $(this).data('arrowhovercolor');
        var _cover = $('.cq-imageslider-cover', _this);
        var _itemContainer = $('.cq-imageslider-itemcontainer', _this);
        var _isautoheight = $(this).data('isautoheight') == "yes" ? true : false;
        var _itemWidth = _cover.width();
        var _itemNum = 0;
        var _index = index;

        if(_contentbackground!=""){
            $('.cq-imageslider-area', _this).css('background', _contentbackground);
        }


        var _autoplay = false;
        if(_autoslide>0) _autoplay = true;
        '.cq-imageslider-itemcontainer', _this.on('init', function(event, slick){
            $(window).trigger('resize');
        });
        var _imagecarousel = $('.cq-imageslider-itemcontainer', _this).slick({
            infinite: true,
            arrow: true,
            dots: false,
            pauseOnHover: true,
            slidesToShow: 1,
            adaptiveHeight: _isautoheight,
            autoplay: _autoplay,
            speed: 600,
            draggable: false,
            swipe: false,
            cssEase:"cubic-bezier(0.87, 0.03, 0.41, 0.9)",
            prevArrow: $('.imageslider-navigation-prev', _this),
            nextArrow: $('.imageslider-navigation-next', _this),
            autoplaySpeed: _autoslide*1000,
            slidesToScroll: 1
        });


        _imagecarousel.on("init", function(slick){
            slick = $(slick.currentTarget);
            setTimeout(function(){
              playPauseVideo(slick,"play");
            }, 1000);
        });

        _imagecarousel.on("beforeChange", function(event, slick, currentSlide, nextSlide) {
            slick = $(slick.$slider);
            playPauseVideo(slick,"pause");

            if($('iframe', currentSlide)[0]){
            }else{
            }

        });


        _imagecarousel.on('afterChange', function(event, slick, currentSlide, nextSlide){
            slick = $(slick.$slider);
            playPauseVideo(slick,"play");
            $('.cq-imageslider-dot li', _this).each(function(index) {
                $(this).removeClass('is-current');
                if($(this).data('index') == currentSlide) $(this).addClass('is-current');
            });

            if($('iframe', currentSlide)[0]){
                if(_autoplay) slick.slick('slickPause');
            }else{
            }

        });

        $('.cq-imageslider-text:has(iframe)').css('margin-top', '0');

        if($('iframe', $('.cq-imageslider-imageitem', _imagecarousel))[0]){
            if(_autoplay) _imagecarousel.slick('slickPause');
        }


        var _minheight = parseInt($('.cq-imageslider-imageitem', $(this)).data('minheight'), 10);
        if(_minheight > 0){
            $('.cq-imageslider-noimage', $(this)).css('min-height', _minheight);
        }else if($('.cq-imageslider-image', $(this)).outerHeight() > 0){
            $('.cq-imageslider-noimage', $(this)).css('min-height', $('.cq-imageslider-image', $(this)).outerHeight());
        }



        $('.cq-imageslider-dot li', _this).each(function(index) {
            $(this).data('index', index);
            if(index==0) $(this).addClass('is-current');
        });

        $('.cq-imageslider-dot', _this).on('click', 'li', function(event) {
            $('.cq-imageslider-dot li', _this).each(function(index) {
                $(this).removeClass('is-current');
            });
            $(this).addClass('is-current');
            _imagecarousel.slick('slickGoTo', $(this).data('index'));
            event.preventDefault();
        });


        _itemNum = $('.cq-imageslider-image', _this).length;

        var _currentItem = 0;


        if(_arrowcolor!=""){
            $('.imageslider-navigation-prev, .imageslider-navigation-next', _this).css('color', _arrowcolor);;
        }

        var _prevBtn = $('.imageslider-navigation-prev', _this);
        var _nextBtn = $('.imageslider-navigation-next', _this);

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
